<?php
require_once('../../class/Class_andor.php');
require_once('../../class/table.php');
require_once('../../class/table.php');

//bloque de codigo que actualiza en la tabla tarjetaestudiante en SALA.
$fechahoy = date("Y-m-d G:i:s", time());
$obj_table = new table("tarjetaestudiante");
$obj_table->setFields();
$fieldarray_tarjeta = array(
    'idestudiantegeneral' => $_REQUEST['v_idestudiantegeneral'], 
    'sinc_andover' => 1, 
    'fechaactivaciontarjetaestudiante' => $fechahoy);
$obj_table->fieldlist['idestudiantegeneral'] = array('pkey' => 'y');
$obj_table->fieldlist['codigotarjetaestudiante'] = array('pkey' => 'y');

if ($_REQUEST['Inactivar']=="true"){    
    $objAndor = new class_andor($_REQUEST['v_documento']);
    /*nivel de acceso por defecto = 1*/
    $NivelAcceso = 1;
    $objAndor->setNivelAcceso($NivelAcceso);
    $objAndor->setNombres($_REQUEST['v_nombre']);
    $objAndor->setApellido($_REQUEST['v_apellido']);
    $objAndor->setNumeroTarjeta($_REQUEST['v_tarjeta']);
    $rsutl = $objAndor->del_ws_result();
    $objAndor->setNombres('');
    $objAndor->setApellido('');
    $objAndor->setNumeroTarjeta('');
    $rsutl = $objAndor->get_ws_result();    
    echo  $objAndor->table_cardholder($rsutl);
    $fieldarray_tarjeta['codigoestado'] = 200;
    $obj_table->updateRecord($fieldarray_tarjeta);
}

if ($_REQUEST['Inactivar']=="false"){
    $objAndor = new class_andor($_REQUEST['v_documento']);
    /*nivel de acceso por defecto = 1*/
    $NivelAcceso = 1;
    $objAndor->setNivelAcceso($NivelAcceso);
    $objAndor->setNombres($_REQUEST['v_nombre']);
    $objAndor->setApellido($_REQUEST['v_apellido']);    
    $objAndor->setNumeroTarjeta($_REQUEST['v_tarjeta']);    
    $rsutl = $objAndor->set_ws_result();
    $objAndor->setNombres('');
     $objAndor->setApellido('');
    $objAndor->setNumeroTarjeta('');
    $rsutl = $objAndor->get_ws_result();
    echo  $objAndor->table_cardholder($rsutl);
    $fieldarray_tarjeta['codigotarjetaestudiante'] = $_REQUEST['v_tarjeta'];
    $fieldarray_tarjeta['codigoestado'] = 100;
    $obj_table->updateRecord($fieldarray_tarjeta);
}
?>
