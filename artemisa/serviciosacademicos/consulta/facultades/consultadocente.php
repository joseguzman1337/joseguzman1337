<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/conexion.php');	
	

mysql_select_db($database_conexion, $conexion);
$query_contratosdocentes = "SELECT * FROM tipocontrato";
$contratosdocentes = mysql_query($query_contratosdocentes, $conexion) or die(mysql_error());
$row_contratosdocentes = mysql_fetch_assoc($contratosdocentes);
$totalRows_contratosdocentes = mysql_num_rows($contratosdocentes);


mysql_select_db($database_conexion, $conexion);
$query_carrera = "SELECT * FROM facultad order by 2 asc";
$carrera = mysql_query($query_carrera, $conexion) or die(mysql_error());
$row_carrera = mysql_fetch_assoc($carrera);
$totalRows_carrera = mysql_num_rows($carrera);

mysql_select_db($database_conexion, $conexion);
$query_estudiosrealizados = "SELECT * FROM tipogrado";
$estudiosrealizados = mysql_query($query_estudiosrealizados, $conexion) or die(mysql_error());
$row_estudiosrealizados = mysql_fetch_assoc($estudiosrealizados);
$totalRows_estudiosrealizados = mysql_num_rows($estudiosrealizados);

mysql_select_db($database_conexion, $conexion);
$query_idiomas = "SELECT * FROM idioma";
$idiomas = mysql_query($query_idiomas, $conexion) or die(mysql_error());
$row_idiomas = mysql_fetch_assoc($idiomas);
$totalRows_idiomas = mysql_num_rows($idiomas);
?>

<html>
<head>
<title>Hojas de Vida</title>
<style type="text/css">
<!--
.Estilo4 {
	font-family: tahoma;
	font-size: x-small;
}
.Estilo5 {font-size: small}
.Estilo7 {font-size: x-small}
.Estilo8 {font-size: 9px}
-->
</style>
</head>
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
		window.location.reload("consultadocente.php?busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("consultadocente.php?busqueda=apellido"); 
	} 
   
    if (tipo == 4)
	{
		window.location.reload("consultadocente.php?busqueda=documento"); 
    } 
	
	if (tipo == 5)
	{
		window.location.reload("consultadocente.php?busqueda=contrato"); 
    }
	if (tipo == 6)
	{
		window.location.reload("consultadocente.php?busqueda=estudios"); 
    }
	if (tipo == 7)
	{
		window.location.reload("consultadocente.php?busqueda=sexo"); 
    }	
	
	if (tipo == 8)
	{
		window.location.reload("consultadocente.php?busqueda=idioma"); 
    }
	if (tipo == 9)
		{
			window.location.reload("consultadocente.php?busqueda=totaldocentes"); 
		}

} 

function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("consultadocente.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center">
<form name="f1" action="consultadocente.php" method="get" onSubmit="return validar(this)">
  <p>&nbsp;</p>
  <p class="Estilo4 Estilo5"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="732" border="1" bordercolor="#003333">
  <tr>
    <td width="347" class="Estilo4" bgcolor="#C5D5D6">
	<span class="Estilo7">Búsqueda por :</span>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Seleccionar</option>
		<option value="1">Nombre</option>
		<option value="2">Apellido</option>		
		<option value="4">Documento</option>
		<option value="5">Tipo de Contrato</option>
		<option value="6">Estudios</option>
		<option value="7">Sexo</option>		
		<option value="8">Idioma</option>
		<option value="9">Docentes por Facultad</option>
	</select>
	</td>
	<td width="369" class="Estilo4">&nbsp;
	<?php
		
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "Digite un Apellido : <input name='busqueda_apellido' type='text'>";
			}
			
			if($_GET['busqueda']=="documento")
			{
				echo "Digite un Número de Documento : <input name='busqueda_documento' type='text'>";
			}
			if($_GET['busqueda']=="contrato")
			{
				echo "Elija el tipo de Contrato: ";
			?>
			<select name="contratodocente" id="contratodocente">
								  <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Seleccionar</option>
								  <?php
					do {  
					?>
								  <option value="<?php echo $row_contratosdocentes['codigotipocontrato']?>"<?php if (!(strcmp($row_contratosdocentes['codigotipocontrato'], 0))) {echo "SELECTED";} ?>><?php echo $row_contratosdocentes['nombretipocontrato']?></option>
								  <?php
					} while ($row_contratosdocentes = mysql_fetch_assoc($contratosdocentes));
					  $rows = mysql_num_rows($contratosdocentes);
					  if($rows > 0) {
						  mysql_data_seek($contratosdocentes, 0);
						  $row_contratosdocentes = mysql_fetch_assoc($contratosdocentes);
					  }
					?>
          </select>	
			<?php
			}// fin contrato
			if($_GET['busqueda']=="estudios")
			{
				echo "Elija el tipo de Estudio: ";
			?>
			
			<select name="estudiosdocente" id="estudiosdocente">
			  <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Seleccionar</option>
							   <?php
					do {  
					?>
								  <option value="<?php echo $row_estudiosrealizados['codigotipogrado']?>"<?php if (!(strcmp($row_estudiosrealizados['codigotipogrado'], 0))) {echo "SELECTED";} ?>><?php echo $row_estudiosrealizados['nombretipogrado']?></option>
								  <?php
					} while ($row_estudiosrealizados = mysql_fetch_assoc($estudiosrealizados));
					  $rows = mysql_num_rows($estudiosrealizados);
					  if($rows > 0) {
						  mysql_data_seek($estudiosrealizados, 0);
						  $row_estudiosrealizados = mysql_fetch_assoc($estudiosrealizados);
					  }
					?>
            </select>			
			<?php
			}//fin estudios  
			if($_GET['busqueda']=="sexo")
			{
				echo "Sexo: ";
			?>
			  <select name="sexo" id="sexo">
			  <option value="0">Seleccionar</option>
			  <option value="M">Masculino</option>
			  <option value="F">Femenino</option>
		      </select>		
			<?php
			}//fin sexo
						
			if($_GET['busqueda']=="idioma")
			{
			  echo "Idioma: ";
			?>	
				
				<select name="idiomadocente" id="idiomadocente">
							  <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Seleccionar</option>
							  <?php
				do {  
				?>
							  <option value="<?php echo $row_idiomas['codigoidioma']?>"<?php if (!(strcmp($row_idiomas['codigoidioma'], 0))) {echo "SELECTED";} ?>><?php echo $row_idiomas['nombreidioma']?></option>
							  <?php
				} while ($row_idiomas = mysql_fetch_assoc($idiomas));
				  $rows = mysql_num_rows($idiomas);
				  if($rows > 0) {
					  mysql_data_seek($idiomas, 0);
					  $row_idiomas = mysql_fetch_assoc($idiomas);
				  }
?>
		    </select>		
<?php			
}///fin idioma     
if($_GET['busqueda']=="totaldocentes")
			{
				
				echo "Docentes por Facultad: ";
?>			  
  <select name="carreratodos" id="carreratodos">
        <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Todas las Facultades</option>
        <?php
				do {  
				?>
						<option value="<?php echo $row_carrera['codigofacultad']?>"<?php if (!(strcmp($row_carrera['codigofacultad'], 0))) {echo "SELECTED";} ?>><?php echo $row_carrera['nombrefacultad']?></option>
						<?php
				} while ($row_carrera = mysql_fetch_assoc($carrera));
				  $rows = mysql_num_rows($carrera);
				  if($rows > 0) {
					  mysql_data_seek($carrera, 0);
					  $row_carrera = mysql_fetch_assoc($carrera);
				  }
				?>
      </select> 		
<?php			
	}// fin totaldocentes
if($_GET['busqueda']=="contrato" or $_GET['busqueda']=="estudios" or $_GET['busqueda']=="sexo" or $_GET['busqueda']=="idioma")
			{
?>				
	<tr>
    <td colspan="2" align="center" class="Estilo4">Seleccione la Facultad:
      <select name="carrera" id="carrera">
        <option value="0" <?php if (!(strcmp(0, 0))) {echo "SELECTED";} ?>>Todas las Facultades</option>
        <?php
do {  
?>
        <option value="<?php echo $row_carrera['codigofacultad']?>"<?php if (!(strcmp($row_carrera['codigofacultad'], 0))) {echo "SELECTED";} ?>><?php echo $row_carrera['nombrefacultad']?></option>
        <?php
} while ($row_carrera = mysql_fetch_assoc($carrera));
  $rows = mysql_num_rows($carrera);
  if($rows > 0) {
      mysql_data_seek($carrera, 0);
	  $row_carrera = mysql_fetch_assoc($carrera);
  }
?>
      </select> 
	  </td>
  </tr>		
				
<?php			  
	}	
?>
</td>
  </tr>
  <tr>  
  	<td colspan="2" align="center" class="Estilo4"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
    mysql_select_db($database_conexion, $conexion);
  ?>
</table>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="386" align="center" class="Estilo4"><strong>Nombre Docente </strong></td>
    <td width="305" align="center" class="Estilo4"><strong>No. Documento</strong></td>
    </tr>
<?php  

  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
	
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT
					*
				FROM
					docente
				WHERE									
					  nombresdocente LIKE '$nombre%'			 
					ORDER BY 4";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	    else
		 $tipoconsulta = "Nombre";   
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		$query_solicitud = "SELECT
					*
				FROM
					docente
				WHERE	
				    apellidosdocente LIKE '$apellido%'				 
					ORDER BY apellidosdocente";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	    else
		 $tipoconsulta = "Apellido";   
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];	
		
		$query_solicitud = "SELECT
					*
				FROM
					docente
					WHERE									
					  numerodocumento LIKE '$documento%'					 
					ORDER BY apellidosdocente";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
		
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	    else
		  $tipoconsulta = "Documento";   
	}	
	
  if(isset($_GET['contratodocente']))
	{
		
	if ($_GET['carrera'] == 0)
	{
		$tipocontrato = $_GET['contratodocente']; 
		
		$query_solicitud = "SELECT distinct d.nombresdocente,d.apellidosdocente,d.numerodocumento
								FROM contratolaboral c,docente d
								WHERE codigotipocontrato = '".$tipocontrato."'
								AND c.numerodocumento = d.numerodocumento
								and codigoestadotipocontrato = 1
								ORDER BY apellidosdocente ASC";
		//echo $query_solicitud;
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	}	
 else		
	if ($_GET['carrera'] <> 0)
	
	{
		$tipocontrato = $_GET['contratodocente']; 
		$facultad = $_GET['carrera']; 
		$query_solicitud = "SELECT DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
								FROM contratolaboral c,docente d,jornadalaboral j
								WHERE codigotipocontrato = '".$tipocontrato."'
								AND j.codigofacultad = '".$facultad."'
								AND d.numerodocumento = j.numerodocumento
								AND c.numerodocumento = d.numerodocumento
								AND codigoestadotipocontrato = 1
								ORDER BY apellidosdocente ASC";
		//echo $query_solicitud;
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	}			
		if($_GET['contratodocente'] == "")
			$vacio = true;
	    else
		  $tipoconsulta = "Tipo de Contrato";   
	}//////fin contratos	
	
if(isset($_GET['estudiosdocente']))
	{
	  if ($_GET['carrera'] == 0)
	  {		
		$tipogrado = $_GET['estudiosdocente']; 
		
		$query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM historialacademico h,docente d
							WHERE codigotipogrado = '".$tipogrado."'
							AND h.numerodocumento = d.numerodocumento
							ORDER BY apellidosdocente ASC";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	   }
	else		
	 if ($_GET['carrera'] <> 0)
	  {
		$tipogrado = $_GET['estudiosdocente'];
		$facultad = $_GET['carrera']; 
		$query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM historialacademico h,docente d,jornadalaboral j
							WHERE codigotipogrado = '".$tipogrado."'
							AND j.codigofacultad = '".$facultad."'
							AND d.numerodocumento = j.numerodocumento
							AND h.numerodocumento = d.numerodocumento
							ORDER BY apellidosdocente ASC";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	   }
		
		if($_GET['estudiosdocente'] == "")
			$vacio = true;
			 else
		 $tipoconsulta = "Estidios Realizados";   
	}
	
if(isset($_GET['sexo']))
	{
	 if ($_GET['carrera'] == 0)
	  {
		$sex = $_GET['sexo']; 
		
		$query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d
							WHERE d.sexodocente = '".$sex."'							
							ORDER BY apellidosdocente ASC";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	  }
	 else		
	 if ($_GET['carrera'] <> 0)
	  { 
	    $sex = $_GET['sexo']; 
		$facultad = $_GET['carrera']; 
	  $query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d, jornadalaboral j
							WHERE d.sexodocente = '".$sex."'
							AND j.codigofacultad = '".$facultad."'
							AND d.numerodocumento = j.numerodocumento
							ORDER BY apellidosdocente ASC";
		//$res_solicitud = mysql_query($query_solicitud,$database_conexion) or die(mysql_error());
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	  }
		if($_GET['sexo'] == "")
			$vacio = true;
	    else
		 $tipoconsulta = "Sexo";   
	}		
	
	
if(isset($_GET['idiomadocente']))
	{
	 if ($_GET['carrera'] == 0)
	  {
		$idio= $_GET['idiomadocente'];
		$query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d,lengua l
							WHERE d.numerodocumento = l.numerodocumento	
							AND l.codigoidioma = '".$idio."'										
							ORDER BY apellidosdocente ASC";	
		//echo $query_solicitud;		
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	  }
	 else		
	 if ($_GET['carrera'] <> 0)
	  {  
	    $idio= $_GET['idiomadocente'];
	    $facultad = $_GET['carrera']; 
	    $query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d,lengua l,jornadalaboral j
							WHERE d.numerodocumento = l.numerodocumento								
							AND d.numerodocumento = j.numerodocumento
							AND j.codigofacultad = '".$facultad."'
							AND l.codigoidioma = '".$idio."'										
							ORDER BY apellidosdocente ASC";			
		//echo  $query_solicitud;
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);  
	  }
	  
		if($_GET['idiomadocente']== "")
			$vacio = true;
			 else
		 $tipoconsulta = "Idioma"; 		
}	
if(isset($_GET['carreratodos']))
	{
	 if ($_GET['carreratodos'] == 0)
	  {
		
		$query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d																
							ORDER BY apellidosdocente ASC";	
		//echo $query_solicitud;		
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);
	  }
	 else		
	 if ($_GET['carreratodos'] <> 0)
	  {  
	    
	    $facultad = $_GET['carreratodos']; 
	    $query_solicitud = "SELECT  DISTINCT d.nombresdocente,d.apellidosdocente,d.numerodocumento
							FROM docente d,jornadalaboral j
							WHERE d.numerodocumento = j.numerodocumento
							AND j.codigofacultad = '".$facultad."'																	
							ORDER BY apellidosdocente ASC";			
		//echo  $query_solicitud;
		$res_solicitud=mysql_db_query($database_conexion,$query_solicitud);  
	  }
	  
		if($_GET['carreratodos']== "")
			$vacio = true;
			 else
		 $tipoconsulta = "Docentes por Facultad"; 		
}	
	
$cuentaregistros = 0;	
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
					
			$est = $solicitud["apellidosdocente"]." ".$solicitud["nombresdocente"];			
			$cc = $solicitud["numerodocumento"];			
			$cuentaregistros ++;
			
			echo "<tr bordercolor='#003333'>
				<td><a href='consultadatosactuales.php?documentos=$cc'>$est&nbsp;</a></td>
				<td>$cc&nbsp;</td>						
			</tr>";
		}
	
	echo "&nbsp;";
	echo "<div align='center' class='Estilo4'><strong>Consulta Por: &nbsp;",$tipoconsulta,"</strong></div>";
	echo "&nbsp;";
	echo "<div align='center' class='Estilo4 Estilo8'><strong>Se encontraron &nbsp;",$cuentaregistros,"&nbsp; Registro(s)</strong></div>";
	echo "&nbsp;";
	echo "<div align='center' class='Estilo4'><strong>Seleccione el Docente</strong>: </div>";
	echo "&nbsp;"; 
	}
	echo '<tr><td colspan="4" align="center"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()"></tr></td>';
}
?>
</table>
<p class="Estilo4">
 
</p>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.reload("consultadocente.php");
}
</script>
</html>
<?php

mysql_free_result($carrera);

mysql_free_result($estudiosrealizados);

mysql_free_result($idiomas);
?>
