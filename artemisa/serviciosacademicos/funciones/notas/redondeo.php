<?php

function redondeo ($notafinal) {
    //$notafinal = number_format($notafinal,1);
    //$notafinal = round($notafinal * 10,1)/10;
    //$notafinal = round($notafinal*10,1)/10;
    $notafinal = round($notafinal,1);
    return $notafinal;
}

function redondeo2 ($notafinal) {
    //$notafinal = number_format($notafinal,2);
    $notafinal = round($notafinal,2);
    /*$notafinal = round($notafinal * 10)/10;
   $notafinal = number_format($notafinal,2);*/
    return $notafinal;
}

function redondeo3 ($notafinal) {
    //$notafinal = number_format($notafinal,2);
    $notafinal = round($notafinal,3);
    /*$notafinal = round($notafinal * 10)/10;
   $notafinal = number_format($notafinal,2);*/
    return $notafinal;
}

function PeriodoSemestralReglamento ($codigoestudiante,$periodosemestral,$cadenamateria,$tipocertificado,$sala, $redondeo=0) {
    $_GET['tipocertificado'] = $tipocertificado;
    require ('calculopromediosemestralmacheteado.php');
    return $promediosemestralperiodo;
}

function AcumuladoReglamento ($codigoestudiante,$tipocertificado,$sala, $periodo = 0, $redondeo=1) {
    $_GET['periodo'] = $periodo;
    $_GET['tipocertificado'] = $tipocertificado;
    require ('calculopromedioacumulado.php');
    return $promedioacumulado;
}

function AcumuladoReglamentoPeriodos ($codigoestudiante,$tipocertificado,$periodo,$sala) {
    //$periodos = implode(",",$periodo);
    $sumacreditos = 0;
    $sumanotas = 0;
    foreach($periodo as $codigoperiodo => $materia) {
        foreach($materia as $codigomateria => $nota) {
            foreach($nota as $creditos => $not) {
                $sumacreditos = $sumacreditos+$creditos;
                //echo "$sumacreditos $creditos => $not <br>";
                $sumanotas += $not * $creditos;
            }
            //echo "$sumacreditos <br>";
        }
        //echo "$sumacreditos <br>";
    }
    //echo "1$sumacreditos <br>";
    //echo "$sumacreditos<br>";
    $promedioacumulado = $sumanotas/$sumacreditos;
    //echo "$promedioacumulado = $notatotal / $creditos";
    $promedioacumulado = redondeo ($promedioacumulado);
    return $promedioacumulado;
    /*$_GET['tipocertificado'] = $tipocertificado;
    print_r($periodo);
   //require ('calculopromedioacumuladoperiodos.php');
   return $promedioacumulado;*/
}

function PeriodoSemestralTodo($codigoestudiante,$periodosemestral,$tipocertificado,$sala, $redondeo=0) {
    $_GET['tipocertificado'] = $tipocertificado;
    require('calculopromediosemestral.php');
    return $promediosemestralperiodo;
}
?>