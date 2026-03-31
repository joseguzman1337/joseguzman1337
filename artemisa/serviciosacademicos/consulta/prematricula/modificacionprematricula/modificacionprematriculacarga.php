<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
?>
<style type="text/css">
<!--
.Estilo1 {
	font-weight: bold;
	font-size: x-small;
	font-family: Tahoma;
}
.Estilo2 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo3 {
	font-size: x-small;
	font-family: Tahoma;
}
.Estilo5 {font-size: 14px}
.Estilo8 {font-size: 12px}
-->
</style>
<body class="Estilo3">
<?php
require_once("../funcionmateriaaprobada.php");
require_once("../generarcargaestudiante.php");

// Coloco las materias de la carga incluyendo las obligatorias.

// Además colocar las materias de la prematricula quitando aquellas que esten en todas las materias

// Datos de la prematricula hecha con las materias del plan de estudio
$query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva, m.nombremateria, dp.semestredetalleplanestudio, 
dp.numerocreditosdetalleplanestudio, t.nombretipomateria 
FROM detalleprematricula d, prematricula p, materia m, estudiante e, tipomateria t, detalleplanestudio dp, planestudioestudiante pe 
where (d.codigomateria = m.codigomateria or d.codigomateriaelectiva = m.codigomateria)
and d.idprematricula = p.idprematricula 
and p.codigoestudiante = e.codigoestudiante 
and e.codigoestudiante = '$codigoestudiante' 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula like '23%') 
and p.codigoperiodo = '$codigoperiodo' 
and t.codigotipomateria = dp.codigotipomateria
and pe.codigoestudiante = e.codigoestudiante
and pe.idplanestudio = dp.idplanestudio
and (dp.codigomateria = d.codigomateria or dp.codigomateria = d.codigomateriaelectiva)";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
$tieneprema = false;
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	$materiasprematricula[] = $row_premainicial1;
	//echo $row_premainicial1['codigomateria']."<br>";
	$tieneprema = true;
}

$query_premainicial1 = "SELECT c.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
d.numerocreditosdetalleplanestudio, t.nombretipomateria 
FROM materia m, tipomateria t, cargaacademica c, detalleplanestudio d, detalleprematricula dp, prematricula p
where c.codigoestudiante = '$codigoestudiante' 
and d.codigoestadodetalleplanestudio like '1%'
and c.codigoestadocargaacademica like '1%'
and c.codigoperiodo = '$codigoperiodo'
and c.codigomateria = d.codigomateria
and c.idplanestudio = d.idplanestudio
and t.codigotipomateria = m.codigotipomateria
and m.codigomateria = c.codigomateria
and dp.idprematricula = p.idprematricula
and p.codigoestudiante = c.codigoestudiante
and dp.codigomateria = c.codigomateria
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '23%')";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1".mysql_error());
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	$materiasprematricula[] = $row_premainicial1;
	//echo $row_premainicial1['codigomateria']."<br>";
	$tieneprema = true;
}


$query_premainicial1 = "SELECT m.codigomateria, m.nombremateria, 1 as semestredetalleplanestudio, 
m.numerocreditos as numerocreditosdetalleplanestudio, t.nombretipomateria 
FROM materia m, tipomateria t, detalleprematricula dp, prematricula p
where p.codigoestudiante = '$codigoestudiante' 
and p.codigoperiodo = '$codigoperiodo'
and t.codigotipomateria = m.codigotipomateria
and dp.idprematricula = p.idprematricula
and dp.codigomateria = m.codigomateria
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '23%')";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1".mysql_error());
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	if(!@in_array($row_premainicial1['codigomateria'],$materiasprematricula))
	{
		$materiasprematricula[] = $row_premainicial1;
		//echo $row_premainicial1['codigomateria']."<br>";
		$tieneprema = true;
	}
}

/*// Datos de la prematricula hecha con las materias de la linea de enfasis
$query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva, m.nombremateria, dp.semestredetalleplanestudio, 
dp.numerocreditosdetalleplanestudio, t.nombretipomateria 
FROM detalleprematricula d, prematricula p, materia m, estudiante e, tipomateria t, detallelineaenfasisplanestudio dl, lineaenfasisestudiante le 
where (d.codigomateria = m.codigomateria or d.codigomateriaelectiva = m.codigomateria)
and d.idprematricula = p.idprematricula 
and p.codigoestudiante = e.codigoestudiante 
and e.codigoestudiante = '$codigoestudiante' 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') 
and p.codigoperiodo = '$codigoperiodo' 
and t.codigotipomateria = dp.codigotipomateria
and le.codigoestudiante = e.codigoestudiante
and le.idlineaenfasisplanestudio = dl.idplanestudio
and (dl.codigomateria = d.codigomateria or dl.codigomateria = d.codigomateriaelectiva)";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
$tieneprema = false;
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	$materiasprematricula[] = $row_premainicial1;
	$tieneprema = true;
}
//$todaslasmateria = array_merge($materiaspropuestas, $materiasobligatorias);
//$todaslasmateria = array_unique($todaslasmateria);
*/
$quitarmateriascarga = "";

$numeromateriaschequeadas = 0;
if(isset($materiaspropuestas) || isset($materiasobligatorias) || isset($materiasprematricula))
{
?>
<p align="center" class="Estilo2 Estilo5"><strong>CARGA DEL ESTUDIANTE</strong></p>
<table width="650" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
	<td width="65" bgcolor="#C5D5D6" class="Estilo2 Estilo1 Estilo8"><div align="center"><strong><strong>C&oacute;digo</strong></strong></div></td>
	<td bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo8"><div align="center"><strong><strong>Asignatura</strong></strong></div></td>
    <td width="26" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8">
      <div align="center"><strong><strong>Sem</strong></strong></div>
    </div></td>
    <td width="70" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8">
      <div align="center"><strong><strong>Tipo</strong></strong></div>
    </div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo8"><div align="center"><strong><strong>Cr&eacute;ditos</strong></strong></div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8"><div align="center"><strong><strong>Eliminar</strong></strong></div></div></td>
    <!--<td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8"><div align="center"><strong><strong>Cambio de grupo</strong></strong></div></div></td>-->
</tr>
</table>
<table width="650" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
<?php
	if(isset($materiaspropuestas))
	{
		//$materiaspropuestas = $materiasfinal;
		foreach($materiaspropuestas as $key3 => $value3)
		{
			$query_estaencarga = "select c.codigomateria
			from cargaacademica c
			where c.codigomateria = '".$value3['codigomateria']."'
			and c.codigoperiodo = '$codigoperiodo'
			and c.codigoestadocargaacademica like '2%'
			and c.codigoestudiante = '$codigoestudiante'";
			//echo "$query_periodoactivo<br>";
			$estaencarga = mysql_db_query($database_sala,$query_estaencarga) or die("$query_estaencarga");
			$totalRows_estaencarga = mysql_num_rows($estaencarga);
			if($totalRows_estaencarga == "")
			{
				//if($value3['idgrupomateria'] == 2 || $value3['idgrupomateria'] == 0)
				//{
					//if($value3['idlineaenfasisplanestudio'] == "")
					//{
						$quitamaterias[] = $value3['codigomateria'];
						$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$value3['codigomateria']."'";
?>
<tr>
	<td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $value3['codigomateria'];?></div></td>
    <td><div align="center"><font size="2" face="Tahoma"><?php echo $value3['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $value3['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $value3['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $value3['numerocreditosdetalleplanestudio'];?></div></td>
    <td width="65"><div align="center"><input type="checkbox" value="<?php echo $value3['codigomateria'];?>" name="eliminarcarga<?php echo $value3['codigomateria'];?>">
  	</div></td>
    <!--<td width="65"><div align="center"><input type="checkbox" value="<?php //echo $value3['codigomateria'];?>" name="cambiogrupo<?php //echo $value3['codigomateria'];?>" <?php //echo $mostrarcambiogrupo; ?>>
    </div></td>-->
</tr>
<?php
					//}
				//}
			}
		}
	}
	if(isset($materiasobligatorias))
	{
		foreach($materiasobligatorias as $keyp => $valuep)
		{
			$query_estaencarga = "select c.codigomateria
			from cargaacademica c
			where c.codigomateria = '".$valuep['codigomateria']."'
			and c.codigoperiodo = '$codigoperiodo'
			and c.codigoestadocargaacademica like '2%'
			and c.codigoestudiante = '$codigoestudiante'";
			//echo "$query_periodoactivo<br>";
			$estaencarga = mysql_db_query($database_sala,$query_estaencarga) or die("$query_estaencarga");
			$totalRows_estaencarga = mysql_num_rows($estaencarga);
			if($totalRows_estaencarga == "")
			{
				if(!@in_array($valuep['codigomateria'],$quitamaterias))
				{
					$quitamaterias[] = $valuep['codigomateria'];
					$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$valuep['codigomateria']."'";
?>
<tr>
	<td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $valuep['codigomateria'];?></div></td>
    <td><div align="center"><font size="2" face="Tahoma"><?php echo $valuep['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $valuep['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $valuep['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $valuep['numerocreditosdetalleplanestudio'];?></div></td>
    <td width="65"><div align="center"><input type="checkbox" value="<?php echo $valuep['codigomateria'];?>" name="eliminarcarga<?php echo $value3['codigomateria'];?>">
  	</div></td>
    <!--<td width="65"><div align="center"><input type="checkbox" value="<?php //echo $valuep['codigomateria'];?>" name="cambiogrupo<?php //echo $value3['codigomateria'];?>" <?php //echo $mostrarcambiogrupo; ?>>
    </div></td>-->
</tr>
<?php			
				}
			}
		}
	}
	if(isset($materiasprematricula))
	{
		foreach($materiasprematricula as $keyprema => $valueprema)
		{
			//echo "<br>$keyprema => ".$valueprema['codigomateria']."<br>";
			/*$query_estaencarga = "select c.codigomateria
			from cargaacademica c
			where c.codigomateria = '".$valueprema['codigomateria']."'
			and c.codigoperiodo = '$codigoperiodo'
			and c.codigoestadocargaacademica like '2%'
			and c.codigoestudiante = '$codigoestudiante'";
			//echo "$query_periodoactivo<br>";
			$estaencarga = mysql_db_query($database_sala,$query_estaencarga) or die("$query_estaencarga");
			$totalRows_estaencarga = mysql_num_rows($estaencarga);
			if($totalRows_estaencarga == "")
			{*/
				//echo "<br>".$valueprema['codigomateria']."<br>";
				if(!@in_array($valueprema['codigomateria'],$quitamaterias))
				{
					$quitamaterias[] = $valueprema['codigomateria'];
					//echo "<br>".$valueprema['codigomateria']."<br>";
					$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$valueprema['codigomateria']."'";
					if($valueprema['codigomateriaelectiva'] != "")
					{
						// Selecciona el nombre de la materia hijo, ya que puede venir el nombre de la materia papa
						$query_nombredemateria = "select m.nombremateria
						from materia m
						where m.codigomateria = '".$valueprema['codigomateria']."'";
						$nombredemateria = mysql_db_query($database_sala,$query_nombredemateria) or die("$query_nombredemateria");
						$row_nombredemateria = mysql_fetch_array($nombredemateria);
						$valueprema['nombremateria'] = $row_nombredemateria['nombremateria'];
					}
?>
<tr>
	<td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $valueprema['codigomateria'];?></div></td>
    <td ><div align="center"><font size="2" face="Tahoma"><?php echo $valueprema['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $valueprema['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $valueprema['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $valueprema['numerocreditosdetalleplanestudio'];?></div></td>
    <td width="65"><div align="center"><input type="checkbox" value="<?php echo $valueprema['codigomateria'];?>" name="eliminadaplan<?php echo $value3['codigomateria'];?>">
  	</div></td>
    <!--<td width="65"><div align="center"><input type="checkbox" value="<?php// echo $valueprema['codigomateria'];?>" name="cambiogrupo<?php //echo $value3['codigomateria'];?>" <?php //echo $mostrarcambiogrupo; ?>>
    </div></td>-->
</tr>
<?php			
				}
				else
				{
					//echo "<br>".$valueprema['codigomateria']."<br>$quitarmateriascarga";
				}
			}
		//}
	}
?>
</table>
<?php
}
else
{
?>
<h4 align="center">NO SE TIENE CARGA ACADEMICA DE ESTE ESTUDIANTE PARA ESTE PERIODO</h4>  
<?php
}
?>