<?php
/**
 * Table Definition for institucioneducativaestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Institucioneducativaestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'institucioneducativaestudiante';    // table name
    var $idinstitucioneducativaestudiante;    // int(11)  not_null primary_key auto_increment
    var $idinstitucioneducativa;          // int(11)  multiple_key
    var $codigoestudiante;                // int(11)  multiple_key
    var $fechagradoinstitucioneducativaestudiante;    // date(10)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Institucioneducativaestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
