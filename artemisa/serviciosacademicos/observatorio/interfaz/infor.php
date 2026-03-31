<?php
include('../templates/templateObservatorio.php');

$db=writeHeaderBD();

$id=$_REQUEST['id'];


$sql_per="SELECT * FROM obs_admisiones_info WHERE idobs_admitidos_campos_evaluar='".$id."' ";
//echo $sql_per;
$data_in= $db->Execute($sql_per);
$E_data = $data_in->GetArray();
echo $E_data[0]['texto']; 
?>


