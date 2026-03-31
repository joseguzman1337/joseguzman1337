<?php 
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
    <?php if(isset($_GET["reponerSesion"])){
         require './class/Session.php';
          $session = Session::getInstance(); ?>
              window.top.location = "./index.php?page=factores&sala=<?php echo urlencode(serialize($session->session)); ?>";
   <?php } else { ?>
    window.top.location = "./redirect.php?reponerSesion=1";
    <?php } ?>
</script>
</head>
<body>
</body>
</html>
