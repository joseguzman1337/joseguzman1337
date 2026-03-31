<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */

header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors','On');

session_start( );


include '../tools/includes.php';

//include '../control/ControlRol.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoGrado.php';

if( isset ( $_SESSION["datoSesion"] ) ){
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 4 ] );
	$persistencia->conectar( );
}else{
	header("Location:error.php");
}

$controlPeriodo = new ControlPeriodo( $persistencia );
$controlFacultad = new ControlFacultad( $persistencia );
$controlTipoGrado = new ControlTipoGrado( $persistencia );

$periodos = $controlPeriodo->consultar( );

if( $lrol != 25 && $lrol != 53 && $lrol != 89 ){
$facultades = $controlFacultad->consultar($idPersona);
}else{
	$facultades = $controlFacultad->consultarFacultad( );
}

$tipoGrados = $controlTipoGrado->consultarTipoGrado( );

$cuenta = count($facultades);
?>
<script src="../js/MainTableroMando.js"></script>
<form id="formTableroMando">
	<p>
		<!--<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="consultar" />-->
		<input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
		<input type="hidden" id="txtCuentaFacultad" name="txtCuentaFacultad" value="<?php echo $cuenta; ?>" />
		<input type="hidden" id="txtUsuario" name="txtUsuario" value="<?php echo $luser; ?>" />
	</p>
	<fieldset>
		<legend>Requisitos de Cumplimiento</legend>
		<br />
		<table width="100%" border="0">
			<tr valign="top">
				<td>
					<fieldset>
						<legend>Consultar Detalle Paz y Salvo Estudiantes</legend>
						<br />
						<table width="100%">
							<tr>
								<td id="tdFacultadTMando">Facultad</td>
								<td id="tdCmbFacultadTMando" ><select id="cmbFacultadTMando" name="cmbFacultadTMando" class="campobox">
									<option value="-1">Seleccione la Facultad</option>
									<?php 
									foreach ( $facultades as $facultad ) {?>
										<option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
									<?php }?>
									</select>
								</td>
								<td>Programa</td>
								<td><select id="cmbCarreraTMando" name="cmbCarreraTMando" class="combobox">
									<option value="-1">Seleccione la Carrera</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Período</td>
								<td><select id="cmbPeriodoTMando" name="cmbPeriodoTMando" class="combobox">
									<option value="-1">Seleccione el Período</option>
									<?php 
									foreach ( $periodos as $periodo ) {?>
										<option value="<?php echo $periodo->getCodigo( ); ?>"><?php echo $periodo->getNombrePeriodo( ) ;?></option>
									<?php }?>
									</select>
								</td>
								<td>Tipo Grado</td>
								<td><select id="cmbTipoGrado" name="cmbTipoGrado" class="campobox">
									<option value="-1">Seleccione el Tipo de Grado</option>
									<?php 
									foreach ( $tipoGrados as $tipoGrado ) {?>
										<option value="<?php echo $tipoGrado->getIdTipoGrado( ); ?>"><?php echo $tipoGrado->getNombreTipoGrado( );?></option>
									<?php }?>
									</select>
								</td>
							</tr>
						</table>
						<br />
					</fieldset>
				</td>
			</tr>
		</table>
		<br />
	</fieldset>
	</br>
	  <div align="left"><a id="btnBuscarTMando">Consultar</a>
	  	<a id="btnRestaurarTMando">Restaurar</a>
	  	<!--<input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
	  <input type="submit" id="btnExportarRadicacion" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>-->
	  </div>
</form>
	</br>
	<div style="overflow: auto; width: 100%; top: 0px; height: 100%px">
		<table width="100%" >
			<tbody id="TablaEstudiante">
			</tbody>
		</table>
		<br />
	</div>
<div id="mensageActualizarEstudiante" align="left"></div>
<div id="mensageDocumentos"></div>
<div id="mensageTrabajoGrado"></div>
<div id="mensageDerechoGrado"></div>
<div id="mensageDocIngles"></div>
<div id="mensageDeudaOtros"></div>
<div id="mensageMaterias"></div>
<div id="mensageDeudaPeople"></div>
<div id="actaAcuerdo"></div>
<div id="mensageDetalleActaAcuerdo"></div>
<div id="mensageAnularActaAcuerdo"></div>
<div id="mensageRAcuerdo"></div>
<div id="mensageImpresion"></div>
<div id="verArchivos"></div>
<div id="dvFolio"></div>
<div id="actualizaDiploma"></div>
<div id="dvFirma"></div>