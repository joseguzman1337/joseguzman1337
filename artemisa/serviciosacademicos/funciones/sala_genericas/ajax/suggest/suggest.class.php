<?php
// load error handling module
//require_once('error_handler.php');
// load configuration file
//require_once('config.php');
// class supports server-side suggest & autocomplete functionality
class Suggest
{
// database handler
var $mMysqli;
//Tabla
var $tablas;
// Columna
var $columna;
// Condicion
var $condicion;
// constructor opens database connection
var $campollave;
var $camponombre;

function Suggest($sala,$tablas,$campollave,$camponombre,$condicion)
{

$this->tablas=$tablas;
$this->campollave=$campollave;
$this->camponombre=$camponombre;
$this->condicion=$condicion;
$this->columna=$columna;
$this->condicion=$condicion;

// connect to the database
	$this->mMysqli=new BaseDeDatosGeneral($sala);
	$this->tabla=$tabla;
}
// destructor, closes database connection
function __destruct()
{
$this->mMysqli->close();
}
// returns all PHP functions that start with $keyword
function getSuggestions($keyword)
{
// escape the keyword string
$patterns = array('/\s+/', '/"+/', '/%+/');
$replace = array('');
$keyword = preg_replace($patterns, $replace, $keyword);
// build the SQL query that gets the matching functions from the database
if($keyword != '')
$query = 'SELECT distinct ' .$this->camponombre.', '.$this->campollave.
' FROM  '.$this->tablas.
' WHERE REPLACE('.$this->camponombre.',\' \',\'\') LIKE "' . $keyword . '%" '.$this->condicion.' limit 0,30';

// if the keyword is empty build a SQL query that will return no results
else
$query = 'SELECT distinct ' .$this->camponombre.
' FROM ' .$this->tablas.
' WHERE '.$this->camponombre.'="" '.$this->condicion.' limit 0,30';
// execute the SQL query
$result = $this->mMysqli->conexion->query($query);
// build the XML response
//echo $query;
$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
$output .= '<response>';
// if we have results, loop through them and add them to the output
//if($result->num_rows)
while ($row = $result->fetchRow()){
$output .= '<name>' . iconv("UTF-8","UTF-8",str_replace("&","y",$row[$this->camponombre])) . '</name>';
$output .= '<id>' . iconv("UTF-8","UTF-8",$row[$this->campollave]) . '</id>';

}
// close the result stream
$result->close();
// add the final closing tag
$output .= '</response>';
// return the results
return $output;
}
//end class Suggest
}
?>