<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_estudiante = "localhost";
$database_estudiante = "consulta";
$username_estudiante = "consulta";
$password_estudiante = "AdminNOTASwf2004";
$estudiante = mysql_pconnect($hostname_estudiante, $username_estudiante, $password_estudiante) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
