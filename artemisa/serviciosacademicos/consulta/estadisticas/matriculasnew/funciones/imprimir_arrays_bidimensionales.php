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
function escribir_filtros($matriz)
{
	error_reporting(0);
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td align='CENTER' id='tituloverde'><input name='$elemento[0]' type='text' size='15' value='".$_GET[$elemento[0]]."'><br>
		<select name='f_$elemento[0]' id='f_$elemento[0]'>
        <option value='like'"; if($_GET['f_'.$elemento[0]]=='like'){echo 'Selected';}echo ">like</option>
        <option value='<>'"; if($_GET['f_'.$elemento[0]]=='<>'){echo 'Selected';}echo "><></option>
        <option value='='"; if($_GET['f_'.$elemento[0]]=='='){echo 'Selected';}echo ">=</option>
        <option value='>'"; if($_GET['f_'.$elemento[0]]=='>'){echo 'Selected';}echo ">></option>
        <option value='>='"; if($_GET['f_'.$elemento[0]]=='>='){echo 'Selected';}echo ">>=</option>
        <option value='<'"; if($_GET['f_'.$elemento[0]]=='<'){echo 'Selected';}echo "><</option>
        <option value='<='"; if($_GET['f_'.$elemento[0]]=='<='){echo 'Selected';}echo "><=</option>
        </select>
		</td>\n";
	}
	echo "</tr>\n";
}


function leer_llaves($matriz)
{
	$matriz_columnas=array_keys($matriz[0]);
	return $matriz_columnas;

}

function escribir_cabeceras($matriz,$href)
{
	while($elemento = each($matriz))
	{
		$pedazo_a="&".$elemento[0]."=".$_GET[$elemento[0]];
		$cadena_a=$cadena_a.$pedazo_a;
	}
	reset($matriz);
	while($elemento = each($matriz))
	{
		$pedazo_b="&f_".$elemento[0]."=".$_GET['f_'.$elemento[0]];
		$cadena_b=$cadena_b.$pedazo_b;
	}
	reset($matriz);
	error_reporting(0);
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td align='CENTER' id='tituloverde'><a href='$href?ordenamiento=$elemento[0]&orden=";if(!isset($_GET['orden'])){echo "asc";}if($_GET['orden']=="asc"){echo "desc";}if($_GET['orden']=="desc"){echo "asc";};
		echo $cadena_a.$cadena_b;
		if(isset($_GET['Filtrar']) and $_GET['Filtrar']!=""){echo "&Filtrar=Filtrar";}
		echo "'>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}

function listar($matriz,$texto="",$link,$filtros="si")
{
	$this->href=$href;
	echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
	echo "<caption align=TOP>$texto</caption>";
	escribir_cabeceras($matriz[0],$link);
	if($filtros=="si"){
		escribir_filtros($matriz[0]);
	}

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

function listar_href($matriz,$texto="",$link,$filtros="si")
{
	$this->href=$href;
	echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
	echo "<caption align=TOP>$texto</caption>";
	escribir_cabeceras($matriz[0],$link);
	if($filtros=="si"){
		escribir_filtros($matriz[0]);
	}

	echo "<tr>\n";
	$conteo=0;

	for($i=0; $i < count($matriz); $i++)
	{
		echo "<tr>\n";
		while($elemento=each($matriz[$i]))
		{
			echo "<td nowrap><a href=''>$elemento[1]</a>&nbsp;</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";

}

function quitar_columnas()
{

}

?>