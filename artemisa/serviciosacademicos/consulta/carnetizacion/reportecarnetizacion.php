<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php');
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

$periodoactual = $row_periodo['codigoperiodo'];
$periodoanterior=encontrarPeriodoAnterior($periodoactual);

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
		/* $seleccion1="SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,pe.fechavencimientoperiodo,o.idsubperiodo
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
		$registros1=mysql_fetch_array($datos1); */

		if (substr($periodoactual,4,5) == 2)
		 {
	    	$periodoanterior = $periodoactual - 1 ;
		 }
		else
		 {
		   $periodoanterior = $periodoactual - 9 ;
		 }
		$seleccion1="


SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,o.idsubperiodo,c.codigomodalidadacademica,o.codigoperiodo, e.semestre
		FROM estudiante e,carrera c,ordenpago o,documento d,estudiantegeneral eg
		WHERE  e.idestudiantegeneral = eg.idestudiantegeneral
		AND e.codigocarrera = c.codigocarrera
		AND o.codigoestudiante = e.codigoestudiante
		AND eg.tipodocumento = d.tipodocumento
        AND (o.numeroordenpago IN( SELECT d.numeroordenpago from detalleordenpago d where d.codigoconcepto=151 and d.numeroordenpago = o.numeroordenpago)
        or  o.numeroordenpago in (SELECT d.numeroordenpago from detalleordenpago d where  d.numeroordenpago = o.numeroordenpago
 and (d.codigoconcepto = 154 OR d.codigoconcepto = 159 OR d.codigoconcepto = 149)))
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo = '".$periodoactual."'
		and e.codigosituacioncarreraestudiante not in (105)
		group by eg.numerodocumento
        union
SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,o.idsubperiodo,c.codigomodalidadacademica,o.codigoperiodo, e.semestre
		FROM estudiante e,carrera c,ordenpago o,documento d,estudiantegeneral eg
		WHERE  e.idestudiantegeneral = eg.idestudiantegeneral
		AND e.codigocarrera = c.codigocarrera
		AND o.codigoestudiante = e.codigoestudiante
		AND eg.tipodocumento = d.tipodocumento
        AND (o.numeroordenpago IN( SELECT d.numeroordenpago from detalleordenpago d where d.codigoconcepto=151 and d.numeroordenpago = o.numeroordenpago)
        or  o.numeroordenpago in (SELECT d.numeroordenpago from detalleordenpago d where  d.numeroordenpago = o.numeroordenpago
 and (d.codigoconcepto = 154 OR d.codigoconcepto = 159 OR d.codigoconcepto = 149 )))
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo = '".$periodoanterior."'
		and e.codigocarrera in (76,452,451)
		group by eg.numerodocumento
        union
		SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,o.idsubperiodo,c.codigomodalidadacademica,o.codigoperiodo, e.semestre
		FROM estudiante e,carrera c,ordenpago o,documento d,estudiantegeneral eg
		WHERE
		    e.idestudiantegeneral = eg.idestudiantegeneral
		AND e.codigocarrera = c.codigocarrera
		AND o.codigoestudiante = e.codigoestudiante
		AND eg.tipodocumento = d.tipodocumento
		AND o.numeroordenpago IN( SELECT d.numeroordenpago from detalleordenpago d where d.codigoconcepto=151 and d.numeroordenpago = o.numeroordenpago)
		AND  o.numeroordenpago in (SELECT d.numeroordenpago from detalleordenpago d where  d.numeroordenpago = o.numeroordenpago
 and (d.codigoconcepto = 154 OR d.codigoconcepto = 159 OR d.codigoconcepto = 149 OR d.codigoconcepto = 'C9076' or d.codigoconcepto='C9077'))
		and (e.codigocarrera = '98' or e.codigocarrera = '60' or e.codigocarrera = '69' or e.codigocarrera = '76' or e.codigocarrera = '78')
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo = '".$periodoactual."'
		group by eg.numerodocumento
union
		SELECT DISTINCT e.codigoestudiante,d.nombrecortodocumento,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,e.codigocarrera,c.nombrecarrera,o.idsubperiodo,c.codigomodalidadacademica,o.codigoperiodo, e.semestre
		FROM estudiante e,carrera c,ordenpago o,documento d,estudiantegeneral eg
		WHERE
		    e.idestudiantegeneral = eg.idestudiantegeneral
		AND e.codigocarrera = c.codigocarrera
		AND o.codigoestudiante = e.codigoestudiante
		AND eg.tipodocumento = d.tipodocumento
		AND  o.numeroordenpago in (SELECT d.numeroordenpago from detalleordenpago d where  d.numeroordenpago = o.numeroordenpago
 		and (d.codigoconcepto = 154 OR d.codigoconcepto = 159 OR d.codigoconcepto = 149 OR d.codigoconcepto = 'C9076'or d.codigoconcepto='C9077' or d.codigoconcepto = 'C9083' or d.codigoconcepto='C9057'))
		and (e.codigocarrera = '98' or e.codigocarrera = '60' or e.codigocarrera = '69' or e.codigocarrera = '76' or e.codigocarrera = '78')
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo = '".$periodoactual."'
		group by eg.numerodocumento
		ORDER BY nombrecarrera,apellidosestudiantegeneral
		";
//exit();
		$datos1=mysql_db_query($database_sala,$seleccion1);
		$registros1=mysql_fetch_array($datos1);
		/////////////////////////

		$nombre_temp = tempnam("","FOO");
		$gestor = fopen($nombre_temp, "r+b");
		fwrite($gestor,"CODIGO,TIPO,DOCUMEN,APELLIDOS,NOMBRES,PROGRAMA,NOMBRE PROGRAMA,SEMESTRE,FECHAVENCE,FIRMA\n");
		/////////////////////////
		//echo "CODIGO,TIPO,DOCUMEN,APELLIDOS,NOMBRES,PROGRAMA,NOMBRE PROGRAMA,FECHAVENCE,FIRMA<br>";
		$repetido = '';
		do{

			if ($registros1['codigocarrera'] == '60' or $registros1['codigocarrera'] == '69' or $registros1['codigocarrera'] == '76' or
			$registros1['codigocarrera'] == '76' or 
			 $registros1['codigocarrera'] == '78')
		    {
				$seleccion2="SELECT fechafinalacademicosubperiodo
				FROM carreraperiodo c,periodo p,subperiodo s
				WHERE c.codigocarrera = '".$registros1['codigocarrera']."'
				AND p.codigoperiodo = c.codigoperiodo
				AND s.idcarreraperiodo = c.idcarreraperiodo
				AND p.codigoestadoperiodo = '1'";
				$datos2=mysql_db_query($database_sala,$seleccion2);
				$registros2=mysql_fetch_array($datos2);
		        //echo $seleccion2,"<br>";
		    }
		  else
		    if ($registros1['codigomodalidadacademica'] == '100')
		    {
				$seleccion2="SELECT fechavencimientoperiodo as fechafinalacademicosubperiodo
				from periodo
				where codigoestadoperiodo = '1'";
				$datos2=mysql_db_query($database_sala,$seleccion2);
				$registros2=mysql_fetch_array($datos2);
		        //echo $seleccion2,"<br>";
		    }
		  else
            {
				$seleccion2="SELECT fechafinalacademicosubperiodo
				from subperiodo
				where idsubperiodo = '".$registros1['idsubperiodo']."'";
				$datos2=mysql_db_query($database_sala,$seleccion2);
				$registros2=mysql_fetch_array($datos2);
		    }

		 //echo $registros1['codigoestudiante'],",",$registros1['tipodocumento'],",",$registros1['numerodocumento'],",",$registros1['apellidosestudiante'],",",$registros1['nombresestudiante'],",",$registros1['codigocarrera'],",",$registros1['nombrecarrera'],"<br>";

		    if ($repetido <> $registros1['numerodocumento'])
			 {
		      fwrite($gestor,"".$registros1['numerodocumento'].",".$registros1['nombrecortodocumento'].",".$registros1['numerodocumento'].",".$registros1['apellidosestudiantegeneral'].",".$registros1['nombresestudiantegeneral'].",".$registros1['codigocarrera'].",".$registros1['nombrecarrera'].",".$registros1['semestre'].",".$registros2['fechafinalacademicosubperiodo']."\n");
		     }

		 //fwrite($gestor,"".$registros1['codigoestudiante']."\n");

		 $repetido = $registros1['numerodocumento'];
		}
		while($registros1=mysql_fetch_array($datos1));
		fclose($gestor);
		readfile($nombre_temp);

		$archivo_fuente=$nombre_temp;
		$archivo_destino="/var/tmp/listadocarnet.txt";
		//rename("$archivo_fuente", "/home/calidad/html/tmp/listadocarnet.txt");
		unlink($archivo_destino);
		rename("$archivo_fuente", "$archivo_destino");

//exit;

	    echo '<script language="javascript">window.location.href="reportecarnetizaciondescarga.php";</script>';
 }
?>
   </span><br>
<br>
<br> <input type="submit" name="Submit" value="Generar Archivo ->">
   </div>
</form>