<?php
function combo_novalida_post_bd($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje,$tablaexistente,$indicetablaexistente,$valorindicetablaexistente,$datotablaexistente)
{
	//DB_DataObject::debugLevel(5);
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	if($where!=''){$$nombreobjeto->whereADD($where);};
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');
	$$tablaexistente = DB_DataObject::factory($tablaexistente);
	$$tablaexistente->get($indicetablaexistente,$valorindicetablaexistente);

?>

 <select name="<?php echo $nombrevar?>" id="<?php echo $nombrevar?>" <?php echo $accion?>>
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $$nombreobjeto->$dato;?>"<?php 
  				if($$nombreobjeto->$dato==$$tablaexistente->$datotablaexistente)
					{
						echo "selected";
					}
			  ?>><?php echo $$nombreobjeto->$etiqueta_dato;?></option>
              <?php
              } while ($$nombreobjeto->fetch());
}
?>
</select>
<?php 
/*$valido['mensaje'] = "OK";
$valido['valido'] = 1;

if($validasino=='si'){
	//if(isset($_POST[$nombrevar])){
		if($_POST[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>'; 
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
} */
?>
