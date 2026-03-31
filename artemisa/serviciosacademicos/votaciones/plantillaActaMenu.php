<?php 
$rutaado = ("../funciones/adodb/");
require_once('../Connections/salaado-pear.php');

$query = "SELECT codigoano FROM ano ORDER BY codigoano DESC ";

$anss = $sala->query($query);
$arrayAns = array();
$row = $anss->fetchRow();
do {
    $arrayAns[] = $row;
} while ($row = $anss->fetchRow());
$optionAns = null;
$optionAns.= "<option value=''></option>";
foreach ($arrayAns as $an) {
	$optionAns.= "<option value='".$an['codigoano']."'>".$an['codigoano']."</option>";
}
?> 
<table align="center" border="1">
	<tr>
		<td>Seleccione Año</td>
		<td><select name="ano" id="ano">
			<?php echo $optionAns;?>
		</select></td>
	<tr>
	<tr>
		<td>Seleccione Votación</td>
		<td align="center"><div id="checkVotacion"></div></td>
	</tr>
	<tr>
		<td>Digité Vicerrectora Académica</td>
		<td align="center"><input type="text" id="vice" autocomplete="off"></input></td>
	</tr>
	<tr>
		<td>Digité Secretario General</td>
		<td align="center"><input type="text" id="secretario" autocomplete="off"></input></td>
	</tr>
	<tr>
		<td>Digité Director de Tecnología</td>
		<td align="center"><input type="text" id="director" autocomplete="off"></input></td>
	</tr>
	<tr>
		<td>Digité Registro y Control Académico</td>
		<td align="center"><input type="text" id="registro" autocomplete="off"></input></td>
	</tr>
	<tr>
		<td>Digité Jefe Auditoría Interna</td>
		<td align="center"><input type="text" id="auditoria" autocomplete="off"></input></td>
	</tr>
	<tr >
		<td colspan="2" align="center"><input type="submit" value="Consultar" id="consultar"></input></td>
	</tr>
</table>
<script src="../votacionesV2/js/jquery.js"></script>
<script>
$().ready(function() {
	$('#ano').change(function() {
		var ano = $("#ano").val();
			$.ajax({
				type: 'POST',
				url: 'plantillaActaController.php',
				async: false,
				data: {ano:ano, action:'checkVotaciones'},                
				success:function(data){
					$('#checkVotacion').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});
				
	});
	$('#consultar').click(function(){
			  var checkid = new Array();
			  var ano = $("#ano").val();
			  var vice = $("#vice").val();
			  var secretario = $("#secretario").val();
			  var director = $("#director").val();
			  var registro = $("#registro").val();
			  var auditoria = $("#auditoria").val();
			$("input[name='checkid[]']:checked").each(function(i) {
				checkid.push($(this).val());
			});
			if(checkid == ''){
				alert("Debe Seleccionar Una Votación");
				return false;
			}
			$.ajax({
				type: 'POST',
				url: 'plantillaActa.php',
				async: false,
				data: {checkid:checkid,ano:ano,vice:vice,secretario:secretario,director:director,registro:registro,auditoria:auditoria},                
				success:function(data){
					location.href = 'plantillaActa.php?checkid='+checkid+'&ano='+ano+'&vice='+vice+'&secretario='+secretario+'&director='+director+'&registro='+registro+'&auditoria='+auditoria;
					$('#checkVotacion').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});

	  
	});
});
</script>
