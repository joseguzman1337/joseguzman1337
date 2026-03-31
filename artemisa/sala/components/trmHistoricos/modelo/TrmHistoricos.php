<?php
require_once(PATH_SITE . "/entidad/TipoMoneda.php");
require_once(PATH_SITE . "/entidad/TrmHistorico.php");
require_once(PATH_SITE . "/includes/salaAutoloader.php");
spl_autoload_register('salaAutoloader');
class TrmHistoricos implements model{

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getVariables($variables) {
        $array = array();
        $where = "";
        $trmHistorico = TrmHistorico::getList($where," idtrmhistorico DESC");
        $array["trmHistorico"] = $trmHistorico;// este array es el que se esta imprimiento en el template / default.php  !importante
        //---------------
        $tipoMoneda = TipoMoneda::getList($where,"");
        $array["tipoMoneda"] = $tipoMoneda;
        return $array;
    }
}