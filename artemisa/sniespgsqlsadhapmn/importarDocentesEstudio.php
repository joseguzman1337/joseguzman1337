<?php
error_reporting(0);
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
require_once 'Excel/reader.php';
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once("../serviciosacademicos/funciones/clases/motorv2/motor.php");
echo date("Y-m-d H:i:s"),"\n\n";

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read("archivos/estudio_docente.xls");
echo count($data->sheets[0]['cells'])-1,"<br>";
DibujarTabla($data->sheets[0]['cells']);
echo "<pre>";
//print_r($data->sheets[0]['cellsInfo']);
echo "</pre>";
//se ingresa en participantes los datos basicos, para luego ingresar las autoridades (integridad ref)

foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	$fila['ies_code']=$valor[1];
	$fila['tipo_doc_unico']=$valor[2];
	$fila['codigo_unico']=$valor[3];
	$fila['nombre_inst']=$valor[4];
	$fila['pais_code']=$valor[5];
	$fila['programa']=$valor[6];
	$fila['cod_programa']=$valor[7];
	$fila['nbc_code']=$valor[8];
	$fila['nivel_est_code']=$valor[9];
	$fila['fecha_ecaes']=$valor[10];
	//$fila['puntaje_ecaes']='0';

	$fila['puntaje_ecaes']=$valor[11];
	if($_GET['insertar']=='si'){
		insertar_fila_bd($snies_conexion,'estudio_docente',$fila);
	}
	unset($fila);
}
function escribir_cabeceras($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}

function DibujarTabla($matriz,$texto="")
{
	if(is_array($matriz))
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		escribir_cabeceras($matriz[0],$link);
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	else
	{
		echo $texto." Matriz no valida<br>";
	}
}

function insertar_fila_bd($conexion,$tabla,$fila)
{

	$claves="(";
	$valores="(";
	$i=0;
	while (list ($clave, $val) = each ($fila)) {

		if($i>0){
			$claves .= ",".$clave."";
			$valores .= ",'".$val."'";
		}
		else{
			$claves .= "".$clave."";
			$valores .= "'".$val."'";
		}
		$i++;
	}
	$claves .= ")";
	$valores .= ")";

	$sql="insert into $tabla $claves values $valores";
	echo $sql;
	$conexion->debug=true;
	$operacion=$conexion->query($sql);
	$conexion->debug=false;
}
?>
