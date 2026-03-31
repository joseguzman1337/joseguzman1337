<?php 
//Calcula la desviacion estandar en un array
function desviacionestandar($datos){
$n=count($datos);
$sumatoriadesviacion=0;
for($i=0;$i<$n;$i++){
		$sumatoriadesviacion+=pow(($datos[$i]-promedio($datos)),2);
}
if(($n-1)>0)
$desviacionestandar=sqrt($sumatoriadesviacion/($n-1));
return $desviacionestandar;
}
//Calcula el promedio en un array
function promedio($datos){

$n=count($datos);
for($i=0;$i<$n;$i++)
$sumatoria+=$datos[$i];
$promedio=$sumatoria/$n;
return $promedio;

}

//Calcula el promedio ponderado en dos array
function promedioponderado($datos,$peso){

$n=count($datos);
for($i=0;$i<$n;$i++){
$sumatoria+=$datos[$i]*$peso[$i];
$sumatoriapeso+=$peso[$i];
}
$promedioponderado=$sumatoria/$sumatoriapeso;
//echo $promedioponderado."=".$sumatoria."/".$sumatoriapeso."<br>";

return $promedioponderado;
}
 
function seleccionarAleatorioArreglo($arregloAleatorio)
{
 $minimo = 0;
 $maximo = count($arregloAleatorio) - 1;
 $aleatorio = rand($minimo, $maximo);
 $rtaAleatorio = $arregloAleatorio[$aleatorio];
 return $rtaAleatorio;
}
?>