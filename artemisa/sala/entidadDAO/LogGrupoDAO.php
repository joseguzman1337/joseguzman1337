<?php namespace Sala\entidadDAO;
use Sala\interfaces\EntidadDAO;
use Sala\entidad;

//defined('_EXEC') or die;

class LogGrupoDAO
{

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type LogGrupo
     * @access private
     */
    private $logGrupoEntity;

    public function __construct(\LogGrupo $logGrupo)
    {
        $this->setDb();
        $this->logGrupoEntity = $logGrupo;
    }

    public function setDb(){
        $this->db = \Factory::createDbo();
    }

    public function logAuditoria($e, $query)
    {
        // TODO: Implement logAuditoria() method.
    }

    public function save()
    {
        $query = "";
        $where = array();
        $logIdGrupo = $this->logGrupoEntity->getIdLogGrupo();
        if(empty($logIdGrupo)){
            $query .= "INSERT INTO ";
        }

        $query .= " loggrupo (
        idgrupo,
        codigogrupo,
        nombregrupo,
        codigomateria,
        codigoperiodo,
        numerodocumento,
        maximogrupo,
        matriculadosgrupo,
        maximogrupoelectiva,
        matriculadosgrupoelectiva,
        codigoestadogrupo,
        codigoindicadorhorario,
        fechainiciogrupo,
        fechafinalgrupo,
        numerodiasconservagrupo,
        fechaloggrupo,
        idUsuario
        ) values
        (
            ".$this->logGrupoEntity->getIdGrupo() .",
            '".$this->logGrupoEntity->getCodigoGrupo()."',
            '".$this->logGrupoEntity->getNombreGrupo()."',
            ".$this->logGrupoEntity->getCodigoMateria().",
            ".$this->logGrupoEntity->getCodigoPeriodo().",
            ".$this->logGrupoEntity->getNumeroDocumento().",
            ".$this->logGrupoEntity->getMaximoGrupo().",
            ".$this->logGrupoEntity->getMatriculadosGrupo().",
            ".$this->logGrupoEntity->getMaximoGrupoElectiva().",
            ".$this->logGrupoEntity->getMatriculadosGrupoElectiva().",
            ".$this->logGrupoEntity->getCodigoEstadoGrupo().",
            ".$this->logGrupoEntity->getCodigoIndicadorHorario().",
            '".$this->logGrupoEntity->getFechaInicioGrupo()."',
            '".$this->logGrupoEntity->getFechaFinalGrupo()."',
            ".$this->logGrupoEntity->getNumeroDiasConservaGrupo().",
            '".$this->logGrupoEntity->getFechaLogGrupo()."',
            ".$this->logGrupoEntity->getIdUsuario()."
        );";

        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }

        $rs = $this->db->Execute($query);
        if(empty($codigoestudiante)){
            $this->logGrupoEntity->setIdLogGrupo($this->db->insert_Id());
        }

        if(!$rs){
            return false;
        }

            return true;
    }

}