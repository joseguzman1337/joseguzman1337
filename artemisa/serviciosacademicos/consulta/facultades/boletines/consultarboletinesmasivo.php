<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>
</head>
<?php 
require_once('../../../Connections/sala2.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
@session_start();
//require('funcionequivalenciapromedio.php');
$codigocarrera = $_SESSION['codigofacultad'];
mysql_select_db($database_sala, $sala);

$query_universidad = "SELECT direccionuniversidad,c.nombreciudad,p.nombrepais,u.paginawebuniversidad,u.imagenlogouniversidad,u.telefonouniversidad,u.faxuniversidad,u.nituniversidad,u.personeriauniversidad,u.entidadrigeuniversidad
FROM universidad u,ciudad c,pais p,departamento d 
WHERE u.iduniversidad = 1
AND d.idpais = p.idpais
AND u.idciudad = c.idciudad
AND c.iddepartamento = d.iddepartamento";
$universidad = mysql_query($query_universidad, $sala) or die(mysql_error());
$row_universidad = mysql_fetch_assoc($universidad);
$totalRows_universidad = mysql_num_rows($universidad);


if ($_GET['periodo'] <> "")
 {
    $periodoactual = $_GET['periodo']; 
 }
 else
 {   
    $periodoactual = $_SESSION['codigoperiodosesion'];
 }

if (isset($_GET['busqueda_semestre']))
{ // if (isset($_POST['busqueda_semestre']))
	mysql_select_db($database_sala, $sala);
	$query_materiascarrera = "SELECT distinct eg.numerodocumento, e.codigoestudiante,eg.apellidosestudiantegeneral
	FROM detalleprematricula dp,estudiante e, prematricula p,materia m,grupo g,estudiantegeneral eg
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
	AND p.idprematricula = dp.idprematricula
	AND dp.codigomateria= m.codigomateria
	AND dp.idgrupo = g.idgrupo
	AND e.codigoestudiante = p.codigoestudiante
	AND p.codigoperiodo = g.codigoperiodo
	AND g.codigoperiodo = '".$periodoactual."'
	AND m.codigoestadomateria = '01'
	AND e.codigocarrera = '$codigocarrera'
	AND p.codigoestadoprematricula LIKE '4%'
	AND dp.codigoestadodetalleprematricula  LIKE '3%'
	AND p.semestreprematricula = '".$_GET['busqueda_semestre']."'
	ORDER BY 3";
	//echo $query_materiascarrera;
	$materiascarrera = mysql_query($query_materiascarrera, $sala) or die("$query_promedioestudiante");
	$total_materiascarrera = mysql_num_rows($materiascarrera);
	$row_materiascarrera = mysql_fetch_assoc($materiascarrera);
	
	if($total_materiascarrera != "")
	{ //
		 do{
			$codigoestudiante = $row_materiascarrera['codigoestudiante'];
			require('consultaboletinoperacionmasivo.php');
			 echo "<div align='center' class='Estilo5'>".$row_universidad['direccionuniversidad']." - P B X ".$row_universidad['telefonouniversidad']." - FAX: ".$row_universidad['faxuniversidad']."<br>".$row_universidad['paginawebuniversidad']." - ".$row_universidad['nombreciudad']." ".$row_universidad['nombrepais']."</div>";
			echo "<H1 class=SaltoDePagina> </H1>";
		}while($row_materiascarrera = mysql_fetch_assoc($materiascarrera));
	}
	
	
} 
?>