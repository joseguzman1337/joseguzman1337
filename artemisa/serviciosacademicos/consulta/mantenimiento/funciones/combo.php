<?php
function combo($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where)
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
			
?>
            </select>


<?php } ?>