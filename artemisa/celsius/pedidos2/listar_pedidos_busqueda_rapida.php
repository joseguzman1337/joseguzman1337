<?php
$pageName = "pedidos";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

//debo buscar los pedidos en base a los datos recibidos como parametro

if (empty ($campo))
	$campo = 1;


$pais = $servicesFacade->getPaisPredeterminado();
$institucion = $servicesFacade->getInstitucionPredeterminada();
$valor = $pais["Abreviatura"] . "-" . $institucion["Abreviatura"] . "-";

$conditions = array ();
if (empty ($expresion) && empty($idColeccion)){
	$expresion = $valor;
}else{
	switch ($campo) {
		case '1' :
			$aux = PedidosUtils::armarCodigoCompleto($expresion);
			if ($aux !== false) {
				$conditions["Id"] = $aux;
			}
			break;
		case '2' :{
				if (!empty($idColeccion)){
					$conditions["Codigo_Titulo_Revista"]=(int)$idColeccion;
				}else{
					$conditions["Titulo_Libro"] = $expresion;
					$conditions["Titulo_Revista"] = $expresion;
					$conditions["Titulo_Articulo"] = $expresion;
					$conditions["TituloCongreso"] = $expresion;
					$conditions["TituloTesis"] = $expresion;
				}
				break;
			}
		case '3' :{
				$conditions["Autor_Libro"] = $expresion;
				$conditions["AutorTesis"] = $expresion;
				$conditions["Autor_Detalle1"] = $expresion;
				$conditions["Autor_Detalle2"] = $expresion;
				$conditions["Autor_Detalle3"] = $expresion;
				break;
			}
	}
}


?>
<script language="JavaScript" type="text/javascript">

	valor = '<? echo $valor;?>';

	function cambiar(){
		if (document.getElementById('campo').value == 2){
			document.getElementById('labelTitulos').style.visibility = 'visible';
		  	document.getElementById('labelTitulos').style.position = 'relative';
		}else{
			document.getElementById('labelTitulos').style.visibility = 'hidden';
			document.getElementById('labelTitulos').style.position = 'absolute';
		}
		if (document.getElementById('campo').value == 1)  {
			document.getElementById('expresion').value=valor;
		} else{
			document.getElementById('expresion').value='';
		}
	}
	  	
	function titulosNormalizados(){ 
		var Letra = "A";
		if (document.forms.formBusquedaRapida.expresion.value != '')
			Letra = document.forms.formBusquedaRapida.expresion.value;
		var win =window.open("../colecciones/seleccionar_titulo_coleccion.php?input_id_coleccion=idColeccion&input_titulo_coleccion=expresion&titulo_coleccion=" + Letra, "Seleccione", "dependent=yes, scrollbars=yes, width=700 ,height=600");
		document.getElementById('campo').value=2;
	}

</script>
  


<form action="listar_pedidos_busqueda_rapida.php" name="formBusquedaRapida" method="get">

	<input type="hidden" name="idColeccion" value="<?=$idColeccion?>">
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="table-form">
	<tr>
		<td class="table-form-top-blue" colspan="3">
			<img src="../images/square-w.gif" width="8" height="8">
			<?= $Mensajes["titulo.formularioBusquedaRapida"];?>
		</td>
	</tr>
	<tr>
		<th width="120"><?= $Mensajes["campo.expresion"];?></th>
		<td width="120">
			<input type="text" name="expresion" id="expresion" size="30" value="<?= $expresion?>" onchange="document.forms.formBusquedaRapida.idColeccion.value=''"/>
		</td>
		<td>
			<input type="submit" value='<?= $Mensajes["boton.enviar"];?>'>
			<br/>
		</td>
	</tr>
	<tr>
		<th width="120"></th>
		<td>
			<select name="campo" id="campo" onChange="cambiar();" size="1" style="width:200px">
		  			<option value="1" <?if ($campo==1) echo "selected";?>> <?= $Mensajes["opcion.CodigoPedido"];?></option>
                    <option value="2" <?if ($campo==2) echo "selected";?>> <?= $Mensajes["opcion.titulo"];?> </option>
                    <option value="3" <?if ($campo==3) echo "selected";?>> <?= $Mensajes["opcion.autor"];?> </option>
		  	</select>
		</td>
		<td>
			<span id="labelTitulos" style="position:relative">
			<a href="Javascript:titulosNormalizados();"><?=$Mensajes["link.titulosNormalizados"]; ?></a>
			</span>
		</td>
	</tr>

</table>
            	
</form>

<hr>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC" class="style22">
	<tr>
		<td height="20">
			<img src="../images/square-w.gif" width="8" height="8">
		</td>
	</tr>
</table>

<?
if (count($conditions)>0) {
	$pedidos1 = $servicesFacade->findPedidosCompletos($conditions,"pedidos","or");
	if (is_a($pedidos1, "Celsius_Exception")){
		$mensaje_error = "Error al tratar de listar los pedidos que coincida con la busqueda : ". var_export($conditions, true);
		$excepcion = $pedidos1;
		require "../common/mostrar_error.php";
	}
	
	$pedidos2 = $servicesFacade->findPedidosCompletos($conditions,"pedhist","or");
	if (is_a($pedidos2, "Celsius_Exception")){
		$mensaje_error = "Error al tratar de listar los pedidos que coincida con la busqueda : ". var_export($conditions, true);
		$excepcion = $pedidos2;
		require "../common/mostrar_error.php";
	}
	
	$pedidos3 = $servicesFacade->findPedidosCompletos($conditions,"pedanula","or");
	if (is_a($pedidos3, "Celsius_Exception")){
		$mensaje_error = "Error al tratar de listar los pedidos que coincida con la busqueda : ". var_export($conditions, true);
		$excepcion = $pedidos3;
		require "../common/mostrar_error.php";
	}
	
	$pedidosCompletos = array_merge($pedidos1,$pedidos2,$pedidos3);

}

require "listar_pedidos.php";


require "../layouts/base_layout_admin.php";
?>