<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

/*
 ****
 ****En el servidor de desarrollo  en la ruta /usr/local/freetds/etc/freetds.conf   se debe parametrizar el acceso a la base de SQLSERVER.
 ****Se debe definir un nombre de conexion para este caso "Molinetes", digitar la definir el host= IP del servidor, el puerto para este caso es =49158
 ****Ya q en ka parametrizacion del serividor SQL ellos definieron ese puerto.
 ****Por ultimo se define el tds version = las versiones que trabajan con el freeTDS  son varias para SQLSERVER2005 que es la utiolizada en los molinetes
 ****Se utiliza una version 7.0
 ****
 */
/*
 * @modified Andres Ariza <arizaancres@unbosque.edu.co>
 * Se unifica la declaracion de las rutas HTTP_ROOT Y PATH_ROOT con el archivo de configuracion general
 * @since  Junio 29 2018
*/
require_once(realpath( dirname(__FILE__)."/../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();

$hostname_sql = $Configuration->getHostNameAndover();
$database_sql = $Configuration->getDbNameAndover();
$username_sql = $Configuration->getDbUserNameAndover();
$password_sql = $Configuration->getDbUserPasswdAndover();

require_once(PATH_SITE.'/lib/Factory.php');
Factory::importGeneralLibraries();
/* Fin Modificacion */

$sql_conecction = mssql_connect($hostname_sql,$username_sql,$password_sql);
if(!$sql_conecction){
	die("cero conexion");
}

$dbAndover = Factory::createDbo("andover");

/* conexion con PHP $sql_conecction = mssql_connect($hostname_sql,$username_sql,$password_sql);
Ruta para probar de frente la conexion  $rutaado = "../funciones/adodb/";*/
?>
