<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../Connections/sala2.php'); 

@@session_start();

mysql_select_db($database_sala, $sala);

$codigocarrera = $_SESSION['codigofacultad'];


 $query_tipousuario = "SELECT * from carrera where codigocarrera = '".$codigocarrera."'";



 $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());



 $row_tipousuario = mysql_fetch_assoc($tipousuario);



 $totalRows_tipousuario = mysql_num_rows($tipousuario);



 



 $modalidad = $row_tipousuario['codigomodalidadacademica'];



 $masculino = 0;



 $femenino = 0;



if ($modalidad == 200)



 { // if 1	



	if ($_GET['tipo'] == "")



	 {



	   $query_admitido = "SELECT distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g,estudianteestudio ee



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND ee.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106



		AND c.codigocarrera = '$codigocarrera'



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '200'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		//exit();



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 }



	else



	 {



	 $query_admitido = "SELECT  distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero,ee.observacionestudianteestudio



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g,estudianteestudio ee



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND ee.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106



		AND c.codigocarrera = '10'



		AND ee.observacionestudianteestudio = '".$_GET['tipo']."'



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '200'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		//exit();



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 }



} // if 1



else



 { // else 1



   if ($_GET['tipo'] == "" and $_GET['programa'] == "")



	 {



	   $query_admitido = "SELECT distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g,estudianteestudio ee



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND ee.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106		



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '300'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 }



	else



	 if ($_GET['tipo'] <> "" and $_GET['programa'] <> "")



	 {



	    $query_admitido = "SELECT  distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero,ee.observacionestudianteestudio



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g,estudianteestudio ee



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND ee.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106		



		AND ee.observacionestudianteestudio = '".$_GET['tipo']."'



		AND e.codigocarrera = '".$_GET['programa']."'



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '300'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		//exit();



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 } 



	else



	 if ($_GET['tipo'] == "" and $_GET['programa'] <> "")



	 {



	   $query_admitido = "SELECT distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106		



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND e.codigocarrera = '".$_GET['programa']."'



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '300'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		//exit();



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 }



	else



	 if ($_GET['tipo'] <> "" and $_GET['programa'] == "")



	 {



	 $query_admitido = "SELECT  distinct eg.idestudiantegeneral,c.nombrecarrera,i.numeroinscripcion,c.codigocortocarrera, CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.codigogenero,fechanacimientoestudiantegeneral,eg.tipodocumento,eg.numerodocumento,(YEAR (CURRENT_DATE) - YEAR(fechanacimientoestudiantegeneral)) - (RIGHT(CURRENT_DATE,5) < RIGHT(fechanacimientoestudiantegeneral,5)) AS edad,g.nombregenero,ee.observacionestudianteestudio



		FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,genero g,estudianteestudio ee



		WHERE eg.idestudiantegeneral = i.idestudiantegeneral



		AND ee.idestudiantegeneral = i.idestudiantegeneral



		AND i.idinscripcion = e.idinscripcion



		AND i.codigosituacioncarreraestudiante = 106		



		AND ee.observacionestudianteestudio = '".$_GET['tipo']."'		



		AND eg.codigogenero = g.codigogenero



		AND e.codigocarrera = c.codigocarrera



		AND m.codigomodalidadacademica = i.codigomodalidadacademica 



		AND e.idnumeroopcion = '1'



		and i.codigoestado like '1%'



		AND i.codigomodalidadacademica = '300'



		ORDER BY ".$_GET['ordenado']."";



		//echo "$query_admitido<br>";		



		//exit();



		$admitido = mysql_db_query($database_sala, $query_admitido) or die("$query_admitido".mysql_error());



		$totalRows_admitido = mysql_num_rows($admitido);



		$row_admitido = mysql_fetch_array($admitido);



	 } 



  $row_tipousuario['nombrecarrera'] = "POSTGRADOS";



 }// else 1







?>



<style type="text/css">



<!--



.Estilo1 {font-family: tahoma}



.Estilo2 {



	font-size: xx-small;



	font-weight: bold;



}



.Estilo3 {font-size: xx-small}



-->



</style>



<form action="" method="get" name="f1" class="Estilo1">



  <p align="center" class="Estilo4"><strong>LISTADO DE PREINSCRITOS</strong></p>



  <br>



    <p align="center" class="Estilo4">Fecha de Examen: <?php echo $_GET['fecha'];?></p>



  <br>



  <?php 



   if (!$row_admitido)



    {



	  echo '<script language="JavaScript">alert("No se produjo ningun resultado");



		     history.go(-1);</script>';  



	}



  ?>  



  <table width="707" border="0" bordercolor="#003333" align="center" cellpadding="0" cellspacing="0">



    <tr bgcolor='#C5D5D6'>



     <td align='center' class='Estilo1 Estilo4' colspan="8"><span class="Estilo2"><?php echo  $row_tipousuario['nombrecarrera']; ?><br><br></span></td>	 



   </tr>   



   <tr bgcolor='#C5D5D6'>



     <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">No. Formulario</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Documento</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Nombres</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Programa</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Salón</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Sexo</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Edad</span></td>



	 <td align='center' class='Estilo1 Estilo4'><span class="Estilo2">Firma</span></td>	 



   </tr>  



<?php 



     do{



        $query_salon = "SELECT observacionestudianteestudio 



		 from estudianteestudio



		 where idestudiantegeneral = '".$row_admitido['idestudiantegeneral']."'";



		 $salon = mysql_db_query($database_sala, $query_salon) or die("$query_salon".mysql_error());



		 $totalRows_salon = mysql_num_rows($salon);



		 $row_salon = mysql_fetch_array($salon);  



?> 



	



	 <tr>



     <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['numeroinscripcion'];?><br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['numerodocumento'];?><br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['nombre'];?><br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['nombrecarrera'];?>&nbsp;<br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_salon['observacionestudianteestudio'];?>&nbsp;<br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['nombregenero'];?><br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $row_admitido['edad'];?><br></td>



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br>____________________________<br></td>	 



   </tr>



<?php	 



      if ($row_admitido['codigogenero'] == 100)



	   {



         $femenino ++;	   



	   }



	  else



	  if ($row_admitido['codigogenero'] == 200)



	   {



	     $masculino ++;



	   }



	 



	 }while($row_admitido = mysql_fetch_array($admitido));



?> 



   <tr>



     <td align='center' class='Estilo1 Estilo4 Estilo3'  bgcolor='#C5D5D6' colspan="7"><br><div align="right"><strong>Total Mujeres</strong></div><br></td>	 



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><br><?php echo $femenino;?></td>	 



   </tr>



    <tr>



     <td align='center' class='Estilo1 Estilo4 Estilo3'  bgcolor='#C5D5D6'  colspan="7"><div align="right"><strong>Total Hombres<br></strong></div></td>	 



	 <td align='center' class='Estilo1 Estilo4 Estilo3'><?php echo $masculino;?><br></td>	 



   </tr>



 </table>



  <div align="center"> 



    <br> 



    <br>



    <input type="button" name="imprimir" value="Imprimir" onClick="window.print()">&nbsp; <input type="button" name="regresar" value="Regresar" onClick="history.go(-1)">



  </div>



</form>



