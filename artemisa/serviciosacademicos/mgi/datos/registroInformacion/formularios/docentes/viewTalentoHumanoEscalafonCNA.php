<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();
if($_GET['mes'] && $_GET['anio']) {

$codigoperiodo = $_GET['mes']."-".$_GET['anio'];


$query_categoria="select idsiq_talentohumano_docente_escalafon, nombre from siq_talentohumano_docente_escalafon where codigoestado like '1%'";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="3" style="width:34%;"><span>ESCALAFÓN</span></th>
                    <th class="column" colspan="4" style="width:66%;text-align:center;">Dedicación Semanal de Acuerdo a la Categorización del CNA / Escalafón Docente</span></th>                    
             </tr>
             <tr class="dataColumns">
		<th class="column" style="width:16%;text-align:center;">HORA CÁTEDRA</span></th>                    
                    <th class="column" style="width:16%;text-align:center;">1/2 TIEMPO</span></th>
                    <th class="column" style="width:18%;text-align:center;">TIEMPO COMPLETO</span></th>
                    <th class="column" rowspan="2" style="width:10%;text-align:center;">TOTAL</span></th>
             </tr>
	     <tr class="dataColumns">
		<th class="column" style="width:16%;"><span>1 - 10  HORAS</span></th>
		<th class="column" style="width:16%;"><span>11 - 28  HORAS</span></th>		
		<th class="column" style="width:18	%;"><span>29 - 40  HORAS</span></th>		
	    </tr>
	    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_ededicacioncna="select catedraTiempo,medioTiempo,completoTiempo from siq_formTalentoHumanoDedicacionEscalafonCNA where idTalentoEscalafon='".$row_categoria['idsiq_talentohumano_docente_escalafon']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $ededicacioncna= $db->Execute($query_ededicacioncna);
	  $row_ededicacioncna= $ededicacioncna->FetchRow();
	  
	  $total_t=$row_ededicacioncna['catedraTiempo']+$row_ededicacioncna['medioTiempo']+$row_ededicacioncna['completoTiempo'];
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_categoria['nombre']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['catedraTiempo']; ?></td>	      
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['medioTiempo']; ?></td>	      
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_ededicacioncna['completoTiempo']; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo $total_t; ?></td>    
	</tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	 	 
	 ?>
        </tbody>        	
    </table>
<?php
exit();

}
?>

<form action="" method="post" id="dedicacioncna" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<?php $utils->getMonthsSelect("mes"); ?>
		
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='resCNA'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#dedicacioncna");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#resCNA').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewTalentoHumanoEscalafonCNA.php',
				async: false,
				data: $('#dedicacioncna').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#resCNA').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
