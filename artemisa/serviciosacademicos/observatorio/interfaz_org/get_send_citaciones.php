 
<style>
	#alerta{
		text-align:center;
		line-height:500px;
		vertical-align:middle;
		font-size:16px;
		font-weight:bold;
	}
</style>
<?php
   include("../templates/templateObservatorio.php");
   include("../class/toolsFormClass.php");
   
   $db =writeHeader("Observatorio",true);
		
	$correos1=$_POST['correo1'];
	$correos2=$_POST['correo2'];
	$nombres=$_POST['nombre'];
	$apellidos=$_POST['apellido'];
	
	$elgenero=$_POST['genero'];
	$mensaje=$_POST['mensaje'];
	
	$mensajeOriginal=$_POST['mensaje'];
	
	foreach($correos1 as $i =>$datos){
		($elgenero[$i]=='100')? $genero='Srta':$genero='Sr';
	$mensaje=str_replace("{genero}",$genero,$mensaje);
	$mensaje=str_replace("{nombres}",$nombres[$i],$mensaje);
	$cuerpo=str_replace("{apellidos}",$apellidos[$i],$mensaje);
	
	
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: sandovaldiana@unbosque.edu.co <sandovaldiana@unbosque.edu.co>\r\n";
		//mail('sandovaldiana@unbosque.edu.co','Citación Universidad El Bosque',$cuerpo,$headers);
		
		mail($correos1[$i],'Citación Universidad El Bosque',$cuerpo,$headers);
		mail($correos2[$i],'Citación Universidad El Bosque',$cuerpo,$headers);
		
	}
	
	
?>
<div id="alerta">
Citación enviada
</div>  