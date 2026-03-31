<?
/**
 * $Codigo_Idioma?
 * $Codigo_IdiomaPivot?
 * $Codigo_Pantalla?
 * $bBuscar
 */
$pageName ="traducciones2";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty($Codigo_IdiomaPivot))
	$Codigo_IdiomaPivot = $servicesFacade->getIdiomaPredeterminado();

if (empty($Codigo_Idioma))
	$Codigo_Idioma = $servicesFacade->getIdiomaPredeterminado();
	
if (empty($Codigo_Pantalla))
	$Codigo_Pantalla = 0;
if (!isset($traduccion_completa))
	$traduccion_completa = 2;

?>
<script language="JavaScript">
 function traducir_elemento(Elemento){ 
	ventana=window.open("agregarOModificarTraduccion.php?Codigo_Pantalla="+document.forms.form1.Codigo_Pantalla.value+"&Codigo_Elemento="+Elemento+"&Codigo_Idioma="+document.forms.form1.Codigo_Idioma.value,"traducciones","dependent=yes,toolbar=no,width=630, height=280, top=5, left=20");
 }  

</script>
	

<form method="GET" name="form1" action="seleccionar_traduccion.php">
	<input type="hidden" name="operacion" value="0">
	<input type="hidden" name="Elemento">

<table width="80%" class="table-form">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8"><?= $Mensajes["txt-14"]; ?>
        </td>
    </tr>
    <tr>
    	<th><?= $Mensajes['txt-12']; ?></th>
    	<td>
    		<select size="1" name="Codigo_Pantalla" >
	    		<?
	    		$pantallas = $servicesFacade->getPantallas();
				foreach ($pantallas as $pantalla) {?>
					<option value="<?= $pantalla["Id"];?>" <?if ($Codigo_Pantalla == $pantalla["Id"]) echo "selected";?>>
						<?= $pantalla["Id"];?>
					</option>
				<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-13']; ?></th>
		<td>
			<select size="1" name="Codigo_IdiomaPivot">
				<?
				$idiomas = $servicesFacade->getIdiomas();
				foreach ($idiomas as $idioma) {?>
					<option value="<?= $idioma["Id"];?>" <?if ($idioma["Id"] == $Codigo_IdiomaPivot) echo "selected";?>>
						<?= $idioma["Nombre"]; ?>
					</option>
				<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-1']; ?></th>
		<td>
			<select size="1" name="Codigo_Idioma">
				<?
				$idiomas = $servicesFacade->getIdiomas();
				foreach ($idiomas as $idioma) {?>
					<option value="<?= $idioma["Id"];?>" <?if ($idioma["Id"] == $Codigo_Idioma) echo "selected";?>>
						<?= $idioma["Nombre"]; ?>
					</option>
				<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.traduccionCompleta"]; ?></th>
		<td>
			<input type="radio" name="traduccion_completa" value="1" <?if ($traduccion_completa==1) echo "checked ";?> /><?=$Mensajes["mensaje.afirmacion"];?> 
			<input type="radio" name="traduccion_completa" value="0" <?if ($traduccion_completa==0) echo "checked ";?> /><?=$Mensajes["mensaje.negacion"];?> 
			<input type="radio" name="traduccion_completa" value="2" <?if ($traduccion_completa==2) echo "checked ";?> /><?=$Mensajes["mensaje.todas"];?>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" value="<?= $Mensajes["boton.enviar"];?>" name="bBuscar" />
		</td>
	</tr>
</table>
</form>

<? 
//imprime los resultados si corresponde
if (isset($bBuscar)){ ?>
<br/>
<table width="90%" border='0' class="table-list">
	<tr>
		<th><?= $Mensajes['txt-2']; ?></th>
		<th><?= $Mensajes['txt-3']; ?></th>
		<th><?= $Mensajes['txt-5']; ?></th>
		<th>&nbsp;</th>
	</tr>
	<?
	
	$elementos = $servicesFacade->getElementos(array ("Codigo_Pantalla" => $Codigo_Pantalla));
	
	foreach ($elementos as $elemento) {
		$traduccionPivote = $servicesFacade->getTraduccion($Codigo_Pantalla, $elemento["Codigo_Elemento"], $Codigo_IdiomaPivot);
		$traduccion = $servicesFacade->getTraduccion($Codigo_Pantalla, $elemento["Codigo_Elemento"], $Codigo_Idioma);
		
		if (($traduccion_completa == 2) 
			||
			(!empty($traduccion) && ($traduccion_completa == $traduccion["traduccion_completa"])) 
			|| 
			(empty($traduccion) && $traduccion_completa == 0)){?>
			<tr>
				<td><?= $elemento["Codigo_Elemento"]; ?></td>
				<td><?= $traduccionPivote["Texto"]; ?>&nbsp;</td>
				<td><?= $traduccion["Texto"]; ?>&nbsp;</td>
				<td><input type="button" onclick="javascript:traducir_elemento('<?= $elemento["Codigo_Elemento"]; ?>')" value="<?= $Mensajes['txt-9']; ?>"/></td>
			</tr>
		<?}
	}?>
</table>		

<?} //end del if $bBuscar 
require "../layouts/base_layout_admin.php";?> 