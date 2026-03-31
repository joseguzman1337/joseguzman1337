<?php

/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan los archivos de configuracion y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Julio 19, 2018
*/
//home/arizaandres/Documentos/proyectoSala/serviciosacademicos/consulta/facultades/materiasgrupos/materiasgrupos.php
require(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));
//d($variables);
Factory::validateSession($variables);
require_once(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');
mysql_select_db('sala', $sala);
//require_once('seguridadmateriasgrupos.php');
/************ BORRAR *******************/
/*$_SESSION['codigofacultad'] = '190';
$_SESSION['codigoperiodosesion'] = '20081';*/
/***************************************/
if(isset($_SESSION['codigofacultad']))
{
	$codigocarrera = $_SESSION['codigofacultad'];
}
else
{
	$codigocarrera = "";
}
if($_SESSION['MM_Username'] == "adminplantafisica" || $_SESSION['MM_Username'] == "Adminsoporte")
{
	$_SESSION['codigofacultad'] = "";
	$codigocarrera = $_SESSION['codigofacultad'];
}
//print_r($_SESSION);
?>
<html>
<head>
<title>Busqueda de Materias y Grupos</title>
<?php
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se utilizan las funciones de inclusion de librerias js y css para manejo de cache
     * @since Julio 19, 2018
    */
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");

    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js");
    ?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
-->
</style>
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="materiasgrupos.php?busqueda=codigo";
	}
    if (tipo == 2)
	{
		window.location.href="materiasgrupos.php?busqueda=nombre";
	}
	if (tipo == 3)
	{
		window.location.href="materiasgrupos.php?busqueda=facultad";
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
		window.location.href="materiasgrupos.php?buscar="+busca;
	}
}
</script>
<body>
<div align="center">
<form name="f1" action="materiasgrupos.php" method="get">
  <p class="Estilo3"><strong>CRITERIO DE B&Uacute;SQUEDA DE MATERIAS</strong></p>
  <table width="700" border="1" cellpadding="2" cellspacing="1"  bordercolor="#003333">
    <tr>
      <td width="200" bgcolor="#C5D5D6" class="Estilo6"><div align="center"><strong><span class="Estilo2">Búsqueda por:</span>
                <select name="tipo" onChange="cambia_tipo()">
                  <option value="0">Seleccionar</option>
                  <option value="1">Código</option>
                  <option value="2">Nombre</option>
<?php
if($_SESSION['MM_Username'] == "adminplantafisica") :
?>
                  <option value="3">Facultad</option>
<?php
endif;
?>
                </select>
      </strong></div></td>
      <td width="351" align="center" class="Estilo2"><?php
if(isset($_GET['busqueda']))
{
	if($_GET['busqueda']=="codigo")
	{
		echo "Digite un Código : <input name='busqueda_codigo' type='text'>";
	}
	if($_GET['busqueda']=="nombre")
	{
		echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
	}
	if($_GET['busqueda']=="facultad")
	{
		echo "Digite una Facultad: <input name='busqueda_facultad' type='text'>";
	}
}
?>
  &nbsp; </td>
      <td width="55" bgcolor="#C5D5D6" align="center" class="Estilo2">Fecha</td>
      <td width="70" align="center" class="Estilo1" ><?php echo $fechahoy=date("Y-m-d");?></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">
  &nbsp; </td>
    </tr>
  </table>
  <p class="Estilo6 Estilo1">
<?php
//echo "<h1>".$_SESSION['MM_Username']."</h1>";
if(isset($_GET['buscar']) || isset($_GET['filtrar']))
{
	$vacio = false;
	if($codigocarrera == '')
			$codigocarrera = "%";
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		if($_SESSION['MM_Username'] != "adminplantafisica" && $_SESSION['MM_Username'] != "Adminsoporte")
		{
			$query_solicitud = "SELECT	m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t
			WHERE m.codigomateria LIKE '$codigo%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '$codigocarrera'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			ORDER BY 3,2";
		}
		else if($_SESSION['MM_Username'] == "adminplantafisica")
		{
			$query_solicitud = "SELECT	distinct m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t, grupo g, horario h
			WHERE m.codigomateria LIKE '%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '%'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			and g.codigomateria = m.codigomateria
			and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			and h.idgrupo = g.idgrupo
			and g.codigoestadogrupo = '10'
			and h.codigotiposalon <> '14'
			ORDER BY 3,2";
		}
		else if($_SESSION['MM_Username'] == "Adminsoporte")
		{
			$query_solicitud = "SELECT	distinct m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t, grupo g, horario h
			WHERE m.codigomateria LIKE '%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '%'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			and g.codigomateria = m.codigomateria
			and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			and h.idgrupo = g.idgrupo
			and g.codigoestadogrupo = '10'
			and h.codigotiposalon = '14'
			ORDER BY 3,2";
		}
		// and m.codigotipomateria not like '4'
                //d($query_solicitud);
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		if($codigocarrera == '')
			$codigocarrera = "%";
		if($_SESSION['MM_Username'] != "adminplantafisica" && $_SESSION['MM_Username'] != "Adminsoporte")
		{
			$query_solicitud = "SELECT m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t
			WHERE m.nombremateria LIKE '$nombre%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '$codigocarrera'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			ORDER BY 3,2";
		}
		else if($_SESSION['MM_Username'] == "adminplantafisica")
		{
			$query_solicitud = "SELECT	distinct m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t, grupo g, horario h
			WHERE m.nombremateria LIKE '$nombre%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '%'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			and g.codigomateria = m.codigomateria
			and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			and h.idgrupo = g.idgrupo
			and g.codigoestadogrupo = '10'
			and h.codigotiposalon <> '14'
			ORDER BY 3,2";
		}
		else if($_SESSION['MM_Username'] == "Adminsoporte")
		{
			$query_solicitud = "SELECT	distinct m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
			FROM materia m, carrera c, tipomateria t, grupo g, horario h
			WHERE m.nombremateria LIKE '$nombre%'
			AND m.codigocarrera = c.codigocarrera
			AND m.codigocarrera like '%'
			AND m.codigoestadomateria = '01'
			and m.codigotipomateria = t.codigotipomateria
			and g.codigomateria = m.codigomateria
			and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			and h.idgrupo = g.idgrupo
			and g.codigoestadogrupo = '10'
			and h.codigotiposalon = '14'
			ORDER BY 3,2";
		}
		// and m.codigotipomateria not like '4'
		//echo "$query_solicitud<br>";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
    if(isset($_GET['busqueda_facultad']))
	{
		$facultad = $_GET['busqueda_facultad'];
		//echo "<h1>$facultad</h1>";
		if($facultad == '')
			$facultad = "%";
		else
			$facultad = $facultad."%";
		//echo "<h1>$facultad</h1>";
		$query_solicitud = "SELECT	distinct m.codigomateria, m.nombremateria, c.nombrecarrera, t.nombretipomateria
		FROM materia m, carrera c, tipomateria t, grupo g, horario h
		WHERE m.nombremateria LIKE '%'
		AND m.codigocarrera = c.codigocarrera
		AND m.codigocarrera like '%'
		AND m.codigoestadomateria = '01'
		and m.codigotipomateria = t.codigotipomateria
		and g.codigomateria = m.codigomateria
		and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
		and h.idgrupo = g.idgrupo
		and c.nombrecarrera like '$facultad'
		and g.codigoestadogrupo = '10'
		and h.codigotiposalon <> '14'
		ORDER BY 3,2";
	}
	// and m.codigotipomateria not like '4'
	//echo "$query_solicitud<br>";
	$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
	if(@$_GET['busqueda_nombre'] == "")
		$vacio = true;
	$totalRows1=mysql_num_rows($res_solicitud);
?>
</p>
  <p align="center" class="Estilo3"><strong>MATERIAS ENCONTRADAS</strong> </p>
<?php
if($_SESSION['MM_Username'] == "adminplantafisica") :
?>
	<table  width="700" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td><b>Estado Horarios</b></td><td>
  	<select name="horarios">
  		<option value="Todos" <?php if(!isset($_GET['horarios']) || $_GET['horarios'] == "Todos") echo "selecte"?>>Todos</option>
  		<option value="Tiene" <?php if($_GET['horarios'] == "Tiene") echo "selected" ?>>Tiene</option>
  		<option value="No Tiene" <?php if($_GET['horarios'] == "No Tiene") echo "selected" ?>>No Tiene</option>
  	</select></td>
  </tr>
  <tr>
  	<td><b>Estado Salones</b></td><td>
  	<select name="salones">
  		<option value="Todos" <?php if(!isset($_GET['salones']) || $_GET['salones'] == "Todos") echo "selected" ?>>Todos</option>
  		<option value="Tiene" <?php if($_GET['salones'] == "Tiene") echo "selected" ?>>Tiene</option>
  		<option value="No Tiene" <?php if($_GET['salones'] == "No Tiene") echo "selected" ?>>No Tiene</option>
  	</select></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input name="filtrar" value="Filtrar" type="submit"><input name="busqueda_facultad" value="<?php echo $_GET['busqueda_facultad'] ?>" type="hidden"></td>
  </tr>
  </table>
<?php
endif;
?>
  <p align="center" class="Estilo2">Seleccione la materia que desee  de la siguiente tabla :</p>
  <table width="700" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td width="10%" bgcolor="#C5D5D6" class="Estilo2 Estilo6 Estilo1"><div align="center"></div>
        <div align="center"><span class="Estilo7">C&oacute;digo</span></div></td>
      <td width="30%" class="Estilo6 Estilo1"><div align="center"><span class="Estilo7">Nombre</span></div></td>
      <td width="20%" class="Estilo6 Estilo1"><div align="center">Facultad</div></td>
      <td width="10%" class="Estilo6 Estilo1"><div align="center">Tipo Materia</div></td>
      <td width="10%" class="Estilo6 Estilo1"><div align="center">Estado Horarios</div></td>
      <td width="10%" class="Estilo6 Estilo1"><div align="center">Estado Salones</div></td>
	  <td width="10%" class="Estilo6 Estilo1"><div align="center">Fechas Horarios</div></td>
      </tr>
  </table>
  <table width="700" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E97914">
<?php
	while ($fila=mysql_fetch_array($res_solicitud))
	{
		$nombre = @$_GET['busqueda_nombre'];
		if($_SESSION['MM_Username'] != "adminplantafisica" && $_SESSION['MM_Username'] != "Adminsoporte")
		{
			$query_selhorario = "SELECT * FROM grupo gru, materia mat, docente doc, indicadorhorario i, horario h
			WHERE mat.codigomateria = gru.codigomateria
			and mat.codigoestadomateria like '01'
			AND gru.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND gru.numerodocumento = doc.numerodocumento
			and gru.codigomateria = mat.codigomateria
			AND gru.codigomateria = '".$fila['codigomateria']."'
			and gru.codigoestadogrupo like '1%'
			and gru.codigoindicadorhorario = i.codigoindicadorhorario
			and h.idgrupo = gru.idgrupo";
			//echo "$query_selhorario<br>";
			$selhorario = mysql_query($query_selhorario, $sala) or die("$query_selhorario");
			$totalRows_selhorario = mysql_num_rows($selhorario);
			//echo "uno $selhorario";
			$estadohorario = "No Tiene";
			$estadosalon = "Tiene";
			if($totalRows_selhorario == "")
			{
				$query_selhorario = "SELECT * FROM grupo gru, materia mat, docente doc, indicadorhorario i
				WHERE mat.codigomateria = gru.codigomateria
				and mat.codigoestadomateria like '01'
				AND gru.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
				AND gru.numerodocumento = doc.numerodocumento
				and gru.codigomateria = mat.codigomateria
				AND gru.codigomateria = '".$fila['codigomateria']."'
				and gru.codigoestadogrupo like '1%'
				and gru.codigoindicadorhorario = i.codigoindicadorhorario";
				//echo "$query_selhorario<br>";
				$selhorario = mysql_query($query_selhorario, $sala) or die("$query_selhorario");
			}
		}
		else if($_SESSION['MM_Username'] == "adminplantafisica")
		{
			$query_selhorario = "SELECT * FROM grupo gru, materia mat, docente doc, indicadorhorario i, horario h
			WHERE mat.codigomateria = gru.codigomateria
			and mat.codigoestadomateria like '01'
			AND gru.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND gru.numerodocumento = doc.numerodocumento
			and gru.codigomateria = mat.codigomateria
			AND gru.codigomateria = '".$fila['codigomateria']."'
			and gru.codigoestadogrupo like '1%'
			and gru.codigoindicadorhorario = i.codigoindicadorhorario
			and h.idgrupo = gru.idgrupo
			and h.codigotiposalon <> '14'";
			//echo "$query_selhorario<br>";
			$selhorario = mysql_query($query_selhorario, $sala) or die("$query_selhorario");
			$totalRows_selhorario = mysql_num_rows($selhorario);
			//echo "uno $selhorario";
			$estadohorario = "No Tiene";
			$estadosalon = "Tiene";
		}
		else if($_SESSION['MM_Username'] == "Adminsoporte")
		{
			$query_selhorario = "SELECT * FROM grupo gru, materia mat, docente doc, indicadorhorario i, horario h
			WHERE mat.codigomateria = gru.codigomateria
			and mat.codigoestadomateria like '01'
			AND gru.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND gru.numerodocumento = doc.numerodocumento
			and gru.codigomateria = mat.codigomateria
			AND gru.codigomateria = '".$fila['codigomateria']."'
			and gru.codigoestadogrupo like '1%'
			and gru.codigoindicadorhorario = i.codigoindicadorhorario
			and h.idgrupo = gru.idgrupo
			and h.codigotiposalon = '14'";
			//echo "$query_selhorario<br>";
			$selhorario = mysql_query($query_selhorario, $sala) or die("$query_selhorario");
			$totalRows_selhorario = mysql_num_rows($selhorario);
			//echo "uno $selhorario";
			$estadohorario = "No Tiene";
			$estadosalon = "Tiene";
		}
		while($row_selhorario=mysql_fetch_array($selhorario))
		{
			if($row_selhorario['codigoindicadorhorario'] == 100)
			{
				$estadohorario = "Tiene";
			}
			else if($row_selhorario['codigoindicadorhorario'] == 200)
			{
				$estadohorario = "No Necesita";
				$estadosalon = "No Tiene";
			}
			if(@$row_selhorario['codigosalon'] == 1)
			{
				$estadosalon = "No Tiene";
			}
		}
		if($estadohorario == "No Tiene")
		{
			$estadosalon = "No Tiene";
		}

		$estadofechahorario = "No Tiene";
		$query_fechahorarios = "select h.idhorario
		from horario h, horariodetallefecha hd, grupo gru
		where h.idhorario = hd.idhorario
		AND gru.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
		AND gru.codigomateria = '".$fila['codigomateria']."'
		and gru.codigoestadogrupo like '1%'
		and h.idgrupo = gru.idgrupo";
		$fechahorarios = mysql_query($query_fechahorarios, $sala) or die(mysql_error()." $query_fechahorarios");
		$totalRows_fechahorarios = mysql_num_rows($fechahorarios);
		if($totalRows_fechahorarios != "")
		{
			$estadofechahorario = "Tiene";
		}
		if(isset($_GET['salones']))
		{
    		if($_GET['salones'] != 'Todos' && $_GET['horarios'] != 'Todos')
    		{
    		    if($_GET['horarios'] != $estadohorario || $_GET['salones'] != $estadosalon)
    		    {
    		        continue;
    		    }

    		}
    		elseif($_GET['salones'] == 'Todos' && $_GET['horarios'] == 'Todos')
    		{
    		}
    	    elseif($_GET['salones'] == 'Todos')
    		{
    		    if($_GET['horarios'] != $estadohorario)
    		    {
    		        continue;
    		    }
    		}
    	    elseif($_GET['horarios'] == 'Todos')
    		{
    		    if($_GET['salones'] != $estadosalon)
    		    {
    		        continue;
    		    }
    		}
		}
?>
    <tr class="Estilo1">
      <td width="10%" align="center"><a href="detallesmateria.php?codigomateria1=<?php echo $fila['codigomateria'];?>&carrera1=<?php echo $fila['nombrecarrera'];?>"><?php echo $fila['codigomateria'];?></a></td>
      <td width="30%" align="center"><?php echo $fila['nombremateria'];?></td>
      <td width="20%" align="center"><?php echo $fila['nombrecarrera'];?></td>
	  <td width="10%" align="center"><?php echo $fila['nombretipomateria'];?></td>
	  <td width="10%" align="center"><?php echo $estadohorario;?></td>
	  <td width="10%" align="center"><?php echo $estadosalon;?></td>
	  <td width="10%" align="center"><?php echo $estadofechahorario;?></td>
    </tr>
    <?php
	}
}
?>
</table>
<p class="Estilo1">&nbsp;  </p>
</form>
		<p align="center" class="Estilo5 Estilo3">&nbsp;</p>
        <p class="Estilo1">
</p>
</form>
</div>
</body>
</html>