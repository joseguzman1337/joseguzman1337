<?php 
defined('_EXEC') or die; 
$idusuario = Factory::getSessionVar('idusuario');
$id=$StreamingActividadBienestar->getId();
$url=$StreamingActividadBienestar->getUrl();
$tipo=$StreamingActividadBienestar->getTipo();
$usuarioCreacion=$StreamingActividadBienestar->getUsuarioCreacion();
$usuarioModificacion=$StreamingActividadBienestar->getUsuarioModificacion();
$fechaCreacion=$StreamingActividadBienestar->getFechaCreacion();
$fechaModificacion=$StreamingActividadBienestar->getFechaModificacion();
$codigoEstado=$StreamingActividadBienestar->getCodigoEstado();
?>
<div class="panel">
    <!--Block Styled Form -->
    <!--===================================================-->
    <form id="adminForm" name="adminForm" action="<?php echo HTTP_SITE;?>/index.php">
        <input type="hidden" name="option" value="moduloStreamingActividadesBienestar" />
        <input type="hidden" name="task" value="save" />
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
                        <label class="control-label" for="url">Url </label>
                        <input class="form-control" type="text" id="url" name="url" value="<?php echo $url; ?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="tipo">Tipo</label>
                        <select class="form-control chosen-select" id="tipo" name="tipo">
                            <option value="web" <?php echo ($tipo=="web")?"selected":""; ?> >Web</option>
                            <option value="streaming" <?php echo ($tipo=="streaming")?"selected":""; ?> >Streaming</option>
                        </select>
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
//Bootstrap Validator [ OPTIONAL ]
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");
//jQuery [ REQUIRED ]
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloStreamingActividadesBienestar/assets/js/createEdit.js");
 ?>