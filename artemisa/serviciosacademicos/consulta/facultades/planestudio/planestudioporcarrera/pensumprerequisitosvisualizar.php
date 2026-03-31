<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>    
<link rel="stylesheet" href="https://artemisa.unbosque.edu.co/serviciosacademicos/estilos/sala.css" type="text/css">
<table width="20%"  border="0" align="center" cellpadding="3" cellspacing="3">
<TR><TD><?php if($estaEnenfasis == "no"){ ?><img src="../../../../../imagenes/noticias_logo.gif" height="71">
<?php } else{ ?><img src="../../../../../../imagenes/noticias_logo.gif" height="71" ><?php }?></TD></TR></BR>
<TR><TD align="center"><p align="center"><strong><h3>PREREQUISITOS SELECCIONADOS</h3></strong></TD></TR>
</table>

<input type="hidden" name="tipodereferencia" value="<?php echo $Vartipodereferencia;?>">
<input type="hidden" name="editar" value="<?php echo $limite;?>">
<input type="hidden" name="codigodemateria" value="<?php echo $Varcodigodemateria;?>">
</p>
<table width="780"  cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td width="50%" align="center" ><strong>Nombre Materia</strong></td>
	<td width="50%" align="center" ><strong>Codigo Materia</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center" ><?php echo $row_referenciasmateria['nombremateria']; ?></td>
	<td align="center" ><?php echo $Varcodigodemateria; ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center" colspan="2"><strong>Nombre Plan de Estudio</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center" colspan="2">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha Inicio Prerequisito</strong></td>
	<td align="center" colspan="2"><strong>Fecha Vencimiento Prerequisito</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center"><?php echo ereg_replace(" [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$","",$fechainicio); ?>&nbsp;
	</td>
	<td align="center" colspan="2"><?php echo ereg_replace(" [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$","",$fechavencimiento);?>&nbsp;
	</td>
  </tr>
</table>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#FFE6B1">
<tr id="trgris">
<?php
for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++)
{
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, d.codigotipomateria
	from detalleplanestudio d, materia m
	where d.idplanestudio = '$idplanestudio'
	and d.semestredetalleplanestudio = '$columnasemestre'
	and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = mysql_query($query_cojemateriassemestre, $sala) or die("$query_cojemateriassemestre");
	$totalRows_cojemateriassemestre = mysql_num_rows($cojemateriassemestre);
	while($row_cojemateriassemestre = mysql_fetch_assoc($cojemateriassemestre))
	{
		if($estaEnenfasis == "no")
		{

			$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
			//$semestre[$columnasemestre][] = $row_cojemateriassemestre['nombremateria'];
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
				$materiahija = mysql_query($query_materiahija, $sala) or die("$query_materiahija");
				$totalRows_materiahija = mysql_num_rows($materiahija);
				if($totalRows_materiahija != "")
				{
					while($row_materiahija = mysql_fetch_assoc($materiahija))
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
$query_cuentamateriassemestre = "select d.semestredetalleplanestudio, count(*) as conteo
from detalleplanestudio d
where d.idplanestudio = '$idplanestudio'
group by d.semestredetalleplanestudio
order by 2 desc";
$cuentamateriassemestre = mysql_query($query_cuentamateriassemestre, $sala) or die("$query_detalleplanestudio");
$totalRows_cuentamateriassemestre = mysql_num_rows($cuentamateriassemestre);
$row_cuentamateriassemestre = mysql_fetch_assoc($cuentamateriassemestre);

$query_cuentamateriassemestre2 = "select dl.semestredetallelineaenfasisplanestudio
from detallelineaenfasisplanestudio dl
where dl.idplanestudio = '$idplanestudio'
and idlineaenfasisplanestudio = '$idlineaenfasis'
and semestredetallelineaenfasisplanestudio = '".$row_cuentamateriassemestre2['semestredetalleplanestudio']."'";
$cuentamateriassemestre2 = mysql_query($query_cuentamateriassemestre2, $sala) or die("$query_detalleplanestudio");
$totalRows_cuentamateriassemestre2 = mysql_num_rows($cuentamateriassemestre2);
$row_cuentamateriassemestre2 = mysql_fetch_assoc($cuentamateriassemestre2);

//$limitesemestre = $row_cuentamateriassemestre['conteo'];
for($filamateria=1; $filamateria<=($row_cuentamateriassemestre['conteo']+$row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio']); $filamateria++)
{
?>
<tr>
<?php
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
	{
		$posmateria = strpos ($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
		$codmateria = substr ($semestre[$columnamateria][$cuentamateria[$columnamateria]],0,$posmateria);
		if($codmateria != $Varcodigodemateria)
		{
			if($columnamateria <= $limite)
			{
				if($codmateria != "")
				{
					$esprerequisito = false;
					if(isset($Arregloprerequisitos))
					{
						foreach($Arregloprerequisitos as $key3 => $selPrerequisitos)
						{
							if($selPrerequisitos['codigomateriareferenciaplanestudio'] == $codmateria)
							{
								$esprerequisito = true;
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" class="Estilo2" bgcolor="#3F89E4">
	<strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong>&nbsp;</td>
<?php
							}
						}
					}
					if(!$esprerequisito)
					{
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" class="Estilo2">
	<strong><?php //echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong>&nbsp;</td>
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
  <tr id="trgris">
	<td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
<?php
if(!isset($_GET['visualizado']))
{
?>
<input type="submit" name="edi" value="Editar Prerequisito">
<?php
}
else
{
	$visual = "&visualizado";
}
if($estaEnenfasis == "no")
{
?>
	  <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiasporsemestre.php?planestudio=<?php echo "$idplanestudio.$visual";?>'">
<?php
}
else
{
?>
	  <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis.$visual";?>'">
<?php
}
?>
	</td>
  </tr>
</table>
