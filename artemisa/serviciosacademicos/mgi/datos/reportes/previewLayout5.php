<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    $filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
    
if($numC>0){
    $data = $utils->getDataEntity("data",$columns[0]["idDato"]);
    
    $cat = $utils->getDataEntity("categoriaData",$data["categoria"]);
    
    $catData = explode( '.', $columns[0]["filtro"]);
    $catData = $catData[count($catData)-1];
    
    $dataCat = $utils->getDataEntityByAlias("data",$catData);
    
    $categories = $utils->getDataValue($db,$dataCat,$cat);
    $values = array(); 
    
        $categoriasExcluidas = $utils->getDataEntityByQuery("categoriasExcluidas","idDetalleReporte",$columns[0]["idsiq_detalleReporte"]);
        $categoriasExcluidasArreglo = array();
        if($categoriasExcluidas!=NULL){            
            $categoriasExcluidasArreglo = explode(";", $categoriasExcluidas["categoriasExcluidas"]);
        }
    
     $numCE = count($categoriasExcluidasArreglo);    
     for($j=0; $j < $numCE; $j++) {
         $excluded = false;
         $numVC = count($categories);   
         for($i=0; $i < $numVC && !$excluded; $i++) { 
              if($categoriasExcluidasArreglo[$j] == $categories[$i]["value"]){
                    $excluded = true;
                    unset($categories[$i]);
                    $categories = array_values($categories); 
                    //var_dump($categories);
                    //var_dump("<br/><br/>");
             }  
         }
     }
     
     $categories = array_values($categories); 
     $numVC = count($categories);  
        
    for($j=0; $j < $numVC; $j++) { 
        $alias = explode('.', $columns[0]["filtro"], 2);
        if(count($alias)>1){       

            $alias = $alias[count($alias)-1];
            $filtrosValores[$alias] = $categories[$j]["value"];
            $values[$j] = $utils->getDataValue($db,$data,$cat,$columns[0]["filtro"],$filtrosValores);    
            unset($filtrosValores[$alias]); 
         
        }  else {

            $filtrosValores[$data["alias"]] = $categories[$j]["value"];
            $values[$j] = $utils->getDataValue($db,$data,$cat,$columns[0]["filtro"],$filtrosValores);    
            unset($filtrosValores[$data["alias"]]);  
            
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
            <?php $numV = count($categories);
            for($i=0; $i < ($numV); $i++) { ?>
                <tr id="contentColumns" class="row">
                    <th class="column category"><?php echo $categories[$i]["label"]; ?></th>                                
                    <?php for($j=0; $j < ($numC-1); $j++) { ?>
                        <td class="category"> </td>
                    <?php } ?>
                </tr>
            <?php $num = count($values[$i]);
                for($z=0; $z < ($num); $z++) { ?>                   
                <tr id="contentColumns" class="row">
                    <td class="column"><?php echo $values[$i][$z]["label"]; ?></td>                                
                    <?php for($j=0; $j < ($numC-1); $j++) { ?>
                        <td> </td>
                    <?php } ?>
                </tr>
            <?php } } ?>
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