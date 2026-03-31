<?php 
defined('_EXEC') or die;
//d($oportunidadEditar);
?>
<div class="panel">
    <!--Block Styled Form -->
    <!--===================================================-->
    <form id="crearEditarOportunidad" name="crearEditarOportunidad" action="<?php echo HTTP_GESTION;?>/index.php">
        <input type="hidden" name="option" value="default" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="tmpl" value="json" />
        <input type="hidden" name="idsiq_oportunidad" value="<?php echo !empty($oportunidadEditar->idsiq_oportunidad)?$oportunidadEditar->idsiq_oportunidad:"";?>" />
        <input type="hidden" name="usuariocreacion" value="<?php echo !empty($oportunidadEditar->usuariocreacion)?$oportunidadEditar->usuariocreacion:"";?>" />
        <input type="hidden" name="fechacreacion" value="<?php echo !empty($oportunidadEditar->fechacreacion)?$oportunidadEditar->fechacreacion:"";?>" />
        <input type="hidden" name="codigoestado" value="<?php echo !empty($oportunidadEditar->codigoestado)?$oportunidadEditar->codigoestado:"";?>" />
        
                
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="nombre" required>Nombre </label>
                        <input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo !empty($oportunidadEditar->nombre)?$oportunidadEditar->nombre:"";?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="idsiq_estructuradocumento">Documento de acreditación</label>
                        <select class="form-control chosen-select" id="idsiq_estructuradocumento" name="idsiq_estructuradocumento">
                            <option value="0" <?php echo !empty($oportunidadEditar->idsiq_estructuradocumento)?"selected":"";?> >Seleccione...</option>
                            <?php
                            foreach($listDocumentos as $l){
                                ?>
                                <option value="<?php echo $l->idDocumento;?>" <?php echo ($oportunidadEditar->idsiq_estructuradocumento==$l->idDocumento)?"selected":"";?>><?php echo $l->nombreDocumento;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="idsiq_factorestructuradocumento">Factor</label>
                        <select class="form-control chosen-select" id="idsiq_factorestructuradocumento" name="idsiq_factorestructuradocumento">
                            <option value="0" <?php echo !empty($oportunidadEditar->factor_id)?"selected":"";?>>Seleccione...</option>
                            <?php
                            foreach($listFactores as $l){
                                ?>
                                <option value="<?php echo $l->id;?>" <?php echo ($oportunidadEditar->idsiq_factorestructuradocumento==$l->id)?"selected":"";?>><?php echo $l->nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="idsiq_tipooportunidad">Tipo de oportunidad</label>
                        <select class="form-control chosen-select" id="idsiq_tipooportunidad" name="idsiq_tipooportunidad">
                            <option value="0" <?php echo !empty($oportunidadEditar->idsiq_tipooportunidad)?"selected":"";?>>Seleccione...</option>
                            <?php
                            foreach($listTipoOportunidad as $l){
                                ?>
                                <option value="<?php echo $l->id;?>" <?php echo ($oportunidadEditar->idsiq_tipooportunidad==$l->id)?"selected":"";?>><?php echo $l->nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="descripcion" required>Descripción</label>
                        <textarea class="form-control"  id="descripcion" name="descripcion" placeholder="Descripción" ><?php echo !empty($oportunidadEditar->descripcion)?$oportunidadEditar->descripcion:"";?></textarea>
                    </div>
                </div>
                <!--<div class="col-sm-6">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="nombremenuopcion">Valoracion</label>
                            <select class="form-control chosen-select" id="idsiq_estructuradocumento" name="idsiq_estructuradocumento">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label" for="nombremenuopcion">Estado</label>
                            <input class="form-control" type="text" id="nombremenuopcion" name="nombremenuopcion" value="" />
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success btn-labeled fa fa-floppy-o" id="save" type="submit">Guardar</button>
        </div>
    </form>
    <!--===================================================-->
    <!--End Block Styled Form -->

</div>

<!--Bootstrap Validator [ OPTIONAL ]-->
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-validator/bootstrapValidator.min.js");?>
<!--jQuery [ REQUIRED ]-->
<?php echo Factory::printImportJsCss("js",HTTP_GESTION."/assets/js/createEdit.js");?>