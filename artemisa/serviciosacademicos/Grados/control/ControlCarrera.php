<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 include '../entidades/Carrera.php';
 include '../entidades/ModalidadAcademica.php';
 include '../entidades/ModalidadSIC.php';
 include '../entidades/TituloProfesion.php';
 
 class ControlCarrera{
 	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlCarrera( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta las carreras
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultar( $idFacultad ){
		$carrera = new Carrera( $this->persistencia );
		return $carrera->consultarCarrera( $idFacultad );
	}
	
	/**
	 * Consulta las carreras por usuario
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarreraUsuario( $idPersona, $idFacultad ){
		$carrera = new Carrera( $this->persistencia );
		return $carrera->consultarCarreraUsuario($idPersona, $idFacultad );
	}
	
	/**
	 * Busca una Carrera por Código
	 * @param int $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarCarrera( $txtCodigoCarrera ) {
		$carrera = new Carrera( $this->persistencia );
		$carrera->setCodigoCarrera($txtCodigoCarrera);
		$carrera->buscar( );
		return $carrera;
	}
	
	/**
	 * Consulta las carreras existentes en la universidad para notificar
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarreraNotificar( ){
		$carrera = new Carrera( $this->persistencia );
		return $carrera->consultarCarreraNotificar( );
	}
	
	/**
	 * Busca Titulo de una Profesion por CodigoCarrera
	 * @param int $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarTituloProfesion( $txtCodigoCarrera ) {
		$carrera = new Carrera( $this->persistencia );
		$carrera->setCodigoCarrera($txtCodigoCarrera);
		$carrera->buscarTituloProfesion( );
		return $carrera;
	}
	
	/**
	 * Consulta las carreras existentes dependiendo la modalidad y la facultad
	 * @access public
	 * @return Array<Carrera>
	 */
	public function buscarCarreras ( $modalidad , $facultad ) {
		$carrera = new Carrera( $this->persistencia );
		return $carrera->consultarTodaCarrera( $modalidad , $facultad );
	}
	
	public function Snies( $codigoCarrera){
		$carrera = new Carrera( $this->persistencia  );
		$carrera->carreraSnies( $codigoCarrera );
		return $carrera; 
	}
        /**
	 * Actualizar nombre del titulo a obtener 
	 * @param int $idTitulo, $usuario
         * @param varchar $nombreTitulo , $nombreTituloGenero  
	 * @access public
	 * @return void
	 */
        public function actualizarTituloCarrera( $idTitulo, $nombreTitulo , $nombreTituloGenero , $usuario  ){
            $titulo = new Titulo( $this->persistencia  );
            return $titulo->actualizarNombreTitulo( $idTitulo , $nombreTitulo , $nombreTituloGenero , $usuario );
        }
 }
?>