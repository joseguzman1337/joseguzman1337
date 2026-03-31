<?php
/*****************************************************************
**		Pendientes a definir									**
**																**
**		Fernando Muñoz											**
**															 	**
**																**
**																**
*****************************************************************/
require_once('../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();

$usuario=$_SESSION['MM_Username'];

$query_documento = "SELECT numerodocumento, codigorol
FROM usuario
WHERE usuario = '$usuario'";
//echo "<br>$query_documento";
$documento = mysql_query($query_documento, $sala) or die(mysql_error()) or die("$query_documento<br>");
$total_documento = mysql_num_rows($documento);
$row_documento = mysql_fetch_assoc($documento);
//mysql_close($usuarios);
/*
Roles:
1	Estudiantes
2	Docentes
3	Administrador de Facultades
4	Administrador Credito y Cartera
6	Administrador Recursos Humanos
7	Rectoria y Vicerrectoria
8	Administradores Areas
9	Secretaria, Secretaria Academica Industrial
10	Administradores Areas
*/

  mysql_select_db($database_sala, $sala);
  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
  $row_tipousuario = mysql_fetch_assoc($tipousuario);
  $totalRows_tipousuario = mysql_num_rows($tipousuario);
//echo $query_tipousuario,"<br>";

//echo  $_GET['estudiante'],"get";
	if($row_tipousuario['codigotipousuariofacultad'] == 100 or $usuario == "admintecnologia")
	{
		$usadopor = "facultad";
		$_SESSION['codigo'] = $_GET['estudiante'];
	}
   else
	if($row_tipousuario['codigotipousuariofacultad'] == 200)
	{
		$usadopor = "creditoycartera";
		$_SESSION['codigo'] = $_GET['estudiante'];
	}
//echo $_SESSION['codigo'],"aqui";
//exit();
// Este script debe recibir el codigo del estudiante, ya sea por el get o por que es una sesion
$codigoestudiante = $_SESSION['codigo'];

$estudiante= "SELECT e.codigocarrera,e.codigosituacioncarreraestudiante,s.nombresituacioncarreraestudiante,e.codigoestudiante
FROM estudiante e,situacioncarreraestudiante s
WHERE e.codigoestudiante = '$codigoestudiante'
and e.codigocarrera = '".$_GET['codigocarrera']."'
and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante";
$est=mysql_db_query($database_sala,$estudiante) or die("$estudiante");
$totales = mysql_num_rows($est);
if($totales == "")
{
	$estudiante= "SELECT e.codigocarrera,e.codigosituacioncarreraestudiante,s.nombresituacioncarreraestudiante,e.codigoestudiante
	FROM estudiante e,situacioncarreraestudiante s
	WHERE e.codigoestudiante = '$codigoestudiante'
	and s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante";
	$est=mysql_db_query($database_sala,$estudiante) or die("$estudiante");
	$totales = mysql_num_rows($est);
}
$resultados=mysql_fetch_array($est);
//echo "$estudiante<br>";
//exit();

// Si el usuario que entra al programa es un estudiante valida que se encuentre en la fecha activa
if($row_documento['codigorol'] == 1 || $_SESSION['MM_Username'] == 'estudiante')
{
  ///////////////// Para quitar ///////////////////////////////////
	if(substr($resultados['codigosituacioncarreraestudiante'],0,1) == 1 || substr($resultados['codigosituacioncarreraestudiante'],0,1) == 4)
	{
		echo '<script language="JavaScript">alert("La situación académica actual es: '.$resultados['nombresituacioncarreraestudiante'].'");
		history.go(-1);
		</script>';
	}

	mysql_select_db($database_sala, $sala);
	$query_Recordset3 = "SELECT c.codigocarrera
	FROM carrera c,estudiante e
    WHERE e.codigocarrera = c.codigocarrera
	and e.codigoestudiante = '$codigoestudiante'";
	//echo $query_Recordset3;
	$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
	$row_Recordset3 = mysql_fetch_assoc($Recordset3);
	$totalRows_Recordset3 = mysql_num_rows($Recordset3);

//////////////////////////////////////////////////////////////////////////////////////


	$fecha= "select * from fechaacademica f
	where f.codigocarrera = '".$row_Recordset3['codigocarrera']."'
	and f.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
	$db=mysql_query($fecha, $sala) or die("$fecha");
	$total = mysql_num_rows($db);
	$resultado=mysql_fetch_array($db);
	$usadopor = "estudiante";

	//echo date("Y-m-d",(time())),"- ini  ",$resultado['fechainicialprematricula'],"  fin ",$resultado['fechafinalprematricula'];
	//$postprematricula = true;
	if ((date("Y-m-d",(time())) < $resultado['fechainicialprematricula']) or (date("Y-m-d",(time())) > $resultado['fechafinalprematricula']))
	{
            $postprematricula = false;
            if ($resultado['fechainicialpostmatriculafechaacademica'] <> "0000-00-00" and $resultado['fechafinalpostmatriculafechaacademica'] <> "0000-00-00"){
                if ((date("Y-m-d",(time())) >= $resultado['fechainicialpostmatriculafechaacademica']) and (date("Y-m-d",(time())) <= $resultado['fechafinalpostmatriculafechaacademica'])){
                    $postprematricula = true;
                }
            }

            if (!$postprematricula){
                echo '<script language="JavaScript">alert("La fecha para realizar su prematricula es de '.$resultado['fechainicialprematricula'].' a '.$resultado['fechafinalprematricula'].'")</script>';
                $usadopor = "estudianterestringido";
                $_SESSION['MM_Username'] = 'estudianterestringido';
                $_SESSION['MM_prematricula'] = 'estudianterestringido';
            }else{
                $_SESSION['MM_prematricula'] = 'estudiante';
            }
        }else{
            $_SESSION['MM_prematricula'] = 'estudiante';
        }
    

	$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
}

if($usadopor == "facultad")
{
    $_SESSION['codigofacultad'] = $resultados['codigocarrera'];
    $_SESSION['codigo'] = $resultados['codigoestudiante'];
}

if(substr($resultados['codigosituacioncarreraestudiante'],0,1) == 1 || substr($resultados['codigosituacioncarreraestudiante'],0,1) == 4)
{
	echo '<script language="JavaScript">alert("La situación académica actual es: '.$resultados['nombresituacioncarreraestudiante'].'");
	</script>';
}

//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=matriculaautomaticaordenmatricula.php?programausadopor=".$usadopor."'>";
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=matriculaautomaticaordenmatricula.php'>";
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../facultades/creacionestudiante/estudiante.php?programausadopor=".$usadopor."'>";
        ?>
<script type="text/javascript">
        window.location.href = "matriculaautomaticaordenmatricula.php";
</script>