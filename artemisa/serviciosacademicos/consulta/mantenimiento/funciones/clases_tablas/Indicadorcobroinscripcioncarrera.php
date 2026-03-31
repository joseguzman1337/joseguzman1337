<?php
/**
 * Table Definition for indicadorcobroinscripcioncarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorcobroinscripcioncarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadorcobroinscripcioncarrera';    // table name
    public $codigoindicadorcobroinscripcioncarrera;    // string(3)  not_null primary_key
    public $nombreindicadorcobroinscripcioncarrera;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorcobroinscripcioncarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
