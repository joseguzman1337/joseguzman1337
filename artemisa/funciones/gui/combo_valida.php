<?php
function combo_valida($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	//DB_DataObject::debugLevel(5);
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->whereADD($where);
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');

?>

 <select name="<?php echo $nombrevar?>" id="<?php echo $nombrevar?>" <?php echo $accion?>>
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $$nombreobjeto->$dato;?>"<?php 
              /* if(isset($_GET[$nombrevar]))
              {
              	if($_GET[$nombrevar] == $$nombreobjeto->$dato)
              	{
              		echo "selected";
              	}
              } */
			  ?>><?php echo $$nombreobjeto->$etiqueta_dato;?></option>
              <?php
              } while ($$nombreobjeto->fetch());

?>
</select>
<?php 
//$valido['mensaje'] = "OK";
$valido['valido'] = 1;

if($validasino=='si'){
	//if(isset($_GET[$nombrevar])){
		if($_GET[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';  */
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
		//print_r($valido);
	//}
}
return $valido;
} ?>
