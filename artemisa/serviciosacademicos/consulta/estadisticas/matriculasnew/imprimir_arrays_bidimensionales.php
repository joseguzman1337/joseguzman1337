<?php
function escribir_cabeceras($matriz)
{
	error_reporting(0);
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<th>$elemento[0]</th>\n";
	}
	echo "</tr>\n";
}

function listar($matriz,$texto="")
{
	echo "<table border=1 align=center>\n";
	echo "<caption align=TOP>$texto</caption>";
	escribir_cabeceras($matriz[0]);
	for($i=0; $i < count($matriz); $i++)
	{
		echo "<tr>\n";
		while($elemento=each($matriz[$i]))
		{
			echo "<td>$elemento[1]</td>\n";
		}
	echo "</tr>\n";
	}
	echo "</table>\n";
}
?>