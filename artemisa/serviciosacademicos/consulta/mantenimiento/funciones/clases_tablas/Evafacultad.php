<?php
/**
 * Table Definition for evafacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Evafacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'evafacultad';                     // table name
    public $codigoestudiante;                // string(15)  
    public $resp1;                           // string(2)  
    public $resp2;                           // string(2)  
    public $resp3;                           // string(2)  
    public $resp4;                           // string(2)  
    public $resp5;                           // string(2)  
    public $resp6;                           // string(2)  
    public $resp7;                           // string(2)  
    public $resp8;                           // string(2)  
    public $resp9;                           // string(2)  
    public $resp10;                          // blob(65535)  blob
    public $codigocarrera;                   // string(15)  
    public $evaluof;                         // string(1)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Evafacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
