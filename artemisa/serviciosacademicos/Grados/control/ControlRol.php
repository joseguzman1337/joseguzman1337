<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
require_once '../entidades/Rol.php';

class ControlRol {

    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function ControlRol($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Busca roles
     * @access public
     * @return array
     */
    public function verRol() {
        $rol = new Rol($this->persistencia);
        return $rol->verRoles();
    }

}

?>