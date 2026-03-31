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
.Estilo4 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo5 {font-size: 14px}
.Estilo8 {font-size: 12px}
-->
</style>
<?php
$query_materiascarga = "select d.idplanestudio, d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, c.codigoestadocargaacademica
from detalleplanestudio d, materia m, tipomateria t, cargaacademica c
where c.codigoestudiante = '$codigoestudiante'
and c.idplanestudio = d.idplanestudio
and d.codigoestadodetalleplanestudio like '1%'
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
and d.codigotipomateria not like '5%'
and c.codigomateria = d.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '2%'
$quitarmateriascarga
order by 4,3";
//and d.codigotipomateria not like '4%'";
//echo "$query_materiascarga<br>";
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";

$quitarestas = "";
if($totalRows_materiascarga != "" || $totalRows_cargasinplan != "")
{
?>
<p align="center" class="Estilo2 Estilo5"><strong>MATERIAS RETIRADAS </strong></p>
<table width="650" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
	<td width="65" bgcolor="#C5D5D6" class="Estilo2 Estilo1 Estilo8"><div align="center"></div>
    <div align="center"><strong><strong>C&oacute;digo</strong></strong></div>          </td>
    <td bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo8"><div align="center"></div>        <div align="center"></div>        <div align="center"><strong><strong>Asignatura</strong></strong></div></td>
    <td width="26" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8"><strong><strong>Sem</strong></strong></div></td>
    <td width="70" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8"><strong><strong>Tipo</strong></strong></div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo8"><div align="center"></div>
         <div align="center"><strong><strong>Cr&eacute;ditos</strong></strong></div>
    <div align="center"></div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8"><strong><strong>Adicionar</strong></strong></div></td>
</tr>
</table>
<table width="650" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
<?php
	if($totalRows_materiascarga != "" || $totalRows_cargasinplan != "")
	{
		while($row_materiascarga = mysql_fetch_array($materiascarga))
		{
			$quitarestas = "$quitarestas and  m.codigomateria <> '".$row_materiascarga['codigomateria']."'";
			$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$row_materiascarga['codigomateria']."'";
			if($row_materiascarga['codigoestadocargaacademica'] == "201")
			{
				$nombre = "retiradacarga";
			}
			else if($row_materiascarga['codigoestadocargaacademica'] == "200")
			{
				$nombre = "retiradaplan";
			}
?>
<tr>
	<td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['codigomateria'];?></div></td>
    <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['numerocreditosdetalleplanestudio'];?></div></td>
     <td width="65"><div align="center"><input type="checkbox" value="<?php echo $row_materiascarga['codigomateria'];?>" name="<?php echo "$nombre".$row_materiascarga['codigomateria'];?>">
  	</div></td>
</tr>
<?php
		}
		// Coloca las demás
		$query_cargasinplan = "select distinct m.codigomateria, m.nombremateria, 0 as semestredetalleplanestudio, t.nombretipomateria, 
		t.codigotipomateria, m.numerocreditos as numerocreditosdetalleplanestudio, c.codigoestadocargaacademica 
		from materia m, tipomateria t, cargaacademica c, planestudioestudiante p
		where p.codigoestudiante = '$codigoestudiante' 
		and p.idplanestudio = c.idplanestudio 
		and p.codigoestadoplanestudioestudiante like '1%' 
		and c.codigomateria = m.codigomateria 
		and m.codigotipomateria = t.codigotipomateria 
		and c.codigoestudiante = p.codigoestudiante 
		and c.idplanestudio = p.idplanestudio 
		and c.codigoperiodo = '$codigoperiodo' 
		and c.codigoestadocargaacademica like '2%'
		$quitarestas
		$quitarmateriascarga
		order by 4,3";
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiasplanestudio<br>";
		$cargasinplan=mysql_query($query_cargasinplan, $sala) or die("$query_cargasinplan");
		$totalRows_cargasinplan = mysql_num_rows($cargasinplan);
		while($row_cargasinplan = mysql_fetch_array($cargasinplan))
		{
			$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$row_cargasinplan['codigomateria']."'";
			if($row_cargasinplan['codigoestadocargaacademica'] == "201")
			{
				$nombre = "retiradacarga";
			}
			else if($row_cargasinplan['codigoestadocargaacademica'] == "200")
			{
				$nombre = "retiradaplan";
			}
?>
<tr>
	<td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $row_cargasinplan['codigomateria'];?></div></td>
    <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_cargasinplan['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $row_cargasinplan['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $row_cargasinplan['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $row_cargasinplan['numerocreditosdetalleplanestudio'];?></div></td>
     <td width="65"><div align="center"><input type="checkbox" value="<?php echo $row_cargasinplan['codigomateria'];?>" name="<?php echo "$nombre".$row_cargasinplan['codigomateria'];?>">
  	</div></td>
</tr>
<?php
		}
	}

?>
</table>
<?php
}
else
{
?>
<h4 align="center" class="Estilo4">NO SE TIENEN MATERIAS RETIRADAS</h4>  
<?php
}
?>
