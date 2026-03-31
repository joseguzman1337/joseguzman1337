<?php
/**
 * Clase encargada de la entidad para la configuracion del simulador financiero
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Entidades
 * @since Enero 20, 2017
*/
class ConfigSimuladorFinanciero 
{
 
 	/**
	 * @type int
	 * @access private
	*/
	private $codigoPeriodo;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $tasaInteres;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $porcentajeMinFinanciar;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $porcentajeMaxFinanciar;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $porcentajeEstudioCredito;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $ivaPorcentajeEstudioCredito;
 
 	/**
	 * @type int
	 * @access private
	*/
	private $maxNroCuotas;
 
 	/**
	 * @type float
	 * @access private
	*/
	private $valorEstudioCredito;
		
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
     * @since Enero 20, 2017
    */
    function __construct( $persistencia ){
    	$this->persistencia = $persistencia;
	}
	
	/**
     * Modifica el codigo Periodo
	 * @param float $codigoPeriodo
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setCodigoPeriodo( $codigoPeriodo ){
		$this->codigoPeriodo= $codigoPeriodo;
	}
	
	/**
	 * Retorna el codigo Periodo
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getCodigoPeriodo( ){
		return $this->codigoPeriodo;
	}
	
	/**
     * Modifica la tasa de interes
	 * @param float $tasaInteres
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setTasaInteres( $tasaInteres ){
		$this->tasaInteres= $tasaInteres;
	}
	
	/**
	 * Retorna la tasa de interes
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getTasaInteres( ){
		return $this->tasaInteres;
	}
	
	/**
     * Modifica el porcentaje mininmo financiar
	 * @param float $porcentajeMinFinanciar
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setPorcentajeMinFinanciar( $porcentajeMinFinanciar ){
		$this->porcentajeMinFinanciar= $porcentajeMinFinanciar;
	}
	
	/**
	 * Retorna el porcentaje mininmo financiar
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getPorcentajeMinFinanciar( ){
		return $this->porcentajeMinFinanciar;
	}
	
	/**
     * Modifica el porcentaje maximo financiar
	 * @param float $porcentajeMaxFinanciar
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setPorcentajeMaxFinanciar( $porcentajeMaxFinanciar ){
		$this->porcentajeMaxFinanciar= $porcentajeMaxFinanciar;
	}
	
	/**
	 * Retorna el porcentaje maximo financiar
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getPorcentajeMaxFinanciar( ){
		return $this->porcentajeMaxFinanciar;
	}
	
	/**
     * Modifica el porcentaje Estudio Credito
	 * @param float $porcentajeEstudioCredito
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setPorcentajeEstudioCredito( $porcentajeEstudioCredito ){
		$this->porcentajeEstudioCredito = $porcentajeEstudioCredito;
	}
	
	/**
	 * Retorna el porcentaje Estudio Credito
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getPorcentajeEstudioCredito( ){
		return $this->porcentajeEstudioCredito;
	}
	
	/**
     * Modifica el iva Porcentaje Estudio Credito
	 * @param float $ivaPorcentajeEstudioCredito
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setIvaPorcentajeEstudioCredito( $ivaPorcentajeEstudioCredito ){
		$this->ivaPorcentajeEstudioCredito = $ivaPorcentajeEstudioCredito;
	}
	
	/**
	 * Retorna el iva Porcentaje Estudio Credito
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getIvaPorcentajeEstudioCredito( ){
		return $this->ivaPorcentajeEstudioCredito;
	}
	
	/**
     * Modifica el max Nro Cuotas
	 * @param int $maxNroCuotas
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setMaxNroCuotas( $maxNroCuotas ){
		$this->maxNroCuotas = $maxNroCuotas;
	}
	
	/**
	 * Retorna el max Nro Cuotas
	 * @access public
	 * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getMaxNroCuotas( ){
		return $this->maxNroCuotas;
	}
	
	/**
     * Modifica el valor Estudio Credito
	 * @param float $valorEstudioCredito
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */ 
	public function setValorEstudioCredito( $valorEstudioCredito ){
		$this->valorEstudioCredito = $valorEstudioCredito;
	}
	
	/**
	 * Retorna el valor Estudio Credito
	 * @access public
	 * @return float
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
	 */
	public function getValorEstudioCredito( ){
		return $this->valorEstudioCredito;
	}
	
    /**
     * Consulta la ultima configuracion activa del simulador financiero
     * @access public 
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
    public function getConfigSimuladorFinanciero(  )
    {
    	$sql = "SELECT codigoperiodo, tasainteres, porcentajeminfinanciar, 
    				   porcentajemaxfinanciar, porcentajeestudiocredito, 
    				   ivaporcentajeestudiocredito, maxnrocuotas, ValorEstudioCredito
    			  FROM configsimuladorfinanciero 
    			 WHERE activo =1 
			  ORDER BY idconfigsimuladorfinanciero DESC 
			     LIMIT 1";
       
        $this->persistencia->crearSentenciaSQL( $sql );
        //d( $this->persistencia->getSQLListo( ) );
        
		$this->persistencia->ejecutarConsulta( );
		
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoPeriodo($this->persistencia->getParametro( "codigoperiodo" ));
			$this->setTasaInteres($this->persistencia->getParametro( "tasainteres" ));
			$this->setPorcentajeMinFinanciar($this->persistencia->getParametro( "porcentajeminfinanciar" ));
			$this->setPorcentajeMaxFinanciar($this->persistencia->getParametro( "porcentajemaxfinanciar" ));
			$this->setPorcentajeEstudioCredito($this->persistencia->getParametro( "porcentajeestudiocredito" ));
			$this->setIvaPorcentajeEstudioCredito($this->persistencia->getParametro( "ivaporcentajeestudiocredito" ));
			$this->setMaxNroCuotas($this->persistencia->getParametro( "maxnrocuotas" ));
			$this->setValorEstudioCredito($this->persistencia->getParametro( "ValorEstudioCredito" ));
		}
		//d($this);
		$this->persistencia->freeResult( );
    }
}
?>