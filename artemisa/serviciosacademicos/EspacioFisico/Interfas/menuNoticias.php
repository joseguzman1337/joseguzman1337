<?php
function writeMenuNoticia($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./noticias.php">Gestionar Noticias</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./registrarNoticia.php">Registrar Nueva Noticia</a></li>
    </ul>            
</div>

<script type="text/javascript">
    calculateWidthMenu();
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
         calculateWidthMenu();
    }); 
</script>
<?php } 

function writeMenuAprobarNoticia($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./aprobarNoticias.php">Noticias por aprobar</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./aprobarNoticias.php?aprobado=0">Noticias aprobadas</a></li>
    </ul>            
</div>

<script type="text/javascript">
    calculateWidthMenu();
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
         calculateWidthMenu();
    }); 
</script>
<?php }
?>