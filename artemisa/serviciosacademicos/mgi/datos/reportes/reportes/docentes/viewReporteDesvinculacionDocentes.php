<form action="" method="post" id="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php if(isset($_REQUEST["codigoperiodo"])) {$utils->getSemestresSelect($db,"codigoperiodo",false,$_REQUEST["codigoperiodo"]); } 
                else { $utils->getSemestresSelect($db,"codigoperiodo"); } ?>
                
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_forma'></div>
	</fieldset>
</form>

<?php if(isset($_REQUEST["codigoperiodo"])) { 
    $periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDesvinculados WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
    $row = $db->GetRow($sql);
if(!($row!=NULL && count($row)>0)){
        $row["numTerminacionContrato"] = 0;
        $row["numRenunciaOportunidad"] = 0;
        $row["numRenunciaMotivosPersonales"] = 0;
        $row["numRenunciaCondicionesLaborales"] = 0;
        $row["numRenunciaViaje"] = 0;
        $row["numDespido"] = 0;
        $row["numOtro"] = 0;
    }
$total = ($row["numTerminacionContrato"]+$row["numRenunciaOportunidad"]+$row["numRenunciaMotivosPersonales"]+$row["numRenunciaCondicionesLaborales"]
        +$row["numDespido"]+$row["numRenunciaViaje"]+$row["numOtro"]);
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
                <th class="column"><span>Motivo del retiro</span></th>   
                <th class="column"><span>Número de Académicos</span></th>  
		<th class="column"><span>Porcentaje</span></th>
	    </tr>
        </thead>
        <tbody>
               <tr class="dataColumns">
                       <td class="column">Terminación de Contrato</td>
                       <td class="column center"><?php echo $row["numTerminacionContrato"]; ?></td>
                       <td class="column center"><?php $percent = round($row["numTerminacionContrato"]*100/$total, 2); 
                       echo number_format(($percent), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Renuncia por nueva oportunidad laboral</td>
                       <td class="column center"><?php echo $row["numRenunciaOportunidad"]; ?></td>
                       <td class="column center"><?php $percent += round($row["numRenunciaOportunidad"]*100/$total, 2); 
                       echo number_format(($row["numRenunciaOportunidad"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Renuncia por motivos personales</td>
                       <td class="column center"><?php echo $row["numRenunciaMotivosPersonales"];?></td>
                       <td class="column center"><?php $percent += round($row["numRenunciaMotivosPersonales"]*100/$total, 2); 
                       echo number_format(($row["numRenunciaMotivosPersonales"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                      <td class="column">Renuncia por mejores condiciones laborales</td>
                      <td class="column center"><?php echo $row["numRenunciaCondicionesLaborales"];  ?></td>
                       <td class="column center"><?php $percent += round($row["numRenunciaCondicionesLaborales"]*100/$total, 2); 
                       echo number_format(($row["numRenunciaCondicionesLaborales"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                     <td class="column">Renuncia por viaje</td>
                     <td class="column center"><?php echo $row["numRenunciaViaje"];  ?></td>
                       <td class="column center"><?php $percent += round($row["numRenunciaViaje"]*100/$total, 2); 
                       echo number_format(($row["numRenunciaViaje"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                     <td class="column">Despido</td>
                     <td class="column center"><?php echo $row["numDespido"];  ?></td>
                       <td class="column center"><?php $percent += round($row["numDespido"]*100/$total, 2); 
                       echo number_format(($row["numDespido"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Otro</td>
                       <td class="column center"><?php echo $row["numOtro"]; ?></td>
                     <td class="column center"><?php 
                      echo number_format(($utils->roundNumber($percent,($row["numOtro"]*100/$total))), 2, '.', ','); ?>%</td>
               </tr>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <td class="column center"><?php echo ($total); ?></td>
                <td class="column center">100%</td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>