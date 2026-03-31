<?php
/**
 * Table Definition for LogPagos
 */
require_once 'DB/DataObject.php';

class DataObjects_LogPagos extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'LogPagos';                        // table name
    public $TicketId;                        // string(35)  not_null primary_key
    public $SrvCode;                         // string(80)  not_null
    public $Reference1;                      // string(50)  not_null multiple_key
    public $Reference2;                      // string(50)  multiple_key
    public $Reference3;                      // string(50)  
    public $PaymentDesc;                     // string(80)  
    public $TransValue;                      // string(30)  not_null
    public $TransVatValue;                   // string(30)  
    public $SoliciteDate;                    // datetime(19)  binary
    public $BankProcessDate;                 // datetime(19)  binary
    public $FIName;                          // string(35)  
    public $StaCode;                         // string(50)  multiple_key
    public $TrazabilityCode;                 // string(20)  multiple_key
    public $FlagButton;                      // string(1)  
    public $RefAdc1;                         // string(35)  
    public $RefAdc2;                         // string(35)  
    public $RefAdc3;                         // string(35)  
    public $RefAdc4;                         // string(35)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_LogPagos',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
