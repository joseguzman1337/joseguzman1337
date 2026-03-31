<?php 
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

			$insertSQL = "INSERT INTO preinscripcion(fechapreinscripcion,numerodocumento,tipodocumento,codigoperiodo,apellidosestudiante,nombresestudiante,direccionestudiante,ciudadestudiante,barrioestudiante,telefonoestudiante,celularestudiante,emailestudiante,institucionpreinscripcionestudiante,gradoestudiante,codigocalendarioestudiante,codigoestadopreinscripcionestudiante,idusuario,ip)";
			$insertSQL.= "VALUES( 
			'".date("Y-m-d")."',
            '".$_POST['numerodocumento']."',
            '".$_POST['tipodocumento']."',
		    '".$periodoactivo."',
 		    '".$_POST['apellido']."', 
		    '".$_POST['nombre']."',
		    '".$_POST['direccion']."',
		   '".$_POST['ciudad']."',
		   '".$_POST['barrio']."',
		   '".$_POST['telefono']."',
		   '".$_POST['celular']."',					   
		   '".$_POST['correo']."',
		   '".$_POST['colegio']."',
		   '".$_POST['grado']."',					   
		   '".$_POST['calendario']."',					      
		   '300',
		   '1',
		   '$ip')";					      
		  // echo $insertSQL,"<br>"; 
		    mysql_select_db($database_sala, $sala);
		   $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error("$insertSQL"));			

$numeroidpreinscripcionestudiante=mysql_insert_id();
for ($i = 0; $i <= $totalRows_car; $i++)
{
  if($_POST['carreraseleccionada'.$i] <> "")
     {
	   $insertSQL = "INSERT INTO preinscripcioncarrera (idpreinscripcion,codigocarrera)";
	   $insertSQL.= "VALUES( 
	   '".$numeroidpreinscripcionestudiante."',
	   '".$_POST['carreraseleccionada'.$i]."')";					   		   
	 // echo $insertSQL,"<br>"; 
	   mysql_select_db($database_sala, $sala);
	   $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
      }
}

if ($_POST['observacion'] <> "")
{
	$insertSQL = "INSERT INTO preinscripcionseguimiento(idpreinscripcion,observacionpreinscripcionseguimiento,fechapreinscripcionseguimiento,username)";
	$insertSQL.= "VALUES( 
    '".$numeroidpreinscripcionestudiante."',
    '".$_POST['observacion']."',
    '".date("Y-m-d G:i:s",time())."',
    '".$_SESSION['MM_Username']."')";					   		   
   // echo $insertSQL,"<br>"; 
	mysql_select_db($database_sala, $sala);
    $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
}
for ($i = 1; $i <= $totalRows_mediocomunicacion; $i++)
{
  if($_POST['medio'.$i] <> "")
     {
		$insertSQL = "INSERT INTO preinscripcionmediocomunicacion(idpreinscripcion,codigomediocomunicacion)";
		$insertSQL.= "VALUES( 
        '".$numeroidpreinscripcionestudiante."',
        '".$_POST['medio'.$i]."')";					   		   
	   // echo $insertSQL;
	    mysql_select_db($database_sala, $sala);
	    $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
      }
}
echo '<script language="JavaScript">alert("Sus datos se han Guardado satisfactoriamente");</script>';
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=preinscripcion.php'>";

?>