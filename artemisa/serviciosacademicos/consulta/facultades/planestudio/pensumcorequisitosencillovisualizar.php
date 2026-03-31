<?php
if(!isset($_SESSION['MM_Username'])){
    session_start();
}
is_file(dirname(__FILE__) ."/../../../utilidades/ValidarSesion.php")
    ? include_once(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php')
    : include_once(realpath(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php'));
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

if(isset($fechainicio) && !empty($fechainicio)){
    $dateinicio = new DateTime($fechainicio);
    $fechainicio = $dateinicio->format('Y-m-d');
}else{
    $fechainicio = date('Y-m-d');
}

if(isset($fechavencimiento) && !empty($fechavencimiento)){
    $datevenicimiento = new DateTime($fechavencimiento);
    $fechavencimiento = $datevenicimiento->format('Y-m-d');
}else{
    $fechavencimiento = "2099-12-31";
}

?>
<h2>COREQUISITOS SENCILLOS SELECCIONADOS</h2>
  <input type="hidden" name="tipodereferencia" value="<?php echo $Vartipodereferencia;?>">
<input type="hidden" name="editar" value="<?php echo $limite;?>">
<input type="hidden" name="codigodemateria" value="<?php echo $Varcodigodemateria;?>">
</p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td width="50%" align="center" class="Estilo1"><strong>Nombre Materia</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Codigo Materia</strong></td>
  </tr>
  <tr>
	<td align="center" class="Estilo1"><?php echo $row_referenciasmateria['nombremateria']; ?></td>
	<td align="center" class="Estilo1"><?php echo $Varcodigodemateria; ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center" colspan="2"><strong>Nombre Plan de Estudio</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center" colspan="2">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha Inicio Corequisito</strong></td>
	<td align="center" colspan="2"><strong>Fecha Vencimiento Corequisito</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $fechainicio;  ?>&nbsp;
	</td>
	<td align="center" colspan="2"><?php echo $fechavencimiento;?>&nbsp;
	</td>
  </tr>
</table>
<table width="780" border="1" cellspacing='0' bordercolor='#D76B00'>
<tr>
<?php
for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++)
{
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, d.codigotipomateria
	from detalleplanestudio d, materia m
	where d.idplanestudio = '$idplanestudio'
	and d.semestredetalleplanestudio = '$columnasemestre'
	and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = $db->GetAll($query_cojemateriassemestre);
	$totalRows_cojemateriassemestre = count($cojemateriassemestre);
	foreach($cojemateriassemestre as $row_cojemateriassemestre)
	{
		if($estaEnenfasis == "no")
		{

			$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
		}
		else
		{
			if($row_cojemateriassemestre['codigotipomateria'] != 5)
			{
				$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
			}
			else
			{
				$query_materiahija = "select d.codigomateriadetallelineaenfasisplanestudio,
				m.nombremateria, d.numerocreditosdetallelineaenfasisplanestudio, d.codigotipomateria,
				m.numerohorassemanales, d.semestredetallelineaenfasisplanestudio
				from detallelineaenfasisplanestudio d, materia m
				where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
				and d.idlineaenfasisplanestudio = '$idlineaenfasis'
				and d.idplanestudio = '$idplanestudio'
				and d.codigomateria = '".$row_cojemateriassemestre['codigomateria']."'";
				$materiahija = $db->GetAll($query_materiahija);
				$totalRows_materiahija = count($materiahija);
				if($totalRows_materiahija != "")
				{
					foreach($materiahija as $row_materiahija)
					{
						$semestre[$columnasemestre][] = $row_materiahija['codigomateriadetallelineaenfasisplanestudio']."<br>".$row_materiahija['nombremateria'];
					}
				}
			}
		}
	}
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" align="center"><strong><?php echo $columnasemestre;?>&nbsp;</strong></td>
<?php
}
?>
</tr>
<?php
$query_cuentamateriassemestre = "select d.semestredetalleplanestudio, count(*) as conteo ".
" from detalleplanestudio d where d.idplanestudio = '$idplanestudio' ".
" group by d.semestredetalleplanestudio order by 2 desc";
$cuentamateriassemestre = $db->GetRow($query_cuentamateriassemestre);
$totalRows_cuentamateriassemestre = count($cuentamateriassemestre);
$row_cuentamateriassemestre = $cuentamateriassemestre;

if(isset($row_cuentamateriassemestre['semestredetalleplanestudio']) && !empty($row_cuentamateriassemestre['semestredetalleplanestudio'])) {
    $query_cuentamateriassemestre2 = "select dl.semestredetallelineaenfasisplanestudio " .
        " from detallelineaenfasisplanestudio dl where dl.idplanestudio = '$idplanestudio' " .
        " and idlineaenfasisplanestudio = '$idlineaenfasis' " .
        " and semestredetallelineaenfasisplanestudio = '" . $row_cuentamateriassemestre['semestredetalleplanestudio'] . "'";
    $cuentamateriassemestre2 = $db->GetRow($query_cuentamateriassemestre2);
    $totalRows_cuentamateriassemestre2 = count($cuentamateriassemestre2);
    $row_cuentamateriassemestre2 = $cuentamateriassemestre2;
    if(!isset($row_cuentamateriassemestre2['semestredetalleplanestudio'])){
        $row_cuentamateriassemestre2['semestredetalleplanestudio'] = "";
        $row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio'] = "";
    }
}else{
    $row_cuentamateriassemestre2['semestredetalleplanestudio'] = "";
    $row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio'] = "";
}


for($filamateria=1; $filamateria<=($row_cuentamateriassemestre['conteo']+$row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio']); $filamateria++)
{
?>
<tr>
<?php
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
	{
		$posmateria = @strpos ($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
		$codmateria = @substr ($semestre[$columnamateria][$cuentamateria[$columnamateria]],0,$posmateria);
		if($codmateria != $Varcodigodemateria)
		{
			if($columnamateria == $limite)
			{
				if($codmateria != "")
				{
					$escorequisito = false;
					if(isset($Arreglocorequisitosencillo))
					{
						foreach($Arreglocorequisitosencillo as $key3 => $selCorequisitos)
						{
							if($selCorequisitos['codigomateriareferenciaplanestudio'] == $codmateria)
							{
								$escorequisito = true;
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" class="Estilo2" bgcolor="#3F89E4">
	<strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong>&nbsp;</td>
<?php
							}
						}
					}
					if(!$escorequisito)
					{
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" class="Estilo2">&nbsp;</td>
<?php
					}
				}
				else
				{
?>
	<td>&nbsp;</td>
<?php
				}
			}
			else
			{
?>
	<td>&nbsp;</td>
<?php
			}
		}
		else
		{
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" class="Estilo2" bgcolor="#FFCC99">
	<strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong>&nbsp;
	</td>
<?php
		}
		$cuentamateria[$columnamateria]++;
	}
?>
</tr>
<?php
}
?>
  <tr>
	<td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
<?php
if(!isset($_GET['visualizado']))
{
?>
    <input type="submit" name="edi" value="Editar Corequisito">
    <?php
    $visual = "";
}
else
{
		$visual = "&visualizado";
}
if($estaEnenfasis == "no")
{
?>
	  <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiasporsemestre.php?planestudio=<?php echo "$idplanestudio"."$visual";?>'">
<?php
}
else
{
?>
	  <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis"."$visual";?>'">
<?php
}
?>
	</td>
  </tr>
</table>
