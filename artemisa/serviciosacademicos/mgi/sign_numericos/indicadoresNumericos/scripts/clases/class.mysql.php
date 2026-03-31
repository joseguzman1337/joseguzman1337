<?php
         
class MySQL
{
  var $conexion;

  function MySQL()
  {
      
  	if(!isset($this->conexion))
	{
             global $hostname_sala, $database_sala, $username_sala, $password_sala;  
             
            $ruta = "../";
            while (!is_file($ruta.'Connections/sala2.php'))
            {
                $ruta = $ruta."../";
            }
           include($ruta.'Connections/sala2.php');
         //include('../../../../../Connections/sala2.php');
            
	  //change to your database server/user name/password
	$this->conexion = mysql_connect($hostname_sala,$username_sala,$password_sala) or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db($database_sala) or 
		     die("Could not select database: " . mysql_error());

  	}
  }

 function consulta($consulta)
 {
	$resultado = mysql_query($consulta,$this->conexion);
  	if(!$resultado)
	{
  		echo 'MySQL Error: ' . mysql_error();
	    exit;
	}
  	return $resultado; 
  }
  
 function fetch_array($consulta)
 { 
  	return mysql_fetch_array($consulta);
 }
 
 function num_rows($consulta)
 { 
 	 return mysql_num_rows($consulta);
 }
 
 function fetch_row($consulta)
 { 
 	 return mysql_fetch_row($consulta);
 }
 function fetch_assoc($consulta)
 { 
 	 return mysql_fetch_assoc($consulta);
 } 
 
}

?>