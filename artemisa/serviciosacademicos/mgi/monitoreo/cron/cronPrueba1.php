<?php #!/usr/local/bin/php
// this starts the session 
 session_start(); 
$_SESSION['MM_Username'] = 'admintecnologia';

    include("../../templates/template.php");
    $db = writeHeaderSearchs();
    $apiAlertas = new API_Alertas();

                $mensaje = "Todo bien, el cron funciona ".date('l jS \of F Y h:i:s A');
                $asunto = "cron de prueba ".date('l jS \of F Y h:i:s A');
                $destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
                $apiAlertas->enviarAlerta($destinatario,$asunto,$mensaje);
?>
