<?php
//error_reporting(2047);
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
require_once 'Excel/reader.php';
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/motorv2/motor.php");
$nombrearchivo=$_GET['nombrearchivo'];
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

$data->read("archivos/$nombrearchivo");

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
$data->sheets[0]['cells'][1][17]="FECHA_ACTA";
$data->sheets[0]['cells'][1][18]="CODIGOCARRERA";


foreach ($data->sheets[0]['cells'] as $llave => $valor)
{

	$cadena=null;
	//$documento=ereg_replace("\.","",$valor[12]);

	//eliminar lo que no sea numerico del numero de documento
	if($llave<>1)
	{
		for ($i=0;$i<strlen($valor[12]);$i++)
		{
			if(is_numeric($valor[12][$i]))
			{
				$cadena=$cadena.$valor[12][$i];
			}
		}
		$data->sheets[0]['cells'][$llave][12]=$cadena;


		//convertir fechas a formato MYSQL
		list($dia,$mes,$ano)=explode("/",$valor[13]);
		$data->sheets[0]['cells'][$llave][13]=$ano."-".$mes."-".$dia;

		//extraer número de acta, y fecha acta en formato MYSQL
		list($numero_acta,$dia_acta,$mes_acta,$ano_acta)=explode("-",$valor[14]);

		$data->sheets[0]['cells'][$llave][17]=$ano_acta."-".$mes_acta."-".$dia_acta;
		$data->sheets[0]['cells'][$llave][14]=$numero_acta;

		$programa=strtoupper($valor[5]);

		$data->sheets[0]['cells'][$llave][5]=$programa;

		if(strstr($programa,"ELECTR"))
		{
			$data->sheets[0]['cells'][$llave][18]=118;
		}
		elseif (strstr($programa,"MEDIC"))
		{
			$data->sheets[0]['cells'][$llave][18]=10;
		}
		elseif (strstr($programa,"ENFERME"))
		{
			$data->sheets[0]['cells'][$llave][18]=8;
		}
		elseif (strstr($programa,"ODONTO"))
		{
			$data->sheets[0]['cells'][$llave][18]=11;
		}
		elseif (strstr($programa,"MATEMA"))
		{
			$data->sheets[0]['cells'][$llave][18]=86;
		}
		elseif (strstr($programa,"SOCIAL"))
		{
			$data->sheets[0]['cells'][$llave][18]=88;
		}
		elseif (strstr($programa,"HUMAN"))
		{
			$data->sheets[0]['cells'][$llave][18]=89;
		}
		elseif (strstr($programa,"INFANT"))
		{
			$data->sheets[0]['cells'][$llave][18]=90;
		}
		elseif (strstr($programa,"INFORMAT"))
		{
			$data->sheets[0]['cells'][$llave][18]=91;
		}
		elseif (strstr($programa,"BILING"))
		{
			$data->sheets[0]['cells'][$llave][18]=93;
		}
		elseif (strstr($programa,"BIOMEDIC"))
		{
			$data->sheets[0]['cells'][$llave][18]=121;
		}
		elseif (strstr($programa,"BIOLOGI"))
		{
			$data->sheets[0]['cells'][$llave][18]=122;
		}
		elseif (strstr($programa,"SISTEMAS"))
		{
			$data->sheets[0]['cells'][$llave][18]=123;
		}
		elseif (strstr($programa,"AMBIENT"))
		{
			$data->sheets[0]['cells'][$llave][18]=125;
		}
		elseif (strstr($programa,"INDUST"))
		{
			$data->sheets[0]['cells'][$llave][18]=126;
		}
		elseif(strstr($programa,"MUSICAL"))
		{
			$data->sheets[0]['cells'][$llave][18]=130;
		}
		elseif (strstr($programa,"ESCÉNICAS"))
		{
			$data->sheets[0]['cells'][$llave][18]=131;
		}
		elseif (strstr($programa,"PLÁSTICAS"))
		{
			$data->sheets[0]['cells'][$llave][18]=132;
		}
		elseif (strstr($programa,"PSICOLOG"))
		{
			$data->sheets[0]['cells'][$llave][18]=133;
		}
		elseif (strstr($programa,"EDUCACIÓN ARTÍSTICA"))
		{
			$data->sheets[0]['cells'][$llave][18]=86;
		}
		elseif (strstr($programa,"MATEMÁTICAS E INFORMÁTICA"))
		{
			$data->sheets[0]['cells'][$llave][18]=86;
		}
		elseif (strstr($programa,"ESPAÑOL Y LITERATURA"))
		{
			$data->sheets[0]['cells'][$llave][18]=87;
		}
		elseif (strstr($programa,"PREESCOLAR"))
		{
			$data->sheets[0]['cells'][$llave][18]=81;
		}
		elseif (strstr($programa,"ÉNFASIS EN LENGUAS EXTRANJERAS"))
		{
			$data->sheets[0]['cells'][$llave][18]=82;
		}


	}
}

echo count($data->sheets[0]['cells'])-1,"<br>";
DibujarTabla($data->sheets[0]['cells']);

if(isset($_GET['insertar']))
{
	foreach ($data->sheets[0]['cells'] as $llave => $valor)
	{
		if($llave<>1)
		{
			$inserta="INSERT INTO registrograduadoantiguo
		(`idregistrograduadoantiguo`, `departamentoregistrograduadoantiguo`, 
		`municipioregistrograduadoantiguo`, 
		`areaconocimientoregistrograduadoantiguo`, 
		`codigocarrera`,
		 `programaregistrograduadoantiguo`,
		`modalidadregistrograduadoantiguo`, 
		`metodologiaregistrograduadoantiguo`, 
		`tituloregistrograduadoantiguo`, 
		`numerodiplomaregistrograduadoantiguo`, 
		`nombreregistrograduadoantiguo`, 
		`documentoegresadoregistrograduadoantiguo`, 
		`fechagradoregistrograduadoantiguo`, 
		`numeroactaregistrograduadoantiguo`,
		`fechaactaregistrograduadoantiguo`,
		`numerolibroregistrograduadoantiguo`, 
		`numerofolioregistrograduadoantiguo`
		)
		VALUES
		('', '".$valor[1]."',
		'".$valor[2]."', 
		'".$valor[4]."', 
		'".$valor[18]."', 
		'".$valor[5]."', 
		'".$valor[6]."', 
		'".$valor[7]."', 
		'".$valor[9]."', 
		'".$valor[10]."', 
		'".$valor[11]."', 
		'".$valor[12]."', 
		'".$valor[13]."', 
		'".$valor[14]."',
		'".$valor[17]."',
		'".$valor[15]."', 
		'".$valor[16]."' 
		)";

			if($_GET['insertar']=='si')
			{
				echo $inserta,"<br><br><br>";
				$inserccion=$sala->query($inserta);
			}
		}
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
?>
