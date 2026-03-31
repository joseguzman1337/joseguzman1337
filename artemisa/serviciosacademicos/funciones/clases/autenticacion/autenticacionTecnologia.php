<?php
class autenticacionTecnologia
{

	var $conexion;
	var $usuario;
	var $password;
	var $fechahoy;
	var $permisoAutenticar=false;
	var $politicaCantidadDiasCaducidad;
	var $politicaCantidadIntentosAcceso;
	var $autenticacionAutorizada=false;
	var $mensajeUsuario;
	var $arrayClavesUsuario;
	var $arrayDatosUsuario;
	var $urlRedireccionamiento;
	var $frameRedireccionamiento;
	var $arrayCarrerasUsuario;
	var $claveViva;
	var $ip;
	var $modoRespuestaAutenticacion='XML';
	var $ArrayContadorIntentosAccesoFallidos;
	var $autenticarSegundaClave;
	var $passwordPlano;
	var $arrayAut;

	function autenticacionTecnologia(&$conexion,$usuario){

		$_SESSION['MM_Username'] = $usuario;
		
		$this->conexion=$conexion;
		$this->fechahoy=date("Y-m-d H:i:s");
		$this->usuario=$usuario;
		$this->ip=$this->tomarip();

		if(!empty($usuario)){
			$valido=$this->validarUsuarioBD($usuario);
			if($valido){
				$this->autenticar();
			}
		}
		$this->generaArrayAutenticacion();
		$this->autenticacionAutorizada=true;
		$_SESSION['auth']=true;
		//print_r($this->arrayAut[0]['url']);
		//exit();
		header("Location: " . $this->arrayAut[0]['url'] );
		echo '<script language="javascript">parent.document.location.href="consultafacultadesv2.htm"</script>';
	}

	function activaAutenticarSegundaClave(){
		$this->autenticarSegundaClave=true;
	}

	function autenticar(){
		$this->registraVariablesSesionInicio();
		$this->mensajeUsuario="Autenticado correctamente";
		$this->cargaVariables();
		$this->registraLogActividadUsuario();
	}

	function verificaPasswd(){
		if($this->password==$this->arrayClavesUsuario[0]['claveusuario']){
			return true;
		}
		else{
			return false;
		}
	}

	function verificarSiClaveCorreoHaCambiado($password){
		if($this->arrayClavesUsuario[0]['codigoestado']==200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
			if($this->password==$this->arrayClavesUsuario[0]['claveusuario']){
				return false;
				//no ha cambiado la clave
			}
			else{
				//ya cambio la clave
				return true;
			}
		}
	}

	function caducarUltimoRegistroClave($idusuario){

		if($this->arrayClavesUsuario[0]['codigoestado']<>200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']<>200){
			$query="UPDATE claveusuario SET codigoestado='200',codigoindicadorclaveusuario='200', fechavenceclaveusuario='$this->fechahoy'
			WHERE idusuario='$idusuario' and idclaveusuario='".$this->arrayClavesUsuario[0]['idclaveusuario']."'
			";
			$operacion=$this->conexion->query($query);
			if($operacion){
				return true;
			}
		}
		else{
			return false;
		}
	}

	function validarCorreo($usuario,$password)
	{
		error_reporting(0);
		//sleep(500);
		$msgbox=imap_open ("{172.16.7.109/pop3:110/notls}Inbox", $usuario, $password, OP_HALFOPEN);

		if($msgbox)
		{
			//print ("".$_POST['user']." Conexion satisfactoria!");
			return true;
			imap_close($msgbox);
		}
		else
		{
			$msgbox=imap_open ("{127.0.0.1/pop3:110/notls}Inbox", $usuario, $password, OP_HALFOPEN);
			if($msgbox)
			{
				//print ("".$_POST['user']." Conexion satisfactoria!");
				return true;
				imap_close($msgbox);
			}
			else
			{
				$msgbox = imap_open("{172.16.7.108:143}INBOX", $usuario, $password, OP_HALFOPEN);
				if($msgbox){
					return true;
				}
				else{
					return false;
				}
			}
		}
	}

	function leeContadorIntentosAccesoFallidos(){
		$queryLogIntentos="SELECT * from logintentosaccesousuario WHERE idusuario='".$this->arrayDatosUsuario['idusuario']."'";
		$logIntentos=$this->conexion->query($queryLogIntentos);
		$rowLogIntentos=$logIntentos->fetchRow();
		if(is_array($rowLogIntentos)){
			return $rowLogIntentos;
		}
		else {
			return false;
		}

	}

	function aumentaContadorIntentosAccesoFallidos(){

		if(is_array($this->ArrayContadorIntentosAccesoFallidos)){
			$queryActualizaIntentos="UPDATE logintentosaccesousuario SET contadorlogintentosaccesousuario = '".($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] + 1)."' WHERE idusuario='".$this->ArrayContadorIntentosAccesoFallidos['idusuario']."'";
			$operacion=$this->conexion->query($queryActualizaIntentos);
		}
		else{
			$queryInsertaIntentos="INSERT into logintentosaccesousuario VALUES('','".$this->arrayDatosUsuario['idusuario']."','1')";
			$operacion=$this->conexion->query($queryInsertaIntentos);
		}
	}

	function reseteaContadorIntentosAccesoFallidos(){
		if(is_array($this->ArrayContadorIntentosAccesoFallidos)){
			$queryActualizaIntentos="UPDATE logintentosaccesousuario SET contadorlogintentosaccesousuario = 0 WHERE idusuario='".$this->ArrayContadorIntentosAccesoFallidos['idusuario']."'";
			$operacion=$this->conexion->query($queryActualizaIntentos);
		}
	}

	function verificaPoliticaIntentosAccesoUsuario(){
		if($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] >= $this->politicaCantidadIntentosAcceso){
			return false;
		}
		else {
			return true;
		}
	}

	function defineAutenticacion(){

		switch ($this->arrayDatosUsuario['codigorol']){
			case '1':
				//estudiante se autentica por correo y se obliga a cambiar clave con politica vencimiento
				$correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
				if($correoValido){
					$cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],1);
					if($cantClaves==0){
						$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
						$this->autenticacionAutorizada=true;
					}
					else{
						$this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],1);
						$verificaClaveViva=$this->verificaUltimaClaveViva();
						if($verificaClaveViva==true){
							$verificaPasswd=$this->verificaPasswd();
							if($verificaPasswd==true){
								$this->autenticacionAutorizada=true;
								$this->mensajeUsuario="Clave correcta";
							}
							else{
								//actualizar registro, se supone que el usuario cambió la clave del correo antes de caducar, pero validó OK
								$this->actualizaRegistroPasswd($this->arrayClavesUsuario[0]['idclaveusuario']);
								$this->autenticacionAutorizada=true;
								$this->mensajeUsuario="Clave correcta";
							}
						}
						else{
							$caducar=$this->caducarUltimoRegistroClave($this->arrayDatosUsuario['idusuario']);
							if($caducar==true){
								$this->mensajeUsuario="Su clave caducó";
							}
							else{
								$cambioClave=$this->verificarSiClaveCorreoHaCambiado($this->password);
								if($cambioClave==true){
									$regClave=$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
									if($regClave==true){
										$this->autenticacionAutorizada=true;
									}
								}
								else{
									$this->mensajeUsuario="Aún no ha cambiado su clave de correo electrónico. No podrá entrar al Sistema de Gestión Académica hasta que no cambie la clave del correo";
								}
							}
						}
					}
				}
				else{
					$this->autenticacionAutorizada=false;
					$this->mensajeUsuario="Error de autenticación de correo electrónico";
				}

				break;
			case '2':
				//docente se autentica por correo y se obliga a cambiar clave con politica vencimiento, igual aplica la segunda clave
				//si la bandera autenticar segunda clave es true, se supone que ya habia autenticado correo, por lo que no se requiere revisar esa validacion de nuevo
				if($this->autenticarSegundaClave==true){
					$correoValido=true;
				}
				else{
					$correoValido=$this->validarCorreo($this->usuario,$this->passwordPlano);
				}

				if($correoValido){
					$cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],1);
					if($cantClaves==0){
						$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
						$this->mensajeUsuario="Primera clave(la del correo) correcta, ahora debe diligenciar una nueva segunda clave";
						//en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo
						$this->autenticacionAutorizada=false;

						$cantClaves2BD=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],2);
						if($cantClaves2BD==0){
							$this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
						}
						$_SESSION['2clavereq']='SEGCLAVEREQ';
					}
					else{
						if($this->autenticarSegundaClave==true){
							$this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],3);
						}
						else{
							$this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],1);
						}
						$verificaClaveViva=$this->verificaUltimaClaveViva();
						if($verificaClaveViva==true){
							$verificaPasswd=$this->verificaPasswd();
							if($verificaPasswd==true){
								if($this->autenticarSegundaClave==true){
									$this->autenticacionAutorizada=true;
									$this->mensajeUsuario="Segunda clave correcta";
								}
								else{
									//en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo, activar bandera AutenticacionAutorizada
									$this->autenticacionAutorizada=false;
									$this->mensajeUsuario="Primera clave(la del correo) correcta, ahora debe digitar la segunda clave";
									$_SESSION['2clavereq']='SEGCLAVE';
								}
							}
							else{
								if($this->autenticarSegundaClave==true){
									$this->mensajeUsuario="Segunda clave incorrecta";
								}
								else{
									//actualizar registro, se supone que el usuario cambió la clave del correo antes de caducar, pero validó OK
									$this->actualizaRegistroPasswd($this->arrayClavesUsuario[0]['idclaveusuario']);
								}



							}
						}
						else{
							$caducar=$this->caducarUltimoRegistroClave($this->arrayDatosUsuario['idusuario']);
							if($caducar==true){
								$this->mensajeUsuario="Su clave caducó";
							}
							else{
								$cambioClave=$this->verificarSiClaveCorreoHaCambiado($this->password);
								if($cambioClave==true){
									$regClave=$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,1);
									if($regClave==true){
										if($this->autenticarSegundaClave==true){
											$this->autenticacionAutorizada=true;
											$this->mensajeUsuario="Segunda clave correcta";
										}
										else{
											//en ningun caso habilita true, eso se hace porque los docentes tienen que pasar la segunda clave, luego de la autenticacion x correo, activar bandera AutenticacionAutorizada
											$this->autenticacionAutorizada=false;
											$this->mensajeUsuario="Primera clave(la del correo) correcta";
											$_SESSION['2clavereq']='SEGCLAVE';
										}
									}
								}
								else{
									$this->autenticacionAutorizada=false;
									$this->mensajeUsuario="Aún no ha cambiado su clave de correo electrónico. No podrá entrar al Sistema de Gestión Académica hasta que no cambie la clave del correo";
								}
							}
						}
					}
				}
				else{
					$this->autenticacionAutorizada=false;
					$this->mensajeUsuario="Error de autenticación de correo electrónico";
				}



				break;
			case '3':
				//administrativo se autentica por bd y se obliga a cambiar la clave con politica de vencimiento y control de intentos de acceso a usuario
				$cantClaves=$this->validarExistenciaClave($this->arrayDatosUsuario['idusuario'],2);
				if($cantClaves==0){
					//si no hay clave, se va a guardar la del correo electronico ahora
					$validoCorreo=$this->validarCorreo($this->usuario,$this->passwordPlano);
					if($validoCorreo==true){
						$this->registraClaveBD($this->arrayDatosUsuario['idusuario'],$this->password,2);
						$this->reseteaContadorIntentosAccesoFallidos();
						$this->autenticacionAutorizada=true;
						$this->mensajeUsuario="Clave correcta";
					}
					else{
						$this->autenticacionAutorizada=false;
						$this->mensajeUsuario="Error de autenticación de correo electrónico";
					}
					//desactivado, se usara la clave del correo electronico
					/*$this->claveViva="nueva";
					$this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
					$this->frameRedireccionamiento="contenidocentral";
					$this->autenticacionAutorizada=false;
					$this->mensajeUsuario="Por favor digite clave nueva";*/
				}
				else{
					//ya hay clave, verificar que está viva
					$this->leerClavesCorreoBD($this->arrayDatosUsuario['idusuario'],2);
					$verificaClaveViva=$this->verificaUltimaClaveViva();
					if($verificaClaveViva==true){
						$verificaPoliticaIntentosAcceso=$this->verificaPoliticaIntentosAccesoUsuario();
						if($verificaPoliticaIntentosAcceso==true){
							$verificaPasswd=$this->verificaPasswd();
							if($verificaPasswd==true){
								$this->autenticacionAutorizada=true;
								$this->reseteaContadorIntentosAccesoFallidos();
								$this->mensajeUsuario="Clave correcta";
							}
							else{
								$this->aumentaContadorIntentosAccesoFallidos();
								$this->autenticacionAutorizada=false;
								$contIntentos=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario']+1;
								$this->mensajeUsuario="Clave incorrecta. Usted tiene acumulados ".$contIntentos." intentos fallidos. Por su seguridad su clave será bloqueada después de ".$this->politicaCantidadIntentosAcceso." intentos fallidos.";
							}
						}
						else{
							$this->autenticacionAutorizada=false;
							$this->actualizaUltimaClaveViva(200,400);
							$this->mensajeUsuario="Clave Bloqueada por intentos de acceso fallidos";
							$this->urlRedireccionamiento="../formClaveBDBloqAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
							$this->frameRedireccionamiento="contenidocentral";
						}
					}
					else{
						//****la primera vez, antes de actualizar la bd***revisar....logica
						$verificaExistenciaPreguntaSecret=$this->verificaExistenciaPreguntaRespuestaSecreta();
						if($verificaExistenciaPreguntaSecret==true){
							$this->claveViva="caduca";
							$this->urlRedireccionamiento="../formClaveBDCaducaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
							$this->frameRedireccionamiento="contenidocentral";
							$this->autenticacionAutorizada=false;
							$this->mensajeUsuario="Clave caducada";
						}
						else{
							$this->claveViva="caduca";
							$this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
							$this->frameRedireccionamiento="contenidocentral";
							$this->autenticacionAutorizada=false;
							$this->mensajeUsuario="Clave caducada";
						}
						/********************************************/
						if($this->arrayClavesUsuario[0]['codigoestado']<>200){
							$this->actualizaUltimaClaveViva(200,200);
						}
						$verificaDesbloqueo=$this->verificaDesbloqueoUltimaClave();
						if($verificaDesbloqueo==false){
							//verificar existencia de pregunta secreta
							$verificaExistenciaPreguntaSecreta=$this->verificaExistenciaPreguntaRespuestaSecreta();
							if($verificaExistenciaPreguntaSecreta==true){
								if($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
									$this->claveViva="caduca";
									$this->urlRedireccionamiento="../formClaveBDCaducaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
									$this->frameRedireccionamiento="contenidocentral";
									$this->autenticacionAutorizada=false;
									$this->mensajeUsuario="Clave caducada";
								}
								elseif ($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==400){
									$this->autenticacionAutorizada=false;
									$this->mensajeUsuario="Clave Bloqueada por intentos de acceso fallidos";
									$this->urlRedireccionamiento="../formClaveBDBloqAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
									$this->frameRedireccionamiento="contenidocentral";
								}
							}
							else{
								if($this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==200){
									$this->claveViva="caduca";
									$this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
									$this->frameRedireccionamiento="contenidocentral";
									$this->autenticacionAutorizada=false;
									$this->mensajeUsuario="Clave caducada";
								}

							}
						}
						else{
							$this->claveViva="desbloqueada";
							$this->urlRedireccionamiento="../formClaveBDNuevaAjax.php?idusuario=".$this->arrayDatosUsuario['idusuario'];
							$this->frameRedireccionamiento="contenidocentral";
							$this->autenticacionAutorizada=false;
							$this->mensajeUsuario="Su clave ha sido desbloqueada";
						}
					}
				}
				break;
		}
	}

	function verificaExistenciaPreguntaRespuestaSecreta(){
		$query="SELECT idreferenciaclaveusuario FROM referenciaclaveusuario WHERE idusuario='".$this->arrayDatosUsuario['idusuario']."
		AND $this->fechahoy BETWEEN fechainicioreferenciaclaveusuario AND fechafinalreferenciaclaveusuario
		'";
		$op=$this->conexion->query($query);
		$numRows=$op->numRows();
		if($numRows>0){
			return true;
		}
		else {
			return false;
		}
	}

	function actualizaRegistroPasswd($idclaveusuario){
		$query="UPDATE claveusuario SET claveusuario='$this->password' WHERE idclaveusuario='$idclaveusuario'";
		$op=$this->conexion->query($query);
	}

	function registraVariablesSesionInicio(){

		if($this->autenticacionAutorizada==true){
			$_SESSION['auth']=true;
		}
		else{
			$_SESSION['auth']=false;
		}
	}

	function validarUsuarioBD($usuario){

		$user = (get_magic_quotes_gpc()) ? $usuario : addslashes($usuario);
		$queryUser = sprintf("SELECT * FROM usuario WHERE usuario = '%s'", $user);
		$operacion=$this->conexion->query($queryUser);
		$numRowsOperacion=$operacion->numRows();
		if($numRowsOperacion == 1){
			$rowOperacion=$operacion->fetchRow();
			$this->arrayDatosUsuario=$rowOperacion;
			return true;
		}
		else{
			return false;
		}
	}

	function registraClaveBD($idusuario,$password,$codigotipoclaveusuario){
		$queryInsertaReg="INSERT INTO claveusuario VALUES('','$idusuario','$this->fechahoy','$this->fechahoy','2999-12-31','".$password."','100','100','".$codigotipoclaveusuario."')";
		$operacion=$this->conexion->query($queryInsertaReg);
		if($operacion){
			return true;
		}
		else{
			return false;
		}
	}

	function validarExistenciaClave($idusuario,$codigotipoclaveusuario){
		$query="SELECT count(cu.idclaveusuario) as cantClaves FROM claveusuario cu
		WHERE 
		cu.idusuario='$idusuario' AND cu.codigotipoclaveusuario='$codigotipoclaveusuario'" ;
		$operacion=$this->conexion->query($query);
		$rowOperacion=$operacion->fetchRow();
		return $rowOperacion['cantClaves'];

	}

	function leerClavesCorreoBD($idusuario,$codigotipoclaveusuario){
		$query="SELECT cu.* FROM claveusuario cu
		WHERE 
		cu.idusuario='$idusuario' AND cu.codigotipoclaveusuario = '$codigotipoclaveusuario' ORDER BY cu.idclaveusuario DESC";
		$operacion=$this->conexion->query($query);
		$rowOperacion=$operacion->fetchRow();
		do{
			$this->arrayClavesUsuario[]=$rowOperacion;
		}
		while ($rowOperacion=$operacion->fetchRow());
	}

	function actualizaUltimaClaveViva($codigoestado,$codigoindicadorclaveusuario){
		$query="UPDATE claveusuario SET fechavenceclaveusuario='$this->fechahoy',codigoindicadorclaveusuario='$codigoindicadorclaveusuario',codigoestado='$codigoestado' WHERE idclaveusuario='".$this->arrayClavesUsuario[0]['idclaveusuario']."'";
		$operacion=$this->conexion->query($query);
	}

	function verificaUltimaClaveViva(){
		$fechasinformato=strtotime("+$this->politicaCantidadDiasCaducidad day",strtotime($this->arrayClavesUsuario[0]['fechainicioclaveusuario']));
		$fechanueva=date("Y-m-d H:i:s",$fechasinformato);
		if($this->arrayClavesUsuario[0]['codigoestado']==100 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==100){
			if($fechanueva >= $this->fechahoy){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	function verificaDesbloqueoUltimaClave(){
		if($this->arrayClavesUsuario[0]['codigoestado']==200 and $this->arrayClavesUsuario[0]['codigoindicadorclaveusuario']==500){
			return true;
		}
		else{
			return false;
		}
	}

	function leerPoliticaClave(){
		$queryPoliticaClave="SELECT pc.* FROM politicaclave pc
		WHERE '$this->fechahoy' between pc.fechadesdepoliticaclave and pc.fechahastapoliticaclave";
		$politicaClave=$this->conexion->query($queryPoliticaClave);
		$rowPoliticaClave=$politicaClave->fetchRow();
		$numRowsPoliticaClave=$politicaClave->numRows();

		$this->politicaCantidadDiasCaducidad=$rowPoliticaClave['diascaducidadpoliticaclave'];
		$this->politicaCantidadIntentosAcceso=$rowPoliticaClave['numerointentospoliticaclave'];

		if(empty($cantDias)){
			$cantDias=30;
		}
		if (empty($numerointentospoliticaclave)) {
			$numerointentospoliticaclave=5;
		}
	}

	function registraLogActividadUsuario(){
		$queryLogActividadUsuario="INSERT INTO logactividadusuario VALUES ('','".$this->arrayDatosUsuario['idusuario']."', '".$this->fechahoy."', '$this->ip')";
		$operacion=$this->conexion->query($queryLogActividadUsuario);
	}



	function tomarip()
	{
		if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else
		{
			if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else
			{
				if(preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"]))
				{
					$ip = $_SERVER["REMOTE_HOST"];
				}
				else
				{
					$ip = $_SERVER["REMOTE_ADDR"];
				}
			}
		}
		return $ip;
	}

	function generaXML(){
		if(!empty($_SESSION['2clavereq'])){
			$aut=$_SESSION['2clavereq'];
		}
		elseif($this->autenticacionAutorizada==true){
			$aut="OK";
		}
		else{
			$aut="ERROR";
		}
		if(empty($this->mensajeUsuario)){
			$this->mensajeUsuario="0";
		}
		if(empty($this->urlRedireccionamiento)){
			$this->urlRedireccionamiento="0";
		}
		if(empty($this->frameRedireccionamiento)){
			$this->frameRedireccionamiento="0";
		}
		if(empty($this->arrayDatosUsuario['idusuario'])){
			$this->arrayDatosUsuario['idusuario']="0";
		}
		if(empty($this->arrayDatosUsuario['codigorol'])){
			$this->arrayDatosUsuario['codigorol']="0";
		}
		if(empty($this->claveViva)){
			$this->claveViva="0";
		}
		if(empty($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'])){
			$contador="-";
		}
		else{
			$contador=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'];
		}
		if(empty($this->politicaCantidadIntentosAcceso)){
			$politicaIntentosAcceso=0;
		}
		else{
			$politicaIntentosAcceso=$this->politicaCantidadIntentosAcceso;
		}

		header('Content-Type: text/xml');
		/*echo '<?xml version="1.0" encoding="UTF-8"?>';*/
		echo '<?xml version="1.0" encoding="LATIN1"?>';
		echo "<resultado>";
		echo "<autenticacion>";
		echo $aut;
		echo "</autenticacion>";
		echo "<rol>";
		echo $this->arrayDatosUsuario['codigorol'];
		echo "</rol>";
		echo "<url>";
		echo $this->urlRedireccionamiento;
		echo "</url>";
		echo "<frame>";
		echo $this->frameRedireccionamiento;
		echo "</frame>";
		echo "<idusuario>";
		echo $this->arrayDatosUsuario['idusuario'];
		echo "</idusuario>";
		echo "<mensaje>";
		echo $this->mensajeUsuario;
		echo "</mensaje>";
		echo "<claveviva>";
		echo $this->claveViva;
		echo "</claveviva>";
		echo "<contadorintentosfallidos>";
		echo $contador;
		echo "</contadorintentosfallidos>";
		echo "<cantidadintentosaccesopermitidos>";
		echo $politicaIntentosAcceso;
		echo "</cantidadintentosaccesopermitidos>";
		echo "</resultado>";
	}

	function generaArrayAutenticacion(){

		if(!empty($_SESSION['2clavereq'])){
			$aut=$_SESSION['2clavereq'];
		}
		elseif($this->autenticacionAutorizada==true){
			$aut="OK";
		}
		else{
			$aut="ERROR";
		}
		if(empty($this->mensajeUsuario)){
			$this->mensajeUsuario="0";
		}
		if(empty($this->urlRedireccionamiento)){
			$this->urlRedireccionamiento="0";
		}
		if(empty($this->frameRedireccionamiento)){
			$this->frameRedireccionamiento="0";
		}
		if(empty($this->arrayDatosUsuario['idusuario'])){
			$this->arrayDatosUsuario['idusuario']="0";
		}
		if(empty($this->arrayDatosUsuario['codigorol'])){
			$this->arrayDatosUsuario['codigorol']="0";
		}
		if(empty($this->claveViva)){
			$this->claveViva="0";
		}
		if(empty($this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'])){
			$contador="-";
		}
		else{
			$contador=$this->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'];
		}
		if(empty($this->politicaCantidadIntentosAcceso)){
			$politicaIntentosAcceso=0;
		}
		else{
			$politicaIntentosAcceso=$this->politicaCantidadIntentosAcceso;
		}

		$arrayAutenticacion[0]['autenticacion']=$aut;
		$arrayAutenticacion[0]['rol']=$this->arrayDatosUsuario['codigorol'];
		$arrayAutenticacion[0]['url']=$this->urlRedireccionamiento;
		$arrayAutenticacion[0]['frame']=$this->frameRedireccionamiento;
		$arrayAutenticacion[0]['idusuario']=$this->arrayDatosUsuario['idusuario'];
		$arrayAutenticacion[0]['mensaje']=$this->mensajeUsuario;
		$arrayAutenticacion[0]['claveviva']=$this->claveViva;
		$arrayAutenticacion[0]['contadorintentosfallidos']=$contador;
		$arrayAutenticacion[0]['cantidadintentosaccesopermitidos']=$politicaIntentosAcceso;
		$this->arrayAut=$arrayAutenticacion;

	}

	function cargaVariables(){
		//si hay clave viva y valida (no caduca) continua proceso login
		$rol= $this->arrayDatosUsuario['codigorol'];

		$query_selperiodo = "select p.codigoperiodo, e.codigoestadoperiodo
			from periodo p, estadoperiodo e
			where p.codigoestadoperiodo = e.codigoestadoperiodo
			and e.codigoestadoperiodo = '1'";					
		//echo "$query_selperiodo<br>";
		$selperiodo = $this->conexion->query($query_selperiodo);
		$totalRows_selperiodo=$selperiodo->numRows();
		$row_selperiodo=$selperiodo->fetchRow();
		//echo $_SESSION['Username'];

		if($rol==1)
		{
			$_SESSION['nuevoMenu']=true;
			$_SESSION['MM_Username'] = 'estudiante';

			$_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
			$_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];


			$_SESSION['rol'] = $rol;
			//$_SESSION['codigo']=$row_Recordset1['codigousuario'];
			$_SESSION['codigo']=$this->arrayDatosUsuario['numerodocumento'];
			/////////////////////////////
			$query_periodo = "SELECT * FROM estudiantegeneral WHERE numerodocumento = '".$_SESSION['codigo']."'";
			//echo $query_periodo;
			//exit();
			$periodo = $this->conexion->query($query_periodo);
			$row_periodo = $periodo->fetchRow();
			$totalRows_periodo = $periodo->numRows();

			$ano1 = substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],0,4);
			$ano2 = substr(date("Y-m-d"),0,4);
			$mes1= substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],5,2);
			$mes2= substr(date("Y-m-d"),5,2);
			$dia1 = substr($row_periodo['fechaactualizaciondatosestudiantegeneral'],8,2);
			$dia2 = substr(date("Y-m-d"),8,2);
			$totalano = $ano2 - $ano1;
			if ($totalano > 0)
			{
				$totalano = $totalano * 360;
			}
			$totalmes = $mes2 - $mes1;
			if ($totalmes > 0)
			{
				$totalmes = $totalmes * 30;
			}
			$totaldia = $dia2 - $dia1;
			if (totaldia > 0)
			{
				$totaldia = $totaldia * 1;
			}
			$fechatotal = $totaldia + $totalmes + $totalano;

			if ($fechatotal >= 180 or $row_periodo['direccioncortaresidenciaestudiantegeneral'] == "")
			{
				$this->frameRedireccionamiento='contenidocentral';
				$this->urlRedireccionamiento="../prematricula/inscripcionestudiante/datosbasicos.php?documento=".$_SESSION['codigo']."";

			}
			else
			{
				$this->frameRedireccionamiento='contenidocentral';
				$this->urlRedireccionamiento="../facultades/creacionestudiante/estudiante.php";
			}
		}/////////////////////////////////////////////////////////////////
		else if($rol==2)
		{
			$_SESSION['nuevoMenu']=true;
			$_SESSION['rol'] = $rol;
			$query_selperiododocente = "select p.codigoperiodo, e.codigoestadoperiodo
 			from periodo p, estadoperiodo e
 			where p.codigoestadoperiodo = e.codigoestadoperiodo
 			and e.codigoestadoperiodo = '3'";
			//echo "$query_selperiododocente<br>";
			$selperiododocente = $this->conexion->query($query_selperiododocente);
			$totalRows_selperiododocente=$selperiododocente->fetchRow();
			$row_selperiododocente=$selperiododocente->fetchRow();
			if ($row_selperiododocente <> "")
			{
				$_SESSION['codigoperiodosesion'] = $row_selperiododocente['codigoperiodo'];
				$_SESSION['codigoestadoperiodosesion'] = $row_selperiododocente['codigoestadoperiodo'];
			}
			else
			{
				$_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
				$_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
			}

			$_SESSION['numerodocumento']=$row_Recordset1['numerodocumento'];
			$_SESSION['codigodocente']=$row_Recordset1['numerodocumento'];

			$this->frameRedireccionamiento='contenidocentral';
			$this->urlRedireccionamiento="central.php";

		}
		else if($rol==3)
		{
			// Pone el periodo y su estado en las variables de sesion
			$_SESSION['nuevoMenu']=true;
			$_SESSION['rol'] = $rol ;
			$_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
			$_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];
			$_SESSION['usuario']=$_SESSION['MM_Username'];
			$colname_usuario = (get_magic_quotes_gpc()) ? $this->usuario : addslashes($this->usuario);
			$query_usuario = sprintf("SELECT codigofacultad FROM usuariofacultad WHERE usuario = '%s'", $colname_usuario);
			$usuario = $this->conexion->query($query_usuario);
			$row_usuario = $usuario->fetchRow();
			$totalRows_usuario = $usuario->numRows();

			$_SESSION['codigofacultad']= $row_usuario['codigofacultad'];

			$codigofacultad=$_SESSION['codigofacultad'];

			// SELECCIONA EL PERIODO PARA LA CARRERA QUE ENTRA
			$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo
				from periodo p, carreraperiodo cp 
				where p.codigoestadoperiodo = '1' 
				and cp.codigocarrera = '$codigofacultad'
				and p.codigoperiodo = cp.codigoperiodo";					
			//echo "$query_selperiodo<br>";
			$selperiodo = $this->conexion->query($query_selperiodo);
			$totalRows_selperiodo=$selperiodo->numRows();
			if($totalRows_selperiodo == "")
			{
				$query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo
					from periodo p, carreraperiodo cp 
					where p.codigoestadoperiodo = '1' 
					and cp.codigocarrera = '$codigofacultad'
					and p.codigoperiodo = cp.codigoperiodo";					
				//echo "$query_selperiodo<br>";
				$selperiodo = $this->conexion->query($query_selperiodo);
				$totalRows_selperiodo=$selperiodo->numRows();
			}
			$row_selperiodo=$selperiodo->fetchRow();
			$_SESSION['codigoperiodosesion'] = $row_selperiodo['codigoperiodo'];
			$_SESSION['codigoestadoperiodosesion'] = $row_selperiodo['codigoestadoperiodo'];

			$colname_facultad = "0";
			if (isset($codigofacultad))
			{
				$colname_facultad = (get_magic_quotes_gpc()) ? $codigofacultad : addslashes($codigofacultad);
			}
			$query_facultad ="SELECT nombrecarrera
				FROM carrera
				WHERE codigocarrera = '$colname_facultad'";
			$facultad = $this->conexion->query($query_facultad);
			$row_facultad = $facultad->fetchRow();
			$totalRows_facultad = $facultad->numRows();

			$_SESSION['nombrefacultad']=$row_facultad['nombrecarrera'];
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			//exit();
			if ($totalRows_usuario > 1)
			{
				$query_difusuarios = "SELECT u.codigofacultad,c.nombrecarrera,c.codigocarrera
			                      FROM usuariofacultad u,carrera c
								  WHERE u.usuario = '$colname_usuario'
								  and u.codigofacultad = c.codigocarrera";
				$difusuarios = $this->conexion->query($query_difusuarios);
				$row_difusuarios = $difusuarios->fetchRow();
				$totalRows_difusuarios = $difusuarios->numRows();

				$this->frameRedireccionamiento='contenidocentral';
				$idusuario=$this->arrayDatosUsuario['idusuario'];
				$this->urlRedireccionamiento='seleccionaCarreraAjax.php?idusuario='.$idusuario;
				do{
					$this->arrayCarrerasUsuario[]=$row_difusuarios;
				}
				while ($row_difusuarios = $difusuarios->fetchRow());

			}
			else
			{
				$this->frameRedireccionamiento='contenidocentral';
				$this->urlRedireccionamiento="central.php";
			}
		}
	}
}
?>
