<?php
session_start();
$rutaado=("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");

unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20111'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20111'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'
						AND e.codigoperiodo='20111'
						and c.codigomodalidadacademica='200'
						";


if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.idestudiantegeneral",$_GET['idusuario'],$condicion,'',0))
    $siga=1;
else {
    $siga=0;
}
//exit();

if($siga) {
    $query_selencuesta = "SELECT idencuesta
            FROM encuesta
            where now() between fechainicioencuesta and fechafinalencuesta
		and idencuesta = '".$_GET["idencuesta"]."'";
    //    alerta_javascript($query_selencuesta);
    //echo $query_selencuesta;
    //exit();

    $selencuesta = $objetobase->conexion->query($query_selencuesta);
    $totalRows_selencuesta = $selencuesta->numRows();
    if($totalRows_selencuesta > 0) {
        $query_selrespuestas = "SELECT r.numerodocumento
			FROM encuesta e,encuestapregunta ep,respuestabienestarinduccion r
			where r.numerodocumento = '".$_GET["idusuario"]."'
			and r.codigoestado like '1%'
			and e.idencuesta= ep.idencuesta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.idencuesta = '".$_GET["idencuesta"]."'
			limit 1";
        //alerta_javascript($query_selrespuestas);
        $selrespuestas = $objetobase->conexion->query($query_selrespuestas);
        $totalRows_selrespuestas = $selrespuestas->numRows();
        //    alerta_javascript($query_selrespuestas);
        //echo $query_selrespuestas;
        //exit();

        if($totalRows_selrespuestas == 0) {
            $diligenciarencuesta = true;
        }
        else {
            $query_selrespuestas = "SELECT r.numerodocumento
			FROM respuestabienestarinduccion r,encuesta e,encuestapregunta ep,pregunta p
			where r.numerodocumento = '".$_GET["idusuario"]."'
				and r.codigoestado like '1%'	
			and e.idencuesta= ep.idencuesta
			and p.idpregunta=ep.idpregunta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.idencuesta = '".$_GET["idencuesta"]."'
			and (r.valorrespuestabienestarinduccion = ''
			or r.valorrespuestabienestarinduccion is  null)
			and p.idtipopregunta <> '201'
			limit 1";
            //alerta_javascript($query_selrespuestas);
            //exit();
            $selrespuestas = $objetobase->conexion->query($query_selrespuestas);
            $totalRows_selrespuestas = $selrespuestas->numRows();
            if($totalRows_selrespuestas > 0)
                $diligenciarencuesta = true;
            else
                $completoencuesta=true;
        }
        //exit();
        //$row_selencuesta = $selencuesta->fetchRow()
    }
    //exit();
    //echo "<H1>ENTRO? diligencio:$diligenciarencuesta completo:$completoencuesta</H1>";

    if($diligenciarencuesta) {
        //echo "IN1";
        //exit();
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestabienestar/encuestainduccion.php?idencuesta=42&idusuario=".$_GET["idusuario"]."&codigotipousuario=".$_GET["codigotipousuario"]."'>";
        //alerta_javascript("formularioencuesta.php?idusuario=".$_GET["idusuario"]."&codigotipousuario=".$_GET["codigotipousuario"]);
    }
    else {
       // echo "IN2";
        //exit();
        if($completoencuesta) {
            if($_POST["tipousuario"]!="700") {
                //alerta_javascript("Usted ya diligencio toda la encuesta \\n Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion");
                echo "<script type='text/javascript'>
					  window.parent.continuar();</script>";
            }
            else {
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestabienestar/encuestainduccion.php?idencuesta=42&tipoentrada=1&idusuario=".$_GET["idusuario"]."&codigotipousuario=".$_GET["codigotipousuario"]."'>";
                //alerta_javascript("formularioencuesta.php?idusuario=".$_GET["idusuario"]."&codigotipousuario=".$_GET["codigotipousuario"]);
            }
        }
        else
            echo "<script type='text/javascript'> window.parent.continuar();</script>";
    }

}
else {

    echo "<script type='text/javascript'> window.parent.continuar();</script>";
}

?>
