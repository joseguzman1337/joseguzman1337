<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<input type="hidden" name="listados" value="<?php echo $codigoeditarmateria;?>">
	<table border="1" width="380" cellpadding="2" cellspacing="1" bordercolor="#003333">
	  <tr>
		<td width="50%" align="center" class="Estilo1" colspan="2" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
		<td width="50%" align="center" class="Estilo1" bgcolor="#C5D5D6"><strong>Codigo</strong></td>
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
		<td align="center" class="Estilo1" colspan="2">
		<select name="emformacionacademica">
          <option value="<?php echo $codigoformacionacademica ?>" SELECTED><?php echo $nombreformacionacademica ?></option>
<?php
				do
				{
					if($codigoformacionacademica != $row_formacionacademica['codigoformacionacademica'])
					{    
						
?>
        <option value="<?php echo $row_formacionacademica['codigoformacionacademica']?>"<?php if (!(strcmp($row_formacionacademica['codigoformacionacademica'], $_POST['emformacionacademica']))) {echo "SELECTED";}?>><?php echo $row_formacionacademica['nombreformacionacademica']?></option>
<?php
					}
				}
				while ($row_formacionacademica = mysql_fetch_assoc($formacionacademica));
				$totalRows_formacionacademica = mysql_num_rows($formacionacademica);
				if($totalRows_formacionacademica > 0)
				{
					mysql_data_seek($formacionacademica, 0);
					$row_formacionacademica = mysql_fetch_assoc($formacionacademica);
				}
?>
      </select>
	  </td>
		<td align="center" class="Estilo1"><select name="emareaacademica">
          <option value="<?php echo $codigoareaacademica?>" SELECTED><?php echo $nombreareaacademica ?></option>
          <?php
				do
				{
					if($codigoareaacademica != $row_areaacademica['codigoareaacademica'])
					{    						
?>
          <option value="<?php echo $row_areaacademica['codigoareaacademica']?>"<?php if (!(strcmp($row_areaacademica['codigoareaacademica'], $_POST['emareaacademica']))) {echo "SELECTED";}?>><?php echo $row_areaacademica['nombreareaacademica']?></option>
          <?php
					}
				}
				while ($row_areaacademica = mysql_fetch_assoc($areaacademica));
				$totalRows_areaacademica = mysql_num_rows($areaacademica);
				if($totalRows_areaacademica > 0)
				{
					mysql_data_seek($areaacademica, 0);
					$row_areaacademica = mysql_fetch_assoc($areaacademica);
				}
?>
        </select></td>
	  </tr>
	  <tr>
		<td width="50%" align="center" class="Estilo1" colspan="2" bgcolor="#C5D5D6"><strong>Semestre</strong></td>
		<td width="50%" align="center" class="Estilo1" bgcolor="#C5D5D6"><strong>Valor</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2">
		<table>
  		  <tr>
			<td rowspan="2"><input name="emsemestre" maxlength="2" type="text" size="2" value="<?php if(isset($_POST['emsemestre'])) echo $_POST['emsemestre']; else echo $semestre;?>" style="width: 20px " onBlur="limitesemestre(this)"></td>
		  </tr>
		  <tr>
			<td><input type="button" value="+" onClick="contadorsemestre(1)" class="Estilo3"><br>
				<input type="button" value="-" onClick="contadorsemestre(2)" class="Estilo3">
			</td>
		  </tr>
		</table>
		<font color="#FF0000" size="-2">
<?php
			if(isset($_POST['emsemestre']))
			{
				$validarsemestre = $_POST['emsemestre'];
				$imprimir = true;
				$semestrenumero = validar($validarsemestre,"numero",$error2,$imprimir);
				$semestrerequerido = validar($validarsemestre,"requerido",$error1,$imprimir);
				$formulariovalido = $formulariovalido*$semestrerequerido*$semestrenumero;
				if($validarsemestre == 0)
				{
					$formulariovalido = 0;
					echo "Debe digitar un semestre diferente de cero";
				}
			}
?>
        </font>
	    </td>
    <td align="center" class="Estilo1"> <?php echo $valor;?></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" width="25%" bgcolor="#C5D5D6"><strong>Nº Créditos</strong></td>
		<td align="center" class="Estilo1" width="25%" bgcolor="#C5D5D6"><strong>Nº Horas Semanales</strong></td>
		<td align="center" class="Estilo1" bgcolor="#C5D5D6"><strong>Tipo Materia</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1">
<?php
		if($codigotipomateria != 4)
		{
			echo $creditos;
		}
		else
		{
?>
			<input name="emcreditos" type="text" size="3" value="<?php if(isset($_POST['emcreditos'])) echo $_POST['emcreditos']; else echo "$creditos";?>" style="width: 20px">
			<font color="#FF0000" size="-2">
<?php
			if(isset($_POST['emcreditos']))
			{
				$validarcreditos = $_POST['emcreditos'];
				$imprimir = true;
				$creditosnumero = validar($validarcreditos,"numero",$error2,&$imprimir);
				$creditosrequerido = validar($validarcreditos,"requerido",$error1,&$imprimir);
				//echo "asda".$pefechainiciofecha;
				$formulariovalido = $formulariovalido*$creditosrequerido*$creditosnumero;
			}
		}
?>		</font>
		</td>
		<td align="center" class="Estilo1"><?php echo $horassemanales;?></td>
		<td align="center" class="Estilo1">
<?php
			if($codigotipomateria == 4)
			{
				echo "$tipomateria";
			}
			else
			{
?>
		<select name="emtipomateria">
        <option value="<?php echo $codigotipomateria?>" SELECTED><?php echo $tipomateria ?></option>
<?php
				do
				{
					if($codigotipomateria != $row_tipomateria['codigotipomateria'])
					{    
						if($row_tipomateria['codigotipomateria'] == 1 || $row_tipomateria['codigotipomateria'] == 5)
						{
?>
        <option value="<?php echo $row_tipomateria['codigotipomateria']?>"<?php if (!(strcmp($row_tipomateria['codigotipomateria'], $_POST['emtipomateria']))) {echo "SELECTED";}?>><?php echo $row_tipomateria['nombretipomateria']?></option>
<?php
						}
					}
				}
				while ($row_tipomateria = mysql_fetch_assoc($tipomateriacombo));
				$totalRows_tipomateria = mysql_num_rows($tipomateriacombo);
				if($totalRows_tipomateria > 0)
				{
					mysql_data_seek($tipomateriacombo, 0);
					$row_tipomateria = mysql_fetch_assoc($tipomateriacombo);
				}
			}
?>
      </select>
	  </tr>
	<tr>
		<td align="center" class="Estilo1" colspan="2" bgcolor="#C5D5D6"><strong>Fecha Inicio</strong></td>
		<td align="center" class="Estilo1" bgcolor="#C5D5D6"><strong>Fecha Vencimiento</strong></td>
	  </tr>
	  <tr>
		<td align="center" class="Estilo1" colspan="2"><input name="emfechainicio" type="text" size="10" value="<?php if(isset($_POST['emfechainicio'])) echo trim($_POST['emfechainicio']); else echo trim($fechainicio);?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
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
                    $inicio = new DateTime($_POST['emfechainicio']);
                    $vencimiento = new DateTime($_POST['emfechavencimiento']);
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
		<input name="emfechavencimiento" type="text" size="10" value="<?php if(isset($_POST['emfechavencimiento'])) echo trim($_POST['emfechavencimiento']); else echo trim($fechavencimiento);?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
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
                        $inicio = new DateTime($_POST['emfechainicio']);
                        $vencimiento = new DateTime($_POST['emfechavencimiento']);
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
