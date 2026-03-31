<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
if($_POST['modalidad'] == 100 and $_POST["documento"] <> "")
{
	$documentoestudiante = $_POST["documento"];
	$query_estudiantecodigo = "select e.codigoestudiante
	from estudiantedocumento ed, estudiante e
	where ed.idestudiantegeneral = e.idestudiantegeneral
	and ed.numerodocumento = '$documentoestudiante'
	and e.codigocarrera = '$carrera'";
	echo "$query_estudiantedocumento <br>";
	//exit();
	$estudiantecodigo = mysql_query($query_estudiantecodigo, $sala) or die("$query_estudiantedocumento".mysql_error());
	$row_estudiantecodigo = mysql_fetch_assoc($estudiantecodigo);
	$codigoestudiante = $row_estudiantecodigo['codigoestudiante'];			  
	$documento = 1;
} 
else 
{
	$codigoestudiante = 1;
	$documento = 1;
}
if($_POST['modalidad'] == 200 and $_POST["documento"] <> "")
{	      
	$documento = $_POST["documento"];	
}
else
{	      
	$documento = 1;	
}
if($_POST['indicadorradio'] == 1)
{  /////if 1
	$sql = "insert into mensaje(asuntomensaje,descripcionmensaje,fechamensaje,fechainiciomensaje,fechafinalmensaje,codigocarrera,codigoestudiante,numerodocumento,usuario,codigodirigidomensaje,codigoestadomensaje)";
	$sql.= "VALUES('".$_POST["asuntomensaje"]."','".$_POST["mensaje"]."','".date("Y-m-d H:m:s")."','".$_POST["fecha1"]."','".$_POST["fecha2"]."','".$carrera."','".$codigoestudiante."','".$documento ."','".$usuario."','".$_POST['modalidad']."','100')"; 
	//echo $sql;
	$result = mysql_query($sql,$sala) or die("$sql".mysql_error());
} /////if 1
else
{ /////if 1     
	for($i=1;$i<$_POST['totalmensajes'];$i++)
	{	  
	      
		if ($_POST["idmensajes".$i] == true)
	    {		  
			$base="update mensaje
			set fechainiciomensaje = '".$_POST["fecha1"]."',
			fechafinalmensaje = '".$_POST["fecha2"]."',
			codigoestadomensaje = '100',
			descripcionmensaje = '".$_POST["mensaje".$i]."'
			where idmensaje = '".$_POST["idmensajes".$i]."'";			   
			$sol=mysql_db_query($database_sala,$base);	
		}
	}
} /////if 1
?>