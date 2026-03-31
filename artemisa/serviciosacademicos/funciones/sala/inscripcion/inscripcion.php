<?php
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once (PATH_ROOT . '/kint/Kint.class.php');
}

class inscripcion {

    var $estudiantegeneral;
    var $idsubperiodo;
    var $idinscripcion;
    var $codigomodalidadacademica;
    var $archivoComienzo = "";

    function inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion, $codigomodalidadacademica) {
        global $db;
        $this->estudiantegeneral = $estudiantegeneral;
        $this->subperiodo = $idsubperiodo;
        $this->idinscripcion = $idinscripcion;
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

    function valida_formulario($query) {
        global $db;
        $tablaini = 0;
        $strcampo = "";
        $cuentavacios = 0;
        $cuentacampos = 0;
        $seltabla = $db->Execute($query);
        $totalRows_seltabla = $seltabla->RecordCount();
        $ratadiligenciada = 0;
        if ($totalRows_seltabla != "") {
            $row_seltabla = $seltabla->FetchRow();
            $cuentallenos=0;
            foreach ($row_seltabla as $campo => $valor) {
                if ($valor != "" && $valor != "0" && $valor != "Campo Faltante") {
                    $cuentallenos++;
                } else {
                }
                $cuentacampos++;
            }
            $ratadiligenciada = $cuentallenos / $cuentacampos;
        }
        return $ratadiligenciada;
    }

    function barra($nombre, $porcentaje) {
        //ANCHO DE NUESTRA BARRA
        $ancho = 1;

        //LARGO MÍNIMO
        $largo = 10;
        ?>
        <table width="50%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
            <tr id="trtitulogris">
                <td colspan="2"><?php echo $nombre; ?></td>
            </tr>
            <tr>
                <td width="70%"><img src="../../../../imagenes/punto.gif" height="<?php echo $largo ?>" width="<?php echo $porcentaje ?>%" style="color:#FEF7ED"></td>
                <td width="30%"><?php echo round($porcentaje, 1) . " %"; ?></td>
            </tr>
        </table>
        <br>
        <?php
    }

    function informacionFinanciera() {
        global $ruta, $db;
        require_once($ruta . "recursofinanciero.php");
    }

    function guardarInformacionFinanciera() {
        global $ruta, $db;
        $banderagrabar = 0;
        if ($_POST['idtipoestudianterecursofinanciero'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el tipo de recurso")</script>';
            $banderagrabar = 1;
        } else if ($banderagrabar == 0) {
            $query_recurso = "INSERT INTO estudianterecursofinanciero(idestudianterecursofinanciero,idestudiantegeneral,idtipoestudianterecursofinanciero,descripcionestudianterecursofinanciero,codigoestado)
			VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['idtipoestudianterecursofinanciero'] . "', '" . $_POST['descripcionestudianterecursofinanciero'] . "','100')";
            $recurso = $db->Execute($query_recurso);
            $this->comenzar();
        }
    }

    function informacionFamiliar() {
        global $ruta, $db;
        if ($this->codigomodalidadacademica != '200') {
            require_once($ruta . "datosfamiliares.php");
        } else {
            require_once($ruta . "datosfamiliares_pregrado.php");
        }
    }

    function guardarInformacionFamiliar() {
        global $ruta, $db;
        $cont = 0;
        foreach ($_POST["idobs_admitidos_contextoP"] as $dt) {
            if (isset($_POST["idobs_admitidos_contexto"][$cont]) AND $_POST["idobs_admitidos_contexto"][$cont] !== '') {
                if (!filter_var($_POST["idobs_admitidos_contexto"][$cont], FILTER_VALIDATE_INT)) {
                    echo '<script language="JavaScript">alert("-> ' . $POST["idobs_admitidos_contexto"][$cont] . '<- no es un valor valido para guardar")</script>';
                } else {

                    $idRespuesta = $this->verRespuestaDetallePersonal($this->estudiantegeneral->idestudiantegeneral, $dt);

                    if ($idRespuesta == "null") {
                        $query_detapersonales = "INSERT INTO EstudianteDetallesPersonales(idestudiantegeneral,idobs_admitidos_contexto,IdItemRespuesta,FechaCreacion,UsuarioCreacion,CodigoEstado) 
                                                            VALUES('" . $this->estudiantegeneral->idestudiantegeneral . "','" . $dt . "','" . $_POST["idobs_admitidos_contexto"][$cont] . "',NOW(),'" . $this->verIdUsuario($_SESSION["MM_Username"]) . "','100')";
                    } else {
                        $query_detapersonales = "UPDATE EstudianteDetallesPersonales
					SET IdItemRespuesta='" . $_POST["idobs_admitidos_contexto"][$cont] . "',
                        FechaModificacion=NOW(),
                        UsuarioModificacion='" . $this->verIdUsuario($_SESSION["MM_Username"]) . "'
                    WHERE idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
					and idobs_admitidos_contexto = '" . $dt . "'
					and codigoestado like '1%'";
                    }
                    $detapersonales = $db->Execute($query_detapersonales);
                }
            }
            $cont++;
        }
        /* fin de guardado de detalles personales   */


        if ($this->codigomodalidadacademica != '200') {
            $banderagrabar = 0;
            $email = "^[A-z0-9\._-]+"
                    . "@"
                    . "[A-z0-9][A-z0-9-]*"
                    . "(\.[A-z0-9_-]+)*"
                    . "\.([A-z]{2,6})$";
            if ($_POST['idtipoestudiantefamilia'] == 0) {
                echo '<script language="JavaScript">alert("Debe elegir el parentesco")</script>';
                $banderagrabar = 1;
            } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['nombresestudiantefamilia']) or $_POST['nombresestudiantefamilia'] == "")) {
                echo '<script language="JavaScript">alert("Falta digitar el nombre")</script>';
                $banderagrabar = 1;
            } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['apellidosestudiantefamilia']) or $_POST['apellidosestudiantefamilia'] == "")) {
                echo '<script language="JavaScript">alert("Falta digitar los apellidos")</script>';
                $banderagrabar = 1;
            }
            else if (!eregi("^[0-9]{1,15}$", $_POST['telefonoestudiantefamilia']) and $_POST['telefonoestudiantefamilia'] <> "") {
                echo '<script language="JavaScript">alert("Teléfono Incorrecto")</script>';
                $banderagrabar = 1;
            }
             else if ($banderagrabar == 0) {
                $nivel = "";
                $ciudad = "";
                if ($_POST['niveleducacion'] <> 0) {
                    $nivel = $_POST['niveleducacion'];
                } else {
                    $nivel = 5;
                }
                if ($_POST['ciudadfamilia'] <> 0) {
                    $ciudad = $_POST['ciudadfamilia'];
                } else {
                    $ciudad = 1;
                }
                $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                VALUES(0,'" . $_POST['apellidosestudiantefamilia'] . "','" . $_POST['nombresestudiantefamilia'] . "','" . $_POST['edad'] . "', '" . $_POST['direccion1'] . "','" . $ciudad . "','" . $_POST['telefonoestudiantefamilia'] . "','" . $_POST['telefono2'] . "','" . $_POST['celular'] . "','" . $_POST['email'] . "','" . $_POST['direccion2'] . "','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idtipoestudiantefamilia'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionestudiantefamilia'] . "','" . $nivel . "','100')";
                $familia = $db->Execute($query_familia);
                $this->comenzar();
            }
        } else {
            if (isset($_REQUEST['idmadre'])) {
                $banderagrabar = 0;
                if ($_REQUEST['nomadre'] != 'sinmadre') {
                    // "Insertar mama con datos toca validar";
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['nombremadre']) or $_POST['nombremadre'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar el nombre de la madre")</script>';
                        $banderagrabar = 1;
                    } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['apellidomadre']) or $_POST['apellidomadre'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar los apellidos de la madre")</script>';
                        $banderagrabar = 1;
                    } else if (!eregi("^[0-9]{1,15}$", $_POST['telefonomadre']) and $_POST['telefonomadre'] <> "" or $_POST['telefonomadre'] == "") {
                        echo '<script language="JavaScript">alert("Teléfono de la madre Incorrecto o Vacío")</script>';
                        $banderagrabar = 1;
                    }
                    else if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$", $_POST['emailmadre']) and $_POST['emailmadre'] <> "" or $_POST['emailmadre'] == "") {
                        echo '<script language="JavaScript">alert("E-mail  de la Madre Incorrecto o vacío")</script>';
                        $banderagrabar = 1;
                    }
                    else if ($banderagrabar == 0) {
                        $nivel = "";
                        $ciudad = "";
                        if ($_POST['niveleducacion'] <> 0) {
                            $nivel = $_POST['niveleducacion'];
                        } else {
                            $nivel = 5;
                        }
                        if ($_POST['ciudadfamilia'] <> 0) {
                            $ciudad = $_POST['ciudadfamilia'];
                        } else {
                            $ciudad = 1;
                        }
                        $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                        VALUES(0,'" . $_POST['apellidomadre'] . "','" . $_POST['nombremadre'] . "','" . $_POST['edad'] . "', '" . $_POST['direccion1'] . "','" . $ciudad . "','" . $_POST['telefonomadre'] . "','" . $_POST['telefono2'] . "','" . $_POST['celular'] . "','" . $_POST['emailmadre'] . "','" . $_POST['direccion2'] . "','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idmadre'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionmadre'] . "','" . $nivel . "','100')";
                        $familia = $db->Execute($query_familia);
                    }
                } else {
                    $nivel = "";
                    $ciudad = "";
                    if ($_POST['niveleducacion'] <> 0) {
                        $nivel = $_POST['niveleducacion'];
                    } else {
                        $nivel = 5;
                    }
                    if ($_POST['ciudadfamilia'] <> 0) {
                        $ciudad = $_POST['ciudadfamilia'];
                    } else {
                        $ciudad = 1;
                    }
                    $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                    VALUES(0,'NO APLICA','NO APLICA','" . $_POST['edad'] . "', '','" . $ciudad . "','','','','','','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idmadre'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionmadre'] . "','" . $nivel . "','100')";
                    $familia = $db->Execute($query_familia);
                }
            }
            $banderagrabar = 0;
            if (isset($_REQUEST['idpadre'])) {
                if ($_REQUEST['nopadre'] != 'sinpadre') {
                    //echo "Insertar mama con datos toca validar";
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['nombrepadre']) or $_POST['nombrepadre'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar el nombre del padre")</script>';
                        $banderagrabar = 1;
                    } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['apellidopadre']) or $_POST['apellidopadre'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar los apellidos del padre")</script>';
                        $banderagrabar = 1;
                    } else if (!eregi("^[0-9]{1,15}$", $_POST['telefonopadre']) and $_POST['telefonopadre'] <> "" or $_POST['telefonopadre'] == "") {
                        echo '<script language="JavaScript">alert("Teléfono del padre Incorrecto o Vacío")</script>';
                        $banderagrabar = 1;
                    }
                    else if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$", $_POST['emailpadre']) and $_POST['emailpadre'] <> "" or $_POST['emailpadre'] == "") {
                        echo '<script language="JavaScript">alert("Email del padre Incorrecto o Vacío")</script>';
                        $banderagrabar = 1;
                    }
                    else if ($banderagrabar == 0) {
                        $nivel = "";
                        $ciudad = "";
                        if ($_POST['niveleducacion'] <> 0) {
                            $nivel = $_POST['niveleducacion'];
                        } else {
                            $nivel = 5;
                        }
                        if ($_POST['ciudadfamilia'] <> 0) {
                            $ciudad = $_POST['ciudadfamilia'];
                        } else {
                            $ciudad = 1;
                        }
                        $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                        VALUES(0,'" . $_POST['apellidopadre'] . "','" . $_POST['nombrepadre'] . "','" . $_POST['edad'] . "', '" . $_POST['direccion1'] . "','" . $ciudad . "','" . $_POST['telefonopadre'] . "','" . $_POST['telefono2'] . "','" . $_POST['celular'] . "','" . $_POST['emailpadre'] . "','" . $_POST['direccion2'] . "','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idpadre'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionpadre'] . "','" . $nivel . "','100')";

                        $familia = $db->Execute($query_familia);
                    }
                } else {
                    $nivel = "";
                    $ciudad = "";
                    if ($_POST['niveleducacion'] <> 0) {
                        $nivel = $_POST['niveleducacion'];
                    } else {
                        $nivel = 5;
                    }
                    if ($_POST['ciudadfamilia'] <> 0) {
                        $ciudad = $_POST['ciudadfamilia'];
                    } else {
                        $ciudad = 1;
                    }
                    $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                    VALUES(0,'NO APLICA','NO APLICA','" . $_POST['edad'] . "', '','" . $ciudad . "','','','','','','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idpadre'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionpadre'] . "','" . $nivel . "','100')";
                    $familia = $db->Execute($query_familia);
                }
            }
            $banderagrabar = 0;
            if (isset($_REQUEST['idhermano'])) {
                if ($_REQUEST['nohermano'] != 'sinhermano') {
                    //echo "Insertar mama con datos toca validar";
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['nombrehermano']) or $_POST['nombrehermano'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar el nombre del hermano")</script>';
                        $banderagrabar = 1;
                    } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['apellidohermano']) or $_POST['apellidohermano'] == "")) {
                        echo '<script language="JavaScript">alert("Falta digitar los apellidos del hermano")</script>';
                        $banderagrabar = 1;
                    } else if (!eregi("^[0-9]{1,15}$", $_POST['telefonohermano']) and $_POST['telefonohermano'] <> "" or $_POST['telefonohermano'] == "") {
                        echo '<script language="JavaScript">alert("Teléfono del hermano Incorrecto o Vacío")</script>';
                        $banderagrabar = 1;
                    }
                   else if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$", $_POST['emailhermano']) and $_POST['emailhermano'] <> "" or $_POST['emailhermano'] == "") {
                        echo '<script language="JavaScript">alert("Email del hermano(a) Incorrecto o Vacío")</script>';
                        $banderagrabar = 1;
                    }
                    else if ($banderagrabar == 0) {
                        $nivel = "";
                        $ciudad = "";
                        if ($_POST['niveleducacion'] <> 0) {
                            $nivel = $_POST['niveleducacion'];
                        } else {
                            $nivel = 5;
                        }
                        if ($_POST['ciudadfamilia'] <> 0) {
                            $ciudad = $_POST['ciudadfamilia'];
                        } else {
                            $ciudad = 1;
                        }
                        $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                        VALUES(0,'" . $_POST['apellidohermano'] . "','" . $_POST['nombrehermano'] . "','" . $_POST['edad'] . "', '" . $_POST['direccion1'] . "','" . $ciudad . "','" . $_POST['telefonohermano'] . "','" . $_POST['telefono2'] . "','" . $_POST['celular'] . "','" . $_POST['emailhermano'] . "','" . $_POST['direccion2'] . "','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idhermano'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionhermano'] . "','" . $nivel . "','100')";
                        $familia = $db->Execute($query_familia);
                    }
                } else {
                    $nivel = "";
                    $ciudad = "";
                    if ($_POST['niveleducacion'] <> 0) {
                        $nivel = $_POST['niveleducacion'];
                    } else {
                        $nivel = 5;
                    }
                    if ($_POST['ciudadfamilia'] <> 0) {
                        $ciudad = $_POST['ciudadfamilia'];
                    } else {
                        $ciudad = 1;
                    }
                    $query_familia = "INSERT INTO estudiantefamilia(idestudiantefamilia,apellidosestudiantefamilia,nombresestudiantefamilia,edadestudiantefamilia,direccionestudiantefamilia,idciudadestudiantefamilia,telefonoestudiantefamilia,telefono2estudiantefamilia,celularestudiantefamilia,emailestudiantefamilia,direccioncorrespondenciaestudiantefamilia,idestudiantegeneral,idtipoestudiantefamilia,profesionestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,codigoestado)
                    VALUES(0,'NO APLICA','NO APLICA','" . $_POST['edad'] . "', '','" . $ciudad . "','','','','','','" . $this->estudiantegeneral->idestudiantegeneral . "','" . $_POST['idhermano'] . "','" . $_POST['profesion'] . "','" . $_POST['ocupacionhermano'] . "','" . $nivel . "','100')";
                    $familia = $db->Execute($query_familia);
                }
            }


            $this->comenzar(); //exit();
        }
    }

    //funcion de verificacion de respuesta de estudiante 
    function verRespuestaDetallePersonal($idEstudiante, $idPregunta) {
        global $ruta, $db;
        $query_buscarespuesta = "SELECT EstudianteDetallesPersonalesId 
                                    FROM EstudianteDetallesPersonales 
                                    WHERE idestudiantegeneral='" . $idEstudiante . "' AND idobs_admitidos_contexto='" . $idPregunta . "'";

        $respuestaestu = $db->Execute($query_buscarespuesta);
        $totalRows = $respuestaestu->RecordCount();

        if ($totalRows == 0) {
            return "null";
        } else {
            $rowrespuesta = $respuestaestu->FetchRow();
            return $rowrespuesta["EstudianteDetallesPersonalesId"];
        }
    }

    function verIdUsuario($nomUsuario) {
        global $ruta, $db;
        $query_buscaidusuario = "SELECT idusuario FROM usuario WHERE usuario.usuario = '" . $nomUsuario . "'";

        $respuestaidusuario = $db->Execute($query_buscaidusuario);
        $totalRows = $respuestaidusuario->RecordCount();

        if ($totalRows == 0) {
            return "null";
        } else {
            $rowUsuario = $respuestaidusuario->FetchRow();
            return $rowUsuario["idusuario"];
        }
    }

    //
    function informacionEstudios() {
        global $ruta, $db, $sala2;
        require_once($ruta . "estudiosrealizados.php");
    }

    function otrosEstudios() {
        global $ruta, $db, $sala2;
        require_once($ruta . "otrosestudiosrealizados.php");
    }

    function informacionEstudiosSecundaria() {
        global $ruta, $db, $sala2;
        require_once($ruta . "estudiosrealizadossecundaria.php");
    }

    function guardarInformacionEstudios() {
        global $ruta, $db;
        $banderagrabar = 0;

        if ($_POST['codigocolegio'] <> "") {
            $query_institucion = "SELECT *
			FROM institucioneducativa ins
			WHERE nombrecortoinstitucioneducativa = '" . $_POST['codigocolegio'] . "'";

            $institucion = $db->Execute($query_institucion);
            $totalRows_institucion = $institucion->RecordCount();
            $row_institucion = $institucion->FetchRow();
            if ($row_institucion <> "") {
                $_POST['idinstitucioneducativa'] = $row_institucion['idinstitucioneducativa'];
            } else {
                echo '<script language="JavaScript">alert("Código de Colegio no valido");</script>';
                $banderagrabar = 1;
            }
        }
        if ($_POST['idniveleducacion'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el Nivel de educación");</script>';
            $banderagrabar = 1;
        } else if ($_POST['codigotitulo'] == 0 && $_REQUEST['otrotituloestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar un titulo o digitarlo");</script>';
            $banderagrabar = 1;
        } else if ($_POST['idinstitucioneducativa'] == "" and $_POST['otrainstitucioneducativaestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar una Institución o digitar un colégio");</script>';
            $banderagrabar = 1;
        }
        else if ($_POST['ciudadinstitucioneducativa'] == "") {
            echo '<script language="JavaScript">alert("Debe digitar al Ciudad de la Institucion Educativa")</script>';
            $banderagrabar = 1;
        } else if ($banderagrabar == 0) {
            if ($_POST['codigotitulo'] == 0) {
                $_POST['codigotitulo'] = 1;
            }
            if ($_POST['idinstitucioneducativa'] == "" || $_POST['idinstitucioneducativa'] == 0) {
                $_POST['idinstitucioneducativa'] = 1;
            }
            $query_estudios = "INSERT INTO estudianteestudio(idestudianteestudio, idestudiantegeneral, idniveleducacion, anogradoestudianteestudio, idinstitucioneducativa,ciudadinstitucioneducativa, otrainstitucioneducativaestudianteestudio, codigotitulo, otrotituloestudianteestudio, observacionestudianteestudio, codigoestado)
			VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['idniveleducacion'] . "', '" . $_POST['anogradoestudianteestudio'] . "','" . $_POST['idinstitucioneducativa'] . "','" . $_POST['ciudadinstitucioneducativa'] . "', '" . $_POST['otrainstitucioneducativaestudianteestudio'] . "','" . $_POST['codigotitulo'] . "', '" . $_POST['otrotituloestudianteestudio'] . "', '" . $_POST['observacionestudianteestudio'] . "','100')";
            $estudios = $db->Execute($query_estudios);
            session_unregister('codigoestudiantecolegionuevo');
            $this->comenzar();
        }
    }

    function guardarOtrosEstudios() {
        global $ruta, $db;
        $banderagrabar = 0;
        if ($_POST['codigocolegio'] <> "") {
            $query_institucion = "SELECT *
			FROM institucioneducativa ins
			WHERE nombrecortoinstitucioneducativa = '" . $_POST['codigocolegio'] . "'";
            $institucion = $db->Execute($query_institucion);
            $totalRows_institucion = $institucion->RecordCount();
            $row_institucion = $institucion->FetchRow();
            if ($row_institucion <> "") {
                $_POST['idinstitucioneducativa'] = $row_institucion['idinstitucioneducativa'];
            } else {
                echo '<script language="JavaScript">alert("Código de Institución no valido");</script>';
                $banderagrabar = 1;
            }
        }
        if ($_POST['idniveleducacion'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el Nivel de educación");</script>';
            $banderagrabar = 1;
        } else if ($_POST['codigotitulo'] == 0 && $_REQUEST['otrotituloestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar un titulo o digitarlo");</script>';
            $banderagrabar = 1;
        } else if ($_POST['idinstitucioneducativa'] == "" and $_POST['otrainstitucioneducativaestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar una Institución o digitar una");</script>';
            $banderagrabar = 1;
        } else if (!eregi("^[0-9]{1,15}$", $_POST['anogradoestudianteestudio']) or $_POST['anogradoestudianteestudio'] > date("Y") or $_POST['anogradoestudianteestudio'] < substr($row_data['fechanacimientoestudiantegeneral'], 0, 4)) {
            echo '<script language="JavaScript">alert("Año Incorrecto");</script>';
            $banderagrabar = 1;
        } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ-]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ-]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ-]+)*))*$", $_POST['ciudadinstitucioneducativa']) or $_POST['ciudadinstitucioneducativa'] == "")) {
            echo '<script language="JavaScript">alert("Debe digitar al Ciudad de la Institucion Educativa")</script>';
            $banderagrabar = 1;
        } else if ($banderagrabar == 0) {
            if ($_POST['codigotitulo'] == 0) {
                $_POST['codigotitulo'] = 1;
            }
            if ($_POST['idinstitucioneducativa'] == "" || $_POST['idinstitucioneducativa'] == 0) {
                $_POST['idinstitucioneducativa'] = 1;
            }
            $query_estudios = "INSERT INTO estudianteestudio(idestudianteestudio, idestudiantegeneral, idniveleducacion, anogradoestudianteestudio, idinstitucioneducativa,ciudadinstitucioneducativa, otrainstitucioneducativaestudianteestudio, codigotitulo, otrotituloestudianteestudio, observacionestudianteestudio, codigoestado)
			VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['idniveleducacion'] . "', '" . $_POST['anogradoestudianteestudio'] . "','" . $_POST['idinstitucioneducativa'] . "','" . $_POST['ciudadinstitucioneducativa'] . "', '" . $_POST['otrainstitucioneducativaestudianteestudio'] . "','" . $_POST['codigotitulo'] . "', '" . $_POST['otrotituloestudianteestudio'] . "', '" . $_POST['observacionestudianteestudio'] . "','100')";
            $estudios = $db->Execute($query_estudios);
            session_unregister('codigoestudiantecolegionuevo');
            $this->comenzar();
        }
    }

    function guardarInformacionEstudiosSecundaria() {
        global $ruta, $db;
        $banderagrabar = 0;

        $registroAc = strip_tags(trim(strtoupper($_REQUEST['registro'])));
        $tipoDocumentoAc = strip_tags(trim($_REQUEST['tipoDocumento']));
        $numeroDocumentoAc = strip_tags(trim($_REQUEST['numeroDocumento']));
        if (!empty($registroAc)) {
            require_once (PATH_ROOT . '/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
            require_once (PATH_ROOT . '/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
            require_once (PATH_ROOT . '/serviciosacademicos/PIR/entidad/DocumentoPresentacionPruebaEstado.php');
            require_once (PATH_ROOT . '/serviciosacademicos/PIR/entidad/DetalleResultadoPruebaEstado.php');

            $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
            $ResultadoPruebaEstado->setIdestudiantegeneral($this->estudiantegeneral->idestudiantegeneral);
            $ResultadoPruebaEstado->getResultadoEsutiante();
            $idResultadoPruebaEstado = $ResultadoPruebaEstado->getIdresultadopruebaestado();
            $DetalleResultadoPruebaEstado = new DetalleResultadoPruebaEstado($db);

            $ac = $ResultadoPruebaEstado->getNumeroregistroresultadopruebaestado();
            $actualizadoPIR = $ResultadoPruebaEstado->getActualizadoPir();
            if (($registroAc != $ac) || ($registroAc == $ac && empty($actualizadoPIR))) {
                $idResultadoPruebaEstadoActual = $ResultadoPruebaEstado->getIdresultadopruebaestado();
                $puntajeGlobalActual = $ResultadoPruebaEstado->getPuntajeGlobal();
                $puestoresultadopruebaestadoActual = $ResultadoPruebaEstado->getPuestoresultadopruebaestado();

                if (!empty($idResultadoPruebaEstado)) {
                    if (!empty($puntajeGlobalActual) || !empty($puestoresultadopruebaestadoActual)) {
                        $ResultadoPruebaEstado->desactivarActualAc();
                    }
                    $DetalleResultadoPruebaEstado->desactivarActualAc($idResultadoPruebaEstadoActual);
                }
            }

            $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($registroAc);
            $ResultadoPruebaEstado->getResultadoEsutiante();

            require_once (PATH_ROOT . '/serviciosacademicos/PIR/entidad/LogActualizacionMasivaPIR.php');
            $LogActualizacionMasivaPIR = new LogActualizacionMasivaPIR($db);
            $fechaEjecucion = date("Y-m-d H:i:s");
            $LogActualizacionMasivaPIR->setTipoDocumento($tipoDocumentoAc);
            $LogActualizacionMasivaPIR->setNumerodocumento($numeroDocumentoAc);
            $LogActualizacionMasivaPIR->setNumeroregistroresultadopruebaestado($registroAc);
            $LogActualizacionMasivaPIR->setIdEstudianteGeneral($this->estudiantegeneral->idestudiantegeneral);

            $LogActualizacionMasivaPIR->setFechadelproceso($fechaEjecucion);

            if ($ResultadoPruebaEstado->validarIdestudiantegeneralAC()) {
                $rows = $DetalleResultadoPruebaEstado->getDetallesResultadoActual($idResultadoPruebaEstadoActual);

                if (empty($rows)) {
                    $ids = array();
                    $query = "SELECT idresultadopruebaestado "
                            . " FROM resultadopruebaestado "
                            . " WHERE codigoestado = 100 "
                            . " AND idestudiantegeneral = " . $this->estudiantegeneral->idestudiantegeneral
                            . " ORDER BY idresultadopruebaestado ASC";
                    $rows = $db->getAll($query);

                    if (!empty($rows)) {
                        $count = count($rows) - 1;
                        foreach ($rows as $r) {
                            $ids[] = $r['idresultadopruebaestado'];
                        }
                        if (!empty($ids)) {
                            $update = "UPDATE resultadopruebaestado SET "
                                    . " codigoestado = 200 "
                                    . " WHERE idresultadopruebaestado IN (" . implode(",", $ids) . ") ";
                            $db->Execute($update);
                            $update = "UPDATE detalleresultadopruebaestado SET "
                                    . " codigoestado = 200 "
                                    . " WHERE idresultadopruebaestado IN (" . implode(",", $ids) . ") ";
                            $db->Execute($update);
                        }
                    }
                }

                $ResultadoPruebaEstado->setResultadosEnBlanco();

                if (!empty($tipoDocumentoAc) && !empty($numeroDocumentoAc)) {
                    $DocumentoPresentacionPruebaEstado = new DocumentoPresentacionPruebaEstado($db, $this->estudiantegeneral->idestudiantegeneral, $tipoDocumentoAc, $numeroDocumentoAc);
                    $idEstudianteBD = $DocumentoPresentacionPruebaEstado->consultarIdEsutianteGeneral();

                    if (empty($idEstudianteBD) || ($idEstudianteBD == $this->estudiantegeneral->idestudiantegeneral)) {
                        $ControlConsultarPIR = new ControlConsultarPIR($tipoDocumentoAc, $numeroDocumentoAc, $registroAc, $this->estudiantegeneral->idestudiantegeneral);
                        $ControlConsultarPIR->storeDocumentoAc($db);

                        $at = $ControlConsultarPIR->getAccessToken();
                        if (empty($at->status) && !is_string($at)) {
                            $ControlConsultarPIR->consultarResultadosPIR();
                            $respuestaPIR = $ControlConsultarPIR->getResultadosPIR();
                            //ddd($respuestaPIR );
                            if (empty($respuestaPIR->status)) {
                                $respuesta = $ControlConsultarPIR->actualizarResultadosSALA($db);
                                if (!$respuesta->s) {
                                    $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                                    $LogActualizacionMasivaPIR->storeLog();
                                }
                            } else {
                                $respuesta->msj = "Puede que los datos que esta enviando no concuerden en la base de datos de las pruebas Saber 11, por favor valide que esten correctos e intentelo de nuevo";
                                $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                                $LogActualizacionMasivaPIR->storeLog();
                            }
                        } else {
                            $respuesta->msj = "No es posible establecer conexion con la base de datos de las pruebas Saber 11";
                            $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                            $LogActualizacionMasivaPIR->storeLog();
                        }
                    } else {
                        $respuesta->msj = "El documento '.$tipoDocumentoAc.' numero '.$numeroDocumentoAc.' esta asignado a otro estudiante y no puede ser utilizado";
                        $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                        $LogActualizacionMasivaPIR->storeLog();

                        echo '<script language="JavaScript">alert("' . $respuesta->msj . '");</script>';
                        $banderagrabar = 1;
                    }
                }
            } else {
                $respuesta->msj = "El número de registro'.$registroAc.' esta siendo utilizado por otro estudiante";

                $LogActualizacionMasivaPIR->setMensajeLog($respuesta->msj);
                $LogActualizacionMasivaPIR->storeLog();

                echo '<script language="JavaScript">alert("' . $respuesta->msj . '");</script>';
                $banderagrabar = 1;
            }
        }
        //exit();
        if ($_POST['codigocolegio'] <> "") {
            $query_institucion = "SELECT *
			FROM institucioneducativa ins
			WHERE nombrecortoinstitucioneducativa = '" . $_POST['codigocolegio'] . "'";
            $institucion = $db->Execute($query_institucion);
            $totalRows_institucion = $institucion->RecordCount();
            $row_institucion = $institucion->FetchRow();
            if ($row_institucion <> "") {
                $_POST['idinstitucioneducativa'] = $row_institucion['idinstitucioneducativa'];
            } else {
                echo '<script language="JavaScript">alert("Código de Colegio no valido");</script>';
                $banderagrabar = 1;
            }
        }
        if ($_POST['idniveleducacion'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el Nivel de educación");</script>';
            $banderagrabar = 1;
        } else if ($_POST['codigotitulo'] == 0 && $_REQUEST['otrotituloestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar un titulo o digitarlo");</script>';
            $banderagrabar = 1;
        } else if ($_POST['idinstitucioneducativa'] == "" and $_POST['otrainstitucioneducativaestudianteestudio'] == "") {
            echo '<script language="JavaScript">alert("Debe seleccionar una Institución o digitar un colegio");</script>';
            $banderagrabar = 1;
        }
        else if (!isset($_POST['ciudadinstitucioneducativa']) or $_POST['ciudadinstitucioneducativa'] == "" or $_POST['ciudadinstitucioneducativa'] == "0") {
            echo '<script language="JavaScript">alert("Debe Seleccionar la Ciudad de la Institucion Educativa")</script>';
            $banderagrabar = 1;

        } else if ($banderagrabar == 0) {
            if ($_POST['codigotitulo'] == 0) {
                $_POST['codigotitulo'] = 1;
            }
            if ($_POST['idinstitucioneducativa'] == "" || $_POST['idinstitucioneducativa'] == 0) {
                $_POST['idinstitucioneducativa'] = 1;
            }
            $query_estudios = "INSERT INTO estudianteestudio(idestudianteestudio, idestudiantegeneral, idniveleducacion, anogradoestudianteestudio, idinstitucioneducativa,ciudadinstitucioneducativa,colegiopertenececundinamarca, otrainstitucioneducativaestudianteestudio, codigotitulo, otrotituloestudianteestudio, observacionestudianteestudio, codigoestado)
			VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['idniveleducacion'] . "', '" . $_POST['anogradoestudianteestudio'] . "','" . $_POST['idinstitucioneducativa'] . "','" . $_POST['ciudadinstitucioneducativa'] . "','" . $_POST['origencolegio'] . "', '" . $_POST['otrainstitucioneducativaestudianteestudio'] . "','" . $_POST['codigotitulo'] . "', '" . $_POST['otrotituloestudianteestudio'] . "', '" . $_POST['observacionestudianteestudio'] . "','100')";
            $estudios = $db->Execute($query_estudios);
            session_unregister('codigoestudiantecolegionuevo');
            $this->comenzar();
        }
    }

    function informacionIdiomas() {
        global $ruta, $db, $sala2;
        require_once($ruta . "idiomas.php");
    }

    function guardarInformacionIdiomas() {
        global $ruta, $db;
        $banderagrabar = 0;
        if ($_POST['descripcion10'] != "" && $_POST['nivelidioma10'] == '') {
            echo '<script language="JavaScript">alert("ERROR: Debe seleccionar un nivel");</script>';
        } else if ($_POST['descripcion10'] == "" && $_POST['nivelidioma10'] == '') {
            echo '<script language="JavaScript">alert("ADVERTENCIA: No ha seleccionado nada");</script>';
        }
        foreach ($_POST as $indice => $porcentaje) {
            if (ereg("nivelidioma", $indice)) {
                $ididioma = ereg_replace("nivelidioma", "", $indice);
                if ($ididioma == 10) {
                    if ($_POST['descripcion' . $ididioma] == "") {
                        echo '<script language="JavaScript">alert("Debe digitar el nombre del otro idioma");</script>';
                    } else {
                        $query_idioma = "INSERT INTO estudianteidioma(idestudianteidioma,idestudiantegeneral,ididioma,porcentajeleeestudianteidioma,porcentajeescribeestudianteidioma,porcentajehablaestudianteidioma,descripcionestudianteidioma,codigoestado)
                        VALUES(0,'" . $this->estudiantegeneral->idestudiantegeneral . "','" . $ididioma . "','" . $porcentaje . "','" . $porcentaje . "','" . $porcentaje . "','" . $_POST['descripcion' . $ididioma] . "','100' )";
                        //echo "$query_idioma <br>";
                        $idioma = $db->Execute($query_idioma);
                        $this->comenzar();
                    }
                } else {
                    $query_idioma = "INSERT INTO estudianteidioma(idestudianteidioma,idestudiantegeneral,ididioma,porcentajeleeestudianteidioma,porcentajeescribeestudianteidioma,porcentajehablaestudianteidioma,descripcionestudianteidioma,codigoestado)
                    VALUES(0,'" . $this->estudiantegeneral->idestudiantegeneral . "','" . $ididioma . "','" . $porcentaje . "','" . $porcentaje . "','" . $porcentaje . "','" . $_POST['descripcion' . $ididioma] . "','100' )";
                    //echo "$query_idioma <br>";
                    $idioma = $db->Execute($query_idioma);
                    $this->comenzar();
                }
            }
        }//foreach
    }//function

    function informacionSegundaOpcion() {
        global $ruta, $db;
        require_once($ruta . "carrerasinscritas.php");
    }

    function guardarInformacionSegundaOpcion() {
        global $ruta, $db;
        $indicador = 0;

        if ($_POST['carrera'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar una Carrera"); history.go(-1);</script>';
            $indicador = 1;
        } else if ($indicador == 0) {
            $query_mayor = "select max(idnumeroopcion) as mayor
		    from estudiantecarrerainscripcion
		    where idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
			and idinscripcion = '" . $this->idinscripcion . "'
			and codigoestado like '1%'";
            $mayor = $db->Execute($query_mayor);
            $row_mayor = $mayor->FetchRow();
            $totalRows_mayor = $mayor->RecordCount();

            if ($row_mayor['mayor'] > 1) {
                echo '<script language="JavaScript">alert("Solamente puede seleccionar una carrera como segunda opción"); </script>';
            }
            else {
                $idnumeroopcion = $row_mayor['mayor'] + 1;

                $query_carrerainscripcion = "INSERT INTO estudiantecarrerainscripcion(codigocarrera, idnumeroopcion, idinscripcion, idestudiantegeneral,codigoestado)
				VALUES('" . $_POST['carrera'] . "', '$idnumeroopcion', '" . $this->idinscripcion . "', '" . $this->estudiantegeneral->idestudiantegeneral . "', '100')";
                $inscripcion = $db->Execute($query_carrerainscripcion);
            }
            $this->comenzar();
        }
    }

    function informacionOtrasU() {
        global $ruta, $db;
        require_once($ruta . "otrasuniversidades.php");
    }

    function guardarInformacionOtrasU() {
        global $ruta, $db;
        $banderagrabar = 0;

        if (!isset($_POST['presentadoestudianteotrauniversidad'])) {
            echo '<script language="JavaScript">alert("Debe responder si se ha presentado o no a otras universidades");</script>';
            $banderagrabar = 1;
        } else if ($_POST['presentadoestudianteuniversidad'] == "") {
            echo '<script language="JavaScript">alert("Debe contestar si es la primera vez que se presenta a esta universidad")</script>';
            $banderagrabar = 1;
        } else if ($_POST['presentadoestudianteotrauniversidad'] == "Si") {
            if ($banderagrabar == 0) {
                if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['institucioneducativaestudianteuniversidad'])) or $_POST['institucioneducativaestudianteuniversidad'] == "") {
                    echo '<script language="JavaScript">alert("Digite la institución"); </script>';
                    $banderagrabar = 1;
                } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['programaacademicoestudianteuniversidad'])) or $_POST['programaacademicoestudianteuniversidad'] == "") {
                    echo '<script language="JavaScript">alert("Digite el programa");</script>';
                    $banderagrabar = 1;
                } else if ((!eregi("^[0-9]{1,15}$", $_POST['anoestudianteuniversidad']) or $_POST['anoestudianteuniversidad'] > date("Y") /* or $_POST['anoestudianteuniversidad'] < substr($row_data['fechanacimientoestudiantegeneral'],0,4) */) and $_POST['anoestudianteuniversidad'] <> "") {
                    echo '<script language="JavaScript">alert("Año Incorrecto")</script>';
                    $banderagrabar = 1;
                } else if ($banderagrabar == 0) {
                    // Mirar que no tenga estudiantecarrerainscripcion si tiene hacerle update si no tiene insertarlo
                    $query_updcarrerainscripcion = "UPDATE estudianteotrauniversidad
					SET presentadoestudianteotrauniversidad='" . $_POST['presentadoestudianteotrauniversidad'] . "', presentadoestudianteotrauniversidad='" . $_POST['presentadoestudianteuniversidad'] . "'
					WHERE idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
					and idinscripcion = '" . $this->idinscripcion . "'
					and codigoestado like '1%'";
                    $inscripcion_upd = $db->Execute($query_updcarrerainscripcion);

                    $query = "select *
					from estudianteotrauniversidad
					where idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
                    and idinscripcion = '" . $this->idinscripcion . "'
                    order by 3";
                    $rta = $db->Execute($query);
                    $totalRows = $rta->RecordCount();

                    if ($totalRows == 0) {
                        $query_carrerainscripcion1 = "INSERT INTO estudianteotrauniversidad(idestudianteotrauniversidad, idestudiantegeneral, idinscripcion, presentadoestudianteotrauniversidad, presentadoestudianteuniversidad, codigoestado)
						VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $this->idinscripcion . "', '" . $_POST['presentadoestudianteotrauniversidad'] . "', '" . $_POST['presentadoestudianteuniversidad'] . "', '100')";
                        $inscripcion1 = $db->Execute($query_carrerainscripcion1);
                    }
                    $query_carrerainscripcion = "INSERT INTO estudianteuniversidad(idestudiantegeneral, idinscripcion,institucioneducativaestudianteuniversidad,programaacademicoestudianteuniversidad,anoestudianteuniversidad,codigoestado)
					VALUES('" . $this->estudiantegeneral->idestudiantegeneral . "','" . $this->idinscripcion . "', '" . $_POST['institucioneducativaestudianteuniversidad'] . "','" . $_POST['programaacademicoestudianteuniversidad'] . "', '" . $_POST['anoestudianteuniversidad'] . "' ,'100')";
                    $inscripcion = $db->Execute($query_carrerainscripcion);
                } // aca
            }
        } else if ($_POST['presentadoestudianteotrauniversidad'] == "No") {
            // Grabar el no, quitando las carreras que tenga en estudiante universidad
            $query_updcarrerainscripcion = "UPDATE estudianteotrauniversidad
			SET presentadoestudianteotrauniversidad='" . $_POST['presentadoestudianteotrauniversidad'] . "',
			presentadoestudianteuniversidad='" . $_POST['presentadoestudianteuniversidad'] . "'
			WHERE idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
			and idinscripcion = '" . $this->idinscripcion . "'
			and codigoestado like '1%'";
            $inscripcion_upd = $db->Execute($query_updcarrerainscripcion);

            $query = "select *
			from estudianteotrauniversidad
			where idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
            and idinscripcion = '" . $this->idinscripcion . "'
			order by 3";
            $rta = $db->Execute($query);
            $totalRows = $rta->RecordCount();
            if ($totalRows == 0) {
                $query_carrerainscripcion1 = "INSERT INTO estudianteotrauniversidad(idestudianteotrauniversidad, idestudiantegeneral, idinscripcion, presentadoestudianteotrauniversidad, presentadoestudianteuniversidad, codigoestado)
				VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $this->idinscripcion . "', '" . $_POST['presentadoestudianteotrauniversidad'] . "', '" . $_POST['presentadoestudianteuniversidad'] . "', '100')";
                $inscripcion1 = $db->Execute($query_carrerainscripcion1);
            }

            $query_upd = "UPDATE estudianteuniversidad
			SET codigoestado='200'
			WHERE idestudiantegeneral = '" . $this->estudiantegeneral->idestudiantegeneral . "'
			and idinscripcion = '" . $this->idinscripcion . "'
			and codigoestado like '1%'";
            $upd = $db->Execute($query_upd);
        }
        $this->comenzar();
    }

    function informacionMedioComunicacion() {
        global $ruta, $db;
        require_once($ruta . "mediocomunicacion.php");
    }

    function guardarInformacionMedioComunicacion() {
        global $ruta, $db;
        $indicador = 0; {
            foreach ($_POST as $indice => $valor) {
                if (ereg("^medio", $indice)) {
                    $i = ereg_replace("^medio", "", $indice);
                    if ($_POST['medio' . $i] == "") {
                        $banderagrabar = 1;
                    }
                }
            }
            if ($banderagrabar == 1) {
                echo '<script language="JavaScript">alert("Debe seleccionar el medio por el cual se entero de la Universidad");</script>';
            }
            if ($banderagrabar == 0) {
                foreach ($_POST as $indice => $valor) {
                    if (ereg("^medio", $indice)) {
                        //$db->debug = true;
                        $i = ereg_replace("^medio", "", $indice);
                        $query_decision = "INSERT INTO estudiantemediocomunicacion(idestudiantemediocomunicacion,idestudiantegeneral,idinscripcion,codigomediocomunicacion,codigoestadoestudiantemediocomunicacion,observacionestudiantemediocomunicacion)
						VALUES(0,'" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $this->idinscripcion . "','" . $_POST['medio' . $i] . "','100','" . $_POST['descripcion' . $i] . "')";
                        $decision = $db->Execute($query_decision);
                    }
                }
                $this->comenzar();
            }
        }
    }

    function ocupacionesExperiencia() {
        global $ruta, $db;
        require_once($ruta . "experiencia.php");
    }

    function guardarInformacionOcupacionesExperiencia() {
        global $ruta, $db;
        $banderagrabar = 0;
        $indicador = 0;

        $banderagrabar_continiar = 0;
        $paginaactual = 1;

        if ($_POST['actividad'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar Una actividad")</script>';
            $banderagrabar = 1;
        }
         else if ($_POST['ciudadexperiencia'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el Pais")</script>';
            $banderagrabar = 1;
        } else if ((ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ\.]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]+)*))*$", $_POST['institucion']) and $_POST['institucion'] == "")) {
            echo '<script language="JavaScript">alert("Debe escribir la Institución o Empresa")</script>';
            $banderagrabar = 1;
        } else if ((ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['cargo']) and $_POST['cargo'] == "")) {
            echo '<script language="JavaScript">alert("Debe escribir el cargo")</script>';
            $banderagrabar = 1;
        } else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$", $_POST['descripcion']) and $_POST['descripcion'] == "")) {
            echo '<script language="JavaScript">alert("Descripción Incorrecta")</script>';
            $banderagrabar = 1;
        }
        //END VALIDACIÓN
        else if ($banderagrabar == 0) {
            $institucion = "";
            if ($_POST['institucion'] <> "") {
                $institucion = $_POST['institucion'];
            } else {
                $institucion = "SIN DEFINIR";
            }
            $query_experiencia = "INSERT INTO estudiantelaboral(idestudiantelaboral,idestudiantegeneral,descripcionestudiantelaboral,cargoestudiantelaboral,empresaestudiantelaboral,idciudad,codigoestado,idtipoestudiantelaboral)
            VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['descripcionestudiantelaboral'] . "', '" . $_POST['cargo'] . "', '" . $institucion . "', '" . $_POST['ciudadexperiencia'] . "','100','" . $_POST['actividad'] . "')";
            $experiencia = $db->Execute($query_experiencia);
            $this->comenzar();
        }
    }

    function actividadesDestacar() {
        global $ruta, $db;
        require_once($ruta . "aspectospersonales.php");
    }

    function guardarInformacionActividadesDestacar() {
        global $ruta, $db;
        $banderagrabar = 0;
        $indicador = 0;

        if ($_POST['aspecto'] == 0) {
            echo '<script language="JavaScript">alert("Debe seleccionar el tipo de aspecto")</script>';
            $banderagrabar = 1;
        } else if ($_POST['descripcionaspecto'] == "") {
            echo '<script language="JavaScript">alert("Describa el tipo de Aspecto")</script>';
            $banderagrabar = 1;
        } else if ($banderagrabar == 0) {
            $query_recurso = "INSERT INTO estudianteaspectospersonales(idestudianteaspectospersonales,idestudiantegeneral,descripcionestudianteaspectospersonales,idtipoestudianteaspectospersonales,codigoestado)
            VALUES(0, '" . $this->estudiantegeneral->idestudiantegeneral . "', '" . $_POST['descripcionaspecto'] . "', '" . $_POST['aspecto'] . "','100')";
            $recurso = $db->Execute($query_recurso);
            $this->comenzar();
        }
    }

    function decisionUniversidad() {
        global $ruta, $db;
        require_once($ruta . "decisionuniversidad.php");
    }

    function comenzar() {
        if ($this->archivoComienzo == "") {
            ?>
            <script language="javascript">
                //alert("<?php echo "$this->archivoComienzo?" . $_SESSION['fppal']; ?>")
                window.location.href = "formulariodeinscripcion.php?<?php echo $_SESSION['fppal'] . "#ancla" . $_SESSION['modulosesion']; ?>";
            </script>
            <?php
        } else {
            ?>
            <script language="javascript">
                //alert("<?php echo "$this->archivoComienzo?" . $_SESSION['fppal']; ?>")
                window.location.href = "<?php echo "$this->archivoComienzo?" . $_SESSION['fppal']; ?>";
            </script>
            <?php
        }
    }

    function crearunicoboton($usuario, $script, $valores, $idboton) {
        global $db;
        $query_selrol = "select m.posicionmenuboton, m.nombremenuboton, m.linkmenuboton, m.linkimagenboton, m.codigotipomenuboton,
		m.variablesmenuboton, m.propiedadesimagenmenuboton, m.propiedadesmenuboton
		from usuariorol ur, menuboton m, permisorolboton p, 	UsuarioTipo ut, usuario u
		where u.usuario = '$usuario'
		AND u.idusuario = ut.UsuarioId
        AND ur.idusuariotipo = ut.UsuarioTipoId
        AND ur.idrol = p.idrol
		and p.idmenuboton = m.idmenuboton
		and m.scriptmenuboton = '$script'
		and m.codigoestadomenuboton = '01'
		and m.idmenuboton = '$idboton'
		order by 1";
        $selrol = $db->Execute($query_selrol);
        $totalRows_selrol = $selrol->RecordCount();
        while ($row_selrol = $selrol->FetchRow()) {
            if ($row_selrol['codigotipomenuboton'] == 100) {
                $this->crearbotonreferenciar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);
            }
            if ($row_selrol['codigotipomenuboton'] == 200) {
                $this->crearbotonsubmit($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);
            }
            if ($row_selrol['codigotipomenuboton'] == 300) {
                $this->crearbotonventanaauxiliar($row_selrol['nombremenuboton'], $row_selrol['linkmenuboton'], $row_selrol['linkimagenboton'], explode(",", $row_selrol['variablesmenuboton']), $valores, $row_selrol['propiedadesimagenmenuboton'], $row_selrol['propiedadesmenuboton']);
            }
        }
    }

    function crearbotonreferenciar($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = "", $link = true) {
        $cadenavariables = "?";
        foreach ($variables as $key => $value) {
            $cadenavariables = $cadenavariables . $value . "=" . $valores[$value] . "&";
        }
        $cadenavariables = ereg_replace("&$", "", $cadenavariables);
        if ($imagen != "") {
            ?>
            <a href="<?php echo $referencia . $cadenavariables; ?>"><img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>" style="border-color:#FFFFFF"></a>
            <?php
        } else if (!$link) {
            ?>
            <input type="button" name="<?php echo $nombre ?>" value="<?php echo $nombre ?>" onClick="<?php echo "window.location.reload('" . $referencia . $cadenavariables . "')"; ?>">
            <?php
        } else {
            ?>
            - <a href="<?php echo $referencia . $cadenavariables; ?>" name="aparencialinknaranja" id="aparencialinknaranja"><?php echo $nombre ?></a>
            <?php
        }
    }

    function crearbotonventanaauxiliar($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = "") {
        $cadenavariables = "?";
        foreach ($variables as $key => $value) {
            $cadenavariables = $cadenavariables . $value . "=" . $valores[$value] . "&";
        }
        $cadenavariables = ereg_replace("&$", "", $cadenavariables);
        if ($imagen != "") {
            ?>
            <a onClick="<?php echo "window.open('" . $referencia . $cadenavariables . "'" . $propiedades . ")"; ?>" style="cursor:pointer">
                <!-- style="border:2px solid blue;" -->
                <img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>"></a>
            <?php
        } else {
            ?>
            <input type="button" name="<?php echo $nombre ?>" value="<?php echo $nombre ?>" onClick="<?php echo "window.open('" . $referencia . $cadenavariables . "'" . $propiedades . ")"; ?>">
            <?php
        }
    }

    function crearbotonsubmit($nombre, $referencia, $imagen, $variables, $valores, $propiedadesimagen, $propiedades = "") {
        $cadenavariables = "?";
        foreach ($variables as $key => $value) {
            $cadenavariables = $cadenavariables . $value . "=" . $valores[$value] . "&";
        }
        $cadenavariables = ereg_replace("&$", "", $cadenavariables);
        if ($imagen != "") {
            ?>
            <a onClick="<?php echo "$propiedades"; ?>" style="cursor:pointer">
                <input type="hidden" name="<?php echo $nombre; ?>" value="<?php echo $nombre; ?>">
                <img src="<?php echo $imagen; ?>" <?php echo $propiedadesimagen ?> alt="<?php echo $nombre ?>" style="border:2px solid blue;"></a>
                <?php
            } else {
                ?>
            <input type="submit" name="<?php echo $nombre; ?>" value="<?php echo $nombre; ?>" onClick="<?php echo $propiedades; ?>">
            <?php
        }
    }

    function imprimirFormulario() {
        global $db;
        require_once("imprimirformulario.php");
    }

    function imprimirInformacionEstudios($aprobarHV = false) {
        global $db;
        require_once("imprimirInformacionEstudios.php");
    }

    function imprimirOcupacionesExperiencia($aprobarHV = false) {
        global $db;
        require_once("imprimirOcupacionesExperiencia.php");
    }

    function imprimirInformacionFinanciera($aprobarHV = false) {
        global $db;
        require_once("imprimirInformacionFinanciera.php");
    }

    function imprimirInformacionIdiomas($aprobarHV = false) {
        global $db;
        require_once("imprimirInformacionIdiomas.php");
    }

    function imprimirActividadesDestacar($aprobarHV = false) {
        global $db;
        require_once("imprimirActividadesDestacar.php");
    }

    function imprimirInformacionFamiliar($aprobarHV = false) {
        global $db;
        require_once("imprimirInformacionFamiliar.php");
    }

}

function tomarIdestudiantegeneral($numerodocumento) {
    global $db;
    $query_estudiantegeneral = "SELECT eg.idestudiantegeneral
	FROM estudiantegeneral eg
    inner join estudiantedocumento e on eg.idestudiantegeneral = e.idestudiantegeneral
	where eg.numerodocumento = '".$numerodocumento."'
    and e.fechavencimientoestudiantedocumento >= NOW()";

    $estudiantegeneral = $db->Execute($query_estudiantegeneral);
    $totalRows_estudiantegeneral = $estudiantegeneral->RecordCount();
    $row_estudiantegeneral = $estudiantegeneral->FetchRow();
    return $row_estudiantegeneral['idestudiantegeneral'];
}

function tomarPorcentajeDiligenciadoFormulario() {
    global $db, $inscripcion;

    $query_ordenformulario = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo
	FROM inscripcionformulario ip, inscripcionmodulo im
	WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
	AND ip.codigomodalidadacademica = '$inscripcion->codigomodalidadacademica'
	AND ip.codigoestado LIKE '1%'
    AND ip.codigoindicadorinscripcionformulario LIKE '1%'
	ORDER BY posicioninscripcionformulario";
    $ordenformulario = $db->Execute($query_ordenformulario);
    $totalRows_ordenformulario = $ordenformulario->RecordCount();
    $cuentapasos = 0;
    $ratafinal = 0;
    $cuentaratas = 0;
    while ($row_ordenformulario = $ordenformulario->FetchRow()) {
        $idinscripcionmodulo = $row_ordenformulario['idinscripcionmodulo'];
        $cuentapasos++;
        switch ($idinscripcionmodulo) {
            // Aca vienen Información del aspirante
            case 1:
                /* , casoemergenciallamarestudiantegeneral,
                  telefono1casoemergenciallamarestudiantegeneral,idtipoestudiantefamilia */
                $query = "select nombresestudiantegeneral, apellidosestudiantegeneral,
			tipodocumento, numerodocumento,	expedidodocumento,
			codigogenero, idciudadnacimiento,
			fechanacimientoestudiantegeneral, direccionresidenciaestudiantegeneral,
			telefonoresidenciaestudiantegeneral, ciudadresidenciaestudiantegeneral,
			emailestudiantegeneral
			from estudiantegeneral
			where idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'";
                $ratatotal = $inscripcion->valida_formulario($query);
                $ratafinal = $ratafinal + $ratatotal;
                $cuentaratas++;
                break;

            case 10:
                //, descripcionestudianterecursofinanciero
                $query = "SELECT nombretipoestudianterecursofinanciero
				FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t
				WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
				and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero
				and e.codigoestado like '1%'
				order by nombretipoestudianterecursofinanciero";
                $ratatotal = $inscripcion->valida_formulario($query);
                $ratafinal = $ratafinal + $ratatotal;
                $cuentaratas++;
                break;

            case 4:
                $query = "SELECT idnumeroopcion, c.nombrecarrera, m.nombremodalidadacademica, c.codigocarrera,
				e.idinscripcion , e.idestudiantecarrerainscripcion
				FROM estudiantecarrerainscripcion e,carrera c,modalidadacademica m
				WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
				and m.codigomodalidadacademica = c.codigomodalidadacademica
				and e.codigocarrera = c.codigocarrera
				and e.codigoestado like '1%'
				and e.idinscripcion = '" . $inscripcion->idinscripcion . "'
				and e.idnumeroopcion > 1
				order by idnumeroopcion";
                $ratatotal = $inscripcion->valida_formulario($query);
                $ratafinal = $ratafinal + $ratatotal;
                $cuentaratas++;
                break;

            case 13:
                $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
                e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
                concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa
                FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
                WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                and e.idniveleducacion = n.idniveleducacion
                and ins.idinstitucioneducativa = e.idinstitucioneducativa
                and e.codigotitulo = t.codigotitulo
                and e.codigoestado like '1%'
                order by anogradoestudianteestudio";
                $ratatotal = $inscripcion->valida_formulario($query);
                $ratafinal = $ratafinal + $ratatotal;
                $cuentaratas++;
                break;
            case 14:
                $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
                e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
                concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa,
                concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo
                FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
                WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                and e.idniveleducacion = n.idniveleducacion
                and ins.idinstitucioneducativa = e.idinstitucioneducativa
                and e.codigotitulo = t.codigotitulo
                and e.codigoestado like '1%'
                order by anogradoestudianteestudio";
                $ratatotal = $inscripcion->valida_formulario($query);
                $ratafinal = $ratafinal + $ratatotal;
                $cuentaratas++;
                break;
        }
    }
    if ($cuentaratas != 0)
        return $ratafinal / $cuentaratas;
}
?>
