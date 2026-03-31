<?php
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./indexPlantillas.php">Gestionar Plantillas</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./registroPlantilla.php">Registrar Nueva Plantilla</a></li>
        <li <?php if($active==3) { ?>class="active"<?php } ?>><a href="./plantillaCertificados.php">Editar Plantilla Certificados</a></li>
    </ul>            
</div>

<script type="text/javascript">
    calculateWidthMenu();
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
         calculateWidthMenu();
    }); 
</script>
<?php } ?>