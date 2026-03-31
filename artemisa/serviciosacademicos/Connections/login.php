<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_login = "localhost";
$database_login = "consulta";
$username_login = "consulta";
$password_login = "AdminNOTASwf2004";
$login = mysql_pconnect($hostname_login, $username_login, $password_login) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
