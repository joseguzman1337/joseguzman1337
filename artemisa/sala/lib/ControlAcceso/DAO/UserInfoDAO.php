<?php
namespace Sala\lib\ControlAcceso\DAO;
defined('_EXEC') or die;
class UserInfoDAO {
    private $db;
    
    public function __construct() { 
        $this->db = \Factory::createDbo();
        //ddd($this->db);
    }
    
    public function getInfo($Usuario){
        $userInfoDTO = null;
        $sql = "SELECT u.idusuario, r.idrol, tu.codigotipousuario
                  FROM usuario u
            INNER JOIN UsuarioTipo ut ON ( ut.UsuarioId  = u.idusuario )
            INNER JOIN tipousuario tu ON ( tu.codigotipousuario = ut.CodigoTipoUsuario )
            INNER JOIN usuariorol ur ON ( ur.idusuariotipo=ut.UsuarioTipoId )
            INNER JOIN rol r ON (r.idrol = ur.idrol)
                 WHERE u.usuario = ".$this->db->qstr($Usuario);
        
        $data = $this->db->GetRow($sql);
        
        if(!empty($data)){
            $userInfoDTO = new \Sala\lib\ControlAcceso\DTO\UserInfoDTO($data['idusuario'], $data['idrol'], $data['codigotipousuario']);
        }
        
        return ($userInfoDTO);
    }
}
