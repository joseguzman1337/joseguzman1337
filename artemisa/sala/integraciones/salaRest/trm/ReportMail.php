<?php
class ReportMail{
    public function reportarCaidaServicio($mensajeContenido,$emailDe,$emailPara,$emailCopiaOculta){
        require_once('../../../../serviciosacademicos/consulta/facultades/creacionestudiante/phpmailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $body = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="format-detection" content="telephone=no" />
            <link rel="stylesheet" href="../../../assets/css/bootstrap.css" />
        
            <style type="text/css">
                @media only screen and (max-width: 500px){
                    .footer_mailing_UEB{
                        width: 100%;
                        margin-bottom: 20px;
                    }
                    .columna{
                        width:100% !important;
                        margin: 0 auto 10px !important;
                        border: none !important;
                        text-align: center !important;
                        float: none !important;
                        align-content: center;
                    }
                }
            </style>
        </head>
        <body>';
        $body.= $mensajeContenido.'
        </body>
        </html>';
        $mail->SetFrom($emailDe, 'Universidad El Bosque');
        $mail->Subject = "Servicio TRM Caido Sala";
        $mail->MsgHTML($body);
        $mail->AddAddress($emailPara);
        $mail->addBCC($emailCopiaOculta);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        }
        return true;
    }
}

