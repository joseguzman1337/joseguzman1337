<?php

$output = shell_exec("gs -q -sPAPERSIZE=letter -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=docs_joined.pdf reporteGraduandos_2013-03-21_10-22-08.pdf reporteIndicesEstudiantes_2013-03-21_17-17-26.pdf reportefnctrp7yz_21-03-2013_10-06-09.pdf");
var_dump($output);
?>
