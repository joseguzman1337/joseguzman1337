<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
//include($rutazado.'zadodb-pager.inc.php');

session_start();
if(isset($_SESSION['debug_sesion'])) {
    $db->debug = true;
}
//$db->debug = true;
//print_r($_SERVER);
require_once("Filtro.php");

if(isset($_REQUEST['nacodigoareadisciplinar']) && isset($_REQUEST['nacodigomodalidadacademicasic']) && isset($_REQUEST['naenviar'])) {
    ?>
<script type="text/javascript">
    window.location.href="listadodocente.php?<?php echo "nacodigoareadisciplinar=".$_REQUEST['nacodigoareadisciplinar']."&nacodigomodalidadacademicasic=".$_REQUEST['nacodigomodalidadacademicasic']."&nacodigocarrera=".$_REQUEST['nacodigocarrera']; ?>";
</script>
<?php
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Matriz Estudiante</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <?php
        filtro();
        ?>
    </body>
</html>
