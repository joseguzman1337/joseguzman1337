<?php require_once('../../../Connections/sala2.php');
  ///////////////////  periodo *////////////////////////////////////      
mysql_select_db($database_sala, $sala);
$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '3'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  } 
else
  {
    mysql_select_db($database_sala, $sala);
	$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '1'";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];
  }	
    $query_documentosestuduante = "SELECT * 
    FROM carrera
    order by nombrecarrera
    ";
	//echo $query_documentosestuduante,"<br>";	 
	$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
	$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
	$totalRows_documentosestuduante  = mysql_num_rows($documentosestuduante );  
?>
<form name="form1" method="post" action="">
  <div align="center">
  <select name="situacion" id="situacion">
                <option value="0" <?php if (!(strcmp(0, $_POST['situacion']))) {echo "SELECTED";} ?>>Carrera</option>
<?php
do {  
?>
                <option value="<?php echo $row_documentosestuduante['codigocarrera']?>"<?php if (!(strcmp($row_documentosestuduante['codigocarrera'], $_POST['situacion']))) {echo "SELECTED";} ?>><?php echo $row_documentosestuduante['nombrecarrera']?></option>
<?php
} while ($row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante));
  $rows = mysql_num_rows($documentosestuduante);
  if($rows > 0) {
      mysql_data_seek($documentosestuduante, 0);
	  $row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante);
  }
?>
    </select> 
<?php 		
///////////////////////////////////////////////////////////////		
if ($_POST['Submit'])
  {
		mysql_select_db($database_sala, $sala);
	   $query_estudiantes = "SELECT	DISTINCT codigo
	   FROM tmp_pazysalvo
	   ORDER BY 1
	   ";				
		//echo $query_estudiantes,"<br>";
		//exit();
		$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
		$row_estudiantes = mysql_fetch_assoc($estudiantes);	
      
	   $fecha = date("Y-m-d G:i:s",time());
       $contador = 1;
do{
        
	   $query_noexiste = "SELECT idestudiantegeneral
	   FROM estudiantegeneral
	   WHERE numerodocumento = '".$row_estudiantes['codigo']."' 
	   ORDER BY 1
	   ";				
		//echo $query_estudiantes,"<br>";
		//exit();
		$noexiste = mysql_query($query_noexiste, $sala) or die(mysql_error());
		$row_noexiste = mysql_fetch_assoc($noexiste);
	if ($row_noexiste  <> "")
	 { // no existe
		  $codigo = $row_noexiste['idestudiantegeneral'];
		  $codigoarea = $_POST['situacion'];		
				 $adicion="INSERT INTO pazysalvoestudiante(idpazysalvoestudiante,idestudiantegeneral,codigocarrera,codigoperiodo) 
							VALUES(0, '$codigo', '$codigoarea','$periodoactual')";
				//echo $adicion;
				 $ins=mysql_db_query($database_sala,$adicion) or die("$adicion");
										 
			     $numeroid=mysql_insert_id();
		
	     mysql_select_db($database_sala, $sala);
	     $query_estudiantes1 = "select *
				              from tmp_pazysalvo
				              where codigo = '".$row_estudiantes['codigo']."'
						    ";				
		//echo $query_estudiantes1,"<br>";
		
		$estudiantes1 = mysql_query($query_estudiantes1, $sala) or die(mysql_error());
		$row_estudiantes1 = mysql_fetch_assoc($estudiantes1);		
		
		//exit();
		do{
										 
				$adiciona="INSERT INTO detallepazysalvoestudiante(idpazysalvoestudiante,descripciondetallepazysalvoestudiante,fechainiciodetallepazysalvoestudiante,fechavencimientodetallepazysalvoestudiante,codigotipopazysalvoestudiante,codigoestadopazysalvoestudiante) 
						 VALUES('".$numeroid."','".$row_estudiantes1['descripcion']."','".$fecha."','".$fecha."','".$row_estudiantes1['tipo']."','100')";
				// echo $adiciona;
				$ins_des=mysql_db_query($database_sala,$adiciona) or die("$adiciona");
		  $contador ++;
		
		}while($row_estudiantes1 = mysql_fetch_assoc($estudiantes1));

  } // if no existe
 else
  {
    echo $row_estudiantes['codigo'],"<br><br>";
  
  }
}while($row_estudiantes = mysql_fetch_assoc($estudiantes));
}
echo  $contador;
?>
  </div>
  <div align="center">
   <input type="submit" name="Submit" value="Enviar">
 </div>
</form>