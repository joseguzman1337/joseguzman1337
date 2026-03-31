<?php
/*
 *
 */

require_once "../common/includes.php";

if (!empty($logout)){
	SessionHandler::borrar_session();
	header("Location: ../main/cuerpo.php");
	return;
}

if (empty ($Login) || empty ($Password)) {
	// No tengo datos de login & password
	header("Location: login_usuario.php");
	return;
}

$usuarioEncontrado = $servicesFacade->validarUsuario($Login);

if (empty ($usuarioEncontrado)) {
	// el login  es incorrecto
	header("Location: login_usuario.php");
	return;
}

//$passwordCodificada = md5($usuarioEncontrado["Password"]);
//$nuevoString = substr($passwordCodificada, 0, strlen($passwordCodificada) - 8);
$nuevoString = $usuarioEncontrado["Password"];
if ($nuevoString != $Password) {
	//PASSWORD INCORRECTO
	header("Location: login_usuario.php");
	return;
}

//codigo nuevo
SessionHandler::guardarUsuario($usuarioEncontrado);
$rol_usuario = SessionHandler::getRolUsuario();

/*
if ($rol_usuario == ROL__ADMINISTADOR){
	header("Location: sitio_administrador.php");
}elseif ($rol_usuario == ROL__BIBLIOTECARIO){
	header("Location: sitio_bibliotecario.php");
}else{ 
	header("Location: sitio_usuario.php");
}
*/
?>
<script language="JavaScript" type="text/javascript">
	parent.frames[0].location.reload();
	<?if ($rol_usuario == ROL__ADMINISTADOR){?>
		window.location.href="sitio_administrador.php";
	<?}elseif ($rol_usuario == ROL__BIBLIOTECARIO){?>
		window.location.href="sitio_bibliotecario.php";
	<?}else{ ?>
		window.location.href="sitio_usuario.php";
	<?}	?>
</script>	