<?php

namespace App\origenDatos\entidadDAO;

use App\origenDatos\entidadVO\FormulaLiquidacionVO;

class FormulaLiquidacionDAO extends A_EntidadDAO
{

    public function __construct(FormulaLiquidacionVO $formula)
    {

        $this->entidadVO = $formula;
        $this->setDb();

    }


    public function save()
    {

    }


    public function logAuditoria($e, $query)
    {

    }

    /**
     * @param $idPrograma
     */
    public function busquedaFormulasPorEntidadSalud($idPrograma)
    {

        $coleccion = array();

        $this->setDb();

        $result =
            $this->db->execute(
                " SELECT (@ROW := @ROW + 1) AS ROW,".
                "        InstitucionConvenioId,".
                "        NombreInstitucion,".
                "        ConvenioId,".
                "        IdContraprestacion,".
                "        FormulaLiquidacionId,".
                "        formula,".
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
                "                          f.FechaInicioVigencia,".
                "                          f.FechaFinVigencia,".
                "                          f.FechaCreacion".
                "       FROM conveniocarrera cc".
                "                INNER JOIN Convenios c ON c.ConvenioId = cc.ConvenioId".
                "                INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId".
                "                LEFT JOIN FormulaLiquidaciones f".
                "                          ON (f.ConvenioId = c.ConvenioId AND f.codigocarrera = cc.Codigocarrera AND".
                "                              f.codigoestado = '100')".
                "       WHERE cc.codigocarrera = ".$this->db->qstr($idPrograma)."".
                "     AND cc.codigoestado = '100') d"
            );



        while (!$result->EOF) {

            for ($i=0, $max=$result->fieldCount(); $i < $max; $i++) {
                var_dump($result->fields);
                //print $result->fields[$i].' ';
            }

            $result->moveNext();
            print "<br>\n";
        }



    }
    
}