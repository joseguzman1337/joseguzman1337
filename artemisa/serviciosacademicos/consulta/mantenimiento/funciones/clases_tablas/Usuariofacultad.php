<?php
/**
 * Table Definition for usuariofacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuariofacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'usuariofacultad';                 // table name
    public $idusuario;                       // int(11)  not_null primary_key auto_increment
    public $usuario;                         // string(50)  not_null multiple_key
    public $codigofacultad;                  // string(50)  not_null
    public $codigotipousuariofacultad;       // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuariofacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
