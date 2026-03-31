<?php
/**
 * Table Definition for grado
 */
require_once 'DB/DataObject.php';

class DataObjects_Grado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'grado';                           // table name
    var $idgrado;                         // int(11)  not_null primary_key auto_increment
    var $nombregrado;                     // string(100)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Grado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
