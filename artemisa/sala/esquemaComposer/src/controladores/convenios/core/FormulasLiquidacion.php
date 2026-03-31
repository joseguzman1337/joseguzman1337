<?php

namespace App\controladores\convenios\core;

use App\entidades\CamposFormulas;
use App\entidades\Carrera;
use App\entidades\FormulaLiquidacion;

class FormulasLiquidacion
{

    public static $operadores = array(
        4 => '+',
        3 => '-',
        1 => '*',
        2 => '/',
    );

    /**
     * @param $idPrograma
     * @return array
     * @throws \Exception
     */
    public function getFormulasPorCarrera($idCarrera)
    {

        try{

            $formulas = array();
            $objFormulas = new FormulaLiquidacion();
            $registros = $objFormulas->formulasPorPrograma($idCarrera, ESTADO_LIQ100 | ESTADO_LIQ200);

            # Campos de la formula
            $entidadCamposFormulas = new CamposFormulas();
            $camposForm = $entidadCamposFormulas->getCamposFormArreglo();
            $formulas['camposFormula'] = $camposForm;
            $formulas['camposFormulaDigitar'] = $entidadCamposFormulas->camposDigitados;



            # Nombre de la carrera
            $entidadCarrera = new Carrera();
            $nombreCarrera = $entidadCarrera->find('codigocarrera=' . $idCarrera);
            $formulas['nombreCarrera'] = '';

            if ($nombreCarrera !== false)
            {
                $dataCarrera = current($nombreCarrera);
                $formulas['nombreCarrera'] = $dataCarrera->nombrecarrera;
            }

            if (is_array($registros))
            {
                foreach ($registros as $reg => &$campos)
                {

                    if (! empty($campos['formula']) || true)
                        $campos['formulaVista'] = static::getFormula($campos['formula'], $camposForm);
                    else
                        $campos['formulaVista'] = '';
                }

                $formulas['formulas'] = $registros;
            }

            return $formulas;

        }catch (\Exception $e){

            throw  $e;
        }

    }

    /**
     * Genera visualización de la formula de liquidación con base a un esquema proporcionado
     *
     * @param string $esquemaFormula
     * @param array $camposForm
     * @return string
     * @throws \Exception
     */
    public static function getFormula($esquemaFormula = '', array $camposForm = array())
    {

        $formulatotal = '';

        try{

            $segmentosFormula = explode(',', $esquemaFormula);
            $operadores = static::$operadores;

            foreach ($segmentosFormula as $pos => $segmento) {

                # Si es par la posición en la que se encuentra el segmento es valor de operación
                if ($pos % 2 == 0)
                {
                    $segmentoCompuesto = explode('-', $segmento);

                    if (count($segmentoCompuesto) > 1)
                    {
                        $formulatotal .= $camposForm[$segmentoCompuesto[0]] . ' (' . $segmentoCompuesto[1] . ') ';
                    }
                    elseif(array_key_exists($segmento, $camposForm))
                        $formulatotal .= $camposForm[$segmento];

                }
                # Si es impar la posición en la que se encuentra el segmento es operador (suma / restas / división / ...)
                else {

                    if (! array_key_exists($segmento, $operadores))
                        throw new \Exception('Error el signo usado, no se encuentra definido', 522);

                    $formulatotal .= ' ' . $operadores[$segmento] . ' ';

                }


            }

        }catch(\Exception $e){

            $formulatotal = 'Error esquema de formula (' . $esquemaFormula . ') no cumple con estandar!';
            $formulatotal .= '<small>'.$e->getMessage().'</small>';

        }

        return $formulatotal;

    }

    /**
     * @param string|array $formula
     * @throws \Exception
     * @return \stdClass
     */
    public static function verificarEsquemaFormula($formula)
    {


        $objetoRetorno = new \stdClass();
        $objetoRetorno->valida = false;
        $objetoRetorno->formulaOrigen = $formula;
        $objetoRetorno->formulaEjecucion = '';
        $objetoRetorno->errMsg = null;

        $contador = 0;
        $operadores = static::$operadores;
        $objetoRetorno->formulaEjecucion = '';

        if (! is_array($formula) && ! is_string($formula))
            throw new \Exception('Formato de formula no compatible', 522);


        if (is_string($formula))
            $formula = explode(',', $formula);


        foreach ($formula as $key => $elemento)
        {

            // Ejecución sobre campos
            if ($contador % 2 == 0)
            {

                $fragmentosCampo = explode('-', $elemento);

                // Valida si es un campo digitado
                if (count($fragmentosCampo) > 1){
                    $objetoRetorno->formulaEjecucion .= ' ' . (int) $fragmentosCampo[1];
                }
                // Si no lo es asigna un valor randomico
                else
                    $objetoRetorno->formulaEjecucion .= ' ' . rand(1, 1000000);

            }
            // Ejecución sobre operadores
            else{

                $objetoRetorno->formulaEjecucion .= ' ' . $operadores[$elemento];

            }


            $contador++;
        }


        try{

            eval($objetoRetorno->formulaEjecucion .';');
            $objetoRetorno->valida = true;

        }
        catch (\Exception $e)
        {
            $objetoRetorno->errMsg = $e->getMessage();
        }


        return $objetoRetorno;

    }

    /**
     * Creación de formula
     *
     * @param $idConvenio
     * @param $idcarrera
     * @param array $rangoFechas
     * @param $esquemaFormula
     * @return bool|int
     * @throws \Exception
     */
    public function crearFormula($idConvenio, $idcarrera, array $rangoFechas, $esquemaFormula)
    {

        @session_start();

        $respuesta = false;

        try{

            conexionDB()->StartTrans();

            if(configuracionS1()->getEntorno() != 'sala')
                conexionDB()->debug=true;

            $objFormulas = new FormulaLiquidacion();
            $objFormulas->convenioid = $idConvenio;
            $objFormulas->codigocarrera = $idcarrera;
            $objFormulas->formula = $esquemaFormula;
            $objFormulas->codigoestado = 100;
            $objFormulas->fechacreacion = date('Y-m-d H:i:s');
            $objFormulas->fechainiciovigencia = current($rangoFechas);
            $objFormulas->fechafinvigencia = end($rangoFechas);
            $objFormulas->usuariocreacion = $_SESSION['idusuario'];

            $respuesta = $objFormulas->save();
            conexionDB()->completeTrans();

        }catch (\Exception $e)
        {

            conexionDB()->failTrans();
            throw $e;

        }


        return $respuesta;
    }

    /**
     * Actualizar estado de formula
     *
     * @param $idFormula
     * @param $estado
     * @return bool|int
     * @throws \Exception
     */
    public function actualizarEstadoFormula($idFormula, $estado)
    {

        @session_start();

        $respuesta = false;

        try{

            conexionDB()->StartTrans();

            $objFormulas = new FormulaLiquidacion();
            $objFormulas->load('FormulaLiquidacionId = ' . $idFormula);

            $objFormulas->codigoestado = $estado;
            $objFormulas->usuariomodificacion = $_SESSION['idusuario'];
            $objFormulas->fechamodificacion = date('Y-m-d H:i:s');
            $respuesta = $objFormulas->save();
            conexionDB()->completeTrans();

        }catch (\Exception $e)
        {

            conexionDB()->failTrans();
            throw $e;

        }


        return $respuesta;
    }

    /**
     * Actualizar formula
     *
     * @param $idFormula
     * @param $esquemaFormula
     * @return bool|int
     * @throws \Exception
     */
    public function editarFormula($idFormula, $esquemaFormula)
    {

        @session_start();

        $respuesta = false;

        try{

            conexionDB()->StartTrans();

            $objFormulas = new FormulaLiquidacion();
            $objFormulas->load('FormulaLiquidacionId = ' . $idFormula);

            $objFormulas->formula = $esquemaFormula;
            $objFormulas->usuariomodificacion = $_SESSION['idusuario'];
            $objFormulas->fechamodificacion = date('Y-m-d H:i:s');
            $respuesta = $objFormulas->save();
            conexionDB()->completeTrans();

        }catch (\Exception $e)
        {

            conexionDB()->failTrans();
            throw $e;

        }


        return $respuesta;
    }

    /**
     * Validar que rango de fecha asignado a nueva formula no se encuentre en el sistema
     *
     * @param $idConvenio
     * @param $idCarrera
     * @param $vigencia
     * @return bool
     * @throws \Exception
     */
    public function validarRangoFechas($idConvenio, $idCarrera, $vigencia, $idFormula = null)
    {

        $respuesta = false;

        try{

            $_clausula = 'CodigoCarrera = ? AND ConvenioId = ? AND FechaInicioVigencia = ? AND FechaFinVigencia = ?';

            $_bindings = array($idCarrera, $idConvenio, current($vigencia), end($vigencia));

            if (! empty($idFormula))
            {
                $_clausula .= ' AND FormulaLiquidacionId != ?';
                $_bindings[] = $idFormula;
            }

            $objFormulas = new FormulaLiquidacion();
            $objFormulas->load($_clausula, $_bindings);
            $respuesta = (bool) $objFormulas->_saved;

        }catch (\Exception $e)
        {
            throw $e;
        }

        return $respuesta;
    }

}