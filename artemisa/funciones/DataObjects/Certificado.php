<?php
/**
 * Table Definition for certificado
 */
require_once 'DB/DataObject.php';

class DataObjects_Certificado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'certificado';                     // table name
    var $idcertificado;                   // int(11)  not_null primary_key auto_increment
    var $nombrecertificado;               // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Certificado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
