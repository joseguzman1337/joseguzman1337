<?
   $pageName= "elementos2";
   require_once "../common/includes.php";
   SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
   require "../layouts/top_layout_admin.php";	   
   
   if (empty($Codigo_Elemento ))
   		$Codigo_Elemento=0;
   if (empty($Codigo_Pagina ))
   		$Codigo_Pagina=0;
   
   global $IdiomaSitio;
   $Mensajes = Comienzo ($pageName,$IdiomaSitio);
   if (!empty($Codigo_Elemento)&&!empty($Codigo_Pagina)){	
		$elemento= $servicesFacade->getElemento($Codigo_Pagina , $Codigo_Elemento);
		$Anterior = $Codigo_Elemento;
		$PaginaAnterior = $Codigo_Pagina;
   }	
   
   $pantallas = $servicesFacade->getPantallas();
?>
<script language="JavaScript">
	function enviar_campos(){
		if (document.getElementsByName('Codigo_Elemento').item(0).value==''){
  			alert('<?=$Mensajes["warning.faltaCodigoElemento"];?>');
			return false;
		}
		return true;			
  	}
</script>

<form name="form1" method="POST" action="actualizar_elemento.php" onsubmit="return enviar_campos();">
	<input type="hidden" name="Anterior" value="<? if (!empty($Anterior)) echo $Anterior; ?>" />
	<input type="hidden" name="PaginaAnterior" value="<? if (!empty($PaginaAnterior)) echo $PaginaAnterior; ?>" />
		
	<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" />
    		<?=$Mensajes["et-1"];?>
        </td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-1"];?></th>
		<td>
			<select size="1" name="Codigo_Pagina">
			<?foreach ($pantallas as $pantalla){ 									
			     if ($pantalla["Id"]==$Codigo_Pagina || ((!empty($elemento) )&& $pantalla["Id"]==$elemento["Codigo_Pantalla"] )){?>
						<option value="<?=$pantalla["Id"];?>" selected><?=$pantalla["Id"];?></option>
					<?}else{?>
					    <option value="<?=$pantalla["Id"];?>"><?=$pantalla["Id"];?></option>
					<?}
			 }?> 	       
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></h>
		<td>
			<input type="text"  name="Codigo_Elemento" size="37" value="<? if (!empty($elemento))echo $elemento["Codigo_Elemento"]; ?>"/>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
    	<td colspan="2">
			<input type="submit"  value="<?if (empty($Anterior)) echo $Mensajes["bot-1"]; else echo $Mensajes["bot-2"];?>" name="B1" />&nbsp; 
			<input type="reset"   value="<?= $Mensajes["bot-3"];?>" name="B2" />
		</td>
    </tr>
</table>	
</form>
<? require "../layouts/base_layout_admin.php";?>