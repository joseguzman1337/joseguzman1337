<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class DetalleResultadoPruebaEstado{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type int
     * @access private
     */
    private $iddetalleresultadopruebaestado;  
    
    /**
     * @type int
     * @access private
     */
    private $idresultadopruebaestado;  
    
    /**
     * @type int
     * @access private
     */
    private $idasignaturaestado;  
    
    /**
     * @type int
     * @access private
     */
    private $notadetalleresultadopruebaestado;  
    
    /**
     * @type int
     * @access private
     */
    private $nivel;  
    
    /**
     * @type int
     * @access private
     */
    private $decil;  
    
    /**
     * @type int
     * @access private
     */
    private $ChequeoFacultad;  
    
    /**
     * @type int
     * @access private
     */
    private $codigoestado;
    
    public function DetalleResultadoPruebaEstado($db) {
        $this->db = $db;
    }
    
    function getIddetalleresultadopruebaestado() {
        return $this->iddetalleresultadopruebaestado;
    }

    function getIdresultadopruebaestado() {
        return $this->idresultadopruebaestado;
    }

    function getIdasignaturaestado() {
        return $this->idasignaturaestado;
    }

    function getNotadetalleresultadopruebaestado() {
        return $this->notadetalleresultadopruebaestado;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getDecil() {
        return $this->decil;
    }

    function getChequeoFacultad() {
        return $this->ChequeoFacultad;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setIddetalleresultadopruebaestado($iddetalleresultadopruebaestado) {
        $this->iddetalleresultadopruebaestado = $iddetalleresultadopruebaestado;
    }

    function setIdresultadopruebaestado($idresultadopruebaestado) {
        $this->idresultadopruebaestado = $idresultadopruebaestado;
    }

    function setIdasignaturaestado($idasignaturaestado) {
        $this->idasignaturaestado = $idasignaturaestado;
    }

    function setNotadetalleresultadopruebaestado($notadetalleresultadopruebaestado) {
        $this->notadetalleresultadopruebaestado = $notadetalleresultadopruebaestado;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setDecil($decil) {
        $this->decil = $decil;
    }

    function setChequeoFacultad($ChequeoFacultad) {
        $this->ChequeoFacultad = $ChequeoFacultad;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

        
    public function getDetallesResultadoActual($idResultadoPruebaEstadoActual){
        $query = "SELECT * FROM detalleresultadopruebaestado ".
        " WHERE idresultadopruebaestado = '".$idResultadoPruebaEstadoActual."' and codigoestado = 100";
        $datosgrabados = $this->db->Execute($query);
        
        $rows = array();
        while ($row = $datosgrabados->FetchRow()){
            $detalle = new DetalleResultadoPruebaEstado($this->db);
            $detalle->setIddetalleresultadopruebaestado($row['iddetalleresultadopruebaestado']);
            $detalle->setIdasignaturaestado($row['idasignaturaestado']);
            $detalle->setNotadetalleresultadopruebaestado($row['notadetalleresultadopruebaestado']);
            $detalle->setNivel($row['nivel']);
            $detalle->setDecil($row['decil']);
            $detalle->setChequeoFacultad($row['ChequeoFacultad']);
            $detalle->setCodigoestado($row['codigoestado']);
            $detalle->setIdresultadopruebaestado($row['idresultadopruebaestado']);
            $rows[] = $detalle;
        }
        return $rows;
    }
    
    public function desactivarActualAc($idResultadoPruebaEstadoActual){
        $query = "UPDATE detalleresultadopruebaestado SET codigoestado = 200 WHERE idresultadopruebaestado = ".$idResultadoPruebaEstadoActual;
        //d($query);
        $this->db->Execute($query); 
    }
    
    public function setResultados($respuesta, $idResultadoPruebaEstado){
        $examen = $respuesta->examen;
        //d($examen->resultado->pruebas);
        foreach($examen->resultado->pruebas as $p){
            if(!empty($p->id)){
                //d($p);
                $queryValues = array();
                $query = "INSERT INTO detalleresultadopruebaestado SET ";
                $queryValues[] = "idresultadopruebaestado = '".$idResultadoPruebaEstado."' ";
                $queryValues[] = "idasignaturaestado = '".$this->getIdAsignatura($p->id)."' ";
                $queryValues[] = "codigoestado = 100 ";
                switch($respuesta->examen->estructura){
                    case 7:
                        $queryValues[] = "decil = '".DetalleResultadoPruebaEstado::getCalificacionPercentil($p->calificacion)."' ";
                        $queryValues[] =  "notadetalleresultadopruebaestado = '".DetalleResultadoPruebaEstado::getCalificacionNormal($p->calificacion)."' ";
                        break;
                    case 6:
                        $queryValues[] = "decil = '".DetalleResultadoPruebaEstado::getCalificacionDecil($p->calificacion)."' ";
                        $queryValues[] =  "notadetalleresultadopruebaestado = '".DetalleResultadoPruebaEstado::getCalificacionNormal($p->calificacion)."' ";
                        break;
                    case 5:
                        $queryValues[] =  "notadetalleresultadopruebaestado = '".DetalleResultadoPruebaEstado::getCalificacionNormal($p->calificacion)."' ";
                        break;
                }
                $query .= implode(", ",$queryValues);
                //d($query);
                $this->db->Execute($query);
            }
        }
    }
    public static function getCalificacionNormal($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 0){
                return $c->valor;
            }
        }
    }
    public static function getCalificacionPercentil($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 1){
                return $c->valor;
            }
        }
    } 
    public static function getCalificacionDecil($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 4){
                return $c->valor;
            }
        }
    }
    public function getIdAsignatura($codigoPIR) {
        $query = "SELECT idasignaturaestado FROM asignaturaestado WHERE codigoPir = '".$codigoPIR."'";
        $datos = $this->db->Execute($query);
        $dato = $datos->FetchRow();
        return($dato['idasignaturaestado']);        
    }

}

