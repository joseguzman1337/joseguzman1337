<?php
/**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace organizacion de logica
 * @since Septiembre 13, 2019
 */

require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));
$hoy = date("Y-m-d H:i:s");
switch ($_REQUEST['action']) {
    case 'Validar': {
            $_REQUEST['ciudad1'] = $_POST["ciudad"];
            $_REQUEST['email'] = $_POST["correo"];
            $actualizaPS = false;
            $reg = registroGraduado($db, $_REQUEST["documento"]);
            if (!isset($reg['idestudiantegeneral']) || empty($reg['idestudiantegeneral'])) {
                $reg2 = registroGraduadoAntiguo($db, $_REQUEST["documento"]);
                if (!isset($reg2['idestudiantegeneral']) || empty($reg2['idestudiantegeneral'])) {
                    echo "1";
                } else {
                    $actualizaPS = true;
                    $_REQUEST['tipodocumento'] = $reg2["tipodocumento"];
                    $_REQUEST['tipodocumentoold'] = $reg2["tipodocumento"];
                    $_REQUEST['documentoold'] = $_REQUEST["documento"];
                    $_REQUEST['fnacimiento'] = $reg2["fechanacimientoestudiantegeneral"];
                    $_REQUEST['genero'] = $reg2["codigogenero"];
                    $_REQUEST['direccion1'] = (trim($_REQUEST['direccion']) != "") ? $_REQUEST['direccion'] : $reg2["direccionresidenciaestudiantegeneral"];
                    $_REQUEST['telefono1'] = (trim($_REQUEST['telefono']) != "") ? $_REQUEST['telefono'] : $reg2["telefonoresidenciaestudiantegeneral"];
                    $idestudiantegeneral = $reg2["idestudiantegeneral"];
                }
            } else {
                $actualizaPS = true;
                $_REQUEST['tipodocumento'] = $reg["tipodocumento"];
                $_REQUEST['tipodocumentoold'] = $reg["tipodocumento"];
                $_REQUEST['documentoold'] = $_REQUEST["documento"];
                $_REQUEST['fnacimiento'] = $reg["fechanacimientoestudiantegeneral"];
                $_REQUEST['genero'] = $reg["codigogenero"];
                $_REQUEST['direccion1'] = (trim($_REQUEST['direccion']) != "") ? $_REQUEST['direccion'] : $reg["direccionresidenciaestudiantegeneral"];
                $_REQUEST['telefono1'] = (trim($_REQUEST['telefono']) != "") ? $_REQUEST['telefono'] : $reg["telefonoresidenciaestudiantegeneral"];
                $idestudiantegeneral = $reg["idestudiantegeneral"];
            }


            if ($actualizaPS) {
                //*******************************************************************************************************************
                // INVOCA EL WEB SERVICE DE PS PARA REALIZAR LA ACTUALIZACION DE LOS DATOS, SI LA RESPUESTA ES ERRONEA NO SE HACE LA ACTUALIZACION EN SALA DE LOS DATOS
                require_once('../consulta/interfacespeople/ordenesdepago/reportarmodificacionestudiantesala.php');

                if ($result['ERRNUM'] != 0) {
                    echo '2';
                } else {
                    updateEstudianteGeneral($db, $_REQUEST);

                    $reg4 = consultaCiudad($db, $_REQUEST["ciudad"]);

                    $regEg = consultaEgresado($db, $_REQUEST["documento"]);

                    if (isset($regEg['idestudiantegeneral']) || !empty($regEg['idestudiantegeneral'])) {

                        updateEgresado($db, $_REQUEST, $reg4);

                        $regEg2 = consultaEgresadoExt($db, $idestudiantegeneral);

                        if (isset($regEg2['codigoestudiante']) || !empty($regEg2['codigoestudiante'])) {
                            insertUpdateEgresadoExt($db, $_REQUEST, $reg, "UPDATE", $idestudiantegeneral);
                        } else {
                            insertUpdateEgresadoExt($db, $_REQUEST, $reg, "INSERT INTO", $idestudiantegeneral);
                        }
                    }
                    enviaCorreo($_REQUEST, $reg4);
                    echo "3";
                }
                //*******************************************************************************************************************
            }
        }break;
    case 'consultaCiudad': {
            $ciudades = consultaCiudad($db);
            $ciudadhtml = "<option value=''>Seleccione...</option>";
            foreach ($ciudades as $ciudad) {
                $ciudadhtml .= "<option value='" . $ciudad['idciudad'] . "'>" . $ciudad['nombreciudad'] . " (" . $ciudad['nombredepartamento'] . ")</option>";
            }
            echo $ciudadhtml;
        }break;
}

function consultaCiudad($db, $ciudad = null) {
    $query_ciudad = "select idciudad 
                        ,nombreciudad
                        ,nombredepartamento
                        ,nombrepais
                        from ciudad c
                        join departamento d using(iddepartamento)
                        join pais p using(idpais) ";
    if ($ciudad <> null) {
        $query_ciudad .= "where idciudad='" . $ciudad . "' ";
        $ciudades = $db->GetRow($query_ciudad);
    } else {
        $query_ciudad .= "order by nombreciudad ";
        $ciudades = $db->GetAll($query_ciudad);
    }
    return $ciudades;
}

function consultaEgresado($db, $numeroDocumento) {
    $queryCont = "select * from egresado where numerodocumento='" . $numeroDocumento . "'
                   ";
    $regEg = $db->GetRow($queryCont);
    return $regEg;
}

function consultaEgresadoExt($db, $idestudiantegeneral) {
    //de acuerdo a la informacion encontrada en esta tabla el codigoestudiante = $idestudiantegeneral 
    $queryCont2 = "select * from egresado_ext where codigoestudiante='" . $idestudiantegeneral . "'";
    $regEg2 = $db->GetRow($queryCont2);
    return $regEg2;
}

function registroGraduado($db, $numeroDocumento) {
    $query = "select distinct idestudiantegeneral ,tipodocumento ,fechanacimientoestudiantegeneral
        ,codigogenero ,direccionresidenciaestudiantegeneral ,telefonoresidenciaestudiantegeneral
        from registrograduado
        join estudiante using(codigoestudiante)
        join estudiantegeneral using(idestudiantegeneral)
        where numerodocumento='" . $numeroDocumento . "'";
    $reg = $db->GetRow($query);
    return $reg;
}

/**
 * @param $db
 * @param $numeroDocumento
 * @return mixed
 * busqueda de estudiante egresado graduado antiguo
 */
function registroGraduadoAntiguo($db, $numeroDocumento) {
    $query2 = "select distinct
                 idestudiantegeneral
                ,ciudadresidenciaestudiantegeneral
                ,apellidosestudiantegeneral
                ,nombresestudiantegeneral
                ,emailestudiantegeneral
                ,celularestudiantegeneral
                ,tipodocumento
                ,fechanacimientoestudiantegeneral
                ,codigogenero
                ,direccionresidenciaestudiantegeneral
                ,telefonoresidenciaestudiantegeneral
                from registrograduadoantiguo ra
                left join estudiante using(codigoestudiante)
                left join estudiantegeneral using(idestudiantegeneral)
                where documentoegresadoregistrograduadoantiguo='" . $numeroDocumento . "'
                UNION
                select distinct eg.idestudiantegeneral
                ,ciudadresidenciaestudiantegeneral
                ,apellidosestudiantegeneral
                ,nombresestudiantegeneral
                ,emailestudiantegeneral
                ,celularestudiantegeneral
                ,tipodocumento
                ,fechanacimientoestudiantegeneral
                ,codigogenero
                ,direccionresidenciaestudiantegeneral
                ,telefonoresidenciaestudiantegeneral from RegistroGrado
                inner join ActaGrado AG on RegistroGrado.ActaGradoId = AG.ActaGradoId
                inner join estudiante e ON RegistroGrado.EstudianteId = e.codigoestudiante
                inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral
                where eg.numerodocumento = '" . $numeroDocumento . "'
                and e.codigosituacioncarreraestudiante = 400
                ";
    $reg2 = $db->GetRow($query2);
    return $reg2;
}

$array = array();
$array2 = array();

function updateEstudianteGeneral($db, $array) {
    $query3 = "UPDATE estudiantegeneral SET	
                apellidosestudiantegeneral='" . $array["apellidos"] . "'
                ,nombresestudiantegeneral='" . $array["nombres"] . "'
                ,ciudadresidenciaestudiantegeneral='" . $array["ciudad1"] . "'
                ,emailestudiantegeneral='" . $array["email"] . "'
                ,celularestudiantegeneral='" . $array["celular"] . "'
                ,telefonoresidenciaestudiantegeneral='" . $array["telefono1"] . "'
                ,direccionresidenciaestudiantegeneral='" . $array["direccion1"] . "',
                FechaDocumento='" . $array["fechadocu"] . "',
                fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
                WHERE numerodocumento='" . $array["documento"] . "'";
    $db->Execute($query3);
}

function updateEgresado($db, $array, $array2) {
    $query5 = "UPDATE egresado SET 
                apellidosegresado='" . $array["apellidos"] . "'
                ,nombresegresado='" . $array["nombres"] . "'
                ,ciudadpaisresidenciaegresado='" . $array2["nombreciudad"] . " / " . $array2["nombrepais"] . "'
                ,emailegresado='" . $array["email"] . "'
                ,telefonorecelularegresado='" . $array["celular"] . "'
                ,telefonoresidenciaegresado='" . $array["telefono1"] . "'
                ,direccionresidenciaegresado='" . $array["direccion1"] . "'
                WHERE numerodocumento='" . $array["documento"] . "'";
    $db->Execute($query5);
}

function insertUpdateEgresadoExt($db, $array, $array2, $verb, $idestudiantegeneral) {
    switch ($verb) {
        case "INSERT INTO":
            $complemento = ",";
            break;
        case "UPDATE":
            $complemento = "WHERE";
            break;
    }
    $query6 = $verb . " egresado_ext SET	
                trabajaactualmente='" . $array["encuentra_laborando"] . "'
                ,esempleado='" . $array["usted_es"] . "'
                ,empresa='" . $array["entidaddondetrabaja"] . "'
                ,sectorempresa='" . $array["sector_empresa"] . "'
                ,cargo='" . $array["cargoempleo"] . "'
                ,nivelcoincidencia='" . $array["nivelcoincidencia"] . "'
                ,tipocontrato='" . $array["tipocontrato"] . "'
                ,ingresosalarial='" . $array["ingresosalarial"] . "'
                ,tienecarnet='" . $array["tienecarnet"] . "'
                ,ciudadresidencia='" . $array2["nombreciudad"] . "'
                ,fechaactualizacion='" . date('d/m/Y') . "'
                $complemento codigoestudiante='" . $idestudiantegeneral . "' ";
    $db->Execute($query6);
}

function enviaCorreo($array, $array2) {
    require_once("../funciones/clases/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->From = "mesadeservicio@unbosque.edu.co";
    $mail->FromName = "MESA DE SERVICIO UNIVERSIDAD EL BOSQUE";
    $mail->ContentType = "text/html";
    $mail->Subject = ($array["opc"] == "actualizar") ? "ACTUALIZACIÓN DE INFORMACIÓN (Egresados)" : "SOLICITUD DE CARNÉ (Egresados)";
    $cuerpo = "<b>La siguiente es la información suministrada por el Egresado</b><br><br>" .
            "<b>Documento de identidad: </b>" . $array["documento"] . "<br>" .
            "<b>Apellidos: </b>" . $array["apellidos"] . "<br>" .
            "<b>Nombres: </b>" . $array["nombres"] . "<br>" .
            "<b>Ciudad donde reside: </b>" . $array2["nombreciudad"] . " (" . $array2["nombredepartamento"] . ")<br>" .
            "<b>Correo electrónico: </b>" . $array["email"] . "<br>" .
            "<b>Celular: </b>" . $array["celular"] . "<br>" .
            "<b>Teléfono: </b>" . $array["telefono1"] . "<br>" .
            "<b>Dirección: </b>" . $array["direccion1"] . "<br>" .
            "<b>¿Actualmente se encuentra laborando?: </b>" . $array["encuentra_laborando"] . "<br>" .
            "<b>Usted es: </b>" . $array["usted_es"] . "<br>" .
            "<b>Nombre de la empresa / organización / entidad donde trabaja: </b>" . $array["entidaddondetrabaja"] . "<br>" .
            "<b>¿En cuál de los siguientes sectores está ubicada su empresa?: </b>" . $array["sector_empresa"] . "<br>" .
            "<b>El cargo que ocupa actualmente en su empleo es: </b>" . $array["cargoempleo"] . "<br>" .
            "<b>El nivel de coincidencia entre la actividad laboral actual y su carrera profesional es: </b>" . $array["nivelcoincidencia"] . "<br>" .
            "<b>Que tipo de contrato de vinculación tiene con la empresa en que labora actualmente: </b>" . $array["tipocontrato"] . "<br>" .
            "<b>Cual es su ingreso salarial actual: </b>" . $array["ingresosalarial"] . "<br>";
    if ($array["opc"] == "actualizar") {
        $cuerpo .= "<b>¿Tiene carné de egresados?: </b>" . $array["tienecarnet"];
    }
    $mail->Body = $cuerpo;
            $mail->AddAddress("egresados@unbosque.edu.co", "Egresados UEB");
    $mail->Send();
}
