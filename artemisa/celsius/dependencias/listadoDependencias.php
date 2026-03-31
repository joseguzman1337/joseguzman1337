<?
/**
 * $seleccionarDependencia?
 * $IdDependenciaAEliminar
 * 
 * $Codigo_Institucion
 * $Codigo_Pais
 */
$pageName= "dependencias2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR); 

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";

$esUnion = !empty($seleccionarDependencia);
if (empty($seleccionarDependencia))
	$seleccionarDependencia = 0;
if (empty($IdDependenciaAEliminar))
	$IdDependenciaAEliminar = 0;

if (empty($Codigo_Institucion))
	$Codigo_Institucion = 0;
if (empty($Codigo_Pais))
	$Codigo_Pais = 0;
	
$paises= $servicesFacade->getPaises();
$mostrar_elemento = array("instituciones");
require "../utils/pidui.php";
?>

<form method="get" action="listadoDependencias.php">
	<input type="hidden" name="seleccionarDependencia" value="<?= $seleccionarDependencia?>" />
	<input type="hidden" name="IdDependenciaAEliminar" value="<?= $IdDependenciaAEliminar?>" />

<table width="80%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8">
    		<?= $Mensajes["h-4"]; ?>
        </td>
    </tr>	
    <tr>
    	<th><?=$Mensajes["tf-1"]; ?></th>
        <td>
        	<select size="1" name="Codigo_Pais" OnChange="generar_instituciones(0);"  style="width:400px">
        	</select>
        </td>
     </tr>
     <tr>
     	<th><?=$Mensajes["tf-2"]; ?></th>
     	<td>
     		<select size="1" name="Codigo_Institucion" style="width:400px">
     		</select>
     	</td>
     </tr>
     <tr>
     	<th>&nbsp;</th>
     	<td>
        	<input type="submit" value="<?=$Mensajes["bot-1"]; ?>" name="B1" />
        </td>
     </tr>
</table>
</form>

<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["instituciones"]="Codigo_Institucion";
	generar_paises(<?= $Codigo_Pais?>);
	generar_instituciones(<?= $Codigo_Institucion?>);
</script>

<?
if (!empty($Codigo_Institucion)){

	$conditions=array();
	if ($esUnion && ($seleccionarDependencia==1))
		$conditions["esCentralizado"]=0;
	
	$conditions["Codigo_Institucion"]=$Codigo_Institucion;
	$dependencias = $servicesFacade->getDependencias($conditions);
	?>

<table width="80%" class="table-list" align="center" cellpadding="1" cellspacing="1">  
	<tr>
		<td colspan="2" class="table-list-top">
			&nbsp;
		</td>
    </tr>
    <tr>
    	<th><?=$Mensajes["ec-1"]; ?></th>
    	<th><?=$Mensajes["ec-2"]; ?></th>
    	<th>&nbsp;</th>
    </tr>
	
	<? foreach ($dependencias as $dependencia){?>
	  	<tr>
		   	<td><?=$dependencia["Nombre"]; ?></td>
		   	<td><?=$dependencia["Abreviatura"]; ?></td>
	 		<td> 
				<? if (!$esUnion){?>
					<a href="modificarOAgregarDependencia.php?idDependencia=<?=$dependencia["Id"] ?>"><?=$Mensajes["h-2"]; ?></a>
					&nbsp;|&nbsp;
					<a href="mostrarDependencia.php?idDependencia=<?=$dependencia["Id"] ?>"><?= $Mensajes["boton.mostrar_dependencia"]; ?></a>
				<?} elseif($seleccionarDependencia==1){?>
					<a href="union_dependencias.php?IdDependenciaAEliminar=<?=$dependencia["Id"]; ?>"><?=$Mensajes["h-4"]; ?></a></td>
				<?}elseif ($seleccionarDependencia==2){?>
	  	    		<a href="union_dependencias.php?IdDependenciaAEliminar=<?=$IdDependenciaAEliminar; ?>&IdDependencia=<?=$dependencia["Id"]; ?>"><?=$Mensajes["h-4"]; ?></a></td>
	  	    	<?}?>
	  	    </td>	
		</tr>
	<?}?>
	
    <tr>
      	<td colspan="2">
        	&nbsp;
        </td>
    </tr>
	<tr>
      	<td colspan="3">
        	<a href="../dependencias/union_dependencias.php"><?= $Mensajes["link.unionesDependencias"];?></a>
        </td>
    </tr>
</table>
<?}

require "../layouts/base_layout_admin.php";?>