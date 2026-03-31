<?php 
function campotexto_novalida_get($nombrevar,$tamano,$accion){ ?>
<input name="<?php echo $nombrevar;?>" type="text" id="<?php echo $nombrevar;?>" value="<?php echo $_GET[$nombrevar];?>" size="<?php echo $tamano;?>" <?php echo $accion;?>>
<?php
} 
?>