<?
$pageName = "idiomas1";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
if (isset ($Predeterminado) && $Predeterminado == "ON")
	$Predeterminado = 1;
else
	$Predeterminado = 0;

$idioma = array ();
for ($i = 0; $i <= 6; $i++) {
	$nombre_var = $i . "_Dia";
	$idioma[$i . "_Dia"] = $$nombre_var;
}
for ($i = 1; $i <= 12; $i++) {
	$nombre_var = $i . "_Mes";
	$idioma[$i . "_Mes"] = $$nombre_var;
}
for ($i = 1; $i <= 17; $i++) {
	$nombre_var = "Evento" . $i;
	$idioma["Evento" . $i] = $$nombre_var;
}
for ($i = 1; $i <= 3; $i++) {
	$nombre_var = "Eventos_Mail_" . $i;
	$idioma["Eventos_Mail_" . $i] = $$nombre_var;
}
for ($i = 1; $i <= 17; $i++) {
	$nombre_var = "Estado_" . $i;
	$idioma["Estado_" . $i] = $$nombre_var;
}
for ($i = 1; $i <= 5; $i++) {
	$nombre_var = "Tipo_Material_" . $i;
	$idioma["Tipo_Material_" . $i] = $$nombre_var;
}
for ($i = 1; $i <= 3; $i++) {
	$nombre_var = "Perfil_Biblio_" . $i;
	$idioma["Perfil_Biblio_" . $i] = $$nombre_var;
}
for ($i = 1; $i <= 2; $i++) {
	$nombre_var = "Tipo_Pedido_" . $i;
	$idioma["Tipo_Pedido_" . $i] = $$nombre_var;
}
$idioma["Predeterminado"] = $Predeterminado;
$idioma["Nombre"] = $Nombre;
if ($idioma["Predeterminado"] == 1) {
	$res = $servicesFacade->deshacerIdiomaPredeterminado();

}

if (empty($Id)) {
	$res = $servicesFacade->agregarIdioma($idioma);
} else {
	$idioma["Id"] = $Id;
	$res = $servicesFacade->modificarIdioma($idioma);
}
?>
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?= $Mensajes["titulo.idioma"];?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-1"];?></th>
		<td><?=$Nombre;?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></th>
		<td><?if ($Predeterminado == 1){
				echo $Mensajes["ec-3"];}
			  else {
				echo $Mensajes["ec-4"];}?>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td align="right !important"> 
			<input type="button" onclick="location.href='agregarOModificarIdioma.php?operacion=0&Id=<? echo $Id; ?>'" value="<?=$Mensajes["link.agregarIdioma"];?>" />
			<input type="button" onclick="location.href='seleccionar_idioma.php'" value="<?=$Mensajes["link.listadoIdiomas"];?>" />
		</td>
	</tr>
</table>
<? require "../layouts/base_layout_admin.php";?>