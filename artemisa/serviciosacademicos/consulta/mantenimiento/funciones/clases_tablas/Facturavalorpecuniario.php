<?php
/**
 * Table Definition for facturavalorpecuniario
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Facturavalorpecuniario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'facturavalorpecuniario';          // table name
    var $idfacturavalorpecuniario;        // int(11)  not_null primary_key auto_increment
    var $nombrefacturavalorpecuniario;    // string(50)  
    var $fechafacturavalorpecuniario;     // datetime(19)  not_null binary
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $codigocarrera;                   // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Facturavalorpecuniario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
