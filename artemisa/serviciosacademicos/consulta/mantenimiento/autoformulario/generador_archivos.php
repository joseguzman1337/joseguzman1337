<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/auto_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../../sala/includes/adaptador.php");

$permission = getPermissionByUser($db);

if(count($permission) == 0)
{
    ?>
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
    <?php

    echo "
        <div class='alert alert-danger' role='alert'>
          Usted no tiene permiso para ver esta página
        </div>";
    exit();
}
$generador = new GeneradorArchivoDescripcionTabla($tabla,$sala,'sala',false);
$array_coincidencias=$generador->BuscarCoincidenciasTabla($tabla);
$ruta="/var/tmp";
$generador->GenerarArchivoSeparadoPorComas($array_coincidencias,$ruta,$tabla.".txt");
?>