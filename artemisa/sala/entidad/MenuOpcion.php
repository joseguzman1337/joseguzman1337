<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class MenuOpcion implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idmenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombremenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $linkmenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $linkAbsoluto;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadomenuopcion;
    
    /**
     * @type int
     * @access private
     */
    private $nivelmenuopcion;
    
    /**
     * @type int
     * @access private
     */
    private $posicionmenuopcion;
    
    /**
     * @type char
     * @access private
     */
    private $codigogerarquiarol;
    
    /**
     * @type int
     * @access private
     */
    private $idpadremenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $framedestinomenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $transaccionmenuopcion;
    
    /**
     * @type int
     * @access private
     */
    private $codigotipomenuopcion;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdmenuopcion() {
        return $this->idmenuopcion;
    }

    public function getNombremenuopcion() {
        return $this->nombremenuopcion;
    }

    public function getLinkmenuopcion() {
        return $this->linkmenuopcion;
    }

    public function getLinkAbsoluto() {
        return $this->linkAbsoluto;
    }

    public function getCodigoestadomenuopcion() {
        return $this->codigoestadomenuopcion;
    }

    public function getNivelmenuopcion() {
        return $this->nivelmenuopcion;
    }

    public function getPosicionmenuopcion() {
        return $this->posicionmenuopcion;
    }

    public function getCodigogerarquiarol() {
        return $this->codigogerarquiarol;
    }

    public function getIdpadremenuopcion() {
        return $this->idpadremenuopcion;
    }

    public function getFramedestinomenuopcion() {
        return $this->framedestinomenuopcion;
    }

    public function getTransaccionmenuopcion() {
        return $this->transaccionmenuopcion;
    }

    public function getCodigotipomenuopcion() {
        return $this->codigotipomenuopcion;
    }

    public function setIdmenuopcion($idmenuopcion) {
        $this->idmenuopcion = $idmenuopcion;
    }

    public function setNombremenuopcion($nombremenuopcion) {
        $this->nombremenuopcion = $nombremenuopcion;
    }

    public function setLinkmenuopcion($linkmenuopcion) {
        $this->linkmenuopcion = $linkmenuopcion;
    }

    public function setLinkAbsoluto($linkAbsoluto) {
        $this->linkAbsoluto = $linkAbsoluto;
    }

    public function setCodigoestadomenuopcion($codigoestadomenuopcion) {
        $this->codigoestadomenuopcion = $codigoestadomenuopcion;
    }

    public function setNivelmenuopcion($nivelmenuopcion) {
        $this->nivelmenuopcion = $nivelmenuopcion;
    }

    public function setPosicionmenuopcion($posicionmenuopcion) {
        $this->posicionmenuopcion = $posicionmenuopcion;
    }

    public function setCodigogerarquiarol($codigogerarquiarol) {
        $this->codigogerarquiarol = $codigogerarquiarol;
    }

    public function setIdpadremenuopcion($idpadremenuopcion) {
        $this->idpadremenuopcion = $idpadremenuopcion;
    }

    public function setFramedestinomenuopcion($framedestinomenuopcion) {
        $this->framedestinomenuopcion = $framedestinomenuopcion;
    }

    public function setTransaccionmenuopcion($transaccionmenuopcion) {
        $this->transaccionmenuopcion = $transaccionmenuopcion;
    }

    public function setCodigotipomenuopcion($codigotipomenuopcion) {
        $this->codigotipomenuopcion = $codigotipomenuopcion;
    }

    public function getMenuOpcionById(){
        if(!empty($this->idmenuopcion)){
            $query = "SELECT * FROM menuopcion "
                    . "WHERE idmenuopcion = ".$this->db->qstr($this->idmenuopcion);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombremenuopcion = $d['nombremenuopcion'];
                $this->linkmenuopcion = $d['linkmenuopcion'];
                $this->linkAbsoluto = $d['linkAbsoluto'];
                $this->codigoestadomenuopcion = $d['codigoestadomenuopcion'];
                $this->nivelmenuopcion = $d['nivelmenuopcion'];
                $this->posicionmenuopcion = $d['posicionmenuopcion'];
                $this->codigogerarquiarol = $d['codigogerarquiarol'];
                $this->idpadremenuopcion	 = $d['idpadremenuopcion'];
                $this->framedestinomenuopcion = $d['framedestinomenuopcion'];
                $this->transaccionmenuopcion = $d['transaccionmenuopcion'];
                $this->codigotipomenuopcion = $d['codigotipomenuopcion'];
            }
        }
    }
    
    public function saveMenuOpcion(){
        $query = "";
        $where = array();
        
        if(empty($this->idmenuopcion)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idmenuopcion = ".$this->db->qstr($this->idmenuopcion);
        }
        
        $query .= " menuopcion SET "
               . " nombremenuopcion = ".$this->db->qstr($this->nombremenuopcion).", "
               . " linkmenuopcion = ".$this->db->qstr($this->linkmenuopcion).", "
               . " linkAbsoluto = ".$this->db->qstr($this->linkAbsoluto).", "
               . " codigoestadomenuopcion = ".$this->db->qstr($this->codigoestadomenuopcion).", "
               . " nivelmenuopcion = ".$this->db->qstr($this->nivelmenuopcion).", "
               . " posicionmenuopcion = ".$this->db->qstr($this->posicionmenuopcion).", "
               . " codigogerarquiarol = ".$this->db->qstr($this->codigogerarquiarol).", "
               //. " codigogerarquiarol = ".$this->db->qstr(null).", "
               . " idpadremenuopcion = ".$this->db->qstr($this->idpadremenuopcion).", "
               . " framedestinomenuopcion = ".$this->db->qstr($this->framedestinomenuopcion).", "
               . " transaccionmenuopcion = ".$this->db->qstr($this->transaccionmenuopcion).", "
               . " codigotipomenuopcion = ".$this->db->qstr($this->codigotipomenuopcion);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->idmenuopcion)){
            $this->idmenuopcion = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    
    public static function getListMenuOpcion($order=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM menuopcion "
                . " ORDER BY idpadremenuopcion,nombremenuopcion ";
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $MenuOpcion = new MenuOpcion();
            $MenuOpcion->idmenuopcion = $d['idmenuopcion'];
            $MenuOpcion->nombremenuopcion = $d['nombremenuopcion'];
            $MenuOpcion->linkmenuopcion = $d['linkmenuopcion'];
            $MenuOpcion->linkAbsoluto = $d['linkAbsoluto'];
            $MenuOpcion->codigoestadomenuopcion = $d['codigoestadomenuopcion'];
            $MenuOpcion->nivelmenuopcion = $d['nivelmenuopcion'];
            $MenuOpcion->posicionmenuopcion = $d['posicionmenuopcion'];
            $MenuOpcion->codigogerarquiarol = $d['codigogerarquiarol'];
            $MenuOpcion->idpadremenuopcion	 = $d['idpadremenuopcion'];
            $MenuOpcion->framedestinomenuopcion = $d['framedestinomenuopcion'];
            $MenuOpcion->transaccionmenuopcion = $d['transaccionmenuopcion'];
            $MenuOpcion->codigotipomenuopcion = $d['codigotipomenuopcion'];
            $return[] = $MenuOpcion;
            unset($MenuOpcion);
        }
        return $return;
    }
    
    public function generarLinkAutomatico(){
        $this->setDb();
        //$link =  '/serviciosacademicos/consulta/facultades/';
        $linkBase =  '';
        $linkArray = array('serviciosacademicos','consulta','facultades');
        $pos = strpos($this->linkmenuopcion, "../");
        if($pos!==false){
            $arrayTrozos = explode("../",$this->linkmenuopcion);
            $contador = 0;
            $linkReal = array();
            //d($link);
            //d($this->linkmenuopcion);
            foreach($arrayTrozos as $t){
                if($t == ""){
                    $contador++;
                }else{
                   $linkReal = $t;
                }
            }
            //d($contador);
            
            //d($linkReal);
            //for($i=0; $i<(3-$contador);$i++ ){
            for($i=0; $i<(3-$contador);$i++ ){
                $linkBase[] = $linkArray[$i];
            }
            if(!empty($linkBase)){
                $linkReal = implode("/",$linkBase)."/".$linkReal;
            }
            $this->setLinkAbsoluto($linkReal);
            //d($linkReal);
            //ddd($contador);
        }elseif((substr($this->linkmenuopcion, 0, 1)=="/") || (substr($this->linkmenuopcion, 0, 4)=="http")){
            $this->setLinkAbsoluto($this->linkmenuopcion); 
        }else{ 
            $linkReal = implode("/",$linkArray)."/".$this->linkmenuopcion;
            $this->setLinkAbsoluto($linkReal); 
        }
        if(!empty($this->linkAbsoluto)){
            $this->saveMenuOpcion();
            $this->db = null;
        }
        
    }
    public function getById() {
        $this->getMenuOpcionById();
    }

    public static function getList($where) {
        return self::getListMenuOpcion();
    }

}
/*/
idmenuopcion	int(11)
nombremenuopcion	varchar(70)
linkmenuopcion	varchar(255)
linkAbsoluto	varchar(255)
codigoestadomenuopcion	char(2)
nivelmenuopcion	smallint(6)
posicionmenuopcion	smallint(6)
codigogerarquiarol	char(2)
idpadremenuopcion	int(11)
framedestinomenuopcion	varchar(100)
transaccionmenuopcion	varchar(50)
codigotipomenuopcion	int(11)
/**/