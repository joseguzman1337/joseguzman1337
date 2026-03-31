<?php
/**
 * Table Definition for documentacionfacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Documentacionfacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'documentacionfacultad';           // table name
    var $iddocumentacionfacultad;         // int(11)  not_null primary_key auto_increment
    var $codigocarrera;                   // int(11)  not_null multiple_key
    var $iddocumentacion;                 // int(11)  not_null multiple_key
    var $fechainiciodocumentacionfacultad;    // date(10)  not_null binary
    var $fechavencimientodocumentacionfacultad;    // date(10)  not_null binary
    var $codigotipodocumentacionfacultad;    // string(3)  not_null multiple_key
    var $codigogenerodocumento;           // string(3)  not_null multiple_key
    var $codigotipoobligatoridaddocumentacionfacultad;    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Documentacionfacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
