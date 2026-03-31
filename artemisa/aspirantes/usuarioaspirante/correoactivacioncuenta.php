<?php
require_once("localization.php");
function ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato) {
    if (is_array($array_datos_correspondencia)) {
        $mail = new PHPMailer();
        $mail->From = $array_datos_correspondencia['correoorigencorrespondencia'];
        $mail->FromName = $array_datos_correspondencia['nombreorigencorrespondencia'];
        $mail->ContentType = "text/html";
        $mail->Subject = $array_datos_correspondencia['asuntocorrespondencia'];
        //aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
        $encabezado = $trato . ":" . $nombredestinatario;
        $cuerpo = $encabezado . "<br><br>" . $array_datos_correspondencia['encabezamientocorrespondencia'];
        $mail->Body = $cuerpo;
        $mail->AddAddress($destinatario, $nombredestinatario);

        if (isset($array_datos_correspondencia['detalle']) && is_array($array_datos_correspondencia['detalle'])) {
            foreach ($array_datos_correspondencia['detalle'] as $llave => $url) {
                if (!$mail->AddAttachment($url, $llave)) {
                    alerta_javascript("Error no lo mando AddAttachment($url,$llave)");
                }
            }
        }
       if (!$mail->Send()) {
           return true;
       } else {
            if (isset($depurar) && !empty($depurar) && $depurar== true) {
                echo "Mensaje Enviado";
                echo "<br>";
                echo "<pre>";
                print_r($mail);
                echo "</pre>";
            }
            return true;
        }
    } else {
        return false;
    }
}//function

function enviaCorreoActivacion($objetobase, $tipodocumento, $documento, $clave,$lang="es-es") {
    $condicion = " and tipodocumento='" . $tipodocumento . "'" .
            " and documentoestudianteinscripciontemporal='" . $documento . "'";
    $datosestudiante = $objetobase->recuperar_datos_tabla("estudianteinscripciontemporal ei", "1", "1", $condicion, "");
    $tiempoactivacion = 86400;
    $mktimeactiva = mktime();
    $urlactivacion = ENLACEACTIVACION .
            "?ta=" . $mktimeactiva .
            "&id=" . $datosestudiante["idestudianteinscripciontemporal"] .
            "&correo=" . $datosestudiante["correoestudianteinscripciontemporal"]."&lang=".$lang;

    $destinatario = $datosestudiante["correoestudianteinscripciontemporal"];
    $nombredestinatario = $datosestudiante["nombresestudianteinscripciontemporal"] . " " . $datosestudiante["apellidosestudianteinscripciontemporal"];
    $trato = "<B>".localize("UNIVERSIDAD EL BOSQUE",$lang)." <BR>".localize("ACTIVACION USUARIO ASPIRANTE",$lang)." </B><BR>".localize("Cordial Saludo",$lang)." ";
    $mensaje = "<br><br>" .
            localize("Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la información de su cuenta para continuar su inscripcion",$lang) .
            " <br><br>".localize("Nombre",$lang).": " . $nombredestinatario .
            "<br>".localize("Correo",$lang).": " . $datosestudiante["correoestudianteinscripciontemporal"] .
            "<br>".localize("Clave",$lang).": " . $clave .
            "<br><br>".localize("Para continuar con su proceso de inscripción de click",$lang)." " .
            "<a href='" . $urlactivacion . "' target='new'>".localize("aqui",$lang)."</a>" .
            " ".localize("o copie el siguiente enlace en su navegador",$lang)." <br><br><br>" . $urlactivacion;

    $array_datos_correspondencia['correoorigencorrespondencia'] = localize("UNIVERSIDAD EL BOSQUE",$lang);
    $array_datos_correspondencia['nombreorigencorrespondencia'] = localize("UNIVERSIDAD EL BOSQUE",$lang);
    $array_datos_correspondencia['asuntocorrespondencia'] = localize("UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE",$lang);
    $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
    ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
}

function enviaCorreoRecuperacion($objetobase, $correo,$lang="es-es") {
    $condicion = " and eg.emailestudiantegeneral='" . $correo . "'";
    $tablas = "estudiantegeneral eg";
    if ($datosestudiante = $objetobase->recuperar_datos_tabla($tablas, "1", "1", $condicion, "",0)) {
        $tiempoactivacion = 86400;
        $mktimeactiva = mktime();
        $urlactivacion = ENLACERECUPERACION .
                "?ta=" . $mktimeactiva .
                "&id=" . $datosestudiante["idestudiantegeneral"] .
                "&correo=" . $datosestudiante["emailestudiantegeneral"]."&lang=".$lang;

        $destinatario = $datosestudiante["emailestudiantegeneral"];
        $nombredestinatario = $datosestudiante["nombresestudiantegeneral"] . " " . $datosestudiante["apellidosestudiantegeneral"];
        $trato = "<B>".localize("UNIVERSIDAD EL BOSQUE",$lang)." <BR>".localize("ACTIVACION USUARIO ASPIRANTE",$lang)." </B><BR>".localize("Cordial Saludo",$lang)." ";
        $mensaje = "<br><br>" .
            localize("Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la información de su cuenta para continuar su inscripcion",$lang) .
                "<br><br>".localize("Nombre",$lang).": " . $nombredestinatario .
                "<br>".localize("Correo",$lang).": " . $datosestudiante["emailestudiantegeneral"] .
                "<br><br>".localize("Para asignar una nueva clave siga el enlace",$lang)." " .
                "<a href='" . $urlactivacion . "' target='new'>".localize("aqui",$lang)."</a>" .
                " ".localize("o copie el siguiente enlace en su navegador",$lang)." <br><br><br>" . $urlactivacion;

        $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE RECUPERACION USUARIO ASPIRANTE";
        $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
        ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
                        $mensaje = localize("Revise su correo",$lang)." " . $_POST['correo'] .
                        " ".localize("para continuar con la recuperacion de su contraseña",$lang);

                alerta_javascript($mensaje);
    }
    else{
        alerta_javascript(localize("No se encuentra este correo registrado",$lang));
    }
}
?>