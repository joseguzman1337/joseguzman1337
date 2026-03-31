<?php
/**
 * Table Definition for horario
 */
require_once 'DB/DataObject.php';

class DataObjects_Horario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'horario';                         // table name
    public $idgrupo;                         // int(11)  not_null multiple_key
    public $codigodia;                       // string(2)  not_null multiple_key
    public $horainicial;                     // time(8)  not_null binary
    public $horafinal;                       // time(8)  not_null binary
    public $codigotiposalon;                 // string(2)  not_null multiple_key
    public $codigosalon;                     // string(4)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Horario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
