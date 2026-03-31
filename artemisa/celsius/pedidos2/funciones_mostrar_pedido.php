<?
/**
 * 
 */
function mostrar_pedido_detallado($VectorIdioma, $pedidoCompleto, $Mensajes, $rol_usuario, $mostrarTodasOpciones = true) {
	
	$idPedido = $pedidoCompleto["Id"];
	global $servicesFacade;
	global $usuario;
	imprimirScriptsPedidos();
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" >
		<tr valign="middle"><!-- tipo y Id -->
			<td align="left" class="style49">
				<strong class="style29 style40"><? echo $Mensajes["ec-5"].":"; ?></strong> 
				<? echo TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma, $pedidoCompleto["Tipo_Pedido"], 0) ?>
			</td> 
	        <td align="right">
				<span class="style52"><? echo $Mensajes["et-2"]; ?></span>
				<span class="style49">
					<a href="mostrar_pedido.php?id_pedido=<? echo $idPedido; ?>"><? echo $idPedido; ?></a>
				</span>
			</td>
		</tr>
		
		<!-- ahora el usuario -->
		<tr valign="middle">
			<td align="left">
				<span class="style49">
				<span class="style29"><strong><?echo $Mensajes["et-3"]; ?></strong></span>
					<?
					if ($pedidoCompleto["origen_remoto"]) {
						echo $pedidoCompleto["id_instancia_origen"];
					} else {?>
						<a href="../usuarios2/mostrar_usuario.php?id_usuario=<?=$pedidoCompleto["Codigo_Usuario"]?>">
							<?=$pedidoCompleto["Apellido_Usuario"].", " . $pedidoCompleto["Nombre_Usuario"];?>
						</a>
						&nbsp;&nbsp;
						<?
						$cliente = $servicesFacade->getUsuario($pedidoCompleto["Codigo_Usuario"]);
						$formaDeEntrega = $cliente["Codigo_FormaEntrega"];
				
						// calcula la imagen correspondiente a la forma de Entrega del usuario
						switch ($formaDeEntrega) {
							case 1 :
								echo '<img src="../images/admin02.gif">';
								break;
							case 2 :
								echo '<img src="../images/admin03.gif">';
								break;
							case 3 :
								echo '<img src="../images/admin04.gif">';
								break;
							case 4 :
								echo '<img src="../images/admin.gif">';
								break;
							case 5 :
								echo '<img src="../images/admin03.gif"><img src="../images/files/send-pdf.gif">';
								break;
							case 6 :
								echo '<img src="../images/admin.gif"><img src="../images/files/send-pdf.gif">';
								break;
						} // de switch
						echo $pedidoCompleto["Nombre_Unidad_Usuario"];
					}
				?>
				</span>
			</td>
			<td align="right" class="style49">
				<span class="style52"><? echo $Mensajes["et-5"]; ?></span>
				<? echo $pedidoCompleto["Fecha_Alta_Pedido"]; ?>
			</td>
		</tr>
		
		<tr valign="middle"><!-- datos-->
			<td colspan="2">
				<table cellspacing="0" cellpadding="3" border="0" align="left">
					<tr valign="middle">
						<td class="style28 style18" style="text-align:right" bgcolor="#00ccff"><?= $Mensajes["et-4"]; ?></td>
						<td class="style49" align="left">
  							<? echo Devolver_Descriptivo_Material($pedidoCompleto,$rol_usuario); ?>
  						</td>
					</tr>
				</table>
			</td>
		<tr>
		 
		<tr valign="middle">
			<td align="left" colspan="2">
				<span class="style52"><? echo $Mensajes["et-7"]; ?> (<?=$pedidoCompleto["Estado"]?>)</span>
				<span class="style49"><? echo TraduccionesUtils::Traducir_Estado($VectorIdioma, $pedidoCompleto["Estado"]) ?></span>
				<? if ($pedidoCompleto["Observado"] == 1){ ?>
					<a href="#" onclick="mostar_eventos_simple('<?=$idPedido?>',<?=EVENTO__A_OBSERVACION?>);">
						<img border="0" alt='Observaciones' src='../images/obs.gif'>
					</a>
				<? } ?>
			</td>
		</tr>
		<tr valign="top">
			<td align="left">
				<span class="style52"><? echo $Mensajes["et-6"]; ?></span>
				<span class="style49">
					<?if (!empty($pedidoCompleto["Apellido_Operador"])) 
						echo $pedidoCompleto["Apellido_Operador"] . ", " . $pedidoCompleto["Nombre_Operador"];
					?>
					&nbsp;
				</span>
			</td>
			<td align="center" class="style49" >
				<? imprimirArchivosPedido($idPedido, $rol_usuario,$usuario['habilitar_entrega_pedido']); ?>
			</td>
		</tr>
	
		<tr valign="top">
			<td align="left">
				<span class="style52"><? echo $Mensajes["pedidos.usuarioCreador"]; ?></span>
				<span class="style49">
					<?if (!empty($pedidoCompleto["Nombre_Creador"])) 
						echo $pedidoCompleto["Apellido_Creador"] . ", " . $pedidoCompleto["Nombre_Creador"];
					?>
					&nbsp;
				</span>
			</td>
		</tr>
	</table>
	<?
}

function mostrar_pedido_usuario($VectorIdioma, $pedidoCompleto, $Mensajes, $rol_usuario, $imprimeNombre, $mostrarTodasOpciones = true) {
	global $servicesFacade;
	global $usuario;
	?>
	
	<table width="85%" align="center" class="table-list" cellspacing="1" cellpadding="3" border="0">
		<?if($imprimeNombre){?>
			<tr>
				<td colspan="4" class="table-list-top">
		    		<img src="../images/square-w.gif" width="8" height="8">
		    		<? echo $Mensajes["et-3"]; ?>
		    		<a href="../usuarios2/mostrar_usuario.php?id_usuario=<?=$pedidoCompleto["Codigo_Usuario"]?>">
						<?=$pedidoCompleto["Apellido_Usuario"].", " . $pedidoCompleto["Nombre_Usuario"];?>
					</a>
		        </td>
			</tr>
			<tr>
				<th width="25%"><? echo $Mensajes["et-2"]; ?></th>
				<th width="25%"><? echo $Mensajes["campo.fechaAlta"]; ?></th>
				<th width="25%"><? echo $Mensajes["campo.fechaEntrega"]; ?></th>
				<th width="25%"><? echo $Mensajes["campo.cantidadPag"]; ?></th>
			</tr>
		<?}?>
		<tr>
			<td width="25%" class="style29">
				<a href="mostrar_pedido.php?id_pedido=<?=$pedidoCompleto["Id"]?>"><? echo $pedidoCompleto["Id"]; ?></a>
			</td>
			<td width="25%" class="style29">
				<?=$pedidoCompleto["Fecha_Alta_Pedido"] ?>
			</td>
			<td width="25%" class="style29">
				<? echo $pedidoCompleto["Fecha_Entrega"]; ?>
			</td>
			<td width="25%" class="style29">
				<? echo $pedidoCompleto["Numero_Paginas"]; ?>
			</td>
		</tr>
	</table>				
	<?
}


/**
 * 
 */ 
function mostrar_pedido_corto($VectorIdioma,$Mensajes, $pedidoCompleto,$rol_usuario) {
	$idPedido = $pedidoCompleto["Id"];
	imprimirScriptsPedidos();
	?>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
	<tr bgcolor='#ECECEC'>
		<td colspan="2" align="center" valign="middle" class="style33">
			<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1" >
			<tr>
				<td colspan="3" align="left">
					<span class="style33">
						<? echo TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma, $pedidoCompleto["Tipo_Pedido"]) ?>
						<b><a href="mostrar_pedido.php?id_pedido=<?=$idPedido?>"><? echo $idPedido ?></a></b>
					 	- 
						<? if ($pedidoCompleto["origen_remoto"]) {
							echo $pedidoCompleto["id_instancia_origen"];
						} else {?>
							<a href="../usuarios2/mostrar_usuario.php?id_usuario=<?=$pedidoCompleto["Codigo_Usuario"]?>">
								<?=$pedidoCompleto["Apellido_Usuario"].", " . $pedidoCompleto["Nombre_Usuario"];?>
							</a>
						<?}?>
					 	- 
						<? echo Devolver_Descriptivo_Material_Corto($pedidoCompleto, $rol_usuario);?>
					 	- 
						<?= $Mensajes["campo.fechaSolicitud"];?> <? echo $pedidoCompleto["Fecha_Solicitado"]; ?>
					</span>
							
					<? if ($pedidoCompleto["Observado"] == 1) { ?>
						<a href="#" onclick="mostar_eventos_simple('<?=$idPedido?>',<?=EVENTO__A_OBSERVACION?>);">
							<img border="0" alt='Observaciones' src='../images/obs.gif'>
						</a>
					<?} ?>
				</td>
			</tr>
			<tr>
				<td colspan='3' align='left'>
					<span class='style33'>
						<? if (isset($pedidoCompleto["Nombre_Pais_Solicitado"])) echo $pedidoCompleto["Nombre_Pais_Solicitado"]; ?>
						 - 
						<? if (isset($pedidoCompleto["Nombre_Institucion_Solicitada"]))echo $pedidoCompleto["Nombre_Institucion_Solicitada"]; ?>
						 - 
						<? if (isset($pedidoCompleto["Nombre_Dependencia_Solicitada"]))echo $pedidoCompleto["Nombre_Dependencia_Solicitada"]; ?>
					</span>
				</td>
			</tr>
			</table>
	    </td>
		<td width="15%" height="17" align="left">
				<? if ($pedidoCompleto["Estado"] == ESTADO__BUSQUEDA) { ?>
					<input type="button" value="B" name="B1"  OnClick="mostrar_busquedas('<? echo $idPedido ?>')"> 
					<br>
				<? } ?>
		</td>
	</tr>
	</table>
<?}

/**
 * 
 */
function mostrar_pedido_corto_pdf($VectorIdioma,$Mensajes, $pedidoCompleto, $rol_usuario) {
	global $usuario;
	?>
	 
	<table width="100%" border="0" >
		<tr>
			<td width="12" height="20"  align="center">
				<img src="../images/arrow.gif" width="10" height="13">
			</td>
			<td width="577" bgcolor="#06B4D2" class="style5"><?= $pedidoCompleto['Id'] ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<? echo Devolver_Descriptivo_Material($pedidoCompleto, $rol_usuario);?>
			</td>
		</tr>
		<tr bgcolor="#ECECEC">
			<td colspan="2" align="center">
				<table border="0" cellpadding="0" cellspacing="3">
					<tr>
						<td><span class="style22">Descargar</span></td>
						<td><? imprimirArchivosPedido($pedidoCompleto["Id"], $rol_usuario,$usuario['habilitar_entrega_pedido']); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?
}

/**
 * Devuelve una tabla que describe el material solicitado en el pedido
 * @param array $pedidoCompleto el pedido a mostrar
 * @param int $rol_usuario
 */
function Devolver_Descriptivo_Material($pedidoCompleto, $rol_usuario) {
	$pageName="descriptivo_material";
	$id_pedido = $pedidoCompleto["Id"];
	$TipoMaterial = $pedidoCompleto["Tipo_Material"];
	
	global $IdiomaSitio;
	$Mens = Comienzo($pageName, $IdiomaSitio);

	foreach ($pedidoCompleto as $colName => $colValue) {
		$pedidoCompleto[$colName] = StripSlashes($colValue);
	}

	switch ($TipoMaterial) {
		case TIPO_MATERIAL__REVISTA :
			?>
			<span class="style29" ><strong><? echo $Mens['tf-1']; ?>: </strong></span>
			<? if (!empty ($pedidoCompleto["Codigo_Titulo_Revista"]) && ($rol_usuario == ROL__ADMINISTADOR)) {?>
					<b>
						<a href="../pedidos2/pedidos_coleccion.php?id_pedido=<?=$id_pedido ?>&id_coleccion=<?=$pedidoCompleto["Codigo_Titulo_Revista"]?>">
							<font color="#000000"><? echo $pedidoCompleto["Nombre_Titulo_Colecciones"] ?></font>
						</a>
					</b>
			<?} else {
				echo "<font color='#800000'>" . $pedidoCompleto["Titulo_Revista"] . "</font>";
			}?>
			<? if (!empty($pedidoCompleto["Autor_Detalle1"])){?>
			<br>
			<span class='style29' ><strong><?=$Mens['tf-6'] ?>: </strong></span>
			<?=$pedidoCompleto["Autor_Detalle1"] ?>&nbsp;&nbsp;&nbsp;
			<?}?>
			<br>
			<span class='style29' ><strong><? echo $Mens['tf-2'] ?>: </strong></span>
			<? echo $pedidoCompleto["Anio_Revista"] ?>&nbsp;&nbsp;&nbsp;
			<span class='style29'><strong> Vol: </strong></span>
			<? echo $pedidoCompleto["Volumen_Revista"] ?>&nbsp;&nbsp;&nbsp;
			<span class='style29'><strong><? echo $Mens['tf-3'] ?>: </strong></span>
			<? echo $pedidoCompleto["Numero_Revista"]; ?>&nbsp;&nbsp;&nbsp;
			<span class='style29'><strong><? echo $Mens['tf-4'] ?>: </strong></span>
			<? echo $pedidoCompleto["Pagina_Desde"] . "-" . $pedidoCompleto["Pagina_Hasta"]; ?>
			<? if (($rol_usuario == ROL__ADMINISTADOR) && !empty($pedidoCompleto["Titulo_Articulo"])){?>
				<br><span class='style29'><strong>Art: </strong></span><? echo $pedidoCompleto["Titulo_Articulo"]; ?>
			<?}
			break;
		case TIPO_MATERIAL__LIBRO :?>
			<span class="style29"><strong><? echo $Mens['tf-5'] ?>: </strong></span>
			<b><? echo $pedidoCompleto["Titulo_Libro"] ?></b>
			<br/>
			<span class='style29'><strong><? echo $Mens['tf-6'] ?>: </strong></span>
			<? echo $pedidoCompleto["Autor_Libro"] ?>
			&nbsp;&nbsp;&nbsp;
			<span class='style29'><strong><? echo $Mens['tf-8'] ?>: </strong></span>
			<? echo $pedidoCompleto["Anio_Libro"] ?>
			&nbsp;&nbsp;&nbsp;
			<span class='style29'><strong>Cap: </strong></span>
			<? echo $pedidoCompleto["Capitulo_Libro"] ?>
			&nbsp;&nbsp;&nbsp;
			<span class="style29"><strong>pag. </strong></span>
			<? echo $pedidoCompleto["Pagina_Desde"] . "-" . $pedidoCompleto["Pagina_Hasta"];
			if ($pedidoCompleto["Desea_Indice"] == 1) {?>
				&nbsp;&nbsp;&nbsp;
				<span class="style29"><strong><? echo $Mens['tf-9'] ?></strong></span>
			<?}
			break;
		case TIPO_MATERIAL__PATENTE :?>
			<span class="style29"><strong><? echo $Mens['tf-10'] ?>: </strong></span>
			<? echo $pedidoCompleto["Numero_Patente"] ?> /  
			<span class='style29'><strong><? echo $Mens['tf-11'] ?>: </strong></span>
			<? if (!empty ($pedidoCompleto["Nombre_Pais_Patente"]))
				echo $pedidoCompleto["Nombre_Pais_Patente"];
			elseif (!empty ($pedidoCompleto["Pais_Patente"])) 
				echo $pedidoCompleto["Pais_Patente"];
			?>
			 / 
			<span class='style29'><strong><? echo $Mens['tf-12'] ?>: </strong></span>
			<? echo $pedidoCompleto["Anio_Patente"];
			break;
		case TIPO_MATERIAL__TESIS :?>
			<span class="style29"><strong><? echo $Mens['tf-13'] ?>: </strong></span>
			<? echo $pedidoCompleto["TituloTesis"] ?> / 
			<span class='style29'><strong><? echo $Mens['tf-14'] ?>: </strong></span>
			<? echo $pedidoCompleto["AutorTesis"]." / ".$Mens['tf-15'].":".$pedidoCompleto["DirectorTesis"]." / "; ?>
			<span class='style29'><strong><? echo $Mens['tf-16'] ?>: </strong></span>
			<? echo $pedidoCompleto["Nombre_Pais_Tesis"] ?> / 
			<span class='style29'><strong><? echo $Mens['tf-17'] ?>: </strong></span>
			<? echo $pedidoCompleto["Nombre_Institucion_Tesis"] ?> / 
			<span class='style29'><strong><? echo $Mens['tf-18'] ?>: </strong></span>
			<? echo $pedidoCompleto["Anio_Tesis"];
			break;
		case TIPO_MATERIAL__CONGRESO :?>
			<span class="style29"><strong><? echo $Mens['tf-13'] ?>: </strong></span>
			<? echo $pedidoCompleto["TituloCongreso"] ?> /
			<span class="style29"><strong><? echo $Mens['tf-14'] ?>: </strong></span>
			<? echo $pedidoCompleto["Autor_Detalle1"] ?> /
			<span class='style29'><strong><? echo $Mens['tf-19'] ?>:</strong></span>
			<? echo $pedidoCompleto["Organizador"] ?> / 
			<span class='style29'><strong><? echo $Mens['tf-16'] ?>: </strong></span>
			<? echo $pedidoCompleto["Nombre_Pais_Congreso"] ?> / 
			<span class='style29'><strong><? echo $Mens['tf-18'] ?>: </strong></span>
			<? echo $pedidoCompleto["Anio_Congreso"];
			break;
	}
	if (!empty ($pedidoCompleto["isbn_issn"])) {?>
		<span class='style29'><strong><?= "ISBN/ISSN" ?>: </strong></span>
		<? echo $pedidoCompleto["isbn_issn"] ?>
		&nbsp;&nbsp;&nbsp;
	<? }
	echo "<br/>";
}


/**
 * Devuelve un string con la descrpcion del pedido segun su tipo de material en un formato apto para ser enviado por email 
 * @param array $datosPedido
 */
function Devolver_Descriptivo_Material_Email($datosPedido) {
	global $IdiomaSitio;
	$pageName="descriptivo_material";
	$Mens = Comienzo($pageName, $IdiomaSitio);

	$renglon = "";
	switch ($datosPedido["Tipo_Material"]) {
		case TIPO_MATERIAL__REVISTA :
			$renglon .= $Mens['tf-1'] . " ";
			if (!empty ($datosPedido["Nombre_Titulo"]))
				$renglon .= $datosPedido['Nombre_Titulo'];
			else
				$renglon .= $datosPedido['Titulo_Revista'];

			if ($datosPedido['Titulo_Articulo'])
				$renglon .= " \n Art: " . $datosPedido['Titulo_Articulo'];

			$renglon .= " \n " . $Mens['tf-2'] . " " . $datosPedido['Anio_Revista'] . " / Vol:" . $datosPedido['Volumen_Revista'] . " / " . $Mens['tf-3'] . " " . $datosPedido['Numero_Revista'] . " / " . $Mens['tf-4'] . ": " . $datosPedido['Pagina_Desde'] . "-" . $datosPedido['Pagina_Hasta'];

			break;
		case TIPO_MATERIAL__LIBRO :
			$renglon .= " " . $Mens['tf-5'] . ": " . $datosPedido['Titulo_Libro'] . " / " . $Mens['tf-6'] . ": " . $datosPedido['Autor_Libro'] . " / " . $Mens['tf-8'] . ": " . $datosPedido['Anio_Libro'] . " \n ";

			if ($datosPedido['Capitulo_Libro'])
				$renglon .= "Cap: " . $datosPedido['Capitulo_Libro'] . " \n";
			if ($datosPedido['Desea_Indice'] == 1)
				$renglon .= $Mens['tf-9'];

			break;
		case TIPO_MATERIAL__PATENTE :
			$renglon .= $Mens['tf-10'] . " " . $datosPedido['Numero_Patente'] . " /  " . $Mens['tf-11'] . ":";
			if (!empty ($datosPedido['Nombre_Pais_Patente'])) 
				$renglon .= $datosPedido['Nombre_Pais_Patente'];
			elseif (!empty ($datosPedido['Pais_Patente']))
				$renglon .= $datosPedido['Pais_Patente'];
			$renglon .= " / " . $Mens['tf-12'] . ":" . $datosPedido['Anio_Patente'];
			break;
		case TIPO_MATERIAL__TESIS :
			$renglon .= " " . $Mens['tf-13'] . ":" . $datosPedido['TituloTesis'] . " /  " . $Mens['tf-14'] . ":" . $datosPedido['AutorTesis'] . " / " . $Mens['tf-15'] . ":" . $datosPedido['DirectorTesis'] . " /  " . $Mens['tf-16'] . ":" . $datosPedido['Nombre_Pais_Tesis'] . " /  " . $Mens['tf-17'] . ":" . $datosPedido['Nombre_Institucion_Tesis'] . " /  " . $Mens['tf-18'] . ":" . $datosPedido['Anio_Tesis'];
			break;
		case TIPO_MATERIAL__CONGRESO :
			$renglon .= $Mens['tf-13'] . ":" . $datosPedido['TituloCongreso'] . " / " . $Mens['tf-19'] . ":" . $datosPedido['Organizador'] . " /  " . $Mens['tf-16'] . ": " . $datosPedido['Nombre_Pais_Congreso'] . " /  " . $Mens['tf-18'] . ":" . $datosPedido['Anio_Congreso'];
	}
	return $renglon;
}

/**
 * Devuelve una pequeï¿½a tabla que describe el material solicitado en el pedido
 * @param array $pedidoCompleto el pedido a mostrar
 * @param int $rol_usuario
 */
function Devolver_Descriptivo_Material_Corto($datosPedido, $rol_usuario) {
	global $IdiomaSitio;
	$pageName= "descriptivo_material";
	$Mens = Comienzo($pageName, $IdiomaSitio);

	$TipoMaterial = $datosPedido["Tipo_Material"];
	
	for ($i = 0; $i < count($datosPedido); $i++) {
		if (!empty ($datosPedido[$i]))
			$datosPedido[$i] = StripSlashes($datosPedido[$i]);
	}
	switch ($TipoMaterial) {
		case TIPO_MATERIAL__REVISTA :
			echo $Mens['tf-1'];
			if (!empty($datosPedido['Codigo_Titulo_Revista']) && $rol_usuario == ROL__ADMINISTADOR) {?>
				<a href="../pedidos2/pedidos_coleccion.php?id_pedido=<?=$datosPedido['Id']?>&id_coleccion=<?=$datosPedido['Codigo_Titulo_Revista']?>">
					<font color='#000000'><?=$datosPedido['Titulo_Revista'] ?></font>
				</a>
			<?} else {?>
				<font color='#800000'><?=$datosPedido['Titulo_Revista']?></font>
			<?}
			echo " ".$Mens['tf-2'] . " " . $datosPedido['Anio_Revista'] . " / Vol:" . $datosPedido['Volumen_Revista'] . " / " . $Mens['tf-3'] . " " . $datosPedido['Numero_Revista'];
			echo " /  " . $Mens['tf-4'] . ": <font color='#800000'>" . $datosPedido['Pagina_Desde'] . "-" . $datosPedido['Pagina_Hasta'] . "</font>";
			break;

		case TIPO_MATERIAL__LIBRO : 
			echo " " . $Mens['tf-5'] . ": " . $datosPedido['Titulo_Libro'] . " / " . $Mens['tf-6'] . ": " . $datosPedido['Autor_Libro']
				. " / " . $Mens['tf-8'] . ": " . $datosPedido['Anio_Libro'] . " \n "; 
			if ($datosPedido['Desea_Indice'] == 1)  
				echo $Mens['tf-9']; 
			break;
		case TIPO_MATERIAL__PATENTE :
			echo $Mens['tf-10'] . " " . $datosPedido['Numero_Patente'] . " /  " . $Mens['tf-11'] . ":";
			if (!empty($datosPedido['Nombre_Pais_Patente'])) 
				echo $datosPedido['Nombre_Pais_Patente'];
			
			echo " / " . $Mens['tf-12'] . ":" . $datosPedido['Anio_Patente'];
			break;

		case TIPO_MATERIAL__TESIS : 
			echo " " . $Mens['tf-13'] . ":" . $datosPedido['TituloTesis'] . " /  " . $Mens['tf-14'] . ":" . $datosPedido['AutorTesis'] . " / " . $Mens['tf-15'] . ":" . $datosPedido['DirectorTesis'];
			echo " / " . $Mens['tf-16'] . ":" . $datosPedido['Nombre_Pais_Tesis'] . " /  " . $Mens['tf-17'] . ":" . $datosPedido['Nombre_Institucion_Tesis'] . " /  " . $Mens['tf-18'] . ":" . $datosPedido['Anio_Tesis'];
			break;

		case TIPO_MATERIAL__CONGRESO : 
			echo $Mens['tf-13'] . ":" . $datosPedido['TituloCongreso'] . " / " . 
				$Mens['tf-19'] . ":" . $datosPedido['Organizador'] . " /  " . 
				$Mens['tf-16'] . ": " . $datosPedido['Nombre_Pais_Congreso'] . " /  " . 
				$Mens['tf-18'] . ":" . $datosPedido['Anio_Congreso'];
	}

}


////////////////////////////////////////////////////////////////////////////
///////////////////// FUNCIONES AUXILIARES DE LOS MOSTRAR///////////////////
////////////////////////////////////////////////////////////////////////////


/**
 * Imprime entre 1 y 3 filas (tr) que expresan el historial de busquedas del pedido
 * @param string $id_pedido
 * @param array $Mensajes
 */
function devolverBusqueda($id_pedido, $Mensajes) {
	global $servicesFacade;
	 
	$resultadosBusquedas = $servicesFacade->getAllObjects("busquedas", array (
		"Id_Pedido" => $id_pedido
	), "Resultado, count( Resultado ) AS cantidad", null, "Resultado");
	
	$cantBusquedas = 0;
	foreach ($resultadosBusquedas as $resultadoBusqueda){ 
		if ($resultadoBusqueda["Resultado"] != 0) 
			$cantBusquedas += $resultadoBusqueda['cantidad'];
	}
	?>
	<tr bgcolor="#FFFFFF">
		<td height="20" align="center" class="style22">
			<b><? echo $Mensajes["bb-01"] . ':&nbsp;&nbsp;' .$cantBusquedas; ?></b>
		</td>
	</tr>
	<?

	foreach ($resultadosBusquedas as $resultadoBusqueda) {
		if ($resultadoBusqueda["Resultado"] != 0) {?>
			<tr bgcolor="#0099CC">
				<td height="15" colspan="2" align="center" class="style18">
					<?
					switch ($resultadoBusqueda["Resultado"]) {
						case 1 :
							echo $Mensajes["bb-02"];
							break;
						case 2 :
							echo $Mensajes["bb-03"];
							break;
						case 3 :
							echo $Mensajes["bb-04"];
							break;
					}
					?>:&nbsp;&nbsp; <? echo $resultadoBusqueda["cantidad"]; ?>
				</td>
			</tr>
		<?}
	}
}

/**
 * Funcion auxiliar que imprime los archivos de un pedido
 * @param string idPedido El Id del pedido en cuestion 
 * @param int $rol_usuario El rol del usuario que esta visualizando los datos actualmente
 * @access private 
*/
function imprimirArchivosPedido($idPedido, $rol_usuario,$habilitado_entrega_pedido=0) {
	//Buscar archivo(s) para el pedido e imprime los iconos

	$servicesFacade = ServicesFacade :: getInstance();
	$archivos_pedido = $servicesFacade->getArchivosPedido($idPedido);
	$parteNo = 1;
	foreach ($archivos_pedido as $unArchivo) {

		$inicio_extension = strpos($unArchivo["nombre_archivo"], '.');
		if ($inicio_extension !== false)
			$extension = substr($unArchivo["nombre_archivo"], $inicio_extension +1, strlen($unArchivo["nombre_archivo"]) - 1);
		else
			$extension = "";
		if ($rol_usuario == ROL__ADMINISTADOR) {
			//los administradores siempre pueden bajarse archivos
              if ($unArchivo['borrado']==0){?>
				<a href="../files/download_archivos_pedido.php?codigo_archivo=<?= $unArchivo['codigo'] ?>" >
					<? if (strcasecmp($extension,"pdf") === 0){
						if (count($archivos_pedido)>1)
							echo $parteNo++."&rarr;";
						?>
						
						<img alt='Archivo disponible para bajar' border="0" src='../images/files/pdf.gif' width='20' style="vertical-align:middle">&nbsp;&nbsp;
					<?}elseif (strcasecmp($extension,"zip") === 0){?>
						<img alt='Archivo disponible para bajar' border="0" src='../images/files/zip.gif' width='20'>
					<?}else{?>
						<img alt='Archivo disponible para bajar' border="0" src='../images/files/file.gif' width='20'>
					<?}?>
				</a>
			<?}else{?>
				<img alt='Archivo ya Borrado' border="0" src='../images/files/pdf-cacelled.gif' width='20'>
			<?}?>
				
		<?}
		elseif (strcasecmp($extension, "pdf") === 0) {
			
			if ($habilitado_entrega_pedido==0){
					if ($unArchivo["Permitir_Download"] == 1) {
						?>
							<a href='../files/download_archivos_pedido.php?codigo_archivo=<?= $unArchivo['codigo'] ?>'>
								<img src='../images/files/pdf.gif' alt='Archivo disponible para bajar' border="0" width='20' height='20'>
							</a>
						<?}else{?>
							<img alt='Archivo ya bajado' border="0" src='../images/files/pdf-cacelled.gif' width='20'>
					<?}
			}elseif($habilitado_entrega_pedido==1){?>
				<img alt='El archivo Existe pero no se puede bajar. Consulte con el Administrador' border="0" src='../images/files/pdf-cacelled.gif' width='20'>
			<?}
				
		}
	}
}

/**
 * Imprime un script javascript	 que contiene las funciones basicas para apertura de popups para operaciones
 * sobre los pedidos
 * @access private 
 */
function imprimirScriptsPedidos() {?>
	<script language="JavaScript" type="text/javascript">
	
		function modificar_pedido(id_pedido){
			ventana=window.open("modificar_pedido.php?id_pedido="+id_pedido,"","dependent=yes,toolbar=no,width=700 ,height=500, scrollbars=yes");   
		}
	 
	   	function mostrar_busquedas(id_pedido){
			ventana=window.open("mostrar_busquedas.php?id_pedido="+id_pedido, "" , "dependent=yes,toolbar=no, width="+(screen.width - 300)+",height="+(screen.height - 300)+",scrollbars=yes");
		}
		
		function generar_evento(codigo_evento, id_pedido){
			ventana=window.open("generar_evento.php?id_pedido="+id_pedido+"&codigo_evento=" + codigo_evento, "", "dependent=yes,toolbar=no,width=530 ,height=380");
		}
		
		function mostrar_evento(id_evento){
			ventana=window.open("mostrar_evento.php?id_evento="+id_evento, "", "dependent=yes,toolbar=no, width=530 ,height=450,scrollbars=yes");
		}
		
		function entregar_todo(codigo_evento,id_usuario,id_estado){
			ventana=window.open("registrar_entregas.php?id_usuario="+id_usuario+"&codigo_evento="+codigo_evento+"&id_estado="+id_estado, "", "dependent=yes,toolbar=no,width=530 ,height=380");
		}
		
		function mostar_eventos_simple(id_pedido,codigo_evento){
			ventana=window.open("../pedidos2/listar_eventos_simple.php?id_pedido=" + id_pedido + "&codigo_evento=" + codigo_evento, "", "dependent=yes,toolbar=no,width=630 ,height=250");
		}
		
		function revisar_solicitud(id_instancia_celsius,id_pedido){
			ventana=window.open("mostrar_eventos_destino_remoto.php?id_pedido="+id_pedido+'&id_instancia_remota='+id_instancia_celsius, "Evento Destino Remoto" + id_pedido, "dependent=yes,toolbar=no, width=800 ,height=600,scrollbars=yes");
		}
	</script>
	<?
}


?>