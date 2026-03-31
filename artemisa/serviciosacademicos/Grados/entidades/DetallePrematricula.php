<?php
   /**
    * @author Carlos Albeto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
include ('../../../kint/Kint.class.php');


   class DetallePrematricula{
   	
	/**
	 * @type Prematricula
	 * @access private
	 */
	private $preMatricula;
	
	/**
	 * @type Materia
	 * @access private
	 */
	private $materia;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDetallePrematricula;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTipoDetalle;
	
	/**
	 * @type OrdenPago
	 * @access private
	 */
	private $ordenPago;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function DetallePrematricula( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica la Prematricula del Detalle
	 * @param PreMatricula $preMatricula
	 * @access public
	 * @return void
	 */
	public function setPreMatricula( $preMatricula ){
		$this->preMatricula = $preMatricula;
	}
	
	/**
	 * Retorna la Prematricula del Detalle
	 * @access public
	 * @return PreMatricula
	 */
	public function getPreMatricula( ){
		return $this->preMatricula;
	}
	
	/**
	 * Modifica la materia del Detalle
	 * @param Materia $materia
	 * @access public
	 * @return void
	 */
	public function setMateria( $materia ){
		$this->materia = $materia;
	}
	
	/**
	 * Retorna la materia del Detalle
	 * @access public
	 * @return Materia
	 */
	public function getMateria( ){
		return $this->materia;
	}
	
	/**
	 * Modifica el estado del Detalle
	 * @param int $estadoDetallePrematricula
	 * @access public
	 * @return void
	 */
	public function setEstadoDetallePrematricula( $estadoDetallePrematricula ){
		$this->estadoDetallePrematricula = $estadoDetallePrematricula;
	}
	
	/**
	 * Retorna el estado del Detalle
	 * @access public
	 * @return int
	 */
	public function getEstadoDetallePrematricula( ){
		return $this->estadoDetallePrematricula;
	}
	
	/**
	 * Modifica el codigo del tipo del Detalle
	 * @param int $codigoTipoDetalle
	 * @access public
	 * @return void
	 */
	public function setCodigoTipoDetalle( $codigoTipoDetalle ){
		$this->codigoTipoDetalle = $codigoTipoDetalle;
	}
	
	/**
	 * Retorna el codigo del tipo del Detalle
	 * @access public
	 * @return int
	 */
	public function getCodigoTipoDetalle( ){
		return $this->codigoTipoDetalle;
	}
	
	/**
	 * Modifica la orden de pago del Detalle
	 * @param int $ordenPago
	 * @access public
	 * @return void
	 */
	public function setOrdenPago( $ordenPago ){
		$this->ordenPago = $ordenPago;
	}
	
	/**
	 * Retorna la orden de pago del Detalle
	 * @access public
	 * @return OrdenPago
	 */
	public function getOrdenPago( ){
		return $this->ordenPago;
	}
	
	/**
	 * Existe Materias Actuales
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return void
	 */


	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	* se crea funcion creditosElectivas para contar el numero de creditos de electivas libres que debe cursar el estudiante 
	* se crea funcion creditosObligatorios para contar el numero de creditos obligatorio  que debe cursar el estudiante
	* se crea funcion creditosElectivasVistos para consultar el numero de creditos de electivas libres vistos
	* se crea funcion creditosObligatoriosVistos para consultar el numero de creditos obligatorios vistos	
	* Since Novenber 14 , 2017 
	*/

	public function creditosElectivas ( $txtCodigoEstudiante ){

		$sql = "
			SELECT
				SUM(
					dp.numerocreditosdetalleplanestudio
				) AS creditos
			FROM
				planestudioestudiante pe
			INNER JOIN detalleplanestudio dp ON dp.idplanestudio = pe.idplanestudio
			AND dp.codigotipomateria = 4
			INNER JOIN materia m ON m.codigomateria = dp.codigomateria
			WHERE
				pe.codigoestudiante = ?
			AND pe.codigoestadoplanestudioestudiante != 200";

		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "creditos" );
		}


	}

	
	public function creditosObligatorios( $txtCodigoEstudiante ){
	
		$sql = "
			SELECT
					sum(
						dp.numerocreditosdetalleplanestudio
						)as creditoObligatorios
			FROM
				planestudioestudiante pe
			INNER JOIN detalleplanestudio dp ON dp.idplanestudio = pe.idplanestudio
			AND dp.codigotipomateria = 1
			INNER JOIN materia m ON m.codigomateria = dp.codigomateria
			WHERE
				pe.codigoestudiante = ?
			AND pe.codigoestadoplanestudioestudiante != 200";

		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "creditoObligatorios" );
		}

	}


	

	public function creditosElectivasVistos ( $txtCodigoEstudiante ){
		
		$electivasVistos = 0;	
		$sql = "
				SELECT
					DISTINCT(NH.codigomateria),M.numerocreditos
				FROM
					notahistorico NH
				INNER JOIN materia M ON (
					NH.codigomateria = M.codigomateria
				)
				WHERE
					NH.codigoestudiante = ?
				AND NH.codigoestadonotahistorico = 100
				AND NH.notadefinitiva >= M.notaminimaaprobatoria 
				AND M.codigotipomateria in (4) 
				AND NH.idplanestudio = (select PEE.idplanestudio from planestudioestudiante PEE where PEE.codigoestudiante = ? and (PEE.codigoestadoplanestudioestudiante = 100 or PEE.codigoestadoplanestudioestudiante = 101) )";

		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );	
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante , false );	
		$this->persistencia->ejecutarConsulta( );

		
		while ( $this->persistencia->getNext( ) ){

				$electivasVistos = $electivasVistos + $this->persistencia->getParametro( "numerocreditos" );
		}
			
			return $electivasVistos; 

	}


	public function creditosObligatoriosVistos ( $txtCodigoEstudiante ){
	
	$obligatorias = 0;
		$sql = "
			SELECT
				DISTINCT(NH.codigomateria),M.numerocreditos
			FROM
				notahistorico NH
			INNER JOIN materia M ON (
				NH.codigomateria = M.codigomateria
			)
			WHERE
				NH.codigoestudiante = ?
			AND NH.codigoestadonotahistorico = 100
			AND NH.notadefinitiva >= M.notaminimaaprobatoria 
			AND M.codigotipomateria not IN (4) 
			AND NH.idplanestudio = (select PEE.idplanestudio from planestudioestudiante PEE where PEE.codigoestudiante = ? and (PEE.codigoestadoplanestudioestudiante = 100 or PEE.codigoestadoplanestudioestudiante = 101))";


		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );	
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante , false );	
		//ddd($this->persistencia->getSQLListo( ) );
		$this->persistencia->ejecutarConsulta( );

		while ( $this->persistencia->getNext( ) ){

				$obligatorias =  $obligatorias + $this->persistencia->getParametro( "numerocreditos" );
		}
			
			return $obligatorias; 
		
	}


	public function buscarMateriasActuales( $txtCodigoEstudiante ){


		/*Modified Diego RIvera <riveradiego@unbosque.edu.co>
		*Se cambia consulta sql con el fin de realizar conteo de creditos aprobados  y creditos pendientes respecto al plan de estudio
		*/
		
		/*$sql = "SELECT
				COUNT(D.codigomateria) AS cantidad_materias
			FROM
				planestudioestudiante P
			LEFT JOIN detalleplanestudio D ON ( D.idplanestudio = P.idplanestudio )
			INNER JOIN materia M ON ( M.codigomateria = D.codigomateria )
			INNER JOIN tipomateria T ON ( T.codigotipomateria = D.codigotipomateria )
			WHERE
				P.codigoestudiante = ?
			AND P.codigoestadoplanestudioestudiante LIKE '1%'
			AND D.codigoestadodetalleplanestudio LIKE '1%'
			AND M.codigomateria IN ( 
					SELECT DISTINCT
						MT.codigomateria
					FROM
						detalleprematricula DP
					INNER JOIN prematricula PT ON ( PT.idprematricula = DP.idprematricula )
					INNER JOIN materia MT ON ( MT.codigomateria = DP.codigomateria )
					INNER JOIN estudiante E ON ( E.codigoestudiante = PT.codigoestudiante )
					LEFT JOIN notahistorico N ON ( N.codigomateria = MT.codigomateria
						AND E.codigoestudiante = N.codigoestudiante
						AND PT.codigoperiodo = N.codigoperiodo
					)
					INNER JOIN situacioncarreraestudiante S ON ( S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante )
					WHERE
						E.codigoestudiante = ?
					AND ( PT.codigoestadoprematricula LIKE '4%' AND ( DP.codigoestadodetalleprematricula LIKE '3%' OR DP.codigoestadodetalleprematricula LIKE '2%' )
						OR PT.codigoestadoprematricula NOT LIKE '4%' AND ( DP.codigoestadodetalleprematricula NOT LIKE '3%' OR DP.codigoestadodetalleprematricula != '23' )
					)
					AND S.codigosituacioncarreraestudiante != 104
					AND ( MT.codigomateria NOT IN (
														SELECT
															NH.codigomateria
														FROM
															notahistorico NH
														WHERE
															NH.codigoestudiante = ?
														AND NH.notadefinitiva IS NOT NULL
													)
						OR N.codigomateria NOT IN (
														SELECT
															NH.codigomateria
														FROM
															notahistorico NH
														WHERE
															NH.codigoestudiante = ?
														AND NH.notadefinitiva >= 3
													)
					)
					GROUP BY
						MT.codigomateria
					UNION
						SELECT DISTINCT
							DP.codigomateriaelectiva
						FROM
							detalleprematricula DP
						INNER JOIN prematricula PT ON ( PT.idprematricula = DP.idprematricula )
						INNER JOIN materia MT ON ( MT.codigomateria = DP.codigomateria )
						INNER JOIN estudiante E ON ( E.codigoestudiante = PT.codigoestudiante )
						LEFT JOIN notahistorico N ON ( 
							N.codigomateria = MT.codigomateria
							AND E.codigoestudiante = N.codigoestudiante
							AND PT.codigoperiodo = N.codigoperiodo
						)
						INNER JOIN situacioncarreraestudiante S ON ( S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante )
						WHERE
							E.codigoestudiante = ?
						AND ( PT.codigoestadoprematricula LIKE '4%' AND ( DP.codigoestadodetalleprematricula LIKE '3%' OR DP.codigoestadodetalleprematricula = '23' )
							OR PT.codigoestadoprematricula NOT LIKE '4%' AND ( DP.codigoestadodetalleprematricula NOT LIKE '3%' OR DP.codigoestadodetalleprematricula != '23' )
						)
						AND S.codigosituacioncarreraestudiante != 104
						AND ( MT.codigomateria NOT IN (
															SELECT
																NH.codigomateria
															FROM
																notahistorico NH
															WHERE
																NH.codigoestudiante = ?
															AND NH.notadefinitiva IS NOT NULL
														)
							OR N.codigomateria NOT IN (
															SELECT
																NH.codigomateria
															FROM
																notahistorico NH
															WHERE
																NH.codigoestudiante = ?
															AND NH.notadefinitiva >= 3
														)
						)
						GROUP BY
							MT.codigomateria )
				";
		
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 2 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 3 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 4 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 5 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 6 , $txtCodigoEstudiante, false );
		//$this->persistencia->setParametro( 3 , $txtCodigoEstudiante, false );*/
		
		//echo $this->persistencia->getSQLListo( )."<br /><br />";
		/*
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_materias" );
		}
		return 0;
	}
	
		*/




			$detallePreMatricula = new DetallePrematricula( $this->persistencia );

			$creditosElectivas = $detallePreMatricula->creditosElectivas( $txtCodigoEstudiante );	
			$creditosObligatorios = $detallePreMatricula->creditosObligatorios( $txtCodigoEstudiante );
			$creditosElectivasVistos = $detallePreMatricula->creditosElectivasVistos( $txtCodigoEstudiante );
			$creditosObligatoriosVistos = $detallePreMatricula->creditosObligatoriosVistos( $txtCodigoEstudiante );
			$pendientes = 0;
			$totalCreditos = $creditosElectivas + $creditosObligatorios;


				if ( $creditosElectivasVistos >= $creditosElectivas ) {
				
					 $creditosElectivasVistos = $creditosElectivas;
				
				} 	


				if ( $creditosObligatoriosVistos >= $creditosObligatorios ){

					$creditosObligatoriosVistos = $creditosObligatorios;			
				} 

			$totalCreditosVistos = $creditosObligatoriosVistos + $creditosElectivasVistos ;
			
			$porcentaje = $totalCreditosVistos * 100;

			return $porcentajeVisto = $porcentaje/$totalCreditos;

		}


   }
?>