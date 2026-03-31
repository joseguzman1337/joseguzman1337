<?php

/*
 * Funciones auxiliares para la parte de internacionalizacion del sitio
 */

function Comienzo($Pantalla, $Idioma) {
	global $servicesFacade;
	$traducciones = $servicesFacade->getTraducciones(array (
		"Codigo_Pantalla" => $Pantalla,
		"Codigo_Idioma" => $Idioma
	));
	$textos = array ();
	foreach ($traducciones as $traduccion) {
		$textos[$traduccion["Codigo_Elemento"]] = $traduccion["Texto"];
	}

	return $textos;
}

class TraduccionesUtils {

	function TraduccionesUtils() {
		die("Esta clase no se instancia");
	}

	/**
	 * Devuelve un string (abreviado o no, segun se indique) con el tipo de pedido en el idioma seleccionado
	 */
	function Traducir_Tipo_Pedido($VectorIdioma, $Tipo_Pedido, $Abreviado = 0) {

		if ($Tipo_Pedido == TIPO_PEDIDO__PROVISION)//provision 
			$Solicitud = $VectorIdioma["Tipo_Pedido_2"];
		else //busqueda
			$Solicitud = $VectorIdioma["Tipo_Pedido_1"];
			
		if ($Abreviado)
			return substr($Solicitud, 0, 4);
		else
			return $Solicitud;
	}

	/**
	 * Retorna un array con todos los tipos de material traducidos
	 */
	function Traducir_Tipos_Material($VectorIdioma) {
		$res = array ();
		$tipos_material = PedidosUtils :: getTiposMaterial();
		foreach ($tipos_material as $tipo_material) {
			$res[$tipo_material] = TraduccionesUtils :: Traducir_Tipo_Material($VectorIdioma, $tipo_material);
		}
		return $res;
	}

	/**
	 * Devuelve la traduccion correspondiente al tipo de material indicado como parametro
	 */
	function Traducir_Tipo_Material($VectorIdioma, $codigo_tipo_material) {
		return $VectorIdioma["Tipo_Material_" . $codigo_tipo_material];
	}

	/**
	 * Devuelve la traduccion correspondiente al estados indicado como parametro
	 */
	function Traducir_Estado($VectorIdioma, $Codigo_Estado) {
		return $VectorIdioma["Estado_" . $Codigo_Estado];
	}

	/**
	 * Devuelve la traduccion correspondiente al evento indicado como parametro
	 */
	function Traducir_Evento($VectorIdioma, $Codigo_Evento) {
		$c = $Codigo_Evento;
		return $VectorIdioma["Evento".$c];
	}

	/**
	 * Devuelve un array con todos los eventos 
	 */
	function Traducir_Eventos($VectorIdioma) {
		$codigos_eventos = PedidosUtils :: getCodigosEventos();
		$res = array ();
		foreach ($codigos_eventos as $codigo_evento) {
			$res[$codigo_evento] = TraduccionesUtils :: Traducir_Evento($VectorIdioma, $codigo_evento);
		}
		return $res;
	}

	/**
	 * Devuelve una lista con los eventos que se producen fuera de pedidos y que
	 * necesitan enviar mail. Se separaron numericamente bien los códigos para garantizar
	 * que no se mezclen
	 */
	function Traducir__Eventos_Mails($Idioma) {
		
		return array (
			100 => $Idioma["Eventos_Mail_1"],
			101 => $Idioma["Eventos_Mail_2"],
			102 => $Idioma["Eventos_Mail_3"]
		);
	}

	function Traducir_Mes($Mes, $Vector, $abreviado = false) {
		if ($abreviado)
			return substr($Vector[$Mes . "_Mes"], 0, 3);
		else
			return $Vector[$Mes . "_Mes"];
	}
	
	function Traducir_Dia_Semana($Dia, $Vector) {
		return $Vector[$Dia . "_Dia"];
	}
	
}

?>