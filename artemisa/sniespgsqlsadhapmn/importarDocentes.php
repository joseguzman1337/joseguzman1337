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
/*
$query_carreras="SELECT c.codigocarrera,c.nombrecarrera FROM carrera c";
$operacion=$sala->query($query_carreras);
$row_operacion=$operacion->fetchRow();
do
{
if(!empty($row_operacion))
{
$array_carreras[]=$row_operacion;
}
}
while ($row_operacion=$operacion->fetchRow());
*/
// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('CP1251');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/
/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read("archivos/docentes.xls");

/*
$data->sheets[0]['numRows'] - count rows
$data->sheets[0]['numCols'] - count columns
$data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column
$data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
$data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
$data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format
$data->sheets[0]['cellsInfo'][$i][$j]['colspan']
$data->sheets[0]['cellsInfo'][$i][$j]['rowspan']
*/
/*
error_reporting(E_ALL ^ E_NOTICE);
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
}
echo "\n";
}
*/

//print_r($data->formatRecords);
//DibujarTabla($data->sheets[0]['cells']);
//DibujarTabla($data->sheets[1]['cells']);
//DibujarTabla($array_carreras);
echo count($data->sheets[0]['cells'])-1,"<br>";
DibujarTabla($data->sheets[0]['cells']);
echo "<pre>";
print_r($data->sheets[0]['cellsInfo']);
echo "</pre>";
//se ingresa en participantes los datos basicos, para luego ingresar las autoridades (integridad ref)
/*
foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	$fila['ies_code']=1729;
	$fila['primer_apellido']=$valor[2];
	$fila['segundo_apellido']=$valor[3];
	$fila['primer_nombre']=$valor[4];
	$fila['segundo_nombre']=$valor[5];
	$fila['fecha_nacim']='1900-01-01';
	$fila['pais_ln']='CO';
	$fila['departamento_ln']='11';
	$fila['municipio_ln']='11001';
	$fila['genero_code']='03';
	$fila['email']=$valor[9];
	$fila['est_civil_code']='08';
	$fila['tipo_doc_unico']=$valor[7];
	$fila['codigo_unico']=$valor[1];
	$fila['tipo_id_ant']='NI';
	$fila['codigo_id_ant']='0';
	$fila['pais_tel']=57;
	$fila['area_tel']=1;
	$fila['numero_tel']=$valor[10];
	
	
	if($_GET['insertar']=='si'){
		insertar_fila_bd($snies_conexion,'PARTICIPANTE',$fila);
	}
	unset($fila);
}
*/
foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	$fila2['ies_code']=1729;
	$fila2['codigo_unico']=$valor[1];
	$fila2['nivel_est_code']="0".$valor[2];
	$fila2['tipo_doc_unico']=$valor[5];
	$fila2['fecha_ingreso']=$valor[6];
			
	echo "<pre>";
	print_r($fila2);
	echo "</pre>";
	if($_GET['insertar']=='si'){
		insertar_fila_bd($snies_conexion,'DOCENTE',$fila2);
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
