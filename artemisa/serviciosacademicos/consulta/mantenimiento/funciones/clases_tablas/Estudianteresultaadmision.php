<?php
/**
 * Table Definition for estudianteresultaadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteresultaadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteresultaadmision';       // table name
    public $idestudianteresultaadmision;     // int(11)  not_null primary_key auto_increment
    public $idestudianteadmision;            // int(11)  not_null multiple_key
    public $codigoestadoestudianteresultaadmision;    // string(3)  not_null multiple_key
    public $resultadoestudianteresultaadmision;    // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteresultaadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
