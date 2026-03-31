<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package interfaz
 */

header('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

ini_set('display_errors', 'On');

session_start();

include '../tools/includes.php';

//include '../control/ControlRol.php';
include '../control/ControlCarrera.php';
include '../control/ControlItem.php';
include '../control/ControlPeriodo.php';
include '../control/ControlFacultad.php';
include '../control/ControlTipoDocumento.php';
include '../control/ControlContacto.php';
include '../control/ControlEstudiante.php';
include '../control/ControlTrabajoGrado.php';
include '../control/ControlConcepto.php';
include '../control/ControlDocumentacion.php';
include '../control/ControlCarreraPeople.php';
include '../control/ControlActaAcuerdo.php';
include '../control/ControlRegistroGrado.php';
include '../control/ControlFechaGrado.php';
include '../control/ControlDirectivo.php';
include '../control/ControlDocumentoGrado.php';

if ($_POST) {
	$keys_post = array_keys($_POST);
	foreach ($keys_post as $key_post) {
		$$key_post = strip_tags(trim($_POST[$key_post]));
	}
}

if ($_GET) {
	$keys_get = array_keys($_GET);
	foreach ($keys_get as $key_get) {
		$$key_get = strip_tags(trim($_GET[$key_get]));
	}
}

if (isset($_SESSION["datoSesion"])) {
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[0];
	$luser = $user[1];
	$lrol = $user[3];
	$persistencia = new Singleton();
	$persistencia = $persistencia -> unserializar($user[4]);
	$persistencia -> conectar();
} else {
	header("Location:error.php");
}

$controlDirectivo = new ControlDirectivo($persistencia);
$controlDocumentoGrado = new ControlDocumentoGrado( $persistencia );

$fechaActual = date("Y-m-d");

$txtFechaFirmaDocumento = $fechaActual;

$firmas = $controlDirectivo -> consultarFirmas($txtFechaFirmaDocumento, $txtCodigoCarrera);

$tipoDocumentoGrados = $controlDocumentoGrado->consultarTipoDocumentoGrado( );

?>
<script src="../js/MainFirma.js"></script>
<form id="formFirmas">
	<p>
		<input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado;?>" />
		<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera;  ?>" />
	</p>
	<table width="100%" border="0">
		<tr>
			<td >Tipo Documento Grado</td>
			<td ><select id="cmbTipoDocumentoGrado" name="cmbTipoDocumentoGrado" class="campobox">
				<option value="-1">Seleccione el Tipo Documento Grado</option>
				<?php 
				foreach ( $tipoDocumentoGrados as $tipoDocumentoGrado ) {?>
					<option value="<?php echo $tipoDocumentoGrado->getCodigoTipoDocumentoGrado( ); ?>"><?php echo $tipoDocumentoGrado->getNombreTipoDocumentoGrado( ); ?></option>
				<?php }?>
				</select>
			</td>
		</tr>
	</table>
	<br />
	<table width="100%" border="1" id="directivoFirma" bordercolor="#E9E9E9" cellpadding="10" cellspacing="10" >
		
		<?php foreach( $firmas as $firma  ){
		?>
		<tr>
			<td><?php echo $firma -> getNombreDirectivo();?></td>
			<td>
			<input type="checkbox" id="ckFirma" name="ckFirma" value="<?php echo $firma -> getIdDirectivo();?>" />
			</td>
		</tr>
		<?php }?>
	</table>
	<br />
	<a id="btnGuardarFirma" name="btnGuardarFirma">Enviar</a>
</form>