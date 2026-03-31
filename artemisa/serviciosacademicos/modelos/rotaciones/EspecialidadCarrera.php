<?php 
session_start();
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
require_once(realpath(dirname(__FILE__)).'/../../funciones/adodb/adodb-active-record.inc.php');
$db = getBD();

ADOdb_Active_Record::SetDatabaseAdapter($db);
$ADODB_ASSOC_CASE = 0;
class especialidadCarrera extends ADOdb_Active_Record{
	var $_table = 'EspecialidadCarrera';
	function getEspecialidad() { return $this->especialidad; }
}
?>