<?php
// ESTE SCRIPT GENERA UNA NUEVA ORDEN DEBIDO A QUE SE MODIFICO LA FECHA DE PAGO DE LA ORDEN

require_once('../../../Connections/sala2.php'); 	
require_once('../../../funciones/validacion.php'); 	
require_once('errores_generarnuevaorden.php'); 	
session_start();
mysql_select_db($database_sala, $sala);
$formulariovalido = 1;
?>
<html>
<head>
<title>Generar Nueva Orden</title>
</head>
<body>
<div align="center">
<form action="generarnuevaordenmodificacionfecha.php" method="post">
<p><strong><font size="2" face="Tahoma">MODIFICAR ORDEN DE MATR&Iacute;CULA POR CAMBIO DE FECHA</font></strong></p>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
	<td bgcolor="#C5D5D6"><font size="2" face="Tahoma"><strong>Documento estudiante : </strong></font></td>
	<td><font size="2" face="Tahoma">
	  <input type="text" name="codigo" size="10" value="<?php echo $_POST['codigo'];?>">
	  <font color="#FF0000">
      <?php
					if(isset($_POST['codigo']))
					{
						$codigo = $_POST['codigo'];
						$imprimir = true;
						$codnum = validar($codigo,"numero",$error1,&$imprimir);
						$codnum = validar($codigo,"requerido",$error5,&$imprimir);
						$formulariovalido = $formulariovalido*$codnum;
					}
?>
	  </font></font>
	</td>
</tr>
<tr>
	<td bgcolor="#C5D5D6"><font size="2" face="Tahoma"><strong>Número de orden : </strong></font></td>
	<td><font size="2" face="Tahoma">
	  <input type="text" name="orden" size="10" value="<?php echo $_POST['orden'];?>">
	  <font color="#FF0000">
	  <?php
					if(isset($_POST['orden']))
					{
						$orden = $_POST['orden'];
						$imprimir = true;
						$ordnum = validar($orden,"numero",$error1,&$imprimir);
						$ordnum = validar($orden,"requerido",$error6,&$imprimir);
						$formulariovalido = $formulariovalido*$ordnum;
					}
?>
	  </font></font></td>
</tr>
<tr>
	<td bgcolor="#C5D5D6"><font size="2" face="Tahoma"><strong>Porcentaje a pagar: </strong></font></td>
	<td><font size="2" face="Tahoma">
	  <input type="text" name="porcentaje" size="10" value="<?php echo $_POST['porcentaje'];?>">
	  <font color="#FF0000">
	  <?php
					if(isset($_POST['porcentaje']))
					{
						$porcentaje = $_POST['porcentaje'];
						$imprimir = true;
						$vporcentaje = validar($porcentaje,"porcentaje",$error2,&$imprimir);
						$formulariovalido = $formulariovalido*$vporcentaje;
					}
?>
	  </font></font></td>
</tr>
<tr>
	<td bgcolor="#C5D5D6"><font size="2" face="Tahoma"><strong>Fecha de pago: </strong></font></td>
	<td><font size="2" face="Tahoma">
	  <input type="text" name="fecha" size="10" value="<?php echo $_POST['fecha'];?>">
	  <font color="#FF0000">
	  <?php
					if(isset($_POST['fecha']))
					{
						$fecha = $_POST['fecha'];
						$imprimir = true;
						$vfecha = validar($fecha,"fecha",$error3,&$imprimir);
						//echo "<br>";
						$vfecha = validar($fecha,"fechamayor",$error4,&$imprimir);
						$formulariovalido = $formulariovalido*$vfecha;
					}
?>
	  </font></font></td>
</tr>
<tr>
	<td colspan="2" align="center"><font size="2" face="Tahoma">
	  <input type="submit" name="aceptar" value="Aceptar">
		</font>
	</td>
</tr>
</table>
</form>
<?php
if(isset($_POST['aceptar']))
{
	//echo "Formula: $formulariovalido";
	if($formulariovalido == 1)
	{
		$query_ordenpago = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.numerocohorte, 
		e.codigoestudiante, e.codigocarrera, e.codigotipoestudiante, o.numeroordenpago, p.codigoperiodo, o.codigoestadoordenpago
		from estudiante e, ordenpago o, periodo p,estudiantegeneral eg,estudiantedocumento ed
		where e.idestudiantegeneral = eg.idestudiantegeneral 
		and e.codigoestudiante = o.codigoestudiante
		and ed.numerodocumento = '$codigo'
		and e.idestudiantegeneral = ed.idestudiantegeneral
		and o.numeroordenpago = '$orden'
		and o.codigoestadoordenpago like '1%'
		and p.codigoperiodo = o.codigoperiodo
		and p.codigoestadoperiodo = '1'
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		";
		//echo $query_ordenpago;
		//exit();
		$ordenpago = mysql_query($query_ordenpago, $sala) or die(mysql_error());
		$row_ordenpago = mysql_fetch_assoc($ordenpago);
		$totalRows_ordenpago = mysql_num_rows($ordenpago);
		$nombre = $row_ordenpago['nombre'];
		$codigoestudiante = $row_ordenpago['codigoestudiante'];
		$codigocarrera = $row_ordenpago['codigocarrera'];
		$numeroordenpago = $row_ordenpago['numeroordenpago'];
		$codigoperiodo = $row_ordenpago['codigoperiodo'];
		$numerocohorte = $row_ordenpago['numerocohorte'];
		$codigotipoestudiante = $row_ordenpago['codigotipoestudiante'];
		$codigoestadoordenpago1 = $row_ordenpago['codigoestadoordenpago'];
		if($totalRows_ordenpago == 0)
		{
?>
<script language="javascript">
	alert("No se obtuvo ningún resultado, verifique el documento del estudiante o el número de orden");
</script>
<?php
		}
		else
		{
/*?>
<SCRIPT LANGUAGE="JavaScript">
var entrar = confirm("¿Desea crear una nueva orden para el estudiante?")
if ( !entrar ) 
	window.location.reload("generarnuevaorden.php");
</SCRIPT>
<?php*/				
			require("generarygrabarordenpago.php");
		}
	}
}
?>
</div>
</body>
</html>