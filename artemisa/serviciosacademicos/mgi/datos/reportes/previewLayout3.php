<?php
    $columns = $utils->getAllDetalleReporte($db, $reporte["idsiq_reporte"]); 
    //$filtros = $utils->getFiltrosReporte($db, $columns[0]["idsiq_detalleReporte"]); 
    $numC = count($columns);
    
    
if($numC>0){
    $values = array(); 
    
    for($z=0; $z < $numC; $z++){
        $filtrosValores = array();
        $data = $utils->getDataEntity("data",$columns[$z]["idDato"]);

        $cat = $utils->getDataEntity("categoriaData",$data["categoria"]);
        
        $filtros = $utils->getFiltrosReporte($db, $columns[$z]["idsiq_detalleReporte"]);
        
        
        if(count($filtros)>0){
            $categoriesData = array();
            $keys = array_keys($filtros);
            for($i=0; $i < count($keys); $i++){
                $catData = explode( '.', $keys[$i]);
                $catData = $catData[count($catData)-1];
                
                $filtrosValores[$catData] = $filtros[$keys[$i]];
                
                $dataCat = $utils->getDataEntityByAlias("data",$catData); 
                $catD = $utils->getDataEntity("categoriaData",$dataCat["categoria"]);
                $categoriesD = $utils->getDataValue($db,$dataCat,$catD,$catData,$filtrosValores);
                $categoriesData =  $categoriesData + $categoriesD;
                //$categories[$z] = array("label"=>$catData,"value"=>$filtros[$keys[$i]]);
            }
            $categories[$z] = $categoriesData;
            $values[$z][0] = $utils->getDataValue($db,$data,$cat,$columns[$z]["filtro"],$filtrosValores); 
            //var_dump($values[$z][0]);
            //var_dump("<br/><br/>");
        } else { 
            //var_dump($filtros);
            //var_dump("<br/><br/>");
            
            $catData = explode( '.', $columns[$z]["filtro"]);
            $catData = $catData[count($catData)-1];
            //var_dump($columns[$z]["filtro"]);
            $dataCat = $utils->getDataEntityByAlias("data",$catData);
            $catD = $utils->getDataEntity("categoriaData",$dataCat["categoria"]);

            $categories[$z] = $utils->getDataValue($db,$dataCat,$catD);
            //var_dump($categories[$z]);
            //var_dump("<br/><br/>");

                $categoriasExcluidas = $utils->getDataEntityByQuery("categoriasExcluidas","idDetalleReporte",$columns[$z]["idsiq_detalleReporte"]);
                $categoriasExcluidasArreglo = array();
                if($categoriasExcluidas!=NULL){            
                    $categoriasExcluidasArreglo = explode(";", $categoriasExcluidas["categoriasExcluidas"]);
                }

            $numCE = count($categoriasExcluidasArreglo);    
            for($j=0; $j < $numCE; $j++) {
                $excluded = false;
                $numVC = count($categories[$z]);   
                for($i=0; $i < $numVC && !$excluded; $i++) { 
                    if($categoriasExcluidasArreglo[$j] == $categories[$z][$i]["value"]){
                            $excluded = true;
                            unset($categories[$z][$i]);
                            $categories[$z] = array_values($categories[$z]); 
                            //var_dump($categories);
                            //var_dump("<br/><br/>");
                    }  
                }
            }

            $categories[$z] = array_values($categories[$z]); 
            $numVC = count($categories[$z]);  

            for($j=0; $j < $numVC && $z==0 ; $j++) { 
                $alias = explode('.', $columns[$z]["filtro"], 2);
                if(count($alias)>1){       
                    
                    $alias = $alias[count($alias)-1];
                    $filtrosValores[$alias] = $categories[$z][$j]["value"];
                    $values[$z][$j] = $utils->getDataValue($db,$data,$cat,$columns[$z]["filtro"],$filtrosValores);    
                    unset($filtrosValores[$alias]); 

                }  else {

                    $filtrosValores[$data["alias"]] = $categories[$j]["value"];
                    $values[$z][$j] = $utils->getDataValue($db,$data,$cat,$columns[$z]["filtro"],$filtrosValores);    
                    unset($filtrosValores[$data["alias"]]);  

                }              
            }  
        }
    }
    
 ?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>            
             <tr id="dataColumns">
                 <?php for($i=0; $i < $numC; $i++) { 
                     if($i==0) { ?>
                    <th class="column"><span><?php echo $columns[$i]["etiqueta_columna"]; ?></span></th>
                    <?php } else { ?>
                    <th class="column" colspan="<?php echo count($categories[$i]);?>"><span><?php echo $columns[$i]["etiqueta_columna"]; ?></span></th>
                 <?php } } ?>
            </tr>
        </thead>
        <tbody>
            <?php   //las categorias           
                $numV = count($categories[0]);
                for($i=0; $i < ($numV); $i++) { ?>
                    <tr id="contentColumns" class="row">
                        <th class="column category"><?php if($numV>1){echo $categories[0][$i]["label"];} ?></th>                                
                        <?php for($j=1; $j < ($numC); $j++) { 
                            $numV2 = count($categories[$j]);
                                for($z=0; $z < ($numV2); $z++) { ?>
                                <!--<td class="category"> </td>-->
                                <th class="column category"><?php echo $categories[$j][$z]["label"]; ?></th> 
                        <?php } } ?>
                    </tr>
                <?php $num = count($values[0][$i]);
                    for($z=0; $z < ($num); $z++) { ?>                   
                    <tr id="contentColumns" class="row">
                        <td class="column"><?php echo $values[0][$i][$z]["label"]//. " - ". $values[0][$i][$z]["value"]; ?></td>                                
                        <?php for($j=1; $j < ($numC); $j++) { 
                            $numV2 = count($categories[$j]);
                                for($a=0; $a < ($numV2); $a++) { ?>
                                <!--<td class="category"> </td>-->
                                <td> </td>
                        <?php } } ?>
                    </tr>
                <?php } } 
             ?>
        </tbody>
        <?php if($reporte['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                 <?php for($i=1; $i < ($numC); $i++) { 
                    $numV2 = count($categories[$i]);
                      for($a=0; $a < ($numV2); $a++) { ?>
                                
                                <td> </td>
                        <?php } 
                  } ?>
            </tr>
        </tfoot>
        <?php } ?>
    </table>
<?php } ?>