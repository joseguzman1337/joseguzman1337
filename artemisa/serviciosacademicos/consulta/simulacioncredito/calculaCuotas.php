<?php
/**/
@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**/
require_once('../../../kint/Kint.class.php');
require_once('../../../assets/Singleton.php');
$persistencia = new Singleton( ); 
$persistencia->conectar();

//d($_REQUEST);
$vlrcuotainicial=$_REQUEST["hvlrordenes"]-$_REQUEST["vlrfinanciar"];
//d($vlrcuotainicial);
$vlrtaza=$_REQUEST['config_tasainteres']/100;
$vlrcuota=$_REQUEST['vlrfinanciar']*$vlrtaza*pow((1+$vlrtaza),$_REQUEST['cuotas'])/(pow((1+$vlrtaza),$_REQUEST['cuotas'])-1);
?>
<div class="contenedorColorWhite col-md-12 pad-all-20">
	<?php
	if($_REQUEST['imprime_adicionales']=='S') {
	?>
	<div class="pad-all-20">
		<p><b>CUOTA INICIAL: $<?php echo number_format($vlrcuotainicial,0,',','.')?></b></p>
		<p><b>VALOR A FINANCIAR: $<?php echo number_format($_REQUEST["vlrfinanciar"],0,',','.')?></b></p>
	</div>
	<?php
	}
	?>
	<div class="table-responsive">
		<table class="table table-striped table-line-green-headers">
			<tr>
				<th>Nro. cuota</th>
				<th>Fecha de pago</th>
				<th>Valor capital</th>
				<th>Valor intereses</th>
				<th>Valor cuota</th>
			</tr>
		<?php
			$i=1;
			$sumabonocap=0;
			$sumabonoint=0;
			$sumvlrcuota=0;
			while($i<=$_REQUEST['cuotas']) {
				$Fecha = mktime(0, 0, 0, date("m")+($i), date("d"), date("Y"));
				if($i==1) {
					$saldocapital=$_REQUEST['vlrfinanciar'];
				} else {
					$saldocapital=$saldocapital-$abonocap;
				}
				$abonoint=$saldocapital*$vlrtaza;
				$abonocap=$vlrcuota-$abonoint;
		?>
				<tr>
					<td><?php echo$i?></td>
					<td><?php echo date('Y-m-d',$Fecha)?></td>
					<td>$<?php echo number_format($abonocap,0,',','.')?></td>
					<td>$<?php echo number_format($abonoint,0,',','.')?></td>
					<td>$<?php echo number_format($vlrcuota,0,',','.')?></td>
				</tr>
		<?php
				$sumabonocap+=$abonocap;
				$sumabonoint+=$abonoint;
				$sumvlrcuota+=$vlrcuota;
				$i++;
			}
			
			if(isset($_REQUEST["config_tarifaestudiocredito"])&& $_REQUEST["config_tarifaestudiocredito"]!="" && $_REQUEST["config_tarifaestudiocredito"]>0){
				$vlrestudiodecredito = $_REQUEST["config_tarifaestudiocredito"];
			} else {
				$vlrestudiodecredito=$sumvlrcuota*($_REQUEST["config_porcentajeestudiocredito"]/100);
			}
			$ivavlrestudiodecredito=$vlrestudiodecredito*($_REQUEST["config_ivaporcentajeestudiocredito"]/100);
			$vlrtotalestudiodecredito=$vlrestudiodecredito+$ivavlrestudiodecredito;	
		?>
			<tr>
				<td colspan="2"><b>TOTAL</b></td>
				<td><b>$<?php echo number_format($sumabonocap,0,',','.')?></b></td>
				<td><b>$<?php echo number_format($sumabonoint,0,',','.')?></b></td>
				<td><b>$<?php echo number_format($sumvlrcuota,0,',','.')?></b></td>
			</tr>
		</table>
	</div>
	<div class="clearfix"></div> 
	
	<p>El valor que debe cancelar por el <b>aval de cr&eacute;dito</b> que se realizar&aacute; es de <b>$<?php echo number_format($vlrtotalestudiodecredito,0,',','.')?></b></p>
	
</div>
<div class="clearfix" ></div>

<div class="contenedorColorGray2 col-md-12 pad-all-20">
	<?php
	if($_REQUEST['imprime_adicionales']=='S') {
	?>
	<p class="font-2">Observaciones</p>
	<textarea id="observaciones" name="observaciones" rows="4" cols="70" placeholder="Si lo desea puede agregar observaciones acerca de la simulación realizada para que sean tenidas en cuenta por el personal de Finanzas Estudiantiles."></textarea>
	<div class="clearfix" ></div>
	<a href="#" onClick="windowNew()">Ver formato de impresión</a>
	<div class="clearfix" ></div>
	<?php
	}	
	?>
</div>
<div class="clearfix" ></div>