<?php
@session_start();
//print_r($_SESSION);
require('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require('../../../Connections/sap.php');
require('validacion_pazysalvo.php');
require('validacion_documentos.php');
require('validacion_materias.php');
require('funcion-barra.php');
require('funciones/saldo_favor_contra.php');

if(isset($_GET['facultad']))
{
$query_egresados="SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigosituacioncarreraestudiante,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.codigogenero, c.nombrecarrera, eg.numerodocumento
FROM estudiante e, estudiantegeneral eg, carrera c WHERE
e.codigocarrera=c.codigocarrera AND
e.codigosituacioncarreraestudiante=104 AND 
e.idestudiantegeneral = eg.idestudiantegeneral AND
e.codigocarrera='".$_GET['facultad']."' order by nombre
";
}
else
{
$query_egresados="SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigosituacioncarreraestudiante,concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.codigogenero, c.nombrecarrera, eg.numerodocumento
FROM estudiante e, estudiantegeneral eg, carrera c WHERE
e.codigocarrera=c.codigocarrera AND
e.codigosituacioncarreraestudiante=104 AND 
e.idestudiantegeneral = eg.idestudiantegeneral AND
e.codigocarrera='".$_SESSION['codigofacultad']."' order by nombre
"
;
}
$egresados=mysql_query($query_egresados,$sala) or die(mysql_error());
$row_egresados=mysql_fetch_assoc($egresados);
$row_egresados_tabla=mysql_fetch_assoc($egresados);
//print_r($row_egresados);
//echo "<br>";
//print_r($row_egresados_tabla);

$num_rows_egresados=mysql_num_rows($egresados);
$cant_regs_egresados=$num_rows_egresados;
//echo $query_egresados;
/*while ($row_egresados=mysql_fetch_assoc($egresados)){
//echo $row_egresados['codigogenero'];
$pendiente_documentos=validacion_documentos($row_egresados['codigocarrera'],$row_egresados['codigogenero'],$row_egresados['codigoestudiante'],$sala);
$pendiente_pazysalvo=validacion_pazysalvo($row_egresados['codigoestudiante'],$sala);
$pendiente_materias=generarcargaestudiante($row_egresados['codigoestudiante'],$sala);
//$pendiente_materias=generarcargaestudiante($row_egresados['codigoestudiante'],$sala);
//echo $row_egresados['codigoestudiante'],"<br>";
if ($pendiente_materias==false and $pendiente_documentos==false and $pendiente_pazysalvo==false){echo $row_egresados['codigoestudiante'],"<br>";}
}
*/
//echo "<h1>Este procedimiento puede demorar varios minutos, porfavor no oprima ningï¿½n botï¿½n del explorador, hasta que aparezcan datos</h1>"
?>

<?php
/* //$server = mysql_connect($host, $usr, $pwd) or die ();
//$log = mysql_select_db($ddbb,$server) or die ();

echo "<div id='progress' style='position:relative;padding:0px;width:450px;height:60px;left:25px;'>";
    do {
    sleep(1); //no bbdd... ;)
    //$ins = "INSERT ...";
    //$doins = mysql_query($ins) or die(mysql_error()); 
    echo "<div style='float:left;margin:5px 0px 0px 1px;width:2px;height:12px;background:red;color:red;'> </div>";
    flush();
    ob_flush();
}
while ($row_egresados=mysql_fetch_assoc($egresados));
echo "</div>";
echo "<script>document.getElementById('progress').style.display = 'none'</script>";
 */
?>
<?php 
echo "<br>","<br>","<br>","<br>","<br>","<br>","<br>","<br>";
echo "<h2>Este proceso puede demorar un tiempo, porfavor espere...</h2>";
echo "<div id='progress' style='position:relative;padding:0px;width:2048px;height:60px;left:25px;'>";
     do {
	echo '<img src="barra.JPG">';
		$pendiente_documentos=validacion_documentos($row_egresados['codigocarrera'],$row_egresados['codigogenero'],$row_egresados['codigoestudiante'],$sala);
    	$pendiente_pazysalvo=validacion_pazysalvo($row_egresados['codigoestudiante'],$sala);
    	$pendiente_materias=generarcargaestudiante($row_egresados['codigoestudiante'],$sala);
		$pendiente_sap=saldoencontra($row_egresados['codigoestudiante'],$database_sala,$sala,$rfc,$login,$rfchandle);
    	barra();
		//echo "documentos ",$pendiente_documentos," ",$row_egresados['numerodocumento']," ","sap ",$pendiente_sap,"<br>";
    	if ($pendiente_documentos==false and $pendiente_materias==false and  $pendiente_pazysalvo==false and $pendiente_sap==false){
    		if(!isset($_GET['facultad']))
			{
				$array_codigoestudiante[]=$row_egresados['codigoestudiante'];
				$array_nombre[]=$row_egresados['nombre'];
				$array_numerodocumento[]=$row_egresados['numerodocumento'];
				$array_nombrecarrera[]=$row_egresados['nombrecarrera'];			}
			else
			{				
				$array_codigoestudiante[]=$row_egresados['codigoestudiante'];
				$array_nombre[]=$row_egresados['nombre'];
				$array_numerodocumento[]=$row_egresados['numerodocumento'];
				$array_nombrecarrera[]=$row_egresados['nombrecarrera'];
			}
			
    	}
	}
	 while ($row_egresados=mysql_fetch_assoc($egresados));
	 echo "</div>";
?>
<?php
$_SESSION["nombre"]=$array_nombre;
$_SESSION["codigoestudiante"]=$array_codigoestudiante;
$_SESSION["numerodocumento"]=$array_numerodocumento;
$_SESSION["nombrecarrera"]=$array_nombrecarrera;
if(isset($_GET['facultad'])){
echo '<script language="javascript">window.location.reload("tabla_elegibles.php?datos");</script>';
}
else
{
echo '<script language="javascript">window.location.reload("tabla_elegibles.php?cartas");</script>';
}
?>
