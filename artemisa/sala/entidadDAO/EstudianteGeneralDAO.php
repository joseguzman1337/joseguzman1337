<?php
namespace Sala\entidadDAO;
defined('_EXEC') or die;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidadDAO
 * 
*/
class EstudianteGeneralDAO implements \Sala\interfaces\EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $estudianteGeneral;

    public function __construct(\EstudianteGeneral $estudianteGeneral) {
        $this->estudianteGeneral = $estudianteGeneral;
    }
    
    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    /**
     * Hace una consulta DML de tipo insert o update para las persistencias de 
     * datos en las tabla estudiante con los datos recibidos en $estudianteGeneral
     * @access public
     * @return void
     */
    public function save() {        
        $query = "";
        $where = array();
        $idestudiantegeneral=$this->estudianteGeneral->getIdestudiantegeneral();
        if(empty($idestudiantegeneral)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getIdestudiantegeneral());
        }
        
        $query .= " estudiantegeneral SET ";
	$query .= " idtrato = ".$this->db->qstr($this->estudianteGeneral->getIdtrato());
        $query .= " ,idestadocivil = ".$this->db->qstr($this->estudianteGeneral->getIdestadocivil());
        $query .= " ,tipodocumento = ".$this->db->qstr($this->estudianteGeneral->getTipodocumento());
        $query .= " ,numerodocumento = ".$this->db->qstr($this->estudianteGeneral->getNumerodocumento());
        $query .= " ,expedidodocumento = ".$this->db->qstr($this->estudianteGeneral->getExpedidodocumento());
        $query .= " ,numerolibretamilitar = ".$this->db->qstr($this->estudianteGeneral->getNumerolibretamilitar());
        $query .= " ,numerodistritolibretamilitar = ".$this->db->qstr($this->estudianteGeneral->getNumerodistritolibretamilitar());
        $query .= " ,expedidalibretamilitar = ".$this->db->qstr($this->estudianteGeneral->getExpedidalibretamilitar());
        $query .= " ,nombrecortoestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getNombrecortoestudiantegeneral());
        $query .= " ,nombresestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getNombresestudiantegeneral());
        $query .= " ,apellidosestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getApellidosestudiantegeneral());
        $query .= " ,fechanacimientoestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getFechanacimientoestudiantegeneral());
        $query .= " ,idciudadnacimiento = ".$this->db->qstr($this->estudianteGeneral->getIdciudadnacimiento());
        $query .= " ,codigogenero = ".$this->db->qstr($this->estudianteGeneral->getCodigogenero());
        $query .= " ,direccionresidenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getDireccionresidenciaestudiantegeneral());
        $query .= " ,direccioncortaresidenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getDireccioncortaresidenciaestudiantegeneral());
        $query .= " ,ciudadresidenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getCiudadresidenciaestudiantegeneral());
        $query .= " ,telefonoresidenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getTelefonoresidenciaestudiantegeneral());
        $query .= " ,telefono2estudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getTelefono2estudiantegeneral());
        $query .= " ,celularestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getCelularestudiantegeneral());
        $query .= " ,direccioncorrespondenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getDireccioncorrespondenciaestudiantegeneral());
        $query .= " ,direccioncortacorrespondenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getDireccioncortacorrespondenciaestudiantegeneral());
        $query .= " ,ciudadcorrespondenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getCiudadcorrespondenciaestudiantegeneral());
        $query .= " ,telefonocorrespondenciaestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getTelefonocorrespondenciaestudiantegeneral());
        $query .= " ,emailestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getEmailestudiantegeneral());
        $query .= " ,email2estudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getEmail2estudiantegeneral());
        $query .= " ,fechacreacionestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getFechacreacionestudiantegeneral());
        $query .= " ,fechaactualizaciondatosestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getFechaactualizaciondatosestudiantegeneral());
        $query .= " ,codigotipocliente = ".$this->db->qstr($this->estudianteGeneral->getCodigotipocliente());
        $query .= " ,casoemergenciallamarestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getCasoemergenciallamarestudiantegeneral());
        $query .= " ,telefono1casoemergenciallamarestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getTelefono1casoemergenciallamarestudiantegeneral());
        $query .= " ,telefono2casoemergenciallamarestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getTelefono2casoemergenciallamarestudiantegeneral());
        $query .= " ,idtipoestudiantefamilia = ".$this->db->qstr($this->estudianteGeneral->getIdtipoestudiantefamilia());
        $query .= " ,eps_estudiante = ".$this->db->qstr($this->estudianteGeneral->getEps_estudiante());
        $query .= " ,tipoafiliacion = ".$this->db->qstr($this->estudianteGeneral->getTipoafiliacion());
        $query .= " ,idciudadorigen = ".$this->db->qstr($this->estudianteGeneral->getIdciudadorigen());
        $query .= " ,esextranjeroestudiantegeneral = ".$this->db->qstr($this->estudianteGeneral->getEsextranjeroestudiantegeneral());
        $query .= " ,FechaDocumento = ".$this->db->qstr($this->estudianteGeneral->getFechaDocumento());
        $query .= " ,idpaisnacimiento = ".$this->db->qstr($this->estudianteGeneral->getIdpaisnacimiento());
        $query .= " ,GrupoEtnicoId = ".$this->db->qstr($this->estudianteGeneral->getGrupoEtnicoId());
        $query .= " ,EstadoActualizaDato = ".$this->db->qstr($this->estudianteGeneral->getEstadoActualizaDato());   
        $query .= " ,codigoestado = ".$this->db->qstr($this->estudianteGeneral->getCodigoestado());
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        
        if(empty($idestudiantegeneral)){
            $this->estudianteGeneral->setIdestudiantegeneral($this->db->insert_Id());
        }
        $this->logAuditoria($this->estudianteGeneral, $query);
        if(!$rs){
            return false;
        }else{
            return true;
        }
        
    }
    
    public function logAuditoria( $e, $query) {
        require_once(PATH_SITE."/entidadDAO/LogAuditoriaDAO.php");
        $idUsuario = \Factory::getSessionVar("idusuario");
        \Sala\entidadDAO\LogAuditoriaDAO::setLogAuditoria($e, $query, $idUsuario);
    }

}
