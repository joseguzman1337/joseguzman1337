<?php
/**
 * Table Definition for docente
 */
require_once 'DB/DataObject.php';

class DataObjects_Docente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'docente';                         // table name
    var $codigodocente;                   // string(15)  not_null primary_key
    var $apellidodocente;                 // string(25)  not_null
    var $nombredocente;                   // string(25)  not_null
    var $tipodocumento;                   // string(2)  not_null multiple_key
    var $numerodocumento;                 // string(15)  not_null multiple_key
    var $clavedocente;                    // string(15)  not_null
    var $emaildocente;                    // string(30)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Docente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
