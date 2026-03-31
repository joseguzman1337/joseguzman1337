<?php
/**
 * Table Definition for docente
 */
require_once 'DB/DataObject.php';

class DataObjects_Docente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'docente';                         // table name
    public $codigodocente;                   // string(15)  not_null primary_key
    public $apellidodocente;                 // string(25)  not_null
    public $nombredocente;                   // string(25)  not_null
    public $tipodocumento;                   // string(2)  not_null multiple_key
    public $numerodocumento;                 // string(15)  not_null multiple_key
    public $clavedocente;                    // string(15)  not_null
    public $emaildocente;                    // string(30)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Docente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
