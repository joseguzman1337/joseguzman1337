<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/IconMenu.php");
class MenuBoton implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idmenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombremenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $linkmenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $linkAbsoluto;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadomenuboton;
    
    /**
     * @type smallint
     * @access private
     */
    private $nivelmenuboton;
    
    /**
     * @type smallint
     * @access private
     */
    private $posicionmenuboton;
    
    /**
     * @type char
     * @access private
     */
    private $codigogerarquiarol;
    
    /**
     * @type varchar
     * @access private
     */
    private $linkimagenboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $scriptmenuboton;
    
    /**
     * @type char
     * @access private
     */
    private $codigotipomenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $variablesmenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $propiedadesimagenmenuboton;
    
    /**
     * @type varchar
     * @access private
     */
    private $propiedadesmenuboton;
    
    /**
     * @type IconMenu Object
     * @access private
     */
    private $IconMenu;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdmenuboton() {
        return $this->idmenuboton;
    }

    public function getNombremenuboton() {
        return $this->nombremenuboton;
    }

    public function getLinkmenuboton() {
        return $this->linkmenuboton;
    }

    public function getLinkAbsoluto() {        
        return $this->linkAbsoluto;
    }

    public function getCodigoestadomenuboton() {
        return $this->codigoestadomenuboton;
    }

    public function getNivelmenuboton() {
        return $this->nivelmenuboton;
    }

    public function getPosicionmenuboton() {
        return $this->posicionmenuboton;
    }

    public function getCodigogerarquiarol() {
        return $this->codigogerarquiarol;
    }

    public function getLinkimagenboton() {
        return $this->linkimagenboton;
    }

    public function getScriptmenuboton() {
        return $this->scriptmenuboton;
    }

    public function getCodigotipomenuboton() {
        return $this->codigotipomenuboton;
    }

    public function getVariablesmenuboton() {
        return $this->variablesmenuboton;
    }

    public function getPropiedadesimagenmenuboton() {
        return $this->propiedadesimagenmenuboton;
    }

    public function getPropiedadesmenuboton() {
        return $this->propiedadesmenuboton;
    }

    public function getIconMenu() {
        return $this->IconMenu;
    }

    public function setIdmenuboton($idmenuboton) {
        $this->idmenuboton = $idmenuboton;
    }

    public function setNombremenuboton($nombremenuboton) {
        $this->nombremenuboton = $nombremenuboton;
    }

    public function setLinkmenuboton($linkmenuboton) {
        $this->linkmenuboton = $linkmenuboton;
    }

    public function setLinkAbsoluto($linkAbsoluto) {
        $this->linkAbsoluto = $linkAbsoluto;
    }

    public function setCodigoestadomenuboton($codigoestadomenuboton) {
        $this->codigoestadomenuboton = $codigoestadomenuboton;
    }

    public function setNivelmenuboton($nivelmenuboton) {
        $this->nivelmenuboton = $nivelmenuboton;
    }

    public function setPosicionmenuboton($posicionmenuboton) {
        $this->posicionmenuboton = $posicionmenuboton;
    }

    public function setCodigogerarquiarol($codigogerarquiarol) {
        $this->codigogerarquiarol = $codigogerarquiarol;
    }

    public function setLinkimagenboton($linkimagenboton) {
        $this->linkimagenboton = $linkimagenboton;
    }

    public function setScriptmenuboton($scriptmenuboton) {
        $this->scriptmenuboton = $scriptmenuboton;
    }

    public function setCodigotipomenuboton($codigotipomenuboton) {
        $this->codigotipomenuboton = $codigotipomenuboton;
    }

    public function setVariablesmenuboton($variablesmenuboton) {
        $this->variablesmenuboton = $variablesmenuboton;
    }

    public function setPropiedadesimagenmenuboton($propiedadesimagenmenuboton) {
        $this->propiedadesimagenmenuboton = $propiedadesimagenmenuboton;
    }

    public function setPropiedadesmenuboton($propiedadesmenuboton) {
        $this->propiedadesmenuboton = $propiedadesmenuboton;
    }

    public function setIconMenu($IconMenu) {
        $this->IconMenu = $IconMenu;
    }

    public function getById(){
        if(!empty($this->idmenuboton)){
            $query = "SELECT * FROM menuboton "
                    ." WHERE idmenuboton = ".$this->db->qstr($this->idmenuboton);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){ 
                $this->nombremenuboton = $d["nombremenuboton"];
                $this->linkmenuboton = $d["linkmenuboton"];
                $this->linkAbsoluto = $d["linkAbsoluto"];
                $this->codigoestadomenuboton = $d["codigoestadomenuboton"];
                $this->nivelmenuboton = $d["nivelmenuboton"];
                $this->posicionmenuboton = $d["posicionmenuboton"];
                $this->codigogerarquiarol = $d["codigogerarquiarol"];
                $this->linkimagenboton = $d["linkimagenboton"];
                $this->scriptmenuboton = $d["scriptmenuboton"];
                $this->codigotipomenuboton = $d["codigotipomenuboton"];
                $this->variablesmenuboton = $d["variablesmenuboton"];
                $this->propiedadesimagenmenuboton = $d["propiedadesimagenmenuboton"];
                $this->propiedadesmenuboton = $d["propiedadesmenuboton"];
                $this->IconMenu = new IconMenu();
                $this->IconMenu->setDb();
                $this->IconMenu->setIdMenu($this->idmenuboton);
                $this->IconMenu->setReferenciaMenu("menuBoton");
                $this->IconMenu->getByIdMenuReferenciaMenu();
                $ico = $this->IconMenu->getIcon();
                if(empty($ico)){
                    $this->IconMenu->setIcon("fa-chevron-right");
                    $this->IconMenu->save();                    
                }
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM menuboton "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $MenuBoton = new MenuBoton();
            
            $MenuBoton->idmenuboton = $d["idmenuboton"];
            $MenuBoton->nombremenuboton = $d["nombremenuboton"];
            $MenuBoton->linkmenuboton = $d["linkmenuboton"];
            $MenuBoton->linkAbsoluto = $d["linkAbsoluto"];
            $MenuBoton->codigoestadomenuboton = $d["codigoestadomenuboton"];
            $MenuBoton->nivelmenuboton = $d["nivelmenuboton"];
            $MenuBoton->posicionmenuboton = $d["posicionmenuboton"];
            $MenuBoton->codigogerarquiarol = $d["codigogerarquiarol"];
            $MenuBoton->linkimagenboton = $d["linkimagenboton"];
            $MenuBoton->scriptmenuboton = $d["scriptmenuboton"];
            $MenuBoton->codigotipomenuboton = $d["codigotipomenuboton"];
            $MenuBoton->variablesmenuboton = $d["variablesmenuboton"];
            $MenuBoton->propiedadesimagenmenuboton = $d["propiedadesimagenmenuboton"];
            $MenuBoton->propiedadesmenuboton = $d["propiedadesmenuboton"];
            
                $MenuBoton->IconMenu = new IconMenu();
                $MenuBoton->IconMenu->setDb();
                $MenuBoton->IconMenu->setIdMenu($MenuBoton->idmenuboton);
                $MenuBoton->IconMenu->setReferenciaMenu("menuBoton");
                $MenuBoton->IconMenu->getByIdMenuReferenciaMenu();
                $ico = $MenuBoton->IconMenu->getIcon();
                if(empty($ico)){
                    $MenuBoton->IconMenu->setIcon("fa-chevron-right");
                    $MenuBoton->IconMenu->save();                    
                }
            
            $return[] = $MenuBoton;
            unset($MenuBoton);
        }
        
        return $return;
    }
    
    
    public function save(){
        $query = "";
        $where = array();
        
        if(empty($this->idmenuboton)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idmenuboton = ".$this->db->qstr($this->idmenuboton);
        }
        
        $query .= " menuboton SET "
               . " nombremenuboton = ".$this->db->qstr($this->nombremenuboton).", "
               . " linkmenuboton = ".$this->db->qstr($this->linkmenuboton).", "
               . " linkAbsoluto = ".$this->db->qstr($this->linkAbsoluto).", "
               . " codigoestadomenuboton = ".$this->db->qstr($this->codigoestadomenuboton).", "
               . " nivelmenuboton = ".$this->db->qstr($this->nivelmenuboton).", "
               . " posicionmenuboton = ".$this->db->qstr($this->posicionmenuboton).", "
               . " codigogerarquiarol = ".$this->db->qstr($this->codigogerarquiarol).", " 
               . " linkimagenboton = ".$this->db->qstr($this->linkimagenboton).", "
               . " scriptmenuboton = ".$this->db->qstr($this->scriptmenuboton).", "
               . " codigotipomenuboton = ".$this->db->qstr($this->codigotipomenuboton).", "
               . " variablesmenuboton = ".$this->db->qstr($this->variablesmenuboton).", "
               . " propiedadesimagenmenuboton = ".$this->db->qstr($this->propiedadesimagenmenuboton).", "
               . " propiedadesmenuboton = ".$this->db->qstr($this->propiedadesmenuboton);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->idmenuboton)){
            $this->idmenuboton = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    
    public function generarLinkAutomatico(){
        if(empty($this->linkAbsoluto)){
            $this->setDb();
            //$link =  '/serviciosacademicos/consulta/prematricula/';
            $linkBase =  '';
            $linkArray = array('serviciosacademicos','consulta','prematricula');
            $pos = strpos($this->linkmenuboton, "../");
            if($pos!==false){
                $arrayTrozos = explode("../",$this->linkmenuboton);
                $contador = 0;
                $linkReal = array();
                //d($link);
                //d($this->linkmenuboton);
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
            }elseif((substr($this->linkmenuboton, 0, 1)=="/") || (substr($this->linkmenuboton, 0, 4)=="http")){
                $this->setLinkAbsoluto($this->linkmenuboton); 
            }else{ 
                $linkReal = implode("/",$linkArray)."/".$this->linkmenuboton;
                $this->setLinkAbsoluto($linkReal); 
            }
            if(!empty($this->linkAbsoluto)){
                $this->save();
                $this->db = null;
            }
        }
    }
    
    /*function cmp($a, $b){
        return strcmp($a["nombrecarrera"], $b["nombrecarrera"]);
    }/**/


}
/*/
idmenuboton	int(11)
nombremenuboton	varchar(50)
linkmenuboton	varchar(200)
linkAbsoluto	varchar(255)
codigoestadomenuboton	char(2)
nivelmenuboton	smallint(6)
posicionmenuboton	smallint(6)
codigogerarquiarol	char(2)
linkimagenboton	varchar(200)
scriptmenuboton	varchar(200)
codigotipomenuboton	char(3)
variablesmenuboton	varchar(200)
propiedadesimagenmenuboton	varchar(200)
propiedadesmenuboton	varchar(200)
/**/