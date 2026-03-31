<?php
/**
 * Table Definition for titulo
 */
require_once 'DB/DataObject.php';

class DataObjects_Titulo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'titulo';                          // table name
    public $codigotitulo;                    // int(11)  not_null primary_key auto_increment
    public $nombretitulo;                    // string(100)  not_null
    public $fechainiciotitulo;               // datetime(19)  not_null binary
    public $fechafintitulo;                  // datetime(19)  not_null binary
    public $registrotitulo;                  // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Titulo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
