<?php
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Módulos de Información Estratégica</a></li>
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