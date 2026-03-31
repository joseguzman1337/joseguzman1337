<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ResultadoPruebaEstado{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type int
     * @access private
     */
    private $idresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $nombreresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $numeroregistroresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $puestoresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $fecharesultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $observacionresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $PuntajeGlobal;
    
    /**
     * @type int
     * @access private
     */
    private $actualizadoPir;
    
    /**
     * @type int
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type int
     * @access private
     */
    private $idActual;
    
    function ResultadoPruebaEstado($db) {
        $this->db = $db;
    }
    
    function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    function setNumeroregistroresultadopruebaestado($numeroregistroresultadopruebaestado) {
        $this->numeroregistroresultadopruebaestado = str_replace(" ", "", $numeroregistroresultadopruebaestado);
    }
    function getIdresultadopruebaestado() {
        return $this->idresultadopruebaestado;
    }

    function getNombreresultadopruebaestado() {
        return $this->nombreresultadopruebaestado;
    }

    function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    function getNumeroregistroresultadopruebaestado() {
        return $this->numeroregistroresultadopruebaestado;
    }

    function getPuestoresultadopruebaestado() {
        return $this->puestoresultadopruebaestado;
    }

    function getFecharesultadopruebaestado() {
        return $this->fecharesultadopruebaestado;
    }

    function getObservacionresultadopruebaestado() {
        return $this->observacionresultadopruebaestado;
    }

    function getPuntajeGlobal() {
        return $this->PuntajeGlobal;
    }

    function getActualizadoPir() {
        return $this->actualizadoPir;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }
    
    public function getResultadoEsutiante(){
        $query = "SELECT * FROM resultadopruebaestado WHERE idestudiantegeneral = '".$this->idestudiantegeneral."' AND codigoestado =100 ";
        //d($query);        
        $datosgrabados = $this->db->Execute($query); 
        //$totalRows = $datosgrabados->RecordCount();
        $row = $datosgrabados->FetchRow();
        
        if(!empty($row)){
            $this->idresultadopruebaestado = $row['idresultadopruebaestado'];
            $this->nombreresultadopruebaestado = $row['nombreresultadopruebaestado'];
            $this->numeroregistroresultadopruebaestado = $row['numeroregistroresultadopruebaestado'];
            $this->puestoresultadopruebaestado = $row['puestoresultadopruebaestado'];
            $this->fecharesultadopruebaestado = $row['fecharesultadopruebaestado'];
            $this->observacionresultadopruebaestado = $row['observacionresultadopruebaestado'];
            $this->PuntajeGlobal = $row['PuntajeGlobal'];
            $this->actualizadoPir = $row['actualizadoPir'];
            $this->codigoestado = $row['codigoestado']; 
        }
        //d($this);
        
    }
    
    public function validarIdestudiantegeneralAC(){
        $query = "SELECT idestudiantegeneral FROM resultadopruebaestado WHERE  numeroregistroresultadopruebaestado = '".$this->numeroregistroresultadopruebaestado."'"
                . " AND idestudiantegeneral <> '".$this->idestudiantegeneral."' "
                . " AND actualizadoPir = '1' "
                . " AND codigoestado = 100 ";
        //d($query);        
        $datosgrabados = $this->db->Execute($query); 
        $row = $datosgrabados->FetchRow();
        
        if((!empty($row['idestudiantegeneral']))&&($row['idestudiantegeneral']!=$this->idestudiantegeneral)){
            return false;
        }else{
            return true;
        } 
        
    }
    
    public function desactivarActualAc(){
        $query = "UPDATE resultadopruebaestado SET codigoestado = 200 WHERE idresultadopruebaestado = ".$this->idresultadopruebaestado;
        //d($query);
        $this->db->Execute($query);
    }
    
    public function desactivarAcsEstudiante(){
        if(!empty($this->idestudiantegeneral)){
            $query = "UPDATE resultadopruebaestado SET codigoestado = 200 WHERE idestudiantegeneral = ".$this->idestudiantegeneral;
            //d($query);
            $this->db->Execute($query);
        }
    }
    
    public function getAcutalid(){
        
        $query = "SELECT idresultadopruebaestado "
                . "FROM resultadopruebaestado WHERE "
                . "idestudiantegeneral = '".$this->idestudiantegeneral."' "
                . "AND numeroregistroresultadopruebaestado='".$this->numeroregistroresultadopruebaestado."' "
                . "AND actualizadoPir = 1 "
                . "AND codigoestado=100 ";
        //d($query);
        $datos = $this->db->Execute($query);
        $dato = $datos->FetchRow();
        $idAcutal = $dato['idresultadopruebaestado'];
        
        return $idAcutal;
    }
    
    public function setActualAc($periodo){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/TipoPruebaEstado.php');
        //d($db);
        //ddd($this);
        $TipoPruebaEstado = new TipoPruebaEstado($this->db);
        $TipoPruebaEstado->setCodigoPeriodoMIN($periodo);
        $TipoPruebaEstado->consultarEstructuraPorPeriodo();
        //d($TipoPruebaEstado);
        //return $TipoPruebaEstado->getNombreEstructura();
        
        $idActual = $this->idActual;
        //d($this);
        $where = "";
        $idresultadopruebaestado = $this->getIdresultadopruebaestado();
        if(empty($idresultadopruebaestado)){
            $query = "INSERT INTO resultadopruebaestado ";
        }else{
            $query = "UPDATE resultadopruebaestado ";
            $where = " WHERE idresultadopruebaestado = '".$this->getIdresultadopruebaestado()."' ";
        }
        
        $query.= "SET nombreresultadopruebaestado = '".$this->nombreresultadopruebaestado."', "
                . "idestudiantegeneral = '".$this->idestudiantegeneral."', "
                . "numeroregistroresultadopruebaestado='".$this->numeroregistroresultadopruebaestado."', "
                . "puestoresultadopruebaestado='".$this->puestoresultadopruebaestado."', "
                . "fecharesultadopruebaestado='".$this->fecharesultadopruebaestado."', "
                . "observacionresultadopruebaestado='".$this->observacionresultadopruebaestado."', "
                . "PuntajeGlobal='".$this->PuntajeGlobal."', "
                . "actualizadoPir='".$this->actualizadoPir."', "
                . "codigoestado='".$this->codigoestado."' "
                .$where;
        //d($query);
        $this->db->Execute($query);
        
        $this->idresultadopruebaestado = $this->getAcutalid();
        
        $query = "SELECT id FROM estructuraDelResultado  "
                . "WHERE idResultadoPruebaEstado = '".$this->idresultadopruebaestado."' "
                . "AND idEstructuraPruebaEstado = '".$TipoPruebaEstado->getIdTipoPruebaEstado()."' "
                . "AND codigoPeriodo = '".$periodo."' "
                . "AND codigoEstado = '1' ";
        $datos = $this->db->Execute($query);
        $row = $datos->FetchRow();
        //d($row);
        if(empty($row['id'])){
            $query = "INSERT INTO estructuraDelResultado "
                    . "SET idResultadoPruebaEstado = '".$this->idresultadopruebaestado."', "
                    . "idEstructuraPruebaEstado = '".$TipoPruebaEstado->getIdTipoPruebaEstado()."', "
                    . "codigoPeriodo = '".$periodo."', "
                    . "codigoEstado = '1' ";
            //d($query);
            $this->db->Execute($query);            
        }
    }
    
    
    public function setResultados($respuesta){
        //ddd($respuesta);
        $resultado = $respuesta->getResultadosPIR();
        //d($resultado);
        $calificacion = $resultado->examen->resultado->calificacion;
        //d($calificacion );
        $this->idActual = $this->idresultadopruebaestado;
        //d($this);
        
        $puntajeGlobalActual = $this->getPuntajeGlobal();
        $puestoresultadopruebaestadoActual = $this->getPuestoresultadopruebaestado();
        
        //d($puntajeGlobalActual);
        //d($puestoresultadopruebaestadoActual);
        if(!empty($puntajeGlobalActual)||!empty($puestoresultadopruebaestadoActual)){
            $this->idresultadopruebaestado = null;
        }
        
        $this->nombreresultadopruebaestado = "SABER 11 - PIR"; 
        $this->numeroregistroresultadopruebaestado = $resultado->examen->nui; 
        $this->puestoresultadopruebaestado = null; 
        $this->observacionresultadopruebaestado = @$resultado->examen->observaciones;
        $this->PuntajeGlobal = null;
        $this->actualizadoPir = 1;
        $this->codigoestado = 100;
        //d($resultado->examen->estructura);
        switch($resultado->examen->estructura){
            case 7:
                $this->PuntajeGlobal = ResultadoPruebaEstado::getCalificacionPuntajeGlobal($calificacion);
                $this->puestoresultadopruebaestado = ResultadoPruebaEstado::getCalificacionPercentilGlobal($calificacion);
                break;
            case 6:
                $this->PuntajeGlobal = ResultadoPruebaEstado::getCalificacionPuntajeGlobal($calificacion);
                $this->puestoresultadopruebaestado = ResultadoPruebaEstado::getCalificacionPuestoGlobal($calificacion);
                break;
            case 5:
                $this->puestoresultadopruebaestado = ResultadoPruebaEstado::getCalificacionPuestoGlobal($calificacion);
                break;
        }/**/
        //d($this);
        $this->setActualAc($respuesta->getPeriodo());
        //d($calificacion);
    }
    
    public function setResultadosEnBlanco(){
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/TipoPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        
        $periodo = ControlConsultarPIR::abstraerPeriodo($this->getNumeroregistroresultadopruebaestado());
        
        $TipoPruebaEstado = new TipoPruebaEstado($this->db);
        $TipoPruebaEstado->setCodigoPeriodoMIN($periodo);
        $TipoPruebaEstado->consultarEstructuraPorPeriodo();
        //d($TipoPruebaEstado); 
        
        $query = "INSERT INTO resultadopruebaestado "
                . "SET nombreresultadopruebaestado = '', "
                . "idestudiantegeneral = '".$this->idestudiantegeneral."', "
                . "numeroregistroresultadopruebaestado='".$this->numeroregistroresultadopruebaestado."', "
                . "puestoresultadopruebaestado='0', "
                . "fecharesultadopruebaestado='', "
                . "observacionresultadopruebaestado='', "
                . "PuntajeGlobal='0', "
                . "actualizadoPir='0', "
                . "codigoestado='100' ";
        //d($query);
        $this->db->Execute($query);
        
        $this->idresultadopruebaestado = $this->getAcutalid();
        
        $query = "SELECT id FROM estructuraDelResultado  "
                . "WHERE idResultadoPruebaEstado = '".$this->idresultadopruebaestado."' "
                . "AND idEstructuraPruebaEstado = '".$TipoPruebaEstado->getIdTipoPruebaEstado()."' "
                . "AND codigoPeriodo = '".$periodo."' "
                . "AND codigoEstado = '1' ";
        //d($query);
        $datos = $this->db->Execute($query);
        $row = $datos->FetchRow();
        //d($row);
        if(empty($row['id'])){
            $query = "INSERT INTO estructuraDelResultado "
                    . "SET idResultadoPruebaEstado = '".$this->idresultadopruebaestado."', "
                    . "idEstructuraPruebaEstado = '".$TipoPruebaEstado->getIdTipoPruebaEstado()."', "
                    . "codigoPeriodo = '".$periodo."', "
                    . "codigoEstado = '1' ";
            //d($query);
            $this->db->Execute($query);            
        }
    }
    
    public static function getCalificacionPuntajeGlobal($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 0){
                return $c->valor;
            }
        }
    }
    
    public static function getCalificacionPercentilGlobal($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 1){
                return $c->valor;
            }
        }
    }
    
    public static function getCalificacionPuestoGlobal($calificacion){
        foreach($calificacion as $c){
            if($c->tipo == 6){
                return $c->valor;
            }
        }
    }

}
