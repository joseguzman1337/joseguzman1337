<?php
include("clases/class.mysql.php");
include("clases/class.combos.php");
$selects = new selects();
$paises = $selects->cargarPaises();
foreach($paises as $key=>$value)
{
		echo "<option value=\"$key\">$value</option>";
}
?>