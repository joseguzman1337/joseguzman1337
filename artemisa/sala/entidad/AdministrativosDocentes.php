<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class AdministrativosDocentes implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombresadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $apellidosadministrativosdocentes;
    
    /**
     * @type char
     * @access private
     */
    private $tipodocumento;
    
    /**
     * @type varchar
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type varchar
     * @access private
     */
    private $expedidodocumento;
    
    /**
     * @type int
     * @access private
     */
    private $idtipogruposanguineo;
    
    /**
     * @type char
     * @access private
     */
    private $codigogenero;
    
    /**
     * @type varchar
     * @access private
     */
    private $celularadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $emailadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $direccionadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefonoadministrativosdocentes;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaterminancioncontratoadministrativosdocentes;
    
    /**
     * @type varchar
     * @access private
     */
    private $cargoadministrativosdocentes;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type int
     * @access private
     */
    private $idtipousuarioadmdocen;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombresadministrativosdocentesandover;
    
    /**
     * @type varchar
     * @access private
     */
    private $apellidosadministrativosdocentesandover;
    
    /**
     * @type varchar
     * @access private
     */
    private $EmailInstitucional;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getIdadministrativosdocentes() {
        return $this->idadministrativosdocentes;
    }

    function getNombresadministrativosdocentes() {
        return $this->nombresadministrativosdocentes;
    }

    function getApellidosadministrativosdocentes() {
        return $this->apellidosadministrativosdocentes;
    }

    function getNumerodocumento() {
        return $this->numerodocumento;
    }

    function getTipodocumento() {
        return $this->tipodocumento;
    }

    function getExpedidodocumento() {
        return $this->expedidodocumento;
    }

    function getIdtipogruposanguineo() {
        return $this->idtipogruposanguineo;
    }

    function getCodigogenero() {
        return $this->codigogenero;
    }

    function getCelularadministrativosdocentes() {
        return $this->celularadministrativosdocentes;
    }

    function getEmailadministrativosdocentes() {
        return $this->emailadministrativosdocentes;
    }

    function getDireccionadministrativosdocentes() {
        return $this->direccionadministrativosdocentes;
    }

    function getTelefonoadministrativosdocentes() {
        return $this->telefonoadministrativosdocentes;
    }

    function getFechaterminancioncontratoadministrativosdocentes() {
        return $this->fechaterminancioncontratoadministrativosdocentes;
    }

    function getCargoadministrativosdocentes() {
        return $this->cargoadministrativosdocentes;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function getIdtipousuarioadmdocen() {
        return $this->idtipousuarioadmdocen;
    }

    function getNombresadministrativosdocentesandover() {
        return $this->nombresadministrativosdocentesandover;
    }

    function getApellidosadministrativosdocentesandover() {
        return $this->apellidosadministrativosdocentesandover;
    }

    function getEmailInstitucional() {
        return $this->EmailInstitucional;
    }

    function setIdadministrativosdocentes($idadministrativosdocentes) {
        $this->idadministrativosdocentes = $idadministrativosdocentes;
    }

    function setNombresadministrativosdocentes($nombresadministrativosdocentes) {
        $this->nombresadministrativosdocentes = $nombresadministrativosdocentes;
    }

    function setApellidosadministrativosdocentes($apellidosadministrativosdocentes) {
        $this->apellidosadministrativosdocentes = $apellidosadministrativosdocentes;
    }

    function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    function setExpedidodocumento($expedidodocumento) {
        $this->expedidodocumento = $expedidodocumento;
    }

    function setIdtipogruposanguineo($idtipogruposanguineo) {
        $this->idtipogruposanguineo = $idtipogruposanguineo;
    }

    function setCodigogenero($codigogenero) {
        $this->codigogenero = $codigogenero;
    }

    function setCelularadministrativosdocentes($celularadministrativosdocentes) {
        $this->celularadministrativosdocentes = $celularadministrativosdocentes;
    }

    function setEmailadministrativosdocentes($emailadministrativosdocentes) {
        $this->emailadministrativosdocentes = $emailadministrativosdocentes;
    }

    function setDireccionadministrativosdocentes($direccionadministrativosdocentes) {
        $this->direccionadministrativosdocentes = $direccionadministrativosdocentes;
    }

    function setTelefonoadministrativosdocentes($telefonoadministrativosdocentes) {
        $this->telefonoadministrativosdocentes = $telefonoadministrativosdocentes;
    }

    function setFechaterminancioncontratoadministrativosdocentes($fechaterminancioncontratoadministrativosdocentes) {
        $this->fechaterminancioncontratoadministrativosdocentes = $fechaterminancioncontratoadministrativosdocentes;
    }

    function setCargoadministrativosdocentes($cargoadministrativosdocentes) {
        $this->cargoadministrativosdocentes = $cargoadministrativosdocentes;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    function setIdtipousuarioadmdocen($idtipousuarioadmdocen) {
        $this->idtipousuarioadmdocen = $idtipousuarioadmdocen;
    }

    function setNombresadministrativosdocentesandover($nombresadministrativosdocentesandover) {
        $this->nombresadministrativosdocentesandover = $nombresadministrativosdocentesandover;
    }

    function setApellidosadministrativosdocentesandover($apellidosadministrativosdocentesandover) {
        $this->apellidosadministrativosdocentesandover = $apellidosadministrativosdocentesandover;
    }

    function setEmailInstitucional($EmailInstitucional) {
        $this->EmailInstitucional = $EmailInstitucional;
    }

    public function getById(){
        if(!empty($this->idadministrativosdocentes)){
            $query = "SELECT * FROM administrativosdocentes "
                    . "WHERE idadministrativosdocentes = ".$this->db->qstr($this->idadministrativosdocentes);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombresadministrativosdocentes = $d['nombresadministrativosdocentes'];
                $this->apellidosadministrativosdocentes = $d['apellidosadministrativosdocentes'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->expedidodocumento = $d['expedidodocumento'];
                $this->idtipogruposanguineo = $d['idtipogruposanguineo'];
                $this->codigogenero = $d['codigogenero'];
                $this->celularadministrativosdocentes = $d['celularadministrativosdocentes'];
                $this->emailadministrativosdocentes	 = $d['emailadministrativosdocentes'];
                $this->direccionadministrativosdocentes = $d['direccionadministrativosdocentes'];
                $this->telefonoadministrativosdocentes = $d['telefonoadministrativosdocentes'];
                $this->fechaterminancioncontratoadministrativosdocentes = $d['fechaterminancioncontratoadministrativosdocentes'];
                $this->cargoadministrativosdocentes = $d['cargoadministrativosdocentes'];
                $this->codigoestado = $d['codigoestado'];
                $this->idtipousuarioadmdocen = $d['idtipousuarioadmdocen'];
                $this->nombresadministrativosdocentesandover = $d['nombresadministrativosdocentesandover'];
                $this->apellidosadministrativosdocentesandover = $d['apellidosadministrativosdocentesandover'];
                $this->EmailInstitucional = $d['EmailInstitucional'];
            }
        }
    }    

    public function getByDocumentoTipo(){
        if(!empty($this->tipodocumento) && !empty($this->numerodocumento)){
            $query = "SELECT * FROM administrativosdocentes "
                    . " WHERE tipodocumento = ".$this->db->qstr($this->tipodocumento)
                    . " AND numerodocumento = ".$this->db->qstr($this->numerodocumento);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idadministrativosdocentes = $d['idadministrativosdocentes'];
                $this->nombresadministrativosdocentes = $d['nombresadministrativosdocentes'];
                $this->apellidosadministrativosdocentes = $d['apellidosadministrativosdocentes'];
                $this->expedidodocumento = $d['expedidodocumento'];
                $this->idtipogruposanguineo = $d['idtipogruposanguineo'];
                $this->codigogenero = $d['codigogenero'];
                $this->celularadministrativosdocentes = $d['celularadministrativosdocentes'];
                $this->emailadministrativosdocentes	 = $d['emailadministrativosdocentes'];
                $this->direccionadministrativosdocentes = $d['direccionadministrativosdocentes'];
                $this->telefonoadministrativosdocentes = $d['telefonoadministrativosdocentes'];
                $this->fechaterminancioncontratoadministrativosdocentes = $d['fechaterminancioncontratoadministrativosdocentes'];
                $this->cargoadministrativosdocentes = $d['cargoadministrativosdocentes'];
                $this->codigoestado = $d['codigoestado'];
                $this->idtipousuarioadmdocen = $d['idtipousuarioadmdocen'];
                $this->nombresadministrativosdocentesandover = $d['nombresadministrativosdocentesandover'];
                $this->apellidosadministrativosdocentesandover = $d['apellidosadministrativosdocentesandover'];
                $this->EmailInstitucional = $d['EmailInstitucional'];
            }
        }
    }
    
    public static function getList($where = null){
        $arrayReturn = array();
        return $arrayReturn;
    }
}
/*/
idadministrativosdocentes	int(11)
nombresadministrativosdocentes	varchar(100)
apellidosadministrativosdocentes	varchar(100)
tipodocumento;	char(2)
numerodocumento	varchar(45)
expedidodocumento	varchar(100)
idtipogruposanguineo	int(11)
codigogenero	char(3)
celularadministrativosdocentes	varchar(45)
emailadministrativosdocentes	varchar(45)
direccionadministrativosdocentes	varchar(45)
telefonoadministrativosdocentes	varchar(45)
fechaterminancioncontratoadministrativosdocentes	datetime
cargoadministrativosdocentes	varchar(100)
codigoestado	char(3)
idtipousuarioadmdocen	int(11)
nombresadministrativosdocentesandover	varchar(100)
apellidosadministrativosdocentesandover	varchar(100)
EmailInstitucional	varchar(200)
/**/