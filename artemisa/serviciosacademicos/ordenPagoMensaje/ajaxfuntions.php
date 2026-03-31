<?php

session_start();
require_once('core/functionsPaymentsMessage.php');
require_once("../../sala/includes/adaptador.php");

$funtionsDb = new functionsPaymentsMessage($db);

/**
 * opcion 1: listar carreras por modalidad academica
 */
if($_REQUEST['opcion'] == 1)
{
    $responseAjax = $funtionsDb->listCareersByModalityOptions($_REQUEST['idModalidad']);
    echo $responseAjax;
}

/**
 * opcion 2: Crear mensaje
 */
if($_REQUEST['opcion'] == 2)
{
    $execute = $funtionsDb->createMessageOrderPayment($_REQUEST);
    if($execute)
    {
        echo '<script>
            window.location = "indexPaymentMessage.php?success=true";
        </script>';
    }else
        {
            echo '<script>
            window.location = "formCrearMensaje.php?error=true";
        </script>';
        }

}

/**
 * opcion 3: Editar mensaje
 */
if($_REQUEST['opcion'] == 3)
{
    $execute = $funtionsDb->editMessageOrderPayment($_REQUEST);
    if($execute)
    {
        echo '<script>
            window.location = "indexPaymentMessage.php?success=true";
        </script>';
    }else
    {
        echo '<script>
            window.location = "formCrearMensaje.php?error=true";
        </script>';
    }

}