<hr>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
   <tr id="trtitulogris"> 
      <td>N° Cuotas</td>
	  <td>Fecha de Cheques</td>
	  <td>Capital</td>
	  <td>Intereses</td>
	  <td>Valor a Girar</td>
    </tr>
	<tr> 
      <td><?php echo 1; ?></td>
	  <td><input type="text" name="fecha0" value="<?php 
  	if(!isset($_POST['fecha0']))
	{	
		if($this->fechascreditos[0] == "")
		{
			$this->setFechascreditos(date("Y-m-d"));
			$_POST['fecha0'] = date("Y-m-d"); 
		}
		else
		{
			$_POST['fecha0'] = $this->fechascreditos[0]; 
		}
	}
	else
	{
		$this->fechascreditos[0] = $_POST['fecha0'];
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
	</td>
	  <td>$ <input type="text" name="primerpago" value="<?php echo $this->primerpago;?>" size="10"></td>
	  <td>$ 
<?php
	$objfecha = new CalcDate(); 
	$dias = $objfecha->restarfechacomercial($_POST['fecha0'], $this->fechascreditos[0]);
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
	
	$this->setValoresagirar($this->primerpago+$intereses);
?></td>
	  <td>$ <?php echo number_format($this->valoresagirar[0] + $this->pecuniarios,2); ?></td>
    </tr>
<?php
	$arreglocuotas = $this->simularcuotasarreglo();
	//print_r($arreglocuotas);
	//$this->simularcuotas();
	$this->pintarcuotas($arreglocuotas);
?>
</table>
