<?php
include("clases/class.mysql.php");
include("clases/class.combos.php");
$ciudades = new selects();
$ciudades->code = $_GET["code"];
$ciudades = $ciudades->cargarCiudades();
foreach($ciudades as $key=>$value)
{
		echo "<option value=\"$key\">$value</option>";
                //echo "<input type='text'  class='grid-5-12' required   name='ciudad' id='ciudad' title='Tipo Indicador' maxlength='120' tabindex='1' autocomplete='off' value=\"$value\" />";
}
?>