<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    require_once(dirname(__FILE__).'/../../Connections/sala2.php');
    $rutaado = dirname(__FILE__)."/../../funciones/adodb/";
    require_once(dirname(__FILE__).'/../../Connections/salaado.php');
    require_once(realpath(dirname(__FILE__)).'/../../../nusoap/lib/nusoap.php');
    require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/reporteCaidaPeople.php');
    require_once(realpath(dirname(__FILE__)).'/../../consulta/interfacespeople/funcionesPS.php');
    //inactivo por proceso de agente bancario
    /*
    OtherOrdenes($db);//Actualiza Y Busca Ordenes.


    echo 'Revisando que todas las ordenes tengan el estado correcto....<br/>';
    $Data = buscarOrdenesEstadoMalo($db);
    if($Data){
        while(!$Data->EOF){
            $db->Execute("UPDATE `ordenpago` SET `codigoestadoordenpago`='40' WHERE (`numeroordenpago`='".$Data->fields['ordenpago']."')");
            $Data->MoveNext();
        }
    }
    echo '<br><br>Termino estado ordenes...';

    $Respuesta = llamarPeople();

    if($Respuesta==true){
        echo 'Reenviando agentbank..<br/>';
        //primero voy a reenviar las de agentbank
        $Data = buscarOrdenesAgentBank($db);

        if($Data){
            while(!$Data->EOF){
                echo "voy a notificar la orden ".$Data->fields['ordenpago']." <br/>";
                reportarPagoPeople(
                    $db,
                    $Data->fields['ordenpago'],
                    $Data->fields['TicketID'],
                    $Data->fields['respuestalogtraceintegracionps']
                );
                $Data->MoveNext();
            }
        }
        echo '<br><br>Termino agentbank...';

        echo 'Reenviando PSE..';
        //reenvio las de pse que todavia no han llegado a people
        $Data = buscarOrdenesPSE($db);
        if($Data){
              while(!$Data->EOF){
                    reportarPagoPSE($db,$Data->fields['ordenpago'],$Data->fields['respuestalogtraceintegracionps']);

                $Data->MoveNext();
              }
        }
        echo '<br><br>Termino PSE...';
    }else{
        echo 'people caido';
    }

?>