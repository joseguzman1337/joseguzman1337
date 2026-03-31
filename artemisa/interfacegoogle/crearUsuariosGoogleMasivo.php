<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
session_start();
ini_set('mysql.connect_timeout', 50400);
ini_set('default_socket_timeout', 50400);

//require_once("crearlistacorreo.php");
include_once "google/examples/templates/base.php";
ini_set('max_execution_time', '216000');

$ruta="../serviciosacademicos/";
$rutaado=("../serviciosacademicos/funciones/adodb/");
require_once(dirname(__FILE__)."/../serviciosacademicos/Connections/salaado-pear.php");
require_once(dirname(__FILE__).'/../serviciosacademicos/Connections/sala2.php');
$rutaado = dirname(__FILE__)."/../serviciosacademicos/funciones/adodb/";
require_once(dirname(__FILE__).'/../serviciosacademicos/Connections/salaado.php');
require_once(dirname(__FILE__)."/../serviciosacademicos/consulta/estadisticas/matriculasnew/funciones/obtener_datos.php");
require_once(dirname(__FILE__)."/crearusuariogoogle.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/Connections/conexionldap.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/funciones/clases/autenticacion/claseldap.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/funciones/funcionpassword.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/funciones/clases/phpmailer/class.phpmailer.php");

function ConstruirCorreo($array_datos_correspondencia,$destinatario,$nombredestinatario,$trato){
		if(is_array($array_datos_correspondencia))
		{
			$mail = new PHPMailer();
			$mail->SetLanguage("es", dirname(__FILE__).'/../serviciosacademicos/funciones/clases/phpmailer/language/');
	
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
					echo "Mensaje Enviado";
					echo "<br>";
					echo "<pre>";
					print_r($mail);
					echo "</pre>";
			}
			return true;
		}
		else
		{
			return false;
		}
}

if($_GET["clavemd5"]==md5(CLAVECONEXIONGOOGLE)){
	$periodo = $db->GetRow("SELECT codigoperiodo FROM periodo where codigoestadoperiodo=1");
	
	
	$objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
	$objetoldap->ConexionAdmin();
	/*$datos = new obtener_datos_matriculas($sala,$periodo["codigoperiodo"]);

	//echo "<pre>";print_r($db);
	$pregrado=$datos->obtener_datos_estudiantes_matriculados_nuevos("","arreglo",null,200);
	$postgrado=$datos->obtener_datos_estudiantes_matriculados_nuevos("","arreglo",null,300);
	$total = array_merge($pregrado,$postgrado);
	//echo "<pre>";print_r($total);
	//var_dump(count($total));
	//$estudiante = $total[0];
	
	//die;*/
	$total = $db->Execute("select u.usuario,eg.numerodocumento,e.codigoestudiante from usuario u,estudiantegeneral eg,estudiante e, carrera c 
							WHERE u.codigoestadousuario=400 and 
										u.numerodocumento=eg.numerodocumento and 
										e.idestudiantegeneral=eg.idestudiantegeneral AND e.codigocarrera=c.codigocarrera 
										and c.codigomodalidadacademica in (200,300)
										group by u.numerodocumento ");
	
	foreach($total as $estudiante){
		
		session_start();  
		$datos = $db->GetRow('select eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,CONCAT(u.usuario,"@unbosque.edu.co") as email,u.usuario,
					IF(lg.tmpclavelogcreacionusuario IS NULL, SUBSTRING(UUID(),1,8), lg.tmpclavelogcreacionusuario) as clave,eg.emailestudiantegeneral as correousuario,
					eg.tipodocumento, e.semestre,e.codigocarrera
					 from estudiante e 
					inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
					inner join usuario u on u.numerodocumento=eg.numerodocumento and u.codigoestadousuario<>200 and u.codigotipousuario like "6%"
					LEFT JOIN logcreacionusuario lg on lg.idusuario=u.idusuario and lg.codigoestado=100 
					where e.codigoestudiante='.$estudiante['codigoestudiante']);
					
		if(is_array($datos)&&count($datos)>0){
			crearUsuarioGoogle($datos["usuario"],$datos["apellidosestudiantegeneral"],$datos["nombresestudiantegeneral"],$datos["clave"]);
			
			$mensaje="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><BR><BR>".
				"La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.
				 Puede ingresar a la página www.unbosque.edu.co en las opciones  servicios en linea, correo<br><br>".
				"<b>usuario:\t".$datos['usuario']."</b><br><b>clave:\t".$datos['clave']."</b>";
				//"<br>CORREO=".$estructurausuario[$nombrecarrera]['correousuario'][$i];
			//mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
			$array_datos_correspondencia['correoorigencorrespondencia']="no-responder@unbosque.edu.co";
			$array_datos_correspondencia['nombreorigencorrespondencia']="UNBOSQUE UNIVERSIDAD EL BOSQUE";
			$array_datos_correspondencia['asuntocorrespondencia']="USUARIO CUENTA CORREO INSTITUCIONAL";
			$array_datos_correspondencia['encabezamientocorrespondencia']=$mensaje;
			
			//verificar en el ldap
			$arrayusuarios=$objetoldap->BusquedaUsuarios("uid=".$datos["usuario"]);
			echo "<br>USUARIO?<PRE>";
			print_r($arrayusuarios);
			echo "</pre>";
			if($arrayusuarios["count"]==0){
			
			echo "<BR>CREANDO USUARIO EN LDAP...<BR>";
			
					$fila["usuario"]=$datos["usuario"];
					$fila["numerodocumento"]=$datos["numerodocumento"];
					$fila["tipodocumento"]=$datos["tipodocumento"];
					$fila["apellidos"]=quitartilde($datos["apellidosestudiantegeneral"]);
					$fila["nombres"]=quitartilde($datos["nombresestudiantegeneral"]);
					$fila["codigousuario"]=$datos["numerodocumento"];
					$fila["semestre"]=$datos["semestre"];
					$fila["mail"]=$datos["correousuario"];	
					$fila["codigorol"]=1;
					$fila["fechainiciousuario"]=date("Y-m-d H:i:s");
					$fila["fechavencimientousuario"]="2099-12-31";
					$fila["fecharegistrousuario"]=date("Y-m-d H:i:s");
					$fila["codigotipousuario"]=600;
					$fila["idusuariopadre"]=0;
					$fila["ipaccesousuario"]="";
					$fila["codigoestadousuario"]=400;
		
					//echo "<br>";
					
					$datoscarreraldap=$db->GetRow("select * from carreraldap where codigocarrera=".$datos["codigocarrera"]." and codigoestado=100");
					if(trim($datoscarreraldap["direccioncarreraldap"])!=''){
					$dnpadre="ou=Estudiantes,".$datoscarreraldap["direccioncarreraldap"];}
					else{
					$dnpadre="ou=Usuarios,ou=Estudiantes,".RAIZDIRECTORIO;
					$objetoldap->EntradaEstudiante($datos["usuario"],$datos["clave"],$fila,$dnpadre);}

			}
			unset($fila);
			
			//actualizar estado usuario
			$db->Execute("UPDATE usuario SET codigoestadousuario='100' WHERE usuario='".$datos["usuario"]."'");
			$db->Execute("UPDATE usuario SET codigoestadousuario='200' WHERE numerodocumento='".$datos["numerodocumento"]."' AND codigoestadousuario<>100 AND codigotipousuario=600");
			
			echo "<br/>ya quedo... enviando correo";
			//enviar correo 
			ConstruirCorreo($array_datos_correspondencia,$datos['correousuario'],$datos['usuario'],quitartilde($datos["nombresestudiantegeneral"])." ".quitartilde($datos["apellidosestudiantegeneral"]));
			
		}
		echo "<br/><br/>hizo el de ".$datos["usuario"]." - ".$datos["apellidosestudiantegeneral"].$datos["clave"]."<br/>";
	}
}