<?php

class MostrarEncuesta {

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

    function MostrarEncuesta($idusuarioencuesta, $objetobase, &$formulario, $consultaencuesta) {

        $this->idusuario = $idusuarioencuesta;
        $this->codigotipousuario = $tipousuario;
        $this->objetobase = $objetobase;
        $this->formulario = $formulario;
        $this->objconsultaencuesta = $consultaencuesta;

        //$this->validaencuesta=new ValidaEncuesta();
    }

    function setIdEncuesta($idencuesta) {
        $this->idencuesta = $idencuesta;
        $this->datosencuesta = $this->objetobase->recuperar_datos_tabla("encuesta", "idencuesta", $this->idencuesta, "", "", 0);
        $this->objconsultaencuesta->setIdEncuesta($idencuesta);
    }

    function setTitulosEncuesta($arraytitulos) {
        $this->arraytitulos = $arraytitulos;
    }

    function getFormulario() {
        return $this->formulario;
    }

    function mostrarTitulosEncuesta() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo("<b><BR>" . $this->datosencuesta["titulo1encuesta"] . "<BR><BR></b>", 'tdtituloencuesta', "2", "align='center'", "td");
        $this->formulario->dibujar_fila_titulo("<b><br>" . $this->datosencuesta["titulo2encuesta"] . "<br><br></b>", "tdtituloencuestadescripcion", "2", "align='left'", "td");
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
        $this->objconsultaencuesta->consultaprimernivelpreguntas();
        $this->arrayencuesta = $this->objconsultaencuesta->recuperarencuesta();
        $this->arraydatosrespuesta = $this->objconsultaencuesta->recuperarrespuestapreguntausuario($this->idusuario);
        $this->arraytitulospestanas = $this->objconsultaencuesta->recuperarpadrepreguntas();
    }

    function iniciarEncuestaTipoUsuario() {
        $this->arrayencuesta = $this->objconsultaencuesta->recuperarencuesta();
        $this->arraydatosrespuesta = $this->objconsultaencuesta->recuperarrespuestapreguntausuario($idusuario);
        $this->arraytitulospestanas = $this->objconsultaencuesta->recuperarpadrepreguntas();
    }

    function ingresarTotalPreguntas($tablaparametro="respuestadetalleencuestapreguntadocente", $filaadicional=array(),$condicionactualizaadicion="") {

        if (!is_array($this->arraydatosrespuesta)) {
            /* echo "preguntasencuesta<pre>";
              print_r($this->objconsultaencuesta->preguntasencuesta);
              echo "</pre>"; */
            foreach ($this->objconsultaencuesta->preguntasencuesta as $llave => $idpregunta) {
                unset($fila);
                $tabla = $tablaparametro;
                if (count($filaadicional) > 0) {
                    $fila = $filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"] = $this->idusuario;
                $fila["valor" . $tabla] = "";
                $fila["codigoestado"] = "100";
                $idencuestapregunta = $this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta, $this->idencuesta);
                $fila["idencuestapregunta"] = $idencuestapregunta;
                $fila["iddetallepregunta"] = '1';

               $condicionactualiza = " idencuestapregunta='" . $idencuestapregunta . "'" .
                $condicionactualizaadicion.
                        " and numerodocumento='" . $this->idusuario . "'";
                 // echo "<pre>";
                $this->objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
                //echo "<pre>";
            }
        }
    }

    function imprimirEncuesta($tituloinicial="") {
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta        
        echo "<table border=\"1\" cellpadding=\"1\" align='center' cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial, 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        echo "</table>";


        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla = 0;

        $contadorpestanas = 0;
        if (is_array($this->objconsultaencuesta->arbolpreguntas))
            foreach ($this->objconsultaencuesta->arbolpreguntas as $idpregunta => $ramapregunta) {
                echo "	<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

                $this->objconsultaencuesta->contadorpreguntas = 0;
                $this->objconsultaencuesta->alfabetopestana = $this->objconsultaencuesta->numeracionpestana[$contadorpestanas];
                $this->objconsultaencuesta->muestraformulariopreguntas($ramapregunta, $idpregunta, $this->idencuesta);

                $this->botonesFormulario();
                $this->formulario = $this->objconsultaencuesta->getFormulario();
                $contadorpestanas++;
                echo "</table>";
                echo "</div>";
            }

        echo "</div>";
    }
        function imprimirResultadosEncuestaV2($tituloinicial="",$cadenaparametros,$tablasadicionales) {
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial,'tdtituloencuestadescripcion',"2","align='left'","td");
        echo "</table>";


        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla=0;
        foreach($this->objconsultaencuesta->arbolpreguntas as $idpregunta=>$ramapregunta) {
            echo "	<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

            $this->objconsultaencuesta->muestraresultadospreguntas($ramapregunta,$idpregunta,$this->idencuesta,$cadenaparametros,$tablasadicionales);
            $this->botonesResultado();
            echo "</table>";
            echo "</div>";
        }

        echo "</div>";


    }

    function imprimirResultadosEncuesta($tituloinicial="", $cadenaparametros, $tablasadicionales) {
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        /* echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
          $this->formulario->dibujar_fila_titulo($tituloinicial, 'tdtituloencuestadescripcion', "2", "align='left'", "td");
          echo "</table>"; */

        $this->objconsultaencuesta->cargarTotalRespuestasUsuario();

        //  echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla = 0;
        foreach ($this->objconsultaencuesta->arbolpreguntas as $idpregunta => $ramapregunta) {
            // echo "	<div class='dhtmlgoodies_aTab'>
            //	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
            //$this->objconsultaencuesta->muestraresultadospreguntas($ramapregunta, $idpregunta, $this->idencuesta, $cadenaparametros, $tablasadicionales);
            $this->objconsultaencuesta->arregloResultadoPreguntas($ramapregunta, $idpregunta, $this->idencuesta, $cadenaparametros, $tablasadicionales);
            //    $this->botonesResultado();
            //    echo "</table>";
            //    echo "</div>";
        }

        //  echo "</div>";

        echo "<h1>resultadospreguntas</h1>";
     /*   echo "<pre>";
        print_r($this->objconsultaencuesta->resultadospreguntas);
        echo "</pre>";*/
        echo "<table border='1'><tr>";
        $i = 0;
        echo "<tr><td>No</td><td>";
        echo "usuario";
        echo "</td>";
        $tmparraypreguntas = $this->objconsultaencuesta->arraypreguntas;
        foreach ($tmparraypreguntas as $idpregunta => $detallepregunta) {
            $cantidaddetalle = count($detallepregunta);
            echo "<td colspan='" . $cantidaddetalle . "'>" . $idpregunta . "</td>";
        }
        echo "</tr>";
        /* echo "arraypreguntas<pre>";
          print_r($this->objconsultaencuesta->arraypreguntas);
          echo "</pre>"; */
        echo "<tr><td> - </td><td> - </td>";
        $tmparraypreguntas = $this->objconsultaencuesta->arraypreguntas;
        foreach ($tmparraypreguntas as $idpregunta => $detallepregunta) {
            if (is_array($detallepregunta)) {
                foreach ($detallepregunta as $iiddetallepregunta => $rowdetallepregunta) {
                    // $cantidaddetalle=count($detallepregunta);
                    echo "<td >" . $rowdetallepregunta["iddetallepregunta"] . "</td>";
                }
            } else {
                echo "<td >1</td>";
            }
        }
        echo "</tr>";

        foreach ($this->objconsultaencuesta->resultadospreguntas as $idusuario => $respuestas) {
            $i++;
            echo "<tr><td>" . $i . "</td><td>";
            echo $idusuario;
            echo "</td>";
            $tmparraypreguntas = $this->objconsultaencuesta->arraypreguntas;
            foreach ($tmparraypreguntas as $idpregunta => $detallepregunta) {
                if (is_array($detallepregunta)) {
                    foreach ($detallepregunta as $iiddetallepregunta => $rowdetallepregunta) {
                        if (isset($respuestas[$idpregunta]["1"])&&
                                $rowdetallepregunta["iddetallepregunta"]==$respuestas[$idpregunta]["1"]) {
                            echo "<td>" . $respuestas[$idpregunta]["1"] . "&nbsp;</td>";
                        } else {
                            echo "<td>" . $respuestas[$idpregunta][$rowdetallepregunta["iddetallepregunta"]] . "&nbsp;</td>";
                        }
                    }
                } else {
                    echo "<td >" . $respuestas[$idpregunta]["1"] . "&nbsp;</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    function resultadosEncuesta($tituloinicial="", $cadenaparametros, $tablasadicionales) {
        //Por favor diligencie todas las pestañas para que pueda finalizar la encuesta
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $this->formulario->dibujar_fila_titulo($tituloinicial, 'tdtituloencuestadescripcion', "2", "align='left'", "td");
        echo "</table>";


        echo "<div id='formularioencuesta'>";
        $this->conpreguntatabla = 0;
        foreach ($this->objconsultaencuesta->arbolpreguntas as $idpregunta => $ramapregunta) {
            echo "	<div class='dhtmlgoodies_aTab'>
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

            $this->objconsultaencuesta->muestraresultadospreguntas($ramapregunta, $idpregunta, $this->idencuesta, $cadenaparametros, $tablasadicionales);
            $this->botonesResultado();
            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
    }

    function botonesFormulario() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $conboton = 0;

        /* $parametrobotonenviar[$conboton]="'submit','Guardar','Guardar',''";
          $boton[$conboton]='boton_tipo';
          $conboton++; */
        $parametrobotonenviar[$conboton] = "'button','Seguir','Seguir','onclick=\'return cambiapestana(" . ($this->conpreguntatabla + 1) . "); \''";
        $boton[$conboton] = 'boton_tipo';

        if ($this->conpreguntatabla >= (count($this->objconsultaencuesta->arbolpreguntas) - 1))
            $parametrobotonenviar[$conboton] = "'submit','Finalizar','Finalizar',''";
        $boton[$conboton] = 'boton_tipo';

        /* $parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
          $boton[$conboton]='boton_tipo'; */
        $this->formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');

        $this->formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>', '', "2", "align='center'", "td");
        $this->conpreguntatabla++;
        echo "</table>";
    }

    function botonesResultado() {
        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $conboton = 0;

        /* $parametrobotonenviar[$conboton]="'submit','Guardar','Guardar',''";
          $boton[$conboton]='boton_tipo';
          $conboton++; */
        $parametrobotonenviar[$conboton] = "'button','Seguir','Seguir','onclick=\'return cambiapestana(" . ($this->conpreguntatabla + 1) . "); \''";
        $boton[$conboton] = 'boton_tipo';

        //if($this->conpreguntatabla>=(count($this->objconsultaencuesta->arbolpreguntas)-1))
        //$parametrobotonenviar[$conboton]="'submit','Finalizar','Finalizar',''";
        // $boton[$conboton]='boton_tipo';

        /* $parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
          $boton[$conboton]='boton_tipo'; */
        $this->formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');

        $this->formulario->dibujar_fila_titulo('<b>Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion</b>', '', "2", "align='center'", "td");
        $this->conpreguntatabla++;
        echo "</table>";
    }

    /*function guardarEncuesta($tablaparametro="respuestadetalleencuestapreguntadocente", $filaadicional=array()) {

      
                 if (isset($_POST["Finalizar"])) {


            foreach ($_POST["preguntas"] as $llave => $idpregunta) {
                //echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
                unset($fila);

                $tabla = $tablaparametro;
                if (count($filaadicional) > 0) {
                    $fila = $filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"] = $this->idusuario;
                $fila["valor" . $tabla] = "" . $_POST[$idpregunta];
                $fila["codigoestado"] = "100";
                $idencuestapregunta = $this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta, $_POST["idencuesta"]);
                $fila["idencuestapregunta"] = $idencuestapregunta;


                $datospregunta = $this->objetobase->recuperar_datos_tabla("pregunta", "idpregunta", $idpregunta, "", "", 0);
                //$tabla="respuestadetalleencuestapreguntadocente";

                if (ereg("^4.", $datospregunta["idtipopregunta"])) {
                    $resultadotabla = $this->objetobase->recuperar_resultado_tabla("detallepregunta", "idpregunta", $idpregunta, "", "", 0);
                    while ($rowdetallepregunta = $resultadotabla->fetchRow()) {
                        if ((isset($_POST["a" . $rowdetallepregunta["iddetallepregunta"]]) &&
                                ($_POST["a" . $rowdetallepregunta["iddetallepregunta"]] != '')) ||
                                (isset($_POST["d" . $rowdetallepregunta["iddetallepregunta"]]) &&
                                ($_POST["d" . $rowdetallepregunta["iddetallepregunta"]] != ''))) {
                          
                            $fila["iddetallepregunta"] = $rowdetallepregunta["iddetallepregunta"];
                            if ($rowdetallepregunta["idtipodetallepregunta"] == '4') {
                                $fila["valor" . $tabla] = "" . $_POST["a" . $rowdetallepregunta["iddetallepregunta"]];
                            } else {
                                $fila["valor" . $tabla] = "" . $_POST["d" . $rowdetallepregunta["iddetallepregunta"]];
                            }
                            //echo "<br>valor" . $tabla."==".$fila["valor" . $tabla]."POST a=".$_POST["a" . $rowdetallepregunta["iddetallepregunta"]].
                            //" POST d=".$_POST["a" . $rowdetallepregunta["iddetallepregunta"]];
                            $fila["idencuestapregunta"] = $idencuestapregunta;
                            $condicionactualiza = " idencuestapregunta=" . $idencuestapregunta .
                                    " and numerodocumento='" . $this->idusuario . "'" .
                                    " and iddetallepregunta='" . $rowdetallepregunta["iddetallepregunta"] . "'";
                            echo "ENTRO?<pre>";
                            $this->objetobase->insertar_fila_bd($tabla, $fila, 1, $condicionactualiza);
                            echo "</pre>";
                        }
                    }
                } else {

                    $fila["iddetallepregunta"] = '1';
                    $condicionactualiza = " idencuestapregunta=" . $idencuestapregunta .
                            " and numerodocumento='" . $this->idusuario . "'";
                   // echo "<pre>";
                    $this->objetobase->insertar_fila_bd($tabla, $fila, 1, $condicionactualiza);
                    //echo "</pre>";
                }
                //echo "</pre>";
            }
        }
    }*/
    
   /* function guardarEncuesta($mensajeexito,$mensajefalta,$direccionexito,$direccionfalta,$tablaparametro="respuestadetalleencuestapreguntadocente",$filaadicional=array()) {

        if(isset($_POST["Finalizar"])) {


            foreach($_POST["preguntas"] as $llave=>$idpregunta) {
                //echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
                unset($fila);

                //$tabla="respuestadetalleencuestapreguntadocente";
                $tabla=$tablaparametro;
                if(count($filaadicional)>1) {
                    $fila=$filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"]=$this->idusuario;
                $fila["valor".$tabla]="".$_POST[$idpregunta];
                $fila["codigoestado"]="100";
                $idencuestapregunta=$this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta,$_POST["idencuesta"]);
                $fila["idencuestapregunta"]=$idencuestapregunta;


                $condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
                        " and numerodocumento='".$this->idusuario."'";
                //echo "<pre>";
                $this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
                //echo "</pre>";
            }
            $this->formulario=$this->objconsultaencuesta->recuperaobjetoformulario();
            
            $validacion=$this->formulario->valida_formulario();
            if($validacion==false) {
                //"No puede continuar hasta que diligencie toda la encuesta "
                alerta_javascript($mensajefalta);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionfalta."'>";

            }
            else {
                //"Gracias por su colaboración, sus respuestas son utiles para el mejoramiento de nuestra Institución .\\n Puede continuar"
                alerta_javascript($mensajeexito);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionexito."'>";
            }

        }

    }*/
     function guardarEncuesta($mensajeexito,$mensajefalta,$direccionexito,$direccionfalta,$tablaparametro="respuestadetalleencuestapreguntadocente",$filaadicional=array()) {



/*echo"fdsf<pre>";
print_r( $filaadicional);
echo"</pre>";
exit();*/
if(isset($_POST["Finalizar"])) {


            foreach($_POST["preguntas"] as $llave=>$idpregunta) {
                //echo "<br>".$llave."=>".$idpregunta." =>".$_POST[$idpregunta];
                unset($fila);

                //$tabla="respuestadetalleencuestapreguntadocente";
                $tabla=$tablaparametro;
                if(count($filaadicional)>1) {
                    $fila=$filaadicional;
                }
                //$fila["idpregunta"]=$idpregunta;
                $fila["numerodocumento"]=$this->idusuario;
                $fila["valor".$tabla]="".$_POST[$idpregunta];
                $fila["codigoestado"]="100";
                $idencuestapregunta=$this->objconsultaencuesta->recuperaidencuestapregunta($idpregunta,$_POST["idencuesta"]);
                $fila["idencuestapregunta"]=$idencuestapregunta;


                $condicionactualiza=" idencuestapregunta=".$idencuestapregunta.
                        " and codigomateria=".$filaadicional['codigomateria'].
                        " and numerodocumento='".$this->idusuario."'";
                
                $this->objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
              
            
           }
           
            $this->formulario=$this->objconsultaencuesta->recuperaobjetoformulario();
            
            $validacion=$this->formulario->valida_formulario();
            
            if($validacion==false) {
				//echo "<h1>entro</h1>";
            
                //"No puede continuar hasta que diligencie toda la encuesta "
                alerta_javascript($mensajefalta);
                //exit();
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionfalta."'>";

            }
            
            if($validacion==true) {
				/*echo $direccionexito;
            exit();*/
                //"No puede continuar hasta que diligencie toda la encuesta "
                alerta_javascript($mensajeexito);
               // exit();
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$direccionexito."'>";
            }
            
            

        }

    }

}
?>
