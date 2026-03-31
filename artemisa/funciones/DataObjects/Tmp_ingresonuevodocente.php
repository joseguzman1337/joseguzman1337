<?php
/**
 * Table Definition for tmp_ingresonuevodocente
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_ingresonuevodocente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tmp_ingresonuevodocente';         // table name
    var $codigodocente;                   // string(255)  
    var $apellidodocente;                 // string(255)  
    var $nombredocente;                   // string(255)  
    var $tipodocumento;                   // string(255)  
    var $numerodocumento;                 // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_ingresonuevodocente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
