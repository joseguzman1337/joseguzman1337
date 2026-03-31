<?php

namespace App\entidades;


class FormulaLiquidacion extends EntidadBase
{

    public $_table = 'FormulaLiquidaciones';

    /**
     * @param int $idCarrera
     * @param int $estadosFormula
     * <p>
     *  <b>ESTADO_LIQ100</b> Cuando se carga está bandera las formulas con estado 100 seran cargadas. Por defecto ser carga
     *  <b>ESTADO_LIQ200</b> Cuando se carga está bandera las formulas con estado 200 seran cargadas
     *  <b>Nota:</b> las banderas deben ir separadas por pipelines
     * </p>
     * @return array
     */
    public function formulasPorPrograma($idCarrera, $estadosFormula = ESTADO_LIQ100)
    {

        header('Content-Type: text/html; charset=utf-8');
        $this->DB()->SetFetchMode(ADODB_FETCH_ASSOC);

        $estadoFormula100 = ($estadosFormula & ESTADO_LIQ100) ? 100 : 0;
        $estadoFormula200 = ($estadosFormula & ESTADO_LIQ200) ? 200 : 0;

        $query =

            " SELECT (@ROW := @ROW + 1) AS ROW,".
            "        InstitucionConvenioId,".
            "        NombreInstitucion,".
            "        ConvenioId,".
            "        IdContraprestacion,".
            "        FormulaLiquidacionId,".
            "        formula,".
            "        estadoLiquidacion,".
            "        FechaInicioVigencia,".
            "        FechaFinVigencia,".
            "        FechaCreacion".
            " FROM (SELECT @ROW := 0) r,".
            "      (SELECT DISTINCTROW ic.InstitucionConvenioId,".
            "                          ic.NombreInstitucion,".
            "                          c.ConvenioId,".
            "                          cc.IdContraprestacion,".
            "                          f.FormulaLiquidacionId,".
            "                          f.formula,".
            "                          f.codigoestado AS estadoLiquidacion,".
            "                          f.FechaInicioVigencia,".
            "                          f.FechaFinVigencia,".
            "                          f.FechaCreacion".
            "       FROM conveniocarrera cc".
            "                INNER JOIN Convenios c ON c.ConvenioId = cc.ConvenioId".
            "                INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId".
            "                LEFT JOIN FormulaLiquidaciones f".
            "                          ON (f.ConvenioId = c.ConvenioId AND f.codigocarrera = cc.Codigocarrera AND".
            "                              f.codigoestado IN (?, ?))".
            "       WHERE cc.codigocarrera = ?".
            "     AND cc.codigoestado = '100') d";


        $rows = $this->DB()->GetAssoc($query, array($estadoFormula100, $estadoFormula200, $idCarrera));

        return (is_array($rows)) ? $rows : array();

    }

}

// Constante para cargar formulas con estado 100
if(! defined('ESTADO_LIQ100')) define('ESTADO_LIQ100', 1100100); // 100 funcion decbin(100) arroja el numero

// Constante para cargar formulas con estado 200
if(! defined('ESTADO_LIQ200')) define('ESTADO_LIQ200', 11001000); // 200 funcion decbin(200) arroja el numero