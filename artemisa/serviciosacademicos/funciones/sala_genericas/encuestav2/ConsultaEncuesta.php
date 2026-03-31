<?php

class ConsultaEncuesta {

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
    var $idencuesta;
    var $tablaRespuesta;
    var $mensajeYaMostrado;
    var $funcionrespuestapregunta;
    var $funcionobservacionrespuestas;
    var $numeracionpestana;
    var $contadoramaarbol;
    var $arreglorespuestausuario;
    var $arreglousuario;
    var $totalrespuestausuario;
    var $resultadospreguntas;
    var $arraypreguntas;
    var $condicionadicional;
    var $tablaadicional;
    var $noaplicapreguntas;
    var $resultadonumerico;

    function ConsultaEncuesta($objetobase, &$formulario) {

        $this->objetobase = $objetobase;
        $this->formulario = $formulario;
        $this->tablaRespuesta = "respuestadetalleencuestapreguntadocente";
        $this->mensajeYaMostrado = 0;
        $this->funcionrespuestapregunta = "cantidadRespuestasPregunta";
        $this->funcionobservacionrespuestas = "observacionRespuestasPregunta";
        $this->numeracionpestana = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
        $this->alfabetopestana = "";
        $this->contadoramaarbol = 0;
        $this->noaplicapreguntas = 0;
        $this->resultadonumerico = 0;
    }

    function setTipoUsuario($tipousuario) {
        $this->codigotipousuario = $tipousuario;
    }

    function setIdEncuesta($idencuesta) {
        $this->idencuesta = $idencuesta;
    }

    function setIdUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function resultadoNumerico() {
        $this->resultadonumerico = 1;
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

    function setArregloUsuario($arreglousuario) {
        $this->arreglousuario = $arreglousuario;
    }

    function setCondicionAdicional($condicion) {
        $this->condicionadicional = $condicion;
    }

    function setTablaAdicional($tabla) {
        $this->tablaadicional = $tabla;
    }

    function setAplicaPreguntas($noaplicapreguntas) {
        $this->noaplicapreguntas = $noaplicapreguntas;
    }

    function encuentraRespuestaUsuario($idusuario) {
        $tablas = $this->tablaRespuesta . " r, encuestapregunta ep";
        $condicion = " and r.codigoestado like '1%' " .
                " and ep.idencuestapregunta=r.idencuestapregunta ";
        $resultusuario = $this->objetobase->recuperar_resultado_tabla($tablas, "numerodocumento", $idusuario, $condicion, "", 0);
        while ($rowusuario = $resultusuario->fetchRow()) {
            $respuestas[$rowusuario["idpregunta"]][$rowusuario["iddetallepregunta"]] = $rowusuario["valor" . $this->tablaRespuesta];
        }
        return $respuestas;
    }

    function cargarTotalRespuestasUsuario() {
        for ($i = 0; $i < count($this->arreglousuario); $i++) {
            $totalrespuestas[$this->arreglousuario[$i]] = $this->encuentraRespuestaUsuario($this->arreglousuario[$i]);
        }
        $this->totalrespuestausuario = $totalrespuestas;
    }

    function getFormulario() {
        return $this->formulario;
    }

    function consultaprimernivelpreguntas() {
        //echo "<h1>ENTRO2</h1>";
        $tabla = "preguntatipousuario pt,tipopregunta tp, pregunta p, encuestapregunta ep " . $this->tablaadicional;
        $nombreidtabla = "ep.idencuesta";
        $idtabla = $this->idencuesta;
        $condicion = " and pt.idpregunta=p.idpregunta and
	tp.idtipopregunta=p.idtipopregunta and
	idpreguntagrupo = '0' and
	p.codigoestado like '1%' and
	pt.codigoestado like '1%' and
        ep.idpregunta=p.idpregunta
        " . $this->condicionadicional . "
	order by p.pesopregunta
	 ";

        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, ",p.idpregunta codigopregunta", 0);
        //exit();
        while ($row = $resultado->fetchRow()) {



            $tabla = "encuestapregunta e";
            $nombreidtabla = " e.idpregunta";
            $idtabla = $row["codigopregunta"];
            $condicion = " and e.codigoestado like '1%' ";
            $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
            $conencuesta = 0;
            while ($rowencuesta = $resultadoencuesta->fetchRow()) {
                $tmparrayencuesta[] = $rowencuesta["idencuesta"];
            }
            //if($conencuesta>0)
            //	unset($this->tmpencuesta);

            $tmprow[$row["codigopregunta"]]["nombre"] = $row["nombrepregunta"];
            $tmprow[$row["codigopregunta"]]["tipopregunta"] = $row["idtipopregunta"];
            $tmprow[$row["codigopregunta"]]["numeroopciones"] = $row["numeroopcionestipopregunta"];
            $tmprow[$row["codigopregunta"]]["menornombreopcion"] = $row["textoinicialtipopregunta"];

            $tmprow[$row["codigopregunta"]]["mayornombreopcion"] = $row["textofinaltipopregunta"];
            $tmprow[$row["codigopregunta"]]["idpreguntagrupo"] = $row["idpreguntagrupo"];
            $tmprow[$row["codigopregunta"]]["encuesta"] = $tmparrayencuesta;


            $this->arbolpreguntas[$row["codigopregunta"]]["nombre"] = $row["nombrepregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["tipopregunta"] = $row["idtipopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["descripcionpregunta"] = $row["descripcionpregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["numeroopciones"] = $row["numeroopcionestipopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["menornombreopcion"] = $row["textoinicialtipopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["estadoobligatoriopregunta"] = $row["estadoobligatoriopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["mayornombreopcion"] = $row["textofinaltipopregunta"];
            $this->arbolpreguntas[$row["codigopregunta"]]["idpreguntagrupo"] = $row["idpreguntagrupo"];
            $this->arbolpreguntas[$row["codigopregunta"]]["encuesta"] = $row["idencuesta"];
            //$this->arbolpreguntas=$tmprow;
            //$tmptitulospreguntas[]=$tmprow;
            //exit();

            $this->arbolpreguntas[$row["codigopregunta"]]["grupo"] = $this->recursivaarmaarbolarray($row["codigopregunta"]);

            //if(!is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))
            //unset($this->tmpencuesta);

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

    function getDetallePregunta($idpregunta) {
        $tabla = "detallepregunta";
        $nombreidtabla = "idpregunta";
        $idtabla = $idpregunta;
        $condicion = " and codigoestado='100'";
        $resultadopregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($rowpregunta = $resultadopregunta->fetchRow()) {
            $detallepregunta[] = $rowpregunta;
        }
        return $detallepregunta;
    }

    function recursivaarmaarbolarray($idpregunta) {
        $this->contadoramaarbol++;

        $tabla = "preguntatipousuario pt,tipopregunta tp, pregunta p, encuestapregunta ep " . $this->tablaadicional;
        $nombreidtabla = "ep.idencuesta";
        $idtabla = $this->idencuesta;
        $condicion = " and pt.idpregunta=p.idpregunta and
	tp.idtipopregunta=p.idtipopregunta and
	  idpreguntagrupo = '" . $idpregunta . "' and
	p.codigoestado like '1%' and
	pt.codigoestado like '1%' and
        ep.idpregunta=p.idpregunta
        " . $this->condicionadicional . "
	order by p.pesopregunta";
        /* left join encuestapregunta ep on   ep.idpregunta=p.idpregunta
          left join encuesta e on ep.idencuesta=e.idencuesta and '".date("Y-m-d")."'
          between e.fechainicioencuesta and fechafinalencuesta and e.codigoestado like '1%' */


        $resultadopregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, ",p.idpregunta codigopregunta", 0);
//echo "<br><br>";
//if(is_array($resultadopregunta)){

        while ($datospregunta = $resultadopregunta->fetchRow()) {

            $tabla = "encuestapregunta e";
            $nombreidtabla = " e.idpregunta";
            $idtabla = $datospregunta["codigopregunta"];
            $condicion = " and e.codigoestado like '1%' ";
            $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
            unset($tmparrayencuesta);
            while ($rowencuesta = $resultadoencuesta->fetchRow()) {
                $tmparrayencuesta[] = $rowencuesta["idencuesta"];

                $conencuesta++;
            }

            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["nombre"] = $datospregunta["nombrepregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["tipopregunta"] = $datospregunta["idtipopregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["descripcionpregunta"] = $datospregunta["descripcionpregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["estadoobligatoriopregunta"] = $datospregunta["estadoobligatoriopregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["numeroopciones"] = $datospregunta["numeroopcionestipopregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["menornombreopcion"] = $datospregunta["textoinicialtipopregunta"];

            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["mayornombreopcion"] = $datospregunta["textofinaltipopregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["idpreguntagrupo"] = $datospregunta["idpreguntagrupo"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["valordependenciapregunta"] = $datospregunta["valordependenciapregunta"];
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["encuesta"] = $tmparrayencuesta;
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["grupo"] = $this->recursivaarmaarbolarray($datospregunta["codigopregunta"]);
            $ramaarbolpreguntas[$datospregunta["codigopregunta"]]["detallepregunta"] = $this->getDetallePregunta($datospregunta["codigopregunta"]);
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

//if(!is_array($this->arbolpreguntas[$row["codigopregunta"]]["grupo"]))
            //	unset($this->tmpencuesta);
        }
        return $ramaarbolpreguntas;
//}
    }

    function recuperarpadrepreguntas() {

        return $this->titulospreguntas;
    }

    function recuperarencuestatipousuario() {

        $tabla = "encuestapregunta ep,encuesta e,pregunta p";
        $nombreidtabla = "e.codigotipousuario";
        $idtabla = $this->codigotipousuario;
        $condicion = " and e.idencuesta= ep.idencuesta
	and ep.idpregunta=p.idpregunta
	and ep.codigoestado like '1%'
	and e.codigoestado like '1%'
	and p.codigoestado like '1%'
	and now() between e.fechainicioencuesta and e.fechafinalencuesta";
        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        unset($this->encuesta);

        while ($rowencuesta = $resultadoencuesta->fetchRow()) {


            $this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpregunta"]] = "1";
            $this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpreguntagrupo"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"], $rowencuesta["idencuesta"]);
        }
        return $this->encuesta;
    }

    function recuperarencuesta() {

        $tabla = "encuestapregunta ep,encuesta e,pregunta p";
        $nombreidtabla = "e.idencuesta";
        $idtabla = $this->idencuesta;
        $condicion = " and e.idencuesta= ep.idencuesta
	and ep.idpregunta=p.idpregunta
	and ep.codigoestado like '1%'
	and e.codigoestado like '1%'
	and p.codigoestado like '1%'
	and now() between e.fechainicioencuesta and e.fechafinalencuesta";
        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        unset($this->encuesta);

        while ($rowencuesta = $resultadoencuesta->fetchRow()) {


            $this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpregunta"]] = "1";
            $this->encuesta[$rowencuesta["idencuesta"]][$rowencuesta["idpreguntagrupo"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"], $rowencuesta["idencuesta"]);
        }
        return $this->encuesta;
    }

    function recursivorecuperarencuestapreguntas($idpregunta, $idencuesta) {

        $tabla = "pregunta p";
        $nombreidtabla = "p.idpregunta";
        $idtabla = $idpregunta;
        $condicion = "and idpreguntagrupo <> '0'
	    and	p.codigoestado like '1%'";
        $resultadoencuesta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
//echo "<br>";
//unset($this->encuesta);

        while ($rowencuesta = $resultadoencuesta->fetchRow()) {
            $this->encuesta[$idencuesta][$idpregunta] = "1";
            $this->encuesta[$idencuesta][$rowencuesta["idpreguntagrupo"]] = "1";
            $this->recursivorecuperarencuestapreguntas($rowencuesta["idpreguntagrupo"], $idencuesta);
        }
    }

    function recuperartitulosencuesta() {
        $tabla = "encuesta e";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = " '" . date("Y-m-d") . "' between e.fechainicioencuesta and fechafinalencuesta
	e.codigoestado like '1%' and
";
        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($row = $resultado->fetchRow()) {
            $this->tituloencuesta[]["nombreencuesta"] = $row["nombreencuesta"];
        }
    }

    function recuperartipopregunta() {
        $tabla = "tipopregunta t";
        $nombreidtabla = "1";
        $idtabla = "1";
        $condicion = " and t.codigoestado like '1%'";
        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        $i = 0;
        while ($row = $resultado->fetchRow()) {
            $this->tipopregunta[$i]["nombretipopregunta"] = $row["nombretipopregunta"];
            $this->tipopregunta[$i]["idtipopregunta"] = $row["idtipopregunta"];
            $i++;
        }
    }

    function recuperaidencuestapregunta($idpregunta, $idencuesta) {

        $tabla = "encuestapregunta ep";
        $nombreidtabla = "ep.idpregunta";
        $idtabla = $idpregunta;
        $condicion = " 	and ep.idencuesta=" . $idencuesta . "
			and ep.codigoestado like '1%'";

        $datosrespuestapregunta = $this->objetobase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);

        return $datosrespuestapregunta["idencuestapregunta"];
    }

    function recuperarrespuestapreguntausuario($idusuario) {

        $this->idusuario = $idusuario;

        $tabla = $this->tablaRespuesta . " rp,encuesta e,encuestapregunta ep";
        $nombreidtabla = "rp.numerodocumento";
        $idtabla = $idusuario;
        $condicion = "
			and e.idencuesta=ep.idencuesta
			and rp.idencuestapregunta=ep.idencuestapregunta
			and '" . date("Y-m-d") . "'
 			between e.fechainicioencuesta and fechafinalencuesta
			and e.codigoestado like '1%'
			and ep.codigoestado like '1%'
			and rp.codigoestado like '1%'
			";

        $resultadorespuestapregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, ",ep.idpregunta pregunta,rp.valor" . $this->tablaRespuesta . " valor,ep.idencuesta encuesta", 0);

        $this->noterminado = 0;
        $i = 0;
        while ($row = $resultadorespuestapregunta->fetchRow()) {
            $arraydatosrespuesta["idencuesta"] = $row["encuesta"];
            $arraydatosrespuesta[$row["pregunta"]] = $row["valor"];
            $arraydatosrespuesta["detalle"][$row["pregunta"]][$row["iddetallepregunta"]] = $row["valor"];
            if (trim($row["valor"]) == "")
                $this->noterminado = 1;
            $i++;
        }
        if ($i == 0)
            $this->noterminado = 1;
        /*   echo "detalle<pre>";
          print_r($arraydatosrespuesta["detalle"]);
          echo "</pre>"; */
        $this->respuestausuariopregunta = $arraydatosrespuesta;
        return $arraydatosrespuesta;
    }

    function muestraformularioasignapreguntas($ramapregunta, $idpregunta, $idencuesta="1") {

        unset($formulario->filatmp);

        $idpregunta = $idpregunta;
//echo "<br>TIPOPREGUNTA=";
        $opcionmenuidpregunta = $ramapregunta["tipopregunta"];
//echo "<br>";
        $idpreguntapadre = $ramapregunta["idpreguntagrupo"];
        unset($observacionpregunta);
        $observacionpregunta = $ramapregunta["nombre"];
        unset($this->formulario->filatmp);

        if (ereg("^3.", $ramapregunta["tipopregunta"])) {





            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'observacionpregunta" . $idpregunta . "','pregunta',60,2,'','','',''";
            $boton[$conboton] = 'memo';


            $cuentaencuesta = count($ramapregunta["encuesta"]);
            if ($cuentaencuesta > 0) {
                $conboton++;
                $parametrobotonenviar[$conboton] = "'text','cuentaencuesta" . $idpregunta . "','" . $cuentaencuesta . "','size=2 readonly=true'";
                $boton[$conboton] = 'boton_tipo';
            }
            for ($id = 0; $id < count($this->tipopregunta); $id++) {
                $opcionparametrizacion = $this->tipopregunta[$id]["idtipopregunta"];
                $this->formulario->filatmp[$opcionparametrizacion] = $this->tipopregunta[$id]["nombretipopregunta"];
            }
            $conboton++;

            $parametrobotonenviar[$conboton] = "'menu" . $idpregunta . "','" . $opcionmenuidpregunta . "',''";
            $boton[$conboton] = 'menu_fila';



            $checked = "";
            if (is_array($ramapregunta["encuesta"]))
                if (in_array($idencuesta, $ramapregunta["encuesta"])) {
                    $checked = "checked";
                    $conboton++;
                    $parametrobotonenviar[$conboton] = "'hidden','preguntaschecadas[]','" . $idpregunta . "',''";
                    $boton[$conboton] = 'boton_tipo';
                }

            $conboton++;
            $parametrobotonenviar[$conboton] = "'checkbox','check" . $idpregunta . "','1','" . $checked . "'";
            $boton[$conboton] = 'boton_tipo';

            $conboton++;
            $parametrobotonenviar[$conboton] = "'text','padre" . $idpregunta . "','" . $idpreguntapadre . "','size=5'";
            $boton[$conboton] = 'boton_tipo';

            $conboton++;
            $parametrobotonenviar[$conboton] = "'hidden','preguntas[]','" . $idpregunta . "',''";
            $boton[$conboton] = 'boton_tipo';

            $this->formulario->dibujar_campos($boton, $parametrobotonenviar, $idpregunta, "labelresaltado", 'observacionpregunta', '');
            $this->formulario->cambiar_valor_campo('observacionpregunta' . $idpregunta, $observacionpregunta);
        }


        if (ereg("^1.", $ramapregunta["tipopregunta"])) {


            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'observacionpregunta" . $idpregunta . "','pregunta',60,2,'','','',''";
            $boton[$conboton] = 'memo';

            $cuentaencuesta = count($ramapregunta["encuesta"]);
            if ($cuentaencuesta > 0) {
                $conboton++;
                $parametrobotonenviar[$conboton] = "'text','cuentaencuesta" . $idpregunta . "','" . $cuentaencuesta . "','size=2 readonly=true'";
                $boton[$conboton] = 'boton_tipo';
            }

            for ($id = 0; $id < count($this->tipopregunta); $id++) {
                $opcionparametrizacion = $this->tipopregunta[$id]["idtipopregunta"];
                $this->formulario->filatmp[$opcionparametrizacion] = $this->tipopregunta[$id]["nombretipopregunta"];
            }
            $conboton++;

            $parametrobotonenviar[$conboton] = "'menu" . $idpregunta . "','" . $opcionmenuidpregunta . "',''";
            $boton[$conboton] = 'menu_fila';

            $checked = "";

            if (is_array($ramapregunta["encuesta"]))
                if (in_array($idencuesta, $ramapregunta["encuesta"])) {
                    $checked = "checked";
                    $conboton++;
                    $parametrobotonenviar[$conboton] = "'hidden','preguntaschecadas[]','" . $idpregunta . "',''";
                    $boton[$conboton] = 'boton_tipo';
                }
            /* $conboton++;
              $parametrobotonenviar[$conboton]="'checkbox','check".$idpregunta."','1','".$checked."'";
              $boton[$conboton]='boton_tipo'; */

            $conboton++;
            $parametrobotonenviar[$conboton] = "'text','padre" . $idpregunta . "','" . $idpreguntapadre . "','size=5'";
            $boton[$conboton] = 'boton_tipo';

            $conboton++;
            $parametrobotonenviar[$conboton] = "'hidden','preguntas[]','" . $idpregunta . "',''";
            $boton[$conboton] = 'boton_tipo';

            $this->formulario->dibujar_campos($boton, $parametrobotonenviar, $idpregunta, "tdtitulogris", 'observacionpregunta', '');
            $this->formulario->cambiar_valor_campo('observacionpregunta' . $idpregunta, $observacionpregunta);
        }

        if (is_array($ramapregunta["grupo"]))
            foreach ($ramapregunta["grupo"] as $llave => $grupo) {

                $this->muestraformularioasignapreguntas($grupo, $llave, $idencuesta);
            }
    }

    function recuperaobjetoformulario() {
        return $this->formulario;
    }

    function imprimeTituloPrincipal($ramapregunta, $idpregunta, $idencuesta) {

        $this->formulario->dibujar_fila_titulo("<br>" . $ramapregunta["nombre"], 'tdtitulosubgrupoencuesta', "2", "align='left'", "td");
        if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
            $this->formulario->dibujar_fila_titulo("<br>" . $ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
    }

    function imprimeTituloSecundario($ramapregunta, $idpregunta, $idencuesta) {
        $this->formulario->dibujar_fila_titulo($this->alfabetopestana . " " . $ramapregunta["nombre"], 'tdtituloencuesta', "2", "align='center'", "td");
        if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
            $this->formulario->dibujar_fila_titulo("<br>" . $this->alfabetopestana . " " . $ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
    }

    function listaCamposPregunta($ramapregunta, $idpregunta, $idencuesta, $valorpregunta) {
        /*  echo "ramapregunta<pre>";
          print_r($ramapregunta);
          echo "</pre>"; */
        $this->contadorpreguntas++;
        $numeral = $this->alfabetopestana . "." . $this->contadorpreguntas;
        $this->preguntasencuesta[] = $idpregunta;
        $valorrespuestagrupo = $this->respuestausuariopregunta[$ramapregunta["idpreguntagrupo"]];
        if ($ramapregunta["valordependenciapregunta"] == $valorrespuestagrupo) {
            $ramapregunta["estadoobligatoriopregunta"] = '1';
        }

        $opcionparametrizacion = "1";
        $this->formulario->filatmp[$opcionparametrizacion] = $ramapregunta["menornombreopcion"];
        for ($i = 2; $i < $ramapregunta["numeroopciones"]; $i++) {
            $opcionparametrizacion = $i;
            $this->formulario->filatmp[$opcionparametrizacion] = "";
        }
        $opcionparametrizacion = $ramapregunta["numeroopciones"];
        $this->formulario->filatmp[$opcionparametrizacion] = $ramapregunta["mayornombreopcion"];

        $javascript = "enviarrespuesta(this," . $idpregunta . ",\"" . $this->idusuario . "\"," . $idencuesta . ")";


        $menu[0] = 'radio_fila';
        $parametros[0] = "'" . $idpregunta . "','" . $valorpregunta . "','onclick=\'return " . $javascript . "\''";

        if ($this->codigotipousuario == "700" || $this->codigotipousuario == "800" || $this->noaplicapreguntas) {
            $menu[1] = 'radio_fila_unico';
            $parametros[1] = "'" . $idpregunta . "','" . $valorpregunta . "','onclick=\'return " . $javascript . "\'','-1','No aplica','No aplica'";
        }


        if ($ramapregunta["estadoobligatoriopregunta"]) {
            $requerido = "requerido";
        } else {
            $requerido = "";
        }

        $this->formulario->dibujar_camposseparados($menu, $parametros, $numeral . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, $requerido, "0");

        $conboton++;
        echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
    }

    function preguntaAbierta($ramapregunta, $idpregunta, $idencuesta, $valorpregunta) {

        $this->contadorpreguntas++;
        $numeral = $this->alfabetopestana . "." . $this->contadorpreguntas;
        $conboton = 0;
        $parametrobotonenviar[$conboton] = "'" . $idpregunta . "','pregunta',30,3,'','','',''";
        $boton[$conboton] = 'memo';
        $requerido = "requerido";
        if ($ramapregunta["tipopregunta"] == '201') {
            $requerido = "";
            if ($valorpregunta == '')
                $valorpregunta = " ";
        }

        $this->formulario->dibujar_campos($boton, $parametrobotonenviar, $numeral . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, $requerido, "0");
        $this->formulario->cambiar_valor_campo($idpregunta, $valorpregunta);
        echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
    }

    function seleccionUnica($ramapregunta, $idpregunta, $idencuesta, $valorpregunta) {
        $this->preguntasencuesta[] = $idpregunta;
        $this->contadorpreguntas++;
        $numeral = "<br>" . $this->alfabetopestana . "." . $this->contadorpreguntas;
        echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        $preguntaconvalor = 0;
        /* echo "preguntasencuesta2<pre>";
          print_r($this->preguntasencuesta);
          echo "</pre>"; */
        $valorrespuestagrupo = $this->respuestausuariopregunta[$ramapregunta["idpreguntagrupo"]];
        if ($idpregunta == '1936') {
            echo "<br>if (" . $ramapregunta["valordependenciapregunta"] . " == " . $valorrespuestagrupo . ") {";
        }
        if ($ramapregunta["valordependenciapregunta"] == $valorrespuestagrupo) {
            $ramapregunta["estadoobligatoriopregunta"] = '1';
        }
        /* echo "<pre>";
          print_r($ramapregunta);
          echo "</pre>"; */
        // $this->formulario->dibujar_fila_titulo($this->contadorpreguntas . ") " .$ramapregunta["nombre"], 'tdtituloencuesta', "2", "align='center'", "td");
        if ($ramapregunta["estadoobligatoriopregunta"]) {
            echo "<!--";
            $this->formulario->etiqueta("h" . $idpregunta, $numeral . ") " . $ramapregunta["nombre"], "requerido");
            echo "-->";
            $this->formulario->boton_tipo("hidden", "h" . $idpregunta, '', '');
        } else {
            echo "<!--";
            $this->formulario->etiqueta("h" . $idpregunta, $numeral . ") " . $ramapregunta["nombre"], "requerido");
            echo "-->";
            $this->formulario->boton_tipo("hidden", "h" . $idpregunta, '1', '');
        }
        $this->formulario->dibujar_fila_titulo($numeral . ") " . $ramapregunta["nombre"], 'tdtitulosubgrupoencuesta', "2", "align='left'", "td");
        unset($this->formulario->filatmp);
        foreach ($ramapregunta["detallepregunta"] as $idetallepregunta => $rowdetallepregunta) {
            if (trim($rowdetallepregunta["valordetallepregunta"]) == '' ||
                    !isset($rowdetallepregunta["valordetallepregunta"])) {
                $valordetallepregunta = $rowdetallepregunta["iddetallepregunta"];
            } else {
                $valordetallepregunta = $rowdetallepregunta["iddetallepregunta"];
            }
            if ($valordetallepregunta == $valorpregunta) {
                $preguntaconvalor = 1;
            }
            $javascript = "enviarrespuesta(this," . $idpregunta . ",\"" . $this->idusuario . "\"," . $idencuesta . ")";
            $menu = 'radio_fila_unico';
            $parametros = "'" . $idpregunta . "','" . $valorpregunta . "','onclick=\'return " . $javascript . "\'','" . $valordetallepregunta . "'";
            $requerido = "";
            $this->formulario->dibujar_campo($menu, $parametros, $rowdetallepregunta["nombredetallepregunta"], "tdtitulogris", $idpregunta, $requerido, "0");
        }
        if ($preguntaconvalor) {
            $this->formulario->cambiar_valor_campo("h" . $idpregunta, "1");
        }
    }

    function seleccionMultipleBloqueo($ramapregunta, $idpregunta, $idencuesta, $valorpregunta) {
        $this->preguntasencuesta[] = $idpregunta;
        $this->contadorpreguntas++;
        echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        $numeral = "<br>" . $this->alfabetopestana . "." . $this->contadorpreguntas;
        /* echo "preguntasencuesta2<pre>";
          print_r($this->preguntasencuesta);
          echo "</pre>"; */
        $preguntaconvalor = 0;
        $valorrespuestagrupo = $this->respuestausuariopregunta[$ramapregunta["idpreguntagrupo"]];
        if ($ramapregunta["valordependenciapregunta"] == $valorrespuestagrupo) {
            $ramapregunta["estadoobligatoriopregunta"] = '1';
        }
        /* echo "<pre>";
          print_r($this->respuestausuariopregunta);
          echo "</pre>"; */
        // $this->formulario->dibujar_fila_titulo($this->contadorpreguntas . ") " .$ramapregunta["nombre"], 'tdtituloencuesta', "2", "align='center'", "td");
        $this->formulario->dibujar_fila_titulo($numeral . ") " . $ramapregunta["nombre"], 'tdtitulosubgrupoencuesta', "2", "align='left'", "td");
        if ($ramapregunta["estadoobligatoriopregunta"]) {
            echo "<!--";
            $this->formulario->etiqueta("h" . $idpregunta, $numeral . ") " . $ramapregunta["nombre"], "requerido");
            echo "-->";
            $this->formulario->boton_tipo("hidden", "h" . $idpregunta, '', '');
        } else {
            echo "<!--";
            $this->formulario->etiqueta("h" . $idpregunta, $numeral . ") " . $ramapregunta["nombre"], "requerido");
            echo "-->";
            $this->formulario->boton_tipo("hidden", "h" . $idpregunta, '1', '');
        }
        unset($this->formulario->filatmp);
        $idetallecheck = 0;
        if (is_array($ramapregunta["detallepregunta"]))
            foreach ($ramapregunta["detallepregunta"] as $idetallepregunta => $rowdetallepregunta) {
                $valordetallepregunta = $rowdetallepregunta["iddetallepregunta"];

                if ($rowdetallepregunta["idtipodetallepregunta"] == "4") {
                    $conboton = 0;

                    $valorpregunta = $this->respuestausuariopregunta["detalle"][$idpregunta][$rowdetallepregunta["iddetallepregunta"]];
                    if (isset($valorpregunta) &&
                            trim($valorpregunta) != '') {
                        $check = "checked";
                        $disabled = "false";
                        $preguntaconvalor = 1;
                    } else {
                        $check = "";
                        $disabled = "true";
                    }
                    //$javascript = "bloqueachequeopregunta(this,\"a" . $valordetallepregunta . "\",\"" . $idpregunta . "\");";
                    $javascript = "enviarrespuestadetalle(this," . $idpregunta . ",\"" . $this->idusuario . "\"," . $idencuesta . ",\"d" . $valordetallepregunta . "\"," . $numeroopciones . ",true)";
                    $parametrobotonenviar[$conboton] = "'d" . $valordetallepregunta . "','" . $valordetallepregunta . "','" . $check . "', '" . $mensajeconfirma . "','onclick=\'return " . $javascript . "\''";
                    $boton[$conboton] = 'caja_chequeo';

                    $conboton++;
                    $parametrobotonenviar[$conboton] = "'a" . $valordetallepregunta . "','pregunta',30,3,'','','',''";
                    $boton[$conboton] = 'memo';


                    $requerido = "";


                    $this->formulario->dibujar_campos($boton, $parametrobotonenviar, $rowdetallepregunta["nombredetallepregunta"], "tdtitulogris", "a" . $valordetallepregunta, $requerido, 0);
                    $this->formulario->cambiar_valor_campo("a" . $valordetallepregunta, $valorpregunta);
                    echo "<script type='text/javascript'>" .
                    " campopregunta=document.getElementById('a" . $valordetallepregunta . "');" .
                    " campopregunta.disabled=" . $disabled . ";" .
                    "</script>";
                }
                if ($rowdetallepregunta["idtipodetallepregunta"] == "3") {
                    $idetallecheck++;
                    $valorpregunta = $this->respuestausuariopregunta["detalle"][$idpregunta][$rowdetallepregunta["iddetallepregunta"]];
                    if (isset($valorpregunta) &&
                            trim($valorpregunta) != '') {
                        $check = "checked";
                        $preguntaconvalor = 1;
                    } else {
                        $check = "";
                    }

                    $numeroopciones = $ramapregunta["numeroopciones"];
                    echo "<input type='hidden' name='" . $idpregunta . "c" . $idetallecheck . "' id='" . $idpregunta . "c" . $idetallecheck . "' value='d" . $valordetallepregunta . "' />";
                    $javascript = "enviarrespuestadetalle(this," . $idpregunta . ",\"" . $this->idusuario . "\"," . $idencuesta . ",d" . $valordetallepregunta . "," . $numeroopciones . ",false)";
                    $menu = 'caja_chequeo';
                    //$parametros = "'" . $idpregunta . "','" . $valorpregunta . "','onclick=\'return " . $javascript . "\'','" . $valordetallepregunta . "'";
                    $parametros = "'d" . $valordetallepregunta . "','" . $valordetallepregunta . "','" . $check . "', '" . $mensajeconfirma . "','onclick=\'return " . $javascript . "\''";
                    $requerido = "";
                    $this->formulario->dibujar_campo($menu, $parametros, $rowdetallepregunta["nombredetallepregunta"], "tdtitulogris", $idpregunta, $requerido, "0");
                }
            }
        if ($preguntaconvalor) {
            $this->formulario->cambiar_valor_campo("h" . $idpregunta, "1");
        }
    }

    function estadoObligatorioPregunta($ramapregunta) {
        $valorrespuestagrupo = $this->respuestausuariopregunta[$ramapregunta["idpreguntagrupo"]];
        if ($ramapregunta["valordependenciapregunta"] == $valorrespuestagrupo) {
            return 1;
        }

        return 0;
    }

    function encuentraDependenciaPregunta($ramapregunta) {
        $valorrespuestagrupo = $this->respuestausuariopregunta[$ramapregunta["idpreguntagrupo"]];
        if (trim($ramapregunta["valordependenciapregunta"]) != '' &&
                $ramapregunta["valordependenciapregunta"] != '0' &&
                isset($ramapregunta["valordependenciapregunta"])) {
            return 1;
        }

        return 0;
    }

    function muestraformulariopreguntas($ramapregunta, $idpregunta, $idencuesta) {
        $valorpregunta = $this->respuestausuariopregunta[$idpregunta];
        $estadovisible = "";
        if ($this->encuentraDependenciaPregunta($ramapregunta)) {
            if (!$this->estadoObligatorioPregunta($ramapregunta)) {
                $estadovisible = "style='visibility:hidden;   position:fixed;'";
            }
        }

        unset($this->formulario->filatmp);
        if ($ramapregunta["tipopregunta"] == "101") {
            $this->imprimeTituloPrincipal($ramapregunta, $idpregunta, $idencuesta);
        }

        if ($ramapregunta["tipopregunta"] == "100") {
            $this->imprimeTituloSecundario($ramapregunta, $idpregunta, $idencuesta);
        }
        if (ereg("^3.", $ramapregunta["tipopregunta"])) {
            echo "<tbody id='div" . $idpregunta . "' name='div" . $idpregunta . "' " . $estadovisible . ">";
            $this->listaCamposPregunta($ramapregunta, $idpregunta, $idencuesta, $valorpregunta);
            echo "</tbody>";
        }
        if (ereg("^2.", $ramapregunta["tipopregunta"])) {
            echo "<tbody id='div" . $idpregunta . "' name='div" . $idpregunta . "' " . $estadovisible . ">";
            $this->preguntaAbierta($ramapregunta, $idpregunta, $idencuesta, $valorpregunta);
            echo "</tbody>";
        }
        //echo "<h1>".$ramapregunta["tipopregunta"]."</h1>";
        if (ereg("^4.", $ramapregunta["tipopregunta"])) {
            //echo "<h1>Entro?</h1>";
            echo "<tbody id='div" . $idpregunta . "' name='div" . $idpregunta . "' " . $estadovisible . ">";
            if ($ramapregunta["tipopregunta"] == "400") {
                $this->seleccionUnica($ramapregunta, $idpregunta, $idencuesta, $valorpregunta);
            }
            //if ($ramapregunta["tipopregunta"] == "401") {

            if (ereg("^40.", $ramapregunta["tipopregunta"]) &&
                    $ramapregunta["tipopregunta"] > 400) {

                $this->seleccionMultipleBloqueo($ramapregunta, $idpregunta, $idencuesta, $valorpregunta);
            }
            echo "</tbody>";
        }
        if (is_array($ramapregunta["grupo"]))
            foreach ($ramapregunta["grupo"] as $llave => $grupo) {
                $this->muestraformulariopreguntas($ramapregunta["grupo"][$llave], $llave, $idencuesta);
            }
        //}
    }

    function consultaDependenciaPregunta($valorrespuesta, $idpregunta) {
        $tabla = "pregunta";
        $nombreidtabla = "idpreguntagrupo";
        $idtabla = $idpregunta;
        $condicion = " and codigoestado like '1%' and valordependenciapregunta='" . $valorrespuesta . "'";
        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($row = $resultado->fetchrow()) {
            $preguntasdependencia[] = $row;
        }
        return $preguntasdependencia;
    }

    function consultaNoDependenciaPregunta($valorrespuesta, $idpregunta) {
        $tabla = "pregunta";
        $nombreidtabla = "idpreguntagrupo";
        $idtabla = $idpregunta;
        $condicion = " and codigoestado like '1%' and valordependenciapregunta <>'" . $valorrespuesta . "'";
        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($row = $resultado->fetchrow()) {
            $preguntasdependencia[] = $row;
        }
        return $preguntasdependencia;
    }

    function guardarEncuestaAjax($valorrespuesta, $idpregunta, $filaadicional=array()) {
        unset($fila);
        $tabla = $this->tablaRespuesta;
        if (count($filaadicional) >= 1) {
            $fila = $filaadicional;
        }
        //$tabla="respuestadetalleencuestapreguntadocente";
//$fila["idpregunta"]=$idpregunta;
        $fila["numerodocumento"] = $this->idusuario;
        $fila["valor" . $tabla] = "" . $valorrespuesta;
        $fila["codigoestado"] = "100";
        $idencuestapregunta = $this->recuperaidencuestapregunta($idpregunta, $this->idencuesta);
        $fila["idencuestapregunta"] = $idencuestapregunta;
        $fila["iddetallepregunta"] = '1';
        /*  echo "<pre>";
          print_r($fila);
          echo "<pre>"; */
        $condicionactualiza = " idencuestapregunta='" . $idencuestapregunta . "'" .
                " and numerodocumento='" . $this->idusuario . "'";
        // echo "<pre>";
        $this->objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
        //echo "</pre>";
        $preguntasdependencia = $this->consultaDependenciaPregunta($valorrespuesta, $idpregunta);
        $preguntasnodependencia = $this->consultaNoDependenciaPregunta($valorrespuesta, $idpregunta);

        header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
// generate the output in XML format
        header('Content-type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<data>';
        /* echo "<pre>";
          print_r($preguntasdependencia);
          echo "</pre>"; */
        if (is_array($preguntasnodependencia)) {
            foreach ($preguntasnodependencia as $ipregunta => $filapregunta) {
                echo "<preguntanodependencia>" . $filapregunta["idpregunta"] . "</preguntanodependencia>";
            }
        }
        if (is_array($preguntasdependencia)) {
            foreach ($preguntasdependencia as $ipregunta => $filapregunta) {
                echo "<preguntadependencia>" . $filapregunta["idpregunta"] . "</preguntadependencia>";
            }
        } else {
            echo "<mensaje>Guardado exitoso</mensaje>";
        }
        echo '</data>';
    }

    function guardarEncuestaAjaxDetalle($valorrespuesta, $idpregunta, $estado, $filaadicional=array()) {
        unset($fila);
        $tabla = $this->tablaRespuesta;
        if (count($filaadicional) >= 1) {
            $fila = $filaadicional;
        }
        //$tabla="respuestadetalleencuestapreguntadocente";
//$fila["idpregunta"]=$idpregunta;
        $fila["numerodocumento"] = $this->idusuario;
        $fila["valor" . $tabla] = "" . $valorrespuesta;
        $fila["codigoestado"] = $estado;
        $idencuestapregunta = $this->recuperaidencuestapregunta($idpregunta, $this->idencuesta);
        $fila["idencuestapregunta"] = $idencuestapregunta;
        $fila["iddetallepregunta"] = $valorrespuesta;
        /* echo "<pre>";
          print_r($fila);
          echo "<pre>"; */
        $condicionactualiza = " idencuestapregunta='" . $idencuestapregunta . "'" .
                " and numerodocumento='" . $this->idusuario . "'" .
                " and (iddetallepregunta='" . $fila["iddetallepregunta"] . "' or
                    valor" . $tabla . "=' ')";
//echo "<pre>";
        $this->objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
//echo "</pre>";


        /* header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
          header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
          header('Cache-Control: no-cache, must-revalidate');
          header('Pragma: no-cache');
          // generate the output in XML format
          header('Content-type: text/xml');
          echo '<?xml version="1.0" encoding="UTF-8"?>';
          echo '<data>';
          echo "Guardado exitoso";
          echo '</data>'; */
    }

    function encontrarDetalleRespuestaPregunta($idpregunta) {
        $tabla = $this->tablaRespuesta . " r,encuestapregunta ep";
        $nombreidtabla = "numerodocumento";
        $idtabla = $this->idusuario;
        $condicion = " and ep.idpregunta='" . $idpregunta . "'" .
                " and ep.idencuestapregunta=r.idencuestapregunta " .
                " and r.codigoestado like '1%'
                   and r.valor" . $this->tablaRespuesta . " <> ' '";

        $resultado = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($row = $resultado->fetchRow()) {
            $detallerespuesta[] = $row;
        }
        return $detallerespuesta;
    }

    function arregloResultadoPreguntas($ramapregunta, $idpregunta, $idencuesta, $cadenaparametros, $tablasadicionales) {
        $valorpregunta = $this->respuestausuariopregunta[$idpregunta];

        unset($this->formulario->filatmp);
        if ($ramapregunta["tipopregunta"] == "101") {

        }
        if ($ramapregunta["tipopregunta"] == "100") {

        }
        /* echo "arreglousuario<pre>";
          print_r($this->totalrespuestausuario);
          echo "</pre>"; */
        if (ereg("^3.", $ramapregunta["tipopregunta"]) ||
                ereg("^2.", $ramapregunta["tipopregunta"]) ||
                ereg("^4.", $ramapregunta["tipopregunta"])) {
            //$this->arreglorespuestausuario[$idpregunta][]
            //$this->totalrespuestausuario[$idusuario][$idpregunta];
            for ($i = 0; $i < count($this->arreglousuario); $i++) {
                //$this->arreglousuario[$i];
                $this->arraypreguntas[$idpregunta] = $ramapregunta["detallepregunta"];

                $this->resultadospreguntas[$this->arreglousuario[$i]][$idpregunta] = $this->totalrespuestausuario[$this->arreglousuario[$i]][$idpregunta];
            }
        }
        if (ereg("^2.", $ramapregunta["tipopregunta"])) {

        }
        if (ereg("^4.", $ramapregunta["tipopregunta"])) {
            
        }
        if (is_array($ramapregunta["grupo"]))
            foreach ($ramapregunta["grupo"] as $llave => $grupo) {

                $this->arregloResultadoPreguntas($ramapregunta["grupo"][$llave], $llave, $idencuesta, $cadenaparametros, $tablasadicionales);
            }
        // $this->resultadospreguntas = $resultadopreguntas;
    }

    function muestraresultadospreguntas($ramapregunta, $idpregunta, $idencuesta, $cadenaparametros, $tablasadicionales) {

        /* echo "$idpregunta,$encuesta ENCUESTA<pre>";
          print_r($encuesta);
          echo "</pre>"; */

//if(in_array($idpregunta,$encuesta)){

        /* echo "tipopregunta=".$ramapregunta["tipopregunta"]." RAMAPREGUNTA<pre>";
          print_r($ramapregunta);
          echo "</pre>"; */
        $valorpregunta = $this->respuestausuariopregunta[$idpregunta];

        unset($this->formulario->filatmp);
        if ($ramapregunta["tipopregunta"] == "101") {
            $this->formulario->dibujar_fila_titulo($ramapregunta["nombre"], 'tdtitulosubgrupoencuesta', "2", "align='left'", "td");
            if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
                $this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        }
        if ($ramapregunta["tipopregunta"] == "100") {
            $this->formulario->dibujar_fila_titulo($ramapregunta["nombre"], 'tdtituloencuesta', "2", "align='center'", "td");
            if (isset($ramapregunta["descripcionpregunta"]) && trim($ramapregunta["descripcionpregunta"]) != '')
                $this->formulario->dibujar_fila_titulo($ramapregunta["descripcionpregunta"], 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        }
        if (ereg("^4.", $ramapregunta["tipopregunta"])) {

        }
        if (ereg("^3.", $ramapregunta["tipopregunta"])) {
            $this->preguntasencuesta[] = $idpregunta;
            /*  $opcionparametrizacion="1";
              $this->formulario->filatmp[$opcionparametrizacion]=$ramapregunta["menornombreopcion"];
              for($i=2;$i<$ramapregunta["numeroopciones"];$i++) {
              $opcionparametrizacion=$i;
              $this->formulario->filatmp[$opcionparametrizacion]="";
              }
              $opcionparametrizacion=$ramapregunta["numeroopciones"];
              $this->formulario->filatmp[$opcionparametrizacion]=$ramapregunta["mayornombreopcion"]; */
            $sumacantidad = 0;
            $funcionRespuestaPregunta = $this->funcionrespuestapregunta;
            $respuestasPregunta = $this->$funcionRespuestaPregunta($idpregunta, $cadenaparametros, $tablasadicionales);
            $tmprespuestasPregunta = $respuestasPregunta;
            if (is_array($respuestasPregunta)) {
                foreach ($tmprespuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                    $sumacantidad+=$arraycantidadpregunta["cuenta"];
                }
                $this->formulario->filatmp[$ramapregunta["menornombreopcion"]] = "";
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
                /*  echo "$idpregunta)filatmp<pre>";
                print_r($this->formulario->filatmp);
                echo "</pre>";*/
                //for($i=1;$i<$ramapregunta["numeroopciones"];$i++) {

                foreach ($respuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                    if ($arraycantidadpregunta["valor" . $this->tablaRespuesta] % 2 == 0) {
                        $porcentaje = ceil(($arraycantidadpregunta["cuenta"] / $sumacantidad) * 100);
                    } else {
                        $porcentaje = floor(($arraycantidadpregunta["cuenta"] / $sumacantidad) * 100);
                    }
                    $agregaporcentaje = "%";
                    if ($this->resultadonumerico) {
                        $porcentaje = $arraycantidadpregunta["cuenta"];
                        $agregaporcentaje = "";
                    }
                    $this->formulario->filatmp[$arraycantidadpregunta["valor" . $this->tablaRespuesta]] = $porcentaje . $agregaporcentaje;
                }
                $this->formulario->filatmp[$ramapregunta["mayornombreopcion"]] = "";
               /* echo "$idpregunta)filatmp<pre>";
                print_r($this->formulario->filatmp);
                echo "</pre>";*/
                //}
            }


            //$opcionparametrizacion=$i;
            //$this->formulario->filatmp[$opcionparametrizacion]="";
            else {
                if (!$this->mensajeYaMostrado)
                    alerta_javascript("No tiene respuestas para este docente");
                $this->mensajeYaMostrado = 1;
            }

            $this->formulario->filatmp["Total"] = $sumacantidad;
            $menu[0] = 'label_fila';
            $parametros[0] = "'" . $idpregunta . "','" . $valorpregunta . "',''";
            $this->contadorpreguntas++;
            $this->formulario->dibujar_camposseparados($menu, $parametros, $this->contadorpreguntas . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, 'requerido', "0");

            $conboton++;
            echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        }
        if (ereg("^2.", $ramapregunta["tipopregunta"])) {
            $this->contadorpreguntas++;
            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'" . $idpregunta . "','pregunta',30,3,'','','',''";
            $boton[$conboton] = 'memo';
            $requerido = "requerido";
            if ($ramapregunta["tipopregunta"] == '201') {
                $requerido = "";
                if ($valorpregunta == '')
                    $valorpregunta = " ";
            }

            //$this->formulario->dibujar_campos($boton,$parametrobotonenviar,$this->contadorpreguntas.") ".$ramapregunta["nombre"],"tdtitulogris",$idpregunta,$requerido,"0");

            $funcionobservacionrespuestas = $this->funcionobservacionrespuestas;
            $respuestasPregunta = $this->$funcionobservacionrespuestas($idpregunta, $cadenaparametros, $tablasadicionales);

            foreach ($respuestasPregunta as $ivalorpergunta => $arraycantidadpregunta) {
                $cadenarespuestas.="<br>-" . $arraycantidadpregunta["valor" . $this->tablaRespuesta];
            }
            //echo $cadenarespuestas;
            // exit();
            //$this->formulario->cambiar_valor_campo($idpregunta,$cadenarespuestas);
            $this->formulario->filatmp["Respuestas"] = $cadenarespuestas;
            $menu[0] = 'label_fila';
            $parametros[0] = "'" . $idpregunta . "','" . $valorpregunta . "',''";
            $this->contadorpreguntas++;
            $this->formulario->dibujar_camposseparados($menu, $parametros, $this->contadorpreguntas . ") " . $ramapregunta["nombre"], "tdtitulogris", $idpregunta, 'requerido', "0");

            echo "<input type='hidden' name='preguntas[]' value='" . $idpregunta . "' />";
        }
        if (is_array($ramapregunta["grupo"]))
            foreach ($ramapregunta["grupo"] as $llave => $grupo) {
                $this->muestraresultadospreguntas($ramapregunta["grupo"][$llave], $llave, $idencuesta, $cadenaparametros, $tablasadicionales);
            }
        //}
    }

    function cantidadRespuestasPregunta($idpregunta, $cadenaparametros, $tablasadicionales) {

        /*   foreach($parametros as $llave=>$valor) {
          $cadenaparametros.=$llave."=".$valor." and";
          } */
        $query = "SELECT ep.idencuesta,ep.idpregunta,
            r.valor" . $this->tablaRespuesta . ",count(distinct r.codigoestudiante) cuenta
            FROM " . $this->tablaRespuesta . " r , encuestapregunta ep, pregunta p

" . $tablasadicionales . "
        where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        r.valor" . $this->tablaRespuesta . " <> '' and
        p.idtipopregunta not in (100,101,201) and
        p.idpregunta='" . $idpregunta . "' and

" . $cadenaparametros . "

        r.codigoestudiante not in (
        SELECT r2.codigoestudiante FROM " . $this->tablaRespuesta . " r2 , encuestapregunta ep2, pregunta p2
        where
        r2.idencuestapregunta=ep2.idencuestapregunta and
        p2.idpregunta=ep2.idpregunta and
        r2.valor" . $this->tablaRespuesta . " = '' and
        p2.idtipopregunta not in (100,101,201) and
        ep2.idencuesta=ep.idencuesta and
        r2.codigoestudiante=r.codigoestudiante
        group by r2.codigoestudiante
        )
        group by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "
        order by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "";

//echo $query;
//exit();
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

    
    function cantidadRespuestasPreguntaGenerica($idpregunta, $cadenaparametros, $tablasadicionales) {

        /*   foreach($parametros as $llave=>$valor) {
          $cadenaparametros.=$llave."=".$valor." and";
          } */
        $query = "SELECT ep.idencuesta,ep.idpregunta,
            r.valor" . $this->tablaRespuesta . ",count(distinct r.numerodocumento) cuenta
            FROM " . $this->tablaRespuesta . " r , encuestapregunta ep, pregunta p

" . $tablasadicionales . "
        where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        r.valor" . $this->tablaRespuesta . " <> '' and
        p.idtipopregunta not in (100,101,201) and
        p.idpregunta='" . $idpregunta . "' and

" . $cadenaparametros . "

        r.numerodocumento not in (
        SELECT r2.numerodocumento FROM " . $this->tablaRespuesta . " r2 , encuestapregunta ep2, pregunta p2
        where
        r2.idencuestapregunta=ep2.idencuestapregunta and
        p2.idpregunta=ep2.idpregunta and
        r2.valor" . $this->tablaRespuesta . " = '' and
        p2.idtipopregunta not in (100,101,201) and
        ep2.idencuesta=ep.idencuesta and
        r2.numerodocumento=r.numerodocumento
        group by r2.numerodocumento
        )
        group by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "
        order by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "";

//echo $query;
//exit();
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

        function cantidadRespuestasPreguntaObligatorias($idpregunta, $cadenaparametros, $tablasadicionales) {

        /*   foreach($parametros as $llave=>$valor) {
          $cadenaparametros.=$llave."=".$valor." and";
          } */
        $query = "SELECT ep.idencuesta,ep.idpregunta,
            r.valor" . $this->tablaRespuesta . ",count(distinct r.numerodocumento) cuenta
            FROM " . $this->tablaRespuesta . " r , encuestapregunta ep, pregunta p

" . $tablasadicionales . "
        where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        r.valor" . $this->tablaRespuesta . " <> '' and
        p.idtipopregunta not in (100,101,201) and
        p.idpregunta='" . $idpregunta . "' and

" . $cadenaparametros . "".

" r.numerodocumento not in (SELECT r2.numerodocumento FROM
" . $this->tablaRespuesta . " r2, encuestapregunta ep2
where r2.valor" . $this->tablaRespuesta . " = ''
and r2.numerodocumento = r.numerodocumento
and ep2.codigoestado like '1%'
and r2.idencuestapregunta=ep2.idencuestapregunta
and r2.idencuestapregunta not in (
select ep3.idencuestapregunta from encuestapregunta ep3, pregunta p3
where 
p3.idpregunta = ep3.idpregunta
and ep3.idencuestapregunta=r2.idencuestapregunta
and p3.estadoobligatoriopregunta='0'
)
  )".
     "   group by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "
        order by ep.idencuesta,ep.idpregunta,r.valor" . $this->tablaRespuesta . "";

//echo $query;
//exit();
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

    
    function observacionRespuestasPregunta($idpregunta, $cadenaparametros, $tablasadicionales) {

        /*   foreach($parametros as $llave=>$valor) {
          $cadenaparametros.=$llave."=".$valor." and";
          } */
        $query = "SELECT ep.idencuesta,ep.idpregunta,
            r.valor" . $this->tablaRespuesta . ",r.codigoestudiante
            FROM " . $this->tablaRespuesta . " r , encuestapregunta ep, pregunta p

" . $tablasadicionales . "
        where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        r.valor" . $this->tablaRespuesta . " <> '' and
        p.idtipopregunta in (201,200) and
        p.idpregunta='" . $idpregunta . "' and

" . $cadenaparametros . "

        r.codigoestudiante not in (
        SELECT r2.codigoestudiante FROM " . $this->tablaRespuesta . " r2 , encuestapregunta ep2, pregunta p2
        where
        r2.idencuestapregunta=ep2.idencuestapregunta and
        p2.idpregunta=ep2.idpregunta and
        r2.valor" . $this->tablaRespuesta . " = '' and
        p2.idtipopregunta not in (100,101,201) and
        ep2.idencuesta=ep.idencuesta and
        r2.codigoestudiante=r.codigoestudiante
        group by r2.numerodocumento
        )
        group by r.id" . $this->tablaRespuesta . "
        order by r.id" . $this->tablaRespuesta . "";

        //  echo $query;
//exit();
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

    function observacionRespuestasPreguntaGenerica($idpregunta, $cadenaparametros, $tablasadicionales) {

        /*   foreach($parametros as $llave=>$valor) {
          $cadenaparametros.=$llave."=".$valor." and";
          } */
        $query = "SELECT ep.idencuesta,ep.idpregunta,
            r.valor" . $this->tablaRespuesta . ",r.numerodocumento
            FROM " . $this->tablaRespuesta . " r , encuestapregunta ep, pregunta p

" . $tablasadicionales . "
        where
        r.idencuestapregunta=ep.idencuestapregunta and
        p.idpregunta=ep.idpregunta and
        r.valor" . $this->tablaRespuesta . " <> '' and
        p.idtipopregunta in (201,200) and
        p.idpregunta='" . $idpregunta . "' and

" . $cadenaparametros . "

        r.numerodocumento not in (
        SELECT r2.numerodocumento FROM " . $this->tablaRespuesta . " r2 , encuestapregunta ep2, pregunta p2
        where
        r2.idencuestapregunta=ep2.idencuestapregunta and
        p2.idpregunta=ep2.idpregunta and
        r2.valor" . $this->tablaRespuesta . " = '' and
        p2.idtipopregunta not in (100,101,201) and
        ep2.idencuesta=ep.idencuesta and
        r2.numerodocumento=r.numerodocumento
        group by r2.numerodocumento
        )
        group by r.id" . $this->tablaRespuesta . "
        order by r.id" . $this->tablaRespuesta . "";

        //  echo $query;
//exit();
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

    function listaEstudiantesEncuesta($periodo, $carrera) {


        $query = "select count(distinct dp2.codigomateria) materiadiligenciado,
            count(distinct dp.codigomateria) totalmaterias,
            e.*,
            eg.*,
            c.*
 from estudiante e, detalleprematricula dp, 
 estudiantegeneral eg,  carrera c,prematricula p


left join  detalleprematricula dp2 on  dp2.idprematricula=p.idprematricula
and dp2.codigoestadodetalleprematricula in (10,30)
and dp2.codigomateria in (select em.codigomateria from encuestamateria em where em.codigomateria=dp.codigomateria) and
dp2.codigomateria not in (
        SELECT r2.codigomateria FROM " . $this->tablaRespuesta . " r2 , encuestapregunta ep2, pregunta p2
        where
        r2.idencuestapregunta=ep2.idencuestapregunta and
        p2.idpregunta=ep2.idpregunta and
        r2.valor" . $this->tablaRespuesta . " = '' and
        p2.idtipopregunta not in (100,101,201) and
        r2.codigoestudiante=e.codigoestudiante and
	r2.codigomateria=dp2.codigomateria
        group by r2.codigoestudiante
        )

and dp2.codigomateria in (
SELECT r3.codigomateria FROM " . $this->tablaRespuesta . " r3
where r3.codigomateria=dp2.codigomateria
and r3.codigoestudiante=e.codigoestudiante
and r3.codigoperiodo='" . $periodo . "'
)
where e.codigoestudiante=p.codigoestudiante
and eg.idestudiantegeneral=e.idestudiantegeneral
and p.codigoperiodo='" . $periodo . "'
and e.codigocarrera='" . $carrera . "'
and p.codigoestadoprematricula in (10,40,41)
and c.codigocarrera=e.codigocarrera

and dp.idprematricula=p.idprematricula
and dp.codigoestadodetalleprematricula in (10,30)
and dp.codigomateria in (select em.codigomateria from encuestamateria em where em.codigomateria=dp.codigomateria) 


group by e.codigoestudiante ";
        $resultado = $this->objetobase->conexion->query($query);
        while ($row = $resultado->fetchRow()) {
            $arrayresultado[] = $row;
        }
        return $arrayresultado;
    }

}
?>