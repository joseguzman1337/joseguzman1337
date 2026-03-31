<?php
/**
 * Table Definition for codeudor
 */
require_once 'DB/DataObject.php';

class DataObjects_Codeudor extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'codeudor';                        // table name
    public $idsolicitudcredito;              // int(11)  not_null multiple_key
    public $numerodocumentocodeudor;         // string(15)  not_null
    public $tipodocumento;                   // string(2)  not_null multiple_key
    public $expedidodocumentocodeudor;       // string(20)  not_null
    public $apellidoscodeudor;               // string(20)  not_null
    public $nombrescodeudor;                 // string(20)  not_null
    public $direccionresidenciacodeudor;     // string(30)  not_null
    public $ciudadresidenciacodeudor;        // string(20)  not_null
    public $telefonoresidenciacodeudor;      // string(20)  not_null
    public $direccioncorrespondenciacodeudor;    // string(30)  
    public $ciudadcorrespondenciacodeudor;    // string(20)  
    public $telefonocorrespondenciacodeudor;    // string(20)  
    public $celularcodeudor;                 // string(20)  
    public $emailcodeudor;                   // string(30)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Codeudor',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
