<?php
/**
 * Table Definition for tipoordenpagodevolucion
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoordenpagodevolucion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tipoordenpagodevolucion';         // table name
    public $codigotipoordenpagodevolucion;    // string(3)  not_null primary_key
    public $nombretipoordenpagodevolucion;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoordenpagodevolucion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
