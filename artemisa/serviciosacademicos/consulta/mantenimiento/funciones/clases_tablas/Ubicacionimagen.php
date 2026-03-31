<?php
/**
 * Table Definition for ubicacionimagen
 */
require_once 'DB/DataObject.php';

class DataObjects_Ubicacionimagen extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ubicacionimagen';                 // table name
    public $idubicacionimagen;               // string(3)  not_null primary_key
    public $nombreubicacionimagen;           // string(50)  not_null
    public $linkidubicacionimagen;           // string(200)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ubicacionimagen',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
