<?php 
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Content-Type: application/force-download");
header('Content-disposition: attachment; filename='.urlencode($_GET["nombre"]));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

//readfile(/*"../../SQI_Documento/"*/  "https://artemisa.unbosque.edu.co/serviciosacademicos/mgi/SQI_Documento/".$_GET["ubicacion"]);
readfile("../../SQI_Documento/".$_GET["ubicacion"]);
exit;
?>

