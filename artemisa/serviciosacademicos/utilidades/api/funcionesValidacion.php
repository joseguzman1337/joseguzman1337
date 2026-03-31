<?php

function validarToken($idusuario, $token) {
    require_once(realpath(dirname(__FILE__)) . '/../../Connections/sala2.php');
    $rutaado = ("../../funciones/adodb/");
    require_once(realpath(dirname(__FILE__)) . '/../../Connections/salaado-pear.php');
    require_once(realpath(dirname(__FILE__)) . "/../../funciones/clases/autenticacion/autenticacion.php");

    $tokenValido = false;
    $fecha = date("Y-m-d H:i:s");
    $sql = "SELECT FechaCreacion,TokenID FROM Token WHERE idUsuario=? 
	AND CodigoEstado='100' AND token=?";
    $Validacion[] = "$idusuario";
    $Validacion[] = "$token";
    $activo = $db->GetRow($sql, $Validacion);

    if (count($activo) > 0) {
        $dateTimestamp1 = strtotime($fecha);
        $dateTimestamp2 = strtotime($activo["FechaCreacion"]);
        $dateTimestamp2 = strtotime('+30 minutes', $dateTimestamp2);
        if ($dateTimestamp2 > $dateTimestamp1) {
            $tokenValido = true;
        } else {
            //Sí el tiempo ha finalizado 
            $sql = "UPDATE `Token` SET `CodigoEstado`='200' WHERE (`TokenID`='" . $activo["TokenID"] . "')";
            $db->Execute($sql);
        }
    }
    return $tokenValido;
}

//funcion para la validacion de roles
function CambioRol($db, $usuario, $rol) {
    if ($usuario == false) {
        $usuario = 'appbosque';
    }
    $SQL_B = 'SELECT numerodocumento FROM usuario WHERE usuario=?';
    $VariableBuscar = array();
    $VariableBuscar[] = "$usuario";
    $UsuaroNumero = $db->GetRow($SQL_B, $VariableBuscar);
    $numerodocumento = $UsuaroNumero["numerodocumento"];

    $SQL_V = 'SELECT u.*,d.nombrecortodocumento FROM usuario u INNER JOIN documento d ON d.tipodocumento=u.tipodocumento
            WHERE u.numerodocumento = ? AND u.codigorol=?
            and (NOW() between u.fechainiciousuario and u.fechavencimientousuario)
            and u.codigoestadousuario like "1%"';
    $VariableValida = array();
    $VariableValida[] = "$numerodocumento";
    $VariableValida[] = "$rol";

    $UsuaroDatos = $db->GetRow($SQL_V, $VariableValida);
    return $UsuaroDatos;
}

//funcion para la creacion del token de session para los usuarios
function CreatTokenApp($db, $idusuario, $usuarioname, $plataforma, $devicetoken) {
    $fecha = date("Y-m-d H:i:s");
    $sql = "UPDATE `Token` SET `CodigoEstado`='200' WHERE (`idUsuario`='" . $idusuario . "') AND `CodigoEstado`='100'";
    $db->Execute($sql);
    $Token = sha1($idusuario . $usuarioname . $fecha);
    $sql = "INSERT INTO `Token` (`idUsuario`, `token`, `FechaCreacion`, `CodigoEstado`, `FechaModificacion`, `Plataforma`, `devicetoken`) 
        VALUES ('" . $idusuario . "', '" . $Token . "', '" . $fecha . "', '100', '" . $fecha . "', '" . $plataforma . "', '" . $devicetoken . "')";
    $db->Execute($sql);
    return $Token;
}

/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se quita la funcion TipoPlataforma($db, $idusuario) ya que trae por default Android
 * por lo tanto no sera necesaria ya que el parametro "plataforma" (android o iOS) es enviado desde el dispositivo 
 * @since Marzo 1, 2019
 */
function autenticarUsuario($usuario, $clave, $segunda = false, $rol = false, $plataforma = false, $devicetoken = false) {
    require_once(realpath(dirname(__FILE__)) . '/../../Connections/sala2.php');
    $rutaado = ("../../funciones/adodb/");
    require_once(realpath(dirname(__FILE__)) . '/../../Connections/salaado-pear.php');
    require_once(realpath(dirname(__FILE__)) . "/../../funciones/clases/autenticacion/autenticacion.php");
    require_once(realpath(dirname(__FILE__)) . "/../../Connections/conexionldap.php");
    require_once(realpath(dirname(__FILE__)) . "/../../funciones/clases/autenticacion/claseldap.php");

    if ($rol == 1) {
        $autenticacion->autenticacionAutorizada = 1;
        $autenticacion->arrayDatosUsuario = CambioRol($db, $usuario, $rol);
        $autenticacion->arrayDatosUsuario['rolesmuliple'][] = $autenticacion->arrayDatosUsuario['codigorol'];
        $autenticacion->mensajeUsuario = 'Autenticado correctamente';
    } else {
        $autenticacion = new autenticacion($sala, $usuario, $clave, $segunda, "array", false, 1);
    }

    if ($autenticacion->autenticacionAutorizada == 1) {
        $json["result"] = "OK";
        $json["codigoresultado"] = 0;
        $json['mensaje'] = $autenticacion->mensajeUsuario;
        $json["idusuario"] = $autenticacion->arrayDatosUsuario['idusuario'];
        $json["numerodocumento"] = $autenticacion->arrayDatosUsuario['numerodocumento'];
        $json["tipodocumento"] = $autenticacion->arrayDatosUsuario['nombrecortodocumento'];
        $json["fullname"] = $autenticacion->arrayDatosUsuario['apellidos'] . ' ' . $autenticacion->arrayDatosUsuario['nombres'];

        $sql = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
                FROM estudiantedocumento ed, estudiante e, estudiantegeneral eg, ubicacionimagen u
                where eg.idestudiantegeneral = e.idestudiantegeneral
                and eg.numerodocumento = '" . $autenticacion->arrayDatosUsuario['numerodocumento'] . "' 
                and eg.idestudiantegeneral=ed.idestudiantegeneral
                and u.idubicacionimagen like '1%'
                and u.codigoestado like '1%'
                GROUP BY ed.numerodocumento
                order by 2 desc";
        $documentos = $db->GetAll($sql);
        $json["foto"] = "";
        foreach ($documentos as $doc) {
            if ($json["foto"] == "" && is_file(realpath(dirname(__FILE__)) . '/../../../imagenes/estudiantes/' . $doc['numerodocumento'] . '.jpg')) {
                $json["foto"] = 'https://artemisa.unbosque.edu.co/imagenes/estudiantes/' . $doc['numerodocumento'] . '.jpg';
            } else {
                $json["foto"] = 'https://artemisa.unbosque.edu.co/imagenes/estudiantes/no_foto.jpg';
            }
        }
        $json["plataforma"] = $plataforma;
        $json["devicetoken"] = $devicetoken;
        $json["token"] = CreatTokenApp($db, $json["idusuario"], $autenticacion->usuario, $plataforma, $devicetoken);
    } else if ($autenticacion->arrayDatosUsuario['codigorol'] == 1) {

        if ($autenticacion->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] == 3 || $autenticacion->contenidofail == 3) {
            $json["codigoresultado"] = 2;
            $json["result"] = "ERROR";
            $json['mensaje'] = $autenticacion->mensajeUsuario;
        } else {
            $json["codigoresultado"] = 1;
            $json["result"] = "ERROR";
            $json['mensaje'] = $autenticacion->mensajeUsuario;
        }
    } else if ($autenticacion->arrayDatosUsuario['codigorol'] == 2 && $autenticacion->avanzaAPISegundaClave == true) {

        $json["codigoresultado"] = 6;
        $json["result"] = "OK";
        $json['mensaje'] = $autenticacion->mensajeUsuario;
    } else if ($autenticacion->existesegundaclave) {

        if ($autenticacion->arrayDatosUsuario['codigorol'] == 2 && $autenticacion->arrayClavesUsuario[0]['codigotipoclaveusuario'] == 3) {

            $json["result"] = "OK";
            $json["codigoresultado"] = 0;
            $json['mensaje'] = $autenticacion->mensajeUsuario;

            if ($autenticacion->ArrayContadorIntentosAccesoFallidos['contadorlogintentosaccesousuario'] == 3 || $autenticacion->contenidofail == 3) {
                $json["codigoresultado"] = 2;
                $json["result"] = "ERROR";
                $json['mensaje'] = $autenticacion->mensajeUsuario;
            } else {
                $json["codigoresultado"] = 1;
                $json["result"] = "ERROR";
                $json['mensaje'] = $autenticacion->mensajeUsuario;
            }
        }
    } else if ($autenticacion->respuestaApp && !$autenticacion->existesegundaclave) {

        $json["result"] = "ERROR";
        $json["codigoresultado"] = 5;
        $json['mensaje'] = "Asigne por primera vez su segunda clave desde la aplicación web.";
    }

    if ($json["codigoresultado"] == 0 || $json["codigoresultado"] == 6) {

        if ($rol) {
            $json["rol"][] = $rol;
        } else {
            $numRol = count($autenticacion->arrayDatosUsuario['rolesmuliple']);

            for ($i = 0; $i < $numRol; $i++) {
                if ($autenticacion->arrayDatosUsuario['rolesmuliple'][$i] == 1 || $autenticacion->arrayDatosUsuario['rolesmuliple'][$i] == 2) {
                    $json["rol"][] = $autenticacion->arrayDatosUsuario['rolesmuliple'][$i];
                }
            }
        }

        $num_roles = count($json["rol"]);
        $json["numrol"] = $num_roles;

        if ($json["numrol"] < 1) {
            $admin = true;
        } else {
            $admin = false;
            if ($num_roles == 1 && $segunda == false) {
                switch ($json["rol"][0]) {
                    case '1': {
                            $json["codigoresultado"] = 0;
                        }break;
                    case '2': {
                            $json["codigoresultado"] = 6;
                        }break;
                }
            }
        }
    }

    if ($admin) {
        $autenticacion->arrayDatosUsuario = CambioRol($db, false, 0);

        $autenticacion = new autenticacion($sala, $usuario, $clave, $segunda, "array", $autenticacion->arrayDatosUsuario['idusuario'], 1);

        if ($autenticacion->autenticacionAutorizada == 1) {
            $autenticacion->arrayDatosUsuario['rolesmuliple'][] = 3;
            $autenticacion->mensajeUsuario = 'Autenticado correctamente';

            $json["result"] = "OK";
            $json["codigoresultado"] = 0;
            $json['mensaje'] = $autenticacion->mensajeUsuario;
            $json["idusuario"] = $autenticacion->arrayDatosUsuario['idusuario'];
            $json["numerodocumento"] = ' ';
            $json["tipodocumento"] = ' ';
            $json["fullname"] = ' ';
            $json["token"] = CreatTokenApp($db, $json["idusuario"], $usuario, $plataforma, $devicetoken);
            /**
             * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Se quita TipoPlataforma($db,$json["idusuario"]); ya que colocaba por default Android 
             * por lo tanto no sera necesaria ya que el parametro "plataforma" (android o iOS) es enviado desde el dispositivo 
             * @since Marzo 1, 2019
             */
            $json["plataforma"] = $plataforma;
            $json["rol"] = $autenticacion->arrayDatosUsuario['rolesmuliple'];
            $json["numrol"] = count($json["rol"]);
            $json["foto"] = "";
            if ($json["foto"] == "" && is_file(realpath(dirname(__FILE__)) . '/../../../imagenes/estudiantes/' . $doc['numerodocumento'] . '.jpg')) {
                $json["foto"] = 'https://artemisa.unbosque.edu.co/imagenes/estudiantes/' . $doc['numerodocumento'] . '.jpg';
            } else {
                $json["foto"] = 'https://artemisa.unbosque.edu.co/imagenes/estudiantes/no_foto.jpg';
            }
        } else {
            $json["codigoresultado"] = 1;
            $json["result"] = "ERROR";
            $json['mensaje'] = $autenticacion->mensajeUsuario;
        }
    }
    return $json;
}

?>
