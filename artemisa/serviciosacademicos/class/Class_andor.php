<?php
/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 04 de octubre de 2018.
 */
require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor./home/arizaandres/Documentos/proyectoSala/serviciosacademicos/class/Class_andor.php
 */

/**
 * Description of Class_andor
 *
 * @author stipmp
 */
require_once(PATH_ROOT.'/serviciosacademicos/consulta/interfacespeople/lib/nusoap.php');
require_once(PATH_ROOT.'/serviciosacademicos/funciones/clases/phpmailer/class.phpmailer.php');
//

class Class_andor {
    //put your code here
    var $Apellido = null;
    var $Nombres = null;
    var $Documento = null;
    var $NivelAcceso = null;
    var $NumeroTarjeta = null;
    var $EstaActivo = null;
    var $fecha_inicio = null;
    var $fecha_fin = null;
    var $url_andor = null;
    var $debug = null;
    var $Cardholder=array('Apellido'=> null,'Nombres'=>null,'Documento'=>null,'NivelAcceso'=>1,'NumeroTarjeta'=>null,'EstaActivo'=>true);

    function Class_andor($document) {
        $this->Documento = $document;
        $this->url_andor = 'http://192.168.0.13/carnetizacion/integracioncontinuumws.asmx?WSDL';
    }

     function getApellido() {
        return $this->Apellido;
    }

     function setApellido($Apellido) {
        $this->Apellido = $Apellido;
    }

     function getNombres() {
        return $this->Nombres;
    }

     function setNombres($Nombres) {
        $this->Nombres = $Nombres;
    }

     function getDocumento() {
        return $this->Documento;
    }

     function setDocumento($Documento) {
        $this->Documento = $Documento;
    }

     function getNivelAcceso() {
        return $this->NivelAcceso;
    }

     function setNivelAcceso($NivelAcceso) {
        $this->NivelAcceso = $NivelAcceso;
    }

     function getNumeroTarjeta() {
        return $this->NumeroTarjeta;
    }

    function setNumeroTarjeta($NumeroTarjeta) {
        $this->NumeroTarjeta = $NumeroTarjeta;
    }

    function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    function getFecha_fin() {
        return $this->fecha_fin;
    }

    function setEstaActivo($EstaActivo) {
        $this->EstaActivo = $EstaActivo;
    }

    function getEstaActivo() {
        return $this->EstaActivo;
    }

    function setFecha_fin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    function getCardholder() {
        return $this->Cardholder;
    }

    function setCardholder() {
        $this->Cardholder['Apellido']=  trim($this->Apellido);
        $this->Cardholder['Nombres'] = trim($this->Nombres);
        $this->Cardholder['Documento'] =  trim($this->Documento);
        $this->Cardholder['NivelAcceso'] = 1;
        $this->Cardholder['NumeroTarjeta'] =  trim($this->NumeroTarjeta);
        $this->Cardholder['EstaActivo'] =  trim($this->EstaActivo);
    }

   function table_cardholder($array=""){
        $html = "";
        if(is_array($array)){
            $html =  '<table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">';
            $html .= "<tr><th>Apellidos</th><th>Nombres</th><th>Numero de Tarjeta Registrada</th><th>Estado</th></tr>";
            foreach ($array as $datos){
                if ($datos['EstaActivo']=='true'){
                    $bgcolor = 'style="background-color: #8AB200;"';
                }else{
                    $bgcolor = 'style="background-color: #F38A01;"';
                }
                $html .= "<tr $bgcolor><td>".$datos['Apellido']."</td><td>".$datos['Nombres']."</td><td>".$datos['NumeroTarjeta']."</td>";
                if ($datos['EstaActivo']=='true'){
                    $html .= "<td onclick='javascript:estado(this);' style='cursor: pointer;'>Inactivar</td></tr>";
                }else{
                    $html .="<td onclick='javascript:estado(this);' style='cursor: pointer;'>Activar</td></tr>";
                }
            }
            $html .="</table>";
        }
        return $html;
   }


   function get_ws_result(){
       /* if($this->servidor_activo()){
            return false;
        }*/
        // Create the client instance

       //$this->servidor_acitivo($this->url_andor);
       //if($this->servidor_acitivo($this->url_andor)){
       //}else{
       //}
        $client = new SoapClient($this->url_andor, $this->Cardholder);
        // Check for an error
        $err = $client->getError();
        if ($err) {
        // Display the error
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        // At this point, you know the call that follows will fail
        }
        // Create the proxy
        $proxy = $client->getProxy();
        // Call the SOAP method
        $this->setCardholder();
        $result = $client->call('ConsultarCardholder', array('filtro' => $this->Cardholder));
        //echo "<pre>";
        //print_r($result);


        // Check for a fault
        if ($proxy->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $proxy->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                    foreach ($result as $arreglo){
                        $resutado= $arreglo['CardHolder'];
                        if(is_array($resutado[0])){
                            foreach ($resutado as $datos){
                                $resultado[]=array('Apellido'=>$datos['Apellido'],'Nombres'=>$datos['Nombres'],'Documento'=>$datos['Documento'],'NivelAcceso'=>$datos['NivelAcceso'],'NumeroTarjeta'=>$datos['NumeroTarjeta'],'EstaActivo'=>$datos['EstaActivo']);
                            }
                        }else{
                            $datos = $resutado;
                            $resultado[]=array('Apellido'=>$datos['Apellido'],'Nombres'=>$datos['Nombres'],'Documento'=>$datos['Documento'],'NivelAcceso'=>$datos['NivelAcceso'],'NumeroTarjeta'=>$datos['NumeroTarjeta'],'EstaActivo'=>$datos['EstaActivo']);
                        }
                    }
                    return $resultado;
            }
        }
    }

    function set_ws_result(){
       /* if($this->servidor_activo()){
            return false;
        }*/
        $client = new SoapClient($this->url_andor, $this->Cardholder);
        // Check for an error
        $err = $client->getError();
        if ($err) {
        // Display the error
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        // At this point, you know the call that follows will fail
        }
        // Create the proxy
        $proxy = $client->getProxy();
        // Call the SOAP method
         $this->setCardholder();
         $nextyear  = date('2099-12-31');
         if($this->debug==true){
             print_r($this->Cardholder);
         }
         //
        $result = $client->call('ActivarCardholder', array('cardholder' => $this->Cardholder,'fechaInicio'=>'20'.date('y-m-d'),'fechaFin'=>$nextyear));

        if($result['ActivarCardholderResult']['CodigoError']>0)
            echo $result['ActivarCardholderResult']['Descripcion'];
        // Check for a fault
        if ($proxy->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $proxy->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                    return $result;
            }
        }
    }

    function servidor_activo( $url = ""){
        $url = $this->url_andor;
        $a = explode('//',$url);
        $b = explode('/',$a[1]);
        $fin = explode(':',$b[0]);
        $port = '80';
        if(isset( $fin[1] ) )
        $port = $fin[1];
        $da = @fsockopen($fin[0], $port, $errno, $errstr, 5);
        if (!$da){
            $this->send_mail();
            return false;
        }else{
            return true;
        }
    }

    function send_mail(){
        $mail = new PHPMailer();
        $mail->From = "UNIVERSIDAD EL BOSQUE";
        $mail->FromName = "UNIVERSIDAD EL BOSQUE";
        $mail->ContentType = "text/html";
        $mail->Subject = "Alarma Sala-Servidor Andover";
        $mail->AddAddress("servidores@unbosque.edu.co","Alarma");
        $mensaje="Señor Administrador de Servicios IT.<br><br>"."<b>Se informa que el servidor de la direccion $this->url_andor.</b><BR><BR>".
        "No responde al servicio WS - Andover. Por favor Verificar, Gracias".
        "<br><br><br>Atentamente,<br><b>UNIVERSIDAD EL BOSQUE</b>";
        $mail->Body = $mensaje;
        $mail->Send();

//        $destinatario = "sotelojaime@unbosque.edu.co";
//        $asunto = "Este mensaje es de prueba";
//        $cuerpo = '
//        <html>
//        <head>
//        <title>Prueba de correo</title>
//        </head>
//        <body>
//        <h1>Hola amigos!</h1>
//        <p>
//        <b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje.
//        </p>
//        </body>
//        </html>
//        ';
//
//        //para el envío en formato HTML
//        $headers = "MIME-Version: 1.0\r\n";
//        $headers .= "Content-type: text/html; charset=utf-8\r\n";
//
//        //dirección del remitente
//        $headers .= "From: Miguel Angel Alvarez <pepito@desarrolloweb.com>\r\n";
//
//        //dirección de respuesta, si queremos que sea distinta que la del remitente
//        //$headers .= "Reply-To: mariano@desarrolloweb.com\r\n";
//
//        //ruta del mensaje desde origen a destino
//        //$headers .= "Return-path: holahola@desarrolloweb.com\r\n";
//
//        //direcciones que recibián copia
//        //$headers .= "Cc: maria@desarrolloweb.com\r\n";
//
//        //direcciones que recibirán copia oculta
//        //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n";
//
//        mail($destinatario,$asunto,$cuerpo,$headers);
    }

    function del_ws_result(){
       /* if($this->servidor_activo()){
            return false;
        }*/
        $this->EstaActivo = 'false';
         $client = new SoapClient($this->url_andor, $this->Cardholder);
        // Check for an error
        $err = $client->getError();
        if ($err) {
        // Display the error
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        // At this point, you know the call that follows will fail
        }
        // Create the proxy
        $proxy = $client->getProxy();
        // Call the SOAP method
         $this->setCardholder();

        $result = $client->call('InactivarCardHolder', array('cardHolder' => $this->Cardholder));
        // Check for a fault
        if ($proxy->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            // Check for errors
            $err = $proxy->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                    return $result;
            }
        }
    }
}

?>
