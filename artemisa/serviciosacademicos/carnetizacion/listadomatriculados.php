<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
     
require_once('../../Connections/sala2.php'); 

if (isset($_GET['variables']))
 {
   $usuario = $_GET['variables'];
 }
else
 {
   $usuario = $_POST['variables'];
 }


//echo $usuario,"aca";
	mysql_select_db($database_sala, $sala);
	$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '3'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);
   
    if ($row_periodo == "")
	 {
	   $query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";
	   $periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	   $row_periodo = mysql_fetch_assoc($periodo);
	   $totalRows_periodo = mysql_num_rows($periodo);
	 }

 $periodoactual = $row_periodo['codigoperiodo'];

    mysql_select_db($database_sala, $sala);
	/* $query_tipousuario = "SELECT *
	FROM usuariofacultad
	where usuario = '".$usuario."'";
	echo $query_tipousuario;
	$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	$row_tipousuario = mysql_fetch_assoc($tipousuario);
	$totalRows_tipousuario = mysql_num_rows($tipousuario); */
?>    
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-family: tahoma; font-size: 9px; }
.Estilo3 {font-size: small}
-->
</style>
<script type="text/javascript">
<!--
function ocultar(filtro)
{
	if(filtro.checked)
	{
		document.getElementById("filtrarfecha").style.display="block";
	}
	else
	{
		document.getElementById("filtrarfecha").style.display="none";
	}
}
//-->
</script>
<body class="Estilo2"><form name="form1" method="post" action="listadomatriculados.php">
   <div align="center"><span class="Estilo1"><strong><span class="Estilo3">GENERAR ARCHIVO MATRICULADOS </span><br>
   </strong>
   </span><br>
  Filtrar por Fechas <input type="checkbox" name="fecha" onClick="ocultar(this)">
 <div id="filtrarfecha" style="display: none"> 
Fecha Inicial <input type="text" name="fechaini" size="10"> <b>aaaa-mm-dd</b>
<br>
Fecha Final <input type="text" name="fechafin" size="10"> <b>aaaa-mm-dd</b>
</div>
   <br> 
<span class="Estilo1">
<input type="hidden" name="variables" value="<?php echo $usuario;?>"> 
<?php

if ($_POST['Submit'])

  {
   		if (substr($periodoactual,4,5) == 2)
		 {		
	    	$periodoanterior = $periodoactual - 1 ;
		 }
		else
		 {
		   $periodoanterior = $periodoactual - 9 ;
		 }
		
		 if(isset($_REQUEST['fecha']))
		 {
		     $filtrarfecha = "and o.fechapagosapordenpago between '".$_REQUEST['fechaini']."' and '".$_REQUEST['fechafin']."' ";
		 }
			/* $seleccion1="SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)  AS nombre,(p.semestreprematricula * 1) AS semestre,
			e.codigocarrera,c.nombrecarrera,eg.direccionresidenciaestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,eg.fechanacimientoestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
			FROM estudiante e,prematricula p,carrera c,ordenpago o,estudiantegeneral eg
			WHERE e.codigoestudiante = p.codigoestudiante
			AND e.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = e.codigocarrera 
			AND o.idprematricula = p.idprematricula
			AND p.codigoestadoprematricula LIKE '4%'
			AND o.codigoestadoordenpago LIKE '4%'
			AND p.codigoperiodo = '$periodoactual'
			ORDER BY e.codigocarrera,eg.apellidosestudiantegeneral,semestre";
			$datos1=mysql_db_query($database_sala,$seleccion1);
			$registros1=mysql_fetch_array($datos1); */
		
		    $seleccion1="SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
            e.codigocarrera,c.nombrecarrera,eg.direccionresidenciaestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,eg.fechanacimientoestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
            FROM estudiante e,carrera c,ordenpago o,estudiantegeneral eg, detalleordenpago do
            WHERE e.codigoestudiante = o.codigoestudiante
            AND e.idestudiantegeneral = eg.idestudiantegeneral
            AND c.codigocarrera = e.codigocarrera 
            AND o.codigoestadoordenpago LIKE '4%'
            AND o.codigoperiodo = '$periodoactual'
            and o.numeroordenpago = do.numeroordenpago
			and do.codigoconcepto = 151
			$filtrarfecha
			union
			SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
            e.codigocarrera,c.nombrecarrera,eg.direccionresidenciaestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,eg.fechanacimientoestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad
            FROM estudiante e,carrera c,ordenpago o,estudiantegeneral eg, detalleordenpago do
            WHERE e.idestudiantegeneral = eg.idestudiantegeneral
            AND c.codigocarrera = e.codigocarrera 
            AND o.codigoestadoordenpago LIKE '4%'
            AND o.codigoperiodo = '$periodoanterior'
			and o.codigoestudiante = e.codigoestudiante
            and o.numeroordenpago = do.numeroordenpago
            and do.codigoconcepto = 151
            AND (e.codigocarrera = '60' or e.codigocarrera = '69' or e.codigocarrera = '76' or e.codigocarrera = '78' or e.codigocarrera = '98')
            $filtrarfecha
			ORDER BY 5,3,4"; //
			$datos1=mysql_db_query($database_sala,$seleccion1);
			$registros1=mysql_fetch_array($datos1);		
		    echo $seleccion1; 
		    //exit();
		$nombre_temp = tempnam("","FOO");

		$gestor = fopen($nombre_temp, "r+b");
		fwrite($gestor,"DOCUMENTO,APELLIDOS,NOMBRES,FECHA NACIMIENTO,EDAD,LUGAR ORIGEN,SEMESTRE,PROGRAMA,NOMBRE PROGRAMA,DIRECCION,TELEFONO,EMAIL,FECHAPAGO\n");
		/////////////////////////
		//echo "CODIGO,TIPO,DOCUMEN,APELLIDOS,NOMBRES,PROGRAMA,NOMBRE PROGRAMA,FECHAVENCE,FIRMA<br>";
		do{		   
		   
		    $seleccion3="SELECT MAX(fechapagosapordenpago) AS fechapagosapordenpago
			FROM detalleordenpago d,ordenpago o
			WHERE d.numeroordenpago = o.numeroordenpago
			AND o.codigoestudiante = '".$registros1['codigoestudiante']."'
			AND ( d.codigoconcepto = 151 OR d.codigoconcepto = 154 )";
			$datos3=mysql_db_query($database_sala,$seleccion3);
			$registros3=mysql_fetch_array($datos3);		
			
			// Fecha de pago
			$seleccion2="select nombreciudad
			from estudiantegeneral eg,ciudad c
			where eg.idciudadnacimiento = c.idciudad
			and eg.numerodocumento = '".$registros1['numerodocumento']."'";
			$datos2=mysql_db_query($database_sala,$seleccion2);
			$registros2=mysql_fetch_array($datos2);	
			
			$sem_prema="select (semestreprematricula * 1) AS semestre
			from prematricula
			where codigoestudiante = '".$registros1['codigoestudiante']."'
			and codigoperiodo = '$periodoactual'
			and codigoestadoprematricula like '4%'";
			$res_prema=mysql_db_query($database_sala,$sem_prema);
			$res_sem_prema=mysql_fetch_array($res_prema);		  	  
		    
			if (! $res_sem_prema)
			 {
			  $sem_prema="select (semestreprematricula * 1) AS semestre
			  from prematricula
			  where codigoestudiante = '".$registros1['codigoestudiante']."'
			  and codigoperiodo = '$periodoanterior'
			  and codigoestadoprematricula like '4%'";
			  $res_prema=mysql_db_query($database_sala,$sem_prema);
			  $res_sem_prema=mysql_fetch_array($res_prema);		  	
			 }
			
		 //echo $registros1['codigoestudiante'],",",$registros1['tipodocumento'],",",$registros1['numerodocumento'],",",$registros1['apellidosestudiante'],",",$registros1['nombresestudiante'],",",$registros1['codigocarrera'],",",$registros1['nombrecarrera'],"<br>"; 
		 //fwrite($gestor,"".$registros1['numerodocumento'].",".$registros1['nombre'].",".$registros1['fechanacimientoestudiantegeneral'].",".$registros1['edad'].",".$registros2['nombreciudad'].",".$res_sem_prema['semestre'].",".$registros1['codigocarrera'].",".$registros1['nombrecarrera'].",".$registros1['direccionresidenciaestudiantegeneral'].",".$registros1['telefonoresidenciaestudiantegeneral'].",".$registros1['emailestudiantegeneral'].",".$registros3['fechapagosapordenpago']."\n");
		 fwrite($gestor,"".$registros1['numerodocumento'].",".$registros1['apellidosestudiantegeneral'].",".$registros1['nombresestudiantegeneral'].",".$registros1['fechanacimientoestudiantegeneral'].",".$registros1['edad'].",".$registros2['nombreciudad'].",".$res_sem_prema['semestre'].",".$registros1['codigocarrera'].",".$registros1['nombrecarrera'].",".$registros1['direccionresidenciaestudiantegeneral'].",".$registros1['telefonoresidenciaestudiantegeneral'].",".$registros1['emailestudiantegeneral'].",".$registros3['fechapagosapordenpago']."\n");
		 //fwrite($gestor,"".$registros1['codigoestudiante']."\n");
		 }while($registros1=mysql_fetch_array($datos1));	

		fclose($gestor);
		readfile($nombre_temp);
		$archivo_fuente=$nombre_temp;
		$archivo_destino="/var/tmp/listadoestudiantesmatriculados.txt";

		//rename("$archivo_fuente", "/home/calidad/html/tmp/listadocarnet.txt");
		unlink($archivo_destino);
		rename("$archivo_fuente", "$archivo_destino"); 
		//exit();  
	    echo '<script language="javascript">window.location.reload("listadomatriculadosdescarga.php")</script>';
 }    

?>
</span><br> 
<input type="submit" name="Submit" value="Generar Archivo">   

   </div>

</form>

