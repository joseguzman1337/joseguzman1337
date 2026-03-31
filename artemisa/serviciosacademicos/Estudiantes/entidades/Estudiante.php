<?php
/**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */ 
  
   
   class Estudiante extends EstudianteGeneral{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoEstudiante;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $fechaGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $semestre;
	
	/**
	 * @type Cohorte
	 * @access private
	 */
	private $cohorte;
	
	/**
	 * @type SituacionCarreraEstudiante
	 * @access private
	 */
	private $situacionCarreraEstudiante;
	
	/**
	 * @type PreMatricula
	 * @access private
	 */
	private $preMatricula;
	
	/**
	 * @type Usuario
	 * @access private
	 */
	private $usuario;
		/**
	 * @type codigoMayor
	 * @access private
	 */
	private $codigoMayor;
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia; 
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Estudiante( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el Codigo del Estudiante
	 * @param int $codigoEstudiante
	 * @access public
	 * @return void
	 */
	public function setCodigoEstudiante( $codigoEstudiante ){
		$this->codigoEstudiante = $codigoEstudiante;
	}
	
	/**
	 * Retorna el Codigo del Estudiante
	 * @access public
	 * @return int
	 */
	public function getCodigoEstudiante( ){
		return $this->codigoEstudiante;
	}
	
	/**
	 * Modifica la carrera del Estudiante
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setFechaGrado( $fechaGrado ){
		$this->fechaGrado = $fechaGrado;
	}
	
	/**
	 * Retorna la carrera del Estudiante
	 * @access public
	 * @return Carrera
	 */
	public function getFechaGrado( ){
		return $this->fechaGrado;
	}
	
	/**
	 * Modifica el semestre del Estudiante
	 * @param int $semestre
	 * @access public
	 * @return void
	 */
	public function setSemestre( $semestre ){
		$this->semestre = $semestre;
	}
	
	/**
	 * Retorna el semestre del Estudiante
	 * @access public
	 * @return int
	 */
	public function getSemestre( ){
		return $this->semestre;
	}
	
	/**
	 * Modifica el cohorte del estudiante
	 * @param Cohorte $cohorte
	 * @access public
	 * @return void
	 */
	public function setCohorte( $cohorte ){
		$this->cohorte = $cohorte;
	}
	
	/**
	 * Retorna el cohorte del estudiante
	 * @access public
	 * @return Cohorte
	 */
	public function getCohorte( ){
		return $this->cohorte;
	}
	
	/**
	 * Modifica la Situacion de la Carrera del Estudiante
	 * @param SituacionCarreraEstudiante $situacionCarreraEstudiante
	 * @access public
	 * @return void
	 */
	public function setSituacionCarreraEstudiante( $situacionCarreraEstudiante ){
		$this->situacionCarreraEstudiante = $situacionCarreraEstudiante;
	}
	
	/**
	 * Retorna la Situacion de la Carrera del Estudiante
	 * @access public
	 * @return SituacionCarreraEstudiante
	 */
	public function getSituacionCarreraEstudiante( ){
		return $this->situacionCarreraEstudiante;
	}
	
	/**
	 * Modifica el Usuario del Estudiante
	 * @param usuario $usuario
	 * @access public
	 * @return void
	 */
	public function setUsuarioEstudiante( $usuario ){
		$this->usuario = $usuario;
	}
	
	/**
	 * Retorna el Usuario del Estudiante
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioEstudiante( ){
		return $this->usuario;
	}
	
	/**
	 * Modifica la prematricula del estudiante
	 * @param PreMatricula $preMatricula
	 * @access public
	 * @return void
	 */
	public function setPreMatricula( $preMatricula ){
		$this->preMatricula = $preMatricula;
	}
	
	/**
	 * Retorna la prematricula del estudiante
	 * @access public
	 * @return PreMatricula
	 */
	public function getPreMatricula( ){
		return $this->preMatricula;
	}
	
	public function setCodigoMayor($codigoMayor){
		$this->codigoMayor=$codigoMayor;
	}
	
	public function getCodigoMayor(){
		return $this->codigoMayor;
	}
	
	
 	/**
	 * Buscar codigoestudiantes
	 * @param $idestudiantegeneral
	 * @access public
	 * @return array
	 */
	
	public function buscarEstudiante( $idestudiantegeneral,$idestudianteantiguo ){
		$estudiante = array( );
		$sql="SELECT
			 	codigoestudiante
			  FROM
				estudiante
			  WHERE
				estudiante.idestudiantegeneral = ? ";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idestudiantegeneral , false );
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){					
		$estudiantes=new Estudiante( $this->persistencia);	
		$estudiantes->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
		$estudiante[]=$estudiantes;		
		}
		$this->persistencia->freeResult( );
		return $estudiante;
	
		 	}
	
	/**
	 * Consultar codigo de estudiante actual y codigos anteriores 
	 * @access public
	 * @return array
	 */
		public function buscarEstudianteActual( $idestudiantegeneral,$idestudianteantiguo ){
		$estudiante = array( );
		$sql="
				SELECT
			  codigoestudiante,
			 (  SELECT
			 		 max(codigoestudiante) 
			 	FROM 
			 		 estudiante  
			 	WHERE 
			 	     estudiante.idestudiantegeneral = ? ) as codigonuevo 
			  FROM
				estudiante
			  WHERE
				estudiante.idestudiantegeneral in ( ?,? )  and codigoestudiante<> (  SELECT
			 		 max(codigoestudiante) 
			 	FROM 
			 		 estudiante  
			 	WHERE 
			 	     estudiante.idestudiantegeneral in ( ?,? ))
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idestudiantegeneral , false );
		$this->persistencia->setParametro( 1 , $idestudianteantiguo, false );
		$this->persistencia->setParametro( 2 , $idestudiantegeneral , false );
		$this->persistencia->setParametro( 3 , $idestudianteantiguo , false );
		$this->persistencia->setParametro( 4 , $idestudiantegeneral , false );
		$this->persistencia->ejecutarConsulta( );
		
		while( $this->persistencia->getNext( ) ){					
		$estudiantes = new Estudiante( $this->persistencia);	
		$estudiantes->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
		$estudiantes->setCodigoMayor( $this->persistencia->getParametro( "codigonuevo" ) );
		$estudiante[] = $estudiantes;		
		}
		$this->persistencia->freeResult( );
		return $estudiante;
	
		 	}
	
	
	/**
	 * actualiza idestudiantegeneral en tabla estudiante
	 * @param int $codigoEstudiante,$idestudiantegeneral
	 * @access public
	 * @return void
	 */
	
	public function actualizarIdEstudianteGeneral( $codigoEstudiante , $idestudiantegeneral ){
			$sql="UPDATE 
					estudiante 
				  SET 
				  	idestudiantegeneral=?
				  WHERE
				  	codigoestudiante =?  ";		
			
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $idestudiantegeneral , false );	
			$this->persistencia->setParametro( 1 , $codigoEstudiante , false );
			
			$estado = $this->persistencia->ejecutarUpdate( );
		
			if( $estado ){
				$this->persistencia->confirmarTransaccion( );
			}else{	
				$this->persistencia->cancelarTransaccion( );
			}	
		
			return $estado;	
			}
	
	  }


 
?>