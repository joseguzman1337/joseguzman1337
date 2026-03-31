<form action="" method="post" id="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<label for="semestre" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php if(isset($_REQUEST["codigoperiodo"])) {$utils->getYearsSelect("codigoperiodo",$_REQUEST["codigoperiodo"]); } 
                else { $utils->getYearsSelect("codigoperiodo"); } ?>
                
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_forma'></div>
	</fieldset>
</form>
<?php if(isset($_REQUEST["codigoperiodo"])) { 
    $query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='abierto'";
    $papa= $db->GetRow($query_papa);
    
    $query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$papa['idclasificacion']."'";
    $sectores= $db->GetAll($query_sectores);
    
    $sql = "SELECT SUM(cantidad) as cantidad,tipoprograma FROM educacionabiertocerrado WHERE anio=".$_REQUEST["codigoperiodo"]." and mes IN (1,2,3,4,5,6,7,8,9,10,11,12) and estado=100 
        GROUP BY tipoprograma";
    $rows = $db->GetAll($sql);
    $cursos = array();
    $numCat = count($sectores);
    $total = 0;
    foreach($rows as $row){
        $cursos[$row["tipoprograma"]] = $row["cantidad"];
        $total += $row["cantidad"];
    }
    
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
                <th class="column"><span>Tipo</span></th>   
                <th class="column"><span>Cantidad</span></th>  
		<th class="column"><span>Porcentaje</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            foreach ($sectores as $row) { if($i!=($numCat-1)) { ?>
               <tr class="dataColumns">
                       <td class="column"><?php echo $row["clasificacion"]; ?></td>
                       <td class="column center"><?php echo number_format(($cursos[$row["idclasificacion"]]), 0, '.', ','); ?></td>
                       <td class="column center"><?php $percent += round($cursos[$row["idclasificacion"]]*100/$total, 2); 
                       echo number_format(($cursos[$row["idclasificacion"]]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
             <?php } else { ?>
               <tr class="dataColumns">
                       <td class="column"><?php echo $row["clasificacion"]; ?></td>
                       <td class="column center"><?php echo number_format(($cursos[$row["idclasificacion"]]), 0, '.', ','); ?></td>
                     <td class="column center"><?php 
                      echo number_format(($utils->roundNumber($percent,($cursos[$row["idclasificacion"]]*100/$total))), 2, '.', ','); ?>%</td>
               </tr>                 
             <?php } $i++; } ?>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <td class="column center"><?php echo number_format(($total), 0, '.', ','); ?></td>
                <td class="column center">100%</td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>