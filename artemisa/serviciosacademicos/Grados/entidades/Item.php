<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */
class Item {

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
    public function Item($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Modifica el id del item
     * @param int $id
     * @access public
     * @return void
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Retorna el id del item
     * @access public
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Modifica el modulo del item 
     * @param String $modulo
     * @access public
     * @return void
     */
    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    /**
     * Retorna el modulo del item 
     * @access public
     * @return String
     */
    public function getModulo() {
        return $this->modulo;
    }

    /**
     * Modifica el tipo del item 
     * @param String $tipo
     * @access public
     * @return void
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    /**
     * Retorna el tipo del item 
     * @access public
     * @return String
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Modifica el nombre del item 
     * @param String $nombre
     * @access public
     * @return void
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Retorna el nombre del item 
     * @access public
     * @return String
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Modifica la descripcion del item 
     * @param String $descripcion
     * @access public
     * @return void
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    /**
     * Retorna la descripcion del item 
     * @access public
     * @return String
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Modifica la url del item 
     * @param String $descripcion
     * @access public
     * @return void
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * Retorna la url del item 
     * @access public
     * @return String
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Modifica la ruta del item 
     * @param String $ruta
     * @access public
     * @return void
     */
    public function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    /**
     * Retorna la ruta del item 
     * @access public
     * @return String
     */
    public function getRuta() {
        return $this->ruta;
    }

    /**
     * Modifica el codigo del item 
     * @param String $codigo
     * @access public
     * @return void
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    /**
     * Retorna el codigo del item 
     * @access public
     * @return String
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Modifica el orden del item 
     * @param int $orden
     * @access public
     * @return void
     */
    public function setOrden($orden) {
        $this->orden = $orden;
    }

    /**
     * Retorna el orden del item 
     * @access int
     * @return String
     */
    public function getOrden() {
        return $this->orden;
    }

    /**
     * Modifica el submenu del item 
     * @param Array<Item> $subMenu
     * @access public
     * @return void
     */
    public function setSubMenu($subMenu) {
        $this->subMenu = $subMenu;
    }

    /**
     * Retorna el orden del item 
     * @access public
     * @return Array<Item>
     */
    public function getSubMenu() {
        return $this->subMenu;
    }

    /**
     * Carga el menu principal
     * @param Usuario $usuario
     * @access public 
     * @return Array<Item>
     */
    public function cargarMenuPrincipal($userMenu) {
        $items = array();
        /* @modified Diego Rivera<riveradiego@unbosque.edu.co>
         * Se añade estadoPermiso(100 activo , 200 inactivo) en tabla PermisoGrados P.estadoPermiso=100 permite visualizar la opcion en el menu
         * @since December 7,2018
         */
        $sql = "SELECT
                            O.CodigoRol,
                            O.CodigoSistema,
                            O.ConsecutivoPadre,
                            O.DescripcionObjeto,
                            O.NombreObjeto,
                            O.ObjetoGradosId,
                            O.OrdenObjeto,
                            O.RutaObjeto,
                            O.UrlObjeto
                        FROM
                            ObjetoGrados O
                        inner join PermisoGrados P ON P.ObjetoGradosId = O.ObjetoGradosId
                        inner join usuariorol UR ON P.RolId = UR.idrol
                        inner join UsuarioTipo UT ON UT.UsuarioTipoId = UR.idusuariotipo
                        inner join usuario U on U.idusuario = UT.UsuarioId
                        WHERE
                                U.usuario = ?
                        AND O.CodigoSistema = 'GA'
                        AND O.ConsecutivoPadre IS NULL
                        AND P.estadoPermiso=100
                        ORDER BY
                                O.OrdenObjeto";

        //$this->persistencia->conectar( );
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $userMenu, true);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $item = new Item($this->persistencia);
            $item->setId($this->persistencia->getParametro("ObjetoGradosId"));
            $item->setNombre($this->persistencia->getParametro("NombreObjeto"));
            $item->setDescripcion($this->persistencia->getParametro("DescripcionObjeto"));
            $item->setUrl($this->persistencia->getParametro("UrlObjeto"));
            $item->setRuta($this->persistencia->getParametro("RutaObjeto"));
            $item->setCodigo($this->persistencia->getParametro("CodigoSistema"));
            $item->setOrden($this->persistencia->getParametro("OrdenObjeto"));
            $items[count($items)] = $item;
        }
        foreach ($items as $item) {
            $subMenu = $item->cargarSubMenu($userMenu, $item->getId());
            $item->setSubMenu($subMenu);
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
    public function cargarSubMenu($userMenu, $idPadre) {
        $items = array();
        /* @modified Diego Rivera<riveradiego@unbosque.edu.co>
         * Se añade estadoPermiso(100 activo , 200 inactivo) en tabla PermisoGrados P.estadoPermiso=100 permite visualizar la opcion en el menu
         * @since December 7,2018
         */
        $sql = "SELECT
                            O.CodigoRol,
                            O.CodigoSistema,
                            O.ConsecutivoPadre,
                            O.DescripcionObjeto,
                            O.NombreObjeto,
                            O.ObjetoGradosId,
                            O.OrdenObjeto,
                            O.RutaObjeto,
                            O.UrlObjeto
                        FROM
                                ObjetoGrados O
                        inner join PermisoGrados P ON P.ObjetoGradosId = O.ObjetoGradosId
                        inner join usuariorol UR ON P.RolId = UR.idrol
                        inner join UsuarioTipo UT ON UT.UsuarioTipoId = UR.idusuariotipo
                        inner join usuario U on U.idusuario = UT.UsuarioId
                        WHERE
                                U.usuario = ?
                        AND O.CodigoSistema = 'GA'
                        AND O.ConsecutivoPadre = ?
                        AND P.estadoPermiso= 100
                        ORDER BY
                                O.OrdenObjeto";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $userMenu, true);
        $this->persistencia->setParametro(1, $idPadre, true);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $item = new Item($this->persistencia);
            $item->setId($this->persistencia->getParametro("ObjetoGradosId"));
            $item->setNombre($this->persistencia->getParametro("NombreObjeto"));
            $item->setDescripcion($this->persistencia->getParametro("DescripcionObjeto"));
            $item->setUrl($this->persistencia->getParametro("UrlObjeto"));
            $item->setRuta($this->persistencia->getParametro("RutaObjeto"));
            $item->setCodigo($this->persistencia->getParametro("CodigoSistema"));
            $item->setOrden($this->persistencia->getParametro("OrdenObjeto"));
            $items[count($items)] = $item;
        }
        foreach ($items as $item) {
            $subMenu = $item->cargarSubMenu($userMenu, $item->getId());
            $item->setSubMenu($subMenu);
        }
        return $items;
    }

    /* @modified Diego Rivera<riveradiego@unbosque.edu.co>
     * Consulta los permisos actuales dependiendo el rol
     * @since December 7,2018
     */

    public function verPermiso($codigoRol) {
        $permiso = array();

        $sql = "SELECT
                            ObjetoGrados.ObjetoGradosId,
                            ObjetoGrados.NombreObjeto,
                            PermisoGrados.estadoPermiso,
                            ObjetoGrados.DescripcionObjeto
                    FROM
                            ObjetoGrados
                            LEFT JOIN PermisoGrados ON ( ObjetoGrados.ObjetoGradosId = PermisoGrados.ObjetoGradosId AND PermisoGrados.RolId = ? ) 
                    WHERE
                            ObjetoGrados.CodigoSistema = 'GA' 
                            AND ObjetoGrados.ObjetoGradosId <> 15";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $codigoRol, false);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $item = new Item($this->persistencia);
            $item->setId($this->persistencia->getParametro("ObjetoGradosId"));
            $item->setNombre($this->persistencia->getParametro("NombreObjeto"));
            $item->setCodigo($this->persistencia->getParametro("estadoPermiso"));
            $item->setDescripcion($this->persistencia->getParametro("DescripcionObjeto"));
            $permiso[] = $item;
        }
        return $permiso;
    }

}

?>