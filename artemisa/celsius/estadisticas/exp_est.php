<?


/**
 * Exporta la estadistica
 */
require_once "../common/includes.php";

$path = Configuracion::getDirectorioTemporal();
if (is_a($path, "File_Exception")){
    		return $path;
}

$onlyfile = $mifilename;
$filename = $path . $onlyfile;
if (file_exists($filename))
	unlink($filename);
$file = fopen($filename, "w");
//echo $datos;
fwrite($file, $datos);
fclose($file);
/*header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/x-msexcel" );
header ( "Content-Disposition: attachment; filename=$onlyfile" );
header ( "Content-Description: PHP Generated XLS Data" );
@readfile($filename);
//una vez que se ha hecho el download, borro el archivo para que no queden copias innecesarias en el servidor
unlink($filename);
*/
/*
// ----- begin of function library -----
// Excel begin of file header
function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
	return;
}
// Excel end of file footer
function xlsEOF() {
	echo pack("ssssss", 0x0A, 0x00);
	return;
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("ssssss", 0x203, 14, $Row, $Col, 0x0);
	echo $Col.",".$Row;
	echo pack("d", $Value);
	return;
}
// Function to write a label (text) into Row, Col
function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
return;
}
// ----- end of function library -----


header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");	
header ("Pragma: no-cache");	
header ('Content-type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=EmplList.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" );
//
// the next lines demonstrate the generation of the Excel stream
//
xlsBOF();   // begin Excel stream
xlsWriteLabel(0,0,"gonetil");  // write a label in A1, use for dates too
xlsWriteNumber(10,11,9999);  // write a number B1
xlsEOF(); // close the stream */
?> 
