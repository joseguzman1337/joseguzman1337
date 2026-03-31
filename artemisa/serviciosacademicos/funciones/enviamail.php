<?php

function enviamailfacultad($mailusuario, $nombrecarrera, $nombre, $documento) { // func
    mail($mailusuario, "Preinscripción Estudiante", "Informe de Preinscripción estudiante:\nNombre: $nombre\nDocumento: $documento\nPrograma: $nombrecarrera", "FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n");
}

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

function enviaCorreoFacultad($objetobase, $codigoestudiante) {
    $condicion = " and e.idestudiantegeneral=eg.idestudiantegeneral";
    $datosestudiante = $objetobase->recuperar_datos_tabla("estudiante e,estudiantegeneral eg", "e.codigoestudiante", $codigoestudiante, $condicion, "",1);
    $condicion = " and ca.codigocarrera=c.codigocarrera "
    ." and c.codigotipousuario='600'";
         /*   echo "datosestudiante<pre>";
        print_r($datosestudiante);
        echo "</pre>";*/
    if ($datoscarreraemail = $objetobase->recuperar_datos_tabla("carrera ca,carreraemail c", "c.codigocarrera", $datosestudiante["codigocarrera"], $condicion, "")) {
       /* echo "datosestudiante<pre>";
        print_r($datosestudiante);
        echo "</pre>";
        echo "datoscarreraemail<pre>";
        print_r($datoscarreraemail);
        echo "</pre>";*/

        $destinatario = $datoscarreraemail["emailfacultadcarreraemail"];
        $nombredestinatario = "<br>PROGRAMA DE ".$datoscarreraemail["nombrecarrera"];
        $trato = "<B>UNIVERSIDAD EL BOSQUE <BR>INSCRIPCION DE NUEVO ESTUDIANTE</B><BR>Cordial Saludo ";
        $mensaje = "<br><br>" .
                "Informe de inscripción estudiante:<BR>" .
                "<br>Nombre:" . $datosestudiante["nombresestudiantegeneral"] . " " . $datosestudiante["apellidosestudiantegeneral"] .
                "<br>Documento:" . $datosestudiante["numerodocumento"] .
                "<br>Programa:" . $datoscarreraemail["nombrecarrera"];

        $array_datos_correspondencia['correoorigencorrespondencia'] = "ayuda@unbosque.edu.co";
        $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE INSCRIPCION DE NUEVO ESTUDIANTE";
        $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;

        ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
        ConstruirCorreo($array_datos_correspondencia, "lopezjavier@unbosque.edu.co", $nombredestinatario, $trato);

    }
         //   exit();
}

//$direccionemail = 'virtualeme@hotmail.com'; 
//mail($direccionemail,"Usuario y Contraseña para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\nAdjunto al presente usuario y contraseña para el proceso de inscripción.\n\nusuario:".$usuario."\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n"); 
//enviamailfacultad('garciaemerson@unbosque.edu.co','prueba','eme','89898');
?>