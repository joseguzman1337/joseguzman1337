<?php

include_once("../variables.php");
$subAction = "update";
if ($_POST["idGenerico"] != "" && $_POST["action"] == "save") {
    $_POST["action"] = "update";
    $_POST["idsiq_indicadorGenerico"] = $_POST["idGenerico"];
    $_POST["nombre"] = "";
    $subAction = "save";
}
include($rutaTemplate . 'templateProcess.php');

if ($subAction == "save") {
    $_POST["action"] = "save";
    $action = "save";
    $result = $_POST["idGenerico"];
}

if (isset($_POST["crearIndicadores"]) && isset($_POST["action"]) && (strcmp($_POST["action"], "save") == 0)) {
    //Crear indicadores de detalle
    $fields = array();

    if ($result == 0) {
        $message = 'Ya existe un indicador con el nombre especificado.';
        $data = array('success' => false, 'message' => $message);
        echo json_encode($data);
        exit();
    }

    $fields["idIndicadorGenerico"] = $result;
    $fields["idEstado"] = "1";
    $fields["es_objeto_analisis"] = $_POST["es_objeto_analisis"];
    $fields["tiene_anexo"] = $_POST["tiene_anexo"];
    if ($_POST["idTipo"] == 3) {
        $fields["inexistente"] = $_POST["inexistente"];
    }

    $discriminaciones = $_POST['discriminacion'];
    $num = count($discriminaciones);
    for ($i = 0; $i < $num; $i++) {
        $fields["discriminacion"] = $discriminaciones[$i];
        if($fields["discriminacion"] == 1) {
            $result = $utils->processData($action, "indicador", $fields, false);
        }elseif($fields["discriminacion"] == 3) {
            //carreras
            $carreras = $_POST['carrera'];
            $numF = count($carreras);
            for ($j = 0; $j < $numF; $j++) {
                $fields["idCarrera"] = $carreras[$j];
                $result = $utils->processData($action, "indicador", $fields, false);
            }
        }

        if ($result == 0) {
            $message = 'Ocurrio un problema al tratar de registrar el detalle del indicador.';

            $data = array('success' => false, 'message' => $message);
            echo json_encode($data);
            exit();
        }
    }
}

if ((strcmp($action, "inactivate") == 0) && (strcmp($_POST["entity"], "indicadorGenerico") == 0)) {
    $id = $_POST["idsiq_indicadorGenerico"];
    $result = $utils->inactivateDataJoin("idIndicadorGenerico", "indicador", $id, $db);
}

if (strcmp($action, "dontProcess") == 0) {
    if (isset($_POST["action2"]) && (strcmp($_POST["action2"], "editarDetalleInd") == 0)) {
        //Editar indicadores de detalle

        $inexistente = $_POST['inexistente'];
        $anexo = $_POST['tiene_anexo'];
        $analisis = $_POST['es_objeto_analisis'];
        $id = $_POST["idsiq_indicadorGenerico"];

        $result = $utils->updateDataComplex($db, "`tiene_anexo` = " . $anexo . ", `inexistente`=" . $inexistente . ", `es_objeto_analisis`=" . $analisis . "", "siq_indicador", "idIndicadorGenerico='" . $id . "'");
    } else if (isset($_POST["action2"]) && (strcmp($_POST["action2"], "asignarAlerta") == 0)) {
        //Asignar alertas a indicadores
        $fields = array();

        $action = "save";
        $_POST["action"] = "save";

        $indicadores = $_POST['indicadores'];
        $num = count($indicadores);
        for ($i = 0; $i < $num; $i++) {
            //$fields["idIndicador"] = $indicadores[$i];            
            $fields["tipo"] = 1;
            $fields["idTipoAlerta"] = $_POST["idAlerta"];
            $fields["idPeriodicidad"] = $_POST["idPeriodicidad"];
            $fields["idMonitoreo"] = $indicadores[$i];
            $result = $utils->processData($action, "alertaPeriodica", $fields, false);
        }
    } else {
        //Inactivar indicadores de detalle
        $fields = array();

        $action = "inactivate";
        $_POST["action"] = "inactivate";

        $indicadores = $_POST['indicadores'];
        $num = count($indicadores);
        for ($i = 0; $i < $num; $i++) {

            $fields["idsiq_indicador"] = $indicadores[$i];
            $result = $utils->processData($action, "indicador", $fields, false);
        }
    }
}

// Set up associative array
$data = array('success' => true, 'message' => $result);

// JSON encode and send back to the server
echo json_encode($data);
?>
