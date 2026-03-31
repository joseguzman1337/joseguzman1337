<?php
/**
 * Table Definition for estadoprematriculanovasoft
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoprematriculanovasoft extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoprematriculanovasoft';      // table name
    public $codigoestadoprematriculanovasoft;    // string(2)  not_null primary_key
    public $nombreestadoprematriculanovasoft;    // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoprematriculanovasoft',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
