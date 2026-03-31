<?php
/**
 * Table Definition for cuotacredito
 */
require_once 'DB/DataObject.php';

class DataObjects_Cuotacredito extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'cuotacredito';                    // table name
    var $idcuotacredito;                  // real(22)  
    var $numerocredito;                   // string(255)  
    var $valorcuota;                      // real(22)  
    var $saldocuota;                      // real(22)  
    var $numerocuota;                     // real(22)  
    var $fechavencimiento;                // datetime(19)  binary
    var $formapago;                       // string(255)  
    var $codigobanco;                     // string(255)  
    var $chequepostfechado;               // string(255)  
    var $cuentachequepostfechado;         // string(255)  
    var $fechachequepostfechado;          // datetime(19)  binary
    var $valorchequepostfechado;          // real(22)  
    var $recibopago;                      // string(255)  
    var $fechapago;                       // string(255)  
    var $interesescuota;                  // real(22)  
    var $estadocuota;                     // real(22)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Cuotacredito',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
