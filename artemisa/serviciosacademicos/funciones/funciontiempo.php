<?php

/**
 * @Modifed Ivan quintero <quinteroivan@unbosque.edu.co>
 * @Since  Mayo 14 del 2019
 * Definicion de variable fecha dia hoy, se oculta las lienas de dif 
 */
function restarfecha($fechamayor, $fechamenor) {
    $s = strtotime($fechamayor) - strtotime($fechamenor);
    $d = intval($s / 86400);
    $s -= $d * 86400;
    $h = intval($s / 3600);
    $s -= $h * 3600;
    $m = intval($s / 60);
    $s -= $m * 60;

    //Diferencia en horas:
    //$dif = (($d * 24) + $h) . hrs . " " . $m . "min";
    //Diferencia en dias:
    //$dif2 = $d . space . dias . " " . $h . hrs . " " . $m . "min";

    return $d;
}//restarfecha

// Muestra el día que es hoy
// 0 es Domingo 6 es sabado
function findesemana($fecha, $dia) {
    if (date("w", strtotime($fecha)) == 0 || date("w", strtotime($fecha)) == 6) {
        //return "0 = domingo"; return "6 = sabado";
        $dia = date("w", strtotime($fecha));
        return true;
    }
}//findesemana

function festivo($fecha, $sala) {
    $query_diafestivo = "select diafestivo from festivo where diafestivo = '$fecha'";    
    $diafestivo = mysql_query($query_diafestivo, $sala) or die("$query_horarioselegidos" . mysql_error());
    $totalRows_diafestivo = mysql_num_rows($diafestivo);
    $row_diafestivo = mysql_fetch_array($diafestivo);
    // Si la fecha es un festivo debo mirar otra
    if ($totalRows_diafestivo != "") {
        return true;
    } else if (date("w", strtotime($fecha)) == 0 || date("w", strtotime($fecha)) == 6) {
        return true;
    }
}

// Recibe el número de días que se quieren calcular a partir de la fecha de hoy
function calcularfechafutura($diamax, $sala) {
    //Fecha mayor y fecha menor
    // Selecciono el mayor día habil    
    $fechahoy = date("Y-m-d");    
    $unDiaMas = strtotime("+1 day", strtotime($fechahoy));    
    $fechahabil = date("Y-m-d");
    while ($diamax >= 1) {
        $unDiaMas = strtotime("+1 day", strtotime($fechahabil));
        $fechahabil = date("Y-m-d", $unDiaMas);
        if (!festivo($fechahabil, $sala)) {
            $diamax--;
        }
    }    
    return $fechahabil;
}//calcularfechafutura