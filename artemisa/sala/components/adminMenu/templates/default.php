<?php defined('_EXEC') or die; ?>
<?php 
foreach($listMenuOpcion as $m){
    $linkAbsoluto = $m->getLinkAbsoluto();
    $linkmenuopcion = $m->getLinkmenuopcion();
    if(empty($linkAbsoluto)){
        if(!empty($linkmenuopcion)){
            $m->generarLinkAutomatico();
        }
    }
}
?>
<!--Bootstrap Table [ OPTIONAL ]-->
<link href="<?php echo HTTP_SITE;?>/assets/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<!--Basic Columns-->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Items de menú</h3>
    </div>
    <div class="panel-body">
        <button class="btn btn-success btn-labeled fa fa-plus-circle" id="nuevoMenu">Nuevo</button>
        <table id="datos" data-toggle="table"
                <?php /*/ ?>data-url="data/bs-table.json"<?php /**/ ?>
                data-toolbar="#nuevoMenu"
                data-page-size="20"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"
                data-sort-name="path"  >
            <thead>
                <tr>
                    <th data-field="idnumber">#</th>
                    <th data-field="id" data-switchable="false">ID</th>
                    <th data-field="path" data-sortable="true">Ruta padre</th>
                    <th data-field="name" data-sortable="true">Nombre Opción</th>
                    <th data-field="status" data-sortable="true">Estado</th>
                    <th data-field="edit">Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach($listMenuOpcion as $m){
                    //ddd($m->getIdpadremenuopcion());
                    $menu = $ControlMenu->getCurrentMenu($m->getIdpadremenuopcion());
                    //ddd($menu);
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $m->getIdmenuopcion();?></td>
                        <td>
                            <?php 
                            //echo $m->getIdpadremenuopcion();
                            echo Factory::renderParentPath($menu);
                            ?>
                        </td>
                        <td><?php echo $m->getNombremenuopcion();?></td>
                        <td>
                            <?php
                            echo ControlAdminMenu::printInconEstado($m->getCodigoestadomenuopcion(), $m->getIdmenuopcion());
                            ?>
                        </td>
                        <td>
                            <?php
                            echo ControlAdminMenu::printInconEditar($m->getIdmenuopcion());
                            ?>
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
echo Factory::printImportJsCss("js",HTTP_SITE."/components/adminMenu/assets/js/adminMenu.js");
?>