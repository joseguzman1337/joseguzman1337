<?php

// server should keep session data for AT LEAST 30 mins
//ini_set('session.gc_maxlifetime', 3600);
// each client should remember their session id for EXACTLY 1 hour
//session_set_cookie_params(3600);
/////////////////busca la ruta del managerentity
/* session_unset();
  session_destroy(); */
session_start();
/* include_once('../../../utilidades/ValidarSesion.php'); 
  $ValidarSesion = new ValidarSesion();
  $ValidarSesion->Validar($_SESSION); */

$ruta = "../";
while (!is_file($ruta . 'ManagerEntity.php')) {
    $ruta = $ruta . "../";
}
require_once($ruta . 'ManagerEntity.php');

///////////trae el id del usuario //////////*



if ($_SESSION['MM_Username'] == 'estudiante' && isset($_SESSION['idusuariofinalentradaentrada'])) {
    $userid  = $_POST['Userid'];
    if(empty($userid)){
        $userid = $_SESSION['idusuariofinalentradaentrada'];
    }
} else if (!empty($_SESSION['MM_Username'])) {
    $entity = new ManagerEntity("usuario");
    $entity->sql_select = "idusuario";
    $entity->prefix = "";
    $entity->sql_where = " usuario='" . $_SESSION['MM_Username'] . "' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $userid = $data[0]['idusuario'];
} else if (!empty($_POST["Userid"]) && $_POST["Userid"] != null) {
    $entity = new ManagerEntity("usuario");
    $entity->sql_select = "idusuario";
    $entity->prefix = "";
    $entity->sql_where = " idusuario='" . $_POST["Userid"] . "' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $userid = $data[0]['idusuario'];
} else {
    $userid = null;
}
/*
 *  Ivan Dario quintero 
 * Modificado 1 de marzo 2018
 */

if ($userid != $_SESSION['idusuario']) {
    $userid = $_SESSION['idusuario'];
    $entity = new ManagerEntity("usuario");
    $entity->sql_select = "idusuario";
    $entity->prefix = "";
    $entity->sql_where = " idusuario='" . $userid . "' ";
    $data = $entity->getData();
    $_POST['cedula'] = $data[0]['numerodocumento'];
}
/* end */

$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$currentdate = date("Y-m-d H:i:s");

$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$idname = "idsiq_" . $table;
$id_nam = $_REQUEST[$idname];

$entity = new ManagerEntity($table, "autoevaluacion");

if ($_REQUEST[$idname]) {
    //si existe datos en la variable $idname es porque va a modificar o eliminar
    $entity->SetEntity($_POST);
    $entity->fieldlist[$idname]['pkey'] = $_REQUEST[$idname];
    if ($_REQUEST['delete'] == true) {
        //$entity->debug = true;
        $entity->deleteRecord();
    } else {
        //$entity->debug = true;        
        $entity->updateRecord();
    }
} else {
    //////////inserta los resgistros
    if (!empty($_POST['preg'])) {//es el arreglo de las preguntas
        foreach ($_POST['preg'] as $cp => $vp) { //recorre el arreglo
            $_POST['cedula'] = $_POST['cedula_num'];
            $_POST['idsiq_Apregunta'] = $vp;
            //$_POST['idgrupo'] = $idgrupo;
            $tipo = $_POST['tpreg'][$cp];
            if ($tipo == 4) { //si el tipo de pregunta es 4 recorre los valores
                foreach ($_POST['valor_' . $vp] as $cp2 => $vp2) {
                    if (!empty($vp2)) {
                        $_POST['idsiq_Apreguntarespuesta'] = $vp2;
                        $_POST['fechacreacion'] = $currentdate;
                        $_POST['usuariocreacion'] = $userid;
                        $entity->SetEntity($_POST);
                        //$entity->debug = true;
                        $entity->insertRecord(); //inserta
                    }
                }
            } else if ($tipo == 5) {//si el tiepo de pregunta es 5 inserta el dato de la pregunta abierta
                if (!empty($_POST['valor_' . $vp])) {
                    $_POST['idsiq_Apreguntarespuesta'] = '';
                    $_POST['preg_abierta'] = $_POST['valor_' . $vp];
                    $_POST['fechacreacion'] = $currentdate;
                    $_POST['usuariocreacion'] = $userid;
                    $entity->SetEntity($_POST);
                    //$entity->debug = true;
                    $entity->insertRecord(); //inserta registro
                    $_POST['preg_abierta'] = '';
                }
            } else {
                if (!empty($_POST['valor_' . $vp])) {//si no esta vacio el valor de la pregunra
                    $_POST['idsiq_Apreguntarespuesta'] = $_POST['valor_' . $vp];
                    $_POST['preg_abierta'] = $_POST['justificacion_' . $vp];
                    $_POST['fechacreacion'] = $currentdate;
                    $_POST['usuariocreacion'] = $userid;
                    $entity->SetEntity($_POST);
                    //$entity->debug = true;
                    $entity->insertRecord(); //inserta
                }
            }
            //echo $v.'<---->';
        }
    }
}
$result = 'Se registro exitosamente';
$data = array('success' => true, 'message' => $result, 'id' => $id);
echo json_encode($data);