<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php
function tabla($query){
$totalcampos = mysql_num_fields($query);


echo "<table border = '1' align='center' cellpadding='2' cellspacing='1' bordercolor='#003333'>";
echo "<tr>";
#echo "<td><b>Act</b></td>";
for ($col=0; $col<$totalcampos; $col++)
{
	$campo=mysql_field_name($query,$col);
	echo "<td align='center' bgcolor='#FFFFFF' class='Estilo2'><b>$campo&nbsp;</b></td>";
}
#echo "<td><b>Act</b></td>";
echo "</tr>";

while ($row = mysql_fetch_row($query)){
	echo "<tr>";
	#echo "<td><a href=\"actualizar.php?id=$row[0]\">Actualizar</a></td>";
	for ($col=0; $col<$totalcampos;$col++){
		echo "<td align='center' bgcolor='#FFFFFF' class='Estilo1'>$row[$col]</td>";}
		#echo "<td><a href=\"actualizar.php?id=$row[0]\">Actualizar</a></td>";
		echo "</tr>";
	}

echo "</table> \n";
}
?>