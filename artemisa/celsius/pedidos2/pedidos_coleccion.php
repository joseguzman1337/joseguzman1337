<?
/**
 * Busca el historial de pedidos sobre una coleccion especifica. Si se recibe el id del pedido entonces id_coleccion
 *  se toma del pedido, sino debe recibirse id_coleccion como parametro.  
 * @param int id_coleccion? La coleccion a utilizar para calcular el historial de pedidos
 * @param string id_pedido? El id del pedido a utilizar como base de la consulta
 */

$pageName="colecciones1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

require_once "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($id_pedido)){
	$pedido = $servicesFacade->getPedido($id_pedido);
	if(empty($pedido))
		$pedido = $servicesFacade->getPedido($id_pedido, "pedhist");
	
	$id_coleccion = $pedido["Codigo_Titulo_Revista"];
	$anio_revista_pedida = $pedido["Anio_Revista"];
	$numero_revista_pedida = $pedido["Numero_Revista"];
	$volumen_revista_pedida = $pedido["Volumen_Revista"];
	$paginaDesde_revista_pedida = $pedido["Pagina_Desde"];
	$paginaHasta_revista_pedida = $pedido["Pagina_Hasta"];
}else{
	$anio_revista_pedida = "";
	$numero_revista_pedida = "";
	$volumen_revista_pedida = "";
	$paginaDesde_revista_pedida = "";
	$paginaHasta_revista_pedida = "";
}

if(!empty($id_coleccion))
	$coleccion = $servicesFacade->getTituloColeccion($id_coleccion);
?>

<script language="JavaScript">
	function mostrar_pedido (id_pedido,popup){
		ventana=window.open("../pedidos2/mostrar_pedido.php?id_pedido="+id_pedido+"&popup=1","_blanck","scrollbars=yes,width=600,height=450,alwaysLowered");   
	}
</script>


<!-- ABRE TABLA 3 -->
<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC" class="table-form">
	<tr>
    	<td class="table-form-top" colspan="5">
    		<img src="../images/square-w.gif" width="8" height="8"/> 
			<?= $Mensajes["tf-1"]; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?= $Mensajes["tf-2"] ?>
			<span class='style46'><?= $coleccion["Nombre"]?></span>
		</td>
		<td>
			<?= $Mensajes["campo.volumen"];?>:
			<span class='style46'><?= $volumen_revista_pedida;?></span>
		</td>
		<td>
			<?= $Mensajes["campo.anio"];?>:
			<span class='style46'><?= $anio_revista_pedida;?></span>
		</td>
		<td> 
			<?= $Mensajes["campo.numero"]?>:
			<span class='style46'><?= $numero_revista_pedida;?></span>
		</td>
		<td>
			<?= "Pag";?>:
			<span class='style46'><?= $paginaDesde_revista_pedida."-".$paginaHasta_revista_pedida  ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<br>
			<a href="javascript:history.back()"><span class="style48"><?= $Mensajes["h-1"]; ?></span></a>
		</td>
	</tr>
</table>
<hr>
<!-- ABRE TABLA 6 -->
<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC" class="table-form">
	<?
	if ($id_coleccion != 0)
		$pedidosEnCurso = $servicesFacade->getPedidosCompletos(array("Codigo_Titulo_Revista" => $id_coleccion), "pedidos");
	else 
		$pedidosEnCurso = array();
	?>
	<tr>
    	<td colspan="7" class="table-form-top">
    		<img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-3"]; ?> Total: <?= count($pedidosEnCurso);?>
    	</td>
    </tr>
    <?
	foreach($pedidosEnCurso as $pedido){?>
		<tr class="style63">
			<td align="left">
				<a href="mostrar_pedido.php?id_pedido=<?= $pedido["Id"]; ?>"><?= $pedido["Id"]; ?></a>
			</td>
			<td align="left">
				<?= TraduccionesUtils::Traducir_Estado($VectorIdioma,$pedido["Estado"]) ?>
			</td>
			<td align="left">
				<?= $Mensajes["campo.volumen"];?>:
				<span class="style29">
					<? if ($pedido["Volumen_Revista"]==$volumen_revista_pedida) 
				    	echo "<b>".$pedido["Volumen_Revista"]."</b>"; 
				    else
				    	echo $pedido["Volumen_Revista"];
				    ?>
				</span>
			</td> 
			<td align="left">
				<?= $Mensajes["campo.anio"];?>:
				<span class="style29">
					<? if ($pedido["Anio_Revista"]==$anio_revista_pedida) 
				    	echo "<b>".$pedido["Anio_Revista"]."</b>"; 
				    else
				    	echo $pedido["Anio_Revista"];
				    ?>
				</span> 
			</td>
			<td align="left">
				<?= $Mensajes["campo.numero"]?>:
				<span class="style29">
					<? if ($pedido["Numero_Revista"]==$numero_revista_pedida) 
				    	echo "<b>".$pedido["Numero_Revista"]."</b>"; 
				    else
				    	echo $pedido["Numero_Revista"];
				    ?>
				</span>
			</td>
			<td align="left">
				<?= "Pag"?>:
				<span class="style29">
					<? if (($pedido["Pagina_Desde"]==$paginaDesde_revista_pedida)&&($pedido["Pagina_Hasta"]==$paginaHasta_revista_pedida)) 
				    	echo "<b>".$pedido["Pagina_Desde"]."-".$pedido["Pagina_Hasta"]."</b>"; 
				    else
				    	echo $pedido["Pagina_Desde"]."-".$pedido["Pagina_Hasta"];
				    ?>
				</span>
			</td>
			<? /* <td align="left"><?= $pedido[7]."-".$pedido[8]."-".$pedido[9]; ?></td> */ ?>
			<td>
				<input type="button" OnClick="mostrar_pedido('<?=$pedido["Id"] ?>',1)" value="C"/>
			</td>
		</tr>
	<?}?>
	
	<?
	if ($id_coleccion != 0)
		$pedidosHistoricos = $servicesFacade->getPedidosCompletos(array("Codigo_Titulo_Revista" => $id_coleccion), "pedhist");
	else 
		$pedidosHistoricos = array();
	?>
	<tr>
		<td colspan="7" class="table-form-top">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<? echo $Mensajes["tf-4"]; ?> 
			Total: <?= count($pedidosHistoricos)?>
		</td>
	</tr>
	<?/*AGREGAR LA PARTE DE NUMERO DE PAGINA DESDE Y HASTA*/
	foreach($pedidosHistoricos as $pedido){?>
		<tr class="style63">
			<td align="left">
				<a href="mostrar_pedido.php?id_pedido=<?= $pedido["Id"]; ?>"><?= $pedido["Id"]; ?></a>
			</td>
			<td align="left">
				<? if(($pedido["Estado"]==ESTADO__ENTREGADO_IMPRESO)||($pedido["Estado"]==ESTADO__DESCAGADO_POR_EL_USUARIO)){
				   		if($pedido["Estado"]==ESTADO__ENTREGADO_IMPRESO)
								$evento=EVENTO__A_RECIBIDO;
						else
								$evento=EVENTO__A_AUTORIZADO_A_BAJARSE_PDF;
						
						$eventoDesde= $servicesFacade->getPIDUfromPedidoConEstado($pedido["Id"], $evento); 
						echo $eventoDesde["Abreviatura_Institucion"]."-".$eventoDesde["Nombre_Dependencia"];  
				   }
				   else
						echo TraduccionesUtils::Traducir_Estado($VectorIdioma,$pedido["Estado"]);
				?>
			</td>
			<td align="left">
				<?= $Mensajes["campo.volumen"];?>:
				<span class="style29">
					<? if ($pedido["Volumen_Revista"]==$volumen_revista_pedida) 
				    	echo "<b>".$pedido["Volumen_Revista"]."</b>"; 
				    else
				    	echo $pedido["Volumen_Revista"];
				    ?>
				</span>
			</td>
			<td align="left">
				<?= $Mensajes["campo.anio"];?>:
				<span class="style29">
					<? if ($pedido["Anio_Revista"]==$anio_revista_pedida) 
				    	echo "<b>".$pedido["Anio_Revista"]."</b>"; 
				    else
				    	echo $pedido["Anio_Revista"];
				    ?>
				</span>
			</td>
			<td align="left">
				<?= $Mensajes["campo.numero"];?>:
				<span class="style29">
					<? if ($pedido["Numero_Revista"]==$numero_revista_pedida) 
				    	echo "<b>".$pedido["Numero_Revista"]."</b>"; 
				    else
				    	echo $pedido["Numero_Revista"];
				    ?>
				</span>
			</td>
			<td align="left">
				<?= "Pag";?>:
				<span class="style29">
					<? if (($pedido["Pagina_Desde"]==$paginaDesde_revista_pedida)&&($pedido["Pagina_Hasta"]==$paginaHasta_revista_pedida)) 
				    	echo "<b>".$pedido["Pagina_Desde"]."-".$pedido["Pagina_Hasta"]."</b>"; 
				    else
				    	echo $pedido["Pagina_Desde"]."-".$pedido["Pagina_Hasta"];
				    ?>
				</span>
			</td>
			<? /* <td align="left"><?= $pedido[7]."-".$pedido[8]."-".$pedido[9]; ?></td> */ ?>
			<td>
				<input type="button" OnClick="mostrar_pedido('<?=$pedido["Id"] ?>',1)" value="C" />
			</td>

		</tr>
	<?}?>
</table>
<?
$pageName1="colecciones2";
$Mensajes = Comienzo($pageName1, $IdiomaSitio);

require_once "../existencias/existencias_utils.php";

if (!empty($id_coleccion))
	mostrarExistencias($id_coleccion, $anio_revista_pedida, $Mensajes, $VectorIdioma);
	
require_once "../layouts/base_layout_admin.php";
?>