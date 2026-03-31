<?php
// load error handling module
require_once('error_handler.php');
// load configuration file
require_once('config.php');
// class supports server-side suggest & autocomplete functionality
class Suggest
{
// database handler
var $mMysqli;
//Tabla
var $tabla;
// Columna
var $columna;
// Condicion
var $condicion;
// constructor opens database connection
function Suggest($sala,$tabla,$columna,$condicion="")
{

$this->tabla=$tabla;
$this->columna=$columna;
$this->condicion=$condicion;
// connect to the database
	session_start();
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
$query = 'SELECT distinct ' .$this->columna.
' FROM  '.$this->tabla.
' WHERE REPLACE('.$this->columna.',\' \',\'\') LIKE "' . $keyword . '%" '.$this->condicion.' limit 0,30';
// if the keyword is empty build a SQL query that will return no results
else
$query = 'SELECT distinct ' .$this->columna.
' FROM ' .$this->tabla.
' WHERE '.$this->columna.'="" '.$this->condicion.' limit 0,30';

	
		 $this->columna2= $this->columna;


if($this->tabla=="Interesados"){

	if($this->columna=='idpreinscripcion'){
		  $this->columna='tp.idpreinscripcion';
		  $this->columna2='idpreinscripcion';
	}
	
$query="SELECT distinct ".$this->columna." ".$this->columna2."
			FROM  sectorempresa s, categoriaempresa c,empresa e, preinscripcion tp
			left join programainterespreinscripcion pi on
				pi.idpreinscripcion =tp.idpreinscripcion 
			left join programainteres p on
				p.idprogramainteres =pi.idprogramainteres 
			left join trato t on tp.idtrato=t.idtrato				 
			where e.idempresa=tp.idempresa
			and tp.codigoestado like '1%' 
			and c.idcategoriaempresa=e.idcategoriaempresa
			and s.idsectorempresa=c.idsectorempresa	
			and tp.codigoestadopreinscripcionestudiante=101			
			and REPLACE(".$this->columna.",' ','') LIKE '" . $keyword . "%' ".$this->condicion."		
			limit 0,30 ";
			
}
//echo $keyword;
// execute the SQL query
$result = $this->mMysqli->conexion->query($query);
// build the XML response
//echo $query;
$output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
$output .= '<response>';
// if we have results, loop through them and add them to the output
//if($result->num_rows)
while ($row = $result->fetchRow())
$output .= '<name>' . iconv("UTF-8","UTF-8",str_replace("&","y",$row[$this->columna2])). '</name>';
//htmlentities($row[$this->columna])
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