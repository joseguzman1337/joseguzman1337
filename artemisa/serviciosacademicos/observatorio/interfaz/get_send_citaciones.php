  
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
	session_start();
	if(empty($_SESSION['MM_Username'])){
		echo "No ha iniciado sesión en el sistema";
		exit();
	}	
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
	
	$mensajeValida=trim($mensaje,"<br>");
	
	if(empty($mensajeValida)){
		
		?> <div id='alerta'> Debe digitar el mensaje que desea enviar </div> <?php
		exit();
	}
	foreach($correos1 as $i =>$datos){
		($elgenero[$i]=='100')? $genero='Srta':$genero='Sr';
	$mensaje=str_replace("{genero}",$genero,$mensaje);
	$mensaje=str_replace("{nombres}",$nombres[$i],$mensaje);
	//$cuerpo=str_replace("{apellidos}",$apellidos[$i],$mensaje);
	
	$cuerpo =  $genero."<br>".
				$nombres[$i]."<br>".
				$apellidos[$i]."<br>".
				$mensaje."<br>";
	
		
		//$headers = "From: exitoestudiantil@unbosque.edu.co <exitoestudiantil@unbosque.edu.co>";
		//mail('sandovaldiana@unbosque.edu.co','Citación Universidad El Bosque',$cuerpo,$headers);
		//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: Exito estudiantil <exitoestudiantil@unbosque.edu.co>\r\n"; 

		//dirección de respuesta, si queremos que sea distinta que la del remitente 
		$headers .= "Reply-To: exitoestudiantil@unbosque.edu.co\r\n"; 

		//ruta del mensaje desde origen a destino 
		$headers .= "Return-path: exitoestudiantil@unbosque.edu.co\r\n"; 

		mail($correos1[$i],'Citación Universidad El Bosque',$cuerpo,$headers);
		mail($correos2[$i],'Citación Universidad El Bosque',$cuerpo,$headers);
		
	}
	
	
?>
<div id="alerta">
Citación enviada
</div>  