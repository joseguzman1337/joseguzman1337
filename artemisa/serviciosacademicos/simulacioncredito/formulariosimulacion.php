<?php
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
   <td>&nbsp;</td>
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
  <td colspan="3" class="Estilo1">$ <?php echo number_format($this->valorapagar,2);	?>
	
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
 <input type="text" name="fecha0" value="<?php 
  	if(!isset($_POST['fecha0']))
	{	
		$this->setFechascreditos(date("Y-m-d"));
		$_POST['fecha0'] = date("Y-m-d"); 
	}
	else
	{
		$this->setFechascreditos($_POST['fecha0']);
	}
	echo $this->fechascreditos[0];
	?>" readonly="true" size="10"></td>
  <td colspan="1" class="Estilo1" align="center">$ <input type="text" name="primerpago" value="<?php
//$_POST['primerpago'] = 1000000;
if(!isset($_POST['primerpago']))
{
	$this->calcularprimerpago($this->valorapagar);
}
else
{
	$this->setPrimerpago($_POST['primerpago']);
}
echo $this->primerpago;
$this->setCapitales($this->primerpago);
$this->setValorafinanciar($this->valorapagar - $this->primerpago);
//echo "<br>$valorafinanciar = $valorapagar - $primerpago";
//echo "ACA".$this->capitales[0];
?>	">
   </td>
  <td colspan="1" class="Estilo1" align="center">$ 
<?php
$objfecha = new CalcDate(); 
$dias = $objfecha->restarfechacomercial($_POST['fecha0'], date("Y-m-d"));
$intereses = $this->primerpago*(($this->porcentajefinancierocondicioncredito/100/30)*$dias);  
echo number_format($intereses,2);
$this->setIntereses($intereses);
//echo "ACA".$this->intereses[0];
$_POST['fecha0'] = date("Y-m-d");

// Aca recibe el primer valor a girar
$this->setValoresagirar($this->primerpago+$intereses);
?>
</td>
  <td colspan="1" class="Estilo1" align="center">$ <?php echo number_format($this->valoresagirar[0],2); ?></td>
 </tr>
  <tr>
   <td>&nbsp;</td>
 </tr>
 <tr> 
  <td colspan="2" class="Estilo2" bgcolor="#C5D5D6" align="right">Valor a Financiar : </td>
  <td colspan="1" class="Estilo1">$ <?php echo number_format($this->valorafinanciar,2); ?></td>
  <td colspan="1" class="Estilo2" bgcolor="#C5D5D6" align="right">N° Cuotas : </td>
  <td colspan="1" class="Estilo1"><?php $this->numerocuotas(); ?></td>
 </tr>
</table>
</body>
</html>
