<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
include '../entidades/Item.php';
include '../entidades/PermisoGrados.php';

class ControlItem {

    /**
     * @type String
     * @access private
     */
    private $persistencia;

    /**
     * @type Singleton
     * @access private
     */
    public function ControlItem($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Carga el menu principal
     * @param Usuario $usuario
     * @access public
     * @return Array<Item>
     */
    public function cargarMenu($userMenu) {
        $item = new Item($this->persistencia);
        return $item->cargarMenuPrincipal($userMenu);
    }

    /**
     * Carga el submenu principal
     * @param Usuario $usuario
     * @param int $idPadre
     * @access public
     * @return Arrray<Item>
     */
    public function cargarSubMenu($userMenu, $idPadre) {
        $item = new Item($this->persistencia);
        return $item->cargarSubMenu($userMenu, $idPadre);
    }

    /**
     * Carga las diferentes opciones del menu de grados
     * @param int $rol
     * @access public
     * @return Arrray<Item>
     */
    public function verPermiso($rol) {
        $item = new Item($this->persistencia);
        return $item->verPermiso($rol);
    }

    /**
     * Verifica si existe el permiso para el rol para identifica si debe insertar o actualizar
     * @param int $estado 
     * @param int $rol
     * @param int $permiso
     * @access public
     * @return int 
     */
    public function verificarPermiso($estado, $rol, $permiso, $idPersona) {
        $permisoGrados = new PermisoGrados($this->persistencia);
        return $permisoGrados->verificarPermiso($estado, $rol, $permiso, $idPersona);
    }

}

?>