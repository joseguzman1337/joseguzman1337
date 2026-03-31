<?php
function radios_horizontales_valida_get($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->whereADD($where);
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');
?>
<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <?php do{ ?>
  
    <td><div align="center" class="Estilo1"><?php echo $$nombreobjeto->$etiqueta_dato;?></div></td>
    <td><input name="<?php echo $nombrevar;?>" <?php echo $accion?> type="radio" value="<?php echo $$nombreobjeto->$dato;?>" <?php if($_POST[$nombrevar]==$$nombreobjeto->$dato){echo "checked";}?>></td>
   <?php }  while ($$nombreobjeto->fetch());?>
   <td><?php if($_POST[$nombrevar] == ''){echo "<span class='Estilo99'>*</span>";} ?></td>
   </tr>
   
</table>
<?php
$valido['valido'] = 1;
if($validasino=='si'){
	
		if($_POST[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';  */
			/* echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
		<div align = 'center'>
		<span class='Estilo99'>*</span>
		</div>
		"; */
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		//print_r($valido);
	
}
return $valido;
} ?>
