<?php
/**
 * Table Definition for logdocumentograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Logdocumentograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'logdocumentograduado';            // table name
    public $idlogdocumentograduado;          // int(11)  not_null primary_key auto_increment
    public $iddocumentograduado;             // int(11)  not_null multiple_key
    public $idregistroincentivoacademico;    // int(11)  not_null multiple_key
    public $iddirectivo;                     // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key
    public $codigotipodocumentograduado;     // int(11)  not_null multiple_key
    public $idincentivoacademico;            // int(11)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Logdocumentograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
