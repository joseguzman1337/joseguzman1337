<hr align="center" width="80%" size="4" color="#C5D5D6">
<div align="center">
<p class="Estilo2"><strong>GENERACION DE ORDENES DE PAGO DE INSCRIPCIÓN</strong></p>
<?php
if(!$generarambos)
{
?>
		<p class="Estilo2"><font color="#800000">Haga click en el concepto para generar orden de pago</font></strong></p>
<?php
}
?>
<span class="Estilo1 Estilo4 Estilo1">
</span>
  <table width="500" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td align="center">Concepto</td>
 	  <td align="center">Fecha</td>
	  <td align="center">Valor</td>
    </tr>
<?php
		foreach($conceptos as $key => $codigoconcepto)
		{
			//echo "$key => $value<br>";
			// Selecciono los conceptos que son para inscripción y valido que existan en ordenes de pago activas para el estudiante
			
			// Este query trae los conceptos para el proceso de inscripción por internet por parte del estudiante
			if($generarambos)
			{
				$query_conceptosinscripcion = "SELECT c.nombreconcepto, c.codigoconcepto, vp.valorpecuniario
				FROM concepto c, facturavalorpecuniario fv, detallefacturavalorpecuniario df, valorpecuniario vp, estudiante e
				WHERE c.codigoreferenciaconcepto = '600'
				and c.codigoconcepto = '$codigoconcepto'
				and c.codigoconcepto = vp.codigoconcepto
				and vp.idvalorpecuniario = df.idvalorpecuniario
				and df.idfacturavalorpecuniario = fv.idfacturavalorpecuniario
				and fv.codigocarrera = e.codigocarrera
				and e.codigoestudiante = '$this->codigoestudiante'
				and e.codigotipoestudiante = df.codigotipoestudiante
				and df.codigoestado like '1%'
				and vp.codigoperiodo = '$this->codigoperiodo'
				and vp.codigoindicadorprocesointernet like '1%'";
				$conceptosinscripcion = mysql_query($query_conceptosinscripcion,$this->sala) or die("$query_conceptosinscripcion<br>".mysql_error());
				$cuentaconceptos = mysql_num_rows($conceptosinscripcion);
				$row_conceptosinscripcion = mysql_fetch_array($conceptosinscripcion);
				if($cuentaconceptos == "")
				{
					$query_conceptosinscripcion = "SELECT c.nombreconcepto, c.codigoconcepto, vp.valorpecuniario
					FROM concepto c, facturavalorpecuniario fv, detallefacturavalorpecuniario df, valorpecuniario vp, estudiante e
					WHERE c.codigoreferenciaconcepto = '600'
					and c.codigoconcepto = '$codigoconcepto'
					and c.codigoconcepto = vp.codigoconcepto
					and vp.idvalorpecuniario = df.idvalorpecuniario
					and df.idfacturavalorpecuniario = fv.idfacturavalorpecuniario
					and fv.codigocarrera = e.codigocarrera
					and e.codigoestudiante = '$this->codigoestudiante'
					and e.codigotipoestudiante = df.codigotipoestudiante
					and df.codigoestado like '1%'
					and vp.codigoperiodo = '$this->codigoperiodo'
					and vp.codigoindicadorprocesointernet like '2%'";
					$conceptosinscripcion = mysql_query($query_conceptosinscripcion,$this->sala) or die("$query_conceptosinscripcion<br>".mysql_error());
					$cuentaconceptos = mysql_num_rows($conceptosinscripcion);
					$row_conceptosinscripcion = mysql_fetch_array($conceptosinscripcion);
				}
			}
			else
			{
				$query_conceptosinscripcion = "SELECT c.nombreconcepto, c.codigoconcepto, vp.valorpecuniario
				FROM concepto c, facturavalorpecuniario fv, detallefacturavalorpecuniario df, valorpecuniario vp, estudiante e
				WHERE c.codigoreferenciaconcepto = '600'
				and c.codigoconcepto = '$codigoconcepto'
				and c.codigoconcepto = vp.codigoconcepto
				and vp.idvalorpecuniario = df.idvalorpecuniario
				and df.idfacturavalorpecuniario = fv.idfacturavalorpecuniario
				and fv.codigocarrera = e.codigocarrera
				and e.codigoestudiante = '$this->codigoestudiante'
				and e.codigotipoestudiante = df.codigotipoestudiante
				and df.codigoestado like '1%'
				and vp.codigoperiodo = '$this->codigoperiodo'
				and vp.codigoindicadorprocesointernet like '2%'";
				$conceptosinscripcion = mysql_query($query_conceptosinscripcion,$this->sala) or die("$query_conceptosinscripcion<br>".mysql_error());
				$cuentaconceptos = mysql_num_rows($conceptosinscripcion);
				$row_conceptosinscripcion = mysql_fetch_array($conceptosinscripcion);
			}
			//echo $query_conceptosinscripcion;
			//and dop.codigoconcepto = '151'
			$conceptosinscripcion = mysql_query($query_conceptosinscripcion,$this->sala) or die("$query_conceptosinscripcion<br>".mysql_error());
			$cuentaconceptos = mysql_num_rows($conceptosinscripcion);
			$row_conceptosinscripcion = mysql_fetch_array($conceptosinscripcion);
?>
	<tr bordercolor="#336633" class="Estilo1">
	  <td colspan="1" align="center"><?php if(!$generarambos){ ?> <a href="generarordenpagoinscripcion.php?<?php 
			if($row_conceptosinscripcion['codigoconcepto'] == 153)
			{ 
			 	echo "documentoingreso=".$_GET['documentoingreso']."&codigoestudiante=".$_GET['codigoestudiante']."&codigoperiodo=".$_GET['codigoperiodo']."&todos";
			}
			else
			{ 
			 	echo "documentoingreso=".$_GET['documentoingreso']."&codigoestudiante=".$_GET['codigoestudiante']."&codigoperiodo=".$_GET['codigoperiodo']."&formulario";
			}
			?>"><?php echo $row_conceptosinscripcion['nombreconcepto'] ?></a> <?php } else { echo $row_conceptosinscripcion['nombreconcepto'];}?></td>
	  <td align="center"><?php echo date("Y-m-d");?></td>
	  <td align="center">$ <?php echo number_format($row_conceptosinscripcion['valorpecuniario']);?></td>	  
	</tr>
<?php
		}
		if($generarambos)
		{
?>
	<tr>
	  <td colspan="3" align="center"><a href="generarordenpagoinscripcion.php?<?php echo "documentoingreso=".$_GET['documentoingreso']."&codigoestudiante=".$_GET['codigoestudiante']."&codigoperiodo=".$_GET['codigoperiodo']."";?>&todos">Generar Orden de Pago</a></td>
	</tr>
<?php
		}
?>
 </table>
 <br>
 <br>
</div>
