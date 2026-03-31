<form action="" method="post" id="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php if(isset($_REQUEST["codigoperiodo"])) {$utils->getSemestresSelect($db,"codigoperiodo",false,$_REQUEST["codigoperiodo"]); } 
                else { $utils->getSemestresSelect($db,"codigoperiodo"); } ?>
		
		<!--<label for="semestre" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php //if(isset($_REQUEST["codigoperiodo"])) { $utils->getYearsSelect("codigoperiodo",$_REQUEST["codigoperiodo"]); }
                    //else { $utils->getYearsSelect("codigoperiodo"); } ?>-->
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_forma'></div>
	</fieldset>
</form>

<?php if(isset($_REQUEST["codigoperiodo"])) { 
    require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    $datos_estadistica=new obtener_datos_matriculas($db,$_REQUEST["codigoperiodo"]);
    $matriculados=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos('','arreglo',"200");
    $matriculados2=$datos_estadistica->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante("","",'arreglo',"200");
    if($matriculados!=null){	
                $total_matnuevo=count($matriculados)+count($matriculados2);
    }else{
                $total_matnuevo=0;
    }
    $periodos = $utils->getMesesPeriodo($db,$_REQUEST["codigoperiodo"]);
    
    //el orden es para que me lea como numeros la primera parte del string de codigoperiodo
    $sql = "SELECT * FROM siq_formTalentoHumanoNumeroPersonas WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', -1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', -1) AS SIGNED)";
    //echo $sql;
    $row = $db->GetRow($sql);
    if($row!=NULL && count($row)>0){
        
    } else {
        $row["numAcademicosTC"] = 0;
    }
?> 
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;width:70%;" >
        <tbody>
               <tr class="dataColumns">
                     <th class="column" style="width:70%;">Profesores de TCE (Tiempo completo equivalente)</th>
                     <td class="column center" style="text-align:center;width:30%;"><?php echo number_format($row["numAcademicosTC"], 0, '.', ','); ?></td>
               </tr>
               <tr class="dataColumns">
                      <th class="column" style="width:70%;">Número de estudiantes</th>
                      <td class="column center" style="text-align:center;width:30%;"><?php echo number_format($total_matnuevo, 0, '.', ',');  ?></td>
               </tr>
               <tr class="dataColumns">
                      <th class="column" style="width:70%;text-align:right;">Relación (número de estudiantes / número docentes)</th>
                      <td class="column center" style="text-align:center;width:30%;"><?php echo number_format(($total_matnuevo/$row["numAcademicosTC"]), 2, '.', ','); ?></td>
               </tr>
        </tbody>
    </table>
</div>
<?php } ?>
