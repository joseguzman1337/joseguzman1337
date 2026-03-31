<?php require_once('../../Connections/sala2.php');
/* $hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); */
 
//echo $username_sala,"<br>";
//echo $password_sala,"<br>"; 
//echo $hostname_sala,"<br>";
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
 Nuevo 27.11.2006
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
	  /* $query_elimina = "SELECT DISTINCT dp.idpazysalvoestudiante,dp.iddetallepazysalvoestudiante
		 FROM detallepazysalvoestudiante dp,pazysalvoestudiante pe,estudiantegeneral eg,estudiante e,carrera c
		 WHERE dp.idpazysalvoestudiante = pe.idpazysalvoestudiante
		 AND pe.codigocarrera = '147'
		 AND e.idestudiantegeneral = pe.idestudiantegeneral
		 AND e.codigocarrera = c.codigocarrera 
		 AND (c.codigomodalidadacademica = '100' OR c.codigomodalidadacademica = '200' OR c.codigomodalidadacademica = '400' OR c.codigomodalidadacademica = '600' )
		 AND eg.idestudiantegeneral = pe.idestudiantegeneral
		 AND dp.codigoestadopazysalvoestudiante LIKE '1%'
		 and (dp.iddetallepazysalvoestudiante  >= 108 and  dp.iddetallepazysalvoestudiante  <= 10792 )			
		 order by 2";
		
		$elimina = mysql_query($query_elimina, $sala) or die(mysql_error());
		$row_elimina = mysql_fetch_assoc($elimina); 
	    
		do{
		       /*  $adiciona1="update detallepazysalvoestudiante dp
				set dp.codigoestadopazysalvoestudiante = '200'
				where dp.iddetallepazysalvoestudiante = ".$row_elimina['iddetallepazysalvoestudiante']."";
				echo  $adiciona1,"<br>";				
				$ins_des1=mysql_db_query($database_sala,$adiciona1) or die("$adiciona1");
		 
		 echo $row_elimina['iddetallepazysalvoestudiante'],"<br>"; 
		
		}while($row_elimina = mysql_fetch_assoc($elimina));
		//exit();  */
	   
	   
	   $query_estudiantes = "SELECT	DISTINCT codigo,doc.idestudiantegeneral
	   FROM tmp_pazysalvo tmp,estudiantedocumento doc
	   WHERE tmp.codigo = doc.numerodocumento	  
	   ORDER BY 1";				
		//echo $query_estudiantes,"<br>";
		//exit();
		$estudiantes = mysql_query($query_estudiantes, $sala) or die(mysql_error());
		$row_estudiantes = mysql_fetch_assoc($estudiantes);
      
	   $fecha = date("Y-m-d G:i:s",time());
       $contador = 1;
do{
        $codigo = $row_estudiantes['idestudiantegeneral'];
		$codigoarea = $_POST['situacion'];	
			
				 $adicion="INSERT INTO pazysalvoestudiante(idpazysalvoestudiante,idestudiantegeneral,codigocarrera,codigoperiodo) 
				 VALUES(0, '$codigo', '$codigoarea','$periodoactual')";
				 //echo $adicion;
				 $ins=mysql_db_query($database_sala,$adicion) or die("$adicion");		
			
			     $numeroid=mysql_insert_id();		
		
		mysql_select_db($database_sala, $sala);
	   $query_estudiantes1 = "select *
	   from tmp_pazysalvo
	   where codigo = '".$row_estudiantes['codigo']."'";				
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
}while($row_estudiantes = mysql_fetch_assoc($estudiantes));
}
echo  "<br>",$contador;
?>
  </div>
  <div align="center">
   <input type="submit" name="Submit" value="Enviar">
 </div>
</form>