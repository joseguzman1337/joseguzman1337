<?php

    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

if(!isset ($_SESSION['MM_Username'])) {
    session_start();
}
?>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
<p class="Estilo1" align="center"><strong>PLAN DE ESTUDIO</strong></p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center"><strong>Nombre</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechacreacionplanestudio']); ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center" colspan="2"><strong>Nombre Encargado</strong></td>
  	<td align="center"><strong>Cargo</strong></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
    </td>
	<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
    </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Semestres</strong></td>
  	<td align="center"><strong>Carrera</strong></td>
	<td align="center"><strong>Autorización Nº</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center"><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
  </tr>
 <tr>
  	<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
	<td align="center"><strong>Cantidad</strong></td> -->
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechainioplanestudio']); ?></td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
  </tr>
</table>
<table width="1100" border="1" cellpadding='0' cellspacing='0' bordercolor='#D76B00'>
  <tr>
<?php
$hayelectiva = false;
$totalcreditoselectivas = 0;
$semestrereal = $row_planestudio['cantidadsemestresplanestudio'];
if($row_planestudio['cantidadsemestresplanestudio']<10)
{
	$row_planestudio['cantidadsemestresplanestudio'] = 10;
}
for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++)
{
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, d.numerocreditosdetalleplanestudio, d.codigotipomateria
	from detalleplanestudio d, materia m
	where d.idplanestudio = '$idplanestudio'
	and d.semestredetalleplanestudio = '$columnasemestre'
	and m.codigomateria = d.codigomateria ";
	$cojemateriassemestre = $db->GetAll($query_cojemateriassemestre);
	$totalRows_cojemateriassemestre = count($cojemateriassemestre);
	$cuentacredito[$columnasemestre] = 0;
	$cuentahoras[$columnasemestre] = 0;
	$numeromaterias[$columnasemestre] = 0;
	foreach($cojemateriassemestre as $row_cojemateriassemestre)
	{
		$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
		$credito[$columnasemestre][] = $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
		$horas[$columnasemestre][] = $row_cojemateriassemestre['numerohorassemanales'];
		$tipomateria[$columnasemestre][] = $row_cojemateriassemestre['codigotipomateria'];
		$sintotales[$columnasemestre] = true;
		if($row_cojemateriassemestre['codigotipomateria'] != 5)
		{
			$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_cojemateriassemestre['numerohorassemanales'];
			$numeromaterias[$columnasemestre]++;
			$sintotales[$columnasemestre] = false;
		}
		else
		{
			$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_cojemateriassemestre['numerohorassemanales'];
			$numeromaterias[$columnasemestre]++;
			$haytecnica[$columnasemestre] = true;
		}
		if($row_cojemateriassemestre['codigotipomateria'] == 4)
		{
			$hayelectiva = true;
			$totalcreditoselectivas = $totalcreditoselectivas + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
		}
	}
?>
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio'])+2;?>" align="center"><strong><?php echo $columnasemestre;?>&nbsp;</strong> </td>
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
$cuentamateriassemestre = $db->GetRow($query_cuentamateriassemestre);
$totalRows_cuentamateriassemestre = count($cuentamateriassemestre);
$row_cuentamateriassemestre = $cuentamateriassemestre;
$espacio = false;
$tieneenfasis = false;

for($filamateria=1; $filamateria<=$row_cuentamateriassemestre['conteo']; $filamateria++)
{
	$materiaesenfasis = false;
?>
  <tr>
    <?php
	if(!$espacio)
	{
		$espacio = true;
	}
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
    {
            $posmateria = @strpos($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
            $codmateria = @substr($semestre[$columnamateria][$cuentamateria[$columnamateria]], 0, $posmateria);
            $eselectiva = false;
            $materiaesenfasis = false;
            if ($codmateria != "") {
                $query_tieneprerequisitos = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '1%'";
                $tieneprerequisitos = $db->GetAll($query_tieneprerequisitos);
                $totalRows_tieneprerequisitos = count($tieneprerequisitos);

                $query_tienecorequisitos = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '2%'";
                $tienecorequisitos = $db->GetAll($query_tienecorequisitos);
                $totalRows_tienecorequisitos = count($tienecorequisitos);

                $query_tieneequivalencias = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '3%'";
                $tieneequivalencias = $db->GetAll($query_tieneequivalencias);
                $totalRows_tieneequivalencias = count($tieneequivalencias);

                if ($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#B9B9FF";
                    $cursor = 'style="cursor: pointer"';

                } else if ($totalRows_tieneprerequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#CCFFFF";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#C5D6FC";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneequivalencias != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#C8D5E4";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneprerequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#6699CC";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#FFCC33";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#D9FFA0";
                    $cursor = 'style="cursor: pointer"';
                } else if ($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "";
                    $cursor = 'style="cursor: pointer"';
                } else if ($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '4') {
                    $colorfondo = "";
                    $cursor = "";
                    $eselectiva = true;
                } else {
                    $colorfondo = "#CC9900";
                    $cursor = "";
                    $tieneenfasis = true;
                    $materiaesenfasis = true;
                }
                if (isset($_GET['visualizado'])) {

                }
                ?>
                <td width="<?php echo (1000 / $row_planestudio['cantidadsemestresplanestudio']) + 2; ?>" class="Estilo2"
                    align="center" <?php echo $cursor; ?> bgcolor="<?php echo $colorfondo; ?>">
                    <table border="1" class="Estilo2" width="100" height="50">
                        <tr>
                            <td width="10%"><?php echo $credito[$columnamateria][$cuentamateria[$columnamateria]]; ?></td>
                            <td rowspan="2" width="90%">
                                <label style="font-size: 8px" onClick="
                                <?php
                                if (!isset($_GET['visualizado'])) {
                                    if ($eselectiva)
                                        echo "alert('Las electivas no tienen referencias')";
                                    else if (!$materiaesenfasis)
                                        echo "window.open('opcionesreferenciaplanestudio.php?planestudio=" . $idplanestudio . "&codigodemateria=" . $codmateria . "&limitesemestre=" . $columnamateria . "&tipomateriaenplan=" . $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] . "&lineaenfasis=1','miventana','width=300,height=280,left=300,top=300')";
                                    else echo "alert('Oprima el boton Líneas de Enfasis')";
                                } else {
                                    if ($eselectiva)
                                        echo "alert('Las electivas no tienen referencias')";
                                    else if (!$materiaesenfasis)
                                        echo "window.open('opcionesreferenciaplanestudio.php?planestudio=" . $idplanestudio . "&codigodemateria=" . $codmateria . "&limitesemestre=" . $columnamateria . "&tipomateriaenplan=" . $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] . "&lineaenfasis=1&visualizado','miventana','width=300,height=280,left=300,top=300')";
                                    else echo "alert('Oprima el boton Líneas de Enfasis')";
                                }
                                ?>
                                        "
                                       title="<?php echo preg_replace("<br>", " ", $semestre[$columnamateria][$cuentamateria[$columnamateria]]); ?>"><strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]]; ?></strong>
                                </label>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"><?php echo $horas[$columnamateria][$cuentamateria[$columnamateria]]; ?></td>
                        </tr>
                    </table>
                </td>
                <?php
            } else {
                ?>
                <td>&nbsp;</td>
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
    <?php
$totalcreditos = 0;
$totalhoras = 0;
$totalmaterias = 0;

$mostrarbotonenfasis = true;
for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
{
	if($cuentacredito != "")
	{
		$totalcreditos = $totalcreditos + $cuentacredito[$columnamateria];
		$totalhoras = $totalhoras + $cuentahoras[$columnamateria];
		$totalmaterias = $totalmaterias + $numeromaterias[$columnamateria];
?>
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio']);?>" align="center" style=" font-size:11px" <?php if($haytecnica[$columnamateria])  echo 'bgcolor="#CCCCCC"';?>>
	<table border="1" class="Estilo2" width="100" height="50">
        <tr>
          <td width="10%" style="font-size: 10px"><strong><?php echo $cuentacredito[$columnamateria];?></strong></td>
          <td rowspan="2" width="90%" align="center"><label  style="font-size: 10px"><strong><?php echo $numeromaterias[$columnamateria];?></strong></label>
&nbsp; </td>
        </tr>
        <tr>
          <td width="10%" style="font-size: 10px"><strong><?php echo $cuentahoras[$columnamateria];?></strong></td>
        </tr>
    </table></td>
    <?php
		if($columnamateria <= $semestrereal && $numeromaterias[$columnamateria] == 0)
		{
			$mostrarbotonenfasis = false;
		}
?>
    <?php
	}
	else
	{
?>
    <td>&nbsp;</td>
    <?php
	}
}
?>
  </tr>
  <tr>
    <td colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>" align="center">
	<table align="center" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
        <tr>
          <td>
		  <table border="1" width="104" height="50" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
              <tr>
                <td width="10%" style="font-size: 10px"><strong>Créditos</strong></td>
                <td rowspan="2" width="90%" align="center" valign="bottom"><label  style="font-size: 10px"><strong>Código<br>
                  Asignatura<br>
                  <br>
                  o<br>
                  <br>
                  Materias</strong></label>
&nbsp;</td>
              </tr>
              <tr>
                <td width="10%" style="font-size: 10px"><strong>Horas</strong></td>
              </tr>
          </table>
		  </td>
          <td>
		  <table align="center" border="0" height="80">
              <tr>
                <td style="font-size: 12px"><strong>Sin Referenciar</strong></td>
                <td bgcolor="#CC9900" style="font-size: 12px"><strong>Línea de Enfasis</strong></td>
              </tr>
              <tr>
                <td bgcolor="#6699CC" style="font-size: 12px"><strong>Prerequisitos</strong></td>
                <td bgcolor="#C5D6FC" style="font-size: 12px"><strong>Prerequisitos y Corequisitos</strong></td>
              </tr>
              <tr>
                <td bgcolor="#FFCC33" style="font-size: 12px"><strong>Corequisitos</strong></td>
                <td bgcolor="#CCFFFF" style="font-size: 12px"><strong>Prerequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#D9FFA0" style="font-size: 12px"><strong>Equivalencias</strong></td>
                <td bgcolor="#C8D5E4" style="font-size: 12px"><strong>Corequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#B9B9FF" colspan="2" style="font-size: 12px"><strong>Prerequisitos, Corequisitos y Equivalencias</strong></td>
              </tr>
          </table>
		  </td>
<?php
if($hayelectiva)
{
?>
		  <td>
		  <table align="center" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
		    <tr>
		  	  <td align="center" style="font-size: 12px"><strong>Total de Créditos <br> Electivas</strong></td>
		    </tr>
			<tr>
			  <td align="center" style="font-size: 12px"><?php echo $totalcreditoselectivas;?></td>
			</tr>
		  </table>
		  </td>
<?php
}
?>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>" align="center"><table align="center">
        <tr>
          <td><strong>Creditos:</strong></td>
          <td><?php echo $totalcreditos; ?></td>
          <td></td>
          <td></td>
          <td><strong>Horas:</strong></td>
          <td><?php echo $totalhoras; ?></td>
          <td></td>
          <td></td>
          <td><strong>Materias:</strong></td>
          <td><?php echo $totalmaterias; ?></td>
        </tr>
    </table></td>
  </tr>
  <?php
if($tieneenfasis)
{
?>
  <tr>
    <td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio']+1;?>"><strong>Nota:</strong> <font color="#800000">Los totales para los semestres que poseen línea de énfasis cambian, de acuerdo a las materias que posea cada línea.</font> </td>
  </tr>
  <?php
}
?>
  <tr>
    <td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
	<input type="button" name="ver_electivas" value="Syllabus y contenido electivas libres" OnClick="window.open('materiaselectivasplanestudio.php','_blank','resizable=no,width=800,height=300,scrollbars=YES')">
	<input type="button" name="ver_lineas_esfasis" value="Syllabus y contenido lineas de enfasis" OnClick="window.open('materiaslineasenfasisplanestudio.php?idplanestudio=<?=$idplanestudio?>','_blank','resizable=no,width=800,height=300,scrollbars=YES')">
<?php
if(isset($_GET['estudiante']))
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="history.go(-1)">
<?php
}
else if(isset($_GET['visualizado']))
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='plandeestudioinicial.php'">
<?php
}
else
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='editarmateriasseleccionadas.php?planestudio=<?php echo $idplanestudio;?>'">
<?php
}
if($tieneenfasis && $mostrarbotonenfasis && !isset($_GET['estudiante']))
{
	if(isset($_GET['visualizado']))
	{
?>
        <input type="button" name="lineasenfasis" value="Lineas de Enfasis" onClick="window.location.href='lineadeenfasis/lineadeenfasisinicial.php?planestudio=<?php  echo "$idplanestudio&visualizado";?>'">
<?php
	}
	else
	{
?>
	   <input type="button" name="lineasenfasis" value="Lineas de Enfasis" onClick="window.location.href='lineadeenfasis/lineadeenfasisinicial.php?planestudio=<?php  echo $idplanestudio;?>'">
<?php
	}
}
if(!isset($_GET['estudiante']))
{
?>        <input type="button" name="salir" value="Salir" onClick="window.location.href='plandeestudioinicial.php'">
<?php
}
?>
    </td>
  </tr>
</table>
