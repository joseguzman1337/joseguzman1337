<?php
/**
 * Table Definition for logdocumentograduado
 */
require_once 'DB/DataObject.php';

class DataObjects_Logdocumentograduado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'logdocumentograduado';            // table name
    var $idlogdocumentograduado;          // int(11)  not_null primary_key auto_increment
    var $iddocumentograduado;             // int(11)  not_null multiple_key
    var $idregistroincentivoacademico;    // int(11)  not_null multiple_key
    var $iddirectivo;                     // int(11)  not_null multiple_key
    var $codigoestado;                    // string(3)  not_null multiple_key
    var $codigotipodocumentograduado;     // int(11)  not_null multiple_key
    var $idincentivoacademico;            // int(11)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Logdocumentograduado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
