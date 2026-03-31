<?php

namespace Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo;

defined('_EXEC') or die;

/** 
 * Clase InsertTablaCarreraPeriodo encargada de la insercion de registro 
 * de la tabla de subperiodo cuando se hace un regisitro nuevo en PeriodoAcademico
 * 
 * @author Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo
 * @since March 13, 2019
 */
class InsertTablaSubperiodo {
    /* @var \Entidad SubPeriodo
     * @access private
     */

    private $entidad;

    /**
     * @var adodb Object
     * @access private
     */
    private $db;

    public function __construct($entidad) {
        $this->entidad = $entidad;
        $this->db = \Factory::createDbo();
    }

    public function getEntidad() {
        return $this->entidad;
    }

    /**
     * Esta funcion se encarga de consultar los datos equivalentes a la tabla subperiodo respecto a las
     * tablas periodoacademico ,periodofinanciero y periodo maestro cuando se registra un periodo academico
     * @access public
     * @param int $idPeridoAcademico, int $codigoModalidadAcademica, int $codigoCarrera
     * @return objeto subperiodo
     * @author Diego RIvera<riveradiegos@unbosque.edu.co>
     * @since marzo 13, 2019
     */
    public function buscarSubperiodo($idPeridoAcademico, $codigoModalidadAcademica, $codigoCarrera) {
        $db = \Factory::createDbo();
        $query = " 	
                    SELECT
                        `pm`.`nombre` AS `nombresubperiodo`,
                        `pa`.`fechaCreacion` AS `fechasubperiodo`,
                        `pa`.`fechaInicio` AS `fechainicioacademicosubperiodo`,
                        `pa`.`fechaFin` AS `fechafinalacademicosubperiodo`,
                        `pf`.`fechaInicio` AS `fechainiciofinancierosubperiodo`,
                        `pf`.`fechaFin` AS `fechafinalfinancierosubperiodo`,
                        `pm`.`numeroPeriodo` AS `numerosubperiodo`,
                        `pa`.`idTipoPeriodo` AS `idtiposubperiodo`,
                        `pm`.`codigoEstado` AS `codigoestadosubperiodo`,
                        `pa`.`idUsuarioCreacion` AS `idusuario`,
                        `pa`.`ip` AS `ip` 
                    FROM
                        (
                            ( `periodoAcademico` `pa` JOIN `periodoMaestro` `pm` ON ( ( `pa`.`idPeriodoMaestro` = `pm`.`id` ) ) )
                            JOIN `periodoFinanciero` `pf` ON ( ( ( `pf`.`idPeriodoMaestro` = `pm`.`id` ) AND ( `pa`.`idPeriodoFinanciero` = `pf`.`id` ) ) ) 
                        ) 
                    WHERE
                        ( ( `pa`.`codigoModalidadAcademica` = " . $db->qstr($codigoModalidadAcademica) . " )
                        AND ( `pa`.`codigoCarrera` = " . $db->qstr($codigoCarrera) . " ) ) 
                        AND pa.id=" . $db->qstr($idPeridoAcademico);

        $datos = $db->Execute($query);
        $d = $datos->FetchRow();

        if (!empty($d)) {
            $this->entidad->setNombresubperiodo($d['nombresubperiodo']);
            $this->entidad->setFechasubperiodo($d['fechasubperiodo']);
            $this->entidad->setFechainicioacademicosubperiodo($d['fechainicioacademicosubperiodo']);
            $this->entidad->setFechafinalacademicosubperiodo($d['fechafinalacademicosubperiodo']);
            $this->entidad->setFechainiciofinancierosubperiodo($d['fechainiciofinancierosubperiodo']);
            $this->entidad->setFechafinalfinancierosubperiodo($d['fechafinalfinancierosubperiodo']);
            $this->entidad->setNumerosubperiodo($d['numerosubperiodo']);
            $this->entidad->setidtiposubperiodo($d['idtiposubperiodo']);
            $this->entidad->setCodigoestadosubperiodo($d['codigoestadosubperiodo']);
            $this->entidad->setIdusuario($d['idusuario']);
            $this->entidad->setIp($d['ip']);
        }
    }

    /**
     * Esta funcion se encarga de registra un subperiodo cuando se registra un periodo academico
     * @access public
     * @param int $idCarreraPeriodo
     * @param objeto subPeriodo 
     * @param objeto periodosObjeto
     * @return objeto subperiodo
     * @author Diego RIvera<riveradiegos@unbosque.edu.co>
     * @since marzo 13, 2019
     */
    public function nuevoSubPeriodo($subPeriodo, $idCarreraPeriodo, $periodosObjeto) {
        $db = $this->db;
        $this->entidad->setIdcarreraperiodo($idCarreraPeriodo);
        $this->entidad->setNombresubperiodo($subPeriodo->getNombresubperiodo());
        $this->entidad->setFechasubperiodo($subPeriodo->getFechasubperiodo());
        $this->entidad->setFechainicioacademicosubperiodo($subPeriodo->getFechainicioacademicosubperiodo());
        $this->entidad->setFechafinalacademicosubperiodo($subPeriodo->getFechafinalacademicosubperiodo());
        $this->entidad->setFechainiciofinancierosubperiodo($subPeriodo->getFechainiciofinancierosubperiodo());
        $this->entidad->setFechafinalfinancierosubperiodo($subPeriodo->getFechafinalfinancierosubperiodo());
        $this->entidad->setNumerosubperiodo($subPeriodo->getNumerosubperiodo());
        $this->entidad->setIdtiposubperiodo($subPeriodo->getIdtiposubperiodo());
        $this->entidad->setCodigoestadosubperiodo($subPeriodo->getCodigoestadosubperiodo());
        $this->entidad->setIdusuario($subPeriodo->getIdusuario());
        $this->entidad->setIp($subPeriodo->getIp());
        $this->entidad->setIdsubperiodo("");

        $verificarSubPeriodo = $this->entidad->getList(" idcarreraperiodo=" . $db->qstr($idCarreraPeriodo));

        $objetoRelacionInsertar = new \stdClass();
        $objetoRelacionInsertar->tabla = "subperiodo";
        $objetoRelacionInsertar->idPeriodoMaestro1 = $periodosObjeto->idPeriodoMaestro1;
        $objetoRelacionInsertar->idPeriodoMaestro2 = $periodosObjeto->idPeriodoMaestro2;
        $objetoRelacionInsertar->idPeriodoFinanciero = $periodosObjeto->idPeriodoFinanciero;
        $objetoRelacionInsertar->idPeriodoAcademico = $periodosObjeto->idPeriodoAcademico;

        $subPeriodoDao = new \Sala\entidadDAO\SubperiodoDAO($this->entidad);
        $subPeriodoDao->setDb();

        if (empty($verificarSubPeriodo)) {
            $result = $subPeriodoDao->save();
            $objetoRelacionInsertar->idTabla = $this->entidad->getIdsubperiodo();
        } else {
            foreach ($verificarSubPeriodo as $subperiodo) {
                $objetoRelacionInsertar->idTabla = $subperiodo->getIdsubperiodo();
                $this->entidad->setIdsubperiodo($subperiodo->getIdsubperiodo());
                $result = $subPeriodoDao->save();
            }
        }

        InsertTablaRelacionTablasPeriodos::insertarRelacionTablas($objetoRelacionInsertar);
    }

}
