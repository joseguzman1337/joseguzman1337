<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
 if($_POST["SubmitExcel"]){
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
require_once('../../Connections/sala2.php'); 
//session_start();
if (isset($_GET['variables']))
 {
   $usuario = $_GET['variables'];
 }
else
 {
   $usuario = $_POST['variables'];
 }
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
	 $time = strtotime($row_periodo["fechavencimientoperiodo"]);
	 $periodoFechaVencimiento = date('Ymd',$time);

// $periodoactual = $row_periodo['codigoperiodo'];
 $periodoactual = $_SESSION['codigoperiodosesion'];
 
 if($_POST["SubmitExcel"] || $_POST["Submit"]){
	if (substr($periodoactual,4,5) == 2)
		 {		
	    	$periodoanterior = $periodoactual - 1 ;
		 }
		else
		 {
		   $periodoanterior = $periodoactual - 9 ;
		 }
		 $quitarDuplicados = "";
		 if($_POST["SubmitExcel"]){
			//aqui condiciones especificas para biblioteca
			$quitarDuplicados = " GROUP BY x.numerodocumento ";
		 }
		
		 if(isset($_REQUEST['fecha']))
		 {
		     $filtrarfecha = "and o.fechapagosapordenpago between '".$_REQUEST['fechaini']."' and '".$_REQUEST['fechafin']."' ";
		 }		
		   $seleccion1="SELECT * FROM 
		   (SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral)  AS nombre,
            e.codigocarrera,c.nombrecarrera,eg.direccionresidenciaestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,
			eg.fechanacimientoestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad, usu.usuario
            ,ed.numerodocumento as documento_antiguo,eg.idestudiantegeneral,pb.Prioridad,pb.Perfil,e.codigojornada
			FROM estudiantegeneral eg 
			inner join estudiante e on e.idestudiantegeneral = eg.idestudiantegeneral 	
			inner join carrera c on c.codigocarrera = e.codigocarrera 
			inner join ordenpago o on e.codigoestudiante = o.codigoestudiante
			inner join detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago 
			inner join PerfilBiblioteca pb on pb.ModalidadAcademicaSIC = c.codigomodalidadacademicasic
			left join estudiantedocumento ed on ed.idestudiantegeneral=eg.idestudiantegeneral  and fechavencimientoestudiantedocumento<NOW()
			left join (select numerodocumento,group_concat(usuario separator ' / ') as usuario from usuario WHERE codigoestadousuario=100 and fechavencimientousuario>now() and codigorol=1 group by numerodocumento) usu on eg.numerodocumento=usu.numerodocumento
            WHERE o.codigoestadoordenpago in (40,41,44)
            AND o.codigoperiodo = '$periodoactual' 
			and dop.codigoconcepto = 151 
			$filtrarfecha
			union
			SELECT DISTINCT e.codigoestudiante,eg.numerodocumento, CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral)  AS nombre,
            e.codigocarrera,c.nombrecarrera,eg.direccionresidenciaestudiantegeneral,eg.telefonoresidenciaestudiantegeneral,eg.emailestudiantegeneral,
			eg.fechanacimientoestudiantegeneral,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad, usu.usuario
            ,ed.numerodocumento as documento_antiguo,eg.idestudiantegeneral,pb.Prioridad,pb.Perfil,e.codigojornada
			FROM estudiantegeneral eg 
			inner join estudiante e on e.idestudiantegeneral = eg.idestudiantegeneral 	
			inner join carrera c on c.codigocarrera = e.codigocarrera 
			inner join ordenpago o on e.codigoestudiante = o.codigoestudiante
			inner join detalleordenpago dop on o.numeroordenpago = dop.numeroordenpago 
			inner join PerfilBiblioteca pb on pb.ModalidadAcademicaSIC = c.codigomodalidadacademicasic
			left join estudiantedocumento ed on ed.idestudiantegeneral=eg.idestudiantegeneral  and fechavencimientoestudiantedocumento<NOW()
			left join (select numerodocumento,group_concat(usuario separator ' / ') as usuario from usuario WHERE codigoestadousuario=100 and fechavencimientousuario>now() and codigorol=1 group by numerodocumento) usu on eg.numerodocumento=usu.numerodocumento
            WHERE  o.codigoestadoordenpago in (40,41,44)
            AND o.codigoperiodo = '$periodoanterior' 
            and dop.codigoconcepto = 151
            AND (e.codigocarrera ='98')

            $filtrarfecha
			ORDER BY Prioridad ASC, codigojornada ASC 
			) x 
			$quitarDuplicados 
			ORDER BY 5,3,4"; //
			/* ('60','69','76','78','98','452') )*/
//exit();
			$datos1=mysql_db_query($database_sala,$seleccion1);
			$registros1=mysql_fetch_array($datos1);	
		  // echo $seleccion1; exit();
		  //var_dump($periodoFechaVencimiento);die;
 }
 if($_POST["SubmitExcel"]){ ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
		<title>Reporte</title>


		<style type="text/css">
		table
		{
		 border-collapse: collapse;
			border-spacing: 0;
		}
		th, td {
		border: 1px solid #000000;
			padding: 0.5em;
		}
		</style>
		</head>
		<body>
		<table>
			<thead>
				<tr>
					<th>.USER_TITLE.</th>
					<th>.USER_ID.</th>
					<th>.USER_ALT_ID.</th>
					<th>.USER_GROUP_ID.</th>
					<th>.USER_NAME.</th>
					<!--<th>.USER_LIBRARY.</th>-->
					<th>.USER_PROFILE.</th>
					<!--<th>.USER_STATUS.</th>
					<th>.USER_ROUTING_FLAG.</th>-->
					<th>.USER_PRIV_EXPIRES.</th>
					<th>.USER_PIN.</th>
					<!--<th>.USER_CATEGORY1.</th>
					<th>.USER_CATEGORY2.</th>
					<th>.USER_CATEGORY3.</th>
					<th>.USER_CATEGORY4.</th>-->
					<th>.USER_CATEGORY5.</th>
					<th>.USER_DEPARTMENT.</th>
					<th>.USER_WEB_AUTH.</th>
					<th>.ADDRESS.</th>
					<th>.HOMEPHONE.</th>
					<th>.CITY.</th>
					<th>.EMAIL.</th>
					<th>.EMAIL.</th>
					<th>NOTAS</th>
					<th>Fecha de nacimiento</th>
					<th>Nombre carrera</th>
					<th>Fecha pago</th>
				</tr>
			</thead>
			<tbody>
				<?php 
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
					
					if($registros1['codigocarrera']==98){
						$res_sem_prema['semestre'] = "10-GRADO";
					} else {
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
						 if($res_sem_prema['semestre']=="" || $res_sem_prema['semestre']==0){
							$res_sem_prema['semestre'] = 0;
						 } else {
							$res_sem_prema['semestre'] = $res_sem_prema['semestre']."-SEM";
						 }
					 }
					 
					 if($registros1['codigojornada']=="02" && $registros1['Perfil']=="ES-PREGRAD"){
						$registros1['Perfil']=="ES-PRE-NOC";
					 }
					
					?>
					<tr>
						<td></td>
						<td><?php echo $registros1['numerodocumento']; ?></td>
						<td><?php if(!empty($registros1['documento_antiguo'])){ echo trim($registros1['documento_antiguo']); } else {echo $registros1['numerodocumento'];} ?></td>
						<td><?php echo $registros1['codigocarrera']; ?></td>
						<td><?php echo utf8_encode($registros1['nombre']); ?></td>
						<!--<td></td>-->
						<td><?php echo $registros1['Perfil']; ?></td>
						<!--<td></td>
						<td></td>-->
						<td><?php echo $periodoFechaVencimiento; ?></td>
						<td><?php $excel_date = 25569 + (strtotime($registros1['fechanacimientoestudiantegeneral']) / 86400); echo substr($excel_date, 0, 5); ?></td>
						<!--<td></td>
						<td></td>
						<td></td>
						<td>0</td>-->
						<td><?php echo $res_sem_prema['semestre']; ?></td>
						<td><?php echo $registros1['codigocarrera']; ?></td>
						<td><?php $usuarios=explode("/",$registros1['usuario']); echo trim($usuarios[0]); ?></td>
						<td><?php echo utf8_encode($registros1['direccionresidenciaestudiantegeneral']); ?></td>
						<td><?php echo $registros1['telefonoresidenciaestudiantegeneral']; ?></td>
						<td><?php echo utf8_encode($registros2['nombreciudad']); ?></td>
						<td><?php echo trim($usuarios[0])."@unbosque.edu.co"; ?></td>
						<td><?php echo $registros1['emailestudiantegeneral']; ?></td>
						<td>ESTUDIANTE DE <?php echo strtoupper($registros1['nombrecarrera']); ?> EN <?php echo $res_sem_prema['semestre']; ?> <<?php echo $registros1['codigocarrera']; ?>></td>
						<td><?php echo $registros1['fechanacimientoestudiantegeneral']; ?></td>
						<td><?php echo utf8_encode($registros1['nombrecarrera']); ?></td>
						<td><?php echo $registros3['fechapagosapordenpago']; ?></td>
						
					</tr>				
				<?php }while($registros1=mysql_fetch_array($datos1));	
				 ?>
			</tbody>
		</table>
		</body>
		</html>
<?php exit();
 }


//echo $usuario,"aca";

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
function validar_fechas(){
    /*if((document.getElementById("fechaini").value=="")||(document.getElementById("fechafin").value=="")){
        alert("debe ingresar una fecha inicial y final para procesar el archivo");
        return false;
    }else{*/
        return true;
    //}
    
}
//-->
</script>
<body class="Estilo2"><form name="form1" method="post" action="listadomatriculados.php">
   <div align="center"><span class="Estilo1"><strong><span class="Estilo3">GENERAR ARCHIVO MATRICULADOS </span><br>
   </strong>
   </span>
   Separador: <select id="separador" name="separador">
                    <option value="," selected="">coma ( , )</option>
                    <option value="|" selected="">pipe ( | )</option>
            </select>
   <br>
  Filtrar por Fechas <input type="checkbox" name="fecha" onClick="ocultar(this)">
 <div id="filtrarfecha" style="display: none"> 
Fecha Inicial <input type="text" id="fechaini" name="fechaini" size="10"> <b>aaaa-mm-dd</b>
<br>
Fecha Final <input type="text" id="fechafin" name="fechafin" size="10"> <b>aaaa-mm-dd</b>
</div>
   <br> 
<span class="Estilo1">
<input type="hidden" name="variables" value="<?php echo $usuario;?>"> 
<?php
if ($_POST['Submit'])

  {
   			
		$nombre_temp = tempnam("","FOO");

		$gestor = fopen($nombre_temp, "r+b");
        if(isset($_POST["separador"])&&$_POST["separador"]=="|"){
                $separador="|";
                
            }else{
                $separador=",";
            }
		fwrite($gestor,"DOCUMENTO".$separador."NOMBRES".$separador."FECHA NACIMIENTO".$separador."EDAD".$separador."LUGAR ORIGEN".$separador."SEMESTRE".$separador."PROGRAMA".$separador."NOMBRE PROGRAMA".$separador."DIRECCION".$separador."TELEFONO".$separador."EMAIL".$separador."FECHAPAGO".$separador."USUARIO\n");
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
		 fwrite($gestor,"".$registros1['numerodocumento'].$separador.$registros1['nombre'].$separador.$registros1['fechanacimientoestudiantegeneral'].$separador.$registros1['edad'].$separador.$registros2['nombreciudad'].$separador.$res_sem_prema['semestre'].$separador.$registros1['codigocarrera'].$separador.$registros1['nombrecarrera'].$separador.$registros1['direccionresidenciaestudiantegeneral'].$separador.$registros1['telefonoresidenciaestudiantegeneral'].$separador.$registros1['emailestudiantegeneral'].$separador.$registros3['fechapagosapordenpago'].$separador.$registros1['usuario']."\n");
		 //fwrite($gestor,"".$registros1['codigoestudiante']."\n");
		 }while($registros1=mysql_fetch_array($datos1));	

		fclose($gestor);
		readfile($nombre_temp);
		$archivo_fuente=$nombre_temp;
		$archivo_destino="/var/tmp/listadoestudiantesmatriculados.txt";
        /////windowsprueba
        //$archivo_destino="C:\listadoestudiantesmatriculados.txt";
		//rename("$archivo_fuente", "/home/calidad/html/tmp/listadocarnet.txt");
		unlink($archivo_destino);
		rename("$archivo_fuente", "$archivo_destino"); 
		//exit();  
	    echo '<script language="javascript">window.location.href="listadomatriculadosdescarga.php"</script>';
 }    

?>
</span><br> 
<input type="submit" name="Submit" value="Generar Archivo Plano"  onclick="return validar_fechas(); ">   

<input type="submit" name="SubmitExcel" value="Generar Archivo de Excel Biblioteca"  onclick="return validar_fechas(); ">  
   </div>

</form>

