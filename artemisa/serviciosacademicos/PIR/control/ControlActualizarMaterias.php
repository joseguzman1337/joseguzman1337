<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
require_once (PATH_ROOT.'/assets/lib/CurlRestFul.php');
require_once (PATH_ROOT.'/serviciosacademicos/PIR/config/Configuration.php');

/**
 * @modified Andres Aroza <arizaandres@unbosque.edu.do>
 * Se agrega el uso de namespace para evitar conflictos con el archivo de configuracion 
 * generla de salaV1.0
 * @since Septiembre 10, 2018
 */
use \PIR\config\Configuration;
class ControlActualizarMaterias{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type array de pruebas
     * @access private
     */
    private $pruebas;
    
    /**
     * @type String
     * @access private
     */
    private $maestroMaterias;
    
    function ControlActualizarMaterias($db, $pruebas = null) {
        $this->db = $db; 
        $this->pruebas = $pruebas;
    } 
    
    public function getMaestroMaterias(){
        $url = Configuration::$baseCurl . Configuration::$pathSubjects;
        
        $MateriasCurlRestFul = new CurlRestFul( $url, '', "application/json", "application/json" );
        //$AccesCurlRestFul->setInit();
        $MateriasCurlRestFul->setInit();
        $this->maestroMaterias = $MateriasCurlRestFul->getResult();
        //d($this->maestroMaterias);
    }
    
    public function getMateriaNombre($idMateria, $isIdAsignatura = false){
        //ddd($idMateria);
        if($isIdAsignatura){ 
            return ($this->getMateriaNombreById($idMateria));
        }else{
            foreach($this->maestroMaterias as $m){ 
                if($m->id == $idMateria){
                    return $m->descripcion;
                }
            }
        }
        return false;
    }
    
    public function getMateriaNombreById($id){
        $query = "SELECT nombreasignaturaestado "
                . "FROM asignaturaestado "
                . "WHERE idasignaturaestado = '".$id."' ";
        //d($query);
        $datos = $this->db->Execute($query);
        $row = $datos->FetchRow();
        return $row['nombreasignaturaestado'];
    }
    
    public function actualizaMaterias($estructura){
        foreach($this->pruebas as $p){
            if(!empty($p->id)){
                if(!$this->existeMateria($p->id)){
                    $this->registrarMateria($p->id,$estructura);
                }
                $idAsignatura = $this->existeMateria($p->id);
                //d($p->id); d($idAsignatura); d($estructura);
                $this->asociarEstructura($idAsignatura, $estructura);
                $this->asociarCuentaProcesoAdmicion($idAsignatura, 2);
                $this->asociarCuentaCompetenciaBasica($idAsignatura, 2);
            }
        }
    }

    public function existeMateria($idMateriaPIR){ 
        $query = "SELECT idasignaturaestado "
                . "FROM asignaturaestado "
                . "WHERE codigoPir ='".$idMateriaPIR."'";
        //ddd($query);
        $resultado = $this->db->Execute($query);
        //ddd($resultado);
        if(empty($resultado)){
            return false;
        }else{
            $r = $resultado->FetchRow();
            return $r["idasignaturaestado"];
        }
    }
    
    public function registrarMateria($idMateriaPIR,$estructura){
        
        $query = "INSERT INTO asignaturaestado SET "
                . "nombreasignaturaestado = '".$this->getMateriaNombre($idMateriaPIR)."', "
                . "puntajeminimoasignaturaestado = '60', "
                . "puntajemaximoasignaturaestado = '100', "
                . "codigoPir = '".$idMateriaPIR."', "
                . "codigoestado = 100 ";
        $this->db->Execute($query);
        
        $idAsignatura = $this->existeMateria($idMateriaPIR);
        
        $this->asociarEstructura($idAsignatura, $estructura);
        
        $this->asociarCuentaProcesoAdmicion($idAsignatura, 2);
        
        $this->asociarCuentaCompetenciaBasica($idAsignatura, 2);
    }
    
    public function getIdEstructura($estructura){
        $query = "SELECT * FROM TipoPruebaEstado WHERE nombre = '".$estructura."' AND codigoEstado = 1";
        $tipoPruebas = $this->db->Execute($query);
        $tipoPrueba = $tipoPruebas->FetchRow();
        return $tipoPrueba['id'];
    }
    
    public function asociarCuentaProcesoAdmicion($idAsignatura, $idCuentaProceso){
        $query = "SELECT id FROM AsignaturaCuentaProcesoAdmicion WHERE "
                . "idAsignaturaPruebaEstado = '".$idAsignatura."' "
                . "AND idCuentaProcesoAdmisiones = '".$idCuentaProceso."' "
                . "AND codigoEstado = 1";
        $datos = $this->db->Execute($query);
        $id = $datos->FetchRow();
        
        if(empty($id)){ 
            $query = "INSERT INTO AsignaturaCuentaProcesoAdmicion SET "
                    . "idAsignaturaPruebaEstado = '".$idAsignatura."', "
                    . "idCuentaProcesoAdmisiones = '".$idCuentaProceso."', "
                    . "codigoEstado = 1";
            $this->db->Execute($query);
        }
    }
    
    public function asociarCuentaCompetenciaBasica($idAsignatura, $idCuentaCompetencia){
        $query = "SELECT id FROM AsignaturaCuentaCompetenciaBasica WHERE "
                . "idAsignaturaPruebaEstado = '".$idAsignatura."' "
                . "AND idCuentaCompetenciaBasica = '".$idCuentaCompetencia."' "
                . "AND codigoEstado = 1";
        $datos = $this->db->Execute($query);
        $id = $datos->FetchRow();
        
        if(empty($id)){ 
            $query = "INSERT INTO AsignaturaCuentaCompetenciaBasica SET "
                    . "idAsignaturaPruebaEstado = '".$idAsignatura."', "
                    . "idCuentaCompetenciaBasica = '".$idCuentaCompetencia."', "
                    . "codigoEstado = 1";
            $this->db->Execute($query);
        }
    }
    
    public function asociarEstructura($idAsignatura, $estructura){
        $idTipoPrueba = $this->getIdEstructura($estructura);
        //ddd($tipoPrueba);
        
        $query = "SELECT id FROM AsignaturaTipoPruebaEstado WHERE "
                . "idAsignaturaPruebaEstado = '".$idAsignatura."' "
                . "AND idTipoPruebaEstado = '".$idTipoPrueba."' "
                . "AND codigoEstado = 1";
        $datos = $this->db->Execute($query);
        $id = $datos->FetchRow();
        
        if(empty($id)){
            $query = "INSERT INTO AsignaturaTipoPruebaEstado SET "
                    . "idAsignaturaPruebaEstado = '".$idAsignatura."', "
                    . "idTipoPruebaEstado = '".$idTipoPrueba."', "
                    . "codigoEstado = 1";
            $this->db->Execute($query);
        }
    }
}