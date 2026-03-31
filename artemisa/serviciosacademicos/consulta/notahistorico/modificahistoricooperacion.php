<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require('../../funciones/funcionip.php');
$codigomateria = $_GET['materia'];
$estadonotahistorico = 100;
$idlinea = 0;

if (isset($_SESSION['programaprincipal']))
{
	$usuario = "admintecnologia";	 
}
else
{
	$usuario = $_SESSION['MM_Username'];	 
}	 

$query_selidusuario = "SELECT idusuario
from usuario
where usuario = '$usuario'";	
$selidusuario = mysql_query($query_selidusuario, $salatmp) or die(mysql_error());
$row_selidusuario = mysql_fetch_assoc($selidusuario);
$totalRows_selidusuario = mysql_num_rows($selidusuario);
$idusuario = $row_selidusuario['idusuario'];

$ip = tomarip();

// Indicador carga real
// Si es 100 la nota ha sido guardada en el histórico
// Si es 200 la nota no ha sido guardada en el histórico
$indicadorcargareal = 200;		

if(isset($_GET['notas']))
{			
	$query_historico = "SELECT *
	from tmpnotahistorico n
	where n.codigoestudiante = '".$codigoestudiante."'
	and n.codigoperiodo = '".$periodo."'
	and n.codigomateria = '".$codigomateria."'
	and n.codigoestadonotahistorico like '1%'";	
	echo  $query_historico;
	//exit();
	$historico = mysql_query($query_historico, $salatmp) or die(mysql_error());
	$row_historico = mysql_fetch_assoc($historico);
	$totalRows_historico = mysql_num_rows($historico);
	
	if ($row_historico <> "")
	{
		$notahistorico = $row_historico['notadefinitiva'];
		$grupo = $row_historico['idgrupo'];
		//$electivahistorico = $row_historico['codigomateriaelectiva'];
			
		if ($row_historico['notadefinitiva'] > $_GET['notas'])  
		{
   			echo '<script language="JavaScript">alert("La nota actual es '.$row_historico['notadefinitiva'].'")</script>';
			$estadonotahistorico = 200;  
    	}
		else 
		{
			$base="update tmpnotahistorico 
			set codigoestadonotahistorico ='200' 
			where codigoperiodo = '".$periodo."'
			and codigomateria = '".$codigomateria."'
			and codigoestudiante = '".$codigoestudiante."'";															
			$sol=mysql_db_query($database_sala,$base);			  
		}	  
	}
	else
	{
		$notahistorico = "0.0";
		$grupo = 1;
		//$electivahistorico = 1;
	}
	$tipomateria = $_GET['tipomateria'];
	$planestudio = $_GET['planestudiante'];
				
   	$nota = $_GET['notas'];
	$insertSQL5 = "INSERT INTO auditoria (numerodocumento,usuario,fechaauditoria,codigomateria,grupo,codigoestudiante,notaanterior,notamodificada,corte,tipoauditoria,observacion)";
	$insertSQL5.= "VALUES( 
    '".$_SESSION['codigofacultad']."',
	'".$usuario."',
    '".date("Y-m-j G:i:s",time())."', 
   	'".$codigomateria."', 
   	'".$grupo."', 
	'".$_GET['codigoestudiante']."', 
    '".$notahistorico."',
    '".$nota."', 
    '1', 
    '20',
	'".$_GET['observacion']."')";
		
	mysql_select_db($database_sala, $salatmp);
	//$Result1 = mysql_query($insertSQL5, $sala) or die(mysql_error());
    $observacion = $_GET['observación'];
    if ($_GET['materiaelectiva'] == 0 or $_GET['materiaelectiva'] == "")
	{
		$electivahistorico = 1;		  
	} 
	else
	{
		$electivahistorico = $codigomateria;
		$codigomateria = $_GET['materiaelectiva'];
	   	$query_Recordset ="select idlineaenfasisplanestudio
		from detallelineaenfasisplanestudio
		where codigomateriadetallelineaenfasisplanestudio = '$codigomateria'
		and idplanestudio = '$planestudio'
		and codigoestadodetallelineaenfasisplanestudio LIKE '1%'";
		//echo $query_Recordset,"</br>";
		$Recordset = mysql_query($query_Recordset, $salatmp) or die(mysql_error());
		$row_Recordset = mysql_fetch_assoc($Recordset);
		$totalRows_Recordset = mysql_num_rows($Recordset);
		if ($row_Recordset <> "")
		{
			$idlinea = $row_Recordset['idlineaenfasisplanestudio'];														 													
		}
		else
		{
			$idlinea = 1;
		}		 
	}	
	if ($idlinea == 0)
	{
		$idlinea = 1;
	}
	if ($tipomateria == 0)
	{			
		$tipomateria = 1;
	}	
	$query_historico2 = "SELECT *
    from tmpnotahistorico n
	where n.codigoestudiante = '".$codigoestudiante."'
	and n.codigoperiodo = '".$periodo."'
	and n.codigomateria = '".$codigomateria."'
	and n.codigotiponotahistorico = '".$_GET['tiponota']."' 
	and n.codigoestadonotahistorico like '1%'";
	$historico2 = mysql_query($query_historico2, $salatmp) or die(mysql_error());
    $row_historico2 = mysql_fetch_assoc($historico2);
	$totalRows_historico2 = mysql_num_rows($historico2); 
	if (!$row_historico2)
	{		
		$query_detalleprematricula = "SELECT m.notaminimaaprobatoria,d.idprematricula
		from prematricula p,detalleprematricula d,materia m
		where p.codigoestudiante = '".$codigoestudiante."'
		and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.idprematricula = d.idprematricula
		and d.codigomateria = m.codigomateria
		and d.codigomateria = '".$codigomateria."'";	
		
		$detalleprematricula = mysql_query($query_detalleprematricula, $salatmp) or die(mysql_error());
		$row_detalleprematricula = mysql_fetch_assoc($detalleprematricula);
		$totalRows_detalleprematricula = mysql_num_rows($detalleprematricula);
		if($planestudio == "") $planestudio = '1';
		//$_GET['observacion'] = "Sin insertar al historico".$_GET['observacion'];
		$sql = "insert into tmpnotahistorico(idnotahistorico,codigoperiodo,codigomateria,codigomateriaelectiva,codigoestudiante,notadefinitiva,codigotiponotahistorico,origennotahistorico,fechaprocesonotahistorico,idgrupo,idplanestudio,idlineaenfasisplanestudio,observacionnotahistorico,codigoestadonotahistorico,codigotipomateria,idusuario,ip,indicadorcargareal)";
        $sql.= "VALUES('0','".$_GET['periodo']."','".$codigomateria."','".$electivahistorico."','".$_GET['codigoestudiante']."','".$nota."','".$_GET['tiponota']."','10','".date("Y-m-d",time())."','".$grupo."','".$planestudio."','".$idlinea."','".$_GET['observacion']."','".$estadonotahistorico."','".$tipomateria."','$idusuario','$ip','$indicadorcargareal')"; 
        //echo $sql,"</br>";	
		//exit(); 
		$result = mysql_query($sql,$salatmp);  
	}
}
else//else
{ 
	$query_historico = "SELECT *
	FROM tmpnotahistorico n,materia m,estadonotahistorico e
	WHERE n.idnotahistorico = '".$_GET['idhistorico']."'
	AND e.codigoestadonotahistorico = n.codigoestadonotahistorico
	AND m.codigomateria = n.codigomateria";	
	//echo $query_Recordset1;
	//exit();
	$historico = mysql_query($query_historico, $salatmp) or die(mysql_error());
	$row_historico = mysql_fetch_assoc($historico);
	$totalRows_historico = mysql_num_rows($historico);
	$f= 1;
	//do {
  	$nota = $_GET['nota'];
		
    $insertSQL5 = "INSERT INTO auditoria (numerodocumento,usuario,fechaauditoria,codigomateria,grupo,codigoestudiante,notaanterior,notamodificada,corte,tipoauditoria,observacion)";
	$insertSQL5.= "VALUES( 
    '".$_SESSION['codigofacultad']."',
	'".$usuario."',
    '".date("Y-m-j G:i:s",time())."', 
	'".$row_historico['codigomateria']."', 
	'".$row_historico['idgrupo']."', 
	'".$row_historico['codigoestudiante']."', 
    '".$row_historico['notadefinitiva']."',
    '".$nota."', 
    '1', 
    '20',
	'".$_GET['observacion']."')";
	mysql_select_db($database_sala, $salatmp);
	//$Result1 = mysql_query($insertSQL5, $salatmp) or die(mysql_error());
	//echo $insertSQL5,"2";
	//exit();	
	if($_GET['tiponota'] == "")
	{
		$_GET['tiponota'] = 100;
	}
	$base="update tmpnotahistorico  set  
	notadefinitiva ='".$nota."',
	codigotiponotahistorico = '".$_GET['tiponota']."',
	codigoestadonotahistorico =  '".$_GET['estadonota']."',
	observacionnotahistorico = '".$_GET['observacion']."',
	idusuario = '$idusuario',
	ip = '$ip',
	indicadorcargareal = '$indicadorcargareal'
	where idnotahistorico = '".$_GET['idhistorico']."'";        
	$sol=mysql_db_query($database_sala,$base) or die(mysql_error()." $base");
	//$f++;
//}while($row_historico = mysql_fetch_assoc($historico));
}//else

//exit();
if(isset($_GET['notas']))
{
	echo '<script language="JavaScript">window.location.reload("modificahistoricoformulario.php?codigoestudiante='.$codigoestudiante.'&periodo='.$periodo.'");</script>';					
}  
unset($_GET['notas']);
?>

