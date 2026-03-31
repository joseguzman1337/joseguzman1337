<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
include("../../templates/templateAutoevaluacion.php");

   $db=writeHeaderBD();
   $ban=0;
   $id=$_REQUEST['id'];
    $query_carrera = "SELECT 
                                       idinstitucioneducativa  AS id,
                                        nombreinstitucioneducativa  AS Nombre
                                        FROM
                                        institucioneducativa where nombreinstitucioneducativa  LIKE '%". $_GET['term']."%' limit  20"   ;
   // echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
   $data_user=$data_in->GetArray();
   
if(count($data_user) > 0){
    foreach($data_user as $dt){
       // echo $dt['nombreinstitucioneducativa'];
        $matriculas[] = $dt['Nombre'];
    }
echo json_encode($matriculas);
}
   
 ?>
 