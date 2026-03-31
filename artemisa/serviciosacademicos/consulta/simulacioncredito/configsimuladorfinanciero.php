<html>
	<head>
		<title>::Configuración valores simulador financiero::</title>
                <link type="text/css" rel="stylesheet" media="all" href="css_simulador.css" />
	</head>
	<body>
		<div class="field field-type-text field-field-financia-calculadora">
			<div class="field-label">Configuraci&oacute;n valores simulador financiero</div>
			<div class="field-items">
				<div class="field-item odd">
					<div id="calculadora_de_credito2">
<?php
		require_once('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		require_once('../../Connections/salaado.php');
?>
		<form name="forma" method="post">
<?php
			if(!$_REQUEST["accion"]) {
?>
				<input type="submit" name="accion" value="Nuevo" id="accion">
				<table>
					<thead>
						<tr>
							<th>Periodo</th>
							<th>Tasa de interes</th>
							<th>% M&iacute;nimimo a financiar</th>
							<th>% M&aacute;ximo a financiar</th>
							<th>% Estudio de cr&eacute;dito</th>
							<th>Valor Estudio de cr&eacute;dito</th>
							<th>IVA % Estudio de cr&eacute;dito</th>
							<th>Nro. m&aacute;ximo de cuotas</th>
							<th>Estado</th>
							<th>Accion</th>
						</tr>
					</thead>
					<tbody>
<?php
						$query="select * from configsimuladorfinanciero order by activo desc,codigoperiodo desc";
						$reg=mysql_query($query,$sala);       
						while($row=mysql_fetch_array($reg)) {
							$estado=($row["activo"]==1)?"Activo":"Inactivo";
?>
							<tr>
								<td align='center'><?php echo $row["codigoperiodo"]?></td>
								<td align='right'><?php echo $row["tasainteres"]?></td>
								<td align='right'><?php echo $row["porcentajeminfinanciar"]?></td>
								<td align='right'><?php echo $row["porcentajemaxfinanciar"]?></td>
								<td align='right'><?php echo $row["porcentajeestudiocredito"]?></td>
								<td align='right'><?php echo $row["ValorEstudioCredito"]?></td>
								<td align='right'><?php echo $row["ivaporcentajeestudiocredito"]?></td>
								<td align='center'><?php echo $row["maxnrocuotas"]?></td>
								<td align='center'><?php echo $estado?></td>
								<td align='center'><a href="?accion=Editar&idconfigsimuladorfinanciero=<?php echo$row["idconfigsimuladorfinanciero"]?>">Editar</a></td>
							</tr>
<?php
						}
?>
					</tbody>
				</table>
<?php
			}
			if($_REQUEST["accion"]=="Nuevo" || $_REQUEST["accion"]=="Editar") {
				if($_REQUEST["idconfigsimuladorfinanciero"]) {
					$query="select * from configsimuladorfinanciero where idconfigsimuladorfinanciero=".$_REQUEST["idconfigsimuladorfinanciero"];
					$reg=mysql_query($query,$sala);       
					$row=mysql_fetch_array($reg);
				}
?>
				<table>
					<tr>
						<th>Periodo</th>
						<td align="center"><input type="text" name="codigoperiodo" value="<?php echo $row["codigoperiodo"]?>" size="4" style="text-align:center"></td>
					</tr>
					<tr>
						<th>Tasa de interes</th>
						<td align="center"><input type="text" name="tasainteres" value="<?php echo $row["tasainteres"]?>" size="4" style="text-align:right"></td>
					</tr>
					<tr>
						<th>% M&iacute;nimimo a financiar</th>
						<td align="center"><input type="text" name="porcentajeminfinanciar" value="<?php echo $row["porcentajeminfinanciar"]?>" size="4" style="text-align:right"></td>
					</tr>
					<tr>
						<th>% M&aacute;ximo a financiar</th>
						<td align="center"><input type="text" name="porcentajemaxfinanciar" value="<?php echo $row["porcentajemaxfinanciar"]?>" size="4" style="text-align:right"></td>
					</tr>
					<tr>
						<th>% Estudio de cr&eacute;dito</th>
						<td align="center"><input type="text" name="porcentajeestudiocredito" value="<?php echo $row["porcentajeestudiocredito"]?>" size="4" style="text-align:right"></td>
					</tr>
					<tr>
						<th>Tarifa Estudio de cr&eacute;dito</th>
						<td align="center"><input type="text" name="ValorEstudioCredito" value="<?php echo $row["ValorEstudioCredito"]?>" size="13" style="text-align:right"></td>
					</tr>
					<tr>
						<th>IVA % Estudio de cr&eacute;dito</th>
						<td align="center"><input type="text" name="ivaporcentajeestudiocredito" value="<?php echo $row["ivaporcentajeestudiocredito"]?>" size="4" style="text-align:right"></td>
					</tr>
					<tr>
						<th>Nro. m&aacute;ximo de cuotas</th>
						<td align="center"><input type="text" name="maxnrocuotas" value="<?php echo $row["maxnrocuotas"]?>" size="4" style="text-align:center"></td>
					</tr>
					<tr>
						<th>Estado</th>
						<td align="center">
							<select name="activo">
								<option value="">Seleccione...</option>
								<option value="1" <?php if($row["activo"]==1){echo"selected";}else{echo"selected";}?>>Activo</option>
								<option value="0" <?php if($row["activo"]==0 && $row["activo"]!=null){echo"selected";}else{echo"";}?>>Inactivo</option>
							</select>
						</td>
					</tr>
				</table>
				<br>
				<input type="submit" name="accion" value="Guardar" id="accion">
				<input type="button" name="accion" value="Volver" id="accion" onclick="location.href='configsimuladorfinanciero.php'">
<?php
			}
			if($_REQUEST["accion"]=="Guardar") {
				if($_REQUEST["idconfigsimuladorfinanciero"]) {
					$query="UPDATE configsimuladorfinanciero
						SET	 codigoperiodo='".$_REQUEST["codigoperiodo"]."'
							,tasainteres=".$_REQUEST["tasainteres"]."
							,porcentajeminfinanciar=".$_REQUEST["porcentajeminfinanciar"]."
							,porcentajemaxfinanciar=".$_REQUEST["porcentajemaxfinanciar"]."
							,porcentajeestudiocredito=".$_REQUEST["porcentajeestudiocredito"]."
							,ValorEstudioCredito=".$_REQUEST["ValorEstudioCredito"]."
							,ivaporcentajeestudiocredito=".$_REQUEST["ivaporcentajeestudiocredito"]."
							,maxnrocuotas=".$_REQUEST["maxnrocuotas"]."
							,activo=".$_REQUEST["activo"]."
						WHERE idconfigsimuladorfinanciero=".$_REQUEST["idconfigsimuladorfinanciero"];
				} else {
					$query="INSERT INTO configsimuladorfinanciero
							(codigoperiodo
							,tasainteres
							,porcentajeminfinanciar
							,porcentajemaxfinanciar
							,porcentajeestudiocredito
							,ValorEstudioCredito
							,ivaporcentajeestudiocredito
							,maxnrocuotas
							,activo)
						VALUES ('".$_REQUEST["codigoperiodo"]."'
							,".$_REQUEST["tasainteres"]."
							,".$_REQUEST["porcentajeminfinanciar"]."
							,".$_REQUEST["porcentajemaxfinanciar"]."
							,".$_REQUEST["porcentajeestudiocredito"]."
							,".$_REQUEST["ValorEstudioCredito"]."
							,".$_REQUEST["ivaporcentajeestudiocredito"]."
							,".$_REQUEST["maxnrocuotas"]."
							,".$_REQUEST["activo"].")";
				}
				
				$reg=mysql_query($query,$sala);      
				unset($_REQUEST["accion"]);
?>
				<script>
					alert("La información se guardó satisfactoriamente");
					location.href="configsimuladorfinanciero.php";
				</script>
<?php				
			}
?>
				</div>
				</div>
			</div>
		</div>
		</form>	
	</body>
</html>
