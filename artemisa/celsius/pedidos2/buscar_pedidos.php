<?php
$pageName = "pedidos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);


require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty($id_pedido) && empty($submit)){
	$pais = $servicesFacade->getPaisPredeterminado();
	$institucion = $servicesFacade->getInstitucionPredeterminada();
	$id_pedido = $pais["Abreviatura"] . "-" . $institucion["Abreviatura"] . "-";
}
if (empty($id_usuario)){
	$id_usuario=0;
}else{
	$id_usuario=(int)$id_usuario;
}

if (empty($idColeccion)){
	$idColeccion= 0;
}else{
	$idColeccion=(int)$idColeccion;
}

	
?>
<script language="JavaScript" type="text/javascript">
	function buscar_usuario(){
		ventana=window.open("../usuarios2/seleccionar_usuario.php?input_id_usuario=id_usuario&input_datos_usuario=usuario", "Seleccione", "dependent=yes, scrollbars=yes, width=800 ,height=550");
	}
	function limpiar_usuario(){
		document.getElementsByName('id_usuario')[0].value= '';
		document.getElementsByName('usuario')[0].value= '';
	}
	
	function buscar_tituloNormalizado(){ 
		var win =window.open("../colecciones/seleccionar_titulo_coleccion.php?input_id_coleccion=idColeccion&input_titulo_coleccion=expresion&titulo_coleccion=", "Seleccione", "dependent=yes, scrollbars=yes, width=700 ,height=600");
	}
	
	function limpiar_titulo(){
		document.getElementsByName('expresion')[0].value= '';
		document.getElementsByName('idColeccion')[0].value= '';
	}
		
</script>


<br>
<form action="buscar_pedidos.php" method="get">

	<input type="hidden" name="Modo" value="4" />
	
<table  border="0" align="center" cellpadding="1" cellspacing="1" class="table-form">
	<tr>
		<td class="table-form-top-blue" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" />
			<?=$Mensajes["titulo.formularioBusquedaAvanzada"];?>
		</td>
	</tr>
	<tr>
		<th width='150' >
			<?=$Mensajes["campo.idPedido"].": ";?>
		</th>
    	<td width='190'>
    		<input type="text" name="id_pedido" size="29" maxlength="20" value='<?= $id_pedido;?>'/>
    	</td>
    	<th width='150'>
    		<?=$Mensajes["campo.tabla"].": ";?>
    	</th>
    	<td width='190'>
    		<select name="codTablaPedido" size="1" style="width:190px">
    			<?
    			if (empty($codTablaPedido))
    				$codTablaPedido = 0;
    			$traduccionesTablasPedidos = array();
    			$traduccionesTablasPedidos["pedidos"]=$Mensajes["opcion.pedidos"];  
    			$traduccionesTablasPedidos["pedhist"]=$Mensajes["opcion.pedidosHistoricos"];
    			$traduccionesTablasPedidos["pedanula"]=$Mensajes["opcion.pedidosAnulados"];
    			
    			?>
    			<option value='0' <?if ($codTablaPedido==0) echo "selected";?>><?= $traduccionesTablasPedidos["pedidos"]; ?></option>
    			<option value='1' <?if ($codTablaPedido==1) echo "selected";?>><?= $traduccionesTablasPedidos["pedhist"]; ?></option>
    			<option value='2' <?if ($codTablaPedido==2) echo "selected";?>><?= $traduccionesTablasPedidos["pedanula"]; ?></option>
    			<option value='3' <?if ($codTablaPedido==3) echo "selected";?>><?=$Mensajes["opcion.cualquiera"]?></option>
    		</select>
    	</td>
    </tr>
	<tr>
    	<th>
    		<?=$Mensajes["campo.estado"].": ";?>
    	</th>
    	<td>
    		<select name="estado_pedido" size="1" style="width:190px">
    			<option value='0' <?if (!isset($estado_pedido)||($estado_pedido=="0")) echo "selected";?>><?=$Mensajes["opcion.cualquiera"]?></option>
    			<? $estados = PedidosUtils::getEstados($VectorIdioma); ?>
    			<?foreach ($estados as $id_estado => $tradEstado){
	    			if (!empty($tradEstado)){?>
    					<option value='<?=$id_estado?>' <?if (isset($estado_pedido)&&($estado_pedido==$id_estado)) echo "selected";?>><?=$tradEstado?></option>
    				<?}	
    			}?>
	   		</select>
		</td>
    	<th>
    		<?=$Mensajes["campo.tipoPedido"].": ";?>
    	</th>
    	<td>
    		<select name="tipo_pedido" size="1" style="width:190px">
    			<? if (!isset($tipo_pedido)) $tipo_pedido=0 ?>
	    		<option value='0' <?if ($tipo_pedido==0) echo "selected";?>><?=$Mensajes["opcion.cualquiera"]?></option>
    			<option value='1' <?if ($tipo_pedido==TIPO_PEDIDO__BUSQUEDA) echo "selected";?>><? echo TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__BUSQUEDA); ?></option>
    			<option value='2' <?if ($tipo_pedido==TIPO_PEDIDO__PROVISION) echo "selected";?>><? echo TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__PROVISION); ?></option>
    		</select>
    	</td>
    </tr>
    <tr>
    	<th>
    		<?=$Mensajes["campo.usuario"].": ";?>
    	</th>
    	<td>
    		<input type="text" id="datos_usuario" name="usuario" size="29" value='<?if (isset($usuario)) echo $usuario;?>' readonly />&nbsp;
    		<input type="hidden" id="id_usuario" name="id_usuario" value='<?=$id_usuario?>' /><br>
    		<a href="javascript:buscar_usuario();"><?=$Mensajes["link.elegir"];?></a> /
    		<a href="javascript:limpiar_usuario();"><?=$Mensajes["link.limpiar"];?></a>
    	</td>
    	<th>
    		<?=$Mensajes["campo.tipoMaterial"].": ";?>
    	</th>
    	<td>
	    	<select name="tipo_material" size="1" style="width:190px">
    			<option value="0" <?if (!isset($tipo_material)||($tipo_material=="0")) echo "selected";?>><?=$Mensajes["opcion.cualquiera"]?></option>
    			<? $tipos = PedidosUtils::getTiposMateriales($VectorIdioma);?>
    			
    			<? foreach ($tipos as $id_tipo_material => $tradTipoMaterial){?>
	    			<option value='<?=$id_tipo_material?>' <?if (isset($tipo_material)&&($tipo_material==$id_tipo_material)) echo "selected";?>><?=$tradTipoMaterial?></option>	
    			<? }?>
    		</select>
    	</td>
    </tr>
    <tr>
    	<th>
    		<?=$Mensajes["campo.instanciaCelsiusOrigen"].": ";?>
    	</th>
    	<td>
    		<select name="instancia_celsius" size="1" style="width:190px">
				<option value="0" <?if (!isset($instancia_celsius)||($instancia_celsius=="0")) echo "selected";?>><?=$Mensajes["opcion.cualquiera"]?></option>
		  		<? $instancias = $servicesFacade->getInstancias_Celsius();
		  		foreach ($instancias as $instancia){?>
		  			<option <?if (isset($instancia_celsius)&&($instancia_celsius==$instancia["id"])) echo "selected";?>><? echo $instancia["id"] ?></option>
		  		<?}	?>
			</select>
    	</td>
    	<th>
    		<?=$Mensajes["campo.operadorCorriente"].": ";?>
    	</th>
    	<td>
			<select name="operador_corriente" size="1" style="width:190px">
				<option value="0" <?if (!isset($operador_corriente)||($operador_corriente=="0")) echo "selected";?>><?=$Mensajes["opcion.todos"]?></option>
		  		<? $operadores = $servicesFacade->getUsuarios(array("Personal" => 1));
		  		foreach ($operadores as $oper){?>
		  			<option value="<?= $oper["Id"] ?>"
		  			<?if (isset($operador_corriente)&&($operador_corriente==$oper["Id"])) echo "selected";?>
		  			>
		  				<? echo $oper["Apellido"].", ".$oper["Nombres"] ?>
		  			</option>
		  		<?}	?>
		  		
		  	</select>
		</td>
    </tr>
    <tr>
    	<th>
    		<?=$Mensajes["campo.origenRemoto"].": ";?>
    	</th>
    	<td>
    		<input type="checkbox" name="origen_remoto" <?if (isset($origen_remoto)&&($origen_remoto=="on")) echo "checked";?>/>
    	</td>
    	<th><?= $Mensajes["opcion.titulo"].": ";?></th>
    	<td>
    		<input type="text" id="expresion" name="expresion" size="29" value='<?if (isset($expresion)) echo $expresion;?>' readonly />&nbsp;
    		<input type="hidden" name="idColeccion" id="idColeccion" value="<?=$idColeccion?>" /><br>
    		<a href="javascript:buscar_tituloNormalizado();"><?=$Mensajes["link.elegir"];?></a> /
    		<a href="javascript:limpiar_titulo();"><?=$Mensajes["link.limpiar"];?></a>
    	</td>
    </tr>
  	<tr align="center">
    	<td colspan="4" class="table-form-top-blue" style="text-align:center !important">
    		<input type="submit" value="<?=$Mensajes["boton.buscarPedidos"];?>" name="submit"/>
    	</td>
    </tr>
  </table>
</form>

<?
if (!empty($submit)){
	$tablasPedidos = array();
	switch($codTablaPedido){
		case '0': $tablasPedidos[]= "pedidos";break;
		case '1': $tablasPedidos[]= "pedhist";break;
		case '2': $tablasPedidos[]= "pedanula";break;
		case '3': 
			$tablasPedidos[]= "pedidos";
			$tablasPedidos[]= "pedhist";
			$tablasPedidos[]= "pedanula";
			break;
		default:  $tablasPedidos[]= "pedidos";break;
	}
	
	$conditions = array();
		
	if(!empty($usuario)){
		$conditions["Codigo_Usuario"] = $id_usuario;
	}
	
	if(!empty($id_pedido)){	
		if (($aux = PedidosUtils::armarCodigoCompleto($id_pedido)) !== false)
			//chequea que el id_pedido este bien formado 
			$conditions["Id"] = $aux;
	}
	
	if(!empty($operador_corriente)){
		$conditions["Operador_Corriente"] = $operador_corriente;
	}
	
	if(!empty($tipo_pedido)){
		$conditions["Tipo_Pedido"] = (int)$tipo_pedido;
	} 
	if(!empty($estado_pedido)){
		$conditions["Estado"] = (int)$estado_pedido;
	} 
	if(!empty($tipo_material)){
		$conditions["Tipo_Material"] = (int)$tipo_material;
	} 
	
	if(!empty($instancia_celsius)){
		$conditions["id_instancia_origen"] = $instancia_celsius;
	} 
	
	if(!empty($origen_remoto)){
		$conditions["origen_remoto"] = 1;
	}
	
	if(!empty($expresion)){
		$conditions["Codigo_Titulo_Revista"] = $idColeccion;
	}
	

	if(!empty($conditions)){
		foreach($tablasPedidos as $tablaPedidos){
			
			$pedidosCompletos = $servicesFacade->findPedidosCompletos($conditions,$tablaPedidos);
		 	
		 	if (is_a($pedidosCompletos, "Celsius_Exception")){
		 		$mensaje_error = "Error al tratar de listar los pedidos en la tabla '$tablaPedidos' que coincidan con el criterio: ". var_export($conditions, true);
				$excepcion = $pedidosCompletos;
				require "../common/mostrar_error.php";
			}
			?>
			<hr>
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC" class="style22">
				<tr>
					<td height="20">
						<img src="../images/square-w.gif" width="8" height="8" />
						<?=$Mensajes["titulo.cantidadPedidos"];?>
						<?=$traduccionesTablasPedidos[$tablaPedidos];?>
						
						<b style="color:white"><?= count($pedidosCompletos); ?></b>
					</td>
				</tr>
			</table>
			<br/>
			<?
			require "listar_pedidos.php";
		}
	} 
} 

//bottom
require "../layouts/base_layout_admin.php"?>