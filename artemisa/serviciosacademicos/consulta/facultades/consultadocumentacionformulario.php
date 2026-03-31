<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
	session_start();
$usadopor = "facultad";
if ($_POST['regresar'])
 { // if
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=".$usadopor."'>";
   exit();
 }
   if (isset($_SESSION['codigo']))
	  {
    	$codigoestudiante = $_SESSION['codigo'];	
      }
  else
	if (isset($_GET['codigo']))
	  {
    	$codigoestudiante = $_GET['codigo'];	
      }
	else
	if (isset($_POST['codigo']))
	  {
	    $codigoestudiante = $_POST['codigo'];	
	  }		
if (isset($_SESSION['codigofacultad']))
  {
   $carrera = $_SESSION['codigofacultad']; // SESSION
  }
else
  if (isset($_GET['facultad']))
  {
   $carrera = $_GET['facultad'];
  }

mysql_select_db($database_sala, $sala);
/*$query_periodo = "SELECT * FROM periodo where codigoestadoperiodo = '3'";
$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
$row_periodo = mysql_fetch_assoc($periodo);
$totalRows_periodo = mysql_num_rows($periodo);

if ($row_periodo <> "")
  {
   $periodoactual = $row_periodo['codigoperiodo'];
  }
else
  {*/
    mysql_select_db($database_sala, $sala);
        /*
         * Caso 108540.
         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
         * Diciembre 26 del 2018
         * Ajuste de consulta de periodo activo para la colsulta de documentacion de la opción estudiante.
         */
	$query_periodo = "SELECT p.codigoperiodo, p.nombreperiodo ".
        " FROM ".
            " periodo p ".
        " WHERE ".
            " p.codigoestadoperiodo IN ('1', '3', '4') ".
        " ORDER BY ".
            " p.codigoestadoperiodo ASC ".
        " LIMIT 1";
        //End Caso 108540.
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);

    $periodoactual = $row_periodo['codigoperiodo'];    
 // }

	$query_salud = "SELECT * FROM empresasalud
                    WHERE codigotipoempresasalud = '004'
					order by 2";	
	$salud  = mysql_query($query_salud , $sala) or die(mysql_error());
	$row_salud  = mysql_fetch_assoc($salud);
	$totalRows_salud  = mysql_num_rows($salud);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form action="consultadocumentacionformulario.php" method="post" name="form1" class="Estilo6">
<p align="center" class="Estilo3">DOCUMENTACI&Oacute;N ESTUDIANTE<br>
 </p>
<div align="center">
<?php
        /*
         * Caso 108540.
         * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
         * Diciembre 26 del 2018
         * Ajuste de consulta de periodo activo para la colsulta de documentacion de la opción estudiante.
        */
	$base= "select * from estudiante,carrera,periodo,estadoperiodo,situacioncarreraestudiante,tipoestudiante, estudiantegeneral ".
	" where ".
        " (( periodo.codigoperiodo = ".$periodoactual.") ".
	" and(estudiante.codigoestudiante = '".$codigoestudiante."') ".
	" and(estudiante.codigocarrera=carrera.codigocarrera) ".
	" and(estudiante.codigosituacioncarreraestudiante=situacioncarreraestudiante.codigosituacioncarreraestudiante)".
	" and(estudiante.codigotipoestudiante=tipoestudiante.codigotipoestudiante)".
	" and(estudiante.idestudiantegeneral=estudiantegeneral.idestudiantegeneral))";
       //End Caso 108540.
	$sol=mysql_db_query($database_sala,$base) or die("No se deja seleccionar");
	$totalRows1 = mysql_num_rows($sol);
    if($totalRows1 != "")
	{
		$row=mysql_fetch_array($sol);
		$carrera= $row['codigocarrera'];
		$periodo=$row['codigoperiodo'];

?>
</div>

  <table height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333" width="700">
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo2" align="center">Estudiante</td>
      <td colspan="2" class="Estilo1" align="center"><?php echo $row['nombresestudiantegeneral'];?>&nbsp;&nbsp;<?php echo $row['apellidosestudiantegeneral'];?></td>
      <td bgcolor="#C5D5D6" class="Estilo2" align="center">Documento</td>
      <td colspan="2" align="center" class="Estilo1"><?php echo $row['numerodocumento'];?></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo2" align="center">Carrera</td>
      <td colspan="2" class="Estilo1" align="center"><?php echo $row['nombrecarrera'];?></td>
      <td colspan="1" bgcolor="#C5D5D6" class="Estilo2"align="center">Tipo de Estudiante</td>
      <td colspan="2" align="center" class="Estilo1"><?php echo $row['nombretipoestudiante']; ?></td>
    </tr>
    <tr>
      <!-- <td bgcolor="#C5D5D6"><div align="center" class="Estilo15"><strong>Periodo </strong></div></td>
      <td width="49"><div align="center" class="Estilo15"><?php $periodo=$row['codigoperiodo']; echo $periodo;?></div></td>
      -->
	  <td bgcolor="#C5D5D6" class="Estilo2" align="center">Semestre</td>
      <td align="center" class="Estilo1"><?php echo $row['semestre'];?></td>
      <td bgcolor="#C5D5D6" align="center" class="Estilo2">Situaci&oacute;n Acad&eacute;mica</td>
      <td align="center" class="Estilo1"><?php echo $row['nombresituacioncarreraestudiante'];?></td>
      <td bgcolor="#C5D5D6"align="center" class="Estilo2">Fecha</td>
      <td align="center" class="Estilo1"><?php echo date("Y-m-d",time());?></td>
    </tr>
  </table>
  <table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr class="Estilo2">
      <td align="center" bgcolor="#C5D5D6">Nombre Documento</td>
      <td align="center" bgcolor="#C5D5D6">Fecha Vencimiento</td>
      <td align="center" bgcolor="#C5D5D6">Documento</td>
      <td align="center" bgcolor="#C5D5D6">Cambio Estado</td>
    </tr>
    <?php
		mysql_select_db($database_sala, $sala);
		$query_documentos = "SELECT *
		                     FROM documentacion d,documentacionfacultad df
							 where d.iddocumentacion = df.iddocumentacion
							 and df.codigocarrera = '$carrera'
							 and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
							 and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
							 AND (df.codigogenerodocumento = '300'
							 OR df.codigogenerodocumento = '".$row['codigogenero']."')";
		//echo $query_documentos;
		//exit();
		$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
		$row_documentos = mysql_fetch_assoc($documentos);
		$totalRows_documentos = mysql_num_rows($documentos);
		$doc = 1;
		  do
			{
			   mysql_select_db($database_sala, $sala);
				$query_documentosestuduante ="SELECT distinct d.idempresasalud,fechavencimientodocumentacionestudiante,codigotipovencimientodocumento,nombretipodocumentovencimiento
				                     FROM documentacionestudiante d,documentacionfacultad df,tipovencimientodocumento t
								     where d.codigoestudiante = '".$codigoestudiante."'
									 and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'	
									 AND d.codigotipodocumentovencimiento = '100'
									 and d.iddocumentacion = df.iddocumentacion									 
									 AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento";
				 //echo  $query_documentosestuduante,"<br>";AND d.codigoperiodo = '$periodo'
				$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
				$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
				$totalRows_documentosestuduante  = mysql_num_rows($documentosestuduante );	
			  
			  echo '<tr>';
			  if ($row_documentos['iddocumentacion'] == 20)
			    { // if 100
			     echo '<td><div align="center" class="Estilo1">E.P.S '; ?>
				 <select name="eps" id="eps">
              <option value="0" <?php if (!(strcmp(0,$row_documentosestuduante['idempresasalud']))) {echo "SELECTED";} ?>>E.P.S</option>
              <?php
					do {
					?>
					 <option value="<?php echo $row_salud['idempresasalud']?>"<?php if (!(strcmp($row_salud['idempresasalud'],$row_documentosestuduante['idempresasalud']))) {echo "SELECTED";} ?>><?php echo $row_salud['nombreempresasalud']?></option>
				    <?php
					} while ($row_salud = mysql_fetch_assoc($salud));
					  $rows = mysql_num_rows($salud);
					  if($rows > 0) 
					  {
						  mysql_data_seek($salud, 0);
						  $row_salud  = mysql_fetch_assoc($salud);
					  }
					?>
    </select>

				<?php
				   echo '</td>';
				} // if 100
			   else
				{
				 echo '<td><div align="center" class="Estilo1">'.$row_documentos['nombredocumentacion'].'</div></td>';
		        }

			  if ($row_documentosestuduante <> "")
			   { //////////// 1
			     if ($row_documentos['codigotipodocumentacionfacultad'] == 200)
				  {				   
				       echo '<td><div align="center" class="Estilo1">Válido Hasta&nbsp;<input type="text" name="fecha'.$doc.'" size="8" value='.$row_documentosestuduante['fechavencimientodocumentacionestudiante'].'></div></td>';			     
				  }
                                  elseif($row_documentos['codigotipodocumentacionfacultad'] == 100 && in_array($row_documentos['iddocumentacion'],array('61','62','63','64','65')))
                                  {
                                     //echo '<td><div align="center" class="Estilo15">Fecha Entrega&nbsp;<input type="text" name="fecha'.$doc.'" size="8" value='.$row_documentosestuduante['fechavencimientodocumentacionestudiante'].'>&nbsp;</div></td>';
                                        echo '<td><div align="center" class="Estilo1">Fecha Vacunación&nbsp;<input type="text" name="fecha' . $doc . '" size="8" value=' . $row_documentosestuduante['fechavencimientodocumentacionestudiante'] . '></div></td>';
                                  }
				 else
				  {					
					//echo '<td><div align="center" class="Estilo15">Fecha Entrega&nbsp;<input type="text" name="fecha'.$doc.'" size="8" value='.$row_documentosestuduante['fechavencimientodocumentacionestudiante'].'>&nbsp;</div></td>';
				     echo '<td><div align="center" class="Estilo1">Válido Toda la carrera&nbsp;<input type="hidden" name="fecha'.$doc.'" size="8" value='.$row_documentosestuduante['fechavencimientodocumentacionestudiante'].'>&nbsp;</div></td>';
				  }
				 if ($row_documentos['codigotipodocumentacionfacultad'] == 200 and $row_documentosestuduante['fechavencimientodocumentacionestudiante'] < date("Y-m-d"))
				  {					   
					$base="update documentacionestudiante set  
			        codigotipodocumentovencimiento = '200'				   
			        where codigoestudiante = '".$codigoestudiante."'
			        and iddocumentacion = '".$row_documentos['iddocumentacion']."'";           
		  			 // echo $base;
                    $sol=mysql_db_query($database_sala,$base);	 
				    echo '<td><div align="center" class="Estilo1"><input type="checkbox" name="documento'.$doc.'" value="'.$row_documentos['iddocumentacion'].'"></div></td>';
				  	echo "<td><div align='center' class='Estilo2'><a href='consultadocumentacionformulario.php?estado=".$row_documentosestuduante['codigotipovencimientodocumento']."&codigo=".$codigoestudiante."&iddocument=".$row_documentos['iddocumentacion']."'>".$row_documentosestuduante['nombretipodocumentovencimiento']."</a>&nbsp;</div></td>";
				  }
				 else
				  {
				     echo '<td><div align="center" class="Estilo1"><input type="checkbox" name="documento'.$doc.'" value="'.$row_documentos['iddocumentacion'].'" checked></div></td>';
				  	 echo "<td><div align='center' class='Estilo2'><a href='consultadocumentacionformulario.php?estado=".$row_documentosestuduante['codigotipovencimientodocumento']."&codigo=".$codigoestudiante."&iddocument=".$row_documentos['iddocumentacion']."'>".$row_documentosestuduante['nombretipodocumentovencimiento']."</a>&nbsp;</div></td>";
			      }		
			   }
			  else ////////// 1
			   {
				  if ($row_documentos['codigotipodocumentacionfacultad'] == 200)
				  {
				   if ($_POST["fecha".$doc] == "")
				   {
				     $_POST["fecha".$doc] = $row_periodo['fechavencimientoperiodo'];
				   }
				   echo '<td><div align="center" class="Estilo1">Válido Hasta&nbsp;<input type="text" name="fecha'.$doc.'" size="8" value='.$_POST["fecha".$doc].'></div></td>';
				  }
                                  elseif ($row_documentos['codigotipodocumentacionfacultad'] == 100 && in_array($row_documentos['iddocumentacion'],array('61','62','63','64','65')))
				  {
				   /*if ($_POST["fecha".$doc] == "")
				   {
				     $_POST["fecha".$doc] = $row_periodo['fechavencimientoperiodo'];
				   }*/
				   echo '<td><div align="center" class="Estilo1">Fecha Vacunación&nbsp;<input type="text" name="fecha'.$doc.'" size="8" value='.$_POST["fecha".$doc].'></div></td>';
				  }
				 else
				  {
				   if ($_POST["fecha".$doc] == "")
				   {
				     $_POST["fecha".$doc] = "2999-12-31";
				   }
				    echo '<td><div align="center" class="Estilo1">Válido Toda la carrera</div></td>';
				  }
				echo '<td><div align="center" class="Estilo1"><input type="checkbox" name="documento'.$doc.'" value="'.$row_documentos['iddocumentacion'].'"></div></td>';
			   echo "<td><div align='center' class='Estilo2'><a href='consultadocumentacionformulario.php?estado=".$row_documentosestuduante['codigotipovencimientodocumento']."&codigo=".$codigoestudiante."&iddocument=".$row_documentos['iddocumentacion']."'>".$row_documentosestuduante['nombretipodocumentovencimiento']."</a>&nbsp;</div></td>";
			  }
			  echo '</tr>';
			  $doc ++;

			}while($row_documentos = mysql_fetch_assoc($documentos));

?>
    <tr>
      <td colspan="7" align="center"><input type="submit" name="guardar" value="Guardar">
  &nbsp;&nbsp;
        <input name="regresar" type="submit" value="Regresar"></td>
    </tr>
  </table>
  <p>

    <input type="hidden" name="codigo" value=<?php echo $codigoestudiante;?>>

</p>
</form>
<?php
	}
$fechaincorecta = 0;
$fechamenor = 0;
$validaeps=0;
if ($_POST['guardar'])
 { // if 1
   for($i;$i<$doc;$i++)
    { // for    
	  if ($_POST["documento".$i] <> "")
	    { // if 2
	     $ano = substr($_POST["fecha".$i],0,4); 
		 $mes = substr($_POST["fecha".$i],5,2);
		 $dia = substr($_POST["fecha".$i],8,2);

		 if (! checkdate($mes,$dia,$ano))  
		  {
		    $fechaincorecta = 1;
		  }
		 if ($_POST["fecha".$i] < date("Y-m-d"))
		  {
		   $fechamenor = 1;
		  }		
		 if ($_POST["documento".$i] == 20 and $_POST['eps'] == 0)
		   {
		    $validaeps=1; 
		   }		
		} // if 2	
	} // for

     if ($fechaincorecta == 1)
      {
	    echo '<script language="JavaScript">alert("La Fecha Digitada es Incorrecta")</script>';			
	  }
     /*else
	   if ($fechamenor == 1)
      {
	    echo '<script language="JavaScript">alert("La Fecha Digitada no puede ser menor a la actual")</script>';
	  } */	
	else
	   if ($validaeps == 1)
      {
	    echo '<script language="JavaScript">alert("Seleccione una EPS")</script>';			
	  }
	else
	 {
      $codigo = $codigoestudiante;
	  require('consultadocumentacionoperacion.php');
	 }
 } // if 1
if (isset($_GET['iddocument']))
{
  if($_GET['estado'] == 100)
    {
	  $base="update documentacionestudiante set  
	  codigotipodocumentovencimiento = '200'				   
	  where codigoestudiante = '".$codigoestudiante."'
	  and iddocumentacion = '".$_GET['iddocument']."'";           
	 //echo $base;
     $sol=mysql_db_query($database_sala,$base);	
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultadocumentacionformulario.php?codigo=".$codigoestudiante."'>";
	}
  else
    {
	  $base="update documentacionestudiante set  
	 codigotipodocumentovencimiento = '100'				   
     where codigoestudiante = '".$codigoestudiante."'
     and iddocumentacion = '".$_GET['iddocument']."'";           
	 //echo $base;
     $sol=mysql_db_query($database_sala,$base);	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultadocumentacionformulario.php?codigo=".$codigoestudiante."'>";
	}
}
?>
