<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();
if($_GET['semestre']) {

$codigoperiodo = $_GET['semestre'];


$query_categoria="select idsiq_tipoDescuento, nombre from siq_tipoDescuento where codigoestado like '1%'";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">                   
                    <th class="column" colspan="2" style="width:66%;text-align:center;">Estudiantes que se han Beneficiado por Descuentos</span></th>                    
             </tr>
             <tr class="dataColumns">
		<th class="column" style="width:16%;text-align:center;">Descuentos</span></th>                    
                    <th class="column" style="width:16%;text-align:center;">Número de estudiantes beneficiados</span></th>                
             </tr>    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_efinancierodescuentos="select valor from siq_detalleformCreditoYCarteraDescuentos where idCategory='".$row_categoria['idsiq_tipoDescuento']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $efinancierodescuentos= $db->Execute($query_efinancierodescuentos);
	  $row_efinancierodescuentos= $efinancierodescuentos->FetchRow();	  
	  
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_categoria['nombre']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_efinancierodescuentos['valor']; ?></td>	      	      
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

<form action="" method="post" id="financierodescuentos" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='vdescuentos'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#financierodescuentos");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#vdescuentos').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewCreditoYCarteraDescuentos.php',
				async: false,
				data: $('#financierodescuentos').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#vdescuentos').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
