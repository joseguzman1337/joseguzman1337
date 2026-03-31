<?
/**
 * @param bool popup indica si la pag de seleccion se vera en un popup o en una pag normal. 
 * En el 1º caso se esperan los parametros $input_id_coleccion y $input_titulo_coleccion . EN el 2º se espera 
 * el parametro $url_destino. Por default , popup = true
 * @param string $url_destino?
 * @param string $input_id_coleccion?
 * @param string $input_titulo_coleccion?
 * @param string $titulo_coleccion
 * 
 */
$pageName = "colecciones2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
 
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  

if (isset($popup) && $popup == 0)
	$popup = 0;
else
	$popup = 1;

if ($popup)
	require_once "../layouts/top_layout_popup.php";
else
	require_once "../layouts/top_layout_admin.php";

$rol_usuario = SessionHandler::getRolUsuario();

//inicializa los parametros
if (!isset($titulo_coleccion))
	$titulo_coleccion ="";
if (!isset($abreviatura_coleccion))
	$abreviatura_coleccion ="";
if (!isset($issn_colleccion))
	$issn_colleccion ="";

?>

<script language="JavaScript" type="text/javascript" src="../js/ajax.js"></script>
<script language="JavaScript">
	
	function recargo(Letra){   
		document.getElementsByName("titulo_coleccion").item(0).value=Letra;
		document.getElementById("formBusquedaColecciones").submit();
	}
	
	function retornaCon(titulo_coleccion,id_coleccion){
		//titulo_coleccion=(titulo_coleccion.replace('\'',"'"));
		
		<? if ($popup) {?>
			
			var input_id_coleccion = document.getElementsByName("input_id_coleccion").item(0).value;
			window.opener.document.getElementsByName(input_id_coleccion).item(0).value= id_coleccion;
			
			var input_titulo_coleccion = document.getElementsByName("input_titulo_coleccion").item(0).value;
			window.opener.document.getElementsByName(input_titulo_coleccion).item(0).value= titulo_coleccion;
						
			self.close();
		<? } else{?>
			
			location.href="../<?=$url_destino?><?=(strpos($url_destino,"?") === FALSE)?"?":"&" ?>titulo_coleccion=" + titulo_coleccion + "&IdColeccion=" + id_coleccion; 
		<? } ?>
	}
	
	function agregar(){
		if(document.getElementsByName("titulo_coleccion").item(0).value!=""){
			var titulo_coleccion  = document.getElementsByName("titulo_coleccion").item(0).value;
			var abreviatura_coleccion  = document.getElementsByName("abreviatura_coleccion").item(0).value;
			var issn_coleccion  = document.getElementsByName("issn_coleccion").item(0).value;
			
			var url = "actualizar_coleccion.php?por_ajax=1&titulo_coleccion="+titulo_coleccion + "&abreviatura_coleccion=" + abreviatura_coleccion + "&issn_coleccion=" + issn_coleccion;
			
			id_coleccion = retrieveURL(url);
			
			if (id_coleccion)
				retornaCon(titulo_coleccion,id_coleccion);
			else
				alert('No se pudo agregar la coleccion'+id_coleccion);
		}
		else{
			alert('Escriba un titulo para la nueva coleccion');
			return false;
		}
	
	}
	
</script>    

<br/>

<form method="post" id="formBusquedaColecciones" action="seleccionar_titulo_coleccion.php">
	<? if ($popup) {?>
		<input type="hidden" name="input_id_coleccion" value="<?= $input_id_coleccion; ?>"/>
		<input type="hidden" name="input_titulo_coleccion" value="<?= $input_titulo_coleccion; ?>"/>
	<? } else{?>
		<input type="hidden" name="url_destino" value="<?= $url_destino; ?>"/>
	<? } ?>
		<input type="hidden" name="popup" value="<?= $popup; ?>"/>
		<input type="hidden" name="Responsable" value=""/>
		<input type="hidden" name="Volumenes" value=""/>
		<input type="hidden" name="Frecuencia" value=""/>
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
<tr>
	<td>
		<table width="95%" border="0" align="center" cellpadding="1" cellspacing="0">
		<tr>
			<th><? echo $Mensajes["sel-1"]; ?></th>
			<td>
				<input type="text" name="titulo_coleccion" size="20" value="<?=$titulo_coleccion; ?>"/>
			</td>
		</tr>
		<tr>
			<th><? echo $Mensajes["sel-2"]; ?></th>
			<td>
				<input type="text" name="abreviatura_coleccion" size="20" value="<?=$abreviatura_coleccion; ?>"/>
			</td>
		</tr>
		<tr>
			<th><? echo $Mensajes["sel-3"]; ?></th>
			<td>
				<input type="text" name="issn_coleccion" size="20" value="<?=$issn_coleccion;?>"/>
			</td>
		</tr>
		<tr>
			<td>
			<?if ($rol_usuario == ROL__ADMINISTADOR){?>
				<input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="AgregarColeccion" onClick="agregar();"/>
			<?}?>
				&nbsp;
			</td>
			<td>
				<input type="submit" value="<? echo $Mensajes["bot-2"]; ?>" name="BuscarColeccion"/>
			</td>
		</tr>
		</table>
	</td>
	<td align="left">
		<table width="260" border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
        <tr>
	    <? for($c = 'A'; $c <= 'M'; $c = chr(ord($c)+1)){?>
	        <td width="20" align="center">
	        	<a href="javascript:recargo('<?=$c?>')"><?=$c?></a>
	        </td>
	    <?}?>
        </tr>
        <tr>
	    <? for($c = 'N'; $c <= 'Z'; $c = chr(ord($c)+1)){?>
	        <td width="20" align="center">
	        	<a href="javascript:recargo('<?=$c?>')"><?=$c?></a>
	        </td>
	    <?}?>
        </tr>
		</table>
	</td>
</tr>  		
</table>

</form>
<br/>
<?  

$conditions=array();
if (!empty($titulo_coleccion))
	$conditions['Nombre'] = trim($titulo_coleccion);
if (!empty($abreviatura_coleccion))
	$conditions['Abreviado'] = trim($abreviatura_coleccion);
if (!empty($issn_collecion))
	$conditions['ISSN'] = trim($issn_collecion);

if (count($conditions) == 0)
	$conditions['Nombre'] = "A";


$colecciones = $servicesFacade->getAllTitulosColecciones($conditions);
if (is_a($colecciones, "Celsius_Exception")){
	$mensaje_error = $Mensajes["error.recuperarColecciones"];
	$excepcion = $colecciones;
	require "../common/mostrar_error.php";
}
?>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="table-list">
<tr>
	<td colspan="3" class="table-list-top">
		<img src="../images/square-lb.gif" width="8" height="8"/>
		<?= $Mensajes['titulo.listadoColecciones'] ?>
	</td>
</tr>
<?foreach ($colecciones as $coleccion){?>
<tr>
	<td>
		<strong>    
			<a href="javascript: retornaCon('<?= addslashes($coleccion['Nombre']) ?>','<?= $coleccion['Id'] ?>');">
				<?= $coleccion['Nombre'] ?>
			</a>
		</strong>
	</td>
	<td><?= $coleccion['Abreviado'] ?></td>
	<td><?= $coleccion['ISSN'] ?></td>
</tr>
<?}?>
</table>
<br/>
<center>
	<input type="button" value="<?= $Mensajes["boton.cancelar"];?>" onclick="javascript:<?= ($popup)?"self.close()":"history.back()"?>;" />
</center>
<?
if ($popup)
	require_once "../layouts/base_layout_popup.php";
else
	require_once "../layouts/base_layout_admin.php";
?>