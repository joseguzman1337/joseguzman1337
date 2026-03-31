<?php
session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Gestionar Docentes</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./registro.php">Registrar Nuevo Docente</a></li>
        <li <?php if($active==3) { ?>class="active"<?php } ?>><a href="./registrarDocentes.php">Registrar Docentes desde Excel</a></li>
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