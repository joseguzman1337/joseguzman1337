<?php
/**
 * Table Definition for resultadoadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Resultadoadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'resultadoadmision';               // table name
    var $idresultadoadmision;             // int(11)  not_null primary_key auto_increment
    var $nombreresultadoadmision;         // string(50)  not_null
    var $minimoporcentajeresultadoadmision;    // string(50)  not_null
    var $maximoporcentajeidresultadosadmision;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Resultadoadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
