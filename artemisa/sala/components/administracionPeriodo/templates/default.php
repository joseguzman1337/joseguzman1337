<?php
defined('_EXEC') or die;
echo Factory::printImportJsCss("js", HTTP_SITE . "/components/administracionPeriodo/assets/js/administracionPeriodo.js");
echo Factory::printImportJsCss("css", HTTP_SITE . "/components/administracionPeriodo/assets/css/css.css");
?>

<div class="col-sm-12">
    <nav class="navbar navbar-default" role="navigation"> 
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="accionMenu" data-action="listar" data-type="PeriodoMaestro">
                        <span class="fa-stack fa-lg fa-1x">
                            <i class="fa fa-calendar-o fa-stack-2x"></i>
                            <i class="fa fa-cog fa-stack-1x" style="margin-top: 4px"></i>
                        </span> Maestros
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="accionMenu" data-action="listar" data-type="PeriodoFinanciero">
                        <span class="fa-stack fa-lg fa-1x">
                            <i class="fa fa-calendar-o fa-stack-2x"></i>
                            <i class="fa fa-dollar fa-stack-1x" style="margin-top: 4px"></i>
                        </span> Financieros
                    </a> 
                </li>

                <li class="dropdown">
                    <a href="#" class="accionMenu" data-action="listar" data-type="PeriodoAcademico">
                        <span class="fa-stack fa-lg fa-1x">
                            <i class="fa fa-calendar-o fa-stack-2x"></i>
                            <i class="fa fa-graduation-cap fa-stack-1x" style="margin-top: 4px"></i>
                        </span> Academicos
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="cargarContenido" align="center">
        <div class="col-md-6 col-lg-6">
            <div class="panel panel-info panel-colorful">
                <div class="panel-body text-center">
                    <p class="h2 text-thin">Periodo Financiero Vigente</p>
                    <span class="fa-stack fa-lg fa-3x">
                        <i class="fa fa-calendar-o fa-stack-2x"></i>
                        <i class="fa fa-dollar fa-stack-1x" style="margin-top: 10px"></i>
                    </span>
                    <hr>
                    <p class="text-uppercase mar-btm text-sm"><?php echo $periodoFinancieroActual; ?></p>
                    <small>
                        <span class="text-semibold">
                            <?php echo $codigoPeriodoFinancieroActual; ?> - Programa academico: <?php echo $nombreCarrera ?>
                        </span>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="panel panel-primary panel-colorful">
                <div class="panel-body text-center">
                    <p class="h2 text-thin">Periodo Academico Vigente</p>
                    <span class="fa-stack fa-lg fa-3x">
                        <i class="fa fa-calendar-o fa-stack-2x"></i>
                        <i class="fa fa-graduation-cap fa-stack-1x" style="margin-top: 10px"></i>
                    </span>
                    <hr>
                    <p class="text-uppercase mar-btm text-sm"><?php echo $periodoAcademicoActual; ?></p>
                    <small>
                        <span class="text-semibold">
                            <?php echo $codigoPeriodoAcademicoActual; ?> - Programa academico: <?php echo $nombreCarrera ?>
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>