<?php
/**
 * Table Definition for estadoplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoplanestudio';               // table name
    public $codigoestadoplanestudio;         // string(3)  not_null primary_key
    public $nombrecodigoestadoplanestudio;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
