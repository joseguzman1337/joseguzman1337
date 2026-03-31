<?php
function writeHeader($title, $bd=false, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_numericos") {
    
verifySession();

if($bd){
    $db = writeHeaderBD($nombreUtils); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <style type="text/css" title="currentStyle">
                @import "<?php echo $rutaCss; ?>css/cssreset-min.css";
                @import "<?php echo $rutaCss; ?>../css/demo_page.css";
                @import "<?php echo $rutaCss; ?>../css/demo_table_jui.css";
                @import "<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>          
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

function writeFooter() { ?>
        </div>
    </body>
</html>
<?php } 

function writeStatus($status) { 
    if($status==100){
        echo "Activo";
    } else{
        echo "Inactivo";
    }
}

function writeYesNoSelect($name,$selected,$class="") { ?>
    <select class="grid-auto required <?php echo $class; ?>" id="<?php echo $name ?>" size="1" name="<?php echo $name ?>">
    <option value="1" <?php if($selected==0){ ?>selected<?php } ?>>Si</option>
    <option value="0" <?php if($selected==0){ ?>selected<?php } ?>>No</option>
    </select>
<?php }

function writeYesNoStatus($status) { 
    if($status==0){
        echo "No";
    } else{
        echo "Si";
    }
}

function writeHeaderBD($nombreUtils="Utils_numericos") { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
    if($nombreUtils=="Utils_numericos"){
        while (!is_file($ruta.'sign_numericos/class/'.$nombreUtils.'.php'))
        {
            $ruta = $ruta."../";
        }
        require_once ($ruta.'sign_numericos/class/'.$nombreUtils.'.php');
    }    
    /*else if($nombreUtils=="Utils_numericos"){
        while (!is_file($ruta.'sign_numericos/class/'.$nombreUtils.'.php'))
        {
            $ruta = $ruta."../";
        }
        require_once ($ruta.'sign_numericos/class/'.$nombreUtils.'.php');
    }*/
    
    $ruta = "../";
    while (!is_file($ruta.'API_Monitoreo.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'API_Monitoreo.php');
    
    return $db;
}

function writeHeaderSearchs() {     
    return writeHeaderBD();
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

function writeHeaderCalendar($title) {
    
verifySession();

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>                
        <link href="../../../css/cssreset-min.css" rel="stylesheet" type="text/css" />
        <link href="../../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
        
        <link href="css/dailog.css" rel="stylesheet" type="text/css" />
        <link href="css/calendar.css" rel="stylesheet" type="text/css" /> 
        <link href="css/dp.css" rel="stylesheet" type="text/css" />   
        <link href="css/alert.css" rel="stylesheet" type="text/css" /> 
        <link href="css/main.css" rel="stylesheet" type="text/css" /> 
        <link href="css/dropdown.css" rel="stylesheet" />    
        <link href="css/colorselect.css" rel="stylesheet" />   


        <script src="src/jquery.js" type="text/javascript"></script>  
        <script type="text/javascript" language="javascript" src="../../../js/jquery-ui-1.8.21.custom.min.js"></script> 
        <script src="src/Plugins/Common.js" type="text/javascript"></script>    
        <script src="src/Plugins/jquery.form.js" type="text/javascript"></script>     
        <script src="src/Plugins/jquery.validate.js" type="text/javascript"></script>  
        <script src="src/Plugins/datepicker_lang_ES.js" type="text/javascript"></script>     
        <script src="src/Plugins/jquery.datepicker.js" type="text/javascript"></script>
           
        <script src="src/Plugins/jquery.dropdown.js" type="text/javascript"></script>     
        <script src="src/Plugins/jquery.colorselect.js" type="text/javascript"></script> 

        <script src="src/Plugins/jquery.alert.js" type="text/javascript"></script>    
        <script src="src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
        <script src="src/Plugins/wdCalendar_lang_ES.js" type="text/javascript"></script>    
        <script src="src/Plugins/jquery.calendar.js" type="text/javascript"></script>          
    </head>
    <body>
<?php } ?>