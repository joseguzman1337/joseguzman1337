<?php
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Gestionar Indicadores de Gestión</a></li>
        <li <?php if($active==3) { ?>class="active"<?php } ?>><a href="./inactivos.php">Indicadores Inactivos</a></li>
        <li <?php if($active==4) { ?>class="active"<?php } ?>><a href="./alert.php">Asignar Alerta</a></li>
        <li <?php if($active==5) { ?>class="active"<?php } ?>><a href="./indexAlertas.php">Gestionar Alertas</a></li>
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