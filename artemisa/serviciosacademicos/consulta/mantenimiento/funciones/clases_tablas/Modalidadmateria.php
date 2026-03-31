<?php
/**
 * Table Definition for modalidadmateria
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Modalidadmateria extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'modalidadmateria';                // table name
    var $codigomodalidadmateria;          // string(2)  not_null primary_key
    var $nombremodalidadmateria;          // string(30)  not_null
    var $porcentajefallasmodalidadmateria;    // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Modalidadmateria',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
