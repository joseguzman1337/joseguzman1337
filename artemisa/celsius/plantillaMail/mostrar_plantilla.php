<?
$pageName = "mail.plantilla";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";  

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
	
$plantilla = $servicesFacade->getPlantilla(array("Id" =>$id_plantilla));	
?>

<table width="70%" class="table-form" align="center"  cellpadding="2" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<?=$Mensajes["titulo.plantillaMail"];?>
		</td>
	</tr>
	<tr>
    	<th><?=$Mensajes["campo.denominacion"];?></th>
    	<td><?=$plantilla["Denominacion"];?></td>         
    </tr>
    <tr>
    	<th><?=$Mensajes["campo.texto"];?></th>
    	<td><?=$plantilla["Texto"];?></td>         
    </tr>
	<tr>
    	<th>&nbsp;</th>
    	<td>
    		<input type="button" onclick="location.href='agregarOModificarPMail.php?id_plantilla=<?=$id_plantilla?>';" value="<?=$Mensajes["h-2"]; ?>" />
        	<input type="button" onclick="location.href='seleccionar_pmail.php';" value="<?=$Mensajes["boton.listar_plantillas"]; ?>" />
        </td>
    </tr>
</table>
<? require "../layouts/base_layout_admin.php";?>