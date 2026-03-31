<?php 
function obtenerFotoDocumentoEstudiante($db,$numerodocumento,$link="../../../imagenes/estudiantes/",$tipo=1){
	if($numerodocumento=="votoblanco"){
		$linkimagen = $link."votoblanco.jpg";
	} else {
		$linkimagen = $link."no_foto.jpg";
	}
	$query_seldocumentos = "select ed2.numerodocumento, ed2.fechainicioestudiantedocumento, ed2.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
	from estudiantedocumento ed, estudiantedocumento ed2, ubicacionimagen u
	where ed.idestudiantegeneral = ed2.idestudiantegeneral
	and ed.numerodocumento = '$numerodocumento'
	and u.idubicacionimagen like '1%'
	and u.codigoestado like '1%'
	order by 2 desc";

	if($tipo==2){
		$res=$db->query($query_seldocumentos);
	} else {
		$res=$db->Execute($query_seldocumentos);
	}
	while ($documento=$res->fetchRow()){
		//$link = $row_seldocumentos['linkidubicacionimagen'];
		$imagenjpg = $documento['numerodocumento'].".jpg";
		$imagenJPG = $documento['numerodocumento'].".JPG";
		if(is_file($link.$imagenjpg))
		{
			$linkimagen = $link.$imagenjpg;
			break;
		}
		else if(is_file($link.$imagenJPG))
		{
			$linkimagen = $link.$imagenJPG;
			break;
		}
	}
	
	return $linkimagen;
}

function obtenerFotoCodigoEstudiante($sala,$codigoestudiante,$link="../../../imagenes/estudiantes/"){
	$linkimagen = "../../../sala/assets/images/icons/no_foto2.png";
	$query_seldocumentos = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
	from estudiantedocumento ed, estudiante e, ubicacionimagen u
	where ed.idestudiantegeneral = e.idestudiantegeneral
	and e.codigoestudiante = '$codigoestudiante'
	and u.idubicacionimagen like '1%'
	and u.codigoestado like '1%'
	order by 2 desc";
	//echo $query_seldocumentos."<br>";
	$seldocumentos = mysql_query($query_seldocumentos, $sala) or die("$query_seldocumentos ".mysql_error());
	$totalRows_seldocumentos = mysql_num_rows($seldocumentos);
	while($row_seldocumentos = mysql_fetch_assoc($seldocumentos))
	{
		//$link = $row_seldocumentos['linkidubicacionimagen'];
		$imagenjpg = $row_seldocumentos['numerodocumento'].".jpg";
		$imagenJPG = $row_seldocumentos['numerodocumento'].".JPG";
		if(is_file($link.$imagenjpg))
		{
			$linkimagen = $link.$imagenjpg;
			break;
		}
		else if(is_file($link.$imagenJPG))
		{
			$linkimagen = $link.$imagenJPG;
			break;
		}
	}
	return $linkimagen;
}