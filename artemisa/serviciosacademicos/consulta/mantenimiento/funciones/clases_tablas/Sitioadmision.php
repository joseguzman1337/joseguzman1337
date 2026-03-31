<?php
/**
 * Table Definition for sitioadmision
 */
require_once 'DB/DataObject.php';

class DataObjects_Sitioadmision extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sitioadmision';                   // table name
    public $idsitioadmision;                 // int(11)  not_null primary_key auto_increment
    public $nombresitioadmision;             // string(100)  not_null
    public $direccionsitioadmision;          // string(100)  not_null
    public $telefonositioadmision;           // string(30)  not_null
    public $nombreresponsablesitioadmision;    // string(100)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $capacidadsitioadmision;          // int(6)  not_null
    public $codigocarrera;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sitioadmision',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
