<html>
<head><title>Simulación Para Imprimir</title>
</head>
<body>
<div align="center">
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#003333" width="80%">
   <tr>
   <td>
<?php
$query_selsimulacioncredito = "SELECT idsimulacioncredito, codigoestudiante, fechasimulacioncredito, 
valorsimulacioncredito, fechadesdesimulacioncredito, fechahastasimulacioncredito, numerocuotassimulacioncredito, 
observacionsimulacioncredito, codigoestado, idcondicioncredito 
FROM simulacioncredito
where idsimulacioncredito = '$idsimulacioncredito'
and codigoestado like '1%'";
$selsimulacioncredito = $this->db->Execute($query_selsimulacioncredito); 
$totalRows_selsimulacioncredito = $selsimulacioncredito->RecordCount(); 

$query_seldetallesimulacioncredito = "SELECT iddetallesimulacioncredito, idsimulacioncredito, nocuotadetallesimulacioncredito, fechadesdedetallesimulacioncredito, fechahastadetallesimulacioncredito, valorcapitaldetallesimulacioncredito, valorinteresesdetallesimulacioncredito, codigoestado 
FROM detallesimulacioncredito
where idsimulacioncredito = '$idsimulacioncredito'
and codigoestado like '1%'";
$seldetallesimulacioncredito = $this->db->Execute($query_seldetallesimulacioncredito); 
$totalRows_seldetallesimulacioncredito = $seldetallesimulacioncredito->RecordCount(); 

//$this->db->debug = true; 
$query_seldataestudiante = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, c.nombrecarrera
from estudiantegeneral eg, estudiante e, carrera c
where eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '".$this->getCodigoestudiante()."'
and c.codigocarrera = e.codigocarrera";
$seldataestudiante = $this->db->Execute($query_seldataestudiante); 
$totalRows_seldataestudiante = $seldataestudiante->RecordCount(); 

$query_seldatauniversidad = "select nombreuniversidad, nituniversidad
from universidad
where codigouniversidad = 'UNIVERSIDAD'";
$seldatauniversidad = $this->db->Execute($query_seldatauniversidad); 
$totalRows_seldatauniversidad = $seldatauniversidad->RecordCount(); 

?>
<table border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" width="80%">
   <tr>
   	<td colspan="5" class="Estilo2"><?php echo $seldatauniversidad->fields['nombreuniversidad'];?></td>
   </tr>
   <tr>
   	<td colspan="5" class="Estilo2"><?php echo $seldatauniversidad->fields['nituniversidad'];?></td>
   </tr>
   <tr>
    <td colspan="5" class="Estilo2">SIMULACION DE CREDITO EDUCATIVO</td>
   </tr>
   <tr>
  <td colspan="5" class="Estilo2" align="right">SIMULACION N° <?php echo $idsimulacioncredito;?></td>
   </tr>
   <tr> 
      <td colspan="2" class="Estilo2" bgcolor="#C5D5D6">Facultad : </td>
	  <td colspan="3" class="Estilo1"><?php echo $seldataestudiante->fields['nombrecarrera']; ?></td>
    </tr>
<?php
if($totalRows_seldataestudiante != "")
{
	//$row_seldevoluciones = $recordSet->GetAssoc();
	while(!$seldataestudiante->EOF) 
	{
?>
    <tr> 
     	<td colspan="2" class="Estilo2" bgcolor="#C5D5D6">Nombre : </td>
		<td colspan="3" class="Estilo1"><?php echo $seldataestudiante->fields['nombre']; ?></td>
    </tr>
<?php
		$seldataestudiante->MoveNext();
	}
}
?>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr> 
  <td colspan="2" class="Estilo2" bgcolor="#C5D5D6">Valor A Pagar : </td>
  <td colspan="3" class="Estilo1">$ <?php echo number_format($selsimulacioncredito->fields['valorsimulacioncredito'],2);	?>
	
  </td>
 </tr>
  <tr>
   <td>&nbsp;</td>
 </tr>
 <tr> 
  <td colspan="2" class="Estilo2" bgcolor="#C5D5D6" align="center">Fecha Inicio Credito</td>
  <td colspan="1" class="Estilo2" bgcolor="#C5D5D6" align="center">Mínimo Primer Pago</td>
  <td colspan="1" class="Estilo2" bgcolor="#C5D5D6" align="center">Intereses</td>
  <td colspan="1" class="Estilo2" bgcolor="#C5D5D6" align="center">Valor a Girar</td>
 </tr>
 <tr>
 <td colspan="2" class="Estilo1" align="center">
 <?php 
  	echo $seldetallesimulacioncredito->fields['fechahastadetallesimulacioncredito'];
	?>
</td>
  <td colspan="1" class="Estilo1" align="center">$ <?php echo number_format($seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito'],2); ?> </td>
  <td colspan="1" class="Estilo1" align="center">$<?php echo number_format($seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'],2); ?>
</td>
  <td colspan="1" class="Estilo1" align="center">$ <?php echo number_format($seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito']+$seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'],2); ?></td>
 </tr>
  <tr>
   <td>&nbsp;</td>
 </tr>
 <tr> 
  <td colspan="2" class="Estilo2" bgcolor="#C5D5D6" align="right">Valor a Financiar : </td>
  <td colspan="1" class="Estilo1">$ <?php echo number_format($selsimulacioncredito->fields['valorsimulacioncredito']-$seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito'],2); ?></td>
  <td colspan="1" class="Estilo2" bgcolor="#C5D5D6" align="right">N° Cuotas : </td>
  <td colspan="1" class="Estilo1">&nbsp;<?php echo $selsimulacioncredito->fields['numerocuotassimulacioncredito']; ?></td>
 </tr>
</table>
<hr width="80%">
<table border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" width="80%">
   <tr bgcolor="#C5D5D6"> 
      <td class="Estilo2" align="center">N° Cuotas</td>
	  <td class="Estilo2" align="center">Fecha de Cheques</td>
	  <td class="Estilo2" align="center">Capital</td>
	  <td class="Estilo2" align="center">Intereses</td>
	  <td class="Estilo2" align="center">Valor a Girar</td>
    </tr>
<?php
	$seldetallesimulacioncredito->MoveNext();
	while(!$seldetallesimulacioncredito->EOF) 
	{
?>
	<tr> 
      <td class="Estilo1" align="center"><?php echo $seldetallesimulacioncredito->fields['nocuotadetallesimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center"><?php echo $seldetallesimulacioncredito->fields['fechahastadetallesimulacioncredito']; ?></td>
	  <td class="Estilo1" align="center">$ <?php echo number_format($seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito'],0);?></td>
	  <td class="Estilo1" align="center">$ <?php echo number_format($seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'],2); ?></td>
	  <td class="Estilo1" align="center">$ <?php echo number_format($seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito']+$seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'],2); ?></td>
    </tr>
<?php
		$totalcapital = $totalcapital + $seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito'];
		$totalintereses = $totalintereses + $seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'];
		$totalvaloragirar = $totalvaloragirar + $seldetallesimulacioncredito->fields['valorcapitaldetallesimulacioncredito'] + $seldetallesimulacioncredito->fields['valorinteresesdetallesimulacioncredito'];
		$seldetallesimulacioncredito->MoveNext();
	}
?>
 <tr>
   <td class="Estilo2" align="center" colspan="2"  bgcolor="#C5D5D6">Totales Cuotas</td>
	  <td class="Estilo1" align="center" bgcolor="#999999">$ <?php echo number_format($totalcapital,2);//number_format($this->valorafinanciar,2); ?></td>
	  <td class="Estilo1" align="center" bgcolor="#999999">$ <?php echo number_format(round($totalintereses,0),2); ?></td>
	  <td class="Estilo1" align="center" bgcolor="#999999">$ <?php echo number_format(round($totalvaloragirar,0),2); ?></td>
    </tr>
  </table>
 <br>
</td>
 </tr>
</table>
</div>
</body>
</html>
