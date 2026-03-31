<?php  
//    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
//    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
require_once('./funcionesValidacion.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){     
    $token       = $_POST["token"];
    $usuario     = $_POST["idusuario"];
        
    @$id= $_POST["id"];
    $idActividadesBienestar= $_POST["idActividadesBienestar"];
    $nombre= $_POST["nombre"];
    $email= $_POST["email"];
    $codigoCarrera= $_POST["codigoCarrera"];
    $telefono= $_POST["telefono"];
    $audiencia= $_POST["audiencia"];
    $codigoEstado= $_POST["codigoEstado"];
    
    

                
    
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
       
        if (!$mail->Send()) {
            echo "El mensaje no pudo ser enviado";
            echo "Mailer Error: " . $mail->ErrorInfo;
            //exit();
        } 
        return true;
    } else {
        return false;
    }
}
    
    
    switch ($_POST["action"]){
        case 'Consultar':{
//            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once('RegistroActividadesBienestar_Class.php');
                
                $Lista = new RegistroActividadesBienestar($db,$usuario);
                
                $json['programas'] = $Lista->ListarRegistroActividadesBienestar($id,$idActividadesBienestar);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA***";
//                echo json_encode($json);
//                exit;
//            }
        }break;
        case 'Insercion':{
//            if(validarToken($usuario,$token)){
                
                require_once(realpath(dirname(__FILE__)).'/../../funciones/phpmailer/class.phpmailer.php');
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                
                $sqlcarrera = "SELECT nombrecarrera FROM carrera WHERE codigocarrera=".$codigoCarrera;
                $fSQL = mysql_query($sqlcarrera);
                $cSQL = mysql_fetch_assoc($fSQL);
                
                include_once('ActividadesBienestar_Class.php');
                $Traiga = new ActividadesBienestar($db,$usuario);
                $json['Actividad'] = $Traiga->TraigaActividadesBienestar($idActividadesBienestar);
                
                $destinatario =  $json['Actividad'][0]["emailResponsable"];
                $nombredestinatario =  $json['Actividad'][0]["emailResponsable"];
                $trato = "<B>UNIVERSIDAD EL BOSQUE<BR>REGISTRO DE USUARIO</B><BR>Cordial Saludo ";
                $mensaje = "<br><br>
                       Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la informacion de un nuevo registro de usuario
                        <br><br>Nombre: " . $nombre .
                        "<br>E-mail: " . $email .
                        "<br>Carrera: " . $cSQL['nombrecarrera'] .
                        "<br>Telefono: " . $telefono .
                        "<br>Audiencia: " . $audiencia .
                        "<br><br><br><br><br>";

                $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
                $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
                $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE REGISTRO NUEVO USUARIO EN ACTIVIDAD BIENESTAR";
                $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
                
                ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
                
                include_once('RegistroActividadesBienestar_Class.php');
                $Inserta = new RegistroActividadesBienestar($db,$usuario);
                
                $json['Eventos'] = $Inserta->InsertarRegistroActividadesBienestar($idActividadesBienestar,$nombre,$email,$codigoCarrera,$telefono,$audiencia,$codigoEstado);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;    
        case 'Actualizacion':{
//            if(validarToken($usuario,$token)){
                
                require_once(realpath(dirname(__FILE__)).'/../../funciones/phpmailer/class.phpmailer.php');
                                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                
                $sqlcarrera = "SELECT nombrecarrera FROM carrera WHERE codigocarrera=".$codigoCarrera;
                $fSQL = mysql_query($sqlcarrera);
                $cSQL = mysql_fetch_assoc($fSQL);
                
                include_once('ActividadesBienestar_Class.php');
                $Traiga = new ActividadesBienestar($db,$usuario);
                $json['Actividad'] = $Traiga->TraigaActividadesBienestar($idActividadesBienestar);
                $destinatario = $json['Actividad'][0]["emailResponsable"];
                $nombredestinatario = $json['Actividad'][0]["emailResponsable"];
                $trato = "<B>UNIVERSIDAD EL BOSQUE<BR>MODIFICACION USUARIO</B><BR>Cordial Saludo ";
                $mensaje = "<br><br>
                       Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la informacion de una actualizacion de registro
                        <br><br>Nombre: " . $nombre .
                        "<br>E-mail: " . $email .
                        "<br>Carrera: " . $cSQL['nombrecarrera'] .
                        "<br>Telefono: " . $telefono .
                        "<br>Audiencia: " . $audiencia .
                        "<br><br><br><br><br>";

                $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
                $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
                $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE MODIFICACION USUARIO EN ACTIVIDAD BIENESTAR";
                $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
                
                ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
                
                include_once('RegistroActividadesBienestar_Class.php');                
                $Actualiza = new RegistroActividadesBienestar($db,$usuario);
                
                $json['Eventos'] = $Actualiza->ActualizarRegistroActividadesBienestar($nombre,$email,$codigoCarrera,$telefono,$audiencia,$codigoEstado,$id,$idActividadesBienestar);
                $json["result"] = "OK";
                $json["codigoresultado"] = 0;
//            }else{
//                $json["result"]          ="ERROR";
//                $json["codigoresultado"] =1;
//                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
//                echo json_encode($json);
//                exit;
//            }
        }break;    
    }//switch
}//if
    echo json_encode($json);
?>

