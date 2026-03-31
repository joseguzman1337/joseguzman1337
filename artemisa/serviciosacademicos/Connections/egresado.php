<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion = "200.31.79.227";
$database_conexion = "egresados";
$username_conexion = "root";
$password_conexion = "AdminARTEMISAwf2004";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>