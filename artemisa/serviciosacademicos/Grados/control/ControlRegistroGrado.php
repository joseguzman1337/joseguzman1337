<?php

/**
 * Agosto 3, 2017
 * @author Carlos Alberto Suarez Garrido	<suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidades
 */
include '../entidades/RegistroGrado.php';
include '../entidades/Diploma.php';
include '../../../kint/Kint.class.php';

class ControlRegistroGrado {

    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function ControlRegistroGrado($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Insertar Acta de Grado
     * @param int $txtNumeroActaGrado, $idPersona
     * @access public
     * @return boolean
     */
    public function crearRegistroGrado($txtCodigoEstudiante, $txtIdActaGrado, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona) {
        $registroGrado = new RegistroGrado($this->persistencia);
        $registroGrado->crearRegistroGrado($txtCodigoEstudiante, $txtIdActaGrado, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona);
        return $registroGrado;
    }

    /**
     * Consula si el registro de grado del estudiante ya existe 
     * @access public
     * @return INT
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     */
    public function consultarExisteRegistroGrado($txtCodigoEstudiante, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarExisteRegistroGrado($txtCodigoEstudiante, $txtIdAcuerdoActa, $txtNumeroDiploma, $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona);
    }

    /**
     * Buscar si existe Registro de Grado de Estudiante
     * @param int $txtIdActa, $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function buscarRegistroGradoEstudiante($txtCodigoEstudiante, $txtIdActa) {
        $registroGrado = new RegistroGrado($this->persistencia);
        if ($registroGrado->buscarRegistroGradoEstudiante($txtCodigoEstudiante, $txtIdActa) != 0) {
            $registroGrado = "../css/images/circuloVerde.png";
        } else {
            $registroGrado = "../css/images/circuloRojo.png";
        }
        return $registroGrado;
    }

    /**
     * Buscar identificador de Registro de Grado por Estudiante
     * @param int $txtCodigoEstudiante, $txtIdActa
     * @access public
     * @return void
     */
    public function buscarRegistroGradoId($txtCodigoEstudiante, $txtIdActa) {
        $registroGrado = new RegistroGrado($this->persistencia);
        $registroGrado->buscarRegistroGradoId($txtCodigoEstudiante, $txtIdActa);
        return $registroGrado;
    }

    /**
     * Consulta Estudiantes Registro de Grado
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGrado($txtFechaGrado, $txtCodigoCarrera) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGrado($txtFechaGrado, $txtCodigoCarrera);
    }

    /**
     * Consulta Estudiantes Registro de Grado
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoDigitalizar($filtroDigitalizar) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoDigitalizar($filtroDigitalizar);
    }

    /**
     * Contar Total de Registro Grado
     * @param $filtroDigitalizar
     * @access public
     * @return void
     */
    public function totalRegistroGrado($filtroDigitalizar) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->totalRegistroGrado($filtroDigitalizar);
    }

    /**
     * Existe RegistroGrado por Estudiante
     * @param int $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function existeRegistroGrado($txtCodigoEstudiante) {
        $registroGrado = new RegistroGrado($this->persistencia);
        $registroGrado->existeRegistroGrado($txtCodigoEstudiante);
        return $registroGrado;
    }

    /**
     * Buscar RegistroGrado por Estudiante
     * @param int $txtCodigoCarrera, $txtCodigoEstudiante
     * @access public
     * @return void
     */
    public function buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante) {
        $registroGrado = new RegistroGrado($this->persistencia);
        $registroGrado->buscarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
        return $registroGrado;
    }

    /**
     * Consulta Estudiantes Ceremonia
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarCeremoniaEgresados($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarCeremoniaEgresados($filtro);
    }

    /**
     * Consulta Cantidad de Graduados
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarNumeroGraduados($filtro, $filtroSubConsulta) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarNumeroGraduados($filtro, $filtroSubConsulta);
    }

    /**
     * Existe Secretaria
     * @param $txtUsuario
     * @access public
     * @return void 
     */
    public function contarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->contarRegistroGradoCarreraEstudiante($txtCodigoCarrera, $txtCodigoEstudiante);
    }

    /**
     * Anular Registro Grado
     * @param int txtIdDetalleActa
     * @access public
     * @return boolean
     */
    public function actualizarDiploma($txtIdRegistroGrado, $txtNumeroDiplomaAnterior, $txtObservacionDiploma, $txtNumeroDiploma2, $txtCodigoEstudiante) {
        $registroGrado = new RegistroGrado($this->persistencia);

        $diploma = new Diploma($this->persistencia);
        $diploma->creaDiplomaNuevo($txtIdRegistroGrado, $txtNumeroDiplomaAnterior, $txtObservacionDiploma);


        $registroGrado->actualizarDiploma($txtIdRegistroGrado, $txtNumeroDiploma2, $txtCodigoEstudiante);

        return $registroGrado;
    }

    /**
     * Existe RegistroGradoId por FechaGrado
     * @param $txtFechaGrado
     * @access public
     * @return void
     */
    public function buscarRegistroGradoFechaGrado($txtFechaGrado) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->buscarRegistroGradoFechaGrado($txtFechaGrado);
    }

    /**
     * Consulta Estudiantes Registro de Grado sin Folio
     * @access public
     * @return Array<RegistroGrado>
     */
    /*
     * IVAN DARIO QUINTERO RIOS <quinteroivan@unbosque.edu.co>
     * modificado julio 6 del 2017
     * SE MODIFICA LA VARIABLE DE ACTAACUERDOID POR NUMEROACUERDO
     */
    public function consultarRegistroGradoFolio($txtCodigoCarrera, $txtNumeroacuerdo) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoFolio($txtCodigoCarrera, $txtNumeroacuerdo);
    }

    /* END */

    /**
     * Consulta Estudiantes con Incentivos Registro de Grado sin Folio
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoIncentivo($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoIncentivo($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera);
    }

    /**
     * Consulta Estudiantes Registro de Grado sin Folio por Carrera
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoFolioCarrera() {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoFolioCarrera();
    }

    /**
     * Consulta Estudiantes con Incentivos Registro de Grado Mencion de Honor
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoIncentivoMH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoId) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoIncentivoMH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoId);
    }

    /**
     * Consulta Estudiantes con Incentivos Registro de Grado Grado de Honor
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoIncentivoGH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoIdOtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarRegistroGradoIncentivoGH($txtFechaGrado, $txtIdAcuerdoActa, $txtCodigoCarrera, $txtIncentivoIdOtro);
    }

    /**
     * Consulta los incentivos de los Estudiantes
     * @access public
     * @return Array<Incentivos>
     */
    public function listarIncentivoEstudianteRegistroGrado($txtCodigoEstudiante, $txtCodigoCarrera) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->listarIncentivoEstudianteRegistroGrado($txtCodigoEstudiante, $txtCodigoCarrera);
    }

    /**
     * Consulta Historico de las Observaciones
     * @access public
     * @return Array<ActualizaDiplomaGrado>
     */
    public function consultarObservaciones($txtIdRegistroGrado) {
        $diploma = new Diploma($this->persistencia);
        return $diploma->consultarObservaciones($txtIdRegistroGrado);
    }

    /**
     * Consulta Estudiantes Registro Grado por Estudiante
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarRegistroGradoFormulario($txtCodigoEstudiante) {
        $registroGrado = new RegistroGrado($this->persistencia);
        $registroGrado->consultarRegistroGradoFormulario($txtCodigoEstudiante);
        return $registroGrado;
    }

    /**
     * Consulta Graduados
     * @access public
     * @return Array<RegistroGrado>
     */
    public function consultarIndexacion($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarEgresadosIndexacion($filtro);
    }

    /**
     * Consulta Graduados
     * @access public
     * @return Array<actaAcuerdo>
     */
    public function consultarActaAcuerdos($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarActaAcuerdo($filtro);
    }

    public function detalleConsultarActaAcuerdos($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->detalleConsultarActaAcuerdo($filtro);
    }

    public function consultarCarrerasActaAcuerdos($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarCarrerasActaAcuerdo($filtro);
    }

    public function buscarPromocion( $codigoCarrera, $codigoPeriodo, $tipoGrado ) {
        $registroGrado = new RegistroGrado($this->persistencia);
         $registroGrado->buscarPromocion( $codigoCarrera, $codigoPeriodo, $tipoGrado );
         return $registroGrado;
    }

    public function actualizarPromocion( $codigoCarrera, $codigoPeriodo, $tipoGrado, $numeroPromocion ) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->actualizarPromocion( $codigoCarrera, $codigoPeriodo, $tipoGrado, $numeroPromocion );
    }

    /**
     * Consulta los estudiantes graduados de Psicologia
     * para el reporte a enviar al colegio de psicologia 
     * @access public
     * @return Array<registroGrado>
     * @author Lina Quintero <quinterolina@unbosque.edu.co>
     */
    public function consultarColegioPsicologia($filtro) {
        $registroGrado = new RegistroGrado($this->persistencia);
        return $registroGrado->consultarColegioPsicologia($filtro);
    }
}

?>