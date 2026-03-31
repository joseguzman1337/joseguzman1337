<?php
/**
 * Table Definition for detalleencuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Detalleencuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detalleencuesta';                 // table name
    var $iddetalleencuesta;               // int(11)  not_null primary_key auto_increment
    var $idaspecto;                       // int(11)  not_null multiple_key
    var $idencuesta;                      // int(11)  not_null multiple_key
    var $numeroordendetalleencueta;       // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detalleencuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
