<?php
/**
 * @author Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 'On');
session_start();

include '../tools/includes.php';
include '../control/ControlItem.php';

if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = strip_tags(trim($_POST[$key_post]));
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = strip_tags(trim($_GET[$key_get]));
    }
}


if (isset($_SESSION["datoSesion"])) {
    $user = $_SESSION["datoSesion"];
    $idPersona = $user[0];
    $luser = $user[1];
    $lrol = $user[3];
    $persistencia = new Singleton( );
    $persistencia = $persistencia->unserializar($user[4]);
    $persistencia->conectar();
} else {
    header("Location:error.php");
}

$controlItem = new ControlItem($persistencia);

if ($accion == "permiso") {
    $roles = $controlItem->verPermiso($idRol);
    echo "<h3><strong>Seleccione permisos:</strong></h3>";
    echo "<table><thead><tr><th width='10%'>#</th><th width='40%'>Permiso</th><th width='50%'>Descripcion</th></tr><thead><tbody>";
    foreach ($roles as $rol) {
        echo "<tr>";
        $idPermiso = $rol->getId();
        $nombre = $rol->getNombre();
        $estado = $rol->getCodigo();
        $descripcion = $rol->getDescripcion();
        ?>
        <td>
            <input type="checkbox" name="permiso" class="permiso" attr-data="<?php echo $idPermiso ?>"  value="<?php echo $idPermiso ?>" <?php
                   if ($estado == 100) {
                       echo "checked";
                   }
                   ?>>
        </td>
        <td><?php echo $nombre; ?></td>
        <td><?php echo $descripcion; ?></td>
        <?php
        echo "</tr>";
    }
    echo "<tbody></table>";
} else if ($accion == "asignacionPermiso") {
    echo $controlItem->verificarPermiso($estado, $idRol, $permiso, $idPersona);
}
?>