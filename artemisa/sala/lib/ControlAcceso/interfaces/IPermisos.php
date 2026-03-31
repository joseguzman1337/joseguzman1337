<?php

namespace Sala\lib\ControlAcceso\interfaces;

defined('_EXEC') or die;

/**
 * Interface IPermisos muestra el contrado necesario para la orquestacion de los
 * permisos dentro de sala
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\ControlAcceso\interfaces
 */
interface IPermisos {
    public function getPermisos($relacionUsuario, $tipoPermiso, $id);
    
    public function checkPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action);
    
    public static function validarPermisiosModuloUsuario($idUsuario, $idModulo, $accion );

    public static function validarPermisosComponenteUsuario($Usuario, $idComponente, $accion );
    
    public static function validarPermisosComponenteRol($idRol, $idComponente, $accion);
    
    public static function validarPermisosComponenteTipoUsuario($idTipoUsuario, $idComponente, $accion);
}
