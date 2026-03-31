<?php
defined('_EXEC') or die;
$idusuario = Factory::getSessionVar('idusuario');
$id=$NotificacionApp->getId();
$texto=$NotificacionApp->getTexto();
$fecha=$NotificacionApp->getFecha();
$codigoEstado=$NotificacionApp->getCodigoEstado();
$estado=$NotificacionApp->getEstado();
$usuarioCreacion=$NotificacionApp->getUsuarioCreacion();
$usuarioModificacion=$NotificacionApp->getUsuarioModificacion();
$fechaCreacion=$NotificacionApp->getFechaCreacion();
$fechaModificacion=$NotificacionApp->getFechaModificacion();
?>
<div class="panel">
    <!--Block Styled Form -->
    <!--===================================================-->
    <form id="adminForm" name="adminForm" action="<?php echo HTTP_SITE;?>/index.php">
        <input type="hidden" name="option" value="moduloNotificacionesApp" />
        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="tmpl" value="json" />
        <input type="hidden" name="id" id="id" value="<?php if(!empty($id)){  echo $id; }?>" />
        <input type="hidden" name="usuarioCreacion" value="<?php echo $idusuario; ?>" />
        <input type="hidden" name="usuarioModificacion" value="<?php echo $idusuario; ?>" />
        <input type="hidden" name="fechaCreacion" value="<?php echo date('Y-m-d H:i:s'); ?>" />
        <input type="hidden" name="fechaModificacion" value="<?php echo date('Y-m-d H:i:s'); ?>" />
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="texto">Texto</label>
                        <textarea class="form-control" id="texto" name="texto"><?php echo $texto; ?></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="fecha">Fecha</label>
                            <div class="input-group date">
                                <?php $fecha=explode(" ", $fecha); ?>
                                <input class="form-control" readonly type="text" id="fecha" name="fecha" value="<?php echo $fecha[0]; ?>" />
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="codigoEstado">Estado</label>
                        <?php if($estado=='Procesando' || $estado=='Enviado'){ ?>
                        <input class="form-control"  type="text" readonly id="estado" name="estado" value="<?php echo $estado ?>" />
                        <?php }else{ ?>
                        <select class="form-control chosen-select" id="estado" name="estado">
                            <option value="Pendiente" <?php echo ($estado=='Pendiente')?"selected":""; ?> >Pendiente</option>
                            <option value="Anulado" <?php echo ($estado=='Anulado')?"selected":""; ?> >Anulado</option>
                        </select>
                        <?php } ?>
                        <input class="form-control"  type="hidden" id="codigoEstado" name="codigoEstado" value="<?php echo $codigoEstado ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success btn-labeled fa fa-floppy-o" id="save" type="submit">Guardar</button>
        </div>
    </form>
    <!--===================================================-->
    <!--End Block Styled Form -->

</div>

<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css");
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css");
//Bootstrap Validator [ OPTIONAL ]
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");

echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js");
//jQuery [ REQUIRED ]
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloNotificacionesApp/assets/js/createEdit.js");
 ?>