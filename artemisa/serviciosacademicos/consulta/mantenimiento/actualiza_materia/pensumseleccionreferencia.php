<?php 
require_once('../../../Connections/sala2.php');
require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");
//require("funcionesequivalencias.php");
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadplandeestudio.php');
if (isset($_POST['planestudioselect']))
 {
  $idplanestudio = $_POST['planestudioselect'];
 }

$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, 
p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, 
c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, 
p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
from planestudio p, carrera c, tipocantidadelectivalibre t
where p.codigocarrera = c.codigocarrera
and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
and p.idplanestudio = '$idplanestudio'";
//echo $query_planestudio;
$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio");
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
?>

<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<p class="Estilo1" align="center"><strong><?php echo $row_planestudio['nombreplanestudio'];?></strong></p>
<!--<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center"><strong>Nombre</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechacreacionplanestudio']); ?></td>
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
	<td align="center"><strong>Cantidad</strong></td> 
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
	<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> 
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechainioplanestudio']); ?></td>
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
  </tr>
</table> -->

<table width="1100" border="1" cellpadding='1' cellspacing='0'   bordercolor="" align="center">
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
	and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = mysql_query($query_cojemateriassemestre, $sala) or die("$query_cojemateriassemestre");
	$totalRows_cojemateriassemestre = mysql_num_rows($cojemateriassemestre);
	$cuentacredito[$columnasemestre] = 0;
	$cuentahoras[$columnasemestre] = 0;
	$numeromaterias[$columnasemestre] = 0;
	while($row_cojemateriassemestre = mysql_fetch_assoc($cojemateriassemestre))
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
		//$semestre[$columnasemestre][] = $row_cojemateriassemestre['nombremateria'];
	}
?>
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio'])+2;?>" align="center"  style="border-top-color:#FF9900" bordercolorlight="#E97914"><strong><?php echo $columnasemestre;?>&nbsp;</strong> </td>
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
		$posmateria = strpos ($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
		$codmateria = substr ($semestre[$columnamateria][$cuentamateria[$columnamateria]],0,$posmateria);
		$eselectiva = false;
		$materiaesenfasis = false;
		if($codmateria != "")
		{
			$query_tieneprerequisitos = "select codigomateria
			from referenciaplanestudio 
			where idplanestudio = '$idplanestudio' 
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '1%'";
			$tieneprerequisitos = mysql_query($query_tieneprerequisitos, $sala) or die("$query_tieneprerequisitos");
			$totalRows_tieneprerequisitos = mysql_num_rows($tieneprerequisitos);
			
			$query_tienecorequisitos = "select codigomateria
			from referenciaplanestudio 
			where idplanestudio = '$idplanestudio' 
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '2%'";
			$tienecorequisitos = mysql_query($query_tienecorequisitos, $sala) or die("$query_tienecorequisitos");
			$totalRows_tienecorequisitos = mysql_num_rows($tienecorequisitos);
			
			$query_tieneequivalencias = "select codigomateria
			from referenciaplanestudio 
			where idplanestudio = '$idplanestudio' 
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '3%'";
			$tieneequivalencias = mysql_query($query_tieneequivalencias, $sala) or die("$query_tieneequivalencias");
			$totalRows_tieneequivalencias = mysql_num_rows($tieneequivalencias);
			
			//$row_seltiporeferencia = mysql_fetch_assoc($tieneprerequisitos);
			//echo $row_seltiporeferencia['codigotiporeferenciaplanestudio']."ASKLA";
			//exit();
			if($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
				
			}
			else if($totalRows_tieneprerequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
 			}
			else if($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($totalRows_tieneequivalencias != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($totalRows_tieneprerequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer"';
			}
			else if($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '4')
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer';
				$eselectiva = true;
			}
			else
			{
				//$colorfondo = "#E9E9E9";
				$cursor = 'style="cursor: pointer';
				$tieneenfasis = true;
				$materiaesenfasis = true;
			}
			if(isset($_GET['visualizado']))
			{
				//$cursor = "";
			}
?>
	<td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio'])+2;?>" class="Estilo2" align="center" <?php echo $cursor; ?> id="tdtitulogris">
        <table border="1" class="Estilo2" width="100" height="50">
          <tr>
            <td width="10%" id="tdtitulogris"><?php echo $credito[$columnamateria][$cuentamateria[$columnamateria]];?></td>
            <td rowspan="2" width="90%">
			<label  style="font-size: 8px" onClick=" 
<?php 
          if ($_POST['operacion'] == 1)
           {
?>		 
		     window.open('editar_materia.php?materia=<?php echo ereg_replace("<br>"," ",$semestre[$columnamateria][$cuentamateria[$columnamateria]]);?>','materias','width=600,height=400,left=350,top=250,scrollbars=yes')
<?php		
           }
          else
		   {
?>	
			window.open('contenidos.php?materia=<?php echo ereg_replace("<br>"," ",$semestre[$columnamateria][$cuentamateria[$columnamateria]]);?>&plan=<?php echo $idplanestudio; ?>','materias','width=600,height=400,left=350,top=250,scrollbars=yes')
<?php 
           }
?>			
			" 
			title="<?php echo ereg_replace("<br>"," ",$semestre[$columnamateria][$cuentamateria[$columnamateria]]);?>"><strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong> 
			</label>
&nbsp; </td>
          </tr>
          <tr>
            <td width="10%" id="tdtitulogris"><?php echo $horas[$columnamateria][$cuentamateria[$columnamateria]];?></td>
          </tr>
      </table>
    </td>
    <?php
		}
		else
		{
?>
          <td>&nbsp;</td>
    <?php
		}
		$cuentamateria[$columnamateria]++; 		
	}
?>
  </tr>
  <?php
	//$cuentamateria++;
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
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio']);?>" align="center" style="border-top-color:#FF9900" id="tdtitulogris" bordercolorlight="#E97914">
	<table border="1" class="Estilo2" width="100" height="50">
        <tr >
          <td width="20%" align="center" id="tdtitulogris">Créditos <?php echo $cuentacredito[$columnamateria];?></td>
          <td rowspan="2" width="90%" align="center"><label  style="font-size: 10px"><strong><?php echo $numeromaterias[$columnamateria];?></strong></label>
&nbsp; </td>
        </tr>
        <tr>
          <td width="10%" align="center" id="tdtitulogris">Horas <?php echo $cuentahoras[$columnamateria];?></td>
        </tr>
    </table></td>
    <?php 
		if($columnamateria <= $semestrereal && $numeromaterias[$columnamateria] == 0)
		{
			//$mostrarbotonenfasis = false;
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
</table></td>
  </tr>
</table>
<br>
  <div align="center">
    <input  type="button" name="Submit" value="Regresar" onClick="history.go(-1)">
  </div>
