<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

echo "<pre>";print_r($_POST["txtIdDocente"]);

?>