<?php 
require_once('../../../Connections/sala2.php' );

mysql_select_db($database_sala, $sala);
session_start();

?>
<html>
<head>
<title>Listado De Horarios</title>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
.Estilo2 {font-size: small}
.Estilo3 {font-size: xx-small}
-->
</style>
<script language="javascript">
function recargar(dir)
{
	window.location.reload("listadohorarios.php"+dir);
}
</script>
</head>
<body>
<?php
if(isset($_GET['filtro']))
{
	$filtrado = $_GET['filtro'];
	//echo $filtrado;
}
$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
$idplanestudio = $_GET['planestudio'];

$query_selsemestre = "select p.cantidadsemestresplanestudio
from planestudio p
where p.idplanestudio = '$idplanestudio'";
//echo "$query_selsemestre<br>";
$selsemestre = mysql_db_query($database_sala, $query_selsemestre) or die("$query_selsemestre".mysql_error());
$totalRows_selsemestre = mysql_num_rows($selsemestre);
$row_selsemestre = mysql_fetch_array($selsemestre);
$ultimosemestre = $row_selsemestre['cantidadsemestresplanestudio'];
// Seleccion de las materias del plan de estudio
if($filtrado != 'materia')
{
	if($filtrado == 'materiaunica')
	{
		$codmateria = $_GET['materiaelegida'];
		$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, 
		d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 
		t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.idgrupomateria
		FROM detalleplanestudio d, materia m, tipomateria t
		WHERE d.codigoestadodetalleplanestudio LIKE '1%'
		AND d.codigomateria = m.codigomateria
		AND d.codigotipomateria = t.codigotipomateria
		AND d.idplanestudio = '$idplanestudio'
		and d.codigomateria = '$codmateria'
		ORDER BY 3,2";
	}
	else if($filtrado != 'todos')
	{
		$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, 
		d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 
		t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.idgrupomateria
		FROM detalleplanestudio d, materia m, tipomateria t
		WHERE d.codigoestadodetalleplanestudio LIKE '1%'
		AND d.codigomateria = m.codigomateria
		AND d.codigotipomateria = t.codigotipomateria
		AND d.idplanestudio = '$idplanestudio'
		and d.semestredetalleplanestudio = '$filtrado'
		ORDER BY 3,2";
	}
	else
	{
		$query_materiasplanestudio = "SELECT d.codigomateria, m.nombremateria, 
		d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 
		t.nombretipomateria, d.numerocreditosdetalleplanestudio, m.idgrupomateria
		FROM detalleplanestudio d, materia m, tipomateria t
		WHERE d.codigoestadodetalleplanestudio LIKE '1%'
		AND d.codigomateria = m.codigomateria
		AND d.codigotipomateria = t.codigotipomateria
		AND d.idplanestudio = '$idplanestudio'
		ORDER BY 3,2";
	}
	//echo "$query_horarioinicial<br>";
	$materiasplanestudio = mysql_db_query($database_sala,$query_materiasplanestudio) or die("$query_materiasplanestudio");
	$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
	while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))
	{
		$materiasplan[] = $row_materiasplanestudio;
		// Para cada materia selecciono los grupos sin horario
		$codigomateria = $row_materiasplanestudio['codigomateria'];
		// Para cada materia selecciono los grupos sin horario
		$query_grupoinicial = "SELECT g.nombregrupo, g.idgrupo,	g.codigoindicadorhorario, 
		concat(d.apellidodocente,' ',d.nombredocente) as nombre, g.matriculadosgrupo, g.maximogrupo
		FROM grupo g, docente d 
		where g.codigoperiodo = '$codigoperiodo' 
		and g.codigomateria = '".$row_materiasplanestudio['codigomateria']."'
		and g.codigoestadogrupo like '1%'
		and d.numerodocumento = g.numerodocumento";
		//echo "$query_horarioinicial<br>";
		$grupoinicial=mysql_db_query($database_sala,$query_grupoinicial);
		$totalRows_grupoinicial = mysql_num_rows($grupoinicial);
		if($totalRows_grupoinicial != "")
		{
			while($row_grupoinicial = mysql_fetch_array($grupoinicial))
			{
				$idgrupo = $row_grupoinicial['idgrupo'];
				$grupos[$codigomateria][] = $row_grupoinicial;
				$query_horarioinicial = "select h.horainicial, h.horafinal, h.codigotiposalon, h.codigosalon, s.nombresalon, d.nombredia
				from horario h, dia d, salon s
				where h.idgrupo = '$idgrupo'
				and h.codigosalon = s.codigosalon
				and h.codigodia = d.codigodia";
				//echo "$query_horarioinicial<br>";
				$horarioinicial=mysql_db_query($database_sala,$query_horarioinicial);
				$totalRows_horarioinicial = mysql_num_rows($horarioinicial);
				if($totalRows_horarioinicial != "")
				{
					while($row_horarioinicial = mysql_fetch_array($horarioinicial))
					{
						$horarios[$idgrupo][] = $row_horarioinicial; 
					}
				}
			}
		}
	}
}
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: xx-small;
}
.Estilo2 {font-size: xx-small}
.Estilo3 {font-size: x-small}
-->
</style>
<?php 
echo '<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    window.location.reload("listadohorarios.php?planestudio='.$idplanestudio.'&filtro="+tipo); 
} 
</script>';
?>
<form name="f1" method="post" action='listadohorarios.php'>   
<div align="center" class="Estilo2">
  <p align="center"><span class="Estilo1 Estilo6 Estilo3"><strong><font size="2" face="Tahoma">HORARIOS</font></strong></span></p>
  <p class="Estilo1"> <font size="2" face="Tahoma"> 
  </font></p>
  <table width="250" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo1">
	<span class="Estilo4">Filtrar por :</span>	
	<select name="tipo" onChange="cambia_tipo()">
	<option value="0">Seleccionar</option>
	<option value="todos">Todos</option>
<?php
for($i=1;$i<=$ultimosemestre;$i++)
{
?>
		<option value="<?php echo $i ?>">Semestre <?php echo $i ?></option>
<?php
}
?>
	<option value="materia">Materia</option>
	</select>
&nbsp;	</td>
  </tr>
</table>
<?php
if($filtrado == 'materia')
{
	echo "<script language='javascript'>
	window.open('buscarmateria.php?planestudio=$idplanestudio','miventana','width=500,height=400,left=150,top=100,scrollbars=yes')
	</script>";
	exit();
}
// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
$semestre = 0;
foreach($materiasplan as $llave => $materias)
{
	$codigomateria = $materias['codigomateria'];
	$semestrenuevo = $materias['semestredetalleplanestudio'];
	if($semestrenuevo != $semestre)
	{
?>
	<h2 align="center">Semestre <?php echo $semestrenuevo; ?></h2>
<?php
		$semestre = $semestrenuevo;
	}
	//echo "$codigomateria".${$codigomateria}; 
?>
  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" width="700">
    <tr> 
      <td bgcolor="#607766" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1" colspan="8"><div align="center"></div>
        <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo "<font color = \"#FFFFFF\">",$materias['nombremateria'];?></span></font></div>
      <div align="center"></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center"><font size="2" face="Tahoma"><strong>C&oacute;digo</strong></font></div></td>
      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1" width="5%"><div align="center"></div>
        <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $materias['codigomateria'];?></span></font></div>
      <div align="center"></div></td>
    </tr>
<?php
	if(isset($grupos[$codigomateria]))
	{ 
		foreach($grupos[$codigomateria] as $llave2 => $grupohorario)
		{
?>
    <tr> 
      <td width="1%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Grupo</strong></font></div></td>
      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['idgrupo'];?></span></font></div></td>
      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Docente</strong></font></div></td>
      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['nombre'];?></span></font></div></td>
      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Nombre Grupo</strong></font></div></td>
      <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['nombregrupo'];?></span></font></div></td><td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Max. Grupo</strong></font></div></td>
      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['maximogrupo'];?></span></font></div></td>
      <td width="3%" bgcolor="#C5D5D6" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> 
      <div align="center" class="Estilo2"><font face="Tahoma"><strong>Prematri.</strong></font></div></td>
      <td width="3%" class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"> <div align="center"></div>
      <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $grupohorario['matriculadosgrupo'];?></span></font></div></td>
    </tr>
<?php
			$idgrupo = $grupohorario['idgrupo'];
			if(isset($horarios[$idgrupo]))
			{
?>
	 <tr>
	 <td colspan="11"> 
	  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
	    <tr bgcolor="#C5D5D6"> 
		  <td class="Estilo5 Estilo1 Estilo2"> 
			<div align="center"><font face="Tahoma"><strong>D&iacute;a</strong> 
			  </font></div>
		  <div align="center"></div></td>
		  <td class="Estilo5 Estilo1 Estilo2"><div align="center"><font face="Tahoma"><strong>H. Inicial</strong></font></div>
		  <div align="center"></div></td>
		  <td class="Estilo1 Estilo2 Estilo5 Estilo1"> 
		  <div align="center" class="Estilo2"><font face="Tahoma"><strong>H. Final</strong></font></div></td>
		  <td class="Estilo1 Estilo2 Estilo5 Estilo1"> 
		  <div align="center" class="Estilo2"><font face="Tahoma"><strong>Sal&oacute;n</strong></font></div></td>
 	    </tr>
<?php
				foreach($horarios[$idgrupo] as $llave2 => $horariogrupo)
				{	
?>
	    <tr bordercolor="#FF9900">
		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"></div>
		  <div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['nombredia'];?></span></font></div></td>
		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['horainicial'];?></span></font></div></td>
		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['horafinal'];?></span></font></div></td>
		  <td class="Estilo1 Estilo1 Estilo2 Estilo5 Estilo1"><div align="center"><font size="2" face="Tahoma"><span class="Estilo4"><?php echo $horariogrupo['codigosalon'];?></span> 
			  </font></div></td>
	    </tr>
<?php
				}
?>
		<tr></tr>
		<tr></tr>
		<tr></tr>
		<tr></tr>
		<tr></tr>
		<tr></tr>
	</table>
	</td>
	</tr>
<?php
			}			
			else
			{
?>
	<tr><td colspan="11" align="center"><strong><font color="#800000">Este grupo No tiene Horario</font></strong></td></tr>
<?php
			}
		}
	}
	else
	{ 
?>
	<tr><td colspan="11" align="center"><strong><font color="#800000">Esta materia no tiene grupos</font></strong></td></tr>
<?php
	}
?>
<tr><td colspan="11">&nbsp;</td></tr>
</table>
<?php
}
?>
  <font size="2" face="Tahoma"><span class="Estilo1"> 
<p><hr></p>
</p>
  </span></font><span class="Estilo1"> </span> 
  <p align="center" class="Estilo1">
  <input type="button" onClick="print()" value="Imprimir">
<input name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.reload('plandeestudioinicial.php')"> 
</p>
</div>
</form>
<?php
echo $fitrado;
?>
<script language="javascript">
function habilitar(campo)
{
	var entro = false;
	for (i = 0; i < campo.length; i++)
	{
		campo[i].disabled = false;
		entro = true;
	}
	if(!entro)
	{
		form1.habilita.disabled = false;
	}
}
</script>
</body>
</html>