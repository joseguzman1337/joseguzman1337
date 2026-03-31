<?php
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Personal Universitario</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./docentesEscalafon.php">Docentes por escalafón</a></li>
        <li <?php if($active==3) { ?>class="active"<?php } ?>><a href="./prestacionServicios.php">Personal por prestación de servicios</a></li>
        <li <?php if($active==4) { ?>class="active"<?php } ?>><a href="./docentesDesvinculados.php">Académicos desvinculados</a></li>
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