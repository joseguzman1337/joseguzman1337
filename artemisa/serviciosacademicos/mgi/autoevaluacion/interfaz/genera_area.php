<?php

session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

error_reporting(E_ALL);
ini_set('display_errors', '0');
include("../../templates/templateAutoevaluacion.php");

   $db=writeHeaderBD();
   $ban=0;
   $id=$_REQUEST['id'];
    $query_area = "SELECT
                	siq_Apublicoobjetivocsv.texto2
                FROM
                	siq_Apublicoobjetivocsv
                WHERE
                	texto = '".$id."'
                GROUP BY
                	siq_Apublicoobjetivocsv.texto2"   ;
    //echo $query_area;
   $data_in= $db->Execute($query_area);
   
   
   
if(count($data_in) > 0){
    foreach($data_in as $dt){
       // echo $dt['nombreinstitucioneducativa'];
        $arrayarea[] = $dt['texto2'];
    }
echo json_encode($arrayarea);
}
   
 ?>
 