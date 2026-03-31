<?php

//$file = "/tmp/listadoestudiantesmatriculados.txt";
$file = "/var/tmp/spadies.txt";
//$enlace = $path."/".$file; 
$enlace = $file; 
header ("Content-Disposition: attachment; filename=".$file.""); 
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
//header("Location: generaarchivo.php"); 

?>