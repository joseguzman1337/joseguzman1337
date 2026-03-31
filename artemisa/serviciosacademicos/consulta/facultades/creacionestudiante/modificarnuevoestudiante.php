<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);

session_start();

      $usuario = $_SESSION['MM_Username'];	
	  mysql_select_db($database_sala, $sala);
	  $query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
	  $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
	  $row_tipousuario = mysql_fetch_assoc($tipousuario);
	  $totalRows_tipousuario = mysql_num_rows($tipousuario);

$codigocarrera = $_SESSION['codigofacultad'];

mysql_select_db($database_sala, $sala);
$query_periodos = "SELECT *
						FROM periodo					
					    order by 1 desc";
$periodos = mysql_query($query_periodos, $sala) or die(mysql_error());
$row_periodos = mysql_fetch_assoc($periodos);
?>
<html>
<head>
<title>Bï¿½squeda Modificar Estudiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo5 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo7 {font-size: 12px}
-->
</style>
</head>
<script language="javascript">
function cambia_tipo(obj)
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = obj[obj.selectedIndex].value 
    //miro a ver si el tipo estï¿½ definido 
    if (tipo == 1)
	{
		window.location.href="modificarnuevoestudiante.php?busqueda=nombre"; 
	} 
    if (tipo == 2)
	{
		window.location.href="modificarnuevoestudiante.php?busqueda=apellido"; 
	} 
    if (tipo == 3)
	{
		window.location.href="modificarnuevoestudiante.php?busqueda=codigo"; 
    } 
    if (tipo == 4)
	{
		window.location.href="modificarnuevoestudiante.php?busqueda=documento"; 
    } 
} 

function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo estï¿½ definido 
    if (busca != 0)
	{
		window.location.href="modificarnuevoestudiante.php?buscar="+busca; 
	} 
} 
</script>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="modificarnuevoestudiante.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo5">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="700" border="1" bordercolor="#003333">
  <tr>
    <td width="200" bgcolor="#C5D5D6"><div align="center"><span class="Estilo7"> <strong>Busqueda por :</strong>        
            <select name="tipo" onChange="cambia_tipo(this)">
		      <option value="0">Seleccionar</option>
		      <option value="1">Nombre</option>
		      <option value="2">Apellido</option>
		      <!-- <option value="3">Cï¿½digo</option> -->
		      <option value="4">Documento</option>
            </select>
    </span></div></td>
	<td width="484"><span class="Estilo6">&nbsp;
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
			if($_GET['busqueda']=="codigo")
			{
				echo "Digite un Cï¿½digo : <input name='busqueda_codigo' type='text'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "Nro de Documento : <input name='busqueda_documento' type='text'>";
			}
			if($_GET['busqueda']=="credito")
			{
				echo "Digite un Nï¿½mero de Credito : <input name='busqueda_credito' type='text'>";
			}
if(isset($_GET['busqueda']) and $row_tipousuario['codigotipousuariofacultad'] == 200)
 {
   echo "Periodo Promedio";
  ?>
	    <select name="periodo" id="periodo">
	   <option value="0" <?php if (!(strcmp(0, $_GET['periodo']))) {echo "SELECTED";} ?>>Periodo</option>
       <?php
  do {  
?>
       <option value="<?php echo $row_periodos['codigoperiodo']?>"<?php if (!(strcmp($row_periodos['codigoperiodo'], $_GET['periodo']))) {echo "SELECTED";} ?>><?php echo $row_periodos['codigoperiodo']?></option>
       <?php
} while ($row_periodos = mysql_fetch_assoc($periodos));
  $rows = mysql_num_rows($periodos);
  if($rows > 0) 
  {
      mysql_data_seek($periodos, 0);
	  $row_carreras = mysql_fetch_assoc($periodos);
  }
?>
        </select>
<?php
}			
?>
    </span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {   
	if ($_GET['periodo'] == 0 and $row_tipousuario['codigotipousuariofacultad'] == 200)
	 {
	  echo '<script language="JavaScript">alert("Debe elegir un periodo");history.go(-1);</script>';	 
	 } 
  ?>
</table>
<p align="center" class="Estilo6">Seleccione el estudiante al que le desee modificar sus datos</p>
<table width="700" border="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Cï¿½dula</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Cï¿½digo</strong>&nbsp;</td>
  	</tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
	    if ($row_tipousuario['codigotipousuariofacultad'] == 200)
          {		
		
			$nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
			if($_GET['busqueda_nombre'] == "")
				$vacio = true;
	     }
		else
		 {
		   $nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
			if($_GET['busqueda_nombre'] == "")
				$vacio = true;
		 }
	}
	if(isset($_GET['busqueda_apellido']))
	{
	    if ($row_tipousuario['codigotipousuariofacultad'] == 200)
          {			
			$apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
					c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
					FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
					WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'					
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					and eg.idestudiantegeneral = est.idestudiantegeneral
					and ed.idestudiantegeneral = eg.idestudiantegeneral
					and c.codigocarrera = est.codigocarrera
					and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
					and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
					ORDER BY 3, est.codigoperiodo";
		///echo $query_solicitud,"1";
		///exit();
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			if($_GET['busqueda_apellido'] == "")
				$vacio = true;
	     }
		else
		 {
		    $apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
				WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
				///echo $query_solicitud,"2";
		       /// exit();
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
			if($_GET['busqueda_apellido'] == "")
				$vacio = true;		 
		 }
	}
	
	if(isset($_GET['busqueda_documento']))
	{
	  if ($row_tipousuario['codigotipousuariofacultad'] == 200)
          {			
			$documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
				WHERE ed.numerodocumento LIKE '$documento%'				
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
				//and est.codigosituacioncarreraestudiante not like '1%'
				//and est.codigosituacioncarreraestudiante not like '5%'
				//AND est.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			if($_GET['busqueda_documento'] == "")
				$vacio = true;
		  }
		 else
		  {
		     $documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
				WHERE ed.numerodocumento LIKE '$documento%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
				//and est.codigosituacioncarreraestudiante not like '1%'
				//and est.codigosituacioncarreraestudiante not like '5%'
				//AND est.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			if($_GET['busqueda_documento'] == "")
				$vacio = true;
		  }
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$est = $solicitud["nombre"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigoestudiante"];
			$nombrecarrera = $solicitud["nombrecarrera"];
			//$estado = $solicitud["nombresituacioncarreraestudiante"];
			
			if ($row_tipousuario['codigotipousuariofacultad'] == 200)
            {					
				echo "<tr>
					<td><a href='estudiantecreado.php?periodo=".$_GET['periodo']."&codigocreado=$cod'>$est&nbsp;</a></td>
					<td>$cc&nbsp;</td>
					<td>$nombrecarrera&nbsp;</td>				
				</tr>";
		    }
		  else
            {
			  echo "<tr>
					<td><a href='editarestudiante.php?codigocreado=$cod'>$est&nbsp;</a></td>
					<td>$cc&nbsp;</td>
					<td>$nombrecarrera&nbsp;</td>				
				</tr>";			
			}
		}
	}
	echo '<tr><td colspan="4" align="center"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()"></tr></td>';
}
?>
</table>
<p class="Estilo2">

</p>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.href="menucrearnuevoestudiante1.php";
}
</script>
</html>