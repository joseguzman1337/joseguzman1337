<?php 
defined('_EXEC') or die;
$idusuario = Factory::getSessionVar('idusuario');
$id=$ActividadBienestar->getId();
$nombre=$ActividadBienestar->getNombre();
$descripcion=$ActividadBienestar->getDescripcion();
$fechaLimite=$ActividadBienestar->getFechaLimite();
@list($fecha, $horaInicio)=explode(" ", $fechaLimite);
$cupo=$ActividadBienestar->getCupo();
$usuarioCreacion=$ActividadBienestar->getUsuarioCreacion();
$usuarioModificacion=$ActividadBienestar->getUsuarioModificacion();
$fechaCreacion=$ActividadBienestar->getFechaCreacion();
$fechaModificacion=$ActividadBienestar->getFechaModificacion();
$codigoEstado=$ActividadBienestar->getCodigoEstado();
$emailResponsable=$ActividadBienestar->getEmailResponsable();
$horaFin=$ActividadBienestar->getHoraFin();
$imagen=$ActividadBienestar->getImagen();
$url=$ActividadBienestar->getUrl();

?>
<div class="panel">
    <!--Block Styled Form -->
    <!--===================================================-->
    <form id="adminForm" name="adminForm" action="<?php echo HTTP_SITE;?>/index.php" enctype="multipart/form-data">
        <input type="hidden" name="option" value="moduloActividadesBienestar" />
        <input type="hidden" name="task" id="task" value="save" />
        <input type="hidden" name="tmpl" value="json" />
        <input type="hidden" name="id" value="<?php if(!empty($id)){  echo $id; }?>" />
        <input type="hidden" name="usuarioCreacion" value="<?php echo $idusuario; ?>" />
        <input type="hidden" name="usuarioModificacion" value="<?php echo $idusuario; ?>" />
        <input type="hidden" name="fechaCreacion" value="<?php echo date('Y-m-d H:i:s'); ?>" />
        <input type="hidden" name="fechaModificacion" value="<?php echo date('Y-m-d H:i:s'); ?>" />
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre </label>
                        <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="descripcion">Descripcion</label>
                        <textarea class="form-control" id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="fechaLimite">Fecha Limite </label>
                            <div class="input-group date">
                                <input class="form-control" readonly type="text" id="fechaLimite" name="fechaLimite" value="<?php echo $fecha; ?>" />
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                            </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="horaInicio">Hora Inicio </label>
                            <div class="input-group">
                                <input class="form-control" readonly type="text" id="horaInicio" name="horaInicio" value="<?php echo $horaInicio; ?>" />
                                    <span class="input-group-addon"><i class="fa fa-clock-o fa-lg"></i></span>
                            </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="horaFin">Hora Fin</label>
                        <div class="input-group">
                        <input class="form-control" readonly type="text" id="horaFin" name="horaFin" value="<?php echo $horaFin; ?>" />
                                <span class="input-group-addon"><i class="fa fa-clock-o fa-lg"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="codigoEstado">Estado</label>
                        <select class="form-control chosen-select" id="codigoEstado" name="codigoEstado">
                            <option value="100" <?php echo ($codigoEstado==100)?"selected":""; ?> >Activo</option>
                            <option value="200" <?php echo ($codigoEstado==200)?"selected":""; ?> >Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="url">Url?</label>
                        <input class="form-control" type="text" id="url" name="url" value="<?php echo $url; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="imagen">Imagen</label>
                        <input class="form-control" type="hidden" id="imagen" name="imagen" value="<?php echo $imagen; ?>"/>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*" />
                        
                        <img class="form-control" id="imagen" name="imagen" src="<?php echo $imagen; ?>" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="cupo">Cupo</label>
                        <input class="form-control" type="text" id="cupo" name="cupo" value="<?php echo $cupo; ?>" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="cupo">E-Mail Responsable</label>
                        <input class="form-control" type="text" id="emailResponsable" name="emailResponsable" value="<?php echo $emailResponsable; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right" id="seccionEnviar">
            <button class="btn btn-success btn-labeled fa fa-floppy-o" id="guardar1" type="button">Guardar</button>
        </div>
    </form>
    <!--===================================================-->
    <!--End Block Styled Form -->

</div>

<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css");
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css");
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/upload/jquery.fileupload.css");
//Bootstrap Validator [ OPTIONAL ]
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/upload/jquery.ui.widget.js");
//The basic File Upload plugin
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/upload/jquery.iframe-transport.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/upload/jquery.fileupload.js");

echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js");
//jQuery [ REQUIRED ]
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloActividadesBienestar/assets/js/createEdit.js");
 ?>