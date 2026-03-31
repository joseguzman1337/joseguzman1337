<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
// load error handling script and the Grid class
session_start();
require_once('error_handler.php');
require_once('grid.class.php');
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");

//echo "ACTION=".$action;
//the 'action' parameter should be FEED_GRID_PAGE or UPDATE_ROW
if (!isset($_GET['action']))
{
echo 'Server error: client command missing.';
exit;
}
else
{
// store the action to be performed in the $action variable
$action = $_GET['action'];
}
// create Grid instance
if(isset($_GET['filasporpagina'])&&$_GET['filasporpagina']!='')
{
$filasxpagina=$_GET['filasporpagina'];
}
else
{
$filasxpagina=20;
}
$grid = new Grid($sala,$_GET['tabla'],$filasxpagina);
// valid action values are FEED_GRID_PAGE and UPDATE_ROW
if ($action == 'FEED_GRID_PAGE')
{
// retrieve the page number
$page = $_GET['page'];
// read the products on the page
$grid->readPage($page);
}
else if ($action == 'UPDATE')
{
// retrieve parameters
// update the record
$grid->updateRecord($_GET);
}
else if ($action == "FILTER"){

if(trim($_GET['parametros'])!=""){
 $_GET['parametros']=str_replace("like","LIKE",$_GET['parametros']);

	$parametroscoma=explode(",",$_GET['parametros']);

	$igualexiste=strpos($_GET['parametros'],"=");
	if($igualexiste!==false)
		for($i=0;$i<count($parametroscoma);$i++)
			$parametrosigual[$i]=explode("=",$parametroscoma[$i]);
	
	$likeexiste=strpos($_GET['parametros'],"LIKE");
	
	if($likeexiste !==false)
		for($i=0;$i<count($parametroscoma);$i++)
			$parametroslike[$i]=explode("LIKE",$parametroscoma[$i]);
	
	//print_r($parametroscoma);
	for($i=0;$i<count($parametroscoma);$i++){
	if($igualexiste!==false){
		if($i==0)
			$formarquery .= " ".$parametrosigual[$i][0]." = '".trim($parametrosigual[$i][1])."'";
		else
			$formarquery .= " and ".$parametrosigual[$i][0]." = '".trim($parametrosigual[$i][1])."'";
	$formarquery .= " and ".$parametroslike[$i][0]." like '%".trim($parametroslike[$i][1])."%'";
	}
	else
	$formarquery .= " ".$parametroslike[$i][0]." like '%".trim($parametroslike[$i][1])."%'";
	
	}
}
//echo $formarquery;
$grid->condicionarResultado($formarquery);


}
else if ($action == 'RESET')
{
// retrieve the page number
unset($_SESSION['condicioneducontinuada']);
unset($_SESSION['orderbygrid']);

$page = 1;
// read the products on the page
$grid->readPage($page);
}
else if($action == "SUGGEST"){
// reference the file containing the Suggest class
require_once('suggest/suggest.class.php');
// retrieve the keyword passed as parameter
$keyword = $_GET['keyword'];
$columna = $_GET['columna'];
$grid->findSuggest($sala,$keyword,$columna);
exit();
}
else if($action == "ORDER"){
$grid->orderQuery($_GET['order']);
}
else
echo 'Server error: client command unrecognized.';
	// clear the output
	if(ob_get_length()) ob_clean();
	// headers are sent to prevent browsers from caching
	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
	echo '<action>' . $action . '</action>';
if($action!='UPDATE'){
	echo $grid->getParamsXML();
	echo $grid->getGridXML();
	echo $grid->getColXML();
	echo $grid->getTableXML();
}	echo '</data>';
	//echo "SESSION<br>";
	//print_r($_SESSION);

?>