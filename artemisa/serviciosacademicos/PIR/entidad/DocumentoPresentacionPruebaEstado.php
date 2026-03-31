<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class DocumentoPresentacionPruebaEstado{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;  
    
    /**
     * @type int
     * @access private
     */
    private $idDocumentoPresentacionPruebaEstado;
    
    /**
     * @type int
     * @access private
     */
    private $idResultadoPruebaEstado;
    
    /**
     * @type int
     * @access private
     */
    private $idEstudianteDocumentoPruebaEstado;
    
    /**
     * @type int
     * @access private
     */
    private $codigoEstadoPruebaEstado;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantedocumento;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type String
     * @access private
     */
    private $tipodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $expedidodocumento;
    
    /**
     * @type date
     * @access private
     */
    private $fechainicioestudiantedocumento;
    
    /**
     * @type date
     * @access private
     */
    private $fechavencimientoestudiantedocumento;
    
    function DocumentoPresentacionPruebaEstado($db, $idestudiantegeneral, $tipodocumento, $numerodocumento) {
        $this->db = $db;
        $this->idestudiantegeneral = $idestudiantegeneral;
        $this->tipodocumento = $tipodocumento;
        $this->numerodocumento = $numerodocumento;
        
    }
    
    public function validarDocumentoEstudiante(){ 
        $query = "SELECT ed.idestudiantedocumento, ed.idestudiantegeneral, ed.tipodocumento,
            ed.numerodocumento, ed.expedidodocumento, ed.fechainicioestudiantedocumento, 
            ed.fechavencimientoestudiantedocumento, d.nombrecortodocumento, d.nombrecortodocumento
            FROM estudiantedocumento ed
            INNER JOIN documento d ON (ed.tipodocumento = d.tipodocumento)
            WHERE idestudiantegeneral = '".$this->idestudiantegeneral."'
            AND d.nombrecortodocumento = '".$this->tipodocumento."'
            AND  ed.numerodocumento = '".$this->numerodocumento."'";
        //d($query);
        $documentos = $this->db->Execute($query);
        $documento = $documentos->FetchRow();
        //
        if(empty($documento)){
            $this->storeDocumento();
            return $this->validarDocumentoEstudiante();
        }else{
            $this->idestudiantedocumento = $documento['idestudiantedocumento'];
            $this->expedidodocumento = $documento['expedidodocumento'];
            $this->fechainicioestudiantedocumento = $documento['fechainicioestudiantedocumento'];
            $this->fechavencimientoestudiantedocumento = $documento['fechavencimientoestudiantedocumento'];
            
        }
        //d($this);
        return $this;
    }
    
    public function consultarIdEsutianteGeneral(){
        $query = "SELECT ed.idestudiantegeneral
            FROM estudiantedocumento ed
            INNER JOIN documento d ON (ed.tipodocumento = d.tipodocumento)
            WHERE d.nombrecortodocumento = '".$this->tipodocumento."'
            AND  ed.numerodocumento = '".$this->numerodocumento."'";
        //d($query);
        $documentos = $this->db->Execute($query);
        $documento = $documentos->FetchRow();
        //
        if(!empty($documento)){
            return $documento['idestudiantegeneral']; 
        }
        return false;
    }
    
    private function getCodigoTipoDocumento(){
        $query = "SELECT tipodocumento "
                . "FROM documento "
                . "WHERE nombrecortodocumento = '".$this->tipodocumento."'";
        
        $documentos = $this->db->Execute($query);
        $documento = $documentos->FetchRow();
        return $documento['tipodocumento'];
    }
    
    private function storeDocumento(){
        $query = "INSERT into estudiantedocumento SET "
                . "idestudiantegeneral = '".$this->idestudiantegeneral."', "
                . "numerodocumento = '".$this->numerodocumento."', "
                . "tipodocumento = '".$this->getCodigoTipoDocumento()."', "
                . "fechainicioestudiantedocumento = '2000-01-01', "
                . "fechavencimientoestudiantedocumento = '2000-01-01' ";
        $this->db->Execute($query);
        //d($query);                
    }
    
    public function setRelacion($idresultadopruebaestado){
        $query = "SELECT id FROM DocumentoPresentacionPruebaEstado WHERE "
                . "idResultadoPruebaEstado = '".$idresultadopruebaestado."' "
                . "AND idEstudianteDocumento = '".$this->idestudiantedocumento."' "
                . "AND codigoEstado = 1 ";
        //d($query);
        $datos = $this->db->Execute($query);
        $dato = $datos->FetchRow();
        
        if(empty($dato['id'])){
            $query = "INSERT INTO DocumentoPresentacionPruebaEstado SET "
                    . "idResultadoPruebaEstado = '".$idresultadopruebaestado."', "
                    . "idEstudianteDocumento = '".$this->idestudiantedocumento."',"
                    . "codigoEstado = 1 ";
            //ddd($query);
            $this->db->Execute($query);
        }
        
    }

    
}