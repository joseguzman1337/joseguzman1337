<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function writeMenu($active) {
?>
<div id="menuPrincipal" class="menu">
    <ul class="littleSmaller clearfix">
		<li class="active current-item"><a href="#">Convenios <span class="arrow">▼</span></a>
		<ul class="sub-menu">
			<li <?php if($active==1) { ?>class="active current-item"<?php } ?>><a href="../convenio/listaInstituciones.php">Gestión de Instituciones</a></li>
			<li <?php if($active==2) { ?>class="active current-item"<?php } ?>><a href="../convenio/Propuestaconvenio.php">Gestión de Solicitudes de Convenios</a></li>
			<li <?php if($active==3) { ?>class="active current-item"<?php } ?>><a href="../convenio/AcuerdosCarreras.php">Gestión de Acuerdos</a></li>
			<li <?php if($active==4) { ?>class="active current-item"<?php } ?>><a href="../convenio/MenuConvenios.php">Gestión de Convenios</a></li>
			<li <?php if($active==5) { ?>class="active current-item"<?php } ?>><a href="../convenio/ReporteConvenios.php">Reporte Convenios</a></li>
			<li <?php if($active==6) { ?>class="active current-item"<?php } ?>><a href="../convenio/CargueConvenios.php">Cargue Convenios / Instituciones</a></li>
        </ul>
		</li>
    </ul>            
</div>

<?php } ?>
