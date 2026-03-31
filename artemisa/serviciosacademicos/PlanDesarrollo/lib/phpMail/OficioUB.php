<?php
/**
 * OficioUB.php
 * Clase para manejo de Oficios en la Universidad el Bosque:
 * version 1.0
 **/


class OficioUB {
	/**
         * 2015-04-08 Jose Jhefferson Mora Llanos Metodo para el envio de correos electronicos
         * @param $Mailer string tipo de envio
         * @param $Host string direccion del servidor
         * @param $SMTPAuth boolean true para autintificar o false para anonimo
         * @param $Username string usuario de la cuenta para autentificar
         * @param $Password string contrase�a del usuario del coreo electronico
         * @param $From string correo electronico origen
         * @param $FromName string nombre propetario del origen del correo
         * @param $Timeout int recomendado 500
         * @param $IsHTML boolean si el formato del body es en html true si es en texto plano false
         * @param $Subject string asunto del correo
         * @param $Body string cuerpo del mensaje
         * @param $AddAddress array formato de recepcion array( 0 => array ( "mail" => "c.suarezg84@gmail.com", "nombre" => "Carlos Suarez" )  )
         * @param $AddReplyTo array formato de recepcion array( 0 => array (  "mail" => "c.suarezg84@gmail.com",  "nombre" => "Carlos Suarez" ) )
         * @param $AddAttachment array formato de recepcion array( 0 => "URL LOCAL" )
         * @param $AltBody string cuerpo del mensaje alternativo
         * @return OK que el proceso se llevo finalizado || fase que no se puedo enviar el correo electronico
         */
       function envioCorreoElectronico($Mailer, $IsSMTP, $Host, $SMTPAuth, $From, $FromName, $Timeout, $IsHTML, $SMTPDebug, $Subject, $Body, $AddAddress, $AddReplyTo=null, $AddAttachment=null, $AltBody="", $AddCc=null, $AddBCc=null){		
            //Instanciamos la clase phpMailer
            $mail = new PHPMailer();
			$mail->Mailer = $Mailer;
			$mail->IsSMTP($IsSMTP);
            $mail->Host = $Host;
            $mail->SMTPAuth = $SMTPAuth;
            $mail->From = $From;
            $To = "";
			$mail->To = $To;
            $mail->FromName = $FromName;
            $mail->Timeout = $Timeout;
            $mail->IsHTML($IsHTML);
			$mail->SMTPDebug  = $SMTPDebug;
            $mail->Subject = $Subject;
			
			
			
			//recuperamos a quien se le envia el correo electronico
            foreach($AddAddress as $item => $valor){
                $mail->AddAddress($AddAddress[$item]["mail"], $AddAddress[$item]["nombre"]);
            }

            //preguntamos si por defectos es null que significa que no se va copiar a otro destino
            if($AddReplyTo != null){
                foreach($AddReplyTo as $item => $valor){
                    $mail->AddReplyTo($AddReplyTo[$item]["mail"], $AddReplyTo[$item]["nombre"]);
                }
            }

            //preguntamos si por defectos es null que significa que no se va adjuntar ningun archivo
            if($AddAttachment != null){
                foreach($AddAttachment as $item => $valor){
                    $mail->AddAttachment($AddAttachment[$item]);
                }
            }

            //preguntamos si por defectos es null que significa que no se va adjuntar ningun archivo
            if($AddCc != null){
                foreach($AddCc as $item => $valor){
                    $mail->AddCC($AddCc[$item]["mail"],$AddCc[$item]["nombre"]);
                }
            }

            //preguntamos si por defectos es null que significa que no se va adjuntar ningun archivo
            if($AddBCc != null){
                foreach($AddBCc as $item => $valor){
                    $mail->AddBCC($AddBCc[$item]);
                }
            }

            $mail->Body = $Body;

            //sin texto alternativo que va siempre en formato plano
            if($AltBody != null){
                $mail->AltBody=$AltBody;
            }
			
            //Solo debe hacer el envio si hay datos
            
                if(!$mail->Send())
                {
                    return false;
                }
                else
                {
                    return true;
					$mail->ClearAddresses( );
                }
            
        }
}
?>