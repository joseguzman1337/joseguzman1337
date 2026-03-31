<?php 
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php'); 
require_once("funcioneshora.php");
mysql_select_db($database_sala, $sala); 
session_start();
require_once('seguridadmateriasgrupos.php');
$formulariovalido=1;
$codigocarrera = $_SESSION['codigofacultad'];
$codigomateria = $_GET['codigomateria1'];
$carrera = $_GET['carrera1'];
$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
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
if(isset($_POST['Aceptar']))
{
	echo "<script language='javascript'>
			window.opener.recargar('".$dirini."#".$grupo."');
			window.opener.focus();
			window.close();
	  </script>";
}
/********* COMBO DIA **************/
$query_dia = "SELECT * FROM dia";
$dia = mysql_query($query_dia, $sala) or die(mysql_error());
$row_dia = mysql_fetch_assoc($dia);
$totalRows_dia = mysql_num_rows($dia);
/********* COMBO TIPO SALON **************/
$query_tiposalon = "SELECT t.* FROM tiposalon t 
						WHERE t.codigoestado=100 AND 
						(t.codigotiposalon='0' OR t.codigotiposalon IN 
								(SELECT codigotiposalon FROM ClasificacionEspacios WHERE codigoestado=100)
						)
						ORDER BY nombretiposalon ";
$tiposalon = mysql_query($query_tiposalon, $sala) or die("query_tiposalon");
$row_tiposalon = mysql_fetch_assoc($tiposalon);
$totalRows_tiposalon = mysql_num_rows($tiposalon);

$query_group = "SELECT fechainiciogrupo,fechafinalgrupo
FROM grupo 
where idgrupo = $idgrupo";
$group = mysql_query($query_group, $sala) or die("query_group");
$row_group = mysql_fetch_assoc($group);
$totalRows_group = mysql_num_rows($group);

$fechaini = $row_group['fechainiciogrupo'];
$fechafin = $row_group['fechafinalgrupo'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Adicionar Horario</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
-->
/*@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);*/
</style>
<link rel="stylesheet" type="text/css" href="../../../funciones/calendario_nuevo/calendar-win2k-1.css">
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>
<body>
<p align="center" class="Estilo3">ADICIONAR HORARIO</p>
<form name="f1" action="adicionarhorario.php<?php echo $dirini;?>" method="post">
  <div align="center">
    <font face="Tahoma">
    <input type="hidden" name="grupo1" value="<?php echo $grupo ?>">
    <input type="hidden" name="idgrupo1" value="<?php echo $idgrupo ?>">
    <input type="hidden" name="numerohorassemanales1" value="<?php echo $numerohorassemanales ?>">
    </font>
    <table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
  	    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Horas Semanales</td>
  	    <td align="center"><font size="2" face="Tahoma">
  	      <?php
if($numerohorassemanales < 10) 
	$horassemanales = "0".$numerohorassemanales.":00";
else
	$horassemanales = $numerohorassemanales.":00";
echo $horassemanales;
?>
  	    </font></td>
  	    <td align="center" bgcolor="#C5D5D6" class="Estilo2">Asignadas</td>
  	    <td align="center"><font size="2" face="Tahoma">
  	      <?php 
$query_asignadas = "SELECT h.horainicial, h.horafinal,fechainiciogrupo,fechafinalgrupo
FROM grupo g, horario h
WHERE g.idgrupo = h.idgrupo
AND g.idgrupo = '$idgrupo'";

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
  	    <td colspan="2" align="center"><font size="2" face="Tahoma"><strong> </strong>
<?php 
$horasfaltantes = restarhoras($horassemanales,$horasasignadas);
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
    <font face="Tahoma">
    </font>
<table width="700" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
        <td align="center">Día</td>
        <td align="center">Hora Inicial</td>
        <td align="center">Hora Final</td>
		<td align="center">Tipo Salón</td>
		<td align="center">Fecha Inicial</td>
		<td align="center">Fecha Final</td>
	 </tr>
<?php
if($tienehorario)
{  
?>
  <?php
	$query_horarios = "SELECT * 
	FROM horario h, dia d, tiposalon t,horariodetallefecha hd
	WHERE h.codigodia = d.codigodia
	AND h.idgrupo = '$idgrupo'
	and hd.idhorario = h.idhorario
	and h.codigotiposalon = t.codigotiposalon
	and h.codigoestado like '1%'
	and hd.codigoestado like '1%' 
	order by 1,2,3,4";
	$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
	$totalRows_horarios = mysql_num_rows($horarios);		
	//echo $query_horarios ;
	while($row_horarios = mysql_fetch_assoc($horarios))
	{
		$nombredia=$row_horarios['nombredia'];
		$horainicial=ereg_replace(":00$","",$row_horarios['horainicial']);
		$horafinal=ereg_replace(":00$","",$row_horarios['horafinal']);
?>
	  <tr class="Estilo1">
		<td align="center"><?php echo " $nombredia ";?></td>
		<td align="center"><?php echo " $horainicial "; ?></td>
		<td align="center"><?php echo " $horafinal "; ?></td>
		<td align="center"><?php echo $row_horarios['nombretiposalon'];?></td>
		<td align="center"><?php echo $row_horarios['fechadesdehorariodetallefecha']; ?></td>
		<td align="center"><?php echo $row_horarios['fechahastahorariodetallefecha']; ?></td>
	  </tr>
<?php
	}
}			 
if(!isset($_POST['accion']))
{
	//if($horassemanales != $horasasignadas)
	//{
?>
      <input type="hidden" name="accion" value="adicionarhorario">
      <tr>
  	    <td align="center" colspan="6"><font face="Tahoma"><input type="submit" name="aceptar" value="Adicionar Horario"></font></td> 
      </tr>
    <?php
	//}
}
else
{
	if($_POST['accion']=="adicionarhorario" || $_POST['accion']=="aceptarhorario")
	{
?>
      <tr class="Estilo1">
	    <td><div align="center">
	        <select name="codigodia1">
              <option value="0" <?php if (!(strcmp(0, $_POST['codigodia1']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
		do
		{    
?>
              <option value="<?php echo $row_dia['codigodia']?>"<?php if (!(strcmp($row_dia['codigodia'], $_POST['codigodia1']))) {echo "SELECTED";} ?>><?php echo $row_dia['nombredia']?></option>
              <?php
		}
		while ($row_dia = mysql_fetch_assoc($dia));
		$totalRows_dia = mysql_num_rows($dia);
		if($totalRows_dia > 0)
		{
			mysql_data_seek($dia, 0);
			$row_dia = mysql_fetch_assoc($dia);
		}
?>
            </select>
	        <font color="#FF0000">
            <?php
		if(isset($_POST['codigodia1']))
		{
			$codigodia = $_POST['codigodia1'];
			$imprimir = true;
			$diarequerido = validar($codigodia,"combo",$error1,&$imprimir);
			$formulariovalido = $formulariovalido*$diarequerido;
		}
?>
        </div></td>
        <td><div align="center">
            <input type="text" name="hinicial1" value="<?php if(isset($_POST['hinicial1'])) echo $_POST['hinicial1'];?>" style="width: 80px">
            <font color="#FF0000">
            <?php
		if(isset($_POST['hinicial1']))
		{
			$hinicial = $_POST['hinicial1'];
			$imprimir = true;
			$hinihora = validar($hinicial,"hora",$error2,&$imprimir);
			$formulariovalido = $formulariovalido*$hinihora;
		}
?>
        </div></td>
        <td><div align="center">
            <input type="text" name="hfinal1" value="<?php if(isset($_POST['hfinal1'])) echo $_POST['hfinal1'];?>" style="width: 80px">
            <font color="#FF0000">
            <?php
		if(isset($_POST['hfinal1']))
		{
			$hfinal = $_POST['hfinal1'];
			$imprimir = true;
			$hfinhora = validar($hfinal,"hora",$error2,&$imprimir);
			$formulariovalido = $formulariovalido*$hfinhora;
		}
?>
        </div></td>
		<td><div align="center">
            <select name="codigotiposalon1">
              <option value="0" <?php if (!(strcmp(0, $_POST['codigotiposalon1']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
	do
	{    
?>
              <option value="<?php echo $row_tiposalon['codigotiposalon']?>"<?php if (!(strcmp($row_tiposalon['codigotiposalon'], $_POST['codigotiposalon1']))) {echo "SELECTED";} ?>><?php echo $row_tiposalon['nombretiposalon']?></option>
              <?php
	}
	while ($row_tiposalon = mysql_fetch_assoc($tiposalon));
	$totalRows_tiposalon = mysql_num_rows($tiposalon);
	if($totalRows_tiposalon > 0)
	{
		mysql_data_seek($tiposalon, 0);
		$row_tiposalon = mysql_fetch_assoc($tiposalon);
	}
?>
            </select>
<?php
	if(isset($_POST['codigotiposalon1']))
	{
		$codigotiposalon = $_POST['codigotiposalon1'];
		//echo $codigotiposalon;
		$imprimir = true;
		$tiposalonrequerido = validar($codigotiposalon,"combo",$error1,&$imprimir);
		$formulariovalido = $formulariovalido*$tiposalonrequerido;
	}

?>
    </div></td>

       <td><input type="text" id="fechainicial" name="fechainicial" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php if ($_POST['fechainicial'] <> "") echo $_POST['fechainicial']; else echo $fechaini; ?>" ></td>
	  <td><input type="text" id="fechafinal" name="fechafinal"   style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php if ($_POST['fechafinal'] <> "") echo $_POST['fechafinal']; else echo $fechafin; ?>" >
      </td>

		<script type="text/javascript">
			Calendar.setup(
			{ inputField : "fechainicial", // ID of the input field
				ifFormat : "%Y-%m-%d", // the date format
				range : [1900,9999]
				
			});
		</script>
		<script type="text/javascript">
			Calendar.setup(
			{ inputField : "fechafinal", // ID of the input field
				ifFormat : "%Y-%m-%d", // the date format
				range : [1900,9999]
			});
		</script>
<?php
		if(isset($_POST['hinicial1']) && isset($_POST['hfinal1']))
		{
			$hora = 1;
			$res_hora = restarhoras($_POST['hfinal1'],$_POST['hinicial1']);
			if($res_hora == "00:00" || $res_hora == "Función mal usada")
			{
				echo '<tr><td colspan="6" align="center"><font size="1" face="Tahoma" color="#FF0000">La hora que digito no es correcta, la hora final debe ser mayor a la hora inicial</font></td></tr>';
				$hora = 0;
			}
			else
			{
				if(horamayor($res_hora,$horasfaltantes))
				{
					echo '<tr><td colspan="6" align="center"><font size="1" face="Tahoma" color="#FF0000">La hora que digito no es correcta, sobrepasa las horas faltantes por asignar</font></td></tr>';
					//$hora = 0;
					$sobrepashorasfaltantes = true;
				}
			}
			if(tienecruces($idgrupo,$sala,$_POST['hinicial1'],$_POST['hfinal1'],$_POST['codigodia1']))
			{
				echo '<tr><td colspan="6" align="center"><font size="1" face="Tahoma" color="#FF0000">El horario que digito se cruza con los ya creados, debe modificar.</font></td></tr>';
				$hora = 0;
		
		    }
			
			if ($_POST['fechainicial'] > $_POST['fechafinal'])
			  {
			    echo '<tr><td colspan="6" align="center"><font size="1" face="Tahoma" color="#FF0000">Fecha Inicial Mayor a la Fecha Final</font></td></tr>';
			    $hora = 0;
			  }	 
			if ($_POST['fechainicial'] == "" or $_POST['fechafinal'] == "")
			  {
			    echo '<tr><td colspan="6" align="center"><font size="1" face="Tahoma" color="#FF0000">Debe digitar las fechas de la duración de cada horario</font></td></tr>';
			    $hora = 0;
			  }	     
			$formulariovalido = $formulariovalido*$hora;
		}
?>
      </tr>
      <tr>
  	    <td align="center" colspan="6" valign="middle">
	      <font face="Tahoma">
	      <input type="hidden" name="accion" value="aceptarhorario">
	      <input type="submit" value="Aceptar Horario">
	      &nbsp;
	      <input type="button" name="cancelar" value="Cancelar Horario" onClick="cancelarhorario()">
	      </font></td> 
      </tr>
<?php
		if($formulariovalido == 1)
		{
			if($sobrepasahoras)
			{
/*?>
				 <script language="javascript">
					if(!confirm("¿Desea agregar el horario así el número de horas no corresponda?"))
					{
						history.go(-1);
					}
				</script>
<?php
*/			}
			$codigodia=$_POST['codigodia1'];
			$query_horarios = "SELECT * FROM dia d, salon s, tiposalon t, sede se
			WHERE s.codigotiposalon = t.codigotiposalon
			AND s.codigosede = se.codigosede
			AND s.codigosalon = '1'
            AND d.codigodia = '$codigodia'";
			$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
			$row_horarios = mysql_fetch_assoc($horarios);
			$totalRows_horarios = mysql_num_rows($horarios);		
			if($totalRows_horarios != 0)
			{
				//echo "entro";
				$codigodia = $_POST['codigodia1'];
				$horainicial = $_POST['hinicial1'];
				$horafinal = $_POST['hfinal1'];
				$codigotiposalon = $_POST['codigotiposalon1'];
				$codigosalon = 1;
				$query_addhorario = "
				INSERT INTO horario(idhorario, idgrupo, codigodia, horainicial, horafinal, codigotiposalon, codigosalon, codigoestado) 
				VALUES(0, '$idgrupo', '$codigodia', '$horainicial', '$horafinal', '$codigotiposalon', '$codigosalon', '100')";
				//echo "<br>INSERT HORARIO: $query_addhorario<br>";
				$addhorario = mysql_query($query_addhorario, $sala) or die(mysql_error());
				
				$idhorario = mysql_insert_id();

				$query_inshorariodetallefecha = "INSERT INTO horariodetallefecha(idhorariodetallefecha, idhorario, fechadesdehorariodetallefecha, fechahastahorariodetallefecha, codigoestado) 
				VALUES(0, '$idhorario', '".$_REQUEST['fechainicial']."', '".$_REQUEST['fechafinal']."', '100')";
				//echo "<h3>$query_inshorariodetallefecha</h3>";
				$inshorariodetallefecha = mysql_query($query_inshorariodetallefecha, $sala) or die("$query_inshorariodetallefecha");
				
				echo '<script language="JavaScript">
						window.location.reload("adicionarhorario.php'.$dirini.'&grupo1='.$grupo.'&numerohorassemanales1='.$numerohorassemanales.'&idgrupo1='.$idgrupo.'");
					</script>';
			}
		}
	}
}
?>
      <tr>
  	    <td colspan="6" align="center">
          <font face="Tahoma">
<?php
if($tienehorario && !isset($_POST['accion']))
{
?>
&nbsp;
<input type="submit" name="Aceptar" value="Aceptar">
<?php
}
else
{
	if(!isset($_POST['accion']))
	{
?>
&nbsp;
<input type="button" name="Cancelar" value="Cerrar" onClick="window.close()">
<?php
	}
}
?>
          </font></td>
      </tr>
    </table>
  </div>  
</form>
</body>
<?php
echo '
<script language="JavaScript">
function cancelarhorario()
{
	window.location.reload("adicionarhorario.php'.$dirini.'&grupo1='.$grupo.'&numerohorassemanales1='.$numerohorassemanales.'&idgrupo1='.$idgrupo.'");
}
</script>';
?>
</html>

