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
.Estilo5 {font-size: 14px}
.Estilo6 {
	font-family: Tahoma;
	font-size: 14px;
}
.Estilo9 {font-size: 12px}
.Estilo12 {font-family: Tahoma; font-size: 12px; }
-->
</style>
<?php
$query_materiascarga = "select d.idplanestudio, d.codigomateria, m.nombremateria, d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio
from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
where p.codigoestudiante = '$codigoestudiante'
and p.idplanestudio = d.idplanestudio
and p.codigoestadoplanestudioestudiante like '1%'
and d.codigoestadodetalleplanestudio like '1%'
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
and d.codigotipomateria not like '5%'
and d.codigotipomateria not like '4%'
and m.codigoindicadorgrupomateria = '200'
$quitarmateriascarga
order by 4,3";
//and d.codigotipomateria not like '4%'";
//echo "$query_materiasplanestudio<br>";
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
if($totalRows_materiascarga != "")
{
?>
<p align="center" class="Estilo2 Estilo5"><strong>MATERIAS QUE PUEDEN ADICIONARSE</strong></p>
<table width="650" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
	<td width="65" bgcolor="#C5D5D6" class="Estilo2 Estilo1 Estilo9"><div align="center"></div>
          <div align="center"><strong><strong>C&oacute;digo</strong></strong></div>          </td>
    <td bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo9"><div align="center"></div>        <div align="center"></div>        <div align="center"><strong><strong>Asignatura</strong></strong></div></td>
    <td width="26" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo9"><strong><strong>Sem</strong></strong></div></td>
    <td width="70" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo9"><strong><strong>Tipo</strong></strong></div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2 Estilo9"><div align="center"></div>
         <div align="center"><strong><strong>Cr&eacute;ditos</strong></strong></div>
          <div align="center"></div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo9"><strong><strong>Adicionar</strong></strong></div></td>
</tr>
</table>
<?php
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		$quitarmateriascarga = "$quitarmateriascarga and  m.codigomateria <> '".$row_materiascarga['codigomateria']."'";
?>
<table width="650" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
<tr>
	<td width="65" ><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['codigomateria'];?></div></td>
    <td ><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombremateria'];?></div></td>
    <td width="26" ><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['semestredetalleplanestudio'];?></div></td>
    <td width="70" ><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombretipomateria'];?></div></td>
    <td width="65" ><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['numerocreditosdetalleplanestudio'];?></div></td>
     <td width="65" ><div align="center"><font size="2" face="Tahoma"><input type="checkbox" value="<?php echo $row_materiascarga['codigomateria'];?>" name="adicionadaplan<?php echo $row_materiascarga['codigomateria'];?>">
  	</div></td>
</tr>
</table>
<?php
	}
}
else
{
?>
<h4 align="center" class="Estilo6">NO SE TIENEN MATERIAS PARA ADICIONAR</h4>  
<?php
}
?>
