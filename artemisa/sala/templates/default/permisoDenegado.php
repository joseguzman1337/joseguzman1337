<?php
defined('_EXEC') or die;
if(empty($mensaje)){
    $mensaje = "No tiene acceso a este apartado.";
}
?>
<div class="alert alert-danger text-4x">
    <strong>Alerta <i class="fa fa-exclamation-triangle"></i></strong> <?php echo $mensaje; ?>
</div>
