<?php

require_once(dirname(__FILE__). "/../../../../../sala/includes/adaptador.php");

class universidad
{
    public function consultarUniversidad(){
        $db = Factory::createDbo();
        $universidad = "select * from universidad where iduniversidad = 1";
        $row_universidad = $db->GetRow($universidad);
        return $row_universidad;
    }
}