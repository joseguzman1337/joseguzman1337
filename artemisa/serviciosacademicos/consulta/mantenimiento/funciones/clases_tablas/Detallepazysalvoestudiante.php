<?php
/**
 * Table Definition for detallepazysalvoestudiante
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallepazysalvoestudiante extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'detallepazysalvoestudiante';      // table name
    public $iddetallepazysalvoestudiante;    // int(11)  not_null primary_key auto_increment
    public $idpazysalvoestudiante;           // int(11)  not_null multiple_key
    public $descripciondetallepazysalvoestudiante;    // string(100)  not_null
    public $fechainiciodetallepazysalvoestudiante;    // datetime(19)  not_null binary
    public $fechavencimientodetallepazysalvoestudiante;    // datetime(19)  not_null binary
    public $codigotipopazysalvoestudiante;    // string(3)  not_null multiple_key
    public $codigoestadopazysalvoestudiante;    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallepazysalvoestudiante',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
