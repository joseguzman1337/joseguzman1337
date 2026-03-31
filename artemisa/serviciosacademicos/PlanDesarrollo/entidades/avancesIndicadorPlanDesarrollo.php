<?php

/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología - Universidad el Bosque
 * @package entidades
 */
class avancesIndicadorPlanDesarrollo {

    /**
     * @type int
     * @access private
     */
    private $idAvancesIndicadorPlanDesarrollo;

    /**
     * @type int
     * @access private
     */
    private $indicadorPlanDesarrolloId;

    /**
     * @type text
     * @access private
     */
    private $actividad;

    /**
     * @type double
     * @access private
     */
    private $valorAvance;

    /**
     * @type datetime
     * @access private
     */
    private $fechaActividad;

    /**
     * @type date
     * @access private
     */
    private $observaciones;

    /**
     * @type int
     * @access private
     */
    private $idUsuario;

    /**
     * @type int
     * @access private
     */
    private $estado;

    /**
     * @type datetime
     * @access private
     */
    private $fechaRegistroAvance;

    /**
     * @type varchar
     * @access private
     */
    private $aprobacion;

    /**
     * @type varchar
     * @access private
     */
    private $evidencia;

    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function avancesIndicadorPlanDesarrollo($persistencia) {
        $this->persistencia = $persistencia;
    }

    public function setIdAvancesIndicadorPlanDesarrollo($idAvancesIndicadorPlanDesarrollo) {
        $this->idAvancesIndicadorPlanDesarrollo = $idAvancesIndicadorPlanDesarrollo;
    }

    public function getIdAvancesIndicadorPlanDesarrollo() {
        return $this->idAvancesIndicadorPlanDesarrollo;
    }

    public function setIndicadorPlanDesarrolloId($indicadorPlanDesarrolloId) {
        $this->indicadorPlanDesarrolloId = $indicadorPlanDesarrolloId;
    }

    public function getIndicadorPlanDesarrolloId() {
        return $this->indicadorPlanDesarrolloId;
    }

    public function setActividad($actividad) {
        $this->actividad = $actividad;
    }

    public function getActividad() {
        return $this->actividad;
    }

    public function setValorAvance($valorAvance) {
        $this->valorAvance = $valorAvance;
    }

    public function getValorAvance() {
        return $this->valorAvance;
    }

    public function setFechaActividad($fechaActividad) {
        $this->fechaActividad = $fechaActividad;
    }

    public function getFechaActividad() {
        return $this->fechaActividad;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setFechaRegistroAvance($fechaRegistroAvance) {
        $this->fechaRegistroAvance = $fechaRegistroAvance;
    }

    public function getFechaRegistroAvance() {
        return $this->fechaRegistroAvance;
    }

    public function setEvidencia($evidencia) {
        $this->evidencia = $evidencia;
    }

    public function getEvidencia() {
        return $this->evidencia;
    }

    public function setAprobacion($aprobacion) {
        $this->aprobacion = $aprobacion;
    }

    public function getAprobacion() {
        return $this->aprobacion;
    }

    public function registrarActividad($idPersona) {

        $sql = "INSERT INTO avancesIndicadorPlanDesarrollo (
                                        IndicadorPlanDesarrolloId,
                                        actividad,
                                        valorAvance,
                                        fechaActividad,
                                        observaciones,
                                        IdUsuario,
                                        estado,
                                        fechaRegistroAvance,
                                        evidencia
                                )
                                VALUES
                                        (
                                                ?,
                                                ?,
                                                ?,
                                                ?,
                                                NULL,
                                                ?,
                                                '100',
                                                NOW(),
                                                ?
                                        )";
        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $this->getIndicadorPlanDesarrolloId(), false);
        $this->persistencia->setParametro(1, $this->getActividad(), true);
        $this->persistencia->setParametro(2, $this->getValorAvance(), true);
        $this->persistencia->setParametro(3, $this->getFechaActividad(), true);
        $this->persistencia->setParametro(4, $idPersona, false);
        $this->persistencia->setParametro(5, $this->getEvidencia(), true);

        $this->persistencia->ejecutarUpdate();

        return true;
    }

    public function verAvance($indicadorPlanDesarrolloId) {

        $avances = array();
        $sql = "select max(idAvancesIndicadorPlanDesarrollo)as id, actividad,
                valorAvance, fechaActividad, Observaciones, aprobacion, indicadorPlanDesarrolloId
                from avancesIndicadorPlanDesarrollo
                where  IndicadorPlanDesarrolloId = ?	  
                group by  IndicadorPlanDesarrolloId, aprobacion , actividad, fechaActividad
                order by id ";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $indicadorPlanDesarrolloId, false);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setActividad($this->persistencia->getParametro("actividad"));
            $avancesIndicadorPlanDesarrollo->setValorAvance($this->persistencia->getParametro("valorAvance"));
            $avancesIndicadorPlanDesarrollo->setObservaciones($this->persistencia->getParametro("Observaciones"));
            $avancesIndicadorPlanDesarrollo->setFechaActividad($this->persistencia->getParametro("fechaActividad"));
            $avancesIndicadorPlanDesarrollo->setIdAvancesIndicadorPlanDesarrollo($this->persistencia->getParametro("id"));
            $avancesIndicadorPlanDesarrollo->setAprobacion($this->persistencia->getParametro("aprobacion"));
            $avancesIndicadorPlanDesarrollo->setIndicadorPlanDesarrolloId($this->persistencia->getParametro("indicadorPlanDesarrolloId"));
            $avances[] = $avancesIndicadorPlanDesarrollo;
        }
        $this->persistencia->freeResult();
        return $avances;
    }

    public function verAvanceTotal($idMetaPrincipal, $periodo = 0) {

        $avances = array();

        $sql = "select aipd.actividad, aipd.valorAvance, aipd.fechaActividad,
                aipd.Observaciones, aipd.aprobacion, aipd.indicadorPlanDesarrolloId
                from MetaIndicadorPlanDesarrollo mipd
                INNER JOIN MetaSecundariaPlanDesarrollo mspd on mspd.MetaIndicadorPlanDesarrolloId = mipd.MetaIndicadorPlanDesarrolloId
                INNER JOIN avancesIndicadorPlanDesarrollo aipd on aipd.IndicadorPlanDesarrolloId = mspd.MetaSecundariaPlanDesarrolloId
                where mipd.MetaIndicadorPlanDesarrolloId = ?";
        if ($periodo != 0) {
            $sql .= " and mspd.FechaFinMetaSecundaria like '%?%' ";
        }
        $sql .= " group by  aipd.IndicadorPlanDesarrolloId  , aipd.aprobacion , aipd.actividad, aipd.fechaActividad ";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMetaPrincipal, false);
        if ($periodo != 0) {
            $this->persistencia->setParametro(1, $periodo, false);
        }
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {

            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setActividad($this->persistencia->getParametro("actividad"));
            $avancesIndicadorPlanDesarrollo->setValorAvance($this->persistencia->getParametro("valorAvance"));
            $avancesIndicadorPlanDesarrollo->setObservaciones($this->persistencia->getParametro("Observaciones"));
            $avancesIndicadorPlanDesarrollo->setFechaActividad($this->persistencia->getParametro("fechaActividad"));
            $avancesIndicadorPlanDesarrollo->setAprobacion($this->persistencia->getParametro("aprobacion"));
            $avancesIndicadorPlanDesarrollo->setIndicadorPlanDesarrolloId($this->persistencia->getParametro("indicadorPlanDesarrolloId"));
            $avances[] = $avancesIndicadorPlanDesarrollo;
        }
        $this->persistencia->freeResult();
        return $avances;
    }

    public function verAvanceActual($indicadorPlanDesarrolloId) {
        $sql = "select valorAvance from avancesIndicadorPlanDesarrollo
		where IndicadorPlanDesarrolloId = ? and aprobacion ='Aprobado'
		order by fechaActividad desc limit 0,1 ";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $indicadorPlanDesarrolloId, false);
        $this->persistencia->ejecutarConsulta();

        if ($this->persistencia->getNext()) {
            $this->setValorAvance($this->persistencia->getParametro("valorAvance"));
        }
    }

    public function verAvanceId($idAvanve) {
        $sql = "select valorAvance
		from avancesIndicadorPlanDesarrollo
		where IndicadorPlanDesarrolloId = ? and aprobacion='' 
		GROUP BY IndicadorPlanDesarrolloId ";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idAvanve, false);
        $this->persistencia->ejecutarConsulta();

        if ($this->persistencia->getNext()) {
            $this->setValorAvance($this->persistencia->getParametro("valorAvance"));
        }
    }

    public function actualizarObservacion($idMetaSecundaria, $observaciones, $aprobacion) {
        
        $sql = " update avancesIndicadorPlanDesarrollo set observaciones = ?
		 where indicadorPlanDesarrolloId = ? and aprobacion = '' ";

        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $observaciones, true);
        $this->persistencia->setParametro(1, $idMetaSecundaria, false);
        $this->persistencia->ejecutarUpdate();

        return true;
    }

    public function actualizarAprobacion($idMetaSecundaria, $valor) {

        $sql = "update avancesIndicadorPlanDesarrollo set aprobacion = ?
		where indicadorPlandesarrolloId = ? and aprobacion = '' ";

        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $valor, true);
        $this->persistencia->setParametro(1, $idMetaSecundaria, false);
        $this->persistencia->ejecutarUpdate();

        return true;
    }

    public function actualizarAprobacionEliminar($idMetaSecundaria) {
        $sql = "update avancesIndicadorPlanDesarrollo set aprobacion = ''
		 where  indicadorPlandesarrolloId = ? and aprobacion = 'Aprobado' ";

        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMetaSecundaria, false);
        $this->persistencia->ejecutarUpdate();
        return true;
    }

    public function actualizarEvidencia($idMetaSecundaria, $actividad, $valorAvance, $evidencia, $fechaActividad) {
        $sql = "update avancesIndicadorPlanDesarrollo
            set actividad = ?, valorAvance = ?, fechaActividad = ?
            where IndicadorPlanDesarrolloId = ? and aprobacion='' ";

        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $actividad, true);
        $this->persistencia->setParametro(1, $valorAvance, false);
        $this->persistencia->setParametro(2, $fechaActividad, true);
        $this->persistencia->setParametro(3, $idMetaSecundaria, false);

        $this->persistencia->ejecutarUpdate();

        return true;
    }

    public function verAvanceEvidencia($idAvancesIndicadorPlanDesarrollo) {


        $sql = "select actividad, valorAvance, fechaActividad, Observaciones,
                evidencia, idAvancesIndicadorPlanDesarrollo, aprobacion, indicadorPlanDesarrolloId
                from avancesIndicadorPlanDesarrollo where indicadorPlanDesarrolloId = ?	
                group by indicadorPlanDesarrolloId ,aprobacion ";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idAvancesIndicadorPlanDesarrollo, false);
        $this->persistencia->ejecutarConsulta();

        if ($this->persistencia->getNext()) {

            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setActividad($this->persistencia->getParametro("actividad"));
            $avancesIndicadorPlanDesarrollo->setValorAvance($this->persistencia->getParametro("valorAvance"));
            $avancesIndicadorPlanDesarrollo->setObservaciones($this->persistencia->getParametro("Observaciones"));
            $avancesIndicadorPlanDesarrollo->setFechaActividad($this->persistencia->getParametro("fechaActividad"));
            $avancesIndicadorPlanDesarrollo->setEvidencia($this->persistencia->getParametro("evidencia"));
            $avancesIndicadorPlanDesarrollo->setIdAvancesIndicadorPlanDesarrollo($this->persistencia->getParametro("idAvancesIndicadorPlanDesarrollo"));
            $avancesIndicadorPlanDesarrollo->setAprobacion($this->persistencia->getParametro("aprobacion"));
            $avancesIndicadorPlanDesarrollo->setIndicadorPlanDesarrolloId($this->persistencia->getParametro("indicadorPlanDesarrolloId"));
            return $avancesIndicadorPlanDesarrollo;
        }
    }

    public function verEstadoAvance($idMetaSecundaria) {

        $sql = "SELECT count(*) as indicadorPlanDesarrolloId
		FROM avancesIndicadorPlanDesarrollo aipd
		WHERE aipd.IndicadorPlanDesarrolloId = ?
		and aipd.aprobacion =''";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMetaSecundaria, false);
        $this->persistencia->ejecutarConsulta();

        if ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setIndicadorPlanDesarrolloId($this->persistencia->getParametro("indicadorPlanDesarrolloId"));
            return $avancesIndicadorPlanDesarrollo;
        }
    }

    public function VerEvidencias($idMetaSecundaria, $fechaActividad, $actividad, $valorAvance, $aprobacion) {
        $avances = array();
        $sql = "SELECT idAvancesIndicadorPlanDesarrollo, evidencia, aprobacion
                FROM avancesIndicadorPlanDesarrollo
		WHERE IndicadorPlanDesarrolloId = ? and fechaActividad = ? and 
                valorAvance = ? and aprobacion = ? ";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMetaSecundaria, false);
        $this->persistencia->setParametro(1, $fechaActividad, true);
        $this->persistencia->setParametro(2, $valorAvance, false);
        $this->persistencia->setParametro(3, $aprobacion, true);

        $this->persistencia->ejecutarConsulta();

        while ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setIdAvancesIndicadorPlanDesarrollo($this->persistencia->getParametro("idAvancesIndicadorPlanDesarrollo"));
            $avancesIndicadorPlanDesarrollo->setEvidencia($this->persistencia->getParametro("evidencia"));
            $avancesIndicadorPlanDesarrollo->setAprobacion($this->persistencia->getParametro("aprobacion"));
            $avances[] = $avancesIndicadorPlanDesarrollo;
        }

        return $avances;
    }

    public function VerEvidenciasMeta($idMeta, $fecha, $actividad, $avance, $aprabado) {
        $avances = array();
        $sql = "select  aipd.evidencia,aprobacion				
			from MetaIndicadorPlanDesarrollo mipd
                        INNER JOIN MetaSecundariaPlanDesarrollo mspd on mspd.MetaIndicadorPlanDesarrolloId = mipd.MetaIndicadorPlanDesarrolloId
                        INNER JOIN avancesIndicadorPlanDesarrollo aipd on aipd.IndicadorPlanDesarrolloId = mspd.MetaSecundariaPlanDesarrolloId
			where mipd.MetaIndicadorPlanDesarrolloId = ? and aipd.fechaActividad = ? and aipd.valorAvance = ? and aipd.aprobacion = ?  ";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMeta, false);
        $this->persistencia->setParametro(1, $fecha, true);
        $this->persistencia->setParametro(2, $avance, false);
        $this->persistencia->setParametro(3, $aprabado, true);

        $this->persistencia->ejecutarConsulta();

        while ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setEvidencia($this->persistencia->getParametro("evidencia"));
            $avancesIndicadorPlanDesarrollo->setAprobacion($this->persistencia->getParametro("aprobacion"));
            $avances[] = $avancesIndicadorPlanDesarrollo;
        }


        return $avances;
    }

    public function eliminarEvidencia($idAvance) {
        $sql = "DELETE FROM avancesIndicadorPlanDesarrollo
			WHERE idAvancesIndicadorPlanDesarrollo = ?";

        $this->persistencia->conectar();
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idAvance, false);
        $this->persistencia->ejecutarConsulta();

        return true;
    }

    public function listaArchivosAnual($idMetaSecundaria, $periodo) {
        $lista = array();
        $sql = "SELECT AIPD.evidencia 
                FROM avancesIndicadorPlanDesarrollo AIPD  
                LEFT JOIN MetaSecundariaPlanDesarrollo MSPD  on  (AIPD.IndicadorPlanDesarrolloId =  MSPD.MetaSecundariaPlanDesarrolloId)
                WHERE AIPD.IndicadorPlanDesarrolloId = ?  and AIPD.estado = 100 and MSPD.FechaFinMetaSecundaria like '%?%'";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMetaSecundaria, false);
        $this->persistencia->setParametro(1, $periodo, false);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarConsulta();
        $this->persistencia->getSQLListo();
        while ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setEvidencia($this->persistencia->getParametro("evidencia"));
            $lista[] = $avancesIndicadorPlanDesarrollo;
        }
        return $lista;
    }

    public function listaArchivosTotal($idMeta) {
        $lista = array();
        $sql = "SELECT aipd.evidencia 
                FROM MetaIndicadorPlanDesarrollo mipd
                LEFT JOIN MetaSecundariaPlanDesarrollo mspd ON ( mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId )
                LEFT JOIN avancesIndicadorPlanDesarrollo aipd ON ( mspd.MetaSecundariaPlanDesarrolloId = aipd.IndicadorPlanDesarrolloId ) 
                WHERE mipd.MetaIndicadorPlanDesarrolloId = ? 
                AND mspd.EstadoMetaSecundaria = 100 
                AND aipd.estado = 100 AND aprobacion<>'No aprobado' ";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $idMeta, false);
        $this->persistencia->ejecutarConsulta();
        $this->persistencia->getSQLListo();
        while ($this->persistencia->getNext()) {
            $avancesIndicadorPlanDesarrollo = new avancesIndicadorPlanDesarrollo($this->persistencia);
            $avancesIndicadorPlanDesarrollo->setEvidencia($this->persistencia->getParametro("evidencia"));
            $lista[] = $avancesIndicadorPlanDesarrollo;
        }
        return $lista;
    }

}

?>