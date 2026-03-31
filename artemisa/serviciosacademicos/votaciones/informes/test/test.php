<?php
echo "hello world";
$conexion=mysql_connect("localhost","root","");
mysql_select_db("sala",$conexion);
$query="SELECT * FROM carrera";
$operacion=mysql_query($query) or die(mysql_error());
$row_operacion=mysql_fetch_assoc($operacion);
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=mysql_fetch_assoc($operacion));
DibujarTabla($array_interno);
function escribir_cabeceras($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}

function DibujarTabla($matriz,$texto="")
{
	if(is_array($matriz))
	{
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
	else
	{
		echo $texto." Matriz no valida<br>";
	}
}

?>