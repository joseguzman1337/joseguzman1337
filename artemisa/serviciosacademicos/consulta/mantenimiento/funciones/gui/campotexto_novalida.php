<?php 
function campotexto_novalida($nombrevar,$tamano,$accion){ ?>
<input name="<?php echo $nombrevar;?>" type="text" id="<?php echo $nombrevar;?>" value="<?php echo $_POST[$nombrevar];?>" size="<?php echo $tamano;?>" <?php echo $accion;?>>
<?php
} 
?>