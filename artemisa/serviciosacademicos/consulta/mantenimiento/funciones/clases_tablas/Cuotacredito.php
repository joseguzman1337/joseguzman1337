<?php
/**
 * Table Definition for cuotacredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Cuotacredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'cuotacredito';                    // table name
    public $idcuotacredito;                  // real(22)  
    public $numerocredito;                   // string(255)  
    public $valorcuota;                      // real(22)  
    public $saldocuota;                      // real(22)  
    public $numerocuota;                     // real(22)  
    public $fechavencimiento;                // datetime(19)  binary
    public $formapago;                       // string(255)  
    public $codigobanco;                     // string(255)  
    public $chequepostfechado;               // string(255)  
    public $cuentachequepostfechado;         // string(255)  
    public $fechachequepostfechado;          // datetime(19)  binary
    public $valorchequepostfechado;          // real(22)  
    public $recibopago;                      // string(255)  
    public $fechapago;                       // string(255)  
    public $interesescuota;                  // real(22)  
    public $estadocuota;                     // real(22)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cuotacredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
