<?php
session_start();
require_once(dirname(__FILE__).'/../../Connections/sala2.php');
$rutaado = dirname(__FILE__)."/../../funciones/adodb/";
require_once(dirname(__FILE__).'/../../Connections/salaado.php');
//error_reporting (E_ALL); 
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);


// *************************************************************************************************
// *********************** FUNCIONES NECESARIAS PARA LA CREACIÓN DEL USUARIO ***********************
function validacionCamposUsuarioDocEstAdm($vlr,$nom,$tip) {
	$retorno=true;
	if($tip=='email' && !filter_var($vlr,FILTER_VALIDATE_EMAIL)) {
		echo "<b><font color='orange'>ADVERTENCIA:</font></b> El campo <b>$nom</b> debe ser una dirección de correo válida.<br>";
		$retorno=false;
	}
	if($tip=='int' && !filter_var($vlr,FILTER_VALIDATE_INT)) {
		echo "<b><font color='orange'>ADVERTENCIA:</font></b> El campo <b>$nom</b> debe ser un entero sin caracteres especiales ni espacios en blanco.<br>";
		$retorno=false;
	}
	if($tip=='select' && ($vlr==0 || trim($vlr)=='')) {
		echo "<b><font color='orange'>ADVERTENCIA:</font></b> Seleccione o verifique el <b>$nom</b>.<br>";
		$retorno=false;
	}
	if($tip=='text' && trim($vlr)=='') {
		echo "<b><font color='orange'>ADVERTENCIA:</font></b> El campo <b>$nom</b> no puede estar vacio.<br>";
		$retorno=false;
	}
	if($tip=='boolean' && ($vlr!='0' && $vlr!='1') ) {
		echo "<b><font color='orange'>ADVERTENCIA:</font></b> Los valores permitidos para el campo <b>$nom</b> son 0 y 1.<br>";
		$retorno=false;
	}
	return $retorno;
}
function validacionExisteUsuarioDocEstAdm($nombres,$apellidos,$numerodocumento,$espracticante,$db) {
	$query="select * from usuario where numerodocumento='".$numerodocumento."' and codigotipousuario in (500,503)";
	$row=$db->Execute($query);
	$cont=$row->RecordCount();
	if($cont>0) {
		$reg=$row->FetchRow();
		echo "<b><font color='red'>ERROR:</font></b> El docente <b>$apellidos $nombres</b> ya tiene una cuenta creada. El usuario que le fué asignado es <b>".$reg['usuario']."</b>.<br>";
		return false;
	} else {
		if($espracticante==0) {
			$query2="select * from docente where numerodocumento='".$numerodocumento."'";
			$row2=$db->Execute($query2);
			$cont2=$row2->RecordCount();
			if($cont2==0) {
				echo "<b><font color='red'>ERROR:</font></b> El docente <b>$apellidos $nombres</b> con número de documento <b>$numerodocumento</b> no tiene curso o grupo asignado. Debe acercarse a la facultad para que le realicen este proceso.<br>";
				return false;
			} else 
				return true;
		} else
			return true;
	}
}
function construccionCorreoUsuarioDocEstAdm($usuario,$apellidos,$nombres,$clave,$email) {
	require_once(dirname(__FILE__)."/../../funciones/clases/phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->SetLanguage("es", dirname(__FILE__).'/../../funciones/clases/phpmailer/language/');
	$mail->From = "mesadeservicio@unbosque.edu.co";
	$mail->FromName = "MESA DE SERVICIO UNIVERSIDAD EL BOSQUE";
	$mail->ContentType = "text/html";
	$mail->Subject = "USUARIO CUENTA CORREO INSTITUCIONAL";
	$cuerpo="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><BR><BR>".
		"La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.".
		"Puede ingresar a la página www.unbosque.edu.co por la opción <b>SERVICIOS EN LÍNEA</b>.<br><br>".
		"<b>usuario:\t".$usuario."</b><br><b>clave:\t".$clave."</b>";
	$mail->Body = $cuerpo;
	$mail->AddAddress($email,$apellidos." ".$nombres);
	//$mail->AddAddress("bonillaleyla@unbosque.edu.co",$apellidos." ".$nombres);
	if($mail->Send())
		echo "<b><font color='green'>CORRECTO:</font></b> Se envío email de notificación de creación de cuenta al correo <b>".$email."</b>.<br>";
	else 
		echo "<b><font color='red'>ERROR:</font></b> No se pudo enviar email de notificación de creación de cuenta al correo <b>".$email."</b>. Motivo: ".$mail->ErrorInfo.".<br>";
}
function nombreDefectoUsuarioDocEstAdm($nombre1,$nombre2,$apellido1,$apellido2,$semilla) {
	$largonombre=strlen($nombre1.$nombre2.$apellido1.$apellido2);
	$largonombre1=strlen($nombre1);
	$largonombre2=strlen($nombre2);
	$largoapellido2=strlen($apellido2);
	$campo1="";$campo2="";$campo3="";
	for($i=0;$i<($semilla);$i++)
		$campo1.=$nombre1[$i];
	for($i=0;$i<($semilla-$largonombre1);$i++)
		$campo2.=$nombre2[$i];
	for($i=0;$i<($semilla-($largonombre1+$largonombre2));$i++)
		$campo4.=$apellido2[$i];
	$largogenerado=strlen($campo1.$campo2.$apellido1.$campo4);
	if($largonombre<=$largogenerado)
		return false;
	else
		return $campo1.$campo2.$apellido1.$campo4;
} // cierra función
function creacionSALAUsuarioDocEstAdm($tipodocumento,$nombres,$apellidos,$numerodocumento,$usuario,$espracticante,$db) {
	require_once(dirname(__FILE__).'/../../Connections/sala2.php');
	$rutaado = dirname(__FILE__)."/../../funciones/adodb/";
	require_once(dirname(__FILE__).'/../../Connections/salaado.php');
	//$codtipousuario=($espracticante==0 || $espracticante==99)?"500":"503";
	$codtipousuario="500";
	$query="insert into usuario 
			(usuario
			,numerodocumento
			,tipodocumento
			,apellidos
			,nombres
			,codigousuario
			,semestre
			,codigorol
			,fechainiciousuario
			,fechavencimientousuario
			,fecharegistrousuario
			,codigotipousuario
			,idusuariopadre
			,codigoestadousuario
			,ipaccesousuario) 
		values ( '".$usuario."'
			,'".$numerodocumento."'
			,".$tipodocumento."
			,'".$apellidos."'
			,'".$nombres."'
			,'".$numerodocumento."'
			,'1'
			,2
			,'".date("Y-m-d H:i:s")."'
			,'2999-12-31'
			,'".date("Y-m-d H:i:s")."'
			,'".$codtipousuario."'
			,0
			,'100'
			,'0')";	
	$db->Execute($query);	
	$query="insert into permisousuariomenuopcion (idpermisomenuopcion,idusuario,codigoestado) values (251,".mysql_insert_id().",'100')";
	$db->Execute($query);
	echo "<b><font color='green'>CORRECTO:</font></b> El usuario fué creado en <b>SALA</b><br>...Continua con el envío de notificación al correo alterno.<br>";
	
	$query="INSERT INTO `docente` (`codigodocente`, `apellidodocente`, `nombredocente`, `tipodocumento`, `numerodocumento`, 
	`clavedocente`, `emaildocente`, `codigogenero`, `fechanacimientodocente`) 
	VALUES ('".$numerodocumento."', '".$apellidos."', '".$nombres."', '".$tipodocumento."', '".$numerodocumento."', '0', '".$usuario."@unbosque.edu.co', '100', '0000-00-00')";
	
	$db->Execute($query);
}
function creacionLDAPUsuarioDocEstAdm($usuario,$datos) {
	$dnpadre="ou=docentes,dc=unbosque,dc=edu,dc=co";
	$info["cn"]=$usuario;
	$info["uid"]=$usuario;
	$info["givenName"]=$datos[0]." ".$datos[1];
	$info["sn"]=$datos[2]." ".$datos[3];
	$info["mail"]=trim($usuario)."@unbosque.edu.co";
	$info["gidNumber"]=14969;
	$info["homeDirectory"]="/home/".$usuario;
	$info['objectclass'][0] = "inetOrgPerson";
	$info['objectclass'][1] = "posixAccount";
	$info['objectclass'][2] = "googleUser";
	$info['objectclass'][3] = "top";
	$info['objectclass'][4] = "shadowAccount";
	$info["uidNumber"]=14965;
	$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($datos[4])));
	$info["gacctFirstAccess"]="N";
	$info["gacctMail"]=trim($usuario)."@unbosque.edu.co";
	$info["gacctVerified"]="Y";
	require_once(dirname(__FILE__)."/../../Connections/conexionldap.php");
	$conexion=ldap_connect(SERVIDORLDAP,PUERTOLDAP);
	@ldap_set_option($conexion,LDAP_OPT_PROTOCOL_VERSION,3);
	@ldap_set_option($conexion,LDAP_OPT_REFERRALS,0);
	if(!($resultado=@ldap_bind($conexion,CADENAADMINLDAP,CLAVELDAP))){
		echo "ERROR DE CONEXION, COMPRUEBE LA CONEXION AL SERVIDOR LDAP ".$conexion.",".CADENAADMINLDAP."<br>";
		$resultado=@ldap_bind($conexion);
	} 
	$sr=ldap_search($conexion,"dc=unbosque,dc=edu,dc=co","uid=".$usuario);
	if(ldap_count_entries($conexion,$sr)==0) {
		$respuesta=ldap_add($conexion,"cn=".$usuario.",".$dnpadre,$info);
		ldap_close($conexion);
		if(!$respuesta)
			return false;
		else
			return true;
	} else
		return false;
} // cierra función
function creacionGoogleUsuarioDocEstAdm($tipodocumento,$nuevousuario,$apellidos,$nombres,$clave,$email,$numerodocumento,$espracticante,$db) {
	require_once(dirname(__FILE__)."/../../../interfacegoogle/crearusuariogoogle.php");
		
	crearUsuarioGoogle($nuevousuario,$apellidos,$nombres,$clave);
		
} // cierra función
function generacionUsuarioDocEstAdm($tipodocumento,$numerodocumento,$nombres,$apellidos,$email,$espracticante,$db) {
	require_once(dirname(__FILE__)."/../../funciones/funcionpassword.php");
	require_once(dirname(__FILE__)."/../../funciones/sala_genericas/FuncionesCadena.php");
	$nombres=quitartilde($nombres);
	$apellidos=quitartilde($apellidos);
	$apellidos=str_replace(" DEL "," ",$apellidos);
	$cuentapalabrasapellidos=cuentapalabras(trim($apellidos));
	$apellido1=trim(sacarpalabras(trim($apellidos),0,$cuentapalabrasapellidos-2));
	$apellido2=trim(sacarpalabras(trim($apellidos),$cuentapalabrasapellidos-1,$cuentapalabrasapellidos));
	$cuentapalabrasapellido1=cuentapalabras(trim($apellido1));
	if($cuentapalabrasapellido1>1)
		$apellido1=sacarpalabras(trim($apellido1),$cuentapalabrasapellido1-1,$cuentapalabrasapellido1);
	$nombre1=trim(sacarpalabras($nombres,0,0));
	$nombre2=trim(sacarpalabras($nombres,1));
	$clave=generar_pass(8);
	$nombre1=str_replace(" ","",$nombre1);
	$nombre2=str_replace(" ","",$nombre2);
	$apellido1=str_replace(" ","",$apellido1);
	$apellido2=str_replace(" ","",$apellido2);
	$datos=array($nombre1,$nombre2,$apellido1,$apellido2,$clave);
	$i=0;
	$retorno=false;
	$siguecreacionusuariogoogle=true;
	while($retorno==false) {
		$i++;
		switch($i) {
			case 1:
				$nuevousuario=strtolower($nombre1[0].$apellido1);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 2:
				$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 3:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 4:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$apellido1.$apellido2[0]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 5:
				$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 6:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 7:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 8:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$apellido1.$apellido2[0].$apellido2[1]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 9:
				$nuevousuario=strtolower($nombre1[0].$apellido1.$apellido2[0].$apellido2[1].$apellido2[2]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 10:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			case 11:
				$nuevousuario=strtolower($nombre1[0].$nombre2[0].$nombre2[1].$nombre2[2].$apellido1.$apellido2[0]);
				$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				break;
			default:
				if($nuevousuario= strtolower(nombreDefectoUsuarioDocEstAdm($nombre1,$nombre2,$apellido1,$apellido2,($i-10))))
					$retorno=creacionLDAPUsuarioDocEstAdm($nuevousuario,$datos);
				else {
					$retorno=true;
					$siguecreacionusuariogoogle=false;
				}	
				break;
		} // cierra switch
		if(!$retorno && $siguecreacionusuariogoogle)
			echo "<b><font color='orange'>ADVERTENCIA:</font></b> Intento fallido nro $i al crear el usuario <b>".$nuevousuario."</b> en <b>LDAP</b>, intentando nuevamente.<br>";
		if($retorno && !$siguecreacionusuariogoogle)
			echo "<b><font color='red'>ERROR:</font></b> Todas las combinaciones posibles encontradas. No se pudo generar el usuario en <b>LDAP</b>, contáctese con el área de tecnología.<br>";
		if($retorno && $siguecreacionusuariogoogle)
			echo "<b><font color='green'>CORRECTO:</font></b> El usuario <b>".$nuevousuario."</b> ha sido creado en <b>LDAP</b> con la clave <b>".$clave."</b>.<br>...Continua con la creación en GOOGLE APPS.<br>";
	} // cierra while
	
	
	if($retorno && $siguecreacionusuariogoogle) {
		creacionGoogleUsuarioDocEstAdm($tipodocumento,$nuevousuario,$apellido1." ".$apellido2,$nombre1." ".$nombre2,$clave,$email,$numerodocumento,$espracticante,$db);
		creacionSALAUsuarioDocEstAdm($tipodocumento,$nombre1." ".$nombre2,$apellido1." ".$apellido2,$numerodocumento,$nuevousuario,$espracticante,$db); 
		construccionCorreoUsuarioDocEstAdm($nuevousuario,$apellido1." ".$apellido2,$nombre1." ".$nombre2,$clave,$email);
	}
} // cierra funcion
// *************************************************************************************************
// *************************************************************************************************
?>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<form name="form1" id="form1" action="" method="POST" enctype="multipart/form-data" novalidate>
<?php
	if(!isset($creaciondesdetalentohumano)) {
?>
		<script language="javascript"> 
			function habilitar_deshabilitar(val) {
				if(val==1) {
					document.getElementById('tbl1').style.display="";
					document.getElementById('tbl2').style.display="none";
				} else {
					document.getElementById('tbl1').style.display="none";
					document.getElementById('tbl2').style.display="";
				}
			}
		</script>
		<br>
		<table align="center" border="0" width="40%" cellpadding="5">
			<tr id="trtitulogris">
				<td align="center" colspan="3"><label id="labelresaltadogrande">CREACION DE USUARIOS (LDAP Y GOOGLE APPS)</label></td>
			</tr>
			<tr>
				<td width="10%" align="center" id="tdtitulonegrilla">Tipo de usuario</td>
				<td width="10%" align="center">
					<select name="tipo_usuario" required>
						<option value="0">Seleccione..</option>
						<option value="1" <?php if($_REQUEST["tipo_usuario"]==1){ echo "selected"; } ?>>Docente</option>
						<option value="2" <?php if($_REQUEST["tipo_usuario"]==2){ echo "selected"; } ?> disabled>Administrativo</option>
						<option value="3" <?php if($_REQUEST["tipo_usuario"]==3){ echo "selected"; } ?> disabled>Estudiante</option>
					</select>
				</td>	
				<td width="10%" align="center"><input type="submit" value="Continuar" name="accion"></td>
			</tr>
		</table>
<?php
	}
	if($_REQUEST["accion"]=="Continuar" || $_REQUEST["accion"]=="Crear") {
		if(!isset($creaciondesdetalentohumano)) {
			if(!validacionCamposUsuarioDocEstAdm($_REQUEST['tipo_usuario'],'Tipo de usuario','select'))
				exit;	
			$display_tbl1="none";
			$display_tbl2="none";
			if($_REQUEST["tipo_creacion"]==1)
				$display_tbl1="";
			if($_REQUEST["tipo_creacion"]==2)
				$display_tbl2="";
?>		
			<br>
			<table align="center" border="0" width="40%" cellpadding="5">
				<tr id="trtituloverde">
					<th width="15%"><input type="radio" name="tipo_creacion" value=1 <?php if($_REQUEST["tipo_creacion"]==1){ echo "checked"; }?> OnClick="habilitar_deshabilitar(this.value)"> <label id="labelgrande">Crear un usuario</label></th>
					<th width="15%"><input type="radio" name="tipo_creacion" value=2 <?php if($_REQUEST["tipo_creacion"]==2){ echo "checked"; }?> OnClick="habilitar_deshabilitar(this.value)"> <label id="labelgrande">Crear varios usuarios</label></th>
				</tr>
			</table>
			<br>
			<table align="center" border="0" width="40%" id="tbl1" style="display:<?php echo $display_tbl1?>" cellpadding="5">
				<tr>
					<td><b>Tipo de documento <font color="red">(*)</font></b></td>
					<td>
						<select name="tipodocumento">
<?php
							$query="select * from documento";
							$row=$db->Execute($query);
							while($reg=$row->FetchRow()) {
								$selected=($_REQUEST['tipodocumento']==$reg['tipodocumento'])?"selected":"";
								echo "<option value='".$reg['tipodocumento']."' ".$selected.">".$reg['nombredocumento']."</option>";
							}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td><b>Número de documento <font color="red">(*)</font></b></td>
					<td><input type="number" name="numerodocumento" value="<?php echo $_REQUEST["numerodocumento"]?>" size="10" maxlength="10" required></td>
				</tr>
				<tr>
					<td><b>Apellidos <font color="red">(*)</font></b></td>
					<td><input type="text" name="apellidos" value="<?php echo $_REQUEST["apellidos"]?>" size="20" required></td>
				</tr>
				<tr>
					<td><b>Nombres <font color="red">(*)</font></b></td>
					<td><input type="text" name="nombres" value="<?php echo $_REQUEST["nombres"]?>" size="20" required></td>
				</tr>
				<tr>
					<td><b>Dirección de correo alternativo <font color="red">(*)</font></b></td>
					<td><input type="email" name="email" value="<?php echo $_REQUEST["email"]?>" size="30" required></td>
				</tr>
				<tr>
					<td><b>Es docente practicante ? <font color="red">(*)</font></b></td>
					<td><input type="checkbox" name="espracticante" value="1" <?php if($_REQUEST["espracticante"]){ echo "checked";} ?>></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="accion" value="Crear"></th>
				</tr>
			</table>
			<br>
			<table align="center" border="0" width="40%" id="tbl2" style="display:<?=$display_tbl2?>" cellpadding="5">
				<tr>
					<th>Seleccionar archivo <font color="red">(*)</font></th>
					<th><input type="file" name="archivo"></th>
				</tr>
				<tr>
					<th colspan="2"><label id="labelpequeno">Para ver el archivo de ejemplo haga clic <a href="modelo.xls">Aquí</label></a></th>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="accion" value="Crear"></th>
				</tr>
			</table>
<?php
		}
	} // cierra accion "continuar"
	if($_REQUEST["accion"]=="Crear") {

		if($_REQUEST['tipo_creacion']==1) {
			echo "<br><br>*** GENERANDO USUARIO PARA <b>".$_REQUEST['apellidos']." ".$_REQUEST['nombres']."</b> con número de documento <b>".$_REQUEST['numerodocumento']."</b>. ***<br>";
			$tipodocumentocrear=validacionCamposUsuarioDocEstAdm($_REQUEST['tipodocumento'],'Tipo de documento','select'); 
			$documentocrear=validacionCamposUsuarioDocEstAdm($_REQUEST['numerodocumento'],'Número de documento','int'); 
			$apellidoscrear=validacionCamposUsuarioDocEstAdm($_REQUEST['apellidos'],'Apellidos','text'); 
			$nombrescrear=validacionCamposUsuarioDocEstAdm($_REQUEST['nombres'],'Nombres','text'); 
			$emailcrear=validacionCamposUsuarioDocEstAdm($_REQUEST['email'],'Dirección de correo alternativo','email'); 
			if($tipodocumentocrear && $documentocrear && $apellidoscrear && $nombrescrear && $emailcrear) {
				if(validacionExisteUsuarioDocEstAdm(trim($_REQUEST['nombres']),trim($_REQUEST['apellidos']),trim($_REQUEST['numerodocumento']),trim($_REQUEST['espracticante']),$db))
					generacionUsuarioDocEstAdm(trim($_REQUEST['tipodocumento']),trim($_REQUEST['numerodocumento']),trim($_REQUEST['nombres']),trim($_REQUEST['apellidos']),trim($_REQUEST['email']),trim($_REQUEST['espracticante']),$db);
			}
		} else {
			$nombre_archivo = explode(".",$_FILES['archivo']['name']);
			$tipo_archivo = $_FILES['archivo']['type'];
			$tamano_archivo = $_FILES['archivo']['size'];
			$fechahora=date("Ymd_His");
			if($nombre_archivo[1]!="xls") {
				echo "<b><font color='red'>ERROR:</font></b> El archivo debe ser <b>Excel</b> y con extensión <b>xls</b>.<br>";
				exit;
			}
			if($tamano_archivo > 2000000) {
				echo "<b><font color='red'>ERROR:</font></b> El archivo es demasiado grande, debe tener un máximo de <b>2Mb</b>.<br>";
				exit;
			}
			if(!copy($_FILES['archivo']['tmp_name'], "archivos_cargados/".$nombre_archivo[0]."_".$fechahora.".".$nombre_archivo[1])) {
				echo "<b><font color='red'>ERROR:</font></b> El archivo no pudo ser procesado, contáctese con el área de tecnología.<br>";
				exit;
			} else {	
				require_once(dirname(__FILE__)."/../../funciones/sala_genericas/Excel/reader.php");
				$dataexcel = new Spreadsheet_Excel_Reader();
				$dataexcel->setOutputEncoding('CP1251');
				$dataexcel->read("archivos_cargados/".$nombre_archivo[0]."_".$fechahora.".".$nombre_archivo[1]);
				for($i=1; $i<=$dataexcel->sheets[0]['numRows']; $i++) {
					echo "<br><br>*** GENERANDO USUARIO PARA <b>".$dataexcel->sheets[0]['cells'][$i][3]." ".$dataexcel->sheets[0]['cells'][$i][4]."</b> con número de documento <b>".$dataexcel->sheets[0]['cells'][$i][2]."</b>. ***<br>";
					$tipodocumentocrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][1]),'Tipo de documento','select'); 
					$documentocrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][2]),'Número de documento','int'); 
					$apellidoscrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][3]),'Apellidos','text'); 
					$nombrescrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][4]),'Nombres','text'); 
					$emailcrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][5]),'Dirección de correo alternativo','email'); 
					$espracticantecrear=validacionCamposUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][6]),'Es docente practicante','boolean'); 
					if($tipodocumentocrear && $documentocrear && $apellidoscrear && $nombrescrear && $emailcrear && $espracticantecrear) {
						if(validacionExisteUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][4]),trim($dataexcel->sheets[0]['cells'][$i][3]),trim($dataexcel->sheets[0]['cells'][$i][2]),trim($dataexcel->sheets[0]['cells'][$i][6]),$db))
							generacionUsuarioDocEstAdm(trim($dataexcel->sheets[0]['cells'][$i][1]),trim($dataexcel->sheets[0]['cells'][$i][2]),trim($dataexcel->sheets[0]['cells'][$i][4]),trim($dataexcel->sheets[0]['cells'][$i][3]),trim($dataexcel->sheets[0]['cells'][$i][5]),trim($dataexcel->sheets[0]['cells'][$i][6]),$db);
					}
				}
			}
		}
	} // cierra accion "crear"
?>
</form>
