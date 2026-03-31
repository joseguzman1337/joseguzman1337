<?php
/**
 * Table Definition for materiarotacionestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Materiarotacionestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'materiarotacionestudiante';       // table name
    public $idmateriarotacionestudiante;     // int(11)  not_null primary_key auto_increment
    public $fechamateriarotacionestudiante;    // string(50)  
    public $idmateriarotaciongrupo;          // int(11)  not_null multiple_key
    public $codigoestudiante;                // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Materiarotacionestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
