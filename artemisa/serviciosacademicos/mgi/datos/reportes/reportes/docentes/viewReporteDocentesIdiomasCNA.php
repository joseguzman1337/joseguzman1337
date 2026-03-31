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
    /*$periodos = explode("-", $_REQUEST["codigoperiodo"]);
    if($periodos==1 || $periodos=="1"){
        $mes = "3-".$periodos[0];
    } else {
        $mes = "9-".$periodos[0];
    }*/
    $sql = "SELECT * FROM idioma ORDER BY nombreidioma ASC";
    $idiomas = $db->GetAll($sql);

    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="100%" >
        <thead>            
             <tr class="dataColumns">
		<th class="column" rowspan="3"><span>Estudios en curso</span></th>
		<th class="column" colspan="3"><span>Dedicación - CNA</span></th>
	    </tr>   
             <tr class="dataColumns">
		<th class="column"><span>Hora Cátedra</span></th>
		<th class="column"><span>1/2 Tiempo</span></th>
		<th class="column"><span>Tiempo Completo</span></th>
	    </tr>
             <tr class="dataColumns">
		<th class="column"><span>1 - 10 Horas</span></th>
		<th class="column"><span>11 - 28 Horas</span></th>
		<th class="column"><span>29 - 40 Horas</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php foreach($idiomas as $idioma) {
    
                $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDocentesOtroIdioma WHERE codigoestado=100 AND codigoperiodo IN $periodos AND horas<=10 AND idioma=".$idioma["ididioma"];
                $cuarto = $db->GetAll($sql);
                $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDocentesOtroIdioma WHERE codigoestado=100 AND codigoperiodo IN $periodos AND horas>10 AND horas<=28 AND idioma=".$idioma["ididioma"];
                $medio = $db->GetAll($sql);
                $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDocentesOtroIdioma WHERE codigoestado=100 AND codigoperiodo IN $periodos AND horas>28 AND idioma=".$idioma["ididioma"];
                $completo = $db->GetAll($sql);
             ?>
               <tr class="dataColumns">
                       <td class="column"><?php echo $idioma["nombreidioma"]; ?></td>
                       <td class="column center"><?php echo count($cuarto); $total1+=count($cuarto); ?></td>
                       <td class="column center"><?php echo count($medio); $total2+=count($medio); ?></td>
                       <td class="column center"><?php echo count($completo); $total4+=count($completo); ?></td>
               </tr>
               <?php } ?>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <td class="column center"><?php echo ($total1); ?></td>
                <td class="column center"><?php echo ($total2); ?></td>
                <td class="column center"><?php echo ($total4); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>