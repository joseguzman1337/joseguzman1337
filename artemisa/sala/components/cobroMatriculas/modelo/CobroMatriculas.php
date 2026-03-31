<?php
require_once(PATH_SITE . "/entidad/CobroMatricula.php");
require_once(PATH_SITE . "/entidad/Periodo.php");
require_once(PATH_SITE . "/includes/salaAutoloader.php");
spl_autoload_register('salaAutoloader');

class CobroMatriculas implements model {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getVariables($variables) {
         $array = array();
         $cobroMatricula =CobroMatricula::getList("  1 order by codigoperiodo desc limit 10");
         $array["cobroMatricula"] = $cobroMatricula;
         
         if (!empty($variables->dataAction)) {
             $array["periodoMatricula"]=Periodo::getList(" 1 order by codigoperiodo desc limit 5");
         }
         return $array;
    }

}
