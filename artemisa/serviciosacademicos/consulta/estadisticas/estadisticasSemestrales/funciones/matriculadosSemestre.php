<?php

class matriculadosSemestre extends obtener_datos_matriculas {

    var $codigoperiodo;
    var $conexion;
    var $fechahoy;
    var $arrayCarreras;
    var $arrayMatriculados;
    var $arraySemestres;
    var $codigocarrera;

    function matriculadosSemestre($codigoperiodo, $codigocarrera, $codigomodalidadacademica, $informe='cabecera', &$conexion) {
        $this->conexion = $conexion;
        $this->codigoperiodo = $codigoperiodo;
        $this->fechahoy = date("Y-m-d H:i:s");
        if ($informe == 'cabecera') {
            $this->creaArraySemestre();
            $this->arrayCarreras = $this->leerCarreras($codigomodalidadacademica, $codigocarrera);
            obtener_datos_matriculas::obtener_datos_matriculas($this->conexion, $this->codigoperiodo);
            $this->arrayMatriculados = $this->leerTotalMatriculados();
        } elseif ($informe == 'prematricula') {
            $this->creaArraySemestre();
            $this->arrayCarreras = $this->leerCarreras($codigomodalidadacademica, $codigocarrera);
            obtener_datos_matriculas::obtener_datos_matriculas($this->conexion, $this->codigoperiodo);
            $this->arrayMatriculados = $this->leerTotalPrematriculados();
           /* echo "<pre>prematricula";
            print_r($this->arrayMatriculados);
            echo "<pre>";*/
        } elseif ($informe == 'noprematricula') {
            $this->creaArraySemestre();
            $this->arrayCarreras = $this->leerCarreras($codigomodalidadacademica, $codigocarrera);
            obtener_datos_matriculas::obtener_datos_matriculas($this->conexion, $this->codigoperiodo);
            $this->arrayMatriculados = $this->leerTotalNoPrematriculados();
           /* echo "<pre>noprematricula";
            print_r($this->arrayMatriculados);
            echo "<pre>";*/
        } elseif ($informe == 'detalle') {
            $this->codigocarrera = $codigocarrera;
        }
    }

    function leerCarreras($codigomodalidadacademica="", $codigocarrera="") {
        if ($codigomodalidadacademica == "todos" and $codigocarrera == "todos") {
            $query_obtener_carreras = "SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.fechainiciocarrera <= '" . $this->fechahoy . "' and c.fechavencimientocarrera >= '" . $this->fechahoy . "'
			ORDER BY c.codigocarrera
			";
        } elseif ($codigomodalidadacademica == "todos" and $codigocarrera <> "todos") {
            $query_obtener_carreras = "SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='" . $codigocarrera . "'
			AND c.fechainiciocarrera <= '" . $this->fechahoy . "' and c.fechavencimientocarrera >= '" . $this->fechahoy . "'
			ORDER BY c.codigocarrera
			";
        } elseif ($codigomodalidadacademica <> "todos" and $codigocarrera == "todos") {
            $query_obtener_carreras = "SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigomodalidadacademica='$codigomodalidadacademica'
			AND c.fechainiciocarrera <= '" . $this->fechahoy . "' and c.fechavencimientocarrera >= '" . $this->fechahoy . "'
			ORDER BY c.codigocarrera
			";
        } elseif ($codigomodalidadacademica <> "todos" and $codigocarrera <> "todos") {
            $query_obtener_carreras = "SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='$codigocarrera'
			AND c.fechainiciocarrera <= '" . $this->fechahoy . "' and c.fechavencimientocarrera >= '" . $this->fechahoy . "'
			ORDER BY c.codigocarrera
			";
        }
        $obtener_carreras = $this->conexion->query($query_obtener_carreras);
        $row_obtener_carreras = $obtener_carreras->fetchRow();
        do {
            $array_obtener_carreras[$row_obtener_carreras['codigocarrera']] = $row_obtener_carreras;
        } while ($row_obtener_carreras = $obtener_carreras->fetchRow());
        return $array_obtener_carreras;
    }

    function leerTotalMatriculados() {
        foreach ($this->arrayCarreras as $llave_c => $valor_c) {
            $arrayInterno[$llave_c] = $this->obtener_total_matriculados($llave_c, 'arreglo');
            foreach ($arrayInterno[$llave_c] as $llave_i => $valor_i) {
                $arrayDatos[$llave_c][$valor_i['codigoestudiante']] = $this->obtenerSemestreEstudiante($valor_i['codigoestudiante']);
                //echo memory_get_usage(),"<br>";
            }
        }
        return $arrayDatos;
    }

    function leerTotalNoPrematriculados() {
        foreach ($this->arrayCarreras as $llave_c => $valor_c) {
            //$arrayInterno[$llave_c]=$this->obtener_total_matriculados($llave_c,'arreglo');
            $arrayInterno[$llave_c] = $this->obtener_datos_estudiantes_noprematriculados($llave_c, 'arreglo');
            foreach ($arrayInterno[$llave_c] as $llave_i => $valor_i) {
                //echo "Entro1<br>";
                $arrayDatos[$llave_c][$valor_i['codigoestudiante']] = $this->obtenerSemestreActualEstudiante($valor_i['codigoestudiante']);

                //echo memory_get_usage(),"<br>";
            }
        }
        return $arrayDatos;
    }

    function leerTotalPrematriculados() {
        foreach ($this->arrayCarreras as $llave_c => $valor_c) {
            //$arrayInterno[$llave_c]=$this->obtener_total_matriculados($llave_c,'arreglo');
            $arrayInterno[$llave_c] = $this->obtener_datos_cuentaoperacionprincipal_ordenesnopagas($_SESSION['codigoperiodoinforme'], $llave_c, 151, 'arreglo');
            foreach ($arrayInterno[$llave_c] as $llave_i => $valor_i) {
                $arrayDatos[$llave_c][$valor_i['codigoestudiante']] = $this->obtenerSemestreEstudiante($valor_i['codigoestudiante']);
                //echo memory_get_usage(),"<br>";
            }
        }
        return $arrayDatos;
    }

    function leerTotalMatriculadosDetalle($semestre) {
        $arrayInterno[$this->codigocarrera] = $this->obtener_total_matriculados($this->codigocarrera, 'arreglo');
        foreach ($arrayInterno[$this->codigocarrera] as $llave_i => $valor_i) {
            $arrayDatos[$llave_c][$valor_i['codigoestudiante']] = $this->obtenerSemestreEstudiante($valor_i['codigoestudiante']);
            //echo memory_get_usage(),"<br>";
        }
        foreach ($arrayDatos as $llave => $valor) {
            foreach ($valor as $llavev => $valorv) {
                if ($semestre == $valorv) {
                    $arrayDatosEst[] = $this->obtener_datos_estudiante($llavev);
                }
            }
        }
        return $arrayDatosEst;
    }

    function obtenerSemestreActualEstudiante($codigoestudiante) {
       $periodoanterior = encontrarPeriodoAnterior($this->codigoperiodo);
       $query = "SELECT pr.semestreprematricula FROM estudiante e,prematricula pr
		WHERE
		e.codigoestudiante=pr.codigoestudiante
		AND pr.codigoperiodo='$periodoanterior'
		AND e.codigoestudiante='$codigoestudiante'
                ";
       
        $operacion = $this->conexion->query($query);
        
        $row_operacion = $operacion->fetchRow();
        
        return $row_operacion['semestreprematricula'];
    }

    function creaArrayInformeCabecera() {
        for ($i = 1; $i <= 12; $i++) {
            foreach ($this->arrayMatriculados as $llave_m => $valor) {
                foreach ($valor as $valorInt) {
                    if ($i == $valorInt) {
                        $arrayInterno[] = $valor;
                    }
                }
                $arrayInforme[] = array('semestre' => $i, 'codigocarrera' => $llave_m, 'nombrecarrera' => $this->arrayCarreras[$llave_m]['nombrecarrera'], 'cantidad' => count($arrayInterno));
                unset($arrayInterno);
            }
        }
        return $arrayInforme;
    }

    function creaArrayInformeCabecera2() {
        $cont = 0;
        foreach ($this->arrayMatriculados as $llave_m => $valor) {
            $arrayExterno[$cont]['codigocarrera'] = $this->arrayCarreras[$llave_m]['codigocarrera'];
            $arrayExterno[$cont]['nombrecarrera'] = $this->arrayCarreras[$llave_m]['nombrecarrera'];
            for ($i = 1; $i <= 12; $i++) {
                foreach ($valor as $llave_d => $valor_d) {
                    if ($valor_d == $i) {
                        $arr[] = $valor;
                    }
                }
                $arrayExterno[$cont]['semestre' . $i] = count($arr);
                unset($arr);
            }
            $cont++;
        }

        return $arrayExterno;
    }

    function creaArraySemestre() {
        for ($i = 1; $i <= 12; $i++) {
            $this->arraySemestres[$i] = 0;
        }
    }

    function retornaArrayMatriculados() {
        return $this->arrayMatriculados;
    }

}
?>