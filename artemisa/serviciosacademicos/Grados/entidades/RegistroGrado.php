<?php

/**
 * Agosto 3, 2017
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidades 
 */
class RegistroGrado {

    /**
     * @type int
     * @access private
     */
    private $idRegistroGrado;

    /**
     * @type AcuerdoActa
     * @access private
     */
    private $actaAcuerdo;

    /**
     * @type Estudiante
     * @access private
     */
    private $estudiante;

    /**
     * @type int
     * @access private
     */
    private $numeroDiploma;

    /**
     * @type string
     * @access private
     */
    private $numeroPromocion;

    /**
     * @type int
     * @access private
     */
    private $estadoGrado;

    /**
     * @type string
     * @access private
     */
    private $direccionIp;

    /**
     * @type IncentivoAcademico
     * @access private
     */
    private $incentivoAcademico;

    /**
     * @type date
     * @access private
     */
    private $fechaCreacionRegistroGrado;

    /**
     * @type Directivo
     * @access private
     */
    private $directivoRegistroGrado;

    /**
     * @type tipoDocumento
     * @access private
     */
    private $tipoDocumento;

    /**
     * @type estudianteGeneral
     * @access private
     */
    private $estudianteGeneral;

    /**
     * @type Singleton
     * @access private
     */

    /**
     * @type estudianteGeneral
     * @access private
     */
    private $conteoGradosMujer;

    /**
     * @type estudianteGeneral
     * @access private
     */
    private $conteoGradosHombre;

    /**
     * @type estudianteGeneral
     * @access private
     */
    private $folio;

    /**
     * @type estudianteGeneral
     * @access private
     */
    private $trabjoGrado;

    public function getTrabjoGrado() {
        return $this->trabjoGrado;
    }

    public function setTrabjoGrado($trabjoGrado) {
        $this->trabjoGrado = $trabjoGrado;
    }
    
    private $contadorRegistros;
    
    
    function getContadorRegistros() {
        return $this->contadorRegistros;
    }

    function setContadorRegistros($contadorRegistros) {
        $this->contadorRegistros = $contadorRegistros;
    }

    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * Contructor
     * @param $persistencia
     */
    public function RegistroGrado($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Modifica el identificador del RegistroGrado
     * @param int $idRegistroGrado
     * @access public
     * @return void
     */
    public function setIdRegistroGrado($idRegistroGrado) {
        $this->idRegistroGrado = $idRegistroGrado;
    }

    /**
     * Retorna el identificador del Registro de Grado
     * @access public
     * @return int
     */
    public function getIdRegistroGrado() {
        return $this->idRegistroGrado;
    }

    /**
     * Modifica el actaAcuerdo del registro de grado
     * @param AcuerdoActa $actaAcuerdo
     * @access public
     * @return void
     */
    public function setActaAcuerdo($actaAcuerdo) {
        $this->actaAcuerdo = $actaAcuerdo;
    }

    /**
     * Retorna eñl actaAcuerdo del registro de grado
     * @access public
     * @return AcuerdoActa
     */
    public function getActaAcuerdo() {
        return $this->actaAcuerdo;
    }

    /**
     * Modifica el estudiante del Registro de Grado
     * @param Estudiante $estudiante
     * @access public
     * @return void
     */
    public function setEstudiante($estudiante) {
        $this->estudiante = $estudiante;
    }

    /**
     * Retorna el estudiante del Registro de Grado
     * @access public
     * @return Estudiante
     */
    public function getEstudiante() {
        return $this->estudiante;
    }

    /**
     * Modifica el numero del diploma del registro de grado
     * @param int $numeroDiploma
     * @access public
     * @return void
     */
    public function setNumeroDiploma($numeroDiploma) {
        $this->numeroDiploma = $numeroDiploma;
    }

    /**
     * Retorna el numero del diploma del registro de grado
     * @access public
     * @return int
     */
    public function getNumeroDiploma() {
        return $this->numeroDiploma;
    }

    /**
     * Modifica el numero de promocion del registro de grado
     * @param int $numeroDiploma
     * @access public
     * @return void
     */
    public function setNumeroPromocion($numeroPromocion) {
        $this->numeroPromocion = $numeroPromocion;
    }

    /**
     * Retorna el numero de promocion del registro de grado
     * @access public
     * @return string
     */
    public function getNumeroPromocion() {
        return $this->numeroPromocion;
    }

    /**
     * Modifica el estado del registro de grado
     * @param int $estadoGrado
     * @access public
     * @return void
     */
    public function setEstadoGrado($estadoGrado) {
        $this->estadoGrado = $estadoGrado;
    }

    /**
     * Retorna el estado del registro de grado 
     * @access public
     * @return int
     */
    public function getEstadoGrado() {
        return $this->estadoGrado;
    }

    /**
     * Modifica la dirección ip del registro de grado
     * @param string $direccionIp
     * @access public
     * @return void
     */
    public function setDireccionIp($direccionIp) {
        $this->direccionIp = $direccionIp;
    }

    /**
     * Retorna la direccion ip del registro de grado
     * @access public
     * @return string
     */
    public function getDireccionIp() {
        return $this->direccionIp;
    }

    /**
     * Modifica el incentivo academico del registro de grado
     * @param IncentivoAcademico $incentivoAcademico
     * @access public
     * @return void
     */
    public function setIncentivoAcademico($incentivoAcademico) {
        $this->incentivoAcademico = $incentivoAcademico;
    }

    /**
     * Retorna el incentivo academico del registro de grado
     * @access public 
     * @return IncentivoAcademico
     */
    public function getIncentivoAcademico() {
        return $this->incentivoAcademico;
    }

    /**
     * Modifica la fecha de creacion del registro de grado
     * @param date $fechaCreacionRegistroGrado
     * @access public
     * @return void
     */
    public function setFechaCreacionRegistroGrado($fechaCreacionRegistroGrado) {
        $this->fechaCreacionRegistroGrado = $fechaCreacionRegistroGrado;
    }

    /**
     * Retorna la fecha de creacion del registro de grado
     * @access public 
     * @return date
     */
    public function getFechaCreacionRegistroGrado() {
        return $this->fechaCreacionRegistroGrado;
    }

    /**
     * Modifica el directivo del registro de grado
     * @param Directivo $directivoRegistroGrado
     * @access public
     * @return void
     */
    public function setDirectivoRegistroGrado($directivoRegistroGrado) {
        $this->directivoRegistroGrado = $directivoRegistroGrado;
    }

    /**
     * Retorna el directivo del registro de grado
     * @access public 
     * @return Directivo
     */
    public function getDirectivoRegistroGrado() {
        return $this->directivoRegistroGrado;
    }

    /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se añade get y set  objeto tipodocumento,estudianteGeneral
     * Since June 14.2017
     */

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function setEstudianteGeneral($estudianteGeneral) {
        $this->estudianteGeneral = $estudianteGeneral;
    }

    public function getEstudianteGeneral() {
        return $this->estudianteGeneral;
    }

    public function setConteoGradosMujer($conteoGradosMujer) {
        $this->conteoGradosMujer = $conteoGradosMujer;
    }

    public function getconteoGradosMujer() {
        return $this->conteoGradosMujer;
    }

    public function setConteoGradosHombre($conteoGradosHombre) {
        $this->conteoGradosHombre = $conteoGradosHombre;
    }

    public function getConteoGradosHombre() {
        return $this->conteoGradosHombre;
    }

    public function setFolio($folio) {
        $this->folio = $folio;
    }

    public function getFolio() {
        return $this->folio;
    }

    /**
     * Inserta el registro de grado del estudiante
     * @access public
     * @return Boolean 
     */
    public function crearRegistroGrado($txtCodigoEstudiante, $txtIdActaGrado, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona) {
        $sql = "INSERT INTO RegistroGrado (
					EstudianteId,
					ActaGradoId,
					AcuerdoActaId,
					NumeroDiploma,
					NumeroPromocion,
					DirectivoId,
					CodigoEstado,
					DireccionIp,
					UsuarioCreacion,
					UsuarioModificacion,
					FechaCreacion,
					FechaUltimaModificacion
				)
				VALUES
					(?, ?, ?, ?, ?, ?, 100, ?, ?, NULL, NOW(), NULL)";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $txtCodigoEstudiante, true);
        $this->persistencia->setParametro(1, $txtIdActaGrado, true);
        $this->persistencia->setParametro(2, $txtIdAcuerdoActa, true);
        $this->persistencia->setParametro(3, $txtNumeroDiploma, true);
        $this->persistencia->setParametro(4, $txtNumeroPromocion, true);
        $this->persistencia->setParametro(5, $txtIdDirectivo, true);
        $this->persistencia->setParametro(6, $txtDireccionIp, true);
        $this->persistencia->setParametro(7, $idPersona, true);
        //echo $this->persistencia->getSQLListo( );
        $estado = $this->persistencia->ejecutarUpdate();
        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        //$this->persistencia->freeResult( );

        return $estado;
    }

    /**
     * Consula si el registro de grado del estudiante ya existe
     * @access public
     * @return INT  RegistroGradoId
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     */
    public function consultarExisteRegistroGrado($txtCodigoEstudiante, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona) {
        $estado = 0;
        $sql = "SELECT RegistroGradoId 
		          FROM RegistroGrado 
		         WHERE EstudianteId = ?
		           AND AcuerdoActaId = ?
		           AND NumeroDiploma = ?
		           AND NumeroPromocion = ?
		           AND DirectivoId = ?
		           AND CodigoEstado = 100 ";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $txtCodigoEstudiante, true);
        $this->persistencia->setParametro(1, $txtIdAcuerdoActa, true);
        $this->persistencia->setParametro(2, $txtNumeroDiploma, true);
        $this->persistencia->setParametro(3, $txtNumeroPromocion, true);
        $this->persistencia->setParametro(4, $txtIdDirectivo, true);
        //d($this->persistencia->getSQLListo( )); 
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $estado = $this->persistencia->getParametro("RegistroGradoId");
        }

        return $estado;
    }

    /**
     * Existe RegistroGradoId por Estudiante y Acta
     * @param int $txtCodigoEstudiante, $txtIdActa
     * @access public
     * @return void
     */
    public function buscarRegistroGradoEstudiante($txtCodigoEstudiante, $txtIdActa) {
        $sql = "SELECT COUNT( RegistroGradoId ) AS cantidad_registro
				FROM RegistroGrado
				WHERE EstudianteId = ?
				AND AcuerdoActaId = ?
				AND CodigoEstado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        $this->persistencia->setParametro(1, $txtIdActa, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            return $this->persistencia->getParametro("cantidad_registro");
        }
        return 0;
    }

    /**
     * Existe RegistroGrado
     * @param int $txtCodigoEstudiante, $txtIdActa
     * @access public
     * @return void
     */
    public function buscarRegistroGradoId($txtCodigoEstudiante, $txtIdActa) {
        $sql = "SELECT RegistroGradoId, NumeroDiploma
				FROM RegistroGrado
				WHERE EstudianteId = ?
				AND AcuerdoActaId = ?
				AND CodigoEstado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        $this->persistencia->setParametro(1, $txtIdActa, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $this->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
        }
        $this->persistencia->freeResult();
    }

    /**
     * Consultar Estudiantes con Registro Grado
     * @param int $txtFechaGrado, $txtCodigoCarrera
     * @access public
     * @return void
     */
    public function consultarRegistroGrado($txtFechaGrado, $txtCodigoCarrera) {
        $registroGrados = array();
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Added Order by to avoid different list orders
         * @since  December 21, 2016
         */
        $sql = "SELECT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.nombresestudiantegeneral, ' ', EG.apellidosestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					WHERE F.FechaGradoId = ?
					AND C.codigocarrera = ?
					AND R.CodigoEstado = 100
				ORDER BY R.RegistroGradoId, A.NumeroAcuerdo,EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral  ASC ";
        /* END */

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtFechaGrado, false);
        $this->persistencia->setParametro(1, $txtCodigoCarrera, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Registro Grado
     * @param $filtroDigitalizar
     * @access public
     * @return void
     */
    public function consultarRegistroGradoDigitalizar($filtroDigitalizar) {
        $registroGrados = array();

        /* Modified Diego Rivera<riveradiego@unbosque.edu.co>
         * Se añaden campos D.nombrecortodocumento,EG.numerodocumento y  se relaciona tabla documento
         * Since June 14 ,2017  
         * */


        $sql = "SELECT
					R.RegistroGradoId,
					E.codigoestudiante,
					C.codigocarrera,
					CONCAT(EG.nombresestudiantegeneral, ' ', EG.apellidosestudiantegeneral ) AS Nombre,
					R.NumeroDiploma,
					F.FechaGradoId,
					D.nombrecortodocumento,
					EG.numerodocumento,
					C.nombrecarrera
				FROM 
					RegistroGrado R
				INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
				INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
				INNER JOIN documento D ON (EG.tipodocumento = D.tipodocumento)
				INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
				WHERE";
        // fin modificacion
        $sql .= $filtroDigitalizar;

        $this->persistencia->crearSentenciaSQL($sql);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));


            $actaAcuerdo = new ActaAcuerdo(null);
            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));
            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));


            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setDescripcion($this->persistencia->getParametro("nombrecortodocumento"));

            $estudianteGeneral = new EstudianteGeneral(null);
            $estudianteGeneral->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);
            $registroGrado->setTipoDocumento($tipoDocumento);
            $registroGrado->setEstudianteGeneral($estudianteGeneral);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();
        //ddd($registroGrados);
        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Registro Grado
     * @param $filtroDigitalizar
     * @access public
     * @return cantidadTotalRegistros
     */
    public function totalRegistroGrado($filtroDigitalizar) {
        $sql = "SELECT COUNT(R.RegistroGradoId) AS cantidad_registroGrado 
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					WHERE";

        $sql .= $filtroDigitalizar;

        $this->persistencia->crearSentenciaSQL($sql);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        $cantidad = 0;

        if ($this->persistencia->getNext())
            $cantidad = $this->persistencia->getParametro("cantidad_registroGrado");

        $this->persistencia->freeResult();

        return $cantidad;
    }

    /**
     * Existe RegistroGrado por Estudiante
     * @param int $txtCodigoEstudiante
     * @access public
     * @return existeRegistro
     */
    public function existeRegistroGrado($txtCodigoEstudiante) {
        $sql = "SELECT RegistroGradoId AS registro
				FROM RegistroGrado
				WHERE EstudianteId = ?
				AND CodigoEstado = 100
				UNION
				SELECT idregistrograduado AS registro
				FROM registrograduado
				WHERE codigoestudiante = ?
				AND codigoestado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            $this->setIdRegistroGrado($this->persistencia->getParametro("registro"));
        }
        $this->persistencia->freeResult();
    }

    /**
     * Buscar el Registro de Grado por Estudiante
     * @param int $txtCodigoCarrera, $txtCodigoEstudiante
     * @access public
     * @return RegistroGradoEstudiante
     */
    public function buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante) {

        $sql = "SELECT
					R.RegistroGradoId,
					R.NumeroDiploma,
					F.FechaGradoId, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, F.FechaGrado, A.AcuerdoActaId, A.NumeroActaAcuerdo,
					F.TipoGradoId, C.codigomodalidadacademicasic, C.nombrecortocarrera
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
				INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
				INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
				WHERE C.codigocarrera = ?
				AND E.codigoestudiante = ?
				AND R.CodigoEstado = 100
				";
        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoCarrera, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {

            $this->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $this->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));


            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setIdActaAcuerdo($this->persistencia->getParametro("AcuerdoActaId"));
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));


            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setNombreCortoCarrera($this->persistencia->getParametro("nombrecortocarrera"));

            $modalidadAcademicaSic = new ModalidadSIC(null);
            $modalidadAcademicaSic->setCodigoModalidadAcademicaSic($this->persistencia->getParametro("codigomodalidadacademicasic"));

            $carrera->setModalidadAcademicaSic($modalidadAcademicaSic);

            $tipoGrado = new TipoGrado(null);
            $tipoGrado->setIdTipoGrado($this->persistencia->getParametro("TipoGradoId"));

            $fechaGrado->setCarrera($carrera);

            $fechaGrado->setTipoGrado($tipoGrado);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $this->setActaAcuerdo($actaAcuerdo);
        }
        $this->persistencia->freeResult();
    }

    /**
     * Consultar Estudiantes con Registro Grado
     * @param int $txtFechaGrado, $txtCodigoCarrera
     * @access public
     * @return Array <RegistroGrado>
     */
    public function consultarCeremoniaEgresados($filtro) {
        $registroGrados = array();
        /**
         * @modified Diego Rivera<riveradiego@unbosque.edu.co>
         * Se añade relacion con tabla trabajogrado con el fin obtener el nombre del trabajo de grado del estudiante
         * @since May 20,2019
         */
        $sql = "SELECT
					R.RegistroGradoId,
					E.codigoestudiante,
					C.codigocarrera,
					C.nombrecarrera,
					doc.nombrecortodocumento,
					EG.nombresestudiantegeneral,
					EG.apellidosestudiantegeneral,
					R.NumeroDiploma,
					F.FechaGradoId,
					EG.numerodocumento,
					A.NumeroActaAcuerdo,
					A.NumeroAcuerdo,
					T.nombretitulo,
					A.FechaAcuerdo,
					rin.NombreIncentivoAcademico,
					rin.ObservacionIncentivo,
					rin.CodigoEstado,
                                        TG.nombretrabajodegrado
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON (
					E.codigoestudiante = R.EstudianteId
				)
				INNER JOIN estudiantegeneral EG ON (
					EG.idestudiantegeneral = E.idestudiantegeneral
				)
				INNER JOIN documento doc ON (
					EG.tipodocumento = doc.tipodocumento
				)
				INNER JOIN AcuerdoActa A ON (
					A.AcuerdoActaId = R.AcuerdoActaId
				)
				INNER JOIN FechaGrado F ON (
					F.FechaGradoId = A.FechaGradoId
				)
				INNER JOIN carrera C ON (
					C.codigocarrera = F.CarreraId
				)
				INNER JOIN facultad FT ON (
					FT.codigofacultad = C.codigofacultad
				)
				INNER JOIN titulo T ON (
					T.codigotitulo = C.codigotitulo
				)
                                INNER JOIN trabajodegrado TG ON (
                                        E.codigoestudiante =TG.codigoestudiante
                                )
				LEFT JOIN RegistroIncentivo rin ON (E.codigoestudiante  = rin.EstudianteId )
				WHERE 1 = 1";



        $sql .= $filtro;

        $sql .= " ORDER BY  C.nombrecarrera , EG.apellidosestudiantegeneral   ASC";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->getSQLListo();
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {

            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setTrabjoGrado($this->persistencia->getParametro("nombretrabajodegrado"));


            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $tituloProfesion = new Titulo(null);
            $tituloProfesion->setNombreTitulo($this->persistencia->getParametro("nombretitulo"));

            $carrera->setTituloProfesion($tituloProfesion);

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);

            $incentivoAcademico = new IncentivoAcademico(null);
            $incentivoAcademico->setNombreIncentivo($this->persistencia->getParametro("NombreIncentivoAcademico"));
            $incentivoAcademico->setObservacionIncentivo($this->persistencia->getParametro("ObservacionIncentivo"));
            $incentivoAcademico->setEstadoIncentivo($this->persistencia->getParametro("CodigoEstado"));


            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("nombrecortodocumento"));

            $estudiante->setTipoDocumento($tipoDocumento);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $estudiante->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);

            $registroGrado->setIncentivoAcademico($incentivoAcademico);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Numero de Graduados
     * @param $filtro
     * @access public
     * @return Array RegistroGrado
     */
    public function consultarNumeroGraduados($filtro, $filtroSubConsulta) {

        $registroGrados = array();

        $sql = "SELECT C.nombrecarrera, COUNT(R.RegistroGradoId) AS RegistroGradoId,
					(
						SELECT
							COUNT(*)
						FROM
							RegistroGrado R
						INNER JOIN estudiante E ON (
							E.codigoestudiante = R.EstudianteId
						)
						INNER JOIN estudiantegeneral EG ON (
							EG.idestudiantegeneral = E.idestudiantegeneral
						)
						INNER JOIN AcuerdoActa A ON (
							A.AcuerdoActaId = R.AcuerdoActaId
						)
						INNER JOIN FechaGrado F ON (
							F.FechaGradoId = A.FechaGradoId
						)
						INNER JOIN carrera Carr ON (
							Carr.codigocarrera = F.CarreraId
						)
						INNER JOIN facultad FT ON (
							FT.codigofacultad = Carr.codigofacultad
						)
						WHERE
							1 = 1
						AND EG.codigogenero = 100
						AND Carr.codigocarrera = C.codigocarrera";

        $sql .= $filtroSubConsulta;

        $sql .= " GROUP BY
							C.codigocarrera
					) AS mujer,
					(
						SELECT
							COUNT(*)
						FROM
							RegistroGrado R
						INNER JOIN estudiante E ON (
							E.codigoestudiante = R.EstudianteId
						)
						INNER JOIN estudiantegeneral EG ON (
							EG.idestudiantegeneral = E.idestudiantegeneral
						)
						INNER JOIN AcuerdoActa A ON (
							A.AcuerdoActaId = R.AcuerdoActaId
						)
						INNER JOIN FechaGrado F ON (
							F.FechaGradoId = A.FechaGradoId
						)
						INNER JOIN carrera Carr ON (
							Carr.codigocarrera = F.CarreraId
						)
						INNER JOIN facultad FT ON (
							FT.codigofacultad = Carr.codigofacultad
						)
						WHERE
							1 = 1
						AND Carr.codigocarrera = C.codigocarrera
						AND EG.codigogenero = 200";
        $sql .= $filtroSubConsulta;
        $sql .= " GROUP BY
								C.codigocarrera
						) AS hombre
						
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					INNER JOIN facultad FT ON (FT.codigofacultad = C.codigofacultad)
					WHERE 1 = 1 ";

        $sql .= $filtro;

        $sql .= " GROUP BY C.codigocarrera";

        $this->persistencia->crearSentenciaSQL($sql);
        //echo 	$this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));

            $actaAcuerdo = new ActaAcuerdo(null);

            $fechaGrado = new FechaGrado(null);


            $carrera = new Carrera(null);
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $registroGrado->setActaAcuerdo($actaAcuerdo);

            $registroGrado->setConteoGradosMujer($this->persistencia->getParametro("mujer"));
            $registroGrado->setConteoGradosHombre($this->persistencia->getParametro("hombre"));
            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Existe el Registro de Grado por Estudiante
     * @param int $txtCodigoCarrera, $txtCodigoEstudiante
     * @access public
     * @return Cantidad RegistroGrado
     */
    public function contarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante) {

        $sql = "SELECT
					COUNT(R.RegistroGradoId) AS cantidad_registroGrado
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
				INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
				INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
				WHERE C.codigocarrera = ?
				AND E.codigoestudiante = ?";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoCarrera, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        $cantidad = 0;

        if ($this->persistencia->getNext())
            $cantidad = $this->persistencia->getParametro("cantidad_registroGrado");

        $this->persistencia->freeResult();

        return $cantidad;
    }

    /**
     * Estudiantes sin Foliar
     * @access public
     * @return RegistrodGradoId
     */
    public function estudiantesSinFolio() {
        $registroGrados = array();
        $sql = "SELECT
					rg.RegistroGradoId
				FROM
					RegistroGrado rg
				WHERE
					rg.RegistroGradoId NOT IN (
						SELECT
							rg.RegistroGradoId
						FROM
							registrograduadofolio rgf,
							detalleregistrograduadofolio drgf,
							RegistroGrado rg
						WHERE
							drgf.idregistrograduadofolio = rgf.idregistrograduadofolio
						AND drgf.idregistrograduado = rg.RegistroGradoId
					)
				ORDER BY
					rg.RegistroGradoId";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoCarrera, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));

            $registroGrados[count($registroGrados)] = $registroGrado;
        }

        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Anular Registro Grado
     * @param int $txtIdRegistroGrado, $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function anularRegistroGrado($txtIdRegistroGrado, $txtCodigoEstudiante) {

        $sql = "UPDATE RegistroGrado
				SET CodigoEstado = 200
				WHERE RegistroGradoId = ?
				AND EstudianteId = ?";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $txtIdRegistroGrado, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( );
        $estado = $this->persistencia->ejecutarUpdate();

        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        //$this->persistencia->freeResult( );
        return $estado;
    }

    /**
     * Anular Registro Grado
     * @param int $txtIdRegistroGrado, $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function actualizarDiploma($txtIdRegistroGrado, $txtNumeroDiploma2, $txtCodigoEstudiante) {

        $sql = "UPDATE RegistroGrado
				SET NumeroDiploma = ?
				WHERE RegistroGradoId = ?
				AND EstudianteId = ?";

        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->setParametro(0, $txtNumeroDiploma2, true);
        $this->persistencia->setParametro(1, $txtIdRegistroGrado, false);
        $this->persistencia->setParametro(2, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( );
        $estado = $this->persistencia->ejecutarUpdate();

        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        //$this->persistencia->freeResult( );
        return $estado;
    }

    /**
     * Existe RegistroGradoId por FechaGrado
     * @param int $txtFechaGrado
     * @access public
     * @return void
     */
    public function buscarRegistroGradoFechaGrado($txtFechaGrado) {
        $sql = "SELECT COUNT(RegistroGradoId) cantidad_registroFechaGrado
				FROM RegistroGrado R
				INNER JOIN AcuerdoActa AC ON ( AC.AcuerdoActaId = R.AcuerdoActaId )
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = AC.FechaGradoId )
				WHERE F.FechaGradoId = ?
				AND R.CodigoEstado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtFechaGrado, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {
            return $this->persistencia->getParametro("cantidad_registroFechaGrado");
        }
        return 0;
    }

    /**
     * Consultar Estudiantes con Registro Grado sin Folio
     * @param int $txtFechaGrado, $txtCodigoCarrera
     * @access public
     * @return void
     */
    /*
     * IVAN DARIO QUINTERO RIOS <quinteroivan@unbosque.edu.co>
     * modificado julio 6 del 2017 - 19:29:00
     * SE MODIFICA LA VAIRBLE DEL ACUERDO ACTA ID POR EL NUMERO DE ACUERDO 
     */
    public function consultarRegistroGradoFolio($txtCodigoCarrera, $txtNumeroacuerdo) {
        $registroGrados = array();
        $sql = "SELECT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion, A.NumeroActaAcuerdo, T.nombretitulo, A.AcuerdoActaId
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					INNER JOIN titulo T ON ( T.codigotitulo = C.codigotitulo )
					WHERE R.RegistroGradoId NOT IN
							(SELECT R.RegistroGradoId
							FROM
							registrograduadofolio rgf,
							detalleregistrograduadofolio drgf,
							RegistroGrado R
							WHERE
							drgf.idregistrograduadofolio=rgf.idregistrograduadofolio
							AND drgf.idregistrograduado=R.RegistroGradoId
							)
					AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
																	FROM DetalleAcuerdoActa DAC
																	WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
																	AND DAC.CodigoEstado = 100 )
					AND R.CodigoEstado = 100
					AND C.codigocarrera = ?
					AND A.NumeroAcuerdo = ?
							ORDER BY R.RegistroGradoId";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoCarrera, false);
        $this->persistencia->setParametro(1, $txtNumeroacuerdo, false);
        /* END */
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            /** SE AGREGA LA SIGUIENTE LINEA* */
            $actaAcuerdo->setIdActaAcuerdo($this->persistencia->getParametro("AcuerdoActaId"));
            /* END */
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $tituloProfesion = new Titulo(null);
            $tituloProfesion->setNombreTitulo($this->persistencia->getParametro("nombretitulo"));

            $carrera->setTituloProfesion($tituloProfesion);

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Incentivos
     * @param int $txtFechaGrado
     * @access public
     * @return void
     */
    public function consultarRegistroGradoIncentivo($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera) {
        $registroGrados = array();
        $sql = "SELECT DISTINCT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion, A.NumeroActaAcuerdo, RC.IncentivoAcademicoId,
					I.nombreincentivoacademico, RC.CodigoEstado, RC.NumeroActaAcuerdoIncentivo, RC.NumeroAcuerdoIncentivo, RC.FechaAcuerdoIncentivo
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN RegistroIncentivo RC ON ( RC.EstudianteId = E.codigoestudiante )
					INNER JOIN incentivoacademico I ON ( I.idincentivoacademico = RC.IncentivoAcademicoId )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					WHERE 
					A.NumeroAcuerdo = ?
					AND C.codigocarrera = ?
					AND RC.CodigoEstado = 100
					AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
																	FROM DetalleAcuerdoActa DAC
																	WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
																	AND DAC.CodigoEstado = 100 )
					
					";

        $this->persistencia->crearSentenciaSQL($sql);
        //$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
        $this->persistencia->setParametro(0, $txtIdAcuerdoActa, false);
        $this->persistencia->setParametro(1, $txtCodigoCarrera, false);
        //$this->persistencia->setParametro( 3 , $txtIdAcuerdoActa, false );

        /* if( $txtIdAcuerdoActa == 14805 ){
          echo $this->persistencia->getSQLListo( )."<br /><br />";
          } */
        //echo $this->persistencia->getSQLListo( )."<br /><br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $incentivoAcademico = new IncentivoAcademico(null);
            $incentivoAcademico->setCodigoIncentivo($this->persistencia->getParametro("IncentivoAcademicoId"));
            $incentivoAcademico->setNombreIncentivo($this->persistencia->getParametro("nombreincentivoacademico"));
            $incentivoAcademico->setEstadoIncentivo($this->persistencia->getParametro("CodigoEstado"));
            $incentivoAcademico->setNumeroActaAcuerdoIncentivo($this->persistencia->getParametro("NumeroActaAcuerdoIncentivo"));
            $incentivoAcademico->setNumeroAcuerdoIncentivo($this->persistencia->getParametro("NumeroAcuerdoIncentivo"));
            $incentivoAcademico->setFechaAcuerdoIncentivo($this->persistencia->getParametro("FechaAcuerdoIncentivo"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);
            $registroGrado->setIncentivoAcademico($incentivoAcademico);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Registro Grado sin Folio
     * @param int $txtFechaGrado, $txtCodigoCarrera
     * @access public
     * @return void
     */
    public function consultarRegistroGradoFolioCarrera() {
        $registroGrados = array();
        $sql = "SELECT DISTINCT C.codigocarrera, F.FechaGradoId, A.NumeroActaAcuerdo, A.FechaAcuerdo, A.NumeroAcuerdo, C.codigomodalidadacademicasic
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					INNER JOIN titulo T ON ( T.codigotitulo = C.codigotitulo )
					WHERE R.RegistroGradoId NOT IN
							(SELECT R.RegistroGradoId
							FROM
							registrograduadofolio rgf,
							detalleregistrograduadofolio drgf,
							RegistroGrado R
							WHERE
							drgf.idregistrograduadofolio=rgf.idregistrograduadofolio
							AND drgf.idregistrograduado=R.RegistroGradoId
							)
					AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
																	FROM DetalleAcuerdoActa DAC
																	WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
																	AND DAC.CodigoEstado = 100 )
					AND R.CodigoEstado = 100
					GROUP BY C.codigocarrera, A.NumeroAcuerdo
							ORDER BY R.RegistroGradoId";
        //en los datosd e consulta y en el group by A.AcuerdoActaId

        $this->persistencia->crearSentenciaSQL($sql);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);


            $actaAcuerdo = new ActaAcuerdo(null);
            //$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));

            $modalidadAcademicaSic = new ModalidadSIC(null);
            $modalidadAcademicaSic->setCodigoModalidadAcademicaSic($this->persistencia->getParametro("codigomodalidadacademicasic"));

            $carrera->setModalidadAcademicaSic($modalidadAcademicaSic);

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);



            $registroGrado->setActaAcuerdo($actaAcuerdo);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Incentivos Mencion de Honor
     * @param int txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIdAcuerdoActa
     * @access public
     * @return void
     */
    public function consultarRegistroGradoIncentivoMH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoId) {
        $registroGrados = array();
        $sql = "SELECT DISTINCT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion, A.NumeroActaAcuerdo, RC.IncentivoAcademicoId,
					I.nombreincentivoacademico, RC.CodigoEstado, RC.NumeroActaAcuerdoIncentivo, RC.NumeroAcuerdoIncentivo, RC.FechaAcuerdoIncentivo
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN RegistroIncentivo RC ON ( RC.EstudianteId = E.codigoestudiante )
					INNER JOIN incentivoacademico I ON ( I.idincentivoacademico = RC.IncentivoAcademicoId )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					WHERE 
					A.NumeroAcuerdo = ?
					AND C.codigocarrera = ?
					AND RC.CodigoEstado = 100
					AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
																	FROM DetalleAcuerdoActa DAC
																	WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
																	AND DAC.CodigoEstado = 100 )
					AND RC.IncentivoAcademicoId = ?
					";

        $this->persistencia->crearSentenciaSQL($sql);
        //	$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
        $this->persistencia->setParametro(0, $txtIdAcuerdoActa, false);
        $this->persistencia->setParametro(1, $txtCodigoCarrera, false);
        //$this->persistencia->setParametro( 3 , $txtIdAcuerdoActa, false );
        $this->persistencia->setParametro(2, $txtIncentivoId, false);

        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $incentivoAcademico = new IncentivoAcademico(null);
            $incentivoAcademico->setCodigoIncentivo($this->persistencia->getParametro("IncentivoAcademicoId"));
            $incentivoAcademico->setNombreIncentivo($this->persistencia->getParametro("nombreincentivoacademico"));
            $incentivoAcademico->setEstadoIncentivo($this->persistencia->getParametro("CodigoEstado"));
            $incentivoAcademico->setNumeroActaAcuerdoIncentivo($this->persistencia->getParametro("NumeroActaAcuerdoIncentivo"));
            $incentivoAcademico->setNumeroAcuerdoIncentivo($this->persistencia->getParametro("NumeroAcuerdoIncentivo"));
            $incentivoAcademico->setFechaAcuerdoIncentivo($this->persistencia->getParametro("FechaAcuerdoIncentivo"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);
            $registroGrado->setIncentivoAcademico($incentivoAcademico);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes con Incentivos Grado de Honor
     * @param int $txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIdAcuerdoActa
     * @access public
     * @return void
     */
    public function consultarRegistroGradoIncentivoGH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoIdOtro) {
        $registroGrados = array();
        $sql = "SELECT DISTINCT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion, A.NumeroActaAcuerdo, RC.IncentivoAcademicoId,
					I.nombreincentivoacademico, RC.CodigoEstado, RC.NumeroActaAcuerdoIncentivo, RC.NumeroAcuerdoIncentivo, RC.FechaAcuerdoIncentivo
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN RegistroIncentivo RC ON ( RC.EstudianteId = E.codigoestudiante )
					INNER JOIN incentivoacademico I ON ( I.idincentivoacademico = RC.IncentivoAcademicoId )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					WHERE 
					A.NumeroAcuerdo = ?
					AND C.codigocarrera = ?
					AND RC.CodigoEstado = 100
					AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
																	FROM DetalleAcuerdoActa DAC
																	WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
																	AND DAC.CodigoEstado = 100 )
					AND RC.IncentivoAcademicoId = ?
					";



        $this->persistencia->crearSentenciaSQL($sql);
        //$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
        $this->persistencia->setParametro(0, $txtIdAcuerdoActa, false);
        $this->persistencia->setParametro(1, $txtCodigoCarrera, false);
        //$this->persistencia->setParametro( 3 , $txtIdAcuerdoActa, false );
        $this->persistencia->setParametro(2, $txtIncentivoIdOtro, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $registroGrado->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));

            $fechaGrado->setCarrera($carrera);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $incentivoAcademico = new IncentivoAcademico(null);
            $incentivoAcademico->setCodigoIncentivo($this->persistencia->getParametro("IncentivoAcademicoId"));
            $incentivoAcademico->setNombreIncentivo($this->persistencia->getParametro("nombreincentivoacademico"));
            $incentivoAcademico->setEstadoIncentivo($this->persistencia->getParametro("CodigoEstado"));
            $incentivoAcademico->setNumeroActaAcuerdoIncentivo($this->persistencia->getParametro("NumeroActaAcuerdoIncentivo"));
            $incentivoAcademico->setNumeroAcuerdoIncentivo($this->persistencia->getParametro("NumeroAcuerdoIncentivo"));
            $incentivoAcademico->setFechaAcuerdoIncentivo($this->persistencia->getParametro("FechaAcuerdoIncentivo"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);
            $registroGrado->setIncentivoAcademico($incentivoAcademico);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consulta Incentivos Estudiantes
     * @param int $txtCodigoEstudiante, $txtCodigoCarrera
     * @access public
     * @return String
     */
    public function listarIncentivoEstudianteRegistroGrado($txtCodigoEstudiante, $txtCodigoCarrera) {
        $registroGrados = array();
        $sql = "SELECT
					RC.RegistroIncentivoId,
					RC.IncentivoAcademicoId,
					I.nombreincentivoacademico,
					RC.FechaActaIncentivo,
					RC.NumeroActaIncentivo,
					RC.CodigoEstado,
					RC.NumeroActaAcuerdoIncentivo,
					RC.NumeroAcuerdoIncentivo,
					RC.FechaAcuerdoIncentivo,
					RC.NumeroConsecutivoIncentivo,
					RC.ObservacionIncentivo, 
					R.NumeroPromocion
				FROM
					RegistroGrado R
				INNER JOIN RegistroIncentivo RC ON ( RC.EstudianteId = R.EstudianteId )
				INNER JOIN incentivoacademico I ON ( I.idincentivoacademico = RC.IncentivoAcademicoId )
				WHERE
					RC.EstudianteId = ?
				AND RC.CarreraId = ?
				AND RC.CodigoEstado = 100";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        $this->persistencia->setParametro(1, $txtCodigoCarrera, false);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {
            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));

            $incentivoAcademico = new IncentivoAcademico(null);
            $incentivoAcademico->setIdIncentivo($this->persistencia->getParametro("RegistroIncentivoId"));
            $incentivoAcademico->setCodigoIncentivo($this->persistencia->getParametro("IncentivoAcademicoId"));
            $incentivoAcademico->setNombreIncentivo($this->persistencia->getParametro("nombreincentivoacademico"));
            $incentivoAcademico->setFechaActaIncentivo($this->persistencia->getParametro("FechaActaIncentivo"));
            $incentivoAcademico->setNumeroActaIncentivo($this->persistencia->getParametro("NumeroActaIncentivo"));
            $incentivoAcademico->setEstadoIncentivo($this->persistencia->getParametro("CodigoEstado"));
            $incentivoAcademico->setNumeroActaAcuerdoIncentivo($this->persistencia->getParametro("NumeroActaAcuerdoIncentivo"));
            $incentivoAcademico->setNumeroAcuerdoIncentivo($this->persistencia->getParametro("NumeroAcuerdoIncentivo"));
            $incentivoAcademico->setFechaAcuerdoIncentivo($this->persistencia->getParametro("FechaAcuerdoIncentivo"));
            $incentivoAcademico->setNumeroConsecutivoIncentivo($this->persistencia->getParametro("NumeroConsecutivoIncentivo"));
            $incentivoAcademico->setObservacionIncentivo($this->persistencia->getParametro("ObservacionIncentivo"));

            $registroGrado->setIncentivoAcademico($incentivoAcademico);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }

        $this->persistencia->freeResult();

        return $registroGrados;
    }

    /**
     * Consultar Estudiantes por txtCodigoEstudiante
     * @param int $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function consultarRegistroGradoFormulario($txtCodigoEstudiante) {

        $sql = "SELECT DISTINCT R.RegistroGradoId, E.codigoestudiante, C.codigocarrera, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre,
					R.NumeroDiploma, F.FechaGradoId, C.nombrecarrera, A.NumeroActa, A.NumeroAcuerdo, A.FechaActa, A.FechaAcuerdo, 
					F.FechaGrado, EG.expedidodocumento, R.CodigoEstado, EG.numerodocumento, R.NumeroPromocion, A.NumeroActaAcuerdo, 
					R.FechaCreacion, T.nombretipogrado, C.nombrecortocarrera, CONCAT(D.nombresdirectivo,' ',D.apellidosdirectivo ) as directivo
					FROM RegistroGrado R
					INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId )
					INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral )
					INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId )
					INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
					INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
					INNER JOIN tipogrado T ON (T.idtipogrado = F.TipoGradoId)
					INNER JOIN directivo D ON ( D.iddirectivo = R.DirectivoId )
					WHERE E.codigoestudiante = ?
					";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $txtCodigoEstudiante, false);
        //echo $this->persistencia->getSQLListo( )."<br />";
        $this->persistencia->ejecutarConsulta();
        if ($this->persistencia->getNext()) {

            $this->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $this->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));
            $this->setEstadoGrado($this->persistencia->getParametro("CodigoEstado"));
            $this->setNumeroPromocion($this->persistencia->getParametro("NumeroPromocion"));
            $this->setFechaCreacionRegistroGrado($this->persistencia->getParametro("FechaCreacion"));

            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActa($this->persistencia->getParametro("NumeroActa"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $tipoGrado = new TipoGrado(null);
            $tipoGrado->setNombreTipoGrado($this->persistencia->getParametro("nombretipogrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));
            $carrera->setNombreCortoCarrera($this->persistencia->getParametro("nombrecortocarrera"));

            $fechaGrado->setCarrera($carrera);
            $fechaGrado->setTipoGrado($tipoGrado);

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("Nombre"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $directivoRegistroGrado = new Directivo(null);
            $directivoRegistroGrado->setNombreDirectivo($this->persistencia->getParametro("directivo"));

            $this->setActaAcuerdo($actaAcuerdo);
            $this->setEstudiante($estudiante);
            $this->setDirectivoRegistroGrado($directivoRegistroGrado);
        }
        $this->persistencia->freeResult();
    }

    /**
     * Consultar graudados
     * @param  $filtro
     * @access public
     * @return array registroGrados
     */
    public function consultarEgresadosIndexacion($filtro) {
        $registroGrados = array();
        $sql = "SELECT
					E.codigoestudiante,
					doc.nombrecortodocumento,
					EG.numerodocumento,
					EG.nombresestudiantegeneral,
					EG.apellidosestudiantegeneral,
					C.nombrecarrera,
					F.CodigoPeriodo,
					MA.nombremodalidadacademica,
					TG.nombretipogrado
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON (
					E.codigoestudiante = R.EstudianteId
				)
				INNER JOIN estudiantegeneral EG ON (
					EG.idestudiantegeneral = E.idestudiantegeneral
				)
				INNER JOIN documento doc ON (
					EG.tipodocumento = doc.tipodocumento
				)
				INNER JOIN AcuerdoActa A ON (
					A.AcuerdoActaId = R.AcuerdoActaId
				)
				INNER JOIN FechaGrado F ON (
					F.FechaGradoId = A.FechaGradoId
				)
				INNER JOIN tipogrado TG ON ( 
					TG.idtipogrado = F.TipoGradoId
			    ) 
				INNER JOIN carrera C ON (
					C.codigocarrera = F.CarreraId
				)
				INNER join modalidadacademica  MA ON (
					 MA.codigomodalidadacademica = C.codigomodalidadacademica
				)
				INNER JOIN facultad FT ON (
					FT.codigofacultad = C.codigofacultad
				)
			
				WHERE 1 = 1";

        $sql .= $filtro;

        $sql .= " ORDER BY  C.nombrecarrera , EG.apellidosestudiantegeneral   ASC";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {


            $registroGrado = new RegistroGrado($this->persistencia);
            $actaAcuerdo = new ActaAcuerdo(null);
            $fechaGrado = new FechaGrado(null);
            $tipoGrado = new TipoGrado(null);

            $tipoGrado->setNombreTipoGrado($this->persistencia->getParametro("nombretipogrado"));

            $fechaGrado->setPeriodo($this->persistencia->getParametro("CodigoPeriodo"));
            $fechaGrado->setTipoGrado($tipoGrado);
            $carrera = new Carrera(null);

            $modalidadAcanemica = new ModalidadAcademica(null);
            $modalidadAcanemica->setNombreModalidadAcademica($this->persistencia->getParametro("nombremodalidadacademica"));


            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));
            $carrera->setModalidadAcademica($modalidadAcanemica);

            $fechaGrado->setCarrera($carrera);
            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);

            $tipoDocumento = new TipoDocumento(null);
            $tipoDocumento->setIniciales($this->persistencia->getParametro("nombrecortodocumento"));

            $estudiante->setTipoDocumento($tipoDocumento);
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $estudiante->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $estudiante->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);
            $registroGrados[count($registroGrados)] = $registroGrado;
        }

        $this->persistencia->freeResult();
        return $registroGrados;
    }

    public function consultarActaAcuerdo($filtro) {

        $registroGrados = array();

        $sql = "SELECT
					A.NumeroActaAcuerdo,
					A.NumeroAcuerdo,
					A.FechaAcuerdo,
					F.FechaGrado,
					F.FechaGradoId
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON (
					E.codigoestudiante = R.EstudianteId
				)
				INNER JOIN estudiantegeneral EG ON (
					EG.idestudiantegeneral = E.idestudiantegeneral
				)
				INNER JOIN documento doc ON (
					EG.tipodocumento = doc.tipodocumento
				)
				INNER JOIN AcuerdoActa A ON (
					A.AcuerdoActaId = R.AcuerdoActaId
				)
				INNER JOIN FechaGrado F ON (
					F.FechaGradoId = A.FechaGradoId
				)
				INNER JOIN carrera C ON (
					C.codigocarrera = F.CarreraId
				)
				INNER JOIN facultad FT ON (
					FT.codigofacultad = C.codigofacultad
				)
				INNER JOIN titulo T ON (
					T.codigotitulo = C.codigotitulo
				)
				WHERE
					1 = 1";

        $sql .= $filtro;

        $sql .= " GROUP BY
					A.NumeroActaAcuerdo,
					A.NumeroAcuerdo,
					A.FechaAcuerdo";
        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {

            $registroGrado = new RegistroGrado($this->persistencia);


            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $actaAcuerdo->setFechaGrado($fechaGrado);

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    public function detalleConsultarActaAcuerdo($filtro) {
        $registroGrados = array();
        $sql = "SELECT
					R.RegistroGradoId,
					EG.apellidosestudiantegeneral,
					EG.nombresestudiantegeneral,
					EG.expedidodocumento,
					EG.numerodocumento,
					R.NumeroDiploma,
					TF.folio,
          E.codigoestudiante
					
				FROM
					RegistroGrado R
				INNER JOIN estudiante E ON (
					E.codigoestudiante = R.EstudianteId
				)
				INNER JOIN estudiantegeneral EG ON (
					EG.idestudiantegeneral = E.idestudiantegeneral
				)
				INNER JOIN documento doc ON (
					EG.tipodocumento = doc.tipodocumento
				)
				INNER JOIN AcuerdoActa A ON (
					A.AcuerdoActaId = R.AcuerdoActaId
				)
				INNER JOIN FechaGrado F ON (
					F.FechaGradoId = A.FechaGradoId
				)
				INNER JOIN carrera C ON (
					C.codigocarrera = F.CarreraId
				)
				INNER JOIN facultad FT ON (
					FT.codigofacultad = C.codigofacultad
				)
				INNER JOIN titulo T ON (
					T.codigotitulo = C.codigotitulo
				)
				INNER JOIN foliotemporal TF on ( R.RegistroGradoId = TF.idregistrograduado )
				WHERE
					1 = 1";

        $sql .= $filtro;

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {


            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setFolio($this->persistencia->getParametro("folio"));
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));

            $estudiante = new Estudiante(null);

            $estudiante->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $estudiante->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));
            $estudiante->setExpedicion($this->persistencia->getParametro("expedidodocumento"));
            $estudiante->setCodigoEstudiante($this->persistencia->getParametro("codigoestudiante"));
            $registroGrado->setEstudiante($estudiante);
            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();
        return $registroGrados;
    }

    public function consultarCarrerasActaAcuerdo($filtro) {

        $registroGrados = array();

        $sql = "SELECT
          
           C.codigocarrera,C.nombrecortocarrera

        FROM
          RegistroGrado R
        INNER JOIN estudiante E ON (
          E.codigoestudiante = R.EstudianteId
        )
        INNER JOIN estudiantegeneral EG ON (
          EG.idestudiantegeneral = E.idestudiantegeneral
        )
        INNER JOIN documento doc ON (
          EG.tipodocumento = doc.tipodocumento
        )
        INNER JOIN AcuerdoActa A ON (
          A.AcuerdoActaId = R.AcuerdoActaId
        )
        INNER JOIN FechaGrado F ON (
          F.FechaGradoId = A.FechaGradoId
        )
        INNER JOIN carrera C ON (
          C.codigocarrera = F.CarreraId
        )
        INNER JOIN facultad FT ON (
          FT.codigofacultad = C.codigofacultad
        )
        INNER JOIN titulo T ON (
          T.codigotitulo = C.codigotitulo
        )
        WHERE
          1 = 1";

        $sql .= $filtro;

        $sql .= " GROUP BY
          C.nombrecortocarrera;";
        $this->persistencia->crearSentenciaSQL($sql);

        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {

            $registroGrado = new RegistroGrado($this->persistencia);

            $actaAcuerdo = new ActaAcuerdo(null);

            $fechaGrado = new FechaGrado(null);

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecortocarrera"));

            $fechaGrado->setCarrera($carrera);
            $actaAcuerdo->setFechaGrado($fechaGrado);
            $registroGrado->setActaAcuerdo($actaAcuerdo);

            $registroGrados[count($registroGrados)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroGrados;
    }

    public function buscarPromocion($codigoCarrera, $codigoPeriodo, $tipoGrado) {

        $sql = "SELECT count(*) as numeroRegistros,"
                . "rg.NumeroPromocion "
                . "FROM "
                . "RegistroGrado rg "
                . "INNER JOIN AcuerdoActa ac ON ( rg.AcuerdoActaId = ac.AcuerdoActaId ) "
                . "INNER JOIN FechaGrado fg ON ( ac.FechaGradoId = fg.FechaGradoId ) "
                . "WHERE "
                . "fg.CodigoPeriodo = ? "
                . "AND fg.CarreraId = ? "
                . "AND fg.TipoGradoId = ? "
                . "GROUP BY "
                . "rg.NumeroPromocion";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $codigoPeriodo, false);
        $this->persistencia->setParametro(1, $codigoCarrera, false);
        $this->persistencia->setParametro(2, $tipoGrado, false);
        $this->persistencia->ejecutarConsulta( );
        if( $this->persistencia->getNext( ) ){
                $this->setNumeroPromocion( $this->persistencia->getParametro( "NumeroPromocion" ) );
                $this->setContadorRegistros($this->persistencia->getParametro( "numeroRegistros" ) );
        }
        $this->persistencia->freeResult( );
     
    }

    public function actualizarPromocion($codigoCarrera, $codigoPeriodo, $tipoGrado, $numeroPromocion) {
        $sql = "UPDATE "
                . " RegistroGrado rg "
                . "INNER JOIN AcuerdoActa ac ON ( rg.AcuerdoActaId = ac.AcuerdoActaId ) "
                . "INNER JOIN FechaGrado fg ON ( ac.FechaGradoId = fg.FechaGradoId ) "
                . "SET rg.NumeroPromocion = ? "
                . "WHERE "
                . "fg.CodigoPeriodo = ? "
                . "AND fg.CarreraId = ? "
                . "AND fg.TipoGradoId = ?";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->setParametro(0, $numeroPromocion, true);
        $this->persistencia->setParametro(1, $codigoPeriodo, false);
        $this->persistencia->setParametro(2, $codigoCarrera, false);
        $this->persistencia->setParametro(3, $tipoGrado, false);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarUpdate();
        return $this->persistencia->affectRow();
    }


    /**
     * Consultar Estudiantes Graduados de la Carrera de Psicologia
     * @param $filtro
     * @access public
     * @return Array <registroColegioPsicologia>
     * @author Lina Quintero<quinterolina@unbosque.edu.co>
     */
    public function consultarColegioPsicologia($filtro) {
        $registroColegioPsicologia = array();

        $sql = "SELECT  
            EG.numerodocumento,
            EG.nombresestudiantegeneral,
            EG.apellidosestudiantegeneral,
           
            F.FechaGradoId,
            F.FechaGrado,
            A.NumeroActa, 
            A.NumeroAcuerdo,
            A.NumeroActaAcuerdo, 
            A.FechaActa, 
            A.FechaAcuerdo,
            R.NumeroDiploma, 
            R.RegistroGradoId,
            C.codigocarrera,
            C.nombrecarrera
        FROM RegistroGrado R 
        INNER JOIN estudiante E ON ( E.codigoestudiante = R.EstudianteId ) 
        INNER JOIN estudiantegeneral EG ON ( EG.idestudiantegeneral = E.idestudiantegeneral ) 
        INNER JOIN documento doc ON ( EG.tipodocumento = doc.tipodocumento ) 
        INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = R.AcuerdoActaId ) 
        INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId ) 
        INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId ) 
        INNER JOIN facultad FT ON ( FT.codigofacultad = C.codigofacultad ) 
        INNER JOIN titulo T ON ( T.codigotitulo = C.codigotitulo ) 
        INNER JOIN trabajodegrado TG ON ( E.codigoestudiante =TG.codigoestudiante ) 
        LEFT JOIN RegistroIncentivo rin ON (E.codigoestudiante = rin.EstudianteId ) 
        INNER JOIN carreraregistro CR ON(C.codigocarrera = CR.codigocarrera)
        WHERE 1 = 1 ";

        $sql .= $filtro;
        $sql .= " GROUP BY EG.numerodocumento ";
        $sql .= " ORDER BY  C.nombrecarrera , EG.apellidosestudiantegeneral   ASC";

        $this->persistencia->crearSentenciaSQL($sql);
        $this->persistencia->getSQLListo();
        $this->persistencia->ejecutarConsulta();
        while ($this->persistencia->getNext()) {

            $registroGrado = new RegistroGrado($this->persistencia);
            $registroGrado->setIdRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $registroGrado->setNumeroDiploma($this->persistencia->getParametro("NumeroDiploma"));


            $actaAcuerdo = new ActaAcuerdo(null);
            $actaAcuerdo->setNumeroActaConsejoDirectivo($this->persistencia->getParametro("NumeroActaAcuerdo"));
            $actaAcuerdo->setNumeroAcuerdo($this->persistencia->getParametro("NumeroAcuerdo"));
            $actaAcuerdo->setFechaActa($this->persistencia->getParametro("FechaActa"));
            $actaAcuerdo->setFechaAcuerdo($this->persistencia->getParametro("FechaAcuerdo"));
            

            $fechaGrado = new FechaGrado(null);
            $fechaGrado->setIdFechaGrado($this->persistencia->getParametro("FechaGradoId"));
            $fechaGrado->setFechaGraduacion($this->persistencia->getParametro("FechaGrado"));

            $carrera = new Carrera(null);
            $carrera->setCodigoCarrera($this->persistencia->getParametro("codigocarrera"));
            $carrera->setNombreCarrera($this->persistencia->getParametro("nombrecarrera"));
           

            $fechaGrado->setCarrera($carrera);
            $actaAcuerdo->setFechaGrado($fechaGrado);

            $estudiante = new Estudiante(null);

            $estudiante->setNombreEstudiante($this->persistencia->getParametro("nombresestudiantegeneral"));
            $estudiante->setApellidoEstudiante($this->persistencia->getParametro("apellidosestudiantegeneral"));
            $estudiante->setNumeroDocumento($this->persistencia->getParametro("numerodocumento"));

            $registroGrado->setActaAcuerdo($actaAcuerdo);
            $registroGrado->setEstudiante($estudiante);

            $registroColegioPsicologia[count($registroColegioPsicologia)] = $registroGrado;
        }
        $this->persistencia->freeResult();

        return $registroColegioPsicologia ;
    }

}

?>