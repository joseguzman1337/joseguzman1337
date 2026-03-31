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

    $query_carrera = "SELECT 
                                       idinstitucioneducativa  AS id,
                                        nombreinstitucioneducativa  AS Nombre
                                        FROM
                                        institucioneducativa where nombreinstitucioneducativa = '".$_POST['matricula']."' " ;
  // echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
   $data_user=$data_in->GetArray();
   //$data_user=$data_user[0];
   
   
if(count($data_user) > 0){
    foreach($data_user as $dt){
       // echo $dt['nombreinstitucioneducativa'];
        $respuesta['nombre'] = $dt['Nombre'];
        $respuesta['id']=$dt['id'];
    }
echo json_encode($respuesta);
}
   
 ?>
 