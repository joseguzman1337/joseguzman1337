<?php
/**
 * Table Definition for estadoclaveusuariopreinscripcion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoclaveusuariopreinscripcion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoclaveusuariopreinscripcion';    // table name
    public $codigoestadoclaveusuariopreinscripcion;    // string(3)  not_null primary_key
    public $nombreestadoclaveusuariopreinscripcion;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoclaveusuariopreinscripcion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
