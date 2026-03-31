<?php
class DBConnection{
       
	function getConnection(){
             global $hostname_sala, $database_sala, $username_sala, $password_sala;  
             
            $ruta = "../";
            while (!is_file($ruta.'Connections/sala2.php'))
            {
                $ruta = $ruta."../";
            }
           include($ruta.'Connections/sala2.php');
           // include('../../../../../Connections/sala2.php');
            
	  //change to your database server/user name/password
		mysql_connect($hostname_sala,$username_sala,$password_sala) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($database_sala) or 
		     die("Could not select database: " . mysql_error());
	}
}
?>