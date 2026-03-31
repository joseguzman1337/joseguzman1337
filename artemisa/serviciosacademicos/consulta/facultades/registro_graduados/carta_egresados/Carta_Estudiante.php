<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
?>
<form name="form1" method="post" action="">
<input type="submit" name="Submit" value="Continuar">
<br><br>
<?php 
@session_start();
  $_GET['codigoestudiante'] = $_SESSION['codigo'];
//exit();

require('carta_egresados.php');
$mensajeMedicina = "Si usted no ha radicado la documentación relacionada  con la matrícula del periodo académico en curso 2016-2  (Desprendible de pago, certificado de afiliación a la EPS con máximo un mes de vigencia, certificado de vacunación  de Hepatitis B ó títulos y firma del registro de matrícula) NO PODÁ ASISTIR  a las prácticas  de laboratorio, prácticas clínicas, practicas hospitalarias intra ni extramurales, ni prácticas comunitarias  a partir del 1 de Septiembre del año en curso. Favor acérquese lo antes posible a la Secretaría Académica de la Facultad para completar éste proceso.";
?>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}

function hRefIzq(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{         
		parent.leftFrame.location=url;
	}
	return true;
}

function destruirFrames(url){
	parent.document.location.href=url;
}
var submit = "<?php echo $_REQUEST['Submit']; ?>";
if( submit != "Continuar" ){
	var txtCodigoCarrera = "<?php echo $row_carrera["codigocarrera"]; ?>";
	if( txtCodigoCarrera == 10 ){
		alert( "<?php echo $mensajeMedicina; ?>" );
	}
}
</script>

<?php 
 if ($_REQUEST['Submit'])
 {
    echo "<script language='javascript'>
   //alert('Usted no tiene permiso para entrar a esta opcion');
   //document.location.href='consultanotas.htm';
   hRefIzq('../../facultadeslv2.php');
   hRefCentral('../..//central.php');
   </script>";		
 } 
 ?>
  
</form>