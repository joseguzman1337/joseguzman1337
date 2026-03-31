<?php
/**
 * Clase encargada de la entidad para la Carrera
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Entidades
 * @since Enero 23, 2017
*/
class Carrera 
{
 
 	/**
	 * @type int
	 * @access private
	*/
	private $codigoCarrera;
 
 	/**
	 * @type String
	 * @access private
	*/
	private $nombreCarrera; 
	/**
	 * @type Singleton
	 * @access private
	*/
	private $persistencia;
	
    /**
     * Constructor del objeto
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    function __construct( $persistencia ){
    	$this->persistencia = $persistencia;
	}
	
	/**
     * Modifica el codigo carrera
	 * @param int $codigoCarrera
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */ 
	public function setCodigoCarrera( $codigoCarrera ){
		$this->codigoCarrera= $codigoCarrera;
	}
	
	/**
	 * Retorna el codigo carrera
	 * @access public
	 * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
	 */
	public function getCodigoCarrera( ){
		return $this->codigoCarrera;
	}
	
	/**
     * Modifica el nombre carrera
	 * @param String $nombreCarrera
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */ 
	public function setNombreCarrera( $nombreCarrera ){
		$this->nombreCarrera= $nombreCarrera;
	}
	
	/**
	 * Retorna el nombre Carrera
	 * @access public
	 * @return String
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
	 */
	public function getNombreCarrera( ){
		return $this->nombreCarrera;
	}
	
    /**
     * Consulta y retorna el listado de carreras
     * @access public 
	 * @param int $codigoModalidadAcademica
     * @return Array $carreras
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    public function getListaCarreras( $codigoModalidadAcademica )
    {
    	$carreras = array();
    	$sql = "SELECT codigocarrera, nombrecarrera 
    			  FROM carrera 
    			 WHERE codigomodalidadacademica = ? 
				   AND fechavencimientocarrera > NOW() 
				   AND codigocarrera <> 1 
			  ORDER BY nombrecarrera";
       
        $this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $codigoModalidadAcademica , false );
        //d( $this->persistencia->getSQLListo( ) );
        
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){
			$carrera = new Carrera( NULL );
			$carrera->setCodigoCarrera($this->persistencia->getParametro( "codigocarrera" ));
			$carrera->setNombreCarrera($this->persistencia->getParametro( "nombrecarrera" ));
			
			$carreras[] = $carrera;
		}
		//d($this);
		$this->persistencia->freeResult( );
		
		return $carreras;
    }
	
    /**
     * Consulta y retorna una carrera buscando por el codigo
     * @access public 
	 * @param int $codCarrera
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    public function getCarreraPorCodigo( $codCarrera )
    { 
    	$sql = "SELECT codigocarrera, nombrecarrera 
    			  FROM carrera 
    			 WHERE codigocarrera = ?  
			  ORDER BY nombrecarrera";
       
        $this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $codCarrera , false );
        //d( $this->persistencia->getSQLListo( ) );
        
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){ 
			$this->setCodigoCarrera($this->persistencia->getParametro( "codigocarrera" ));
			$this->setNombreCarrera($this->persistencia->getParametro( "nombrecarrera" )); 
		}
		//d($this);
		$this->persistencia->freeResult( );
		 
    }
}
?>