<?php

namespace Sala\lib\ControlAcceso\impl;

defined('_EXEC') or die;

/**
 * Clase Permisos encargada de la orquestacion de los permisos dentro de sala
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\ControlAcceso
 */
class PermisosImpl implements \Sala\lib\ControlAcceso\interfaces\IPermisos {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    private $userInfoDTO;
    private $idComponente;
    private $accion;
    
    public function __construct() {
        $this->setDb();
    }
    
    public function setDb() {
        $this->db = \Factory::createDbo();
    }
    
    public function getUserInfoDTO() {
        return $this->userInfoDTO;
    }

    public function setUserInfoDTO($userInfoDTO) {
        $this->userInfoDTO = $userInfoDTO;
    }
    
    public function getIdComponente() {
        return $this->idComponente;
    }

    public function setIdComponente($idComponente) {
        $this->idComponente = $idComponente;
    }
    
    public function getAccion() {
        return $this->accion;
    }

    public function setAccion($accion) {
        $this->accion = $accion;
    }

    public function getPermisos($relacionUsuario=null, $tipoPermiso=null, $id=null) {
        $return = null;
        if(!empty($this->userInfoDTO)){
            $whereArray = array();
            $where = "";
            if(!empty($id)){
                $whereArray[] = 'p.id = '.$this->db->qstr($id); 
            }
            if(!empty($relacionUsuario)){ 
                $whereArray[] = 'p.idRelacionUsuario = '.$this->db->qstr($relacionUsuario);
            }
            if(!empty($this->userInfoDTO)){ 
                $whereArray[] = 'p.idUsuario = '.$this->getWhereIdUsuario($relacionUsuario);
            }
            if(!empty($this->idComponente)){
                $whereArray[] = 'p.idComponenteModulo = '.$this->db->qstr($this->idComponente);
            }
            if(!empty($tipoPermiso)){
                $whereArray[] = 'tp.nombre = '.$this->db->qstr($tipoPermiso);
            }
            if(!empty($whereArray)){
                    $where = implode(' AND ',$whereArray);
            }
            $permisos =  \Sala\entidad\Permiso::getList($where);
            if(!empty($permisos)){
                $return = $permisos[0];
            }            
        }        
        return $return;
    }
    
    public function checkPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action) {
        $permiso =  $this->getPermisos($relacionUsuario, $idUsuario, $idComponent, $tipoPermiso, $action); 
        
        if(!empty($action)){
            $permisoAccion = $permiso->{'get'.ucfirst($action)}() ; 
            return $permisoAccion;
        }else{
            return $permiso;
        }
    }
       

    public static function validarPermisiosModuloUsuario($idUsuario, $idModulo, $accion) {
        
    }

    public static function validarPermisosComponenteRol($idRol, $idComponente, $accion) {
        
    }

    public static function validarPermisosComponenteTipoUsuario($idTipoUsuario, $idComponente, $accion) {
        
    }

    public static function validarPermisosComponenteUsuario($Usuario, $idComponente, $accion=null) {
        $Permisos = new PermisosImpl();
        $Permisos->setIdComponente($idComponente);
        $Permisos->setAccion($accion);
             
        $userInfoDAO = new \Sala\lib\ControlAcceso\DAO\UserInfoDAO();
        $Permisos->setUserInfoDTO($userInfoDAO->getInfo($Usuario));
        
        $countPerisos = $Permisos->countAllPermisosPara("componentes");
        return !empty($countPerisos);
        
    }
    
    private function countAllPermisosPara($tipoPermiso,$relacionUsuario=3){
        $countPerisos = 0;
        if($relacionUsuario>=1){
            $PermisoUsuario = $this->getPermisos($relacionUsuario, $tipoPermiso);
            if(!empty($PermisoUsuario)){
                if(empty($this->accion)){
                    $countPerisos += $PermisoUsuario->getVer() + $PermisoUsuario->getEditar() + $PermisoUsuario->getInsertar() + $PermisoUsuario->getEliminar();
                }else{
                    $countPerisos += $PermisoUsuario->{"get".ucfirst($this->accion)}();
                }
                if(!empty($countPerisos)){
                    $countPerisos += $this->countAllPermisosPara($tipoPermiso, ($relacionUsuario-1));
                }
            }else{
                $countPerisos += $this->countAllPermisosPara($tipoPermiso, ($relacionUsuario-1));
            }
        }
        return $countPerisos;
    }
    
    private function validarPermisosPorNivel($nivel,$idTipoUsuario, $idComponente, $tipo, $accion){
        $Permisos = new PermisosImpl();
        
        //validamos los permisos del usuario a nivel Usuario Especifico para el componente, idRelacionUsuario = 3
        $PermisoUsuario = $Permisos->getPermisos(3,$idUsuario, $idComponente, "componentes", $accion);
        //d($PermisoUsuario);
        if(empty($accion)){
            $countPerisos = $PermisoUsuario->getVer() + $PermisoUsuario->getEditar() + $PermisoUsuario->getInsertar() + $PermisoUsuario->getEliminar();
        }else{
            $countPerisos = $PermisoUsuario->{"get".ucfirst($accion)}();
        }
    }
    
    private function getWhereIdUsuario($relacionUsuario){
        $return  = "";
        switch ($relacionUsuario){
            case 1 :
                $return = $this->db->qstr($this->userInfoDTO->getIdTipoUsuario());
                break;
            case 2 :
                $return = $this->db->qstr($this->userInfoDTO->getIdRol());
                break;
            case 3 :
                $return = $this->db->qstr($this->userInfoDTO->getIdUsuario());
                break;
        }
        return $return;
    }

}
