<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 require_once 'Usuario.php';
 require_once 'Rol.php';
 
 class ControlUsuario{
 	
	private $persistencia;
	
	/**
	 * Constructor 
	 * @param Singleton $persistencia
	 */
	public function ControlUsuario( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Autentica una persona
	 * @param String $user
	 * @param String clave
	 * @return Usuario
	 */
	public function login( $user ){
		$usuario = new Usuario( $this->persistencia );
		$usuario->setUser( $user );
		$usuario->login( );
		return $usuario;
	}
	
	/**
	 * Busca un usuario
	 * @param String $txtUsuario, $txtClave
	 * @access public
	 * @return void
	 */
	public function buscar( $txtUsuario, $txtClave ) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->setUser( $txtUsuario );
		$usuario->setPass( $txtClave );
		$usuario->buscar( );
		return $usuario;
	}
	
	/**
	 * Busca un usuario Estudiante
	 * @param String $txtUsuario, $txtClave
	 * @access public
	 * @return void
	 */
	/*public function buscarUsuarioEstudiante( $txtUsuario, $txtClave ) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->setUser( $txtUsuario );
		$usuario->setPass( $txtClave );
		$usuario->buscarUsuarioEstudiante( );
		return $usuario;
	}*/
	
	/**
	 * Busca un usuario por Id
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarId( $idPersona ) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->setId( $idPersona );
		$usuario->buscarId( );
		return $usuario;
	}
	
	
	/**
	 * Actualiza la clave un usuario
	 * @param int $idPersona
	 * @param String $txtUsuario
 	 * @param String $txtClave
 	 * @access public
 	 * @return void
	 */
	public function actualizarClave( $idPersona , $txtUsuario , $txtClave) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->setId( $idPersona );
		$usuario->setUser( $txtUsuario );
		$usuario->setPass( base64_encode( $txtClave ) );
		return $usuario->actualizarClave( );
	}
	
	/**
	 * Busca un usuario por Id
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarRecuperar( $user ) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->setUser($user);
		$usuario->buscarRecuperar( );
		return $usuario;
	}
	
	/**
	 * Consulta Usuarios Directivos, Coordinadores y Decanos
	 * @access public
	 * @return Array<Usuarios>
	 */
	public function consultarUsuariosFacultad( $codigoFacultad, $codigoCarrera ){
		$usuario = new Usuario( $this->persistencia );
		return $usuario->consultarUsuariosFacultad( $codigoFacultad, $codigoCarrera );
	}
	
	/**
	 * Busca usuario Decano por Carrera
	 * @param String $txtCodigoCarrera
	 * @access public
	 * @return Usuario
	 */
	public function buscarUsuarioDecano( $txtCodigoCarrera ) {
		$usuario = new Usuario( $this->persistencia );
		
		$carrera = new Carrera( null  );
		$carrera->setCodigoCarrera( $txtCodigoCarrera );
		
		$usuario->setCarrera( $carrera );
		
		$usuario->buscarUsuarioDecano( );
		
		return $usuario;
	}
	
	/**
	 * Existe Secretaria
	 * @param $txtUsuario
	 * @access public
	 * @return void 
	 */
	public function existeSecretaria( $txtIdRol, $txtUsuario ){
		$rol = new Rol( $this->persistencia );
		return $rol->buscarSecretaria( $txtIdRol, $txtUsuario );
	}
	
	/**
	 * Busca usuario por Documento
	 * @param String $txtNumeroDocumento
	 * @access public
	 * @return Usuario
	 */
	public function buscarUsuarioDocumento( $txtNumeroDocumento ) {
		$usuario = new Usuario( $this->persistencia );
		$usuario->buscarUsuarioDocumento( $txtNumeroDocumento );
		return $usuario;
	}
 	
 }
?>