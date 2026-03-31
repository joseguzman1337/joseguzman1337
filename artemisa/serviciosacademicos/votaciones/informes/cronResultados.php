<?php 
 session_start(); 
//$_SESSION['MM_Username'] = 'admintecnologia';
//setlocale(LC_ALL,"es_ES");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("funciones.php");

$votacionesHoy = getVotacionesActuales($sala);

$mensaje = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reporte de resultados</title>
		<script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
		<style type="text/css">
			.tableDiv{
				margin-top:50px;
			}
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
<body>';


foreach($votacionesHoy as $votacionLoop){

$dataVotacion = getDatosVotacion($sala,$votacionLoop["idvotacion"]);
//print_r($dataVotacion);
$facultades = getDatosFacultades($sala);
//print_r($facultades);
$plantillasVotacion = getPlantillasVotacion($sala,$votacionLoop["idvotacion"]);
//print_r($plantillasVotacion); 

$mensaje .= '
<div class="tableDiv" style="margin-top:50px;">
	<table cellpadding="0" cellspacing="0" >
		<thead>
			<tr style="background-color:#ccc;height:40px;">
				<th colspan="6">'.strtoupper($dataVotacion["nombrevotacion"]).'</th>
			</tr>
		</thead>
		<tbody>';
			 foreach($plantillasVotacion as $plantilla) {
				$mensaje .= '<tr style="border:0;height:20px;">
					<td colspan="6" style="border:0;"> </td>
				</tr>
				<tr class="nombrePlantilla" style="background-color:#ccc;">
					<td colspan="6">'.trim(strtoupper($plantilla["nombretipoplantillavotacion"])).'</td>
				</tr>';
				
					//no es consejo de facultad
					if($plantilla["idtipoplantillavotacion"]!=3) { 
				$mensaje .= '<tr class="etiquetasPlantilla">
					<td>PUESTO</td>
					<td>PLANTILLA</td>
					<td>VOTOS</td>
					<td>PRINCIPAL</td>
					<td>SUPLENTE</td>
					<td>CARRERA++</td>
				</tr>';
				
					$resultados = getVotoTipoPlantilla($sala,$dataVotacion["idvotacion"],$plantilla["idtipoplantillavotacion"]); 
					$contador = 1;
					
					foreach($resultados as $resultado){
				
				$mensaje .= '<tr>
					<td style="text-align:center;">';
					if($resultado["idcargo"]==2) { $mensaje .= $contador; }
					$mensaje .= '</td>
					<td>'.$resultado["nombreplantillavotacion"].'</td>
					<td style="text-align:center;">'.number_format( $resultado["votos"], 0 ).'</td>
					<td>'.$resultado["nombrePrincipal"].'</td>
					<td>'.$resultado["nombreSuplente"].'</td>
					<td>'.$resultado["nombrecarrera"].'</td>					
				</tr>';
			 $contador++;} } else {
					foreach($facultades as $facultad) {
						$html = "";
						$carreras =  getCarrerasFacultad($sala,$facultad["codigofacultad"]); 
						
						$totales = array();
						foreach($carreras as $carrera){
							$votos = getVotoPorCarrera($sala,$dataVotacion["idvotacion"],$plantilla["idtipoplantillavotacion"],$carrera["codigocarrera"]);
							/*if($carrera["codigocarrera"]==500){
							echo "<br/><br/><pre>"; print_r($votos);var_dump(count($votos)>0 && $votos[0]!="" && $votos[0]!=null);}*/
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
												<td>PUESTO**</td>
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

								// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
								// porque la posición de 'a' está en el 1° (primer) caracter.
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
					
					$mensaje .= $html; } //facultades
				} //else
			} //for plantillas 
		$mensaje .='</tbody>
	</table>
</div>';
 } 

 $mensaje .= '</body>
	</html>';
	$destinatarios = array();
	/*$destinatarios = array("Leyla Bonilla <bonillaleyla@unbosque.edu.co>","AUDITORIA INTERNA <auditoria@unbosque.edu.co>","Secretaria General <secretaria.general@unbosque.edu.co>",
		"Consuelo Martinez <martinezconsuelo@unbosque.edu.co>", "Jorge Martinez <it@unbosque.edu.co>");*/
		
                /*
                 * Se cambia Leyla Bonilla <bonillaleyla@unbosque.edu.co>
                 * por Coordinador de Sistemas de Informcion <coordinadorsisinfo@unbosque.edu.co>
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Modificado 21 de febrero de 2018.
                 */
                if (strpos($dataVotacion["nombrevotacion"],'Convivencia') !== false) {
//			$destinatarios = array("Gabriel Vega <vegagabriel@unbosque.edu.co>");
			$destinatarios = array("Coordinador de Sistemas de Informcion <coordinadorsisinfo@unbosque.edu.co>","Talento Humano <secretaria.personal@unbosque.edu.co>","Olga Rueda <seleccionpersonal@unbosque.edu.co>");
		} else {		
//			$destinatarios = array("Gabriel Andres Vega <vegagabriel@unbosque.edu.co>");
			$destinatarios = array("Coordinador de Sistemas de Informcion <coordinadorsisinfo@unbosque.edu.co>","Consuelo Martinez <martinezconsuelo@unbosque.edu.co>", 
			"Jorge Martinez <it@unbosque.edu.co>","Secretaria General <secretaria.general@unbosque.edu.co>","AUDITORIA INTERNA <auditoria@unbosque.edu.co>");
		}
//                end
	foreach($destinatarios as $destinatario){
	
	$asunto = "Informe de Resultados Votaciones ".date('d-m-Y h:i:s A');
    //$destinatario = "Leyla Bonilla <bonillaleyla@unbosque.edu.co>";
    //$headers = "From: no-responder@unbosque.edu.co \r\n";
        
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        

        // Cabeceras adicionales
        //$cabeceras .= 'To: ' .$to. "\r\n";
        $cabeceras .= 'From: Tecnologia <it@unbosque.edu.co>' . "\r\n";
        //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        
			  // Enviamos el mensaje
			  if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
					$aviso = "Su mensaje fue enviado.";
					$succed = true;
			  } else {
					$aviso = "Error de envío.";
					$succed = false;
			  }
		  }
		  
		 echo $aviso;
		// echo  $mensaje;

?>