<?php
    session_start();
    $rutaado = ("../../serviciosacademicos/funciones/adodb/");
    require_once("../../serviciosacademicos/Connections/salaado-pear.php");
    require_once("../../serviciosacademicos/funciones/clases/formulario/clase_formulario.php");
    require_once("../../serviciosacademicos/funciones/phpmailer/class.phpmailer.php");
    require_once("../../serviciosacademicos/funciones/validaciones/validaciongenerica.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesSeguridad.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesMatematica.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/formulariobaseestudiante.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/securimage/securimage.php");
    require_once("correoactivacioncuenta.php");
    require_once("constantesactivacion.php");
    require_once("localization.php");
    $lang = "es-es";
    if(isset($_GET["lang"])&&$_GET["lang"]!=""){
        $lang = $_GET["lang"];
    }

    $formulario = new formulariobaseestudiante($sala, "form1", "post", "", "true");
    $formulario->rutaraiz = "../../serviciosacademicos/funciones/sala_genericas/";
    $objetobase = new BaseDeDatosGeneral($sala);

    $estudianteinscripcion = $objetobase->recuperar_datos_tabla("estudianteinscripciontemporal",
        "idestudianteinscripciontemporal", $_GET['id']);
    $horaactual = mktime();
    $horaregistro = $_GET['ta'];

    if (($horaactual - $horaregistro) > TIEMPOACTIVACION) {
        $mensaje = localize('Su tiempo para realizar la activacion de su cuenta expiro',$lang).",\\n ".
                localize('puede registrarse de nuevo para continuar',$lang);
        alerta_javascript($mensaje);
    } else {
        $tablaes = "estudianteinscripciontemporal";
        $condicion = " and tipodocumento='" . $estudianteinscripcion['tipodocumento'] . "'";
        if ($datosestudiantedocumento = $objetobase->recuperar_datos_tabla("estudiantedocumento",
            "numerodocumento", $estudianteinscripcion['documento' . $tablaes], $condicion,
            "", 0)) {
            $datosestudiantegeneral = $objetobase->recuperar_datos_tabla("estudiantegeneral",
                "idestudiantegeneral", $datosestudiantedocumento["idestudiantegeneral"], "");
            $mensaje = localize("Usted ya habia estado registrado en un programa de La Universidad El Bosque",$lang)
                    . " \\n ".localize("su correo inscrito actual es",$lang)." " .
                    $datosestudiantegeneral['emailestudiantegeneral'] .
                    " ".localize("con este puede recuperar su clave ingresandolo a continuacion",$lang);
            alerta_javascript($mensaje);
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=recuperarclave.php'>";
        } else {
            $tabla = "estudiantegeneral";
            $fila['idtrato'] = $estudianteinscripcion['idtrato'];
            $fila['idestadocivil'] = '1';
            $fila['tipodocumento'] = $estudianteinscripcion['tipodocumento'];
            $fila['numerodocumento'] = $estudianteinscripcion["documento" . $tablaes];
            $fila['expedidodocumento'] = "";
            $fila['nombrecortoestudiantegeneral'] = $estudianteinscripcion["documento" . $tablaes];
            $fila["nombresestudiantegeneral"] = $estudianteinscripcion["nombres" . $tablaes];
            $fila["apellidosestudiantegeneral"] = $estudianteinscripcion["apellidos" . $tablaes];
            $fila["fechanacimientoestudiantegeneral"] = $estudianteinscripcion["fechanacimiento" . $tablaes];
            $fila["codigogenero"] = $estudianteinscripcion["codigogenero"];
            $fila["direccionresidenciaestudiantegeneral"] = "";
            $fila["direccioncortaresidenciaestudiantegeneral"] = "";
            $fila["ciudadresidenciaestudiantegeneral"] = '359';
            $fila["telefonoresidenciaestudiantegeneral"] = $estudianteinscripcion["telefonoresidencia" . $tablaes];
            $fila["telefono2estudiantegeneral"] = $estudianteinscripcion["telefonooficina" . $tablaes];
            $fila["celularestudiantegeneral"] = $estudianteinscripcion["celular" . $tablaes];
            $fila["direccioncorrespondenciaestudiantegeneral"] = "";
            $fila["direccioncortacorrespondenciaestudiantegeneral"] = "";
            $fila["ciudadcorrespondenciaestudiantegeneral"] = "";
            $fila["telefonocorrespondenciaestudiantegeneral"] = "";
            $fila["emailestudiantegeneral"] = $estudianteinscripcion["correo" . $tablaes];
            $fila["fechacreacionestudiantegeneral"] = date("Y-m-d G:i:s", time());
            $fila["fechaactualizaciondatosestudiantegeneral"] = date("Y-m-d G:i:s", time());
            $fila["codigotipocliente"] = '0';
            $fila["numerolibretamilitar"] = '';
            $fila["numerodistritolibretamilitar"] = '';
            $fila["expedidalibretamilitar"] = '';
            $fila["idciudadnacimiento"] = '359';
            $fila["nombrecortoestudiantegeneral"] = '';
            $fila["casoemergenciallamarestudiantegeneral"] = '';
            $fila["telefono1casoemergenciallamarestudiantegeneral"] = '';
            $fila["telefono2casoemergenciallamarestudiantegeneral"] = '';
            $fila["idtipoestudiantefamilia"] = '';
            $fila["codigoestado"] = '100';
            $condicion = " numerodocumento='" . $fila['numerodocumento'] . "'" .
                    " and tipodocumento='" . $fila['tipodocumento'] . "'";
            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);

            $datosestudiantegeneral = $objetobase->recuperar_datos_tabla("estudiantegeneral", "1", "1", " and " . $condicion);
            unset($fila);
            $tabla = "estudiantedocumento";
            $fila["idestudiantegeneral"] = $datosestudiantegeneral["idestudiantegeneral"];
            $fila["tipodocumento"] = $datosestudiantegeneral["tipodocumento"];
            $fila["numerodocumento"] = $datosestudiantegeneral["numerodocumento"];
            $fila["expedidodocumento"] = $datosestudiantegeneral["expedidodocumento"];
            $fila["fechainicioestudiantedocumento"] = date("Y-m-d G:i:s", time());
            $fila["fechavencimientoestudiantedocumento"] = "2999-12-31";
            $condicion = " numerodocumento='" . $fila['numerodocumento'] . "'" .
                    " and tipodocumento='" . $fila['tipodocumento'] . "'";
            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);


            unset($fila);
            $tabla = "usuariopreinscripcion";
            $fila["idestudiantegeneral"] = $datosestudiantegeneral["idestudiantegeneral"];
            $fila["usuariopreinscripcion"] = $estudianteinscripcion["correo" . $tablaes];
            $fila["claveusuariopreinscripcion"] = $estudianteinscripcion["clave" . $tablaes];
            $fila["fechavencimientoclaveusuariopresinscripcion"] = "2999-12-31";
            $fila["fechavencimientousuariopresinscripcion"] = "2999-12-31";

            $condicion = " idestudiantegeneral='" . $fila['idestudiantegeneral']."'";
            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);

            unset($fila);
            $tabla = $tablaes;
            $fila["codigoestado"] = "100";
            $condicion = "id" . $tablaes . "=" . $_GET["id"];
            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);
            $mensaje = "Felicitaciones: Su cuenta para inscripcion esta activada, puede ingresar por la siguiente pagina";
            alerta_javascript($mensaje);
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE."?lang=".$lang . "'>";
        }
    }
?>
