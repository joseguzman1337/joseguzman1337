<?php
include('../templates/templateObservatorio.php');

   $db=writeHeaderBD();
   $ban=0;
   $i=$_REQUEST['i'];
   $tipo=$_REQUEST['tipo'];
   $ndocumento=$_REQUEST['ndocumento'];
   $sql="SELECT u.idusuario, apellidos, nombres, numerodocumento
            FROM usuario as u 
            where u.numerodocumento='".$ndocumento."' ";
   //echo $sql;
   $data_in= $db->Execute($sql);
   $data_user=$data_in->GetArray();
   $data_user=$data_user[0];
   if (!empty($data_user['nombres'])){
       $nom=$data_user['nombres'].' '.$data_user['apellidos'];
   }else{
       $nom="No se encontro";
   }
   
 ?>
 <b><?php echo $nom?></b>
 <input type="hidden" name="idusuario[]" id="idusuario" value="<?php echo $data_user['idobs_tiporiesgo']?>" />   