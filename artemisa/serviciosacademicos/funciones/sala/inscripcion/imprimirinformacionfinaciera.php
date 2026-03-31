<?php
//$db->debug = true;$codigoinscripcion = $_SESSION['numerodocumentosesion'];$query_tipoestudianterecursofinanciero = "select *from tipoestudianterecursofinancieroorder by 2";$tipoestudianterecursofinanciero = $db->Execute($query_tipoestudianterecursofinanciero);$totalRows_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->RecordCount();$row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow();
$query_datosgrabados = "SELECT *FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinancieroand e.codigoestado like '1%'order by nombretipoestudianterecursofinanciero";			  //echo $query_data;$datosgrabados = $db->Execute($query_datosgrabados);$totalRows_datosgrabados = $datosgrabados->RecordCount();$row_datosgrabados = $datosgrabados->FetchRow();if ($row_datosgrabados <> ""){ ?>
		<table width="670px" border="1" cellpadding="1" cellspacing="0"
			bordercolor="#E9E9E9">
			<tr id="trtitulogris">
				<td>Tipo de recurso</td>
				<td>Descripción</td>
			</tr>
<?php	do
	{ 
?>
			<tr>
				<td><?php echo $row_datosgrabados['nombretipoestudianterecursofinanciero'];?></td>
				<td><?php echo $row_datosgrabados['descripcionestudianterecursofinanciero'];?></td>
			</tr>
			<?php	}
	while($row_datosgrabados = $datosgrabados->FetchRow());?>
		</table>
<?php	   
}else{?> <!-- <tr><td>Sin datos diligenciados</td></tr> --> 
<?php}