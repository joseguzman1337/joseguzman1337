<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

require_once('../../../Connections/sala2.php');



require_once('../../../funciones/funcionip.php');



mysql_select_db($database_sala, $sala);



@@session_start();



$ip = "SIN DEFINIR";



$ip = tomarip();



$usuario = $_SESSION['MM_Username'];



$carrera = $_SESSION['codigofacultad'];



$fechahoy = date("Y-m-d G:i:s",time());



$query_periodo = "select * from periodo p,carreraperiodo c,carrera ca



			      where p.codigoperiodo = c.codigoperiodo



				  and  c.codigocarrera = ca.codigocarrera



				  and c.codigocarrera = '$carrera'



			      and p.codigoestadoperiodo like '1'



				  order by p.codigoperiodo";



$periodo = mysql_query($query_periodo, $sala) or die("$query_periodo");



$totalRows_periodo = mysql_num_rows($periodo);



$row_periodo = mysql_fetch_assoc($periodo);



     $query_planestudios = "SELECT * FROM planestudio where codigocarrera = '$carrera' 



	                       and codigoestadoplanestudio like '1%'";



	$planestudios = mysql_query($query_planestudios, $sala) or die("$query_planestudios");



	$row_planestudios = mysql_fetch_assoc($planestudios);



	$totalRows_planestudios = mysql_num_rows($planestudios);







$query_data1 = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,s.nombresituacioncarreraestudiante,s.codigosituacioncarreraestudiante

               FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,situacioncarreraestudiante s

			   WHERE e.codigocarrera = '$carrera'

			   AND eg.idestudiantegeneral = i.idestudiantegeneral

			   AND s.codigosituacioncarreraestudiante = i.codigosituacioncarreraestudiante

			   AND eg.idciudadnacimiento = ci.idciudad

			   AND i.idinscripcion = e.idinscripcion

			   AND e.codigocarrera = c.codigocarrera

			   AND m.codigomodalidadacademica = i.codigomodalidadacademica

			   AND i.codigoperiodo = '".$row_periodo['codigoperiodo']."'

			   AND i.codigosituacioncarreraestudiante = '106'

			   and i.codigoestado like '1%'			   		   

			   order by eg.apellidosestudiantegeneral		   

			   ";

		// echo $query_data1; 

		 //exit();

$data1 = mysql_query($query_data1, $sala) or die("$query_data1".mysql_error());

$totalRows_data1 = mysql_num_rows($data1);

$row_data1 = mysql_fetch_assoc($data1);

$modalidadcarrera = $row_data1['codigomodalidadacademica'];

?>



<script language="JavaScript" src="calendario/javascripts.js"></script>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8">



<style type="text/css">



<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



-->



</style>



<script language="javascript">



function HabilitarTodos(chkbox, seleccion)



{



	for (var i=0;i < document.forms[0].elements.length;i++)



	{



		var elemento = document.forms[0].elements[i];



		if(elemento.type == "checkbox")



		{



			if (elemento.title == "estudiante")



			{



				elemento.checked = chkbox.checked



			}



		}



	}



}



function grabar()



 {



  document.inscripcion.submit();



 }



</script> 



<form name="inscripcion" method="post" action="">



<table width="70%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">



 <tr>



   <td>



	 <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">



      <tr>



       <td colspan="2" align="center" bgcolor="#CCDADD" class="Estilo2"><a href="aspirantespreinscritos.php">Inscritos</a></td>



       <td colspan="2" align="center" bgcolor="#CCDADD" class="Estilo2"><a href="aspirantesinscritos.php">Admitidos</a></td>



      </tr>



<?php



  if ($row_data1 <> "")



   { // if 2



?>	 



	  <tr>



       <td class="Estilo2" align="center" colspan="4" bgcolor="#CCDADD"><?php echo $row_periodo['nombrecarrera'] ?></td>



      </tr>



	  <tr>



       <td class="Estilo2" align="center" colspan="4" bgcolor="#CCDADD">LISTADO DE ESTUDIANTES PREINSCRITOS PARA <?php echo $row_periodo['nombreperiodo'] ?> </td>



      </tr>



	 <tr>



       <td align="center" bgcolor="#CCDADD" class="Estilo2"><div align="center">Plan de Estudios </div></td>



       <td align="center" bgcolor="#CCDADD" class="Estilo2">



	    <select name="planestudio">



<?php



			if($totalRows_dataestudianteplan == "")



			{



?>



            <option value="0" <?php if (!(strcmp(0,$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>>Seleccionar ...</option>



<?php



			}



			do 



			{



				//if($row_planestudios['idplanestudio'] != $row_dataestudianteplan['idplanestudio'])



				//{  



?>



            <option value="<?php echo $row_planestudios['idplanestudio'];?>"<?php if(!(strcmp($row_planestudios['idplanestudio'],$row_dataestudianteplan['idplanestudio']))) {echo "SELECTED";} ?>><?php echo $row_planestudios['nombreplanestudio']?></option>



<?php



				//}



			} 



			while ($row_planestudios = mysql_fetch_assoc($planestudios));



			$totalRows_planestudios = mysql_num_rows($planestudios);



			if($totalRows_planestudios > 0)



			{



				mysql_data_seek($planestudios, 0);



				$row_planestudios = mysql_fetch_assoc($planestudios);



			}



?>



          </select>



	   </td>



       <td align="center" bgcolor="#CCDADD" class="Estilo2"><div align="right">Habilitar Todos</div></td>



       <td class="Estilo2" align="center" bgcolor="#CCDADD"><input type="checkbox" name="checkbox" onClick="HabilitarTodos(this)"></td>



	  </tr>



	  <tr bgcolor="#CCDADD">



       <td width="26%" class="Estilo2"><div align="center">Documento</div></td>



	   <td class="Estilo2" colspan="2"><div align="center">Nombre</div></td>



	   <td width="8%" class="Estilo2"><div align="center">Admitir</div></td>



	  </tr>



<?php 



	    $w = 1;



		 do{



?>



		   <tr>



              <td class="Estilo1"><div align="center"><?php echo $row_data1['numerodocumento'] ?> </div></td>



			  <td colspan="2" class="Estilo1"><div align="center"><?php echo $row_data1['apellidosestudiantegeneral'] ?> <?php echo $row_data1['nombresestudiantegeneral']; ?> 



		        <input type="hidden" name="documento<?php echo $w; ?>" value="<?php echo $row_data1['numerodocumento'];?>"> 



	            <input type="hidden" name="tipo<?php echo $w; ?>" value="<?php echo $row_data1['tipodocumento'];?>"> 



				<input type="hidden" name="expedido<?php echo $w; ?>" value="<?php echo $row_data1['expedidodocumento'];?>">



			  </div></td>



			  <td class="Estilo1"><div align="center">



<?php 



			      /* $query_data2 = "SELECT * from inscripcion i



				   where i.idestudiantegeneral = '".$row_data1['idestudiantegeneral']."'



				   AND i.codigoperiodo = '".$row_periodo['codigoperiodo']."'



				   and i.codigosituacioncarreraestudiante = 300



				   ";



				   // echo $query_data1; 



				   //exit();



                   $data2 = mysql_query($query_data2, $sala) or die("$query_data2".mysql_error());



                   $totalRows_data2= mysql_num_rows($data2);



                   $row_data2 = mysql_fetch_assoc($data2);



			      if ($row_data2 == "")



     			   {		*/	   



?>



			          <input type="checkbox" name="estudiante<?php echo $w;?>" title="estudiante" value="<?php echo $row_data1['idestudiantegeneral']; ?>"></div>



			  <?php 



			  /*     }



				  else



				   {



				    echo "Admitido";



				   }*/



			  ?>



			  </td>



           </tr>



<?php		 



		  $w ++ ;



		 }while($row_data1 = mysql_fetch_assoc($data1));



?>



     </table>



<?php 



   } // if 2



  else



   {



    //echo "No se produjo ningun resultado";



   }



?> 	



   </td>



 </tr>



</table>



<br><br>



<div align="center">



 <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>



   <input type="hidden" name="grabado" value="grabado">



</div>



<?php 



 if (isset($_POST['grabado']))



   {     



    // echo $_POST['planestudio'],"----",$modalidadcarrera; exit();



     if ($_POST['planestudio'] == 0 and $modalidadcarrera == 200)



	  {



	     echo '<script language="JavaScript">alert("Debe seleccionar un Plan de estudios");



		        history.go(-1);</script>';  



         exit();



	  }  



    else



	  if ($_POST['planestudio'] == 0 and $modalidadcarrera <> 200)



	  {



	   $_POST['planestudio'] = 1;	  



	  }



    for($i = 1; $i < $w ; $i++)



	 {



	   if ($_POST['estudiante'.$i] <> "")



	    {



		   $query_estudiante = "SELECT * from estudiantedocumento 

           where numerodocumento = '".$_POST['documento'.$i]."'";

		   $estudiante = mysql_query($query_estudiante, $sala) or die("$query_data1".mysql_error());

		   $totalRows_estudiante = mysql_num_rows($estudiante);

	  	   $row_estudiante = mysql_fetch_assoc($estudiante);



		 if (! $row_estudiante )

		  {  

		  /* $query_insestudiantedocumento = "INSERT INTO estudiantedocumento(idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechainicioestudiantedocumento, fechavencimientoestudiantedocumento) 

		   VALUES(0, '".$_POST['estudiante'.$i]."', '".$_POST['tipo'.$i]."', '".$_POST['documento'.$i]."', '".$_POST['expedido'.$i]."', '".date("Y-m-d G:i:s",time())."', '2999-12-31')"; 

		  // echo "$query_insestudiantedocumento <br>";

		  $insestudiantedocumento = mysql_db_query($database_sala,$query_insestudiantedocumento) or die("$query_insestudiantedocumento".mysql_error());

		   */

		   }

		 

		  $query_estudiante1 = "SELECT * from estudiante 

          where idestudiantegeneral = '".$_POST['estudiante'.$i]."'

		  and codigocarrera = '$carrera'";

		 //echo $query_data;

		 //exit();

		  $estudiante1 = mysql_query($query_estudiante1, $sala) or die(" $query_estudiante1".mysql_error());

		  $totalRows_estudiante1 = mysql_num_rows($estudiante1);

		  $row_estudiante1 = mysql_fetch_assoc($estudiante1);

		 

		 if (!$row_estudiante1)

		 {		 

		 /* $query_insestudiantecarrera = "INSERT INTO estudiante(codigoestudiante, idestudiantegeneral, codigocarrera, semestre, numerocohorte, codigotipoestudiante, codigosituacioncarreraestudiante, codigoperiodo, codigojornada) 

		  VALUES(0,'".$_POST['estudiante'.$i]."', '$carrera','1', '1', '10', '107', '".$row_periodo['codigoperiodo']."','01')"; 

		  //echo "$query_insestudiantecarrera <br>";

		  $insestudiantecarrera = mysql_db_query($database_sala,$query_insestudiantecarrera) or die("query_insestudiantecarrera".mysql_error());

		  $codigoestudiantecarrera = mysql_insert_id();*/

		 }

		else

		 {

		   $codigoestudiantecarrera = $row_estudiante1['codigoestudiante'];

		 } 

		$query_dataestudianteplan = "select * 

		from planestudioestudiante pee, planestudio p 

		where pee.codigoestudiante = '$codigoestudiantecarrera'

		and p.idplanestudio = pee.idplanestudio";

		$dataestudianteplan = mysql_query($query_dataestudianteplan, $sala) or die("$query_dataestudiante".mysql_error());

		$row_dataestudianteplan = mysql_fetch_assoc($dataestudianteplan);

		$totalRows_dataestudianteplan = mysql_num_rows($dataestudianteplan);		

		//echo $query_dataestudianteplan;

		///exit();

		if($totalRows_dataestudianteplan == "")

		 {

			$query_insplanestudioestudiante = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante) 

    		VALUES('".$_POST['planestudio']."', '$codigoestudiantecarrera', '".date("Y-m-d")."', '".date("Y-m-d")."', '2999-12-31', '101')"; 

			//echo "<br>".$query_insplanestudioestudiante."<br>";

			//exit();

			$insplanestudioestudiante = mysql_query($query_insplanestudioestudiante,$sala); 

		 }

		else

		 {

			$query_planestudioestudiante = "UPDATE planestudioestudiante 

			SET idplanestudio='".$_POST['planestudio']."', fechaasignacionplanestudioestudiante='".date("Y-m-d")."'

			WHERE codigoestudiante = '$codigoestudiantecarrera'"; 

			//echo "<br>".$query_planestudioestudiante."<br>";

			//exit();

			$planestudioestudiante = mysql_query($query_planestudioestudiante,$sala); 

		 }	

		

		 $sql = "insert into historicosituacionestudiante(idhistoricosituacionestudiante,codigoestudiante,codigosituacioncarreraestudiante,codigoperiodo,fechahistoricosituacionestudiante,fechainiciohistoricosituacionestudiante,fechafinalhistoricosituacionestudiante,usuario)";

		 $sql.= "VALUES('0','".$codigoestudiantecarrera."','107','".$row_periodo['codigoperiodo']."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."')"; 	

		 $result = mysql_query($sql,$sala);		

		 $sql1 = "insert into historicotipoestudiante(idhistoricotipoestudiante,codigoestudiante,codigotipoestudiante,codigoperiodo,fechahistoricotipoestudiante,fechainiciohistoricotipoestudiante,fechafinalhistoricotipoestudiante,usuario,iphistoricotipoestudiante)";

		 $sql1.= "VALUES('0','".$codigoestudiantecarrera."','10','".$row_periodo['codigoperiodo']."','".$fechahoy."','".$fechahoy."','2999-12-31','".$usuario."','$ip')"; 	

		 $result1 = mysql_query($sql1,$sala);	

				

		   

		   $query_estadoestudiante ="UPDATE estudiante e,inscripcion i,estudiantecarrerainscripcion ec

		   SET i.codigosituacioncarreraestudiante = '107',

		   e.codigosituacioncarreraestudiante = '107'

		   WHERE i.idestudiantegeneral  = e.idestudiantegeneral

		   AND ec.codigocarrera = e.codigocarrera 

		   AND i.idinscripcion = ec.idinscripcion

		   AND e.codigoestudiante = '$codigoestudiantecarrera'"; 

		   $estadoestudiante = mysql_db_query($database_sala,$query_estadoestudiante) or die("$query_estadoestudiante".mysql_error());

 

		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=aspirantesinscritos.php'>";



		}



	 } 



   }



?>



</form>



