<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class Titulo{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTitulo;
	
	/**
	 * @type string
	 * @access private;
	 */
	private $nombreTitulo;
        /**
	 * @type string
	 * @access private;
	 */
        private $nombreTituloGenero;
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function Titulo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del titulo de la carrera
	 * @param int $codigoTitulo
	 * @access public
	 * @return void
	 */
	public function setCodigoTitulo( $codigoTitulo ){
		$this->codigoTitulo = $codigoTitulo;
	}
	
	/**
	 * Retorna el codigo del titulo de la carrera
	 * @access public
	 * @return int
	 */
	public function getCodigoTitulo( ){
		return $this->codigoTitulo;
	}
	
	/**
	 * Modifica el nombre del titulo de la carrera
	 * @param string $nombreTitulo
	 * @access public
	 * @return void
	 */
	public function setNombreTitulo( $nombreTitulo ){
		$this->nombreTitulo = $nombreTitulo;
	}
	
	/**
	 * Retorna el nombre del titulo de la carrera
	 * @access public
	 * @return string
	 */
	public function getNombreTitulo( ){
		return $this->nombreTitulo;
	}
        /**
	 * Modifica el nombre del titulo de la carrera
	 * @param string $nombreTituloGenero
	 * @access public
	 * @return void
	 */
	public function setNombreTituloGenero( $nombreTituloGenero ) {
            $this->nombreTituloGenero = $nombreTituloGenero;
        }
        /**
	 * Retorna el nombre del titulo de la carrera
	 * @access public
	 * @return string
	 */
        public function getNombreTituloGenero( ) {
            return $this->nombreTituloGenero;
        }
        
        /**
	 * Actualiza el nombre del titulo de la carrera dependiendo el sexo
	 * @param $idTitulo, $nombreTitulo , $nombreTituloGenero , $usuario 
	 * @access public
	 */
        public function actualizarNombreTitulo( $idTitulo, $nombreTitulo , $nombreTituloGenero , $usuario ){
            $sql="UPDATE titulo 
                  SET nombretitulo = ?,
                    nombreTituloGenero = ?,
                    fechaModificacion = now(),
                    usuarioModificacion = ?    
                  WHERE
                    codigotitulo = ?";
            $this->persistencia->crearSentenciaSQL( $sql );
            $this->persistencia->setParametro( 0 , $nombreTitulo , true );
            $this->persistencia->setParametro( 1 , $nombreTituloGenero , true );
            $this->persistencia->setParametro( 2 , $usuario , false );
            $this->persistencia->setParametro( 3 , $idTitulo , false );
            $this->persistencia->ejecutarUpdate( );
            return mysql_affected_rows();
        }
	
   }
?>