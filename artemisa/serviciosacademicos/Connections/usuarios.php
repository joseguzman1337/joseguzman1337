<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_usuarios = "localhost";
$database_usuarios = "consulta";
$username_usuarios = "consulta";
$password_usuarios = "AdminNOTASwf2004";
$usuarios = mysql_pconnect($hostname_usuarios, $username_usuarios, $password_usuarios) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
