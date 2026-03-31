<?PHP 
$rutaCss="../../";
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
	
?>
         
      
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/jquery-ui-1.8.21.custom.min.js"></script>  
        
        <link rel="stylesheet" href="../../serviciosacademicos/mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="../../serviciosacademicos/css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../../serviciosacademicos/css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="../../serviciosacademicos/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../serviciosacademicos/mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../../serviciosacademicos/mgi/css/styleDatos.css" type="text/css" /> 
        
       
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/jquery.fastLiveFilter.js"></script>     
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/functionsMonitoreo.js"></script> 
         <script type="text/javascript" language="javascript" src="../../serviciosacademicos/mgi/js/plusTabs.js"></script> 
  