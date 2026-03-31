<?php
/**
 * Table Definition for documentacionfacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentacionfacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'documentacionfacultad';           // table name
    public $iddocumentacionfacultad;         // int(11)  not_null primary_key auto_increment
    public $codigocarrera;                   // int(11)  not_null multiple_key
    public $iddocumentacion;                 // int(11)  not_null multiple_key
    public $fechainiciodocumentacionfacultad;    // date(10)  not_null binary
    public $fechavencimientodocumentacionfacultad;    // date(10)  not_null binary
    public $codigotipodocumentacionfacultad;    // string(3)  not_null multiple_key
    public $codigogenerodocumento;           // string(3)  not_null multiple_key
    public $codigotipoobligatoridaddocumentacionfacultad;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentacionfacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
