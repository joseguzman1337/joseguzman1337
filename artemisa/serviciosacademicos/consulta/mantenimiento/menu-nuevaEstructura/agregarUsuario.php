<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
?>
<?php
$formulario = new formulario(&$sala,'form1','post','',true,'','');

?>
	<form action="#" method="post" name="formAgregarUsuario" id="formAgregarUsuario">

		<table>
			<?php $formulario->celdaHorizontalCampoTextoDHTML('usuario','Usuario Sistema','',40,'','','','','required','');?>
			<?php $formulario->celdaHorizontalCampoTextoDHTML('numerodocumento','Número de documento','',40,'','','','','required','numeric');?>
			<?php $formulario->celdaHorizontalComboDHTML('tipodocumento','Tipo documento','documento','','tipodocumento','nombredocumento','','','','nombredocumento','','','required');?>
			<?php $formulario->celdaHorizontalCampoTextoDHTML('apellidos','Apellidos Usuario','',40,'','','','','required','');?>
			<?php $formulario->celdaHorizontalCampoTextoDHTML('nombres','NombresUsuario','',40,'','','','','required','');?>
			<input type="hidden" name="codigousuario" id="codigousuario" value="00">
			<?php $formulario->celdaHorizontalCampoTextoDHTML('semestre','Semestre','',5,'','','','','required','numeric');?>
						
			<tr>
				<td><div id="datosUsuarioSoporteTecnico"></div></td>
			</tr>
			<td colspan="2">
				</td>
			<td>
				<input type="button" id="mySubmit" class="formButton" value="Enviar" >
				<input type="reset" class="formButton" value="Borrar">
				<input type="button" class="formButton" value="Restablecer" onclick="instanciadorInicial()">
			</td>
		</tr>
		<tr>
			<td colspan="2"><div id="respuestaFormAgregarUsuario"></div></td>
		</tr>
		</table>
	</form>