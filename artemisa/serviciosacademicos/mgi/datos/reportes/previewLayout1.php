<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    $filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
    
if($numC>0){
    $data = $utils->getDataEntity("data",$columns[0]["idDato"]);
    
    $cat = $utils->getDataEntity("categoriaData",$data["categoria"]);

    $values = $utils->getDataValue($db,$data,$cat,$columns[0]["filtro"],$filtros);
    
 ?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>            
             <tr id="dataColumns">
                 <?php for($i=0; $i < $numC; $i++) { ?>
                    <th class="column"><span><?php echo $columns[$i]["etiqueta_columna"]; ?></span></th>
                 <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $numV = count($values);
            for($i=0; $i < ($numV); $i++) { ?>                   
                <tr id="contentColumns row">
                    <td class="column"><?php echo $values[$i]["label"]; ?></td>                                
                    <?php for($j=0; $j < ($numC-1); $j++) { ?>
                        <td> </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <?php if($reporte['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 <?php for($i=0; $i < ($numC-1); $i++) { ?>
                    <td> </td>
                 <?php } ?>
            </tr>
        </tfoot>
        <?php } ?>
    </table>
<?php } ?>