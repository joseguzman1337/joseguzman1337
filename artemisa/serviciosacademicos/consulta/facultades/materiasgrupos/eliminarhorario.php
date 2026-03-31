<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php'); 
require_once("funcioneshora.php");
mysql_select_db($database_sala, $sala); 
session_start();
require_once('seguridadmateriasgrupos.php');
$formulariovalido=1;

$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

$Usario_id = mysql_query($SQL_User, $sala) or die("$SQL_User");
$Usario_idD = mysql_fetch_assoc($Usario_id);

$userid=$Usario_idD['id'];
$Padre = $_REQUEST['Padre'];
$codigocarrera = $_SESSION['codigofacultad'];
$codigomateria = $_GET['codigomateria1'];
$carrera = $_GET['carrera1'];
$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera&Padre=$Padre";
if(isset($_GET['grupo1']))
{
	$grupo=$_GET['grupo1'];
	$idgrupo=$_GET['idgrupo1'];
	$numerohorassemanales=$_GET['numerohorassemanales1'];
}
if(isset($_POST['grupo1']))
{
	$grupo=$_POST['grupo1'];
	$idgrupo=$_POST['idgrupo1'];
	$numerohorassemanales=$_POST['numerohorassemanales1'];
}
if(isset($_POST['Eliminar']))
{
    include_once('../../../EspacioFisico/Interfas/FuncionesSolicitudEspacios_Class.php');   $C_FuncionesSolicitudEspacios = new FuncionesSolicitudEspacios();
//echo "<br>IDHORARIO:$idhorario";
	$numerohorario = $_POST['numerohorario1'];
	$query_horarios = "SELECT * FROM horario h, dia d
	WHERE h.codigodia = d.codigodia
	AND h.idgrupo = '$idgrupo'
	order by 1,2,3,4";
	$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
	$totalRows_horarios = mysql_num_rows($horarios);		
	if($totalRows_horarios != 0)
	{
		$cuentahorario = 1;
		while($row_horarios = mysql_fetch_assoc($horarios))
		{
			$codigodia2=$row_horarios['codigodia'];
			$nombredia2=$row_horarios['nombredia'];
			$codigosalon2=$row_horarios['codigosalon'];
			$horainicial2=$row_horarios['horainicial'];
			$horafinal2=$row_horarios['horafinal'];
			
			if($cuentahorario == $numerohorario)
			{
				$query_horarioeliminar = "SELECT *
				FROM horario 
				WHERE idgrupo='$idgrupo' 
				and codigodia='$codigodia2' 
				and horainicial='$horainicial2' 
				and horafinal='$horafinal2' 
				and codigosalon='$codigosalon2'";
				//echo $query_horarioeliminar;
				//exit();
				$horarioeliminar = mysql_query($query_horarioeliminar, $sala) or die(mysql_error());
				$row_horarioeliminar = mysql_fetch_assoc($horarioeliminar);
				$totalRows_horarioeliminar = mysql_num_rows($horarioeliminar);

				$query_delhorario1 = "DELETE FROM horariodetallefecha 
				WHERE idhorario = '".$row_horarioeliminar['idhorario']."'";
				//echo "<br>INSERT HORARIO: $query_delhorario<br>";
				$delhorario1 = mysql_query($query_delhorario1, $sala) or die(mysql_error());
				
				$query_delhorario = "DELETE FROM horario 
				WHERE idgrupo='$idgrupo' and codigodia='$codigodia2' and horainicial='$horainicial2' 
				and horafinal='$horafinal2' and codigosalon='$codigosalon2'";
				//echo "<br>INSERT HORARIO: $query_delhorario<br>";
				$delhorario = mysql_query($query_delhorario, $sala) or die(mysql_error());
                
                //Eliminar Horarrio
                 
                $SQL_h='SELECT
                        	s.SolicitudAsignacionEspacioId AS id
                        FROM
                        	AsociacionSolicitud a
                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                        WHERE
                        	a.SolicitudPadreId = "'.$Padre.'"
                        AND s.codigodia = "'.$codigodia2.'"
                        AND s.codigoestado = 100';
                        
                $R_Hijos = mysql_query($SQL_h, $sala) or die(mysql_error());  
                $row_hijos = mysql_fetch_assoc($R_Hijos);
                
                $Hijo = $row_hijos['id'];
                if($Hijo){
                    $C_FuncionesSolicitudEspacios->EliminarDia($userid,$Hijo,$codigodia2,'../../../EspacioFisico/');
                }
				break;
			}
			$cuentahorario++;
		}
        
        
	}
}

if(isset($_POST['sinhorario']))
{
  echo "<script language='javascript'>
     	window.opener.recargar('".$dirini."#".$grupo."');
		window.opener.focus();
		window.close();
	   </script>";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Eliminar Horario</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
-->
</style>
<script type="text/javascript">
function ValidarAcceso(id){
    if(id){
        var text = 'Seguro desea Modificar...? \n Tenga encuenta que los cambios afectaran las \n Solicitudes de Espacios Fisicos y \n La Asignacion de Salones...';
    }else{
        var text = 'Seguro desea Modificar...?';
    }
    
    if(confirm(text)){
        return true;
    }else{
        return false;
    }
}//function ValidarAcceso
</script>
</head>
<body>
<p align="center" class="Estilo3">ELIMINAR HORARIO</p>
<div align="center">
<form name="f1" action="eliminarhorario.php<?php echo $dirini;?>" method="post">
<font size="2" face="Tahoma">
<input type="hidden" name="grupo1" value="<?php echo $grupo ?>">
<input type="hidden" name="idgrupo1" value="<?php echo $idgrupo ?>">
<input type="hidden" name="numerohorassemanales1" value="<?php echo $numerohorassemanales ?>">
</font>
<table width="450" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Horas Semanales</td>
  	    <td align="center" class="Estilo1">
<?php 

if($numerohorassemanales < 10) 
	$horassemanales = "0".$numerohorassemanales.":00";
else
	$horassemanales = $numerohorassemanales.":00";
echo $horassemanales;
?>
  	    </font></td>
  	    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Asignadas</td>
  	    <td align="center" class="Estilo1">
<?php 
$query_asignadas = "SELECT h.horainicial, h.horafinal
FROM grupo g, horario h
WHERE g.idgrupo = h.idgrupo
AND g.idgrupo = '$idgrupo'";
//echo $query_asignadas;
$asignadas = mysql_query($query_asignadas, $sala) or die(mysql_error());
$totalRows_asignadas = mysql_num_rows($asignadas);

$tienehorario = false;
$cuentahoras = 0;

while($row_asignadas = mysql_fetch_assoc($asignadas))
{
	$horainicial=ereg_replace(":00$","",$row_asignadas['horainicial']);
	$horafinal=ereg_replace(":00$","",$row_asignadas['horafinal']);
	$horas[] = restarhoras($horafinal, $horainicial);
	$tienehorario = true;
	$cuentahoras++;
}

$horasasignadas = "00:00";
if($cuentahoras != 0)
{
	$contador = 0;
	while($contador <= $cuentahoras)
	{
		$horasasignadas =  sumarhoras($horasasignadas,$horas[$contador]);
		$contador++;
	}
}
echo $horasasignadas;
?>
  	    </font></td>
  	    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Faltantes</td>
  	    <td align="center" class="Estilo1">
<?php 
$horasfaltantes = restarhoras($horassemanales,$horasasignadas);
//echo $horasfaltantes;
if($horasfaltantes == "Función mal usada")
{
	echo "Sobrepaso las Horas Semanales";
}
else
{
	echo $horasfaltantes;
}
?>
          </font></td>
 </tr>
</table>
<table width="450" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
<?php
if($tienehorario)
{
?>
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td align="center">Día</td>
    <td align="center">Hora Inicial</td>
    <td align="center">Hora Final</td>
    <td align="center" bgcolor="#C5D5D6">Eliminación</td>
  </tr>
<?php
	$query_horarios = "SELECT * FROM horario h, dia d
	WHERE h.codigodia = d.codigodia
	AND h.idgrupo = '$idgrupo'
	order by 1,2,3,4";
	$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
	$totalRows_horarios = mysql_num_rows($horarios);		
	$numerohorario = 1;

	while($row_horarios = mysql_fetch_assoc($horarios))
	{
		$codigodia=$row_horarios['codigodia'];
		$nombredia=$row_horarios['nombredia'];
		$codigosalon=$row_horarios['codigosalon'];
		$horainicial=ereg_replace(":00$","",$row_horarios['horainicial']);
		$horafinal=ereg_replace(":00$","",$row_horarios['horafinal']);
             
?>
  <tr class="Estilo1">
	<td align="center"><?php echo " $nombredia ";?></td>
	<td align="center"><?php echo " $horainicial "; ?></td>
	<td align="center"><?php echo " $horafinal "; ?></td>
	<td align="center">
    
	<input type="radio" name="numerohorario1" value="<?php echo $numerohorario; ?>" <?php if($numerohorario == 1) echo "checked";?>>
	&nbsp;
	  </font></td>
  </tr>
<?php
		$numerohorario++;
	}
}

if(!isset($_POST['eliminar']))
{
?>
  <tr>
  	<td colspan="4" align="center">
      <font size="2" face="Tahoma">
<?php
	if($tienehorario)
	{
		if(!isset($_POST['accion']))
		{ 
?>
&nbsp;
<input type="submit" name="Eliminar" value="Eliminar" onclick="return ValidarAcceso('<?PHP echo $Padre?>');">
<?php
		}
	}
	else
	{
?>
<input type="submit" name="sinhorario" value="Aceptar">
<?php
	}
?>
      </font></td>
  </tr>
  <tr>
  	<td colspan="4" align="center"><font size="2" face="Tahoma">
  	  <input type="submit" name="sinhorario" value="Cerrar">
    </font></td>
  </tr>
<?php
}
?>
</table>
</form>
</div>
</body>
</html>