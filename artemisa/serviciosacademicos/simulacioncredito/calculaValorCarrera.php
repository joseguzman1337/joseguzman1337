<?php
/**/
@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**/
require_once('../../../kint/Kint.class.php');
require_once('../../../assets/Singleton.php');
$persistencia = new Singleton( ); 
$persistencia->conectar();

require_once("control/ControlCalculaValorCarrera.php");

 
$ControlCalculaValorCarrera = new ControlCalculaValorCarrera();
$row = $ControlCalculaValorCarrera->getPeriodoActualSiguiente($persistencia);

$codcarrera=($_REQUEST["modalidad"]=="pre")?$_REQUEST["codigocarrerapregrado"]:$_REQUEST["codigocarreraposgrado"];

$reg2 = $ControlCalculaValorCarrera->getValorCohortePeriodoCarrera($persistencia, $codcarrera, $row->getPeriodoSiguiente());

$reg2 = $reg2->getValorDetalleCohorte();

if (empty($reg2)) {
	$reg2 = $ControlCalculaValorCarrera->getValorCohortePeriodoCarrera($persistencia, $codcarrera, $row->getPeriodoActivo());
	$totalmatricula = $reg2->getValorDetalleCohorte(); 
} else { 
	$totalmatricula=$reg2;
}
$minvlrfinanciar=$totalmatricula*$_REQUEST["config_porcentajeminfinanciar"]/100;
$maxvlrfinanciar=$totalmatricula*$_REQUEST["config_porcentajemaxfinanciar"]/100;
?>
<h2>Datos de la simulaci&oacute;n</h2>
<p class="font-2">
	Valor de la simulación: $<?php echo number_format($totalmatricula,0,',','.')?><input type="hidden" name="hvlrordenes" id="hvlrordenes" value="<?php echo $totalmatricula?>">
</p>
<div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 pad-all-10" >
	<div class="cuotas contenedorColorWhite pad-all-20">
		<span class="etiqueta_seccion">
			El valor <strong>M&iacute;nimo</strong> a financiar es del <strong><?php echo round($_REQUEST["config_porcentajeminfinanciar"])?>%</strong>:
		</span>
		<strong>
			<span id="vlrminformat">$<?php echo number_format($minvlrfinanciar,0,',','.')?></span>
		</strong>
		<input type="hidden" id="hminvlrfinanciar" name="hminvlrfinanciar" value="<?php echo $minvlrfinanciar?>"> 
	</div>
</div>

<div class="col-md-5 col-sm-5 pad-all-10" >
	<div class="cuotas contenedorColorWhite pad-all-20">
		<span class="etiqueta_seccion">
			El valor <strong>M&aacute;ximo</strong> a financiar es del <strong><?php echo round($_REQUEST["config_porcentajemaxfinanciar"])?>%</strong>:
		</span>
		<strong>
			<span id="vlrmaxformat">$<?php echo number_format($maxvlrfinanciar,0,',','.')?></span>
		</strong>
		<input type="hidden" id="hmaxvlrfinanciar" name="hmaxvlrfinanciar" value="<?php echo $maxvlrfinanciar?>"> 
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 pad-all-10" >
	<div class="cuotas pad-all-20">
		<span class="etiqueta_seccion">
			<div class="form-group">
				Valor a financiar: <input type="text" name="vlrfinanciar" id="vlrfinanciar" size="10" placeholder="0" style="width: 50% !important; display: inline-block;" class="form-control">
			</div>
		</span>
	</div>
</div>

<div class="col-md-5 col-sm-5 pad-all-10" >
	<div class="cuotas pad-all-20">
		<span class="etiqueta_seccion">
			<div class="form-group">
				Nro. de cuotas:
				<select id="cuotas" name="cuotas" style="width: 50% !important; display: inline-block;" class="form-control">
					<option value="">Seleccione...</option>
					<?php
					for($i=1;$i<=$_REQUEST["config_maxnrocuotas"];$i++) {
					?>
						<option value="<?php echo$i?>"><?php echo$i?> cuota(s)</option>
					<?php
					}
					?>
				</select>
			</div>
		</span>
	</div>
</div>
<div class="clearfix"></div> 
<?php
$row = $ControlCalculaValorCarrera->getCarreraPorCodigo($persistencia,$codcarrera);
 
?>
<div class="col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 pad-all-10" >
	<div class="cuotas pad-all-20">
		<input type="hidden" name="hnombrecarrera" id="hnombrecarrera" value="<?php echo $row->getNombreCarrera(); ?>">
		<input type="submit" class="btn btn-fill-green-XL"  value="Calcular" id="calcular">
	</div>
</div>
<div class="clearfix"></div> 
