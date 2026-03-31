<?php
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright  Desarrollo Tecnologico
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', 'On');
set_time_limit(0);

session_start();
include '../tools/includes.php';
include '../control/ControlCarrera.php';

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

$controlCarrera = new ControlCarrera($persistencia);

switch ($tipoOperacionTitulo) {
    case "consultar":
        if ($cmbCarreraTitulo == "pregrados" or $cmbCarreraTitulo == "posgrados") {
            echo "invalido";
        } else {
            $titulo = $controlCarrera->buscarTituloProfesion($cmbCarreraTitulo);
            $carrera = $controlCarrera->buscarCarrera($cmbCarreraTitulo);
            ?>
            <script src="../js/MainTitulo.js"></script>
            <form id="modificarTitulo">
                <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $idPersona; ?>" />
                <input type="hidden" id="txtIdTitulo" name="txtIdTitulo" value="<?php echo $titulo->getTituloProfesion()->getCodigoTitulo(); ?>" />
                <fieldset>
                    <legend align="right" >Actualizar nombre de titulo a obtener</legend>
                    <br />  
                    <table width="70%" border="0" align="center">
                        <tr>
                            <td>Carrera: </td>
                            <td><input type="text" readonly name="carrera" size="70" value="<?php echo $carrera->getNombreCarrera(); ?>"></td>
                        </tr>
                        <tr>
                            <td>Titulo a obtener genero Masculino:</td>
                            <td><input type="text" id="nombreTitulo" name="nombreTitulo" size="70" value="<?php echo $titulo->getTituloProfesion()->getNombreTitulo(); ?>"></td>
                        </tr>
                        <tr>
                            <td>Titulo a obtener genero Femenino:</td>
                            <td><input type="text" id="nombreTituloGenero" name="nombreTituloGenero" size="70" value="<?php echo $titulo->getTituloProfesion()->getNombreTituloGenero(); ?>"></td>
                        </tr>
                    </table>
                </fieldset>
                </br>
                <div align="center">
                    <a id="btnActualizarTitulo">Actualizar</a>

                </div>
                <br />
            </form>    
            <?php
        }
        break;

    case "actualizar":
        echo $controlCarrera->actualizarTituloCarrera($txtIdTitulo, $nombreTitulo, $nombreTituloGenero, $idPersona);
        break;
    default:
        break;
}
?>