<?php
defined('_EXEC') or die;
?>

<!--Bootstrap Table [ OPTIONAL ]-->
<?php
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");
?>
<!--Basic Columns-->
<!--===================================================-->
<div class="panel">
    <?php 
    if(empty($origin)){ 
        ?>
        <div class="panel-heading">
            <h3 class="panel-title">Mis carreas</h3>
        </div>
        <?php
    } 
    ?>
    <div class="panel-body">
        <table id="datos" data-toggle="table"
                <?php /*/ ?>data-url="data/bs-table.json"<?php /**/ ?>
                data-page-size="<?php if(!empty($origin)){ echo '10';}else{ echo '20'; } ?>"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"   >
            <thead>
                <tr>
                    <th data-field="idnumber" class="hidden-xs">#</th>
                    <th data-field="codeprogram" data-switchable="false">Codigo programa</th>
                    <th data-field="program" data-sortable="false">Programa</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($listaCarreras as $m){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td>
                            <a href="#" class="seleccionarCarrera" data-origin="<?php if(!empty($origin)){ echo $origin; } ?>" dataCodigoCarrera="<?php echo $m->getCodigocarrera();?>">
                                <?php echo $m->getCodigocarrera();?>
                            </a>
                        </td>
                        <td>
                            <a href="#" class="seleccionarCarrera" data-origin="<?php if(!empty($origin)){ echo $origin; } ?>" dataCodigoCarrera="<?php echo $m->getCodigocarrera();?>">
                                <?php echo $m->getNombrecarrera();?>
                            </a>
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
<!--===================================================-->


<!--Bootstrap Table [ OPTIONAL ]-->
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/components/misCarreras/assets/js/misCarreras.js");
?>

