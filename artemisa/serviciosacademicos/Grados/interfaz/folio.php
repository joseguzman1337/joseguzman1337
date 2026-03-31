<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
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
	
?>
<script src="../js/MainFolio.js"></script>
<br />
<br />
<div id="dvOpcionFolio">
	<form id="formMenuFolio" method="post" action="../servicio/folio.php" target="_blank">
	<p align="center" class="Estilo2">Graduar Estudiantes - Generación de Folios </p>
	<p><input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="<?php echo $txtCodigoCarrera; ?>" />
		<input type="hidden" id="txtFechaGrado" name="txtFechaGrado" value="<?php echo $txtFechaGrado; ?>" />
	</p>
	<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr>
	    <td><table width="100%"  border="0" cellpadding="2" cellspacing="2">
	      <tr>
	        <td width="22%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Accion</div></td>
	        <td width="78%" bgcolor="#FEF7ED" class="verde">
	        	<select name="cmbOpcionFolio" id="cmbOpcionFolio">
			          <option value="0" selected>Seleccionar</option>
			          <option value="1">Generación e impresión automática de folios</option>
					  <option value="2">Impresión de copias de folios previamente generados/impresos</option>
	        </select></td>
	      </tr>
	      <tr>
	      	<td>&nbsp;</td>
	      	<td>&nbsp;</td>
	      </tr>
	      <tr>
	      	<td>&nbsp;</td>
	      	<td>
	      		<div id="dvGenerarFolio" style="display: none; margin-right: 10px;">
	      			<fieldset>
	      				<legend>Impresión de Folios</legend>
	      				<br />
						<form name="formGenerarFolio">
						  <table width="298" border="0">
						  <tr>
						    <td width="251">Previsualizar nuevos Folios</td>
						    <td width="31"><input type="radio" id="rdPrevisualizar" name="gFolio"></td>
						  </tr>
						  <tr>
						    <td>Generar e Imprimir nuevos folios</td>
						    <td><input type="radio" id="rdGenerar" name="gFolio"></td>
						  </tr>
						  <tr>
						  	<td>&nbsp;</td>
						  	<td>&nbsp;</td>
						  </tr>
						  <tr>
						    <td colspan="2"><div align="left">
						    <!-- <a id="btnEnviarGenerarFolio">Enviar</a> -->
						     <input type="submit" id="btnEnviarGenerarFolio" value="Enviar"  onclick="this.form.action='../servicio/folio.php'">
						    </div></td>
						    </tr>
						</table>
						</form>
						<br />
					</fieldset>
	      		</div>
	      		<div id="dvReImprimirFolio" style="display: none; margin-right: 10px; ">
	      			<fieldset>
	      				<legend>Reimpresión de folios</legend>
	      				<br />
		      			<form name="formReImprimirFolio">
						  <table width="200" border="0">
						    <tr>
						      <td>Desde:</td>
						      <td><div align="center"><input type="text" id="fromFolio" name="fromFolio" /></div></td>
						      <td>&nbsp;&nbsp;Hasta:</td>
						      <td><div align="center"><input type="text" id="toFolio" name="toFolio" /></div></td>
						    </tr>
						    <tr>
						    	<td>&nbsp;</td>
						    </tr>
						    <tr>
						     	<td colspan="4">
						      		<div align="left">
						      			<!--<a id="btnEnviarReImpresion">Enviar</a>
						      			<a id="btnRegresarReImpresion">Regresar</a>-->
							        	<input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							        	<!--<input name="Regresar" type="submit" id="Regresar" value="Regresar">-->
									</div>
								</td>
						    </tr>
						  </table>
						</form>
						<br />
					</fieldset>
	      		</div>
	      	</td>
	      </tr>
	      <tr>
	      	<td>&nbsp;</td>
	      	<td>&nbsp;</td>
	      </tr>
	      
	      <tr bgcolor="#CCDADD">
	        <td colspan="2" class="Estilo2"><div align="center">
	        	 <!--<a id="btnOpcionFolio">Enviar</a>
	           <input name="Enviar" type="submit" id="Enviar" value="Enviar">-->
	        </div></td>
	      </tr>
	    </table></td>
	  </tr>
	</table>
	</form>
</div>
<br />
<br />