<?php
/**
 * Table Definition for docente22
 */
require_once 'DB/DataObject.php';

class DataObjects_Docente22 extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'docente22';                       // table name
    var $IES_CODIGO;                      // int(4)  
    var $PRIMER_APE;                      // string(13)  
    var $SEGUNDO_AP;                      // string(14)  
    var $PRIMER_NOM;                      // string(30)  
    var $FECH_INGR;                       // datetime(19)  binary
    var $FECHA_NACI;                      // datetime(19)  binary
    var $LUGAR_NACI;                      // int(5)  
    var $NACIONALID;                      // int(2)  
    var $GENERO_COD;                      // int(2)  
    var $LUGAR_RESI;                      // int(5)  
    var $EMAIL;                           // string(40)  
    var $EST_CIVIL_;                      // int(2)  
    var $TIP_IDE;                         // int(1)  
    var $TIPO_DOC_U;                      // string(2)  
    var $CODIGO_UNI;                      // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Docente22',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
