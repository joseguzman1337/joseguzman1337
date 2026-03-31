<?
require_once "../common/PedidosUtils.php";

/**
 * throws Celsius_Exception
 */
function actualizar_pedidos_eventos_16_a_nt($tabla_pedidos, $tabla_eventos) {
	global $servicesFacade;
	$inicio = microtime_float();
	$resPedidos = mysql_query("SELECT P.Id as Id_Pedido,P.Estado as Estado_Pedido, P.En_Busqueda, E.Id as Id_Evento, E.Fecha, E.Codigo_Evento,E.Codigo_Pais,E.Codigo_Institucion,E.Codigo_Dependencia, E.vigente FROM $tabla_pedidos as P LEFT JOIN $tabla_eventos as E ON P.Id = E.Id_Pedido ORDER BY P.Id, E.Id");
	if ($resPedidos == false){
		return new DB_Exception("Error al intentar recuperar los pedidos de la base de datos",mysql_error(),mysql_errno());
	}
	$evento_pedido = mysql_fetch_assoc($resPedidos);
	
	$ya = time();
	while ($evento_pedido !== false) {
		$id_pedido = $evento_pedido["Id_Pedido"];
		$estado_viejo = $evento_pedido["Estado_Pedido"];
		
		$eventos = array ();
		do {
			if (!empty($evento_pedido["Id_Evento"]))
				$eventos[] = $evento_pedido;
		} while ((($evento_pedido = mysql_fetch_assoc($resPedidos)) !== false) && ($id_pedido == $evento_pedido["Id_Pedido"]));
		
		$vigentesATrue = array ();
		$vigentesAFalse = array ();
		$cambiar_eventos = array();
		$estado_nuevo = 0;
		$EnBusqueda = 0;
		foreach ($eventos as $evento) {
			$vigente = 0;

			switch ($evento["Codigo_Evento"]) {
				case EVENTO__A_BUSQUEDA : //(2)
					if (count($eventos) == 1){
						$vigente = 1;
						$estado_nuevo = ESTADO__BUSQUEDA;
						$EnBusqueda = 1;
					}elseif ($EnBusqueda == 0){
						//chequeo q el pedido solo tenga eventos simples ( q no cambien el estado) luego de la creacion del evento de busqueda actual
						$aux = 1;
						foreach ($eventos as $eventoX) {
							if (PedidosUtils::Determinar_Estado($eventoX["Codigo_Evento"]) == 0 || strtotime($eventoX["Fecha"]) < strtotime($evento["Fecha"]))
								$aux = 1;
							else{
								$aux=0;
								break;
							}
						}
						$EnBusqueda = $aux;
					}
					break;
				case EVENTO__A_SOLICITADO : //(3)

					//me fijo si el pedido fue recibido
					$eventosRecepcion = buscarEvento(array (EVENTO__A_RECIBIDO,	EVENTO__A_AUTORIZADO_A_BAJARSE_PDF), $eventos);

					if (empty ($eventosRecepcion)) {
						$vigente = 1;
						$estado_nuevo = ESTADO__SOLICITADO;
					} else {
						foreach ($eventosRecepcion as $eventoRecepcion) {
							if (($evento["Codigo_Pais"] == $eventoRecepcion["Codigo_Pais"]) && ($evento["Codigo_Institucion"] == $eventoRecepcion["Codigo_Institucion"]) && ($evento["Codigo_Dependencia"] == $eventoRecepcion["Codigo_Dependencia"])){
								//es la solicitud que permitio q se reciba el pedido
								$vigente = 1;
								//el estado no se cambia aca porq se va a cambiar cuando se procese el evento de recepcion del pedido
							}
						}
					}
					break;
				case EVENTO__A_ESPERA_DE_CONF_USUARIO : //(4)
					$eventosConfirmacion = buscarEvento(array (EVENTO__CONFIRMADO_POR_USUARIO), $eventos);
					$vigente = 1;
					foreach ($eventosConfirmacion as $eventoConfirmacion) {
						if (strtotime($eventoConfirmacion["Fecha"]) >= strtotime($evento["Fecha"]))
							$vigente = 0;
					}

					break;
				case EVENTO__CONFIRMADO_POR_USUARIO : //(5)
					$vigente = 1;
					foreach ($eventos as $eventoX) {
						if (strtotime($eventoX["Fecha"]) > strtotime($evento["Fecha"]) ||
							(strtotime($eventoX["Fecha"]) == strtotime($evento["Fecha"]) && $eventoX["Id_Evento"] > $evento["Id_Evento"]))
							$vigente = 0;
					}
					break;
				case EVENTO__A_RECIBIDO : //(6)
					$vigente = 1;
					if ($estado_viejo == ESTADO__DESCAGADO_POR_EL_USUARIO)
						$cambiar_eventos[]=array("Id" => $evento["Id_Evento"], "Codigo_Evento" => EVENTO__A_AUTORIZADO_A_BAJARSE_PDF);
					elseif ($estado_nuevo == 0)
						$estado_nuevo = ESTADO__RECIBIDO;
					break;
				case EVENTO__A_ENTREGADO_IMPRESO : //(7) el pedido esta en historico
				case EVENTO__A_CANCELADO_POR_USUARIO : //(8)
				case EVENTO__A_CANCELADO_POR_OPERADOR : //(9)
				case EVENTO__A_CANCELADO_POR_ESTAR_EN_SECYT : //(11)
					$vigente = 1;
					$estado_nuevo = PedidosUtils :: Determinar_Estado($evento["Codigo_Evento"]);
					break;
				case EVENTO__A_OBSERVACION : //(10)
					$vigente = 1;
					break;
				case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF : //(13)
					//me fijo si el pedido fue recibido
					$eventosCancelados = buscarEvento(array (EVENTO__A_CANCELADO_POR_OPERADOR,EVENTO__A_CANCELADO_POR_USUARIO), $eventos);

					$vigente = 1;
					if (empty ($eventosCancelados)) {
						if ($tabla_pedidos == "pedhist") {
							//es un evento de descarga
							$estado_nuevo = PedidosUtils :: Determinar_Estado(EVENTO__A_PDF_DESCARGADO);
							
							//transformo el evento 13 en uno 14
							$eventosDescargados = buscarEvento(array (EVENTO__A_PDF_DESCARGADO), $eventos);
							if (empty($eventosDescargados)){
								$eventos13 = buscarEvento(array (EVENTO__A_AUTORIZADO_A_BAJARSE_PDF), $eventos);
								if (count($eventos13) == 2){
									if ($eventos13[0]["Id_Evento"] > $eventos13[1]["Id_Evento"] && $eventos13[0]["Id_Evento"]==$evento["Id_Evento"])
										$cambiar_eventos[]=array("Id" => $evento["Id_Evento"], "Codigo_Evento" => EVENTO__A_PDF_DESCARGADO);
									elseif ($eventos13[0]["Id_Evento"] < $eventos13[1]["Id_Evento"] && $eventos13[1]["Id_Evento"]==$evento["Id_Evento"])
										$cambiar_eventos[]=array("Id" => $evento["Id_Evento"], "Codigo_Evento" => EVENTO__A_PDF_DESCARGADO);
								}
							}
							
							
						} else {
							if ($estado_nuevo == 0)
								$estado_nuevo = PedidosUtils :: Determinar_Estado(EVENTO__A_AUTORIZADO_A_BAJARSE_PDF);
						}
					}

					break;
				case EVENTO__A_PDF_DESCARGADO : //(14) no deberia pasar porq el pedido esta en historico
					$vigente = 1;
					$estado_nuevo = PedidosUtils :: Determinar_Estado(EVENTO__A_PDF_DESCARGADO);
					break;
				case EVENTO__A_INTERMEDIO_POR_NT : //(15)
				case EVENTO__A_ESPERA_DE_CONF_OPERADOR : //(16)
				case EVENTO__CONFIRMADO_POR_OPERADOR : //(17)
					//no deberia pasar porq son eventos propios de CelsiusNT
					break;
				default :
					//no se. Es un evento incorrecto
					break;
			}
			if ($evento["vigente"] != $vigente && $vigente == 1)
				$vigentesATrue[] = $evento['Id_Evento'];
			elseif ($evento["vigente"] != $vigente && $vigente == 0) 
				$vigentesAFalse[] = $evento['Id_Evento'];
		} //del foreach de eventos

		if (count($vigentesATrue) > 0){
			$res = $servicesFacade->ejecutarSQL("UPDATE $tabla_eventos SET vigente = 1 WHERE Id IN (" .
			implode(",", $vigentesATrue) . ")");
			if (is_a($res, "Celsius_Exception"))
				return $res;
		}
		if (count($vigentesAFalse) > 0){
			$res = $servicesFacade->ejecutarSQL("UPDATE $tabla_eventos SET vigente = 0 WHERE Id IN (" .
			implode(",", $vigentesAFalse) . ")");
			if (is_a($res, "Celsius_Exception"))
				return $res;
		}

		if (count($cambiar_eventos) > 0){
			foreach($cambiar_eventos as $cambiar_evento){
				$res = $servicesFacade->ejecutarSQL("UPDATE $tabla_eventos SET Codigo_Evento = ".$cambiar_evento["Codigo_Evento"]." WHERE Id=".$cambiar_evento["Id"]);
				if (is_a($res, "Celsius_Exception"))
					return $res;
			}
		}
		if ($estado_nuevo == 0)
			$estado_nuevo = CalcularEstadoPedido($eventos);
		if ($tabla_pedidos == "pedidos" && ($estado_nuevo != $estado_viejo || $EnBusqueda != 0)){
			$res = $servicesFacade->ejecutarSQL("UPDATE $tabla_pedidos SET Estado = $estado_nuevo ,En_Busqueda = $EnBusqueda  WHERE Id = '$id_pedido'");
			if (is_a($res, "Celsius_Exception"))
				return $res;
		}
		if((time() - $ya) > 10){
			$ya = time();
			echo "Procesando la tabla $tabla_pedidos... <br/>";
			flush();
		}
		
	}
	mysql_free_result($resPedidos);
	$fin = microtime_float() - $inicio;
	echo "El procesamiento de la tabla $tabla_pedidos tardo $fin segundos. <br/>";
	flush();
}

if (!function_exists("microtime_float")){
	function microtime_float()
	{
	   list($useg, $seg) = explode(" ", microtime());
	   return ((float)$useg + (float)$seg);
	}
}


function buscarEvento($codigos_eventos = array(), $eventos){
	$resultado = array();
	foreach($eventos as $evento){
		if (array_search($evento["Codigo_Evento"], $codigos_eventos) !== FALSE)
			$resultado[]= $evento;
	}
	return $resultado;
}

function CalcularEstadoPedido($eventos) {
	if (count($eventos) == 0)
		return ESTADO__PENDIENTE;
	
	$estado = 0;
	foreach ($eventos as $evento) {
		$nuevoEstado = PedidosUtils :: Determinar_Estado($evento["Codigo_Evento"]);
		if ($nuevoEstado == ESTADO__CANCELADO || $nuevoEstado > $estado) {
			$estado = $nuevoEstado;
			if ($nuevoEstado == ESTADO__CANCELADO)
				return $estado;
		}
	}
	if ($estado == 0)
		return ESTADO__BUSQUEDA;
	else
		return $estado;
	
}

/**
 * Pasa los eventos de la tabla evanula cuyo pedido no esta en pedanula a la tabla de pedidos q correponde
 */
function mover_eventos_anulados() {
	global $servicesFacade;

	$res = $servicesFacade->ejecutarSQL("INSERT INTO eventos 
			(Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,
			Operador,Es_Privado,Numero_Paginas,Id_Correo,Codigo_Unidad,Id_Instancia_Celsius,Id_Pedido_Remoto,
			vigente,motivo_anulacion,fecha_anulacion,operador_anulacion,destino_remoto) 
		SELECT E.Id_Pedido,E.Codigo_Evento,E.Codigo_Pais,E.Codigo_Institucion,E.Codigo_Dependencia,E.Fecha,
			E.Observaciones,E.Operador,E.Es_Privado,E.Numero_Paginas,E.Id_Correo,E.Codigo_Unidad,
			E.Id_Instancia_Celsius,E.Id_Pedido_Remoto, 0,E.motivo_anulacion,E.fecha_anulacion,
			E.operador_anulacion,E.destino_remoto 
		FROM evanula as E INNER JOIN pedidos as P ON E.Id_Pedido = P.Id");
	if (is_a($res, "Celsius_Exception")){
		return $res;
	}
	$res = $servicesFacade->ejecutarSQL("INSERT INTO evhist 
			(Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,
			Operador,Es_Privado,Numero_Paginas,Id_Correo,Codigo_Unidad,Id_Instancia_Celsius,Id_Pedido_Remoto,
			vigente,motivo_anulacion,fecha_anulacion,operador_anulacion,destino_remoto) 
		SELECT E.Id_Pedido,E.Codigo_Evento,E.Codigo_Pais,E.Codigo_Institucion,E.Codigo_Dependencia,E.Fecha,
			E.Observaciones,E.Operador,E.Es_Privado,E.Numero_Paginas,E.Id_Correo,E.Codigo_Unidad,
			E.Id_Instancia_Celsius,E.Id_Pedido_Remoto, 0,E.motivo_anulacion,E.fecha_anulacion,
			E.operador_anulacion,E.destino_remoto 
		FROM evanula as E INNER JOIN pedhist as P ON E.Id_Pedido = P.Id");
	if (is_a($res, "Celsius_Exception")){
		return $res;
	}
	$res = $servicesFacade->ejecutarSQL("DELETE E FROM evanula as E LEFT JOIN pedanula as P ON E.Id_Pedido = P.Id WHERE isNull(P.Id)");
	if (is_a($res, "Celsius_Exception")){
		return $res;
	}
	
	return true;
}

/**
 * Actualiza los pedidos con datos 1.6 a NT.
 * 
 */
function actualizacion_pedidos_16_a_NT() {
	require_once "../common/ServicesFacade.php";
	global $servicesFacade;
	
	$res = actualizar_pedidos_eventos_16_a_nt("pedidos", "eventos");
	if(is_a($res,"Celsius_Exception"))
		return $res;
	
	$res = actualizar_pedidos_eventos_16_a_nt("pedhist", "evhist");
	if(is_a($res,"Celsius_Exception"))
		return $res;
		
	$res = actualizar_pedidos_eventos_16_a_nt("pedanula", "evanula");
	if(is_a($res,"Celsius_Exception"))
		return $res;

	$res = mover_eventos_anulados();
	if(is_a($res,"Celsius_Exception"))
		return $res;
	
	return true;
	
}

/**
 * Script sql que contiene una serie de updates sobre las tablas importadas de celsius1.6.
 * Principalmente se actualizan las columnas que se agregaron a la base de datos
 */
function actualizacion_16_a_NT($dbname16, $dbnameNT){
	global $servicesFacade;

	$res = $servicesFacade->ejecutarSQL("UPDATE evanula as EvDestino,$dbname16.EvAnula as EvOrigen SET EvDestino.fecha_anulacion=EvOrigen.Fecha_Anulacion, 
	EvDestino.motivo_anulacion=EvOrigen.Causa_Anulacion,EvDestino.operador_anulacion=EvOrigen.Operador_Anulacion
	WHERE EvDestino.Id=EvOrigen.Id");
	if(is_a($res,"Celsius_Exception"))
		return $res;
		
	$res = $servicesFacade->ejecutarSQL("UPDATE usuarios, $dbname16.Usuarios as UsOrigen SET Codigo_FormaEntrega = UsOrigen.Codigo_FormaPago;");
	if(is_a($res,"Celsius_Exception"))
		return $res;
	$res = $servicesFacade->ejecutarSQL("INSERT INTO forma_entrega SELECT * FROM $dbname16.Forma_Pago;");
	if(is_a($res,"Celsius_Exception"))
		return $res;
		
	return true;
}

global $servicesFacade;
$servicesFacade = ServicesFacade::getInstance();

?>