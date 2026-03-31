<?php //require_once('../Connections/sala2.php'); 
$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 


mysql_select_db($database_sala, $sala);

$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";

$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());

$row_periodo = mysql_fetch_assoc($periodo);

$totalRows_periodo = mysql_num_rows($periodo);



 $periodoactual = $row_periodo['codigoperiodo'];

?>

<style type="text/css">

<!--

.Estilo1 {font-family: tahoma}

-->

</style>

<title>Listado para Carnetización</title>



<form name="form1" method="post" action="reportecarnetizacion.php">

   <div align="center"><span class="Estilo1"><strong>GENERAR ARCHIVO CARNETIZACI&Oacute;N </strong>

    <?php

if ($_POST['Submit'])

  {



		$seleccion1="SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,pe.fechavencimientoperiodo

		FROM estudiante e,prematricula p,carrera c,ordenpago o,periodo pe,documento d,estudiantegeneral eg

		WHERE e.codigoestudiante = p.codigoestudiante

		AND e.idestudiantegeneral = eg.idestudiantegeneral

		AND e.codigocarrera = c.codigocarrera

		AND p.idprematricula = o.idprematricula

		AND p.codigoperiodo = pe.codigoperiodo

		AND eg.tipodocumento = d.tipodocumento

		AND p.codigoestadoprematricula LIKE '4%'

		AND o.codigoestadoordenpago LIKE '4%'		

		AND p.codigoperiodo = '$periodoactual'

		ORDER BY c.nombrecarrera,eg.apellidosestudiantegeneral";
		$datos1=mysql_db_query($database_sala,$seleccion1);
		$registros1=mysql_fetch_array($datos1);

		

		/////////////////////////

		$nombre_temp = tempnam("","FOO");

		$gestor = fopen($nombre_temp, "r+b");

		fwrite($gestor,"CODIGO,TIPO,DOCUMEN,APELLIDOS,NOMBRES,PROGRAMA,NOMBRE PROGRAMA,FECHAVENCE,FIRMA\n");

		

		

		

		/////////////////////////

		//echo "CODIGO,TIPO,DOCUMEN,APELLIDOS,NOMBRES,PROGRAMA,NOMBRE PROGRAMA,FECHAVENCE,FIRMA<br>";

		do{

		 //echo $registros1['codigoestudiante'],",",$registros1['tipodocumento'],",",$registros1['numerodocumento'],",",$registros1['apellidosestudiante'],",",$registros1['nombresestudiante'],",",$registros1['codigocarrera'],",",$registros1['nombrecarrera'],"<br>"; 

		 fwrite($gestor,"".$registros1['numerodocumento'].",".$registros1['nombrecortodocumento'].",".$registros1['numerodocumento'].",".$registros1['apellidosestudiantegeneral'].",".$registros1['nombresestudiantegeneral'].",".$registros1['codigocarrera'].",".$registros1['nombrecarrera'].",".$registros1['fechavencimientoperiodo']."\n");

		 //fwrite($gestor,"".$registros1['codigoestudiante']."\n");

		}

		while($registros1=mysql_fetch_array($datos1));

		

		fclose($gestor);

		readfile($nombre_temp);

			

		$archivo_fuente=$nombre_temp;

		$archivo_destino="/var/tmp/listadocarnet.txt";

		//rename("$archivo_fuente", "/home/calidad/html/tmp/listadocarnet.txt");

		unlink($archivo_destino);

		rename("$archivo_fuente", "$archivo_destino");    

	   echo '<script language="javascript">window.location.reload("reportecarnetizaciondescarga.php")</script>';	

    

 }    

?>

   </span><br> 

<br> 

<br> <input type="submit" name="Submit" value="Generar Archivo">   

   </div>

</form>

