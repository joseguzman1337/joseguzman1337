<?php
session_start();
$rutaado=("../../../../funciones/adodb/");

require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../..//funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
?>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #EDF0D5;
}
</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
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
</head>
<body>
<table width="755" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#8AB200" valign="center"><img src="../../../../../imagenes/noticias_logo.gif" width="755" height="71"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
$mensaje="Respetado profesor, solicitamos su valiosa colaboración para actualizar la información docente que hace parte del proceso de calidad institucional.";

$formulario->dibujar_fila_titulo($mensaje,'tdtituloencuestadescripcion',"2","align='left'","td");

	$formulario->dibujar_fila_titulo('HOJA DE VIDA DOCENTE PROCESO DE CALIDAD INSTITUCIONAL','labelresaltado',"2","align='center'");
	
	

	//$formulario->filatmp["1"]="Egresado";
/*if($_GET["encuestado"]=="director"){
$formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci?n sirven para verificar que quienes diligencian la herramienta hagan parte de la comunidad academica. Los resultados se manejaran de manera global y la informaci?n por usted suministrada sera absolutamente CONFIDENCIAL','tdtituloencuestadescripcion',"2","align='left'","td");
	$formulario->filatmp["800"]="Director Division Departamento";
}
else{*/
//$formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci?n sirven para verificar que quienes diligencian la heramienta hagan parte de la comunidad academica. Los resultados se manejaran de manera global y la informaci?n por usted suministrada sera absolutamente CONFIDENCIAL','tdtituloencuestadescripcion',"2","align='left'","td");
	//$formulario->filatmp["500"]="Docente";

	//$formulario->filatmp[""]="Seleccionar";


//}

	//$campo="boton_tipo"; $parametros="'hidden','tipousuario','500',''";
	$formulario->boton_tipo('hidden','tipousuario','500','');
	//$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris","tipousuario",'requerido');


	$campo="boton_tipo"; $parametros="'text','nombreegresado','".$_POST['nombreegresado']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombreegresado','requerido');
	
	$campo="boton_tipo"; $parametros="'text','apellidoegresado','".$_POST['apellidoegresado']."',''";
  	$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellidoegresado','requerido');


//boton_link_emergente($url,$nombrelink,$ancho,$alto,$menubar="no",$javascript="",$activafuncion=1,$retorno=0)




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


	$campo="boton_link_emergente"; $parametros="'ManualDocentesv2.pdf','Manual de Ayuda','800','600'";
  	$formulario->dibujar_campo($campo,$parametros,"","tdtitulogris",'apellidoegresado','');


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
									 $condicion.="nombredocente like '%".$arraynombreegresado[$i]."%'";
								else
									$condicion.=" or nombredocente like '%".$arraynombreegresado[$i]."%'";
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
					$condicion .=" and c.iddocente=d.iddocente and d.codigoestado like '1%' group by d.iddocente";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("docente d, contratodocente c","d.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))
						$siga=1;
					else{
						$siga=0;
					}
					//exit();
			
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
										$condicion.="apellidodocente like '%".$arrayapellidoegresado[$i]."%'";
									else
										$condicion.=" or apellidodocente like '%".$arrayapellidoegresado[$i]."%'";
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
					$condicion .=" and d.codigoestado like '1%' and c.iddocente=d.iddocente group by d.iddocente";
			
					
					if($datosnombresegresado=$objetobase->recuperar_datos_tabla("docente d, contratodocente c","d.numerodocumento",$_POST['numerodocumento'],$condicion,'',0))

						$siga=1;
					else{
						alerta_javascript("Apellido de Docente no corresponde con el documento ");
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
			$_SESSION["sissic_numerodocumentodocente"]=$_POST["numerodocumento"];

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formularios/index.php'>";
	
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
</body>
</html>

