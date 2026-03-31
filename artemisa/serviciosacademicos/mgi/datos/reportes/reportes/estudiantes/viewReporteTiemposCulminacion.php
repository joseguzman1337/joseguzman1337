<?php

if($_GET['semestre'] && $_GET['codigocarrera']) {


	require_once("../../../templates/template.php");
	$db = getBD();
        require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
        require_once('functionsGananciaAcademica.php');
        require_once('functionsTiemposCulminacion.php');
        $utils = new Utils_datos();
	$codigocarrera=$_GET['codigocarrera'];
	$periodo=$_REQUEST['semestre'];
	//$periodo_inicial=$_REQUEST['semestre'];
	//$periodo_final=$_REQUEST['semestre'];
        $arrayP = str_split($periodo, strlen($periodo)-1);
        $labelPeriodo = $arrayP[0]."-".$arrayP[1];
	$reporte = $utils->getDataEntity("reporte",$codigocarrera);
	$data = $utils->getDataEntity("carrera",$codigocarrera,"","codigocarrera");
    $enlace = $_GET["urlview"];		
        $array_matnuevo=obtenerEstudiantes($db,$periodo,$codigocarrera);
        if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
            //echo "<pre>"; print_r($array_matnuevo);

            $totalEstudiantesCohorte = count($array_matnuevo);
			$estudiantes = clasificarEstudiantes($db,$array_matnuevo,$totalEstudiantesCohorte,false,true);
        }
        
	/*function duracion ($codigoperiodo,$codigocarrera,$db) {
		$query="SELECT	 fechainicioperiodo
				,fechavencimientoperiodo 
			FROM periodo 
			WHERE codigoperiodo=$codigoperiodo";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
	  
		$query="SELECT DISTINCT codigoestudiante
			FROM registrograduado
			JOIN estudiante USING(codigoestudiante)
			WHERE fechagradoregistrograduado BETWEEN '".$row['fechainicioperiodo']."' AND '".$row['fechavencimientoperiodo']."'
				AND codigocarrera=$codigocarrera";
		$exec= $db->Execute($query);
		$conteoestudiante = $exec->RecordCount();
		
		$query2="SELECT	 distinct 
				 codigoperiodo
				,codigoestudiante
			FROM ($query) AS sub
			JOIN notahistorico nh USING(codigoestudiante)";
		$exec2= $db->Execute($query2);
		$conteoperiodos = $exec2->RecordCount();
		

		return round($conteoperiodos/$conteoestudiante);
	}*/

?>
	<table id="estructuraReporte" class="previewReport formData" style="text-align:left;clear:both;margin: 10px auto;width:80%;">
		<thead>           
			<tr class="dataColumns">
				<th class="column" colspan="3"><span><?php echo $data["nombrecarrera"]; ?></span></th>
                        </tr>
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Cohorte del periodo <?php echo $labelPeriodo;?> - <?php echo $totalEstudiantesCohorte; ?> Estudiantes </span></th>
                        </tr>
                        <tr class="dataColumns">
				<th class="column borderR"><span>Semestre de Grado</span></th>
				<th class="column borderR"><span>Total de Estudiantes</span></th>
                <th class="column borderR"><span>Porcentaje de Estudiantes</span></th>
			</tr>			
		</thead>
		<tbody>
<?PHP 
		/*$query="SELECT	 fechainicioperiodo
				,fechavencimientoperiodo 
			FROM periodo 
			WHERE codigoperiodo=$periodo";
		$exec= $db->Execute($query);
		$row = $exec->FetchRow();
	  
		$query="SELECT DISTINCT codigoestudiante, concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) as nombre
			FROM registrograduado
			JOIN estudiante USING(codigoestudiante)
			join estudiantegeneral USING(idestudiantegeneral)
			WHERE fechagradoregistrograduado BETWEEN '".$row['fechainicioperiodo']."' AND '".$row['fechavencimientoperiodo']."'
			AND codigocarrera=$codigocarrera
			order by 2";
		$exec= $db->Execute($query);
		$conteoestudiante = $exec->RecordCount();
		$cuenta=1;
		while($row_estud = $exec->FetchRow()) {
		
		$query_cantidad="select distinct codigoperiodo ,codigoestudiante 
		from notahistorico 
		where codigoestudiante='".$row_estud['codigoestudiante']."'";
		$exec_can= $db->Execute($query_cantidad);
		$conteoperiodos = $exec_can->RecordCount();*/
		if(count($estudiantes)>0){ 
                    $periodosGrados = count($estudiantes["graduados"]);
                    $contG = 0;
                    if($periodosGrados>0){
                        foreach ($estudiantes["graduados"] as $periodo => $value) {    
                            $contG += $value["cantidad"];    
                            $arrayP = str_split($periodo, strlen($periodo)-1);
                            $labelPeriodo = $arrayP[0]."-".$arrayP[1];
		
?>
		<tr class="contentColumns row">
                    <td class="column borderR">Graduados <?php echo $labelPeriodo; ?></td>
					<td class="column borderR center" ><?php if($enlace){ echo '<a href="./viewDetalleTiemposCulminacion.php?situacion='.$value["situacion"].'&c='.$codigocarrera.'&p='.$_REQUEST['semestre'].'&grado='.$periodo.'">';} ?>
							<?PHP echo $value["cantidad"]?><?php if($enlace){ echo '</a>'; } ?></td>
                    <td class="column borderR center" ><?PHP echo number_format((($value["cantidad"]*100)/$totalEstudiantesCohorte),'2','.','.')?>%</td>
		</tr>
                <?php }} ?>
                <tr class="contentColumns row">
                    <td class="column borderR right"><strong>Total graduados</strong></td>
                    <td class="column borderR center" ><strong><?PHP echo $contG?></strong></td>
                    <td class="column borderR center" ><strong><?PHP echo number_format((($contG*100)/$totalEstudiantesCohorte),'2','.','.')?>%</strong></td>
		</tr>
		<?php $periodosGrados = count($estudiantes["desertores"]);
                    $contG = 0;
                    if($periodosGrados>0){
                        foreach ($estudiantes["desertores"] as $key => $value) {    
                            $contG += $value["cantidad"];    
		
?>
		<tr class="contentColumns row">
                    <td class="column borderR"><?php echo $key; ?></td>
                    <td class="column borderR center" ><?php if($enlace){ echo '<a href="./viewDetalleTiemposCulminacion.php?situacion='.$value["situacion"].'&c='.$codigocarrera.'&p='.$_REQUEST['semestre'].'">';} ?>
							<?PHP echo $value["cantidad"]?><?php if($enlace){ echo '</a>'; } ?></td>
                    <td class="column borderR center" ><?PHP echo number_format((($value["cantidad"]*100)/$totalEstudiantesCohorte),'2','.','.')?>%</td>
		</tr>
                <?php }} ?>
                <tr class="contentColumns row">
                    <td class="column borderR right"><strong>Total desertores</strong></td>
                    <td class="column borderR center" ><strong><?PHP echo $contG?></strong></td>
                    <td class="column borderR center" ><strong><?PHP echo number_format((($contG*100)/$totalEstudiantesCohorte),'2','.','.')?>%</strong></td>
		</tr>
                <?php $periodosGrados = count($estudiantes["sinGrado"]);
                    $contG = 0;
                    if($periodosGrados>0){ 
                        foreach ($estudiantes["sinGrado"] as $key => $value) {    
                            $contG += $value["cantidad"];    
                           ?>
                        <tr class="contentColumns row">
                            <td class="column borderR"><?php echo $key; ?></td>
                            <td class="column borderR center" ><?php if($enlace){ echo '<a href="./viewDetalleTiemposCulminacion.php?situacion='.$value["situacion"].'&c='.$codigocarrera.'&p='.$_REQUEST['semestre'].'">';} ?>
							<?PHP echo $value["cantidad"]?><?php if($enlace){ echo '</a>'; } ?></td>
                            <td class="column borderR center" ><?PHP echo number_format((($value["cantidad"]*100)/$totalEstudiantesCohorte),'2','.','.')?>%</td>
                        </tr>
                 <?php   }} ?>
		<tr class="contentColumns row">
                    <td class="column borderR right"><strong>Total de estudiantes sin graduarse</strong></td>
                    <td class="column borderR center" ><strong><?PHP echo $contG?></strong></td>
                    <td class="column borderR center" ><strong><?PHP echo number_format((($contG*100)/$totalEstudiantesCohorte),'2','.','.')?>%</strong></td>
		</tr>

<?PHP 
		/*$totalconteoperiodo=$totalconteoperiodo+$conteoperiodos;
		$cuenta++;*/
		}		//
?>					
		</tbody>
		<!--<tfoot>
		  <tr class="totalColumns">
		    <td class="column total title" colspan="2"><b>TOTAL PROMEDIO TIEMPO DE CULMINACIÓN</b></td>
		    <td style="text-align:center"><b><?php //echo round($totalconteoperiodo/$conteoestudiante); ?></b></td>
		  </tr>
	      </tfoot>-->
	</table>
<?PHP 
	exit;
}
?>
<?PHP //echo '<pre>';print_r($db);
if($UrlView==1){
    $Url = '../../mgi/datos/';
    $Imagen = '../../mgi/'; 
    $Report = '../../mgi/datos/reportes/';  
	$enlace = true;
    ?>
    <link rel="stylesheet" href="../../mgi/css/cssreset-min.css" type="text/css" /> 
    <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
    <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>
    <?PHP
 
}else{
    $Url = '../';
    $Imagen = '../../';
    $Report = '';
	$enlace = false;
}

?>
<form action="" method="post" id="forma" class="report">
	<br>
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<input type="hidden" name="urlview" value="<?php echo $enlace; ?>" />
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
        <img src="<?PHP echo $Imagen?>images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
		<div id='respuesta_forma'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) { 
		event.preventDefault();
		var valido= validateForm("#forma");
      
		if(valido){
			$('#respuesta_forma').html('<br><center><img src="<?PHP echo $Imagen?>images/ajax-loader.gif"> <b>Generando reporte, por favor espere...</b></center>');
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
			type: 'GET',
			url: '<?PHP echo $Report?>reportes/estudiantes/viewReporteTiemposCulminacion.php',
			async: false,
			data: $('#forma').serialize(),                
			success:function(data){
				$('#respuesta_forma').html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
	  });            
	}
	$('#forma #modalidad').change(function(event){
                   //getCarreras('#forma');
                   Carreras('#forma');
                   
     });
     
     function Carreras(formName){
        
       
        
        $(formName + " #unidadAcademica").html("");
        $(formName + " #unidadAcademica").css("width","auto");   
            
        if($(formName + ' #modalidad').val()!=""){
            var mod = $(formName + ' #modalidad').val();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: '<?PHP echo $Url?>searchs/lookForCareersByModalidadSIC.php',
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
               
                function getCarreras(formName){
                    
                }

</script>
