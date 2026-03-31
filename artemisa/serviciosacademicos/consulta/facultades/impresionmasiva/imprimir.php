<?php 
set_time_limit(0);

$nombre_temp = tempnam("","FOO");
//echo "$nombre_temp<br>";
$archivo = fopen($nombre_temp, "r+b");
readfile($nombre_temp);

//abre un archivo y escribe en él
//$archivo = fopen("1006238.TXT", "w") or die("No se pudo abrir el archivo");
require("formateararchivo.php");	
fclose($archivo);

//echo "Archivo modificado";

//Conectamos al host
//$servidor_ftp = $_SESSION['impresorasesion'];
$servidor_ftp = $_REQUEST['naipseleccionaimpresora'];
//echo "<h5>$numeroordenpago --- $servidor_ftp</h5>";
//exit();
// Credito y cartera
//$servidor_ftp="172.16.6.147";

// Piso 11 otra
//$servidor_ftp="172.16.7.123";

// Piso 11 ini
//$servidor_ftp="172.16.7.114";
$nombre_usuario_ftp="";
$contrasenya_ftp="";
// establecer una conexion basica
$id_con = ftp_connect($servidor_ftp) or die("No se establecio una conexion basica<br>");

// inicio de sesion con nombre de usuario y contraseña
//$resultado_login = ftp_login($id_con, $nombre_usuario_ftp, $contrasenya_ftp) or die("No inicio la sesion<br>"); 
//echo "Conectado con $servidor_ftp<br>";

$archivo_fuente1="UBCOP.MCR";
$archivo_destino1="UBCOP.MCR";
$archivo_fuente2=$nombre_temp;
//$archivo_fuente2="1006238.TXT";
$archivo_destino2=$numeroordenpago.".TXT";

//$carga1 = ftp_put($id_con, $archivo_destino1, $archivo_fuente1, FTP_BINARY) or die("No pudo mandar el archivo ubcop");
//echo "Subio el archivo ubcop<br>";	
//$carga2 = ftp_put($id_con, $archivo_destino2, $archivo_fuente2, FTP_BINARY) or die("No pudo mandar el archivo $numeroordenpago.txt");
//echo "Impresión de la orden $archivo_destino2<br>$servidor_ftp";	

// Hacer esto por si al caso
/*copy($nombre_temp,"/tmp/user.txt");	
$archivo_fuente2="/tmp/user.txt";
$carga2 = ftp_put($id_con, $archivo_destino2, $archivo_fuente2, FTP_BINARY) or die("No pudo mandar el archivo $numeroordenpago.txt");
*/

ftp_close($id_con);

unlink($nombre_temp);

$query_updimpresion = "UPDATE ordenpago
SET codigocopiaordenpago = '200'
WHERE numeroordenpago = '$numeroordenpago'"; 
$updimpresion = $db->Execute($query_updimpresion);
?>
