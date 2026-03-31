<?php

/**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se crea esta clase (MostrarEncuestaInstrumento) para que muestre tambien las respuestas cuando se parametrice el instrumento. 
 * @since Abril 9, 2019
 */
class MostrarEncuestaInstrumento {

    var $tipousuario;
    var $objetobase;
    var $formulario;
    var $consultaencuesta;
    var $arrayencuesta;
    var $arraydatosrespuesta;
    var $arraytitulospestanas;
    var $idusuario;
    var $datosencuesta;
    var $conpreguntatabla;

    function MostrarEncuestaInstrumento($idusuarioencuesta, $objetobase, $formulario, $consultaencuestainstrumento) {

        $this->idusuario = $idusuarioencuesta;
        $this->codigotipousuario = $tipousuario;
        $this->objetobase = $objetobase;
        $this->formulario = $formulario;
        $this->objconsultaencuestainstrumento = $consultaencuestainstrumento;
    }

    function setIdInstrumento($idinstrumento) {
        $this->idinstrumento = $idinstrumento;
        $this->datosencuesta = $this->objetobase->recuperar_datos_tabla("siq_Ainstrumentoconfiguracion", "idsiq_Ainstrumentoconfiguracion", $_REQUEST['idinstrumento'], "", "", 0);
        $this->objconsultaencuestainstrumento->setIdInstrumento($idinstrumento);
    }

    function setTitulosEncuesta($arraytitulos) {
        $this->arraytitulos = $arraytitulos;
    }

    function mostrarTitulosEncuesta() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo("<b><BR>" . $this->datosencuesta["nombre"] . "<BR><BR></b>", 'tdtituloencuesta', "2", "align='center'", "td");
        $this->formulario->dibujar_fila_titulo("<b><br><br>" . $this->datosencuesta["mostrar_bienvenida"] . "<br><br><br><br></b>", "tdtituloencuestadescripcion", "2", "align='left'", "td");
        echo "</table>";
        if (is_array($this->arraytitulos))
            foreach ($this->arraytitulos as $i => $valortitulo) {
                echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
                if (isset($valortitulo["estilo"]) && trim($valortitulo["estilo"]) != '') {
                    $estilo = $valortitulo["estilo"];
                } else {
                    $estilo = 'tdtituloencuestadescripcion';
                }

                $this->formulario->dibujar_fila_titulo($valortitulo["descripcion"], $estilo, "2", "align='left'", "td");
                echo "</table>";
            }
    }

    function iniciarEncuestaUsuario() {
        $this->objconsultaencuestainstrumento->consultaprimernivelpreguntas();
        $this->arrayencuesta = $this->objconsultaencuestainstrumento->recuperarencuesta();
        $this->arraydatosrespuesta = $this->objconsultaencuestainstrumento->recuperarrespuestapreguntausuario($this->idusuario);
        $this->arraytitulospestanas = $this->objconsultaencuestainstrumento->recuperarpadrepreguntas();
    }

    function iniciarEncuestaTipoUsuario() {
        $this->arrayencuesta = $this->objconsultaencuestainstrumento->recuperarencuesta();
        $this->arraydatosrespuesta = $this->objconsultaencuestainstrumento->recuperarrespuestapreguntausuario($idusuario);
        $this->arraytitulospestanas = $this->objconsultaencuestainstrumento->recuperarpadrepreguntas();
    }

    function imprimirResultadosEncuesta($tituloinicial = "", $cadenaparametros, $tablasadicionales) {
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial, 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        echo "</table>";

        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla = 0;

        foreach ($this->objconsultaencuestainstrumento->arbolpreguntas as $idpregunta => $ramapregunta) {
            echo "<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

            unset($this->objconsultaencuestainstrumento->arrayNotas);

            $this->objconsultaencuestainstrumento->muestraresultadospreguntas($ramapregunta, $idpregunta, $this->idinstrumento, $cadenaparametros, $tablasadicionales);

            $numeronotas = count($this->objconsultaencuestainstrumento->arrayNotas);

            $sumanotas = 0;

            foreach ($this->objconsultaencuestainstrumento->arrayNotas as $inota => $notaparcial) {

                $sumanotas += $notaparcial;
                $sumanotastotal += $notaparcial;
            }
            $notaporpestana = round($sumanotas / $numeronotas, 2);
            $this->formulario->dibujar_fila_titulo("<b>Nota parcial</n> " . $notaporpestana, 'tdtituloencuestadescripcion', "2", "align='right'", "td");
            $this->botonesResultado();
            echo "</table>";
            echo "</div>";
        }

        echo "</div>";
        echo "<div style ='position:absolute;
	left:8px;
	top:550px;
	z-index:1;'>";
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

        $this->formulario->dibujar_fila_titulo("<b>Nota Total</n> " . $notaporpestana, 'tdtituloencuestadescripcion', "4", "align='left'", "td");
        echo "</table>";
        echo "</div>";
    }
    function botonesResultado() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $conboton=0;
        
        $parametrobotonenviar[$conboton]="'button','Seguir','Seguir','onclick=\'return cambiapestana(".($this->conpreguntatabla+1)."); \''";
        $boton[$conboton]='boton_tipo';
        
        $this->formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');

        $this->formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>','',"2","align='center'","td");
        $this->conpreguntatabla++;
        echo  "</table>";
    }
}

?>
