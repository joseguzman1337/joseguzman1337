<?php
/**
 * Table Definition for tmpcb
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmpcb extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmpcb';                           // table name
    public $codigocentrobeneficio;           // int(11)  
    public $nombrecentrobeneficio;           // string(255)  
    public $codigocentrobeneficiosap;        // string(255)  
    public $codigoestado;                    // int(11)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmpcb',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
