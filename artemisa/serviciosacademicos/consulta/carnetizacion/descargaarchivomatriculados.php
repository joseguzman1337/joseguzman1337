<?php

//$file = "/tmp/listadoestudiantesmatriculados.txt";

$file = "/var/tmp/listadoestudiantesmatriculados.txt";

//$enlace = $path."/".$file; 

$enlace = $file; 

header ("Content-Disposition: attachment; filename=".$file.""); 

header ("Content-Type: application/octet-stream");

header ("Content-Length: ".filesize($enlace));

readfile($enlace);

//header("Location: reportecarnetizacion.php"); 

?>