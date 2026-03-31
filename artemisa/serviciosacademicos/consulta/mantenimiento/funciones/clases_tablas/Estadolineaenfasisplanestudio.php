<?php
/**
 * Table Definition for estadolineaenfasisplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadolineaenfasisplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadolineaenfasisplanestudio';    // table name
    public $codigoestadolineaenfasisplanestudio;    // string(3)  not_null primary_key
    public $nombreestadolineaenfasisplanestudio;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadolineaenfasisplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
