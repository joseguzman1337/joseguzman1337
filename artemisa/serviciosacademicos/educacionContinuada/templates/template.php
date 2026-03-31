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
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "";
    while (!is_file($ruta.'class/Utils.php'))
    {
            $ruta = $ruta."../";
    }
    require_once($ruta.'class/Utils.php');
     
    
    return $db;
} 

function initializeCertificados() { 
    $ruta = "";
    while (!is_file($ruta.'class/Utils_Certificados.php'))
    {
            $ruta = $ruta."../";
    }
    require_once ($ruta.'class/Utils_Certificados.php');
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

function writeHeader($title, $bd=false, $rutaCss="../",$classBody="body") {
    
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
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/normalize.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/style.css" type="text/css"  media="screen, projection" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/stylePrint.css" type="text/css" media="print" /> 
        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>../mgi/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>../mgi/js/jquery.fastLiveFilter.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>  
    </head>
    <body class="<?php echo $classBody; ?>">
        <div id="pageContainer">
<?php if($bd){ return $db; } }

function writeFooter() { ?>
        </div>
    </body>
</html>
<?php } ?>
