<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    $filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
    $filtrosValores = array();
    $dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);
    
if(count($dates)>0){
    $filtrosValores["fechas"] = $dates;
    
if($numC>0){
    /*$data = $utils->getDataEntity("data",$columns[0]["idDato"]);
    
    $cat = $utils->getDataEntity("categoriaData",$data["categoria"]);

    $values = $utils->getDataValue($db,$data,$cat,$columns[0]["filtro"],$filtros);    
    
    $datosReporte = array();
    $datosReporte[0]["dato"] = $data;    
    $datosReporte[0]["cat"] = $cat;*/
    for($j=0; $j < $numC; $j++) {
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
                $alias = explode('.', $columns[$j]["filtro"], 2);
                if(count($alias)==2){
                
                    $datosReporte[$j]["rel"] = $datosReporte[$j]["rel"].".".$alias[1];
                    //$datosReporte[$j]["values"] = $utils->getDataValue($db,$dato,$categ,$datosReporte[$j]["rel"],array($datosReporte[$j]["rel"]=>$values[$i]["value"])); 
                    $datosReporte[$j]["values"] = $utils->getDataValue($db,$dato,$categ,$datosReporte[$j]["rel"],$filtrosValores);  
                } else {
                    $datosReporte[$j]["values"] = $utils->getDataValue($db,$dato,$categ,null,$filtrosValores);  
                }                
            } else {
                
                $datosReporte[$j]["values"] = $utils->getDataValue($db,$dato,$categ,$columns[$j]["filtro"],$filtrosValores);  
            }
        }
    }
 ?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <tbody>
            <?php for($i=0; $i < $numC; $i++) { ?>
                <tr id="contentColumns">
                    <th class="column"><span><?php echo $columns[$i]["etiqueta_columna"]; ?></span></th>
                    <td <?php if($datosReporte[$i]["dato"]["tipo_data"]==2){ ?>style="text-align:center"<?php } ?>> <?php echo $datosReporte[$i]["values"][0]["label"]; ?></td>
                 </tr>
            <?php } ?>
        </tbody>
        <?php if($reporte['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 <?php for($i=1; $i < $numC; $i++) { ?>
                    <td> </td>
                 <?php } ?>
            </tr>
        </tfoot>
        <?php } ?>
    </table>
<?php }} else {
    echo "<span style='color:red'>Todavía no ha seleccionado el rango de fechas para el reporte. Por favor vaya a editar reporte y 
        elija el rango en el Paso 3.</span>";
} ?>