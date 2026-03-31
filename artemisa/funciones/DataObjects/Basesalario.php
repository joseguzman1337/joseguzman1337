<?php
/**
 * Table Definition for basesalario
 */
require_once 'DB/DataObject.php';

class DataObjects_Basesalario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'basesalario';                     // table name
    var $idbasesalario;                   // int(11)  not_null primary_key auto_increment
    var $nombrebasesalario;               // string(50)  not_null
    var $fechainiciobasesalario;          // datetime(19)  not_null binary
    var $fechafinalbasesalario;           // datetime(19)  not_null binary
    var $valorbasesalario;                // int(11)  not_null
    var $porcentajeincrementobasesalario;    // unknown(15)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Basesalario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
