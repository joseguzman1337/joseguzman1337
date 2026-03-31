<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 * @since enero  23, 2017
 */ 

header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//include('../../../kint/Kint.class.php');

ini_set('display_errors','On');
//error_reporting(E_ALL);
session_start( );

include '../tools/includes.php';
include '../control/ControlEstudianteGeneral.php';
include '../control/ControlDocumento.php';

require_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);


if( isset ( $_SESSION["datoSesion"] ) ){

	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 4 ] );
	$persistencia->conectar( );
}

$controlTipoDocumento=new ControlDocumento( $persistencia );
$tipoDocumento=$controlTipoDocumento->consultarTipoDocumento( );
$arraydocumento = $tipoDocumento->consultar();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <title>Unificacion de documentos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
  <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
  <script src="../../../assets/js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

</head>
<body>
	<br><br>
	<div class="container">
	 
	  <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4">
	
	  <div class="panel panel-default panel-warning">
		  <div class="panel-heading">
		  	  <h3 class="panel-title" align="center"><strong>Unificación de documentos</strong></h3>
		  </div>
		  
	  <div class="panel-body">
	   <div id="msn"></div>
	   <form name="form1" method="post" action=""  role="form" id="formulario">
	   	<div class="form-group">
	  	<label for="tipodocumento">Tipo documento antiguo:</label>
	  	 <select class="form-control" name="cbmTipoDocumentoAnterior" id="cbmTipoDocumentoAnterior">
			<option value="-1">Seleccionar tipo documento Antiguo</option>
			 <?php
			  foreach ($arraydocumento as $tipoDocumentoGenerala) { ?>
			  <option value="<?php echo $tipoDocumentoGenerala->getTipoDocumento( ); ?>"><?php echo $tipoDocumentoGenerala->getDescripcion( ); ?></option>
				
			<?php } ?>
		 </select>
		 <div id="errorTipoDocumentoAntiguo"></div>
		</div>
		
	  	 <div class="form-group">
		    <label for="documentoAnterior">Número documento antiguo:</label>
		    <input type="text" class="form-control" id="txtDocumentoAnterior" placeholder="Registre número documento antiguo" name="txtDocumentoAnterior" autocomplete="off" >
		    <div id="errordocumentoAnterior"></div>
		    <div id="nombreestudiante"></div>
	     </div>
	     
	     <div class="form-group">
	  		<label for="tipodocumento">Tipo documento nuevo:</label>
	  	 	<select class="form-control" name="cbmTipoDocumentoNuevo" id="cbmTipoDocumentoNuevo">
	  	 									   							  
				 <option value="-1">Seleccionar tipo documento nuevo</option>
			  <?php
			  foreach ($arraydocumento as $tipoDocumentoGeneraln) { ?>
				  <option value="<?php echo $tipoDocumentoGeneraln->getTipoDocumento( ); ?>"><?php echo $tipoDocumentoGeneraln->getDescripcion( ); ?></option>
			  <?php } ?>
			</select>
			<div id="errorTipoDocumentoNuevo"></div>
		 </div>
		
		 <div class="form-group">
		    <label for="DocumentoNuevo">Número documento nuevo:</label>
		    <input type="text" class="form-control" id="txtDocumentoNuevo"  placeholder="Registre número documento nuevo" name="txtDocumentoNuevo" autocomplete="off">
		  	<div id="errordocumentoNuevo"></div>
		  	<div id="nombreestudiantenuevo"></div>
		  </div>
		  
	   	<div class="form-group" >    
	      <button type="submit" class="btn btn-warning col-xs-12 col-md-4 col-md-offset-4" id="btnActualizar">Actualizar</button>
	   	  <input type="hidden" name="oculto" id="oculto">
	    </div>
	  
		  </form>
	  	</div>
	  </div>
	</div>
  </div>
</body>
</html>