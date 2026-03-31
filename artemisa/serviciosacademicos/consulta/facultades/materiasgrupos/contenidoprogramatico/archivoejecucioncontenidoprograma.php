<?php

$formatoinstitucional= $_REQUEST['formatoinstitucional'];
$nombrearchivocontenido=$_REQUEST['nombrearchivocontenido'];
$definitivo=$_REQUEST['definitivo'];
/*El archivo en produccion debe ir con artemisa (https://artemisa.unbosque.edu.co ), reemplazar en las variables
 * $urlformatoinstitucional
 * $urlnombrearchivocontenido
 */
$urlformatoinstitucional="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$formatoinstitucional;
$urlnombrearchivocontenido="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$nombrearchivocontenido;
$urldefinitivo="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$definitivo;

$arch1 = file_get_contents($urlformatoinstitucional);
touch($formatoinstitucional);
$newfile = fopen($formatoinstitucional, "w");
        fputs ($newfile, $arch1);
        fclose ($newfile);

$arch2 = file_get_contents($urlnombrearchivocontenido);
touch($nombrearchivocontenido);
$newfile2 = fopen($nombrearchivocontenido, "w");
        fputs ($newfile2, $arch2);
        fclose ($newfile2);

$union="pdftk ".$formatoinstitucional." ".$nombrearchivocontenido." cat output ".$definitivo;
$ejecuta=shell_exec($union);
$ejecuta2=shell_exec('rm '.$formatoinstitucional);

$pdfunido=file_get_contents($urldefinitivo);
echo $pdfunido;
//esta linea se comenta solo para desarrollo
//$ejecuta4=shell_exec('rm '.$nombrearchivocontenido);


$ejecuta3=shell_exec('rm '.$definitivo);



?>


<?php
/*
$formatoinstitucional= $_REQUEST['formatoinstitucional'];
$nombrearchivocontenido=$_REQUEST['nombrearchivocontenido'];
$definitivo=$_REQUEST['definitivo'];
/*El archivo en produccion debe ir con artemisa (https://artemisa.unbosque.edu.co ), reemplazar en las variables
 * $urlformatoinstitucional
 * $urlnombrearchivocontenido

$urlformatoinstitucional="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$formatoinstitucional;
$urlnombrearchivocontenido="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$nombrearchivocontenido;
$urldefinitivo="http://172.16.3.202/~dmolano/desarrollo/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/".$definitivo;

$arch1 = file_get_contents($urlformatoinstitucional);
touch($formatoinstitucional);
$newfile = fopen($formatoinstitucional, "w");
        fputs ($newfile, $arch1);
        fclose ($newfile);

$arch2 = file_get_contents($urlnombrearchivocontenido);
touch($nombrearchivocontenido);
$newfile2 = fopen($nombrearchivocontenido, "w");
        fputs ($newfile2, $arch2);
        fclose ($newfile2);

$union="pdftk ".$formatoinstitucional." ".$nombrearchivocontenido." cat output ".$definitivo;
$ejecuta=shell_exec($union);
$ejecuta2=shell_exec('rm '.$formatoinstitucional);

$pdfunido=file_get_contents($urldefinitivo);
echo $pdfunido;
//esta linea se comenta solo para desarrollo
$ejecuta4=shell_exec('rm '.$nombrearchivocontenido);


$ejecuta3=shell_exec('rm '.$definitivo);


*/
?>
