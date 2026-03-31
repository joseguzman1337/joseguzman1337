<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<input type="hidden" name="listados" value="<?php echo $codigoeditarmateria;?>">
	<table border="1" width="380" cellpadding="2" cellspacing="1" bordercolor="#003333">
	  <tr bgcolor="#C5D5D6">
		<td width="50%" align="center" class="Estilo1" colspan="2"><strong>Nombre</strong></td>
		<td width="50%" align="center" class="Estilo1"><strong>Codigo</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><?php echo $nombre; ?></td>
		<td align="center" class="Estilo1"><?php echo $codigo; ?></td>
	  </tr>
	  <tr>
		<td width="50%" align="center" class="Estilo1" colspan="2" bgcolor="#C5D5D6"><strong>Formación Acad&eacute;mica </strong></td>
		<td width="50%" align="center" class="Estilo1" bgcolor="#C5D5D6"><strong>Area Académica</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><?php echo $nombreformacionacademica ?></td>
		<td align="center" class="Estilo1"><?php echo $nombreareaacademica ?></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td width="50%" align="center" class="Estilo1" colspan="2"><strong>Semestre</strong></td>
		<td width="50%" align="center" class="Estilo1"><strong>Valor</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><?php echo $semestre;?></td>
		<td align="center" class="Estilo1"><?php echo $valor;?></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" width="25%"><strong>Nº Créditos</strong></td>
		<td align="center" class="Estilo1" width="25%"><strong>Nº Horas Semanales</strong></td>
		<td align="center" class="Estilo1"><strong>Tipo Materia</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1"><?php echo $creditos; ?></td>
		<td align="center" class="Estilo1"><?php echo $horassemanales; ?></td>
		<td align="center" class="Estilo1"><?php echo $tipomateria;?></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" colspan="2"><strong>Fecha Inicio</strong></td>
		<td align="center" class="Estilo1"><strong>Fecha Vencimiento</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><?php echo $fechainicio; ?></td>
		<td align="center" class="Estilo1"><?php echo $fechavencimiento;?></td>
	  </tr>
	  <tr>
	  	<td align="center" colspan="3"><input type="submit" name="accionmateria" value="Editar"style="width:120px">
		<input type="submit" name="ok" value="Aceptar"style="width:120px"></td>
	  </tr>
	</table>
