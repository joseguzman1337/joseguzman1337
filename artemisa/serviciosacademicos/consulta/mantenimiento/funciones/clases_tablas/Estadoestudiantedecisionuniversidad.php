<?php
/**
 * Table Definition for estadoestudiantedecisionuniversidad
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoestudiantedecisionuniversidad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoestudiantedecisionuniversidad';    // table name
    public $codigoestadoestudiantedecisionuniversidad;    // string(3)  not_null primary_key
    public $nombreestadoestudiantedecisionuniversidad;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoestudiantedecisionuniversidad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
