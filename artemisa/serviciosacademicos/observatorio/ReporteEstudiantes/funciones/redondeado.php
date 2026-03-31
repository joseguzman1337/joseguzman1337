<?php
    /*
     * Reporte de resultados evaluacion docente - funcion de promedio acumulado (pregrado)
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Creado 10 de Octubre de 2017.
     */
function AcumuladoReglamento1 ($codigoestudiante,$tipocertificado,$sala, $periodo = 0, $redondeo=1) {
    $_GET['periodo'] = $periodo;
    $_GET['tipocertificado'] = $tipocertificado;
    require ('calculopromedioacumulado.php');
    return $promedioacumulado;
}
//end
?>