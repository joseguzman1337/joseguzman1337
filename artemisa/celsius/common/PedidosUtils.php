<?php

/*
 *
 */

class PedidosUtils {
	function getEventoNT($codigo_evento_local, $rol = "creador") {
		//SEE falta el evento 13???

		if ($rol == "creador") {
			switch ($codigo_evento_local) {
				case EVENTO__CONFIRMADO_POR_OPERADOR :
					return EVENTO_NT__CONFIRMADO;
				case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF :
					return EVENTO_NT__RECIBIDO;
				case EVENTO__A_RECIBIDO :
					return EVENTO_NT__RECIBIDO;
				case EVENTO__A_CANCELADO_POR_USUARIO :
					return EVENTO_NT__CANCELADO;
				case EVENTO__A_CANCELADO_POR_OPERADOR :
					return EVENTO_NT__CANCELADO;
				case EVENTO__A_CANCELADO_POR_ESTAR_EN_SECYT :
					return EVENTO_NT__CANCELADO;
				case EVENTO__A_RECLAMADO_POR_OPERADOR :
					return EVENTO_NT__RECLAMADO;
				default :
					return 0;
			}
		} else { //($rol=="proveedor")
			switch ($codigo_evento_local) {
				case EVENTO__A_ESPERA_DE_CONF_USUARIO :
					return EVENTO_NT__ESPERAR_CONFIRMACION;
				case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF :
					return EVENTO_NT__ENVIADO;
				case EVENTO__A_ENTREGADO_IMPRESO :
					return EVENTO_NT__ENVIADO;
				case EVENTO__A_CANCELADO_POR_OPERADOR :
					return EVENTO_NT__CANCELADO;
				case EVENTO__A_CANCELADO_POR_USUARIO :
					return EVENTO_NT__CANCELADO;
				case EVENTO__A_ESPERA_DE_CONF_OPERADOR :
					return EVENTO_NT__ESPERAR_CONFIRMACION;
				default :
					return 0;
			}
		}
	}

	/**
	 * Determina el estado en que quedará el pedido de acuerdo al evento que le llega
	 */
	function Determinar_Estado($Evento) {
		switch ($Evento) {
			case EVENTO__A_BUSQUEDA :
				return 0;
			case EVENTO__A_SOLICITADO :
				return ESTADO__SOLICITADO;
			case EVENTO__A_ESPERA_DE_CONF_USUARIO :
			case EVENTO__CONFIRMADO_POR_USUARIO :
				return 0;
			case EVENTO__A_RECIBIDO :
				return ESTADO__RECIBIDO;
			case EVENTO__A_ENTREGADO_IMPRESO :
				return ESTADO__ENTREGADO_IMPRESO;
			case EVENTO__A_CANCELADO_POR_USUARIO :
				return ESTADO__CANCELADO;
			case EVENTO__A_CANCELADO_POR_OPERADOR :
				return ESTADO__CANCELADO;
			case EVENTO__A_OBSERVACION :
				return 0;
			case EVENTO__A_CANCELADO_POR_ESTAR_EN_SECYT :
				return ESTADO__CANCELADO;
			case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF :
				return ESTADO__LISTO_PARA_BAJARSE;
			case EVENTO__A_PDF_DESCARGADO :
				return ESTADO__DESCAGADO_POR_EL_USUARIO;
			case EVENTO__A_INTERMEDIO_POR_NT :
				return ESTADO__PENDIENTE_LLEGADA_NT;
			case EVENTO__A_ESPERA_DE_CONF_OPERADOR :
			case EVENTO__CONFIRMADO_POR_OPERADOR :
			case EVENTO__A_RECLAMADO_POR_OPERADOR :
			case EVENTO__A_RECLAMADO_POR_USUARIO :
			default :
				return 0;
		}
	}
	
	/**
	 * Devuelve el nombre de la tabla de pedidos segun el estado del pedido.
	 */
	function getTablaPedidosParaEstado($estado){
		switch ($estado) {
			case ESTADO__ENTREGADO_IMPRESO:
			case ESTADO__CANCELADO:
			case ESTADO__DESCAGADO_POR_EL_USUARIO:
				return "pedhist";
			default:
				return "pedidos";
		}
	}
	/**
	 * Devuelve el nombre de la tabla de eventos segun el evento del pedido.
	 */
	function getTablaEventosParaEventos($evento){
		
		switch ($evento) {
			case EVENTO__A_ENTREGADO_IMPRESO:
			case EVENTO__A_CANCELADO_POR_OPERADOR:
			case EVENTO__A_PDF_DESCARGADO:
				return "evhist";
			default:
				return "eventos";
		}
	}

	/**
	 * Indica si un pedido con un estado determinado deberia ser pasado a la tabla de pedidos historicos
	 */
	function Pedido_Pasa_Historico($estado) {
		return ($estado == ESTADO__ENTREGADO_IMPRESO) || ($estado == ESTADO__CANCELADO) || ($estado == ESTADO__DESCAGADO_POR_EL_USUARIO);
	}

	/**
	 * Retorna todos los tipos de materiales manejados en Celsius
	 */
	function getTiposMaterial() {
		return array (
			TIPO_MATERIAL__REVISTA,
			TIPO_MATERIAL__LIBRO,
			TIPO_MATERIAL__PATENTE,
			TIPO_MATERIAL__TESIS,
			TIPO_MATERIAL__CONGRESO
		);
	}

	/**
	 * Retorna todos los tipos de materiales manejados en Celsius
	 */
	function getCodigosEventos() {
		return array (
			EVENTO__A_BUSQUEDA,
			EVENTO__A_SOLICITADO,
			EVENTO__A_ESPERA_DE_CONF_USUARIO,
			EVENTO__CONFIRMADO_POR_USUARIO,
			EVENTO__A_RECIBIDO,
			EVENTO__A_ENTREGADO_IMPRESO,
			EVENTO__A_CANCELADO_POR_USUARIO,
			EVENTO__A_CANCELADO_POR_OPERADOR,
			EVENTO__A_OBSERVACION,
			EVENTO__A_AUTORIZADO_A_BAJARSE_PDF,
			EVENTO__A_PDF_DESCARGADO,
			EVENTO__A_INTERMEDIO_POR_NT,
			EVENTO__A_ESPERA_DE_CONF_OPERADOR,
			EVENTO__CONFIRMADO_POR_OPERADOR,
			EVENTO__A_RECLAMADO_POR_OPERADOR,
			EVENTO__A_RECLAMADO_POR_USUARIO
		);
	}

	function getEstados($VectorIdioma) {
		$estados = array ();
		$estados["0" . ESTADO__PENDIENTE] = $VectorIdioma["Estado_" . ESTADO__PENDIENTE];
		$estados["0" . ESTADO__BUSQUEDA] = $VectorIdioma["Estado_" . ESTADO__BUSQUEDA];
		$estados["0" . ESTADO__SOLICITADO] = $VectorIdioma["Estado_" . ESTADO__SOLICITADO];
		$estados["0" . ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO] = $VectorIdioma["Estado_" . ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_USUARIO];
		$estados["0" . ESTADO__CONFIRMADO_POR_EL_USUARIO] = $VectorIdioma["Estado_" . ESTADO__CONFIRMADO_POR_EL_USUARIO];
		$estados["0" . ESTADO__RECIBIDO] = $VectorIdioma["Estado_" . ESTADO__RECIBIDO];
		$estados["0" . ESTADO__ENTREGADO_IMPRESO] = $VectorIdioma["Estado_" . ESTADO__ENTREGADO_IMPRESO];
		$estados["0" . ESTADO__CANCELADO] = $VectorIdioma["Estado_" . ESTADO__CANCELADO];
		//$estados["0".ESTADO__EN_OBSERVACION]=$VectorIdioma["Estado_" . ESTADO__EN_OBSERVACION];
		$estados["0" . ESTADO__LISTO_PARA_BAJARSE] = $VectorIdioma["Estado_" . ESTADO__LISTO_PARA_BAJARSE];
		$estados["0" . ESTADO__DESCAGADO_POR_EL_USUARIO] = $VectorIdioma["Estado_" . ESTADO__DESCAGADO_POR_EL_USUARIO];
		$estados["0" . ESTADO__PENDIENTE_LLEGADA_NT] = $VectorIdioma["Estado_" . ESTADO__PENDIENTE_LLEGADA_NT];
		$estados["0" . ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR] = $VectorIdioma["Estado_" . ESTADO__EN_ESPERA_DE_CONFIRMACION_DEL_OPERADOR];
		return $estados;
	}

	function getTiposMateriales($VectorIdioma) {
		$tipos = array ();
		$tipos["0" . TIPO_MATERIAL__REVISTA] = $VectorIdioma["Tipo_Material_" . TIPO_MATERIAL__REVISTA];
		$tipos["0" . TIPO_MATERIAL__LIBRO] = $VectorIdioma["Tipo_Material_" . TIPO_MATERIAL__LIBRO];
		$tipos["0" . TIPO_MATERIAL__PATENTE] = $VectorIdioma["Tipo_Material_" . TIPO_MATERIAL__PATENTE];
		$tipos["0" . TIPO_MATERIAL__TESIS] = $VectorIdioma["Tipo_Material_" . TIPO_MATERIAL__TESIS];
		$tipos["0" . TIPO_MATERIAL__CONGRESO] = $VectorIdioma["Tipo_Material_" . TIPO_MATERIAL__CONGRESO];
		return $tipos;
	}

	/**
	 * Devuelve el color que se debe utilizar en base al tipo de material especificado como parametro
	 */
	function Devolver_Color_Para_Tipo_Material($tipo_material) {
		switch ($tipo_material) {
			case 1 :
				return "#CCCCCC";
			case 2 :
				return "#FFFFFF";
			case 3 :
				return "#A6CEDD";
			case 4 :
				return "#C8C7BB";
			case 5 :
				return "#F5EED3";
			default :
				return "#CCCCCC";
		}
	}

	function describirEvento($evento) {
		global $MensajesEventos;
		$descripcion = "";
		switch ($evento["Codigo_Evento"]) {
			 
				 
				
				
			case EVENTO__A_SOLICITADO :
					$descripcion .= $evento["Nombre_Pais"];
						if (!empty ($evento["Nombre_Institucion"])) {
							$descripcion .= " - " . $evento["Nombre_Institucion"];
							if (!empty ($evento["Nombre_Dependencia"])) {
								$descripcion .= " - " . $evento["Nombre_Dependencia"];
								if (!empty ($evento["Nombre_Unidad"])) {
									$descripcion .= " - " . $evento["Nombre_Unidad"];
									if (!empty ($evento["Id_Instancia_Celsius"]))
										$descripcion .= " - " . $evento["Id_Instancia_Celsius"];
								}
							}
						}
						  break;
			case EVENTO__A_RECIBIDO :
			      		$descripcion=" ".$MensajesEventos["cantidadPaginas"].":".$evento['Numero_Paginas'];
					      break; 
			case EVENTO__A_INTERMEDIO_POR_NT:
			case EVENTO__A_RECLAMADO_POR_OPERADOR:
			case EVENTO__A_RECLAMADO_POR_USUARIO:
			case EVENTO__A_ESPERA_DE_CONF_OPERADOR: 
			case EVENTO__CONFIRMADO_POR_OPERADOR:
			case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF :
				
			default :
				}
		return $descripcion;
	}
	
	/**
	 * Funcion auxiliar que genera una expresion regular para mysql de un id_pedido dado.
	 * coloca un % en medio de la region numerica del pedido. Si el pedido no posee region 
	 * numerica retorna false 
	 */
	function armarCodigoCompleto($Codigo) {
		$PrimerLugar = strpos($Codigo, '-');
		$SegundoLugar = strrpos($Codigo, '-');
		if ($PrimerLugar !== $SegundoLugar) {
			$Numero = substr($Codigo, $SegundoLugar + 1);
			if ($Numero!== false && strlen($Numero) > 0){
				$Numero = '%' . $Numero;
				$Codigo = substr($Codigo, 0, $SegundoLugar +1) . $Numero;
				return trim($Codigo);
			}
			/*
			$Counter = 7 - (strlen($Codigo) - $SegundoLugar);
			for ($i = 0; $i <= $Counter; $i++) {
				$Numero = "0" . $Numero;
			}
			*/
			
			
		}
		return false;
	}
	
function guardarURLEnWSDL($wsdl_filename,$url_wsdl){
	if (!file_exists($wsdl_filename) && !is_readable($wsdl_filename)) 
		return new CelsiusException("El archivo de web services '$wsdl_filename' no existe o no es accesible por la aplicacion");

	$wsdl_old_content = file_get_contents($wsdl_filename);
	if ($wsdl_old_content === false) 
		return new CelsiusException("El archivo de web services '$wsdl_filename' no pudo ser leido por la aplicacion");
	
	$wsdl_new_content = preg_replace('/(<soap:address[^"]*location=")[^"]*/','\\1'.$url_wsdl,$wsdl_old_content);
	$handle = fopen($wsdl_filename, "w");
	fwrite($handle, $wsdl_new_content);
	fclose($handle);
	return true;
}

function guardarURLLocalEnWSDLs($url_local){
	$url_local = rtrim($url_local,'/').'/';
	$url_wsdl_celsius = $url_local.'soap-celsius/CelsiusSOAPServer.php';
	$wsdl_filename_celsius = realpath(dirname(__FILE__).'/../').'/soap-celsius/celsius-celsius.wsdl';
	$url_wsdl_directorio = $url_local.'soap-directorio/DirectorioSoapServer.php';
	$wsdl_filename_directorio = realpath(dirname(__FILE__).'/../').'/soap-directorio/celsius-directorio.wsdl';
	
	$res = PedidosUtils::guardarURLEnWSDL($wsdl_filename_celsius,$url_wsdl_celsius);
	if ($res !== true)
		return $res;
	
	$res = PedidosUtils::guardarURLEnWSDL($wsdl_filename_directorio,$url_wsdl_directorio);
	if ($res !== true)
		return $res;
	
	return true;
}	

}
?>