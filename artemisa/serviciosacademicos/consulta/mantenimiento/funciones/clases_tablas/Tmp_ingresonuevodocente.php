<?php
/**
 * Table Definition for tmp_ingresonuevodocente
 */
require_once 'DB/DataObject.php';

class DataObjects_Tmp_ingresonuevodocente extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tmp_ingresonuevodocente';         // table name
    public $codigodocente;                   // string(255)  
    public $apellidodocente;                 // string(255)  
    public $nombredocente;                   // string(255)  
    public $tipodocumento;                   // string(255)  
    public $numerodocumento;                 // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tmp_ingresonuevodocente',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
