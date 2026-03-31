<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
        	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	        <title>Plna de trabajo docentes</title>
	</head>
	<body>
<?php
		include_once('../../../ReportesAuditoria/templates/mainjson.php');
		$qry = "select nombredocente,apellidodocente from docente where iddocente=".$_REQUEST['iddocente'];
		$rs=$db->Execute($qry);
		$row=$rs->fetchrow();
?>
		<h1>Docente: <?=$row['nombredocente']." ".$row['apellidodocente']?></h1>
<?php
		$arrVocacion=array("1"=>"Enseñanaza-Aprendizaje","2"=>"Descubrimiento","3"=>"Compromiso","4"=>"Gestión Académica");
		while(list($key,$value)=each($arrVocacion)) {
?>
			<h2><?=$value?></h2>
			<div style='width:900px;height:300px;background-color:#F2F2F2;overflow:auto;padding:10px 10px 10px 10px;'>
<?php
				$qry = "select	 autoevaluacion
						,porcentaje
						,consolidacion
						,mejora
						,proyecto_nom
						,descripcion
						,nombrefacultad
						,nombrecarrera
						,nombremateria
						,nombregrupo
						,horas
					from plandocente pd 
					join accionesplandocente_temp apdt on pd.plantrabajo_id=apdt.id_accionesplandocentetemp 
					left join grupo g on apdt.grupo_id=g.idgrupo
					left join materia m on apdt.materia_id=m.codigomateria
					left join carrera c on apdt.carrera_id=c.codigocarrera
					left join facultad f on apdt.facultad_id=f.codigofacultad
					where pd.id_docente=".$_REQUEST['iddocente']." and pd.codigoperiodo='".$_REQUEST['codigoperiodo']."' and id_vocacion=".$key."
					order by grupo_id";
				$rs=$db->Execute($qry);
				if($rs->RecordCount()>0) {
					while($row=$rs->fetchrow()) {
						if($key==1) {
?>
							<b>Facultad:</b> <?=$row["nombrefacultad"]?><br>
							<b>Carrera:</b> <?=$row["nombrecarrera"]?><br>
							<b>Materia:</b> <?=$row["nombremateria"]?><br>
							<b>Grupo:</b> <?=$row["nombregrupo"]?><br><br>
<?php
						} else {
?>
							<b>Proyecto nombre:</b> <?=$row["proyecto_nom"]?><br><br>
							<b>Horas:</b> <?=$row["horas"]?><br><br>
<?php						}
						
?>
						<b>Descripci&oacute;n:</b> <?=$row["descripcion"]?><br><br>
						<b>Autoevaluaci&oacute;n:</b> <?=$row["autoevaluacion"]?><br><br>
						<b>Porcentaje:</b> <?=$row["porcentaje"]?><br><br>
						<b>Consolidaci&oacute;n:</b> <?=$row["consolidacion"]?><br><br>
						<b>Mejora:</b> <?=$row["mejora"]?><br><br>
						<br><hr><br>
<?php
					}
				} else {
?>
					No existe informaci&oacute;n registrada para el periodo <b><?=$_REQUEST['codigoperiodo']?></b>
<?php
				}
?>
			</div>
<?php
		}
?>
	</body>
</html>
