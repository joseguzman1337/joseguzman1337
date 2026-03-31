<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package servicio
   */
  
  	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	set_time_limit(0);
	
	session_start( );
	
	include '../tools/includes.php';
	
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
	include '../control/ControlFechaGrado.php';
	include '../control/ControlPazySalvoEstudiante.php';
	include '../control/ControlPreMatricula.php';
	include '../control/ControlClienteWebService.php';
	include '../control/ControlCarreraPeople.php';
	include '../control/ControlActaAcuerdo.php';
	include '../control/ControlIncentivoAcademico.php';
	include '../control/ControlRegistroGrado.php';
	include '../control/ControlDeudaPeople.php';
	include '../control/ControlEstudianteDocumento.php';
	include '../control/ControlDocumentoPeople.php';
	include '../control/ControlGeneroPeople.php';
	include '../control/ControlLocalidad.php';
	include '../control/ControlFolioTemporal.php';
	include '../control/ControlDirectivo.php';
	
	if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			$$key_post = strip_tags(trim($_POST[$key_post]));
		}
	}
	
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){ 
	        $$key_get = strip_tags(trim($_GET[$key_get])); 
	     } 
	}
	
	$persistencia = new Singleton( );
	$persistencia->conectar( );
	
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	$controlIncentivoAcademico = new ControlIncentivoAcademico( $persistencia );
	
	$estudiante = $controlRegistroGrado->consultarRegistroGradoFormulario( $txtCodigoEstudiante );
	
	$txtIdRegistroGrado = $estudiante->getIdRegistroGrado( );
	if( $txtIdRegistroGrado != "" ){
	$txtCodigoCarrera = $estudiante->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getCodigoCarrera( );
	
	$observaciones = $controlRegistroGrado->consultarObservaciones( $txtIdRegistroGrado );
	
	
	$incentivos = $controlIncentivoAcademico->listarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera );
	
?>
<form>
<table width="716" border="1">
  <tr>
    <td colspan="4"><strong style="color: rgb(258,128,0)" >Registro Grado</strong></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Nombre del Egresado</strong></td>
    <td colspan="2"><strong>Documento del Egresado</strong></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $estudiante->getEstudiante( )->getNombreEstudiante( ); ?></td>
    <td colspan="2"><?php echo $estudiante->getEstudiante( )->getNumeroDocumento( ); ?></td>
  </tr>
  <tr>
    <td width="174"><strong>Id del Estudiante</strong></td>
    <td width="178"><strong>Fecha del Registro de Grado</strong></td>
    <td width="169"><strong>Fecha del Grado</strong></td>
    <td width="167"><strong>Fecha de Autorización</strong></td>
  </tr>
  <tr>
    <td><?php echo $estudiante->getEstudiante( )->getCodigoEstudiante( ); ?></td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getFechaCreacionRegistroGrado( ) ) ); ?></td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getActaAcuerdo( )->getFechaAcuerdo( ) ) ); ?></td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getFechaCreacionRegistroGrado( ) ) ); ?></td>
  </tr>
  <tr>
    <td><strong>Tipo del Registro</strong></td>
    <td><strong>Fecha del Acuerdo</strong></td>
    <td><strong>Fecha del Diploma</strong></td>
    <td><strong>Fecha del Acta</strong></td>
  </tr>
  <tr>
    <td>Ordinario</td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getActaAcuerdo( )->getFechaAcuerdo( ) ) ); ?></td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getFechaCreacionRegistroGrado( ) ) ); ?></td>
    <td><?php echo date( "Y-m-d", strtotime( $estudiante->getActaAcuerdo( )->getFechaAcuerdo( ) ) ); ?></td>
  </tr>
  <tr>
    <td><strong>Número de Promoción</strong></td>
    <td><strong>Número de Acuerdo</strong></td>
    <td><strong>Número del Diploma</strong></td>
    <td><strong>Número del Acta</strong></td>
  </tr>
  <tr>
    <td><?php echo $estudiante->getNumeroPromocion( ); ?></td>
    <td><?php echo $estudiante->getActaAcuerdo( )->getNumeroAcuerdo( ); ?></td>
    <td><?php echo $estudiante->getNumeroDiploma( ); ?></td>
    <td><?php echo $estudiante->getActaAcuerdo( )->getNumeroActaConsejoDirectivo( ); ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Grado</strong></td>
    <td><strong>Autorización</strong></td>
    <td><strong>Carrera</strong></td>
    <td><strong>Tipo de Modificación</strong></td>
  </tr>
  <tr>
    <td><?php echo $estudiante->getActaAcuerdo( )->getFechaGrado( )->getTipoGrado( )->getNombreTipoGrado( ); ?></td>
    <td>Autorizado Grado</td>
    <td><?php echo $estudiante->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCortoCarrera( ); ?></td>
    <td>Registro Original</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Responsable del Acuerdo</strong></td>
    <td colspan="2"><strong>Nombre del Directivo Responsable</strong></td>
  </tr>
  <tr>
    <td colspan="2">Consejo Directivo</td>
    <td colspan="2"><?php echo $estudiante->getDirectivoRegistroGrado( )->getNombreDirectivo( ); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Lugar Registro</strong></td>
    <td colspan="2"><strong>Presidio del Registro</strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Observaciones</strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php if( count( $observaciones ) != 0 ){ ?> 
    	<ul><?php foreach( $observaciones as $observacion ){ ?>
     	<li><?php echo $observacion->getObservacionDiploma( ); ?></li>
    	<?php }
    	?></ul><?php }else{
    		echo "No tiene observaciones";
    	} ?>  
		</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Incentivos</strong></td>
  </tr>
  <tr>
    <td colspan="4"><?php if( count( $incentivos ) != 0 ){ ?> 
    	<ul><?php foreach( $incentivos as $incentivo ){ ?>
     	<li><?php echo $incentivo->getNombreIncentivo( ); ?></li>
    	<?php }
    	?></ul><?php }else{
    		echo "No tiene incentivos";
    	} ?> </td>
  </tr>
</table>
<input type="button" name="Regresar" value="Regresar" onClick="javascript:window.history.back();" />
</form>
<?php }else{
	echo "El estudiante no tiene registro de Grado nuevo";
} ?>