<?php session_start();
require_once('../../../Connections/sala2.php'); 
require_once('validacion.php'); 
require_once('errores_descuentosvsdeudas.php');
require_once('../../../funciones/funcionip.php' );
require_once('seguridaddescuentosvsdeudas.php');
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

mysql_select_db($database_sala, $sala);	
$ip = "SIN DEFINIR";
$ip = tomarip();
 $usuario = $_SESSION['MM_Username'];
        $query_user = "select idusuario 
		from usuariofacultad 
		where usuario = '$usuario'";
		//echo $query_user;
		$user = mysql_query($query_user, $sala) or die("$query_user");
		$row_user = mysql_fetch_assoc($user);
		$totalRows_user = mysql_num_rows($user);
 
 $idusuariofacultad = $row_user['idusuario']; 
?>
<html>
<head>
<title>Solicitud de crédito</title>
<style type="text/css">

<!--

.Estilo1 {

	font-family: Tahoma;

	font-weight: bold;

	font-size: x-small;

}

.Estilo2 {font-family: Tahoma}

.Estilo3 {

	font-size: x-small;

	font-weight: bold;

}

.Estilo4 {font-family: Tahoma; font-size: x-small; }

-->

</style>

</head>

<body>

<style type="text/css">

<!--

.Estilo3 {

	color: #FF0000;

	font-size: 8pt;

}

-->

</style>

<?php 

	/*foreach($_POST as $materia => $valor)

	{ 

	   	$asignacion = "\$" . $materia . "='" . $valor . "';"; 

		echo $asignacion."<br>";

	}

	*/

	$entro = false;

	if(isset($_GET['accion']))

	{

		$accion = $_GET['accion'];
		$codigoestudiante = $_GET['estudiante'];       
		$periodo = $_GET['periodo'];
		$con = $_GET['codigoconcepto']; 
		$val = $_GET['valor'];
		$id = $_GET['editar'];
        $obs = $_GET['obs'];
		

		// CONCEPTO

		$query_concepto = "SELECT * 
	    FROM concepto
		WHERE codigoconcepto='$con'
		and codigoestado like '1%'";
		$res_concepto = mysql_query($query_concepto, $sala) or die(mysql_error());
		$concepto = mysql_fetch_assoc($res_concepto); 

		// COMBO DESCRIPCION
		$query_descripcion = "SELECT * 
		FROM concepto c,tipoconcepto t
		WHERE c.codigotipoconcepto = t.codigotipoconcepto
		and c.codigoestado like '1%'
		ORDER BY 2";
        $res_descripcion = mysql_query($query_descripcion, $sala) or die(mysql_error());
    	$descripcion = mysql_fetch_assoc($res_descripcion); 

		if($accion == adicionar)

		{

			$formulariovalido = 1;

?>

<!--  <form method="post" action="descuentosvsdeudas.php?estudiante=<?//php echo $codigoestudiante;?>&accion=adicionar">-->

<form method="post" action="<?php echo 'descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=adicionar&periodo='.$periodo.'"';?>">

  <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">

    <tr>

      <td colspan="2">

      <div align="center" class="Estilo4"><b>FORMULARIO PARA ADICIONAR DESCUENTO Y DEUDA</b></div>      </td>

    </tr>

    <tr>

      <td>

      <div align="right" class="Estilo4"><strong>Descripción: </strong></div>      </td>

      <td><span class="Estilo4"><b>

        <select name="codigoconcepto">

          <option value="0" <?php if (!(strcmp(0, $_POST['codigoconcepto']))) {echo "SELECTED";} ?>>Seleccionar</option>

          <?php

	do {  

	?>

          <option value="<?php echo $descripcion['codigoconcepto']?>"<?php if (!(strcmp($descripcion['codigoconcepto'], $_POST['codigoconcepto']))) {echo "SELECTED";} ?>><?php echo $descripcion['nombreconcepto'],"-",$descripcion['nombretipoconcepto'];?></option>

          <?php

				  

	} while ($descripcion = mysql_fetch_assoc($res_descripcion));

	  $rows = mysql_num_rows($res_descripcion);

	  if($rows > 0) {

		  mysql_data_seek($res_descripcion, 0);

		  $descripcion = mysql_fetch_assoc($res_descripcion);

	  }

	?>

        </select>

        <?php

					echo "<span class='Estilo3'>";

					if(isset($_POST['codigoconcepto']))

					{

						$entro = true;

						$codigoestudianteconcepto = $_POST['codigoconcepto'];

						$imprimir = true;

						$ccorequerido = validar($codigoestudianteconcepto,"combo",$error1,&$imprimir);

						$formulariovalido = $formulariovalido*$ccorequerido;

					}

					echo "</span>";

				?>

      </b>

	  </span></td>

    </tr>

    <tr>

      <td>

      <div align="right" class="Estilo4"><strong>Valor: </strong></div>      </td>

      <td><span class="Estilo4"><b>

        <input type="text" name="valor" size="20" maxlength="50" value="<?php echo $_POST['valor'];?>">

      </b>

        <?php

					echo "<span class='Estilo3'>";

					if(isset($_POST['valor']))

					{

						$entro = true;

						$valor = $_POST['valor'];

						$imprimir = true;

						$valrequerido = validar($valor,"requerido",$error1,&$imprimir);

						$valnumero = validar($valor,"numero",$error2,&$imprimir);

						$formulariovalido = $valrequerido*$valnumero;

					}

					echo "</span>";

				?>

      </span></td>

    </tr>

    <tr>
      <td><div align="right" class="Estilo4"><strong>Descripción: </strong></div></td>
      <td><span class="Estilo4"><b>
        <input type="text" name="observaciondescuento" size="40" maxlength="100" value="<?php echo $_POST['observaciondescuento'];?>">
      </b>
	   <?php

					echo "<span class='Estilo3'>";
					if(isset($_POST['observaciondescuento']))
					{
						$entro = true;
						$observacion = $_POST['observaciondescuento'];
						$imprimir = true;
						$valrequerido = validar($observacion,"requerido",$error1,&$imprimir);
						$formulariovalido = $valrequerido*$valnumero;
					}
					echo "</span>";
				?>

	  
	 </span></td>
    </tr>
    <tr>

      <td colspan="2">

        <div align="center" class="Estilo4">

          <input type="submit" name="Adicionar" value="Aceptar">&nbsp;&nbsp;<input type="reset" value="Restablecer">&nbsp;&nbsp;

          <input type="button" value="Cancelar" onClick="recargar()">

      </div>      </td>

    </tr>

  </table>

</form>

<?php 

			if($formulariovalido == 1 && $entro)

			{	

				//echo "por aca entro ESTUDIANTE: $codigoestudiante, VALOR: $valor, CONCEPTO: $codigoestudianteconcepto, PERIODO: $periodo <br>";

				$adicionadescuentodeuda="INSERT INTO descuentovsdeuda(iddescuentovsdeuda, fechadescuentovsdeuda,codigoestudiante, codigoconcepto, valordescuentovsdeuda, codigoperiodo, codigoactualizo, codigoestadodescuentovsdeuda,observaciondescuentovsdeuda,idusuario,direccionip) 

    									 VALUES(0,'".date("Y-m-d H:i:s")."','$codigoestudiante' ,'$codigoestudianteconcepto', $valor, '$periodo', '02', '01','$observacion','$idusuariofacultad','$ip')
										";	
										//echo $adicionadescuentodeuda;
										//exit();
				$ins_descuentodeuda=mysql_db_query($database_sala,$adicionadescuentodeuda) or die("No se dejo adicionar descuentosvsdeudas111");

				

				echo '<script language="javascript"> window.location.reload("descuentosvsdeudas.php?estudiante='.$codigoestudiante.'"); </script>';

			}

		}

		if($accion == editar)

		{

			$formulariovalido = 1;

?>

<form method="post" action="<?php echo 'descuentosvsdeudasoperacion.php?estudiante='.$codigoestudiante.'&accion=editar&editar='.$id.'&codigoconcepto='.$con.'&valor='.$val.'"';?>">



  <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">

    <tr>

      <td colspan="2">

      <div align="center" class="Estilo1">FORMULARIO PARA EDITAR DESCUENTO Y DEUDA</div>      </td>

    </tr>

    <tr>

      <td><div align="right" class="Estilo4"><strong>Descripci&oacute;n: </strong></div></td>

      <td><span class="Estilo1">

        <select name="codigoconcepto">

          <?php 

					  echo '<option value="'.$concepto['codigoconcepto'].'">';

					  /*if (!(strcmp(0, $_POST['codigoconcepto']))) 

					  {echo "selected";}

					  */echo $concepto['nombreconcepto'].'</option>';

					  ?>

          <?php

				do 

				{  

					if($concepto['nombreconcepto']!=$descripcion['nombreconcepto'])

					{

						if ((strcmp($descripcion['codigoconcepto'], $_POST['codigoconcepto']))) 

						{

							echo '<option value="'.$descripcion['codigoconcepto'].'">';

							echo $descripcion["nombreconcepto"].'</option>';

						}

						else

						{

							echo '<option value="'.$descripcion['codigoconcepto'].'" SELECTED>';

							echo $descripcion["nombreconcepto"].'</option>';

						}

					}

					/*else

					{

					  	echo '<option value="0">';

						echo "Seleccionar</option>";

				    }*/

				} 

				while ($descripcion = mysql_fetch_assoc($res_descripcion));

				 $rows = mysql_num_rows($res_descripcion);

				  if($rows > 0) {

					  mysql_data_seek($res_descripcion, 0);

					  $descripcion = mysql_fetch_assoc($res_descripcion);

				  }

				  ?>

        </select>

        <?php

					echo "<span class='Estilo3'>";

					if(isset($_POST['codigoconcepto']))

					{

						$entro = true;

						$codigoestudianteconcepto = $_POST['codigoconcepto'];

						$imprimir = true;

						$ccorequerido = validar($codigoestudianteconcepto,"combo",$error1,&$imprimir);

						$formulariovalido = $formulariovalido*$ccorequerido;

					}

					echo "</span>";

				?>

       </span></td>

    </tr>

    <tr>

      <td><div align="right" class="Estilo4"><strong>Valor: </strong></div></td>

      <td><span class="Estilo4"><b>

        <input type="text" name="valor" size="20" maxlength="50" value="<?php if(isset($_POST['valor'])) echo $_POST['valor']; else echo $val;?>">

        <?php

					echo "<span class='Estilo3'>";

					if(isset($_POST['valor']))

					{

						$entro = true;

						$valor = $_POST['valor'];

						$imprimir = true;

						$valrequerido = validar($valor,"requerido",$error1,&$imprimir);

						$valnumero = validar($valor,"numero",$error2,&$imprimir);

						$formulariovalido = $formulariovalido*$valrequerido*$valnumero;

					}

					echo "</span>";

				?>

      </b> </span></td>
    </tr>
      <tr>
      <td><div align="right" class="Estilo4"><strong>Descripción: </strong></div></td>
      <td><span class="Estilo4"><b>
        <input type="text" name="observaciondescuento" size="40" maxlength="100" value="<?php if(isset($_POST['observaciondescuento'])) echo $_POST['observaciondescuento']; else echo $obs;?>">
      </b>
	  <?php

					echo "<span class='Estilo3'>";
					if(isset($_POST['observaciondescuento']))
					{
						$entro = true;
						$observacion = $_POST['observaciondescuento'];
						$imprimir = true;
						$valrequerido = validar($observacion,"requerido",$error1,&$imprimir);
						$formulariovalido = $valrequerido*$valnumero;
					}
					echo "</span>"; 
				?>

	  </span></td>
    </tr>
    <tr>

      <td colspan="2">

        <div align="center" class="Estilo4">

          <input type="submit" name="Editar" value="Aceptar">&nbsp;&nbsp;<input type="reset" value="Restablecer">&nbsp;&nbsp;<input type="button" value="Cancelar" onClick="recargar()">

      </div>      </td>

    </tr>

  </table>

</form>

<?php 

			if($formulariovalido == 1 && $entro)

			{	

				//echo "por aca entro ESTUDIANTE: $estudiante, ID: $id, VALOR: $val, CONCEPTO: $con <br>";

				$modificadescuentodeuda="UPDATE descuentovsdeuda SET 
										codigoconcepto='$codigoestudianteconcepto',
										valordescuentovsdeuda='$valor', 
										codigoactualizo='04',
										codigoestadodescuentovsdeuda='01',
										observaciondescuentovsdeuda = '".$_POST['observaciondescuento']."'
										WHERE iddescuentovsdeuda = '$id'";
				$upd_descuentodeuda=mysql_db_query($database_sala,$modificadescuentodeuda) or die("No se dejo modificar descuentosvsdeudas");

				echo '<script language="javascript"> window.location.reload("descuentosvsdeudas.php?estudiante='.$codigoestudiante.'"); </script>';

			}

		}

		if($accion == eliminar)

		{

				$id = $_GET['eliminar'];

				$eliminadescuentodeuda="UPDATE descuentovsdeuda SET 
										codigoactualizo='03',
										codigoestadodescuentovsdeuda='02'
										WHERE iddescuentovsdeuda = '$id'";
				$del_descuentodeuda=mysql_db_query($database_sala,$eliminadescuentodeuda) or die("No se dejo eliminar descuentosvsdeudas");

				echo '<script language="javascript"> window.location.reload("descuentosvsdeudas.php?estudiante='.$codigoestudiante.'"); </script>';

			

		}

	}

?>

</body>

</html>

<?php

echo '<script language="javascript">

function recargar()

{ 

    window.location.reload("descuentosvsdeudas.php?estudiante='.$codigoestudiante.'");  

} 

</script>'

?>