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
	
	ini_set('display_errors','On');
	
	session_start( );
	
	include '../lib/nuSoap5/nusoap.php';
	
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
	include '../control/ControlClienteWebService.php';
	include '../control/ControlLocalidad.php';
	include '../control/ControlDeudaPeople.php';
	
	require_once "../../consulta/interfacespeople/conexionpeople.php";
	require_once "../../consulta/interfacespeople/reporteCaidaPeople.php";
	
	
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
	
	$txtItems = array( );
	$controlCarreraPeople = new ControlCarreraPeople( $persistencia );
	$controlClienteWebService = new ControlClienteWebService( $persistencia );
	
	$deuda = $controlClienteWebService->verificarDeudaPeople( $txtCodigoEstudiante , $txtCodigoCarrera );
	$controlDeudaPeople = new ControlDeudaPeople( $persistencia );
	
	
	if( isset( $deuda["deudas"] ) ){
		$txtItems = $deuda["deudas"]; 
	}
	//$txtItems = json_decode( stripslashes($txtItems), true );
	
	if( count($txtItems) != 0 ){ 
		$existeDeuda = $controlDeudaPeople->existeDeudaPeopleEstudiante( $txtCodigoEstudiante );
		if( $existeDeuda == 0 ){
			$controlDeudaPeople->crearDeudaPeople( $txtCodigoEstudiante );
		}
		$existeDeuda2 = $controlDeudaPeople->existeDeudaPeopleEstudiante( $txtCodigoEstudiante );
		$txtFinanciera = $existeDeuda2;
		?>
	<p align="justify">Los siguientes son los conceptos que tiene el estudiante por pagar:</p>
	<p><input type="hidden" id="txtActualizaDeuda" name="txtActualizaDeuda" value="<?php echo $txtFinanciera; ?>" /></p>
	<br />
	<div class="detalles">
		<table width="100%" border="1" cellpadding="0" cellspacing="0" >
			<thead>
				<tr >
					<th>Concepto</th>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Valor</th>
					
				</tr>
			</thead>
			<tbody class="listaRadicaciones">
	<?php
		$sumaValor = 0; 
		foreach( $txtItems as $txtItem ){
				$txtItemPeople = $txtItem["ITEM_TYPE"];
				$txtValorItem = $txtItem['ITEM_AMT'];
				$txtItemDescripcion = $txtItem['DESCR'];
				
				
				$carreraPeople = $controlCarreraPeople->buscarCarreraPeople( $txtItemPeople );
				
				$txtCodigoConcepto = $carreraPeople->getConcepto( )->getCodigoConcepto( );
				$txtNombreConcepto = $carreraPeople->getConcepto( )->getNombreConcepto( );
				
				$sumaValor = $sumaValor + $txtValorItem;
				
				
				
				?>
				<tr>
					<td align="center"><?php echo $txtCodigoConcepto; ?></td>
					<td align="center"><?php echo $txtNombreConcepto; ?></td>
					<td align="center"><?php echo $txtItemDescripcion; ?></td>
					<td align="center"><?php echo "$".number_format($txtValorItem,0, '', '.'); ?></td>
				</tr>
			<?php 
			}
			?>
				</tbody>
			</table>
			<br />
			<div align="right"><p>El valor total de la deuda es: <?php echo "$".number_format($sumaValor,0, '', '.'); ?></p></div>
		</div>
	<?php
		
	}else{
		if( $txtFinanciera != 1 ){ ?>
			<p><input type="hidden" id="txtActualizaDeuda" name="txtActualizaDeuda" value="<?php echo $txtFinanciera; ?>" /></p>
			<?php 
			$controlDeudaPeople->actualizarDeudaPeople( $txtCodigoEstudiante );
			echo "El estudiante no tiene conceptos por pagar";
		}else{
			echo "El estudiante no tiene conceptos por pagar";
		}
	}
?>
	
	



