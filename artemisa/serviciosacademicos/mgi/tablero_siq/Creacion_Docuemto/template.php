<?php
// this starts the session 
 session_start(); 

function writeHeader($title, $bd=false, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_monitoreo") {
    
//verifySession();

if($bd){
    $db = writeHeaderBD($nombreUtils); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title><?php echo $title; ?></title>
        <style type="text/css" title="currentStyle">
                /* todas estas son de librerias */
                @import "<?php echo $rutaCss; ?>css/cssreset-min.css";
                @import "<?php echo $rutaCss; ?>../css/demo_page.css";
                @import "<?php echo $rutaCss; ?>../css/demo_table_jui.css";
                @import "<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                /*@import "<?php echo $rutaCss; ?>../css/jquery-ui.css";*/
        </style>                
        <link rel="stylesheet" href="../../css/style.css" type="text/css" />
        <link rel="stylesheet" href="../../css/styleImagen.css" type="text/css" />
        <link rel="stylesheet" href="VisualizarGeneral.css" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script> 
         <script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>          
        <?php if($proyecto!="") { 
            $rutaCSS = $rutaCss."css/style".$proyecto.".css";
            $rutaJS = $rutaCss."js/functions".$proyecto.".js";
        ?>
        <style type="text/css" title="currentStyle">
              @import "<?php echo $rutaCSS; ?>";
        </style>   
        <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
        <?php } ?>
    </head>
    <body class="<?php echo $classBody; ?>">
        <div id="pageContainer">
<?php if($bd){ return $db; } }


function writeHeader2($title, $bd=false, $styles=true, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_monitoreo") {
    
//verifySession();

if($bd){
    $db = writeHeaderBD($nombreUtils); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title><?php echo $title; ?></title>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>  
        <script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>         
        <?php if($proyecto!="") { 
            $rutaCSS = $rutaCss."css/style".$proyecto.".css";
            $rutaJS = $rutaCss."js/functions".$proyecto.".js";
        ?>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
        <?php } ?>
    </head>
    <body class="<?php echo $classBody; ?>">
        <div id="pageContainer">
<?php if($bd){ return $db; } }


function writeFooter() { ?>
        </div>
    </body>
</html>
<?php } 

function writeHeaderBD($nombreUtils="Utils_monitoreo") { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
    if($nombreUtils=="Utils_monitoreo"){
        while (!is_file($ruta.'monitoreo/class/'.$nombreUtils.'.php'))
        {
            $ruta = $ruta."../";
        }
        require_once ($ruta.'monitoreo/class/'.$nombreUtils.'.php');
    }    
    
    $ruta = "../";
    while (!is_file($ruta.'API_Monitoreo.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'API_Monitoreo.php');
    require_once ($ruta.'API_Alertas.php');
    //var_dump($db);
    return $db;
} 

function verifySession() {     
    //verifica la sesión del usuario
    $ruta = "../";
    while (!is_file($ruta.'functionsUsersClass.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'functionsUsersClass.php');
    $functionsUsers = new functionsUsersClass();
    $functionsUsers->verifySession();
}
?>