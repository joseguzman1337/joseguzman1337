<?php
function combo_novalida_post($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	//DB_DataObject::debugLevel(5);
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	if($where!=''){$$nombreobjeto->whereADD($where);};
	if($ordenamiento!=''){$$nombreobjeto->orderBy($ordenamiento);};
	$$nombreobjeto->get('','*');

?>

 <select name="<?php echo $nombrevar?>" id="<?php echo $nombrevar?>" <?php echo $accion?>>
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $$nombreobjeto->$dato;?>"<?php 
              if(isset($_POST[$nombrevar]))
              {
              	if($_POST[$nombrevar] == $$nombreobjeto->$dato)
              	{
              		echo "selected";
              	}
              }
			  ?>><?php echo $$nombreobjeto->$etiqueta_dato;?></option>
              <?php
              } while ($$nombreobjeto->fetch());

}?>
</select>
<?php 
/* $valido['valido'] = 1;

if($validasino=='si'){
	//if(isset($_POST[$nombrevar])){
		if($_POST[$nombrevar] == '')
		{
			echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
		<span class='Estilo99'>*</span>";
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		
	//}
}
return $valido;
}  */?>
