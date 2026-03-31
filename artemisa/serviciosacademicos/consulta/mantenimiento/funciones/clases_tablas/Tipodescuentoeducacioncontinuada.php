<?php
/**
 * Table Definition for tipodescuentoeducacioncontinuada
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Tipodescuentoeducacioncontinuada extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipodescuentoeducacioncontinuada';    // table name
    var $codigotipodescuentoeducacioncontinuada;    // string(3)  not_null primary_key
    var $nombredescuentoeducacioncontinuada;    // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipodescuentoeducacioncontinuada',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
