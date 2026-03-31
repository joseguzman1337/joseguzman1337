<?php
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   $ban=0;
   $id=$_REQUEST['id'];
    $query_carrera = "SELECT idobs_admitidos_contexto, nombre, nombretiporiesgo, t.idobs_tiporiesgo
                    FROM obs_admitidos_contexto as c 
                    LEFT JOIN obs_tiporiesgo as t on (t.idobs_tiporiesgo=c.idobs_tiporiesgo and t.codigoestado=100)
                    WHERE c.idobs_admitidos_contexto='".$id."' and c.codigoestado=100; ";
   // echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
   $data_user=$data_in->GetArray();
   $data_user=$data_user[0];
   if (!empty($data_user['nombretiporiesgo'])){
       $nom=$data_user['nombretiporiesgo'];
       $valo=$data_user['idobs_tiporiesgo'];
   }else{
       $nom="Sin Riesgo";
       $valo=0;
   }
   
 ?>
 <b><?php echo $nom?></b>
 <input type="hidden" name="idobs_tiporiesgo[]" id="idobs_tiporiesgo" value="<?php echo $valo ?>" />   