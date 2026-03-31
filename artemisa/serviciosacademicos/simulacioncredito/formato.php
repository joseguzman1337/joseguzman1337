<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>:: Formato simulación credito ::</title>
		<style> body { font-family:"sans serif"; } </style>
	</head>
	<body>
		<table width="100%" align="center" border="0">
			<tr>
				<td width="20%" align="center"><img src="logo.gif" width="167" height="69"></td>
				<td width="70%" align="center">
					<b>UNIVERSIDAD EL BOSQUE</b>
					<br>Personer&iacute;a jur&iacute;dica Resoluci&oacute;n No. 11153
					<br>CARRERA 7B BIS No. 132-11
					<br>NIT: 860.066.789-6
				</td>
				<td width="10%"><img src="imprimir.png" onclick="window.print()"></td>
			</tr>
			<tr>
				<th width="100%" colspan="2">
					<br>SIMULACI&Oacute;N DE CR&Eacute;DITO<br>
				</th>
			</tr>
		</table>
		<br>
		<table width="100%" align="center" border="0">
			<tr>
				<td width="50%">
					Se&ntilde;or(a):
					<br><b><?php echo$_REQUEST['hestudiante']?></b>
					<br><?php echo$_REQUEST['hnumerodocumento']?>
					<br><?php echo$_REQUEST['hnombrecarrera']?>
				</td>
				<td width="50%" align="right">
					Fecha: <?php echo date('Y-m-d')?>
					<br>Orden(es) de Matr&iacute;cula(s): <?php echo$_REQUEST['hordenes']?>
				</td>
			</tr>
		</table>
		<br>
<?php
		$vlrcuotainicial=$_REQUEST["hvlrordenes"]-$_REQUEST["vlrfinanciar"];
?>
		<table width="100%" align="center" border="0">
			<tr>
				<td width="80%"><b>N&uacute;mero de cuotas</b></td>
				<td width="20%" align="right"><b><?php echo$_REQUEST['cuotas']?></b></td>
			</tr>
			<tr>
				<td width="80%"><b>Valor orden(es)</b></td>
				<td width="20%" align="right">$<?php echo number_format($_REQUEST['hvlrordenes'],0,',','.')?></td>
			</tr>
			<tr>
				<td width="80%"><b>VALOR CUOTA INICIAL</b></td>
				<td width="20%" align="right"><b>$<?php echo number_format($vlrcuotainicial,0,',','.')?></b></td>
			</tr>
			<tr>
				<td width="80%"><b>VALOR A FINANCIAR</b></td>
				<td width="20%" align="right"><b>$<?php echo number_format($_REQUEST['vlrfinanciar'],0,',','.')?></b></td>
			</tr>
		</table>
<?php
		include_once("calculaCuotas.php");
?>		
		<br><br>
		<table width="100%" align="center" frame="border" rules="none">
			<tr>
				<td valign="top"><b>Observaciones: </b></td>
				<td align="justify"><?php echo$_REQUEST['observaciones']?></td>
			</tr>
		</table>
		<br>
		<table width="100%" align="center" border="0">
			<tr>
				<td width="100%" align="justify">
					<p>Este simulador es informativo y no significa aprobación de la financiación, hasta no obtener respuesta del Departamento de Finanzas Estudiantiles.
					<br>Con este simulador la Universidad el Bosque no asume ningún compromiso académico-financiero.
					<br>El no pago de la cuota inicial, le acarrea los recargos establecidos por la Universidad y no se incluye en el plan de pagos.
					<br>Esta simulación debe ser depositada en el <b>BUZON</b> ubicado en el Departamento de Finanzas Estudiantiles a más tardar al día siguiente hábil de su elaboración, pasado este tiempo debe realizar una nueva simulación y se hace acreedor a los recargos a que haya lugar.
					<br>Recuerde que las solicitudes mal diligenciadas y/o los documentos incompletos anulan la simulación, y deberá iniciar nuevamente este proceso, lo que le puede acarrear matricula extraordinaria.</p>
					<p>De conformidad con lo anterior acepto y firmo.</p>
				</td>
			</tr>
		</table>
		<br><br><br>
		<table width="100%" align="center" border="0">
			<tr>
				<td valign="top" width="50%">
					<b>
						_________________________________
						<br>ESTUDIANTE
						<br><?php echo$_REQUEST['hestudiante']?>
						<br><?php echo$_REQUEST['hnumerodocumento']?>
					<b>
				</td>
				<td valign="top" width="50%">
					<b>
						_________________________________
						<br>CO-DEUDOR
						<br>
						<br>
					<b>
				</td>
			</tr>
		</table>
	</body>
</html>
