<?php

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
/*PARA TRAER LAS CARRERAS*/

if(isset($_POST["codigomodalidadacademicasic"]))
 {
    $opciones = '<option value=""></option>';
    
    $query_selcarrera = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademicasic = '".$_POST['codigomodalidadacademicasic']."'";
    $selcarrera = $db->Execute($query_selcarrera);
    $totalRows_selcarrera = $selcarrera->RecordCount();
    
    while($row_selcarrera = $selcarrera->FetchRow())
    {
    
       $opciones.='<option value="'.$row_selcarrera["codigocarrera"].'">'.$row_selcarrera["nombrecarrera"].'</option>';
    }
     echo $opciones;
 }




?>
