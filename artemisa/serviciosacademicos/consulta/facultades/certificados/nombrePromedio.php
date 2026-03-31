<?php
/* 
El presente archivo se encarga de nombrar los certificados acorde a la modalidad
académica del estudiante. De manera que si el codigo del estudiante esta asociado a un
programa virtual, los certificados se muestren como 'del Periodo', de lo contrario se muestren
como 'semestrales'
*/

//se obtiene la modalidad academica del estudiante
$str_modalidad = "select c.codigomodalidadacademica
                  from estudiante e
                  join carrera c on e.codigocarrera = c.codigocarrera
                  where e.codigoestudiante  = $codigoestudiante";
$query_modalidad = mysql_query($str_modalidad, $sala) or die("$str_modalidad".mysql_error());
$res_modalidad = mysql_fetch_assoc($query_modalidad);
$modalidadacademica = $res_modalidad['codigomodalidadacademica'];

//se obtiene si el modulo debe mostrar la información por Semestre o por Periodo
$nombrePromPonderado = "";
$nombrePromPonderadoAcumulado = "";
$nombrePeriodoTipoCertificado = "";
$nombreTipoPeriodo = "";
if ($modalidadacademica == '800' || $modalidadacademica == '810') {
    $nombrePromPonderado = "Promedio Ponderado del Periodo";
    $nombrePromPonderadoAcumulado = "Promedio Ponderado Acumulado del Periodo";
    $nombrePeriodoTipoCertificado = "Certificado por Periodo";
    $nombreTipoPeriodo = "Periodo";
}else{
    $nombrePromPonderado = "Promedio Ponderado del Semestre";
    $nombrePromPonderadoAcumulado = "Promedio Ponderado Semestral Acumulado";
    $nombrePeriodoTipoCertificado = "Certificado por Semestre";
    $nombreTipoPeriodo = "Semestre";
}


?>