<?php
if (isset($_POST["idusuario"])){
    $idUsuario=$_POST["idusuario"];
}else{
    $idUsuario= 2;
}

if(isset($_POST['action']) && !empty($_POST['action'])){
    if(isset($_POST['idconvenio']) && !empty($_POST['idconvenio'])) {
        $id = $_POST['idconvenio'];
        if(isset($_POST['codigoestudiante']) && !empty($_POST['codigoestudiante'])) {
            $codigoestudiante = $_POST['codigoestudiante'];
            if(isset($_POST['codigoperiodo']) && !empty($_POST['codigoperiodo'])) {
                $periodo = $_POST['codigoperiodo'];
                is_file(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
                    ? require_once(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
                    : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

                $sqlconsulta = "select idlog from logconvenioinscripcion where codigoestudiante =" . $codigoestudiante . " " .
                    " and codigoestado = 100";
                $existe = $db->GetRow($sqlconsulta);

                if (isset($existe['idlog']) && !empty($existe['idlog'])) {
                    $sqlupdate = "UPDATE logconvenioinscripcion l SET l.codigoestado='200'  ".
                    " WHERE l.codigoestudiante ='".$codigoestudiante."' and l.codigoestado = 100";
                    $db->Execute($sqlupdate);

                    $sqlinsert = "insert into logconvenioinscripcion (idconvenioinscripcion, codigoestudiante, codigoperiodo," .
                        " codigoestado, fechacreacion, usuariocreacion) " .
                        " VALUE ('" . $id . "','" . $codigoestudiante . "', ".$periodo.", '100', now(), '".$idUsuario."')";
                    $db->Execute($sqlinsert);

                    $return['msg'] = "Asignacion actualizado";
                } else {
                    $sqlinsert = "insert into logconvenioinscripcion (idconvenioinscripcion, codigoestudiante, codigoperiodo," .
                        " codigoestado, fechacreacion, usuariocreacion) " .
                        " VALUE ('" . $id . "','" . $codigoestudiante . "', ".$periodo.", '100', now(), '".$idUsuario."')";
                    $db->Execute($sqlinsert);
                    $return['msg'] = "Nueva asignacion realizada ";
                }
            }else{
                $return['msg'] = "Error de registro de periodo";
            }
        }else{
            $return['msg'] = "Datos incompletos usuario";
        }
    }else{
        $return['msg'] = "Datos incompletos convenio";
    }
    $return['sql'] = $sqlconsulta;

    echo json_encode($return);
}
