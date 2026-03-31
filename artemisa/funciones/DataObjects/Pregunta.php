<?php
/**
 * Table Definition for pregunta
 */
require_once 'DB/DataObject.php';

class DataObjects_Pregunta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'pregunta';                        // table name
    var $idpregunta;                      // int(11)  not_null primary_key auto_increment
    var $idtipopregunta;                  // int(11)  not_null multiple_key
    var $idtiporespuesta;                 // int(11)  not_null multiple_key
    var $nombrepregunta;                  // string(80)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pregunta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
