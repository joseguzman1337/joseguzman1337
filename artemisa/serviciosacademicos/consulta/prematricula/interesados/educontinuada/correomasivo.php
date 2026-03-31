<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
?>
<html>
<head>
<title>Correo Masivo</title>
</head>
<body>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/clases/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
function ConstruirCorreo($array_datos_correspondencia,$destinatario,$nombredestinatario,$trato){
		if(is_array($array_datos_correspondencia))
		{
			$mail = new PHPMailer();
			$mail->From = $array_datos_correspondencia['correoorigencorrespondencia'];
			$mail->FromName = $array_datos_correspondencia['nombreorigencorrespondencia'];
			$mail->ContentType = "text/html";
			$mail->Subject = $array_datos_correspondencia['asuntocorrespondencia'];
			//aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
			$encabezado=$trato.":<br>".$nombre_destinatario;
			$cuerpo=$encabezado."<br><br>".$array_datos_correspondencia['encabezamientocorrespondencia'];
			//$cuerpo2="en ".$array_datos_correo['direccionsitioadmision'].", teléfono: ".$array_datos_correo['telefonositioadmision']." el día ".$array_datos_correo['dia']." de ".$array_datos_correo['mesTexto']." del año ".$array_datos_correo['ano'].' a las '.substr($array_datos_correo['hora'],0,5)." en el salón ".$array_datos_correo['codigosalon'].".<br>";
			//$cuerpo3="<br><br>".$this->$array_datos_correo['firmacorrespondencia'];
			$mail->Body = $cuerpo;
			//echo $cuerpo.$cuerpo2.$cuerpo3;
			$mail->AddAddress($destinatario,$nombre_destinatario);
			//$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
			//$mail->AddAddress("dianarojas@sistemasunbosque.edu.co","Prueba");
			
			if(is_array($array_datos_correspondencia['detalle'])){
				foreach ($array_datos_correspondencia['detalle'] as $llave => $url)
				{
					//$ruta="tmp/".$url;
					//echo "<br>entro el atqachment AddAttachment($url,$llave);<br>";
					if(!$mail->AddAttachment($url,$llave)){
							alerta_javascript("Error no lo mando AddAttachment($url,$llave)");
					}
				}
			}
			if(!$mail->Send())
			{
				echo "El mensaje no pudo ser enviado";
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit();
			}
			else
			{
				if($this->depurar==true)
				{
					echo "Mensaje Enviado";
					echo "<br>";
					echo "<pre>";
					print_r($mail);
					echo "</pre>";
				}
			}
			return true;
		}
		else
		{
			return false;
		}
	}

?>
<form name="form1" action="" method="POST" enctype="multipart/form-data">
<input type="hidden" name="AnularOK" value=""/>
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
	//echo $_SESSION['limitsesioneducontinuada'];

	$formulario->dibujar_fila_titulo('Correo Masivo','labelresaltado');
	$campo="boton_tipo"; $parametros="'text','correoorigen',''";
	$formulario->dibujar_campo($campo,$parametros,"Correo de origen","tdtitulogris","correoorigen","requerido");
	$campo="boton_tipo"; $parametros="'text','origen',''";
	$formulario->dibujar_campo($campo,$parametros,"Titulo de origen","tdtitulogris","correoorigen","requerido");
	$campo="boton_tipo"; $parametros="'text','asunto',''";
	$formulario->dibujar_campo($campo,$parametros,"Asunto","tdtitulogris","asunto","requerido");



	$formulario->filatmp["todos"]="Todos";
	$formulario->filatmp["paginaactual"]="Pagina Actual";
	$menu="menu_fila"; $parametrosmenu="'agrupacion','".$_POST['agrupacion']."',''";
	$formulario->dibujar_campo($menu,$parametrosmenu,"Tipo de Agrupacion","tdtitulogris","agrupacion","requerido");

	$camposad[]="boton_tipo"; $parametrosad[]="'file','archivo','".$archivo."',''";
	$camposad[]="boton_tipo"; $parametrosad[]="'submit','Adjuntar','Adjuntar'";
	$formulario->dibujar_campos($camposad,$parametrosad,"Archivo adjunto","tdtitulogris",'adjunto');	
	if(isset($_REQUEST['Adjuntar'])){
		/* echo "<pre>";
		  print_r($HTTP_POST_FILES['archivo']);
		 echo "</pre>";*/
		 if($HTTP_POST_FILES['archivo']['size']<900000){
		 	$cuentaarchivos=count($_SESSION['archivosadjuntos']['name']);
			if(!isset($cuentaarchivos)||($cuentaarchivos==''))
			$cuentaarchivos=0;
			
			if(!copy($HTTP_POST_FILES['archivo']['tmp_name'],"/tmp/tmpeducontinuada".$cuentaarchivos))
			{
				alerta_javascript("Error al copiar el archivo");
			}
			else{
				$_SESSION['archivosadjuntos']['name'][]=$HTTP_POST_FILES['archivo']['name'];
				$_SESSION['archivosadjuntos']['link'][]="/tmp/tmpeducontinuada".$cuentaarchivos;				
			}
		 }
		 else{
			alerta_javascript("Archivo no puede ser de mas de 900kb");
		 }	 
	}
			

			for($i=0;$i<count($_SESSION['archivosadjuntos']['name']);$i++)
			if($i==0)
			$cadena .= $_SESSION['archivosadjuntos']['name'][$i];
			else
			$cadena .= ",".$_SESSION['archivosadjuntos']['name'][$i];
			if(!isset($_REQUEST['Enviar']))
			echo "<tr><td tdtitulogris></td><td>".$cadena."</td></tr>";



	//$formulario->dibujar_campo($campo,$parametros,"Archivo Adjunto","tdtitulogris",'archivo','');
	$campo="memo"; $parametros="'observacionnovedad','estudiantenovedadarp',60,5,'','','',''";
	$formulario->dibujar_campo($campo,$parametros,"Correo","tdtitulogris",'observacionnovedad');
	$formulario->cambiar_valor_campo('observacionnovedad',$observacionnovedad);	 
	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	$parametrobotonenviar[$conboton]="'submit','Borrar','Borrar'";
	$boton[$conboton]='boton_tipo';
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');	

	if(isset($_REQUEST['Enviar'])){
	if(trim($_POST['agrupacion'])=="todos"){
		$query=str_replace($_SESSION['limitsesioneducontinuada'],"",$_SESSION['querystringeducacioncontinuada']);
		$operando=$objetobase->conexion->query($query);
	}
	else{
		$query=$_SESSION['querystringeducacioncontinuada'];
		$operando=$objetobase->conexion->query($query);
	}

	//echo "$query<br>if(".$_POST['agrupacion']."=="."todos)<br>";
	//echo $_SESSION['querystringeducacioncontinuada'];
		/***Armado de correo**/
		$array_datos_correspondencia['correoorigencorrespondencia']=$_POST['correoorigen'];
		$array_datos_correspondencia['nombreorigencorrespondencia']=$_POST['origen'];
		$array_datos_correspondencia['asuntocorrespondencia']=$_POST['asunto'];
		$array_datos_correspondencia['encabezamientocorrespondencia']=$_POST['observacionnovedad'];
		for($i=0;$i<count($_SESSION['archivosadjuntos']['name']);$i++){
			//echo "NOMBRE HABER =".$_SESSION['archivosadjuntos']['name']." ".$_SESSION['archivosadjuntos']['link'][$i];
			$array_datos_correspondencia['detalle'][$_SESSION['archivosadjuntos']['name'][$i]]=$_SESSION['archivosadjuntos']['link'][$i];
			
		}
//		"fmunozb@unal.edu.co";
		$cuentacorreo=0;
		while($row=$operando->fetchRow()){
			if(trim($row["emailestudiante"])!=''){
				//echo "<br>".$row["emailestudiante"];
				$cuentacorreo++;
				if($cuentacorreo<250)
					ConstruirCorreo($array_datos_correspondencia,$row["emailestudiante"],$row["apellidosestudiante"]." ".$row["nombresestudiante"],$row["nombretrato"]." ".$row["apellidosestudiante"]." ".$row["nombresestudiante"]);
				else{
					alerta_javascript("Tope maximo de 250 correos superado");
					break;
				}
			}
		}
		if(isset($_REQUEST['Enviar'])){
			for($i=0;$i<count($_SESSION['archivosadjuntos']['name']);$i++){
					unlink($_SESSION['archivosadjuntos']['link'][$i]);
					unset($_SESSION['archivosadjuntos']['link'][$i]);
			}
				unset($_SESSION['archivosadjuntos']);
		} 
		
		
		alerta_javascript("$cuentacorreo Correos Enviados Exitosamente ");

		//mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
	}
	if(isset($_REQUEST['Borrar'])){
		for($i=0;$i<count($_SESSION['archivosadjuntos']['name']);$i++){
			unlink($_SESSION['archivosadjuntos']['link'][$i]);
			unset($_SESSION['archivosadjuntos']['link'][$i]);

		}
		unset($_SESSION['archivosadjuntos']);
	}

?>	
  </table>
</form>
</body>
</html>
