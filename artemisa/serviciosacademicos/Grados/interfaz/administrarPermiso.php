<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/* error_reporting(E_ALL);
  ini_set('display_errors', '1');
 */
session_start();
include '../tools/includes.php';
include '../control/ControlItem.php';
include '../control/ControlRol.php';


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

$controlRol = new ControlRol($persistencia);
$verRoles = $controlRol->verRol();
?>
<script src="../js/MainPermiso.js"></script>
<form id="adicionarGrado">
    <p>
        <input type="hidden" id="txtIdRolU" name="txtIdRolU" value="<?php echo $lrol; ?>" />
        <input type="hidden" id="txtCuentaFacultadEU" name="txtCuentaFacultadEU" value="<?php echo $cuentaFacultad; ?>" />
    </p>
    <fieldset>
        <legend align="right" >Administración de permisos</legend>
        <br />
        <table width="100%" border="0">
            <tr valign="top">
                <td>
                    <fieldset style="margin-left: 20px;">
                        <legend>Registrar</legend>
                        <br />
                        <table width="100%" border="0">
                            <tr>
                                <td id="tdrol">Roles de Usuarios : </td>
                                <td id="tdroles">
                                    <select id="cmbRoles" name="cmbRoles">
                                        <option value="">Seleccione Rol</option>
                                        <?php
                                        foreach ($verRoles as $rol) {
                                            $idRol = $rol->getId();
                                            $nombre = $rol->getNombre();
                                            ?>
                                            <option value="<?php echo $idRol; ?>"><?php echo $nombre; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <td>
                            </tr>   
                            <tr>
                                <td colspan="2">
                                    <div id="cargarPermisos"></div>
                                    <div id="mensajePermiso"></div>
                                </td>
                            </tr>
                        </table>    
                    </fieldset>
                </td>
            </tr>

        </table>
        <br />
    </fieldset>

</form>