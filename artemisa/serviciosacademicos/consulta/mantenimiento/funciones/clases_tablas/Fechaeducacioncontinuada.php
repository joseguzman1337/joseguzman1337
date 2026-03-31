<?php
/**
 * Table Definition for fechaeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Fechaeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'fechaeducacioncontinuada';        // table name
    var $idfechaeducacioncontinuada;      // int(11)  not_null primary_key auto_increment
    var $idgrupo;                         // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Fechaeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
