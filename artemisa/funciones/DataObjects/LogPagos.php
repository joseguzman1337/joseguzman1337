<?php
/**
 * Table Definition for LogPagos
 */
require_once 'DB/DataObject.php';

class DataObjects_LogPagos extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'LogPagos';                        // table name
    var $TicketId;                        // int(11)  not_null primary_key
    var $SrvCode;                         // string(80)  not_null
    var $Reference1;                      // string(50)  not_null multiple_key
    var $Reference2;                      // string(50)  multiple_key
    var $Reference3;                      // string(50)  
    var $PaymentDesc;                     // string(80)  
    var $TransValue;                      // string(30)  not_null
    var $TransVatValue;                   // string(30)  
    var $SoliciteDate;                    // datetime(19)  binary
    var $BankProcessDate;                 // datetime(19)  binary
    var $FIName;                          // string(35)  
    var $StaCode;                         // string(50)  multiple_key
    var $TrazabilityCode;                 // string(20)  multiple_key
    var $FlagButton;                      // string(1)  
    var $RefAdc1;                         // string(35)  
    var $RefAdc2;                         // string(35)  
    var $RefAdc3;                         // string(35)  
    var $RefAdc4;                         // string(35)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_LogPagos',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
