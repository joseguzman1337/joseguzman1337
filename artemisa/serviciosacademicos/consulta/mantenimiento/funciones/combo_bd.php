<?php
function combo_bd($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$tablaexistente,$indicetablaexistente,$accion)
{
	//DB_DataObject::debugLevel(5);
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->get('','*');
	
	$$tablaexistente = DB_DataObject::factory($tablaexistente);
	$$tablaexistente->get($indicetablaexistente);
?>
 <select name="<?php echo $nombrevar?>" id="<?php echo $nombrevar?>" <?php echo $accion?>>
              <option value="">Seleccionar</option>
              <?php
            do {
?>
              <option value="<?php echo $$nombreobjeto->$dato;?>"<?php 

				
				if($$nombreobjeto->$dato==$$tablaexistente->$dato)
					{
						echo "selected";
					}
					
			  ?>><?php echo $$nombreobjeto->$etiqueta_dato;?></option>
              <?php
            } while ($$nombreobjeto->fetch());

?>
            </select>


<?php } ?>