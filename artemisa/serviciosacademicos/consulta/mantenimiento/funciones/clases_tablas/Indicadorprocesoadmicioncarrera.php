<?php
/**
 * Table Definition for indicadorprocesoadmicioncarrera
 */
require_once 'DB/DataObject.php';

class DataObjects_Indicadorprocesoadmicioncarrera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'indicadorprocesoadmicioncarrera';    // table name
    public $codigoindicadorprocesoadmisioncarrera;    // string(3)  not_null primary_key
    public $nombreindicadorprocesoadmisioncarrera;    // string(50)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Indicadorprocesoadmicioncarrera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
