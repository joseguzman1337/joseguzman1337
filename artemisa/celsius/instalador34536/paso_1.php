<?php
/**
 * Paso 1: Seleccion de idioma
 */

$paso_numero = 1;
require "top_layout_install.php";

?>

<form action="instalador_controller.php?paso_numero=1">
<?=PASO1_TITULO?>

<select name="idioma" size="1">
	<option value="es"><?=PASO1_ES?></option>
	<option value="en"><?=PASO1_EN?></option>
	<option value="pt"><?=PASO1_PT?></option>
</select>

<input type="submit" value="<?=COMMON_BUTTON_SIGUIENTE?>"/>

</form>

<?
require "base_layout_install.php";
?>