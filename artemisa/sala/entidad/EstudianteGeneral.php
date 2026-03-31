<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
defined('_EXEC') or die;
class EstudianteGeneral implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $idtrato;
    
    /**
     * @type int
     * @access private
     */
    private $idestadocivil;
    
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
     * @type varchar
     * @access private
     */
    private $numerolibretamilitar;
    
    /**
     * @type varchar
     * @access private
     */
    private $numerodistritolibretamilitar;
    
    /**
     * @type varchar
     * @access private
     */
    private $expedidalibretamilitar;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombrecortoestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombresestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $apellidosestudiantegeneral;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechanacimientoestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $idciudadnacimiento;
    
    /**
     * @type char
     * @access private
     */
    private $codigogenero;
    
    /**
     * @type varchar
     * @access private
     */
    private $direccionresidenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $direccioncortaresidenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $ciudadresidenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefonoresidenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefono2estudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $celularestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $direccioncorrespondenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $direccioncortacorrespondenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $ciudadcorrespondenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefonocorrespondenciaestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $emailestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $email2estudiantegeneral;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechacreacionestudiantegeneral;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaactualizaciondatosestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigotipocliente;
    
    /**
     * @type varchar
     * @access private
     */
    private $casoemergenciallamarestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefono1casoemergenciallamarestudiantegeneral;
    
    /**
     * @type varchar
     * @access private
     */
    private $telefono2casoemergenciallamarestudiantegeneral;
    
    /**
     * @type int
     * @access private
     */
    private $idtipoestudiantefamilia;
    
    /**
     * @type int
     * @access private
     */
    private $eps_estudiante;
    
    /**
     * @type int
     * @access private
     */
    private $tipoafiliacion;
    
    /**
     * @type int
     * @access private
     */
    private $idciudadorigen;
    
    /**
     * @type int
     * @access private
     */
    private $esextranjeroestudiantegeneral;
    
    /**
     * @type datetime
     * @access private
     */
    private $FechaDocumento;
    
    /**
     * @type int
     * @access private
     */
    private $idpaisnacimiento;
    
    /**
     * @type int
     * @access private
     */
    private $GrupoEtnicoId;
    
    /**
     * @type char
     * @access private
     */
    private $EstadoActualizaDato;
    /**
     * @type int
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
        $this->setDb();
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function getIdtrato() {
        return $this->idtrato;
    }

    public function getIdestadocivil() {
        return $this->idestadocivil;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getExpedidodocumento() {
        return $this->expedidodocumento;
    }

    public function getNumerolibretamilitar() {
        return $this->numerolibretamilitar;
    }

    public function getNumerodistritolibretamilitar() {
        return $this->numerodistritolibretamilitar;
    }

    public function getExpedidalibretamilitar() {
        return $this->expedidalibretamilitar;
    }

    public function getNombrecortoestudiantegeneral() {
        return $this->nombrecortoestudiantegeneral;
    }

    public function getNombresestudiantegeneral() {
        return $this->nombresestudiantegeneral;
    }

    public function getApellidosestudiantegeneral() {
        return $this->apellidosestudiantegeneral;
    }

    public function getFechanacimientoestudiantegeneral() {
        return $this->fechanacimientoestudiantegeneral;
    }

    public function getIdciudadnacimiento() {
        return $this->idciudadnacimiento;
    }

    public function getCodigogenero() {
        return $this->codigogenero;
    }

    public function getDireccionresidenciaestudiantegeneral() {
        return $this->direccionresidenciaestudiantegeneral;
    }

    public function getDireccioncortaresidenciaestudiantegeneral() {
        return $this->direccioncortaresidenciaestudiantegeneral;
    }

    public function getCiudadresidenciaestudiantegeneral() {
        return $this->ciudadresidenciaestudiantegeneral;
    }

    public function getTelefonoresidenciaestudiantegeneral() {
        return $this->telefonoresidenciaestudiantegeneral;
    }

    public function getTelefono2estudiantegeneral() {
        return $this->telefono2estudiantegeneral;
    }

    public function getCelularestudiantegeneral() {
        return $this->celularestudiantegeneral;
    }

    public function getDireccioncorrespondenciaestudiantegeneral() {
        return $this->direccioncorrespondenciaestudiantegeneral;
    }

    public function getDireccioncortacorrespondenciaestudiantegeneral() {
        return $this->direccioncortacorrespondenciaestudiantegeneral;
    }

    public function getCiudadcorrespondenciaestudiantegeneral() {
        return $this->ciudadcorrespondenciaestudiantegeneral;
    }

    public function getTelefonocorrespondenciaestudiantegeneral() {
        return $this->telefonocorrespondenciaestudiantegeneral;
    }

    public function getEmailestudiantegeneral() {
        return $this->emailestudiantegeneral;
    }

    public function getEmail2estudiantegeneral() {
        return $this->email2estudiantegeneral;
    }

    public function getFechacreacionestudiantegeneral() {
        return $this->fechacreacionestudiantegeneral;
    }

    public function getFechaactualizaciondatosestudiantegeneral() {
        return $this->fechaactualizaciondatosestudiantegeneral;
    }

    public function getCodigotipocliente() {
        return $this->codigotipocliente;
    }

    public function getCasoemergenciallamarestudiantegeneral() {
        return $this->casoemergenciallamarestudiantegeneral;
    }

    public function getTelefono1casoemergenciallamarestudiantegeneral() {
        return $this->telefono1casoemergenciallamarestudiantegeneral;
    }

    public function getTelefono2casoemergenciallamarestudiantegeneral() {
        return $this->telefono2casoemergenciallamarestudiantegeneral;
    }

    public function getIdtipoestudiantefamilia() {
        return $this->idtipoestudiantefamilia;
    }

    public function getEps_estudiante() {
        return $this->eps_estudiante;
    }

    public function getTipoafiliacion() {
        return $this->tipoafiliacion;
    }

    public function getIdciudadorigen() {
        return $this->idciudadorigen;
    }

    public function getEsextranjeroestudiantegeneral() {
        return $this->esextranjeroestudiantegeneral;
    }

    public function getFechaDocumento() {
        return $this->FechaDocumento;
    }

    public function getIdpaisnacimiento() {
        return $this->idpaisnacimiento;
    }

    public function getGrupoEtnicoId() {
        return $this->GrupoEtnicoId;
    }

    public function getEstadoActualizaDato() {
        return $this->EstadoActualizaDato;
    }
    
    
    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

    public function setIdtrato($idtrato) {
        $this->idtrato = $idtrato;
    }

    public function setIdestadocivil($idestadocivil) {
        $this->idestadocivil = $idestadocivil;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function setExpedidodocumento($expedidodocumento) {
        $this->expedidodocumento = $expedidodocumento;
    }

    public function setNumerolibretamilitar($numerolibretamilitar) {
        $this->numerolibretamilitar = $numerolibretamilitar;
    }

    public function setNumerodistritolibretamilitar($numerodistritolibretamilitar) {
        $this->numerodistritolibretamilitar = $numerodistritolibretamilitar;
    }

    public function setExpedidalibretamilitar($expedidalibretamilitar) {
        $this->expedidalibretamilitar = $expedidalibretamilitar;
    }

    public function setNombrecortoestudiantegeneral($nombrecortoestudiantegeneral) {
        $this->nombrecortoestudiantegeneral = $nombrecortoestudiantegeneral;
    }

    public function setNombresestudiantegeneral($nombresestudiantegeneral) {
        $this->nombresestudiantegeneral = $nombresestudiantegeneral;
    }

    public function setApellidosestudiantegeneral($apellidosestudiantegeneral) {
        $this->apellidosestudiantegeneral = $apellidosestudiantegeneral;
    }

    public function setFechanacimientoestudiantegeneral($fechanacimientoestudiantegeneral) {
        $this->fechanacimientoestudiantegeneral = $fechanacimientoestudiantegeneral;
    }

    public function setIdciudadnacimiento($idciudadnacimiento) {
        $this->idciudadnacimiento = $idciudadnacimiento;
    }

    public function setCodigogenero($codigogenero) {
        $this->codigogenero = $codigogenero;
    }

    public function setDireccionresidenciaestudiantegeneral($direccionresidenciaestudiantegeneral) {
        $this->direccionresidenciaestudiantegeneral = $direccionresidenciaestudiantegeneral;
    }

    public function setDireccioncortaresidenciaestudiantegeneral($direccioncortaresidenciaestudiantegeneral) {
        $this->direccioncortaresidenciaestudiantegeneral = $direccioncortaresidenciaestudiantegeneral;
    }

    public function setCiudadresidenciaestudiantegeneral($ciudadresidenciaestudiantegeneral) {
        $this->ciudadresidenciaestudiantegeneral = $ciudadresidenciaestudiantegeneral;
    }

    public function setTelefonoresidenciaestudiantegeneral($telefonoresidenciaestudiantegeneral) {
        $this->telefonoresidenciaestudiantegeneral = $telefonoresidenciaestudiantegeneral;
    }

    public function setTelefono2estudiantegeneral($telefono2estudiantegeneral) {
        $this->telefono2estudiantegeneral = $telefono2estudiantegeneral;
    }

    public function setCelularestudiantegeneral($celularestudiantegeneral) {
        $this->celularestudiantegeneral = $celularestudiantegeneral;
    }

    public function setDireccioncorrespondenciaestudiantegeneral($direccioncorrespondenciaestudiantegeneral) {
        $this->direccioncorrespondenciaestudiantegeneral = $direccioncorrespondenciaestudiantegeneral;
    }

    public function setDireccioncortacorrespondenciaestudiantegeneral($direccioncortacorrespondenciaestudiantegeneral) {
        $this->direccioncortacorrespondenciaestudiantegeneral = $direccioncortacorrespondenciaestudiantegeneral;
    }

    public function setCiudadcorrespondenciaestudiantegeneral($ciudadcorrespondenciaestudiantegeneral) {
        $this->ciudadcorrespondenciaestudiantegeneral = $ciudadcorrespondenciaestudiantegeneral;
    }

    public function setTelefonocorrespondenciaestudiantegeneral($telefonocorrespondenciaestudiantegeneral) {
        $this->telefonocorrespondenciaestudiantegeneral = $telefonocorrespondenciaestudiantegeneral;
    }

    public function setEmailestudiantegeneral($emailestudiantegeneral) {
        $this->emailestudiantegeneral = $emailestudiantegeneral;
    }

    public function setEmail2estudiantegeneral($email2estudiantegeneral) {
        $this->email2estudiantegeneral = $email2estudiantegeneral;
    }

    public function setFechacreacionestudiantegeneral($fechacreacionestudiantegeneral) {
        $this->fechacreacionestudiantegeneral = $fechacreacionestudiantegeneral;
    }

    public function setFechaactualizaciondatosestudiantegeneral($fechaactualizaciondatosestudiantegeneral) {
        $this->fechaactualizaciondatosestudiantegeneral = $fechaactualizaciondatosestudiantegeneral;
    }

    public function setCodigotipocliente($codigotipocliente) {
        $this->codigotipocliente = $codigotipocliente;
    }

    public function setCasoemergenciallamarestudiantegeneral($casoemergenciallamarestudiantegeneral) {
        $this->casoemergenciallamarestudiantegeneral = $casoemergenciallamarestudiantegeneral;
    }

    public function setTelefono1casoemergenciallamarestudiantegeneral($telefono1casoemergenciallamarestudiantegeneral) {
        $this->telefono1casoemergenciallamarestudiantegeneral = $telefono1casoemergenciallamarestudiantegeneral;
    }

    public function setTelefono2casoemergenciallamarestudiantegeneral($telefono2casoemergenciallamarestudiantegeneral) {
        $this->telefono2casoemergenciallamarestudiantegeneral = $telefono2casoemergenciallamarestudiantegeneral;
    }

    public function setIdtipoestudiantefamilia($idtipoestudiantefamilia) {
        $this->idtipoestudiantefamilia = $idtipoestudiantefamilia;
    }

    public function setEps_estudiante($eps_estudiante) {
        $this->eps_estudiante = $eps_estudiante;
    }

    public function setTipoafiliacion($tipoafiliacion) {
        $this->tipoafiliacion = $tipoafiliacion;
    }

    public function setIdciudadorigen($idciudadorigen) {
        $this->idciudadorigen = $idciudadorigen;
    }

    public function setEsextranjeroestudiantegeneral($esextranjeroestudiantegeneral) {
        $this->esextranjeroestudiantegeneral = $esextranjeroestudiantegeneral;
    }

    public function setFechaDocumento($FechaDocumento) {
        $this->FechaDocumento = $FechaDocumento;
    }

    public function setIdpaisnacimiento($idpaisnacimiento) {
        $this->idpaisnacimiento = $idpaisnacimiento;
    }

    public function setGrupoEtnicoId($GrupoEtnicoId) {
        $this->GrupoEtnicoId = $GrupoEtnicoId;
    }

    public function setEstadoActualizaDato($EstadoActualizaDato) {
        $this->EstadoActualizaDato = $EstadoActualizaDato;
    }
    
    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
    
    public function getById(){
        if(!empty($this->idestudiantegeneral) || !empty($this->numerodocumento)){
            $query = "SELECT * FROM estudiantegeneral "
                . "WHERE idestudiantegeneral = ".$this->db->qstr($this->idestudiantegeneral);

            if(!is_null($this->numerodocumento))
            {
                $query = "SELECT * FROM estudiantegeneral "
                    . "WHERE numerodocumento = ".$this->db->qstr($this->numerodocumento);
            }
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idtrato = $d['idtrato'];
                $this->idestadocivil = $d['idestadocivil'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->expedidodocumento = $d['expedidodocumento'];
                $this->numerolibretamilitar = $d['numerolibretamilitar'];
                $this->numerodistritolibretamilitar = $d['numerodistritolibretamilitar'];
                $this->expedidalibretamilitar = $d['expedidalibretamilitar'];
                $this->nombrecortoestudiantegeneral	 = $d['nombrecortoestudiantegeneral'];
                $this->nombresestudiantegeneral = $d['nombresestudiantegeneral'];
                $this->apellidosestudiantegeneral = $d['apellidosestudiantegeneral'];
                $this->fechanacimientoestudiantegeneral = $d['fechanacimientoestudiantegeneral'];
                $this->idciudadnacimiento = $d['idciudadnacimiento'];
                $this->codigogenero = $d['codigogenero'];
                $this->direccionresidenciaestudiantegeneral = $d['direccionresidenciaestudiantegeneral'];
                $this->direccioncortaresidenciaestudiantegeneral = $d['direccioncortaresidenciaestudiantegeneral'];
                $this->ciudadresidenciaestudiantegeneral = $d['ciudadresidenciaestudiantegeneral'];
                $this->telefonoresidenciaestudiantegeneral = $d['telefonoresidenciaestudiantegeneral'];
                $this->telefono2estudiantegeneral = $d['telefono2estudiantegeneral'];
                $this->celularestudiantegeneral = $d['celularestudiantegeneral'];
                $this->direccioncorrespondenciaestudiantegeneral = $d['direccioncorrespondenciaestudiantegeneral'];
                $this->direccioncortacorrespondenciaestudiantegeneral = $d['direccioncortacorrespondenciaestudiantegeneral'];
                $this->ciudadcorrespondenciaestudiantegeneral = $d['ciudadcorrespondenciaestudiantegeneral'];
                $this->telefonocorrespondenciaestudiantegeneral = $d['telefonocorrespondenciaestudiantegeneral'];
                $this->emailestudiantegeneral = $d['emailestudiantegeneral'];
                $this->email2estudiantegeneral = $d['email2estudiantegeneral'];
                $this->fechacreacionestudiantegeneral = $d['fechacreacionestudiantegeneral'];
                $this->fechaactualizaciondatosestudiantegeneral = $d['fechaactualizaciondatosestudiantegeneral'];
                $this->codigotipocliente = $d['codigotipocliente'];
                $this->casoemergenciallamarestudiantegeneral = $d['casoemergenciallamarestudiantegeneral'];
                $this->telefono1casoemergenciallamarestudiantegeneral = $d['telefono1casoemergenciallamarestudiantegeneral'];
                $this->telefono2casoemergenciallamarestudiantegeneral = $d['telefono2casoemergenciallamarestudiantegeneral'];
                $this->idtipoestudiantefamilia = $d['idtipoestudiantefamilia'];
                $this->eps_estudiante = $d['eps_estudiante'];
                $this->tipoafiliacion = $d['tipoafiliacion'];
                $this->idciudadorigen = $d['idciudadorigen'];
                $this->esextranjeroestudiantegeneral = $d['esextranjeroestudiantegeneral'];
                $this->FechaDocumento = $d['FechaDocumento'];
                $this->idpaisnacimiento = $d['idpaisnacimiento'];
                $this->GrupoEtnicoId = $d['GrupoEtnicoId'];
                $this->EstadoActualizaDato = $d['EstadoActualizaDato'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }
    
    public static function getList($where = null, $orderBy = null){
        $return = array();        
        $db = Factory::createDbo();
        $query = "SELECT * FROM estudiantegeneral "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $EstudianteGeneral = new EstudianteGeneral();            
            $EstudianteGeneral->idestudiantegeneral = $d['idestudiantegeneral'];
            $EstudianteGeneral->idtrato = $d['idtrato'];
            $EstudianteGeneral->idestadocivil = $d['idestadocivil'];
            $EstudianteGeneral->tipodocumento = $d['tipodocumento'];
            $EstudianteGeneral->numerodocumento = $d['numerodocumento'];
            $EstudianteGeneral->expedidodocumento = $d['expedidodocumento'];
            $EstudianteGeneral->numerolibretamilitar = $d['numerolibretamilitar'];
            $EstudianteGeneral->numerodistritolibretamilitar = $d['numerodistritolibretamilitar'];
            $EstudianteGeneral->expedidalibretamilitar = $d['expedidalibretamilitar'];
            $EstudianteGeneral->nombrecortoestudiantegeneral	 = $d['nombrecortoestudiantegeneral'];
            $EstudianteGeneral->nombresestudiantegeneral = $d['nombresestudiantegeneral'];
            $EstudianteGeneral->apellidosestudiantegeneral = $d['apellidosestudiantegeneral'];
            $EstudianteGeneral->fechanacimientoestudiantegeneral = $d['fechanacimientoestudiantegeneral'];
            $EstudianteGeneral->idciudadnacimiento = $d['idciudadnacimiento'];
            $EstudianteGeneral->codigogenero = $d['codigogenero'];
            $EstudianteGeneral->direccionresidenciaestudiantegeneral = $d['direccionresidenciaestudiantegeneral'];
            $EstudianteGeneral->direccioncortaresidenciaestudiantegeneral = $d['direccioncortaresidenciaestudiantegeneral'];
            $EstudianteGeneral->ciudadresidenciaestudiantegeneral = $d['ciudadresidenciaestudiantegeneral'];
            $EstudianteGeneral->telefonoresidenciaestudiantegeneral = $d['telefonoresidenciaestudiantegeneral'];
            $EstudianteGeneral->telefono2estudiantegeneral = $d['telefono2estudiantegeneral'];
            $EstudianteGeneral->celularestudiantegeneral = $d['celularestudiantegeneral'];
            $EstudianteGeneral->direccioncorrespondenciaestudiantegeneral = $d['direccioncorrespondenciaestudiantegeneral'];
            $EstudianteGeneral->direccioncortacorrespondenciaestudiantegeneral = $d['direccioncortacorrespondenciaestudiantegeneral'];
            $EstudianteGeneral->ciudadcorrespondenciaestudiantegeneral = $d['ciudadcorrespondenciaestudiantegeneral'];
            $EstudianteGeneral->telefonocorrespondenciaestudiantegeneral = $d['telefonocorrespondenciaestudiantegeneral'];
            $EstudianteGeneral->emailestudiantegeneral = $d['emailestudiantegeneral'];
            $EstudianteGeneral->email2estudiantegeneral = $d['email2estudiantegeneral'];
            $EstudianteGeneral->fechacreacionestudiantegeneral = $d['fechacreacionestudiantegeneral'];
            $EstudianteGeneral->fechaactualizaciondatosestudiantegeneral = $d['fechaactualizaciondatosestudiantegeneral'];
            $EstudianteGeneral->codigotipocliente = $d['codigotipocliente'];
            $EstudianteGeneral->casoemergenciallamarestudiantegeneral = $d['casoemergenciallamarestudiantegeneral'];
            $EstudianteGeneral->telefono1casoemergenciallamarestudiantegeneral = $d['telefono1casoemergenciallamarestudiantegeneral'];
            $EstudianteGeneral->telefono2casoemergenciallamarestudiantegeneral = $d['telefono2casoemergenciallamarestudiantegeneral'];
            $EstudianteGeneral->idtipoestudiantefamilia = $d['idtipoestudiantefamilia'];
            $EstudianteGeneral->eps_estudiante = $d['eps_estudiante'];
            $EstudianteGeneral->tipoafiliacion = $d['tipoafiliacion'];
            $EstudianteGeneral->idciudadorigen = $d['idciudadorigen'];
            $EstudianteGeneral->esextranjeroestudiantegeneral = $d['esextranjeroestudiantegeneral'];
            $EstudianteGeneral->FechaDocumento = $d['FechaDocumento'];
            $EstudianteGeneral->idpaisnacimiento = $d['idpaisnacimiento'];
            $EstudianteGeneral->GrupoEtnicoId = $d['GrupoEtnicoId'];
            $EstudianteGeneral->EstadoActualizaDato = $d['EstadoActualizaDato'];
            $EstudianteGeneral->codigoestado = $d['codigoestado'];
            
            $return[] = $EstudianteGeneral;
            unset($EstudianteGeneral);
        }        
        return $return;
    }
}
/*/
idestudiantegeneral	int(11)
idtrato	int(11)
idestadocivil	int(11)
tipodocumento	char(2)
numerodocumento	varchar(15)
expedidodocumento	varchar(100)
numerolibretamilitar	varchar(20)
numerodistritolibretamilitar	varchar(10)
expedidalibretamilitar	varchar(50)
nombrecortoestudiantegeneral	varchar(15)
nombresestudiantegeneral	varchar(50)
apellidosestudiantegeneral	varchar(50)
fechanacimientoestudiantegeneral	datetime
idciudadnacimiento	int(11)
codigogenero	char(3)
direccionresidenciaestudiantegeneral	varchar(255)
direccioncortaresidenciaestudiantegeneral	varchar(255)
ciudadresidenciaestudiantegeneral	varchar(25)
telefonoresidenciaestudiantegeneral	varchar(15)
telefono2estudiantegeneral	varchar(15)
celularestudiantegeneral	varchar(15)
direccioncorrespondenciaestudiantegeneral	varchar(100)
direccioncortacorrespondenciaestudiantegeneral	varchar(255)
ciudadcorrespondenciaestudiantegeneral	varchar(25)
telefonocorrespondenciaestudiantegeneral	varchar(15)
emailestudiantegeneral	varchar(100)
email2estudiantegeneral	varchar(100)
fechacreacionestudiantegeneral	datetime
fechaactualizaciondatosestudiantegeneral	datetime
codigotipocliente	varchar(3)
casoemergenciallamarestudiantegeneral	varchar(255)
telefono1casoemergenciallamarestudiantegeneral	varchar(50)
telefono2casoemergenciallamarestudiantegeneral	varchar(50)
idtipoestudiantefamilia	int(11)
eps_estudiante	varchar(250)
tipoafiliacion	int(11)
idciudadorigen	int(11)
esextranjeroestudiantegeneral	tinyint(1)
FechaDocumento	date
idpaisnacimiento	int(11)
GrupoEtnicoId	int(11)
EstadoActualizaDato	char(1)
codigoestado	int(11)
/**/