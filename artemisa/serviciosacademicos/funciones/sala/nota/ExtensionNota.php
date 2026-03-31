<?php
class ExtensionNota extends detallenota {
    // Variables
    function ExtensionNota($codigoestudiante, $codigoperiodo, $condatos = true) {
        $this->detallenota($codigoestudiante, $codigoperiodo, $condatos = true);
    }
    function calcularPonderadoSemestral($notas,$creditos,$porcentajes) {
        $i=0;

        if(is_array($notas)) {
            foreach($notas as $codigomateria=>$nota) {
                if($porcentajes[$codigomateria]>0){
                    $notareal=$nota*100/$porcentajes[$codigomateria];
                }
                $promedio+=$notareal*$creditos[$codigomateria];
                $sumacredito+=$creditos[$codigomateria];
                $i++;
            }
            $ponderado=$promedio/$sumacredito;
        }else {
            $ponderado=0;

        }
        return number_format(($ponderado),2);
    }
    function calcularNotaReal($notas,$creditos,$porcentajes,$codigomateria) {
        $i=0;
        if(is_array($notas)) {
            foreach($notas as $codigomaterianota=>$nota) {
                if($codigomateria==$codigomaterianota) {
                    $notareal=$nota*100/$porcentajes[$codigomateria];
                }
            }

        }else {
            $notareal=0;

        }
        return number_format(($notareal),2);
    }
    function calcularPonderadoParcialSemestral($notas,$creditos,$porcentajes) {
        $i=0;
        if(is_array($notas)) {
            foreach($notas as $codigomateria=>$nota) {
                //$notareal=$nota*100/$porcentajes[$codigomateria];
                $promedio+=$nota*$creditos[$codigomateria];
                $sumacredito+=$creditos[$codigomateria];
                $i++;
            }
            $ponderado=$promedio/$sumacredito;
        }else {
            $ponderado=0;

        }
        return number_format(($ponderado),2);
    }
    function acumuladoFallasCorte($numerocorte,$codigomateria){
        for($i=1;$i<=$numerocorte;$i++){
        $acumuladoFallas["teorica"]+=$this->fallasteoricacorte[$codigomateria][$i];
        $acumuladoFallas["practica"]+=$this->fallaspracticacorte[$codigomateria][$i];
        }
        return $acumuladoFallas;
    }

}
?>
