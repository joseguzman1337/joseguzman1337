<?php
// reference the file containing the Suggest class
//require_once('suggest.class.php');
// create a new Suggest instance
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
//require_once('error_handler.php');
//require_once('config.php');

require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

require_once("suggest.class.php");
	session_start();


	$nombrecampo=$_GET['nombrecampo'];
	$tablas=$_SESSION[$nombrecampo.'tablas'];
	$campollave=$_SESSION[$nombrecampo.'campollave'];
	$camponombre=$_SESSION[$nombrecampo.'camponombre'];
	$condicion=$_SESSION[$nombrecampo.'condicion'];

//echo "$nombrecampo";
$suggest = new Suggest($sala,$tablas,$campollave,$camponombre,$condicion);
// retrieve the keyword passed as parameter
$keyword = $_GET['keyword'];
// clear the output
if(ob_get_length()) ob_clean();
// headers are sent to prevent browsers from caching
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');
// send the results to the client
echo $suggest->getSuggestions($keyword);
?>