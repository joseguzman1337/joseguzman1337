<?php
/**
 * Table Definition for usuariofacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariofacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'usuariofacultad';                 // table name
    var $idusuario;                       // int(11)  not_null primary_key auto_increment
    var $usuario;                         // string(50)  not_null multiple_key
    var $codigofacultad;                  // string(50)  not_null
    var $codigotipousuariofacultad;       // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariofacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
