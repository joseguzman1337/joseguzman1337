<?php

namespace Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo;

defined('_EXEC') or die;

/** 
 * Clase InsertTablaRelacionTablasPeriodos encargada de la insercion de registro 
 * de las relaciones entre las tablas legado y las tablas de PeriodoMaestro,
 * PeriodoFinanciero y PeriodoAcademico
 * 
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\clases\insertTablasPeriodo
 * @since March 13, 2019 
 */
abstract class InsertTablaRelacionTablasPeriodos {

    public static function insertarRelacionTablas(\stdClass $objetoRelacionInsertar) {
        $db = \Factory::createDbo();
        $eRelacionTablasPeriodos = new \Sala\entidad\RelacionTablasPeriodos();
        $eRelacionTablasPeriodos->setTabla($objetoRelacionInsertar->tabla);
        $eRelacionTablasPeriodos->setIdTabla($objetoRelacionInsertar->idTabla);
        $eRelacionTablasPeriodos->setIdPeriodoMaestro1($objetoRelacionInsertar->idPeriodoMaestro1);
        $eRelacionTablasPeriodos->setIdPeriodoMaestro2($objetoRelacionInsertar->idPeriodoMaestro2);
        $eRelacionTablasPeriodos->setIdPeriodoFinanciero($objetoRelacionInsertar->idPeriodoFinanciero);
        $eRelacionTablasPeriodos->setIdPeriodoAcademico($objetoRelacionInsertar->idPeriodoAcademico);
        $relacionTablas = new \Sala\entidad\RelacionTablasPeriodos();
        $relacionTablasPeriodos = $relacionTablas->getList(" tabla=" . $db->qstr($objetoRelacionInsertar->tabla) . " AND idTabla=" . $db->qstr($objetoRelacionInsertar->idTabla) . "");

        if (!empty($relacionTablasPeriodos)) {
            foreach ($relacionTablasPeriodos as $tablasPeriodo) {
                $eRelacionTablasPeriodos->setId($tablasPeriodo->getId());
            }
        }

        $relacionTablasPeriodosDAO = new \Sala\entidadDAO\RelacionTablasPeriodosDAO($eRelacionTablasPeriodos);
        $relacionTablasPeriodosDAO->setDb();
        $relacionTablasPeriodosDAO->save();
    }

}
