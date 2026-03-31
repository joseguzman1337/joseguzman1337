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
.Estilo5 {font-family: Tahoma; font-size: 12px}
.Estilo6 {font-size: 14px}
.Estilo7 {font-size: 12px; font-family: Tahoma; }
.Estilo8 {font-size: 12px}
-->
</style>
<?php
// Selecciona las materias de la carga, tomando los creditos y el semestre del plan de estudio que fue seleccionado
$query_materiascarga = "select d.idplanestudio, d.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, c.codigoestadocargaacademica
from detalleplanestudio d, materia m, tipomateria t, cargaacademica c
where d.codigoestadodetalleplanestudio like '1%'
and d.idplanestudio = c.idplanestudio
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
and d.codigotipomateria not like '5%'
and c.codigomateria = d.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
$quitarmateriascarga
and c.codigoestudiante = '$codigoestudiante'
order by 4,3";
//and d.codigotipomateria not like '4%'";
//echo "$query_materiascarga<br>";
$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga".mysql_error());
$totalRows_materiascarga = mysql_num_rows($materiascarga);
//echo "Total: $totalRows_materiasplanestudio<br>";
if($totalRows_materiascarga != "")
{
?>
<p align="center" class="Estilo2 Estilo6"><strong>MATERIAS ADICIONADAS </strong></p>
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
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8">
        <div align="center"><strong><strong>Eliminar</strong></strong></div>
    </div></td>
    <td width="65" bgcolor="#C5D5D6" class="Estilo1 Estilo2"><div align="center" class="Estilo8">
        <div align="center"><strong><strong>Cambio de grupo</strong></strong></div>
    </div></td>
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
    <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombremateria'];?></div></td>
    <td width="26"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['semestredetalleplanestudio'];?></div></td>
    <td width="70"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['nombretipomateria'];?></div></td>
    <td width="65"><div align="center"><font size="2" face="Tahoma"><?php echo $row_materiascarga['numerocreditosdetalleplanestudio'];?></div></td>
     <td width="65"><div align="center"><input type="checkbox" value="<?php echo $row_materiascarga['codigomateria'];?>" name="eliminadaplan<?php echo $row_materiascarga['codigomateria'];?>">
  	</div></td>
    <td width="65" class="Estilo1 Estilo2"><div align="center"><input type="checkbox" value="<?php echo $row_materiascarga['codigomateria'];?>" name="cambiogrupo<?php echo $row_materiascarga['codigomateria'];?>">
     </div></td>
</tr>
</table>
<?php
	}
}
else
{
?>
<h4 align="center" class="Estilo7">NO SE TIENEN MATERIAS ADICIONADAS</h4>  
<?php
}
?>
