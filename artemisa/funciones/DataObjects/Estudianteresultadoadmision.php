<?php
/**
 * Table Definition for estudianteresultadoadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estudianteresultadoadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estudianteresultadoadmision';     // table name
    var $idestudianteresultadoadmision;    // int(11)  not_null primary_key auto_increment
    var $idestudiantegeneral;             // int(11)  not_null multiple_key
    var $idresultadoadmision;             // int(11)  not_null multiple_key
    var $numeroestudianteresultadoadmision;    // string(50)  
    var $resultadoadmision;               // string(50)  
    var $codigoestadoestudianteresultadoadmision;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estudianteresultadoadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
