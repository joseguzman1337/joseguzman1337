<?php

    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../trm/lib/nusoap.php');

    $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

/*$query_estudiante = "SELECT distinct(ee.idestudiantegeneral),
( case eg.tipodocumento
when 01 then 'Cedula'
when 02 then 'Tarjeta de Identidad'
when 03 then 'Cedula Extranjeria'
when 04 then 'Cedula'
when 05 then 'Pasaporte'
when 10 then 'Cedula'
end
)as documento, eg.numerodocumento, 30 as tipopersona  FROM estudianteelempleo ee, estudiantegeneral eg, estudiante e
where ee.confimacionestudianteelempleo = 'SI'
and eg.idestudiantegeneral=ee.idestudiantegeneral
and ee.idestudiantegeneral=e.idestudiantegeneral
and e.codigosituacioncarreraestudiante=104
order by 3";*/
$query_estudiante="SELECT distinct(ee.idestudiantegeneral),
( case eg.tipodocumento
when 01 then 'Cedula'
when 02 then 'Tarjeta de Identidad'
when 03 then 'Cedula Extranjeria'
when 04 then 'Cedula'
when 05 then 'Pasaporte'
when 10 then 'Cedula'
end
)as documento, eg.numerodocumento,10 as tipopersona
FROM estudianteelempleo ee, estudiantegeneral eg, estudiante e, carrera c
where ee.confimacionestudianteelempleo = 'SI'
and eg.idestudiantegeneral=ee.idestudiantegeneral
and ee.idestudiantegeneral=e.idestudiantegeneral
and e.codigocarrera=c.codigocarrera
and c.codigomodalidadacademica in(200,300)
and (e.codigosituacioncarreraestudiante like '2%' or e.codigosituacioncarreraestudiante like '3%')
and c.codigocarrera not in(13, 560, 554)
group by 1
order by 3
limit 150,50";
$estudiante= $db->Execute($query_estudiante);
$totalRows_estudiante= $estudiante->RecordCount();
$row_estudiante = $estudiante->FetchRow();


    $client = new soapclient("http://www.elempleo.com/colombia/WebServices/UniversityServices.asmx?WSDL", true);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();

    do{
        $parametros['identityCards']['DtoIdentityCard'] = array(
            'IdentityCardTypeKey' => $row_estudiante['documento'],
            'Number' => $row_estudiante['numerodocumento']);
        $parametros['candidateType']=$row_estudiante['tipopersona'];
        $parametros['total']='false';
        $parametros['token'] = array(
            'UserName' => 'egresados@unbosque.edu.co',
            'Password' => 'bosque2011',
            'UniId'=>'39370');

        $result = $client->call('UploadIdentityCard',array($parametros));

            echo "<pre>";
           print_r($parametros);
            echo "</pre>";

            echo "<pre>";
            print_r($result);
            echo "</pre>";

            /*if($result['UploadIdentityCardResult']){
                echo "Sube Pleno";
            }
            else{
                echo "paila algun error";
            }*/

    }while($row_estudiante = $estudiante->FetchRow());

/*if ($proxy->fault) {
        echo '<h2>Fault</h2><pre>';
        print_r($result);
        echo '</pre>';
    } else {
        echo "<pre>AAAAA" . print_r($result) . "</pre>";
    }
    echo '<h2>Proxy Debug</h2><pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';
    echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';



    echo "<pre>";
   print_r($parametros);
    echo "</pre>";

    echo "<pre>";
    print_r($datosest);
    echo "</pre>";

    echo "<pre>";
    print_r($result);
    echo "</pre>";

//}*/


?>