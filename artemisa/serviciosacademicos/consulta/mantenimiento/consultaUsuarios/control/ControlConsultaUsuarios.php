<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$return = array();
if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] == 'buscarUsuario'){
    if(isset($_POST['fechanacimiento']) && !empty($_POST['fechanacimiento'])) {
        if (isset($_POST['documento']) && !empty($_POST['documento'])) {
            is_file(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php")
                ? require_once(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php")
                : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

            $sqlconsulta = "select us.usuario, us.apellidos, us.nombres, us.codigoestadousuario, " .
            " eg.emailestudiantegeneral, eg.codigoestado, lc.fechalogcreacionusuario, ".
            " lc.tmpclavelogcreacionusuario, lc.codigoestado " .
            " from usuario us " .
            " inner join estudiantegeneral eg on eg.numerodocumento = us.numerodocumento " .
            " left join logcreacionusuario lc on lc.idusuario = us.idusuario " .
            " where us.numerodocumento = '" . $_POST['documento'] . "' ".
            " and eg.fechanacimientoestudiantegeneral like '%".$_POST['fechanacimiento']."%'".
            " and us.codigotipousuario = 600";
            $idusuario = $db->GetRow($sqlconsulta);

            if (isset($idusuario['usuario']) && !empty($idusuario['usuario'])) {
                $return['id'] = $idusuario['usuario'];
                $return['apellidos'] = $idusuario['apellidos'];
                $return['nombres'] = $idusuario['nombres'];
                $return['emailestudiantegeneral'] = $idusuario['emailestudiantegeneral'];
                $return['claveusuario'] = $idusuario['tmpclavelogcreacionusuario'];
                $return['fechalogcreacionusuario'] = $idusuario['fechalogcreacionusuario'];

                $return['val'] = true;
            } else {
                $return['msg'] = "No existe un usuario asociado a ese número de documento, ".
                " contactese con mesa de servicio mesadeservicio@unbosque.edu.co";
                $return['val'] = false;
            }
        } else {
            $return['msg'] = "Error de numero de documento, intenlo de nuevo";
            $return['val'] = false;
        }
    }
    else {
        $return['msg'] = "Error de fecha de nacimiento, intenlo de nuevo";
        $return['val'] = false;
    }

    echo json_encode($return);
}

