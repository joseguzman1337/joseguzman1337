<?php 
 session_start();
 $rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$objetobase=new BaseDeDatosGeneral($sala);

 ?>

<?php
/*columnas[0]="idcargo";
columnas[1]="nombrecargo";
columnas[2]="prioridadcargo";
columnas[3]="codigoestado";*/

if(isset($_GET['idcargo'])&&trim($_GET['idcargo'])!='&nbsp;'&&trim($_GET['idcargo'])!=''){
$fila['idcargo']=$_GET['idcargo'];
$condicionactualiza="idcargo=".$fila['idcargo'];
}
$fila['nombrecargo']=$_GET['nombrecargo'];
$fila['prioridadcargo']=$_GET['prioridadcargo'];
$fila['codigoestado']=$_GET['codigoestado'];
$tabla="cargo";
							
//$condicionactualiza="idcargo"
$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
echo $linea=$fila['idcargo']."-".$fila['nombrecargo']."-".$fila['prioridadcargo']."-".$fila['codigoestado'];

$file="logcargo.txt";
touch($file);
$apuntadorarchivo=fopen($file,"w+");
fputs($apuntadorarchivo,$linea);
fclose($apuntadorarchivo);

?>