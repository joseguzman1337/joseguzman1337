<?php


if (isset($creando)) {

include_once( "psxlsgen.php" );
include_once( "db_sxlsgen.php" );

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
$onlyfile="prueba.csv";
$filename=$path.$onlyfile;
if ($query == '')
   $query = "SELECT login,Password from Usuarios where id > 1201";
   
if (file_exists($filename))
  unlink($filename);
$file=fopen($filename,"w");
mysql_connect('localhost','root','TrySome@Home!');
mysql_select_db('Emiliano');
$result = mysql_query($query);
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


//echo "<br> <a href='mytest.php'> Reload </a>";
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
   }
   else {
   ?>
     <form name="form1" action="mytest.php" method=POST>
	   <textarea name="query" rows=20 cols=30>SELECT login, Password FROM Usuarios where Id > 1201</textarea><br>
       <input type="submit" value="Generar archivo con la consulta">
	   <Input type="reset" value="Vaciar consulta">
	   <input type="hidden" name="creando" value=1>
     </form>
   <?
   }
?>
