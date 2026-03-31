<?php

/**
 * Filtros para datos académicos
 *
 * @author proyecto_mgi_cp
 */
class filtrosInfoClass {
    
    function __construct() {
        
    }
    
    public function getFiltrosNumeroAsignaturas(){
        return array("aulaVirtual"=>"Aulas Virtuales","formacionAcademica"=>"Formación académica");
    }
    
    public function getFiltrosNumeroCreditosAsignaturas(){
        return array("formacionAcademica"=>"Formación académica");
    }
    
    public function getFiltrosProgramaAcademico(){
        return array("modalidadAcademica"=>"Modalidad académica","modalidadAcademicaSIC"=>"Modalidad académica SIC");
    }
    
    public function getFiltrosNumeroAulasVirtuales(){
        return array("modalidadAcademica"=>"Modalidad académica","modalidadAcademicaSIC"=>"Modalidad académica SIC", "modalidadAcademicaAulaVirtual"=>"Modalidad académica Aulas Virtuales");
    }
    
    public function __destruct() {
        
    }
}

?>
