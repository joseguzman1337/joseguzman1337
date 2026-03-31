<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    $filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
    $filtrosValores = array();
    $dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);
if(count($dates)>0){
    $filtrosValores["fechas"] = $dates;    
    
    if(count($filtros)>0){
            $keys = array_keys($filtros);
            for($i=0; $i < count($keys); $i++){
                $catData = explode( '.', $keys[$i]);
                $catData = $catData[count($catData)-1];
                
                $filtrosValores[$catData] = $filtros[$keys[$i]];                
            }
    }
    
if($numC>0){
    $data = $utils->getDataEntity("data",$columns[0]["idDato"]);
    
    $cat = $utils->getDataEntity("categoriaData",$data["categoria"]);

    $values = $utils->getDataValue($db,$data,$cat,$columns[0]["filtro"],$filtrosValores);   
    $total[0] = 0;
    
    $datosReporte = array();
    $datosReporte[0]["dato"] = $data;    
    $datosReporte[0]["cat"] = $cat;
    for($j=1; $j < $numC; $j++) {
        $total[$j] = 0;
        $dato = $utils->getDataEntity("data",$columns[$j]["idDato"]);
        $categ = $utils->getDataEntity("categoriaData",$dato["categoria"]);
        $datosReporte[$j]["dato"] = $dato;    
        $datosReporte[$j]["cat"] = $categ;
        $datosReporte[$j]["rel"] = NULL;
        if($datosReporte[$j]["dato"]["tipo_data"]==2){
            $datosReporte[$j]["rel"] = $utils->getFiltroRel($db, $dato["idsiq_data"]);
            if($datosReporte[$j]["rel"]!=null){
                // necesito que me pase en $columns[$j]["filtro"] asignatura.programaAcademico, 
                // id del programa que es $values[$i]["value"]
                // se me ocurre que asocie el dato total asignaturas con asignatura y al guardar pregunto 
                // por el dato de la primera columna cosa que pa los tipo informacion me queda
                // datoAsociado.datoColumna1 en filtro
                $datosReporte[$j]["rel"] = $datosReporte[$j]["rel"].".".$data["alias"];
            }
        }
    }
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
                <tr id="contentColumns" class="row">
                    <td class="column"><?php echo $values[$i]["label"]; ?></td>                                
                    <?php for($j=1; $j < $numC; $j++) { 
                        if($datosReporte[$j]["rel"] == null){
                            $values2 = $utils->getDataValue($db,$dato,$categ,$columns[$j]["filtro"],$filtrosValores);                        
                        } else {
                            $filtrosValores[$data["alias"]] = $values[$i]["value"];
                            $values2 = $utils->getDataValue($db,$datosReporte[$j]["dato"],$datosReporte[$j]["cat"],$datosReporte[$j]["rel"],$filtrosValores);
                        
                            unset($filtrosValores[$data["alias"]]);
                        }
                        //var_dump($values[$i]["value"]);
                        //var_dump($values2);
                        ?>
                        <td <?php if($datosReporte[$j]["dato"]["tipo_data"]==2){ ?>style="text-align:center"<?php } ?>> <?php echo $values2[0]["label"]; $total[$j] = $total[$j] + $values2[0]["label"]; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
        <?php if($reporte['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 <?php for($i=1; $i < $numC; $i++) { ?>
                    <td style="text-align:center"> <?php echo $total[$i]; ?></td>
                 <?php } ?>
            </tr>
        </tfoot>
        <?php } ?>
    </table>
<?php } } else {
    echo "<span style='color:red'>Todavía no ha seleccionado el rango de fechas para el reporte. Por favor vaya a editar reporte y 
        elija el rango en el Paso 3.</span>";
} ?>