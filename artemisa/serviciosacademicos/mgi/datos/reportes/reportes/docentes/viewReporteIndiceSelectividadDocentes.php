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

    $rows = $utils->getDataIndiceSelectividadDocentes($db,$_REQUEST["codigoperiodo"]);
	//echo "<pre>";print_r($rows);
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
             <tr class="dataColumns">
		<th class="column"><span>Dedicación</span></th>
		<th class="column"><span>Número procesos<br/>de selección</span></th>
		<th class="column"><span>Número de Aspirantes</span></th>
		<th class="column"><span>Número de seleccionados</span></th>
		<th class="column"><span>Índice de selectividad (%)</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $row){ $total["aspirantes"] += $row["numAspirantes"];
			$total["procesos"] += $row["numProcesosSeleccion"];
            $total["seleccionados"] += $row["numSeleccionados"]; ?>
               <tr class="dataColumns">
                       <td class="column"><?php echo $row["nombre"]; ?></td>
                       <td class="column center"><?php echo $row["numProcesosSeleccion"]; ?></td>
                       <td class="column center"><?php echo $row["numAspirantes"]; ?></td>
                       <td class="column center"><?php echo $row["numSeleccionados"]; ?></td>
                       <td class="column center"><?php echo number_format(($row["numSeleccionados"]/$row["numAspirantes"])*100, 2, '.', ','); ?></td>
               </tr>
               <?php } ?>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                <td class="column center"><?php echo $total["procesos"]; ?></td>
                       <td class="column center"><?php echo $total["aspirantes"]; ?></td>
                       <td class="column center"><?php echo $total["seleccionados"]; ?></td>
                       <td class="column center"><?php echo number_format(($row["numSeleccionados"]/$row["numAspirantes"])*100, 2, '.', ','); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>