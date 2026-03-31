<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class EstudiantesActualizar{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type int
     * @access private
     */
    private $idEstudianteGeneral;
    
    /**
     * @type String
     * @access private
     */
    private $numeroregistroresultadopruebaestado;
    
    /**
     * @type int
     * @access private
     */
    private $actualizadoPir;
    
    /**
     * @type String
     * @access private
     */
    private $tipodocumento;
    
    /**
     * @type int
     * @access private
     */
    private $numerodocumento;
    
    
    public function EstudiantesActualizar($db) {
        $this->db = $db;
    }
    
    public function getIdEstudianteGeneral() {
        return $this->idEstudianteGeneral;
    }

    public function getNumeroregistroresultadopruebaestado() {
        return $this->numeroregistroresultadopruebaestado;
    }

    public function getActualizadoPir() {
        return $this->actualizadoPir;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }
    
    public function setIdEstudianteGeneral($idEstudianteGeneral) {
        $this->idEstudianteGeneral = $idEstudianteGeneral;
    }

    public function setNumeroregistroresultadopruebaestado($numeroregistroresultadopruebaestado) {
        $this->numeroregistroresultadopruebaestado = str_replace(" ", "", $numeroregistroresultadopruebaestado);
    }

    public function setActualizadoPir($actualizadoPir) {
        $this->actualizadoPir = $actualizadoPir;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    
    public function getListaPreinscritos(){
        $listaReturn = array();
        $Periodo = new Periodo($this->db);
        $listaPeriodosActivos = $Periodo->getPeriodosActivos();
        $periodos = array();
        $whereBase = array();
        foreach($listaPeriodosActivos as $p){
            $periodos[] = $p->getCodigoPeriodo();
        }
        
        $queryBase = "SELECT DISTINCT rpe.numeroregistroresultadopruebaestado,  "
                . "rpe.actualizadoPir, i.idestudiantegeneral , "
                . "ed.numerodocumento, d.nombrecortodocumento "
                . "FROM resultadopruebaestado rpe "
                . "INNER JOIN inscripcion i ON (i.idestudiantegeneral = rpe.idestudiantegeneral ) "
                . "INNER JOIN estudiantegeneral eg ON (eg.idestudiantegeneral = i.idestudiantegeneral) "
                . "INNER JOIN estudiantedocumento ed ON (ed.idestudiantegeneral = eg.idestudiantegeneral AND ed.fechavencimientoestudiantedocumento > NOW() ) "
                . "INNER JOIN documento d ON (d.tipodocumento = ed.tipodocumento) ";
        
        //Primer query: Se consultan todos los registros que no tienen informacion en la tabla DocumentoPresentacionPruebaEstado
        //esto significa que el registro se hizo de la antigua forma, y que se NO registraron referencias en las tablas del modelo PIR
        $query = $queryBase
                . "LEFT JOIN DocumentoPresentacionPruebaEstado dppe ON (dppe.idEstudianteDocumento = ed.idestudiantedocumento AND dppe.idResultadoPruebaEstado = rpe.idresultadopruebaestado) ";
        
        if(!empty($periodos)){
            $whereBase[] = "i.codigoperiodo IN (".implode(",",$periodos).") ";
        }
        $whereBase[] = "i.codigomodalidadacademica IN (200,400,800) ";
        $whereBase[] = "i.codigosituacioncarreraestudiante IN (106,107,108,110,111,114,115,200,300,301,302) ";
        $whereBase[] = "(rpe.actualizadoPir = 0 OR rpe.actualizadoPir IS NULL) ";
        $whereBase[] = "rpe.codigoestado = 100 ";
        
        $where = $whereBase;
        $where[] = "dppe.idEstudianteDocumento IS NULL ";
        $where[] = "dppe.idResultadoPruebaEstado IS NULL ";
        
        $query .= "WHERE ".implode(" AND ",$where);
        //$query .= "LIMIT 0,100 ";//temporal para pruebas
        $datos = $this->db->Execute($query);
        
        while($e = $datos->FetchRow()){
            $EstudiantesActualizar = null;
            if(!empty($e)){
                $EstudiantesActualizar = new EstudiantesActualizar(null);
                $EstudiantesActualizar->setNumeroregistroresultadopruebaestado($e['numeroregistroresultadopruebaestado']);
                $EstudiantesActualizar->setActualizadoPir($e['actualizadoPir']);
                $EstudiantesActualizar->setIdEstudianteGeneral($e['idestudiantegeneral']);
                $EstudiantesActualizar->setNumerodocumento($e['numerodocumento']);
                $EstudiantesActualizar->setTipodocumento($e['nombrecortodocumento']);
                
                $listaReturn[] = $EstudiantesActualizar;
            }
        }
        
        //Segundo query: Se consultan todos los registros que SI tienen informacion en la tabla DocumentoPresentacionPruebaEstado
        //esto significa que el registro se hizo de la nueva forma, y que se registraron referencias en las tablas del modelo PIR
        $query = $queryBase
                . "INNER JOIN DocumentoPresentacionPruebaEstado dppe ON (dppe.idEstudianteDocumento = ed.idestudiantedocumento AND dppe.idResultadoPruebaEstado = rpe.idresultadopruebaestado) ";
        $where = $whereBase;
        $query .= "WHERE ".implode(" AND ",$where);
        //$query .= "LIMIT 0,100 ";//temporal para pruebas
        $datos = $this->db->Execute($query);
        
        while($e = $datos->FetchRow()){
            $EstudiantesActualizar = null;
            if(!empty($e)){
                $EstudiantesActualizar = new EstudiantesActualizar(null);
                $EstudiantesActualizar->setNumeroregistroresultadopruebaestado($e['numeroregistroresultadopruebaestado']);
                $EstudiantesActualizar->setActualizadoPir($e['actualizadoPir']);
                $EstudiantesActualizar->setIdEstudianteGeneral($e['idestudiantegeneral']);
                $EstudiantesActualizar->setNumerodocumento($e['numerodocumento']);
                $EstudiantesActualizar->setTipodocumento($e['nombrecortodocumento']);
                
                $listaReturn[] = $EstudiantesActualizar;
            }
        }
        return($listaReturn);
    }

    
    public function getListaInscritos(){
        $listaReturn = array();
        
        $Periodo = new Periodo($this->db);
        $listaPeriodosActivos = $Periodo->getPeriodosActivos();
        $periodos = array();
        $whereBase = array();
        foreach($listaPeriodosActivos as $p){
            $periodos[] = $p->getCodigoPeriodo();
        }
        
        $queryBase = "SELECT DISTINCT rpe.numeroregistroresultadopruebaestado, rpe.actualizadoPir, "
                . "i.idestudiantegeneral, ed.numerodocumento, d.nombrecortodocumento "
                . "FROM resultadopruebaestado rpe "
                . "INNER JOIN inscripcion i ON (i.idestudiantegeneral = rpe.idestudiantegeneral ) "
                . "INNER JOIN estudiantegeneral eg ON (eg.idestudiantegeneral = i.idestudiantegeneral) "
                . "INNER JOIN estudiantedocumento ed ON (ed.idestudiantegeneral = eg.idestudiantegeneral AND ed.fechavencimientoestudiantedocumento > NOW() ) "
                . "INNER JOIN documento d ON (d.tipodocumento = ed.tipodocumento) ";
        
        //Primer query: Se consultan todos los registros que no tienen informacion en la tabla DocumentoPresentacionPruebaEstado
        //esto significa que el registro se hizo de la antigua forma, y que se NO registraron referencias en las tablas del modelo PIR
        $query = $queryBase
                ."LEFT JOIN DocumentoPresentacionPruebaEstado dppe ON (dppe.idEstudianteDocumento = ed.idestudiantedocumento AND dppe.idResultadoPruebaEstado = rpe.idresultadopruebaestado) ";
        
        if(!empty($periodos)){
            $whereBase[] = "i.codigoperiodo IN (".implode(",",$periodos).") ";
        }
        $whereBase[] = "i.codigomodalidadacademica IN (200,400,800) ";
        $whereBase[] = "i.codigosituacioncarreraestudiante IN (106,107,108,110,111,114,115,200,300,301,302) ";
        $whereBase[] = "(rpe.actualizadoPir = 0 OR rpe.actualizadoPir IS NULL) ";
        $whereBase[] = "rpe.codigoestado = 100 ";
        
        $where = $whereBase;
        $where[] = "dppe.idEstudianteDocumento IS NULL ";
        $where[] = "dppe.idResultadoPruebaEstado IS NULL ";
        
        $query .= "WHERE ".implode(" AND ",$where);
        
        //d($query);
        //$query .= "LIMIT 0,100 ";//temporal para pruebas
        $datos = $this->db->Execute($query);
        
        while($e = $datos->FetchRow()){
            $EstudiantesActualizar = null;
            if(!empty($e)){
                $EstudiantesActualizar = new EstudiantesActualizar(null);
                $EstudiantesActualizar->setNumeroregistroresultadopruebaestado($e['numeroregistroresultadopruebaestado']);
                $EstudiantesActualizar->setActualizadoPir($e['actualizadoPir']);
                $EstudiantesActualizar->setIdEstudianteGeneral($e['idestudiantegeneral']);
                $EstudiantesActualizar->setNumerodocumento($e['numerodocumento']);
                $EstudiantesActualizar->setTipodocumento($e['nombrecortodocumento']);
                
                $listaReturn[] = $EstudiantesActualizar;
            }
        }
        
        //Segundo query: Se consultan todos los registros que SI tienen informacion en la tabla DocumentoPresentacionPruebaEstado
        //esto significa que el registro se hizo de la nueva forma, y que se registraron referencias en las tablas del modelo PIR
        $query = $queryBase
                . "INNER JOIN DocumentoPresentacionPruebaEstado dppe ON (dppe.idEstudianteDocumento = ed.idestudiantedocumento AND dppe.idResultadoPruebaEstado = rpe.idresultadopruebaestado) ";
        $where = $whereBase;
        $query .= "WHERE ".implode(" AND ",$where);
        ////$query .= "LIMIT 0,100 ";//temporal para pruebas
        
        $datos = $this->db->Execute($query);
        
        while($e = $datos->FetchRow()){
            $EstudiantesActualizar = null;
            if(!empty($e)){
                $EstudiantesActualizar = new EstudiantesActualizar(null);
                $EstudiantesActualizar->setNumeroregistroresultadopruebaestado($e['numeroregistroresultadopruebaestado']);
                $EstudiantesActualizar->setActualizadoPir($e['actualizadoPir']);
                $EstudiantesActualizar->setIdEstudianteGeneral($e['idestudiantegeneral']);
                $EstudiantesActualizar->setNumerodocumento($e['numerodocumento']);
                $EstudiantesActualizar->setTipodocumento($e['nombrecortodocumento']);
                
                $listaReturn[] = $EstudiantesActualizar;
            }
        }
        return($listaReturn);        
    }
}
