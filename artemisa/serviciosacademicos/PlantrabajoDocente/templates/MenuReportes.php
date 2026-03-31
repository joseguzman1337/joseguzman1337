<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
<?PHP 

$rutaCss="../";
$rutaCss_2="../";
$ruta = "../";
 
 global $db;
 
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
   
	
	#return $db;
	
	#var_dump($db);
    //echo '<pre>';print_r($db);
	
?>
        <title>Planeación de Actividades Académicas</title>
        <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:700,700italic,300,300italic,100,100italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,400,400italic' rel='stylesheet' type='text/css'>
        
		<link rel="stylesheet" href="../mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.fastLiveFilter.js"></script>   
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../mgi/js/functionsMonitoreo.js"></script> 
</head>