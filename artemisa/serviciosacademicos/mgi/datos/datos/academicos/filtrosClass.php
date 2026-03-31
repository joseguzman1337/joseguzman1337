<?php

/**
 * Filtros para datos académicos
 *
 * @author proyecto_mgi_cp
 */
class filtrosClass {
    
    function __construct() {
        
    }
    
    public function getFiltrosAsignatura($date=false){
        return array("programaAcademico"=>"Programas académicos");
    }
    
    public function getFiltrosProgramaAcademico(){
        return array("modalidadAcademica"=>"Modalidad académica","modalidadAcademicaSIC"=>"Modalidad académica SIC");
    }
    
    public function getFiltrosContenidoProgramatico(){
        return array("programaAcademico"=>"Programas académicos");
    }
    
    public function getFiltrosAulaVirtual(){
        return array("modalidadAcademicaAulaVirtual"=>"Modalidad académica");
    }
    
    public function __destruct() {
        
    }
}

?>
