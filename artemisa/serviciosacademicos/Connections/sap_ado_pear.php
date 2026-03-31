<?php
$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, 
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = $sala->query($query_estadoconexionexterna);     
$row_estadoconexionexterna = $estadoconexionexterna->fetchRow($estadoconexionexterna);
if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
	$login = array (                              // Set login data to R/3 
    "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name 
	"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number 
	"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client 
	"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user 
	"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
	"CODEPAGE"=>"1100");              												// codepage  

	$rfc = saprfc_open($login);
	if(!$rfc) 
	{
		// We have failed to connect to the SAP server
		//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
		//exit(1);
	}
}
?>