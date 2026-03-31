<?php
/**
 * Table Definition for nota
 */
require_once 'DB/DataObject.php';

class DataObjects_Nota extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'nota';                            // table name
    var $idgrupo;                         // int(11)  not_null primary_key multiple_key
    var $idcorte;                         // int(11)  not_null primary_key multiple_key
    var $fechaorigennota;                 // datetime(19)  not_null binary
    var $actividadesacademicasteoricanota;    // int(6)  not_null
    var $actividadesacademicaspracticanota;    // int(6)  not_null
    var $fechaultimoregistronota;         // datetime(19)  not_null binary
    var $codigotipoequivalencianota;      // string(2)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Nota',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
