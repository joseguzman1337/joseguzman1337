<?php

/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidades
 */
class Estudiante extends EstudianteGeneral {

    /**
     * @type int
     * @access private
     */
    private $codigoEstudiante;

    /**
     * @type Carrera
     * @access private
     */
    private $fechaGrado;

    /**
     * @type int
     * @access private
     */
    private $semestre;

    /**
     * @type Cohorte
     * @access private
     */
    private $cohorte;

    /**
     * @type SituacionCarreraEstudiante
     * @access private
     */
    private $situacionCarreraEstudiante;

    /**
     * @type PreMatricula
     * @access private
     */
    private $preMatricula;

    /**
     * @type Usuario
     * @access private
     */
    private $usuario;

    /**
     * @type Carrera
     * @access private
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 15 2017
     */
    private $carrera;

    /**
     * @type Singleton
     * @access private
     */
    private $rotacion;
    
    private $persistencia;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function Estudiante($persistencia) {
        $this->persistencia = $persistencia;
    }
    
    
    public function getRotacion() {
        return $this->rotacion;
    }

    public function setRotacion($rotacion) {
        $this->rotacion = $rotacion;
    }

        
    /**
     * Modifica el Codigo del Estudiante
     * @param int $codigoEstudiante
     * @access public
     * @return void
     */
    public function setCodigoEstudiante($codigoEstudiante) {
        $this->codigoEstudiante = $codigoEstudiante;
    }

    /**
     * Retorna el Codigo del Estudiante
     * @access public
     * @return int
     */
    public function getCodigoEstudiante() {
        return $this->codigoEstudiante;
    }

    /**
     * Modifica la carrera del Estudiante
     * @param Carrera $carrera
     * @access public
     * @return void
     */
    public function setFechaGrado($fechaGrado) {
        $this->fechaGrado = $fechaGrado;
    }

    /**
     * Retorna la carrera del Estudiante
     * @access public
     * @return Carrera
     */
    public function getFechaGrado() {
        return $this->fechaGrado;
    }

    /**
     * Modifica el semestre del Estudiante
     * @param int $semestre
     * @access public
     * @return void
     */
    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    /**
     * Retorna el semestre del Estudiante
     * @access public
     * @return int
     */
    public function getSemestre() {
        return $this->semestre;
    }

    /**
     * Modifica el cohorte del estudiante
     * @param Cohorte $cohorte
     * @access public
     * @return void
     */
    public function setCohorte($cohorte) {
        $this->cohorte = $cohorte;
    }

    /**
     * Retorna el cohorte del estudiante
     * @access public
     * @return Cohorte
     */
    public function getCohorte() {
        return $this->cohorte;
    }

    /**
     * Modifica la Situacion de la Carrera del Estudiante
     * @param SituacionCarreraEstudiante $situacionCarreraEstudiante
     * @access public
     * @return void
     */
    public function setSituacionCarreraEstudiante($situacionCarreraEstudiante) {
        $this->situacionCarreraEstudiante = $situacionCarreraEstudiante;
    }

    /**
     * Retorna la Situacion de la Carrera del Estudiante
     * @access public
     * @return SituacionCarreraEstudiante
     */
    public function getSituacionCarreraEstudiante() {
        return $this->situacionCarreraEstudiante;
    }

    /**
     * Modifica el Usuario del Estudiante
     * @param usuario $usuario
     * @access public
     * @return void
     */
    public function setUsuarioEstudiante($usuario) {
        $this->usuario = $usuario;
    }

    /**
     * Retorna el Usuario del Estudiante
     * @access public
     * @return Usuario
     */
    public function getUsuarioEstudiante() {
        return $this->usuario;
    }

    /**
     * Modifica la prematricula del estudiante
     * @param PreMatricula $preMatricula
     * @access public
     * @return void
     */
    public function setPreMatricula($preMatricula) {
        $this->preMatricula = $preMatricula;
    }

    /**
     * Retorna la prematricula del estudiante
     * @access public
     * @return PreMatricula
     */
    public function getPreMatricula() {
        return $this->preMatricula;
    }

    /**
     * Modifica la carrera del Estudiante
     * @param Carrera $carrera
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     */
    public function setCarrera($carrera) {
        $this->carrera = $carrera;
    }

    /**
     * Retorna la carrera del Estudiante
     * @access public
     * @return Carrera
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     */
    public function getCarrera() {
        return $this->carrera;
    }

    /**
     * Consultar estudiantes ultimo semestre
     * @param $filtro
     * Se remueve where AND E.semestre <= P.cantidadsemestresplanestudio 
     * Se remueve AND PR.codigoestadoprematricula IN ( SELECT MAX(PM.codigoestadoprematricula)
      FROM prematricula PM
      WHERE codigoperiodo = ( SELECT MAX(PT.codigoperiodo)
      FROM prematricula PT
      WHERE PT.codigoestudiante = E.codigoestudiante
      AND PT.codigoestadoprematricula IN (40, 41)
      )
      AND PM.codigoestudiante = E.codigoestudiante )
     */
    public function consultar($filtro, $codigoModalidadAcademica = NULL) {
        $estudiantes = array();

        /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
         * Se añade filtor  105(Admitido que no Ingreso) en S.codigosituacioncarreraestudiante NOT IN (100, 101, 102, 103, 108, 109, 112, 302, 400 ) 
         * Since October 5,2017
         */
        $sql = "
            SELECT DISTINCT
                    P.idplanestudio,
                    EG.idestudiantegeneral,
                    E.codigoestudiante,
                    CONCAT( EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
                    C.nombrecarrera,
                    PR.semestreprematricula,
                    PR.codigoestadoprematricula,
                    C.codigocarrera,
                    FG.FechaMaximaCumplimiento,
                    MAX( PR.codigoperiodo ) AS codigoperiodo,
                    FG.FechaGradoId,
                    EG.EstadoActualizaDato,
                    E.codigosituacioncarreraestudiante,
                    FG.TipoGradoId 
            FROM
                    estudiantegeneral EG
                    INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
                    INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
                    INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
                    LEFT JOIN prematricula PR ON ( PR.codigoestudiante = E.codigoestudiante )
                    LEFT JOIN detalleprematricula DP ON ( DP.idprematricula = PR.idprematricula )
                    INNER JOIN planestudio P ON ( P.codigocarrera = C.codigocarrera )
                    INNER JOIN planestudioestudiante PE ON ( PE.idplanestudio = P.idplanestudio AND PE.codigoestudiante = E.codigoestudiante AND PE.codigoestadoplanestudioestudiante != 200 )
                    INNER JOIN situacioncarreraestudiante S ON ( S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante )
                    INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera ) 
            WHERE
                    S.codigosituacioncarreraestudiante NOT IN ( 100, 101, 102, 103, 108, 109, 112, 302, 400, 105 ) 
                    AND (
                            PR.semestreprematricula BETWEEN ( IF ( C.codigocarrera = 1186, P.cantidadsemestresplanestudio - 9, P.cantidadsemestresplanestudio - 3 ) ) 
                            AND P.cantidadsemestresplanestudio 
                    OR E.semestre = P.cantidadsemestresplanestudio 
                    ) ";

        if (empty($codigoModalidadAcademica) || $codigoModalidadAcademica == 200 || $codigoModalidadAcademica == 800) {
            $sql .= " AND ( DP.codigoestadodetalleprematricula IN (10,30,20) OR DP.codigoestadodetalleprematricula IS NULL )";
        }
        $sql .= $filtro;
        $sql .= " AND E.codigoestudiante NOT IN ( 
                  SELECT
                    R.codigoestudiante
                  FROM 
                    registrograduado R
                  WHERE
                    R.codigoestudiante = E.codigoestudiante AND R.codigoestado = 100
                  UNION
                  SELECT 
                    RG.EstudianteId
                  FROM 
                    RegistroGrado RG
                  WHERE
                    RG.EstudianteId = E.codigoestudiante AND RG.CodigoEstado = 100";
        
        if (isset($_POST["cmbTipoGrado"]) && $_POST["cmbTipoGrado"] == 1) {
            $sql .= " UNION
                        SELECT
                         DC.EstudianteId
                        FROM
                            DetalleAcuerdoActa DC
                        INNER JOIN AcuerdoActa AC ON ( AC.AcuerdoActaId = DC.AcuerdoActaId )
                        INNER JOIN FechaGrado FGR ON (FGR.FechaGradoId = AC.FechaGradoId )
                        WHERE
                                DC.EstudianteId = E.codigoestudiante AND FGR.TipoGradoId = 2 AND DC.CodigoEstado = 100";
        }
        if (isset($_POST["cmbTipoGrado"]) && $_POST["cmbTipoGrado"] == 2) {
            $sql .= " UNION
                        SELECT
                                DC.EstudianteId
                                FROM
                                DetalleAcuerdoActa DC
                                INNER JOIN AcuerdoActa AC ON (
                                        AC.AcuerdoActaId = DC.AcuerdoActaId
                                )
                                INNER JOIN FechaGrado FGR ON (FGR.FechaGradoId = AC.FechaGradoId )
                                WHERE
                                        DC.EstudianteId = E.codigoestudiante
                                AND FGR.TipoGradoId = 1
                                AND DC.CodigoEstado = 100";
        }
        $sql .= ")
                GROUP BY E.codigoestudiante
                ORDER BY EG.apellidosestudiantegeneral ASC";
        
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            
            $estudiante = new Estudiante($this->persistencia);
            $estudiante->setIdEstudiante($this->persistencia->getParametro("idestudiantegeneral"));
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setEstadoActualizaDato($this->persistencia->getParametro("EstadoActualizaDato"));

            $situacionCarreraEstudiante = new SituacionCarreraEstudiante(null);
            $situacionCarreraEstudiante->setCodigoSituacion($this->persistencia->getParametro("codigosituacioncarreraestudiante"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaMaxima($this->persistencia->getParametro("FechaMaximaCumplimiento"));

            $tipoGrado = new TipoGrado(null);
            $tipoGrado->setIdTipoGrado($this->persistencia->getParametro("TipoGradoId"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);
            $fechaGrado->setTipoGrado($tipoGrado);

            $estudiante->setFechaGrado($fechaGrado);
            $estudiante->setSituacionCarreraEstudiante($situacionCarreraEstudiante);

            $preMatricula = new PreMatricula(null);
            $preMatricula->setSemestrePreMatricula($this->persistencia->getParametro("semestreprematricula"));

            $periodo = new Periodo(null);
            $periodo->setCodigo($this->persistencia->getParametro("codigoperiodo"));
            $preMatricula->setPeriodo($periodo);

            $estudiante->setPreMatricula($preMatricula);
            $estudiantes[count($estudiantes)] = $estudiante;
        }
        $this->persistencia->freeResult();

        return $estudiantes;
    }

    /**
     * Buscar Lugar Rotación Estudiante Esp. Anestesiologia
     * @param $txtEstudiante
     * @access public
     */
    public function buscarRotacionEstudiante( $txtCodigoEstudiante ){
        $sql="SELECT
                        LugarRotacionCarreraID 
                FROM
                        LugarRotacionCarreraEstudiante 
                WHERE
                        codigoestudiante = ?";
         $this->persistencia->crearSentenciaSQL($sql);
         $this->persistencia->setParametro(0, $txtCodigoEstudiante , false);
          $this->persistencia->ejecutarConsulta();
            if ($this->persistencia->getNext()) {
                $this->setRotacion($this->persistencia->getParametro("LugarRotacionCarreraID"));
            }
          return $this->getRotacion();
    }

    /**
     * Buscar Estudiante por Codigo
     * @param $txtCodigoEstudiante
     * @access public
     */
    public function buscarEstudiante() {

        $sql = "SELECT D.tipodocumento, D.nombrecortodocumento, E.codigocarrera,
                    EG.numerodocumento, EG.idestudiantegeneral, EG.nombresestudiantegeneral, 
                    EG.apellidosestudiantegeneral, EG.expedidodocumento, EG.codigogenero, 
                    EG.ciudadresidenciaestudiantegeneral, EG.fechanacimientoestudiantegeneral, EG.direccionresidenciaestudiantegeneral, 
                    EG.telefonoresidenciaestudiantegeneral, EG.emailestudiantegeneral, D.nombredocumento
		FROM 
                    estudiantegeneral EG
		INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
		INNER JOIN documento D ON ( D.tipodocumento = EG.tipodocumento )
		WHERE
                E.codigoestudiante = ? ";
        /* FIN MODIFICACION */

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $this->getCodigoEstudiante(), false);

        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setIdEstudiante($this->persistencia->getParametro("idestudiantegeneral"));
            $this->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));
            $this->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $this->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $this->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $this->setFechaNacimiento($this->persistencia->getParametro("fechanacimientoestudiantegeneral"));
            $this->setDireccion($this->persistencia->getParametro("direccionresidenciaestudiantegeneral"));
            $this->setTelefono($this->persistencia->getParametro("telefonoresidenciaestudiantegeneral"));
            $this->setEmail($this->persistencia->getParametro("emailestudiantegeneral"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $this->setCarrera($carrera);


            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("tipodocumento"));
            $tipoDocumento->setDescripcion($this->persistencia->getParametro("nombrecortodocumento"));
            $tipoDocumento->setNombreDocumento($this->persistencia->getParametro("nombredocumento"));

            $genero = new Genero(null);
            $genero->setCodigo($this->persistencia->getParametro("codigogenero"));

            $ciudad = new Ciudad(null);
            $ciudad->setId($this->persistencia->getParametro("ciudadresidenciaestudiantegeneral"));

            $this->setCiudad($ciudad);
            $this->setGenero($genero);
            $this->setTipoDocumento($tipoDocumento);
        }

        $this->persistencia->freeResult();
    }

    /**
     * Actualiza Datos Estudiante
     * @access public
     * @return Booelan
     */
    public function actualizarEstudiante() {

        $sql = "UPDATE estudiantegeneral
                SET 
                    tipodocumento = ?,
                    numerodocumento = ?, 
                    nombrecortoestudiantegeneral = ?, 
                    nombresestudiantegeneral = ?,
                    apellidosestudiantegeneral = ?,
                    expedidodocumento = ?,
                    codigogenero = ?,
                    EstadoActualizaDato = 1,
                    fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
                WHERE
                    idestudiantegeneral = ?";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $this->getTipoDocumento()->getIniciales(), true);
        $this->persistencia->setParametro(1, $this->getNumeroDocumento(), true);
        $this->persistencia->setParametro(2, $this->getNumeroDocumento(), true); //nombrecortoestudiantegeneral=numerodocumento
        $this->persistencia->setParametro(3, $this->getNombreEstudiante(), true);
        $this->persistencia->setParametro(4, $this->getApellidoEstudiante(), true);
        $this->persistencia->setParametro(5, $this->getExpedicion(), true);
        $this->persistencia->setParametro(6, $this->getGenero()->getCodigo(), false);

        $this->persistencia->setParametro(7, $this->getIdEstudiante(), false);

        $estado = $this->persistencia->ejecutarUpdate();

        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        return $estado;
    }

    /**
     * Buscar acta de Estudiante
     * @param $txtCodigoEstudiante
     * @access public
     */
    public function buscarEstudianteActa() {

        $sql = "SELECT
                    D.tipodocumento, D.nombrecortodocumento, EG.numerodocumento, EG.idestudiantegeneral,
                    EG.nombresestudiantegeneral, EG.apellidosestudiantegeneral, EG.expedidodocumento, C.codigocarrera
                FROM 
                    estudiantegeneral EG
                INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
                INNER JOIN documento D ON ( D.tipodocumento = EG.tipodocumento )
                INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
                WHERE 
                    E.codigoestudiante = ?
                    AND E.codigoestudiante NOT IN ( 
                    SELECT 
                        DC.EstudianteId
                    FROM 
                        DetalleAcuerdoActa DC
                    WHERE 
                        CodigoEstado = 100)";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $this->getCodigoEstudiante(), false);

        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setIdEstudiante($this->persistencia->getParametro("idestudiantegeneral"));
            $this->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));
            $this->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $this->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $this->setExpedicion($this->persistencia->getParametro("expedidodocumento"));

            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("tipodocumento"));
            $tipoDocumento->setDescripcion($this->persistencia->getParametro("nombrecortodocumento"));

            $fechaGrado = new FechaGrado(null);
            $carrera = new Carrera(null);

            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $fechaGrado->setCarrera($carrera);
            $this->setTipoDocumento($tipoDocumento);
            $this->setFechaGrado($fechaGrado);
        }

        $this->persistencia->freeResult();
    }

    /**
     * Buscar acuerdo de Estudiante
     * @param $txtCodigoEstudiante
     * @access public
     */
    public function buscarEstudianteAcuerdo() {

        $sql = "SELECT 
                    D.tipodocumento, D.nombrecortodocumento, EG.numerodocumento, EG.idestudiantegeneral,
                    EG.nombresestudiantegeneral, EG.apellidosestudiantegeneral, EG.expedidodocumento, C.codigocarrera
                FROM 
                    estudiantegeneral EG
                INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
                INNER JOIN documento D ON ( D.tipodocumento = EG.tipodocumento )
                INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
                INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
                INNER JOIN AcuerdoActa A ON ( A.FechaGradoId = FG.FechaGradoId )
                INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = A.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
                WHERE
                    E.codigoestudiante = ?
                    AND D.CodigoEstado = 100
                    AND DAC.EstadoAcuerdo = 0
                    AND DAC.CodigoEstado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $this->getCodigoEstudiante(), false);
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setIdEstudiante($this->persistencia->getParametro("idestudiantegeneral"));
            $this->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));
            $this->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $this->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $this->setExpedicion($this->persistencia->getParametro("expedidodocumento"));

            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("tipodocumento"));
            $tipoDocumento->setDescripcion($this->persistencia->getParametro("nombrecortodocumento"));

            $fechaGrado = new FechaGrado(null);

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));

            $fechaGrado->setCarrera($carrera);

            $this->setTipoDocumento($tipoDocumento);

            $this->setFechaGrado($fechaGrado);
        }

        $this->persistencia->freeResult();
    }

    /**
     * Consulta Estudiantes a Graduarse semestre 7 adelante
     * @access public
     * @return Array
     */
    public function consultarEstudianteGraduarse() {
        $estudiantes = array();
        $sql = "SELECT DISTINCT
			E.codigoestudiante,
			CONCAT(
				EG.nombresestudiantegeneral,
				' ',
				EG.apellidosestudiantegeneral
			) AS Nombre,
			C.nombrecarrera,
			C.codigocarrera,
			S.nombresituacioncarreraestudiante, S.codigosituacioncarreraestudiante, PR.semestreprematricula, U.usuario, 
			F.codigofacultad, F.nombrefacultad, FG.FechaGrado, FG.FechaMaximaCumplimiento		
		FROM
			estudiantegeneral EG
		INNER JOIN estudiante E ON (
			E.idestudiantegeneral = EG.idestudiantegeneral
		)
		INNER JOIN usuario U ON (U.numerodocumento = EG.numerodocumento )
		INNER JOIN carrera C ON (
			C.codigocarrera = E.codigocarrera  
		)
		INNER JOIN facultad F ON (
			F.codigofacultad = C.codigofacultad
		)
		INNER JOIN prematricula PR ON (
			PR.codigoestudiante = E.codigoestudiante
		)
		INNER JOIN detalleprematricula DP ON (
			DP.idprematricula = PR.idprematricula
		)
		INNER JOIN planestudio P ON (
			P.codigocarrera = C.codigocarrera
		)
		INNER JOIN planestudioestudiante PE ON (
			PE.idplanestudio = P.idplanestudio
			AND PE.codigoestudiante = E.codigoestudiante AND PE.codigoestadoplanestudioestudiante != 200
		)
		INNER JOIN situacioncarreraestudiante S ON (
			S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante
		)
		INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
		WHERE
			S.codigosituacioncarreraestudiante NOT IN (100,101,102,103,109,400,104)
		AND DP.codigoestadodetalleprematricula = 30
		AND PR.semestreprematricula = P.cantidadsemestresplanestudio AND E.semestre = P.cantidadsemestresplanestudio
		AND C.codigomodalidadacademica IN (200,300) AND C.fechavencimientocarrera > NOW()
		AND PR.codigoperiodo = ( SELECT MAX(codigoperiodo) FROM periodo WHERE codigoestadoperiodo = 1 )
		AND FG.CodigoPeriodo = ( SELECT MAX(codigoperiodo) FROM periodo WHERE codigoestadoperiodo = 1 )
		AND E.codigoestudiante NOT IN (
			SELECT
				R.codigoestudiante
			FROM
				registrograduado R
			WHERE
				R.codigoestudiante = E.codigoestudiante
			AND R.codigoestado = 100
			UNION
				SELECT
					RG.EstudianteId
				FROM
					RegistroGrado RG
				WHERE
					RG.EstudianteId = E.codigoestudiante
				AND RG.CodigoEstado = 100
		)
		GROUP BY
			E.codigoestudiante
		ORDER BY C.codigocarrera";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $estudiante = new Estudiante($this->persistencia);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setSemestre($this->persistencia->getParametro("semestreprematricula"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));
            $fechaGrado->setFechaMaxima($this->persistencia->getParametro("FechaMaximaCumplimiento"));

            $carrera = new Carrera(null);
            $facultad = new Facultad(null);

            $facultad->setCodigoFacultad($this->persistencia->getParametro("codigofacultad"));
            $facultad->setNombreFacultad($this->persistencia->getParametro("nombrefacultad"));
            $carrera->setFacultad($facultad);
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $fechaGrado->setCarrera($carrera);
            $estudiante->setFechaGrado($fechaGrado);

            $situacionCarreraEstudiante = new SituacionCarreraEstudiante(null);
            $situacionCarreraEstudiante->setCodigoSituacion($this->persistencia->getParametro("codigosituacioncarreraestudiante"));
            $situacionCarreraEstudiante->setNombreSituacion($this->persistencia->getParametro("nombresituacioncarreraestudiante"));

            $estudiante->setSituacionCarreraEstudiante($situacionCarreraEstudiante);

            $usuario = new Usuario(null);
            $usuario->setUser($this->persistencia->getParametro("usuario"));

            $estudiante->setUsuarioEstudiante($usuario);
            $estudiantes[count($estudiantes)] = $estudiante;
        }
        $this->persistencia->freeResult();

        return $estudiantes;
    }

    /**
     * Consultar Estudiantes por Facultad y Carrera para Notificar a la Facultad
     * @param $codigoFacultad, $codigoCarrera
     * @access public
     * @return Array
     */
    public function consultarEstudianteNotificarFacultad($codigoFacultad, $codigoCarrera) {
        $estudiantes = array();
        $sql = "SELECT DISTINCT
                    E.codigoestudiante,
                    CONCAT(
                            EG.nombresestudiantegeneral,
                            ' ',
                            EG.apellidosestudiantegeneral
                    ) AS Nombre,
                    EG.numerodocumento,
                    C.nombrecarrera,
                    F.nombrefacultad,
                    EG.expedidodocumento, FG.FechaGrado, FG.FechaMaximaCumplimiento
                FROM
                        estudiantegeneral EG
                INNER JOIN estudiante E ON (
                        E.idestudiantegeneral = EG.idestudiantegeneral
                )
                INNER JOIN usuario U ON (U.numerodocumento = EG.numerodocumento )
                INNER JOIN carrera C ON (
                        C.codigocarrera = E.codigocarrera 
                )
                INNER JOIN facultad F ON (
                        F.codigofacultad = C.codigofacultad
                )
                INNER JOIN prematricula PR ON (
                        PR.codigoestudiante = E.codigoestudiante
                )
                INNER JOIN detalleprematricula DP ON (
                        DP.idprematricula = PR.idprematricula
                )
                INNER JOIN planestudio P ON (
                        P.codigocarrera = C.codigocarrera
                )
                INNER JOIN planestudioestudiante PE ON (
                        PE.idplanestudio = P.idplanestudio
                        AND PE.codigoestudiante = E.codigoestudiante AND PE.codigoestadoplanestudioestudiante != 200
                )
                INNER JOIN situacioncarreraestudiante S ON (
                        S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante
                )
                INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
                WHERE
                        S.codigosituacioncarreraestudiante NOT IN (100,101,102,103,109,400,104)
                AND DP.codigoestadodetalleprematricula = 30
                AND PR.semestreprematricula = P.cantidadsemestresplanestudio AND E.semestre = P.cantidadsemestresplanestudio
                AND C.codigomodalidadacademica IN (200,300) AND C.fechavencimientocarrera > NOW() 
                AND PR.codigoperiodo = ( SELECT MAX(codigoperiodo) FROM periodo WHERE codigoestadoperiodo = 1 )
                AND FG.CodigoPeriodo = ( SELECT MAX(codigoperiodo) FROM periodo WHERE codigoestadoperiodo = 1 )
                AND F.codigofacultad = ?
                AND C.codigocarrera = ?
                GROUP BY
                        E.codigoestudiante
                ORDER BY C.codigocarrera";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $codigoFacultad, false);
        $this->persistencia->setParametro(1, $codigoCarrera, false);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $estudiante = new Estudiante($this->persistencia);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));
            $fechaGrado->setFechaMaxima($this->persistencia->getParametro("FechaMaximaCumplimiento"));

            $carrera = new Carrera(null);

            $facultad = new Facultad(null);
            $facultad->setNombreFacultad($this->persistencia->getParametro("nombrefacultad"));

            $carrera->setFacultad($facultad);

            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $estudiante->setFechaGrado($fechaGrado);

            $estudiantes[count($estudiantes)] = $estudiante;
        }
        $this->persistencia->freeResult();

        return $estudiantes;
    }

    /**
     * Consultar Estudiantes 5 Semestres antes Notificar Inglés
     * @access public
     * @return Array
     */
    public function consultarEstudiantesNotificarIngles() {
        $estudiantes = array();
$sql = "SELECT DISTINCT
                E.codigoestudiante,
                CONCAT(
                        EG.nombresestudiantegeneral,
                        ' ',
                        EG.apellidosestudiantegeneral
                ) AS Nombre,
                C.nombrecarrera,
                C.codigocarrera,
                PR.semestreprematricula, U.usuario, 
                F.codigofacultad, F.nombrefacultad			
                FROM
                        estudiantegeneral EG
                INNER JOIN estudiante E ON (
                        E.idestudiantegeneral = EG.idestudiantegeneral
                )
                INNER JOIN usuario U ON (U.numerodocumento = EG.numerodocumento )
                INNER JOIN carrera C ON (
                        C.codigocarrera = E.codigocarrera  
                )
                INNER JOIN facultad F ON (
                        F.codigofacultad = C.codigofacultad
                )
                INNER JOIN prematricula PR ON (
                        PR.codigoestudiante = E.codigoestudiante
                )
                INNER JOIN detalleprematricula DP ON (
                        DP.idprematricula = PR.idprematricula
                )
                INNER JOIN planestudio P ON (
                        P.codigocarrera = C.codigocarrera
                )
                INNER JOIN planestudioestudiante PE ON (
                        PE.idplanestudio = P.idplanestudio
                        AND PE.codigoestudiante = E.codigoestudiante AND PE.codigoestadoplanestudioestudiante != 200
                )

                WHERE
                        E.codigosituacioncarreraestudiante NOT IN (100,101,102,103,109,400)
                AND DP.codigoestadodetalleprematricula = 30
                AND ((PR.semestreprematricula >= (ROUND(P.cantidadsemestresplanestudio/2)) AND PR.semestreprematricula <= (P.cantidadsemestresplanestudio-1)) AND (E.semestre >= (ROUND(P.cantidadsemestresplanestudio/2)) AND E.semestre <= (P.cantidadsemestresplanestudio-1)))
                AND C.codigomodalidadacademica = 200 AND C.fechavencimientocarrera > NOW()
                AND PR.codigoperiodo = (SELECT MAX(codigoperiodo) FROM periodo WHERE codigoestadoperiodo = 1)
                GROUP BY
                        E.codigoestudiante
                ORDER BY C.codigocarrera";
        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $estudiante = new Estudiante($this->persistencia);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));

            $fechaGrado = new FechaGrado(null);

            $carrera = new Carrera(null);

            $facultad = new Facultad(null);
            $facultad->setCodigoFacultad($this->persistencia->getParametro("codigofacultad"));
            $facultad->setNombreFacultad($this->persistencia->getParametro("nombrefacultad"));

            $carrera->setFacultad($facultad);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $estudiante->setFechaGrado($fechaGrado);

            $usuario = new Usuario(null);
            $usuario->setUser($this->persistencia->getParametro("usuario"));

            $estudiante->setUsuarioEstudiante($usuario);

            $estudiantes[count($estudiantes)] = $estudiante;
        }
        $this->persistencia->freeResult();

        return $estudiantes;
    }

    /**
     * Consultar estudiantes ultimo semestre Cron
     * @param $filtro
     */
    public function consultarCronEstudiante($txtCodigoCarrera) {
        $estudiantes = array();
        $sql = "SELECT DISTINCT P.idplanestudio, EG.idestudiantegeneral, E.codigoestudiante, CONCAT(EG.nombresestudiantegeneral, ' ', EG.apellidosestudiantegeneral ) AS Nombre, 
					C.nombrecarrera, PR.semestreprematricula, PR.codigoestadoprematricula, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId,
					EG.EstadoActualizaDato, D.tipodocumento, D.nombrecortodocumento, EG.numerodocumento
					FROM estudiantegeneral EG
					INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
					INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
					INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
					INNER JOIN prematricula PR ON ( PR.codigoestudiante = E.codigoestudiante )
					INNER JOIN detalleprematricula DP ON ( DP.idprematricula = PR.idprematricula )
					INNER JOIN planestudio P ON ( P.codigocarrera = C.codigocarrera )
					INNER JOIN planestudioestudiante PE ON ( PE.idplanestudio = P.idplanestudio AND PE.codigoestudiante = E.codigoestudiante AND PE.codigoestadoplanestudioestudiante != 200 )
					INNER JOIN situacioncarreraestudiante S ON ( S.codigosituacioncarreraestudiante = E.codigosituacioncarreraestudiante )
					INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
					INNER JOIN documento D ON ( D.tipodocumento = EG.tipodocumento )
					WHERE S.codigosituacioncarreraestudiante NOT IN (100, 101, 102, 103, 108, 109, 112, 302, 400)
					AND DP.codigoestadodetalleprematricula = 30
					AND PR.semestreprematricula = P.cantidadsemestresplanestudio AND E.semestre <= P.cantidadsemestresplanestudio 
					AND C.codigocarrera = ?
				 	AND PR.codigoestadoprematricula IN ( SELECT MAX(PM.codigoestadoprematricula)
                                            FROM prematricula PM
                                            WHERE codigoperiodo = ( SELECT MAX(PT.codigoperiodo)
                                            FROM prematricula PT
                                            WHERE PT.codigoestudiante = E.codigoestudiante
                                                    AND PT.codigoestadoprematricula IN (40, 41)
                                                    )
                                            AND PM.codigoestudiante = E.codigoestudiante )
                                            AND E.codigoestudiante NOT IN ( SELECT R.codigoestudiante
                                                                            FROM registrograduado R
                                                                            WHERE R.codigoestudiante = E.codigoestudiante
                                                                            AND R.codigoestado = 100
                                                                            UNION
                                                                            SELECT 
                                                                                    RG.EstudianteId
                                                                            FROM 
                                                                                    RegistroGrado RG
                                                                            WHERE
                                                                                    RG.EstudianteId = E.codigoestudiante
                                                                            AND RG.CodigoEstado = 100 )
							GROUP BY E.codigoestudiante
							ORDER BY C.nombrecarrera ASC, Nombre ASC
				";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoCarrera, false);

        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $estudiante = new Estudiante($this->persistencia);
            $estudiante->setIdEstudiante($this->persistencia->getParametro("idestudiantegeneral"));
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setEstadoActualizaDato($this->persistencia->getParametro("EstadoActualizaDato"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaMaxima($this->persistencia->getParametro("FechaMaximaCumplimiento"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $estudiante->setFechaGrado($fechaGrado);

            $preMatricula = new PreMatricula(null);
            $preMatricula->setSemestrePreMatricula($this->persistencia->getParametro("semestreprematricula"));

            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("tipodocumento"));
            $tipoDocumento->setDescripcion($this->persistencia->getParametro("nombrecortodocumento"));

            $estudiante->setTipoDocumento($tipoDocumento);


            $estudiante->setPreMatricula($preMatricula);

            $estudiantes[count($estudiantes)] = $estudiante;
        }
        $this->persistencia->freeResult();

        return $estudiantes;
    }

    /**
     * Buscar Estado CivilPeopleEstudiante
     * @param $txtCodigoEstudiante
     * @access public
     */
    public function buscarEstadoCivilPeople($txtNumeroDocumento) {

        $sql = "SELECT codigoestadocivilpeople
				FROM estudiantegeneral
				JOIN estadocivilpeople USING(idestadocivil)
				WHERE numerodocumento = ?
				";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtNumeroDocumento, true);

        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setEstadoCivilEstudiante($this->persistencia->getParametro("codigoestadocivilpeople"));
        }

        $this->persistencia->freeResult();
    }

    /**
     * Actualizar Situacion Carrera Estudiante
     * @param int $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function actualizarSituacionCarreraEstudiante($txtCodigoEstudiante) {

        $sql = "UPDATE estudiante
				SET codigosituacioncarreraestudiante = 400
				WHERE codigoestudiante = ?";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( );
        $estado = $this->persistencia->ejecutarUpdate();

        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        return $estado;
    }

    public function insertaLogtraceintegracionps($actualizaWebService = '') {

        $sql = "INSERT INTO logtraceintegracionps (transaccionlogtraceintegracionps,enviologtraceintegracionps,respuestalogtraceintegracionps,documentologtraceintegracionps,estadoenvio) VALUES ('Actualizacion estudiante','" . $actualizaWebService['xml'] . "','id:" . $actualizaWebService['ERRNUM'] . " descripcion: " . $actualizaWebService['DESCRLONG'] . "','" . $actualizaWebService['NATIONAL_ID'] . "',2)";

        $this->persistencia->crearSentenciaSQL($sql);
        $estado = $this->persistencia->ejecutarUpdate();
    }

    public function estudianteCarrera($idCarrera, $documento) {
        $sql = "SELECT
                        E.codigoestudiante,
                        CONCAT( EG.nombresestudiantegeneral ,' ', EG.apellidosestudiantegeneral ) AS nombre 
                FROM
                        estudiante E
                        INNER JOIN estudiantegeneral EG ON ( E.Idestudiantegeneral = EG.idestudiantegeneral ) 
                WHERE
                        EG.numerodocumento = ?
                        AND E.codigocarrera = ?";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $documento, true);
        $this->persistencia->setParametro(1, $idCarrera, false);

        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $this->setNombreEstudiante($this->persistencia->getParametro("nombre"));
        }
    }

}

?>