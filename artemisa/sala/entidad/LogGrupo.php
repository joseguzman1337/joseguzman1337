<?php
/**
 * @author Jesus Jimenez (king of kings) <jimenezjesus@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 * 
*/
//defined('_EXEC') or die;
class LogGrupo{

    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idLogGrupo;
    private $idGrupo;
    private $codigoGrupo;
    private $nombreGrupo;
    private $codigoMateria;
    private $codigoPeriodo;
    private $numeroDocumento;
    private $maximoGrupo;
    private $matriculadosGrupo;
    private $maximoGrupoElectiva;
    private $matriculadosGrupoElectiva;
    private $codigoEstadoGrupo;
    private $codigoIndicadorHorario;
    private $fechaInicioGrupo;
    private $fechaFinalGrupo;
    private $numeroDiasConservaGrupo;
    private $fechaLogGrupo;
    private $idUsuario;
    private $dataGroup;


    
    public function __construct($idGrupo)
    {
        $this->setDb();
        $this->idLogGrupo = "";
        $this->idGrupo = $idGrupo;
        $this->setParametersGroup();

    }

    public function getDb()
    {
        return $this->db;
    }

    public function setParametersGroup()
    {
        $query = "select * from grupo where idgrupo = ".$this->idGrupo;
        $dataGroup = $this->db->Execute($query);
        $this->dataGroup = $dataGroup->FetchRow();

        $this->codigoGrupo = $this->dataGroup['codigogrupo'];
        $this->nombreGrupo = $this->dataGroup['nombregrupo'];
        $this->codigoMateria = $this->dataGroup['codigomateria'];
        $this->codigoPeriodo = $this->dataGroup['codigoperiodo'];
        $this->numeroDocumento = $this->dataGroup['numerodocumento'];
        $this->maximoGrupo = $this->dataGroup['maximogrupo'];
        $this->matriculadosGrupo = $this->dataGroup['matriculadosgrupo'];
        $this->maximoGrupoElectiva = $this->dataGroup['maximogrupoelectiva'];
        $this->matriculadosGrupoElectiva = $this->dataGroup['matriculadosgrupoelectiva'];
        $this->codigoEstadoGrupo = $this->dataGroup['codigoestadogrupo'];
        $this->codigoIndicadorHorario = $this->dataGroup['codigoindicadorhorario'];
        $this->fechaInicioGrupo = $this->dataGroup['fechainiciogrupo'];
        $this->fechaFinalGrupo = $this->dataGroup['fechafinalgrupo'];
        $this->numeroDiasConservaGrupo = $this->dataGroup['numerodiasconservagrupo'];
        $this->fechaLogGrupo = date('Y-m-d h:m:s');
        $this->idUsuario = $_SESSION['idusuario'];

    }

    public function getDataGroup()
    {
        return $this->dataGroup;
    }

    public function setDb(){
        $this->db = Factory::createDbo();
    }

    /**
     * @return mixed
     */
    public function getIdLogGrupo()
    {
        return $this->idLogGrupo;
    }

    /**
     * @param mixed $idLogGrupo
     */
    public function setIdLogGrupo($idLogGrupo)
    {
        $this->idLogGrupo = $idLogGrupo;
    }

    /**
     * @return mixed
     */
    public function getIdGrupo()
    {
        return $this->idGrupo;
    }

    /**
     * @param mixed $idGrupo
     */
    public function setIdGrupo($idGrupo)
    {
        $this->idGrupo = $idGrupo;
    }

    /**
     * @return mixed
     */
    public function getCodigoGrupo()
    {
        return $this->codigoGrupo;
    }

    /**
     * @param mixed $codigoGrupo
     */
    public function setCodigoGrupo($codigoGrupo)
    {
        $this->codigoGrupo = $codigoGrupo;
    }

    /**
     * @return mixed
     */
    public function getNombreGrupo()
    {
        return $this->nombreGrupo;
    }

    /**
     * @param mixed $nombreGrupo
     */
    public function setNombreGrupo($nombreGrupo)
    {
        $this->nombreGrupo = $nombreGrupo;
    }

    /**
     * @return mixed
     */
    public function getCodigoMateria()
    {
        return $this->codigoMateria;
    }

    /**
     * @param mixed $codigoMateria
     */
    public function setCodigoMateria($codigoMateria)
    {
        $this->codigoMateria = $codigoMateria;
    }

    /**
     * @return mixed
     */
    public function getCodigoPeriodo()
    {
        return $this->codigoPeriodo;
    }

    /**
     * @param mixed $codigoPeriodo
     */
    public function setCodigoPeriodo($codigoPeriodo)
    {
        $this->codigoPeriodo = $codigoPeriodo;
    }

    /**
     * @return mixed
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * @param mixed $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * @return mixed
     */
    public function getMaximoGrupo()
    {
        return $this->maximoGrupo;
    }

    /**
     * @param mixed $maximoGrupo
     */
    public function setMaximoGrupo($maximoGrupo)
    {
        $this->maximoGrupo = $maximoGrupo;
    }

    /**
     * @return mixed
     */
    public function getMatriculadosGrupo()
    {
        return $this->matriculadosGrupo;
    }

    /**
     * @param mixed $matriculadosGrupo
     */
    public function setMatriculadosGrupo($matriculadosGrupo)
    {
        $this->matriculadosGrupo = $matriculadosGrupo;
    }

    /**
     * @return mixed
     */
    public function getMaximoGrupoElectiva()
    {
        return $this->maximoGrupoElectiva;
    }

    /**
     * @param mixed $maximoGrupoElectiva
     */
    public function setMaximoGrupoElectiva($maximoGrupoElectiva)
    {
        $this->maximoGrupoElectiva = $maximoGrupoElectiva;
    }

    /**
     * @return mixed
     */
    public function getMatriculadosGrupoElectiva()
    {
        return $this->matriculadosGrupoElectiva;
    }

    /**
     * @param mixed $matriculadosGrupoElectiva
     */
    public function setMatriculadosGrupoElectiva($matriculadosGrupoElectiva)
    {
        $this->matriculadosGrupoElectiva = $matriculadosGrupoElectiva;
    }

    /**
     * @return mixed
     */
    public function getCodigoEstadoGrupo()
    {
        return $this->codigoEstadoGrupo;
    }

    /**
     * @param mixed $codigoEstadoGrupo
     */
    public function setCodigoEstadoGrupo($codigoEstadoGrupo)
    {
        $this->codigoEstadoGrupo = $codigoEstadoGrupo;
    }

    /**
     * @return mixed
     */
    public function getCodigoIndicadorHorario()
    {
        return $this->codigoIndicadorHorario;
    }

    /**
     * @param mixed $codigoIndicadorHorario
     */
    public function setCodigoIndicadorHorario($codigoIndicadorHorario)
    {
        $this->codigoIndicadorHorario = $codigoIndicadorHorario;
    }

    /**
     * @return mixed
     */
    public function getFechaInicioGrupo()
    {
        return $this->fechaInicioGrupo;
    }

    /**
     * @param mixed $fechaInicioGrupo
     */
    public function setFechaInicioGrupo($fechaInicioGrupo)
    {
        $this->fechaInicioGrupo = $fechaInicioGrupo;
    }

    /**
     * @return mixed
     */
    public function getFechaFinalGrupo()
    {
        return $this->fechaFinalGrupo;
    }

    /**
     * @param mixed $fechaFinalGrupo
     */
    public function setFechaFinalGrupo($fechaFinalGrupo)
    {
        $this->fechaFinalGrupo = $fechaFinalGrupo;
    }

    /**
     * @return mixed
     */
    public function getNumeroDiasConservaGrupo()
    {
        return $this->numeroDiasConservaGrupo;
    }

    /**
     * @param mixed $numeroDiasConservaGrupo
     */
    public function setNumeroDiasConservaGrupo($numeroDiasConservaGrupo)
    {
        $this->numeroDiasConservaGrupo = $numeroDiasConservaGrupo;
    }

    /**
     * @return mixed
     */
    public function getFechaLogGrupo()
    {
        return $this->fechaLogGrupo;
    }

    /**
     * @param mixed $fechaLogGrupo
     */
    public function setFechaLogGrupo($fechaLogGrupo)
    {
        $this->fechaLogGrupo = $fechaLogGrupo;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * @param mixed $idUsuario
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getById(){
        if(!is_null($this->idloggrupo)){
            $query = "SELECT * FROM loggrupo "
                    . "WHERE idloggrupo = ".$this->db->qstr($this->idgrupo);
            //d($query);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();

            if(!empty($d)){
                $this->idgrupo = $d['idgrupo'];
                $this->codigogrupo = $d['codigogrupo'];
                $this->nombregrupo = $d['nombregrupo'];
                $this->codigomateria = $d['codigomateria'];
                $this->codigoperiodo = $d['codigoperiodo'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->maximogrupo = $d['maximogrupo'];
                $this->matriculadosgrupo = $d['matriculadosgrupo'];
                $this->maximogrupoelectiva = $d['maximogrupoelectiva'];
                $this->matriculadosgrupoelectiva = $d['matriculadosgrupoelectiva'];
                $this->codigoestadogrupo = $d['codigoestadogrupo'];
                $this->codigoindicadorhorario = $d['codigoindicadorhorario'];
                $this->fechainiciogrupo = $d['fechainiciogrupo'];
                $this->fechafinalgrupo = $d['fechafinalgrupo'];
                $this->numerodiasconservagrupo = $d['numerodiasconservagrupo'];
                $this->fechaloggrupo = $d['fechaloggrupo'];
            }
        }
    }

    public static function getList($where = null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM logrgupo "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }

        $datos = $db->Execute($query);

        while( $d = $datos->FetchRow() ){
            $logGrupo = new LogGrupo($d['idgrupo']);
            $logGrupo->idgrupo = $d['idgrupo'];
            $logGrupo->codigogrupo = $d['codigogrupo'];
            $logGrupo->nombregrupo = $d['nombregrupo'];
            $logGrupo->codigomateria = $d['codigomateria'];
            $logGrupo->codigoperiodo = $d['codigoperiodo'];
            $logGrupo->numerodocumento = $d['numerodocumento'];
            $logGrupo->maximogrupo = $d['maximogrupo'];
            $logGrupo->matriculadosgrupo = $d['matriculadosgrupo'];
            $logGrupo->maximogrupoelectiva = $d['maximogrupoelectiva'];
            $logGrupo->matriculadosgrupoelectiva = $d['matriculadosgrupoelectiva'];
            $logGrupo->codigoestadogrupo = $d['codigoestadogrupo'];
            $logGrupo->codigoindicadorhorario = $d['codigoindicadorhorario'];
            $logGrupo->fechainiciogrupo = $d['fechainiciogrupo'];
            $logGrupo->fechafinalgrupo = $d['fechafinalgrupo'];
            $logGrupo->numerodiasconservagrupo = $d['numerodiasconservagrupo'];
            $logGrupo->fechaloggrupo = $d['fechaloggrupo'];



            $return[] = $logGrupo;
            unset($logGrupo);
        }

        return $return;
    }
}

