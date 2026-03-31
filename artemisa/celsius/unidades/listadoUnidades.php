<?
/**
 * $seleccionarUnidad?
 * $IdUnidadAEliminar?
 * 
 * $Codigo_Pais
 * $Codigo_Institucion
 * $Codigo_Dependencia
 */
$pageName= "unidades1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";

$mostrar_elemento = array("instituciones","dependencias");
require "../utils/pidui.php";

if (empty($Codigo_Pais))
	$Codigo_Pais = 0;
if (empty($Codigo_Institucion))
	$Codigo_Institucion = 0;
if (empty($Codigo_Dependencia))
	$Codigo_Dependencia = 0;

$esUnion = (!empty($seleccionarUnidad));
if (empty($seleccionarUnidad))
	$seleccionarUnidad = 0;
if (empty($IdUnidadAEliminar))
	$IdUnidadAEliminar = 0;
?>	

<form method="POST" action="listadoUnidades.php">
	<input type="hidden" name="seleccionarUnidad" value=<?=$seleccionarUnidad?> />
	<input type="hidden" name="IdUnidadAEliminar" value=<?=$IdUnidadAEliminar?> />
    
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8">
    		&nbsp;
    		<?=$Mensajes["mensaje.listado_unidades"]; ?>
        </td>
    </tr>
    <tr>
    	<th><?=$Mensajes["campo.pais"]; ?></th>
        <td>
        	<select size="1" name="Codigo_Pais" OnChange="generar_instituciones(0);"  style="width:400px">
        	</select>
        </td>
    </tr>
    <tr>
     	<th><?=$Mensajes["et-2"]; ?></th>
     	<td>
     		<select size="1" name="Codigo_Institucion" OnChange="generar_dependencias(0);" style="width:400px" >
     		</select>
     	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-3"]; ?></th>
     	<td>
     		<select size="1" name="Codigo_Dependencia" style="width:400px">
     		</select>
     	</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td colspan="2">
        	<input type="submit" value="<?=$Mensajes["boton.listar_unidades"]; ?>" name="B1">
        </td>
    </tr>
</table>
</form>
<br/>
<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["instituciones"]="Codigo_Institucion";
    listNames[0]["dependencias"]="Codigo_Dependencia";
	generar_paises(<?=$Codigo_Pais?>);
	generar_instituciones(<?=$Codigo_Institucion?>); 
	generar_dependencias(<?=$Codigo_Dependencia?>);
</script>

<?
if (!empty($Codigo_Dependencia)){
	$conditions=array();
	if ($esUnion&&($seleccionarUnidad==1))
		$conditions["esCentralizado"]=0;
	$conditions["Codigo_Dependencia"]=$Codigo_Dependencia;
	$unidades = $servicesFacade->getUnidades($conditions);
	?>

<table width="80%" class="table-list" align="center" cellpadding="1" cellspacing="1">  
	<tr>
		<td colspan="3" class="table-list-top">
			&nbsp;
		</td>
    </tr>
    <tr>
	  	<th><?=$Mensajes["et-4"]; ?></th>
	  	<th>&nbsp;</th>
	</tr>
	<? foreach ($unidades as $unidad){?>
		   	<td><?=$unidad["Nombre"]; ?></td>
			<td>
				<? if (!$esUnion){
					if ($unidad["esCentralizado"] == 0){?>
						<a href="javascript:void(0)" onclick="location.href='modificarOAgregarUnidad.php?idUnidad=<?=$unidad["Id"] ?>'">
							<?=$Mensajes["boton.modificar_unidad"]; ?>
						</a> | 
					<?}?>
			   		<a href="javascript:void(0)" onclick="location.href='mostrarUnidad.php?idUnidad=<?=$unidad["Id"] ?>'">
						<?=$Mensajes["boton.mostrar_unidad"]; ?>
					</a>
				<?}elseif ($seleccionarUnidad==1 && $unidad["esCentralizado"] == 0){?>
					<a href="union_unidades.php?IdUnidadAEliminar=<?=$unidad["Id"]; ?>"><?= $Mensajes["boton.unir_unidades"]; ?></a>
			  	<?}elseif (!empty($seleccionarUnidad) && $seleccionarUnidad==2){?>
			  	    <a href="union_unidades.php?IdUnidadAEliminar=<?=$IdUnidadAEliminar; ?>&IdUnidad=<?=$unidad["Id"]; ?>"><?= $Mensajes["boton.unir_unidades"]; ?></a>
			  	<?}?>
		    </td>
		</tr>
	<?}?>
	<tr>
      	<td colspan="2">&nbsp;</td>
    </tr>
	<tr>
      	<td colspan="2">
        	<a href="../unidades/modificarOAgregarUnidad.php"><?= $Mensajes["boton.crear_unidad"]; ?></a>
        </td>
    </tr>
</table>
<?}?>
<? require "../layouts/base_layout_admin.php";?>