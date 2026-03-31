<?php
/**
 * Table Definition for ordenpagoplandepago
 */
require_once 'DB/DataObject.php';

class DataObjects_Ordenpagoplandepago extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ordenpagoplandepago';             // table name
    public $idordenpagoplandepago;           // int(11)  not_null primary_key auto_increment
    public $nombreordenpagoplandepago;       // string(50)  not_null
    public $fechaordenpagoplandepago;        // date(10)  not_null binary
    public $numerodocumentoplandepagosap;    // string(20)  not_null
    public $fechaplandepagosap;              // date(10)  not_null binary
    public $valortotalplandepagosap;         // unknown(15)  not_null
    public $numerorodenpago;                 // int(11)  not_null multiple_key
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ordenpagoplandepago',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
