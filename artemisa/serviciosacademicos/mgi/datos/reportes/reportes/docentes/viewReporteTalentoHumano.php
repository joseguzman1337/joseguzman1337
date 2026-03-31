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
        $row["numAcademicos"] = 0;
        $row["numAdministrativos"] = 0;
    }
$total = 0;
    ?>
<div id="tableDiv">
    <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;font-size:0.8em;width:70%;" >
        <thead>            
             <tr class="dataColumns">
		<th class="column" style="text-align:center;width:70%;"><span>Talento Humano</span></th>
		<th class="column" style="text-align:center;width:30%;"><span>Número de Personas</span></th>
	    </tr>
        </thead>
        <tbody>
               <tr class="dataColumns">
                     <td class="column" style="width:70%;">Académicos</td>
                     <td class="column center" style="text-align:center;width:30%;"><?php echo $row["numAcademicos"]; 
                        $total = $total + $row["numAcademicos"]; ?></td>
               </tr>
               <tr class="dataColumns">
                      <td class="column" style="width:70%;">Administrativos</td>
                      <td class="column center" style="text-align:center;width:30%;"><?php echo $row["numAdministrativos"]; 
                      $total = $total + $row["numAdministrativos"]; ?></td>
               </tr>
               <tr class="dataColumns">
                      <td class="column" style="width:70%;">Estudiantes</td>
                      <td class="column center" style="text-align:center;width:30%;"><?php echo $total_matnuevo; ?></td>
               </tr>
        </tbody>
        <tfoot>
             <tr id="totalColumns">
                <td class="column total title" style="width:70%;">Total Personal</td>   
                <td class="column center" style="text-align:center;width:30%;"><?php echo ($total); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php } ?>