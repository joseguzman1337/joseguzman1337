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
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlReferencia.php';

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

$controlTipoDocumento = new ControlTipoDocumento( $persistencia );
$controlFacultad = new ControlFacultad( $persistencia );
$controlReferencia = new ControlReferencia( $persistencia );

$tipoDocumentos = $controlTipoDocumento->consultar( );

$facultades = $controlFacultad->consultarFacultad( );

$documentoDuplicados = $controlReferencia->consultarDocumentoDuplicado( );

?>
<script src="../js/MainDuplicar.js"></script>
<form id="formDuplicar" method="post">
	<p>
		<input type="hidden" id="txtIdRol" name="txtIdRol" value="<?php echo $lrol; ?>" />
	</p>
	<fieldset>
		<legend>Duplicar Documentos de Grado</legend>
		<br />
		<table width="100%" border="0">
			<tr valign="top">
				<td>
					<fieldset>
						<legend>Generar Duplicados</legend>
						<br />
						<table width="100%">
							<tr>
								<td >Facultad</td>
								<td ><select id="cmbFacultadDuplicar" name="cmbFacultadDuplicar" class="campobox">
									<option value="-1">Seleccione la Facultad</option>
									<?php 
									foreach ( $facultades as $facultad ) {?>
										<option value="<?php echo $facultad->getCodigoFacultad( ); ?>"><?php echo $facultad->getNombreFacultad( ); ?></option>
									<?php }?>
									</select>
								</td>
								<td>Programa</td>
								<td><select id="cmbCarreraDuplicar" name="cmbCarreraDuplicar" class="combobox">
									<option value="-1">Seleccione la Carrera</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Número Documento</td>
								<td><input type="text" id="txtNumeroEstudiante" name="txtNumeroEstudiante" class="txtNumeroDocumento" />
									<input type="hidden" id="txtIdEstudiante" name="txtIdEstudiante" />
								</td>
								<td>Tipo Documento</td>
								<td><select id="cmbTipoDocumento" name="cmbTipoDocumento" class="combobox">
									<option value="-1">Seleccione el Tipo de Documento</option>
									<?php 
									foreach ( $tipoDocumentos as $tipoDocumento ) {?>
										<option value="<?php echo $tipoDocumento->getIniciales( ); ?>"><?php echo $tipoDocumento->getDescripcion( ); ?></option>
									<?php }?>
								</select></td>
							</tr>
							<tr>
								<td>Nombres</td>
								<td><input type="text" id="txtNombreEstudiante" name="txtNombreEstudiante" /></td>
								<td>Apellidos</td>
								<td><input type="text" id="txtApellidoEstudiante" name="txtApellidoEstudiante" /></td>
							</tr>
							<tr>
								<td>Persona que Autoriza</td>
								<td><div class="frmSearch">
									<input type="text" id="txtDirectivo" name="txtDirectivo" />
									<input type="hidden" id="idDirectivo" name="idDirectivo" />
									<div id="suggesstion-box"></div>
									</div>
								</td>
								<td>Documentos a Duplicar</td>
								<td><div>
									<?php foreach( $documentoDuplicados as $documentoDuplicado ){ ?>
									<input type="checkbox" id="ckDuplicado[]" name="ckDuplicado[]" class="ckDuplicado" value="<?php echo $documentoDuplicado->getCodigoReferencia( ); ?>" /><?php echo $documentoDuplicado->getNombreReferencia( ); ?><br />
									<?php } ?>
									</div></td>
							</tr>
						</table>
						<br />
						<table width="100%">
							<tr id="trNumeroDuplicadoDiploma">
								<td>Número de Diploma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td><input type="text" id="txtNumeroDiplomaDuplicado" name="txtNumeroDiplomaDuplicado" /></td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
		
		<br />
	</fieldset>
	<br />
	  <div align="left">
	  	<input type="submit" id="btnDuplicar" value="Duplicar Documento"  onclick="this.form.action='../servicio/duplicar.php'"/>
	  	<!--<a id="btnDuplicar">Duplicar</a>-->
	  	<a id="btnRestaurarDuplicar">Restaurar</a>
	  	<!--<input type="submit" id="btnExportarRGrado" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>
	  <input type="submit" id="btnExportarRadicacion" value="Exportar Excel" onclick="this.form.action='../servicio/excel.php'"/>-->
	  </div>
	<br />
</form>