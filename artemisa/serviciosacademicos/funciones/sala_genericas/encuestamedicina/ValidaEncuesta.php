<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ValidaEncuesta {

    var $objetobase;
    var $codigoperiodo;
    var $codigoestudiante;
    var $idasistente;
    var $tablarespuesta;
    var $idusuario;
    var $idencuesta;
    var $condicionadicional;
    var $tablaadicional;

    function ValidaEncuesta($objetobase, $codigoperiodo, $codigoestudiante) {
        $this->objetobase = $objetobase;
        $this->codigoperiodo = $codigoperiodo;
        $this->codigoestudiante = $codigoestudiante;
    }

    function setidasistente($idasistente) {
        $this->idasistente = $idasistente;
    }

    function setTablaRespuesta($tablarespuesta) {
        $this->tablarespuesta = $tablarespuesta;
    }

    function setIdEncuesta($idencuesta) {
        $this->idencuesta = $idencuesta;
    }

    function setUsuario($idusuario) {
        $this->idusuario = $idusuario;
    }

     function setCondicionAdicional($condicion) {
        $this->condicionadicional=$condicion;
    }
    function setTablaAdicional($tabla) {
        $this->tablaadicional=$tabla;
    }
    function encuestaCarreraActiva() {
        $condicion = " and ec.codigocarrera=e.codigocarrera"
                . " and now() between fechainicioencuesta and fechafinalencuesta"
                . " and e.codigoestudiante='" . $this->codigoestudiante . "'";
        if ($datosencuesta = $this->objetobase->recuperar_datos_tabla("encuesta ec , estudiante e", "1", "1", $condicion, "", 0)) {
            return 1;
        }
        return 0;
    }

    //Hacer el nuevo query para validar
    function validaEncuestaCompleta() {
		$query = "SELECT codigoperiodo from periodo where codigoestadoperiodo in (3,1) ORDER BY codigoestadoperiodo DESC";
		$resultado=$this->objetobase->conexion->query($query);
		$rowperiodo=$resultado->fetchRow();
		
      $query="select *,if(h.horainicial>='18:00','Nocturna','Diurna') jornada
            from prematricula p,detalleprematricula dp,
	materia m,docente d,grupo g
	left join horario h on h.idgrupo=g.idgrupo
	left join dia di on di.codigodia=h.codigodia
	where
	p.idprematricula=dp.idprematricula and
	dp.codigomateria=m.codigomateria and
	p.codigoestadoprematricula like '4%' and
	dp.codigoestadodetalleprematricula like '3%' and
	g.idgrupo=dp.idgrupo and
	g.numerodocumento=d.numerodocumento and
	p.codigoperiodo='".$rowperiodo["codigoperiodo"]."' and
	p.codigoestudiante=".$this->codigoestudiante." and
        m.codigomateria in (select codigomateria from encuestamateria em , encuesta e
        where em.idencuesta=e.idencuesta
        and now() between e.fechainicioencuesta and e.fechafinalencuesta and e.idencuesta in (69))
	group by m.codigomateria";
        $resultado=$this->objetobase->conexion->query($query);
        
        $formulario->filatmp[""]="Seleccionar";
        while($rowmateria=$resultado->fetchRow()) {
		
		 $query=" select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='".$rowperiodo["codigoperiodo"]."'
                                 and r.valorrespuestaautoevaluacion <> ''
				and r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'
having cuenta = (
select count(distinct r.idrespuestaautoevaluacion) cuenta from respuestaautoevaluacion r,
                                encuestapregunta ep,pregunta p where
                                r.idencuestapregunta=ep.idencuestapregunta and
                                p.idpregunta=ep.idpregunta and
                                p.codigoestado like '1%' and
                                ep.codigoestado like '1%' and
                                p.idtipopregunta not in (100,101,201) and
				r.codigoestudiante=".$this->codigoestudiante." and
				r.codigoperiodo='".$rowperiodo["codigoperiodo"]."' and
r.codigomateria='".$rowmateria["codigomateria"]."'
				 and r.codigoestado like '1%'

)";

            $resultadorespuesta = $this->objetobase->conexion->query($query);
            $registros = $resultadorespuesta->fetchRow();

            if (!($registros["cuenta"] > 0)) {
                return 0;
            }
        }
        return 1;
    }

    //funcion para la encuesta de los certificados
    function validaEncuestaEducontinuada() {

        $query = "select count(distinct r.idrespuestaeducacioncontinuada) cuenta
                    from respuestaeducacioncontinuada r,
                    encuestapregunta ep,pregunta p 
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
		    r.numerodocumento=" . $this->idasistente . "
                    and r.valorrespuestaeducacioncontinuada <> ''				
		    and r.codigoestado like '1%'
                    having cuenta = (
                    select count(distinct r.idrespuestaeducacioncontinuada) cuenta 
                    from respuestaeducacioncontinuada r,
                    encuestapregunta ep,pregunta p 
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
	            r.numerodocumento=" . $this->idasistente . "
		    and r.codigoestado like '1%')";

        $resultadorespuesta = $this->objetobase->conexion->query($query);
        $registros = $resultadorespuesta->fetchRow();

        if (!($registros["cuenta"] > 0)) {
            return 0;
        }

        return 1;
    }

    /*
     * Hace validacion necesaria para encuesta  bienestar
     */

    function validaEncuestaBienestar() {

        echo $query = "select count(distinct r.id" . $this->tablarespuesta . ") cuenta
                    from " . $this->tablarespuesta . " r,
                    encuestapregunta ep,pregunta p
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
		    r.numerodocumento=" . $this->idusuario . "
                    and r.valor" . $this->tablarespuesta . " <> ''
		    and r.codigoestado like '1%'
                    having cuenta = (
                    select count(distinct r.id" . $this->tablarespuesta . ") cuenta
                    from " . $this->tablarespuesta . " r,
                    encuestapregunta ep,pregunta p
                    where r.idencuestapregunta=ep.idencuestapregunta and
                    p.idpregunta=ep.idpregunta and
                    p.codigoestado like '1%' and
                    ep.codigoestado like '1%' and
                    p.idtipopregunta not in (100,101,201) and
	            r.numerodocumento=" . $this->idusuario . "
		    and r.codigoestado like '1%')";

        $resultadorespuesta = $this->objetobase->conexion->query($query);
        $registros = $resultadorespuesta->fetchRow();

        if (!($registros["cuenta"] > 0)) {
            return 0;
        }
        return 1;
    }

    /*
     * Encuentra en tabla temporal el estudiante correspondiente al usuario y retorna falso o verdadero
     */

    function encuentraEstudianteEncuestaBienestar($idusuario) {
        if ($datosestudiantebienestar = $this->objetobase->recuperar_datos_tabla("tmpestudianteencuestabienestar", "idestudiantegeneral", $idusuario, "", "", 0)) {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     * Retorna Array con preguntas de la encuesta
     */

    function preguntasEncuesta() {
        $tabla = "pregunta p, encuestapregunta ep ".$this->tablaadicional;
        $nombreidtabla = "ep.idencuesta";
        $idtabla = $this->idencuesta;
        $condicion = " and p.idpregunta=ep.idpregunta ".$this->condicionadicional;
        $resultadopregunta = $this->objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        while ($row = $resultadopregunta->fetchRow()) {
            $datospreguntas[$row['idpregunta']] = $row;
        }
        return $datospreguntas;
    }

    /*
     * Encuentra si la pregunta enviada por parametro fue respondida
     */

    function respondePregunta($idpregunta) {
        $tabla = $this->tablarespuesta . " r, encuestapregunta ep";
        $nombreidtabla = "ep.idencuesta";
        $idtabla = $this->idencuesta;
        $condicion = " and r.idencuestapregunta=ep.idencuestapregunta " .
                " and ep.idpregunta='" . $idpregunta . "'" .
                " and r.numerodocumento='" . $this->idusuario ."'".
                " and r.codigoestado like '1%'";
        $datosrespuestapregunta = $this->objetobase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion, "", 0);
        return $datosrespuestapregunta;
    }

    function validaPreguntasFaltantes() {
        $datospregunta = $this->preguntasEncuesta();
        $tmpdatospregunta = $datospregunta;
        /*echo "SALE ALGO?<pre>";
        print_r($datospregunta);
        echo "</pre>";
       // EXIT();*/
        foreach ($tmpdatospregunta as $idpregunta => $filapregunta) {
            //echo "<br>";
            $datosrespuestapregunta = $this->respondePregunta($idpregunta);
            
           //echo "<br>";
            $datosrespuestapreguntagrupo = $this->respondePregunta($filapregunta['idpreguntagrupo']);
            //echo "<br>datosrespuestapreguntagrupo[valor". $this->tablarespuesta."]";
            if ($datosrespuestapreguntagrupo["valor" . $this->tablarespuesta] == $filapregunta['valordependenciapregunta']) {
                $filapregunta['estadoobligatoriopregunta'] = '1';
            }
            if ($filapregunta['estadoobligatoriopregunta']) {
                if ((trim($datosrespuestapregunta["valor" . $this->tablarespuesta]) == '' ||
                        !isset($datosrespuestapregunta["valor" . $this->tablarespuesta])) &&
                        !in_array($filapregunta['idtipopregunta'], array("100", "101", "201"))) {
                    $preguntasfaltantes[$idpregunta] = $filapregunta;
                }
            }


            //echo "<br>$idpregunta)<b>".$datosrespuestapreguntagrupo["valor" . $this->tablarespuesta]." != ".$filapregunta['valordependenciapregunta']."</b>";
        }
        return $preguntasfaltantes;
    }

    function mensajeValidaEncuesta($mensajeexito, $mensajefalta, $direccionexito, $direccionfalta, &$formulario) {
        if (isset($_POST["Finalizar"])) {
            $preguntasfaltantes = $this->validaPreguntasFaltantes();
global $formulario;
           /* echo "otravezpreguntasfaltantes<pre>";
            print_r($preguntasfaltantes);
            echo "</pre>";*/
            $validacion = 0;
            $cadenamensaje = "Es requerido diligenciar: \\n";
            foreach ($preguntasfaltantes as $idpregunta => $filapregunta) {
              /*  echo "otravezpreguntasfaltantes<pre>";
                print_r($formulario->array_validacion);
                echo "</pre>";*/
                for ($i = 0; $i < count($formulario->array_validacion); $i++) {
                   // echo "<br>" . $formulario->array_validacion[$i]['campo'] . " == " . "h" . $idpregunta;
                    if ($formulario->array_validacion[$i]['campo'] == "h" . $idpregunta ||
                            $formulario->array_validacion[$i]['campo'] == $idpregunta) {
                        $cadenamensaje.=$formulario->array_validacion[$i]['mensaje'] . " \\n";
                        //echo $cadenamensaje;
                        $validacion = 1;
                    }
                }
            }
            // $validacion = $formulario->valida_formulario();
            if ($validacion) {
                //"No puede continuar hasta que diligencie toda la encuesta "
                $cadenamensaje=str_replace("\n", "", $cadenamensaje);

                alerta_javascript($mensajefalta);
                 $cadenamensaje=str_replace("<br>","",$cadenamensaje);
                alerta_javascript($cadenamensaje);
                //echo "Mensaje falta $cadenamensaje";
             //   exit();
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $direccionfalta . "'>";
            } else {
                //"Gracias por su colaboración, sus respuestas son utiles para el mejoramiento de nuestra Institución .\\n Puede continuar"
                alerta_javascript($mensajeexito);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $direccionexito . "'>";
            }
        }
    }

}
?>
