<?php
	session_start();
	include_once ('../templates/template.php');
	$db = getBD();
	$SQL = 'SELECT ClasificacionEspaciosId, Nombre FROM ClasificacionEspacios WHERE ClasificacionEspacionPadreId = "1" AND EspaciosFisicosId = "3"';
	if($Sede=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL ;
		die;    
	}
?>
<html>
    <head>
        <title>Monitoreo de aulas</title>
		<script type="text/javascript" charset="utf-8" src="../js/jquery-1.13.1.js"></script>
		<script type="text/javascript" charset="utf-8" src="../js/function.js"></script>
		<?php
                /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
                 *Se cambia js por<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> por js local
                 *@since November 29,2018
                 */
                ?>
                <script src="../../../assets/js/jquery-ui.js"></script>
              
                <script>
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
		</script>
		<?php 
                /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
                 *se cambia css externa <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
                  por local 
                 *@since November 29,2018
                 */
                ?>
		<link rel="stylesheet" href="../../../assets/css/jquery-ui-git.css">
                
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="logo"></div>				
				<div class="horas">
					<form method="post" action="resultado_ocupacion.php" id="form-reporte">
						<table align="center">
							<tr>
								<td>Fecha inicio: </td>
								<td><input type="text" id="FechaInicio" name="FechaInicio"></td>
							</tr>
							<tr>
								<td>Fecha fin: </td>
								<td><input type="text" id="FechaFin" name="FechaFin"></td>
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
								<td colspan="2" align="center"><input type="submit" value="Consultar" /></td>
							</tr>
						</table>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>