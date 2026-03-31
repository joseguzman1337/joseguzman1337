<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('memory_limit', '256M');
ini_set('max_execution_time','6400000');
require_once 'Excel/reader.php';
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once("../serviciosacademicos/funciones/clases/motorv2/motor.php");
echo date("Y-m-d H:i:s"),"\n\n";
		
function sanear_string($string) {
	$string = trim($string);
	$string = str_replace( array('á','à','ä','â','ª','Á','À','Â','Ä'),array('a','a','a','a','a','A','A','A','A'),$string);
	$string = str_replace( array('é','è','ë','ê','É','È','Ê','Ë'),array('e','e','e','e','E','E','E','E'),$string);
	$string = str_replace( array('í','ì','ï','î','Í','Ì','Ï','Î'),array('i','i','i','i','I','I','I','I'),$string);
	$string = str_replace( array('ó','ò','ö','ô','Ó','Ò','Ö','Ô'),array('o','o','o','o','O','O','O','O'),$string);
	$string = str_replace( array('ú','ù','ü','û','Ú','Ù','Û','Ü'),array('u','u','u','u','U','U','U','U'),$string);
	$string = str_replace( array('ñ','Ñ','ç','Ç'),array('n','N','c','C',),$string);
	$string = str_replace( array("\\","¨","º","-","~","#","@","|","!","\"","·","$","%","&","/","(",")","?","'","¡","¿","[","^","`","]","+","}","{","¨","´",">","<",";",",",":","."),'',$string);
	return $string;
}

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read("archivos/PARTICIPANTES2007II.xls");
echo count($data->sheets[0]['cells'])-1,"<br>";
DibujarTabla($data->sheets[0]['cells']);
echo "<pre>";
//print_r($data->sheets[0]['cellsInfo']);
echo "</pre>";
//se ingresa en participantes los datos basicos, para luego ingresar las autoridades (integridad ref)

foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	$fila['ies_code']=$valor[1];
	$fila['primer_apellido']=sanear_string($valor[2]);
	$fila['segundo_apellido']=sanear_string($valor[3]);
	$fila['primer_nombre']=sanear_string($valor[4]);
	$fila['segundo_nombre']=sanear_string($valor[5]);
	$fila['fecha_nacim']=$valor[6];
	$fila['pais_ln']='CO';
	$fila['departamento_ln']=$valor[8]-0;
	$fila['municipio_ln']=$fila['departamento_ln'].'001';
	$fila['genero_code']=$valor[9];
	$fila['email']=$valor[10];
	$fila['est_civil_code']=$valor[11];
	$fila['tipo_doc_unico']=$valor[12];
	$fila['codigo_unico']=$valor[13];
	//$fila['tipo_id_ant']='NI';
	$fila['codigo_id_ant']='0';
	$fila['pais_tel']=57;
	$fila['area_tel']=1;
	$fila['numero_tel']=$valor[14];
	
	if($_GET['insertar']=='si'){
		insertar_fila_bd($snies_conexion,'PARTICIPANTE',$fila);
	}
	unset($fila);
}


$data2 = new Spreadsheet_Excel_Reader();
$data2->setOutputEncoding('UTF-8');
$data2->read("archivos/DOCENTES2007II.xls");

foreach ($data2->sheets[0]['cells'] as $llave => $valor)
{

$query="select tipo_doc_unico from participante where codigo_unico='".$valor[2]."'";
$operacionsnies=$snies_conexion->query($query);
if(!empty($operacionsnies))
$rowsnies=$operacionsnies->fetchRow();
else
$rowsnies["tipo_doc_unico"]=$valor[4];

	$fila['ies_code']=$valor[1];
	$fila['codigo_unico']=$valor[2];
	if(trim($valor[3])=='00')
	$valor[3]='01';
	$fila['nivel_est_code']=$valor[3];
	$fila['tipo_doc_unico']=$rowsnies["tipo_doc_unico"];
	//$valor[4];
	$fila['fecha_ingreso']=$valor[5];
	
	if($_GET['insertar']=='si'){
		insertar_fila_bd($snies_conexion,'DOCENTE',$fila);
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
