<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hace formateo y limpieza de codigo.
 * @since Abril 25, 2019
 */ 
class Votaciones {

    var $conexion;
    var $depurar = false;
    var $array_datos_votacion;
    var $array_plantillas_votacion;
    var $array_detalle_plantillas_votacion;
    var $array_tipos_plantillas_votacion;
    var $codigocarrera;
    var $idtipodestinoplantillavotacion;
    var $array_datos_usuario;
    var $numerodocumentovotante;
    var $array_carreras;
    var $array_conteo_votos;
    var $array_conteo_votos_x_carrera;
    var $array_ganadores;
    var $array_ranking_x_votos;
    var $array_ranking_x_votos_consejo_facultad;

    function Votaciones(&$conexion, $depurar = false) {
        $this->conexion = $conexion;
        $this->depurar = $depurar;
        if ($depurar == true) {
            $conexion->debug = true;
        }
    }

    function asignarEscrutinios($idvotacion = '', $convigencia = 1) {
        $this->leerVotacion($idvotacion, $convigencia);
        $this->leerTiposPlantillasVotacion();
        $this->array_carreras = $this->LeerCarreras();
        $this->leerPlantillasVotacionGenerales();
        $this->leeDetallePlantillasVotacion();
        $this->cuentaVotosPlantillasVotacion();
        $this->cuentaVotos_x_Carrera();
    }

    function leerPlantillasxCarreraxTipo() {
        foreach ($this->array_tipos_plantillas_votacion as $llave_t => $valor_t) {
            unset($array_interno_2);
            foreach ($this->array_carreras as $llave_carrera => $valor_carrera) {
                unset($array_interno);
                $query = "SELECT
				c.prioridadcargo,
				pv.codigocarrera,
				pv.idplantillavotacion, 
				pv.nombreplantillavotacion, 
				pv.idvotacion,
				pv.idtipoplantillavotacion, 
				pv.resumenplantillavotacion,
				pv.codigocarrera,
				tpv.nombretipoplantillavotacion,
				dpv.iddetalleplantillavotacion, 
				dpv.idcandidatovotacion, 
				dpv.fechainscripcioncandidatodetalleplantillavotacion,
				dpv.resumenpropuestascandidatodetalleplantillavotacion,
				dpv.idplantillavotacion,
				dpv.idcargo,
				c.nombrecargo,
				cvt.numerodocumentocandidatovotacion,
				CONCAT(cvt.nombrescandidatovotacion,' ',cvt.apellidoscandidatovotacion) as nombrecandidato,
				cvt.telefonocandidatovotacion,
				cvt.celularcandidatovotacion,
				cvt.direccioncandidatovotacion,
				cvt.rutaarchivofotocandidatovotacion,
				cvt.idtipocandidatodetalleplantillavotacion,
				cvt.numerotarjetoncandidatovotacion,
				tcvt.nombretipocandidatodetalleplantillavotacion
				FROM plantillavotacion pv, tipoplantillavotacion tpv, detalleplantillavotacion dpv,cargo c, candidatovotacion cvt, tipocandidatodetalleplantillavotacion tcvt
				WHERE
				pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
				AND pv.idvotacion='" . $this->array_datos_votacion[0]['idvotacion'] . "'
				AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
				AND pv.codigocarrera='" . $valor_carrera['codigocarrera'] . "'
				AND pv.idplantillavotacion=dpv.idplantillavotacion
				AND dpv.idcandidatovotacion=cvt.idcandidatovotacion and cvt.codigoestado=100 
				AND dpv.idcargo=c.idcargo
				AND dpv.idcandidatovotacion=cvt.idcandidatovotacion
				AND cvt.idtipocandidatodetalleplantillavotacion=tcvt.idtipocandidatodetalleplantillavotacion
				ORDER BY c.prioridadcargo
				";
                $array_interno = $this->Query($query, false);
                if (is_array($array_interno)) {
                    if ($this->depurar == true) {
                        $this->DibujarTablaNormal($array_interno);
                    }
                    $array_interno_2[$valor_carrera['codigocarrera']] = $array_interno;
                }
            }
            if (is_array($array_interno_2)) {
                $this->array_plantillas_votacion_x_carrera[$valor_t['idtipoplantillavotacion']] = $array_interno_2;
            }
        }
    }

    function LeerCarreras($codigomodalidadacademica = 200) {
        $query = "SELECT c.* FROM carrera c
		WHERE c.codigomodalidadacademica='$codigomodalidadacademica'
		OR c.codigocarrera='1'
		AND NOW() BETWEEN c.fechainiciocarrera AND c.fechavencimientocarrera
		";
        $array_carreras = $this->QueryLlave($query, 'codigocarrera');
        if ($this->depurar == true) {
            $this->DibujarTablaNormal($array_carreras);
        }
        return $array_carreras;
    }

    function LeerCarrerasVotacion($idtipoplantillavotacion = "") {

        if (!empty($idtipoplantillavotacion))
            $cadenatipo = " and p.idtipoplantillavotacion=" . $idtipoplantillavotacion;
        else
            $cadenatipo = "";


        $query = "select distinct c.* from votacion  v, carrera c, plantillavotacion p
			where 
			v.idvotacion=p.idvotacion and
			p.codigocarrera=c.codigocarrera and
			p.codigoestado like '1%' and
			v.idvotacion=" . $this->array_datos_votacion[0]["idvotacion"] . $cadenatipo .
                " order by c.nombrecarrera";        
        $array_carreras = $this->QueryLlave($query, 'codigocarrera');
        if ($this->depurar == true) {
            $this->DibujarTablaNormal($array_carreras);
        }
        return $array_carreras;
    }

    function asignarVotaciones($codigocarrera, $numerodocumentovotante, $tipovotante = '', $idvotacion = '', $convigencia = 1) {
        $this->leerVotacion($idvotacion, $convigencia);
        $this->leerTiposPlantillasVotacion($idvotacion);
        $this->numerodocumentovotante = $numerodocumentovotante;
        $this->conexion->debug = @$depurar;
        $this->codigocarrera = $codigocarrera;

        if ($tipovotante == 'estudiante') {
            $this->idtipodestinoplantillavotacion = 2;
        } elseif ($tipovotante == 'docente') {
            $this->idtipodestinoplantillavotacion = 3;
        } else {
            $this->idtipodestinoplantillavotacion = 1;
        }
        $this->leerPlantillasVotacion();
        $this->leeDetallePlantillasVotacion();
    }

    function leerVotacion($idvotacion = '', $convigencia = 1) {
        if ($idvotacion == '') {
            if ($convigencia == 1)
                $vigencia = "AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion";
            else
                $vigencia = "";

            $query = "SELECT v.idvotacion, v.nombrevotacion,
		 v.descripcionvotacion, v.fechainiciovotacion,
		 v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, 
		 v.fechafinalvigenciacargoaspiracionvotacion,
 		 v.idtipocandidatodetalleplantillavotacion
		   FROM
		votacion v
		WHERE
		v.codigoestado=100
		$vigencia
		";
        }
        else {
            $query = "SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, 
			v.fechainiciovotacion, v.fechafinalvotacion, 
			v.fechainiciovigenciacargoaspiracionvotacion, 
			v.fechafinalvigenciacargoaspiracionvotacion,
			v.idtipocandidatodetalleplantillavotacion
			 FROM
		votacion v
		WHERE
		v.codigoestado=100
		AND v.idvotacion='$idvotacion'
		";
        }
        unset($this->array_datos_votacion);
        $operacion = $this->conexion->query($query);
        while ($row_operacion = $operacion->fetchRow()) {
            if (!empty($row_operacion)) {
                $this->array_datos_votacion[] = $row_operacion;
            }
        }
        if ($this->depurar == true) {
            $this->DibujarTablaNormal($this->array_datos_votacion, "Array_datos_votacion");
        }
        if (!is_array($this->array_datos_votacion)) {
            echo '<script language="javascript">alert("El plazo para votar a caducado")</script>';
            exit();
        }
    }

    function leerTiposPlantillasVotacion($idvotacion = "") {
        if ($idvotacion != "")
            $query = "SELECT distinct tpv.* FROM tipoplantillavotacion tpv,
		plantillavotacion pv
		 WHERE tpv.codigoestado=100
				and tpv.idtipoplantillavotacion=pv.idtipoplantillavotacion
				and pv.idvotacion=" . $idvotacion . " ORDER BY idtipoplantillavotacion ASC";
        else
            $query = "SELECT tpv.* FROM tipoplantillavotacion tpv
			 WHERE codigoestado=100";
        unset($this->array_tipos_plantillas_votacion);
        $operacion = $this->conexion->query($query);
        while ($row_operacion = $operacion->fetchRow()) {
            if (!empty($row_operacion)) {
                $this->array_tipos_plantillas_votacion[] = $row_operacion;
            }
        }
        if ($this->depurar == true) {
            $this->DibujarTablaNormal($this->array_tipos_plantillas_votacion, "Array_tipos_plantillas_votacion");
        }
    }

    function leerPlantillasVotacionGenerales() {
        foreach ($this->array_datos_votacion as $llave => $valor) {
            foreach ($this->array_tipos_plantillas_votacion as $llave_t => $valor_t) {
                $query = "SELECT
				pv.idplantillavotacion, 
				pv.nombreplantillavotacion, 
				pv.idvotacion,
				pv.idtipoplantillavotacion, 
				pv.resumenplantillavotacion,
				pv.codigocarrera,
				tpv.nombretipoplantillavotacion
				FROM plantillavotacion pv, tipoplantillavotacion tpv
				WHERE
				pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
				AND pv.idvotacion='" . $valor['idvotacion'] . "'
				AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
				AND pv.codigoestado='100'
				";
                $operacion = $this->conexion->query($query);
                while ($row_operacion = $operacion->fetchRow()) {
                    if (!empty($row_operacion)) {
                        $array_interno[] = $row_operacion;
                    }
                }

                $this->array_plantillas_votacion[$valor_t['idtipoplantillavotacion']] = $array_interno;
                if ($this->depurar == true) {
                    $this->DibujarTablaNormal($array_interno, "votacion " . $valor['idvotacion']);
                }
                unset($array_interno);
            }
        }
    }

    function leerPlantillasVotacion() {
        foreach ($this->array_datos_votacion as $llave => $valor) {
            if (is_array($this->array_tipos_plantillas_votacion))
                foreach ($this->array_tipos_plantillas_votacion as $llave_t => $valor_t) {
                    if (empty($this->codigocarrera)) {
                        if ($this->idtipodestinoplantillavotacion == 1) {
                            $query = "SELECT
						pv.idplantillavotacion, 
						pv.nombreplantillavotacion, 
						pv.idvotacion,
						pv.idtipoplantillavotacion, 
						pv.resumenplantillavotacion,
						pv.codigocarrera,
						tpv.nombretipoplantillavotacion
						FROM plantillavotacion pv, tipoplantillavotacion tpv
						WHERE
						pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
						AND pv.idvotacion='" . $valor['idvotacion'] . "'
						AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
						AND pv.codigocarrera=1
						AND pv.iddestinoplantillavotacion='$this->idtipodestinoplantillavotacion'
						AND pv.codigoestado='100' 
						";
                        } else {
                            $query = "SELECT
						pv.idplantillavotacion, 
						pv.nombreplantillavotacion, 
						pv.idvotacion,
						pv.idtipoplantillavotacion, 
						pv.resumenplantillavotacion,
						pv.codigocarrera,
						tpv.nombretipoplantillavotacion
						FROM plantillavotacion pv, tipoplantillavotacion tpv
						WHERE
						pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
						AND pv.idvotacion='" . $valor['idvotacion'] . "'
						AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
						AND pv.codigocarrera=1
						AND (pv.iddestinoplantillavotacion='$this->idtipodestinoplantillavotacion' or pv.iddestinoplantillavotacion='1')
						AND pv.codigoestado='100'
						";
                        }
                    } else {
                        if ($this->idtipodestinoplantillavotacion == 1) {
                            $query = "SELECT
						pv.idplantillavotacion, 
						pv.nombreplantillavotacion, 
						pv.idvotacion,
						pv.idtipoplantillavotacion, 
						pv.resumenplantillavotacion,
						pv.codigocarrera,
						tpv.nombretipoplantillavotacion
						FROM plantillavotacion pv, tipoplantillavotacion tpv
						WHERE
						pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
						AND pv.idvotacion='" . $valor['idvotacion'] . "'
						AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
						AND (pv.codigocarrera='$this->codigocarrera' or pv.codigocarrera='1')
						AND pv.iddestinoplantillavotacion='$this->idtipodestinoplantillavotacion'
						AND pv.codigoestado='100'
						";
                        } else {
                            $query = "SELECT
						pv.idplantillavotacion, 
						pv.nombreplantillavotacion, 
						pv.idvotacion,
						pv.idtipoplantillavotacion, 
						pv.resumenplantillavotacion,
						pv.codigocarrera,
						tpv.nombretipoplantillavotacion
						FROM plantillavotacion pv, tipoplantillavotacion tpv
						WHERE
						pv.idtipoplantillavotacion=tpv.idtipoplantillavotacion
						AND pv.idvotacion='" . $valor['idvotacion'] . "'
						AND pv.idtipoplantillavotacion='" . $valor_t['idtipoplantillavotacion'] . "'
						AND (pv.codigocarrera='$this->codigocarrera' or pv.codigocarrera='1')
						AND (pv.iddestinoplantillavotacion='$this->idtipodestinoplantillavotacion' or pv.iddestinoplantillavotacion='1')
						AND pv.codigoestado='100'
						";
                        }
                    }
                    $operacion = $this->conexion->query($query);
                    while ($row_operacion = $operacion->fetchRow()) {
                        if (!empty($row_operacion)) {
                            $array_interno[] = $row_operacion;
                        }
                    }
                    $this->array_plantillas_votacion[$valor_t['idtipoplantillavotacion']] = @$array_interno;
                    if ($this->depurar == true) {
                        $this->DibujarTablaNormal($array_interno, "votacion " . $valor['idvotacion']);
                    }
                    unset($array_interno);
                }
        }
    }

    function leeDetallePlantillasVotacion() {
        require_once("../utilidades/datosEstudiante.php");

        $hayDatos = false;
        foreach ($this->array_plantillas_votacion as $dato) {
            if (!empty($dato)) {
                $hayDatos = true;
            }
        }
        if (!$hayDatos) {
            $this->leerPlantillasVotacionGenerales();
        }
        foreach ($this->array_plantillas_votacion as $llave => $valor) {
            if (is_array($valor)) {
                $iidvalor = 0;
                $cadenaidplantillavotacion = "";
                foreach ($valor as $llave_plantillas => $valor_plantillas) {
                    if ($iidvalor == 0)
                        $cadenaidplantillavotacion .= $valor_plantillas['idplantillavotacion'];
                    else
                        $cadenaidplantillavotacion .= "," . $valor_plantillas['idplantillavotacion'];
                    $iidvalor++;
                }
                $query = "SELECT
					dpv.iddetalleplantillavotacion, 
					dpv.idcandidatovotacion, 
					dpv.fechainscripcioncandidatodetalleplantillavotacion,
					dpv.resumenpropuestascandidatodetalleplantillavotacion,
					dpv.idplantillavotacion,
					dpv.idcargo,
					c.nombrecargo,
					cvt.numerodocumentocandidatovotacion,
					CONCAT(cvt.nombrescandidatovotacion,' ',cvt.apellidoscandidatovotacion) as nombrecandidato,
					cvt.telefonocandidatovotacion,
					cvt.celularcandidatovotacion,
					cvt.direccioncandidatovotacion,
					cvt.rutaarchivofotocandidatovotacion,
					cvt.idtipocandidatodetalleplantillavotacion,
					cvt.numerotarjetoncandidatovotacion,
					tcvt.nombretipocandidatodetalleplantillavotacion
					FROM detalleplantillavotacion dpv, cargo c, candidatovotacion cvt, tipocandidatodetalleplantillavotacion tcvt
					WHERE
					dpv.idcargo=c.idcargo
					AND dpv.idcandidatovotacion=cvt.idcandidatovotacion and cvt.codigoestado=100 
					AND cvt.idtipocandidatodetalleplantillavotacion=tcvt.idtipocandidatodetalleplantillavotacion
					AND dpv.idplantillavotacion in (" . $cadenaidplantillavotacion . ")
					AND dpv.codigoestado='100'
					ORDER BY c.prioridadcargo, tcvt.nombretipocandidatodetalleplantillavotacion
					";
                $operacion = $this->conexion->query($query);

                while ($row_operacion = $operacion->fetchRow()) {
                    if (!empty($row_operacion)) {
                        $row_operacion["rutaarchivofotocandidatovotacion"] = obtenerFotoDocumentoEstudiante($this->conexion, $row_operacion["numerodocumentocandidatovotacion"], "../../imagenes/estudiantes/", 2);
                        if (strpos($row_operacion["rutaarchivofotocandidatovotacion"], 'no_foto') !== false) {
                            if (file_exists("../../imagenes/estudiantes/" . $row_operacion["numerodocumentocandidatovotacion"] . ".jpg")) {
                                $row_operacion["rutaarchivofotocandidatovotacion"] = "../../imagenes/estudiantes/" . $row_operacion["numerodocumentocandidatovotacion"] . ".jpg";
                            }
                        }
                        $array_interno[] = $row_operacion;
                        $this->array_detalle_plantillas_votacion[$row_operacion["idplantillavotacion"]][] = $row_operacion;
                    }
                }
                if ($this->depurar == true) {
                    $this->DibujarTablaNormal($array_interno, "plantilla " . $valor_plantillas['idplantillavotacion']);
                }

                unset($array_interno);
            }
        }
    }

    function ingresaVotacion($codigocarrera, $numerodocumentovotantesvotacion, $idvotacion, $array_plantillas_seleccionadas, $urldestino = "../consulta/central.php") {
        $votanteHaVotado = $this->verificaVotoVotante($numerodocumentovotantesvotacion);
        if ($votanteHaVotado == false) {
            
            $query_usuario = "select u.nombres, u.apellidos, u.usuario from usuario u ";
            $query_usuario .= "WHERE 1 ";
            $query_usuario .= "AND u.codigoestadousuario=100 ";
            switch ($_SESSION['datosvotante']['tipovotante']) {
                case "egresado":
                case "estudiante":
                    $query_usuario .= "AND u.codigotipousuario='600' ";
                    break;
                case "docente":
                    $query_usuario .= "AND u.codigotipousuario='500' ";
                    break;
            }
            $query_usuario .= "AND u.numerodocumento='$numerodocumentovotantesvotacion' ";
            $susuario = $this->conexion->query($query_usuario);
            $row_usuario = $susuario->fetchRow();

            switch ($_SESSION['datosvotante']['tipovotante']) {
                case "egresado":
                    $querycorreo = "SELECT distinct e.apellidosegresado as apellidos,e.nombresegresado as nombres, e.emailegresado as emailpersonal 
                            FROM egresado e join estudiante ee using(idestudiantegeneral) 
                            join carrera c using(codigocarrera) where e.numerodocumento='" . $numerodocumentovotantesvotacion . "' and ee.codigosituacioncarreraestudiante=400 
                            UNION 
                            SELECT distinct eg.apellidosestudiantegeneral as apellidos,eg.nombresestudiantegeneral as nombres,eg.emailestudiantegeneral as emailpersonal 
                            FROM registrograduado rg inner join estudiante e on e.codigoestudiante=rg.codigoestudiante AND e.codigosituacioncarreraestudiante=400 
                            INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
                            WHERE eg.numerodocumento='" . $numerodocumentovotantesvotacion . "' 
                            UNION 
                            SELECT distinct eg.apellidosestudiantegeneral as apellidos,eg.nombresestudiantegeneral as nombres,eg.emailestudiantegeneral as emailpersonal 
                            FROM registrograduadoantiguo rg inner join estudiante e on e.codigoestudiante=rg.codigoestudiante AND e.codigosituacioncarreraestudiante=400 
                            INNER JOIN estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral 
                            WHERE eg.numerodocumento='" . $numerodocumentovotantesvotacion . "' ";
                    break;
                case "estudiante":
                    $querycorreo = "select distinct eg.apellidosestudiantegeneral as apellidos,eg.nombresestudiantegeneral as nombres,eg.emailestudiantegeneral as emailpersonal 
                            from estudiante e 
                            join carrera c on e.codigocarrera=c.codigocarrera 
                            join estudianteestadistica ee on ee.codigoestudiante=e.codigoestudiante 
                            join prematricula p on e.codigoestudiante=p.codigoestudiante 
                            join estudiantegeneral eg using(idestudiantegeneral) 
                            join periodo per on p.codigoperiodo=per.codigoperiodo and per.codigoestadoperiodo=1 
                            where ee.codigoperiodo=p.codigoperiodo and c.codigomodalidadacademica in (200,300)  
                            and ee.codigoprocesovidaestudiante in(400,401) and ee.codigoestado like '1%' and numerodocumento='" . $numerodocumentovotantesvotacion . "' ";
                    break;
                case "docente":
                    $querycorreo = "select distinct apellidodocente as apellidos,nombredocente as nombres,emaildocente as emailpersonal from docente where numerodocumento='" . $numerodocumentovotantesvotacion . "' ";
                    break;
                case "administrativo":
                    $querycorreo = "SELECT  DISTINCT apellidosadministrativosdocentes AS apellidos,nombresadministrativosdocentes AS nombres,
                                telefonoadministrativosdocentes AS telefono,celularadministrativosdocentes AS celular, 
                                direccionadministrativosdocentes AS direccion
                            FROM administrativosdocentes 
                            WHERE codigoestado = 100
                            AND numerodocumento = '" . trim($numerodocumentovotantesvotacion) . "'";
                    break;
            }
            $scorreo = $this->conexion->query($querycorreo);
            $row_correo = $scorreo->fetchRow();

            $query_votantesvotacion = "INSERT INTO votantesvotacion
			(`idvotantesvotacion`, `fechavotantesvotacion`, `numerodocumentovotantesvotacion`, `idvotacion`, `codigoestado`)
			VALUES
			('', NOW(), '$numerodocumentovotantesvotacion', '$idvotacion', '100')";
            $inserta_votantesvotacion = $this->conexion->query($query_votantesvotacion);

            if ($this->depurar == true) {
                echo $query_votantesvotacion, "<br>";
            }
            foreach ($array_plantillas_seleccionadas as $llave => $valor) {
                if ($valor <> '') {

                    $query_votos = "INSERT INTO votosvotacion(`idvotosvotacion`, `fechavotosvotacion`, `idplantillavotacion`, `codigocarrera`, `observacionvotosvotacion`, `codigoestado`)

					VALUES
					('', NOW(), '" . $valor . "', '$codigocarrera', null, '100')";

                    $inserta_votosvotacion = $this->conexion->query($query_votos);

                    if ($this->depurar == true) {
                        echo $query_votos, "<br><br>";
                    }
                }
            }
            if ($inserta_votantesvotacion and $inserta_votosvotacion) {
                echo '<script languaje="javascript">alert("Sus votos han sido ingresados")</script>';

                $asunto = "Informe de Votaciones " . date('d-m-Y h:i:s A');
                $mensaje = '
                    <html>
                        <head>
                            <style>
                                table, td, th {    
                                    border: 1px solid #ddd;
                                    text-align: left;
                                }

                                table {
                                    border-collapse: collapse;
                                    width: 100%;
                                }

                                th, td {
                                    padding: 10px;
                                }
                            </style>
                        </head>
                        <body>
                            <page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
                                <div style="width: 100%;">
                                    <div style="width:100%; background-color: #364329; height: 200px;">
                                        <img style="margin-left: 50px; margin-top: 15px;" src="cid:logo" alt="logo" />
                                    </div>

                                    <div style="width:80%; margin:auto;">
                                        <h1>Muchas gracias por su voto y su participación en la convocatoria del 2018-1</h1>
                                        <h2>Sus votos fueron registrados correctamente.</h2>                                                                    
                                        <p>&nbsp;</p>
                                        <hr />        
                                        <p style="font-size: 11px;" align="center">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
                                    </div>
                                </div>
                            </page>
                        </body>
                    </html>
                    <br>';

                if(empty($row_usuario)){
                    require_once ('../funciones/phpmailer/class.phpmailer.php');

                    $mail = new PHPMailer;
                    $mail->From = "servidorsala@unbosque.edu.co";
                    $mail->FromName = "Tecnologia";
                    $mail->addAddress($row_usuario['nombres'] . " " . $row_usuario['apellidos'] . " <" . $row_usuario['usuario'] . "@unbosque.edu.co>, " . $row_correo['nombres'] . " " . $row_correo['apellidos'] . " <" . $row_correo['emailpersonal'] . "> ");
                    $mail->AddEmbeddedImage("logoblanco.png", "logo");
                    $mail->isHTML(true);
                    $mail->Subject = $asunto;
                    $mail->Body = $mensaje;

                    // Enviamos el mensaje
                    if (!$mail->Send()) {
                        echo '<script languaje="javascript">alert("Su Correo institucional y/o personal no se encuentran registrados. Por favor actualicelos.")</script>';
                    }   
                }
                if ($_SESSION['datosvotante']['estadovotante'] == 'porfuera') {
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingreso.php'>";
                } else {
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../consulta/central.php'>";
                }
            }
        } else {
            echo '<script languaje="javascript">alert("Usted ya ha votado, no puede volver a votar. Si no está de acuerdo, porfavor comuníquese con Dirección de Tecnología")</script>';
        }
    }

    function verificaVotoVotante($numerodocumentovotantesvotacion) {
        $query_verifica_votos_votante = "SELECT vv.numerodocumentovotantesvotacion FROM votantesvotacion vv
		WHERE
		vv.numerodocumentovotantesvotacion='$numerodocumentovotantesvotacion'
		and vv.idvotacion='" . $this->array_datos_votacion[0]['idvotacion'] . "'
		AND vv.codigoestado='100'
		";
        $row_verifica_votos_votante = $this->Query($query_verifica_votos_votante, true);

        if (!empty($row_verifica_votos_votante['numerodocumentovotantesvotacion'])) {
            return true; //ya votÃ³
        } else {
            return false; //no ha votado aÃºn
        }
    }

    function leeDatosUsuarioSistema() {
        if (isset($_SESSION['MM_Username']) and ! empty($_SESSION['MM_Username'])) {
            $query = "SELECT * FROM usuario WHERE usuario='" . $_SESSION['MM_Username'] . "'";
            $row_datos_usuario = $this->Query($query, true);
            if (is_array($row_datos_usuario)) {
                return $row_datos_usuario;
            }
        } else {
            echo "<h1>Se ha perdido la sesión: Porfavor cierre su explorador, intente entrar de nuevo...</h1>";
            exit();
        }
    }

    function Query($query, $unicaFila = true) {
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        if ($unicaFila == true) {
            return $row_operacion;
        } else {
            do {
                if (!empty($row_operacion)) {
                    $array_interno[] = $row_operacion;
                }
            } while ($row_operacion = $operacion->fetchRow());
            if (is_array($array_interno)) {
                return $array_interno;
            }
        }
    }

    function QueryLlave($query, $llave) {
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se hace adicion de validacion de contador 
         * @since Abril 25, 2019
         */
        if(count($row_operacion)> 1){
            do {
               if (!empty($row_operacion)) {
                    $array_interno[$row_operacion[$llave]] = $row_operacion;
                }
            } while ($row_operacion = $operacion->fetchRow());
            if (is_array($array_interno)) {
                return $array_interno;
            }
        }else{
            return "";
        }
    }

    function DibujarTablaNormal($matriz, $texto = "") {
        if (is_array($matriz)) {
            echo "<table width='100%' border=1 cellpadding='2' cellspacing='1' align=center>\n ";
            echo "<caption align=TOP><h4>$texto</h4></caption>";
            $this->EscribirCabecerasTablaNormal($matriz[0], $link);
            for ($i = 0; $i < count($matriz); $i++) {
                echo "<tr>\n";
                while ($elemento = each($matriz[$i])) {
                    echo "<td wrap>$elemento[1]&nbsp;</td>\n";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
        } else {
            echo $texto . " Matriz no valida<br>";
        }
    }

    function cuentaVotosPlantillasVotacion() {
        if (is_array($this->array_tipos_plantillas_votacion))
            foreach ($this->array_tipos_plantillas_votacion as $llave_tipos => $valor_tipos) {
                if (is_array($this->array_plantillas_votacion[$valor_tipos['idtipoplantillavotacion']]))
                    foreach ($this->array_plantillas_votacion[$valor_tipos['idtipoplantillavotacion']] as $llave_plantillas => $valor_plantillas) {
                        $cantVotosPlantilla = $this->leeVotosPlantillaVotacion($valor_plantillas['idplantillavotacion']);
                        $this->array_conteo_votos[] = array('nombreplantillavotacion' => $valor_plantillas['nombreplantillavotacion'], 'CantVotos' => $cantVotosPlantilla, 'idtipoplantillavotacion' => $valor_tipos['idtipoplantillavotacion'], 'nombretipoplantillavotacion' => $valor_tipos['nombretipoplantillavotacion'], 'representanteplantilla' => $this->array_detalle_plantillas_votacion[$valor_plantillas['idplantillavotacion']][0]['nombrecandidato'], 'cargo' => $this->array_detalle_plantillas_votacion[$valor_plantillas['idplantillavotacion']][0]['nombrecargo'], 'codigocarrerapertenenciaplantilla' => $valor_plantillas['codigocarrera'], 'nombrecarrerapertenciaplantilla' => $this->array_carreras[$valor_plantillas['codigocarrera']]['nombrecarrera'], 'representanteplantilla' => $this->array_detalle_plantillas_votacion[$valor_plantillas['idplantillavotacion']][0]['nombrecandidato']);
                    }
            }

        if ($this->depurar == true) {
            $this->DibujarTablaNormal($this->array_conteo_votos, "array_conteo_votos");
        }
    }

    function ordenaArrayParaCalculoGanadoresSegunConteo() {
        //se reagrupa el array por tipos, se le asigna la llave segun el tipo
        foreach ($this->array_tipos_plantillas_votacion as $llave_t => $valor_t) {
            foreach ($this->array_conteo_votos as $llave_cont => $valor_cont) {
                if ($valor_cont['idtipoplantillavotacion'] == $valor_t['idtipoplantillavotacion']) {
                    $array_interno_1[] = $valor_cont;
                }
            }
            $array_interno[$valor_t['idtipoplantillavotacion']] = $array_interno_1;
            unset($array_interno_1);
        }
        //se ordenan los arrays pequeños (2d) de mayor a menor para sacar el ganador, osea la posición 0
        foreach ($array_interno as $llave => $valor) {
            if ($this->depurar == true) {
                $this->DibujarTablaNormal($valor, 'array_sin_ordenar');
            }
            $this->OrdenarMatriz($valor, 'CantVotos', 'DESC');
            if ($this->depurar == true) {
                $this->DibujarTablaNormal($valor, 'array_ordenado');
            }
            $this->array_ranking_x_votos[$llave] = $valor;
            $this->array_ganadores[] = $valor[0];
        }

        if ($this->depurar == true) {
            foreach ($this->array_ranking_x_votos as $llave_g => $valor_g) {
                $this->DibujarTablaNormal($valor_g, "rearme_array_ordenado");
            }
        }

        if ($this->depurar == true) {
            $this->DibujarTablaNormal($this->array_ganadores, "array_ganadores");
        }
        return $this->array_ganadores;
    }

    function ordenaArrayParaCalculoGanadores_x_Consejo_Facultad() {
        foreach ($this->array_carreras as $llave_c => $valor_c) {
            foreach ($this->array_ranking_x_votos[3] as $llave_r => $valor_r) {
                if ($valor_c['codigocarrera'] == $valor_r['codigocarrerapertenenciaplantilla']) {
                    $this->OrdenarMatriz($valor_r, 'CantVotos', 'DESC');
                    $this->array_ranking_x_votos_consejo_facultad[$valor_c['codigocarrera']][] = $valor_r;
                }
            }
        }
    }

    function retornaArrayConteoVotos() {
        return $this->array_conteo_votos;
    }

    function retornaArrayConteoVotos_x_Carrera() {
        return $this->array_conteo_votos_x_carrera;
    }

    function cuentaVotos_x_Carrera() {
        foreach ($this->array_carreras as $llave_c => $valor_c) {
            foreach ($this->array_tipos_plantillas_votacion as $llave_t => $valor_t) {
                if (is_array($this->array_plantillas_votacion[$valor_tipos['idtipoplantillavotacion']]))
                    foreach ($this->array_plantillas_votacion[$valor_t['idtipoplantillavotacion']] as $llave_plantillas => $valor_plantillas) {
                        $cantVotosPlantilla = $this->leeVotosPlantillaVotacion_x_carrera($valor_plantillas['idplantillavotacion'], $valor_c['codigocarrera']);
                        $this->array_conteo_votos_x_carrera[] = array('nombreplantillavotacion' => $valor_plantillas['nombreplantillavotacion'], 'CantVotos' => $cantVotosPlantilla, 'idtipoplantillavotacion' => $valor_t['idtipoplantillavotacion'], 'nombretipoplantillavotacion' => $valor_t['nombretipoplantillavotacion'], 'representanteplantilla' => $this->array_detalle_plantillas_votacion[$valor_plantillas['idplantillavotacion']][0]['nombrecandidato'], 'cargo' => $this->array_detalle_plantillas_votacion[$valor_plantillas['idplantillavotacion']][0]['nombrecargo'], 'codigocarreravotosplantilla' => $valor_c['codigocarrera'], 'nombrecarreravotosplantilla' => $valor_c['nombrecarrera']);
                    }
            }
        }
        if ($this->depurar == true) {
            $this->DibujarTablaNormal($this->array_conteo_votos_x_carrera, "array_conteos_votos_x_carrera");
        }
    }

    function OrdenarMatriz($matriz, $columna, $orden) {
        foreach ($matriz as $llave => $fila) {
            $arreglo_interno[$llave] = $fila[$columna];
        }
        if ($orden == "ASC" or $orden == "asc") {
            $this->orden = "ASC";
            array_multisort($arreglo_interno, SORT_ASC, $matriz);
        } elseif ($orden == "DESC" or $orden == "desc") {
            $this->orden = "DESC";
            array_multisort($arreglo_interno, SORT_DESC, $matriz);
        }
    }

    function leeVotosPlantillaVotacion_x_carrera($idplantillavotacion, $codigocarrera) {
        $query = "SELECT COUNT(vv.idplantillavotacion) as cant FROM votosvotacion vv WHERE vv.codigoestado=100 AND vv.idplantillavotacion='$idplantillavotacion' and vv.codigocarrera='$codigocarrera'";
        $cantVotos = $this->Query($query, true);
        if ($this->depurar == true) {
            print_r($cantVotos);
            echo $query, "<br>";
        }
        return $cantVotos['cant'];
    }

    function leeVotosPlantillaVotacion($idplantillavotacion) {
        $query = "SELECT COUNT(vv.idplantillavotacion) as cant FROM votosvotacion vv WHERE vv.codigoestado=100 AND vv.idplantillavotacion='$idplantillavotacion'";
        $cantVotos = $this->Query($query, true);
        if ($this->depurar == true) {
            print_r($cantVotos);
            echo $query, "<br>";
        }
        return $cantVotos['cant'];
    }

    function retornaFacultadVotante($codigocarrera) {
        $query = "SELECT nombrefacultad FROM facultad f 
				INNER JOIN carrera c on c.codigofacultad=f.codigofacultad 
				WHERE c.codigocarrera='$codigocarrera'";
        $row_datos_usuario = $this->Query($query, true);
        if (is_array($row_datos_usuario)) {
            return "<br/>" . $row_datos_usuario["nombrefacultad"];
        } else {
            return "";
        }
    }

    function EscribirCabecerasTablaNormal($matriz) {
        echo "<tr>\n";
        while ($elemento = each($matriz)) {
            echo "<td>$elemento[0]</a></td>\n";
        }
        echo "</tr>\n";
    }

    function retornaArrayDatosVotacion() {
        return $this->array_datos_votacion;
    }

    function retornaArrayPlantillasVotacion() {
        return $this->array_plantillas_votacion;
    }

    function retornaArrayDetallePlantillasVotacion() {
        return $this->array_detalle_plantillas_votacion;
    }

    function retornaArrayTiposPlantillasVotacion() {
        return $this->array_tipos_plantillas_votacion;
    }

    function retornaArrayCarreras() {
        return $this->array_carreras;
    }

    function retornaArrayPlantillasVotacion_x_carrera() {
        return $this->array_plantillas_votacion_x_carrera;
    }

    function retornaArrayRanking_x_votos() {
        return $this->array_ranking_x_votos;
    }

    function retornaArrayGanadores() {
        return $this->array_ganadores;
    }

    function retorna_array_ranking_x_votos_consejo_facultad() {
        return $this->array_ranking_x_votos_consejo_facultad;
    }

}
