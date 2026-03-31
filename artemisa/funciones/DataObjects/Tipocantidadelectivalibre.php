<?php
/**
 * Table Definition for tipocantidadelectivalibre
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipocantidadelectivalibre extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipocantidadelectivalibre';       // table name
    var $codigotipocantidadelectivalibre;    // string(3)  not_null primary_key
    var $nombretipocantidadelectivalibre;    // string(50)  not_null
    var $fechainiciotipocantidadelectivalibre;    // datetime(19)  not_null binary
    var $fechavencimientotipocantidadelectivalibre;    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipocantidadelectivalibre',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
