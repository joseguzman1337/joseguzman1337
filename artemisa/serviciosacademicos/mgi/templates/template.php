<?php
/*
 * @modified Andres Ariza <arizaancres@unbosque.edu.co>
 * Se unifica la declaracion del archivo de configuracion general para validacion de sesion
 * y para unificar la instanciacion de Base de datos y se unifican las claves con el archivo de configuracion
 * @since  Agosto 9 2018
*/
require_once(realpath(dirname(__FILE__)."/../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    require_once (PATH_ROOT.'/kint/Kint.class.php');
}

require_once (PATH_SITE.'/lib/Factory.php');
Factory::importGeneralLibraries();
$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        //d($key_post);
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}

/*
    * Caso  104113
    * Luis Dario Gualteros <castroluisd@unbosque.edu.co>
    *  Agosto 27de 2018
    *  Se comenta la linea de validacion de sesion ya que hay archivos publicos y se ven afectados
    * Ejemplo plan de actividades docente y prueba de intereses.
 */

//Factory::validateSession($variables);

//End Caso  104113
/*
 *  Ivan Dario quintero Rios
 *  junio 15 del 2018
 *  ajuste para google analitys
 */

    function writeHeader($title, $bd=false, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_monitoreo",$Seccion=false,$Apis=true){
        if($Seccion==true){   
            verifySession();
	}
	
	if($bd && $Apis){
            $db = writeHeaderBD($nombreUtils);
		 
	}else if($bd){
            $db = writeHeaderBD($nombreUtils,false);
	}
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
                <title><?php echo $title; ?></title>
                <style type="text/css" title="currentStyle">
                    @import "<?php echo $rutaCss; ?>css/cssreset-min.css";
                    @import "<?php echo $rutaCss; ?>../css/demo_page.css";
                    @import "<?php echo $rutaCss; ?>../css/demo_table_jui.css";
                    @import "<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                    /*@import "<?php echo $rutaCss; ?>../css/jquery-ui.css";*/
                    input[type=text]{
                        width:90%;
                    }
                </style>        
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
                <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>   
                <?php 
                if($proyecto!="") { 
                    $rutaCSS = $rutaCss."css/style".$proyecto.".css";
                    $rutaJS = $rutaCss."js/functions".$proyecto.".js";
                    ?>
                    <style type="text/css" title="currentStyle">
                        @import "<?php echo $rutaCSS; ?>";
                    </style>   
                    <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
                    <?php 
                } ?>
            </head>
            <body class="<?php echo $classBody; ?>">
                <div id="pageContainer">
                    <?php 
                    if($bd){ return $db; } 
    }//function writeHeader

    function writeHeader2($title, $bd=false, $styles=true, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_monitoreo") {
        verifySession();
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
                <?php if($styles) { ?>
                    <link rel="stylesheet" type="text/css" href="<?php echo $rutaCss; ?>css/cssreset-min.css" />
                    <link rel="stylesheet" type="text/css" href="<?php echo $rutaCss; ?>../css/demo_page.css" />
                    <link rel="stylesheet" type="text/css" href="<?php echo $rutaCss; ?>../css/demo_table_jui.css" />
                    <link rel="stylesheet" type="text/css" href="<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css" />
                <?php } ?>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
                <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>          
                <?php if($proyecto!="") { 
                    $rutaCSS = $rutaCss."css/style".$proyecto.".css";
                    $rutaJS = $rutaCss."js/functions".$proyecto.".js";
                    ?>
                    <?php if($styles) { ?>
                        <link rel="stylesheet" type="text/css" href="<?php echo $rutaCSS; ?>" />
                    <?php } ?>
                    <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
                <?php } ?>
            </head>
            <body class="<?php echo $classBody; ?>">
                <div id="pageContainer">
                <?php if($bd){ return $db; } 
    }//function writeHeader2
    
    //plantilla para test de intereses
    function writeHeader3($title, $bd=false, $proyecto="",$rutaCss="../../",$classBody="body",$nombreUtils="Utils_monitoreo",$Seccion=false,$Apis=true){
        if($Seccion==true){   
            verifySession();
	}
	
	if($bd && $Apis){
            $db = writeHeaderBD($nombreUtils);
	}else if($bd){
            $db = writeHeaderBD($nombreUtils,false);
	}
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
                <title><?php echo $title; ?></title>
                <style type="text/css" title="currentStyle">
                    @import "<?php echo $rutaCss; ?>css/cssreset-min.css";
                    @import "<?php echo $rutaCss; ?>../css/demo_page.css";
                    @import "<?php echo $rutaCss; ?>../css/demo_table_jui.css";
                    @import "<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                    /*@import "<?php echo $rutaCss; ?>../css/jquery-ui.css";*/
                </style>        
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
                <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
                <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>   
                <?php 
                if($proyecto!="") { 
                    $rutaCSS = $rutaCss."css/style".$proyecto.".css";
                    $rutaJS = $rutaCss."js/functions".$proyecto.".js";
                    ?>
                    <style type="text/css" title="currentStyle">
                        @import "<?php echo $rutaCSS; ?>";
                    </style>   
                    <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
                    <?php 
                } ?>
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-WWDFF92');</script>
                <!-- End Google Tag Manager -->
            </head>
            <body class="<?php echo $classBody; ?>">
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WWDFF92"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
                <div id="pageContainer">
                    <?php 
                    if($bd){ return $db; } 
    }//function writeHeader3

    function writeFooter() { 
        ?>
        </div>
        </body>
        </html>
        <?php 
    } //function writeFooter

    function writeStatus($status) { 
        if($status==100){
            echo "Activo";
        } else{
            echo "Inactivo";
        }
    }//function writeStatuss

    function writeYesNoSelect($name,$selected,$class="") { 
        ?>
        <select class="grid-auto required <?php echo $class; ?>" id="<?php echo $name ?>" size="1" name="<?php echo $name ?>">
            <option value="1" <?php if($selected==1){ ?>selected<?php } ?>>Si</option>
            <option value="0" <?php if($selected==0){ ?>selected<?php } ?>>No</option>
        </select>
        <?php 
    }//function writeYesNoSelect

    function writeYesNoStatus($status) {
        if($status==0){
            echo "No";
        } else{
            echo "Si";
        }
    }//function writeYesNoStatus

    function writeHeaderBD($nombreUtils="Utils_monitoreo",$Apis=true) { 
        /*
         * @modified Andres Ariza <arizaancres@unbosque.edu.co>
         * Se unifica la instanciacion de Base de datos y se unifican las claves con el archivo de configuracion
         * @since  Agosto 9 2018
        */
        $Configuration = Configuration::getInstance();
        $db = Factory::createDbo();
    
        $ruta = "../";
	if($nombreUtils=="Utils_monitoreo"){
            while (!is_file($ruta.'monitoreo/class/'.$nombreUtils.'.php')){
                $ruta = $ruta."../";
            }
            require_once ($ruta.'monitoreo/class/'.$nombreUtils.'.php');
        }else if($nombreUtils=="Utils_numericos"){
            while (!is_file($ruta.'sign_numericos/class/'.$nombreUtils.'.php')){
                $ruta = $ruta."../";
            }
            require_once ($ruta.'sign_numericos/class/'.$nombreUtils.'.php');
        }
	$rutaN = "../";
        while(!is_file($rutaN.'API_Monitoreo.php')){
            $rutaN = $rutaN."../";
        }
	//var_dump($rutaN.'API_Monitoreo.php');
	//var_dump(is_file($rutaN.'API_Monitoreo.php'));
	require_once($rutaN.'API_Monitoreo.php');
	//var_dump($rutaN.'API_Monitoreo.php');
	require_once($rutaN.'API_Alertas.php');
        //var_dump($db);
        return $db;
    } //function writeHeaderBD

    function writeHeaderSearchs() {     
        return writeHeaderBD();
    }//function writeHeaderSearchs

    function verifySession() {
        /*
         * @modified Andres Ariza <arizaancres@unbosque.edu.co>
         * Se unifica la validacion de sesion con el ambiente de /sala
         * @since  Agosto 9 2018
        */
        $variables = new stdClass();
        $option = "";
        $tastk = "";
        $action = "";
        if(!empty($_REQUEST)){
            $keys_post = array_keys($_REQUEST);
            foreach ($keys_post as $key_post) {
                $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
                //d($key_post);
                switch($key_post){
                    case 'option':
                        @$option = $_REQUEST[$key_post];
                        break;
                    case 'task':
                        @$task = $_REQUEST[$key_post];
                        break;
                    case 'action':
                        @$action = $_REQUEST[$key_post];
                        break;
                    case 'layout':
                        @$layout = $_REQUEST[$key_post];
                        break;
                        break;
                    case 'itemId':
                        @$itemId = $_REQUEST[$key_post];
                        break;
                }
            }
        }
       Factory::validateSession($variables);
    }//function verifySession

    function writeHeaderCalendar($title) {
        verifySession();
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <!--<meta http-equiv='cache-control' content='no-cache'>
                <meta http-equiv='expires' content='0'>
                <meta http-equiv='pragma' content='no-cache'>-->
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
                <script src="src/Plugins/jquery.ifrmdailog.js" defer type="text/javascript"></script>
                <script src="src/Plugins/wdCalendar_lang_ES.js" type="text/javascript"></script>    
                <script src="src/Plugins/jquery.calendar.js" type="text/javascript"></script>          
            </head>
            <body>
            <?php 
    } //function writeHeaderCalendar
?>