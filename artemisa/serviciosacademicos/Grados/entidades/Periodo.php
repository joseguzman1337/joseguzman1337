<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */

 class Periodo{
 	
	/**
	 * @type int
	 * @access private 
	 */
	private $codigo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaInicio;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaVencimiento;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroPeriodo;
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Periodo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del periodo
	 * @access public 
	 * @return void
	 */
	public function setCodigo( $codigo ){
		$this->codigo = $codigo;
	}
	
	/**
	 * Retorna el codigo del periodo
	 * @param int $codigo
	 * @access public
	 * @return int
	 */
	public function getCodigo( ){
		return $this->codigo;
	}
	
	/**
	 * Modifica el nombre del Codigo
	 * @access public
	 * @return void
	 */
	public function setNombrePeriodo( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del Codigo
	 * @param String $nombre
	 * @access public
	 * @return String
	 */
	public function getNombrePeriodo( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica el estado del periodo
	 * @access public
	 * @return void
	 */
	public function setEstadoPeriodo( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado del periodo
	 * @param int $estado
	 * @access public
	 * @return int 
	 */
	public function getEstadoPeriodo( ){
		return $this->estado;
	}
	
	/**
	 * Modifica la fecha de inicio del periodo
	 * @access public
	 * @return void
	 */
	public function setFechaInicioPeriodo( $fechaInicio ){
		$this->fechaInicio = $fechaInicio; 
	}
	
	/**
	 * Retorna la fecha de inicio del periodo
	 * @param date $fechaInicio
	 * @access public
	 * @return date
	 */
	public function getFechaInicioPeriodo( ){
		return $this->fechaInicio;
	}
	
	/**
	 * Modifica la fecha de vencimiento del periodo
	 * @access public
	 * @return void
	 */
	public function setFechaVencimientoPeriodo( $fechaVencimiento ){
		$this->fechaVencimiento = $fechaVencimiento;
	}
	
	/**
	 * Retorna la fecha de vencimiento del periodo
	 * @param date $fechaVencimiento
	 * @access public
	 * @return date
	 */
	public function getFechaVencimientoPeriodo( ){
		return $this->fechaVencimiento;
	}
	
	/**
	 * Modifica el numero del periodo
	 * @access public
	 * @return void
	 */
	public function setNumeroPeriodo( $numeroPeriodo ){
		$this->numeroPeriodo = $numeroPeriodo;
	}
	
	/**
	 * Retorna el numero del periodo
	 * @param int $numeroPeriodo
	 * @access public
	 * @return int
	 */
	public function getNumeroPeriodo( ){
		return $this->numeroPeriodo;
	}
	
	/**
	 * Consultar Periodo
	 * @access public
	 * @return Array<Periodo>
	 */
	public function consultarPeriodo( ){
		$periodos = array( );
                /**
                 *@modified Diego Rivera<riveradiego@unbosque.edu.co> 
                 *Se modifica consulta se cambia parametro del año debido a que se necesitan periodos anteriores para registro
                 *de grados adicionales
                 *@since May 15,2019  
                 */
                $sql ="SELECT
                                codigoestadoperiodo,
                                codigoperiodo,
                                nombreperiodo 
                        FROM
                                periodo 
                        WHERE
                                codigoperiodo >= 19901
                        ORDER BY  codigoperiodo  DESC       ";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){
			$periodo = new Periodo( null );
			$periodo->setEstadoPeriodo( $this->persistencia->getParametro( "codigoestadoperiodo" ) );
			$periodo->setCodigo( $this->persistencia->getParametro( "codigoperiodo" ) );
			$periodo->setNombrePeriodo( $this->persistencia->getParametro( "nombreperiodo" ) );
			
			$periodos[ count( $periodos ) ] = $periodo;
		}
		return $periodos;
	}
	
	/**
	 * Buscar Periodo Activo
	 * @access public
	 * @return estadoperiodo
	 */
	public function buscarPeriodoActivo( ){
		$sql = "SELECT codigoperiodo, nombreperiodo
				FROM periodo
				WHERE codigoestadoperiodo = 1";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigo( $this->persistencia->getParametro( "codigoperiodo" ) );
			$this->setNombrePeriodo( $this->persistencia->getParametro( "nombreperiodo" ) );
		}
		/*echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );*/
	}
 	
 }
?>