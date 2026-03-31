<?php

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
        //$cuerpo2="en ".$array_datos_correo['direccionsitioadmision'].", teléfono: ".$array_datos_correo['telefonositioadmision']." el día ".$array_datos_correo['dia']." de ".$array_datos_correo['mesTexto']." del año ".$array_datos_correo['ano'].' a las '.substr($array_datos_correo['hora'],0,5)." en el salón ".$array_datos_correo['codigosalon'].".<br>";
        //$cuerpo3="<br><br>".$this->$array_datos_correo['firmacorrespondencia'];
        $mail->Body = $cuerpo;
        //echo $cuerpo.$cuerpo2.$cuerpo3;
        $mail->AddAddress($destinatario, $nombredestinatario);
        //$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
        //$mail->AddAddress("dianarojas@sistemasunbosque.edu.co","Prueba");

        if (is_array($array_datos_correspondencia['detalle'])) {
            foreach ($array_datos_correspondencia['detalle'] as $llave => $url) {
                //$ruta="tmp/".$url;
                //echo "<br>entro el atqachment AddAttachment($url,$llave);<br>";
                if (!$mail->AddAttachment($url, $llave)) {
                    alerta_javascript("Error no lo mando AddAttachment($url,$llave)");
                }
            }
        }
        if (!$mail->Send()) {
            echo "El mensaje no pudo ser enviado";
            echo "Mailer Error: " . $mail->ErrorInfo;
            //exit();
        } else {
            if ($depurar == true) {
                echo "Mensaje Enviado";
                echo "<br>";
                echo "<pre>";
                print_r($mail);
                echo "</pre>";
            }
        }
        return true;
    } else {
        return false;
    }
}

function enviaCorreoActivacion($objetobase, $tipodocumento, $documento, $clave) {
    $condicion = " and tipodocumento='" . $tipodocumento . "'" .
            " and documentoestudianteinscripciontemporal='" . $documento . "'";
    $datosestudiante = $objetobase->recuperar_datos_tabla("estudianteinscripciontemporal ei", "1", "1", $condicion, "");
    /* echo "<pre>";
      print_r($datosestudiante);
      echo "</pre>";
      exit(); */
    $tiempoactivacion = 86400;
    $mktimeactiva = mktime();
    $urlactivacion = ENLACEACTIVACION .
            "?ta=" . $mktimeactiva .
            "&id=" . $datosestudiante["idestudianteinscripciontemporal"] .
            "&correo=" . $datosestudiante["correoestudianteinscripciontemporal"];

    $destinatario = $datosestudiante["correoestudianteinscripciontemporal"];
    $nombredestinatario = $datosestudiante["nombresestudianteinscripciontemporal"] . " " . $datosestudiante["apellidosestudianteinscripciontemporal"];
    $trato = "<B>UNIVERSIDAD EL BOSQUE <BR>ACTIVACION USUARIO ASPIRANTE </B><BR>Cordial Saludo ";
    $mensaje = "<br><br>" .
            "Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la información de su cuenta para continuar su inscripcion " .
            "<br><br>Nombre: " . $nombredestinatario .
            "<br>Correo: " . $datosestudiante["correoestudianteinscripciontemporal"] .
            "<br>Clave: " . $clave .
            "<br><br>Para continuar con su proceso de inscripción de click " .
            "<a href='" . $urlactivacion . "' target='new'>aqui</a>" .
            " o copie el siguiente enlace en su navegador <br><br><br>" . $urlactivacion;

    $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
    $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
    $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE";
    $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
    ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
}

function enviaCorreoRecuperacion($objetobase, $correo) {
    $condicion = " and eg.emailestudiantegeneral='" . $correo . "'";
    $tablas = "estudiantegeneral eg";
    if ($datosestudiante = $objetobase->recuperar_datos_tabla($tablas, "1", "1", $condicion, "",0)) {
        /* echo "<pre>";
          print_r($datosestudiante);
          echo "</pre>";*/
          //exit();
        $tiempoactivacion = 86400;
        $mktimeactiva = mktime();
        $urlactivacion = ENLACERECUPERACION .
                "?ta=" . $mktimeactiva .
                "&id=" . $datosestudiante["idestudiantegeneral"] .
                "&correo=" . $datosestudiante["emailestudiantegeneral"];

        $destinatario = $datosestudiante["emailestudiantegeneral"];
        $nombredestinatario = $datosestudiante["nombresestudiantegeneral"] . " " . $datosestudiante["apellidosestudiantegeneral"];
        $trato = "<B>UNIVERSIDAD EL BOSQUE <BR>ACTIVACION USUARIO ASPIRANTE </B><BR>Cordial Saludo ";
        $mensaje = "<br><br>" .
                "Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la información de su cuenta para continuar su inscripcion " .
                "<br><br>Nombre: " . $nombredestinatario .
                "<br>Correo: " . $datosestudiante["emailestudiantegeneral"] .
                "<br><br>Para asignar una nueva clave siga el enlace " .
                "<a href='" . $urlactivacion . "' target='new'>aqui</a>" .
                " o copie el siguiente enlace en su navegador <br><br><br>" . $urlactivacion;

        $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE RECUPERACION USUARIO ASPIRANTE";
        $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
        ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
                        $mensaje = "Revise su correo " . $_POST['correo'] .
                        " para continuar con la recuperacion de su contraseña";

                alerta_javascript($mensaje);
    }
    else{
        alerta_javascript("No se encuentra este correo registrado");
    }
}
?>