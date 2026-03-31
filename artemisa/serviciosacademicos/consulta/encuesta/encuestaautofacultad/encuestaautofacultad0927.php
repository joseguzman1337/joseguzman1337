<?php

session_start();


//
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuestav2/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ValidaEncuesta.php");
//require_once("seleccionmateria.php");


unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$idencuesta = '50';
$codigoperiodo='20121';


$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

if(isset ($_GET['codigotipousuario']))
{
	
    $complemento="and e.idestudiantegeneral=eg.idestudiantegeneral";
    if($estudianteindustrial=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg","eg.idestudiantegeneral",$_GET['idusuario'],$complemento,'',0)){
        $_GET['codigoestudiante']=$estudianteindustrial['codigoestudiante'];
       // exit();
  
    }
    
    else{
		//echo"<h1>Entro a...</h1>";
		 //exit();
        echo "<script type='text/javascript'> window.parent.continuar();</script>";
    }
}

?>
<input type="hidden" name="codigotipousuario" value="<?php echo $_REQUEST['codigotipousuario']; ?>">
<?php

$datoestudiante=$objetobase->recuperar_datos_tabla("estudiante e","e.codigoestudiante",$_GET['codigoestudiante'],"","",0);
$codigocarrera=$datoestudiante["codigocarrera"];


$condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='$codigoperiodo'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='$codigoperiodo'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'
						AND c.codigocarrera in(118,119,125,126,564,123,124)						
						";


if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,'',0))
    $siga=1;
else {
    $siga=0;
        if(isset($_REQUEST['codigotipousuario']) && $_REQUEST['codigotipousuario']!=""){
        echo "<script type='text/javascript'> window.parent.continuar();</script>";
    }
   /* else{
        alerta_javascript('Usted No está autorizado para realizar esta evaluación.');
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
    }*/
}



$_SESSION["codigoperiodo_evafacultad"]=$codigoperiodo;
$_SESSION["codigocarrera_evafacultad"]=$codigocarrera;

$objvalidaautoevaluacion = new ValidaEncuesta($objetobase, $codigoperiodo, '1');

$objvalidaautoevaluacion->setIdEncuesta($idencuesta);


$condicion=" and pc.idpregunta=p.idpregunta and (pc.codigocarrera ='".$codigocarrera."' or pc.codigocarrera=1) ";
$objvalidaautoevaluacion->setCondicionAdicional($condicion);
$objvalidaautoevaluacion->setTablaAdicional(",preguntacarrera pc");



$tabla = "respuestaautoevaluacion";
$objvalidaautoevaluacion->setTablaRespuesta($tabla);


$objvalidaautoevaluacion->setUsuario($_GET['codigoestudiante']);
$preguntasfacultades=$objvalidaautoevaluacion->validaPreguntasFaltantes();




if (is_array($preguntasfacultades)||
        (count($preguntasfacultades)>1)) {
		
		
    alerta_javascript('La autoevaluación que usted va a realizar corresponde al período 20121');
 //echo "<script type='text/javascript'>parent.continuar();</script>";
 $urlexito="../encuestaenfermeria/encuestaenfermeria.php?codigoestudiante=" . $_GET['codigoestudiante']."&codigotipousuario=".$_REQUEST['codigotipousuario'];
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$urlexito."'>";
}


exit();
/*else{
   // alerta_javascript('No ha finalizado la encuesta');
}*/
//}
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);
//$objconsultaencuesta->setAplicaPreguntas(1);
$objconsultaencuesta->setTablaRespuesta($tabla);
$condicion=" and pc.idpregunta=p.idpregunta and (pc.codigocarrera ='".$codigocarrera."' or pc.codigocarrera=1)";
$objconsultaencuesta->setCondicionAdicional($condicion);
$objconsultaencuesta->setTablaAdicional(",preguntacarrera pc");

//$objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);

$idusuarioencuesta = $_GET['codigoestudiante'];
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);

/* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
  $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
  $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
 */


//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>


        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
        <script LANGUAGE="JavaScript">

        </script>
    </head>
    <body>
        <center>
        <?php
// seleccionmateria($_GET["codigoestudiante"],$objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
      //  echo "<br>mostrarTitulosEncuesta 1 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->setIdEncuesta($idencuesta);
        //echo "<br>mostrarTitulosEncuesta 2 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->iniciarEncuestaUsuario();
        //echo "<H1>CONTADOR=".$objmostrarencuesta->objconsultaencuesta->contadoramaarbol."</H1>";
        //echo "<br>mostrarTitulosEncuesta 3 " . date("Y-m-d H:i:s");
        $objmostrarencuesta->mostrarTitulosEncuesta();

        $filaadicional["codigoperiodo"] = $codigoperiodo;
        $filaadicional["codigocarrera"] = $codigocarrera;

        //$mensajeninicial = "Califique las siguientes preguntas relacionadas al evento realizado";
        $mensajeninicial = "";

        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"" . $objmostrarencuesta->idencuesta . "\">";

      //  echo "<br>mostrarTitulosEncuesta 4 " . date("Y-m-d H:i:s");

        $objmostrarencuesta->imprimirEncuesta($mensajeninicial);

$condicionactualizaadicion=" and codigoperiodo='".$filaadicional["codigoperiodo"]."'";
        $objmostrarencuesta->ingresarTotalPreguntas($tabla, $filaadicional,$condicionactualizaadicion);

        $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
        echo "</form>";
       // echo "<h1>ENTRO1</h1>";
        $mensajeexito = "Ha sido para nosotros muy importante su colaboración. \\nGracias";
        $mensajefalta = "No puede continuar hasta que diligencie toda la encuesta";
        $direccionfalta = "encuestaautofacultad.php?codigoestudiante=" . $_GET['codigoestudiante']."&codigotipousuario=".$_REQUEST['codigotipousuario'];
        $direccionexito = "../encuestaenfermeria/encuestaenfermeria.php?codigoestudiante=" . $_GET['codigoestudiante']."&codigotipousuario=".$_REQUEST['codigotipousuario'];
        $objmostrarencuesta->guardarEncuesta($tabla,$filaadicional);
       // echo "<h1>ENTRO2</h1>";
	$formulario=$objmostrarencuesta->getFormulario();
        //echo "<h1>ENTRO3</h1>";
        $objvalidaautoevaluacion->mensajeValidaEncuesta($mensajeexito, $mensajefalta,$direccionexito, $direccionfalta,$formulario);
        //echo "<h1>ENTRO4</h1>";

        ?>
        <script type="text/javascript">
            var pathruta='../../../funciones/sala_genericas/ajax/tab/';
<?php

        $cadena = "var arraypestanas=Array(";
        $con = 0;
        if (is_array($objmostrarencuesta->arraytitulospestanas))
            foreach ($objmostrarencuesta->arraytitulospestanas as $i => $row) {
                //trim(sacarpalabras(str_replace("de","",str_replace("y","",$row["nombre"])),0,1))

                if ($con == 0)
                    $cadena.="'" . substr($objconsultaencuesta->numeracionpestana[$con] . ". " . $row["nombre"], 0, 13) . "...'";
                else
                    $cadena.=",'" . substr($objconsultaencuesta->numeracionpestana[$con] . ". " . $row["nombre"], 0, 13) . "...'";

                $con++;
            }
        $cadena.= ");\n";
        echo $cadena;
?>
    initTabs('formularioencuesta',arraypestanas,0,760,400);

    function cambiapestana(pestana){
        //alert("pestana="+pestana);
        //initTabs('formulariohorario',arraypestanas,pestana,760,400);
        showTab('formularioencuesta',pestana);
        return false;
    }

        </script>
    </center>
    </body>
</html>

