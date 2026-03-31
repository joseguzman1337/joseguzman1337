<?php
// this starts the session 
session_start();

function writeHeader($title, $bd = false, $proyecto = "", $rutaCss = "../../", $classBody = "body", $nombreUtils = "Utils_monitoreo") {

//verifySession();

    if ($bd) {
        $db = writeHeaderBD($nombreUtils);
    }
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $title; ?></title> 
            <meta name="viewport" content="initial-scale=1, maximum-scale=1">
            <?php
            /**
             * @modified Andres Ariza <arizaandres@unbosque.edu.do>
             * Se agrega llamado a css y js del nuevo diseño para la seccion
             * @since enero 24, 2019
             */
            ?>
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/normalize.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/font-page.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/font-awesome.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/chosen.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/serviciosacademicos/mgi/tablero_siq/frontAcreditacion/assets/styleAcreditacion.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/bootstrap.css">
            <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/general.css">
            <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT;?>/assets/js/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="<?php echo HTTP_ROOT;?>/assets/js/bootstrap.js"></script>
            
            <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>        
            <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
            <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script> 
            <script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>          
            <?php
            if ($proyecto != "") { 
                $rutaJS = $rutaCss . "js/functions" . $proyecto . ".js";
                ?>  
                <script type="text/javascript" language="javascript" src="<?php echo $rutaJS; ?>"></script>  
            <?php } ?>
        </head>
        <body class="<?php echo $classBody; ?>">
        <?php
    if ($bd) {
        return $db;
    }
}

function writeFooter() { 
    ?>
        </body>
    </html>
    <?php 
} 

function writeHeader2($title, $bd = false, $styles = true, $proyecto = "", $rutaCss = "../../", $classBody = "body", $nombreUtils = "Utils_monitoreo") {
    if ($bd) {
        $db = writeHeaderBD($nombreUtils);
    }
    ?>
    <?php
}

function writeHeaderBD($nombreUtils = "Utils_monitoreo") {
    $ruta = "../";
    while (!is_file($ruta . 'Connections/sala2.php')) {
        $ruta = $ruta . "../";
    }
    require_once($ruta . 'Connections/sala2.php');
    $rutaado = $ruta . "funciones/adodb/";
    require_once($ruta . 'Connections/salaado.php');

    $ruta = "../";
    if ($nombreUtils == "Utils_monitoreo") {
        while (!is_file($ruta . 'monitoreo/class/' . $nombreUtils . '.php')) {
            $ruta = $ruta . "../";
        }
        require_once ($ruta . 'monitoreo/class/' . $nombreUtils . '.php');
    }

    $ruta = "../";
    while (!is_file($ruta . 'API_Monitoreo.php')) {
        $ruta = $ruta . "../";
    }
    require_once ($ruta . 'API_Monitoreo.php');
    require_once ($ruta . 'API_Alertas.php');
    //var_dump($db);
    return $db;
}

function verifySession() {
    //verifica la sesión del usuario
    $ruta = "../";
    while (!is_file($ruta . 'functionsUsersClass.php')) {
        $ruta = $ruta . "../";
    }
    require_once ($ruta . 'functionsUsersClass.php');
    $functionsUsers = new functionsUsersClass();
    $functionsUsers->verifySession();
}
?>