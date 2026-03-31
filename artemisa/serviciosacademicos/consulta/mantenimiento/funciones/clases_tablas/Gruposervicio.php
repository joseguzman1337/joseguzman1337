<?php
/**
 * Table Definition for gruposervicio
 */
require_once 'DB/DataObject.php';

class DataObjects_Gruposervicio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'gruposervicio';                   // table name
    public $codigogruposervicio;             // string(3)  not_null primary_key
    public $nombregruposervicio;             // string(200)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Gruposervicio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
