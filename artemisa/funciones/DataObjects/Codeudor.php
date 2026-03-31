<?php
/**
 * Table Definition for codeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Codeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'codeudor';                        // table name
    var $idsolicitudcredito;              // int(11)  not_null multiple_key
    var $numerodocumentocodeudor;         // string(15)  not_null
    var $tipodocumento;                   // string(2)  not_null multiple_key
    var $expedidodocumentocodeudor;       // string(20)  not_null
    var $apellidoscodeudor;               // string(20)  not_null
    var $nombrescodeudor;                 // string(20)  not_null
    var $direccionresidenciacodeudor;     // string(30)  not_null
    var $ciudadresidenciacodeudor;        // string(20)  not_null
    var $telefonoresidenciacodeudor;      // string(20)  not_null
    var $direccioncorrespondenciacodeudor;    // string(30)  
    var $ciudadcorrespondenciacodeudor;    // string(20)  
    var $telefonocorrespondenciacodeudor;    // string(20)  
    var $celularcodeudor;                 // string(20)  
    var $emailcodeudor;                   // string(30)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Codeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
