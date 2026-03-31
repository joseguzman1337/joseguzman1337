<?php

if($_GET['semestre'] && $_GET['codigocarrera']) {

require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();

//$reporte = $utils->getDataEntity("reporte",$_GET['codigocarrera']);
//$categoria = $utils->getDataEntity("categoriaData",$reporte["categoria"]);  

require_once('../../../../../funciones/notas/funcionequivalenciapromedio.php');
require_once('../../../../../funciones/notas/redondeo.php');
require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
require_once('functionsGananciaAcademica.php');
$ruta = "../";
while (!is_file($ruta.'Connections/sala2.php'))
{
        $ruta = $ruta."../";
}
require($ruta.'Connections/sala2.php');
/* Query rango de Periodo */
$periodo = $_GET['semestre'];
$carrera = $_GET['codigocarrera'];
$arrayP = str_split($periodo, strlen($periodo)-1);
$labelPeriodo = $arrayP[0]."-".$arrayP[1];


 $array_matnuevo=obtenerEstudiantes($db,$periodo,$carrera);
 if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
   // echo "<pre>"; print_r($array_matnuevo);
    
    $totalEstudiantesCohorte = count($array_matnuevo);
    $data = obtenerMaxSemestreCarrera($db,$carrera,$periodo);
    $maxSemestre = $data["semestre"];
    //echo "<pre>"; print_r($maxSemestre); echo "<br/><br/>";
    $promedios = array();
    for($i=1; $i<=$maxSemestre; $i++){
        $sumaPromedios = 0;
        $totalEstudiantesSemestre = 0;
        for($z=0; $z<$totalEstudiantesCohorte; $z++){
            $codigoestudiante = $array_matnuevo[$z]['codigoestudiante'];
            $nota = obtenerPromedioEstudiantes($db,$codigoestudiante,$carrera,$i,$database_sala, $sala);
            $sumaPromedios += $nota;
            if($nota!=0){
                $totalEstudiantesSemestre += 1;
            }
        }
        //echo "<pre>"; print_r($sumaPromedios); echo "<br/><br/>";
        if($sumaPromedios!=0){
            $promedios[] = array("semestre"=>"Semestre " + $i,"nota"=>($sumaPromedios/$totalEstudiantesSemestre),"numEstudiantes"=>$totalEstudiantesSemestre);
        }
    }
    //echo "<pre>"; print_r($promedios); echo "<br/><br/>";

    

?>
<table id="estructuraReporte" class="previewReport formData" style="text-align:left;clear:both;margin: 10px auto;width:80%;" >
        <thead>            
             <tr class="dataColumns">
                    <th class="column" colspan="3"><span><?php echo $data["carrera"]; ?></span></th>
             </tr>        
             <tr class="dataColumns">
                    <th class="column" colspan="3"><span>Cohorte del periodo <?php echo $labelPeriodo;?> - <?php echo $totalEstudiantesCohorte; ?> Estudiantes </span></th>
             </tr>
	     <tr class="dataColumns">	
		<th class="column borderR"><span>Semestre</span></th>	
		<th class="column borderR"><span>Total de Estudiantes</span></th>	
		<th class="column borderR"><span>Promedio Semestral Cohorte</span></th>
	    </tr>
        </thead>
        <tbody>
            <?php $notas = 0;
            $numE = $totalEstudiantesCohorte;
            foreach($promedios as $promedio) {
                //arsort ($notaspromedio[$i]);?>
            <tr class="contentColumns row">
                <td class="column center borderR" ><span><?php echo $promedio["semestre"]; ?></span></td>
                <td class="column center borderR"><?php echo $promedio["numEstudiantes"]; $numE=$promedio["numEstudiantes"]; ?></td>
                <td class="column center borderR"><?php echo number_format($promedio["nota"],2); $notas+=number_format($promedio["nota"],2); ?></td>
            </tr>
        <?php } ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
                <td class="column total title borderR " style="text-align:right;"><b>Promedio Cohorte</b></td>                
                <td class="borderR" style="text-align:center"></td>                          
                <td style="text-align:center"><b><?php echo number_format($notas/count($promedios),2); ?></b></td>       
            </tr>
        </tfoot>
    </table>
<?php 
 }
 
exit();

} 
?>   


<form action="" method="post" id="ganancia" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset style="min-width: 800px;">  
		<input type="hidden" value="<?php echo $categoria["alias"]; ?>" name="categoria" />
		<label for="semestre" class="fixedLabel">Semestre/Cohorte: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<label for="modalidad" class="fixedLabel">Modalidad Acad&eacute;mica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em'>
		<option value=""></option>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
		<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
		<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
		</option>
		<?php
		}
		?>
		</select>
                
                <label for="unidadAcademica" class="fixedLabel">Unidad Académica: <span class="mandatory">(*)</span></label>
                <select name="codigocarrera" id="unidadAcademica" class="required" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>		
		
                <div class="vacio"></div>
	
	<input type="submit" value="Consultar" class="first small" style="margin-left:220px" />	
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#ganancia");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/estudiantes/viewReporteGananciaAcademica.php',
				async: false,
				data: $('#ganancia').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
        
        $('#ganancia #modalidad').change(function(event) {
                    getCarreras("#ganancia");
                });
                
                function getCarreras(formName){
                    $(formName + " #unidadAcademica").html("");
                    $(formName + " #unidadAcademica").css("width","auto");   
                        
                    if($(formName + ' #modalidad').val()!=""){
                        var mod = $(formName + ' #modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForCareersByModalidadSIC.php',
                                data: { modalidad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #unidadAcademica").html(html);
                                        $(formName + " #unidadAcademica").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
</script>    
    
    