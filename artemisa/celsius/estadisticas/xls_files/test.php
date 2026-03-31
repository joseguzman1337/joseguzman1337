<?php
   
	  include_once Obtener_Direccion(0)."conexion.inc";
      Conexion();
  include_once Obtener_Direccion(0)."parametros.inc";
//if (isset($creando)) {

include_once( "psxlsgen.php" );
include_once( "db_sxlsgen.php" );

function agregarHeader($result,$file)
{//agrega en el archivo $file ya abierto los nombres de los campos de una consulta ya realizada, separados por comas
$myheader='';
for ($i=0;$i<mysql_num_fields($result);$i++) {
   $myheader .= mysql_field_name($result,$i).",";
   }

fwrite($file,$myheader,strlen($myheader)-1);
fwrite($file,"\r\n");
}
/* Este archivo recibe un query y genera un archivo .csv con los resultados del query*/
/*$myxls = new PhpSimpleXlsGen();
$myxls->totalcol = 2;
$myxls->InsertText( "Gonzalo" );
$myxls->InsertText( "Villarreal" );
$myxls->InsertText( "This text should be at (3,0) if header was used, otherwise at (1,0)" );
$myxls->ChangePos(4,0);
$myxls->InsertText( "You must pay" );
$myxls->InsertNumber( 20.48 );
$myxls->WriteText_pos(4,2, "USD to use this class :-))" );         // hidden costs :-))
$myxls->SendFile();
*/

$path="/services/upload/";
$onlyfile=$mifilename;
$filename=$path.$onlyfile;

if ($query == '')
   return false;
   
if (file_exists($filename))
  unlink($filename);
$file=fopen($filename,"w");
//mysql_connect('localhost','root','TrySome@Home!');
//mysql_select_db('Emiliano');
$result = mysql_query($query);

//imprimo como encabezado los nombres de los campos recuperados
agregarHeader($result,$file);
//Ahora se imprimen en el archivo todos los datos recuperados del query
$cant = 0;
while ($row = mysql_fetch_row($result))
  {  $str ="";
  	  for ($i=0;$i < sizeof($row); $i++) {
		   $str .= $row[$i].',';
       	  }
  $cant ++;
  fwrite($file,substr($str,0,strlen($str)-1).",".$cant."\r\n");
  }
fclose($file);
		header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
        header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
        header ( "Pragma: no-cache" );
        header ( "Content-type: application/x-msexcel" );
        header ( "Content-Disposition: attachment; filename=$onlyfile" );
        header ( "Content-Description: PHP Generated XLS Data" );
        @readfile($filename);

/*
$myxls = new Db_SXlsGen;
$myxls->filename = "mytest";
$myxls->GetXlsFromQuery($query);
*/

?>
