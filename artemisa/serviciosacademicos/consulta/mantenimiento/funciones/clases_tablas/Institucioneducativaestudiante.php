<?php
/**
 * Table Definition for institucioneducativaestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Institucioneducativaestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'institucioneducativaestudiante';    // table name
    public $idinstitucioneducativaestudiante;    // int(11)  not_null primary_key auto_increment
    public $idinstitucioneducativa;          // int(11)  multiple_key
    public $codigoestudiante;                // int(11)  multiple_key
    public $fechagradoinstitucioneducativaestudiante;    // date(10)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Institucioneducativaestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
