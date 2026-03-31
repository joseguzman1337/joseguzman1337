<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_directorio = "localhost";
$database_directorio = "directorio";
$username_directorio = "root";
$password_directorio = "";
$directorio = mysql_pconnect($hostname_directorio, $username_directorio, $password_directorio) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
