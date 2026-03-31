<?php
error_reporting(0);
if($totalrows_registrograduado==0)
{
	foreach($diploma as $vdiploma => $valor)
	{
		if (ereg("sel",$vdiploma))
		{
			$query_insertar_documentograduado_diploma="insert into documentograduado values ('','$idregistrograduado','1','".$diploma[$vdiploma]."','100','1','1')";
			$insertar_documentograduado_diploma=mysql_query($query_insertar_documentograduado_diploma,$sala);
			$iddocumentograduado_diploma=mysql_insert_id();
			$query_insertar_log_documentograduado_diploma="insert into logdocumentograduado values ('','$iddocumentograduado_diploma','1','".$diploma[$vdiploma]."','100','1','1')";
			//echo $query_insertar_documentograduado_diploma;
			//echo $query_insertar_log_documentograduado_diploma;
			$insertar_log_documentograduado_diploma=mysql_query($query_insertar_log_documentograduado_diploma,$sala) or die(mysql_error());
			if(!$insertar_documentograduado_diploma or !$insertar_log_documentograduado_diploma){echo mysql_error();}
		}
	}

	foreach($acta as $vacta => $valor)
	{
		if (ereg("sel",$vacta))
		{

			$query_insertar_documentograduado_acta="insert into documentograduado values ('','$idregistrograduado','1','".$acta[$vacta]."','100','2','1')";
			//echo $query_insertar_documentograduado_acta,"<br>";
			$insertar_documentograduado_acta=mysql_query($query_insertar_documentograduado_acta,$sala);
			$iddocumentograduado_acta=mysql_insert_id();
			$query_insertar_log_documentograduado_acta="insert into logdocumentograduado values ('','$iddocumentograduado_acta','1','".$acta[$vacta]."','100','2','1')";
			$insertar_log_documentograduado_acta=mysql_query($query_insertar_log_documentograduado_acta) or die(mysql_error());
			//echo $insertar_log_documentograduado_acta;
			if(!$insertar_documentograduado_acta or !$insertar_log_documentograduado_acta){echo mysql_error();}
		}

	}
	if($insertar_documentograduado_acta or $insertar_log_documentograduado_acta){
	
	echo '<script language="javascript">window.location.reload("graduar_estudiantes_ingreso.php?codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'");</script>';
	
	}
}

elseif(@$totalrows_registrograduado==1)
{
	foreach(@$diploma as $vdiploma => $valor)
	{
		if (ereg("sel",$vdiploma))
		{
			$query_insertar_documentograduado_diploma="insert into documentograduado values ('','$idregistrograduado','1','".$diploma[$vdiploma]."','100','1','1')";
			//echo $query_insertar_documentograduado_diploma;
			$insertar_documentograduado_diploma=mysql_query($query_insertar_documentograduado_diploma,$sala);
			$iddocumentograduado_diploma=mysql_insert_id();
			$query_insertar_log_documentograduado_diploma="insert into logdocumentograduado values ('',$iddocumentograduado_diploma,'1','".$diploma[$vdiploma]."','100','1','1')";
			//echo $query_insertar_log_documentograduado_diploma;
			$insertar_log_documentograduado_diploma=mysql_query($query_insertar_log_documentograduado_diploma,$sala) or die(mysql_error());

			if(!$insertar_documentograduado_diploma or !$insertar_log_documentograduado_diploma){echo mysql_error();}
		}
	}

	foreach(@$acta as $vacta => $valor)
	{
		if (ereg("sel",$vacta))
		{

			$query_insertar_documentograduado_acta="insert into documentograduado values ('','".$row_registrograduado['idregistrograduado']."','1','".$acta[$vacta]."','100','2','1')";
			$insertar_documentograduado_acta=mysql_query($query_insertar_documentograduado_acta,$sala);
			$iddocumentograduado_acta=mysql_insert_id();
			$query_insertar_log_documentograduado_acta="insert into logdocumentograduado values ('','$iddocumentograduado_acta','1','".$acta[$vacta]."','100','2','1')";
			//echo $query_insertar_log_documentograduado_acta;
			$insertar_log_documentograduado_acta=mysql_query($query_insertar_log_documentograduado_acta) or die(mysql_error());
			if(!$insertar_documentograduado_acta or !$insertar_log_documentograduado_acta){echo mysql_error();}
		}
	}
	if($insertar_documentograduado_acta or $insertar_log_documentograduado_acta){
	
	echo '<script language="javascript">window.location.reload("graduar_estudiantes_ingreso.php?codigocarrera='.$codigocarrera.'&estudiante='.$codigoestudiante.'&codigogenero='.$codigogenero.'");</script>';}

}
?>