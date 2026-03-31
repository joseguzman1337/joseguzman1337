<?php
mysql_select_db("sala",$sala);
$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
	$login = array (                              // Set login data to R/3
            "ASHOST"=>"172.16.3.199",             // application server host name
            "SYSNR"=>"00",                     // system number
            "CLIENT"=>"400",                    // client
            "USER"=>"SALA",                  // user
            "PASSWD"=>"salaado7",
			"CODEPAGE"=>"1100");              // codepage

           $rfc = saprfc_open($login);
		   if(!$rfc) {
			// We have failed to connect to the SAP server
			echo "<br><br>Failed to connect to the SAP server".saprfc_error();
			//exit(1);
	}
}

?>
