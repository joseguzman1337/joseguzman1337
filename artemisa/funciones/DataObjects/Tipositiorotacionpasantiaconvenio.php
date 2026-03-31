<?php
/**
 * Table Definition for tipositiorotacionpasantiaconvenio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipositiorotacionpasantiaconvenio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipositiorotacionpasantiaconvenio';    // table name
    var $idtipositiorotacionpasantiaconvenio;    // int(11)  not_null primary_key auto_increment
    var $nombretipositiorotacionpasantiaconvenio;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipositiorotacionpasantiaconvenio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
