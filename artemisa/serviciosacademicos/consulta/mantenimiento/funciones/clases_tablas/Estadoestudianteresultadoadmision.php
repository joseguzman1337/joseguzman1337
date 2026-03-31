<?php
/**
 * Table Definition for estadoestudianteresultadoadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoestudianteresultadoadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoestudianteresultadoadmision';    // table name
    public $codigoestadoestudianteresultadoadmision;    // string(3)  not_null primary_key
    public $nombreestadoestudianteresultadoadmision;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoestudianteresultadoadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
