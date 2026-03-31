<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
/*
    [CodigoCarrera] => Array
        (
            [0] => 5
            [1] => 123
            [2] => 124
            [3] => 10
            [4] => 11
            [5] => 375
            [6] => 133
        )

    [Periodo_1] => 20131
    [Periodo_2] => 20142
*/

/*header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reporteMateriasPlanesEstudio_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
ini_set('mysql.connect_timeout', 14400);
ini_set('default_socket_timeout', 14400);*/
$rutaF = "../../../../";
include_once('../../../estadisticas/notascorte/_funcionesNotas.php');
$objetobase=new BaseDeDatosGeneral($sala);

//$objetobase->conexion->query("USE sala;");
require_once('../../../../mgi/datos/templates/template.php');
require_once("./funciones.php");


$periodo_1 = $_POST['Periodo_1'];
$periodo_2 = $_POST['Periodo_2']; 

  $SQL='SELECT
        	codigoperiodo 
        FROM
        	periodo
        
        WHERE
        
        codigoperiodo BETWEEN "'.$periodo_1.'" AND "'.$periodo_2.'"';
        
$C_Periodos = $objetobase->conexion->GetAll($SQL); 

$Carreras = '';
if($_POST['CodigoCarrera'][0]!=1){
    for($i=0;$i<count($_POST['CodigoCarrera']);$i++){
        if($i<1){
            $Carreras = $_POST['CodigoCarrera'][$i];
        }else{
            $Carreras = $Carreras.','.$_POST['CodigoCarrera'][$i];
        }
    }
}

$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado($Carreras);
$separarJornadas = false;

//echo "BASE DE DATOS 2<BR/><pre>";print_r($db);
$codigoperiodo = $_REQUEST['codigoperiodo'];
//$queryPlanes = getQueryPlanesEstudioActivos($codigoperiodo);
//$queryPlanes =getQueryPlanesEstudio();
$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado();
//$queryMaterias= getQueryListadoMateriasPlanesEstudiosPregrado("123,124,118,119,133,134");
$separarJornadas = true;

//echo $queryMaterias;die;
$planes = $objetobase->conexion->GetAll($queryMaterias);

//echo '<pre>';print_r($planes);die;

$estados[100] = "Activo";
$estados[101] = "Construccion";
$estados[200] = "Inactivo";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">   
<title>Reporte</title>


<style type="text/css">
table
{
 border-collapse: collapse;
    border-spacing: 0;
}
th, td {
border: 1px solid #000000;
    padding: 0.5em;
}
</style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Programa académico</th>
                <th>No. Plan de Estudio</th>
                <th>Plan de Estudio</th>
                <th>Estado plan</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Créditos</th>
                <th>Materia Padre</th>
                <th>Linea Enfasis</th>

                <?PHP 
                $N = count($C_Periodos)-1;
                for($p=0;$p<count($C_Periodos);$p++){
                    ?>
                    <th>Total Estudiantes <?PHP echo $C_Periodos[$p]['codigoperiodo']?></th>
                    <th>Estudiantes que perdieron <?PHP echo $C_Periodos[$p]['codigoperiodo']?></th>
                    <?PHP
                }
               
                ?>
            </tr>
        </thead>
        <tbody>
		<?php
foreach($planes as $plan){
    
	echo "<tr>";
	/*$materiasQuery = getQueryMateriasElectivas($plan["idplanestudio"]);
	$materias = $db->GetAll($materiasQuery);*/
	echo "<td>".$plan["nombrecarrera"]."</td>";
	echo "<td>".$plan["idplanestudio"]."</td>";
	echo "<td>".$plan["nombreplanestudio"]."</td>";
	echo "<td>".$estados[$plan["codigoestadoplanestudio"]]."</td>";
	if($plan["indicadorLinea"]==="Si"){
        
	    for($p=0;$p<count($C_Periodos);$p++){
		$estudiantes[$C_Periodos[$p]['codigoperiodo']]= encuentra_array_materias($plan["codMateria"],$plan["codigocarrera"],200,$C_Periodos[$p]['codigoperiodo'],$C_Periodos[$p]['codigoperiodo'],$objetobase,0,$separarJornadas);
		
        }

		echo "<td>".$plan["materia"]."</td>";
		echo "<td>".$plan["semestredetalleplanestudio"]."</td>";
		echo "<td>".$plan["creditos"]."</td>";
		echo "<td>".$plan["nombremateria"]."</td>";
		echo "<td>".$plan["linea"]."</td>";
	} else {
	   
	   for($p=0;$p<count($C_Periodos);$p++){	    
	       $estudiantes[$C_Periodos[$p]['codigoperiodo']]=  encuentra_array_materias($plan["codigomateria"],$plan["codigocarrera"],200,$C_Periodos[$p]['codigoperiodo'],$C_Periodos[$p]['codigoperiodo'],$objetobase,0,$separarJornadas);
		}

		echo "<td>".$plan["nombremateria"]."</td>";
		echo "<td>".$plan["semestredetalleplanestudio"]."</td>";
		echo "<td>".$plan["numerocreditos"]."</td>";
		echo "<td></td><td></td>";
	}
    
     
    for($p=0;$p<count($C_Periodos);$p++){
		echo "<td>".$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Total_Estudiantes_".$C_Periodos[$p]['codigoperiodo']]."</td>";
		echo "<td>".$estudiantes[$C_Periodos[$p]['codigoperiodo']][0][0]["Perdieron_Periodo_".$C_Periodos[$p]['codigoperiodo']]."</td>";
	
    }	
	echo "</tr>";
}
?>
    </tbody>
    </table>
</body>
</html>
