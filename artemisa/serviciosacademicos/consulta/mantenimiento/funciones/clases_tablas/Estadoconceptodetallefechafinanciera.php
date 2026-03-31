<?php
/**
 * Table Definition for estadoconceptodetallefechafinanciera
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoconceptodetallefechafinanciera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoconceptodetallefechafinanciera';    // table name
    public $codigoestadoconceptodetallefechafinanciera;    // string(2)  not_null primary_key
    public $nombreestadoconceptodetallefechafinanciera;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoconceptodetallefechafinanciera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
