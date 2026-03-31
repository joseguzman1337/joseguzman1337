<?php
/**
 * Table Definition for tipocliente
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipocliente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipocliente';                     // table name
    public $codigotipocliente;               // string(3)  not_null primary_key
    public $nombretipocliente;               // string(50)  not_null
    public $codigoestado;                    // string(50)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipocliente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
