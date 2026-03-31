<?php

/**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se crea esta clase (ConsultaEncuestaInstrumento) para que muestre tambien las respuestas cuando se parametrice el instrumento. 
 * @since Abril 9, 2019
 */
class ConsultaEncuestaInstrumento {

    var $codigotipousuario;
    var $objetobase;
    var $arbolpreguntas;
    var $titulospreguntas;
    var $tipopregunta;
    var $tmpencuesta;
    var $encuesta;
    var $tmppadrepregunta;
    var $respuestausuariopregunta;
    var $idusuario;
    var $preguntasencuesta;
    var $noterminado;
    var $contadorpreguntas = 0;
    var $idinstrumento;
    var $tablaRespuesta;
    var $mensajeYaMostrado;
    var $funcionrespuestapregunta;
    var $funcionobservacionrespuestas;

    function ConsultaEncuestaInstrumento($objetobase, $formulario) {

        $this->objetobase = $objetobase;
        $this->formulario = $formulario;
        $this->mensajeYaMostrado = 0;
        $this->funcionrespuestapregunta = "cantidadRespuestasPregunta";
        $this->funcionobservacionrespuestas = "observacionRespuestasPregunta";
    }

    function setTipoUsuario($tipousuario) {
        $this->codigotipousuario = $tipousuario;
    }

    function setIdInstrumento($idinstrumento) {
        $this->idinstrumento = $idinstrumento;
    }

    function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function setTablaRespuesta($tablaRespuesta) {
        $this->tablaRespuesta = $tablaRespuesta;
    }

    function setFuncionRespuestaPregunta($funcionrespuestapregunta) {
        $this->funcionrespuestapregunta = $funcionrespuestapregunta;
    }

    function setFuncionObservacionRespuestas($funcionobservacionrespuestas) {
        $this->funcionobservacionrespuestas = $funcionobservacionrespuestas;
    }

    function consultaprimernivelpreguntas() {

        $tabla = "siq_Ainstrumento i, siq_Aseccion s, siq_Apregunta p";
        $nombreidtabla = "i.idsiq_Ainstrumentoconfiguracion";
        $idtabla = $_REQUEST['idinstrumento'];
        $condicion = " AND s.idsiq_Aseccion=i.idsiq_Aseccion
        AND p.idsiq_Apregunta=i.idsiq_Apregunta
        AND i.codigoestado=100 
        GROUP BY i.idsiq_Aseccion
        ORDER BY i.idsiq_Aseccion, i.orden ";

        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, ",i.idsiq_Apregunta codigopregunta", 0);
        while ($row = $resultado->fetchRow()) {


            $tabla = "siq_Ainstrumento i";
            $nombreidtabla = " i.idsiq_Aseccion";
            $idtabla = $row["idsiq_Aseccion"];
            $condicion = " and i.codigoestado like '1%' and i.idsiq_Ainstrumentoconfiguracion=" . $_REQUEST['idinstrumento'] . " ";
            $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
            $conencuesta = 0;

            while ($rowencuesta = $resultadoencuesta->fetchRow()) {
                $tmparrayencuestainstrumento[] = $rowencuesta["idsiq_Ainstrumentoconfiguracion"];
            }

            $tmprow[$row["codigopregunta"]]["nombre"] = $row["nombre"];
            $tmprow[$row["codigopregunta"]]["tipopregunta"] = $row["idsiq_Atipopregunta"];
            $tmprow[$row["codigopregunta"]]["numeroopciones"] = '0';
            $tmprow[$row["codigopregunta"]]["menornombreopcion"] = '';

            $tmprow[$row["codigopregunta"]]["mayornombreopcion"] = '';
            $tmprow[$row["codigopregunta"]]["idpreguntagrupo"] = '0';
            $tmprow[$row["codigopregunta"]]["encuesta"] = $tmparrayencuestainstrumento;


            $this->arbolpreguntas[$row["codigopregunta"]]["nombre"] = $row["nombre"];
            $this->arbolpreguntas[$row["codigopregunta"]]["tipopregunta"] = $row["idsiq_Atipopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["descripcionpregunta"] = $row["descripcion"];
            $this->arbolpreguntas[$row["codigopregunta"]]["numeroopciones"] = '0';
            $this->arbolpreguntas[$row["codigopregunta"]]["menornombreopcion"] = '';

            $this->arbolpreguntas[$row["codigopregunta"]]["mayornombreopcion"] = '';
            $this->arbolpreguntas[$row["codigopregunta"]]["idpreguntagrupo"] = '0';
            $this->arbolpreguntas[$row["codigopregunta"]]["encuesta"] = $row["idsiq_Ainstrumentoconfiguracion"];

            $this->arbolpreguntas[$row["codigopregunta"]]["grupo"] = $this->recursivaarmaarbolarray($row["idsiq_Aseccion"]);

            unset($tmpencuestas);
            if (is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))
                foreach ($this->arbolpreguntas[$row["codigopregunta"]]["grupo"] as $idpreguntahijo => $arrayhijos) {
                    if (is_array($arrayhijos["encuesta"]))
                        foreach ($arrayhijos["encuesta"] as $tmpi => $idencuesta)
                            $tmpencuestas[$idencuesta] = "1";
                }
            $jtmp = 0;
            if (is_array($tmpencuestas))
                foreach ($tmpencuestas as $idencuestatmp => $valor) {
                    $this->arbolpreguntas[$row["codigopregunta"]]["encuesta"][$jtmp] = $idencuestatmp;
                    $this->encuesta[$idencuestatmp][$row["codigopregunta"]] = "1";
                    $jtmp++;
                }
        }
        $this->titulospreguntas = $tmprow;
    }

    function recursivaarmaarbolarray($idpregunta) {

        $tabla = "siq_Ainstrumento i, siq_Aseccion s, siq_Apregunta p";
        $nombreidtabla = "i.idsiq_Ainstrumentoconfiguracion";
        $idtabla = $_REQUEST['idinstrumento'];
        $condicion = " AND s.idsiq_Aseccion=i.idsiq_Aseccion
        AND p.idsiq_Apregunta=i.idsiq_Apregunta
        AND i.idsiq_Aseccion='" . $idpregunta . "' 
        AND i.codigoestado=100 
        ORDER BY i.idsiq_Aseccion, i.orden ";

        $resultadopregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, ",i.idsiq_Apregunta codigopregunta", 0);

        while ($datospregunta = $resultadopregunta->fetchRow()) {

            $tabla = "siq_Ainstrumento i";
            $nombreidtabla = " i.idsiq_Aseccion";
            $idtabla = $datospregunta["idsiq_Aseccion"];
            $condicion = " and i.codigoestado like '1%' and i.idsiq_Ainstrumentoconfiguracion=" . $_REQUEST['idinstrumento'] . " ";
            $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
            $conencuesta = 0;

            unset($tmparrayencuesta);
            while ($rowencuesta = $resultadoencuesta->fetchRow()) {
                $tmparrayencuesta[] = $rowencuesta["idsiq_Ainstrumentoconfiguracion"];
                $conencuesta++;
            }

            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["nombre"] = $datospregunta["titulo"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["tipopregunta"] = $datospregunta["idsiq_Atipopregunta"] . '33'; //se concatena un numero para diferenciar del ipopregunta de os encabezados
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["descripcionpregunta"] = $datospregunta["descripcion"];

            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["numeroopciones"] = '5';
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["menornombreopcion"] = '1';

            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["mayornombreopcion"] = '5';
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["idpreguntagrupo"] = $datospregunta["idsiq_Aseccion"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["encuesta"] = $tmparrayencuesta;
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"] = $this->recursivaarmaarbolarray($datospregunta["codigopregunta"]);

            if (!is_array($tmparrayencuesta)) {
                unset($tmpencuestas);
                if (is_array($ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"]))
                    foreach ($ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"] as $idpreguntahijo => $arrayhijos) {
                        if (is_array($arrayhijos["encuesta"]))
                            foreach ($arrayhijos["encuesta"] as $tmpi => $idencuesta)
                                $tmpencuestas[$idencuesta] = "1";
                    }
                $jtmp = 0;
                if (is_array($tmpencuestas))
                    foreach ($tmpencuestas as $idencuestatmp => $valor) {
                        $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["encuesta"][$jtmp] = $idencuestatmp;
                        $this->encuesta[$idencuestatmp][$datospregunta["codigopregunta"]] = "1";
                        $jtmp++;
                    }
            } else {
                foreach ($tmparrayencuesta as $tmpi => $idencuestatmp)
                    $this->encuesta[$idencuestatmp][$datospregunta["codigopregunta"]] = "1";
            }
        }
        return $ramaarbolpreguntas;
    }

    function recuperarpadrepreguntas() {

        return $this->titulospreguntas;
    }

    function recuperarencuestatipousuario() {
        $tabla = "encuestapregunta ep,encuesta e,pregunta p";
        $nombreidtabla = "e.codigotipousuario";
        $idtabla = $this->codigotipousuario;
        $condicion = " and e.idinstrumento= ep.idinstrumento
	and ep.idpregunta=p.idpregunta
	and ep.codigoestado like '1%'
	and e.codigoestado like '1%'
	and p.codigoestado like '1%'
	and now() between e.fechainicioencuesta and e.fechafinalencuesta dsds";
        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        unset($this->encuesta);

        while ($rowencuesta = $resultadoencuesta->fetchRow()) {


            $this->encuesta[$rowencuesta["idinstrumento"]][$rowencuesta["idpregunta"]] = "1";
            $this->encuesta[$rowencuesta["idinstrumento"]][$rowencuesta["idpreguntagrupo"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"], $rowencuesta["idinstrumento"]);
        }
        return $this->encuesta;
    }

    function recuperarencuesta() {
        $tabla = "siq_Ainstrumento i, siq_Aseccion s, siq_Apregunta p";
        $nombreidtabla = "i.idsiq_Ainstrumentoconfiguracion";
        $idtabla = $_REQUEST['idinstrumento'];
        $condicion = " AND s.idsiq_Aseccion=i.idsiq_Aseccion
        AND p.idsiq_Apregunta=i.idsiq_Apregunta
        AND i.codigoestado=100 
        GROUP BY i.idsiq_Aseccion
        ORDER BY i.idsiq_Aseccion, i.orden ";

        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        unset($this->encuesta);


        while ($rowencuesta = $resultadoencuesta->fetchRow()) {


            $this->encuesta[$rowencuesta["idsiq_Ainstrumentoconfiguracion"]][$rowencuesta["idsiq_Ainstrumentoconfiguracion"]] = "1";
            $this->encuesta[$rowencuesta["idsiq_Ainstrumentoconfiguracion"]][$rowencuesta["idsiq_Aseccion"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idsiq_Aseccion"], $rowencuesta["idsiq_Ainstrumentoconfiguracion"]);
        }
        return $this->encuesta;
    }

    function recursivorecuperarencuestapreguntas($idpregunta, $idinstrumento) {

        $tabla = "siq_Ainstrumento i";
        $nombreidtabla = " i.idsiq_Apregunta";
        $idtabla = $idpregunta;
        $condicion = " and codigoestado like '1%' ";
        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);

        while ($rowencuestas = $resultadoencuesta->fetchRow()) {
            $this->encuesta[$idinstrumento][$idpregunta] = "1";
            $this->encuesta[$idinstrumento][$rowencuesta["idsiq_Aseccion"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idsiq_Aseccion"], $idinstrumento);
        }
    }

    function recuperartipopregunta() {
        $tabla = "siq_Atipopregunta t";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = " and t.codigoestado like '1%'";
        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        $i = 0;
        while ($row = $resultado->fetchRow()) {
            $this->tipopregunta[$i]["nombretipopregunta"] = $row["nombre"];
            $this->tipopregunta[$i]["idtipopregunta"] = $row["idsiq_Atipopregunta"];
            $i++;
        }
    }

    function recuperarrespuestapreguntausuario($idusuario) {

        $this->idusuario = $idusuario;

        $tabla = " siq_Arespuestainstrumento sri 
        inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=sri.idsiq_Apregunta)
        LEFT JOIN siq_Apreguntarespuesta spr ON (sri.idsiq_Apreguntarespuesta = spr.idsiq_Apreguntarespuesta)";
        $nombreidtabla = "sri.idgrupo";
        $idtabla = $_REQUEST['idgrupo'];
        $condicion = "AND sri.idsiq_Ainstrumentoconfiguracion =" . $_REQUEST['idinstrumento'] . " AND sri.codigoestado = 100 ";

        $resultadorespuestapregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);

        $this->noterminado = 0;
        $i = 0;

        while ($row = $resultadorespuestapregunta->fetchRow()) {
            $arraydatosrespuesta["idencuesta"] = $row["idsiq_Ainstrumentoconfiguracion"];
            $arraydatosrespuesta[$row["titulo"]] = $row["valor"];

            if (trim($row["valor"]) == "")
                $this->noterminado = 1;
            $i++;
        }
        if ($i == 0)
            $this->noterminado = 1;

        $this->respuestausuariopregunta = $arraydatosrespuesta;

        return $arraydatosrespuesta;
    }

    function recuperaobjetoformulario() {
        return $this->formulario;
    }

    function muestraresultadospreguntas($ramapregunta, $idpregunta, $idinstrumento, $cadenaparametros, $tablasadicionales) {

        $valorpregunta = $this->respuestausuariopregunta[$idpregunta];

        unset($this->formulario->filatmp);
        if ($ramapregunta["tipopregunta"] == "101") {
            $this->formulario->dibujar_fila_titulo($ramapregunta["nombre"], 'tdtitulosubgrupoencuesta', "2", "align='left'", "td");
            if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
                $this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        }

        if ($ramapregunta["tipopregunta"] == "1") {
            $this->formulario->dibujar_fila_titulo($ramapregunta["nombre"], 'tdtituloencuesta', "2", "align='center'", "td");
            if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
                $this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        }
        if (ereg("^1.", $ramapregunta["tipopregunta"])) {
            $this->preguntasencuesta[] = $idpregunta;
            $sumacantidad = 0;
            $funcionRespuestaPregunta = $this->funcionrespuestapregunta;
            unset($respuestasPregunta);
            unset($this->formulario->filatmp);
            $respuestasPregunta = $this->$funcionRespuestaPregunta($idpregunta, $cadenaparametros, $tablasadicionales);
            $tmprespuestasPregunta = $respuestasPregunta;
            if (is_array($respuestasPregunta)) {
                foreach ($tmprespuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                    $sumacantidad += $arraycantidadpregunta["cuenta"];
                }

                for ($i = 1; $i <= $ramapregunta["numeroopciones"]; $i++) {
                    if ($this->resultadonumerico) {
                        $this->formulario->filatmp[$i] = "0";
                    } else {
                        $this->formulario->filatmp[$i] = "0%";
                    }
                }

                if ($this->noaplicapreguntas) {
                    if ($this->resultadonumerico) {
                        $this->formulario->filatmp["-1"] = "0";
                    } else {
                        $this->formulario->filatmp["-1"] = "0%";
                    }
                }

                foreach ($respuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                    if ($arraycantidadpregunta["valor"] % 2 == 0) {
                        $porcentaje = ceil(($arraycantidadpregunta["cuenta"] / $sumacantidad) * 100);
                        $ponderadoparcial += $arraycantidadpregunta["cuenta"] * $arraycantidadpregunta["valor"];
                    } else {
                        $porcentaje = floor(($arraycantidadpregunta["cuenta"] / $sumacantidad) * 100);
                        $ponderadoparcial += $arraycantidadpregunta["cuenta"] * $arraycantidadpregunta["valor"];
                    }
                    $agregaporcentaje = "%";
                    if ($this->resultadonumerico) {
                        $porcentaje = $arraycantidadpregunta["cuenta"];
                        $agregaporcentaje = "";
                    }
                    $this->formulario->filatmp[$arraycantidadpregunta["valor"]] = $porcentaje . $agregaporcentaje;
                }
            } else {
                if (!$this->mensajeYaMostrado)
                    alerta_javascript("No tiene respuestas para este docente");
                $this->mensajeYaMostrado = 1;
            }

            $this->formulario->filatmp["Total"] = $sumacantidad;
            if ($sumacantidad > 0)
                $this->formulario->filatmp["Nota"] = round($ponderadoparcial / ($sumacantidad * 5) * 5, 2);
            $this->arrayNotas[] = $this->formulario->filatmp["Nota"];
            $menu[0] = 'label_fila';
            $parametros[0] = "'" . $idpregunta . "','" . $valorpregunta . "',''";
            $this->contadorpreguntas++;
            $this->formulario->dibujar_camposseparados($menu, $parametros, $this->contadorpreguntas . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, 'requerido', "0");

            $conboton++;
            echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        }
        if (ereg("^5.", $ramapregunta["tipopregunta"])) {
            $this->contadorpreguntas++;
            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'" . $idpregunta . "','pregunta',30,3,'','','',''";
            $boton[$conboton] = 'memo';
            $requerido = "requerido";
            if ($ramapregunta["tipopregunta"] == '5') {
                $requerido = "";
                if ($valorpregunta == '')
                    $valorpregunta = " ";
            }

            $funcionobservacionrespuestas = $this->funcionobservacionrespuestas;
            $respuestasPregunta = $this->$funcionobservacionrespuestas($idpregunta, $cadenaparametros, $tablasadicionales);

            if (is_array($respuestasPregunta))
                foreach ($respuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                    $cadenarespuestas .= "<br>-" . $arraycantidadpregunta["preg_abierta"];
                }
            $this->formulario->filatmp["Respuestas"] = $cadenarespuestas;
            $menu[0] = 'label_fila';
            $parametros[0] = "'" . $idpregunta . "','" . $valorpregunta . "',''";
            $this->contadorpreguntas++;

            $this->formulario->dibujar_camposseparados($menu, $parametros, $this->contadorpreguntas . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, 'requerido', "0");

            echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        }
        if (is_array($ramapregunta["grupo"]))
            foreach ($ramapregunta["grupo"] as $llave => $grupo) {
                $this->muestraresultadospreguntas($ramapregunta["grupo"][$llave], $llave, $idinstrumento, $cadenaparametros, $tablasadicionales);
            }
    }

    function cantidadRespuestasPregunta($idpregunta, $cadenaparametros, $tablasadicionales) {

        $query = "SELECT sri.idsiq_Apregunta, sri.preg_abierta, spr.respuesta, spr.valor, spr.multiple_respuesta, COUNT(spr.valor) cuenta
        FROM siq_Arespuestainstrumento sri 
        " . $tablasadicionales . "
        WHERE 
        sri.idsiq_Ainstrumentoconfiguracion =" . $_REQUEST['idinstrumento'] . "
        AND sri.idsiq_Apregunta='" . $idpregunta . "'     
        " . $cadenaparametros . "
        GROUP BY spr.valor, sri.idsiq_Apregunta
        ORDER BY sri.idsiq_Apregunta, spr.valor";

        $resultado = $this->objetobase->conexion->query($query);

        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

    function observacionRespuestasPregunta($idpregunta, $cadenaparametros, $tablasadicionales) {

        $query = "SELECT sri.idsiq_Apregunta, sri.preg_abierta 
        FROM siq_Arespuestainstrumento sri 
        " . $tablasadicionales . "
        WHERE sri.idsiq_Ainstrumentoconfiguracion =" . $_REQUEST['idinstrumento'] . " 
        AND sri.idsiq_Apregunta='" . $idpregunta . "'              
        " . $cadenaparametros . " ";

        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

}

?>
