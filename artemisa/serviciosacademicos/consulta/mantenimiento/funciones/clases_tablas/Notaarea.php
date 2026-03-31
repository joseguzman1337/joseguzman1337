<?php
/**
 * Table Definition for notaarea
 */
require_once 'DB/DataObject.php';

class DataObjects_Notaarea extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'notaarea';                        // table name
    public $numerodocumento;                 // string(15)  not_null multiple_key
    public $codigoperiodo;                   // string(8)  not_null multiple_key
    public $idgrupo;                         // int(11)  not_null multiple_key
    public $codigoestadonotaarea;            // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Notaarea',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
