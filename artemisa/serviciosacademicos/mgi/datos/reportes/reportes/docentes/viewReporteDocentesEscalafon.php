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
    $periodos = substr($_REQUEST["codigoperiodo"],-1);
    //var_dump($periodos);
    if($periodos==1 || $periodos=="1"){
        $mes = "3-".substr($_REQUEST["codigoperiodo"],0,strlen($_REQUEST["codigoperiodo"])-1);
    } else {
        $mes = "9-".substr($_REQUEST["codigoperiodo"],0,strlen($_REQUEST["codigoperiodo"])-1);
    }
    $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoestado=100 AND codigoperiodo='$mes' ";
    $row = $db->GetRow($sql);
if(!($row!=NULL && count($row)>0)){
    $periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    $sql = "SELECT * FROM siq_formTalentoHumanoDocentesEscalafon WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
    $row = $db->GetRow($sql);
        if(!($row!=NULL && count($row)>0)){
            $row["numAcademicosIAsistente"] = 0;
            $row["numAcademicosIAsociado"] = 0;
            $row["numAcademicosPAsistente"] = 0;
            $row["numAcademicosPAsociado"] = 0;
            $row["numAcademicosPTitular"] = 0;
            $row["numAcademicosOtros"] = 0;
        }
    }
$total = ($row["numAcademicosIAsistente"]+$row["numAcademicosIAsociado"]+$row["numAcademicosPAsistente"]+$row["numAcademicosPAsociado"]
        +$row["numAcademicosPTitular"]+$row["numAcademicosOtros"]);
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
		<th class="column"><span>Escalafón Docente</span></th>
		<th class="column"><span>Número Académicos</span></th>
		<th class="column"><span>Porcentaje</span></th>
	    </tr>
        </thead>
        <tbody>
               <tr class="dataColumns">
                       <td class="column">Instructor Asistente</td>
                       <td class="column center"><?php echo $row["numAcademicosIAsistente"]; ?></td>
                       <td class="column center"><?php $percent = round($row["numAcademicosIAsistente"]*100/$total, 2); 
                       echo number_format(($percent), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Instructor Asociado</td>
                       <td class="column center"><?php echo $row["numAcademicosIAsociado"]; ?></td>
                       <td class="column center"><?php $percent += round($row["numAcademicosIAsociado"]*100/$total, 2); 
                       echo number_format(($row["numAcademicosIAsociado"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Profesor Asistente</td>
                       <td class="column center"><?php echo $row["numAcademicosPAsistente"];?></td>
                       <td class="column center"><?php $percent += round($row["numAcademicosPAsistente"]*100/$total, 2); 
                       echo number_format(($row["numAcademicosPAsistente"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                      <td class="column">Profesor Asociado</td>
                      <td class="column center"><?php echo $row["numAcademicosPAsociado"];  ?></td>
                       <td class="column center"><?php $percent += round($row["numAcademicosPAsociado"]*100/$total, 2); 
                       echo number_format(($row["numAcademicosPAsociado"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                     <td class="column">Profesor Titular</td>
                     <td class="column center"><?php echo $row["numAcademicosPTitular"];  ?></td>
                       <td class="column center"><?php $percent += round($row["numAcademicosPTitular"]*100/$total, 2); 
                       echo number_format(($row["numAcademicosPTitular"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Otros</td>
                       <td class="column center"><?php echo $row["numAcademicosOtros"]; ?></td>
                     <td class="column center"><?php 
                      echo number_format(($utils->roundNumber($percent,($row["numAcademicosOtros"]*100/$total))), 2, '.', ','); ?>%</td>
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