<?php
 include_once("../variables.php");
    include($rutaTemplate."template.php");
 $db = writeHeader("",TRUE,$proyectoNumericos,"../../","body",$Utils_numericos);

 $q=$_GET["q"];

 $con = $db;
 // echo ($con);
 // die();
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("sala", $con);

$sql="SELECT * FROM siq_funcion WHERE idsiq_funcion = '".$q."'";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Descrición</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['descripcion'] . "</td>";
  #echo "<td>" . $row[''] . "</td>";
  #echo "<td>" . $row[''] . "</td>";
  #echo "<td>" . $row[''] . "</td>";
  #echo "<td>" . $row[''] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?>