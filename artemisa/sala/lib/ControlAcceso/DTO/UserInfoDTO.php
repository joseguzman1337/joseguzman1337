<?php
namespace Sala\lib\ControlAcceso\DTO;
defined('_EXEC') or die;
class UserInfoDTO {
    private $idUsuario;
    private $idRol;
    private $idTipoUsuario;
    
    public function __construct($idUsuario, $idRol, $idTipoUsuario) {
        $this->idUsuario = $idUsuario;
        $this->idRol = $idRol;
        $this->idTipoUsuario = $idTipoUsuario;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdRol() {
        return $this->idRol;
    }

    public function getIdTipoUsuario() {
        return $this->idTipoUsuario;
    }
}
