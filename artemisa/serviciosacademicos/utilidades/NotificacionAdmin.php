<?php

function EnviarCorreo($to, $asunto, $mensaje, $reportSend = false){
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        
        $cabeceras .= 'From: Universidad El Bosque - Ingreso sistema' . "\r\n";
          // Enviamos el mensaje
          if (mail($to, $asunto, $mensaje, $cabeceras)) {
                $aviso = "Su mensaje fue enviado.";
                $succed = true;
          } else {
                $aviso = "Error de envío.";
                $succed = false;
          }
          if($reportSend){
            return array("mensaje" =>$aviso, "succes"=>$succed); 
          } else {
            return $aviso;
          }
    }//public function EnviarCorreo


?>