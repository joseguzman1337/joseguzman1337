<?php
$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];
if (!isset($IdPaisAEliminar))	$IdPaisAEliminar=0; 
if (!isset($IdPais))	$IdPais=0; 
?>

<script language="JavaScript">
function buscarPaisesAEmilinar()
{
	document.forms.form1.IdPaisAEliminar.value=<? if (empty($IdPaisAEliminar)){ $IdPaisAEliminar=0; } echo $IdPaisAEliminar; ?>; 
	document.forms.form1.seleccionarPais.value=1;
	document.forms.form1.action = "listadoPaises.php";
	document.forms.form1.submit();
}

function buscarPaises()
{
	document.forms.form1.IdPais.value=<? if (empty($IdPais) || $IdPais==$IdPaisAEliminar) { $IdPais=0; } echo $IdPais; ?>; 
	document.forms.form1.seleccionarPais.value=2;
	document.forms.form1.action = "listadoPaises.php";
	document.forms.form1.submit();
}

</script>

<?
if (empty($IdPaisAEliminar) || empty($IdPais)|| empty($B1)){?> 
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["tf-7"]; ?>
		</td>
	</tr>
	<tr>
		<td>
		<form method="POST" name="form1" action="union_paises.php">
			<table width="100%" class="table-form">
				<tr>
					<th><?=$Mensajes["ec-5"]; ?></th>
					<td>
						<input type="text" name="NombrePaisAEliminar" size="43" value="<? if (isset($NombrePaisAEliminar)){echo $NombrePaisAEliminar;}?>" />
						<input type="button" value="?" name="B3" OnClick="buscarPaisesAEmilinar();" />
					</td>
					<td>
						<? if (isset($IdPaisAEliminar)) {echo $IdPaisAEliminar;} ?>
					</td>
				</tr>
				<tr>
                	<th><? echo $Mensajes["ec-6"];?></th>
                    <td>
                    	<input type="text"  name="NombrePais" value="<? if (isset($NombrePais)){echo $NombrePais;} ?>"size="43" />
						<input type="button" value="?" name="B4" OnClick="buscarPaises();" />
                    </td>
                    <td>
                    	<? if (isset($IdPais)) {echo $IdPais;} ?>
                    </td>
                </tr>
                <tr>
					<th>&nbsp;</th>
					<td colspan="3" align="center" valign="top">
						<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" />
						<input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" />
						<input type="hidden" name="IdPaisAEliminar" value="<?=$IdPaisAEliminar?>" />
                        <input type="hidden" name="IdPais" value="<?=$IdPais ?>" />
                        <input type="hidden" name="seleccionarPais" />
                    </td>
                </tr>
			</table>
		</form>
		</td>
	</tr>
</table>
<?}else{
  		
	$res= $servicesFacade->unirPaises($IdPaisAEliminar,$IdPais,$id_usuario);
	
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.unionPaises"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
?>
   
<table width="100%" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top-blue"><?=$Mensajes["tf-7"]; ?></td>
	</tr>
	<tr>
    	<th><?=$Mensajes["tf-8"]; ?></th>
        <td><?=$NombrePaisAEliminar; ?></td>
    </tr>
    <tr>
    	<th><?=$Mensajes["tf-9"]; ?>&nbsp;</th>
      	<td><?=$NombrePais; ?></td>
    </tr>
    <tr>
    	<td>
        	<a href="../uniones/administracion_uniones.php"><?=$Mensajes["h-2"]; ?>&nbsp;</a>
        </td>
    </tr>
</table>
<?}?>
<? require "../layouts/base_layout_admin.php";?>