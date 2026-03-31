<?php 

if($documento==1){
	foreach($diploma as $vdiploma => $valor)
	{
		if (ereg("sel",$vdiploma))
		{
			$query_anular_documentograduado_diploma="update documentograduado set codigoestado='200' where idregistrograduado='$idregistrograduado' and iddirectivo='".$diploma[$vdiploma]."' and codigotipodocumentograduado='1'";
			echo $query_anular_documentograduado_diploma,"<br>";
			$anular_documentograduado_diploma=mysql_query($query_anular_documentograduado_diploma,$sala);
			if(!$anular_documentograduado_diploma){echo mysql_error();}
			else{echo '
			<script language="javascript">window.opener.recargar();</script>;
			<script language="javascript">window.close();</script>';}
		}
	}
}

if($documento==2){
	foreach($acta as $vacta => $valor)
	{
		if (ereg("sel",$vacta))
		{
			$query_anular_documentograduado_acta="update documentograduado set codigoestado='200' where idregistrograduado='$idregistrograduado' and iddirectivo='".$acta[$vacta]."' and codigotipodocumentograduado='2'";
			echo $query_anular_documentograduado_acta,"<br>";
			$anular_documentograduado_acta=mysql_query($query_anular_documentograduado_acta,$sala);
			if(!$anular_documentograduado_acta){echo mysql_error();}
			else{echo '
			<script language="javascript">window.opener.recargar();</script>;
			<script language="javascript">window.close();</script>';}
		}
	}
}
?>