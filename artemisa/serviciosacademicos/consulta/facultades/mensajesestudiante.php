<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
         
require_once('../../Connections/sala2.php');  
session_start();
$carrera = $_SESSION['codigofacultad'];
//echo "<br>$carrera aca";
$usuario = $_SESSION['MM_Username'];
//$carrera = 100;
//$usuario = "adminmedicina";

$documento = 0;
mysql_select_db($database_sala, $sala);
$query_modalidad = "SELECT * 
                    FROM dirigidomensaje 
					where codigodirigidomensaje = '100'
					order by 1";
//echo $query_modalidad;
$modalidad = mysql_query($query_modalidad, $sala) or die(mysql_error());
$row_modalidad = mysql_fetch_assoc($modalidad);
$totalRows_modalidad = mysql_num_rows($modalidad);
?>
<html>
<head>
<title>Mensajes</title>
</head>
<script language="javascript">
function enviar()
			{
				document.form1.submit();
			}
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: xx-small;
}
.Estilo2 {
	font-size: x-small;
	font-weight: bold;
}
.Estilo3 {
	font-size: 9;
	font-weight: bold;
}
.Estilo5 {font-size: 9}
.Estilo6 {font-size: x-small}
-->
</style>
<body>
<form action="mensajesestudiante.php" method="post" name="form1" class="Estilo1">
 <p align="center" class="Estilo2">MENSAJES</p>
 <table width="40%"  border="1" align="center" cellpadding="2" bordercolor="#003333">
   <tr>
     <td width="51%" bgcolor="#C5D5D6"><div align="center"><span class="Estilo3">Mensaje Dirigido a: </span></div></td>
     <td width="49%"><span class="Estilo5">
       <select name="modalidad" id="modalidad" onChange="enviar()">
         <option value="0" <?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>
         <?php
do {  
?>
         <option value="<?php echo $row_modalidad['codigodirigidomensaje']?>"<?php if (!(strcmp($row_modalidad['codigodirigidomensaje'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombredirigidomensaje']?></option>
         <?php
} while ($row_modalidad = mysql_fetch_assoc($modalidad));
  $rows = mysql_num_rows($modalidad);
  if($rows > 0) {
      mysql_data_seek($car, 0);
	  $row_modalidad = mysql_fetch_assoc($modalidad);
  }
?>
       </select>
     </span></td>
   </tr>
   <?php 
   if ($_POST['modalidad'] <> 0)
     { // if    
         if ($_POST["fecha1"] == "")
		   {
			 $_POST["fecha1"] = date("Y-m-d");
		   }				
         if ($_POST["fecha2"] == "")
		   {
			 $_POST["fecha2"] = date("Y-m-d");
		   }
?>   
   <tr>
     <td><span class="Estilo5"><strong>Fecha Inicial:</strong><input type="text" name="fecha1" size="8" value="<?php echo $_POST["fecha1"];?>">
     </span></td>
     <td><span class="Estilo5"><strong>Fecha Final:</strong><input type="text" name="fecha2" size="8" value="<?php echo $_POST["fecha2"];?>">
     </span></td>
   </tr>
   <tr>
     <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="Estilo5"><strong>Si el mensaje es para toda la Facultad deje el campo <span class="Estilo6">Documento</span> en blanco </strong></div></td>
   </tr>
   <tr>
     <td colspan="2"><p align="center" class="Estilo5"><strong>Digite el Documento<?php 
	   /*if ($_POST['modalidad'] == 100)
	     {
		   echo "Código :";          
         } 
		else
		 {
		   echo "No Documento :";
		 } */
		 ?></strong>
	   <input type="text" name="documento" value="<?php echo $_POST["documento"];?>">
     </p>
      <p align="center" class="Estilo5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="tipomensaje" type="radio" value="1">
        <strong> Nuevo Mensaje&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
         <input name="tipomensaje" type="radio" value="2">
         Editar</strong> <strong>Mensaje</strong> 
      </p></td>
   </tr>
   <tr>
    <?php 
	//if ($_POST['tipomensaje'] == "")
	 // {
	?> 
	 <td colspan="2"><div align="center" class="Estilo5">
     <input type="submit" name="consultar" value="Consultar">
	 </div></td>
    <?php 
	 // }
	?>  
	</tr>
<?php 
 } // if
$banderaexiste = 0;
if ($_POST['consultar'])
  {
  if ($_POST['modalidad'] == 100 and $_POST["documento"] <> "")
	   { // if 1
	    mysql_select_db($database_sala, $sala);
		
		$documentoestudiante = $_POST["documento"];
		$query_estudiantecodigo = "select e.codigoestudiante
		from estudiantedocumento ed, estudiante e
		where ed.idestudiantegeneral = e.idestudiantegeneral
		and ed.numerodocumento = '$documentoestudiante'
		and e.codigocarrera = '$carrera'";
		//echo $query_estudiantecodigo;
		//exit();
		$estudiantecodigo = mysql_query($query_estudiantecodigo, $sala) or die("$query_estudiantedocumento".mysql_error());
		$row_estudiantecodigo = mysql_fetch_assoc($estudiantecodigo);
		$codigoestudiante = $row_estudiantecodigo['codigoestudiante'];			  
	
		$query_estudiante = "SELECT * 
		                     FROM estudiante 
							 where codigoestudiante = '$codigoestudiante'
							 and codigocarrera = '$carrera'";
		//echo $query_estudiante;
		//exit();
		$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
		$row_estudiante = mysql_fetch_assoc($estudiante);
		$totalRows_estudiante = mysql_num_rows($estudiante);
		if (!$row_estudiante)
		  {
		   echo '<script language="JavaScript">alert("Estudiante no existe")</script>';		      
		   $banderaexiste = 1; 
		  } 	   
	     else
		  {
		    $documento = $_POST["documento"];	   
		  }
	   
	   } // if 1 
	 
	 if ($_POST['modalidad'] == 200 and $_POST["documento"] <> "")
	   {
	     
		mysql_select_db($database_sala, $sala);
		$query_estudiante = "SELECT * 
		                     FROM docente
							 where numerodocumento = '".$_POST["documento"]."'";
		$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
		$row_estudiante = mysql_fetch_assoc($estudiante);
		$totalRows_estudiante = mysql_num_rows($estudiante);
		if (!$row_estudiante)
		  {
		   echo '<script language="JavaScript">alert("Docente no existe")</script>';		       
	       $banderaexiste = 1; 
		  } 	   
	    else
		  {
		    $documento = $_POST["documento"];		  
		  }
	   }
}  //// if consultar

if ($_POST['tipomensaje'] == 1 and $banderaexiste == 0)
  {
?>	   
   <tr>
     <td colspan="2"><div align="center" class="Estilo5">
         <strong>Asunto:</strong> <input name="asuntomensaje" type="text" value="<?php echo $_POST['asuntomensaje'];?>" size="50">
       <br>
      <strong>Mensaje:</strong><br>
	   <textarea name="mensaje" cols="50" rows="8"><?php echo $_POST["mensaje"];?></textarea>
     </div></td>
   </tr>
  
 <?php 
   } // if $_POST['tipomensaje']
 else
  if ($_POST['tipomensaje'] == 2 and $banderaexiste == 0)
   { //  if ($_POST['tipomensaje'] == 2 and $banderaexiste == 0)
      if ($_POST['modalidad'] == 100 and $_POST["documento"] <> "")
	    {
	  
			$documentoestudiante = $_POST["documento"];
			$query_estudiantecodigo = "select e.codigoestudiante
			from estudiantedocumento ed, estudiante e
			where ed.idestudiantegeneral = e.idestudiantegeneral
			and ed.numerodocumento = '$documentoestudiante'
			and e.codigocarrera = '$carrera'";
			$estudiantecodigo = mysql_query($query_estudiantecodigo, $sala) or die("$query_estudiantedocumento".mysql_error());
			$row_estudiantecodigo = mysql_fetch_assoc($estudiantecodigo);
			$codigoestudiante = $row_estudiantecodigo['codigoestudiante'];			  
	
			$query_estudiantemensaje = "SELECT * 
									 FROM mensaje
									 where codigoestudiante = '$codigoestudiante'
									 and fechainiciomensaje >= '".$_POST["fecha1"]."'  
									 and fechafinalmensaje <= '".$_POST["fecha2"]."'
									 and codigocarrera = '$carrera'
									 order by 3 desc";
			//echo $query_estudiantemensaje;
			//exit();
			$estudiantemensaje = mysql_query($query_estudiantemensaje, $sala) or die(mysql_error());
			$row_estudiantemensaje = mysql_fetch_assoc($estudiantemensaje);
			$totalRows_estudiantemensaje = mysql_num_rows($estudiantemensaje);    
            if (!$row_estudiantemensaje)
			  {
			    echo '<script language="JavaScript">alert("No tiene mensajes para editar")</script>';		   
			  }     
	    }
	 ////////////////////
	 else
	  if ($_POST['modalidad'] == 100 and $_POST["documento"] == "") 
	   { 
	       $query_estudiantemensaje = "SELECT * 
									 FROM mensaje
									 where codigoestudiante = '1'
									 and codigodirigidomensaje = '".$_POST['modalidad']."'
									 and fechainiciomensaje >= '".$_POST["fecha1"]."'  
									 and fechafinalmensaje <= '".$_POST["fecha2"]."'
									 and codigocarrera = '$carrera'
									 order by 3 desc";
			//echo $query_estudiantemensaje; 
			$estudiantemensaje = mysql_query($query_estudiantemensaje, $sala) or die(mysql_error());
			$row_estudiantemensaje = mysql_fetch_assoc($estudiantemensaje);
			$totalRows_estudiantemensaje = mysql_num_rows($estudiantemensaje);    
            if (!$row_estudiantemensaje)
			  {
			    echo '<script language="JavaScript">alert("No tiene mensajes para editar")</script>';		   
			  }     
	   
	   
	   }
  /////////////////////////	 
	 if ($_POST['modalidad'] == 200 and $_POST["documento"] <> "")
	    {
		   $query_estudiantemensaje = "SELECT * 
									 FROM mensaje
									 where numerodocumento = '".$_POST["documento"]."'
									 and fechainiciomensaje >= '".$_POST["fecha1"]."'  
									 and fechafinalmensaje  <= '".$_POST["fecha2"]."'
									 order by 3 desc";
			$estudiantemensaje = mysql_query($query_estudiantemensaje, $sala) or die(mysql_error());
			$row_estudiantemensaje = mysql_fetch_assoc($estudiantemensaje);
			$totalRows_estudiantemensaje = mysql_num_rows($estudiantemensaje);    
		  if (!$row_estudiantemensaje)
			  {
			    echo '<script language="JavaScript">alert("No tiene mensajes para editar")</script>';		   
			  }	
		}
      else
	    if ($_POST['modalidad'] == 200 and $_POST["documento"] == "")
	     {
		   
		     $query_estudiantemensaje = "SELECT * 
									 FROM mensaje
									 where numerodocumento = '1'
									 and codigodirigidomensaje = '".$_POST['modalidad']."'
									 and fechainiciomensaje >= '".$_POST["fecha1"]."'  
									 and fechafinalmensaje  <= '".$_POST["fecha2"]."'
									 and codigocarrera = '$carrera'
									 order by 3 desc";
			$estudiantemensaje = mysql_query($query_estudiantemensaje, $sala) or die(mysql_error());
			$row_estudiantemensaje = mysql_fetch_assoc($estudiantemensaje);
			$totalRows_estudiantemensaje = mysql_num_rows($estudiantemensaje);    
		    if (!$row_estudiantemensaje)
			  {
			    echo '<script language="JavaScript">alert("No tiene mensajes para editar")</script>';		   
			  }		
		 }
	
	 if ($row_estudiantemensaje <> "")
	   {
	     $w=1;
		  do {
		      //echo $row_estudiantemensaje['idmensaje'];
			?>
	 <tr>
     <td colspan="2"><div align="center" class="Estilo5"><strong>Mensaje:</strong>       
       <input type="checkbox" name="idmensajes<?php echo $w?>"  value="<?php echo $row_estudiantemensaje['idmensaje']?>" onClick="HabilitarGrupo('mensaje<?php echo $w?>')">
         
	  <br>
	  
	  <?php echo '<textarea name="mensaje'.$w.'" cols="50" rows="8" disabled>'.$row_estudiantemensaje['descripcionmensaje'].'</textarea>';?>
     </div></td>
   </tr>  
		<?php   
	         $w++;
		   }while($row_estudiantemensaje = mysql_fetch_assoc($estudiantemensaje));
	   }   
   }  //  if ($_POST['tipomensaje'] == 2 and $banderaexiste == 0)
 ?> 
   <tr>
     <?php if ($_POST['tipomensaje'] <> "")
	   {?> 
		 <td colspan="2"><div align="center" class="Estilo5">
		   <input type="submit" name="guardar" value="Enviar">
		 </div></td>
     <?php }?> 
	</tr>		
 </table>
 
<?php   
$banderaguardar = 0;
$numerodocumento = 0;
if ($_POST["guardar"])
  {	
	if (!checkdate(substr($_POST["fecha1"],5,2),substr($_POST["fecha1"],8,2),substr($_POST["fecha1"],0,4)))  
       {
	   echo '<script language="JavaScript">alert("La Fecha Inicial es incorrecta")</script>';		   
	    $banderaguardar = 1; 
	    echo '<script language="JavaScript">history.go(-1)</script>';		   
	   }  
     if (!checkdate(substr($_POST["fecha2"],5,2),substr($_POST["fecha2"],8,2),substr($_POST["fecha2"],0,4)))  
       {
	     echo '<script language="JavaScript">alert("La Fecha Final es incorrecta")</script>';		   
	     echo '<script language="JavaScript">history.go(-1)</script>';	 
		$banderaguardar = 1;
	   }  
	  if ($_POST["fecha1"] > $_POST["fecha2"])  
       {
	     echo '<script language="JavaScript">alert("Fecha Inicial no puede ser mayor a la Fecha Final")</script>';		   
	     echo '<script language="JavaScript">history.go(-1)</script>';	
		 $banderaguardar = 1;
	   }    
	  if ($_POST["asuntomensaje"] == "" and $_POST['indicadorradio'] == 1)  
       {
	     echo '<script language="JavaScript">alert("Debe digitar un asunto")</script>';		   
	     echo '<script language="JavaScript">history.go(-1)</script>';	
		 $banderaguardar = 1;
	   }    
	 
	 if ($banderaguardar == 0)
	   {
	    require('mensajeestudianteguardar.php');
	   }
  }
?>
<input type="hidden" name="indicadorradio" value="<?php echo $_POST['tipomensaje'];?>">
<input type="hidden" name="totalmensajes" value="<?php echo $w;?>">
</form>
</body>
</html>
<script language="javascript">
function HabilitarGrupo(seleccion)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		
		if(elemento.type == "textarea")
		{
			var reg = new RegExp("^"+seleccion);
			//elemento.name.search(regexp)
			//elemento.title == seleccion 	
			if(!elemento.name.search(reg))
			{
			  if(elemento.disabled == true)
			   {
				elemento.disabled = false;				
			   }
			  else
			   {
			    elemento.disabled = true;	
			   }
			}
		  	
		}
	}
}
</script>