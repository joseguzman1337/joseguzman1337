<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
define ('RCV_PSWD', 'qwe12ZXC');
$ruta="../../../";
$rutaado=("../../../funciones/adodb/");
//require_once("../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
require_once($ruta."Connections/conexionldap.php");
require_once($ruta."funciones/clases/autenticacion/claseldap.php");
require_once($ruta."funciones/clases/phpmailer/class.phpmailer.php");
require_once($ruta."funciones/funcionpassword.php");


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
				//exit();
			}
			else
			{
				if($depurar==true)
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

if($_SESSION['SESIONINICIADASAHDJASHER8921743']){
$objetobase=new BaseDeDatosGeneral($sala);
$objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
$objetoldap->ConexionAdmin();

$condicion="  l.idusuario=u.idusuario and
			l.codigoestado=100 and
			l.tmpclavelogcreacionusuario <> ''";
$datoslogusuario=$objetobase->recuperar_datos_tabla("usuario u left join logcreacionusuario l on ".$condicion,"u.usuario",trim($_GET['usuario']),"",", u.idusuario codigoidusuario",0);
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiantegeneral eg","eg.numerodocumento",$_GET['numerodocumento'],"","",0);

/*echo "<pre>";
print_r($datoslogusuario);
echo "</pre>";*/

$tabla="logcreacionusuario l";
$fila["codigoestado"]=200;
$nombreidtabla="idusuario";
$idtabla=$datoslogusuario["idusuario"];
if(trim($datoslogusuario["idlogcreacionusuario"])!='')
$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
unset($fila);

//$clave=generar_pass(8);	
//$infomodificado["userPassword"]="{MD5}".base64_encode(pack("H*",md5($clave)));
/*echo "<pre>";
print_r($infomodificado);
echo "</pre>";*/
if(!is_array($objetoldap->DatosUsuario($_GET['usuario']))){
	$action= "EL USUARIO POSIBLEMENTE NO HA SIDO CREADO O NO ESTA HABILITADO";

}else{
/*
$fila["idusuario"]=$datoslogusuario["codigoidusuario"];
$fila["tmpclavelogcreacionusuario"]=$clave;
$fila["observacionlogcreacionusuario"]="Cambio por programa de clave actual<br>
										Enviado al correo ".$datosestudiante["emailestudiantegeneral"]."
										 y usuario ".$_GET['usuario'];
										 
$fila["fechalogcreacionusuario"]=date("Y-m-d");
$fila["numerodocumentocreacionusuario"]=$_GET['numerodocumento'];
$fila["codigoestado"]='100';

*/
//$objetobase->insertar_fila_bd("logcreacionusuario",$fila,0,"");


				$mensaje="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><BR><BR>".
				"La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.
				 Puede ingresar a la página www.unbosque.edu.co en las opciones  servicios en linea, correo<br><br>".
				"<b>usuario:\t".$datoslogusuario['usuario']."</b><br>";
				/*<b>clave:\t".$clave."</b>"*/
				$id = mktime();
				$cod = md5($id . RCV_PSWD . $datoslogusuario['usuario']);
				$urlRecuperacion = SERVIDORLDAPGAPPS.'recuperacion.php?id=' . $id . '&cod=' . $cod . '&login=' . $datoslogusuario['usuario'];
				$mensaje.="<br>Para asignar Usted mismo la contraseña use el vínculo de abajo:<br><br>".$urlRecuperacion;
				//"<br>CORREO=".$estructurausuario[$nombrecarrera]['correousuario'][$i];
			//mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
			$array_datos_correspondencia['correoorigencorrespondencia']=CORREOMESADEAYUDA;
			//echo "mesa de ayuda -->".CORREOMESADEAYUDA." - servidor gapps ".SERVIDORLDAPGAPPS; die;
			$array_datos_correspondencia['nombreorigencorrespondencia']="UNIVERSIDAD EL BOSQUE";
			$array_datos_correspondencia['asuntocorrespondencia']="USUARIO CUENTA CORREO INSTITUCIONAL";
			$array_datos_correspondencia['encabezamientocorrespondencia']=$mensaje;
			//ConstruirCorreo($array_datos_correspondencia,"lopezjavier@unbosque.edu.co",$datoslogusuario['apellidos']." ".$datoslogusuario['nombres'],$datoslogusuario['apellidos']." ".$datoslogusuario['nombres']);
			ConstruirCorreo($array_datos_correspondencia,$datosestudiante["emailestudiantegeneral"],$datoslogusuario['apellidos']." ".$datoslogusuario['nombres'],$datoslogusuario['apellidos']." ".$datoslogusuario['nombres']);

	$action= "CORREO ENVIADO A LA DIRECCION ".$datosestudiante["emailestudiantegeneral"];
}
	
	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
		
	//echo '<action>' . $action . '</action>';
	echo $action;
	echo '</data>';
}
?>
