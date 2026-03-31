<?php
if($totalrows_verifica_registroincentivo==0){
	foreach($incentivos as $vincentivos => $valor)
	{
		if (ereg("sel",$vincentivos))
		{

			$query_insertar_documentograduado_incentivos="insert into documentograduado values ('','$idregistrograduado','$idregistroincentivoacademico','".$incentivos[$vincentivos]."','100','3','".$_POST['idincentivoacademico']."')";
			$insertar_documentograduado_incentivos=mysql_query($query_insertar_documentograduado_incentivos,$sala) or die("$query_insertar_documentograduado_incentivos".mysql_error());
			$iddocumentograduado_incentivos=mysql_insert_id();
			$query_insertar_log_documentograduado_incentivos="insert into logdocumentograduado values ('','$iddocumentograduado_incentivos','$idregistroincentivoacademico','".$incentivos[$vincentivos]."','100','3','1')";
			$insertar_log_documentograduado_incentivos=mysql_query($query_insertar_log_documentograduado_incentivos) or die("$query_insertar_log_documentograduado_incentivos".mysql_error());

		}
	}
}

/* else if($totalrows_verifica_registroincentivo==1){
	foreach($incentivos as $vincentivos => $valor)
	{
		if (ereg("sel",$vincentivos))
		{
			$query_insertar_documentograduado_incentivos="insert into documentograduado values ('','$idregistrograduado','".$row_verifica_registroincentivo['idregistroincentivoacademico']."','".$incentivos[$vincentivos]."','100','3','".$row_verifica_registroincentivo['idincentivoacademico']."')";
			$insertar_documentograduado_incentivos=mysql_query($query_insertar_documentograduado_incentivos,$sala) or die(mysql_error()."$query_insertar_documentograduado_incentivos");
			$iddocumentograduado_incentivos=mysql_insert_id();
			$query_insertar_log_documentograduado_incentivos="insert into logdocumentograduado values ('','$iddocumentograduado_incentivos','".$row_verifica_registroincentivo['idregistroincentivoacademico']."','".$incentivos[$vincentivos]."','100','3','".$row_verifica_registroincentivo['idincentivoacademico']."')";
			$insertar_log_documentograduado_incentivos=mysql_query($query_insertar_log_documentograduado_incentivos) or die(mysql_error()."$query_insertar_log_documentograduado_incentivos");
		}
	} 
}*/
?>