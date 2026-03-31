<?php 
/**/
@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**/
require_once('../../../kint/Kint.class.php');
require_once('../../../assets/Singleton.php');
$persistencia = new Singleton( ); 
$persistencia->conectar();

require_once("control/ControlConfigSimuladorFinanciero.php");
$ControlConfigSimuladorFinanciero = new ControlConfigSimuladorFinanciero();
//ddd($ControlConfigSimuladorFinanciero);
//include('funciones.php');


$carreraspregrado = $ControlConfigSimuladorFinanciero->getListaCarreras($persistencia,200);
$carrerasposgrado = $ControlConfigSimuladorFinanciero->getListaCarreras($persistencia,300);
//d($carreraspregrado);

session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Simulador de crédito</title> 
		<link type="text/css" rel="stylesheet" href="../../../assets/css/normalize.css">  
		<link type="text/css" rel="stylesheet" href="../../../assets/css/font-page.css"> 	
		<?php /**/ ?><link type="text/css" rel="stylesheet" href="../../../assets/css/font-awesome.css">	
		<link type="text/css" rel="stylesheet" href="../../../assets/css/bootstrap.css">  	<?php /**/ ?>
		<link type="text/css" rel="stylesheet" href="../../../assets/css/general.css">		 	
		<script type="text/javascript" src="../../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../../mgi/js/jquery.validate.min.js"></script>		
		<script defer="defer" type="text/javascript">
			function windowNew() 
			{
				var imprime_adicionales=$("#imprime_adicionales").val();
				var hestudiante=$("#hestudiante").val();
				var hnumerodocumento=$("#hnumerodocumento").val()
				var hnombrecarrera=$("#hnombrecarrera").val();
				var hordenes='No aplica';
				var hvlrordenes=$("#hvlrordenes").val();
				var hminvlrfinanciar=$("#hminvlrfinanciar").val();
				var hmaxvlrfinanciar=$("#hmaxvlrfinanciar").val();
				var vlrfinanciar=$("#vlrfinanciar").val();
				var cuotas=$("#cuotas").val();
				var observaciones=$("#observaciones").val();
				var config_tasainteres=$("#config_tasainteres").val();
				var config_porcentajeestudiocredito=$("#config_porcentajeestudiocredito").val();
				var config_tarifaestudiocredito=$("#config_tarifaestudiocredito").val();
				var config_ivaporcentajeestudiocredito=$("#config_ivaporcentajeestudiocredito").val();
				var imprime_observaciones='N';
				window.open('formato.php?imprime_adicionales='+imprime_adicionales+'&hestudiante='+hestudiante+'&hnumerodocumento='+hnumerodocumento+'&hnombrecarrera='+hnombrecarrera+'&hordenes='+hordenes+'&hvlrordenes='+hvlrordenes+'&hminvlrfinanciar='+hminvlrfinanciar+'&hmaxvlrfinanciar='+hmaxvlrfinanciar+'&vlrfinanciar='+vlrfinanciar+'&cuotas='+cuotas+'&observaciones='+observaciones+'&config_tasainteres='+config_tasainteres+'&config_porcentajeestudiocredito='+config_porcentajeestudiocredito+'&config_tarifaestudiocredito='+config_tarifaestudiocredito+'&config_ivaporcentajeestudiocredito='+config_ivaporcentajeestudiocredito+'&imprime_observaciones='+imprime_observaciones,'_blank','width=800,height=800,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes');
			}
			function cargaLista(vlr) {
				if(vlr==1) {
					document.getElementById('pregrado').style.display='';
					document.getElementById('posgrado').style.display='none';
					document.getElementById('posgrado').value="";
				} else {
					document.getElementById('pregrado').style.display='none';
					document.getElementById('posgrado').style.display='';
					document.getElementById('pregrado').value="";
				}
				$('#spanvValoresCarrera').html("");
				$('#calculadora_de_credito2').html("");
			}
		</script>
	</head>
	<body>
		<?php 		
		//$datos = $persistencia->obtenerconfiguracion();
		/*require_once('../../Connections/sala2.php'); $rutaado = "../../funciones/adodb/";
		require_once('../../Connections/salaado.php');
		$query="select * from configsimuladorfinanciero where activo order by idconfigsimuladorfinanciero desc limit 1";		
		$reg=mysql_query($query,$sala);
		$row=mysql_fetch_array($reg);/**/
		$row = $ControlConfigSimuladorFinanciero->getConfigSimuladorFinanciero($persistencia);
		//ddd($row);
		$config_codigoperiodo=$row->getCodigoPeriodo();
		$config_tasainteres=$row->getTasaInteres();
		$config_porcentajeminfinanciar=$row->getPorcentajeMinFinanciar();
		$config_porcentajemaxfinanciar=$row->getPorcentajeMaxFinanciar();
		$config_porcentajeestudiocredito=$row->getPorcentajeEstudioCredito();
		$config_ivaporcentajeestudiocredito=$row->getIvaPorcentajeEstudioCredito();
		$config_maxnrocuotas=$row->getMaxNroCuotas();
		$config_tarifaestudiocredito = $row->getValorEstudioCredito();
		?>
		<div class="container">			
			<div class="row" id="simulador">
				<center>
					<h1 class="h1">Simulador financiero</h1> 
				</center>
				<p class="font-2 pad-bottom-15">
					Evalúa, calcula y decide la mejor manera de realizar tus pagos del semestre que cursarás. Organiza tus finanzas y planifica tus cuotas para tener una mejor proyección financiera.
				</p>
				<div class="contenedorColorBrand fontColorWhite col-md-5  col-md-offset-1 col-sm-5  col-sm-offset-1 pad-all-20" >
					<h4>Cálculo aproximado del crédito</h4>
					<form  id="formulario" name="formulario" action="#">
						<div class="form-group">
							<input type="text" class="form-control input-sm" name="hestudiante" id="hestudiante" placeholder="Nombre Completo">	
							<br>
							<input type="text" class="form-control input-sm" name="hnumerodocumento" id="hnumerodocumento" placeholder="Documento">
						</div>				
						<h4>Seleccione el programa de interes:</h4>	
						<label class="radio-inline"> <input type="radio" value="1" onclick="cargaLista(this.value)" name="nivel" checked="checked">Pregrado</label>
						<label class="radio-inline"> <input type="radio" value="2" onclick="cargaLista(this.value)" name="nivel">Posgrado </label>					
				
						<div>						
							<h4>Seleccione el programa de su interés:</h4>
							<select name="codigocarrerapregrado" id="pregrado" style="color:black;" class="form-control">
								<option value="">Seleccione...</option>
								<?php
								foreach($carreraspregrado as  $row ) {
								?>
									<option value='<?php echo $row->getCodigoCarrera(); ?>' ><?php echo $row->getNombreCarrera(); ?></option>
								<?php
								}
								?>
							</select>
							<select name="codigocarreraposgrado" id="posgrado" style="display:none; color:black;" class="form-control">
								<option value="">Seleccione...</option>
								<?php
								foreach($carrerasposgrado as  $row ) {
								?>
									<option value='<?php echo $row->getCodigoCarrera(); ?>' ><?php echo $row->getNombreCarrera(); ?></option>
								<?php
								}
								?>
							</select>						
						</div>
						<input type="hidden" name="imprime_adicionales" id="imprime_adicionales" value="S">
						<input type="hidden" name="config_tasainteres" id="config_tasainteres" value="<?php echo $config_tasainteres?>">
						<input type="hidden" name="config_porcentajeestudiocredito" id="config_porcentajeestudiocredito" value="<?php echo $config_porcentajeestudiocredito?>">
						<input type="hidden" name="config_tarifaestudiocredito" id="config_tarifaestudiocredito" value="<?php echo $config_tarifaestudiocredito?>">
						<input type="hidden" name="config_ivaporcentajeestudiocredito" id="config_ivaporcentajeestudiocredito" value="<?php echo $config_ivaporcentajeestudiocredito?>">
						<input type="hidden" name="config_porcentajeminfinanciar" id="config_porcentajeminfinanciar" value="<?php echo $config_porcentajeminfinanciar?>">
						<input type="hidden" name="config_porcentajemaxfinanciar" id="config_porcentajemaxfinanciar" value="<?php echo $config_porcentajemaxfinanciar?>">
						<input type="hidden" name="config_maxnrocuotas" id="config_maxnrocuotas" value="<?php echo $config_maxnrocuotas?>">
					</form>
				</div>
				<div id="lateral" class="col-md-5 col-sm-5 pad-all-20">						
					<p id="textolegal">
							<strong>Formatos descargables</strong>
					</p>
					<p id="formatos">
						<i class="fa fa-file-pdf-o" aria-hidden="true"></i> 
						<a href="pagare.pdf" target="_blank">Pagaré</a>
						<br>	
												
						<i class="fa fa-file-pdf-o" aria-hidden="true"></i> 
						<a href="solicitud_credito_educativo.pdf" target="_blank" >Solicitud de crédito educativo</a>
						<br>
						
						<i class="fa fa-file-pdf-o" aria-hidden="true"></i>
						<a href="carta_instrucciones.pdf" target="_blank">Carta de instrucciones</a>
					</p>
					<p id="textolegal">
						Los valores y montos aqui reflejados son informativos y aproximados, te podrán orientar en la toma de decisiones. Para mayor informacón, acércate al departamento de <a href="http://www.uelbosque.edu.co/institucional/directorio/credito-cartera-departamento" target="_blank">Finanzas Estudiantiles</a>.
						<br><br>
						<span class="font-italic">
							Tasa de inter&eacute;s: <?php echo $config_tasainteres?> M.V.
							<br>Periodo: <?php echo $config_codigoperiodo?>
						</span>
					</p>					
				</div>
			</div>
			
			<div class="row" >
				<div class="contenedorColorGray2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 pad-all-20" >
					<form  id="formulario2" name="formulario2" action="#">
						<div id="spanvValoresCarrera" class="" >					
						</div>
						<div id="calculadora_de_credito2">
						</div>
						
						<input type="hidden" name="imprime_adicionales" id="imprime_adicionales" value="S">
						<input type="hidden" name="config_tasainteres" id="config_tasainteres" value="<?php echo $config_tasainteres?>">
						<input type="hidden" name="config_porcentajeestudiocredito" id="config_porcentajeestudiocredito" value="<?php echo $config_porcentajeestudiocredito?>">
						<input type="hidden" name="config_tarifaestudiocredito" id="config_tarifaestudiocredito" value="<?php echo $config_tarifaestudiocredito?>">
						<input type="hidden" name="config_ivaporcentajeestudiocredito" id="config_ivaporcentajeestudiocredito" value="<?php echo $config_ivaporcentajeestudiocredito?>">
						<input type="hidden" name="config_porcentajeminfinanciar" id="config_porcentajeminfinanciar" value="<?php echo $config_porcentajeminfinanciar?>">
						<input type="hidden" name="config_porcentajemaxfinanciar" id="config_porcentajemaxfinanciar" value="<?php echo $config_porcentajemaxfinanciar?>">
						<input type="hidden" name="config_maxnrocuotas" id="config_maxnrocuotas" value="<?php echo $config_maxnrocuotas?>">
					</form>
				</div>
			</div>
		</div>
		<script>
			jQuery(function() {
				$('#formulario2').validate({
					rules:{
						 hestudiante:{required:true}
						,hnumerodocumento:{required:true}
						,vlrfinanciar:{
							 required:true
							,min:function() { return $("#hminvlrfinanciar").val() }
							,max:function() { return $("#hmaxvlrfinanciar").val() }
						 }
						,cuotas:{required:true}
					}
					,messages:{
						 hestudiante:{required:"Digite su nombre"}
						,hnumerodocumento:{required:"Digite su documento"}
						,vlrfinanciar:{
							 required:"Debe ingresar un vlr a financiar"
							,min:function() { return "Valor mínimo: "+$("#vlrminformat").html() }
							,max:function() { return "Valor máximo: "+$("#vlrmaxformat").html() }
						 }
						,cuotas:{required:"Seleccione el nro de cuotas"}
					}
					,submitHandler: function(form) {
						$.ajax({
								type: 'GET',
								url: 'calculaCuotas.php',
								async: false,
								data: $('#formulario2').serialize(),                
								success:function(data){
									$('#calculadora_de_credito2').html(data);
								},
								error: function(data,error,errorThrown){alert(error + errorThrown);}
						});
					}
				});
				$("#pregrado").change(function(evento){
					evento.preventDefault();
					$.ajax({
							type: 'GET',
							url: 'calculaValorCarrera.php',
							async: false,
							data: $('#formulario').serialize()+"&modalidad=pre",
							success:function(data){
								$('#spanvValoresCarrera').html(data);
								$('#calculadora_de_credito2').html("");
							},
							error: function(data,error,errorThrown){alert(error + errorThrown);}
					});
				});
				$("#posgrado").change(function(evento){
					evento.preventDefault();
					$.ajax({
							type: 'GET',
							url: 'calculaValorCarrera.php',
							async: false,
							data: $('#formulario').serialize()+"&modalidad=pos",
							success:function(data){
								$('#spanvValoresCarrera').html(data);
								$('#calculadora_de_credito2').html("");
							},
							error: function(data,error,errorThrown){alert(error + errorThrown);}
					});
				});
			});
		</script>
	</body>
</html>