<?php

namespace Sala\entidadDAO;

//Author: Lina Quintero
//Fecha: 15-06-2021
//class ColaNotificacionPagoPsDAO
//Clase encargada de las consultas a la tabla ColaNotificacionPagoPSID

defined('_EXEC') or die;

class ColaNotificacionPagoPsDAO
{

    private $db;
    private $colaNotificacionPagoPs;

    public function __construct(\ColaNotificacionPagoPs $colaNotificacionPagoPs = null)
    {
        $this->colaNotificacionPagoPs = $colaNotificacionPagoPs;
        $this->setDb();
    }

    public function setDb()
    {
        $this->db = \Factory::createDbo();
    }

    //Author: Lina Quintero
    //Fecha: 15-06-2021
    //Obtiene el Id de la tabla ColaNotificacionPagoPSID por el numero de Orden
    //Parametros: $numeroordenpago: Numero de Orden a Consultar
    //Return: El Id de la Tabla ColaNotificacionPagoPSID
    public function getIdColaByOrderNumber($numeroordenpago)
    {

        $sqlgetIdCola = "SELECT  ColaNotificacionPagoPSID from ColaNotificacionPagoPS " .
            " where numeroordenpago = " . $numeroordenpago . " ";

        $executeGetIdCola = $this->db->GetRow($sqlgetIdCola);
        return $executeGetIdCola['ColaNotificacionPagoPSID'];
    }


    //Author: Lina Quintero
    //Fecha: 15-06-2021
    //Consulta la orden en la tabla ColaNotificacionPagoPS para insertar o no el registro
    //Parametros: $numeroordenpago: Numero de Orden a Consultar
    //Return: 0 si no existe registro de la orden, 1 si existe registro y esta en  0,
    //2 si el ProcesoEnvio es diferente de 0
    public function getOrderInProcess($numeroordenpago)
    {
        $sqlgetOrder = "SELECT  ProcesoEnvio from ColaNotificacionPagoPS " .
            " where numeroordenpago = " . $numeroordenpago . " ";

        $executeGetOrder = $this->db->GetRow($sqlgetOrder);

        if ($executeGetOrder['ProcesoEnvio'] == "") {
            //insertar registro en la cola
            return 0;
        } else if ($executeGetOrder['ProcesoEnvio'] == 0) {
            //Actualiza el estado de proceso de envio en el registro de la cola ya insertada
            return  1;
        } else {
            return 2;
        }
    }

    //Author: Lina Quintero
    //Fecha: 15-06-2021
    //Inserta el registro de la orden a validar su envio
    //Return: True o False segun la respuesta de la insercion
    public function save()
    {
        $query = "";
        $query .= "INSERT INTO ";

        $query .= "ColaNotificacionPagoPS SET "
            . " NumeroOrdenPago = " . $this->db->qstr($this->colaNotificacionPagoPs->getNumeroOrdenPago()) . ", "
            . " TicketID = " . $this->db->qstr($this->colaNotificacionPagoPs->getTicketId()) . ", "
            . " EstadoEnvio = " . $this->db->qstr($this->colaNotificacionPagoPs->getEstadoEnvio()) . ", "
            . " ResultadoNotificacion = " . $this->db->qstr($this->colaNotificacionPagoPs->getResultadoNotificacion()) . ", "
            . " FechaRegistro = now(),"
            . " ProcesoEnvio = " . $this->db->qstr($this->colaNotificacionPagoPs->getProcesoEnvio()) . ","
            . " ResultadoProcesoEnvio = " . $this->db->qstr($this->colaNotificacionPagoPs->getResultadoProcesoEnvio()) . "";

        $rs = $this->db->Execute($query);

        if (is_null($this->colaNotificacionPagoPs->getIdColaNotificacionPagoPS())) {
            $this->colaNotificacionPagoPs->setIdColaNotificacionPagoPS($this->db->insert_Id());
        }

        if (!$rs) {
            return false;
        }

        return true;
    }

    //Author: Lina Quintero
    //Fecha: 15-06-2021
    //Actuliza el estado de envio de la orden en la tabla ColaNotificacionPagoPS
    //Return: True o False segun la respuesta de la insercion
    public function update()
    {
        $query = "";
        $where = array();

        $query .= "UPDATE ColaNotificacionPagoPS SET "
            . " ProcesoEnvio = " . $this->db->qstr($this->colaNotificacionPagoPs->getProcesoEnvio()) . ", "
            . " ResultadoProcesoEnvio = " . $this->db->qstr($this->colaNotificacionPagoPs->getResultadoProcesoEnvio()) . "";

        $where[] = "ColaNotificacionPagoPSID = " . $this->db->qstr($this->colaNotificacionPagoPs->getIdColaNotificacionPagoPS());

        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $rs = $this->db->Execute($query);

        if (!$rs) {
            return false;
        }
        return true;
    }
}
