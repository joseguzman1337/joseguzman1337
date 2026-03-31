<?php

namespace App\FormRequest\convenios;


class FormRequestValidarRangoFechasFormulaLiq extends FormRequestCrearFormulaLiq
{

    protected function cargarReglas()
    {

        $reglas = parent::cargarReglas();


        foreach ($reglas as $regla => $lambda) {

            if ($regla != 'vigencia.formato')
            {
                # Eliminar reglas no necesarias
                unset($reglas[$regla]);
            }

        }

        return $reglas;
    }

}