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
    $sql = "SELECT SUM(valorNacionalEspecializacion) as valorNacionalEspecializacion, SUM(valorNacionalMaestria) as valorNacionalMaestria,
    SUM(valorNacionalDoctorado) as valorNacionalDoctorado, SUM(valorInternacionalEspecializacion) as valorInternacionalEspecializacion,
    SUM(valorInternacionalMaestria) as valorInternacionalMaestria, SUM(valorInternacionalDoctorado) as valorInternacionalDoctorado 
    FROM siq_formTalentoHumanoPrestamosCondonables WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
    //echo $sql;
    $row = $db->GetRow($sql);
if(!($row!=NULL && count($row)>0)){
        $row["valorNacionalEspecializacion"] = 0;
        $row["valorNacionalMaestria"] = 0;
        $row["valorNacionalDoctorado"] = 0;
        $row["valorInternacionalEspecializacion"] = 0;
        $row["valorInternacionalMaestria"] = 0;
        $row["valorInternacionalDoctorado"] = 0;
    }

    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;" width="70%" >
        <thead>            
                   <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Préstamos Condonables (Aprobados por Consejo Directivo)</span></th>                                    
                   </tr>         
                   <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Estímulos</span></th>   
                            <th class="column borderR" colspan="3"><span>Nivel de Formación</span></th>  
                            <th class="column" rowspan="2"><span>Total</span></th>                        
                    </tr>
                    <tr class="dataColumns category">
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column" ><span>Doctorado</span></th> 
                    </tr>
          </thead>
        <tbody>
               <tr class="dataColumns">
                       <td class="column">Préstamos condonables Internacionales</td>
                       <td class="column center"><?php echo "$".number_format($row["valorInternacionalEspecializacion"], 0, '.', ','); ?></td>
                       <td class="column center"><?php echo "$".number_format($row["valorInternacionalMaestria"], 0, '.', ','); ?></td>
                       <td class="column center"><?php echo "$".number_format($row["valorInternacionalDoctorado"], 0, '.', ','); ?></td>
                       <td class="column center"><?php $totalI = $row["valorInternacionalEspecializacion"]+$row["valorInternacionalMaestria"]+$row["valorInternacionalDoctorado"];
                       echo "$".number_format($totalI, 0, '.', ','); ?></td>
               </tr>
               <tr class="dataColumns">
                       <td class="column">Préstamos condonables Nacionales</td>
                       <td class="column center"><?php echo "$".number_format($row["valorNacionalEspecializacion"], 0, '.', ','); ?></td>
                       <td class="column center"><?php echo "$".number_format($row["valorNacionalMaestria"], 0, '.', ','); ?></td>
                       <td class="column center"><?php echo "$".number_format($row["valorNacionalDoctorado"], 0, '.', ','); ?></td>
                       <td class="column center"><?php $totalN = $row["valorNacionalEspecializacion"]+$row["valorNacionalMaestria"]+$row["valorNacionalDoctorado"];
                       echo "$".number_format($totalN, 0, '.', ','); ?></td>
               </tr>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>   
                       <td class="column center"><?php $t = $row["valorInternacionalEspecializacion"] + $row["valorNacionalEspecializacion"];
                       echo "$".number_format($t, 0, '.', ','); ?></td>
                       <td class="column center"><?php $t = $row["valorInternacionalMaestria"] + $row["valorNacionalMaestria"];
                       echo "$".number_format($t, 0, '.', ','); ?></td>
                       <td class="column center"><?php $t = $row["valorInternacionalDoctorado"] + $row["valorNacionalDoctorado"];
                       echo "$".number_format($t, 0, '.', ','); ?></td>
                       <td class="column center"><?php $total = $totalI+$totalN;
                       echo "$".number_format($total, 0, '.', ','); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>