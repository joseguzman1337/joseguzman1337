<?php

namespace App\FormRequest\convenios;

use App\FormRequest\AFormRequestDef;

class FormRequestCrearFormulaLiq extends AFormRequestDef
{


    protected function __autorizado()
    {
        return true;
    }

    protected function cargarReglas()
    {

        $reglas = array(

            'esquemaFormula.requerido' => function($val){
                return ! empty($val);
            },
            'vigencia.formato' => function($val){

                if (! is_array($val))
                    return false;

                $fechaInicio = current($val);
                $fechafin = end($val);

                return
                    ( date('Y-m-d', strtotime($fechaInicio)) == $fechaInicio ) &&
                    ( date('Y-m-d', strtotime($fechafin)) == $fechafin );

            }

        );


        return $reglas;
    }

    protected function cargarMensajeRegla()
    {

        $mensajes = array(

            'esquemaFormula.requerido' => 'Campo Requerido',
            'vigencia.formato' => 'Formato de fecha invalido'

        );


        return $mensajes;

    }

    /**
     * Devolución de campos que llegan en petición
     *
     * @return array
     */
    public function toArray()
    {
        return $_REQUEST;
    }

}