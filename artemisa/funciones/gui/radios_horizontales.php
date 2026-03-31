<?php
function radios_horizontales($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$ordenamiento)
{
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	if(isset($where)){$$nombreobjeto->whereADD($where);}
	if(isset($ordenamiento)){$$nombreobjeto->orderBy($ordenamiento);}
	$$nombreobjeto->get('','*');
?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <?php do{ ?>
  
    <td><div align="center" class="Estilo1"><?php echo $$nombreobjeto->$etiqueta_dato;?></div></td>
    <td><input name="<?php echo $nombrevar;?>" <?php echo $accion?> type="radio" value="<?php echo $$nombreobjeto->$dato;?>" <?php if($_POST[$nombrevar]==$$nombreobjeto->$dato){echo "checked";}?>></td>
   <?php }  while ($$nombreobjeto->fetch());?>
   </tr>
</table>
<?php
} ?>
