<?php
$datos = explode('-',$_POST['codigomateria_idgrupo']);
$codigomateria = $datos[0];
$idgrupo = $datos[1];

// Seleccionar los cortes
//$db->debug = true;
$query_cortes = "select c.idcorte, c.numerocorte, porcentajecorte
from corte c
where c.codigomateria = '$codigomateria'
and c.codigocarrera = '$codigocarrera'
and c.codigoperiodo = '$codigoperiodo'
order by 2";
$cortes = $db->Execute($query_cortes);
$totalRows_cortes = $cortes->RecordCount();
if($totalRows_cortes == 0)
{
    $query_cortes = "select c.idcorte, c.numerocorte, porcentajecorte
    from corte c
    where c.codigomateria = '1'
    and c.codigocarrera = '$codigocarrera'
    and c.codigoperiodo = '$codigoperiodo'
    order by 2";
    $cortes = $db->Execute($query_cortes);
}
while($row_cortes = $cortes->FetchRow()) :
    $idcorte = $row_cortes['idcorte'];
    $query_notas = "select d.nota
    from detallenota d
    where d.codigotiponota = 10
    and d.idgrupo = '$idgrupo'
    and d.codigomateria = '$codigomateria'
    and d.idcorte = '$idcorte'";
    $notas = $db->Execute($query_notas);
    $totalRows_notas = $notas->RecordCount();

    $totalnotas['total'] = 0;
    $totalnotas['1_199'] = 0;
    $totalnotas['2_249'] = 0;
    $totalnotas['25_299'] = 0;
    $totalnotas['3_349'] = 0;
    $totalnotas['35_399'] = 0;
    $totalnotas['4_449'] = 0;
    $totalnotas['45_5'] = 0;

    while($row_notas = $notas->FetchRow()) :
        $totalnotas['total']++;
        if($row_notas['nota'] >= 0 && $row_notas['nota'] < 2)
            $totalnotas['1_199']++;
        if($row_notas['nota'] >= 2 && $row_notas['nota'] < 2.5)
            $totalnotas['2_249']++;
        if($row_notas['nota'] >= 2.5 && $row_notas['nota'] < 3)
            $totalnotas['25_299']++;
        if($row_notas['nota'] >= 3 && $row_notas['nota'] < 3.5)
            $totalnotas['3_349']++;
        if($row_notas['nota'] >= 3.5 && $row_notas['nota'] < 4)
            $totalnotas['35_399']++;
        if($row_notas['nota'] >= 4 && $row_notas['nota'] < 4.5)
            $totalnotas['4_449']++;
        if($row_notas['nota'] >= 4.5 && $row_notas['nota'] < 5)
            $totalnotas['45_5']++;
    endwhile;
?>
<br>
<br>
<table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr align="center">
    <td id="tdtitulogris">Numero Corte</td>
    <td><?php echo $row_cortes['numerocorte']; ?></td>
    <td id="tdtitulogris">Porcentaje</td>
    <td><?php echo $row_cortes['porcentajecorte']; ?>%</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr id="trtitulogris" align="center">
    <td>RANGO DE NOTAS</td>
    <td>1.0 - 1.99</td>
    <td>2.0 - 2.49</td>
    <td>2.5 - 2.99</td>
    <td>3.0 - 3.49</td>
    <td>3.5 - 3.99</td>
    <td>4.0 - 4.49</td>
    <td>4.5 - 5.0</td>
  </tr>
<?php
    if($totalnotas['total'] != 0) :
?>
  <tr align="center">
    <td id="tdtitulogris">NUMERO DE ESTUDIANTES</td>
    <td><?php echo $totalnotas['1_199'];?></td>
    <td><?php echo $totalnotas['2_249'];?></td>
    <td><?php echo $totalnotas['25_299'];?></td>
    <td><?php echo $totalnotas['3_349'];?></td>
    <td><?php echo $totalnotas['35_399'];?></td>
    <td><?php echo $totalnotas['4_449'];?></td>
    <td><?php echo $totalnotas['45_5'];?></td>
  </tr>
  <tr align="center">
    <td id="tdtitulogris">% DE ESTUDIANTES</td>
    <td><?php echo round($totalnotas['1_199']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['2_249']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['25_299']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['3_349']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['35_399']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['4_449']/$totalnotas['total']*100,2);?>%</td>
    <td><?php echo round($totalnotas['45_5']/$totalnotas['total']*100,2);?>%</td>
  </tr>
<?php
    else:
?>
  <tr align="center"><td colspan="8">No hay notas digitadas en este corte</td></tr>
<?php
    endif;
?>
</table>
<?php
endwhile;
?>