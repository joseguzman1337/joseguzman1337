<?php
/**
 * Table Definition for usuario
 */
require_once 'DB/DataObject.php';

class DataObjects_Usuario extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'usuario';                         // table name
    var $idusuario;                       // int(11)  not_null primary_key auto_increment
    var $usuario;                         // string(50)  not_null unique_key
    var $numerodocumento;                 // string(20)  not_null
    var $tipodocumento;                   // int(11)  not_null
    var $apellidos;                       // string(100)  not_null
    var $nombres;                         // string(100)  not_null
    var $codigousuario;                   // string(50)  not_null
    var $semestre;                        // string(20)  
    var $codigorol;                       // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Usuario',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
