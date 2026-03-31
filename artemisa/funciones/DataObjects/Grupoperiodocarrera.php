<?php
/**
 * Table Definition for grupoperiodocarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Grupoperiodocarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'grupoperiodocarrera';             // table name
    var $idgrupoperiodocarrera;           // int(11)  not_null primary_key auto_increment
    var $nombregrupoperiodocarrera;       // string(50)  not_null
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $fechainiciogrupoperiodocarrera;    // date(10)  not_null binary
    var $fechafinalgrupoperiodocarrera;    // date(10)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Grupoperiodocarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
