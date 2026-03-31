<?php
function ingresar_modificaciones($idregistrograduadop,$codigoestudiantep,$fecharegistrograduadop,$direccionipregistrograduadop,$usuariop,$codigotipomodificaregistrograduadop,$conexion) //parametro es el codigotipomodificaregistrograduado
{
	$query_ingresardatos_log_modificaciones=
	"
	insert into logregistrograduado
	values
	(
	'',
	'$idregistrograduadop',
	'$codigoestudiantep',
	'".$_POST['numeropromocion']."',
	'$fecharegistrograduadop',
	'".$_POST['numeroacuerdoregistrograduado']."',
	'".$_POST['fechaacuerdoregistrograduado']."',
	'".$_POST['responsableacuerdoregistrograduado']."',
	'".$_POST['numeroactaregistrograduado']."',
	'".$_POST['fechaactaregistrograduado']."',
	'".$_POST['numerodiplomaregistrograduado']."',
	'".$_POST['fechadiplomaregistrograduado']."',
	'".$_POST['fechagradoregistrograduado']."',
	'".$_POST['lugarregistrograduado']."',
	'".$_POST['presidioregistrograduado']."',
	'".$_POST['observacionregistrograduado']."',
	'100',
	'".$_POST['codigotiporegistrograduado']."',
	'$direccionipregistrograduadop',
	'$usuariop',
	'1',
	'200',
	'0000-00-00',
	'$codigotipomodificaregistrograduadop',
	'".$_POST['idtipogrado']."'
	)
	";
	$ingresar_datos_log_modificaciones=mysql_query($query_ingresardatos_log_modificaciones,$conexion);
	if($ingresar_datos_log_modificaciones){
	}else{echo "<br>",$query_ingresardatos_log_modificaciones,"<br>",mysql_error();}
}


if($totalrows_registrograduado==0){

	$query_ingresardatos=
	"
insert into registrograduado
(
codigoestudiante,
numeropromocion,
fecharegistrograduado,
numeroacuerdoregistrograduado,
fechaacuerdoregistrograduado, 
responsableacuerdoregistrograduado,
numeroactaregistrograduado,
fechaactaregistrograduado,
numerodiplomaregistrograduado,
fechadiplomaregistrograduado,
fechagradoregistrograduado,
lugarregistrograduado,
presidioregistrograduado,
observacionregistrograduado,
codigoestado,
codigotiporegistrograduado,
direccionipregistrograduado,
usuario,
iddirectivo,
codigoautorizacionregistrograduado,
fechaautorizacionregistrograduado,
codigotipomodificaregistrograduado,
idtipogrado)
values
(
'$codigoestudiante',
'".$_POST['numeropromocion']."',
'$fecharegistrograduado',
'".$_POST['numeroacuerdoregistrograduado']."',
'".$_POST['fechaacuerdoregistrograduado']."',
'".$_POST['responsableacuerdoregistrograduado']."',
'".$_POST['numeroactaregistrograduado']."',
'".$_POST['fechaactaregistrograduado']."',
'".$_POST['numerodiplomaregistrograduado']."',
'".$_POST['fechadiplomaregistrograduado']."',
'".$_POST['fechagradoregistrograduado']."',
'".$_POST['lugarregistrograduado']."',
'".$_POST['presidioregistrograduado']."',
'".$_POST['observacionregistrograduado']."',
'100',
'".$_POST['codigotiporegistrograduado']."',
'$direccionipregistrograduado',
'$usuario',
'1',
'200',
'0000-00-00',
'100',
'".$_POST['idtipogrado']."'
)
";
	$ingresar_datos=mysql_query($query_ingresardatos,$sala);
	//echo $query_ingresardatos;
	if(!$ingresar_datos){echo mysql_error();}
	if($ingresar_datos)
	{

		$idregistrograduado=mysql_insert_id();
		$query_ingresardatos_log=
		"
	insert into logregistrograduado
	values
	(
	'',
	'$idregistrograduado',
	'$codigoestudiante',
	'".$_POST['numeropromocion']."',
	'$fecharegistrograduado',
	'".$_POST['numeroacuerdoregistrograduado']."',
	'".$_POST['fechaacuerdoregistrograduado']."',
	'".$_POST['responsableacuerdoregistrograduado']."',
	'".$_POST['numeroactaregistrograduado']."',
	'".$_POST['fechaactaregistrograduado']."',
	'".$_POST['numerodiplomaregistrograduado']."',
	'".$_POST['fechadiplomaregistrograduado']."',
	'".$_POST['fechagradoregistrograduado']."',
	'".$_POST['lugarregistrograduado']."',
	'".$_POST['presidioregistrograduado']."',
	'".$_POST['observacionregistrograduado']."',
	'100',
	'".$_POST['codigotiporegistrograduado']."',
	'$direccionipregistrograduado',
	'$usuario',
	'1',
	'200',
	'0000-00-00',
	'100',
	'".$_POST['idtipogrado']."'
	)
	";
		$ingresar_datos_log=mysql_query($query_ingresardatos_log,$sala);
		//echo $query_ingresardatos_log;
		if($ingresar_datos_log and $ingresar_datos){
			unset($_POST['Grabar']);
		/* 	echo '<script language="javascript">window.location.reload("graduar_estudiantes_ingreso.php?codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'");</script>'; */
			}
			else{echo mysql_error();}
		}
	}

	elseif($totalrows_registrograduado==1)
	{

		$query_actualizar_datos=
		"
update registrograduado
set 
numeropromocion='".$_POST['numeropromocion']."',
fecharegistrograduado='$fecharegistrograduado',
numeroacuerdoregistrograduado='".$_POST['numeroacuerdoregistrograduado']."',
fechaacuerdoregistrograduado='".$_POST['fechaacuerdoregistrograduado']."', 
responsableacuerdoregistrograduado='".$_POST['responsableacuerdoregistrograduado']."',
numeroactaregistrograduado='".$_POST['numeroactaregistrograduado']."',
fechaactaregistrograduado='".$_POST['fechaactaregistrograduado']."',
numerodiplomaregistrograduado='".$_POST['numerodiplomaregistrograduado']."',
fechadiplomaregistrograduado='".$_POST['fechadiplomaregistrograduado']."',
fechagradoregistrograduado='".$_POST['fechagradoregistrograduado']."',
lugarregistrograduado='".$_POST['lugarregistrograduado']."',
presidioregistrograduado='".$_POST['presidioregistrograduado']."',
observacionregistrograduado='".$_POST['observacionregistrograduado']."',
codigoestado='100',
codigotiporegistrograduado='".$_POST['codigotiporegistrograduado']."',
direccionipregistrograduado='$direccionipregistrograduado',
usuario='$usuario',
idtipogrado='".$_POST['idtipogrado']."'
where idregistrograduado='$idregistrograduado'
";
		$acualizar_datos=mysql_query($query_actualizar_datos,$sala);
		if(!$acualizar_datos){
			echo "<br>",$query_actualizar_datos,"<br>",mysql_error();;
		}
		else
		{
			if($row_registrograduado['numerodiplomaregistrograduado']!=$_POST['numerodiplomaregistrograduado']){
				$codigotipomodificaregistrograduado='200';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de numerodiplomaregistrograduado",$codigotipomodificaregistrograduado;
			}
			if($row_registrograduado['fechadiplomaregistrograduado']!=$_POST['fechadiplomaregistrograduado']){
				$codigotipomodificaregistrograduado='201';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de fechadiplomaregistrograduado",$codigotipomodificaregistrograduado;
			}
			if($row_registrograduado['numeroacuerdoregistrograduado']!=$_POST['numeroacuerdoregistrograduado']){
				$codigotipomodificaregistrograduado='204';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de numeroacuerdoregistrograduado",$codigotipomodificaregistrograduado;
			}
			if($row_registrograduado['fechaacuerdoregistrograduado']!=$_POST['fechaacuerdoregistrograduado']){
				$codigotipomodificaregistrograduado='205';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de fechaacuerdoregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['responsableacuerdoregistrograduado']!=$_POST['responsableacuerdoregistrograduado']){
				$codigotipomodificaregistrograduado='206';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de fechadiplomaregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['numeroactaregistrograduado']!=$_POST['numeroactaregistrograduado']){
				$codigotipomodificaregistrograduado='207';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de numeroactaregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['fechaactaregistrograduado']!=$_POST['fechaactaregistrograduado']){
				$codigotipomodificaregistrograduado='208';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de fechaactaregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['fechagradoregistrograduado']!=$_POST['fechagradoregistrograduado']){
				$codigotipomodificaregistrograduado='209';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de fechagradoregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['lugarregistrograduado']!=$_POST['lugarregistrograduado']){
				$codigotipomodificaregistrograduado='210';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de lugarregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['presidioregistrograduado']!=$_POST['presidioregistrograduado']){
				$codigotipomodificaregistrograduado='211';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de presidioregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['observacionregistrograduado']!=$_POST['observacionregistrograduado']){
				$codigotipomodificaregistrograduado='212';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de observacionregistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['codigotiporegistrograduado']!=$_POST['codigotiporegistrograduado']){
				$codigotipomodificaregistrograduado='213';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de codigotiporegistrograduado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['idtipogrado']!=$_POST['idtipogrado']){
				$codigotipomodificaregistrograduado='214';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de idtipogrado",$codigotipomodificaregistrograduado;
			}

			if($row_registrograduado['numeropromocion']!=$_POST['numeropromocion']){
				$codigotipomodificaregistrograduado='217';
				ingresar_modificaciones($idregistrograduado,$codigoestudiante,$fecharegistrograduado,$direccionipregistrograduado,$usuario,$codigotipomodificaregistrograduado,$sala);
				//echo "cambio de idtipogrado",$codigotipomodificaregistrograduado;
			}
			unset($_POST['Grabar']);
			//echo '<script language="javascript">window.location.reload("graduar_estudiantes_ingreso.php?codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'");</script>';
		}
	}
?>