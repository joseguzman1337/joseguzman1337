<?php
/**
 * Clase encargada de la entidad para el periodo
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Entidades
 * @since Enero 23, 2017
*/
class Cohorte 
{
 
 	/**
	 * @type int
	 * @access private
	*/
	private $valorDetalleCohorte; 
	
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
     * Modifica el valor Detalle Cohorte
	 * @param int $valorDetalleCohorte
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */ 
	public function setValorDetalleCohorte( $valorDetalleCohorte ){
		$this->valorDetalleCohorte = $valorDetalleCohorte;
	}
	
	/**
	 * Retorna el valor Detalle Cohorte
	 * @access public
	 * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
	 */
	public function getValorDetalleCohorte( ){
		return $this->valorDetalleCohorte;
	}
	
    /**
     * Consulta y retorna los periodos acual y siguiente
     * @access public  
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 23, 2017
    */
    public function getValorCohortePeriodoCarrera( $codcarrera, $periodoSiguiente )
    {
    	$carreras = array();
    	$sql = "SELECT valordetallecohorte
				  FROM cohorte
				  JOIN detallecohorte USING(idcohorte)
				 WHERE codigocarrera=?
				   AND codigoperiodo=?
				   AND semestredetallecohorte=1";
       
        $this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $codcarrera , false );
		$this->persistencia->setParametro( 1 , $periodoSiguiente , true );
        //d( $this->persistencia->getSQLListo( ) );
        
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){
			$this->setValorDetalleCohorte($this->persistencia->getParametro( "valordetallecohorte" )); 
		}
		//d($this);
		$this->persistencia->freeResult( );
		 
    }
}
?>