<?php
function imprimir_array($array)
{
	print "\n<pre>";
	print_r ($array);
	print "\n</pre>";
}
?>
<?php
function escribir_cabeceras($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<th>$elemento[0]</th>\n";
		//echo "<th>",listar($elemento[0],"");echo "</th>";
	}
	echo "</tr>\n";
}
function array_cabeceras($matriz)
{
	while($elemento = each($matriz))
	{
		//print_r($elemento[0]);
		echo $elemento[0];
		//listar($elemento[0],"");
	}
	return $cabeceras;
}
function listar($matriz,$texto)
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
			//echo "<td>";print_r($elemento[1]);echo "</td>\n";
			//echo "<td>";listar($elemento[1],0);echo "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}

?>