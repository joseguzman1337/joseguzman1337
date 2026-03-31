<?php

function tabla_arreglo_chulitos($matriz)
{
	$contador=1;
	echo "<form name='recortar' method='post' action=''>";
	echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
	foreach ($matriz as $llave => $valor)
	{
		if($contador%4==0)
		{

			$contador=1;
			echo "<tr>\n";
		}
		echo "<td nowrap>$valor&nbsp;</td>\n";
		if($_POST["sel".$valor]==$valor)
		{
			$chequear="checked";
		}
		else
		{
			$chequear="";
		}
		echo "<td><input type='checkbox'  name='sel".$valor."' $chequear value='".$valor."'></td>\n";
		if($contador%4==0)
		{
			$contador=1;
			echo "</tr>\n";
		}
		$contador++;
	}
	echo "<tr><td><input name='Recortar' type='submit' id='Recortar' value='Recortar'></td></tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}

function leer_llaves($matriz)
{
	$matriz_columnas=array_keys($matriz[0]);
	return $matriz_columnas;

}
function escribir_cabeceras($matriz,$href)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}
function tabla($matriz,$texto="")
{
	$this->href=$href;
	echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
	echo "<caption align=TOP>$texto</caption>";
	escribir_cabeceras($matriz[0],$link);
	for($i=0; $i < count($matriz); $i++)
	{
		echo "<tr>\n";
		while($elemento=each($matriz[$i]))
		{
			echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}
?>