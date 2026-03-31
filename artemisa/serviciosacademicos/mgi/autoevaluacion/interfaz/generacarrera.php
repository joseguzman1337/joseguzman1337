<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include("../../templates/templateAutoevaluacion.php");
   $db =writeHeaderBD();
   $val=$_REQUEST['id'];
   $query_carrera = "SELECT '' as nombrecarrera, '' as codigocarrera 
                     UNION SELECT nombrecarrera, codigocarrera 
                     FROM carrera 
                     where codigomodalidadacademica='".$val."'
                      order by 1";
   $reg_carrera =$db->Execute($query_carrera);
   echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' onchange="displayIndicadores(3)" id=codigocarrera  style="width:150px;"');
                                     