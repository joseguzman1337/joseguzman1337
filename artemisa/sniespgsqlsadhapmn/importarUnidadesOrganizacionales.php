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

$data->read("archivos/unidades_organizaconales.xls");

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

foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	echo $llave;
	if($llave<>1){
		$fila['ies_code']=$valor[1];
		$fila['cod_unidad']=$valor[2];//$valor[6];
		$fila['tipo_unidad_code']=$valor[3];
		$fila['cod_dependiente']=$valor[4]	;
		$fila['nombre_unidad']=$valor[5];
		$fila['pais']=$valor[6];
		$fila['departamento']=$valor[7];
		$fila['municipio']=$valor[8];
		$fila['direccion']=$valor[9];
		$fila['tel_cod_pais']=$valor[10];
		$fila['tel_cod_area']=$valor[11];
		$fila['tel_numero']=$valor[12];
		$fila['fax_cod_pais']=$valor[13];
		$fila['fax_cod_area']=$valor[14];
		$fila['fax_numero']=$valor[15];
		$fila['apartado']=null;
		$fila['email']=$valor[16];
		$fila['url']=$valor[17];
		$fila['aut_cargo']=$valor[18];
		$fila['aut_tip_ident']=$valor[19];
		$fila['aut_documento']=$valor[20];
		$fila['tel_ext']=$valor[21];
		echo "<pre>";
		print_r($fila);
		echo "</pre>";
		if($_GET['insertar']=='si'){
			insertar_fila_bd($snies_conexion,'UNID_ORGANIZACIONAL',$fila);
		}
		unset($fila);
	}
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
