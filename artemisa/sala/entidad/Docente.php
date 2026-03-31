<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Docente implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $iddocente;
    
    /**
     * @type String
     * @access private
     */
    private $codigodocente;
    
    /**
     * @type String
     * @access private
     */
    private $apellidodocente;
    
    /**
     * @type String
     * @access private
     */
    private $nombredocente;
    
    /**
     * @type String
     * @access private
     */
    private $tipodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $numerodocumento;
    
    /**
     * @type String
     * @access private
     */
    private $clavedocente;
    
    /**
     * @type String
     * @access private
     */
    private $emaildocente;
    
    /**
     * @type String
     * @access private
     */
    private $usuarioskypedocente;
    
    /**
     * @type String
     * @access private
     */
    private $perfilfacebookdocente;
    
    /**
     * @type String
     * @access private
     */
    private $codigogenero;
    
    /**
     * @type Date
     * @access private
     */
    private $fechanacimientodocente;
    
    /**
     * @type int
     * @access private
     */
    private $idpaisnacimiento;
    
    /**
     * @type int
     * @access private
     */
    private $iddepartamentonacimiento;
    
    /**
     * @type int
     * @access private
     */
    private $idciudadnacimiento;
    
    /**
     * @type int
     * @access private
     */
    private $idestadocivil;
    
    /**
     * @type String
     * @access private
     */
    private $direcciondocente;
    
    /**
     * @type int
     * @access private
     */
    private $idciudadresidencia;
    
    /**
     * @type String
     * @access private
     */
    private $telefonoresidenciadocente;
    
    /**
     * @type String
     * @access private
     */
    private $numerocelulardocente;
    
    /**
     * @type String
     * @access private
     */
    private $profesion;
    
    /**
     * @type String
     * @access private
     */
    private $numerotarjetaprofesionaldocente;
    
    /**
     * @type Date
     * @access private
     */
    private $fechaexpediciontarjetaprofesionaldocente;
    
    /**
     * @type String
     * @access private
     */
    private $nombreempresapropiadocente;
    
    /**
     * @type Date
     * @access private
     */
    private $fechaprimercontratodocente;
    
    /**
     * @type Date
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type Date
     * @access private
     */
    private $modalidadocente;
    
    /**
     * @type int
     * @access private
     */
    private $entrydate;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIddocente() {
        return $this->iddocente;
    }

    public function getCodigodocente() {
        return $this->codigodocente;
    }

    public function getApellidodocente() {
        return $this->apellidodocente;
    }

    public function getNombredocente() {
        return $this->nombredocente;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getClavedocente() {
        return $this->clavedocente;
    }

    public function getEmaildocente() {
        return $this->emaildocente;
    }

    public function getUsuarioskypedocente() {
        return $this->usuarioskypedocente;
    }

    public function getPerfilfacebookdocente() {
        return $this->perfilfacebookdocente;
    }

    public function getCodigogenero() {
        return $this->codigogenero;
    }

    public function getFechanacimientodocente() {
        return $this->fechanacimientodocente;
    }

    public function getIdpaisnacimiento() {
        return $this->idpaisnacimiento;
    }

    public function getIddepartamentonacimiento() {
        return $this->iddepartamentonacimiento;
    }

    public function getIdciudadnacimiento() {
        return $this->idciudadnacimiento;
    }

    public function getIdestadocivil() {
        return $this->idestadocivil;
    }

    public function getDirecciondocente() {
        return $this->direcciondocente;
    }

    public function getIdciudadresidencia() {
        return $this->idciudadresidencia;
    }

    public function getTelefonoresidenciadocente() {
        return $this->telefonoresidenciadocente;
    }

    public function getNumerocelulardocente() {
        return $this->numerocelulardocente;
    }

    public function getProfesion() {
        return $this->profesion;
    }

    public function getNumerotarjetaprofesionaldocente() {
        return $this->numerotarjetaprofesionaldocente;
    }

    public function getFechaexpediciontarjetaprofesionaldocente() {
        return $this->fechaexpediciontarjetaprofesionaldocente;
    }

    public function getNombreempresapropiadocente() {
        return $this->nombreempresapropiadocente;
    }

    public function getFechaprimercontratodocente() {
        return $this->fechaprimercontratodocente;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getModalidadocente() {
        return $this->modalidadocente;
    }

    public function getEntrydate() {
        return $this->entrydate;
    }

    public function setIddocente($iddocente) {
        $this->iddocente = $iddocente;
    }

    public function setCodigodocente($codigodocente) {
        $this->codigodocente = $codigodocente;
    }

    public function setApellidodocente($apellidodocente) {
        $this->apellidodocente = $apellidodocente;
    }

    public function setNombredocente($nombredocente) {
        $this->nombredocente = $nombredocente;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setClavedocente($clavedocente) {
        $this->clavedocente = $clavedocente;
    }

    public function setEmaildocente($emaildocente) {
        $this->emaildocente = $emaildocente;
    }

    public function setUsuarioskypedocente($usuarioskypedocente) {
        $this->usuarioskypedocente = $usuarioskypedocente;
    }

    public function setPerfilfacebookdocente($perfilfacebookdocente) {
        $this->perfilfacebookdocente = $perfilfacebookdocente;
    }

    public function setCodigogenero($codigogenero) {
        $this->codigogenero = $codigogenero;
    }

    public function setFechanacimientodocente($fechanacimientodocente) {
        $this->fechanacimientodocente = $fechanacimientodocente;
    }

    public function setIdpaisnacimiento($idpaisnacimiento) {
        $this->idpaisnacimiento = $idpaisnacimiento;
    }

    public function setIddepartamentonacimiento($iddepartamentonacimiento) {
        $this->iddepartamentonacimiento = $iddepartamentonacimiento;
    }

    public function setIdciudadnacimiento($idciudadnacimiento) {
        $this->idciudadnacimiento = $idciudadnacimiento;
    }

    public function setIdestadocivil($idestadocivil) {
        $this->idestadocivil = $idestadocivil;
    }

    public function setDirecciondocente($direcciondocente) {
        $this->direcciondocente = $direcciondocente;
    }

    public function setIdciudadresidencia($idciudadresidencia) {
        $this->idciudadresidencia = $idciudadresidencia;
    }

    public function setTelefonoresidenciadocente($telefonoresidenciadocente) {
        $this->telefonoresidenciadocente = $telefonoresidenciadocente;
    }

    public function setNumerocelulardocente($numerocelulardocente) {
        $this->numerocelulardocente = $numerocelulardocente;
    }

    public function setProfesion($profesion) {
        $this->profesion = $profesion;
    }

    public function setNumerotarjetaprofesionaldocente($numerotarjetaprofesionaldocente) {
        $this->numerotarjetaprofesionaldocente = $numerotarjetaprofesionaldocente;
    }

    public function setFechaexpediciontarjetaprofesionaldocente($fechaexpediciontarjetaprofesionaldocente) {
        $this->fechaexpediciontarjetaprofesionaldocente = $fechaexpediciontarjetaprofesionaldocente;
    }

    public function setNombreempresapropiadocente($nombreempresapropiadocente) {
        $this->nombreempresapropiadocente = $nombreempresapropiadocente;
    }

    public function setFechaprimercontratodocente($fechaprimercontratodocente) {
        $this->fechaprimercontratodocente = $fechaprimercontratodocente;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setModalidadocente($modalidadocente) {
        $this->modalidadocente = $modalidadocente;
    }

    public function setEntrydate($entrydate) {
        $this->entrydate = $entrydate;
    }

    public function getById() {
        if(!empty($this->iddocente)){
            $query = "SELECT * FROM docente "
                    ." WHERE iddocente = ".$this->db->qstr($this->iddocente);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->codigodocente = $d['codigodocente'];
                $this->apellidodocente = $d['apellidodocente'];
                $this->nombredocente = $d['nombredocente'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->clavedocente = $d['clavedocente'];
                $this->emaildocente = $d['emaildocente'];
                $this->usuarioskypedocente = $d['usuarioskypedocente'];
                $this->perfilfacebookdocente = $d['perfilfacebookdocente'];
                $this->codigogenero = $d['codigogenero'];
                $this->fechanacimientodocente = $d['fechanacimientodocente'];
                $this->idpaisnacimiento = $d['idpaisnacimiento'];
                $this->iddepartamentonacimiento = $d['iddepartamentonacimiento'];
                $this->idciudadnacimiento = $d['idciudadnacimiento'];
                $this->idestadocivil = $d['idestadocivil'];
                $this->direcciondocente = $d['direcciondocente'];
                $this->idciudadresidencia = $d['idciudadresidencia'];
                $this->telefonoresidenciadocente = $d['telefonoresidenciadocente'];
                $this->numerocelulardocente = $d['numerocelulardocente'];
                $this->profesion = $d['profesion'];
                $this->numerotarjetaprofesionaldocente = $d['numerotarjetaprofesionaldocente'];
                $this->fechaexpediciontarjetaprofesionaldocente = $d['fechaexpediciontarjetaprofesionaldocente'];
                $this->nombreempresapropiadocente = $d['nombreempresapropiadocente'];
                $this->fechaprimercontratodocente = $d['fechaprimercontratodocente'];
                $this->codigoestado = $d['codigoestado'];
                $this->modalidadocente = $d['modalidadocente'];
                $this->entrydate = $d['entrydate'];
            }
        }
    }

    public static function getList($where=null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM docente "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $Docente = new Docente();
            $Docente->iddocente = $d['iddocente'];
            $Docente->codigodocente = $d['codigodocente'];
            $Docente->apellidodocente = $d['apellidodocente'];
            $Docente->nombredocente = $d['nombredocente'];
            $Docente->tipodocumento = $d['tipodocumento'];
            $Docente->numerodocumento = $d['numerodocumento'];
            $Docente->clavedocente = $d['clavedocente'];
            $Docente->emaildocente = $d['emaildocente'];
            $Docente->usuarioskypedocente = $d['usuarioskypedocente'];
            $Docente->perfilfacebookdocente = $d['perfilfacebookdocente'];
            $Docente->codigogenero = $d['codigogenero'];
            $Docente->fechanacimientodocente = $d['fechanacimientodocente'];
            $Docente->idpaisnacimiento = $d['idpaisnacimiento'];
            $Docente->iddepartamentonacimiento = $d['iddepartamentonacimiento'];
            $Docente->idciudadnacimiento = $d['idciudadnacimiento'];
            $Docente->idestadocivil = $d['idestadocivil'];
            $Docente->direcciondocente = $d['direcciondocente'];
            $Docente->idciudadresidencia = $d['idciudadresidencia'];
            $Docente->telefonoresidenciadocente = $d['telefonoresidenciadocente'];
            $Docente->numerocelulardocente = $d['numerocelulardocente'];
            $Docente->profesion = $d['profesion'];
            $Docente->numerotarjetaprofesionaldocente = $d['numerotarjetaprofesionaldocente'];
            $Docente->fechaexpediciontarjetaprofesionaldocente = $d['fechaexpediciontarjetaprofesionaldocente'];
            $Docente->nombreempresapropiadocente = $d['nombreempresapropiadocente'];
            $Docente->fechaprimercontratodocente = $d['fechaprimercontratodocente'];
            $Docente->codigoestado = $d['codigoestado'];
            $Docente->modalidadocente = $d['modalidadocente'];
            $Docente->entrydate = $d['entrydate'];
            
            $return[] = $Docente;
            unset($Docente);
        }
        
        return $return;
    }

}
/*/
iddocente	int(11)
codigodocente	varchar(15)
apellidodocente	varchar(25)
nombredocente	varchar(25)
tipodocumento	char(2)
numerodocumento	varchar(15)
clavedocente	varchar(15)
emaildocente	varchar(50)
usuarioskypedocente	varchar(30)
perfilfacebookdocente	varchar(30)
codigogenero	varchar(3)
fechanacimientodocente	date
idpaisnacimiento	int(11)
iddepartamentonacimiento	int(11)
idciudadnacimiento	int(11)
idestadocivil	int(11)
direcciondocente	varchar(100)
idciudadresidencia	int(11)
telefonoresidenciadocente	varchar(20)
numerocelulardocente	varchar(20)
profesion	varchar(200)
numerotarjetaprofesionaldocente	varchar(20)
fechaexpediciontarjetaprofesionaldocente	date
nombreempresapropiadocente	varchar(50)
fechaprimercontratodocente	date
codigoestado	char(3)
modalidadocente	int(11)
entrydate	timestamp
/**/