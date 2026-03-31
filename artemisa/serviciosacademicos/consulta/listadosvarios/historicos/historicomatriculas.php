<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
include($rutazado.'zadodb-pager.inc.php');

session_start();
if(isset($_SESSION['debug_sesion']))
{
	$db->debug = true; 
}
//$db->debug = true;
$codigocarrera = $_SESSION['codigofacultad'];
//print_r($_SESSION);
$query_periodos = "select codigoperiodo from periodo order by 1 desc"; 
$periodos = $db->Execute($query_periodos); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado de Históricos</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<?php
if(isset($_REQUEST['cadasemestre'])&&$_REQUEST['cadasemestre']!="")
{
?>
<p>ESTUDIANTES MATRICULADOS EN CADA SEMESTRE</p>
<?php
}
if(isset($_REQUEST['sinmateriasperdidas'])&&$_REQUEST['sinmateriasperdidas']!="")
{
?>
<p>ESTUDIANTES MATRICULADOS EN CADA SEMESTRE SIN MATERIAS PERDIDAS</p>
<?php
}
if(isset($_REQUEST['conmateriasperdidas'])&&trim($_REQUEST['conmateriasperdidas'])!="")
{
?>
<p>ESTUDIANTES MATRICULADOS EN CADA SEMESTRE CON MATERIAS PERDIDAS</p>
<?php
}
?>
<form action="" method="post" name="f1">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
	<td id="tdtitulogris" colspan="3">Limitar Consulta</td>
  </tr>
 <tr><td>Periodo Inicial <?php echo $periodos->GetMenu("naperiodoini",$_REQUEST['naperiodoini'],$multiple=true,$size=0,'tittle="habilitar"'); $periodos->Move(0);?></td><td>Periodo Final <?php echo $periodos->GetMenu("naperiodofin",$_REQUEST['naperiodofin'],$multiple=true,$size=0,'tittle="habilitar"');?></td>
   <td><input type="submit" name="Filtrar" value="Filtrar"></td>
 </tr>
</table>
<br>
<?php 
if($_REQUEST['naperiodoini'] == "")
{
	$_REQUEST['naperiodoini'] = 1;
}
if($_REQUEST['naperiodofin'] == "")
{
	$_REQUEST['naperiodofin'] = 99999;
}
$rows_per_page=10;
if($_REQUEST['row_page'] != "")
{
	$rows_per_page = $_REQUEST['row_page'];
}
	
$linkadd = "&naperiodoini=".$_REQUEST['naperiodoini']."&naperiodofin=".$_REQUEST['naperiodofin']."&cadasemestre=".$_REQUEST['cadasemestre'].
"&sinmateriasperdidas=".$_REQUEST['sinmateriasperdidas']."&conmateriasperdidas=".$_REQUEST['conmateriasperdidas'];
$filter = "";
if(isset($_REQUEST['cadasemestre'])&&$_REQUEST['cadasemestre']!="")
{
	// Campos que se van a filtrar, en el valor del arreglo va la condición
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	//$array_campos['codigosituacioncarreraestudiante'] = "e.codigoperiodo";
	
	$sqlini = "select eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoperiodo, eg.emailestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, e.semestre, s.nombresituacioncarreraestudiante
	from estudiante e, estudiantegeneral eg, notahistorico n, situacioncarreraestudiante s
	where e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigocarrera = '$codigocarrera'
	and e.codigoperiodo >= ".$_REQUEST['naperiodoini']."
	and e.codigoperiodo <= ".$_REQUEST['naperiodofin']."
	and e.codigoestudiante = n.codigoestudiante
	and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante";
	$sqlfin =" group by 1";
	
	//$gSQLBlockRows = 100;
	//rs2html($matriculas,'width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Documento','Nombre','Periodo de Ingreso')); 
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin);
	$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('Documento','Nombre','Periodo de Ingreso','Email','Teléfono','Semestre','Situación Académica')); 
	
?>
<br>
<input type="submit" name="Filtrar" value="Filtrar"><input type="button" value="Restablecer" onClick="window.location.reload('historicomatriculas.php?cadasemestre=1')"><input type="button" value="Regresar" onClick="window.location.reload('historicos.php')">
<?php
}
if(isset($_REQUEST['sinmateriasperdidas'])&&$_REQUEST['sinmateriasperdidas']!="")
{
	// Campos que se van a filtrar, en el valor del arreglo va la condición
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	
	$sqlini = "select eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoperiodo, eg.emailestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, e.semestre, s.nombresituacioncarreraestudiante
	from estudiante e, estudiantegeneral eg, notahistorico n, situacioncarreraestudiante s
	where e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigocarrera = '$codigocarrera'
	and e.codigoperiodo >= ".$_REQUEST['naperiodoini']."
	and e.codigoperiodo <= ".$_REQUEST['naperiodofin']."
	and e.codigoestudiante = n.codigoestudiante
	and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
	and e.codigoestudiante <> all(
	select n.codigoestudiante 
	from notahistorico n
	where e.codigoestudiante = n.codigoestudiante
	and n.notadefinitiva < 3
	)";
	$sqlfin =" group by 1";
	
	//$gSQLBlockRows = 100;
	//rs2html($matriculas,'width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Documento','Nombre','Periodo de Ingreso')); 
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin);
	$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('Documento','Nombre','Periodo de Ingreso','Email','Teléfono','Semestre','Situación Académica')); 
?>
<br>
<input type="submit" name="Filtrar" value="Filtrar"><input type="button" value="Restablecer" onClick="window.location.reload('historicomatriculas.php?sinmateriasperdidas=1')"><input type="button" value="Regresar" onClick="window.location.reload('historicos.php')">
<?php
}
if(isset($_REQUEST['conmateriasperdidas'])&&trim($_REQUEST['conmateriasperdidas'])!="")
{
	// Campos que se van a filtrar, en el valor del arreglo va la condición
	$array_campos['nombre'] = "concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)";
	$array_campos['codigoperiodo'] = "e.codigoperiodo";
	
	$sqlini = "select eg.numerodocumento, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, e.codigoperiodo, eg.emailestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, e.semestre, s.nombresituacioncarreraestudiante
	from estudiante e, estudiantegeneral eg, notahistorico n, situacioncarreraestudiante s
	where e.idestudiantegeneral = eg.idestudiantegeneral
	and e.codigocarrera = '$codigocarrera'
	and e.codigoperiodo >= ".$_REQUEST['naperiodoini']."
	and e.codigoperiodo <= ".$_REQUEST['naperiodofin']."
	and e.codigoestudiante = n.codigoestudiante
	and n.notadefinitiva < 3
	and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante";
	$sqlfin =" group by 1";
	
	//$gSQLBlockRows = 100;
	//rs2html($matriculas,'width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"',array('Documento','Nombre','Periodo de Ingreso')); 
	$pager = new ADODB_Pager($db,$sqlini.$sqlfin);
	$pager->Filter($sqlini,$sqlfin,$array_campos,$linkadd);
	$pager->Render($rows_per_page,'width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9"', array('Documento','Nombre','Periodo de Ingreso','Email','Teléfono','Semestre','Situación Académica')); 
?>
<br>
<input type="submit" name="Filtrar" value="Filtrar"><input type="button" value="Restablecer" onClick="window.location.reload('historicomatriculas.php?conmateriasperdidas=1')"><input type="button" value="Regresar" onClick="window.location.reload('historicos.php')">
<?php
}
?>

</form>
</body>
<script language="javascript">
function HabilitarGrupo(seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		
		var reg = new RegExp("^periodo");
		//elemento.name.search(regexp)
		//elemento.title == seleccion 	
		if(!elemento.name.search(reg))
		{
			//alert("aca"+elemento.name+" == "+seleccion);
			if(elemento.disabled == true)//alert("aca"+elemento.title+" == "+seleccion);
			{	
				elemento.disabled = false;
			}
			else
			{
				elemento.disabled = true;
			}
		}
	}
}
</script>
</html>
