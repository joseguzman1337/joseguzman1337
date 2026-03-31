<?php
/*
 * Se reorganiza el codigo, se eliminan sentencias else innecesarias y se remplaza
 * el tipo de la variable "$siga" por boolean para mas facil manejo de validaciones
 * Andres Ariza <andresariza@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 18 de septiembre de 2018.
 */
function IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase, $campoNumeroDocumento = "t1.numerodocumento") {

    $arraynombre = explode(" ", trim($nombre));
    $arrayapellido = explode(" ", trim($apellido));

    $siga = false;
    if (count($arraynombre) > 0) {
        $condicion .= " AND (";
        for ($i = 0; $i < count($arraynombre); $i++) {
            if (strlen($arraynombre[$i]) >= 3) {
                $siga = true;
                if ($i == 0) {
                    $condicion .= " " . $tablanombre . " LIKE '%" . $arraynombre[$i] . "%'";
                } else {
                    $condicion .= " OR " . $tablanombre . " LIKE '%" . $arraynombre[$i] . "%'";
                }
            }
        }
        $condicion .= ")";
    }
    //ddd($campoNumeroDocumento);
    if ($datosnombresegresado = $objetobase->recuperar_datos_tabla($tabla, $campoNumeroDocumento, $numerodocumento, $condicion, '', 0)) {
        $siga = true;
    } else {
        $siga = false;
    }

    if (!$siga) {
        alerta_javascript("Nombre  no corresponde con el documento");
        exit();
    }

    $siga = false;
    if (count($arrayapellido) > 0) {
        $condicion .= " AND (";
        for ($i = 0; $i < count($arrayapellido); $i++) {
            if (strlen($arrayapellido[$i]) >= 3) {
                $siga = true;
                if ($i == 0){
                    $condicion .= " " . $tablaapellido . " LIKE '%" . $arrayapellido[$i] . "%'";
                }else{
                    $condicion .= " OR " . $tablaapellido . " LIKE '%" . $arrayapellido[$i] . "%'";
                }
            }
        }
        $condicion .= ")";
    }
    
    if (!$siga) {
        alerta_javascript("Apellido  no corresponde con el documento");
        exit();
    }
    
    if ($datosnombresegresado = $objetobase->recuperar_datos_tabla($tabla, $campoNumeroDocumento, $numerodocumento, $condicion, '', 0)) {
        $siga = true;
    } else {
        $siga = false;
    }

    if (!$siga) {
        alerta_javascript("Apellido no corresponde con el documento");
        exit();
    }
}

?>