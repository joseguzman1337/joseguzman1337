<?php
//$this->db->debug = true; 
$query_seldataestudiante = "select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, c.nombrecarrera, eg.numerodocumento
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
<table border="0" cellpadding="2" cellspacing="1" bordercolor="#003333" width="750">
   <tr id="trtitulogris">
   	<td colspan="6"><?php echo $seldatauniversidad->fields['nombreuniversidad'];?></td>
   </tr>
   <tr id="trtitulogris">
   	<td colspan="6"><?php echo $seldatauniversidad->fields['nituniversidad'];?></td>
   </tr>
   <tr id="trtitulogris">
    <td colspan="6">SIMULACION DE CREDITO EDUCATIVO</td>
   </tr>
   <tr>
   <td colspan="6" style="border-top-color:#000000"><HR><label id="labelresaltado">DATOS ESTUDIANTE</label></td>
   </tr>
   <tr> 
<?php
//if($totalRows_seldataestudiante != "")
//{
	//$row_seldevoluciones = $recordSet->GetAssoc();
	//while(!$seldataestudiante->EOF) 
	//{
?>
     	<td colspan="1" id="tdtitulogris">Nombre : </td>
		<td colspan="1"><?php echo $seldataestudiante->fields['nombre']; ?></td>
		<td colspan="1" id="tdtitulogris">Documento : </td>
		<td colspan="1"><?php echo $seldataestudiante->fields['numerodocumento']; ?></td>
		<td colspan="1" id="tdtitulogris">Facultad : </td>
	    <td colspan="1"><?php echo $seldataestudiante->fields['nombrecarrera']; ?></td>
<?php
		$seldataestudiante->MoveNext();
	//}
//}
if(!isset($_POST['valorapagar']))
{
	//$this->setValorapagar($_SESSION['codigoperiodosesion']);
	//$this->setValorapagar(2946000);
}
else 
{
	$this->setValorapagar($_POST['valorapagar']);
}
?>
    </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <?php
	//$this->dataordenpago();
?>
 <tr> 
  <td colspan="1" id="tdtitulogris">Valor Para Simular</td>
  <td colspan="1">$ <input type="text" name="valorapagar" value="<?php echo $this->valorapagar;?>">
  </td>
  <td colspan="1" id="tdtitulogris">Total Pecuniarios</td>
  <td colspan="1">$ <?php echo number_format($this->pecuniarios, 0);?></td>
  <td colspan="1" align="right">N° Cuotas : </td>
  <td colspan="1"><?php $this->numerocuotas(); ?></td>
 </tr>
  <tr>
   <td>&nbsp;</td>
 </tr>
 <!-- <tr  id="trtitulogris"> 
  <td colspan="2">Fecha Inicio Credito</td>
  <td colspan="1">Mínimo Primer Pago</td>
  <td colspan="1">Intereses</td>
  <td colspan="1">Valor a Girar</td>
 </tr>
 <tr>
 <td colspan="2">
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
 
<?php 
if(!isset($_POST['primerpago']))
{
	$this->calcularprimerpago($this->valorapagar);
}
else
{
	$this->setPrimerpago($_POST['primerpago']);
}
$this->setCapitales($this->primerpago);
$this->setValorafinanciar($this->valorapagar - $this->primerpago);

?>
<td colspan="1">$ <input type="text" name="primerpago" value="<?php echo $this->primerpago;?>">
   </td>
  <td colspan="1">$ 
<?php
$objfecha = new CalcDate(); 
$dias = $objfecha->restarfechacomercial($_POST['fecha0'], date("Y-m-d"));
$intereses = $this->primerpago*(($this->porcentajefinancierocondicioncredito/100/30)*$dias);
if($intereses < 0)
{
?>
<script language="javascript">
	alert("Tiene un error en la parametrización de la fecha, los intereses no deben ser negativos");
	window.location.reload("simulacioncredito.php");
</script>
<?php
	exit();
}
echo number_format($intereses,2);
$this->setIntereses($intereses);
//echo "ACA".$this->intereses[0];
//$_POST['fecha0'] = date("Y-m-d");

// Aca recibe el primer valor a girar
$this->setValoresagirar($this->primerpago+$intereses);
?>
</td>
  <td colspan="1">$ <?php echo number_format($this->valoresagirar[0],2); ?></td>
 </tr>
  <tr>
   <td>&nbsp;</td>
 </tr> -->
 <tr> 
  <!-- <td colspan="2" align="right">Valor a Financiar : </td>
  <td colspan="1">$ <?php echo number_format($this->valorafinanciar,2); ?></td>
   -->
 </tr>
</table>
