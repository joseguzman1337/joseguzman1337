<?php
@session_start();
?>
<SCRIPT language="JavaScript">
function derecha(e) {
	if (navigator.appName == 'Netscape' && (e.which == 3 || e.which == 2)){
		alert('Botón derecho inhabilitado');
		return false;
	}

	else if (navigator.appName == 'Microsoft Internet Explorer' && (event.button == 2)){
		alert('Botón derecho inhabilitado');
	}
}
document.onmousedown=derecha;
document.oncontextmenu=new Function("return false");
</SCRIPT>
<?php 
if(empty($_SESSION['MM_Username']) or $_SESSION['auth']<>true or empty($_SESSION['rol'])){
	foreach ($_SESSION as $llave => $valor){
		unset($_SESSION[$llave]);
		session_unregister($_SESSION[$llave]);
	}
	session_destroy();
	?>
	<script language="javascript">parent.document.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm'</script>
<?php 
exit();
}
?>
