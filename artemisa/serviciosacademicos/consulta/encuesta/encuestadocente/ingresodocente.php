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
	$formulario->filatmp["500"]="Docente";
	$formulario->filatmp["700"]="Decano Secretario academico";
	$formulario->filatmp["800"]="Director Division Departamento";
	$formulario->filatmp["400"]="Administrativos";
	$formulario->filatmp["610"]="Egresados";
	$formulario->filatmp["620"]="Estudiantes Postgrado";
	$formulario->filatmp["630"]="Educacion Continuada";
	$formulario->filatmp["660"]="Graduandos";
	$formulario->filatmp["900"]="Padres de Familia";
	$formulario->filatmp["501"]="Docentes Educacion continuada";
	$formulario->filatmp["502"]="Coordinadores Educacion continuada";
	$formulario->filatmp["640"]="Estudiantes En Practica";
	$formulario->filatmp["670"]="Estudiantes De Colegio";
	$formulario->filatmp[""]="Seleccionar";


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

case "500":			
					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombres like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombres like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre de Docente no corresponde con el documento");
						exit();
					}
					$condicion .=" and carrera1 <> 'ADMINISTRACION'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("tmpdocente","numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre de docente no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidos like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or apellidos like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido  de Docente no corresponde con el documento");
						exit();
					}
					$condicion .="  and carrera1 <> 'ADMINISTRACION'";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla("tmpdocente","numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido de Docente no corresponde con el documento ");
						$siga=0;
						exit();
					}















	

break;

case "700":



					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '400'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '400'";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;

case "800":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '200'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '200'";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;

case "400":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '300'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipopersonal = '300'";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla("tmplistadopersonal","documento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;


case "610":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombresegresado like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombresegresado like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and codigoestado = '100'";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("egresado","numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
			
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidosegresado like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or apellidosegresado like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and codigoestado = '100'";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla("egresado","numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;



case "620":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="  and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
					AND e.codigoestudiante=o.codigoestudiante
					AND c.codigocarrera=e.codigocarrera
					AND d.codigoconcepto=co.codigoconcepto
					AND co.cuentaoperacionprincipal=151
					AND o.codigoperiodo='20091'
					AND o.codigoestadoordenpago LIKE '4%'
					AND c.codigomodalidadacademica like '3%'
					AND e.codigoperiodo<>'20092'
					and u.numerodocumento=eg.numerodocumento
					group by u.idusuario";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co,estudiantegeneral eg,usuario u";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion 					.="  and o.numeroordenpago=d.numeroordenpago
						and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20091'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20091'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '3%'
						AND e.codigoperiodo<>'20092'
						and u.numerodocumento=eg.numerodocumento
					group by u.idusuario";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg,usuario u";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;





case "630":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="  and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
					AND e.codigoestudiante=o.codigoestudiante
					AND c.codigocarrera=e.codigocarrera
					AND d.codigoconcepto=co.codigoconcepto
					AND co.cuentaoperacionprincipal=151
					AND o.codigoperiodo='20091'
					AND o.codigoestadoordenpago LIKE '4%'
					AND c.codigomodalidadacademica like '4%'
					AND e.codigoperiodo<>'20092'
					and  c.codigocarrera not in (169,170,171,174,179,180,182,191,201,240,242,250,263,269,273,
320,326,341,342,344,347,379,399,409,432,436,437,438,440,441,448,453,458,449)
					";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co,estudiantegeneral eg";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
			
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion 					.="  and o.numeroordenpago=d.numeroordenpago
						and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20091'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '4%'
						AND e.codigoperiodo<>'20092'
						and  c.codigocarrera not in (169,170,171,174,179,180,182,191,201,240,242,250,263,269,273,
						320,326,341,342,344,347,379,399,409,432,436,437,438,440,441,448,453,458,449)
						";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co,estudiantegeneral eg";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;


case "660":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="  and codigosituacioncarreraestudiante = '104' and c.codigocarrera <> '13'
					and c.codigocarrera = e.codigocarrera and c.codigomodalidadacademica in ('200','300')
					and eg.idestudiantegeneral=e.idestudiantegeneral
					and u.numerodocumento=eg.numerodocumento
					and u.codigotipousuario='600'
					";

					$tabla=" estudiante e, carrera c,estudiantegeneral eg,usuario u";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .="  and codigosituacioncarreraestudiante = '104' and c.codigocarrera <> '13'
					and c.codigocarrera = e.codigocarrera and c.codigomodalidadacademica in ('200','300')
					and eg.idestudiantegeneral=e.idestudiantegeneral
					and u.numerodocumento=eg.numerodocumento
					and u.codigotipousuario='600'
					";

					$tabla=" estudiante e, carrera c,estudiantegeneral eg,usuario u";

					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;

case "900":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="ef.nombresestudiantefamilia like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or ef.nombresestudiantefamilia like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="  and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
					AND e.codigoestudiante=pr.codigoestudiante
					AND pr.codigoperiodo='20091'
					AND e.codigoestudiante=o.codigoestudiante
					AND c.codigocarrera=e.codigocarrera
					AND d.codigoconcepto=co.codigoconcepto
					AND co.cuentaoperacionprincipal=151
					AND o.codigoperiodo='20091'
					AND o.codigoestadoordenpago LIKE '4%'
					AND c.codigomodalidadacademica like '2%'
					AND e.codigoperiodo<>'20092'
					and ef.idestudiantegeneral = eg.idestudiantegeneral
					and u.numerodocumento=eg.numerodocumento
					and telefonoestudiantefamilia <> '' 
					and tp.idtipoestudiantefamilia=ef.idtipoestudiantefamilia
					and (ef.telefonoestudiantefamilia = '".$_POST['numerodocumento']."' or ef.telefono2estudiantefamilia = '".$_POST['numerodocumento']."' or
					ef.celularestudiantefamilia = '".$_POST['numerodocumento']."')
					";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg,usuario u,estudiantefamilia ef,tipoestudiantefamilia tp";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"ef.codigoestado","100",$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="ef.apellidosestudiantefamilia like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or ef.apellidosestudiantefamilia like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .="  and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
					AND e.codigoestudiante=pr.codigoestudiante
					AND pr.codigoperiodo='20091'
					AND e.codigoestudiante=o.codigoestudiante
					AND c.codigocarrera=e.codigocarrera
					AND d.codigoconcepto=co.codigoconcepto
					AND co.cuentaoperacionprincipal=151
					AND o.codigoperiodo='20091'
					AND o.codigoestadoordenpago LIKE '4%'
					AND c.codigomodalidadacademica like '2%'
					AND e.codigoperiodo<>'20092'
					and ef.idestudiantegeneral = eg.idestudiantegeneral
					and u.numerodocumento=eg.numerodocumento
					and telefonoestudiantefamilia <> '' 
					and tp.idtipoestudiantefamilia=ef.idtipoestudiantefamilia
					and (ef.telefonoestudiantefamilia = '".$_POST['numerodocumento']."' or ef.telefono2estudiantefamilia = '".$_POST['numerodocumento']."' or
					ef.celularestudiantefamilia = '".$_POST['numerodocumento']."')
					";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg,usuario u,estudiantefamilia ef,tipoestudiantefamilia tp";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"ef.codigoestado","100",$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;


case "501":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipodocente like '%docente%' and numerodocumento not in (select numerodocumento from tmpdocenteeducontinuada where numerodocumento = ".$_POST['numerodocumento']." and tipodocente like '%coordinador%')
					";

					$tabla=" tmpdocenteeducontinuada t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipodocente like '%docente%' and numerodocumento not in (select numerodocumento from tmpdocenteeducontinuada where numerodocumento = ".$_POST['numerodocumento']." and tipodocente like '%coordinador%')";

					$tabla=" tmpdocenteeducontinuada t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;


case "502":
					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipodocente like '%coordinador%'
					";

					$tabla=" tmpdocenteeducontinuada t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .=" and tipodocente like '%coordinador%'";

					$tabla=" tmpdocenteeducontinuada t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}

break;


case "640":
					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombrecompleto like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombrecompleto like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="";

					$tabla=" tmpestudiantepractica t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				
					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or nombrecompleto like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion .="";

					$tabla=" tmpestudiantepractica t";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}


break;

case "670":


					if(count($arraynombreegresado)>0){
					$condicion.=" and (";
						for($i=0;$i<count($arraynombreegresado);$i++){
							if(strlen($arraynombreegresado[$i])>=3){
								$siga=1;
								if($i==0)
									 $condicion.="nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
								else
$condicion.=" or nombresestudiantegeneral like '%".$arraynombreegresado[$i]."%'";
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
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
					$condicion .="  and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
					AND e.codigoestudiante=o.codigoestudiante
					AND c.codigocarrera=e.codigocarrera
					AND d.codigoconcepto=co.codigoconcepto
					AND co.cuentaoperacionprincipal=151
					AND o.codigoperiodo in ('20091','20092','20082')
					AND o.codigoestadoordenpago LIKE '4%'
					AND c.codigomodalidadacademica like '1%'
					and u.numerodocumento=eg.numerodocumento
					group by u.idusuario";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co,estudiantegeneral eg,usuario u";
					
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
					if(!$siga){
						alerta_javascript("Nombre  no corresponde con el documento");
						exit();
					}
				

					$condicion="";
					if(count($arrayapellidoegresado)>0){			
							$siga=1;
							$condicion=" and (";
							for($i=0;$i<count($arrayapellidoegresado);$i++){
								if(strlen($arrayapellidoegresado[$i])>=3){
									if($i==0)
										$condicion.="apellidosestudiantegeneral like '%".$arrayapellidoegresado[$i]."%'";
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
						alerta_javascript("Apellido no corresponde con el documento");
						exit();
					}
					$condicion 					.="  and o.numeroordenpago=d.numeroordenpago
						and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal in ('151','159','C9076','C9077')
						AND o.codigoperiodo in ('20091','20092','20082')
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '1%'
						and u.numerodocumento=eg.numerodocumento
					group by u.idusuario";

					$tabla=" ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg,usuario u";
					if($datosapellidosegresado=$objetobase->recuperar_datos_tabla($tabla,"eg.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						alerta_javascript("Apellido no corresponde con el documento ");
						$siga=0;
						exit();
					}
					//exit();

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
			where r.numerodocumento = '".$_POST["numerodocumento"]."'
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
			where r.numerodocumento = '".$_POST["numerodocumento"]."'
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
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$_POST["numerodocumento"]."&codigotipousuario=".$_POST["tipousuario"]."'>";
	
		}
		else{
			if($completoencuesta){
			if($_POST["tipousuario"]!="700")
				alerta_javascript("Usted ya diligencio toda la encuesta \\n Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion");
			else	
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularioencuesta.php?idusuario=".$_POST["numerodocumento"]."&codigotipousuario=".$_POST["tipousuario"]."'>";

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

