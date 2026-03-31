<?php
/**
 * Table Definition for estadodescuentovsdeuda
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadodescuentovsdeuda extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadodescuentovsdeuda';          // table name
    var $codigoestadodescuentovsdeuda;    // string(2)  not_null primary_key
    var $nombreestadodescuentovsdeuda;    // string(25)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadodescuentovsdeuda',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
