<?php
	session_start();
	include_once ('../templates/template.php');
	$db = writeHeader('Reporte ...',true);
	$SQL = 'SELECT ClasificacionEspaciosId, Nombre FROM ClasificacionEspacios WHERE ClasificacionEspacionPadreId = "1" AND EspaciosFisicosId = "3"';
	if($Sede=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL ;
		die;    
	}
?>
		<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="../asignacionSalones/css/jquery.datetimepicker.css"/>
        <script type="text/javascript" src="../asignacionSalones/js/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>-->
		<script type="text/javascript">
			$.datepicker.regional['es'] = {
				 closeText: 'Cerrar',
				 prevText: '<Ant',
				 nextText: 'Sig>',
				 currentText: 'Hoy',
				 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				 weekHeader: 'Sm',
				 dateFormat: 'dd/mm/yy',
				 firstDay: 1,
				 isRTL: false,
				 showMonthAfterYear: false,
				 yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);
			$(function() {
				$("#FechaInicio").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#FechaFin").datepicker({ dateFormat: 'yy-mm-dd' });
			});
			function enviar_formulario(){
				$.ajax({
					type: 'POST',
					url: '../reportes/reporteAulasDiario.php',
					async: false,
					dataType: 'html',
					data:({FechaInicio: $('#FechaInicio').val(),
						FechaFin:$('#FechaFin').val(),
						sede:$('#sede').val()
					}),
					beforeSend: function(){
						$('#boton').html('Cargando...');
					},
					error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					success: function(data){
						$('#wrapper').html(data);
					}
				});
			}
		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<div class="wrapper" id="wrapper">
			<div class="header">
				<div class="logo"></div>				
				<div class="horas">
					<form method="post" action="reporteAulasDiario.php" id="form-reporte">
						<table align="center">
							<tr>
								<td>Fecha inicio: </td>
								<td><input type="text" id="FechaInicio" name="FechaInicio" autocomplete="off" readonly="true"></td>
							</tr>
							<tr>
								<td>Fecha fin: </td>
								<td><input type="text" id="FechaFin" name="FechaFin" autocomplete="off" readonly="true"></td>
							</tr>
							<tr>
								<td>Sede: </td>
								<td><select id="sede" name="sede">
														<option value="0" selected="selected">Seleccione</option>
															<?php
																	if(!$Sede->EOF){
																		 while(!$Sede->EOF){
																			 echo '<option value="'.$Sede->fields['ClasificacionEspaciosId'].'">'.$Sede->fields['Nombre'].'</option>';
																			 $Sede->MoveNext();
																		 }
																	 }                                                        
															?>
														</select></td>
							</tr>
							<tr>
								<td colspan="2" align="center" id="boton"><input type="button" onclick="javascript:enviar_formulario();" value="Consultar" /></td>
							</tr>
						</table>
					</form>
				</div>
			</div>	
		</div>
		