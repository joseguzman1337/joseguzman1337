<?php
/**
 * Table Definition for estadocivil
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadocivil extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadocivil';                     // table name
    public $idestadocivil;                   // int(11)  not_null primary_key auto_increment
    public $nombreestadocivil;               // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadocivil',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
