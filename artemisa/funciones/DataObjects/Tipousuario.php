<?php
/**
 * Table Definition for tipousuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipousuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipousuario';                     // table name
    var $codigotipousuario;               // string(3)  not_null primary_key
    var $nombretipousuario;               // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipousuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
