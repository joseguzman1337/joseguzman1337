<?php
/**
 * Table Definition for certificado
 */
require_once 'DB/DataObject.php';

class DataObjects_Certificado extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'certificado';                     // table name
    public $idcertificado;                   // int(11)  not_null primary_key auto_increment
    public $nombrecertificado;               // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Certificado',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
