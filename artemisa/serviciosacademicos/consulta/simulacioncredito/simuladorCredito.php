<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>:: Simulador de crédito ::</title>
		<link type="text/css" rel="stylesheet" media="all" href="css_simulador.css" />
		<script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../mgi/js/jquery.validate.min.js"></script>
		<script defer="defer" type="text/javascript">
			function windowNew() {
				var hestudiante=document.formulario.hestudiante.value;
				var hnumerodocumento=document.formulario.hnumerodocumento.value;
				var hnombrecarrera=document.formulario.hnombrecarrera.value;
				var hordenes=document.formulario.hordenes.value;
				var hvlrordenes=document.formulario.hvlrordenes.value;
				var hminvlrfinanciar=document.formulario.hminvlrfinanciar.value;
				var hmaxvlrfinanciar=document.formulario.hmaxvlrfinanciar.value;
				var vlrfinanciar=document.formulario.vlrfinanciar.value;
				var cuotas=document.formulario.cuotas.value;
				var observaciones=document.getElementById("observaciones").value;
				var config_tasainteres=document.formulario.config_tasainteres.value;
				var config_porcentajeestudiocredito=document.formulario.config_porcentajeestudiocredito.value;
				var config_ivaporcentajeestudiocredito=document.formulario.config_ivaporcentajeestudiocredito.value;
                                var config_tarifaestudiocredito=document.formulario.config_tarifaestudiocredito.value;
				var imprime_adicionales='N';
				window.open('formato.php?hestudiante='+hestudiante+'&hnumerodocumento='+hnumerodocumento+'&hnombrecarrera='+hnombrecarrera+'&hordenes='+hordenes+'&hvlrordenes='+hvlrordenes+'&hminvlrfinanciar='+hminvlrfinanciar+'&hmaxvlrfinanciar='+hmaxvlrfinanciar+'&vlrfinanciar='+vlrfinanciar+'&cuotas='+cuotas+'&observaciones='+observaciones+'&config_tasainteres='+config_tasainteres+'&config_porcentajeestudiocredito='+config_porcentajeestudiocredito+'&config_tarifaestudiocredito='+config_tarifaestudiocredito+'&config_ivaporcentajeestudiocredito='+config_ivaporcentajeestudiocredito+'&imprime_adicionales='+imprime_adicionales,'_blank','width=800,height=800,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes');
			}
		</script>
	</head>
	<body>
<?php 
		//print_r($_SESSION);
		require_once('../../Connections/sala2.php');
		$rutaado = "../../funciones/adodb/";
		require_once('../../Connections/salaado.php');
		$query="select * from configsimuladorfinanciero where activo order by idconfigsimuladorfinanciero desc limit 1";
		$reg=mysql_query($query,$sala);
		$row=mysql_fetch_array($reg);
		$config_codigoperiodo=$row["codigoperiodo"];
		$config_tasainteres=$row["tasainteres"];
		$config_porcentajeminfinanciar=$row["porcentajeminfinanciar"];
		$config_porcentajemaxfinanciar=$row["porcentajemaxfinanciar"];
		$config_porcentajeestudiocredito=$row["porcentajeestudiocredito"];
		$config_ivaporcentajeestudiocredito=$row["ivaporcentajeestudiocredito"];
		$config_maxnrocuotas=$row["maxnrocuotas"];
		$config_tarifaestudiocredito = $row["ValorEstudioCredito"];
?>
		<div class="field field-type-text field-field-financia-calculadora">
			<div class="field-label">Simulador financiero</div>
			<div class="field-items">
				<div class="field-item odd">
					<div id="calculadora_de_credito">
						<form id="formulario" name="formulario" action="#">
							<div class="div_titulo">
								<span id="numcuotas">C&aacute;lculo aproximado de su cr&eacute;dito</span>
							</div>
<?php
							// verifica que ordenes de pago por concepto de matricula están activas
							$query="select numeroordenpago
								from ordenpago op
								join detalleordenpago dop using(numeroordenpago)
								where codigoestudiante=".$_SESSION['codigo']."
									and codigoconcepto=151
									and codigoestadoordenpago like '1%'";
							$reg=mysql_query($query,$sala);
							if (mysql_num_rows($reg)>0) {
?>
								<div>
<?php
									$query1="select	 nombrecarrera
											,numerodocumento
											,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) as estudiante
										from carrera
										join estudiante using(codigocarrera)
										join estudiantegeneral using(idestudiantegeneral)
										where codigoestudiante=".$_SESSION['codigo'];
									$reg1=mysql_query($query1,$sala);
									$row1=mysql_fetch_array($reg1);
?>
									<span class="etiqueta_seccion">Nombre:</span> <strong><?php echo $row1['estudiante']?><input type="hidden" name="hestudiante" value="<?php echo $row1['estudiante']?>"></strong>
									<span class="etiqueta_seccion">Documento:</span> <strong><?php echo $row1['numerodocumento']?><input type="hidden" name="hnumerodocumento" value="<?php echo $row1['numerodocumento']?>"></strong>
									<span class="etiqueta_seccion">Facultad:</span> <strong><?php echo $row1['nombrecarrera']?><input type="hidden" name="hnombrecarrera" value="<?php echo $row1['nombrecarrera']?>"></strong>
								</div>
								<div class="div_subtitulo">
									<span id="numcuotas">Datos de la simulaci&oacute;n</span>
								</div>
								<div>
<?php 
									// si es mayor a 0 es porque tiene ordenes activas y se puede realizar la simulacion
									$vlrordenes=0;
									$ordenes="";
									while($row=mysql_fetch_array($reg)) {
										$ordenes.=$row['numeroordenpago']." - ";
										$query2="select valorfechaordenpago from fechaordenpago where numeroordenpago=".$row['numeroordenpago']." and current_date()<=fechaordenpago order by fechaordenpago limit 1";
										$reg2=mysql_query($query2,$sala);
										if (mysql_num_rows($reg2)>0) {
											$row2=mysql_fetch_array($reg2);
											$vlrordenes+=$row2['valorfechaordenpago'];
										} else {
											$query3="select max(valorfechaordenpago) as vlr from fechaordenpago where numeroordenpago=".$row['numeroordenpago'];
											$reg3=mysql_query($query3,$sala);
											$row3=mysql_fetch_array($reg3);
											$vlrordenes+=$row3['vlr'];
										}
									}
									$minvlrfinanciar=$vlrordenes*$config_porcentajeminfinanciar/100;
									$maxvlrfinanciar=$vlrordenes*$config_porcentajemaxfinanciar/100;
?>
									<span class="etiqueta_seccion">Orden(es) de matricula activa(s):</span> <strong><?php echo rtrim($ordenes,'- ')?><input type="hidden" name="hordenes" value="<?php echo rtrim($ordenes,'- ')?>"></strong>
								</div>
								<div>
									<span class="etiqueta_seccion2"><strong>Valor de la(s) orden(es): $<?php echo number_format($vlrordenes,0,',','.')?><input type="hidden" name="hvlrordenes" value="<?php echo $vlrordenes?>"></strong></span>
								</div>
								<div class="cuotas">
									<span class="etiqueta_seccion">
										El valor <strong>M&iacute;nimo</strong> a financiar es del <strong><?php echo round($config_porcentajeminfinanciar)?>%</strong>:
									</span>
									<strong>
										<span id="vlrminformat">$<?php echo number_format($minvlrfinanciar,0,',','.')?></span>
									</strong>
									<input type="hidden" id="hminvlrfinanciar" name="hminvlrfinanciar" value="<?php echo $minvlrfinanciar?>">
								</div>
								<div class="cuotas">
									<span class="etiqueta_seccion">
										El valor <strong>M&aacute;ximo</strong> a financiar es del <strong><?php echo round($config_porcentajemaxfinanciar)?>%</strong>:
									</span>
									<strong>
										<span id="vlrmaxformat">$<?php echo number_format($maxvlrfinanciar,0,',','.')?></span>
									</strong>
									<input type="hidden" id="hmaxvlrfinanciar" name="hmaxvlrfinanciar" value="<?php echo $maxvlrfinanciar?>">
								</div>
								<div class="cuotas">
									<span class="etiqueta_seccion">Valor a financiar: <input type="text" name="vlrfinanciar" id="vlrfinanciar" class="boxVlr" size="10" placeholder="0"></span>
								</div>
								<div class="cuotas">
									<span class="etiqueta_seccion">
										Nro. de cuotas:
										<select id="cuotas" name="cuotas" style="width:90px">
											<option value="">Seleccione...</option>
<?php
											for($i=1;$i<=$config_maxnrocuotas;$i++) {
?>
												<option value="<?php echo$i?>"><?php echo$i?> cuota(s)</option>
<?php
											}
?>
										</select>
									</span>
								</div>
								<input type="hidden" name="imprime_adicionales" value="S">
								<input type="hidden" name="config_tasainteres" value="<?php echo $config_tasainteres?>">
								<input type="hidden" name="config_porcentajeestudiocredito" value="<?php echo $config_porcentajeestudiocredito?>">
								<input type="hidden" name="config_ivaporcentajeestudiocredito" value="<?php echo $config_ivaporcentajeestudiocredito?>">
                                                                <input type="hidden" name="config_tarifaestudiocredito" value="<?php echo $config_tarifaestudiocredito?>">
								<input type="submit" value="Calcular" id="calcular">&nbsp;
<?php
							} else {
								// si no hay ordenes activas si informa al estudiante que no se puede realizar la simulacion debido a que no tiene ordenes de matricula generadas activas
?>
								<span class="etiqueta_mensaje"><strong>NO SE PUEDE REALIZAR LA SIMULACIÓN, DEBIDO A QUE NO HAY ORDENES DE MATRICULA ACTIVAS.</strong></span>
<?php
							}
?>
						</form>
					</div>
					<p id="textolegal">
						<strong>Formatos descargables</strong>
					</p>
					<p id="formatos">
						<img src="pdf.png"> <a href="pagare.pdf" target="_blank" style="text-decoration:none">Pagaré</a>
						<br><img src="pdf.png"> <a href="solicitud_credito_educativo.pdf" target="_blank" style="text-decoration:none">Solicitud de crédito educativo</a>
						<br><img src="pdf.png"> <a href="carta_instrucciones.pdf" target="_blank" style="text-decoration:none">Carta de instrucciones</a>
					</p>
					<p id="textolegal">
						Los valores y montos aqui reflejados son <strong>informativos</strong> y <strong>aproximados</strong> y lo pueden orientar en la toma de decisiones. Para mayor informaci&oacute;n, dir&iacute;jase al departamento de <a href="http://www.uelbosque.edu.co/institucional/directorio/credito-cartera-departamento" target="_blank">Finanzas Estudiantiles</a>.
						<br><br>Tasa de inter&eacute;s: <?php echo $config_tasainteres?> M.V.
						<br>Periodo: <?php echo $config_codigoperiodo?>
					</p>
					<div id="calculadora_de_credito2"></div>
				</div>
			</div>
		</div>
		<script>
			jQuery(function() {
				var vmin = $("#hminvlrfinanciar").val();
				var vmax = $("#hmaxvlrfinanciar").val();
				var vminformat = $("#vlrminformat").html();
				var vmaxformat = $("#vlrmaxformat").html();
				$('#formulario').validate({
					rules:{
						 vlrfinanciar:{required:true,min:vmin,max:vmax}
						,cuotas:{required:true}
					}
					,messages:{
						 vlrfinanciar:{required:"Debe ingresar un vlr a financiar",min:"Valor mínimo: "+vminformat,max:"Valor máximo: "+vmaxformat}
						,cuotas:{required:"Seleccione el nro de cuotas"}
					}
					,submitHandler: function(form) {
						$.ajax({
								type: 'GET',
								url: 'calculaCuotas.php',
								async: false,
								data: $('#formulario').serialize(),                
								success:function(data){
									$('#calculadora_de_credito2').html(data);
								},
								error: function(data,error,errorThrown){alert(error + errorThrown);}
						});
					}
				});
			});
		</script>
	</body>
</html>
