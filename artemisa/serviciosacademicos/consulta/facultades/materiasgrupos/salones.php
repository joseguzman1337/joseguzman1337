<?php 
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php'); 
require_once("funcioneshora.php");
mysql_select_db($database_sala, $sala); 
session_start();
require_once('seguridadmateriasgrupos.php');
//$formulariovalido=1;
$codigocarrera = $_SESSION['codigofacultad'];
$codigomateria = $_GET['codigomateria1'];
$carrera = $_GET['carrera1'];
$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
if(isset($_GET['grupo1']))
{
	$grupo=$_GET['grupo1'];
	$idgrupo=$_GET['idgrupo1'];
}
$tipofiltro = "";
if(isset($_GET['Aceptar']))
{
	// Le coloca el salon al grupo
	foreach($_GET as $llave => $valor)
	{
		//echo "<br> Por fuera $llave => $valor <br>";
		// Toma los dias
		if(ereg("coddia:[0-9]+",$llave))
		{
			$dias[] = $valor;
		}
		else if(ereg("hinicial:[0-9]+",$llave))
		{
			$hiniciales[] = $valor;
		}
		else if(ereg("hfinal:[0-9]+",$llave))
		{
			$hfinales[] = $valor;
		}
		else if(ereg("salonseleccionado:[0-9]+",$llave))
		{
			$salones[] = $valor;
			//echo $valor;
		}
	}
	foreach($dias as $llave => $codigodia)
	{
		// Selecciona el tipo de salon que fue seleccionado para modificarlo en el horario
		// Esto lo hace para los salones que son diferentes del sin asignar
		// Si el salon era diferente a sin asignar y se le pone sin asignar entra
		$query_seltiposalon = "select s.codigotiposalon
		from salon s
		where s.codigosalon like '".$salones[$llave]."'";
		//echo $query_selsalones;
		$seltiposalon = mysql_query($query_seltiposalon, $sala) or die("$query_seltiposalon");
		$totalRows_seltiposalon = mysql_num_rows($seltiposalon);
		$row_seltiposalon = mysql_fetch_assoc($seltiposalon);
		if($salones[$llave] != 1)
		{
			$query_updhorario = "UPDATE horario 
			SET codigotiposalon = '".$row_seltiposalon['codigotiposalon']."', codigosalon = '".$salones[$llave]."'
			WHERE idgrupo = '$idgrupo'
			and codigodia = '$codigodia'
			and horainicial = '".$hiniciales[$llave]."'
			and horafinal = '".$hfinales[$llave]."'";
		}
		else
		{
			$query_updhorario = "UPDATE horario 
			SET codigosalon = '".$salones[$llave]."'
			WHERE idgrupo = '$idgrupo'
			and codigodia = '$codigodia'
			and horainicial = '".$hiniciales[$llave]."'
			and horafinal = '".$hfinales[$llave]."'";
		}
		//echo "<br>UPDATE $llave: $query_updhorario <br>";
		$updhorario = mysql_query($query_updhorario, $sala) or die("$query_updhorario");
	}
	//exit();
	echo "<script language='javascript'>
			window.opener.recargar('".$dirini."#".$grupo."');
			window.opener.focus();
			window.close();
	  </script>";
}
if(isset($_GET['filtrado']))
{
	if($_GET['filtrado'] == "Aceptar")
	{
		if(isset($_GET['selectsede']) && isset($_GET['selectsalon']) && isset($_GET['selectcupo']))
		{
			$tipofiltro = "POR SEDE, SALON Y CUPO";	
		}
		else if(isset($_GET['selectsede']) && isset($_GET['selectsalon']))
		{
			$tipofiltro = "POR SEDE Y SALON";	
		}
		else if(isset($_GET['selectsede']) && isset($_GET['selectcupo']))
		{
			$tipofiltro = "POR SEDE Y CUPO";	
		}
		else if(isset($_GET['selectsede']))
		{
			$tipofiltro = "POR SEDE";	
		}
		else if(isset($_GET['selectsalon']) && isset($_GET['selectcupo']))
		{
			$tipofiltro = "POR SALON Y CUPO";	
		}
		else if(isset($_GET['selectsalon']))
		{
			$tipofiltro = "POR SALON";	
		}
		else if(isset($_GET['selectcupo']))
		{
			$tipofiltro = "POR CUPO";	
		}
		else
		{
			$tipofiltro = "SIN FILTRAR";
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Salones</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
-->
</style>
</head>
<body>
<div align="center">
<form name="f1" action="salones.php<?php echo "$dirini&filtrado=".$_GET['filtrado']."";?>" method="get">
<input type="hidden" name="grupo1" value="<?php echo $grupo ?>">
<input type="hidden" name="idgrupo1" value="<?php echo $idgrupo ?>">
<?php
if(!isset($_GET['Filtrar']))
{
?>
<p align="center" class="Estilo3">SELECCION DE SALONES <?php echo $tipofiltro;?></p>
<table width="400" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <?php 
			// Mira los horarios asignados
			if($_SESSION['MM_Username'] == "adminplantafisica")
			{
				$query_horarios = "SELECT h.codigodia, h.codigodia, h.horainicial, h.horafinal, d.nombredia, se.nombresede, s.nombresalon, s.codigosalon, h.codigotiposalon, t.nombretiposalon, g.maximogrupo 
				FROM horario h, dia d, salon s, tiposalon t, sede se, grupo g
				WHERE h.codigodia = d.codigodia
				AND h.codigosalon = s.codigosalon
				AND s.codigotiposalon = t.codigotiposalon
				AND s.codigosede = se.codigosede
				AND h.idgrupo = '$idgrupo'
				and g.idgrupo = h.idgrupo
				and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
				and h.codigotiposalon <> '14'
				order by 1,2,3,4";
			}
			if($_SESSION['MM_Username'] == "Adminsoporte")
			{
				$query_horarios = "SELECT h.codigodia, h.codigodia, h.horainicial, h.horafinal, d.nombredia, se.nombresede, s.nombresalon, s.codigosalon, h.codigotiposalon, t.nombretiposalon, g.maximogrupo 
				FROM horario h, dia d, salon s, tiposalon t, sede se, grupo g
				WHERE h.codigodia = d.codigodia
				AND h.codigosalon = s.codigosalon
				AND s.codigotiposalon = t.codigotiposalon
				AND s.codigosede = se.codigosede
				AND h.idgrupo = '$idgrupo'
				and g.idgrupo = h.idgrupo
				and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
				and h.codigotiposalon = '14'
				order by 1,2,3,4";
			}
			$horarios = mysql_query($query_horarios, $sala) or die(mysql_error());
			$totalRows_horarios = mysql_num_rows($horarios);		
			//echo "NUMERO HORARIOS: $totalRows_horarios<br>";
			//echo "<br> $query_horarios<br>";
			if($totalRows_horarios != 0)
			{
?>
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td align="center">Día</td>
      <td align="center">Hora Inicial</td>
      <td align="center">Hora Final</td>
      <!-- <td align="center" class="estilo2"><strong>Sede</strong></font></td> -->
      <td align="center">Sal&oacute;n</td>
	  <!-- <td align="center" class="estilo2"><strong>Tipo</strong></font></td> -->
    </tr>
<?php
				$numerohorario = 0;
				while($row_horarios = mysql_fetch_assoc($horarios))
				{
					$horario['nombredia']=$row_horarios['nombredia'];
					$horario['codigodia']=$row_horarios['codigodia'];
					//echo "CDIA: ".$horario['codigodia'];
					$horario['horainicial']=ereg_replace(":00$","",$row_horarios['horainicial']);
					//echo "<br>hini:: ".$horario['horainicial'];
					$horario['horafinal']=ereg_replace(":00$","",$row_horarios['horafinal']);
					$horario['nombresede']=$row_horarios['nombresede'];
					$horario['nombresalon']=$row_horarios['nombresalon'];
					$horario['codigosalon']=$row_horarios['codigosalon'];
					$horario['codigotiposalon']=$row_horarios['codigotiposalon'];
					$horario['nombretiposalon']=$row_horarios['nombretiposalon'];
					//$objetos[$numobj]->horariogrupo($horario,$horario);
					//$objetos[$numobj]->horariohistorico($horario);
					// Selecciona los salones a quitar que tengan el mismo tipo y se crucen en horarios
					$query_salonesaquitar = "select distinct s.codigosalon, s.nombresalon
					from salon s, horario h, grupo g
					where s.codigosalon = h.codigosalon
					and h.idgrupo = g.idgrupo
					and g.codigoestadogrupo like '1%'
					and h.codigodia = '".$row_horarios['codigodia']."'
					and h.horainicial >= '".$row_horarios['horainicial']."'
					and h.horafinal <= '".$row_horarios['horafinal']."'
					and s.codigotiposalon = '".$row_horarios['codigotiposalon']."'
					and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
					and s.codigosalon <> '1'";
					//echo "<br>A QUITAR".$query_salonesaquitar."<br>";
					$salonesaquitar = mysql_query($query_salonesaquitar, $sala) or die("$query_salonesaquitar");
					$totalRows_salonesaquitar = mysql_num_rows($salonesaquitar);
					$quitarsalones = "";
					if($totalRows_salonesaquitar != "")
					{
						while($row_salonesaquitar = mysql_fetch_assoc($salonesaquitar))
						{
							$quitarsalones = "$quitarsalones and s.codigosalon <> '".$row_salonesaquitar['codigosalon']."'";
						}
						//echo $quitarsalones;
						/********* Seleccion de los salones sin cruces y por algun filtro **************/
						//echo $tipofiltro;
						if($tipofiltro == "SIN FILTRAR")
						{
							//echo "entro uno";
							// Selecciona los salones que sirven
							$query_selsalones = "select s.codigosalon, s.nombresalon
							from salon s
							where s.codigotiposalon = '".$row_horarios['codigotiposalon']."'
							$quitarsalones
							order by 1";
							// and s.cupomaximosalon >= '".$row_horarios['maximogrupo']."'
							//echo "<br>SIN FILTRO = $query_selsalones<br>";
						}
						else
						{
							$query_selsalones = "select s.codigosalon, s.nombresalon
							from salon s
							where s.codigotiposalon like '".$row_horarios['codigotiposalon']."%'
							$quitarsalones
							and s.codigosede like '".$_GET['selectsede']."%'
							order by 1";
							// and s.cupomaximosalon >= ".$row_horarios['maximogrupo']."
							// echo "$query_selsalones";
						}
					}
					//exit();
					else
					{
						// Selecciona todos los salones si no tiene que quitar ninguno
						if($tipofiltro == "SIN FILTRAR")
						{
							//echo "entro dos";
							$query_selsalones = "select s.codigosalon, s.nombresalon
							from salon s
							where s.codigotiposalon = '".$row_horarios['codigotiposalon']."'
							order by 1";
							// s.cupomaximosalon >= '".$row_horarios['maximogrupo']."'
							//echo "<br>$query_selsalones<br>";
						}
						else
						{
							$query_selsalones = "select s.codigosalon, s.nombresalon
							from salon s
							where s.codigotiposalon like '".$row_horarios['codigotiposalon']."%'
							and s.codigosede like '".$_GET['selectsede']."%'
							order by 1";
							// and s.cupomaximosalon >= ".$row_horarios['maximogrupo']."
							//echo "$query_selsalones";
						}
					}
					//echo $query_selsalones;
					$selsalones = mysql_query($query_selsalones, $sala) or die("$query_selsalones");
					$totalRows_selsalones = mysql_num_rows($selsalones);
					//exit();
?>
    <tr class="Estilo1">
	  <td align="center">
	  	<input type="hidden" name="<?php echo "coddia:$numerohorario"; ?>" value="<?php echo $row_horarios['codigodia'];?>">	
		<?php echo " ".$horario['nombredia']." ";?></strong>
	  </td>
	  <td align="center">
	  	<input type="hidden" name="<?php echo "hinicial:$numerohorario"; ?>" value="<?php echo $row_horarios['horainicial'];?>">
		<?php echo " ".$horario['horainicial']." "; ?>
	  </td>
	  <td align="center">
	  	<input type="hidden" name="<?php echo "hfinal:$numerohorario"; ?>" value="<?php echo $row_horarios['horafinal'];?>">	
		<?php echo " ".$horario['horafinal']." "; ?>
	  </td>
	  <td align="center">
		<strong>
		<select name="<?php echo "salonseleccionado:$numerohorario"; ?>">
			<option value="<?php $sinasignar = false; echo $row_horarios['codigosalon']; ?>" selected><?php if($row_horarios['codigosalon'] != 1) echo " ".$row_horarios['codigosalon']." "; else { echo " ".$row_horarios['nombresalon']." "; $sinasignar = true;	}?></option>
<?php
					$numerohorario++;
					if($totalRows_selsalones != "")
					{
						while($row_selsalones = mysql_fetch_assoc($selsalones))
						{
							if($row_selsalones['codigosalon'] == '1')
							{
								$sinasignar = true; 
?>
			<option value="<?php echo $row_selsalones['codigosalon']; ?>"><?php 
								echo " ".$row_selsalones['nombresalon']." "; 
					?></option>			
<?php
							}
							else if($row_horarios['codigosalon'] == $row_selsalones['codigosalon'])
							{
								continue;
							}
							else
							{							
?>
			<option value="<?php echo $row_selsalones['codigosalon']; ?>"><?php 
								echo " ".$row_selsalones['codigosalon']." "; 
					?></option>			
<?php
							}	
						}
						if(!$sinasignar)
						{
?>
			<option value="1">Sin Asignar</option>			
<?php
						}
					}
/*					if($tipofiltro == "" || $tipofiltro == "SIN FILTRAR")
					{
?>			
			<option value="<?php echo 1; ?>"><?php echo " Sin Asignar"; ?></option>			
<?php
					}
*/
?>
		</select>
		</strong>
		</td>
<?php
?>
	</tr>
<?php 
				}
?>
	<tr>
	    <td colspan="6" align="center">
		  <input type="submit" name="Aceptar" value="Aceptar">
          <input type="button" name="cancelar" value="Cancelar" onClick="window.close()">
          </font>
		</td>
    </tr>
<?php
			}
//			else
	//		{
?>
   <!-- <tr>
     <td align="center" colspan="6">
      <input type="submit" name="Filtrar" value="Filtrar"></font> 
	  </td> 
	</tr> -->
<?php
	//			$pendiente = true;
//			}
?>
  </table>
<?php
}
else
{
?>
<p class="Estilo3">SELECCIONE EL FILTRO</p>
<table width="400" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td align="center">Sede
        <input type="checkbox" name="checksede" onClick="estadosede()"></td>
      <td align="center" >Tipo de Salón
        <input type="checkbox" name="checksalon" onClick="estadosalon()"></td>
      </tr>
    <tr class="Estilo1">
	    <td align="center">
<?php
	// Seleccion de las sedes
	$query_selsede = "select s.codigosede, s.nombresede
	from sede s";
	//echo $query_selsalones;
	$selsede = mysql_query($query_selsede, $sala) or die("$query_selsede");
	$totalRows_selsede = mysql_num_rows($selsede);
	if($totalRows_selsede != "")
	{
?>
          <select name="selectsede" disabled style="font-size: 9px">
<?php
		while($row_selsede = mysql_fetch_assoc($selsede))
		{
?>
            <option value="<?php echo $row_selsede['codigosede']; ?>"><?php echo $row_selsede['nombresede']; ?></option>
<?php
		}
?>
         </select>
<?php
	}
?>
	    </td>
	    <td align="center">
<?php
	// Seleccion de las sedes
	$query_selsalon = "select t.codigotiposalon, t.nombretiposalon
	from tiposalon t";
	//echo $query_selsalones;
	$selsalon = mysql_query($query_selsalon, $sala) or die("$query_selsalon");
	$totalRows_selsalon = mysql_num_rows($selsalon);
	if($totalRows_selsalon != "")
	{
?>
          <select name="selectsalon" disabled style="font-size: 9px">
<?php
		while($row_selsalon = mysql_fetch_assoc($selsalon))
		{
?>
            <option value="<?php echo $row_selsalon['codigotiposalon']; ?>"><?php echo $row_selsalon['nombretiposalon']; ?></option>
<?php
		}
?>
         </select>
<?php
	}
?>
        </td>
	 </tr>
	<tr>
	  <td colspan="6" align="center"> 
       <input type="submit" name="filtrado" value="Aceptar">
          <input type="button" name="cancelar" value="Cancelar" onClick="history.go(-1)">
          </font>
	  </td>
    </tr>
   </table>
<?php
}
?>
</form>
</div>
</body>
<?php
echo '
<script language="JavaScript">
function cancelarhorario()
{
	window.location.reload("adicionarhorario.php'.$dirini.'&grupo1='.$grupo.'&idgrupo1='.$idgrupo.'");
}
</script>';
?>
<script language="JavaScript">
function estadosede()
{
	if(document.f1.checksede.checked == true)
	{
		document.f1.selectsede.disabled = false;
	}
	else
	{
		document.f1.selectsede.disabled = true;
	}
}
function estadosalon()
{
	if(document.f1.checksalon.checked == true)
	{
		document.f1.selectsalon.disabled = false;
	}
	else
	{
		document.f1.selectsalon.disabled = true;
	}
}
function estadocupo()
{
	if(document.f1.checkcupo.checked == true)
	{
		document.f1.textcupo.disabled = false;
	}
	else
	{
		document.f1.textcupo.disabled = true;
	}
}
</script>
</html>