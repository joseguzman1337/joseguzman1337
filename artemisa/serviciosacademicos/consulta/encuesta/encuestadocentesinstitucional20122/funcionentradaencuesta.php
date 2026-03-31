<?php

function validaEntradaEncuesta($nombre, $apellido, $camponombre, $campopellido, $tabla, $nombreid, $campoid,$objetobase, $condicionadicional="") {

    $arraynombre = explode(" ", trim($nombre));
    $arrayapellido = explode(" ", trim($apellido));


    $siga = 0;
    if (count($arraynombre) > 0) {
        $condicion.=" and (";
        for ($i = 0; $i < count($arraynombre); $i++) {
            if (strlen($arraynombre[$i]) >= 3) {
                $siga = 1;
                if ($i == 0)
                    $condicion.="" . $camponombre . " like '%" . $arraynombre[$i] . "%'";
                else
                    $condicion.=" or " . $camponombre . " like '%" . $arraynombre[$i] . "%'";
            }else {
                $siga = 0;
            }
        }
        $condicion.=")";
    } else {
        $siga = 0;
    }

    if (!$siga) {
        alerta_javascript("Nombre  no corresponde con el documento");
        exit();
    }
    $condicion .=$condicionadicional;

    if ($datosnombresegresado = $objetobase->recuperar_datos_tabla($tabla, $nombreid, $campoid, $condicion, '', 0))
        $siga = 1;
    else {
        $siga = 0;
    }

    if (!$siga) {
        alerta_javascript("Nombre no corresponde con el documento");
        exit();
    }

    $condicion = "";
    if (count($arrayapellido) > 0) {
        $siga = 1;
        $condicion = " and (";
        for ($i = 0; $i < count($arrayapellido); $i++) {
            if (strlen($arrayapellido[$i]) >= 3) {
                if ($i == 0)
                    $condicion.="" . $campopellido . " like '%" . $arrayapellido[$i] . "%'";
                else
                    $condicion.=" or " . $campopellido . " like '%" . $arrayapellido[$i] . "%'";
            }
            else {
                $siga = 0;
            }
        }
        $condicion.=")";
    } else {
        $siga = 0;
    }

    if (!$siga) {
        alerta_javascript("Apellido no corresponde con el documento");
        exit();
    }
    // $condicion .="  and carrera1 <> 'ADMINISTRACION'";
    $condicion .=$condicionadicional;
    if ($datosapellidosegresado = $objetobase->recuperar_datos_tabla($tabla, $nombreid, $campoid, $condicion, '', 0))
        $siga = 1;
    else {
        alerta_javascript("Apellido no corresponde con el documento ");
        $siga = 0;
        exit();
    }
    return $siga;
}
?>
