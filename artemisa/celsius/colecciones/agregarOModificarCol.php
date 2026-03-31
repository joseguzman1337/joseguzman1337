<?
 /*
   * $id_coleccion int - identificador de la coleccion
   * $titulo_coleccion string - nombre de la coleccion
   * 
   * */
  
$pageName = "colecciones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($IdColeccion)) {
	$titulocoleccion = $servicesFacade->getTituloColeccion($IdColeccion);
} else {
	$IdColeccion = 0;
}
?>
<script language="JavaScript">
	function enviar_campos(){
		if (document.getElementsByName('titulo_coleccion').item(0).value==''){
  			alert('<?=$Mensajes["warning.faltaNombreColeccion"];?>');
			return false;
		}
		return true;			
  	}
</script>

<form method="POST" action="actualizar_coleccion.php"  onsubmit="return enviar_campos();">
	<input type="hidden" name="NumeroPedidos" size="13" value="0" /> 
	<input type="hidden" name="IdColeccion" value="<?=$IdColeccion ?>" />
	
<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" /><? echo $Mensajes["tf-1"];?>
        </td>
	</tr>	
	<tr>
		<th><? echo $Mensajes["tf-2"]; ?></th>
		<td>
			<input  type="text" name="titulo_coleccion" size="41" value="<? if (!empty($titulocoleccion["Nombre"])){echo $titulocoleccion["Nombre"];} ?>" />
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["tf-3"]; ?></th>
		<td>
			<input type="text" name="abreviatura_coleccion"  size="38" value="<? if (!empty($titulocoleccion["Abreviado"])){echo $titulocoleccion["Abreviado"];} ?>" />
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["tf-4"]; ?></th>
		<td>
			<input type="text"   name="issn_collecion" size="20" value="<? if (!empty($titulocoleccion["ISSN"])){echo $titulocoleccion["ISSN"];} ?>" />
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["tf-5"]; ?></th>
		<td>
			<input type="text" name="Responsable"   size="41" value="<? if (!empty($titulocoleccion["Responsable"])){echo $titulocoleccion["Responsable"];} ?>" />
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["campo.volumenes"]; ?></th>
		<td>
			<input type="text" name="Volumenes"   size="41" value="<? if (!empty($titulocoleccion["Volumenes"])){echo $titulocoleccion["Volumenes"];} ?>" />
		</td>
	</tr>
	<tr>
		<th><? echo $Mensajes["campo.frecuencia"]; ?></th>
		<td>
			<input type="text" name="Frecuencia"   size="41" value="<? if (!empty($titulocoleccion["Frecuencia"])){echo $titulocoleccion["Frecuencia"];} ?>" />
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" value="<? if (empty($IdColeccion)) { echo $Mensajes["botc-1"];} else { echo $Mensajes["botc-2"]; } ?>" name="B1" />
			<input type="reset" value="<?=$Mensajes["bot-3"]; ?>" name="B2" />
		</td>
	</tr>
	</table>
</form>
<? require "../layouts/base_layout_admin.php";?> 