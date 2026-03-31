<?php 
	session_start();
	$rutaado=("../../funciones/adodb/");
	require_once('../../Connections/salaado-pear.php');
	require_once("funciones.php");

	$dataVotacion = getDatosVotacion($sala,$_GET["votacion"]);
	$facultades = getDatosFacultades($sala);
	$plantillasVotacion = getPlantillasVotacion($sala,$_GET["votacion"]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		<script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
		<style type="text/css">
			th{
				font-weigh:bold;
				text-align:center;
				font-size:1.3em;
			}
			
			.nombrePlantilla, .etiquetasPlantilla{
				text-align:center;
				font-size:1.1em;
			}
			
			table{
				border: 0;
				padding:0;
				margin:0;
			}
			
			tr td, tr th{
				border: 1px solid #000;
			}
			
			tr.noBorder td{
				border: 0;
			}
		</style>
	</head>
<body>
<div id="tableDiv">
	<table cellpadding="0" cellspacing="0" >
		<thead>
			<tr style="background-color:#ccc;height:40px;">
				<th colspan="6"><?php echo strtoupper($dataVotacion["nombrevotacion"]); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($plantillasVotacion as $plantilla) { ?>
				<tr style="border:0;height:20px;">
					<td colspan="6" style="border:0;"> </td>
				</tr>
				<tr class="nombrePlantilla" style="background-color:#ccc;">
					<td colspan="6"><?php echo trim(strtoupper($plantilla["nombretipoplantillavotacion"])); ?></td>
				</tr>
				<?php 
					//no es consejo de facultad
					if($plantilla["idtipoplantillavotacion"]!=3) { ?> 
				<tr class="etiquetasPlantilla">
					<td>PUESTO</td>
					<td>PLANTILLA</td>
					<td>VOTOS</td>
					<td>PRINCIPAL</td>
					<td>SUPLENTE</td>
					<td>CARRERA</td>
				</tr>
				<?php 
					$resultados = getVotoTipoPlantilla($sala,$dataVotacion["idvotacion"],$plantilla["idtipoplantillavotacion"]); 
					$contador = 1;
					
					foreach($resultados as $resultado){
						?>
						<tr>
							<td style="text-align:center;"><?php if($resultado["idcargo"]==2) { echo $contador; } ?></td>
							<td><?php echo $resultado["nombreplantillavotacion"]; ?></td>
							<td style="text-align:center;"><?php echo number_format( $resultado["votos"], 0 ); ?></td>
							<td><?php echo $resultado["nombrePrincipal"]; ?></td>
							<td><?php echo $resultado["nombreSuplente"]; ?></td>
							<td><?php echo $resultado["nombrecarrera"]; ?></td>					
						</tr>
						<?php $contador++;
					}//foreach 
				} 
				else {
					foreach($facultades as $facultad) {
						$html = "";
						$carreras =  getCarrerasFacultad($sala,$facultad["codigofacultad"]); 	
						$totales = array();
						foreach($carreras as $carrera){
							$votos = getVotoPorCarrera($sala,$dataVotacion["idvotacion"],$plantilla["idtipoplantillavotacion"],$carrera["codigocarrera"]);
							if(count($votos)>0 && $votos[0]!="" && $votos[0]!=null){
								if($html===""){
									$html = '<tr style="border:0;height:20px;">
												<td colspan="6" style="border:0;"> </td>
											</tr>
											<tr class="nombrePlantilla" style="background-color:#ccc;">
												<td colspan="6">'.trim($facultad["nombrefacultad"]).'</td>
											</tr>
											<tr class="nombreCarrera" style="background-color:#ddd;">
												<td colspan="6">'.trim($carrera["nombrecarrera"]).'</td>
											</tr>
											<tr class="etiquetasPlantilla">
												<td>PUESTO</td>
												<td>PLANTILLA</td>
												<td>VOTOS</td>
												<td>PRINCIPAL</td>
												<td>SUPLENTE</td>
												<td>CARRERA</td>
											</tr>';
								} else {
									$html .= '<tr class="nombreCarrera" style="background-color:#ddd;">
												<td colspan="6">'.trim($carrera["nombrecarrera"]).'</td>
											</tr>';
								}		
								$contador = 1;
								foreach($votos as $voto){									
									$nombrePlantilla = trim(str_replace(trim($carrera["nombrecarrera"]), "", $voto["nombreplantillavotacion"]));									
									$totales[$nombrePlantilla] += $voto["votos"];									
									$html .= '<tr>';
									if($voto["idcargo"]==2) {
										$html .= '<td style="text-align:center;">'.$contador.'</td>';
									} else {
										$html .= '<td></td>';
									}
									$html .= '<td>'.$nombrePlantilla.'</td>
												<td style="text-align:center;">'.number_format( $voto["votos"], 0 ).'</td>
												<td>'.$voto["nombrePrincipal"].'</td>
												<td>'.$voto["nombreSuplente"].'</td>
												<td>'.$voto["nombrecarrera"].'</td>					
											</tr>';
									$contador++;
								}
							} //votos 
						} //carreras
					
						if(count($totales)>0){
							arsort($totales);
							$contador = 1;
							foreach($totales as $key=>$valor){
								$pos = strpos(strtoupper($key), "BLANCO");
								// Notese el uso de ===. Puesto que == simple no funcionara como se espera
								// porque la posicion de 'a' esta en el 1° (primer) caracter.
								if ($pos === false) {									
									$html .= '<tr><td colspan="4" style="text-align:center;">PUESTO '.$contador.' '.$key.'</td>
												<td colspan="2" style="text-align:center;">'.number_format( $valor, 0 ).'</td>				
											</tr>';
											$contador += 1;
								} else {
									$totales["votoBlanco"] = array(strtoupper($key),$valor);
								}								
							}
							$html .= '<tr><td colspan="4" style="text-align:center;">'.$totales["votoBlanco"][0].'</td>
												<td colspan="2" style="text-align:center;">'.number_format( $totales["votoBlanco"][1], 0 ).'</td>				
											</tr>';
						} //totales					
						echo $html; 
					} //facultades
				} //else
			} //for plantillas ?>
		</tbody>
	</table>
</div>	
	<input type="button" name="esxportarExcel" value="Exportar a Excel" onClick="esxportarExcel();" style="margin-top:10px;">

<form action="../../consulta/facultades/registro_graduados/carta_egresados/imprimirReporteElectivasPendientes.php" name="myFormExcel" id="myFormExcel" method="post">
<input id="htmlText2" type="hidden" value="" name="datos_a_enviar">
</form>
<script type="text/javascript">
	function esxportarExcel(){        
			$("#htmlText2").val($("#tableDiv").append( $("table").eq(1).clone()).html());			
			document.myFormExcel.submit();
	}
</script>
</body>
</html>