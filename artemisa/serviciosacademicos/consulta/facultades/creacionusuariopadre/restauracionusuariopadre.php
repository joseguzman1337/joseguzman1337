<?php
require_once('../../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");

function CorreoRecuperacion($correo) {
    global $db;
    $query_emailconsulta="SELECT * FROM usuariopadre
    where emailusuariopadre='$correo'
    and codigoestado like '1%'";
    $emailconsulta= $db->Execute($query_emailconsulta);
    $totalRows_emailconsulta = $emailconsulta->RecordCount();
    $row_emailconsulta= $emailconsulta->FetchRow();    
    
    if($totalRows_emailconsulta !=0){
    
        /* echo "<pre>";
          print_r($datosestudiante);
          echo "</pre>";*/
          //exit();
        //$urldesarrollo="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php";
        $urldesarrollo="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php";
        $tiempoactivacion = 86400;
        $mktimeactiva = mktime();
        $urlactivacion = $urldesarrollo.
                "?ta=" . $mktimeactiva .
                "&id=" . $row_emailconsulta["usuario"] .
                "&correo=" . $row_emailconsulta["emailusuariopadre"];
        
        $destinatario = $row_emailconsulta["emailusuariopadre"];
        $nombredestinatario = strtoupper($row_emailconsulta["nombresusuariopadre"]) . " " . strtoupper($row_emailconsulta["apellidosusuariopadre"]);

        //echo $urlactivacion."<br>".$destinatario."<br>".$nombredestinatario;
        $trato = "<B>UNIVERSIDAD EL BOSQUE <BR>CAMBIO CLAVE DE USUARIO </B><BR>Cordial Saludo ";
        $mensaje = "<br><br>" .
                "La siguiente es la información de su cuenta para continuar su con la recuperacion de su clave" .
                "<br><br>Nombre: " . $nombredestinatario .
                "<br>Correo: " . $destinatario .
                "<br><br>Para asignar una nueva clave siga el enlace " .
                "<a href='" . $urlactivacion . "' target='new'>aqui</a>" .
                " o copie el siguiente enlace en su navegador <br><br><br>" . $urlactivacion;        
        $cuerpo=$trato.$mensaje;

        $mail = new PHPMailer();
            $mail->From = "UNBOSQUE UNIVERSIDAD EL BOSQUE";
            $mail->FromName = "UNBOSQUE UNIVERSIDAD EL BOSQUE";
            $mail->ContentType = "text/html";
            $mail->Subject = "RECUPERACION Y CAMBIO DE CLAVE";
            $mail->AddAddress($destinatario,$nombredestinatario);
            $mail->Body = $cuerpo;
            //$mail->Send();

                if(!$mail->Send())
                {
                    echo "El mensaje no pudo ser enviado";
                    echo "Mailer Error: " . $mail->ErrorInfo;
                //exit();
		}
                else
                {
                   echo "<script language='javascript'>
                    alert('Revise su correo " . $correo .
                        " para continuar con la recuperacion de su contraseña');
                    </script>";
                }
        
    }
    else{
        echo "<script language='javascript'>
            alert('No se encuentra este correo registrado');
            </script>";
    }
}

?>
