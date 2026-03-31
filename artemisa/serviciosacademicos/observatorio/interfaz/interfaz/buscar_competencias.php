<?php include("funciones_competencias.php"); ?>
		<link rel="stylesheet" type="text/css" href="../../js/datatables/media/css/jquery.dataTables.css" media="screen" />
		<style>
		.dataTables_paginate{
			display:block;min-width:450px;
		}
		</style>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/datatables/extensions/TableTools/js/dataTables.tableTools.js"></script>
		<script type="text/javascript" language="javascript" class="init">
		$(document).ready(function() {
			$('#example').dataTable( {
				"dom": 'T<"clear">lfrtip',
				"language": {
						"url": "../../js/datatables/Spanish.json"
					},
					"tableTools": {
						"aButtons": [
							"copy",						
							{
								"sExtends": "csv",
								"sFileName": "Competencias.csv"
							},	
							{
								"sExtends": "xls",
								"sFileName": "Competencias.xls",
                                "bFooter": false
							},	
							{
								"sExtends": "pdf",
								"sFileName": "Competencias.pdf"
							},		
							{
								"sExtends": "print",
								"sButtonText": "Imprimir"
							}
						],
						"sSwfPath": "../../js/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
						"sPrintMessage": ""
					}				
				/*"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "funciones_competencias.php",
					"type": 'POST',
					"data": { 
						"periodo" : "<?php echo $_POST["periodo"]; ?>",
						"modalidad" : "<?php echo $_POST["modalidad"]; ?>",
						"carrera" : "<?php echo $_POST["carrera"]; ?>"
					}
				},		
				"columns": [
					{ "data": "nombrecarrera" },
					{ "data": "nombreEstudiante" },
					{ "data": "numerodocumento" }
				] */
			} );
		} );
	</script>
<?php //var_dump($MateriasExamenNuevo); ?>
	<div style="margin-top:20px;">
		<table id="example" class="display" cellspacing="0" width="100%" >
			<thead>
				<tr>
					<th>Programa</th>
					<th>Nombre</th>
					<th>No. de Documento</th>
					<?php foreach($MateriasExamenNuevo as $materia){ ?>
						<th><?php echo $materia["nombreasignaturaestado"]; ?></th>
						<th>Quintil</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach($D_ExamenEstado as $estudiante){ ?>
			<tr>
				<td><?php echo $estudiante["nombrecarrera"]; ?></td>
				<td><?php echo $estudiante["nombreEstudiante"]; ?></td>
				<td><?php echo $estudiante["numerodocumento"]; ?></td>
				<?php foreach($MateriasExamenNuevo as $materia){ ?>
					<td><?php echo $estudiantes[$estudiante["codigoestudiante"]][$materia["idasignaturaestado"]]["valor"]; ?></td>
					<td><?php echo $estudiantes[$estudiante["codigoestudiante"]][$materia["idasignaturaestado"]]["quintil"]; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Programa</th>
					<th>Nombre</th>
					<th>No. de Documento</th>
					<?php foreach($MateriasExamenNuevo as $materia){ ?>
						<th><?php echo $materia["nombreasignaturaestado"]; ?></th>
						<th>Quintil</th>
					<?php } ?>
				</tr>
			</tfoot>
		</table>
	</div>