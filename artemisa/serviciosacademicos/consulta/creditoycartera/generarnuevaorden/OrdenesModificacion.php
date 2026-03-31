<?php

class OrdenesModificacion{
    public function ordenPago($db, $numeroorden){
        $query_selordenpago = "SELECT numeroordenpago, codigoestudiante, fechaordenpago, idprematricula, ".
            " fechaentregaordenpago, codigoperiodo, codigoestadoordenpago, ".
            " codigoimprimeordenpago, observacionordenpago,codigocopiaordenpago, ".
            " idsubperiodo FROM ordenpago WHERE numeroordenpago = $numeroorden";
        $rowordenpago = $db->GetRow($query_selordenpago);
        return $rowordenpago;
    }

    public function detallesOrdenpago($db, $numeroorden){
        $query_seldetalleordenpago = "SELECT numeroordenpago, codigoconcepto, valorconcepto, codigotipodetalleordenpago ".
            " FROM detalleordenpago where numeroordenpago = '$numeroorden'";
        $rows_seldetalleordenpago = $db->GetAll($query_seldetalleordenpago);
        return $rows_seldetalleordenpago;
    }

    public function fechaOrden($db, $numeroorden){
        $query_selfechaordenpago = "SELECT numeroordenpago, fechaordenpago, porcentajefechaordenpago, " .
        " valorfechaordenpago FROM fechaordenpago where numeroordenpago = '$numeroorden'";
        $rows_selfechaordenpago = $db->GetAll($query_selfechaordenpago);
        return $rows_selfechaordenpago;

    }

    public function costoBeneficio($db, $codigoestudiante){
        $query_tipocosto = "select c.codigotipocosto, c.codigocentrobeneficio, c.codigomodalidadacademica ".
            " from carrera c, estudiante e where c.codigocarrera = e.codigocarrera ".
            " and e.codigocarrera = c.codigocarrera and e.codigoestudiante = '$codigoestudiante'";
        $tipocosto = $db->GetRow($query_tipocosto);

        return $tipocosto;
    }

    public function updateorden($db, $numeroorden, $estado){
        $query_updimpresion = "UPDATE ordenpago SET codigoestadoordenpago = '$estado' ".
        " WHERE numeroordenpago = '$numeroorden'";
        $db->execute($query_updimpresion);
    }

    public function updateDetallePrematricula($db, $numeroordenpago, $numeroordenpagoini){
        $query_updfechaordenpago = "UPDATE detalleprematricula SET numeroordenpago = '$numeroordenpago' ".
        " WHERE numeroordenpago = '$numeroordenpagoini'";
        $db->execute($query_updfechaordenpago);
    }

    public function updateFechaOrden($db, $total, $numeroordenpago, $porcentaje){
        $query_updfecha = "UPDATE fechaordenpago SET valorfechaordenpago = '$total' ".
        " WHERE numeroordenpago = '".$numeroordenpago."' and porcentajefechaordenpago = '".$porcentaje."'";
        $db->execute($query_updfecha);
    }

    public function usuario($db, $usuario){
        $query_id = "select idusuario from usuario where usuario = '$usuario'";
        $row_id = $db->GetRow($query_id);
        $idusuario = $row_id['idusuario'];
        return $idusuario;
    }

    public function logordenpago($db, $numeroorden, $idusuario, $observacion){
        $query_inslogordenpago = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, ".
        " observacionlogordenpago, numeroordenpago, idusuario, ip) ".
        " VALUES(0, now(), '$observacion', '$numeroorden', '$idusuario', '".tomarip()."')";
        $db->Execute($query_inslogordenpago);
    }

    public function crearOrden($db, $datos){
        $query_insordenpago = "INSERT INTO ordenpago(numeroordenpago, codigoestudiante, fechaordenpago, ".
        " idprematricula, fechaentregaordenpago, codigoperiodo, codigoestadoordenpago, codigoimprimeordenpago, ".
        " observacionordenpago, codigocopiaordenpago, documentosapordenpago, idsubperiodo, idsubperiododestino, ".
        " documentocuentaxcobrarsap, documentocuentacompensacionsap, fechapagosapordenpago) ".
        " VALUES('".$datos['numeroorden']."','".$datos['codigoestudiante']."','".$datos['fecha']."','".
        $datos['prematricula']."','".$datos['fechaentregaordenpago']."','".$datos['periodo']."','".
        $datos['estadoordenpago']."','".$datos['imprimeorden']."','".$datos['observacionordenpago']."','".
        $datos['codigocopiaordenpago']."', '".$datos['documentosapordenpago']."', '".$datos['idsubperiodo']."', '".
        $datos['idsubperiododestino']."', '', '', '".$datos['fechapagosapordenpago']."')";
        $db->execute($query_insordenpago);
    }


    public function crearDetalleOrden($db, $datos){
        $query_insdetalleordenpago = "INSERT INTO detalleordenpago(numeroordenpago, codigoconcepto, " .
        "cantidaddetalleordenpago,valorconcepto, codigotipodetalleordenpago) " .
        " VALUES('".$datos['numeroordenpago']."', '" . $datos['codigoconcepto'] . "', '" . $datos['cantidaddetalleordenpago'] . "', '" .
        $datos['valorconcepto'] . "', '" . $datos['codigotipodetalle'] . "')";
        $db->execute($query_insdetalleordenpago);
    }

    public function crearFechaOrden($db, $datos){
        $query_insfechaordenpago = "INSERT INTO fechaordenpago(numeroordenpago, fechaordenpago, " .
        " porcentajefechaordenpago, valorfechaordenpago) " .
        " VALUES('".$datos['numeroordenpago']."', '".$datos['fechaordenpago']."', '".
            $datos['porcentajefechaordenpago']."', '".$datos['valorfechaordenpago']. "')";
        $db->execute($query_insfechaordenpago);
    }

    public function eliminarDetalle($db, $numeroorden, $condicion= null){
        $query_deldvd = "delete from detalleordenpago where numeroordenpago = '$numeroorden' ".
        " $condicion";
        $db->execute($query_deldvd);
    }

}//class