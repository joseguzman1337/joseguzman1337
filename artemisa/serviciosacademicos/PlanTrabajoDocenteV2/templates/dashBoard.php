<?php 
//d($codigoCarrera); 
//d($idDocente); 
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Autoevaluación - Cambiar Periodo</title>
    <?php 
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap-datetimepicker.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap-datetimepicker.min.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
    
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/moment.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/moment-with-locales.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-datetimepicker.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/PlanTrabajoDocenteV2/js/AutoEvaluacionCambiarPeriodo.js");
    ?>
    <script type="text/javascript">
        showLoader();
        var HTTP_SITE = "<?php echo HTTP_SITE?>";
        var HTTP_ROOT = "<?php echo HTTP_ROOT?>";
        var carreraSeleccionada = <?php echo (empty($codigoCarrera))?0:$codigoCarrera; ?>;
        var docenteSeleccionado = <?php echo (empty($idDocente))?0:$idDocente; ?>;
    </script>
</head>
<body>
    <div class="loaderContent">
        <div class="contenedorInterior">
            <i class="fa fa-spinner fa-pulse fa-5x"></i>
            <span class="sr-only">Cargando...</span>
            <div id="mensajeLoader"></div>
        </div>
    </div>
    <?php
       // d($datosConciliaciones["conId_".$listaConciliacionesFinalizadas[0]->getId()]);
    ?>
    <div class="container-fluid">
        <h1>Plan Docente Autoevaluación - Cambiar Periodo</h1>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-all-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="filter" method="post" action="<?php echo HTTP_ROOT; ?>/serviciosacademicos/PlanTrabajoDocenteV2/AutoEvaluacionCambiarPeriodo.php" >
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pad-all-5">
                                <select name="codigoperiodo" id="codigoperiodo" class="chosen-select" >
                                    <option >Filtrar por Periodo...</option>
                                    <?php
                                    foreach($listaPeriodos as $p){
                                        $selected = "";
                                        if($codigoPeriodo == $p->getCodigoperiodo()){
                                            $selected = " selected ";
                                        }
                                        ?>
                                        <option value="<?php echo $p->getCodigoperiodo(); ?>" <?php echo $selected; ?> ><?php echo $p->getCodigoperiodo(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pad-all-5">
                                <select name="codigocarrera" id="codigocarrera" class="chosen-select" >
                                    <option value="" >Filtrar por Carrera...</option>
                                    <?php
                                    foreach($listaCarreras as $c){
                                        $selected = "";
                                        if(!empty($codigoCarrera) && ($codigoCarrera == $c->getCodigocarrera()) ){
                                            $selected = " selected ";
                                        }
                                        ?>
                                        <option value="<?php echo $c->getCodigocarrera(); ?>" <?php echo $selected; ?> ><?php echo $c->getNombrecarrera(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pad-all-5">
                                <select name="iddocente" id="iddocente" class="chosen-select" >
                                    <option value="" >Filtrar por Docente...</option>
                                    <?php
                                    foreach($listaDocentes as $d){
                                        $selected = "";
                                        if( !empty($idDocente) && ($idDocente == $d->getIddocente()) ){
                                            $selected = " selected ";
                                        }
                                        ?>
                                        <option value="<?php echo $d->getIddocente(); ?>" <?php echo $selected; ?> ><?php echo $d->getNumerodocumento(); ?> - <?php echo $d->getNombredocente()." ".$d->getApellidodocente(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pad-all-5">
                                <input type="submit" value="Filtrar" id="Filtrar" class="btn btn-fill-green-XL btn-labeled fa fa-plus" />
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Documento Docente</th>
                                <th>Nombre Docente</th>
                                <th>Email Docente</th>
                                <th>Descripcion Autoevaluacion</th>
                                <th>Codigo Periodo</th>
                                <th>Codigo Carrera</th>
                                <th>Nombre Carrera</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach($listaAutoevaluacionDoncentes as $l){
                                unset($Docente);
                                $Docente = new Docente();
                                $Docente->setDb();
                                $Docente->setIddocente($l->getDocenteId());
                                $Docente->getById();
                                
                                unset($Carrera);
                                $Carrera = new Carrera();
                                $Carrera->setDb();
                                $Carrera->setCodigocarrera($l->getCodigoCarrera());
                                $Carrera->getById();
                                //ddd($l);
                                        //text-ColorGray60
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $Docente->getNumerodocumento(); ?>
                                    </td>
                                    <td>
                                        <?php echo $Docente->getNombredocente()." ".$Docente->getApellidodocente(); ?>
                                    </td>
                                    <td>
                                        <?php echo $Docente->getEmaildocente(); ?>
                                    </td>
                                    <td>
                                        <?php echo $l->getDescripcion(); ?>
                                    </td>
                                    <td>
                                        <?php echo $l->getCodigoPeriodo(); ?> 
                                        <?php echo DashBoard::printInconEditar($l->getAutoevaluacionDocentesId()); ?>
                                    </td>
                                    <td>
                                        <?php echo $l->getCodigoCarrera(); ?>
                                    </td>
                                    <td>
                                        <?php echo $Carrera->getNombrecarrera(); ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Trigger the modal with a button -->
    <a href="#" id="triggerModal" data-toggle="modal" data-target="#myModal">&nbsp;</a>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" id="modalHeader">
                    <button type="button" class="close" data-dismiss="modal" data-toggle="tooltip" title="Clic para cerrar"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <h4 class="modal-title" id="modalTitle">Modal titulo</h4>
                </div>
                <div class="modal-body" id="modalBoby">
                    <p></p>
                </div>
                <div class="modal-footer" id="modalFooter">
                    <button class="btn btn-danger btn-labeled fa fa-times" id="cerrarModal" type="button" data-dismiss="modal" data-toggle="tooltip" title="Clic para cerar" >Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body> 

