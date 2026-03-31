<?php
include("clases/class.mysql.php");
include("clases/class.combos.php");
$selects = new selects();
$per= $_GET["id"];
$paises = $selects->cargarPaisesEditar($per);
foreach($paises as $key=>$value)
{
		echo "<option value=\"$key\">$value</option>";
}
?>