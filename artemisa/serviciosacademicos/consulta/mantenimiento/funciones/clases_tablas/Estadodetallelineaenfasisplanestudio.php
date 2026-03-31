<?php
/**
 * Table Definition for estadodetallelineaenfasisplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadodetallelineaenfasisplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadodetallelineaenfasisplanestudio';    // table name
    public $codigoestadodetallelineaenfasisplanestudio;    // string(3)  not_null primary_key
    public $nombreestadodetallelineaenfasisplanestudio;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadodetallelineaenfasisplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
