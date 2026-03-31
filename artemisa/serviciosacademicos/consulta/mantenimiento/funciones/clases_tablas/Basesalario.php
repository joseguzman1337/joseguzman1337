<?php
/**
 * Table Definition for basesalario
 */
require_once 'DB/DataObject.php';

class DataObjects_Basesalario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'basesalario';                     // table name
    public $idbasesalario;                   // int(11)  not_null primary_key auto_increment
    public $nombrebasesalario;               // string(50)  not_null
    public $fechainiciobasesalario;          // datetime(19)  not_null binary
    public $fechafinalbasesalario;           // datetime(19)  not_null binary
    public $valorbasesalario;                // int(11)  not_null
    public $porcentajeincrementobasesalario;    // unknown(15)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Basesalario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
