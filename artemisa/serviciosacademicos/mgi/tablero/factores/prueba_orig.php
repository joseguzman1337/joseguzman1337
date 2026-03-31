<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include_once('../../../ReportesAuditoria/templates/mainjson.php');
$qry = "select nombredocente,apellidodocente from docente where iddocente=".$_REQUEST['iddocente'];
$rs=$db->Execute($qry);
$row=$rs->fetchrow();

echo "<b>Docente:</b> ".$row['nombredocente']." ".$row['apellidodocente']."<br><br><br>";
 
$qry = "select	case 
			when id_vocacion=1 then 'Enseñanaza-Aprendizaje'
			when id_vocacion=2 then 'Descubrimiento'
			when id_vocacion=3 then 'Compromizo'
			when id_vocacion=4 then 'Gestión Académica'
		 end as vocacion
		,autoevaluacion
		,porcentaje
		,consolidacion
		,mejora
		,proyecto_nom
		,descripcion
		,nombrefacultad
		,nombrecarrera
		,nombremateria
		,nombregrupo
	from plandocente pd 
	join accionesplandocente_temp apdt on pd.plantrabajo_id=apdt.id_accionesplandocentetemp 
	left join grupo g on apdt.grupo_id=g.idgrupo
	left join materia m on apdt.materia_id=m.codigomateria
	left join carrera c on apdt.carrera_id=c.codigocarrera
	left join facultad f on apdt.facultad_id=f.codigofacultad
	where pd.id_docente=".$_REQUEST['iddocente']." and pd.codigoperiodo='".$_REQUEST['codigoperiodo']."'
	order by id_vocacion
		,grupo_id";
$rs=$db->Execute($qry);
if($rs->RecordCount()>0) {
	while($row=$rs->fetchrow()) {
		echo "<b>vocacion:</b> ".$row["vocacion"]."<br>";
		echo "<b>autoevaluacion:</b> ".$row["autoevaluacion"]."<br>";
		echo "<b>porcentaje:</b> ".$row["porcentaje"]."<br>";
		echo "<b>consolidacion:</b> ".$row["consolidacion"]."<br>";
		echo "<b>mejora:</b> ".$row["mejora"]."<br>";
		echo "<b>proyecto nombre:</b> ".$row["proyecto_nom"];
		echo "<hr>";
		echo "<b>descripcion:</b> ".$row["descripcion"]."<br>";
		echo "<b>facultad:</b> ".$row["nombrefacultad"]."<br>";
		echo "<b>carrera:</b> ".$row["nombrecarrera"]."<br>";
		echo "<b>materia:</b> ".$row["nombremateria"]."<br>";
		echo "<b>grupo:</b> ".$row["nombregrupo"];
		echo "<br><br><hr><hr><br>";


	/*
	select	 nombresestudiantegeneral		as nombres
		,apellidosestudiantegeneral		as apellidos
		,idestudiantegeneral			as interlocutor
		,tipodocumento			
		,numerodocumento
		,emailestudiantegeneral			as email
		,telefonoresidenciaestudiantegeneral	as telefono
		,celularestudiantegeneral		as celular
		,direccionresidenciaestudiantegeneral	as direccion
		,nombrecarrera				as carrera
		,nombrefacultad				as facultad
	from estudiantegeneral 
	join (	select	 distinct
			 idestudiantegeneral
			,codigoestudiante
			,codigocarrera 
		from estudiante e 
		join ordenpago op using(codigoestudiante) 
		join detalleordenpago dop using(numeroordenpago) 
		where e.codigoperiodo in ('20121','20122','20131','20132','20141','20142') 
			and op.codigoestadoordenpago=40 
			and dop.codigoconcepto=151
	) sub using(idestudiantegeneral)
	join carrera using(codigocarrera)
	join facultad using(codigofacultad)
	order by nombrefacultad
		,nombrecarrera;
	*/

	}
} else {
	echo "No existe información registrada para el periodo <b>".$_REQUEST['codigoperiodo']."</b>";
}

//echo "<b> :</b> ".$row[""]."<br><br>";
?>
