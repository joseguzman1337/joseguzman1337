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
    //$periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    $periodos = substr($_REQUEST["codigoperiodo"],-1);
    //var_dump($periodos);
    if($periodos==1 || $periodos=="1"){
        $mes = "3-".substr($_REQUEST["codigoperiodo"],0,strlen($_REQUEST["codigoperiodo"])-1);
    } else {
        $mes = "9-".substr($_REQUEST["codigoperiodo"],0,strlen($_REQUEST["codigoperiodo"])-1);
    }
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
    $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo='$mes'";
    //echo $sql;
    $row = $db->GetRow($sql);
    if($row!=NULL && count($row)>0){
    } else {
        $periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
        $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
        $row = $db->GetRow($sql);
        if(!($row!=NULL && count($row)>0)){
            $row["numAcademicosNucleoProfesoral"] = 0;
            $row["numAcademicosAnual"] = 0;
            $row["numAcademicosSemestral"] = 0;
        }
    }
$total = ($row["numAcademicosNucleoProfesoral"]+$row["numAcademicosAnual"]+$row["numAcademicosSemestral"]);
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
		<th class="column"><span>Tipo de contrato</span></th>
		<th class="column"><span>Número Académicos</span></th>
		<th class="column"><span>Porcentaje</span></th>
	    </tr>
        </thead>
        <tbody>
               <tr class="dataColumns">
                     <td class="column">Académico Adjunto (semestral)</td>
                     <td class="column center"><?php echo $row["numAcademicosSemestral"]; ?></td>
                     <td class="column center"><?php $percent = round($row["numAcademicosSemestral"]*100/$total, 2); echo number_format(($percent), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                      <td class="column">Académico (11 meses)</td>
                      <td class="column center"><?php echo $row["numAcademicosAnual"]; ?></td>
                     <td class="column center"><?php $percent += round($row["numAcademicosAnual"]*100/$total, 2); echo number_format(($row["numAcademicosAnual"]*100/$total), 2, '.', ','); ?>%</td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Núcleo Profesoral</td>
                       <td class="column center"><?php echo $row["numAcademicosNucleoProfesoral"]; ?></td>
                     <td class="column center"><?php 
                      echo number_format(($utils->roundNumber($percent,($row["numAcademicosNucleoProfesoral"]*100/$total))), 2, '.', ','); ?>%</td>
               </tr>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <td class="column center"><?php echo $total; ?></td>
                <td class="column center"><?php echo "100%"; ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>