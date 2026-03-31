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
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #EDF0D5;
}
</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript">
if (document.location.protocol == "https:"){
	var direccion=document.location.href;
	var ssl=(direccion.replace(/https/, "http"));
	document.location.href=ssl;
}
function enviar(){
var formulario=document.getElementById("form1");
formulario.submit();

}
</script>
<table width="755" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#8AB200" valign="center"><img src="../../../../imagenes/noticias_logo.gif" width="755" height="71"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

<?php 
	$formulario->dibujar_fila_titulo('PROCESO DE AUTOEVALUACI&Oacute;N INSTITUCIONAL','labelresaltado',"2","align='center'");
	
	

	//$formulario->filatmp["1"]="Egresado";
if($_GET["encuestado"]=="director"){
$formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci&oacute;n sirven para verificar que quienes diligencian la herramienta hagan parte de la comunidad academica. Los resultados se manejaran de manera global y la informaci&oacute;n por usted suministrada sera absolutamente CONFIDENCIAL','tdtituloencuestadescripcion',"2","align='left'","td");
	$formulario->filatmp["800"]="Director Division Departamento";
}
else{
$formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci&oacute;n sirven para verificar que quienes diligencian la heramienta hagan parte de la comunidad academica. Los resultados se manejaran de manera global y la informaci&oacute;n por usted suministrada sera absolutamente CONFIDENCIAL','tdtituloencuestadescripcion',"2","align='left'","td");
	$formulario->filatmp["650"]="Estudiantes Nuevos";
	//$formulario->filatmp[""]="Seleccionar";


}

	$menu="menu_fila"; $parametrosmenu="'tipousuario','".$_REQUEST['tipousuario']."','onchange=enviar();'";
	$formulario->dibujar_campo($menu,$parametrosmenu,"Tipo de Encuestado","tdtitulogris","tipousuario",'requerido');


	$campo="boton_tipo"; $parametros="'text','nombreegresado','".$_POST['nombreegresado']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombreegresado','requerido');
	
	$campo="boton_tipo"; $parametros="'text','apellidoegresado','".$_POST['apellidoegresado']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellidoegresado','requerido');

if($_REQUEST["tipousuario"]=="900")
$titulodocumento="Numero telefonico";
else
$titulodocumento="Numero de documento";

	$campo="boton_tipo"; $parametros="'text','numerodocumento','".$_POST['numerodocumento']."',''";
  	$formulario->dibujar_campo($campo,$parametros,$titulodocumento,"tdtitulogris",'numerodocumento','requerido');

$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);


$mensaje="En caso de que no pueda ingresar por favor envie un correo con una cuenta institucional con datos personales (nombre completo , numero de documento) a la direccion <a href='mailto:autoevaluacioninstitucional@unbosque.edu.co'>autoevaluacioninstitucional@unbosque.edu.co</a>";

//$formulario->dibujar_fila_titulo($mensaje,'tdtituloencuestadescripcion',"2","align='left'","td");


	if(isset($_REQUEST['Enviar'])){


$_POST["numerodocumento"]=str_replace(",","",trim($_POST["numerodocumento"]));
$_POST["numerodocumento"]=str_replace(".","",$_POST["numerodocumento"]);

$arraynombreegresado=explode(" ",trim($_POST['nombreegresado']));
$arrayapellidoegresado=explode(" ",trim($_POST['apellidoegresado']));


		$siga=0;

//echo "<BR>TIPOUSUARIO=".$_POST["tipousuario"];
switch($_POST["tipousuario"]){

case "650":			
					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="eg.nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or eg.nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
							}else{
								$siga=0;
							}				
						}
					$condicion.=")";
					}
					else{
						$siga=0;
					}
					
					if(!$siga){
						alerta_javascript("Nombre de estudiante no corresponde con el documento");
						exit();
					}
					$condicion .=" and o.numeroordenpago=d.numeroordenpago
						and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20101'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20101'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre de Estudiante no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="eg.apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
								}
								else{
									$siga=0;
								}
							}
							$condicion.=")";
			
					}
					else{
						$siga=0;
					}

					if(!$siga){
						alerta_javascript("Apellido  de Estudiante no corresponde con el documento");
						exit();
					}
					$condicion .=" and o.numeroordenpago=d.numeroordenpago
						and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20101'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20101'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido de Estudiante no corresponde con el documento ");
						$siga=0;
						exit();
					}
break;




default:
alerta_javascript("Por favor seleccione Tipo de encuestado");
break;

}

	if($siga)
	if($formulario->valida_formulario()){




		
	/* consulta en tmpdocente*/	
/*	$query_selusuario = "SELECT t.numerodocumento
		FROM tmpdocente t where t.numerodocumento= ".$_POST["numerodocumento"]."		
		";

            $selusuario = $objetobase->conexion->query($query_selusuario);
            $totalRows_selusuario = $selusuario->numRows();
            if($totalRows_selusuario > 0)
            {*/
		
         $query_selencuesta = "SELECT idencuesta
            FROM encuesta
            where now() between fechainicioencuesta and fechafinalencuesta
		and codigotipousuario = '".$_POST["tipousuario"]."'";
            //echo "$query_selperiodo<br>";
            $selencuesta = $objetobase->conexion->query($query_selencuesta);
            $totalRows_selencuesta = $selencuesta->numRows();
		if($totalRows_selencuesta > 0)
		{
			 $query_selrespuestas = "SELECT r.numerodocumento
			FROM encuesta e,encuestapregunta ep,respuestadetalleencuestapreguntadocente r
			where r.numerodocumento = '".$datosnombresegresado["idestudiantegeneral"]."'
			and r.codigoestado like '1%'
			and e.idencuesta= ep.idencuesta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.codigotipousuario = '".$_POST["tipousuario"]."'
			limit 1";
			//echo "$query_selperiodo<br>";
			$selrespuestas = $objetobase->conexion->query($query_selrespuestas);
			$totalRows_selrespuestas = $selrespuestas->numRows();
			if($totalRows_selrespuestas == 0)
			{
			$diligenciarencuesta = true;
			}
			else
			{
			  $query_selrespuestas = "SELECT r.numerodocumento
			FROM respuestadetalleencuestapreguntadocente r,encuesta e,encuestapregunta ep,pregunta p
			where r.numerodocumento = '".$datosnombresegresado["idestudiantegeneral"]."'
				and r.codigoestado like '1%'	
			and e.idencuesta= ep.idencuesta
			and p.idpregunta=ep.idpregunta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.codigotipousuario = '".$_POST["tipousuario"]."'
			and (r.valorrespuestadetalleencuestapreguntadocente = ''
			or r.valorrespuestadetalleencuestapreguntadocente is  null)
			and p.idtipopregunta <> '201'
			limit 1";
			//echo "$query_selperiodo<br>";
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
	 
		if($diligenciarencuesta){
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$datosnombresegresado["idestudiantegeneral"]."&codigotipousuario=".$_POST["tipousuario"]."'>";
	
		}
		else{
			if($completoencuesta){
			if($_POST["tipousuario"]!="700")
				alerta_javascript("Usted ya diligencio toda la encuesta \\n Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion");
			else	
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$datosnombresegresado["idestudiantegeneral"]."&codigotipousuario=".$_POST["tipousuario"]."'>";

			}
			else
			alerta_javascript("No tiene permiso para  diligenciar la encuesta ");
		}

	}
	else{
		alerta_javascript("Es necesario diligenciar todos los campos");
	}

		
}
?>
 </table>
</form></td>
  </tr>
</table>