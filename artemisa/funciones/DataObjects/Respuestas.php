<?php
/**
 * Table Definition for respuestas
 */
require_once 'DB/DataObject.php';

class DataObjects_Respuestas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'respuestas';                      // table name
    var $codigomateria;                   // int(11)  not_null
    var $codigoestudiante;                // string(15)  
    var $codigodocente;                   // string(15)  
    var $evaluado;                        // int(11)  
    var $idgrupo;                         // int(11)  
    var $resp1;                           // string(1)  
    var $resp2;                           // string(1)  
    var $resp3;                           // string(1)  
    var $resp4;                           // string(1)  
    var $resp5;                           // string(1)  
    var $resp6;                           // string(1)  
    var $resp7;                           // string(1)  
    var $resp8;                           // string(1)  
    var $resp9;                           // string(1)  
    var $respa1;                          // string(1)  
    var $respb1;                          // string(1)  
    var $respc1;                          // string(1)  
    var $respd1;                          // string(1)  
    var $respa2;                          // string(1)  
    var $respb2;                          // string(1)  
    var $respc2;                          // string(1)  
    var $respd2;                          // string(1)  
    var $respa3;                          // string(1)  
    var $respb3;                          // string(1)  
    var $respc3;                          // string(1)  
    var $respd3;                          // string(1)  
    var $respa4;                          // string(1)  
    var $respb4;                          // string(1)  
    var $respc4;                          // string(1)  
    var $respd4;                          // string(1)  
    var $respa5;                          // string(1)  
    var $respb5;                          // string(1)  
    var $respc5;                          // string(1)  
    var $respd5;                          // string(1)  
    var $respa6;                          // string(1)  
    var $respb6;                          // string(1)  
    var $respc6;                          // string(1)  
    var $respd6;                          // string(1)  
    var $respa7;                          // string(1)  
    var $respb7;                          // string(1)  
    var $respc7;                          // string(1)  
    var $respd7;                          // string(1)  
    var $respa8;                          // string(1)  
    var $respb8;                          // string(1)  
    var $respc8;                          // string(1)  
    var $respd8;                          // string(1)  
    var $respa9;                          // string(1)  
    var $respb9;                          // string(1)  
    var $respc9;                          // string(1)  
    var $respd9;                          // string(1)  
    var $observaciones;                   // blob(65535)  blob

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Respuestas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
