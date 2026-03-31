<?php
session_start();
foreach ($_SESSION as $llave => $valor){
	session_unregister($llave);
	unset($_SESSION[$llave]);
}
session_destroy();
?>