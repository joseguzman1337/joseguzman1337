<?php
// onClick="window.location.reload('impresion.php<?php echo "?ordenpago=$this->numeroordenpago&estudiante=".$this->codigoestudiante."&periodo=".$this->codigoperiodo."&ipimpresora=$rutaimpresion"; ')"
// Seleccionar la impresora par ser impresa la orden
$query_selimpresora= "select s.idseleccionaimpresora, s.nombreseleccionaimpresora, s.ubicacionseleccionaimpresora, s.ipseleccionaimpresora
from seleccionaimpresora s
where s.fechafinalseleccionaimpresora >= '".date("Y-m-d")."'";
$selimpresora=mysql_query($query_selimpresora, $this->sala) or die("$query_selimpresora".mysql_error());
$totalRows_selimpresora = mysql_num_rows($selimpresora);
?>
<form action="impresion.php" method="get" name="f1">
<input type="hidden" name="ordenpago" value="<?php echo $this->numeroordenpago?>">
<input type="hidden" name="estudiante" value="<?php echo $this->codigoestudiante?>">
<input type="hidden" name="ipimpresora" value="<?php echo $rutaimpresion?>">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<tr>
<td>
<strong>SELECCIONE LA IMPRESORA</strong>
</td>
</tr>
  <tr>
	<td>
	<select name="ipimpresora">
<?php
while($row_selimpresora = mysql_fetch_array($selimpresora))
{
?>
	  <option value="<?php echo $row_selimpresora['ipseleccionaimpresora']; ?>">
	  <?php echo $row_selimpresora['nombreseleccionaimpresora'];?>
	  </option>
<?php
}
//echo "sadas".$_SERVER['HTTP_REFERER']."asDSADa".$HTTP_SERVER_VARS['HTTP_REFERER'];
?>
	</select>
	</td>
  </tr>
  <tr>
  <td>
<?php
// Priemro toca mirar si los conceptos de la orden tienen restriccion de impresion
// Se restringe la impresion solamente a las ordenes que tengan concepto de matricula
if($this->existe_bloqueo())
{
	// 1 Miranos si esta a paz y salvo el estudiante
	$estaapazysalvo = $this->valida_pazysalvoestudiante();
	$sindocumentospendientes = $this->valida_documentosestudiante();
	$tieneevaluaciondocente = $this->valida_evaluaciondocenteestudiante();
	$estasindeudas = $this->valida_saldoencontra();
}
else
{
	$estaapazysalvo = true;
	$sindocumentospendientes = true;
	$tieneevaluaciondocente = true;
	$estasindeudas = true;
}
//echo $_SESSION['impresorasesion'];
//echo "Deudas ".$estasindeudas;
if($this->codigoimprimeordenpago == "02" && !$estaapazysalvo)
{
	//echo "No se le imprime orden de pago debido a que solicito crédito y tiene deuda";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito y tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
/*else if($this->codigoimprimeordenpago == "02")
{
	//echo "No se le imprime orden de pago debido a que solicito crédito";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}*/
else if(!$estaapazysalvo)
{
	//echo "No se le imprime orden de pago debido a que tiene deuda";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que tiene deuda en sala')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
else if(!$sindocumentospendientes)
{
	//echo "No se le imprime orden de pago debido a que tiene documentospendientes";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que tiene documentos pendientes')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
else if(!$tieneevaluaciondocente)
{
	//echo "No se le imprime orden de pago debido a que no ha hecho la evaluacion docente";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a no ha realizado la evaluación docente')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
else if(!$estasindeudas)
{
	//echo "No se le imprime orden de pago debido a que no ha tienen deudas pendientes";
	// Este mensaje es cuando tiene deudas en sap
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('NO SE ENCUENTRA A PAZ Y SALVO, POR FAVOR REVISE SU ESTADO DE CUENTA')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
else
{
	//echo "No debe nada";
?>
<input name="imprimir" type="submit" id="imprimir" value="Imprimir">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
}
?>
  		<input type="hidden" name="periodo" value="<?php echo $_SESSION['codigoperiodosesion'];?>">
  	  </td>
  </tr>
</table>
</form>

