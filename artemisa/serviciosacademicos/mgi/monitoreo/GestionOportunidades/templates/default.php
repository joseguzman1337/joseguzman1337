<?php
defined('_EXEC') or die;
?>
<!--Bootstrap Table [ OPTIONAL ]-->
<link href="<?php echo HTTP_SITE;?>/assets/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<!--Basic Columns-->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Gestión de oportunidades</h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle" id="nuevoMenu">Nuevo</button>
        <table id="datos" data-toggle="table"
                <?php /*/ ?>data-url="data/bs-table.json"<?php /**/ ?>
                data-toolbar="#nuevoMenu"
                data-page-size="10"
                data-search="true"
                data-show-pagination-switch="true"
                data-pagination="true"
                data-sort-name="idnumber"
                data-page-list="[5, 10, 20, 30, 40, 50, 100, 200, 300, 400, 500, 1000, 2000, 3000, 4000, 5000]">
            <thead>
                <tr>
                    <th data-field="idnumber" data-sortable="true">#</th>
                    <th data-field="name" data-sortable="true" data-width="250">Nombre</th>
                    <th data-field="description" data-sortable="false" data-width="500">Descripcion</th>
                    <th data-field="tipo" data-sortable="true" >Tipo</th>
                    <th data-field="factor" data-sortable="true">Factor</th>
                    <th data-field="actions" data-width="85">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($listOportunidades as $l){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $l->nombre;?></td>
                        <td><?php echo $l->descripcion;?></td>
                        <td><?php echo $l->tipooportunidad_nombre;?></td>
                        <td><?php echo $l->factorCodigo;?></td>
                        <td><?php echo $l->editIcon;?> <?php echo $l->deleteIcon;?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js"); 
echo Factory::printImportJsCss("js",HTTP_GESTION."/assets/js/default.js");
?>