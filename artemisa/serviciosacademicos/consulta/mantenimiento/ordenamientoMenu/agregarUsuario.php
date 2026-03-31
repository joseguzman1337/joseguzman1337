<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php');
$query_usuario="SELECT u.idusuario FROM usuario u WHERE u.usuario = '".$_SESSION['MM_Username']."'";
$op=$sala->execute($query_usuario);
$idusuario=$op->fields['idusuario'];
if (empty($idusuario)) {
	echo "<h1>Error, variable idusuario perdida, no se puede continuar!</h1>";
	exit();
}
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
			<input type="hidden" name="semestre" id="semestre" value="0">
			<input type="hidden" name="codigorol" value="3" id="codigorol">
			<tr>
				<td id="tdtitulogris">Fecha inicio usuario</td>
				<td id="_fechainiciousuario"></td>
				<td><input type="text" required name="fechainiciousuario" value="" onclick=""><input type="button" value="..." onclick="pickDate(this,document.getElementById('fechainiciousuario'));"></td>
			</tr>
			<tr>
				<td id="tdtitulogris">Fecha vencimiento usuario</td>
				<td id="_fechavencimientousuario"></td>
				<td><input type="text" required name="fechavencimientousuario" value="" onclick=""><input type="button" value="..." onclick="pickDate(this,getElementById('fechavencimientousuario'));"></td>
			</tr>
			<input type="hidden" name="fecharegistrousuario" id="fecharegistrousuario"value="<?php echo date("Y-m-d H:i:s")?>">
			<td colspan="2">
				</td>
			<td>
				<input type="button" id="EnviarAgregarUsuario" class="formButton" value="Enviar" onclick="formAgregaEditaUsuario.submit()">
				<input type="reset" class="formButton" value="Borrar">
			</td>
			<input type="hidden" name="codigotipousuario" id="codigotipousuario" value="400">
			<input type="hidden" name="idusuariopadre" id="idusuariopadre" value="<?php echo $idusuario?>">
		</tr>
		<tr>
			<td colspan="3"><div style="visibility:hidden;" id="datosUsuarioSoporteTecnico"></div></td>
		</tr>
		</table>
	</form>