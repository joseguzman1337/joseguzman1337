<?php
/**
 * Table Definition for detallecohorte
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallecohorte extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallecohorte';                  // table name
    var $iddetallecohorte;                // int(11)  not_null primary_key auto_increment
    var $idcohorte;                       // int(11)  not_null multiple_key
    var $semestredetallecohorte;          // string(2)  not_null
    var $codigoconcepto;                  // string(8)  not_null multiple_key
    var $valordetallecohorte;             // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallecohorte',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
