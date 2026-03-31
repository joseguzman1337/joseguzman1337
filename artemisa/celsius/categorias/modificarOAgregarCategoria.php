<?
$pageName= "categorias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

if (!isset($IdCategoria))
	$IdCategoria="";

if ((!empty($operacion))&&($operacion==1)){
	$conditions=array("Id"=>$IdCategoria);
	$tipoUsuario=$servicesFacade->getCategoriasUsuarios($conditions);
}

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  
?>	

<script language="JavaScript" type="text/javascript">
  function validar_form(){
  	if (document.getElementsByName('Categoria').item(0).value==''){
  		alert('<?=$Mensajes["warning.faltaNombreCategoria"];?>');
		return false;
  	}
  	return true;
  }
</script>
  
<form method="POST"  action="actualizar_categoria.php" onsubmit="return validar_form();">
	<input type="hidden" name="operacion" value="<?= $operacion; ?>" />
	<input type="hidden" name="IdCategoria" value=<?= $IdCategoria; ?> />

<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" /><?=$Mensajes["ec-1"];?>
        </td>
	</tr>	
	<tr>
		<th><?=$Mensajes["tf-1"]; ?></th>
    	<td>
       		<input type="text" name="Categoria" size="41" value="<? if (isset($tipoUsuario)) echo $tipoUsuario[0]["Nombre"]; ?>" />
    	</td>
	</tr>
	<tr>	
   		<th>&nbsp;</th>
   		<td>                                  
           	<input type="submit" value="<? if (empty($operacion)) {echo $Mensajes["botc-1"];} else { echo $Mensajes["botc-2"];} ?>" name="B1" />
			<input type="reset"  value="<?= $Mensajes["bot-2"]; ?>" name="B2" />
		</td>
	</tr>
</table>
</form>
<? require "../layouts/base_layout_admin.php";?>