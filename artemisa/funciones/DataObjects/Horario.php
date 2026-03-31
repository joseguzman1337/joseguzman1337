<?php
/**
 * Table Definition for horario
 */
require_once 'DB/DataObject.php';

class DataObjects_Horario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'horario';                         // table name
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $codigodia;                       // string(2)  not_null multiple_key
    var $horainicial;                     // time(8)  not_null binary
    var $horafinal;                       // time(8)  not_null binary
    var $codigotiposalon;                 // string(2)  not_null multiple_key
    var $codigosalon;                     // string(4)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Horario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
