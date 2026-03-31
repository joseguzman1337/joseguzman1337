<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
//if(!ereg('zfica_plan_pago.php',$_SERVER['PHP_SELF']) and
//!ereg('seleccionar_ordenes_sap.php',$_SERVER['PHP_SELF']) and
//!ereg('aspirantes',$_SERVER['PHP_SELF']) and
//!ereg('prematricula',$_SERVER['PHP_SELF'])) {
      /*         if(!isset($_SERVER['HTTPS']) or $_SERVER['https']=='on'){
                               echo "<h1>Debe entrar con https://artemisa.unbosque.edu.co</h1>";
                               exit();
                }*/
//				}
/*$hostname_sala = "localhost";
$database_sala = "sala";
$username_sala = "consulta";
$password_sala = "AdminNOTASwf2004";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); */

$hostname_sala = "172.16.3.231";
$database_sala = "sala";
$username_sala = "desarrollo";
$password_sala = "SalaPre2013";
$sala = mysql_connect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR);

//set_time_limit(0);
//ini_set('session.gc_maxlifetime',3600);
//ini_set('session.gc_maxlifetime',3600);
?>
