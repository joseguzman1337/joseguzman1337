<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 
 require_once("Persona.php");
 require_once("Carrera.php");
 class Usuario extends Persona{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $iduser;
 	
	/**
	 * @type String 
	 * @access private
	 */
	private $user;
	
	/**
	 * $type String
	 * @access private
	 */
	private $pass;
	
	/**
	 * @type String
	 * @access private
	 */
	private $rol;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Usuario( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id de la Persona
	 * @access public
	 * @return void
	 */ 
	public function setIduser( $iduser ){
		$this->iduser = $iduser;
	}
	 
	/**
	 * Retorna el id de la Persona
	 * @param int $id
	 * @access public
	 * @return int
  	 */
	public function getIduser( ){
		return $this->iduser;
	}
	
	/**
	 * Modifica el nombre de usuario del usuario
	 * @param String $usuario
	 * @access public
	 * @return void
	 */
	public function setUser( $user ){
		$this->user = $user;
	}
	
	/**
	 * Retorna el nombre de usuario del usuario
	 * @access public
	 * @return String
	 */
	public function getUser( ){
		return $this->user;
	}
	
	/**
	 * Modifica la clave del usuario
	 * @param String $clave
	 * @access public
	 * @return void
	 */
	public function setPass( $pass ){
		$this->pass = $pass;
	}
	
	/**
	 * Retorna la clave del usuario
	 * @access public 
	 * @return String
	 */
	public function getPass( ){
		return $this->pass;
	}
	
	
	/**
	 * Modifica el rol del usuario 
	 * @param Rol $rol
	 * @access public
	 * @return void
	 */
	public function setRol ( $rol ) {
		$this->rol = $rol;
	}


	/**
	 * Retorna el rol del usuario 
	 * @access public
	 * @return Rol
	 */
	public function getRol (  ) {
		return $this->rol;
	}
	
	/**
	 * Modifica la carrera del usuario 
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera ( $carrera ) {
		$this->carrera = $carrera;
	}

	/**
	 * Retorna la carrera del usuario 
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera (  ) {
		return $this->carrera;
	}
	
	
	/**
	 * Funcion Autenticar Usuario
	 */
	public function login( ){
		$sql = "SELECT U.idusuario
				FROM usuario U
				WHERE U.usuario = ?
				";
		$this->persistencia->conectar( );
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	
	/**
	 * Busca un usuario por Id
	 * @access public
	 * @return void
	 */
	public function buscarId( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				WHERE U.idusuario = ?
				AND U.codigorol = 3";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getId( ) , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
		
	}
	
	/**
	 * Busca un usuario por usuario
	 * @access public
	 * @return void
	 */
	public function buscar( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol, CU.claveusuario, 
				F.codigofacultad, F.nombrefacultad
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				INNER JOIN claveusuario CU ON ( CU.idusuario = U.idusuario )
				INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				WHERE U.usuario = ?
				AND CU.claveusuario = ?
				AND U.codigorol = 3
				AND CU.codigoestado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		$this->persistencia->setParametro( 1 , $this->getPass( ) , true );
		//echo $this->persistencia->getSQLListo( ); exit( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( $this->persistencia );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
			
			$carrera = new Carrera( $this->persistencia );
			$facultad = new Facultad( $this->persistencia );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			
			$carrera->setFacultad($facultad);
			
			$this->setCarrera( $carrera );
		}
		
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Busca un usuario por usuario
	 * @access public
	 * @return void
	 */
	/*public function buscarUsuarioEstudiante( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol, CU.claveusuario
				FROM usuario U
				INNER JOIN rol R ON ( R.idrol = U.codigorol )
				INNER JOIN claveusuario CU ON ( CU.idusuario = U.idusuario )
				WHERE U.usuario = ?
				AND CU.claveusuario = ?
				AND U.codigorol = 1
				AND CU.codigoestado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		$this->persistencia->setParametro( 1 , $this->getPass( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
		}
		
		$this->persistencia->freeResult( );
	}*/
	
	
	
	/**
	 * Actualiza la clave un usuario
	 * @access public
	 * @return void
	 */
	public function actualizarClave ( ) {
		$sql = "UPDATE usuario 
				SET pass_usua = ? 
				WHERE codi_sist = 'CA'
				AND fech_fina is null
				AND logi_usua = ?
				AND iden_pers = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $this->getPass( ) , true );
		$this->persistencia->setParametro( 1 , $this->getUser( ) , true );
		$this->persistencia->setParametro( 2 , $this->getId( ) , true );
		
		$this->persistencia->ejecutarUpdate( );
		
		$this->persistencia->confirmarTransaccion( );

	}
	
	
	/**
	 * Busca un usuario por Id
	 * @access public
	 * @return void
	 */
	public function buscarRecuperar( ){
		$sql = "SELECT U.iden_pers, F.nom1_func, F.nom2_func, F.ape1_func, F.ape2_func , U.logi_usua , U.pass_usua , 
						R.codi_rol, R.nomb_rol, R.desc_rol, R.priv_rol
				FROM usuario U, funcionario F, rol R
				WHERE U.logi_usua = ?
				AND U.codi_sist = 'CA'
				AND U.fech_fina is null
				AND F.iden_pers = U.iden_pers
				AND U.codi_rol = R.codi_rol";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "iden_pers" ) );
			$this->setNombre1( $this->persistencia->getParametro( "nom1_func" ) );
			$this->setNombre2( $this->persistencia->getParametro( "nom2_func" ) );
			$this->setApellido1( $this->persistencia->getParametro( "ape1_func" ) );
			$this->setApellido2( $this->persistencia->getParametro( "ape2_func" ) );
			$this->setUser( $this->persistencia->getParametro( "logi_usua" ) );
			$this->setPass( $this->persistencia->getParametro( "pass_usua" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "codi_rol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nomb_rol" ) );
			$rol->setRelacion( $this->persistencia->getParametro( "desc_rol" ) );
			$this->setRol( $rol );
		}
	}


	/**
	 * Consulta Usuarios Decanos, Coordinadores, Secretarios por Facultad
	 * @access public
	 * @return Array
	 */
	public function consultarUsuariosFacultad( $codigoFacultad, $codigoCarrera ){
		$usuarios = array( );
		$sql = "SELECT DISTINCT
					U.usuario, F.codigofacultad, F.nombrefacultad, C.codigocarrera, C.nombrecarrera
				FROM
					usuario U
				INNER JOIN usuariofacultad UF ON ( U.usuario = UF.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				WHERE
					UR.idrol = 93
				AND C.codigomodalidadacademica IN (200,300)
				AND F.codigofacultad = ?
				AND C.codigocarrera = ?
				AND U.idusuario != 47327
				GROUP BY
					U.idusuario";
					
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $codigoFacultad , false );
		$this->persistencia->setParametro( 1 , $codigoCarrera , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$usuario = new Usuario( $this->persistencia );
			$usuario->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$facultad = new Facultad( null );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$carrera->setFacultad( $facultad );
			
			$usuario->setCarrera( $carrera );
			
			$usuarios[ count( $usuarios ) ] = $usuario;
		}
		$this->persistencia->freeResult( );
		
		return 	$usuarios;		
	}


	/**
	 * Buscar Usuario Decano
	 * @param $txtCodigoCarrera
	 * @access public 
	 * @return void
	 */
	public function buscarUsuarioDecano( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				WHERE UF.codigofacultad = ?
				AND U.codigorol = 3
				AND R.idrol = 93
				AND U.nombres like 'De%'
				AND U.fechavencimientousuario >= CURDATE()
				AND U.idusuariopadre = 0";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCarrera( )->getCodigoCarrera( ) , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	/**
	 * Buscar Usuario por Documento
	 * @param $txtNumeroDocumento
	 * @access public 
	 * @return void
	 */
	public function buscarUsuarioDocumento( $txtNumeroDocumento ){
		$sql = "SELECT idusuario, usuario
				FROM usuario
				WHERE numerodocumento = ?
				AND codigotipousuario = 600";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtNumeroDocumento , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	
	
 }
?>