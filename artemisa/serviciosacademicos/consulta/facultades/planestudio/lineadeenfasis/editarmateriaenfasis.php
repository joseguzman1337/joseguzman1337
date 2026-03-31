<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
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
	  <tr bgcolor="#C5D5D6">
		<td width="50%" align="center" class="Estilo1" colspan="2"><strong>Semestre</strong></td>
		<td width="50%" align="center" class="Estilo1"><strong>Valor</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><?php echo $semestre;?></td>
    <td align="center" class="Estilo1"> <?php echo $valor;?></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" width="25%"><strong>Nº Créditos</strong></td>
		<td align="center" class="Estilo1" width="25%"><strong>Nº Horas Semanales</strong></td>
		<td align="center" class="Estilo1"><strong>Tipo Materia</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1"><?php echo "$creditos";?></td>
		<td align="center" class="Estilo1"><?php echo $horassemanales;?></td>
		<td align="center" class="Estilo1"><?php echo $tipomateria ?></td>
	  </tr>
	  <tr bgcolor="#C5D5D6">
		<td align="center" class="Estilo1" colspan="2"><strong>Fecha Inicio</strong></td>
		<td align="center" class="Estilo1"><strong>Fecha Vencimiento</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><input name="emfechainicio" type="text" size="10" value="<?php if(isset($_POST['emfechainicio'])) echo $_POST['emfechainicio']; else echo "$fechainicio";?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
		<font color="#FF0000" size="-2">
<?php
				if(isset($_POST['emfechainicio']))
			{
				$validarfechainicio = $_POST['emfechainicio'];
				$imprimir = true;
				$fechainiciofecha = validar($validarfechainicio,"fecha",$error3,&$imprimir);
				//echo "asda".$pefechainiciofecha;
				$formulariovalido = $formulariovalido*$fechainiciofecha;
				if($formulariovalido == 1)
				{
					$inicio = ereg_replace("-","",$_POST['emfechainicio']);
					$vencimiento = ereg_replace("-","",$_POST['emfechavencimiento']);
					if($inicio > $vencimiento)
					{
						echo "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
						$formulariovalido = 0;
					}
					if($inicio == $vencimiento)
					{
						echo "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
						$formulariovalido = 0;
					}
				}
			}
?>
		</font>
		</td>
		<td align="center" class="Estilo1">
		<input name="emfechavencimiento" type="text" size="10" value="<?php if(isset($_POST['emfechavencimiento'])) echo $_POST['emfechavencimiento']; else echo "$fechavencimiento";?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
		<font color="#FF0000" size="-2">
<?php
				if(isset($_POST['emfechavencimiento']))
				{
					$fechavencimiento = $_POST['emfechavencimiento'];
					$imprimir = true;
					$fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,&$imprimir);
					$formulariovalido = $formulariovalido*$fechavencimientofecha;
					if($formulariovalido == 1)
					{
						$inicio = ereg_replace("-","",$_POST['emfechainicio']);
						$vencimiento = ereg_replace("-","",$_POST['emfechavencimiento']);
						if($inicio > $vencimiento)
						{
							echo "La Fecha de Vencimiento debe ser mayor que la Fecha de Vencimiento";
							$formulariovalido = 0;
						}
						if($inicio == $vencimiento)
						{
							echo "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
							$formulariovalido = 0;
						}
					}
				}
?>		</font>
		</td>
	  </tr>
	  <tr>
	  	<td align="center" colspan="3"><input type="submit" name="aceptaredicion" value="Aceptar Materia"style="width:120px">
		<input type="submit" name="cancelarmateria" value="Cancelar"style="width:120px"></td>
	  </tr>
	</table>
