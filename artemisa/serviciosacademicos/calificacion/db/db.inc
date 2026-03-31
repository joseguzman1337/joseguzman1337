<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*produccion*/
$dbconnect    = NULL;
$dbhost          = "172.16.3.208";
$dbname        = "sala";
$dbusername = "UsuAppConSal";
$dbuserpass   = "197DA72C7FEACUNB0$QU32016";
$query      = NULL;

function db_connect()
{
   global $dbconnect, $dbhost, $dbusername, $dbuserpass,$dbname;   
   if (!$dbconnect) $dbconnect = mysql_connect($dbhost, $dbusername, $dbuserpass) or trigger_error(mysql_error(),E_USER_ERROR);
   if (!$dbconnect) {
      return 0;
   } elseif (!mysql_select_db($dbname)) {
      return 0;
   } else {
      return $dbconnect;
   } // if   
} // db_connect
?>
