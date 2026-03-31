<?php
/**
 * Table Definition for estudianteresultadoadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteresultadoadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estudianteresultadoadmision';     // table name
    public $idestudianteresultadoadmision;    // int(11)  not_null primary_key auto_increment
    public $idestudiantegeneral;             // int(11)  not_null multiple_key
    public $idresultadoadmision;             // int(11)  not_null multiple_key
    public $numeroestudianteresultadoadmision;    // string(50)  
    public $resultadoadmision;               // string(50)  
    public $codigoestadoestudianteresultadoadmision;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteresultadoadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
