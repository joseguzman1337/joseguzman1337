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


$facultades = $controlFacultad->consultarFacultad( );

$tipoGrados = $controlTipoGrado->consultarTipoGrado( );
	
?>
<script src="../js/jquery-filestyle.min.js"></script>
<link href="../css/jquery-filestyle.min.css" rel="stylesheet">
<script src="../js/MainDigitalizar.js"></script>
<form id="formDigitalizar">
	<p>
		<input type="hidden" id="tipoOperacionDigitalizar" name="tipoOperacionDigitalizar" value="consultarDigitalizar" />
		<input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
	</p>
	<fieldset>
		<legend>Digitalización de Documentos</legend>
		<br />
		<table width="100%" border="0">
			<tr valign="top">
				<td>
					<fieldset>
						<legend>Consultar Estudiantes Graduado</legend>
						<br />
						<table width="100%">
							<tr>
								<td >Facultad</td>
								<td ><select id="cmbFacultadDigitalizar" name="cmbFacultadDigitalizar" class="campobox">
									<option value="-1">Seleccione la Facultad</option>
									<?php 
									foreach ( $facultades as $facultad ) {?>
										<option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
									<?php }?>
									</select>
								</td>
								<td>Programa</td>
								<td><select id="cmbCarreraDigitalizar" name="cmbCarreraDigitalizar" class="combobox">
									<option value="-1">Seleccione la Carrera</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Período</td>
								<td><select id="cmbPeriodoDigitalizar" name="cmbPeriodoDigitalizar" class="combobox">
									<option value="-1">Seleccione el Período</option>
									<?php 
									foreach ( $periodos as $periodo ) {?>
										<option value="<?php echo $periodo->getCodigo( ); ?>"><?php echo $periodo->getNombrePeriodo( ) ;?></option>
									<?php }?>
									</select>
								</td>
								<td>Tipo Grado</td>
								<td><select id="cmbTipoGradoDigitalizar" name="cmbTipoGradoDigitalizar" class="campobox">
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
	<div>
	  <div style="float:left">
	  	<a id="btnBuscarDigitalizar">Consultar</a>
	  	<a id="btnRestaurarDigitalizar">Restaurar</a>
	
	  	<!--<input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
		<input type="submit" id="btnExportarRadicacion" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>-->
	  </div>
	 <div style="float:right">
	  <input type="file"  multiple="multiple"  id="txtFileAvance" name="txtFileAvance"   webkitdirectory  class="jfilestyle"  accept=".pdf"  data-input="false" data-buttonText="Seleccionar Archivos">
	  <button id="btnCargarArchivos">Guardar</button>
	</div>
	  
	 <div>
	<br />
</form>
<br />
<br />
<table width="100%" >
	<tbody id="TablaDigitalizar">
	</tbody>
</table>
<br />
<div align="right" id="reportePaginador"></div>

