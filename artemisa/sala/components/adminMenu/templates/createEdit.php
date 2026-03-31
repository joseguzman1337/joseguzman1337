<?php 
defined('_EXEC') or die;
$idmenuopcion = $MenuOpcion->getIdmenuopcion();
$linkmenuopcion = $MenuOpcion->getLinkmenuopcion();
$nivelmenuopcion = $MenuOpcion->getNivelmenuopcion();
$posicionmenuopcion = $MenuOpcion->getPosicionmenuopcion();
$framedestinomenuopcion = $MenuOpcion->getFramedestinomenuopcion();
$transaccionmenuopcion = $MenuOpcion->getTransaccionmenuopcion();
$codigotipomenuopcion = $MenuOpcion->getCodigotipomenuopcion();
$linkAbsoluto = $MenuOpcion->getLinkAbsoluto();
// ddd($listGerarquiaRol);
?>
<div class="panel">
    <!--Block Styled Form -->
    <!--===================================================-->
    <form id="adminForm" name="adminForm" action="<?php echo HTTP_SITE;?>/index.php">
        <input type="hidden" id="option" name="option" value="adminMenu" />
        <input type="hidden" id="task" name="task" value="save" />
        <input type="hidden" id="tmpl" name="tmpl" value="json" />
        <input type="hidden" id="idmenuopcion" name="idmenuopcion" value="<?php if(!empty($idmenuopcion)){  echo $MenuOpcion->getIdmenuopcion(); }?>" />
        <input type="hidden" id="linkmenuopcion" name="linkmenuopcion" value="<?php echo (empty($linkmenuopcion))?"":$MenuOpcion->getLinkmenuopcion();?>" />
        <input type="hidden" id="nivelmenuopcion" name="nivelmenuopcion" value="<?php echo (empty($nivelmenuopcion))?"1":$MenuOpcion->getNivelmenuopcion();//1?>" />
        <input type="hidden" id="posicionmenuopcion" name="posicionmenuopcion" value="<?php echo (empty($posicionmenuopcion))?"02":$MenuOpcion->getPosicionmenuopcion();//02?>" />
        <input type="hidden" id="framedestinomenuopcion" name="framedestinomenuopcion" value="<?php echo (empty($framedestinomenuopcion))?"contenidocentral":$MenuOpcion->getFramedestinomenuopcion();//contenidocentral?>" />
        <input type="hidden" id="transaccionmenuopcion" name="transaccionmenuopcion" value="<?php echo (empty($transaccionmenuopcion))?mktime():$MenuOpcion->getTransaccionmenuopcion();?>" />
        <input type="hidden" id="codigotipomenuopcion" name="codigotipomenuopcion" value="<?php echo (empty($codigotipomenuopcion))?"2":$MenuOpcion->getCodigotipomenuopcion();//2;?>" />
                
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="nombremenuopcion">Nombre </label>
                        <input class="form-control" type="text" id="nombremenuopcion" name="nombremenuopcion" value="<?php echo $MenuOpcion->getNombremenuopcion();?>" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="linkAbsoluto">Url absoluta <span class="text-info text-sm">(Despues de <?php echo HTTP_ROOT;?>/)</span></label>
                        <input class="form-control" type="text" id="linkAbsoluto" name="linkAbsoluto" value="<?php echo empty($linkAbsoluto)?$MenuOpcion->getLinkmenuopcion():$MenuOpcion->getLinkAbsoluto();?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="idpadremenuopcion">Padre</label>
                        <select class="form-control chosen-select" id="idpadremenuopcion" name="idpadremenuopcion">
                            <option value="0" <?php echo ($MenuOpcion->getIdpadremenuopcion()==0)?"selected":""; ?> >Inicio</option>
                            <?php
                            foreach($listMenuOpcion as $m){
                                $selected = "";
                                $menu = $ControlMenu->getCurrentMenu($m->getIdpadremenuopcion());
                                if($m->getIdmenuopcion()==$MenuOpcion->getIdpadremenuopcion()){
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $m->getIdmenuopcion();?>" <?php echo $selected; ?> ><?php echo Factory::renderParentPath($menu).$m->getNombremenuopcion();?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="codigoestadomenuopcion">Estatus</label>
                        <select class="form-control chosen-select" id="codigoestadomenuopcion" name="codigoestadomenuopcion">
                            <option value="01" <?php echo ($MenuOpcion->getCodigoestadomenuopcion()=="01")?"selected":""; ?> >Publicado</option>
                            <option value="02" <?php echo ($MenuOpcion->getCodigoestadomenuopcion()=="02")?"selected":""; ?> >Despublicado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="codigogerarquiarol">Gerarquia Rol</label>
                        <select class="form-control chosen-select" id="codigogerarquiarol" name="codigogerarquiarol">
                            <?php
                            foreach($listGerarquiaRol as $m){
                                $selected = ""; 
                                if($m->getCodigogerarquiarol()==$MenuOpcion->getCodigogerarquiarol()){
                                    $selected = "selected";
                                }
                                ?>
                                <option value="<?php echo $m->getCodigogerarquiarol();?>" <?php echo $selected; ?> ><?php echo $m->getNombregerarquiarol();?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php /*/?><div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="codigoestadomenuopcion">Estatus</label>
                        <select class="form-control chosen-select" id="codigoestadomenuopcion" name="codigoestadomenuopcion">
                            <option value="01" <?php echo ($MenuOpcion->getCodigoestadomenuopcion()=="01")?"selected":""; ?> >Publicado</option>
                            <option value="02" <?php echo ($MenuOpcion->getCodigoestadomenuopcion()=="02")?"selected":""; ?> >Despublicado</option>
                        </select>
                    </div>
                </div><?php /**/?>
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
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/adminMenu/assets/js/createEdit.js");?>