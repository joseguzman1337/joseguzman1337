
<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");
$data= $_POST['datos_a_enviar'];
$data2= $_POST['datos_a_enviar2'];
if(!empty($data2)){
$data=($data2);
}elseif(!empty($data)){
$data=utf8_decode($data);    
}

echo $data;
?>