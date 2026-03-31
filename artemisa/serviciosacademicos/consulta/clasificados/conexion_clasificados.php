<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_clasificados = "localhost";
$database_clasificados = "clasificados";
$username_clasificados = "root";
$password_clasificados = "";
$clasificados = mysql_pconnect($hostname_clasificados, $username_clasificados, $password_clasificados) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
