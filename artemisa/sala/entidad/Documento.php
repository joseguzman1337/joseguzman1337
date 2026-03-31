<?php
/**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */
defined('_EXEC') or die;
 class Documento implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $tipoDocumento;

    /**
     * @type String
     * @access private
     */
    private $nombreDocumento;

    /**
     * @type String
     * @access private
     */
    private $nombreCortoDocumento;

    /**
     * @type String
     * @access private
     */
    private $tipoDocumentoSap;

    /**
     * @type int
     * @access private
     */
    private $codigoEstado;
	
    public function __construct(){}
    
    
    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getNombreDocumento() {
        return $this->nombreDocumento;
    }

    public function getNombreCortoDocumento() {
        return $this->nombreCortoDocumento;
    }

    public function getTipoDocumentoSap() {
        return $this->tipoDocumentoSap;
    }

    public function getCodigoEstado() {
        return $this->codigoEstado;
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setNombreDocumento($nombreDocumento) {
        $this->nombreDocumento = $nombreDocumento;
    }

    public function setNombreCortoDocumento($nombreCortoDocumento) {
        $this->nombreCortoDocumento = $nombreCortoDocumento;
    }

    public function setTipoDocumentoSap($tipoDocumentoSap) {
        $this->tipoDocumentoSap = $tipoDocumentoSap;
    }

    public function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

            
        
        
        
        
        
        
        
        
	
 public function getById(){
        if(!empty($this->tipoDocumento)){
            $query = "SELECT * FROM documento "
                    . "WHERE tipodocumento = ".$this->db->qstr($this->tipoDocumento);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombreDocumento = $d['nombredocumento'];
                $this->nombreCortoDocumento = $d['nombrecortodocumento'];
                $this->tipoDocumentoSap = $d['tipodocumentosap'];
                $this->codigoEstado = $d['codigoestado'];
            }
        }
    }
    
    public static function getList($where = null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM documento "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $Documento = new Documento();
            $Documento->tipoDocumento = $d['tipodocumento'];
            $Documento->nombreDocumento = $d['nombredocumento'];
            $Documento->nombreCortoDocumento = $d['nombrecortodocumento'];
            $Documento->tipoDocumentoSap = $d['tipodocumentosap'];
            $Documento->codigoEstado = $d['codigoestado'];
            
            $return[] = $Documento;
            unset($Documento);
        }
        
        return $return;
    }	
	/**
	 * Consultar Tipo de Documento
	 * @access public
	 * @return array
	 */
	public function consultar( ){
		$tipoDocumentos = array( );
		$sql = "SELECT tipodocumento, nombredocumento 
				FROM documento
				WHERE codigoestado = 100
				";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$tipoDocumento = new Documento( null );
			$tipoDocumento->setTipoDocumento( $this->persistencia->getParametro( "tipodocumento" ) );
			$tipoDocumento->setDescripcion( $this->persistencia->getParametro( "nombredocumento" ) );
			$tipoDocumentos[] = $tipoDocumento;
		}
		
		$this->persistencia->freeResult( );
		return $tipoDocumentos;
	}
	
	
 }
 
?>