<?php
/**
 * Table Definition for numeroordeninternasap
 */
require_once 'DB/DataObject.php';

class DataObjects_Numeroordeninternasap extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'numeroordeninternasap';           // table name
    var $idnumeroordeninternasap;         // int(11)  not_null primary_key auto_increment
    var $fechanumeroordeninternasap;      // date(10)  not_null binary
    var $fechainicionumeroordeninternasap;    // date(10)  not_null binary
    var $fechavencimientonumeroordeninternasap;    // date(10)  not_null binary
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $idusuario;                       // int(11)  not_null multiple_key
    var $ip;                              // string(50)  not_null
    var $numeroordeninternasap;           // string(20)  not_null unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Numeroordeninternasap',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
