<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verAcademicosClass
 *
 * @author proyecto_mgi_cp
 */
class mostrarClass {
    
    function __construct() {
        
    }
    
    public function displayAsignatura($asignatura){
        return $asignatura["nombremateria"];
    }
    
    public function displayProgramaAcademico($programa){
        return $programa["nombrecarrera"];
    }
    
    public function displayModalidadAcademicaSIC($mod){
        return $mod["nombremodalidadacademicasic"];
    }
    
    public function displayModalidadAcademica($mod){
        return $mod["nombremodalidadacademica"];
    }
    
    public function displayModalidadAcademicaAulaVirtual($mod){
        return $mod["nombre"];
    }
    
    public function displayAulaVirtual($mod){
        return $mod["asignatura"];
    }
    
    public function displayContenidoProgramatico($contenido){
        return "archivo contenido: ".$contenido["urlaarchivofinalcontenidoprogramatico"]."<br/> archivo syllabus: ".$contenido["urlasyllabuscontenidoprogramatico"];
    }
    
    public function displayFormacionAcademica($mod){
        return $mod["nombreformacionacademica"];
    }
    
    public function __destruct() {
        
    }
}

?>
