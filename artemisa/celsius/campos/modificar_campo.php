<?
/**
 * @var int $idCampo
 */
$pageName= "campos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
$descripcionesTipoDeMaterial= PedidosUtils::getTiposMateriales($VectorIdioma);

$datosCampo= $servicesFacade->getCampoPedido($idCampo);
$idiomas= $servicesFacade->getIdiomasDisponibles();
$cantIdiomas= sizeof($idiomas);

$idiomaPredeterminado= $servicesFacade->getIdiomaPredeterminado();
$idIdiomaPredeterminado= $idiomaPredeterminado["Id"];

/*trae los campos cargados en la tabla camposTraducidos para cargarlos en el formulario*/
$camposTraducidos= $servicesFacade->getAllCamposPedidosTraducidos($idCampo);
foreach ($camposTraducidos as $campo){
	$nombreCampo= "texto".$campo["id_idioma"];
	$datos[$nombreCampo]=$campo["texto"];
	
	$nombreCampo= "abreviatura".$campo["id_idioma"];
	$datos[$nombreCampo]=$campo["abreviatura"];
	
	$nombreCampo= "ayuda".$campo["id_idioma"];
	$datos[$nombreCampo]=$campo["mensaje_ayuda"];
	
	$nombreCampo= "error".$campo["id_idioma"];
	$datos[$nombreCampo]=$campo["mensaje_error"];
}
?>

<script language="javascript">
 function validarIdiomaPred(nroIdiomaPredeterminado){
 	c1= document.getElementById('texto'+nroIdiomaPredeterminado).value;
 	c2= document.getElementById('abreviatura'+nroIdiomaPredeterminado).value;
 	c3= document.getElementById('ayuda'+nroIdiomaPredeterminado).value;
 	c4= document.getElementById('error'+nroIdiomaPredeterminado).value;
 	
 	if(((c1=='')||(c2==''))||((c3=='')||(c4==''))){
 		alert('<?echo $Mensajes["mensaje.camposVacios"];?>');
 		return false;}
 	else{
 		document.getElementsByName('formuIdioma')[0].submit();}
 }
</script>

<table class="table-form" width="75%" >
	<tr>
		<th style='text-align:left !important' colspan=2><?echo $Mensajes["titulo.campoPedido"];?></th>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.tipoMaterial"];?></td>
		<td><? if (isset($descripcionesTipoDeMaterial["0".$datosCampo["tipo_material"]])) echo $descripcionesTipoDeMaterial["0".$datosCampo["tipo_material"]];
			   else echo $Mensajes["titulo.camposComunes"];?>
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.codigo"];?></td>
		<td><?echo $datosCampo["codigo"];?></td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.obligatorio"];?></td>
		<td><?
			  if (empty($datosCampo["obligatorio"]))
					echo $Mensajes["mensaje.negacion"];
			  else
					echo $Mensajes["mensaje.afirmacion"];
			?>
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["mensaje.expresionRegular"];?></td>
		<td><?echo $datosCampo["tipo_regexp"];?></td>
	</tr>
</table>


<br>
<form method="post" action="saveOrUpdateCampos.php" name="formuIdioma">
<?
foreach($idiomas as $idioma){
?>
	<table border="0" class="table-form" width="75%">
	<tr>
		<th colspan=2 style='text-align:left !important'><?echo $idioma["Nombre"];?></th>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.texto"];?></td>
		<td>
			<input type="text" size="50" name=<?echo "texto".$idioma["Id"];?> 
		     id=<?echo "texto".$idioma["Id"];?> 
			 value='<?if(isset($datos['texto'.$idioma["Id"]])) echo $datos['texto'.$idioma["Id"]];?>' />
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.abreviatura"];?></td>
		<td><input type="text" size="50" name=<?echo "abreviatura".$idioma["Id"];?> 
		     id=<?echo "abreviatura".$idioma["Id"];?> 
		     value='<?if (isset($datos['abreviatura'.$idioma["Id"]])) echo $datos['abreviatura'.$idioma["Id"]];?>' />
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.ayuda"];?></td>
		<td><input type="text" size="50" name=<?echo "ayuda".$idioma["Id"];?> 
			id=<?echo "ayuda".$idioma["Id"];?> 
			value='<?if (isset($datos['ayuda'.$idioma["Id"]])) echo $datos['ayuda'.$idioma["Id"]];?>' />
		</td>
	</tr>
	<tr>
		<td><?echo $Mensajes["campo.error"];?></td>
		<td><input type="text" size="50" name=<?echo "error".$idioma["Id"];?> 
			id=<?echo "error".$idioma["Id"];?> 
			value='<?if (isset($datos['error'.$idioma["Id"]])) echo $datos['error'.$idioma["Id"]];?>' />
		</td>
	</tr>
	<tr>
		<td  colspan=2 >&nbsp;</td>
	</tr>
</table>
<?}?>

	<input type="hidden" name="id_campo" id="id_campo" value=<?echo $idCampo;?> />
	<input type="hidden" name="cantIdiomas" id="cantIdiomas" value=<?echo $cantIdiomas;?> />
	<input type="hidden" name="idIdiomaPredeterminado" id="idIdiomaPredeterminado" value=<?echo $idIdiomaPredeterminado;?> />
	<div align="center">
		<input type="button" value="<?echo $Mensajes["boton.guardar"];?>" onClick="validarIdiomaPred(<?echo $idIdiomaPredeterminado;?>);" />
	</div>
</form> 
<?require "../layouts/base_layout_admin.php";?>