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
    
    $sql = "SELECT * FROM siq_tipoCursoIdioma ORDER BY nombre ASC";
    $tipos = $db->GetAll($sql);

    $sql = "SELECT * FROM siq_nivelIdioma ORDER BY nombre ASC";
    $niveles = $db->GetAll($sql);
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="100%" >
        <thead>            
             <tr class="dataColumns">
		<th class="column"><span>Niveles de Competencia</span></th>
                <?php foreach($tipos as $tipo) { ?>
		<th class="column"><span><?php echo $tipo["nombre"]; ?></span></th>
                <?php } ?>
	    </tr>   
        </thead>
        <tbody>
            <?php foreach($niveles as $nivel) { ?>
               <tr class="dataColumns">
                       <td class="column"><?php echo $nivel["nombre"]; ?></td>
                       <?php foreach($tipos as $tipo) { 
                           $sql = "SELECT * FROM siq_formTalentoHumanoAcademicosDocentesOtroIdioma WHERE codigoestado=100 AND codigoperiodo IN $periodos AND tipoCurso<=".$tipo["idsiq_tipoCursoIdioma"]." AND nivel=".$nivel["idsiq_nivelIdioma"];
                $results = $db->GetAll($sql);
                           ?>
                            <td class="column center"><?php echo count($results); $total[$tipo["idsiq_tipoCursoIdioma"]]+=count($results);?></td>
                        <?php } ?>
               </tr>
               <?php } ?>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <?php foreach($tipos as $tipo) { ?>
                <td class="column center"><?php echo ($total[$tipo["idsiq_tipoCursoIdioma"]]); ?></td>
                <?php } ?>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>