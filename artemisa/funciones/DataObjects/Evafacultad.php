<?php
/**
 * Table Definition for evafacultad
 */
require_once 'DB/DataObject.php';

class DataObjects_Evafacultad extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'evafacultad';                     // table name
    var $codigoestudiante;                // string(15)  
    var $resp1;                           // string(2)  
    var $resp2;                           // string(2)  
    var $resp3;                           // string(2)  
    var $resp4;                           // string(2)  
    var $resp5;                           // string(2)  
    var $resp6;                           // string(2)  
    var $resp7;                           // string(2)  
    var $resp8;                           // string(2)  
    var $resp9;                           // string(2)  
    var $resp10;                          // blob(65535)  blob
    var $codigocarrera;                   // string(15)  
    var $evaluof;                         // string(1)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Evafacultad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
