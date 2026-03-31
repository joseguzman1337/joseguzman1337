<?php

namespace Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo;

defined('_EXEC') or die;

/** 
 * Clase InsertTablaCarreraPeriodo encargada de la insercion de registro 
 * de la tabla de carreraperiodo cuando se hace un regisitro nuevo en PeriodoAcademico
 * 
 * @author Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo
 * @since March 13, 2019
 */
class InsertTablaCarreraPeriodo {
    /* @var \Entidad CarreraPeriodo
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
     * Esta funcion se encarga de consultar los datos equivalentes a la tabla carreraperiodo respecto a las
     * tablas periodoacademico y periodo maestro cuando se registra un periodo academico
     * @access public
     * @param int $codigoCarrera, int $idPeriodoMaestro, int $codigoModalidad
     * @return objeto carreraperiodo
     * @author Diego RIvera<riveradiegos@unbosque.edu.co>
     * @since marzo 13, 2019
     */
    public function consultarCarreraPeriodo($codigoCarrera, $idPeriodoMaestro, $codigoModalidad) {
        $db = $this->db;
        $query = " SELECT
                        `pa`.`id` AS `idcarreraperiodo`,
                        `pa`.`codigoCarrera` AS `codigocarrera`,
                        `pm`.`codigo` AS `codigoperiodo`,
                        `pm`.`codigoEstado` AS `codigoestado` 
                    FROM
                        ( `periodoAcademico` `pa` JOIN `periodoMaestro` `pm` ON ( ( `pa`.`idPeriodoMaestro` = `pm`.`id` ) ) ) 
                    WHERE
                        `pa`.`codigoCarrera` = " . $db->qstr($codigoCarrera) . " 
                        AND pa.idPeriodoMaestro = " . $db->qstr($idPeriodoMaestro) . "  
                        AND `pa`.`codigoModalidadAcademica` = " . $db->qstr($codigoModalidad) . " ";
        $datos = $db->Execute($query);
        $d = $datos->FetchRow();

        if (!empty($d)) {
            $this->entidad->setIdCarreraPeriodo($d["idcarreraperiodo"]);
            $this->entidad->setCodigoCarrera($d["codigocarrera"]);
            $this->entidad->setCodigoPeriodo($d["codigoperiodo"]);
            $this->entidad->setCodigoEstado($d["codigoestado"]);
        }
    }

    /**
     * Esta funcion se encarga de registrar en la tabla carreraperiodo cuando se registra un periodo academico
     * @access public
     * @param int codigoCarrera, int idPeriodo, int codigoEstado
     * @param object periodosObjeto recibe los id de los diferentes periodos(academico,financiero,maestro)
     * @return boolean
     * @author Diego RIvera<riveradiegos@unbosque.edu.co>
     * @since marzo 13, 2019
     */
    public function nuevoCarreraPeriodo($codigoCarrera, $codigoPeriodo, $codigoEstado, $periodosObjeto) {
        $db = $this->db;
        $this->entidad->setCodigoCarrera($codigoCarrera);
        $this->entidad->setCodigoPeriodo($codigoPeriodo);
        $this->entidad->setCodigoEstado($codigoEstado);
        $this->entidad->setIdCarreraPeriodo("");

        $verificarCarreraPeriodo = $this->entidad->getList(" codigocarrera=" . $db->qstr($codigoCarrera) . " AND codigoperiodo=" . $db->qstr($codigoPeriodo));

        $objetoRelacionInsertar = new \stdClass();
        $objetoRelacionInsertar->tabla = "carreraperiodo";
        $objetoRelacionInsertar->idPeriodoMaestro1 = $periodosObjeto->idPeriodoMaestro1;
        $objetoRelacionInsertar->idPeriodoMaestro2 = $periodosObjeto->idPeriodoMaestro2;
        $objetoRelacionInsertar->idPeriodoFinanciero = $periodosObjeto->idPeriodoFinanciero;
        $objetoRelacionInsertar->idPeriodoAcademico = $periodosObjeto->idPeriodoAcademico;

        if (empty($verificarCarreraPeriodo)) {
            $carrerasPeriodoDao = new \Sala\entidadDAO\CarreraPeriodoDAO($this->entidad);
            $carrerasPeriodoDao->setDb();
            $carrerasPeriodoDao->save();
            $objetoRelacionInsertar->idTabla = $this->entidad->getIdCarreraPeriodo();
        } else {
            foreach ($verificarCarreraPeriodo as $carreraPeriodo) {
                $objetoRelacionInsertar->idTabla = $carreraPeriodo->getIdCarreraPeriodo();
                $this->entidad->setIdCarreraPeriodo($carreraPeriodo->getIdCarreraPeriodo());
            }
        }

        InsertTablaRelacionTablasPeriodos::insertarRelacionTablas($objetoRelacionInsertar);
    }

}
