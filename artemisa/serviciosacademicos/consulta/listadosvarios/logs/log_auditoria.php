<?php
session_start();
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo ini_get('memory_limit');
//print_r( ini_get_all());
error_reporting(0);
$_SESSION['get']=$_GET;
//echo '<pre>';print_r($_SESSION);
if($_GET['fechainicio']!="" and $_GET['fechafinal']!="")
{
	$_SESSION['fechainicio']=$_GET['fechainicio'];
	$_SESSION['fechafinal']=$_GET['fechafinal'];
	if(isset($_GET['codigocarrera'])){
		$_SESSION['codigofacultad']=$_GET['codigocarrera'];
	}
}
if(!isset($_SESSION['codigofacultad']))
{
	echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
	exit();
}
if(isset($_GET['Restablecer']))
{
	unset($_SESSION['datos']);
	unset($_SESSION['get']);
	unset($_SESSION['rows']);
	unset($_SESSION['idauditoria']);
	?><script language="javascript">window.location.href="log_auditoria.php";</script><?php
}
if(isset($_GET['Regresar']))
{
	unset($_SESSION['get']);
	//echo '<script language="javascript">window.location.reload("menu_log_auditoria.php")</script>';
	echo '<script language="javascript">history.go(-2)</script>';
}
if(isset($_GET['Exportar']))
{
	$_SESSION['tipo_exportacion']=$_GET['tipo_exp'];
	$informe->filtrasino(true,$_SESSION['get']);
	$informe->emergente($_GET['tipo_exp'],$_SESSION['tipo_exportacion'],"log_auditoria");
	
}
if(isset($_POST['Exportar_recorte']))
{
	$_SESSION['tipo_exportacion']=$_POST['tipo_exp'];
	$informe->recortar($_POST);
	$informe->emergente($_GET['tipo_exp'],$_SESSION['tipo_exportacion'],"log_auditoria");
}
if(isset($_GET['orden']) and $_GET['orden']!="")
{
	$_SESSION['orden']=$_GET['orden'];
}
if(isset($_GET['ordenamiento']) and $_GET['ordenamiento']!="")
{
	$_SESSION['ordenamiento']=$_GET['ordenamiento'];
}
$_SESSION['get']=$_GET;
if(isset($_GET['codigoestudiante']))
{
	$_SESSION['estudiante']=$_GET['codigoestudiante'];
}

//print_r($_SESSION['get']);
//require_once("../../../../funciones/conexion/conexionpear.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/sala2.php");
$rutaado = realpath(dirname(__FILE__))."/../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
$rutaVistas = "./vistas";
require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php");
require_once("funciones/motor2.php");

$contador=0;
if(!isset($_GET['fechainicio']) and isset($_GET['fechafinal']))
{
	echo '<script language="javascript">alert("No hay fechas para consultar")</script>';
}

if(!isset($_SESSION['rows']))
{
	if(isset($_SESSION['estudiante']) and $_SESSION['estudiante']!="")
	{
		$query_inicial=
		"SELECT
		a.idauditoria,
		a.fechaauditoria,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		eg.numerodocumento as documento_estudiante,
		a.numerodocumento as documento_docente,
		m.nombremateria as materia,
		a.notaanterior,
		a.notamodificada,
		a.corte,
		a.observacion,
		a.usuario,
        CONCAT(u.apellidos,' ',u.nombres) as NomUsuario
		
		from auditoria a, estudiantegeneral eg, estudiante e, materia m,usuario u 
		WHERE 
		m.codigomateria=a.codigomateria
		and e.idestudiantegeneral=eg.idestudiantegeneral
		and e.codigoestudiante=a.codigoestudiante
		
		and e.codigoestudiante='".$_SESSION['estudiante']."'
		AND
        u.usuario=a.usuario 
		";
		$_SESSION['rows']=$db->GetRow($query_inicial);
		$_SESSION['idauditoria']=$_SESSION['rows']['idauditoria'];
	}

	else
	{ $query_inicial=
		"SELECT
		a.idauditoria,
		a.fechaauditoria,
		concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
		eg.numerodocumento as documento_estudiante,
		a.numerodocumento as documento_docente,
		m.nombremateria as materia,
		a.notaanterior,
		a.notamodificada,
		a.corte,
		a.observacion,
		a.usuario,
        CONCAT(u.apellidos,' ',u.nombres) as NomUsuario
		
		from auditoria a, estudiantegeneral eg, estudiante e, materia m, usuario u 
		WHERE 
		m.codigomateria=a.codigomateria
		and e.idestudiantegeneral=eg.idestudiantegeneral
		and e.codigoestudiante=a.codigoestudiante
		and e.codigocarrera='".$_SESSION['codigofacultad']."'
		and fechaauditoria >= '".$_SESSION['fechainicio']."' and fechaauditoria <='".$_SESSION['fechafinal']."'
		AND
        u.usuario=a.usuario 
		";
		$_SESSION['rows']=$db->GetRow($query_inicial);
		$_SESSION['idauditoria']=$_SESSION['rows']['idauditoria'];
	}

}

if(isset($_GET['Siguiente']))
{
	$_SESSION['idauditoria']=$_GET['Siguiente'];
}
if(isset($_GET['Atras']))
{
	$_SESSION['idauditoria']=$_GET['Atras'];
}
if(isset($_SESSION['estudiante']) and $_SESSION['estudiante']!="")
{
	$query_auditoria="
	SELECT 
	a.idauditoria,
	a.fechaauditoria,
	concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
	eg.numerodocumento as documento_estudiante,
	a.numerodocumento as documento_docente,
	m.nombremateria as materia,
	a.notaanterior,
	a.notamodificada,
	a.corte,
	a.observacion,
	a.usuario,
    CONCAT(u.apellidos,' ',u.nombres) as NomUsuario

	from auditoria a, estudiantegeneral eg, estudiante e, materia m, usuario u 

	WHERE 
	m.codigomateria=a.codigomateria
	and e.idestudiantegeneral=eg.idestudiantegeneral
	and e.codigoestudiante=a.codigoestudiante
	
	and e.codigoestudiante='".$_SESSION['estudiante']."'
	
	and (a.idauditoria >= '".$_SESSION['idauditoria']."') 
	AND
    u.usuario=a.usuario

	limit 1000";
}
else
{
	$query_auditoria="
	SELECT 
	a.idauditoria,
	a.fechaauditoria,
	concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
	eg.numerodocumento as documento_estudiante,
	a.numerodocumento as documento_docente,
	m.nombremateria as materia,
	a.notaanterior,
	a.notamodificada,
	a.corte,
	a.observacion,
	a.usuario,
    CONCAT(u.apellidos,' ',u.nombres) as NomUsuario
	from auditoria a, estudiantegeneral eg, estudiante e, materia m, usuario u 
	WHERE 
	m.codigomateria=a.codigomateria
	and e.idestudiantegeneral=eg.idestudiantegeneral
	and e.codigocarrera='".$_SESSION['codigofacultad']."'
	and e.codigoestudiante=a.codigoestudiante
	and fechaauditoria >= '".$_SESSION['fechainicio']."' and fechaauditoria <='".$_SESSION['fechafinal']."' 
	and (a.idauditoria >= '".$_SESSION['idauditoria']."') 
	AND
    u.usuario=a.usuario
	limit 1000
	";

}
//echo "<h1>".$_SESSION['idauditoria']."</h1><br>";
//echo "<h1>".$query_auditoria."</h1>";
//var_dump($query_auditoria);echo "<br/>";
$auditorias=$db->Execute($query_auditoria);


$contador=0;
foreach($auditorias as $row_auditoria)
{
	//$array_datos[$contador]=$row_auditoria;
	$array_datos[$contador]['idauditoria']=$row_auditoria['idauditoria'];
	$array_datos[$contador]['fechaauditoria']=$row_auditoria['fechaauditoria'];
	$array_datos[$contador]['nombre']=$row_auditoria['nombre'];
	$array_datos[$contador]['documento_estudiante']=$row_auditoria['documento_estudiante'];
	$array_datos[$contador]['documento_docente']=$row_auditoria['documento_docente'];
	$array_datos[$contador]['materia']=$row_auditoria['materia'];
	$array_datos[$contador]['notaanterior']=$row_auditoria['notaanterior'];
	$array_datos[$contador]['notamodificada']=$row_auditoria['notamodificada'];	
	$array_datos[$contador]['corte']=$row_auditoria['corte'];
	$array_datos[$contador]['observacion']=$row_auditoria['observacion'];
	$array_datos[$contador]['Nombre Usuario']=$row_auditoria['nomusuario'];
	$array_datos[$contador]['Usuario']=$row_auditoria['usuario'];
	if($array_datos[$contador]['notaanterior']!=$array_datos[$contador]['notamodificada'])
	{
		$array_datos[$contador]['cambio']='si';
	}
	else
	{
		$array_datos[$contador]['cambio']='no';
	}
	$contador++;
}


$template = $mustache->loadTemplate('log_auditoria');

$informe=new matriz($array_datos,"Log Auditoría");

if(isset($_GET['Filtrar']) and $_GET['Filtrar']!="")
{
	$informe->filtrasino(true,$_SESSION['get']);
	$informe->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
}
else
{
	$informe->ordenamiento($_GET['ordenamiento'],$_GET['orden']);
}

//echo $informe->imprimir_matriz("log_auditoria.php","si");

$result = $template->render(array('title' => 'Log de Auditoría', 
						'atras' => ($_SESSION['idauditoria']-500), 
						'siguiente' => ($_SESSION['idauditoria']+500),
						'imprimir_matriz' => '|imprimir_matriz|'
						)
					);
				
echo str_replace ( '|imprimir_matriz|' , $informe->imprimir_matriz("log_auditoria.php","si") , $result );
?>