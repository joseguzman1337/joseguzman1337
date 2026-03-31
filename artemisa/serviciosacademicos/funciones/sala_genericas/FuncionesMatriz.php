<?php 
function InsertarColumnaFila($array,$columnanueva,$posicion){
$columnas1=array_slice($array, 0,$posicion);
$columnas2=array_slice($array,$posicion);
$columnas1_1=array_merge($columnas1, $columnanueva);
$arraynuevo=array_merge($columnas1_1, $columnas2);
return $arraynuevo;
}
function QuitarColumnaFila($array,$posicion){
$columnas1=array_slice($array, 0,$posicion);
$columnas2=array_slice($array,$posicion+1);
//$columnas1_1=array_merge($columnas1, $columnanueva);
$arraynuevo=array_merge($columnas1,$columnas2);
return $arraynuevo;
}
function EncuentraFilaVector($vector,$fila){
	for($i=0;$i<count($vector);$i++)
		if($vector[$i]==$fila)
			return true;

return false;
}
function InsertaCeldaPosicion($matriz,$celda,$posicion){


$tmpceldamatriz=$matriz[$posicion];
$matriz[$posicion]=$celda;
$posicion++;
if(isset($matriz[$posicion]))
	$matriz=InsertaCeldaPosicion($matriz,$tmpceldamatriz,$posicion);


return $matriz;
}
function UnionArray($array1,$array2){

$i=0;
foreach($array1 as $llave => $valor){
$arrafinaltras[$valor]=$i;
$i++;
}
foreach($array2 as $llave => $valor){
$arrafinaltras[$valor]=$i;
$i++;
}
if(is_array($arrafinaltras))
$arrayfinal=array_flip($arrafinaltras);
else
$arrayfinal=array();
return $arrayfinal;
}
?>