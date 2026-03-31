<?
$pageName="noticias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (!empty($idNoticia)){
	$noticia= $servicesFacade->getNoticia($idNoticia);
}else{
	$idNoticia = 0;
	$noticia = array("Fecha" => date("Y-m-d"),"Titulo" => "","Texto_Noticia" =>"","Codigo_Idioma" => $servicesFacade->getIdiomaPredeterminado());
}

?>
<script language="JavaScript" type="text/javascript" src="../js/ts_picker.js"></script>

<script language="JavaScript" type="text/javascript">
	function validar_noticia(){
		if (!document.getElementsByName("Titulo").item(0).value){
			alert("<?=$Mensajes["warning.campo_titulo_incompleto"]?>")
			return false;
		}
		if (!document.getElementsByName("Texto").item(0).value){
			alert("<?=$Mensajes["warning.campo_texto_incompleto"]?>")
			return false;
		}
		 
		return true;
	}
</script>

<form method="post" name="formNoticia" action="noticiasController.php" onsubmit="return validar_noticia();">
	<input type='hidden' name='idNoticia' value='<?=$idNoticia?>' />
	
<table class="table-form" width="80%" align="center" cellpadding="2" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8" />
			<? echo $Mensajes["tf-1"]; ?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-1"];?></th>
		<td>
			<? $fecha_noticia= date("d-m-Y", strtotime($noticia["Fecha"]));	?>      
       		<input type="text" name="Fecha" style='width:90' size="10" value="<?=$fecha_noticia?>" />
    		<a href="javascript:show_calendar('document.formNoticia.Fecha',document.formNoticia.Fecha.value);">
				<img border="0" src="../images/ts_picker/calendar.gif" width="16" height="16" />
			</a>
       	</td>
    </tr>
   	<tr>
   		<th><? echo $Mensajes["ec-4"]; ?></th>
       	<td>
       		<select size="1" name="Codigo_Idioma">
     			<?
          		$idiomas= $servicesFacade->getIdiomasDisponibles();
          		foreach($idiomas as $idioma){?>
          	   		<option value="<?=$idioma["Id"]?>" <? if ($noticia["Codigo_Idioma"]==$idioma["Id"]) echo "selected"; ?>>
          	   			<?=$idioma["Nombre"]?>
          	   		</option>
          	   	<?}?>    
       		</select>
        </td>
   	</tr>
   	<tr>
       	<th><? echo $Mensajes["ec-2"]; ?></th>
       	<td>
       		<input type="text" name="Titulo" size="50" value="<?=$noticia["Titulo"] ?>" />
       	</td>
   	</tr>
   	<tr>
   		<th><? echo $Mensajes["ec-3"]; ?></th>
       	<td>
       		<textarea rows="8" name="Texto" cols="47"><?=$noticia["Texto_Noticia"]?></textarea>
       	</td>
   	</tr>
   	<tr>
   		<th>&nbsp;</th>
       	<td>
       		<input type="submit" value=<? if (empty($idNoticia)) echo $Mensajes["bot-2"]; else echo $Mensajes["bot-1"];?> name="B1"/>
       		<input type="reset" value="<? echo $Mensajes["bot-3"]; ?>" name="B2" />
       	</td>
   	</tr>
</table>

</form>
<? require "../layouts/base_layout_admin.php";?>