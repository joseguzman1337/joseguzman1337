<?php

defined('_EXEC') or die;

//Author: Leonardo Rubio
//Fecha: 15-06-2021
//class ColaNotificacionPagoPs
//Clase encargada del mapeo de los campos de la tabla ColaNotificacionPagoPSID
class ColaNotificacionPagoPs implements Entidad
{

    private $db;
    private $idColaNotificacionPagoPS;
    private $numeroOrdenPago;
    private $ticketId;
    private $estadoEnvio;
    private $resultadoNotificacion;
    private $fechaRegistro;
    private $procesoEnvio;
    private $resultadoProcesoEnvio;

    /**
     * ColaNotificacionPagoPs constructor.
     */
    public function __construct()
    {
    }

    public function setDb()
    {
        $this->db = Factory::createDbo();
    }

    public function getIdColaNotificacionPagoPS()
    {
        return $this->idColaNotificacionPagoPS;
    }
    public function getNumeroOrdenPago()
    {
        return $this->numeroOrdenPago;
    }
    public function getTicketId()
    {
        return $this->ticketId;
    }
    public function getEstadoEnvio()
    {
        return $this->estadoEnvio;
    }
    public function getResultadoNotificacion()
    {
        return $this->resultadoNotificacion;
    }
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }
    public function getProcesoEnvio()
    {
        return $this->procesoEnvio;
    }
    public function getResultadoProcesoEnvio()
    {
        return $this->resultadoProcesoEnvio;
    }

    public function setIdColaNotificacionPagoPS($idColaNotificacionPagoPS)
    {
        return $this->idColaNotificacionPagoPS = $idColaNotificacionPagoPS;
    }
    public function setNumeroOrdenPago($numeroOrdenPago)
    {
        return $this->numeroOrdenPago = $numeroOrdenPago;
    }
    public function setTicketId($ticketId)
    {
        return $this->ticketId = $ticketId;
    }
    public function setEstadoEnvio($estadoEnvio)
    {
        return $this->estadoEnvio = $estadoEnvio;
    }
    public function setResultadoNotificacion($resultadoNotificacion)
    {
        return $this->resultadoNotificacion = $resultadoNotificacion;
    }
    public function setFechaRegistro($fechaRegistro)
    {
        return $this->fechaRegistro = $fechaRegistro;
    }
    public function setProcesoEnvio($procesoEnvio)
    {
        return $this->procesoEnvio = $procesoEnvio;
    }
    public function setResultadoProcesoEnvio($resultadoProcesoEnvio)
    {
        return $this->resultadoProcesoEnvio = $resultadoProcesoEnvio;
    }


    public function getById()
    {
        if (!empty($this->idColaNotificacionPagoPS)) {
            $query = "SELECT * "
                . "FROM ColaNotificacionPagoPS"
                . " WHERE ColaNotificacionPagoPSID = " . $this->db->qstr($this->idColaNotificacionPagoPS);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->numeroOrdenPago       = $d['NumeroOrdenPago'];
                $this->ticketId              = $d['TicketID'];
                $this->estadoEnvio           = $d['EstadoEnvio'];
                $this->resultadoNotificacion = $d['ResultadoNotificacion'];
                $this->fechaRegistro         = $d['FechaRegistro'];
                $this->procesoEnvio          = $d['ProcesoEnvio'];
                $this->resultadoProcesoEnvio = $d['ResultadoProcesoEnvio'];
            }
        }
    }

    public function getIdByOrdenNumber()
    {
        if (!empty($this->numeroOrdenPago)) {
            $query = "SELECT * "
                . "FROM ColaNotificacionPagoPS"
                . " WHERE NumeroOrdenPago = " . $this->db->qstr($this->numeroOrdenPago);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if (!empty($d)) {
                $this->idColaNotificacionPagoPS = $d['idColaNotificacionPagoPS'];
                $this->ticketId              = $d['TicketID'];
                $this->estadoEnvio           = $d['EstadoEnvio'];
                $this->resultadoNotificacion = $d['ResultadoNotificacion'];
                $this->fechaRegistro         = $d['FechaRegistro'];
                $this->procesoEnvio          = $d['ProcesoEnvio'];
                $this->resultadoProcesoEnvio = $d['ResultadoProcesoEnvio'];
            }
        }
    }


    public static function getList($where = null)
    {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
            . "FROM ColaNotificacionPagoPS "
            . "WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $datos = $db->Execute($query);

        while ($d = $datos->FetchRow()) {
            $ColaNotificacion = new ColaNotificacionPagoPs();
            $ColaNotificacion->idColaNotificacionPagoPS($d['idColaNotificacionPagoPS']);
            $ColaNotificacion->numeroOrdenPago($d['NumeroOrdenPago']);
            $ColaNotificacion->ticketId($d['TicketID']);
            $ColaNotificacion->estadoEnvio($d['EstadoEnvio']);
            $ColaNotificacion->resultadoNotificacion($d['ResultadoNotificacion']);
            $ColaNotificacion->fechaRegistro($d['FechaRegistro']);
            $return[] = $ColaNotificacion;
            unset($ColaNotificacion);
        }
        return $return;
    }
}
