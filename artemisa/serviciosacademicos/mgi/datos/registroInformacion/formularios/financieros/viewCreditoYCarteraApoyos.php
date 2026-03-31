<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();
if($_GET['semestre']) {

$codigoperiodo = $_GET['semestre'];


$query_categoria="select idsiq_tipoApoyo, nombre from siq_tipoApoyo where codigoestado like '1%'";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">                   
                    <th class="column" colspan="2" style="width:66%;text-align:center;">Estudiantes Beneficiados por Apoyos o Estímulos</span></th>                    
             </tr>
             <tr class="dataColumns">
		<th class="column" style="width:16%;text-align:center;">Apoyos o Estímulos</span></th>                    
                    <th class="column" style="width:16%;text-align:center;">Número de estudiantes Beneficiados</span></th>                
             </tr>    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_eapoyosfinancieros="select valor from siq_formCreditoYCarteraApoyos where idCategory='".$row_categoria['idsiq_tipoApoyo']."'
	  and codigoperiodo='$codigoperiodo'
	  and codigoestado like '1%'";
	  $eapoyosfinancieros= $db->Execute($query_eapoyosfinancieros);
	  $row_eapoyosfinancieros= $eapoyosfinancieros->FetchRow();	  
	  
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_categoria['nombre']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $row_eapoyosfinancieros['valor']; ?></td>	      	      
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

<form action="" method="post" id="apoyosfinancieros" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='vapoyos'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#apoyosfinancieros");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#vapoyos').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewCreditoYCarteraApoyos.php',
				async: false,
				data: $('#apoyosfinancieros').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#vapoyos').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
