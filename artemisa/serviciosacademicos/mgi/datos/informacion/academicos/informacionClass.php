<?php

/**
 * Piscina de datos academicos
 *
 * @author proyecto_mgi_cp
 */
$ruta = "../";
while (!is_file($ruta.'templates/template.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta."templates/template.php");
require_once($ruta."/datos/academicos/datosClass.php");
class informacionClass {
    var $db = null;
    var $datos = null;
    
    function __construct() {
        $this->db = getBD();
        $this->datos = new datosClass();
        $this->datos->initialize($db);
    }
    
    public function initialize($database) {
        $this->db = $database;
        $this->datos->initialize($database);
    }
    
    public function getNumeroAsignaturas($alias=null,$valor=null){  
        
        $asignaturas = $this->datos->getAsignatura($alias,$valor);
        //var_dump($asignaturas);
        //var_dump(count($asignaturas));
        //var_dump($sql);        
        //var_dump("<br/><br/>");
        
        return array("0"=>count($asignaturas));        
    }
    
    public function getNumeroContenidoProgramatico($alias=null,$valor=null){
        
        $arreglo = $this->datos->getContenidoProgramatico($alias,$valor);
        
        //var_dump($arreglo);
        //var_dump(count($arreglo));
        //var_dump($sql);        
        //var_dump("<br/><br/>");
        
        return array("0"=>count($arreglo));  
    }
    
    public function getNumeroAulasVirtuales($alias=null,$valor=null){  
        $arreglo = $this->datos->getAulaVirtual($alias,$valor);
        
        return array("0"=>count($arreglo));  
    }
    
    public function getNumeroCreditosAsignaturasVirtuales($alias=null,$valor=null){  
        $arreglo = $this->datos->getAulaVirtual($alias,$valor);
        
        return array("0"=>count($arreglo));  
    }

    public function __destruct() {
        
    }
}

?>
