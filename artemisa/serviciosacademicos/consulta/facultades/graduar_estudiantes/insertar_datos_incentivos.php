<?php
if($totalrows_verifica_registroincentivo==0){
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
elseif($totalrows_verifica_registroincentivo>0)
{
	$fecharegistroincentivoacademico=date("Y-m-d H:i:s");
	$idregistroincentivoacademico=$row_verifica_registroincentivo['idregistroincentivoacademico'];
	$query_actualizar_registroincentivoacademico="
	update registroincentivoacademico set
	idincentivoacademico='".$_POST['idincentivoacademico']."',
	nombreregistroincentivoacademico='".$_POST['nombreregistroincentivoacademico']."', 
	numeroacuerdoregistroincentivoacademico='".$_POST['numeroacuerdoregistroincentivoacademico']."', 
	fechaacuerdoregistroincentivoacademico='".$_POST['fechaacuerdoregistroincentivoacademico']."',
	numeroactaregistroincentivoacademico='".$_POST['numeroactaregistroincentivoacademico']."',
	fechaactaregistroincentivoacademico='".$_POST['fechaactaregistroincentivoacademico']."',
	observacionregistroincentivoacademico='".$_POST['observacionregistroincentivoacademico']."'
	where idincentivoacademico='$idincentivoacademico' and idregistrograduado = '$idregistrograduado' and idregistroincentivoacademico='$idregistroincentivoacademico_2'
	";
	//echo $query_actualizar_registroincentivoacademico;
	$actualizar_registroincentivoacademico=mysql_query($query_actualizar_registroincentivoacademico, $sala) or die(mysql_error()."$query_actualizar_registroincentivoacademico");
	$query_insertar_log_registroincentivoacademico="
		insert into logregistroincentivoacademico values 
		('','".$row_verifica_registroincentivo['idregistroincentivoacademico']."','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
		'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
		'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
		'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
		'100','".$_GET['idusuario']."')";
	//echo $query_insertar_log_registroincentivoacademico;
	$insertar_log_registroincentivoacademico=mysql_query($query_insertar_log_registroincentivoacademico,$sala) or die(mysql_error()."$query_insertar_log_registroincentivoacademico");
	if($actualizar_registroincentivoacademico and $insertar_log_registroincentivoacademico){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
}



?>