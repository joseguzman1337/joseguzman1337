<?php

namespace Sala\lib\AdministracionPeriodos\api\clases\utiles;

defined('_EXEC') or die;

abstract class ValidacionesComunes {

    public static function validarFechasIngresadas($return, $variables) {
        if (empty($variables->fechaInicio)) {
            $return["s"] = false;
            $return["msj"] = "Debe seleccionar la fecha de inicio del período financiero";
            return $return;
        }

        if (empty($variables->fechaFin)) {
            $return["s"] = false;
            $return["msj"] = "Debe seleccionar la fecha de fin del período financiero";
            return $return;
        }
        //checkdate ( int $month , int $day , int $year ) YYYY-MM-DD
        $fechaInicio = explode("-", $variables->fechaInicio);
        if (!checkdate((int) $fechaInicio[1], (int) $fechaInicio[2], (int) $fechaInicio[0])) {
            $return["s"] = false;
            $return["msj"] = "La fecha de inicio no tiene formato valido (AAAA-MM-DD)";
            return $return;
        }

        $fechaFin = explode("-", $variables->fechaFin);
        if (!checkdate((int) $fechaFin[1], (int) $fechaFin[2], (int) $fechaFin[0])) {
            $return["s"] = false;
            $return["msj"] = "La fecha de fin no tiene formato valido (AAAA-MM-DD)";
            return $return;
        }
        //checkdate ( int $month , int $day , int $year );
        if (strtotime($variables->fechaInicio) > strtotime($variables->fechaFin)) {
            $return["s"] = false;
            $return["msj"] = "La fecha fin debe ser mayor que la fecha de inicio";
            return $return;
        }
        return $return;
    }


}
