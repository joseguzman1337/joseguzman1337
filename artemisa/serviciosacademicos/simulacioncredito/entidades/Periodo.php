<?php
/**
 * Clase encargada de la entidad para el periodo
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Entidades
 * @since Enero 23, 2017
*/
class Periodo 
{
 
 	/**
	 * @type int
	 * @access private
	*/
	private $periodoActivo;
 
 	/**
	 * @type int
	 * @access private
	*/
	private $siguientePeriodo; 
	
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
     * Modifica el periodo activo
	 * @param int $periodoActivo
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */ 
	public function setPeriodoActivo( $periodoActivo ){
		$this->periodoActivo= $periodoActivo;
	}
	
	/**
	 * Retorna el periodo activo
	 * @access public
	 * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
	 */
	public function getPeriodoActivo( ){
		return $this->periodoActivo;
	}
	
	/**
     * Modifica el periodo siguiente
	 * @param int $periodoSiguiente
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */ 
	public function setPeriodoSiguiente( $periodoSiguiente ){
		$this->periodoSiguiente= $periodoSiguiente;
	}
	
	/**
	 * Retorna el periodo siguiente
	 * @access public
	 * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
	 */
	public function getPeriodoSiguiente( ){
		return $this->periodoSiguiente;
	} 
	
    /**
     * Consulta y retorna los periodos acual y siguiente
     * @access public  
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    public function getPeriodoActualSiguiente(  )
    {
    	$carreras = array();
    	$sql = "SELECT *
				  FROM (
							SELECT codigoperiodo AS periodoactivo
							  FROM periodo 
							 WHERE codigoestadoperiodo=1
					   ) sub1
			CROSS JOIN (
							SELECT codigoperiodo AS siguienteperiodo
							  FROM periodo
							 WHERE codigoperiodo > (
														SELECT codigoperiodo
							 							  FROM periodo
														 WHERE codigoestadoperiodo=1 
												   )
						  ORDER BY codigoperiodo
							 LIMIT 1
						) sub2 ";
       
        $this->persistencia->crearSentenciaSQL( $sql );
		//$this->persistencia->setParametro( 0 , $codigoModalidadAcademica , false );
        //d( $this->persistencia->getSQLListo( ) );
        
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){
			$this->setPeriodoActivo($this->persistencia->getParametro( "periodoactivo" ));
			$this->setPeriodoSiguiente($this->persistencia->getParametro( "siguienteperiodo" ));
		}
		//d($this);
		$this->persistencia->freeResult( );
		 
    }
}
?>