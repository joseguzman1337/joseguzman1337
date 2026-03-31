<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan los archivos de configuracion y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Julio 19, 2018
 */
require(realpath(dirname(__FILE__) . "/../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas") {
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once (PATH_ROOT . '/kint/Kint.class.php');
}
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace limpieza de codigo y se coloca en cada funcion de envio de notificacion
 * la logica para que no muestre como un array el contenido del mensaje
 * @since Julio 23, 2018
 */
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se quita una funcion sobrante y se parametriza para que el envio de las notificacones
 * a los dispositivos sean por paquetes de 100 (iOS) y de 1000 (Android).
 * la logica para que no muestre como un array el contenido del mensaje
 * @since Septiembre 25, 2018
 */
require (PATH_SITE . '/lib/Factory.php');

if(!defined("DISPOSITIVOS_X_ENVIO")){
    define("DISPOSITIVOS_X_ENVIO", 500);
}

$db = Factory::createDbo();

$fechahora = date("Y-m-d H:i:s");
$fecha = date("Y-m-d");

/**
 * Envia un determinado mensaje a un lote de usarios al sistema FireBase encargado
 * de la orquestacion de los push a los dispositivos moviles
 * @author Gabriel Vega <vegagabriel@unbosque.edu.co>
 * @access public
 * @param array $data lista de mensajes a enviar
 * @param array $target lote de dispositivos receptores
 * @return void
 */
function sendMessage($data, $target) {
    $cuenta = count($data);
    //Este for es por si hay mas de una notificacion por dia y asi mismo estas queden separadas y sean enviadas en un solo mensaje al dispoditivo
    $a = '';
    for ($i = 0; $i <= $cuenta - 1; $i++) {
        $a .= $data[$i] . "    ";
    }
    $mensaje = substr($a, 0, -4);

    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    $server_key = 'AIzaSyCLADRCTlG6OIs5X2SbBRHFkm3_ldYV30s'; //**************
    //$server_key = 'AAAAa13-N5c:APA91bED9A3gA4KgiRvAksia_qGuQvIW6yb9q6SHAGbpXk0mP0xGz8vRDxcqnXDtEVpVcMZCc-3unKPTNdcqsDmdqhu5NLAkqP7X6B3MpmFhqdUEpAlSBt4geWCUaJ-_Ae_za5v6s3yj';//**************

    $fields = array(
        'registration_ids' => $target,
        'priority' => 10,
        'notification' => array('title' => '', 'body' => $mensaje, 'sound' => 'elbosque.mp3', 'image' => 'Notification Image'),
    );
    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key=' . $server_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    //$result = true;
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    //print_r($result);
    curl_close($ch);
    return $result;
}

/**
 * Cuenta y retorna los dispositivos registrados activos en el sistema para una
 * o todas las plataformas disponibles (android, iOS)
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param string $tipoPlataforma el tipo de plataforma que se va a consultar (android, iOS)
 * @return integer
 */
function getCantidadDispositivos($tipoPlataforma = null){
    $db = Factory::createDbo();
    $SQLIdUsuarioAndroid = 'SELECT COUNT(1) as cantidad FROM Token WHERE CodigoEstado="100" ';
    
    if(!empty($tipoPlataforma)){
        $SQLIdUsuarioAndroid .= ' AND plataforma="'.$tipoPlataforma.'"';
    }else{
        $SQLIdUsuarioAndroid .= ' AND Plataforma IN ("android", "iOS")';
        
    }
    
    $datos = $db->Execute($SQLIdUsuarioAndroid);
    $d = $datos->FetchRow();
    return($d['cantidad']);
}

/**
 * Valida y retorna el limite valido para la busqueda de dispositivos a los que
 * se va a enviar un mensaje basado en un parametro de inicio la cantidad total y
 * el numero de dispositivos por envio
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param integer $cantidad Cantidad total de dispositivos activos registrados en el sistema
 * @param integer $inicio el numero inicio de registros desde el que se va a consultar
 * @return string|false
 */
function getLimit ($cantidad, $inicio){
    //d($cantidad);
    //d($inicio);
    $totalPags = ceil($cantidad/DISPOSITIVOS_X_ENVIO);
    //echo $totalPags."\n";
    //echo ($cantidad)."\n";
    if($inicio < $cantidad){
        return " LIMIT ".$inicio.", ".DISPOSITIVOS_X_ENVIO;
    }else{
        return false;
    }    
}

/**
 * funcion encargada de invocar recursivamente el llamado al hilo de envio
 * de notificaciones una vez se ha terminado de enviar el lote acutal
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param integer $inicio el numero inicio de registros desde el que se va a consultar
 * @param integer $idNotificacion el id de la notificacion que se esta enviando
 * @return void
 */
function invocarNuevoHiloRecursivo($inicio=0,$idNotificacion=null){
    //d($inicio);
    //d($idNotificacion);
    $complemento = "";
    if(!empty($idNotificacion)){
        $complemento .= "&idNotificacion=".$idNotificacion; 
    }
    $url = HTTP_ROOT."/serviciosacademicos/utilidades/api/CronNotificacionesApp_Android_iOS.php?inicio=".$inicio.$complemento;
    //sleep(5);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch); 
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    echo $url."\n";
    print_r($result);
    die();exit();
}

/**
 * funcion encargada escribir un archivo de log por cada lote de dispositivos al 
 * que se envía un determinado mensaje
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param string $log detalle de log que se esta guardando
 * @param integer $inicio el numero inicio de lote que se esta enviando
 * @param integer $idNotificacion el id de la notificacion que se esta enviando
 * @return void
 */
function escribirLog($log, $inicio=0,$idNotificacion){
    $nombre_archivo = PATH_ROOT."/log/testCron_".$idNotificacion."_".$inicio.".txt"; 
    echo $log."\n";
    if($archivo = fopen($nombre_archivo, "a")){
        fwrite($archivo, $log. "\n"); 
        fclose($archivo);
    }
}

/**
 * funcion encargada actualizar en base de datos el log de envio de notificiaciones 
 * a usuarios
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @access public
 * @param array $dataUsuario lote de dispositivos de usuarios a los que se envia el mensaje
 * @param string $estado estado de log que se registrará en base de datos
 * @param integer $notiApp id de la notificacion que se esta enviando
 * @param string $fechahora fecha y hora del envío
 * @return void
 */
function actualizarEstadoEnvio($dataUsuario, $estado, $notiApp, $fechahora){
    $db = Factory::createDbo();
    $LogEnvioNotificacion = "INSERT INTO LogEnvioNotificacion (idNotificacion,idUsuario,plataforma,estado,fechaHoraEnvio) VALUES ";
    $insertLog = array();
    foreach($dataUsuario as $usuarioDisp){
        switch($usuarioDisp['plataforma']){
            case "android":
                $insertLog[] = " ('" . $notiApp . "','" . $usuarioDisp['idUsuario'] . "','android','".$estado."','$fechahora')";
                break;
            case "iOS":
                $insertLog[] = " ('" . $notiApp . "','" . $usuarioDisp['idUsuario'] . "','iOS','".$estado."','$fechahora')";
                break;
        }
    }
    $LogEnvioNotificacion = $LogEnvioNotificacion.implode(', ',$insertLog);
    $db->Execute($LogEnvioNotificacion);
}

$inicio = empty($_REQUEST['inicio'])?0:$_REQUEST['inicio'];
$idNotificacion = empty($_REQUEST['idNotificacion'])?null:$_REQUEST['idNotificacion'];
//$idNotificacion = 26;
$log = "idNotificacion del request: ".($idNotificacion)."\n";
$log .=  "inicio del request: ".($inicio)."\n";

//consultamos la tabla NotificacionesApp que traiga las notificaciones de estado="Pendiente" de acuerdo a la fecha actual
$SQLNotifiApp = 'SELECT * FROM NotificacionesApp WHERE codigoEstado="100" ';

if(!empty($idNotificacion)){
    $SQLNotifiApp .= ' AND id = '.$idNotificacion;
}else{
    $SQLNotifiApp .= ' AND fecha like "%' . $fecha . '%" AND estado="Pendiente" ';
}

$dNotifiApp = $db->Execute($SQLNotifiApp);
$dataNotifiApp = $dNotifiApp->FetchRow();
$log .= "dataNotifiApp: ".print_r($dataNotifiApp, true)."\n";
//ddd($log);
//ddd($dataNotifiApp);
if (!empty($dataNotifiApp)) {
    $notiApp = $dataNotifiApp;
    
    $log .=  "id: ".($notiApp['id'])."\n";
    //update para cambiar el estado de Pendiente a Procesando en la tabla NotificacionesApp de acuerdo a la fecha actual
    $updatenoti = 'UPDATE NotificacionesApp SET estado="Procesando",  fechaModificacion="'.$fecha.'" WHERE id = '.$notiApp['id'];
    $db->Execute($updatenoti);

    //Notificaciones
    $idnotificacion = array();
    $texto = array();

    $idnotificacion[] = $notiApp['id'];
    $texto[] = $notiApp['texto'];

    $cantidad = getCantidadDispositivos();
    //d($cantidad);
    $log .=  "cantidad: ".($cantidad)."\n";

    $limit = getLimit($cantidad, $inicio);

    $log .=  "limite: ".($limit)."\n";
    //echo $log;
    if(!empty($limit)){
        //consultamos tabla Token para que traiga los usuarios activos y plataforma android
        //t.idUsuario IN (43359,45593,50531,54437,66913,71305) AND
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se une otro select para que llegue la notificacion a los usuarios administrativos que no se encuentran registrados en SALA.
         * @since Marzo 1, 2019
         */ 
        $SQLIdUsuario = ' SELECT t.idUsuario, t.plataforma, t.devicetoken FROM Token t WHERE  t.CodigoEstado="100" AND t.Plataforma IN ("android", "iOS") and (t.devicetoken <>"0" and t.devicetoken <>"") ';
        $SQLIdUsuario .= ' UNION SELECT t.idUsuario, t.plataforma, t.devicetoken from Token t WHERE idUsuario=58843 and (t.devicetoken <>"0" and t.devicetoken <>"") GROUP BY devicetoken '.$limit;
        $log .= "SQLIdUsuario: ".$SQLIdUsuario."\n";
        //ddd($SQLIdUsuario);
        $dataUsuario = $db->GetAll($SQLIdUsuario);
        $log .= "dataUsuario: ".print_r($dataUsuario, true)."\n";

        foreach($dataUsuario as $usuarioDisp){
            switch($usuarioDisp['plataforma']){
                case "android":
                    $idusuarioAndroid[] = $usuarioDisp['idUsuario'];
                    $arraysAndroid[] = $usuarioDisp['devicetoken'];
                    break;
                case "iOS":
                    $idusuarioiOS[] = $usuarioDisp['idUsuario'];
                    $arraysiOS[] = $usuarioDisp['devicetoken'];
                    break;
            }

        }

        actualizarEstadoEnvio($dataUsuario, 'Procesando', $notiApp['id'], $fechahora);

        if(!empty($arraysiOS)){
            $resultiOS = sendMessage($texto, $arraysiOS);
            $log .= "resultiOS: ".print_r($resultiOS, true)."\n";
            //echo $resultiOS."\n";
        }

        if(!empty($arraysAndroid)){
            $resultAndroid = sendMessage($texto, $arraysAndroid);
            $log .= "resultAndroid: ".print_r($resultAndroid, true)."\n";
        }

        actualizarEstadoEnvio($dataUsuario, 'Enviado', $notiApp['id'], $fechahora);

        escribirLog($log, $inicio, $notiApp['id']);
        //echo (" DEBE VOLVERSE A LLAMAR fin")."\n";
        $inicio += DISPOSITIVOS_X_ENVIO;
        //ddd($inicio);
        $idNotificacion = $notiApp['id'];
        invocarNuevoHiloRecursivo($inicio, $idNotificacion);
    }else{
        echo "Se hace update del estado de la notificacion";
        $updatenotif = 'UPDATE NotificacionesApp SET estado="Enviado",  fechaModificacion="'.$fecha.'" WHERE id = '.$notiApp['id'];
        //ddd($updatenotif);
        $db->Execute($updatenotif);            
        invocarNuevoHiloRecursivo();
    }
} else {
    echo 'No hay notificaciones pendientes';
}