<?php 
$ruta="../";
$rutaado=($ruta."funciones/adodb/");
require_once($ruta."Connections/salaado-pear.php");
require_once($ruta."funciones/sala_genericas/FuncionesCadena.php");
require_once($ruta."funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once($ruta."funciones/funcionpassword.php");
require_once($ruta."funciones/clases/phpmailer/class.phpmailer.php");
require_once($ruta."funciones/clases/phpmailer/class.phpmailer.php");
require_once($ruta."Connections/conexionldap.php");
require_once($ruta."funciones/clases/autenticacion/claseldap.php");
ini_set('max_execution_time','216000');


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
print_r($_GET);

if($_GET['clbs']=="CB34FGHIL56"){
echo "	2 SALE EL LETRERO?<BR>";
echo "<BR>CLB=".$_GET['clb'];

$objetobase=new BaseDeDatosGeneral($sala);
$objetoldap=new claseldap(SERVIDORLDAP,CLAVELDAP,PUERTOLDAP,CADENAADMINLDAP,"",RAIZDIRECTORIO);
$objetoldap->ConexionAdmin();

//$datosperiodo=$objetobase->recuperar_datos_tabla("periodo","1","1","codigoestadoperiodo in (1,3)","",0);

//$periodo=$datosperiodo["codigoperiodo"];
$condicion=" and u.idusuario=lc.idusuario and
			u.numerodocumento=eg.numerodocumento and
			e.idestudiantegeneral=eg.idestudiantegeneral and
			e.codigocarrera=c.codigocarrera
			group by u.numerodocumento
			order by c.nombrecarrera, eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral";
$tablas="usuario u, logcreacionusuario lc, carrera c, estudiantegeneral eg,estudiante e";
$resultado_documento= $objetobase->recuperar_resultado_tabla($tablas,"codigoestadousuario","400",$condicion,"",1);

//exit();
while ($row = $resultado_documento->fetchRow()){
$estructurausuario[$row['nombrecarrera']]['nombreusuario'][]=$row['apellidosestudiantegeneral']." ".$row['nombresestudiantegeneral'];
$estructurausuario[$row['nombrecarrera']]['usuario'][]=$row['usuario'];
$estructurausuario[$row['nombrecarrera']]['claveusuario'][]=$row['tmpclavelogcreacionusuario'];
$estructurausuario[$row['nombrecarrera']]['codigocarrera']=$row['codigocarrera'];
$estructurausuario[$row['nombrecarrera']]['correousuario'][]=$row['emailestudiantegeneral'];
$estructurausuario[$row['nombrecarrera']]['numerodocumento'][]=$row['numerodocumento'];
$estructurausuario[$row['nombrecarrera']]['apellidos'][]=$row['apellidosestudiantegeneral'];
$estructurausuario[$row['nombrecarrera']]['nombres'][]=$row['nombresestudiantegeneral'];
$estructurausuario[$row['nombrecarrera']]['tipodocumento'][]=$row['tipodocumento'];
$estructurausuario[$row['nombrecarrera']]['semestre'][]=$row['semestre'];

/*$fila['tmpclavelogcreacionusuario']="";
$nombreidtabla='idusuario';
$idtabla=$row["idusuario"];
$objetobase->actualizar_fila_bd("usuario",$fila,$nombreidtabla,$idtabla);*/
unset($fila);

}


/*La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.
Puede ingresar a la página www.unbosque.edu.co en las opciones  servicios en linea, correo  */
//foreach($estructurausuario['PSICOLOGIA'] as )
if(is_array($estructurausuario))
foreach($estructurausuario as $nombrecarrera => $rownombrecarrera){

		for($i=0;$i<count($estructurausuario[$nombrecarrera]['nombreusuario']);$i++)
		{
				$mensaje="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><BR><BR>".
				"La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.
				 Puede ingresar a la página www.unbosque.edu.co en las opciones  servicios en linea, correo<br><br>".
				"<b>usuario:\t".$estructurausuario[$nombrecarrera]['usuario'][$i]."</b><br><b>clave:\t".$estructurausuario[$nombrecarrera]['claveusuario'][$i]."</b>";
				//"<br>CORREO=".$estructurausuario[$nombrecarrera]['correousuario'][$i];
			//mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
			$array_datos_correspondencia['correoorigencorrespondencia']="";
			$array_datos_correspondencia['nombreorigencorrespondencia']="UNBOSQUE UNIVERSIDAD EL BOSQUE";
			$array_datos_correspondencia['asuntocorrespondencia']="USUARIO CUENTA CORREO INSTITUCIONAL";
			$array_datos_correspondencia['encabezamientocorrespondencia']=$mensaje;
			
			$datosusuario["usuario"]=$estructurausuario[$nombrecarrera]['usuario'][$i];
			$datosusuario["nombres"]=$estructurausuario[$nombrecarrera]['nombres'][$i];
			$datosusuario["apellidos"]=$estructurausuario[$nombrecarrera]['apellidos'][$i];
			$datosusuario["clave"]=$estructurausuario[$nombrecarrera]['claveusuario'][$i];
			$datosusuario["numerodocumento"]=$estructurausuario[$nombrecarrera]['numerodocumento'][$i];
			$datosusuario["tipodocumento"]=$estructurausuario[$nombrecarrera]['tipodocumento'][$i];
			$datosusuario["correousuario"]=$estructurausuario[$nombrecarrera]['correousuario'][$i];
			$datosusuario["semestre"]=$estructurausuario[$nombrecarrera]['semestre'][$i];
			$datosusuario["codigocarrera"]=$estructurausuario[$nombrecarrera]['codigocarrera'][$i];

			$objetoldap->CreaUsuarioGoogle($datosusuario);
			ob_flush();
			flush();

			$arrayusuarios=$objetoldap->BusquedaUsuarios("uid=".$datosusuario["usuario"]);
			echo "<br>USUARIO?<PRE>";
			print_r($arrayusuarios);
			echo "</pre>";
			if($arrayusuarios["count"]==0){
			
			echo "<BR>CREANDO USUARIO EN LDAP...<BR>";
			
					$fila["usuario"]=$datosusuario["usuario"];
					$fila["numerodocumento"]=$datosusuario["numerodocumento"];
					$fila["tipodocumento"]=$datosusuario["tipodocumento"];
					$fila["apellidos"]=quitartilde($datosusuario["apellidos"]);
					$fila["nombres"]=quitartilde($datosusuario["nombres"]);
					$fila["codigousuario"]=$datosusuario["numerodocumento"];
					$fila["semestre"]=$datosusuario["semestre"];
					$fila["mail"]=$datosusuario["correousuario"];	
					$fila["codigorol"]=1;
					$fila["fechainiciousuario"]=date("Y-m-d H:i:s");
					$fila["fechavencimientousuario"]="2099-12-31";
					$fila["fecharegistrousuario"]=date("Y-m-d H:i:s");
					$fila["codigotipousuario"]=600;
					$fila["idusuariopadre"]=0;
					$fila["ipaccesousuario"]="";
					$fila["codigoestadousuario"]=400;
		
					//echo "<br>";
					$datoscarreraldap=$objetobase->recuperar_datos_tabla("carreraldap","codigocarrera",$datosorden["codigocarrera"]," and codigoestado=100","",0);
					if(trim($datoscarreraldap["direccioncarreraldap"])!='')
					$dnpadre="ou=Estudiantes,".$datoscarreraldap["direccioncarreraldap"];
					else
					$dnpadre="ou=Usuarios,ou=Estudiantes,".RAIZDIRECTORIO;
					$objetoldap->EntradaEstudiante($datosusuario["usuario"],$datosusuario["clave"],$fila,$dnpadre);

			}
			unset($fila);
			$fila['codigoestadousuario']="100";
			$fila['codigousuario']="100";
			$nombreidtabla='usuario';
			$idtabla="'".$datosusuario["usuario"]."'";
			$objetobase->actualizar_fila_bd("usuario",$fila,$nombreidtabla,$idtabla);
			unset($fila);

			ConstruirCorreo($array_datos_correspondencia,$estructurausuario[$nombrecarrera]['correousuario'][$i],$estructurausuario[$nombrecarrera]['nombreusuario'][$i],$estructurausuario[$nombrecarrera]['nombreusuario'][$i]);
			//exit();
			//ConstruirCorreo($array_datos_correspondencia,"javeeto@gmail.com",$estructurausuario[$nombrecarrera]['nombreusuario'][$i],$estructurausuario[$nombrecarrera]['nombreusuario'][$i]);
			//$estructurausuario[$nombrecarrera]['correousuario'][$i]
		}

echo $nombrecarrera."<br>";
		$codigocarrera=$estructurausuario[$nombrecarrera]['codigocarrera'];
		$tablas="usuario u, usuariofacultad uf";
		$condicion=" and u.usuario=uf.usuario and uf.codigoestado=100 
					and u.codigorol in (3,93) and
					uf.codigofacultad=".$codigocarrera;
		$resultado_uf= $objetobase->recuperar_resultado_tabla($tablas,"u.codigotipousuario","700",$condicion,"",0);



		while ($rowusuariofacultad = $resultado_uf->fetchRow()){

				if(trim($rowusuariofacultad['emailusuariofacultad'])!=''){
				
					$cadenaestudiante="<table border=1><tr><td align='center'><b>NOMBRE</b></td>".
								"<td align='center'><b>DOCUMENTO</b></td>".
								//"<td align='center'><b>CORREO</b></td>".
								"<td align='center'><b>USUARIO</b></td>".
								"<td align='center'><b>CONTRASEÑA</b></td></tr>";
					
					for($i=0;$i<count($estructurausuario[$nombrecarrera]['nombreusuario']);$i++)
					{
					$cadenaestudiante.="<tr><td>".$estructurausuario[$nombrecarrera]['nombreusuario'][$i].
										"</td><td> ". $estructurausuario[$nombrecarrera]['numerodocumento'][$i].
										//"</td><td> ". $estructurausuario[$nombrecarrera]['correousuario'][$i].
										"</td><td> ". $estructurausuario[$nombrecarrera]['usuario'][$i].
										" </td><td>". $estructurausuario[$nombrecarrera]['claveusuario'][$i]."</td></tr>";					
					}
					$cadenaestudiante.="</table>";
					echo "ENTRO HABER".$cadenaestudiante;

					$mensaje="Reciban un respetuoso saludo<br><br>							
							Cordial Saludo<br><br>							
							De la manera más respetuosa se informa que la  relación enviada a cada facultad de usuarios y claves de estudiantes nuevos para correo electrónico y ayudas virtuales es intransferible  y personal, por lo tanto solo debe ser entregada al usuario dueño de la cuenta quien debe identificarse plenamente mediante su documento de identidad o carnet estudiantil, no se debe entregar a terceros. Además recomendar que la clave se debe cambiar inmediatamente.<br>
							Por favor informarle al estudiante que el sistema automáticamente envío un email al correo personal que de  su usuario y clave asignada para la cuenta electrónica de unbosque.<br>
							Cualquier inquietud por favor dirigirla al correo ayuda@unbosque.edu.co<br><br>									
							".$cadenaestudiante."<br>

							Muchas gracias por su colaboración.<br><br>

							<br><br>";
					$encabezado="<br>Señores:<br>Decanos<br>Secretarios Académicos";
					//mail($this->datosorden["emailestudiantegeneral"],"Nueva cuenta de correo UNBOSQUE",$mensaje);
					$array_datos_correspondencia['correoorigencorrespondencia']="";
					$array_datos_correspondencia['nombreorigencorrespondencia']="UNBOSQUE UNIVERSIDAD EL BOSQUE";
					$array_datos_correspondencia['asuntocorrespondencia']="USUARIOS CUENTAS CORREO INSTITUCIONAL ".$nombrecarrera;
					$array_datos_correspondencia['encabezamientocorrespondencia']=$mensaje;
					ConstruirCorreo($array_datos_correspondencia,$rowusuariofacultad['emailusuariofacultad'],$nombrecarrera,$nombrecarrera);
					ConstruirCorreo($array_datos_correspondencia,"lopezjavier@unbosque.edu.co",$encabezado,$encabezado);
				}
		}

}

/* echo "<pre>";
print_r($estructurausuario);
echo "</pre>";*/
 
}
?>
