<?php 
// this starts the session 
 session_start(); 

function getBD() { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
   
    while (!is_file($ruta.'datos/class/Utils_datos.php'))
    {
            $ruta = $ruta."../";
    }
    
    require_once ($ruta.'datos/class/Utils_datos.php');
    
    return $db;
} 

function getBDOracle($tipoDB) { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/ConexionOracleFinanzas.php'))
    {
        $ruta = $ruta."../";
    }

    if($tipoDB==1){
    require_once($ruta.'Connections/ConexionOracleFinanzas.php');
	$Conect = new Conectar;
	$conn = $Conect->con();
	// echo '<pre>';print_r($Conect);
    return $conn;
	}
    if($tipoDB==2){
    require_once($ruta.'Connections/ConexionOracleRH.php');
	 $ConectarRh = new ConectarRh;
	 
	 $conn=$ConectarRh->con();
     echo '<br>hola template..';
     //echo '<pre>';print_r($conn);
	 
    return $conn;
	}
    if($tipoDB==3){
    require_once($ruta.'Connections/ConexionOracleFEstudiantiles.php');
	 $ConectarFE = new ConectarFE;
	 
	 $conn	= $ConectarFE->con();
	 
    return $conn; //Finanzas Estudiantiles
	}
   
} 

function getBDMoodle() { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    require_once($ruta.'Connections/moodle.php');
    require_once($ruta.'Connections/moodleNuevo.php');
    
    $ruta = "../";
    while (!is_file($ruta.'datos/class/Utils_datos.php'))
    {
            $ruta = $ruta."../";
    }
    require_once ($ruta.'datos/class/Utils_datos.php');
     
    
    return array($db,$dbMoodle, $dbMoodle2);
} 

    /**
    * Verificación de si el usuario ha iniciado sesión en el sistema de sala o no 
    * Ojo que para el redirect con header no se puede imprimir nada antes en la página
    */
    function verifySession() {        
        //var_dump($_SESSION['MM_Username']);
        if(!isLogin()){
            echo "No ha iniciado sesión en el sistema";
            exit();
        }
    }
    
    function isLogin() {        
        //var_dump($_SESSION['MM_Username']);
        if(!isset ($_SESSION['MM_Username'])){
            return false;
        } else {
            return true;
        }
    }

function writeHeader($title, $bd=false, $rutaCss="../../",$classBody="body") {
    
verifySession();

if($bd){
    $db = getBD(); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/styleDatos.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.fastLiveFilter.js"></script>     
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functionsMonitoreo.js"></script> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/plusTabs.js"></script>
        <!--<script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jshashtable-3.0.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.numberformatter-1.2.3.js"></script> --> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.maskMoney.js"></script>      

    </head>
    <body class="<?php echo $classBody; ?>">
        <div id="pageContainer">
<?php if($bd){ return $db; } }

function writeFooter() { ?>
        </div>
    </body>
</html>
<?php } ?>
