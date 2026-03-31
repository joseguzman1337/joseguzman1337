<?php
/**
 * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/

defined('_EXEC') or die;
class SiqAdetallepublicoobjetivo implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    private $idsiq_Adetallepublicoobjetivo;
    
    private $idsiq_Apublicoobjetivo;
    
    private $tipoestudiante;
    
    private $E_New;
    
    private $E_Old;
    
    private $E_Egr;
    
    private $E_Gra;
    
    private $filtro;
    
    private $semestre;
    
    private $modalidadsic;
    
    private $codigocarrera;
    
    private $cadena;
    
    private $tipocadena;
    
    private $userid;
    
    private $entrydate;
    
    private $codigoestado;
    
    private $userid_estado;
    
    private $changedate;
    
    private $docente;
    
    private $modalidadocente;
    
    private $recienegresado;
    
    private $consolidacionprofesional;
    
    private $senior;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_Adetallepublicoobjetivo() {
        return $this->idsiq_Adetallepublicoobjetivo;
    }

    public function getIdsiq_Apublicoobjetivo() {
        return $this->idsiq_Apublicoobjetivo;
    }

    public function getTipoestudiante() {
        return $this->tipoestudiante;
    }

    public function getE_New() {
        return $this->E_New;
    }

    public function getE_Old() {
        return $this->E_Old;
    }

    public function getE_Egr() {
        return $this->E_Egr;
    }

    public function getE_Gra() {
        return $this->E_Gra;
    }

    public function getFiltro() {
        return $this->filtro;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getModalidadsic() {
        return $this->modalidadsic;
    }
    
    public function getCodigocarrera(){
        return $this->codigocarrera;
    }
    
    public function getCadena(){
        return $this->cadena;
    }

    public function getTipocadena(){
        return $this->tipocadena;
    }
    
    public function getUserid(){
        return $this->userid;
    }
    
    public function getEntrydate(){
        return $this->entrydate;
    }
    
    public function getCodigoestado(){
        return $this->codigoestado;
    }
    
    public function getUserid_estado(){
        return $this->userid_estado;
    }
    
    public function getChangedate(){
        return $this->changedate;
    }
    
    public function getDocente(){
        return $this->docente;
    }
    
    public function getModalidadocente(){
        return $this->modalidadocente;
    }
    
    public function getRecienegresado(){
        return $this->recienegresado;
    }
    
    public function getConsolidacionprofesional(){
        return $this->consolidacionprofesional;
    } 
    
    public function getSenior(){
        return $this->senior;
    }
    
    public function setIdsiq_Adetallepublicoobjetivo($idsiq_Adetallepublicoobjetivo) {
        $this->idsiq_Adetallepublicoobjetivo = $idsiq_Adetallepublicoobjetivo;
    }

    public function setIdsiq_Apublicoobjetivo($idsiq_Apublicoobjetivo) {
        $this->idsiq_Apublicoobjetivo = $idsiq_Apublicoobjetivo;
    }

    public function setTipoestudiante($tipoestudiante) {
        $this->tipoestudiante = $tipoestudiante;
    }

    public function setE_New($E_New) {
        $this->E_New = $E_New;
    }

    public function setE_Old($E_Old) {
        $this->E_Old = $E_Old;
    }

    public function setE_Egr($E_Egr) {
        $this->E_Egr = $E_Egr;
    }

    public function setE_Gra($E_Gra) {
        $this->E_Gra = $E_Gra;
    }

    public function setFiltro($filtro) {
        $this->filtro = $filtro;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }
    
    public function setModalidadsic ($modalidadsic){
        $this->modalidadsic = $modalidadsic;
    }

    public function setCodigocarrera($codigocarrera){
        $this->codigocarrera = $codigocarrera;
    }

    public function setCadena($cadena){
        $this->cadena = $cadena;
    }

    public function setTipocadena($tipocadena){
        $this->tipocadena = $tipocadena;
    }

    public function setUserid($userid){
        $this->userid = $userid;
    }
    
    public function setEntrydate($entrydate){
        $this->entrydate = $entrydate;
    }
   
    public function setCodigoestado($codigoestado){
        $this->codigoestado = $codigoestado;
    }
    
    public function setuserid_estado($userid_estado){
        $this->userid_estado = $userid_estado;
    }   
    
    public function setChangedate($changedate){
        $this->changedate = $changedate;
    }
    
    public function setDocente($docente){
        $this->docente = $docente;
    }
    
    public function setModalidadocente( $modalidadocente){
        $this->modalidadocente = $modalidadocente;
    }
    
    public function setRecienegresado($recienegresado){
        $this->recienegresado = $recienegresado;
    }
    
    public function setConsolidacionprofesional($consolidacionprofesional){
        $this->consolidacionprofesional = $consolidacionprofesional;
    }
    
    public function setSenior($senior){
        $this->senior = $senior;
    }
    
    public function getById() {
        if(!empty($this->idsiq_Adetallepublicoobjetivo)){
            $query = "SELECT * FROM siq_Adetallepublicoobjetivo "
                    ." WHERE idsiq_Adetallepublicoobjetivo = ".$this->db->qstr($this->idsiq_Adetallepublicoobjetivo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_Apublicoobjetivo = $d['idsiq_Apublicoobjetivo']; 
                $this->tipoestudiante = $d['tipoestudiante']; 
                $this->E_New = $d['E_New']; 
                $this->E_Old = $d['E_Old']; 
                $this->E_Egr = $d['E_Egr']; 
                $this->E_Gra = $d['E_Gra']; 
                $this->filtro = $d['filtro']; 
                $this->semestre = $d['semestre']; 
                $this->modalidadsic = $d['modalidadsic']; 
                $this->codigocarrera = $d['codigocarrera']; 
                $this->cadena = $d['cadena']; 
                $this->tipocadena = $d['tipocadena']; 
                $this->userid = $d['userid']; 
                $this->entrydate = $d['entrydate']; 
                $this->codigoestado = $d['codigoestado']; 
                $this->userid_estado = $d['userid_estado']; 
                $this->changedate = $d['changedate']; 
                $this->docente = $d['docente']; 
                $this->modalidadocente = $d['modalidadocente']; 
                $this->recienegresado = $d['recienegresado']; 
                $this->consolidacionprofesional = $d['consolidacionprofesional']; 
                $this->senior = $d['senior']; 
            }
        }
    }

    public static function getList($where=null, $orderBy = null) {
        $db = Factory::createDbo();
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_Adetallepublicoobjetivo "
                . " WHERE 1";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqAdetallepublicoobjetivo = new SiqAdetallepublicoobjetivo();
            $SiqAdetallepublicoobjetivo->idsiq_Adetallepublicoobjetivo = $d['idsiq_Adetallepublicoobjetivo'];
            $SiqAdetallepublicoobjetivo->idsiq_Apublicoobjetivo = $d['idsiq_Apublicoobjetivo']; 
            $SiqAdetallepublicoobjetivo->tipoestudiante = $d['tipoestudiante']; 
            $SiqAdetallepublicoobjetivo->E_New = $d['E_New']; 
            $SiqAdetallepublicoobjetivo->E_Old = $d['E_Old']; 
            $SiqAdetallepublicoobjetivo->E_Egr = $d['E_Egr']; 
            $SiqAdetallepublicoobjetivo->E_Gra = $d['E_Gra']; 
            $SiqAdetallepublicoobjetivo->filtro = $d['filtro']; 
            $SiqAdetallepublicoobjetivo->semestre = $d['semestre']; 
            $SiqAdetallepublicoobjetivo->modalidadsic = $d['modalidadsic']; 
            $SiqAdetallepublicoobjetivo->codigocarrera = $d['codigocarrera']; 
            $SiqAdetallepublicoobjetivo->cadena = $d['cadena']; 
            $SiqAdetallepublicoobjetivo->tipocadena = $d['tipocadena']; 
            $SiqAdetallepublicoobjetivo->userid = $d['userid']; 
            $SiqAdetallepublicoobjetivo->entrydate = $d['entrydate']; 
            $SiqAdetallepublicoobjetivo->codigoestado = $d['codigoestado']; 
            $SiqAdetallepublicoobjetivo->userid_estado = $d['userid_estado']; 
            $SiqAdetallepublicoobjetivo->changedate = $d['changedate']; 
            $SiqAdetallepublicoobjetivo->docente = $d['docente'];
            $SiqAdetallepublicoobjetivo->modalidadocente = $d['modalidadocente'];
            $SiqAdetallepublicoobjetivo->recienegresado = $d['recienegresado'];
            $SiqAdetallepublicoobjetivo->consolidacionprofesional = $d['consolidacionprofesional'];
            $SiqAdetallepublicoobjetivo->senior = $d['senior'];
            
            $return[] = $SiqAdetallepublicoobjetivo;
        }
        return $return;
    }//function
    
    
    public function getPublicoCsv($idpublico, $documento){
        //esta funcion debe validar la informacion de las personas asignadas por cargue manual a una encuestas especifica.
        $db = Factory::createDbo();
        
        $query = "select count(*) as id  from siq_Apublicoobjetivocsv "
        ."where 1 and idsiq_Apublicoobjetivo = '".$idpublico."' and cedula = '".$documento."' and codigoestado= 100";        
        $datos = $db->GetRow($query);
        //sí el id es 0 o vacio significa que le usuario no esta en la lista de participantes
        if($datos['id'] == 0 || empty($datos['id'])){
            return false; 
        }else{
            return true; 
        }
        
    }//function
    
    public function getPublicoObjetivoinstrumento ($idinstrumento, $tipoestudiante, $situacionestudiante, $idCarrera){        
        $db = Factory::createDbo();
        $cadena = "";
        $valor = false;
        $querydatos = "select dop.tipoestudiante, dop.E_New, dop.E_Old, dop.E_Egr, dop.E_Gra, dop.cadena, dop.semestre  "
        ." from siq_Apublicoobjetivo ob  "
        ."INNER JOIN siq_Adetallepublicoobjetivo dop on (ob.idsiq_Apublicoobjetivo = dop.idsiq_Apublicoobjetivo) "
        ."where ob.idsiq_Ainstrumentoconfiguracion =  '".$idinstrumento."' "
        ."and (dop.E_New = 1 || dop.E_Old = 1 || dop.E_Egr = 1 ||dop.E_Gra = 1)";             
        $datos = $db->GetAll($querydatos);                    
        if(count($datos)> 0){            
            foreach ($datos as $resultado){                
                if($resultado['cadena'] == null || $resultado['cadena'] == '0'){
                    $cadena = $idCarrera;
                }else{
                    $cadena = strpos($resultado['cadena'], $idCarrera);
                    if($cadena > 0){
                         $cadena = $idCarrera;
                    }
                }                      
                if($cadena === $idCarrera ){
                    //if($resultado['semestre'] === '99'){
                        switch($resultado['tipoestudiante']){
                            case ('1'):{ //nuevo
                                if(($tipoestudiante == 10 || $tipoestudiante == 11) && ($situacionestudiante <> '400' || $situacionestudiante == '104')){
                                    $valor= true;
                                }
                            }break;
                            case ('2'):{ //viejo
                                if(($tipoestudiante == 20 || $tipoestudiante == 21) && ($situacionestudiante <> '400' || $situacionestudiante == '104')){
                                    $valor= true;
                                }
                            }break;
                            case ('3'):{//egresado
                                if(($tipoestudiante == 20 || $tipoestudiante == 21) && $situacionestudiante == '104'){
                                    $valor= true;
                                }
                            }break;
                            case ('4'):{//graduado
                                if(($tipoestudiante == 20 || $tipoestudiante == 21) && $situacionestudiante == '400'){
                                    $valor= true;
                                }
                            }break; 
                        }//switch
                    //}//semestre
                }//if                    
            }//foreach
        }//if
        return $valor;
    }  
}
