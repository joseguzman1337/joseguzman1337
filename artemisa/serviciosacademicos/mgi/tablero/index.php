<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
// for use in development mode
//error_reporting(E_ALL);

define('BASE_PATH', dirname(realpath(__FILE__)) . '/');
define('APP_PATH', BASE_PATH . 'class/');

 require './class/VistaController.php';
 require './class/Session.php';
 
 if(isset($_GET["sala"])){
    $session = Session::getInstance();
    $session->recoverSession();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
    window.top.location = "index.php?page=<?php echo $_GET["page"]; ?>";
</script>
</head>
<body>
</body>
</html>
 <?php } else {
 
    $vista = VistaController::getInstance();
    if(isset($_GET["renderPartial"])){
        $vista->renderPartial($_GET["page"]);
    } else {
        $vista->render($_GET["page"]);
    }
 
 }
?>
