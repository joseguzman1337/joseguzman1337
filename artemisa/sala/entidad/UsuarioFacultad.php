<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class UsuarioFacultad implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idusuario;
    
    /**
     * @type varchar
     * @access private
     */
    private $usuario;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigofacultad;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipousuariofacultad;
    
    /**
     * @type varchar
     * @access private
     */
    private $emailusuariofacultad;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getCodigofacultad() {
        return $this->codigofacultad;
    }

    public function getCodigotipousuariofacultad() {
        return $this->codigotipousuariofacultad;
    }

    public function getEmailusuariofacultad() {
        return $this->emailusuariofacultad;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCodigofacultad($codigofacultad) {
        $this->codigofacultad = $codigofacultad;
    }

    public function setCodigotipousuariofacultad($codigotipousuariofacultad) {
        $this->codigotipousuariofacultad = $codigotipousuariofacultad;
    }

    public function setEmailusuariofacultad($emailusuariofacultad) {
        $this->emailusuariofacultad = $emailusuariofacultad;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
    
    public function getById(){
        if(!empty($this->idusuario)){
            $query = "SELECT * FROM usuariofacultad "
                    ." WHERE idusuario = ".$this->db->qstr($this->idusuario);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->usuario = $d['usuario'];
                $this->codigofacultad = $d['codigofacultad'];
                $this->codigotipousuariofacultad = $d['codigotipousuariofacultad'];
                $this->emailusuariofacultad = $d['emailusuariofacultad'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }
    
    public static function getList($where = null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM usuariofacultad "
                ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);

        $datos = $db->Execute($query);
        
        while($d = $datos->FetchRow()){
            $UsuarioFacultad = new UsuarioFacultad();
            $UsuarioFacultad->idusuario = $d['idusuario'];
            $UsuarioFacultad->usuario = $d['usuario'];
            $UsuarioFacultad->codigofacultad = $d['codigofacultad'];
            $UsuarioFacultad->codigotipousuariofacultad = $d['codigotipousuariofacultad'];
            $UsuarioFacultad->emailusuariofacultad = $d['emailusuariofacultad'];
            $UsuarioFacultad->codigoestado = $d['codigoestado'];
            $return[] = $UsuarioFacultad;
        }
        return $return;
    }
}
/*/
idusuario	int(11)
usuario	varchar(50)
codigofacultad	varchar(50)
codigotipousuariofacultad	char(3)
emailusuariofacultad	varchar(50)
codigoestado	char(3)
/**/