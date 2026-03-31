<?php
/*
 * se cambia location:intermedio.php por location:sintermedio.php (redireccionamiento).
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 23 de Enero de 2018.
 */
session_start();
foreach ($_SESSION as $llave => $valor){ 
	//session_unregister($llave);
	unset($_SESSION[$llave]);
}
session_unset();

session_destroy();

header ('Cache-Control: no-cache, no-store, must-revalidate');
header ('Pragma: no-cache');
header ("location:sintermedio.php"); 
exit();
//end     
?>
