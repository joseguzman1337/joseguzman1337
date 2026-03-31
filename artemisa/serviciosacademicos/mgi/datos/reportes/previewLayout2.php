<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    $filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
if($numC>0){
?>  

<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <tbody>
            <?php for($i=0; $i < $numC; $i++) { ?>
                <tr id="contentColumns">
                    <th class="column"><span><?php echo $columns[$i]["etiqueta_columna"]; ?></span></th>
                    <td> </td>
                 </tr>
            <?php } ?>
        </tbody>
        <?php if($reporte['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                <td> </td>
            </tr>
        </tfoot>
        <?php } ?>
</table>
<?php } ?>