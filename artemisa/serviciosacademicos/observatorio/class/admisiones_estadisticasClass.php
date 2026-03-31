
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class admisiones_estadisticasClass {
        
    var $idobs_admisiones_estadisticas=null;
    var $codigocarrera=null;
    var $interesados=null;
    var $aspirantes=null;
    var $inscritos=null;
    var $meta_inscritos=null;
    var $logros=null;
    var $inscritos_totales=null;
    var $inscripcion_p1_p2=null;
    var $inscritos_no_evaluados=null;
    var $por_inscritos_no_evaluados=null;
    var $lista_espera=null;
    var $evaluados_no_adminitdos=null;
    var $admitidos_no_matriculados=null;
    var $administos_no_ingresaron=null;
    var $matriculados_nuevos_sala=null;
    var $meta_matriculados=null;
    var $logros2=null;
    var $matriculados_periodo=null;
    var $matriculados_p1_p2=null;
    var $matriculados_periodo_totales=null;
    var $matriculados_antiguos=null;
    var $matriculados_totales=null;
    var $fecha_crear=null;
    var $codigoestado=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $fechamodificacion=null;
    var $usuariomodificacion=null;
    var $codigoperiodo=null;
    var $codigomodalidadacademica=null;

    public function __construct() {
        
    }
    
    public function getIdobs_admisiones_estadisticas() {
        return $this->idobs_admisiones_estadisticas;
    }

    public function setIdobs_admisiones_estadisticas($idobs_admisiones_estadisticas) {
        $this->idobs_admisiones_estadisticas = $idobs_admisiones_estadisticas;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getInteresados() {
        return $this->interesados;
    }

    public function setInteresados($interesados) {
        $this->interesados = $interesados;
    }

    public function getAspirantes() {
        return $this->aspirantes;
    }

    public function setAspirantes($aspirantes) {
        $this->aspirantes = $aspirantes;
    }

    public function getInscritos() {
        return $this->inscritos;
    }

    public function setInscritos($inscritos) {
        $this->inscritos = $inscritos;
    }

    public function getMeta_inscritos() {
        return $this->meta_inscritos;
    }

    public function setMeta_inscritos($meta_inscritos) {
        $this->meta_inscritos = $meta_inscritos;
    }

    public function getLogros() {
        return $this->logros;
    }

    public function setLogros($logros) {
        $this->logros = $logros;
    }

    public function getInscritos_totales() {
        return $this->inscritos_totales;
    }

    public function setInscritos_totales($inscritos_totales) {
        $this->inscritos_totales = $inscritos_totales;
    }

    public function getInscripcion_p1_p2() {
        return $this->inscripcion_p1_p2;
    }

    public function setInscripcion_p1_p2($inscripcion_p1_p2) {
        $this->inscripcion_p1_p2 = $inscripcion_p1_p2;
    }

    public function getInscritos_no_evaluados() {
        return $this->inscritos_no_evaluados;
    }

    public function setInscritos_no_evaluados($inscritos_no_evaluados) {
        $this->inscritos_no_evaluados = $inscritos_no_evaluados;
    }

    public function getPor_inscritos_no_evaluados() {
        return $this->por_inscritos_no_evaluados;
    }

    public function setPor_inscritos_no_evaluados($por_inscritos_no_evaluados) {
        $this->por_inscritos_no_evaluados = $por_inscritos_no_evaluados;
    }

    public function getLista_espera() {
        return $this->lista_espera;
    }

    public function setLista_espera($lista_espera) {
        $this->lista_espera = $lista_espera;
    }

    public function getEvaluados_no_adminitdos() {
        return $this->evaluados_no_adminitdos;
    }

    public function setEvaluados_no_adminitdos($evaluados_no_adminitdos) {
        $this->evaluados_no_adminitdos = $evaluados_no_adminitdos;
    }

    public function getAdmitidos_no_matriculados() {
        return $this->admitidos_no_matriculados;
    }

    public function setAdmitidos_no_matriculados($admitidos_no_matriculados) {
        $this->admitidos_no_matriculados = $admitidos_no_matriculados;
    }

    public function getAdministos_no_ingresaron() {
        return $this->administos_no_ingresaron;
    }

    public function setAdministos_no_ingresaron($administos_no_ingresaron) {
        $this->administos_no_ingresaron = $administos_no_ingresaron;
    }

    public function getMatriculados_nuevos_sala() {
        return $this->matriculados_nuevos_sala;
    }

    public function setMatriculados_nuevos_sala($matriculados_nuevos_sala) {
        $this->matriculados_nuevos_sala = $matriculados_nuevos_sala;
    }

    public function getMeta_matriculados() {
        return $this->meta_matriculados;
    }

    public function setMeta_matriculados($meta_matriculados) {
        $this->meta_matriculados = $meta_matriculados;
    }

    public function getLogros2() {
        return $this->logros2;
    }

    public function setLogros2($logros2) {
        $this->logros2 = $logros2;
    }

    public function getMatriculados_periodo() {
        return $this->matriculados_periodo;
    }

    public function setMatriculados_periodo($matriculados_periodo) {
        $this->matriculados_periodo = $matriculados_periodo;
    }

    public function getMatriculados_p1_p2() {
        return $this->matriculados_p1_p2;
    }

    public function setMatriculados_p1_p2($matriculados_p1_p2) {
        $this->matriculados_p1_p2 = $matriculados_p1_p2;
    }

    public function getMatriculados_periodo_totales() {
        return $this->matriculados_periodo_totales;
    }

    public function setMatriculados_periodo_totales($matriculados_periodo_totales) {
        $this->matriculados_periodo_totales = $matriculados_periodo_totales;
    }

    public function getMatriculados_antiguos() {
        return $this->matriculados_antiguos;
    }

    public function setMatriculados_antiguos($matriculados_antiguos) {
        $this->matriculados_antiguos = $matriculados_antiguos;
    }

    public function getMatriculados_totales() {
        return $this->matriculados_totales;
    }

    public function setMatriculados_totales($matriculados_totales) {
        $this->matriculados_totales = $matriculados_totales;
    }

    public function getFecha_crear() {
        return $this->fecha_crear;
    }

    public function setFecha_crear($fecha_crear) {
        $this->fecha_crear = $fecha_crear;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

      
    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }  
                        
    public function __destruct() {
        
    }
}
?>
