<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado-pear.php');
require_once('../../../funciones/clases/motorv2/motor.php');

if($_GET['codigocarrerainf']<>'' and isset($_GET['codigocarrerainf'])){
	echo "-";
	$_SESSION['codigocarrerainf']=$_GET['codigocarrerainf'];
}

if($_GET['codigoperiodoinf']<>'' and isset($_GET['codigoperiodoinf'])){
	echo "*";
	$_SESSION['codigoperiodoinf']=$_GET['codigoperiodoinf'];
}

//print_r($_SESSION);

$codigocarrera=$_SESSION['codigocarrerainf'];
$codigoperiodo=$_SESSION['codigoperiodoinf'];

$query="
SELECT DISTINCT e.idestudiantegeneral,e.codigoestudiante,e.codigocarrera FROM estudiante e
INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante
INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula
INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
WHERE op.codigoestadoordenpago LIKE '4%'
AND op.codigoperiodo='$codigoperiodo'
AND pr.codigoperiodo='$codigoperiodo'
AND e.codigocarrera='$codigocarrera'
";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
do{
	$arrayInterno[]=$rowOperacion;
}
while($rowOperacion=$operacion->fetchRow());


foreach ($arrayInterno as $llave => $valor){
	$query="
	SELECT DISTINCT e.idestudiantegeneral,e.codigoestudiante,e.codigocarrera FROM estudiante e
	INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante
	INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula
	INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
	WHERE op.codigoestadoordenpago LIKE '4%'
	AND op.codigoperiodo='$codigoperiodo'
	AND pr.codigoperiodo='$codigoperiodo'
	AND e.codigocarrera <> '$codigocarrera'
	AND e.idestudiantegeneral='".$valor['idestudiantegeneral']."'
	";
	$operacion=$sala->query($query);
	$rowOperacion=$operacion->fetchRow();
	do{
		if($rowOperacion['idestudiantegeneral']<>''){
			$arrayInterno2[]=$rowOperacion;
		}
	}
	while($rowOperacion=$operacion->fetchRow());
}
unset($arrayInterno);
//print_r($_GET);
foreach ($arrayInterno2 as $llave2 => $valor2){
    if($_GET['codigomodalidadacademica']!='400')
    {
        $query="
        SELECT DISTINCT e.idestudiantegeneral,e.codigoestudiante,op.codigoperiodo,c.codigocarrera,c.nombrecarrera, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento, eg.telefonoresidenciaestudiantegeneral, eg.celularestudiantegeneral, eg.emailestudiantegeneral, e.semestre FROM estudiante e
        INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante
        INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula
        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
        INNER JOIN carrera c on c.codigocarrera=e.codigocarrera
        WHERE op.codigoestadoordenpago LIKE '4%'
        AND op.codigoperiodo='$codigoperiodo'
        AND pr.codigoperiodo='$codigoperiodo'
        AND e.idestudiantegeneral='".$valor2['idestudiantegeneral']."'
        ";
    }
    else
    {
        $query="
        SELECT DISTINCT e.idestudiantegeneral,e.codigoestudiante,op.codigoperiodo,c.codigocarrera,c.nombrecarrera, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,eg.numerodocumento, eg.telefonoresidenciaestudiantegeneral, eg.celularestudiantegeneral, eg.emailestudiantegeneral, e.semestre, if(c.codigomodalidadacademica <> '400','',(select mat.nombremateria from materia mat where mat.codigomateria = dp.codigomateria)) as Nivel
        FROM detalleprematricula dp, materia m, estudiante e
        INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante
        INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula
        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
        INNER JOIN carrera c on c.codigocarrera=e.codigocarrera
        WHERE op.codigoestadoordenpago LIKE '4%'
        AND op.codigoperiodo='$codigoperiodo'
        AND pr.codigoperiodo='$codigoperiodo'
        AND e.idestudiantegeneral='".$valor2['idestudiantegeneral']."'
        and pr.idprematricula = dp.idprematricula
        and dp.codigoestadodetalleprematricula like '3%'
        and dp.codigomateria = m.codigomateria
        ";
    }
    $operacion=$sala->query($query);
    $rowOperacion=$operacion->fetchRow();
	do{
		if($rowOperacion['idestudiantegeneral']<>''){
			$arrayInterno3[]=$rowOperacion;
		}
	}
	while($rowOperacion=$operacion->fetchRow());

}
unset($arrayInterno2);
/*echo "<pre>";
print_r($arrayInterno3);
echo "</pre>";*/
$motor = new matriz($arrayInterno3,"Informe matriculados en más de una carrera","informe.php",'si','no','menu.php','informe.php',false,'si','../../../',false);
$motor->jsVarios();
$motor->mostrarTitulo=true;
$motor->botonRecargar=false;
$motor->mostrar();
?>