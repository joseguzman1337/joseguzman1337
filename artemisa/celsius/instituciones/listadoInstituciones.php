<?
/**
 * $seleccionarInstitucion? = (1,2)
 * $IdInstitucionAEliminar?
 * $Pais? El pais 
 */
$pageName= "instituciones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR); 
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;

$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$esUnion = !empty($seleccionarInstitucion);
if (empty($seleccionarInstitucion))
	$seleccionarInstitucion = 0;
if (empty($IdInstitucionAEliminar))
	$IdInstitucionAEliminar = 0;
if (empty($Pais))
	$Pais = 0;
?>

<form method="get" action="listadoInstituciones.php">
	<input type="hidden" name="seleccionarInstitucion" value="<?=$seleccionarInstitucion?>" />
	<input type="hidden" name="IdInstitucionAEliminar" value="<?=$IdInstitucionAEliminar?>" />

<table width="80%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" />
    		&nbsp;
    		<? echo $Mensajes["ec-1"]; ?>
        </td>
    </tr>	
    <tr>
    	<th><?=$Mensajes["et-1"]; ?></th>
        <td>
        	<select size="1" name="Pais" >
        	<? 
        	$paises= $servicesFacade->getPaises();
        	foreach($paises as $pais){?>
			   	<option value="<? echo $pais["Id"]; ?>" <? if ($Pais == $pais["Id"]) echo "selected"?>>
			   		<? echo $pais["Nombre"]." (".$pais["Abreviatura"].")" ?>
			   	</option>	
			<?}?>
			</select>
        </td>
     </tr>
    
    <!--
    <tr>
    	<th></th>
        <td>
    		<input type="radio" name="solo_istec" value="0" <?if ($solo_istec == 0) echo "selected";?>/><?=$Mensajes["et-1"]; ?>
    		<input type="radio" name="solo_istec" value="0" <?if ($solo_istec == 0) echo "selected";?>/><?=$Mensajes["et-1"]; ?> 
    		<input type="radio" name="solo_istec" value="0" <?if ($solo_istec == 0) echo "selected";?>/><?=$Mensajes["et-1"]; ?>  
		</td>
	</tr>
	-->
	
     <tr>
     	<th>&nbsp;</th>
     	<td>
        	<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" />
        </td>
     </tr>
</table>
</form>

<?if (!empty($Pais)){?>
<br/>
<table width="80%" class="table-list" align="center" cellpadding="1" cellspaing="1">
	
	<tr>
		<th><?= $Mensajes["campo.nombreInstitucion"]; ?></th>
		<th>&nbsp;</th>
		
	</tr>
	<?
	$conditions=array();
	if ($esUnion && ($seleccionarInstitucion==1)){
		$conditions["esCentralizado"]=0;
	}
	$conditions["Codigo_Pais"]=$Pais;
	
	if (empty($solo_istec))
		$solo_istec = 0;
	elseif ($solo_istec == 1)
		$conditions["Participa_Proyecto"]=1;
	elseif ($solo_istec == 2)
		$conditions["Participa_Proyecto"]=0;
	
	$instituciones = $servicesFacade->getInstituciones($conditions);
	foreach ($instituciones as $institucion){?>
	  	<tr>
			<td><?= $institucion["Nombre"]; ?></td>
			<td>
				<? if(!$esUnion){?>
					<a  href="modificarOAgregarInstitucion.php?idInstitucion=<?=$institucion["Codigo"] ?>"><?=$Mensajes["h-2"]; ?></a>
					&nbsp;|&nbsp; 
					<a  href="mostrarInstitucion.php?idInstitucion=<?=$institucion["Codigo"] ?>"><?=$Mensajes["boton.mostrarInstitucion"]; ?></a> 
				<?}else if ($seleccionarInstitucion==1){?>
		  	   		<a href="union_instituciones.php?IdInstitucionAEliminar=<?=$institucion["Codigo"]; ?>"><?=$Mensajes["h-4"]; ?></a>
		  	    <?}elseif ($seleccionarInstitucion==2){?>
		  	   		<a href="union_instituciones.php?IdInstitucionAEliminar=<?= $IdInstitucionAEliminar; ?>&IdInstitucion=<?=$institucion["Codigo"]; ?>"><?=$Mensajes["h-4"]; ?></a>
				<?}?>	
	  	    </td>
		</tr>
	<?}?>
	<tr>
      	<td colspan="2">
        	<a href="../instituciones/union_instituciones.php"><?= $Mensajes["link.unionesInstituciones"]; ?></a> |
        	<a href="modificarOAgregarInstitucion.php"><?=$Mensajes["boton.agregarInstitucion"]; ?></a>
        </td>
    </tr>
</table>
<?}?>
<? require "../layouts/base_layout_admin.php";?>