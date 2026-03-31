<?php 
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package templates
*/
defined('_EXEC') or die;
//d($NotificacionesApp);
?>
<?php // if(empty($tmpl) || $tmpl=="default"){ ?>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $test; ?></h3>
    </div>
    <div  class="panel-body"> 
        <button class="btn btn-success btn-labeled fa fa-plus-circle" id="nuevaNotificacion">Nueva Notificacion</button>
        <?php // } ?>
        <div id="tablaDatos">
        <table id="datos" data-toggle="table"
                <?php /*/ ?>data-url="data/bs-table.json"<?php /**/ ?>
                data-page-size="<?php if(!empty($origin)){ echo '10';}else{ echo '20'; } ?>"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"   >
            <thead>
                <tr>
                    <th data-field="idnumber" class="hidden-xs">#</th>
                    <th data-field="text" data-sortable="false">Texto</th> 
                    <th data-field="date" data-sortable="false">Fecha</th> 
                    <th data-field="status" data-sortable="false">Estado</th> 
                    <th data-field="edit" data-sortable="false">Editar</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
//                ddd($NotificacionesApp);
                foreach($NotificacionesApp as $m){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td>
                            <?php echo $m->getTexto();?>
                        </td> 
                        <td>
                            <?php 
                            $fecha=explode(" ", $m->getFecha()); 
                            echo $fecha[0];
                            ?>
                        </td> 
                        <td>
                            <?php echo $m->getEstado();?>
                        </td> 
                        <td>
                            <?php echo ControlModuloNotificacionesApp::printInconEditar($m->getId());?>
                        </td> 
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
        </div>
        <?php //if(empty($tmpl) || $tmpl=="default"){ ?>
    </div>
</div>
       
<?php
//Bootstrap Table [ OPTIONAL ]
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");

echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloNotificacionesApp/assets/js/moduloNotificacionesApp.js");
?>
 <?php //} ?>