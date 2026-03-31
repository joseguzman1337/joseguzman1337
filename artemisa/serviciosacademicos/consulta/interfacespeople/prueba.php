<?
require_once('../../Connections/sala2.php');
//mysql_select_db("sala", $sala);
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
    $queEmp = "SELECT * from logtraceintegracionps order by fecharegistrologtraceintegracionps desc limit 0 , 100";
    $resEmp = mysql_query($queEmp, $sala) or die("$queEmp".mysql_error());
    $totEmp = mysql_num_rows($resEmp);
print $totEmp;
?>
