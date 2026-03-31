<?
$pageName= "elementos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR); 
require "../layouts/top_layout_admin.php";
if (!isset($dedonde ))			
	$dedonde=1;
if (!isset($Codigo_Pagina ))		
	$Codigo_Pagina="";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>

<form method="POST" action="seleccionar_elemento.php">
<table width="70%" align="center" class="table-list" cellpadding="1" cellspacing="1"> 
	<tr>
    	<td colspan="2" class="table-list-top">
    		<img src="../images/square-w.gif" width="8" height="8" /> 
    		<? echo $Mensajes["et-1"];?>
        </td>
    </tr>
	<tr>
    	<th><?=$Mensajes["ec-1"]?></th>
        <td>
        	<select size="1" name="Codigo_Pagina" >
        	<? $pantallas = $servicesFacade->getPantallas();
			   foreach ($pantallas as $pantalla){?>
			   		<option value="<?=$pantalla["Id"];?>" <?if ($pantalla["Id"]==$Codigo_Pagina) echo " selected " ;?>><?=$pantalla["Id"];?></option>
			<?}?>
			</select>
		</td>
    </tr>
    <tr>
      	<th>&nbsp;</th>
    	<td>
    	   	<input type="submit" value="<?=$Mensajes["bot-1"];?>" name="B1"/>&nbsp;
    	   	<input type="reset"  value="<?=$Mensajes["bot-2"];?>" name="B2"/>
        </td>
    </tr>
</table>                      
<?
if (!empty($Codigo_Pagina)){ 
	$elementos = $servicesFacade->getElementos(array("Codigo_Pantalla" =>$Codigo_Pagina));
	?>
	<table width="70%" align="center"  class="table-form" >
		<?foreach ($elementos as $elemento) {?>	
		    <tr>
		    	<th><?=$Mensajes["ec-2"];?></th>
		        <td><?=$elemento["Codigo_Elemento"] ?></td>
		    	<td>
		    		<a href="agregarOModificarElemento.php?dedonde=1&Codigo_Elemento=<?echo $elemento["Codigo_Elemento"]; ?>&Codigo_Pagina=<?=$Codigo_Pagina; ?>"><?=$Mensajes["ec-3"];?></a>
		        </td>
		    </tr>                    
		<?}?>
	</table>
<?}
require "../layouts/base_layout_admin.php";?>