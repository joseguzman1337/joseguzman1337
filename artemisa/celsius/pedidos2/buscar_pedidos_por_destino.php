<?php
/**
 * @id_pais?
 * @id_institucion?
 * @id_dependencia?
 * @id_unidad?
 * @estado (solicitado | recibido)
 */
$pageName = "pedidos";

require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


$mostrar_elemento = array("instituciones","dependencias","unidades");
require "../utils/pidui.php";

if (!isset($estado))
	$estado = ESTADO__SOLICITADO;
if (!isset($id_pais))
	$id_pais = 0;
?>
<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="id_pais";
	listNames[0]["instituciones"]="id_institucion";
	listNames[0]["dependencias"]="id_dependencia";
	listNames[0]["unidades"]="id_unidad";
</script>

<form method="get">

<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="table-form">
	<tr>
		<td class="table-form-top-blue" colspan="2">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<? echo $Mensajes["tf-7"]; ?>
		</td>
	</tr>
	<tr>
		<th width="120"><?= $Mensajes["ec-1"]; ?></th>
		<td colspan="2">
			<select name="id_pais" onchange="generar_instituciones(0)" size="1" style="width:300px">
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"]; ?></th>
		<td colspan="2">
			<select name="id_institucion" onchange="generar_dependencias(0)" size="1" style="width:300px">
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-3"]; ?></th>
		<td>
			<select name="id_dependencia" onchange="generar_unidades(0)" size="1" style="width:300px">
			</select>
		</td>
		<td rowspan="2" valign="middle" width="120">
			<?
			if (empty($Lista) || $Lista!=1) 
				$Lista=2;
			?>			
			<input type="radio" value="1" name="Lista" <? if ($Lista==1) echo " checked" ?>/><? echo $Mensajes["tf-3"]; ?>
			<br/>
			<input type="radio" value="2" name="Lista" <? if ($Lista==2) echo " checked" ?>/><? echo $Mensajes["tf-4"]; ?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.unidad"]; ?></th>
		<td>
			<select name="id_unidad" size="1" style="width:300px">
			</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-4"]; ?></th>
		<td>
			<select size="1" name="estado">
				<option value="<?= ESTADO__SOLICITADO ?>" <? if ($estado == ESTADO__SOLICITADO) echo " selected" ?> >
					<?= $Mensajes["otp-1"]; ?>
				</option>
				<option value="<?= ESTADO__RECIBIDO ?>" <? if ($estado == ESTADO__RECIBIDO) echo " selected" ?> >
					<?= $Mensajes["otp-2"]; ?>
				</option>
				<option value="0" <? if (($estado != ESTADO__SOLICITADO) && ($estado != ESTADO__RECIBIDO)) echo " selected" ?> >
					<?= $Mensajes["otp-3"]; ?>
				</option>
			</select>
		</td>
		<td>
			<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="buscar">
		</td>
	</tr>
	
</table>

</form>
<script language="JavaScript">
	generar_paises(<?=$id_pais ?>);
	<? if (!empty($id_institucion)){ ?>
		generar_instituciones(<?=$id_institucion ?>);
	<?}if (!empty($id_dependencia)){ ?>
		generar_dependencias(<?=$id_dependencia ?>);
	<?}if (!empty($id_unidad)){ ?>
		generar_unidades(<?=$id_unidad ?>);
	<?} ?>

</script>

<?
if (!empty($buscar)){
	$conditionsEventos = array();
	if ($estado == ESTADO__SOLICITADO){
		$conditionsEventos["Codigo_Evento"] = EVENTO__A_SOLICITADO; 
	}elseif ($estado == ESTADO__RECIBIDO){
		$conditionsEventos["Codigo_Evento"] = EVENTO__A_RECIBIDO;
	}
	if (!empty($id_pais))
		$conditionsEventos["Codigo_Pais"] = $id_pais;
	if (!empty($id_institucion))
		$conditionsEventos["Codigo_Institucion"] = $id_institucion;
	if (!empty($id_dependencia))
		$conditionsEventos["Codigo_Dependencia"] = $id_dependencia;
	if (!empty($id_unidad))
		$conditionsEventos["Codigo_Unidad"] = $id_unidad;
		
	$conditionsEventos["vigente"] = 1;
	$pedidosCompletos = $servicesFacade->getPedidosConEventos($conditionsEventos, "eventos");
	if (is_a($pedidosCompletos, "Celsius_Exception")){
		$mensaje_error = $pedidosCompletos->getMessage();
		$excepcion = $pedidosCompletos;
		require "../common/mostrar_error.php";
	}
	?>
	
	<hr>
	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC" class="style22">
		<tr>
			<td height="20">
				<img src="../images/square-w.gif" width="8" height="8">
				<?= $Mensajes["tf-7"]." :"; ?><b style="color:white"><?= count($pedidosCompletos); ?></b>
			</td>
		</tr>
	</table>

<? require "listar_pedidos.php";
}

require "../layouts/base_layout_admin.php"; 
?>