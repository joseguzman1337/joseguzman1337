<?php 
session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

$base = "update preinscripcion set				 
                       numerodocumento = '".$_POST['numerodocumento']."',
                       tipodocumento='".$_POST['tipodocumento']."',
					   apellidosestudiante='".$_POST['apellido']."', 
					   nombresestudiante='".$_POST['nombre']."',
					   direccionestudiante='".$_POST['direccion']."',
					   ciudadestudiante='".$_POST['ciudad']."',
					   barrioestudiante='".$_POST['barrio']."',
					   telefonoestudiante='".$_POST['telefono']."',
					   celularestudiante='".$_POST['celular']."',					   
					   emailestudiante='".$_POST['correo']."',
					   institucionpreinscripcionestudiante='".$_POST['colegio']."',
					   gradoestudiante='".$_POST['grado']."',
					   codigocalendarioestudiante='".$_POST['calendario']."',					      
					   codigoestadopreinscripcionestudiante='".$_POST['estados']."'
					   where idpreinscripcion = '".$_SESSION['idpreinscripcionestudiante']."'";		            
					  //echo $base;
                      //exit();
					   $sol=mysql_db_query($database_sala,$base);
if ($_POST['observacion'] <> "")
{
$insertSQL = "INSERT INTO preinscripcionseguimiento(idpreinscripcion,observacionpreinscripcionseguimiento,fechapreinscripcionseguimiento,username)";
$insertSQL.= "VALUES( 
                       '".$_SESSION['idpreinscripcionestudiante']."',
                       '".$_POST['observacion']."',
					   '".date("Y-m-d G:i:s",time())."',
					   '".$_SESSION['MM_Username']."')";					   		   
			   //echo $insertSQL;
			   //exit();
			   mysql_select_db($database_sala, $sala);
			   $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
//".$_SESSION['MM_Username']."
}

echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=modificarpreinscripcion1.php'>";
///<input name="id" type="hidden" id="id" value="<?php echo $_POST['id']; ?>
?>
