<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class TablasAdmisiones {

    var $conexion;
    var $codigoperiodo;
    var $debug;
    var $fechahoy;

    function TablasAdmisiones($conexion, $debug=false) {
        $this->conexion = $conexion;
        $this->debug = $debug;
        $this->fechahoy = date("Y-m-d H:i:s");
    }

    /**
     * Manes que hayan pagado cuentaoperacionprincipal 153, que se hayan inscrito para el periodo y la carrera seleccionada, y que no estén metidos ya en la tabla estudianteadmision
     *
     * @param unknown_type $codigocarrera
     * @param unknown_type $codigoperiodo
     * @param unknown_type $cuentaoperacionprincipal
     * @param unknown_type $codigosituacioncarreraestudiante
     * @return unknown
     */
    function ObtenerEstudiantesInscritosOrdenPagada($codigocarrera, $codigoperiodo, $idsubperiodo, $cuentaoperacionprincipal=153) {
        $query = "SELECT e.codigoestudiante,
		i.idinscripcion,
		e.idestudiantegeneral,
		i.codigoperiodo,
		eci.codigocarrera
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, inscripcion i, estudiantecarrerainscripcion eci
		WHERE o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral=i.idestudiantegeneral
		AND i.idinscripcion=eci.idinscripcion
		AND i.codigoperiodo='$codigoperiodo'
		AND eci.codigocarrera='$codigocarrera'
		AND e.codigoestudiante NOT IN
		(SELECT e.codigoestudiante FROM estudiante e, estudianteadmision ea, admision a
		WHERE e.codigoestudiante = ea.codigoestudiante
		AND ea.idadmision = a.idadmision
		AND a.idsubperiodo = '$idsubperiodo'
		AND a.codigoestado=100
		AND ea.codigoestado=100
		)";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['codigoestudiante'] <> "") {
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Estudiantes que pagaron derechos inscripción, que todavía  no tienen salones asignados");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function ObtenerEstudiantesInscritosOrdenPagadaIncluyeInscritosSinPago($codigocarrera, $codigoperiodo, $idsubperiodo, $cuentaoperacionprincipal=153) {
		/*
		 * @modified David Perez <perezdavid@unbosque.edu.co>
		 * @since  Octubre 23, 2018
		 * Se añade en el segundo union el condicional de que el registro de estudiante tenga tambien codigoperiodo debido a que estaba tomando registros
		 * duplicados por un problema que se presentó en el formulario de inscripciones.
		*/
                
        $query = "SELECT e.codigoestudiante,
		i.idinscripcion,
		e.idestudiantegeneral,
		i.codigoperiodo,
		eci.codigocarrera,
		lr.LugarRotacionCarreraID
		FROM ordenpago o
		INNER JOIN detalleordenpago d ON o.numeroordenpago=d.numeroordenpago
		INNER JOIN estudiante e ON e.codigoestudiante=o.codigoestudiante
		INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
		INNER JOIN concepto co ON d.codigoconcepto=co.codigoconcepto
		INNER JOIN inscripcion i ON e.idestudiantegeneral=i.idestudiantegeneral
		INNER JOIN estudiantecarrerainscripcion eci ON i.idinscripcion=eci.idinscripcion
		LEFT JOIN LugarRotacionCarreraEstudiante lr ON lr.codigoestudiante=e.codigoestudiante and lr.codigoestado=100 
		WHERE  co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera' 
		AND i.codigoperiodo='$codigoperiodo'
		AND eci.codigocarrera='$codigocarrera'
               and eci.idnumeroopcion='1'
		AND e.codigoestudiante NOT IN
		(SELECT e.codigoestudiante FROM estudiante e, estudianteadmision ea, admision a
		WHERE e.codigoestudiante = ea.codigoestudiante
		AND ea.idadmision = a.idadmision
		AND a.idsubperiodo = '$idsubperiodo'
		AND a.codigoestado=100
		AND ea.codigoestado=100
		)
		UNION
		SELECT e.codigoestudiante,
		i.idinscripcion,
		e.idestudiantegeneral,
		i.codigoperiodo,
		eci.codigocarrera,
		lr.LugarRotacionCarreraID
		FROM
		estudiante e 
		INNER JOIN inscripcion i ON e.idestudiantegeneral=i.idestudiantegeneral
		INNER JOIN estudiantecarrerainscripcion eci ON i.idinscripcion=eci.idinscripcion
		LEFT JOIN LugarRotacionCarreraEstudiante lr ON lr.codigoestudiante=e.codigoestudiante and lr.codigoestado=100 
		WHERE
		 i.codigosituacioncarreraestudiante = '111'
		AND eci.codigocarrera='$codigocarrera'
		AND i.codigoperiodo = '$codigoperiodo'
		AND e.codigocarrera = '$codigocarrera'
		AND e.codigoperiodo = '$codigoperiodo'
            and eci.idnumeroopcion='1'
		AND e.codigoestudiante NOT IN
		(SELECT e.codigoestudiante FROM estudiante e, estudianteadmision ea, admision a
		WHERE e.codigoestudiante = ea.codigoestudiante
		AND ea.idadmision = a.idadmision
		AND a.idsubperiodo = '$idsubperiodo'
		AND a.codigoestado=100
		AND ea.codigoestado=100
		)
		";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['codigoestudiante'] <> "") {
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Estudiantes que pagaron derechos inscripción, que todavía  no tienen salones asignados");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function ObtenerSalonesdelaAdmision($codigocarrera, $idsubperiodo) {
//LOCATE(' ',hdsa.fechainiciohorariodetallesitioadmision)
         $query =
                "SELECT
		a.idadmision, s.codigosalon, s.cupomaximosalon, hdsa.idhorariodetallesitioadmision, 
		CONCAT(SUBSTRING(hdsa.fechainiciohorariodetallesitioadmision,1,LOCATE(' ',hdsa.fechainiciohorariodetallesitioadmision)),
		' (', hdsa.horainicialhorariodetallesitioadmision,' - ',hdsa.horafinalhorariodetallesitioadmision,')') horario,
		lugarRotacionBase as rotacion,
		lr.LugarRotacionCarreraID as rotacionID
		FROM
		admision a
		INNER JOIN detallesitioadmision dsa on a.idadmision=dsa.idadmision
		INNER JOIN salon s ON dsa.codigosalon=s.codigosalon 
		INNER JOIN horariodetallesitioadmision hdsa ON dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
                LEFT JOIN LugarRotacionCarrera lr on lr.LugarRotacionCarreraID = dsa.LugarRotacionCarreraID
		WHERE
		a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigoestado=100
		AND hdsa.codigoestado=100
		AND dsa.codigoestado=100";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['codigosalon'] <> "") {
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Datos de los salones para la inscripción");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function DeterminarSalonesConCupo($array_salones, $codigocarrera, $idsubperiodo) {
        foreach ($array_salones as $llave => $valor) {
            $query = "
			SELECT COUNT(distinct ea.idestudianteadmision) as cantidad
			FROM
			admision a
			INNER JOIN detallesitioadmision dsa ON a.idadmision=dsa.idadmision
			INNER JOIN horariodetallesitioadmision hdsa ON dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
			INNER JOIN estudianteadmision ea ON a.idadmision=ea.idadmision
			INNER JOIN detalleestudianteadmision dea ON ea.idestudianteadmision=dea.idestudianteadmision 
			AND dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
			WHERE
			a.codigocarrera='$codigocarrera'
			AND a.idsubperiodo='$idsubperiodo'
			AND dsa.codigosalon='" . $valor['codigosalon'] . "'
			AND a.codigoestado=100
			AND ea.codigoestado=100
			AND dea.codigoestado=100
			AND hdsa.codigoestado=100
			AND dsa.codigoestado=100
			";
			
            if ($this->debug == true) {
                $this->conexion->debug = true;
            }
            $operacion = $this->conexion->query($query);
            $row_operacion = $operacion->fetchRow();
            do {
                //echo "cupo maximo salon: ".$valor['cupomaximosalon']," Cupo usado: ",$row_operacion['cantidad'],"<br>";
                $disponibles = $valor['cupomaximosalon'] - $row_operacion['cantidad'];
                if ($disponibles >= 1) {
                    $array_interno[] = array('codigosalon' => $valor['codigosalon'], 
					'disponibles' => $disponibles, 'idhorariodetallesitioadmision' => $valor['idhorariodetallesitioadmision'], 
					'Horario' => $valor['horario'],'RotacionID' => $valor['rotacionID']);
                }
            } while ($row_operacion = $operacion->fetchRow());
        }
        if ($this->debug == true) {
            echo "idsubperiodo $idsubperiodo<br>";
            $this->DibujarTabla($array_interno, "Salones con cupo disponible");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function AsignarSalonesConCupo($array_codigoestudiante, $array_salones_con_cupo) {
        $ContadorInicioSiguienteMechudo = 0;
        $PunteroRecorreArray = 0;
        $ini_bucle = 0;
        foreach ($array_salones_con_cupo as $llave_salones => $valor_salones) {
            $CantidadDisponibleMechudosParaAsignar = $valor_salones['disponibles'];
            $MaximoPunteroRecorreArray = $ini_bucle + $CantidadDisponibleMechudosParaAsignar;
			$total_estudiantes = count($array_codigoestudiante);
			$i = 0;
			//var_dump($valor_salones); die;
            if ($this->debug == true) {
                echo "<h1>Cantidad Inscritos para asignar: " . $CantidadDisponibleMechudosParaAsignar, "<br></h1>";
                echo "<h1>Salon: " . $valor_salones['codigosalon'] . "<br></h1>";
                echo "<h1>Inicia bucle: " . $ini_bucle . "<br></h1>";
                echo "<h1>Termina bucle: " . $MaximoPunteroRecorreArray . "<br></h1>";
            }
            //for ($i = $ini_bucle; $i < $MaximoPunteroRecorreArray && ; $i++) {
			while($CantidadDisponibleMechudosParaAsignar>0 && $i<$total_estudiantes){
                if ($this->debug == true) {
                    echo $i . "<br>";
                    echo "ContadorInicioSiguienteInscrito: " . $ContadorInicioSiguienteMechudo, "<br>";
                    echo "Codigoestudiante " . $array_codigoestudiante[$i]['codigoestudiante'], "<br>";
                }
                if ($array_codigoestudiante[$i]['codigoestudiante'] <> "") {
					if($valor_salones["RotacionID"]=="" || $valor_salones["RotacionID"]==null){
						$array_asignacion[] = array('codigoestudiante' => $array_codigoestudiante[$i]['codigoestudiante'], 'codigosalon' => $valor_salones['codigosalon'], 
						'idinscripcion' => $array_codigoestudiante[$i]['idinscripcion'], 'idhorariodetallesitioadmision' => $valor_salones['idhorariodetallesitioadmision']);
						$array_codigoestudiante[$i]['codigoestudiante'] = "";
						$CantidadDisponibleMechudosParaAsignar = $CantidadDisponibleMechudosParaAsignar-1;
					} else if($array_codigoestudiante[$i]['LugarRotacionCarreraID']==$valor_salones["RotacionID"]){
						$array_asignacion[] = array('codigoestudiante' => $array_codigoestudiante[$i]['codigoestudiante'], 'codigosalon' => $valor_salones['codigosalon'], 
						'idinscripcion' => $array_codigoestudiante[$i]['idinscripcion'], 'idhorariodetallesitioadmision' => $valor_salones['idhorariodetallesitioadmision']);
						$array_codigoestudiante[$i]['codigoestudiante'] = "";
						$CantidadDisponibleMechudosParaAsignar = $CantidadDisponibleMechudosParaAsignar-1;
					}
                }
                $ContadorInicioSiguienteMechudo++;
				$i++;
            }
            $ini_bucle = $ContadorInicioSiguienteMechudo;
            //$ini_bucle = 0;
        }
        if ($this->debug == true) {
            $this->DibujarTabla($array_asignacion, "Asignaciones");
            echo "Cantidad registros: " . count($array_asignacion) . "<br>";
        }
        return $array_asignacion;
    }

    function InsertarAsignacionesEnBaseDatos($array_asignacion_salones, $codigocarrera, $idsubperiodo) {        
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        //echo "<h1>".count($array_asignacion_salones)."</h1>";
        if (count($array_asignacion_salones) == 0) {
            echo "<script language='javascript'>alert('Todos los inscritos ya tienen salón asignado')</script>";
        } else {
            $query_idadmision = "
			SELECT a.idadmision FROM
			admision a
			WHERE 
			a.codigocarrera='$codigocarrera'
			AND a.idsubperiodo='$idsubperiodo'
			AND a.codigoestado='100'
			";
            $operacion_idadmision = $this->conexion->query($query_idadmision);
            $row_idadmision = $operacion_idadmision->fetchRow();
            $idadmision = $row_idadmision['idadmision'];

            if ($idadmision <> "") {
                $array_parametrizacion_admisiones = $this->LeerParametrizacionPruebasAdmision($idadmision);
                foreach ($array_asignacion_salones as $llave => $valor) {
                    if (is_array($array_parametrizacion_admisiones)) {
                        $query_estudianteadmision = "INSERT INTO estudianteadmision
						(idestudianteadmision, idadmision,fechaestudianteadmision,codigoestudiante, idinscripcion, codigoestado,codigoestadoestudianteadmision) 
						VALUES ('', '$idadmision', '$this->fechahoy', '" . $valor['codigoestudiante'] . "','" . $valor['idinscripcion'] . "', '100', '100')";
                        $operacion_estudianteadmision = $this->conexion->query($query_estudianteadmision);
                        $idestudianteadmision = $this->conexion->Insert_ID();
                        /**
                         * Se inserta por cada prueba parametrizada en detalleadmision, valores con el salon, pero en blanco, en tabla detalleestudianteadmision
                         */
                        //if(is_array($array_parametrizacion_admisiones))
                        foreach ($array_parametrizacion_admisiones as $llave => $valor_admisiones) {
                            //if($valor_admisiones['iddetalleadmision']!='')
                            if ($valor_admisiones['codigotipodetalleadmision'] <> 4) {//no inserta nada para icfes
                                $query_detalleestudianteadmision = "INSERT INTO detalleestudianteadmision(iddetalleestudianteadmision,
									 fechadetalleestudianteadmision, idestudianteadmision, iddetalleadmision,
									 resultadodetalleestudianteadmision, idhorariodetallesitioadmision,
									 codigoestado, codigoestadoestudianteadmision, observacionesdetalleestudianteadmision)
									 VALUES ('', '$this->fechahoy', '$idestudianteadmision', '" . $valor_admisiones['iddetalleadmision'] . "','0','" . $valor['idhorariodetallesitioadmision'] . "', '100', '100', '')";
                                $operacion_detalleestudianteadmision = $this->conexion->query($query_detalleestudianteadmision);
                            }
                        }
                    } else {
                        echo "<h1>No parametrización para ninguna prueba tipo examen admision(iddetalleadmision para ingresar poder ingresar los datos)<br>Proceso abortado</h1>";
                        exit();
                    }
                }
            }
            echo "<script language='javascript'>alert('Han asignado los salones de los nuevos inscritos')</script>";
        }
        if ($this->debug == true) {
            $this->conexion->debug = false;
        }
    }

    function LeerSubperiodos($codigocarrera) {
        $array_periodo = $this->LeerCarreraPeriodoSubperiodoCodigoestadoperiodo($codigocarrera, 1);
        //if(count($array_periodo)==1) {
            //$array_periodo=$this->LeerCarreraPeriodoSubperiodoCodigoestadoperiodo($codigocarrera,2);
      //  }
        if ($this->debug == true) {
            echo "Array sub periodo:<br>";
            print_r($array_periodo);
        }
        return $array_periodo;
    }

    function LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera, $codigoperiodo) {
        $query = "SELECT sp.idsubperiodo
		FROM subperiodo sp, carreraperiodo cp
		WHERE
		cp.codigoperiodo='" . $codigoperiodo . "'
		AND sp.codigoestadosubperiodo like '1%'
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND cp.codigocarrera='" . $codigocarrera . "'
		";        
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();

        if ($this->debug == true) {
            echo "Array sub periodo:<br>";
            print_r($array_periodo);
            $this->conexion->debug = false;
        }

        return $row_operacion;
    }

    function LeerCarreraPeriodoSubperiodoCodigoestadoperiodo($codigocarrera, $codigoestadoperiodo) {
        $query = "SELECT cp.codigocarrera,p.codigoperiodo,cp.idcarreraperiodo,sp.idsubperiodo
		FROM periodo p, carreraperiodo cp, subperiodo sp
		WHERE
		    p.codigoestadoperiodo='$codigoestadoperiodo'
		AND p.codigoperiodo=cp.codigoperiodo
		AND cp.codigocarrera='$codigocarrera'
		AND cp.idcarreraperiodo=sp.idcarreraperiodo
		AND sp.codigoestadosubperiodo=100 ";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion;
    }

    function LeerCarreras($codigomodalidadacademica="", $codigocarrera="") {
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

        if ($this->debug == true) {
            $this->conexion->debug = true;
        }

        $obtener_carreras = $this->conexion->query($query_obtener_carreras);
        $row_obtener_carreras = $obtener_carreras->fetchRow();
        do {
            $array_obtener_carreras[] = $row_obtener_carreras;
        } while ($row_obtener_carreras = $obtener_carreras->fetchRow());
        $this->array_obtener_carreras = $array_obtener_carreras;
        if ($this->debug == true) {
            $this->DibujarTabla($array_obtener_carreras, "Array Carreras");
            $this->conexion->debug = false;
        }

        return $array_obtener_carreras;
    }

    function GenerarArrayListadoInteresados($codigocarrera, $codigoperiodo, $idsubperiodo, $cuentaoperacionprincipal=153) {
        /*
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega la condicion: and eci.codigoestado='100' para que no muestre datos duplicados
         * @since Ocubre 29, 2018
        */ 
        $query = "SELECT eg.numerodocumento,
		CONCAT(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre, 
		i.idinscripcion,i.codigosituacioncarreraestudiante, sce.nombresituacioncarreraestudiante 
		FROM estudiantegeneral eg, estudiantecarrerainscripcion eci,
		inscripcion i,situacioncarreraestudiante sce 
                WHERE eg.idestudiantegeneral=eci.idestudiantegeneral 
                AND eci.idinscripcion=i.idinscripcion
                AND eci.codigocarrera=$codigocarrera 
                AND i.codigoperiodo=$codigoperiodo 
                AND i.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante 
                AND eci.codigoestado='100'
		ORDER BY nombre";

        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            //if($row_operacion['codigoestudiante']<>"")
            //{
            //$row_operacion['idadmision']="&nbsp;";
            //$row_operacion['codigosalon']="&nbsp;";
            //$row_operacion['nombreestadoestudianteadmision']="&nbsp;";
            $array_interno[] = $row_operacion;
            //}
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Listado General de Asignación de Salones");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        //print_r($array_interno);
        return $array_interno;
    }

    function GenerarArrayListadoNoAsignados($codigocarrera, $codigoperiodo, $idsubperiodo, $cuentaoperacionprincipal=153) {
        //ivan quintero 
        //modificado 12 de mayo del 2018 
        //adicion de and i.codigoperiodo = e.codigoperiodo en la linea 539
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.co>.
         * Se agrega en cada select las condicionales AND i.codigoestado='100'AND eci.codigoestado='100' para que no se visualicen registros duplicados
         * @since Octubre 10, 2018
        */ 
        /**
         * Caso 1125.
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>.
         * Se adiciona la condición AND e.codigosituacioncarreraestudiante <> 109 para que no se visualicen registros duplicados cuando 
         * El estado del código del estudiante este como registro anulado.
         * @since Abril 24, 2019.
         */ 
        $query = "SELECT
		eg.numerodocumento, 
		concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre, 
		c.nombrecarrera,
		e.codigoestudiante,
		i.idinscripcion,
		sce.nombresituacioncarreraestudiante
		FROM ordenpago o, detalleordenpago d, estudiante e, estudiantegeneral eg, 
		carrera c, concepto co, inscripcion i, estudiantecarrerainscripcion eci, 
		situacioncarreraestudiante sce
		WHERE o.numeroordenpago=d.numeroordenpago
		AND eg.idestudiantegeneral=e.idestudiantegeneral
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal='$cuentaoperacionprincipal'
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo='$codigoperiodo'
		AND c.codigocarrera='$codigocarrera'
		AND e.idestudiantegeneral=i.idestudiantegeneral
		AND i.idinscripcion=eci.idinscripcion
		AND i.codigoperiodo='$codigoperiodo'
		AND i.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante		
		AND i.codigoestado='100'
		AND eci.codigoestado='100'		
		AND eci.codigocarrera='$codigocarrera'
		AND eci.idnumeroopcion='1'
                AND e.codigosituacioncarreraestudiante <> 109
		AND e.codigoestudiante NOT IN
		(SELECT e.codigoestudiante FROM estudiante e, estudianteadmision ea, admision a
		WHERE e.codigoestudiante = ea.codigoestudiante
		AND ea.idadmision = a.idadmision
		AND a.idsubperiodo = '$idsubperiodo'
		AND a.codigoestado=100
		AND ea.codigoestado=100
		)
		UNION
		select 		eg.numerodocumento, 
				concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as 
		nombre, 
				c.nombrecarrera,
				e.codigoestudiante,
				i.idinscripcion,
				sce.nombresituacioncarreraestudiante
			
		from  estudiante e, estudiantegeneral eg, 
				carrera c,  inscripcion i, estudiantecarrerainscripcion eci, 
				situacioncarreraestudiante sce
		where e.idestudiantegeneral=eg.idestudiantegeneral
				AND i.idinscripcion=eci.idinscripcion
                                AND i.codigoperiodo = e.codigoperiodo
				AND i.codigoperiodo='" . $codigoperiodo . "'
				and i.idestudiantegeneral=e.idestudiantegeneral
				AND i.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
				AND eci.codigocarrera='" . $codigocarrera . "'
				AND eci.idnumeroopcion='1'	
				and eci.codigocarrera=c.codigocarrera
				and eci.codigocarrera=e.codigocarrera
				and i.codigosituacioncarreraestudiante in ('111','300')		
                                AND i.codigoestado='100'
                                AND eci.codigoestado='100'
                                AND e.codigosituacioncarreraestudiante <> 109
				AND e.codigoestudiante NOT IN
				(SELECT e.codigoestudiante FROM estudiante e, estudianteadmision ea, admision a
				WHERE e.codigoestudiante = ea.codigoestudiante
				AND ea.idadmision = a.idadmision
				AND a.idsubperiodo = '" . $idsubperiodo . "'
				AND a.codigoestado=100
				AND ea.codigoestado=100
				)
		order by nombre asc
		";
        
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();

        do {
            if ($row_operacion['codigoestudiante'] <> "") {
                $row_operacion['idadmision'] = "&nbsp;";
                $row_operacion['codigosalon'] = "&nbsp;";
                $row_operacion['nombreestadoestudianteadmision'] = "&nbsp;";
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Listado General de Asignación de Salones");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function GenerarArrayListadoAsignacionSalones($codigocarrera, $idsubperiodo) {
        //Ivan quintero
        //Mayo 12 del 2018 
        //se agrega and e.codigoperiodo = i.codigoperiodo en la linea 708
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega el DISTINCT y las condicionales AND e.codigoestudiante=ea.codigoestudiante AND i.idinscripcion=ea.idinscripcion para que no muestre datos duplicados
         * @since Octubre 10, 2018
         */ 
        /**
         * Caso 1125.
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>.
         * Se adiciona la condición AND e.codigosituacioncarreraestudiante <> 109 para que no se visualicen registros duplicados cuando 
         * El estado del código del estudiante este como registro anulado.
         * @since Abril 24, 2019.
        */ 
        $query = "SELECT DISTINCT 
                    dsa.codigosalon,
                    eg.numerodocumento, 
                    concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre, 
                    c.nombrecarrera,
                    a.idadmision, 
                    ea.codigoestudiante,
                    ea.idestudianteadmision,
                    sce.nombresituacioncarreraestudiante,
                    i.idinscripcion
                    FROM 
                    admision a, 
                    estudianteadmision ea, 
                    detalleestudianteadmision dea, 
                    detalleadmision da,
                    estudiante e,
                    estudiantegeneral eg, 
                    detallesitioadmision dsa,
                    horariodetallesitioadmision hdsa,
                    carrera c,
                    situacioncarreraestudiante sce,
                    estudiantecarrerainscripcion eci,
                    inscripcion i, 
                    subperiodo sp,
                    carreraperiodo cp		
		WHERE a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
                AND e.codigoperiodo = i.codigoperiodo
		AND a.idadmision=ea.idadmision
		AND ea.idestudianteadmision=dea.idestudianteadmision		
		AND e.codigoestudiante=ea.codigoestudiante		
		AND da.idadmision=a.idadmision
		AND da.iddetalleadmision=dea.iddetalleadmision
		AND da.codigotipodetalleadmision=1
		AND e.codigoestudiante=ea.codigoestudiante
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
		AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
		AND c.codigocarrera=a.codigocarrera
		AND i.idestudiantegeneral=eg.idestudiantegeneral		
		AND i.idinscripcion=ea.idinscripcion		
		AND i.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		AND i.codigoperiodo=cp.codigoperiodo
		AND eci.idinscripcion=i.idinscripcion
		AND eci.codigocarrera=a.codigocarrera
		AND eci.idnumeroopcion=1
		AND sp.idsubperiodo=a.idsubperiodo
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND da.codigoestado=100
		AND a.codigoestado=100
		AND ea.codigoestado=100
		AND dea.codigoestado=100
		AND hdsa.codigoestado=100
		AND dsa.codigoestado=100
		AND i.codigoestado=100
		AND eci.codigoestado=100
                AND e.codigosituacioncarreraestudiante <> '109'
		ORDER BY nombre
		";
        //End Caso 1125.
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['codigoestudiante'] <> "") {
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Listado General de Asignación de Salones");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function ObtenerColegio($codigoestudiante) {
        $query = "SELECT e.codigoestudiante,
if(ie.idinstitucioneducativa=1,ee.otrainstitucioneducativaestudianteestudio,ie.nombreinstitucioneducativa) nombreinstitucion FROM

		institucioneducativa ie, 
		estudianteestudio ee, 
		estudiantegeneral eg,
		estudiante e
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND ee.idestudiantegeneral=e.idestudiantegeneral
		AND ee.idinstitucioneducativa = ie.idinstitucioneducativa
		AND ie.codigomodalidadacademica='100'
                 and (ee.idniveleducacion='2' or ie.codigomodalidadacademica='100')
		";        
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        $nombreinstitucioneducativa = $row_operacion['nombreinstitucion'];
        if ($nombreinstitucioneducativa == "") {
            //$nombreinstitucioneducativa="No asignada";
        }
        return $nombreinstitucioneducativa;
    }

    function ObtenerUniversidadEgreso($codigoestudiante) {
        $query = "SELECT e.codigoestudiante,
if(ie.idinstitucioneducativa=1,ee.otrainstitucioneducativaestudianteestudio,ie.nombreinstitucioneducativa) nombreinstitucion FROM
		institucioneducativa ie, 
		estudianteestudio ee, 
		estudiantegeneral eg,
		estudiante e
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.idestudiantegeneral=eg.idestudiantegeneral
		AND ee.idestudiantegeneral=e.idestudiantegeneral
		AND ee.idinstitucioneducativa = ie.idinstitucioneducativa
		and (ee.idniveleducacion='3' or ie.codigomodalidadacademica='200')
		and ee.codigoestado like '1%'";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        $nombreinstitucioneducativa = $row_operacion['nombreinstitucion'];
        if ($nombreinstitucioneducativa == "") {
            //$nombreinstitucioneducativa="No asignada";
        }
        return $nombreinstitucioneducativa;
    }

    function ObtenerSegundaOpcion($codigoestudiante, $codigocarrera, $idsubperiodo) {

        /* $query="
          select distinct  ec.idestudiantecarrerainscripcion,c.nombrecarrera from
          estudiantecarrerainscripcion ec,
          inscripcion i,
          carrera c,
          carreraperiodo cp,
          subperiodo s,
          estudiante e
          where
          e.codigoestudiante=$codigoestudiante and
          i.idinscripcion=ec.idinscripcion and
          ec.idestudiantegeneral=e.idestudiantegeneral and
          ec.idestudiantegeneral=i.idestudiantegeneral and
          s.idcarreraperiodo=cp.idcarreraperiodo and
          s.idsubperiodo=$idsubperiodo and
          cp.codigoperiodo=i.codigoperiodo and
          cp.codigocarrera=$codigocarrera and
          ec.idnumeroopcion=2
          "; */

        $query = "select distinct ec.idestudiantecarrerainscripcion, c.nombrecarrera from estudiantecarrerainscripcion ec, inscripcion i,
		carreraperiodo cp, carrera c,
		subperiodo s, estudiante e where 
		e.codigoestudiante=$codigoestudiante 
		and i.idinscripcion=ec.idinscripcion 
		and ec.idestudiantegeneral=e.idestudiantegeneral 
		and ec.idestudiantegeneral=i.idestudiantegeneral 
		and s.idcarreraperiodo=cp.idcarreraperiodo 
		and s.idsubperiodo=$idsubperiodo 
		and cp.codigoperiodo=i.codigoperiodo 
		and ec.idnumeroopcion=2
		and c.codigocarrera=ec.codigocarrera";
        //echo "$query<br>";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        $row['Carrera_Segunda_Opcion'] = $row_operacion['nombrecarrera'];
        if (!empty($row_operacion['idestudiantecarrerainscripcion']))
            $row['Segunda_Opcion'] = "Si";
        else
            $row['Segunda_Opcion'] = "No";

        return $row;
    }

    function LeerCarreraPeriodoSubPeriodo($codigocarrera, $codigoperiodo) {
        $query = "
		SELECT p.codigoperiodo, 
		p.codigoestadoperiodo, 
		cp.idcarreraperiodo, 
		sp.idsubperiodo
		FROM 
		periodo p, subperiodo sp, carreraperiodo cp
		WHERE
		p.codigoperiodo='$codigoperiodo'
		AND p.codigoperiodo=cp.codigoperiodo
		AND cp.codigocarrera='$codigocarrera'
		AND cp.idcarreraperiodo=sp.idcarreraperiodo
		AND sp.numerosubperiodo=1
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        /*
          do
          {
          $array_interno[]=$row_operacion;
          }
          while ($row_operacion=$operacion->fetchRow);
         */
        return $row_operacion;
    }

    function ObtenerDatosEstudiantePartiendoDesdeDocumento($numerodocumento, $codigocarrera, $codigoperiodo) {
        $query = "SELECT e.codigoestudiante, eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre
		FROM
		estudiante e, estudiantegeneral eg, carrera c
		WHERE
		e.idestudiantegeneral=eg.idestudiantegeneral
		AND e.codigocarrera=c.codigocarrera
                AND e.codigoperiodo = '$codigoperiodo'
		AND eg.numerodocumento='$numerodocumento'
		AND e.codigocarrera='$codigocarrera'
		order by nombre
		";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        if ($this->debug == true) {
            $this->conexion->debug = false;
        }
        $tienedatos = true;
        if ($row_operacion['codigoestudiante'] == null) {
            $tienedatos = false;
        }
        $array_interno = array('numerodocumento' => $numerodocumento, 'codigoestudiante' => $row_operacion['codigoestudiante'], 'codigocarrera' => $codigocarrera, 'nombre' => $row_operacion['nombre'], 'tieneDatosEstudianteEstudiantegeneral' => $tienedatos);
        return $array_interno;
    }
    //se agrega el estado como variable de condicion. Ivan quintero
    function LeerDetalleAdmision($codigocarrera, $idsubperiodo, $tipodetalleadmision) {
        $query = "select dea.* from admision a, detalleadmision dea where
			a.idadmision=dea.idadmision and 
			a.idsubperiodo='$idsubperiodo' and
			a.codigocarrera='$codigocarrera' and
			dea.codigotipodetalleadmision='$tipodetalleadmision'
            AND dea.codigoestado = '100'
			";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion;
    }

    function LeerSiHaySalonPreviamenteAsignado($codigoestudiante, $codigocarrera, $idsubperiodo) {
        $query = "SELECT ea.codigoestudiante,ea.idestudianteadmision,
		dea.iddetalleestudianteadmision
		FROM estudianteadmision ea, 
		detalleestudianteadmision dea, 
		detalleadmision da,
		admision a
		WHERE
		a.idadmision = ea.idadmision
		AND ea.idestudianteadmision = dea.idestudianteadmision
		AND dea.iddetalleadmision = da.iddetalleadmision
		AND da.codigotipodetalleadmision=1
		AND ea.codigoestudiante='$codigoestudiante'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigocarrera='$codigocarrera'
                AND ea.codigoestado=100
                AND dea.codigoestado=100
                AND da.codigoestado=100
		";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        if ($this->debug == true) {
            $this->conexion->debug = false;
        }
        $tienedatos = true;
        if ($row_operacion['iddetalleestudianteadmision'] == null) {
            $tienedatos = false;
        }
        $array_interno = array('TieneDatosEstudianteadmisionDetalleestudianteadmision' => $tienedatos, 'codigoestudiante' => $codigoestudiante, 'idestudianteadmision' => $row_operacion['idestudianteadmision'], 'iddetalleestudianteadmision' => $row_operacion['iddetalleestudianteadmision']);
        return $array_interno;
    }

    function LeerIdadmision($codigocarrera, $idsubperiodo) {
        $query_idadmision = "
		SELECT a.idadmision FROM
		admision a
		WHERE 
		a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigoestado='100'
		";
        $operacion_idadmision = $this->conexion->query($query_idadmision);
        $row_idadmision = $operacion_idadmision->fetchRow();
        $idadmision = $row_idadmision['idadmision'];
        return $idadmision;
    }

    function ActualizarDatosPruebasExamenAdmision($array_datos, $array_puntajes) {
        if (count($array_datos) == count($array_puntajes)) {
            for ($i = 0; $i < count($array_datos); $i++) {
                if ($array_datos[$i]['TieneDatosEstudianteadmisionDetalleestudianteadmision'] == true) {
                    $query = "UPDATE detalleestudianteadmision SET resultadodetalleestudianteadmision='" . $array_puntajes[$i]['puntaje'] . "'
					WHERE iddetalleestudianteadmision='" . $array_datos[$i]['iddetalleestudianteadmision'] . "'
					";                    
                    if ($this->debug == true) {
                        $this->conexion->debug = true;
                    }
                    $operacion = $this->conexion->query($query);
                    $actualizadoOK = true;
                } else {
                    $actualizadoOK = false;
                }
                $array_resultado_datos_actualizados[] = array('numerodocumento' => $array_puntajes[$i]['numerodocumento'], 'codigoestudiante' => $array_datos[$i]['codigoestudiante'], 'puntaje' => $array_puntajes[$i]['puntaje'], 'actualizadoOK' => $actualizadoOK);
            }
        }
        if ($this->debug == true) {
            $this->conexion->debug = false;
        }
        return $array_resultado_datos_actualizados;
    }

    function GenerarListadoPruebasAdmision($codigocarrera, $idsubperiodo) {
        /* $query="
          SELECT
          eg.numerodocumento,
          concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre,
          c.nombrecarrera,
          a.idadmision,
          ea.codigoestudiante,
          ea.idinscripcion,
          ea.idestudianteadmision,
          eea.codigoestadoestudianteadmision,
          eea.nombreestadoestudianteadmision,
          dsa.codigosalon
          FROM
          admision a,
          estudianteadmision ea,
          detalleestudianteadmision dea,
          detallesitioadmision dsa,
          horariodetallesitioadmision hdsa,
          estudiante e,
          estudiantegeneral eg,
          carrera c,
          estadoestudianteadmision eea,
          detalleadmision da,
          tipodetalleadmision tda
          WHERE
          a.codigocarrera='$codigocarrera'
          AND a.idsubperiodo='$idsubperiodo'
          AND a.idadmision=dsa.idadmision
          AND a.idadmision=ea.idadmision
          AND ea.idestudianteadmision=dea.idestudianteadmision
          AND dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
          AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
          AND ea.codigoestudiante=e.codigoestudiante
          AND e.idestudiantegeneral=eg.idestudiantegeneral
          AND e.codigocarrera=c.codigocarrera
          AND ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision
          AND a.idadmision=da.idadmision
          AND da.codigotipodetalleadmision=tda.codigotipodetalleadmision
          AND tda.codigotipodetalleadmision=1
          AND da.codigoestado=100
          AND a.codigoestado=100
          AND ea.codigoestado=100
          AND dea.codigoestado=100
          AND hdsa.codigoestado=100
          AND dsa.codigoestado=100
          GROUP BY e.codigoestudiante
          order by nombre
          "; */

        /* $query="
          SELECT
          eg.numerodocumento,
          concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre,
          c.nombrecarrera,
          a.idadmision,
          ea.codigoestudiante,
          ea.idinscripcion,
          ea.idestudianteadmision,
          eea.codigoestadoestudianteadmision,
          eea.nombreestadoestudianteadmision,
          dsa.codigosalon
          FROM
          admision a,
          estudianteadmision ea,
          detalleestudianteadmision dea,
          detallesitioadmision dsa,
          horariodetallesitioadmision hdsa,
          estudiante e,
          estudiantegeneral eg,
          carrera c,
          estadoestudianteadmision eea,
          detalleadmision da
          WHERE
          a.codigocarrera='$codigocarrera'
          AND a.idsubperiodo='$idsubperiodo'
          AND a.idadmision=ea.idadmision
          AND ea.idestudianteadmision=dea.idestudianteadmision
          AND da.idadmision=a.idadmision
          AND da.iddetalleadmision=dea.iddetalleadmision
          AND da.codigotipodetalleadmision=1
          AND e.codigoestudiante=ea.codigoestudiante
          AND e.idestudiantegeneral=eg.idestudiantegeneral
          AND dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
          AND dsa.iddetallesitioadmision=hdsa.iddetallesitioadmision
          AND c.codigocarrera=a.codigocarrera
          AND ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision
          AND da.codigoestado=100
          AND a.codigoestado=100
          AND ea.codigoestado=100
          AND hdsa.codigoestado=100
          AND dsa.codigoestado=100
          AND eea.codigoestado=100
          "; */
        
        /*
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega la condicion: AND ea.idinscripcion=i.idinscripcionm para que no muestre datos duplicados
         * @since Ocubre 29, 2018
         */ 
        $query = "
		SELECT 
		eg.numerodocumento, 
		concat(UPPER(eg. apellidosestudiantegeneral),' ', UPPER(eg.nombresestudiantegeneral)) as nombre, 
		c.nombrecarrera,
		a.idadmision, 
		ea.codigoestudiante,
		ea.idinscripcion,
		ea.idestudianteadmision,
		eea.codigoestadoestudianteadmision,
		eea.nombreestadoestudianteadmision,
		dsa.codigosalon,	
		lr.lugarRotacionBase as rotacion,
		g.nombregenero genero,
		substring(eg.fechanacimientoestudiantegeneral,1,10) fechanacimiento,	
		sce.nombresituacioncarreraestudiante		
		FROM 
		admision a 
		inner join estudianteadmision ea on a.idadmision=ea.idadmision
		inner join detalleestudianteadmision dea on ea.idestudianteadmision=dea.idestudianteadmision
		inner join detalleadmision da on da.idadmision=a.idadmision
		inner join estudiante e on e.codigoestudiante=ea.codigoestudiante
		inner join horariodetallesitioadmision hdsa on dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision
		INNER JOIN detallesitioadmision dsa ON dsa.iddetallesitioadmision = hdsa.iddetallesitioadmision
		inner join carrera c on c.codigocarrera=a.codigocarrera
		inner join estudiantecarrerainscripcion eci on eci.codigocarrera=a.codigocarrera
		inner join inscripcion i on eci.idinscripcion=i.idinscripcion
		inner join situacioncarreraestudiante sce on i.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
		inner join subperiodo sp on sp.idsubperiodo=a.idsubperiodo
		inner join carreraperiodo cp on i.codigoperiodo=cp.codigoperiodo
		inner join estadoestudianteadmision eea on ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision
		inner join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
		left join  genero g on g.codigogenero=eg.codigogenero 
		left join LugarRotacionCarreraEstudiante lrc on lrc.codigoestudiante=e.codigoestudiante and lrc.codigoestado=100 
		left join LugarRotacionCarrera lr on lr.LugarRotacionCarreraID=lrc.LugarRotacionCarreraID 
		WHERE a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND da.iddetalleadmision=dea.iddetalleadmision
		AND da.codigotipodetalleadmision=1
		AND i.idestudiantegeneral=eg.idestudiantegeneral
		AND eci.idnumeroopcion=1
		AND sp.idcarreraperiodo=cp.idcarreraperiodo 
		AND ea.idinscripcion=i.idinscripcion
		AND da.codigoestado=100
		AND a.codigoestado=100
		AND ea.codigoestado=100
		AND dea.codigoestado=100 
		AND hdsa.codigoestado=100
		AND dsa.codigoestado=100
		AND i.codigoestado=100
		AND eci.codigoestado=100
		AND eea.codigoestado=100
		order by nombre
		";        

        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['codigoestudiante'] <> "") {
                $array_interno[] = $row_operacion;
            }
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            $this->DibujarTabla($array_interno, "Listado General de Asignación de Salones");
            echo "Cantidad registros: " . count($array_interno) . "<br>";
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function ObtenerResultadoExamen($codigoestudiante, $idadmision, $codigotipodetalleadmision) {
        $query = "SELECT
		dea.resultadodetalleestudianteadmision,da.porcentajedetalleadmision, da.totalpreguntasdetalleadmision
		FROM
		estudianteadmision ea, detalleestudianteadmision dea, detalleadmision da
		WHERE
		ea.idadmision='$idadmision'
		AND ea.idadmision = ea.idadmision
		AND ea.idestudianteadmision = dea.idestudianteadmision
		AND dea.iddetalleadmision=da.iddetalleadmision
		AND da.codigotipodetalleadmision='$codigotipodetalleadmision'
		AND ea.codigoestudiante='$codigoestudiante'
		AND ea.codigoestado=100
		AND dea.codigoestado=100
		AND da.codigoestado=100
		order by dea.resultadodetalleestudianteadmision
		";
       
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            if ($row_operacion['resultadodetalleestudianteadmision'] <> "") {
                $resultado = $row_operacion['resultadodetalleestudianteadmision'];
            } else {
                $resultado = "0";
            }
            $array_interno = array('resultado' => $resultado, 'porcentaje' => $row_operacion['porcentajedetalleadmision'], 'total_preguntas' => $row_operacion['totalpreguntasdetalleadmision']);
        } while ($row_operacion = $operacion->fetchRow());

        if ($this->debug == true) {
            echo "array_puntajes<br>";
            print_r($array_interno);
            $this->conexion->debug = false;
        }
        return $array_interno;
    }

    function ObtenerResultadoIcfes($codigoestudiante) {
        $query = "
		SELECT SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado) as resultadoprueba
		FROM resultadopruebaestado rp, detalleresultadopruebaestado dr, asignaturaestado ae, estudiante e
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.idestudiantegeneral = rp.idestudiantegeneral
		AND dr.idresultadopruebaestado = rp.idresultadopruebaestado
		AND dr.idasignaturaestado = ae.idasignaturaestado
		AND ae.codigoestado like '1%'
		AND ae.CuentaProcesoAdmisiones='1' 
		GROUP BY rp.idestudiantegeneral";        
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        //$resultadoprueba=$row_operacion['resultadoprueba'];
        $resultadoprueba = $row_operacion['resultadoprueba'];
        if ($resultadoprueba == "") {
            $resultadoprueba = 0;
        }

        if ($this->debug == true) {
            echo "Resultado Icfes $resultadoprueba<br>";
            $this->conexion->debug = false;
        }
        $resultadoprueba = round($resultadoprueba, 2);
        return $resultadoprueba;
    }//ObtenerResultadoIcfes
    
    function ObtenerResultadoEcaes($codigoestudiante)
    {
        $query= "SELECT RP.PuntajeGeneral as resultadoprueba, RP.FechaPrueba, RP.ResultadoPruebaestadoEcaesId FROM ResultadoPruebaestadoEcaes RP, estudiante E WHERE E.codigoestudiante ='".$codigoestudiante."' and E.idestudiantegeneral = RP.IdEstudianteGeneral";           
        $this->conexion->debug = true;
        $operacion = $this->conexion->query($query);          
        $row_operacion = $operacion->fetchRow();
        $resultadoprueba = $row_operacion['resultadoprueba'];        
        if ($resultadoprueba == null || $resultadoprueba == "") {
            $resultadoprueba = 0;
        }        
        if(!$resultadoprueba)
        {            
            $sqlEcaesPuntajes = "SELECT SUM( DRP.Puntaje ) / count( DRP.Puntaje ) AS 'resultadoprueba', RP.ResultadoPruebaestadoEcaesId FROM ResultadoPruebaestadoEcaes RP INNER JOIN estudiante E ON E.idestudiantegeneral = RP.IdEstudianteGeneral INNER JOIN DetalleResultadoPruebaestadoEcaes DRP on DRP.ResultadoPruebaestadoEcaesId = RP.ResultadoPruebaestadoEcaesId INNER JOIN AsignaturaEcaes AE on AE.AsignaturaEcaesId = DRP.AsignaturaEcaesId WHERE E.codigoestudiante =".$codigoestudiante."  AND AE.codigoestado like '1%'";
            $operacion = $this->conexion->query($sqlEcaesPuntajes);
            $row_operacion = $operacion->fetchRow();
            
            $fecha = $row_operacion['FechaPrueba'];
            if($fecha >= '2012' || $fecha == "")
            {
                $resultadoprueba = $row_operacion['resultadoprueba'];
                if ($resultadoprueba == "") {
                    $resultadoprueba = 0;
                }else
                {
                    $resultadoprueba = round($resultadoprueba, 2);
                    $sqlinsert = "update ResultadoPruebaestadoEcaes set PuntajeGeneral = ".$resultadoprueba." where ResultadoPruebaestadoEcaesId = ".$row_operacion['ResultadoPruebaestadoEcaesId'];                     
                    $this->conexion->query($sqlinsert);
                }
            }else
            {
                $resultadoprueba= 'no aplica';
            }
        }else
        {            
            $fecha = $row_operacion['FechaPrueba'];                        
            if($fecha >= '2012' || $fecha == "")
            {
                $resultadoprueba = $row_operacion['resultadoprueba'];
                if ($resultadoprueba == "") {
                    $resultadoprueba = 0;
                }
            }else
            {
                 $resultadoprueba= 'no aplica';
            }
        }      
        if(!$resultadoprueba== 'no aplica')
        {            
            $resultadoprueba = round($resultadoprueba, 2);  
        }   
        return $resultadoprueba;
    }//ObtenerResultadoEcaes

    function ObtenerResultadoIcfesCalculoPHP($codigoestudiante) {
        
        $query = "
		SELECT dr.notadetalleresultadopruebaestado
		FROM resultadopruebaestado rp, detalleresultadopruebaestado dr, asignaturaestado ae, estudiante e
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.idestudiantegeneral = rp.idestudiantegeneral
		AND dr.idresultadopruebaestado = rp.idresultadopruebaestado
		AND dr.idasignaturaestado = ae.idasignaturaestado
		AND ae.codigoestado like '1%' 
		AND ae.CuentaProcesoAdmisiones='1' 
		";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            $array_interno[] = $row_operacion;
        } while ($row_operacion = $operacion->fetchRow());

        $contador_sumatoria = 0;
        for ($i = 0; $i < count($array_interno); $i++) {
            $contador_sumatoria = $contador_sumatoria + $array_interno[$i]['notadetalleresultadopruebaestado'];
        }

        $resultadoprueba = $contador_sumatoria / count($array_interno);

        if ($resultadoprueba == "") {
            $resultadoprueba = 0;
        }

        if ($this->debug == true) {
            echo "Resultado Icfes $resultadoprueba<br>";
            $this->conexion->debug = false;
        }
        return $resultadoprueba;
    }
    //se agrega da.nombredetalleadmision. IQ
    function LeerParametrizacionPruebasAdmision($idadmision) {
        $query = "SELECT da.codigotipodetalleadmision,
		tda.nombretipodetalleadmision, 
		da.iddetalleadmision, 
		da.porcentajedetalleadmision, 
		da.totalpreguntasdetalleadmision,
        da.nombredetalleadmision
		FROM
		admision a, detalleadmision da, tipodetalleadmision tda
		WHERE
		a.idadmision = da.idadmision
		AND a.codigoestado=100
		AND da.codigoestado=100
		AND a.idadmision='$idadmision'
		AND da.codigotipodetalleadmision=tda.codigotipodetalleadmision
		ORDER BY
		da.codigotipodetalleadmision
		";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {

            $array_interno[] = $row_operacion;
        } while ($row_operacion = $operacion->fetchRow());
        if ($this->debug == true) {
            $this->conexion->debug = false;
            $this->DibujarTabla($array_interno, "Array_parametrizacion_admision");
        }
        return $array_interno;
    }

    function CalculaPromedioColumnaResultados($puntaje, $porcentaje, $total_preguntas) {
        $AcumuladoCol = $puntaje * ($porcentaje / $total_preguntas);        
        if ($this->debug == true) {
            echo "Acumulado = $puntaje * $porcentaje / $total_preguntas = $AcumuladoCol<br>";
        }
        $AcumuladoCol = round($AcumuladoCol, 2);
        return $AcumuladoCol;
    }

    function CalculaColumnaAcumuladoTotalSumatoria($array_datos, $array_parametrizacion, $requiere_icfes) {  
        //echo '<pre>'; print_r($array_datos); die;
        $sumatoria = 0;
        $cadena_icfes = "ACUMULADO_PRUEBAS_ESTADO";
        foreach ($array_datos as $llave_d => $valor_d) {        
            foreach ($array_parametrizacion as $llave => $valor) {
                if ($valor['codigotipodetalleadmision'] <> 4) {
                    $cadena_promedio = "ACUMULADO " . ereg_replace(" ", "_", $valor['nombretipodetalleadmision']);
                } else {
                    $cadena_promedio = $cadena_icfes;
                }
                /*if($valor_d['RESULTADO_PRUEBAS_ESTADO']== 'no aplica')
                {
                    $sumatoria = $sumatoria + $valor_d['ACUMULADO EXAMEN_ESCRITO_DE_CONOCIMIENTOS_GENERALES'];; 
                }else
                {*/
                    $sumatoria = $sumatoria + $valor_d[$cadena_promedio];    
                //}
            }
            $array_sumatoria[] = array('PUNTAJE_TOTAL' => $sumatoria);
            unset($sumatoria);
        }        
        return $array_sumatoria;
    }//CalculaColumnaAcumuladoTotalSumatoria

    function SumaArreglosBidimensionalesDelMismoTamano($arreglo1, $arreglo2) {
        if (count($arreglo1) == count($arreglo2)) {
            for ($i = 0; $i < count($arreglo1); $i++) {
                $array_sumado[] = $arreglo1[$i] + $arreglo2[$i];
            }
            return $array_sumado;
        } else {
            echo "No son del mismo tamaño";
            return;
        }
    }

    function EscribirCabeceras($matriz) {
        echo "<tr>\n";
        echo "<td>Conteo</a></td>\n";
        while ($elemento = each($matriz)) {
            echo "<td>$elemento[0]</a></td>\n";
        }
        echo "</tr>\n";
    }

    function DibujarTabla($matriz, $texto="") {

        if (is_array($matriz)) {
            echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
            echo "<caption align=TOP><h1>$texto</h1></caption>";
            $this->EscribirCabeceras($matriz[0], $link);
            for ($i = 0; $i < count($matriz); $i++) {
                $MostrarConteo = $i + 1;
                echo "<tr>\n";
                echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
                while ($elemento = each($matriz[$i])) {
                    echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
        } else {
            echo $texto . " Matriz no valida<br>";
        }
    }

    function DibujarMenuEstadoAdmision($seleccionado, $sql="", $javascript="") {
        $query = "
		SELECT codigoestadoestudianteadmision, nombreestadoestudianteadmision
		FROM
		estadoestudianteadmision
		WHERE 
		codigoestado like '1%'
		$sql
		ORDER BY
		codigoestadoestudianteadmision
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();


        echo "<select name='estadoadmision' $javascript>";
        echo "<option value='' selected>Seleccionar</option>";
        do {
            echo "if(" . $row_operacion['codigoestadoestudianteadmision'] . "==" . $seleccionado . ")	<br>";
            if ($row_operacion['codigoestadoestudianteadmision'] == $seleccionado)
                echo "<option value='" . $row_operacion['codigoestadoestudianteadmision'] . "' selected>" . $row_operacion['nombreestadoestudianteadmision'] . "</option>";
            else
                echo "<option value='" . $row_operacion['codigoestadoestudianteadmision'] . "'>" . $row_operacion['nombreestadoestudianteadmision'] . "</option>";
        }
        while ($row_operacion = $operacion->fetchRow());
        echo "</select>";
    }

    function DibujarMenuColumnas($tabla, $valordefecto="universidad_egreso") {

        echo "<select name='nombrecolumna' $javascript>";
        echo "<option value='' selected>Seleccionar</option>";
        $tmptabla = $tabla->matriz_filtrada;
        foreach ($tmptabla[0] as $nombrecolumna => $valorcolumna) {

            if ($nombrecolumna == $valordefecto)
                echo "<option value='" . $nombrecolumna . "' selected>" . $nombrecolumna . "</option>";
            else
                echo "<option value='" . $nombrecolumna . "'>" . $nombrecolumna . "</option>";
        }
        echo "</select>";
    }

    function idDetalleAdmisionNombre($idadmision, $nombre) {
        $query = "
		SELECT iddetalleadmision, nombredetalleadmision
		FROM
		detalleadmision
		where
		idadmision=$idadmision
		and nombredetalleadmision like '%" . $nombre . "%'
		ORDER BY
		nombredetalleadmision
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();

        return $row_operacion['iddetalleadmision'];
    }

    function DibujarMenuDetalleAdmision($idadmision, $seleccionado, $javascript="") {
        $query = "
		SELECT iddetalleadmision, nombredetalleadmision
		FROM
		detalleadmision
		where
		idadmision='$idadmision'
		and codigoestado like '1%'
		ORDER BY
		nombredetalleadmision
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        echo "<select name='detalleadmision' id='detalleadmision' $javascript>";
        echo "<option value='' selected>Seleccionar</option>";

        do {
            if ($row_operacion['iddetalleadmision'] == $seleccionado)
                echo "<option value='" . $row_operacion['iddetalleadmision'] . "' selected>" . $row_operacion['nombredetalleadmision'] . "</option>";
            else
                echo "<option value='" . $row_operacion['iddetalleadmision'] . "'>" . $row_operacion['nombredetalleadmision'] . "</option>";
        }
        while ($row_operacion = $operacion->fetchRow());

        echo "</select>";
    }

    function DibujarMenuDetalleSitioAdmision($idadmision, $iddetalleadmision, $seleccionado, $javascript="") {
        $query = "
		SELECT hda.idhorariodetallesitioadmision, 
		CONCAT(dsa.codigosalon,' ',SUBSTRING(hda.fechainiciohorariodetallesitioadmision,1,LOCATE(' ',hda.fechainiciohorariodetallesitioadmision)),' ',hda.horainicialhorariodetallesitioadmision) as
		salonhorario 
		FROM
		detallesitioadmision dsa, horariodetallesitioadmision hda
		where
		dsa.idadmision='$idadmision'
		and dsa.iddetalleadmision='$iddetalleadmision'
		and dsa.iddetallesitioadmision=hda.iddetallesitioadmision
		and hda.idhorariodetallesitioadmision
		and dsa.codigoestado like '1%'
		ORDER BY
		codigosalon
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        echo "<select name='detallesitioadmision' id='detallesitioadmision' $javascript>";
        echo "<option value='' selected>Seleccionar</option>";

        do {
            if ($row_operacion['codigosalon'] == $seleccionado)
                echo "<option value='" . $row_operacion['idhorariodetallesitioadmision'] . "' selected>" . $row_operacion['salonhorario'] . "</option>";
            else
                echo "<option value='" . $row_operacion['idhorariodetallesitioadmision'] . "'>" . $row_operacion['salonhorario'] . "</option>";
        }
        while ($row_operacion = $operacion->fetchRow());
        echo "</select>";
    }

    function DibujarMenuSituacion($idadmision, $iddetalleadmision, $seleccionado, $javascript="") {
        $query = "
		SELECT *
		FROM
		situacioncarreraestudiante
		where
		codigosituacioncarreraestudiante like '1%'
		ORDER BY
		nombresituacioncarreraestudiante
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        echo "<select name='situacioncarreraestudiante' id='situacioncarreraestudiante' $javascript>";
        echo "<option value='' selected>Seleccionar</option>";

        do {
            if ($row_operacion['codigosalon'] == $seleccionado)
                echo "<option value='" . $row_operacion['codigosituacioncarreraestudiante'] . "' selected>" . $row_operacion['nombresituacioncarreraestudiante'] . "</option>";
            else
                echo "<option value='" . $row_operacion['codigosituacioncarreraestudiante'] . "'>" . $row_operacion['nombresituacioncarreraestudiante'] . "</option>";
        }
        while ($row_operacion = $operacion->fetchRow());
        echo "</select>";
    }

    function ActualizarHorarioEstudiante($idestudianteadmnision, $detalleadmision, $detallesitioadmision) {

        echo $query = "update detalleestudianteadmision set
		idhorariodetallesitioadmision='$detallesitioadmision'
		where idestudianteadmision='$idestudianteadmnision' and
		iddetalleadmision='$detalleadmision'
		";
        $operacion = $this->conexion->query($query);
    }

    function AnularHorarioEstudiante($idestudianteadmnision, $detalleadmision, $detallesitioadmision) {

        echo $query = "update detalleestudianteadmision set
		codigoestado=200
		where idestudianteadmision='$idestudianteadmnision'
		";
        $operacion = $this->conexion->query($query);
    }

    function ObtenerDetalleHorario($idadmision, $iddetalleadmision) {
        $query = "SELECT d.codigosalon, h.fechainiciohorariodetallesitioadmision,
		h.idhorariodetallesitioadmision, h.horainicialhorariodetallesitioadmision, h.horafinalhorariodetallesitioadmision,
		h.intervalotiempohorariodetallesitioadmision,
		s.cupomaximosalon, s.nombresalon, se.nombresede, d.LugarRotacionCarreraID
		FROM
		detallesitioadmision d 
		INNER JOIN horariodetallesitioadmision h on h.iddetallesitioadmision=d.iddetallesitioadmision
		INNER JOIN salon s on s.codigosalon=d.codigosalon
		INNER JOIN sede se on se.codigosede=s.codigosede 
		where
		d.idadmision='$idadmision'
		and d.iddetalleadmision='$iddetalleadmision'
		and h.codigoestado like '1%'
		and d.codigoestado like '1%'
		order by h.horainicialhorariodetallesitioadmision,d.prioridaddetallesitioadmision";
		//echo  $query;
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        $tmphorainicial = $row_operacion['horainicialhorariodetallesitioadmision'];
        $cuentahorainicial = 0;
        do {
            if ($tmphorainicial != $row_operacion['horainicialhorariodetallesitioadmision'])
                $cuentahorainicial++;
            $tmphorainicial = $row_operacion['horainicialhorariodetallesitioadmision'];
            $array_interno[$cuentahorainicial][] = $row_operacion;
        }
        while ($row_operacion = $operacion->fetchRow());
        if ($this->debug == true) {
            $this->conexion->debug = false;
            $this->DibujarTabla($array_interno, "Array_parametrizacion_admision");
        }
        return $array_interno;
    }

    function CambiaEstadoAdmision($estadoestudianteadmision, $codigoestudiante, $idadmision, $idinscripcion) {
        $query = "update estudianteadmision set
			codigoestadoestudianteadmision=$estadoestudianteadmision
			where codigoestudiante=$codigoestudiante and
			idadmision=$idadmision and
			idinscripcion=$idinscripcion";
        //echo "<br>";
        $operacion = $this->conexion->query($query);
    }

    function ActualizarSituacionInscripcion($situacioncarreraestudiante, $idinscripcion) {
        $query = "update inscripcion set
			codigosituacioncarreraestudiante=$situacioncarreraestudiante
			where idinscripcion=$idinscripcion";
        //echo $query."<br>";
        $operacion = $this->conexion->query($query);
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega llamado al proceso de sincronizacion de estudiante e inscripcion
         * @since Nobiembre 15, 2018
         */
        $localFachada = new localFachadaOD();
        $constructor = $localFachada->construir($idinscripcion, null);
        $localFachada->sincronizar($constructor->getInscripcion()->getCodigoperiodo(), $constructor->getInscripcion()->getCodigosituacioncarreraestudiante(), $constructor->getEstudiante()->getCodigoestudiante(),  $constructor->getInscripcion()->getIdinscripcion());

    }

    function IngresaDetalleEstudianteAdmision($array, $objetobase) {
        $tabla = "detalleestudianteadmision";
        $fila['fechadetalleestudianteadmision'] = date("Y-m-d");
        $fila['idestudianteadmision'] = $array['idestudianteadmision'];
        $fila['iddetalleadmision'] = $array['iddetalleadmision'];
        $fila['idhorariodetallesitioadmision'] = $array['idhorariodetallesitioadmision'];
        $fila['codigoestado'] = "100";
        $fila['codigoestadoestudianteadmision'] = $array['codigoestadoestudianteadmision'];
        $fila['resultadodetalleestudianteadmision'] = "";
        $fila['observacionesdetalleestudianteadmision'] = "";
        $condicionactualiza = " idestudianteadmision=" . $fila['idestudianteadmision'] .
                " and iddetalleadmision='" . $fila["iddetalleadmision"] . "'";

        //print_r($fila);
        //if($fila['idestudianteadmision']==1966)
        //echo $condicionactualiza."<br>";

        $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
    }

    function actualizaPuntajeExamen($array, $objetobase) {
        $resultadodetalleestudianteadmision=$array['resultadodetalleestudianteadmision'];
        $observacionesdetalleestudianteadmision=$array['observacionesdetalleestudianteadmision'];
        $idestudianteadmision=$array['idestudianteadmision'];
        $iddetalleadmision=$array['iddetalleadmision'];
        $tabla = "detalleestudianteadmision";
        $nombreidtabla = 'idestudianteadmision';
        $idtabla = $idestudianteadmision;
        $fila['codigoestado'] = "100";
        $fila['resultadodetalleestudianteadmision'] = $resultadodetalleestudianteadmision;
        $fila['observacionesdetalleestudianteadmision'] = $observacionesdetalleestudianteadmision;
        $condicionactualiza = " and idestudianteadmision=" . $idestudianteadmision .
                " and iddetalleadmision='" . $iddetalleadmision . "'";
        $objetobase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicionactualiza, 1);
    }
    
    function modalidadcarrera($codigocarrera)
    {
        $query = "select codigomodalidadacademica from carrera where codigocarrera =$codigocarrera";        
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion['codigomodalidadacademica'];
    }
    
    function validarperiodo($codigoestudiante)
    {
        $query ="SELECT re.FechaPrueba, re.PuntajeGeneral FROM estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral INNER JOIN ResultadoPruebaestadoEcaes re on re.IdEstudianteGeneral = eg.idestudiantegeneral WHERE e.codigoestudiante = ".$codigoestudiante;         
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion;
    }
    
    function AjustarresultadoExamen($codigoestudiante, $idadmision, $puntaje)
    {
        $sqlporcentajes = "select  SUM(DA.porcentajedetalleadmision) as 'suma', DA.totalpreguntasdetalleadmision as 'total' from estudianteadmision EA,  detalleadmision DA where EA.codigoestudiante = ".$codigoestudiante." and DA.idadmision = EA.idadmision and EA.idadmision = ".$idadmision." and DA.codigotipodetalleadmision in (1, 4)";
        $operacion = $this->conexion->query($sqlporcentajes);
        $row_operacion = $operacion->fetchRow();
        
        $salida = (($puntaje*$row_operacion['suma'])/$row_operacion['total']); 
        
        return $salida;
    }
    
    function ObtenerPuntajeGeneralIcfes($codigoestudiante) {
        $query = "
		SELECT rp.PuntajeGlobal
		FROM resultadopruebaestado rp, detalleresultadopruebaestado dr, asignaturaestado ae, estudiante e
		WHERE
		e.codigoestudiante='$codigoestudiante'
		AND e.idestudiantegeneral = rp.idestudiantegeneral
		AND dr.idresultadopruebaestado = rp.idresultadopruebaestado
		AND dr.idasignaturaestado = ae.idasignaturaestado
		AND ae.codigoestado like '1%'
		AND ae.CuentaProcesoAdmisiones='1' 
        AND rp.codigoestado = 100
		GROUP BY rp.idestudiantegeneral";        
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        $resultadoprueba = $row_operacion['PuntajeGlobal'];
        if ($resultadoprueba == "") {
            $resultadoprueba = 0;
        }

        if ($this->debug == true) {
            echo $resultadoprueba;
            $this->conexion->debug = false;
        }
        return $resultadoprueba;
    }//ObtenerResultadoIcfes

    function ObtenerTipoRecurso($codigoestudiante)
    {
        $sql= "SELECT t.nombretipoestudianterecursofinanciero FROM 	estudianterecursofinanciero erf INNER JOIN estudiante e on e.idestudiantegeneral = erf.idestudiantegeneral INNER JOIN tipoestudianterecursofinanciero t on t.idtipoestudianterecursofinanciero  = erf.idtipoestudianterecursofinanciero WHERE 	e.codigoestudiante = '".$codigoestudiante."'";
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($sql);
        $row_operacion = $operacion->fetchRow();
        $resultadoprueba = $row_operacion['nombretipoestudianterecursofinanciero'];
        if ($resultadoprueba == "") {
            $resultadoprueba = 0;
        }
        return $resultadoprueba;
    }//function ObtenerTipoRecurso
    
    function ObetnerSegundaOpcion($codigoestudiante, $idadmision)
    {
        $sql="select eci.codigocarrera, c.nombrecarrera from estudiantecarrerainscripcion eci INNER JOIN estudiante e on e.idestudiantegeneral = eci.idestudiantegeneral INNER JOIN estudianteadmision ea on ea.codigoestudiante = e.codigoestudiante INNER JOIN carrera c on c.codigocarrera = eci.codigocarrera where e.codigoestudiante = '".$codigoestudiante."' and eci.idnumeroopcion = 2 and eci.idinscripcion = ea.idinscripcion and ea.idadmision = '".$idadmision."' and ea.codigoestadoestudianteadmision = 102";
        
        if ($this->debug == true) {
            $this->conexion->debug = true;
        }
        $operacion = $this->conexion->query($sql);
        $row_operacion = $operacion->fetchRow();      
        
        if ($resultadoprueba == "") {
            $resultadoprueba = 0;
        }
        return $resultadoprueba;
        
        return $row_operacion;
    }//function ObetnerEstadoAdmision
}

/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agrega llamado al proceso de sincronizacion de estudiante e inscripcion
 * @since Nobiembre 15, 2018
 */
require_once(realpath(dirname(__FILE__)."/../../../../../../sala/includes/adaptador.php"));
require_once(PATH_SITE."/utiles/SincronizarInscripcionEstudiante/Fachada.php"); 

class localFachadaOD extends Sala\utiles\SincronizarInscripcionEstudiante\Fachada{
    function __construct() { } 
}
?>
