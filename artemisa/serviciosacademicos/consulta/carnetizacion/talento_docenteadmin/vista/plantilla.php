<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro De Informacion Para Carnetizacion</title>
    <?php
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/select2.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/datatables.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/plugins/font-awesome/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/sweetalert.css");
    ?>
</head>
<body>
<div class="container-fluid">
    <?php

    if (isset($_POST["accion"])){
        $accion = $_POST["accion"];
        switch ($accion){
            case "formAdministrativoDocente";
                include ('modulo/formAdministrativoDocente.php');
            break;
            case "crearAdministrativoDocente";
                include ('modulo/formAdministrativoDocente.php');
                controlAdministrativoDocente::ctrCreacionAdministrativoDocente();
            break;
            case "pasoActualizarAdministrativoDocente";
                include ('modulo/formAdministrativoDocente.php');
                break;
            case "actualizarAdministrativoDocente";
                controlAdministrativoDocente::ctrActualizarAdministrativoDocente();
                include('modulo/menuConsulta.php');
                break;

            default:
                 include('modulo/menuConsulta.php');
        }
    }else {
        include('modulo/menuConsulta.php');
    }
    ?>
</div>
<?php
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/datatables.js");
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/select2.min.js");
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/select2.full.min.js");
echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/sweetAlert/sweetalert.min.js");
?>
<script  type="text/javascript"  src="assets/js/main.js"></script>
<script  type="text/javascript"  src="assets/js/mainFormAdministrativoDocente.js"></script>
<script  type="text/javascript"  src="assets/js/mainActualizaUsuario.js"></script>
</body>
</html>



