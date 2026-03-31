<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */
	include ('../../../kint/Kint.class.php'); 
 class Item{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	/**
	 * @type String
	 * @access private
	 */
	private $modulo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $tipo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type String
	 * @access private
	 */
	private $descripcion;
	
	/**
	 * @type String
	 * @access private
	 */
	private $url;
	
	/**
	 * @type String
	 * @access private
	 */
	private $ruta;
	
	/**
	 * @type String
	 * @access private
	 */
	private $codigo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $orden;
	
	/**
	 * @type Item
	 * @access private
	 */
	private $subMenu;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Item( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del item
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setId( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el id del item
	 * @access public
	 * @return int
	 */
	public function getId( ){
		return $this->id;
	}
	
	/**
	 * Modifica el modulo del item 
	 * @param String $modulo
	 * @access public
	 * @return void
	 */
	public function setModulo ( $modulo ) {
		$this->modulo = $modulo;
	}


	/**
	 * Retorna el modulo del item 
	 * @access public
	 * @return String
	 */
	public function getModulo (  ) {
		return $this->modulo;
	}


	/**
	 * Modifica el tipo del item 
	 * @param String $tipo
	 * @access public
	 * @return void
	 */
	public function setTipo ( $tipo ) {
		$this->tipo = $tipo;
	}


	/**
	 * Retorna el tipo del item 
	 * @access public
	 * @return String
	 */
	public function getTipo (  ) {
		return $this->tipo;
	}


	/**
	 * Modifica el nombre del item 
	 * @param String $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre ( $nombre ) {
		$this->nombre = $nombre;
	}


	/**
	 * Retorna el nombre del item 
	 * @access public
	 * @return String
	 */
	public function getNombre (  ) {
		return $this->nombre;
	}


	/**
	 * Modifica la descripcion del item 
	 * @param String $descripcion
	 * @access public
	 * @return void
	 */
	public function setDescripcion ( $descripcion ) {
		$this->descripcion = $descripcion;
	}


	/**
	 * Retorna la descripcion del item 
	 * @access public
	 * @return String
	 */
	public function getDescripcion (  ) {
		return $this->descripcion;
	}


	/**
	 * Modifica la url del item 
	 * @param String $descripcion
	 * @access public
	 * @return void
	 */
	public function setUrl ( $url ) {
		$this->url = $url;
	}


	/**
	 * Retorna la url del item 
	 * @access public
	 * @return String
	 */
	public function getUrl (  ) {
		return $this->url;
	}


	/**
	 * Modifica la ruta del item 
	 * @param String $ruta
	 * @access public
	 * @return void
	 */
	public function setRuta ( $ruta ) {
		$this->ruta = $ruta;
	}


	/**
	 * Retorna la ruta del item 
	 * @access public
	 * @return String
	 */
	public function getRuta (  ) {
		return $this->ruta;
	}
	

	/**
	 * Modifica el codigo del item 
	 * @param String $codigo
	 * @access public
	 * @return void
	 */
	public function setCodigo ( $codigo ) {
		$this->codigo = $codigo;
	}


	/**
	 * Retorna el codigo del item 
	 * @access public
	 * @return String
	 */
	public function getCodigo (  ) {
		return $this->codigo;
	}


	/**
	 * Modifica el orden del item 
	 * @param int $orden
	 * @access public
	 * @return void
	 */
	public function setOrden ( $orden ) {
		$this->orden = $orden;
	}


	/**
	 * Retorna el orden del item 
	 * @access int
	 * @return String
	 */
	public function getOrden (  ) {
		return $this->orden;
	}


	/**
	 * Modifica el submenu del item 
	 * @param Array<Item> $subMenu
	 * @access public
	 * @return void
	 */
	public function setSubMenu( $subMenu ) {
		$this->subMenu = $subMenu;
	}


	/**
	 * Retorna el orden del item 
	 * @access public
	 * @return Array<Item>
	 */
	public function getSubMenu (  ) {
		return $this->subMenu;
	}
	
	/**
	 * Carga el menu principal
	 * @param Usuario $usuario
	 * @access public 
	 * @return Array<Item>
	 *
	 *Ivan quintero 
	 *ajuste de  consulta 
	 * marzo 24 de 2017
	 */
	public function cargarMenuPrincipal( $userMenu ){
		$items = array( );
		/*
                 * Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
                 * Modificacion de la consulta del menu omitiendo el campo del rol en la tabla PermisoGrados
                 * abril 25 del 2017
                 */
		$sql="
			SELECT
				og.CodigoSistema,
				og.ConsecutivoPadre,
				og.DescripcionObjeto,
				og.NombreObjeto,
				og.ObjetoGradosId,
				og.OrdenObjeto,
				og.RutaObjeto,
				og.UrlObjeto
			FROM
				ObjetoGrados og
			INNER JOIN Permiso p ON p.idComponenteModulo = og.IdComponente
			WHERE
				og.CodigoSistema = 'PD'
			AND og.ConsecutivoPadre IS NULL
			AND p.idUsuario IN (
				SELECT
					u.idusuario
				FROM
					usuario u
				WHERE
					u.usuario = ?
				UNION
					SELECT
						u.codigotipousuario
					FROM
						usuario u
					WHERE
						u.usuario = ?
					UNION
						SELECT
							ur.idrol
						FROM
							usuario u,
							UsuarioTipo ut,
							usuariorol ur
						WHERE
							u.usuario = ?
						AND ut.UsuarioId = u.idusuario
						AND ur.idusuariotipo = ut.UsuarioTipoId
			)
			AND p.ver = 1
			
			group by ObjetoGradosId
		";
                /*end*/
                
		//$this->persistencia->conectar( );
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $userMenu , true );
		$this->persistencia->setParametro( 1 , $userMenu , true );
		$this->persistencia->setParametro( 2 , $userMenu , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$item = new Item( $this->persistencia );
			$item->setId( $this->persistencia->getParametro( "ObjetoGradosId" ) );
			$item->setNombre( $this->persistencia->getParametro( "NombreObjeto" ) );
			$item->setDescripcion( $this->persistencia->getParametro( "DescripcionObjeto" ) );
			$item->setUrl( $this->persistencia->getParametro( "UrlObjeto" ) );
			$item->setRuta( $this->persistencia->getParametro( "RutaObjeto" ) );
			$item->setCodigo( $this->persistencia->getParametro( "CodigoSistema" ) );
			$item->setOrden( $this->persistencia->getParametro( "OrdenObjeto" ) );
			$items[count( $items ) ] = $item;
		}

		return $items;
	}


	/**
	 * Cargar el submenu principal
	 * @param Usuario $usuario
	 * @param int $idPadre
	 * @access public
	 * @return Array<Item>
	 */
	public function cargarSubMenu( $userMenu , $idPadre ){
		$items = array( );
	
		$sql="
			SELECT
					og.CodigoSistema,
					og.ConsecutivoPadre,
					og.DescripcionObjeto,
					og.NombreObjeto,
					og.ObjetoGradosId,
					og.OrdenObjeto,
					og.RutaObjeto,
					og.UrlObjeto
				FROM
					ObjetoGrados og
				INNER JOIN Permiso p ON p.idComponenteModulo = og.IdComponente
				WHERE
					og.CodigoSistema = 'PD'
				AND og.ConsecutivoPadre = ?
				AND p.idUsuario IN (
					SELECT
						u.idusuario
					FROM
						usuario u
					WHERE
						u.usuario = ?
					UNION
						SELECT
							u.codigotipousuario
						FROM
							usuario u
						WHERE
							u.usuario = ?
						UNION
							SELECT
								ur.idrol
							FROM
								usuario u,
								UsuarioTipo ut,
								usuariorol ur
							WHERE
								u.usuario = ?
							AND ut.UsuarioId = u.idusuario
							AND ur.idusuariotipo = ut.UsuarioTipoId
				)
				AND p.ver = 1 
		 		group by ObjetoGradosId";
                /*end*/
		
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idPadre , true );  
        $this->persistencia->setParametro( 1 , $userMenu , true );
        $this->persistencia->setParametro( 2 , $userMenu , true );
        $this->persistencia->setParametro( 3 , $userMenu , true );             
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$item = new Item( $this->persistencia );
			$item->setId( $this->persistencia->getParametro( "ObjetoGradosId" ) );
			$item->setNombre( $this->persistencia->getParametro( "NombreObjeto" ) );
			$item->setDescripcion( $this->persistencia->getParametro( "DescripcionObjeto" ) );
			$item->setUrl( $this->persistencia->getParametro( "UrlObjeto" ) );
			$item->setRuta( $this->persistencia->getParametro( "RutaObjeto" ) );
			$item->setCodigo( $this->persistencia->getParametro( "CodigoSistema" ) );
			$item->setOrden( $this->persistencia->getParametro( "OrdenObjeto" ) );
			$items[count( $items ) ] = $item;
		}
		foreach( $items as $item ){
			$subMenu = $item->cargarSubMenu( $userMenu , $item->getId( ) );
			$item->setSubMenu( $subMenu );
		}
		
		return $items;
	} 
 }
?>