<?php 

	require_once('seguridaddescuentosvsdeudas.php');

	$codigoestudiante = $_GET['estudiante'];

?>

<style type="text/css">

<!--

.Estilo6 {

	font-family: Tahoma;

	font-size: x-small;

}

.Estilo7 {

	font-size: x-small;

	font-weight: bold;

}

.Estilo12 {font-size: x-small}

.Estilo13 {

	color: #993300;

	font-weight: bold;

	font-family: Tahoma;

	font-size: x-small;

}
.Estilo15 {font-size: xx-small; font-weight: bold; }

-->

</style>

<form action="decuentosvsdeudas.php" method="post" name="form1" class="Estilo6">

<p align="center"><strong>ACTUALIZACI&Oacute;N DESCUENTOS Y DEUDAS</strong><br>

 </p>

<div align="center">

<?php

 	$base= "SELECT * 

	FROM estudiante,carrera,situacioncarreraestudiante,tipoestudiante,estudiantegeneral

	WHERE estudiante.codigoestudiante = '$codigoestudiante'

	AND estudiante.idestudiantegeneral = estudiantegeneral.idestudiantegeneral

    AND estudiante.codigocarrera=carrera.codigocarrera

    AND estudiante.codigosituacioncarreraestudiante=situacioncarreraestudiante.codigosituacioncarreraestudiante

    AND estudiante.codigotipoestudiante=tipoestudiante.codigotipoestudiante";

	$sol=mysql_db_query($database_sala,$base) or die("No se deja seleccionar");;

	$totalRows1 = mysql_num_rows($sol);

    if($totalRows1 != "")

	{

		$row=mysql_fetch_array($sol);

		$carrera= $row['codigocarrera'];

	

?>

</div>

  

  <table width="707" height="5" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">

    <tr>

      <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo7">Estudiante</span></div></td>

      <td colspan="6"><div align="center" class="Estilo12"><?php echo $row['nombresestudiantegeneral'];?>&nbsp;&nbsp;<?php echo $row['apellidosestudiantegeneral'];?></div></td>

      <td width="44" bgcolor="#C5D5D6"><div align="center" class="Estilo7">Documento</div></td>

      <td><div align="center" class="Estilo12"><?php echo $row['numerodocumento'];?></div></td>

    </tr>

    <tr>

      <td bgcolor="#C5D5D6"><div align="center" class="Estilo12"></div>

      <div align="center" class="Estilo12"><strong>Carrera</strong></div></td>

      <td colspan="4"><div align="center" class="Estilo12"><?php echo $row['nombrecarrera'];?></div></td>

      <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="Estilo12"><strong>Tipo de Estudiante </strong></div></td>

      <td colspan="2"><div align="center" class="Estilo12"><?php echo $row['nombretipoestudiante'];?></div></td>

    </tr>

    <tr>

      <td bgcolor="#C5D5D6"><div align="center" class="Estilo12"><strong>Periodo </strong></div></td>

      <td width="49"><div align="center" class="Estilo12"><?php $periodo=$_SESSION['codigoperiodosesion']; echo $periodo;?></div></td>

      <td width="69" bgcolor="#C5D5D6"><div align="center" class="Estilo12"><strong>Semestre</strong></div></td>

      <td><div align="center" class="Estilo12"><?php echo $row['semestre'];?></div></td>

      <td colspan="2" bgcolor="#C5D5D6"><div align="center" class="Estilo12"><strong>Situaci&oacute;n Academica</strong></div></td>

      <td><div align="center" class="Estilo12"><?php echo $row['nombresituacioncarreraestudiante'];?></div></td>

      <td bgcolor="#C5D5D6"><div align="center" class="Estilo12"><strong>Fecha </strong></div></td>

      <td><div align="center" class="Estilo12"><?php echo date("Y-m-d",time());?></div></td>

    </tr>

  </table>

	<table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
	    <td align="center" bgcolor="#C5D5D6" class="Estilo15">Fecha&nbsp;</td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Concepto&nbsp;</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Descripci&oacute;n&nbsp;</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Valor</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Observación</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Estado</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo15">Operación</span></td>
      </tr>

    <?php

		$query_descuetovsdeudas = "SELECT dvd.*, con.*, act.*
		FROM descuentovsdeuda dvd, concepto con, estadodescuentovsdeuda act
		WHERE dvd.codigoconcepto = con.codigoconcepto
		AND dvd.codigoestadodescuentovsdeuda = act.codigoestadodescuentovsdeuda
		AND dvd.codigoestudiante = '$codigoestudiante'
		AND dvd.codigoestadodescuentovsdeuda = '01'";
		//echo $query_descuetovsdeudas; 
		$res_descuetovsdeudas = mysql_query($query_descuetovsdeudas, $sala) or die(mysql_error());
		$totalRows2=mysql_num_rows($res_descuetovsdeudas);

		if($totalRows2 != 0)

		{

			while($descuetovsdeudas = mysql_fetch_assoc($res_descuetovsdeudas))

			{

				$fecha = $descuetovsdeudas["fechadescuentovsdeuda"];
				$id = $descuetovsdeudas["iddescuentovsdeuda"];
				$con = $descuetovsdeudas["codigoconcepto"];
				$des = $descuetovsdeudas["nombreconcepto"];
				$val = $descuetovsdeudas["valordescuentovsdeuda"];
				$est = $descuetovsdeudas["nombreestadodescuentovsdeuda"];
                $obs = $descuetovsdeudas["observaciondescuentovsdeuda"];
				echo '<tr>
                    <td><span class="Estilo6">'.$fecha.'&nbsp;</span></td>
					<td><span class="Estilo6">'.$con.'&nbsp;</span></td>
					<td><span class="Estilo6">'.$des.'&nbsp;</span></td>
					<td><span class="Estilo6">'.$val.'&nbsp;</span></td>
                    <td><span class="Estilo6">'.$obs.'&nbsp;</span></td>
					<td><span class="Estilo6">'.$est.'&nbsp;</span></td>

					<td align="center">
						<a href="descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=editar&editar='.$id.'&codigoconcepto='.$con.'&valor='.$val.'&obs='.$obs.'"><img src="editar.png" width="23" height="23" alt="Modificar"></a>
						<a href="descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=adicionar&periodo='.$periodo.'"><img src="adicionar.png" width="23" height="23" alt="Adicionar"></a>
						<a href="descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=eliminar&eliminar='.$id.'"><img src="eliminar.png" width="23" height="23" alt="Anular"></td></a>
				  </tr>';
			}
		}
		else
		{
			echo '<tr>
					<td colspan="6" align="center"><strong><font color="#800040">Este estudiante no tiene Descuentos y Deudas. </font></strong>&nbsp;</td>
					<td align="center"><a href="descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=adicionar&periodo='.$periodo.'"><img src="adicionar.png" width="23" height="23" alt="Adicionar"></a>
				</tr>';
		}
?>

<tr><td colspan="7" align="center"><input type="button" onClick="cancelar2()" value="Cancelar"></td></tr>

  </table>

</form>

<?php 
	}
	else
	{	

?>		<div align="center"><span class="Estilo13">No se Tiene acceso para este estudiante. </span>
		<br>
		<input type="button" onClick="history.go(-1)" value="Aceptar"></div>
<?php
	} 
?>