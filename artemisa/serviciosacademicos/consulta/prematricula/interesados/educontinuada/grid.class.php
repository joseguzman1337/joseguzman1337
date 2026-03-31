<?php
// start session
session_start();
// load configuration file
require_once('config.php');
// includes functionality to manipulate the products list
class Grid
{
// grid pages count public
var $mTotalPages;
// grid items count public
var $mItemsCount;
// index of page to be returned public
var $mReturnedPage;
// database handler private
var $mMysqli;
// database handler private
var $grid;
// class constructor public
var $tabla;
//Columnas
var $columnasgrid;
//Columnas
var $columnas;
//Condicion
var $condicion;
//Condicion
var $order;
//tablas
var $listadotablas;
//primarykey
var $primarykeys;

function Grid($sala,$tabla,$filasxpagina)
{
	// create the MySQL connection
	session_start();
	$this->mMysqli=new BaseDeDatosGeneral($sala);
	$this->tabla=$tabla;
	$this->filasxpagina=$filasxpagina;
	// call countAllRecords to get the number of grid records
	$this->primarykeys=$this->findPrimaryKeys();
	$this->mItemsCount=$this->countAllRecords();
}

// class destructor, closes database connection
function __destruct()
{
$this->mMysqli->close();
}
//Condiciona el resultado
function condicionarResultado($formarquery){
if(trim($formarquery)!="")
	if(trim($_SESSION['condicioneducontinuada'])!="")
		$this->readPage(1,$_SESSION['condicioneducontinuada']." and ".$formarquery);
	else
		$this->readPage(1," where ".$formarquery);
else
$this->readPage(1);
}
// Order by parameter 
function orderQuery($order)
{
if(isset($_SESSION['orderbygrid'])&&trim($_SESSION['orderbygrid'])!="")
$_SESSION['orderbygrid']=$_SESSION['orderbygrid'].",".$order;
else
$_SESSION['orderbygrid']=$order;
$this->readPage(1);
}

// read a page of products and save it to $this->grid public
function readPage($page,$where="")
{
if(trim($where)==""&&$_SESSION['condicioneducontinuada']!="")
$this->condicion=$_SESSION['condicioneducontinuada'];
else{
$this->condicion=$where;
$_SESSION['condicioneducontinuada']=$where;
}
$this->mItemsCount = $this->countAllRecords();

if(isset($_SESSION['orderbygrid'])&&trim($_SESSION['orderbygrid'])!="")
$this->order=" order by ".$_SESSION['orderbygrid'];

if($this->tabla=="Interesados"){
if(trim($this->condicion)!='')
$and="and";
else
$and="";


$query="SELECT tp.idpreinscripcion,s.nombresectorempresa,c.nombrecategoriaempresa, e.nombreempresa,
t.nombretrato,tp.nombresestudiante,tp.apellidosestudiante,tp.emailestudiante,
				p.nombreprogramainteres
			FROM sectorempresa s, categoriaempresa c, empresa e, preinscripcion tp
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
			$and ".str_replace("where","",str_replace("idpreinscripcion","tp.idpreinscripcion",$this->condicion).$this->order);
}
else{
	$query='SELECT * FROM '.$this->tabla.$this->condicion.$this->order;
}
// create the SQL query that returns a page of products
$queryString = $this->createSubpageQuery($query, $page);
$_SESSION['querystringeducacioncontinuada']=$queryString;
//echo $queryString;
//echo $queryString."<br> digame=".$this->mItemsCount;
//exit;
// execute the query
if ($result = $this->mMysqli->conexion->query($queryString))
{
// fetch associative array

unset($_SESSION['grid']);
while ($row = $result->fetchRow())
{
// build the XML structure containing products


$this->grid .= "<row>\n";
$i=0;
foreach($row as $name=>$val){
if($i<1)
$this->grid .= "<id>" .
htmlentities(quitartilde($val)) .
"</id>\n";

$this->grid .= "<column>" .
"<campo>" .iconv("UTF-8","UTF-8",str_replace("&","y",$val)).
"</campo></column>\n";
$columnas[$i]=$name;
$i++;
}
$this->grid .= "</row>\n";
}

for($j=0;$j<count($columnas);$j++){
$this->columnasgrid .= "<columnas><col>".$columnas[$j]."</col></columnas>\n";
$this->columnas[$j]=$columnas[$j];
$_SESSION['columnas']=$this->columnas;
}
// close the results stream
$result->close();

}
}
// update a product public
function updateRecord($matriz)
{
// escape input data for safely using it in SQL statements
// build the SQL query that updates a product record
$i=0;
foreach ($matriz as $llave => $valor){
$entrocambiollave=0;	
if($llave!='action'&&$llave!='tabla'){
		if($i==0){
			$llavecambiar=$llave;
			$valorcambiar=$valor;
			$llavecambiar=str_replace("TMP","",$llave);
			$entrocambiollave=1;	
		}
		if($i>0)
		if($llave==$llavecambiar){
				$llaveset=$llave;
				$valorset=$valor;
				$entrocambiollave=1;	
			
		}
		if(!$entrocambiollave)
			if($this->primarykeys[$llave]){
				$condicionupdate.= " and ".$llave."='". $valor."'";
			}
		$i++;
		
	}
}
$setupdate= $llaveset ."='". $valorset."'";
$condicionupdate= $llavecambiar ."='". $valorcambiar."' ". $condicionupdate;

$queryString = 'UPDATE '.$this->tabla.' SET ' . $setupdate . 
' WHERE ' .$condicionupdate;
/*$nombre_archivo="loggrid.txt";
$cadena="Se agrega un nuevo texto";
$gestor = fopen($nombre_archivo,'w');
fwrite($gestor, $queryString);
fclose($gestor);*/
// execute the SQL command
$this->mMysqli->conexion->query($queryString);
}
// returns data about the current request (number of grid pages, etc) public
function getParamsXML()
{
// calculate the previous page number
$previous_page =
($this->mReturnedPage == 1) ? '' : $this->mReturnedPage-1;
// calculate the next page number
$next_page = ($this->mTotalPages == $this->mReturnedPage) ?
'' : $this->mReturnedPage + 1;
// return the parameters
return "<params>\n" .
"<returned_page>" . $this->mReturnedPage . "</returned_page>\n".
"<total_pages>" . $this->mTotalPages . "</total_pages>\n".
"<items_count>" . $this->mItemsCount . "</items_count>\n".
"<previous_page>" . $previous_page . "</previous_page>\n".
"<next_page>" . $next_page . "</next_page>\n" .
"<items_x_page>" . $next_page . "</items_x_page>\n" .
"<rows_x_page>" .$this->filasxpagina. "</rows_x_page>\n" .
"<tablaseleccionada>".$this->tabla."</tablaseleccionada>\n".
"</params>\n";
}
// returns the current grid page in XML format public
function getGridXML()
{
return "<grid>" . $this->grid . "</grid>\n";
}
function getColXML()
{
return  $this->columnasgrid;
}
function getTableXML(){
//$query = 'show tables';
//$result = $this->mMysqli->conexion->query($query);
$tablas=array("0"=>"sectorempresa","1"=>"categoriaempresa","2"=>"empresa","3"=>"programainteres","4"=>"preinscripcion","6"=>"Interesados");
//while ($row = $result->fetchRow()){
foreach ($tablas as $llave => $valor)
$this->listadotablas.="<tablas><tab>".$valor."</tab></tablas>\n";
//}


return $this->listadotablas;
}
// returns the total number of records for the grid private
function countAllRecords()
{
/* if the record count isn"t already cached in the session,
read the value from the database */
//if (!isset($record_count))
//{
// the query that returns the record count
if($this->tabla=="Interesados"){

if(trim($this->condicion)!='')
$and="and";
else
$and="";

$count_query="SELECT count(*) cuenta FROM  sectorempresa s, categoriaempresa c,
			empresa e, preinscripcion tp
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
			$and ".str_replace("where","",str_replace("idpreinscripcion","tp.idpreinscripcion",$this->condicion).$this->order);
}
else{			
	$count_query = 'SELECT COUNT(*) cuenta FROM '.$this->tabla.$this->condicion;
}
// execute the query and fetch the result
if ($result = $this->mMysqli->conexion->query($count_query))
{
// retrieve the first returned row
$row = $result->fetchRow();
/* retrieve the first column of the first row (it represents the
records count that we were looking for), and save its value in the session */
unset($_SESSION['record_count']);
//echo "CUENTA = ".$row['cuenta'];
$record_count = $row['cuenta'];
// close the database handle
$result->close();
}
//}
// read the record count from the session and return it
return $record_count;
}
// receives a SELECT query that returns all products and modifies it
// to return only a page of products private
function createSubpageQuery($queryString, $pageNo)
{
// if we have few products then we don't implement pagination
if ($this->mItemsCount <= $this->filasxpagina)
{
$pageNo = 1;
$this->mTotalPages = 1;
}
// else we calculate number of pages and build new SELECT query
else
{
$this->mTotalPages = ceil($this->mItemsCount / $this->filasxpagina);
$start_page = ($pageNo - 1) * $this->filasxpagina;
$_SESSION['limitsesioneducontinuada']=' LIMIT ' . $start_page . ',' . $this->filasxpagina;
$queryString .= $_SESSION['limitsesioneducontinuada'];
}
// save the number of the returned page
$this->mReturnedPage = $pageNo;
// returns the new query string
return $queryString;
}

function findSuggest($sala,$keyword,$nocolumna)
{
// create a new Suggest instance
$columna=$_SESSION['columnas'][$nocolumna];
//print_r($_SESSION['columnas']);
//echo "<br>COLUMNA=".$columna."<BR>";

$suggest = new Suggest($sala,$this->tabla,$columna,$this->condicion);
// clear the output
if(ob_get_length()) ob_clean();
// headers are sent to prevent browsers from caching
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');
// send the results to the client
echo $suggest->getSuggestions($keyword);

}

function findPrimaryKeys()
{
// create a new Suggest instance
if($this->tabla=="Interesados")
$query = 'describe preinscripcion';
else
$query = 'describe '.$this->tabla;
// execute the query and fetch the result
if ($result = $this->mMysqli->conexion->query($query))
{
// retrieve the first returned row
	while($row = $result->fetchRow()){
	//echo "\n".$row['key'];
		if($row['Key']=='PRI'){
				$array_interno[$row['Field']]=1;
		}
	}
}
	return $array_interno;
}

// end class Grid
}
?>