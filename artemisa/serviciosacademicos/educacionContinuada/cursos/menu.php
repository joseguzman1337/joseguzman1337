<?php
/*session_start;
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Gestionar Programas</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./registrarCursoPorWeb.php">Registrar Nuevo Programa</a></li>
        <li <?php if($active==4) { ?>class="active"<?php } ?>><a href="./registrarCursos.php">Registrar Programas desde Excel</a></li>
        <li <?php if($active==5) { ?>class="active"<?php } ?>><a href="./inscribirParticipantes.php">Inscribir Estudiantes desde Excel</a></li>
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