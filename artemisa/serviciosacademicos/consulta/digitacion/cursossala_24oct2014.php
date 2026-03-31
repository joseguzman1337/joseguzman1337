<?php require_once('../../Connections/sala2.php');
session_start();
$GLOBALS['periodos'];
$GLOBALS['grupos'];
$GLOBALS['materias'];
$GLOBALS['facultades'];
//$_SESSION['codigoperiodosesion'] = "20051";
$periodoactual = $_SESSION['codigoperiodosesion'];

if (!$_SESSION['codigodocente'] or !$_SESSION['codigoperiodosesion'])
{
    header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
</head>
<script LANGUAGE="JavaScript1.1">
/*function derecha(e) {
 if (navigator.appName == 'Netscape' && (e.which == 3 || e.which == 2)){
    alert('Botón derecho inhabilitado');
    return false;
   }
  else if (navigator.appName == 'Microsoft Internet Explorer' && (event.button == 2)){
   alert('Botón derecho inhabilitado');
   }
}
document.onmousedown=derecha;*/
</script>

<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: small;
}

.style3 {
	font-size: x-small;
	font-weight: bold;
}

.style4 {
	font-size: x-small
}

.style5 {
	color: #FF0000;
	font-weight: bold;
}

.Estilo23 {
	font-family: Tahoma;
	font-size: x-small;
}

body {
	margin-top: 0px;
}

.Estilo24 {
	font-family: Tahoma;
	font-size: xx-small;
}

.Estilo27 {
	font-family: Tahoma
}

.Estilo28 {
	font-size: 12px;
	font-weight: bold;
}

.Estilo31 {
	font-size: 12
}

.Estilo34 {
	color: #000000
}

.Estilo35 {
	color: #FF0000
}

.Estilo36 {
	font-size: 12px
}
-->
</style>
<?php
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}
/*
 $MM_restrictGoTo = "../login.php";
 if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
 $MM_qsChar = "?";
 $MM_referrer = $_SERVER['PHP_SELF'];
 if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
 if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
 $MM_referrer .= "?" . $QUERY_STRING;
 $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
 header("Location: ". $MM_restrictGoTo);
 exit;
 }*/
?>
<body>
<form name="form1" method="post" action="cursossala.php">
<div align="center"><span class="Estilo27"> <?php
//$_SESSION['codigodocente']=19192036;

$corte=0;
$peractivo=0;
mysql_select_db($database_sala, $sala);

$colname_cursos = "1";
if (isset($_SESSION['codigodocente'])) {
    $colname_cursos = (get_magic_quotes_gpc()) ? $_SESSION['codigodocente'] : addslashes($_SESSION['codigodocente']);
}
mysql_select_db($database_sala, $sala);

//  Query real
mysql_select_db($database_sala, $sala);
$query_cursos = "SELECT  *
						FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
						WHERE g.numerodocumento = '".$colname_cursos."'
						and c.codigocarrera = m.codigocarrera 
						AND g.codigomateria = m.codigomateria
						AND m.codigoestadomateria = '01'
						and g.codigoestadogrupo like '1%'
						AND g.codigoperiodo = cp.codigoperiodo
						and p.codigoperiodo = cp.codigoperiodo
						and p.codigoestadoperiodo = '3'
						and cp.codigoestado like '1%'
						and cp.codigocarrera = c.codigocarrera";
//AND g.codigomaterianovasoft = m.codigomaterianovasoft
//echo $query_cursos;
$cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
$row_cursos = mysql_fetch_assoc($cursos);
$totalRows_cursos = mysql_num_rows($cursos);
if(!$row_cursos)
{
    $query_cursos = "SELECT  *
						FROM grupo g,materia m,carrera c, carreraperiodo cp, periodo p
						WHERE g.numerodocumento = '".$colname_cursos."'
						and c.codigocarrera = m.codigocarrera 
						AND g.codigomateria = m.codigomateria
						AND m.codigoestadomateria = '01'
						and g.codigoestadogrupo like '1%'
						AND g.codigoperiodo = cp.codigoperiodo
						and p.codigoperiodo = cp.codigoperiodo
						and p.codigoestadoperiodo = '1'
						and cp.codigoestado like '1%'
						and cp.codigocarrera = c.codigocarrera";
    //AND g.codigomaterianovasoft = m.codigomaterianovasoft
    //echo $query_cursos;
    $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
    $row_cursos = mysql_fetch_assoc($cursos);
    $totalRows_cursos = mysql_num_rows($cursos);
}

mysql_select_db($database_sala, $sala);
$query_estudiantes ="SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral
					FROM prematricula p,detalleprematricula d,estudiante e,estudiantegeneral eg
					WHERE eg.idestudiantegeneral = e.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND p.idprematricula = d.idprematricula
					AND d.idgrupo = '".$_SESSION['grupos']."'
					AND p.codigoestadoprematricula LIKE '4%'
					AND d.codigoestadodetalleprematricula LIKE '3%'
					ORDER BY 4";
$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
$row_estudiantes = mysql_fetch_assoc($estudiantes);
$totalRows_estudiantes = mysql_num_rows($estudiantes);
$banderagrabar= 0;

if ($_POST['Submit'] == true)
{
    if($_POST['actividadteorica'] == "" || $_POST['actividadpractica'] == "")
    {
        echo '<script language="JavaScript">alert("Debe digitar los campos de las Actividades realizadas en el corte")</script>';
        $banderagrabar = 1;
        $_POST['Submit'] = false;
    }
    elseif (!eregi("^[0-9]{1,3}$", $_POST['actividadteorica']) || !eregi("^[0-9]{1,3}$", $_POST['actividadpractica']))
    {
        echo '<script language="JavaScript">alert("Los campos de las actividades realizadas deben contener números de máximo tres digitos y que no comiencen en cero")</script>';
        $banderagrabar = 1;
        $_POST['Submit'] = false;
    }
    for($q=1; $q <= $totalRows_estudiantes; $q++)
    {
         
        if ((!eregi("^[0-5]{1,1}\.[0-9]{1,1}$", $_POST['nota1'.$q])) or ($_POST['nota1'.$q] > 5))
        {
            echo '<script language="JavaScript">alert("Las notas se deben digitar en formato 0.0 a 5.0 con separador PUNTO(.)")</script>';
            $q = $totalRows_estudiantes + 1 ;
            $banderagrabar = 1;
            $_POST['Submit'] = false;
        }
        else
        if ((!eregi("^[0-9]{1,2}$", $_POST['fallateorica1'.$q])) or (!eregi("^[0-9]{1,2}$", $_POST['fallapractica1'.$q])))
        {
            echo '<script language="JavaScript">alert("Las fallas se deben digitar en formato numérico")</script>';
            $q = $totalRows_estudiantes + 1 ;
            $banderagrabar = 1;
            $_POST['Submit'] = false;
        }
    }
    if ( $banderagrabar == 0)
    {
        require_once('validarsala.php');
        exit();
    }
}// fin if de boton

mysql_select_db($database_sala, $sala);
$query_fecha ="SELECT *
						FROM corte c,materia g
						WHERE c.codigomateria = '".$_SESSION['materias']."'
						AND c.codigoperiodo = '".$periodoactual."'												
						AND c.codigomateria = g.codigomateria
						AND g.codigoestadomateria = '01'
						";
//AND c.codigomaterianovasoft = g.codigomaterianovasoft
//echo $query_fecha,"<br>";
$fecha = mysql_query($query_fecha,$sala) or die(mysql_error());
$row_fecha = mysql_fetch_assoc($fecha);
$totalRows_fecha = mysql_num_rows($fecha);
$i= 1;
$contadorcortes = 0;
if ($totalRows_fecha <> 0)
{
     
    do {
        $cortes[$i]=$row_fecha;
        $i+=1;
        $contadorcortes +=1;
    } while ($row_fecha = mysql_fetch_assoc($fecha));

}
else
if ($totalRows_fecha==0)
{
    mysql_select_db($database_sala, $sala);
    $query_fecha = "SELECT *
	                        FROM corte 
							WHERE codigocarrera = '".$_SESSION['facultades']."'
							AND codigoperiodo = '".$periodoactual."'
						    order by numerocorte";
    //echo $query_fecha,"<br>";
    $fecha = mysql_query($query_fecha, $sala) or die(mysql_error());
    $row_fecha = mysql_fetch_assoc($fecha);
    $totalRows_fecha = mysql_num_rows($fecha);

    do {
        $cortes[$i]=$row_fecha;
        $i+=1;
        $contadorcortes +=1;
    } while ($row_fecha = mysql_fetch_assoc($fecha));
}
mysql_select_db($database_sala, $sala);
$query_nombremateria = "SELECT materia.nombremateria,materia.codigomateria
													FROM materia,grupo 
													WHERE grupo.codigomateria = '".$_SESSION['materias']."'
													AND grupo.idgrupo = '".$_SESSION['grupos']."'
													AND grupo.codigomateria = materia.codigomateria 
													AND materia.codigoestadomateria = '01'
													AND grupo.codigoperiodo = '".$periodoactual."'";
//AND grupo.codigomaterianovasoft = materia.codigomaterianovasoft
$nombremateria = mysql_query($query_nombremateria, $sala) or die(mysql_error());
$row_nombremateria = mysql_fetch_assoc($nombremateria);
$totalRows_nombremateria = mysql_num_rows($nombremateria);

$colname_docente = "1";
if (isset($_SESSION['codigodocente'])) {
    $colname_docente = (get_magic_quotes_gpc()) ? $_SESSION['codigodocente'] : addslashes($_SESSION['codigodocente']);
}
mysql_select_db($database_sala, $sala);
$query_docente = "SELECT * FROM docente
                          WHERE numerodocumento = '".$colname_docente."'";
$docente = mysql_query($query_docente, $sala) or die(mysql_error());
$row_docente = mysql_fetch_assoc($docente);
$totalRows_docente = mysql_num_rows($docente);
?>
<table width="600" border="1" cellpadding="1" cellspacing="0"
	bordercolor="#E9E9E9">
	<tr>
		<td colspan="3" id="tdtitulogris">LISTADO DE GRUPOS</td>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Fecha</td>
		<td align="center" class="Estilo23"><span class="Estilo31"><?php echo date("j/m/Y",time());?></span></td>
	</tr>
	<tr>
		<td width="10%" bgcolor="#E9E9E9" id="tdtitulogris">C&oacute;digo</td>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Grupo</td>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Act. Teórico-Prácticas</td>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Materia</td>
		<td colspan="2" bgcolor="#E9E9E9" id="tdtitulogris">Facultad</td>
	</tr>
	<?php
	$g = 1;
	do{
	    $imprimemateria = 0;

	    $query_area = "SELECT *
					FROM notaarea n							
					where  n.idgrupo = '".$row_cursos['idgrupo']."'
					AND n.codigoperiodo = '".$periodoactual."'
					and n.codigoestadonotaarea like '1%'";
	    //WHERE n.idgrupo = '".$row_cursos['idgrupo']."' n.numerodocumento = '".$colname_docente."'
	    //echo $query_area;
	    $area = mysql_query($query_area,$sala) or die(mysql_error());
	    $row_area  = mysql_fetch_assoc($area);
	    $totalRows_area  = mysql_num_rows($area);
	    if (! $row_area)
	    {
	        $imprimemateria = 1;
	    }
	    else
	    if ($row_area <> "" and $row_area['numerodocumento'] == $colname_docente)
	    {
	        $imprimemateria = 1;
	    }

	    if($imprimemateria == 1)
	    {
	        $guardagruposimpresos[$g] = $row_cursos['idgrupo'];

	        //// linea modificada   <td><span class="style4"><?php echo "<a href='cargavariablesnotas.php?materia=".$row_cursos['codigomateria']."&grupo=".$row_cursos['idgrupo']."&nombreperiodo=".$row_periodo['codigoperiodo']."&facultad=".$row_cursos['codigocarrera']."'>".$row_cursos['codigomateria']."</a>";
	        ?>
	<tr>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo "<a href='cargavariablesnotas.php?materia=".$row_cursos['codigomateria']."&grupo=".$row_cursos['idgrupo']."&nombreperiodo=".$row_periodo['codigoperiodo']."&facultad=".$row_cursos['codigocarrera']."'>".$row_cursos['codigomateria']."</a>"; ?></font></div>
		</td>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo $row_cursos['idgrupo']; ?></font></div>
		</td>
		<td>
		<div align="center"><font size="1" face="Tahoma"><a
			onClick="window.open('practica_teoricas.php?materia=<?php echo $row_cursos['codigomateria'];?>&idgrupo=<?php echo $row_cursos['idgrupo'];?>','actividades','width=600,height=400,left=200,top=100,scrollbars=yes')"
			style="cursor: pointer; font-size: 10px;">EDITAR</a></font></div>
		</td>
		<td><font size="1" face="Tahoma"><?php echo $row_cursos['nombremateria']; ?>
		</font></td>
		<td colspan="2"><font size="1" face="Tahoma"><?php echo $row_cursos['nombrecarrera'];?></font></td>
	</tr>
	<?php
	$g++;
}
} while ($row_cursos = mysql_fetch_assoc($cursos));


$m= 1;
$query_area = "SELECT *
					FROM notaarea n							
					where  n.numerodocumento = '".$colname_docente."'
					AND n.codigoperiodo = '".$periodoactual."'
					and n.codigoestadonotaarea like '1%'";
//WHERE n.idgrupo = '".$row_cursos['idgrupo']."' n.numerodocumento = '".$colname_docente."'
//echo $query_area;
$area = mysql_query($query_area,$sala) or die(mysql_error());
$row_area  = mysql_fetch_assoc($area);
$totalRows_area  = mysql_num_rows($area);
if ($row_area <> "")
{
    do{
        $impresa = 0;
        for ($m = 1; $m < $g; $m++)
        {
            if($row_area['idgrupo'] == $guardagruposimpresos[$m])
            {
                $impresa = 1;
            }
        }
        if ($impresa == 0)
        {
            $query_cursos = "SELECT  *
						FROM grupo g,materia m,carrera c
						WHERE g.idgrupo = '".$row_area['idgrupo']."'
						and c.codigocarrera = m.codigocarrera 
						AND g.codigomateria = m.codigomateria
						AND g.codigoperiodo = '".$periodoactual."'
						AND m.codigoestadomateria = '01'";
            //AND g.codigomaterianovasoft = m.codigomaterianovasoft
            //echo $query_cursos;
            $cursos = mysql_query($query_cursos, $sala) or die(mysql_error());
            $row_cursos = mysql_fetch_assoc($cursos);
            $totalRows_cursos = mysql_num_rows($cursos);
            ?>

	<tr>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo "<a href='cargavariablesnotas.php?materia=".$row_cursos['codigomateria']."&grupo=".$row_cursos['idgrupo']."&nombreperiodo=".$row_periodo['codigoperiodo']."&facultad=".$row_cursos['codigocarrera']."'>".$row_cursos['codigomateria']."</a>"; ?></font></div>
		</td>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo $row_cursos['idgrupo']; ?></font></div>
		</td>
		<td><font size="1" face="Tahoma"><?php echo $row_cursos['nombremateria']; ?>
		</font></td>
		<td colspan="2"><font size="1" face="Tahoma"><?php echo $row_cursos['nombrecarrera'];?></font></td>
	</tr>
	<?php
}

} while ($row_area  = mysql_fetch_assoc($area));
}
?>
</table>
<?php if (isset($_SESSION['materias']))
{
    ?>

<table width="600" border="1" cellpadding="1" cellspacing="0"
	bordercolor="#E9E9E9">
	<tr>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Materia</td>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo $row_nombremateria['nombremateria'];?>&nbsp;</font></div>
		</td>
		<td bgcolor="#E9E9E9" id="tdtitulogris">Docente</td>
		<td>
		<div align="center"><font size="1" face="Tahoma"><?php echo $row_docente['apellidodocente']."  ".$row_docente['nombredocente'];?></font></div>
		</td>
	</tr>
</table>
<br>
<table width="90%" border="1" align="center" cellpadding="1"
	cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td colspan="4" rowspan="4" align="left" valign="top" class="Estilo27">
		<p align="justify"><span class="Estilo23"><span class="Estilo35"><span
			class="Estilo34">Recuerde que para desplazarse por las casillas, se
		hace por medio de la tecla </span></span><span class="style5">TABULADOR
		</span><span class="Estilo35"><span class="Estilo34">y no por </span></span>
		<span class="style5">ENTER.</span></span></p>
		<span class="Estilo36"><strong>FAT:</strong> Fallas en Actividades
		Te&oacute;ricas.</span><br>
		<span class="Estilo36"> <strong>FAP:</strong> Fallas en Actividades
		Pr&aacute;cticas.</span><br>
		<br><strong>Alto Riesgo :</strong> <img src='rojo.png' align='middle'>
		&nbsp;&nbsp;&nbsp;<strong>Mediano Riesgo :</strong> <img src='amarillo.png' align='middle'>
		&nbsp;&nbsp;&nbsp;<strong>Bajo Riesgo :</strong> <img src='azul.png' align='middle'>
		<strong> <!-- Las Fallas deben digitarse en horas y no por bloque de clase. --></strong></td>
		<?php
		for ($i=1;$i<=$contadorcortes;$i++)
		{
	     echo "<td colspan='3' id='tdtitulogris' align='center'>Corte ".$i." </td>";
		}
		?>
		<td colspan='3' align='center'><a href="manualdigitacionnotasweb.pdf"
			target="_blank" id="aparencialinknaranja">Ayuda</a></td>
	</tr>
	<tr>
	<?php
	for ($i=1;$i<=$contadorcortes;$i++)
	{
	    echo "<td colspan='3' align='center' valign='middle'><font size='1' face='Tahoma'>".$cortes[$i]['fechainicialcorte']."</span></td>";
	    //echo "<td colspan='2' align='center'><font size='2' face='Tahoma'><strong>Fecha Inicial </strong></span></td>";
	    //echo "<td align='center'><font size='2' face='Tahoma'><strong>Fecha Final </strong></span></td>";
	}
	?>
		<td width="80" align='center' id="tdtitulogris">Fecha Inicial</td>
	</tr>
	<tr>
	<?php
	for ($i=1;$i<=$contadorcortes;$i++)
	{
	    //echo "<td align='center' valign='middle'><font size='2' face='Tahoma'>".$cortes[$i]['fechainicialcorte']."</span></td>";
	    echo "<td colspan='3' align='center' valign='middle'><font size='1' face='Tahoma'>".$cortes[$i]['fechafinalcorte']."</span></td>";
	}
	///<td align="left" valign="middle"><span class="style4"><?php //echo $row_fecha['notarecuperacioninicial']; </span></td>
	//<td align="left" valign="middle"><span class="style4"><?php //echo $row_fecha['notarecuperacionfinal']; </span></td>

	?>
		<td width="80" align='center' id="tdtitulogris">Fecha Final</td>
	</tr>
	<tr>
	<?php
	$cuentaporcentajes = 0;
	for ($i=1;$i<=$contadorcortes;$i++) {
	    //echo "
	    //<td colspan='2' align='left' valign='middle'><div align='right' class='style4'></div>
	    //<div align='right' class='style4'>Porcentaje:</div></td>
	    //<td align='left' valign='middle'><span class='style4'>";
	    echo "<td colspan='3' align='center' valign='top'><font size='1' face='Tahoma'><strong>Porcentaje</strong><br>";
	    if ($cortes[$i]['fechainicialcorte']<=date("Y-m-d",time()) &&  date("Y-m-d",time()) <= $cortes[$i]['fechafinalcorte'])
	    {
	        echo "".$cortes[$i]['porcentajecorte']."%";
	        $corte=$i;
	        $peractivo=1;
	        //echo $cortes[$i]['idcorte'];
	        $porcentajeactivo = $cortes[$i]['porcentajecorte'];
	        $corteactivo = $cortes[$i]['numerocorte'];
	        $idcorteactivo = $cortes[$i]['idcorte'];
	        $cuentaporcentajes = $cuentaporcentajes + $cortes[$i]['porcentajecorte'];
	    } else
	    {
	        echo $cortes[$i]['porcentajecorte']."%";
	        $cuentaporcentajes = $cuentaporcentajes + $cortes[$i]['porcentajecorte'];
	    }
	    //echo "</span></td>";
		   // echo "<td align='left' valign='middle'><div align='right' class='style4'><strong>Porcentaje (1-100) </strong></div></td>";
	    // echo "<input name='porcentaje".$i."' type='hidden' id='porcentaje".$i."' value='".$cortes[$i]['porcentajecorte']."'>";

	}
	?>
		<td width="80" align='center' id="tdtitulogris">Porcentaje<br>
		<?php echo $cuentaporcentajes;?>%</td>
	</tr>
	<tr>
		<td align="center" id="tdtitulogris">No.</td>
		<td align="center" id="tdtitulogris">Riesgo</td>
		<td align="center" id="tdtitulogris">Documento</td>
		<td align="center" id="tdtitulogris">Apellidos</td>
		<td align="center" id="tdtitulogris">Nombres</td>
		<?php
		for ($i=1;$i<=$contadorcortes;$i++)
		{
			   echo "<td align='center' id='tdtitulogris'>Nota</td>";
			   echo "<td align='center' id='tdtitulogris'>FAT</td>";
			   echo "<td align='center' id='tdtitulogris'>FAP</td>";
		}
		?>
		<td width="80" align="center" id="tdtitulogris">Nota Final</td>
	</tr>
	<?php
	$j=1;
	$k=10;
	$l=20;
    //require_once('../../Connections/sala2.php');
    $rutaado = "../../funciones/adodb/";
    //$rutazado = "../../../funciones/zadodb/";
    require_once('../../Connections/salaado.php'); 
    require('../../funciones/sala/nota/nota.php');
    if(isset($_GET['debug']))
    {
    	$db->debug = true; 
    }
	
	do 
	{
	    unset($detallenota);
	    $detallenota = new detallenota($row_estudiantes['codigoestudiante'], $periodoactual);
	    /*echo "<pre>";
    print_r($detallenota);
    echo "</pre>";*/
        ?>
	<tr>
		<td align="center" valign="middle"><font size="1" face="Tahoma"><?php echo $j;?></font></td>
		<td align="center" valign="middle"><font size="1" face="Tahoma"><?php echo $detallenota->riesgoEstudianteXMateria($_SESSION['materias'], $_SESSION['grupos']);?></font></td>
		<td height="22" align="left" valign="middle"><font size="1"
			face="Tahoma"><?php echo $row_estudiantes['numerodocumento']; ?></font></td>
		<td align="left" valign="middle" nowrap><font size="1" face="Tahoma"><?php echo $row_estudiantes['apellidosestudiantegeneral']; ?>
		</font></td>
		<td align="left" valign="middle" nowrap><font size="1" face="Tahoma"><?php echo $row_estudiantes['nombresestudiantegeneral']; ?></font></td>
		<?php
		$notafinal = 0;
		for ($i=1;$i<=$contadorcortes;$i++)
		{
		     
		    $query_estudiantes1="SELECT d.*,c.numerocorte
							FROM detallenota d,corte c
							WHERE d.idcorte = c.idcorte							
							AND d.codigomateria = '".$_SESSION['materias']."'
							AND c.numerocorte = '".$i."'
							AND d.codigoestudiante = '".$row_estudiantes['codigoestudiante']."'
							AND c.codigoperiodo = '".$periodoactual."'";
		     
		    //echo $query_estudiantes1;
		    $estudiantes1 = mysql_query($query_estudiantes1,$sala) OR die(mysql_error());
		    $row_estudiantes1 = mysql_fetch_assoc($estudiantes1);
		    $totalRows_estudiantes1 = mysql_num_rows($estudiantes1);

		    if((!$row_estudiantes1) and ($corteactivo == $i))
		    {
		        if ($_POST['nota1'.$j] == "")
		        {
		            $_POST['nota1'.$j]="0.0";
		        }
		        // else
		        if ($_POST['fallateorica1'.$j] == "")
		        {
		            $_POST['fallateorica1'.$j]="0";
		        }
		        //else
		        if ($_POST['fallapractica1'.$j] == "")
		        {
		            $_POST['fallapractica1'.$j]="0";
		        }
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='3' name='nota1".$j."' value='".$_POST['nota1'.$j]."' style='width: 25px '></td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='2' name='fallateorica1".$j."' value='".$_POST['fallateorica1'.$j]."' style='width: 25px '></td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='2' name='fallapractica1".$j."' value='".$_POST['fallapractica1'.$j]."' style='width: 25px '></td>";
		         
		    }
		    else
		    if (($row_estudiantes1 <> "") and ($corteactivo == $i))
		    {
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='3' name='nota1".$j."' value='".$row_estudiantes1['nota']."' style='width: 25px '></td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='2' name='fallateorica1".$j."' value='".$row_estudiantes1['numerofallasteoria']."' style='width: 25px '></td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'><input type='text' size='1' maxlength='2' name='fallapractica1".$j."' value='".$row_estudiantes1['numerofallaspractica']."' style='width: 25px '></td>";
		        $notafinal = $notafinal + ($row_estudiantes1['nota'] * $cortes[$i]['porcentajecorte'])/100;

		    }
		    else
		    // if (($row_estudiantes1 <> "") and ($corteactivo <> $i))
		    {

		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'>".$row_estudiantes1['nota']."&nbsp;</td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'>".$row_estudiantes1['numerofallasteoria']."&nbsp;</td>";
		        echo "<td align='center' valign='middle'><font size='2' face='Tahoma'>".$row_estudiantes1['numerofallaspractica']."&nbsp;</td>";
		        $notafinal = $notafinal + ($row_estudiantes1['nota'] * $cortes[$i]['porcentajecorte'])/100;
		    }
		}

		?>
		<td width="80" align='center' class="Estilo27"><span class='style4'><strong><?php $notafinal = number_format($notafinal,1); echo round($notafinal * 10)/10;?>&nbsp;</strong></span></td>
	</tr>
	<?php

	$j++;
	$k++;
	$l++;
} while ($row_estudiantes = mysql_fetch_assoc($estudiantes));
}// fin de if (isset($_SESSION['materias'])) {
// $_SESSION['cuentaalumnos']=$j++;
?>
	<tr>
		<td height="22" colspan="38" align="left" valign="top"
			class="Estilo27"><span class="Estilo24"> <?php 
			if($peractivo==1)
			{
			    $query_nota="SELECT *
			FROM nota n  
			WHERE idcorte = '$idcorteactivo'
			AND idgrupo = '".$_SESSION['grupos']."'";                            		
			    $nota = mysql_query($query_nota,$sala) OR die(mysql_error());
			    $row_nota = mysql_fetch_assoc($nota);
			    $totalRows_nota = mysql_num_rows($nota);
			    if($row_nota)
			    {
			        $actividadesacademicaspracticanota = $row_nota['actividadesacademicaspracticanota'];
			        $actividadesacademicasteoricanota = $row_nota['actividadesacademicasteoricanota'];
			        //echo "$query_nota<br>";

			    }
			    if(isset($_POST['actividadpractica']))
			    {
			        $actividadesacademicaspracticanota = $_POST['actividadpractica'];
			        //echo "$actividadesacademicaspracticanota<br>";
			    }
			    if(isset($_POST['actividadteorica']))
			    {
			        $actividadesacademicasteoricanota = $_POST['actividadteorica'];
			        //echo "$actividadesacademicasteoricanota<br>";
			    }
			    echo "<strong>Actividades Teóricas Realizadas</strong> <input name='actividadteorica' type='text' value='$actividadesacademicasteoricanota' size='2' maxlength='3'>&nbsp;&nbsp;&nbsp;&nbsp;";
			    echo "<strong>Actividades Prácticas Realizadas</strong> <input name='actividadpractica' type='text' value='$actividadesacademicaspracticanota' size='2' maxlength='3'> ";
		 }
		 ?> </span></td>
	</tr>
	<tr>
		<td height="22" colspan="38" align="left" valign="top"
			class="Estilo27"><span class="Estilo24"> <?php 
			/**** para validar si ya digito las notas*/////

			$flagnotas = false;

			$query_detallenota="SELECT *
FROM detallenota 
WHERE idcorte = '$idcorteactivo'
AND idgrupo = '".$_SESSION['grupos']."'";                            		
			$detallenota = mysql_query($query_detallenota,$sala) OR die(mysql_error());
			$row_detallenota = mysql_fetch_assoc($detallenota);
			$totalRows_detallenota = mysql_num_rows($detallenota);

			if ($row_detallenota <> "")
			{
			    $flagnotas = true;
			}

			/**** para validar si ya digito las notas*/////
			//and !$flagnotas
			if ($peractivo==1)
			{
			    echo "<input name='Submit' type='submit' value='Guardar Cambios'> ";
			    echo "<span class='style5'><= Recuerde Guardar los cambios</span>";
			}
	  /* else
	   if($flagnotas)
	   {
	   echo "<span class='style5'>Señor Docente si desea Realizar Modificaciones por favor diríjalas a la Secretaria Académica de la Facultad</span>";
	   } */
			?> </span></td>
	</tr>
</table>
<span class="Estilo27"> <input name="idcorte" type="hidden" id="idcorte"
	value="<?php echo $idcorteactivo; ?>"> <input name="grupo"
	type="hidden" id="grupo" value="<?php echo $_GET['grupo']; ?>"> <input
	name="periodo" type="hidden" id="periodo"
	value="<?php echo $_GET['nombreperiodo']; ?>"> <input
	name="nombremateria" type="hidden" id="nombremateria"
	value="<?php echo $row_nombremateria['nombremateria'];?>"> <input
	name="nombre" type="hidden" id="nombre"
	value="<?php echo $row_docente['apellidodocente']."  ".$row_docente['nombredocente'];?>">
<input name="materia" type="hidden" id="idcorte"
	value="<?php echo $row_nombremateria['codigomateria'];?>"> <br>
<br>
<br>
</span> <span class="Estilo27"> <?php
mysql_free_result($cursos);
mysql_free_result($estudiantes);
//mysql_free_result($fecha);
mysql_free_result($nombremateria);
mysql_free_result($docente);
//mysql_free_result($periodo);
?> </span></div>
</form>
</body>
</html>
