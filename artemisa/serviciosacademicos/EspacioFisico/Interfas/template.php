<?php  
if(session_id() == '' )
 {
// this starts the session 
 session_start(); 
  }

function getBD() { 
    $ruta = "../";
    
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
   
    //echo '<pre>';var_dump(is_file($ruta.'Connections/sala2.php'));die;
    require_once($ruta.'Connections/sala2.php');
    
    $rutaado = $ruta."funciones/adodb/";
    
    require_once($ruta.'Connections/salaado.php');
 
   // echo '<pre>';print_r($db);
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
     //echo '<br>hola template..';
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

function writeHeader($title, $bd=false, $rutaCss="../../mgi/",$classBody="body") { 
    
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
        <link rel="stylesheet" href="../css/Botones.css" type="text/css" />
        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.fastLiveFilter.js"></script>     
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functionsMonitoreo.js"></script> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/plusTabs.js"></script>
         <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.maskMoney.js"></script>      
        <style type="text/css">
          .tooltip {
            display: inline;
            position: relative;
          }
          .tooltip:hover:after {
            bottom: 26px;
            content: attr(title); /* este es el texto que será mostrado */
            left: 20%;
            position: absolute;
            z-index: 98;
            /* el formato gráfico */
            background: #9CBA7F; /* el color de fondo */
            border-radius: 5px;
            color: #FFFFFF; /* el color del texto */
            font-weight: bold;
            font-size: 14px;
            padding: 5px 15px;
            text-align: center;
            text-shadow: 1px 1px 1px #000;
            width: 250px;
          }
          .tooltip:hover:before {
            bottom: 40px;
            content: "";
            left: 50%;
            position: absolute;
            z-index: 99;
            /* el triángulo inferior */
            border: solid;
            border-color: rgba(255,255,255, 0.2) transparent;
            border-width: 6px 6px 0 6px;
          }
          .adicionarVisitantes{
            display: inline;
            position: static;
          }
          .removerVisitantes{
            display: inline;
          }
          th,td{
            border:1px solid white;
          }
        </style>
        <script type="text/javascript">
        function botonconsultar(x)
        {
            $(x).addClass('tooltip');
            $(x).css("position","flex");
            $(x).css("display","relative");
            $(x).attr('title', 'Consultar información registrada');
        }
        function guardar(x)
        {
            $(x).addClass('tooltip');
            $(x).css("position","relative");
            $(x).css("display","fixed");
            $(x).attr('title', 'Guardar información para el periodo indicado');
        }
        function verArchivos(x)
        {
            $(x).addClass('tooltip');
            $(x).css("left","57%");
            $(x).attr('title', 'Consultar archivos adjuntos para el periodo indicado');
        }
        function cargarArchivos(x)
        {
            $(x).addClass('tooltip');
            $(x).css("left","76%");
            $(x).attr('title', 'Cargar archivos de soporte a la información registrada');
        }
        function adicionarVisitantes(x)
        {
            $(x).addClass('tooltip');
            $(x).css("position","relative");
            $(x).css("display","fixed");
            $(x).attr('title', 'Agregar nueva fila');
        }
        function removerVisitantes(x)
        {
            $(x).addClass('tooltip');
            $(x).attr('title', 'Eliminar última fila');
        }
        function modulo(x)
        {
            $(x).addClass('tooltip');
            // $(x).css('position','absolute');
            $(x).attr('title', '1. Elija un módulo');
        }
        </script>

    </head>
    <body class="<?php echo $classBody; ?>">
        <div id="pageContainer">
<?php

 if($bd){ return $db; } }

function writeFooter() { ?>
        </div>
    </body>
</html>
<?php } ?>
