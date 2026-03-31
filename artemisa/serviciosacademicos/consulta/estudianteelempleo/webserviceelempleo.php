<?php
function insertaelempleo($tipodocumento,$numerodocumento,$codigosituacioncarreraestudiante,$idestudiantegeneral,$db,$sala){
    global $db;

switch ($tipodocumento) {
    case "01":
        $nombredocumento='Cedula';
        break;
    case "02":
        $nombredocumento='Tarjeta de Identidad';
        break;
    case "03":
        $nombredocumento='Cedula Extranjeria';
        break;
    case "04":
        $nombredocumento='Cedula';
        break;
    case "05":
        $nombredocumento='Pasaporte';
        break;
    case "10":
        $nombredocumento='Cedula';
        break;
}

if($codigosituacioncarreraestudiante==200 || $codigosituacioncarreraestudiante==300 || $codigosituacioncarreraestudiante==301 || $codigosituacioncarreraestudiante==302)
{
    $tipopersona=10;
}
elseif($codigosituacioncarreraestudiante==104){
    $tipopersona=30;
}

    $client = new soapclient("http://www.elempleo.com/colombia/WebServices/UniversityServices.asmx?WSDL", true);
    $err = $client->getError();
    if ($err) {
        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
    }
    $proxy = $client->getProxy();


     $parametros['identityCards']['DtoIdentityCard'] = array(
            'IdentityCardTypeKey' => $nombredocumento,
            'Number' => $numerodocumento);
     $parametros['candidateType']=$tipopersona;
     $parametros['total']='false';
     $parametros['token'] = array(
            'UserName' => 'egresados@unbosque.edu.co',
            'Password' => 'bosque2011',
            'UniId'=>'39370');

     $result = $client->call('UploadIdentityCard',array($parametros));

    /*echo "<pre>";
    print_r($result);
    echo "</pre>";*/

     if($result['UploadIdentityCardResult']){         
         mysql_select_db($db, $sala);
         $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral,
         confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado, subidoestudianteelempleo)
         values (0, '{$idestudiantegeneral}', 'SI', now(), 100, 'SI')";
         $guardar = mysql_query($query_guardar, $sala) or die(mysql_error());                    
         echo '<script language="JavaScript">alert("Se ha autorizado el envio de información a elempleo.com")</script>';
      }
      else{         
         mysql_select_db($db, $sala);
         $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral,
         confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado, subidoestudianteelempleo)
         values (0, '{$idestudiantegeneral}', 'SI', now(), 100, 'NO')";
         $guardar = mysql_query($query_guardar, $sala) or die(mysql_error());
         echo '<script language="JavaScript">alert("Se ha autorizado el envio de información a elempleo.com")</script>';
      }
}
?>