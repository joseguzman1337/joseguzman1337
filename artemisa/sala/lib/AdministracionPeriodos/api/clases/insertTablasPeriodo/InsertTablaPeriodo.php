<?php

namespace Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo;

defined('_EXEC') or die;

/** 
 * Clase InsertTablaPeriodo encargada de la insercion de registro 
 * de la tabla de periodo cuando se hace un regisitro nuevo en PeriodoAcademico
 * 
 * @author Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo
 * @since March 13, 2019
 */
class InsertTablaPeriodo {
    /* @var \Entidad periodo
     * @access private
     */
    private $entidad;
   /**
     * @type int
     * @access private
     */
    private $idPeriodoFinanciero;

    /**
     * @var adodb Object
     * @access private
     */
    private $db;

    public function __construct($entidad, $idPeriodoFinanciero) {
        $this->entidad = $entidad;
        $this->idPeriodoFinanciero = $idPeriodoFinanciero;
        $this->db = \Factory::createDbo();
    }
    /**
     * Esta funcion se encarga de registrar en la tabla  periodo  cuando  se registra un periodo academico
     * @access public
     * @return objeto subperiodo
     * @author Diego RIvera<riveradiegos@unbosque.edu.co>
     * @since marzo 13, 2019
     */
    public function nuevoPeriodo() {
        $db = $this->db;
        $query = "
                SELECT
                    `pmf`.`id` AS `PeriodoId`,
                    `pmf`.`codigo` AS `codigoperiodo`,
                    `pma`.`nombre` AS `nombrePeriodo`,
                    `pa`.`idEstadoPeriodo` AS `codigoestadoperiodo`,
                    `pa`.`id` AS `idPeriodoAcademico`,
                    `pf`.`id` AS `idPeriodoFinanciero`,
                    `pf`.`fechaInicio` AS `fechainicioperiodo`,
                    `pf`.`fechaFin` AS `fechavencimientoperiodo`,
                    `pma`.`numeroPeriodo` AS `numeroperiodo` 
                FROM
                    (
                        (
                            ( `periodoFinanciero` `pf` JOIN `periodoMaestro` `pmf` ON ( ( `pmf`.`id` = `pf`.`idPeriodoMaestro` ) ) )
                            JOIN `periodoAcademico` `pa` ON ( ( `pa`.`idPeriodoFinanciero` = `pf`.`id` ) ) 
                        )
                        JOIN `periodoMaestro` `pma` ON ( ( `pma`.`id` = `pa`.`idPeriodoMaestro` ) ) 
                    ) 
                WHERE
                        ( ( `pa`.`codigoModalidadAcademica` = 1 ) AND ( `pa`.`codigoCarrera` = 1 ) ) AND pf.id=" . $db->qstr($this->idPeriodoFinanciero);

        $datos = $db->Execute($query);
        $d = $datos->FetchRow();
        
        $this->entidad->setCodigoperiodo($d["codigoperiodo"]);
        $this->entidad->setNombrePeriodo($d["nombrePeriodo"]);
        $this->entidad->setCodigoEstadoPeriodo($d["codigoestadoperiodo"]);
        $this->entidad->setFechaInicioPeriodo($d["fechainicioperiodo"]);
        $this->entidad->setFechaVencimientoPeriodo($d["fechavencimientoperiodo"]);
        $this->entidad->setNumeroPeriodo($d["numeroperiodo"]);
        $periodos = new \Sala\entidadDAO\PeriodoDAO($this->entidad);
        $periodos->setDb();
        $periodos->save();
        
        $this->entidad->setDb();
        $this->entidad->getById();

        $objetoRelacionInsertar = new \stdClass();
        $objetoRelacionInsertar->tabla = "periodo";
        $objetoRelacionInsertar->idTabla = $this->entidad->getPeriodoId();
        $objetoRelacionInsertar->idPeriodoMaestro1 = $d["PeriodoId"];
        $objetoRelacionInsertar->idPeriodoMaestro2 = null;
        $objetoRelacionInsertar->idPeriodoFinanciero = $d["idPeriodoFinanciero"];
        $objetoRelacionInsertar->idPeriodoAcademico =$d["idPeriodoAcademico"];
        
        InsertTablaRelacionTablasPeriodos::insertarRelacionTablas($objetoRelacionInsertar);
    }

}
