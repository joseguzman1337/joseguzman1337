<?php
session_start();
$_SESSION['MM_Username']='dirsecgeneral';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<form name="form1" action="" method="POST"> 
<?php
$fechafirmadocumentos=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
$ip=$formulario->GetIP();
$depurar=new SADebug();
if($_REQUEST['depurar']=="si")
{
	$sala->debug=true;
	$depurar->trace($formulario,'','');
	$formulario->depurar();
}
//if(isset($_GET['codigoestudiante']) and isset($_GET['idregistrograduado']))
//para compatibilidad de firmas de icentivos, se comentó esta linea
{
	$array_datos_estudiante=$formulario->datos_estudiante_noprematricula($_GET['codigoestudiante']);
	$codigocarrera=$array_datos_estudiante['codigocarrera'];
	$formulario->carga=true;//engaño al obj formulario, para que asuma que se cargaron datos, cargue los chulitos
	$formulario->llave_carga='idregistrograduado';
	$formulario->valor_llave_carga=$_GET['idregistrograduado'];

}
$query_seliddirectivo = "SELECT rf.iddirectivo, concat(apellidosdirectivo,' ',nombresdirectivo) AS nombre FROM directivo d, referenciafirmagrado rf
WHERE d.codigotipodirectivo='100' AND rf.iddirectivo=d.iddirectivo 
AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado
AND (d.codigocarrera = '1' or d.codigocarrera='$codigocarrera') order by nombre
";
$titulo="Firmas ".$_GET['documento'];
if($_GET['documento']=='acta')
{
	$formulario->cuadro_chulitos_bd_query($query_seliddirectivo,$titulo,'directivo',"d.codigotipodirectivo='100' AND rf.iddirectivo=d.iddirectivo AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado AND (d.codigocarrera = '1' or d.codigocarrera='$codigocarrera')","AND codigotipodocumentograduado=2",'nombre','iddirectivo','nombre','documentograduado','iddocumentograduado','codigoestado',100,200);
}
elseif($_GET['documento']=='diploma')
{
	$formulario->cuadro_chulitos_bd_query($query_seliddirectivo,$titulo,'directivo',"d.codigotipodirectivo='100' AND rf.iddirectivo=d.iddirectivo AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado AND (d.codigocarrera = '1' or d.codigocarrera='$codigocarrera')","AND codigotipodocumentograduado=1",'nombre','iddirectivo','nombre','documentograduado','iddocumentograduado','codigoestado',100,200);
}
elseif($_GET['documento']=='incentivo')
{
	$idregistroincentivoacademico=$_GET['idregistroincentivoacademico'];
	$formulario->cuadro_chulitos_bd_query($query_seliddirectivo,$titulo,'directivo',"d.codigotipodirectivo='100' AND rf.iddirectivo=d.iddirectivo AND '$fechafirmadocumentos' >= rf.fechainicioreferenciafirmagrado  AND '$fechafirmadocumentos' <= rf.fechafinalreferenciafirmagrado AND (d.codigocarrera = '1' or d.codigocarrera='$codigocarrera')","AND codigotipodocumentograduado=3 AND idregistroincentivoacademico='$idregistroincentivoacademico'",'nombre','iddirectivo','nombre','documentograduado','iddocumentograduado','codigoestado',100,200);
}

?>
<input type="submit" name="Enviar" value="Enviar">
</form>
<?php

if(isset($_POST['Enviar']))
{
	$formulario->submitir();
	$datos_sql_documentograduado[]=array('campo'=>'idregistrograduado','valor'=>$_GET['idregistrograduado']);

	$datos_sql_documentograduado[]=array('campo'=>'codigoestado','valor'=>100);
	if($_GET['documento']=='diploma')
	{
		$datos_sql_documentograduado[]=array('campo'=>'idregistroincentivoacademico','valor'=>1);
		$datos_sql_documentograduado[]=array('campo'=>'codigotipodocumentograduado','valor'=>1);
		$datos_sql_documentograduado[]=array('campo'=>'idincentivoacademico','valor'=>1);
	}
	elseif($_GET['documento']=='acta')
	{
		$datos_sql_documentograduado[]=array('campo'=>'idregistroincentivoacademico','valor'=>1);
		$datos_sql_documentograduado[]=array('campo'=>'codigotipodocumentograduado','valor'=>2);
		$datos_sql_documentograduado[]=array('campo'=>'idincentivoacademico','valor'=>1);
	}
	elseif($_GET['documento']=='incentivo')
	{
		if($_GET['idregistroincentivoacademico']=="")
		{
			echo '<script language="javascript">alert("No ha insertado el incentivo")</script>';
		}
		$datos_sql_documentograduado[]=array('campo'=>'idregistroincentivoacademico','valor'=>$_GET['idregistroincentivoacademico']);
		$datos_sql_documentograduado[]=array('campo'=>'codigotipodocumentograduado','valor'=>3);
		$datos_sql_documentograduado[]=array('campo'=>'idincentivoacademico','valor'=>$_GET['idincentivoacademico']);

	}

	//$formulario->sql_cuadro_chulitos_bd_query($datos_sql_documentograduado,'documentograduado','iddirectivo','codigoestado',100,200,1,"","");
	$formulario->sql_cuadro_chulitos_bd_query($datos_sql_documentograduado,'documentograduado','iddirectivo','codigoestado',100,200,1,"<script language='javascript'>window.close();</script>'<script language='javascript'>window.opener.recargar();</script>'","<script language='javascript'>window.close();</script>'<script language='javascript'>window.opener.recargar();</script>'");
	if($_REQUEST['depurar']=="si")
	{
		$sala->debug=true;
		$depurar->trace($formulario,'','');
		$formulario->depurar();
	}
}

?>