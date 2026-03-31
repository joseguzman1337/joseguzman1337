<?php
/**
 * Table Definition for ordenpagoplandepago
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpagoplandepago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ordenpagoplandepago';             // table name
    var $idordenpagoplandepago;           // int(11)  not_null primary_key auto_increment
    var $fechaordenpagoplandepago;        // date(10)  not_null binary
    var $numerodocumentoplandepagosap;    // string(20)  not_null
    var $cuentaxcobrarplandepagosap;      // string(20)  not_null
    var $numerorodenpagoplandepagosap;    // int(11)  not_null multiple_key
    var $numerorodencoutaplandepagosap;    // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpagoplandepago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
