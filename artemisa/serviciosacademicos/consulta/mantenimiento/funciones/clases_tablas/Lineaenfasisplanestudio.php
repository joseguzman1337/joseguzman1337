<?php
/**
 * Table Definition for lineaenfasisplanestudio
 */
require_once 'DB/DataObject.php';

class DataObjects_Lineaenfasisplanestudio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'lineaenfasisplanestudio';         // table name
    public $idlineaenfasisplanestudio;       // int(11)  not_null primary_key auto_increment
    public $idplanestudio;                   // int(11)  not_null multiple_key
    public $nombrelineaenfasisplanestudio;    // string(50)  not_null
    public $fechacreacionlineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $fechainiciolineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $fechavencimientolineaenfasisplanestudio;    // datetime(19)  not_null binary
    public $responsablelineaenfasisplanestudio;    // string(50)  not_null
    public $codigoestadolineaenfasisplanestudio;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Lineaenfasisplanestudio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
