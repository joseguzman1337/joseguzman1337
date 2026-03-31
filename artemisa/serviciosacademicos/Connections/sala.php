<?php

/*
* Andres Alberto Ariza <arizaandres@unbosque.edu.co>
* Modificado@ Junio 12 del 2018
* Se unifican las claves con el archivo de configuracion
*/
require_once(realpath ( dirname(__FILE__)."/../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();

$hostname_sala = $Configuration->getHostName();
$database_sala = $Configuration->getDbName();
$username_sala = $Configuration->getDbUserName();
$password_sala = $Configuration->getDbUserPasswd(); 

$sala = mysql_connect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR);

require_once (PATH_SITE.'/lib/Factory.php');

$MM_Username = Factory::getSessionVar('MM_Username');
$auth = Factory::getSessionVar('auth');

//d($variables);

if(!empty($MM_Username) && !empty($auth) && $auth==TRUE ){
    $curTime = mktime();
    $lastActivity = Factory::getSessionVar('lastActivity');
}
?>
