<?php
if(isset($accion) and $accion=="nuevo")
{
	$fecharegistroincentivoacademico=date("Y-m-d H:i:s");
	$query_insertar_registroincentivoacademico="
	insert into registroincentivoacademico values 
	('','".$_GET['idregistrograduado']."','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
	'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
	'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
	'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
	'100','".$_GET['idusuario']."')";
	//echo $query_insertar_registroincentivoacademico;
	$insertar_registroincentivoacademico=mysql_query($query_insertar_registroincentivoacademico,$sala) or die($query_insertar_registroincentivoacademico);
	if($insertar_registroincentivoacademico){
		$idregistroincentivoacademico=mysql_insert_id();
		$query_insertar_log_registroincentivoacademico="
		insert into logregistroincentivoacademico values 
		('','$idregistroincentivoacademico','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
		'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
		'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
		'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
		'100','".$_GET['idusuario']."')";
		//echo $query_insertar_log_registroincentivoacademico;
		$insertar_log_registroincentivoacademico=mysql_query($query_insertar_log_registroincentivoacademico,$sala) or die(mysql_error());
		if($insertar_log_registroincentivoacademico){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
	}
}

?>
