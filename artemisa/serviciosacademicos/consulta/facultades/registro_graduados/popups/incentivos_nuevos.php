<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script language="javascript">
function resetearform()
{
	document.form1.reset();
}
</script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

<?php require_once('../../../../Connections/sala2.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
?>
<?php
$idregistrograduado=$_GET['idregistrograduado'];
unset($incentivos);
unset($_SESSION["incentivos"]);
?>
<?php
require_once('../../../../Connections/sala2.php');
$usuario=$_SESSION['MM_Username'];
require('../../../../funciones/funcionip.php');
require('../../../../funciones/validacion.php');
$fecharegistroincenitvograduado=date("Y-m-d H:i:s");
$direccionipregistroincentivograduado=tomarip();


mysql_select_db($database_sala, $sala);
$query_incentivoacademico="select * from incentivoacademico";
$incentivoacademico=mysql_query($query_incentivoacademico,$sala) or die(mysql_error());
$row_incentivoacademico=mysql_fetch_assoc($incentivoacademico);
$totalrows_incentivoacademico=mysql_num_rows($incentivoacademico);


/* mysql_select_db($database_sala, $sala);
$query_registroincentivo="select * from registroincentivoacademico where idregistrograduado='$idregistrograduado' and codigoestado='100'";
$registroincentivo=mysql_query($query_registroincentivo,$sala) or die(mysql_error());
$totalrows_registroincentivo=mysql_num_rows($registroincentivo);
$row_registroincentivo=mysql_fetch_assoc($registroincentivo); */

mysql_select_db($database_sala, $sala);
$query_verifica_incentivos="select * from documentograduado d where d.idregistrograduado='$idregistrograduado' and d.codigotipodocumentograduado='3' and codigoestado='100'";
$verifica_incentivos=mysql_query($query_verifica_incentivos,$sala);
$row_verifica_incentivos=mysql_fetch_assoc($verifica_incentivos);
$numrows_verifica_incentivos=mysql_num_rows($verifica_incentivos);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<div align="center" class="Estilo3">
  <form name="form1" method="post" action="">
    <div align="center" class="Estilo3">
      <p>REGISTRO INCENTIVOS ACADEMICOS </p>
    </div>
  <table border="2" align="center" cellpadding="2" bordercolor="#003333">
      <tr>
        <td><table border="0" align="center" cellpadding="0" bordercolor="#003333">
          <tr class="Estilo2">
            <td bgcolor="#C5D5D6"><div align="center">Descripci&oacute;n Incentivo Acad&eacute;mico<span class="Estilo4">*</span> </div></td>
            <td bgcolor="#FFFFFF"><input name="nombreregistroincentivoacademico" type="text" id="nombreregistroincentivoacademico" size="65"></td>
          </tr>
          <tr class="Estilo2">
            <td width="116" bgcolor="#C5D5D6"><div align="center">Incentivo<span class="Estilo4">*</span></div></td>
            <td width="42" bgcolor="#FFFFFF"><div align="center"><span class="Estilo1">
                <select name="idincentivoacademico">
                  <option value="">Seleccionar</option>
                  <?php
                  do {
?>
                  <option value="<?php echo $row_incentivoacademico['idincentivoacademico']?>" <?php if(isset($_POST['idincentivoacademico'])){if($_POST['idincentivoacademico']==$row_incentivoacademico['idincentivoacademico']){echo "selected";};}elseif($row_registroincentivo['idincentivoacademico']==$row_incentivoacademico['idincentivoacademico']){echo "selected";}?>><?php echo $row_incentivoacademico['nombreincentivoacademico']?></option>
                  <?php
                  } while ($row_incentivoacademico = mysql_fetch_assoc($incentivoacademico));
 ?>
                </select>
            </span></div></td>
          </tr>
          <tr class="Estilo2">
            <td bgcolor="#C5D5D6"><div align="center">Observaci&oacute;n<span class="Estilo4">*</span><span class="Estilo4"></span> </div></td>
            <td bgcolor="#FFFFFF"><textarea name="observacionregistroincentivoacademico" cols="55" id="observacionregistroincentivoacademico"><?php if(isset($_POST['observacionregistroincentivoacademico'])){echo $_POST['observacionregistroincentivoacademico'];}else{echo $row_registroincentivo['observacionregistroincentivoacademico'];}?></textarea></td>
          </tr>
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Fecha de Acuerdo<span class="Estilo4">*</span></div></td>
            <td><input name="fechaacuerdoregistroincentivoacademico" type="text" id="fechaacuerdoregistroincentivoacademico" size="8" value="<?php if(isset($_POST['fechaacuerdoregistroincentivoacademico'])){echo $_POST['fechaacuerdoregistroincentivoacademico'];}else{echo $row_registroincentivo['fechaacuerdoregistroincentivoacademico'];}?>"><button id="btfechaacuerdoregistroincentivoacademico">...</button></td>
          </tr>
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">N&uacute;mero de Acuerdo<span class="Estilo4">*</span></span></div></td>
            <td><input name="numeroacuerdoregistroincentivoacademico" type="text" id="numeroacuerdoregistroincentivoacademico" size="65"></td>
          </tr>
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Fecha de Acta<span class="Estilo4">*</span></span></div></td>
            <td><input name="fechaactaregistroincentivoacademico" type="text" id="fechaactaregistroincentivoacademico" size="8" value="<?php if(isset($_POST['fechaactaregistroincentivoacademico'])){echo $_POST['fechaactaregistroincentivoacademico'];}else{echo $row_registroincentivo['fechaactaregistroincentivoacademico'];}?>"><button id="btfechaactaregistroincentivoacademico">...</button></td>
          </tr>
          <tr class="Estilo1">
            <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">N&uacute;mero de Acta<span class="Estilo4">*</span></span></div></td>
            <td><input name="numeroactaregistroincentivoacademico" type="text" id="numeroactaregistroincentivoacademico" size="65"></td>
          </tr>
<tr class="Estilo1">
                <!--<td bgcolor="#C5D5D6"><div align="center"><span class="Estilo2">Firmas<span class="Estilo4">*</span></span></div></td>-->
              <!--<td><input name="firmas" type="submit" id="firmas" onclick="abrir('firmas_incentivos.php?idincentivoacademico=<?php if($totalrows_registroincentivo==1){echo $row_registroincentivo['idincentivoacademico'];}?>&documento=incentivos&idregistrograduado=<?php echo $idregistrograduado;?>&idregistroincentivoacademico=<?php echo $idregistroincentivoacademico?>','ventana2','width=300,height=300,top=200,left=150,scrollbars=yes');return false" value="Registrar Firmas"/>                <span class="Estilo4">*</span></td>-->
            </tr>
          </table>
          <p>
          </p>
<div align="center">
              <input name="Atras" type="submit" id="Atras" value="Atras" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Grabar" type="submit" id="Grabar" value="Grabar">
          </div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
<?php 
if(isset($_POST['Grabar'])){
	if(isset($_SESSION["incentivos"]))
	{
		$incentivos=$_SESSION["incentivos"];
	}
	$validacion_incentivo['req_nombreregistroincentivoacademico']=validar($_POST['nombreregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el nombre del trabajo de grado")</script>', true);
	$validacion_incentivo['req_idincentivoacademico']=validar($_POST['idincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado el incentivo académico")</script>', true);
	$validacion_incentivo['req_observacion']=validar($_POST['observacionregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado la Observación")</script>', true);
	$validacion_incentivo['req_fechaacuerdoregistroincentivoacademico']=validar($_POST['fechaacuerdoregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado la fecha del acuerdo")</script>', true);
	$validacion_incentivo['fech_fechaacuerdoregistroincentivoacademico']=validar($_POST['fechaacuerdoregistroincentivoacademico'],"fecha",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acuerdo")</script>', true);
	$validacion_incentivo['req_numeroacuerdoregistroincentivoacademico']=validar($_POST['numeroacuerdoregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del acuerdo")</script>', true);
	$validacion_incentivo['req_fechaactaregistroincentivoacademico']=validar($_POST['fechaactaregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acta")</script>', true);
	$validacion_incentivo['fech_fechaactaregistroincentivoacademico']=validar($_POST['fechaactaregistroincentivoacademico'],"fecha",'<script language="JavaScript">alert("No ha seleccionado correctamente la fecha del acta")</script>', true);
	$validacion_incentivo['req_numeroactaregistroincentivoacademico']=validar($_POST['numeroactaregistroincentivoacademico'],"requerido",'<script language="JavaScript">alert("No ha digitado el número del acta")</script>', true);

	$validacion_general=true;
	foreach ($validacion_incentivo as $indice => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validacion_general=false;
		}
	}

	if($numrows_verifica_incentivos > 0)
	{
		$validaporbd=true;
	}
	else
	{
		$validaporbd=false;
	}
	if($validaporbd==true){
		if($validacion_general==true){
			$accion="nuevo";
			//inserccion de incentivos nuevos
			if(isset($accion) and $accion=="nuevo")
			{
				$fecharegistroincentivoacademico=date("Y-m-d H:i:s");
				$query_insertar_registroincentivoacademico="
	insert into registroincentivoacademico values 
	('','".$_GET['idregistrograduado']."','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
	'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
	'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
	'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
	'100','".$_GET['idusuario']."')";
				//echo $query_insertar_registroincentivoacademico;
				$insertar_registroincentivoacademico=mysql_query($query_insertar_registroincentivoacademico,$sala) or die($query_insertar_registroincentivoacademico);
				if($insertar_registroincentivoacademico){
					$idregistroincentivoacademico=mysql_insert_id();
					$query_insertar_log_registroincentivoacademico="
		insert into logregistroincentivoacademico values 
		('','$idregistroincentivoacademico','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
		'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
		'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
		'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
		'100','".$_GET['idusuario']."')";
					//echo $query_insertar_log_registroincentivoacademico;
					$insertar_log_registroincentivoacademico=mysql_query($query_insertar_log_registroincentivoacademico,$sala) or die(mysql_error());
					if($insertar_log_registroincentivoacademico){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
				}
			}
			//fin de inserccion insentivos nuevos
			//insertar datos firmas incentivos
			if($totalrows_verifica_registroincentivo==0){
				foreach($incentivos as $vincentivos => $valor)
				{
					if (ereg("sel",$vincentivos))
					{

						$query_insertar_documentograduado_incentivos="insert into documentograduado values ('','$idregistrograduado','$idregistroincentivoacademico','".$incentivos[$vincentivos]."','100','3','".$_POST['idincentivoacademico']."')";
						$insertar_documentograduado_incentivos=mysql_query($query_insertar_documentograduado_incentivos,$sala) or die("$query_insertar_documentograduado_incentivos".mysql_error());
						$iddocumentograduado_incentivos=mysql_insert_id();
						$query_insertar_log_documentograduado_incentivos="insert into logdocumentograduado values ('','$iddocumentograduado_incentivos','$idregistroincentivoacademico','".$incentivos[$vincentivos]."','100','3','1')";
						$insertar_log_documentograduado_incentivos=mysql_query($query_insertar_log_documentograduado_incentivos) or die("$query_insertar_log_documentograduado_incentivos".mysql_error());

					}
				}
			}
			//fin insertar datos firmas incentivos
			unset($incentivos);
			unset($_SESSION['incentivos']);
			unset($accion);
		}
	}
	else
	{
		if($validacion_general==true and isset($incentivos)){
			$accion="nuevo";
			//insertar datos insentivos existentes
			if($totalrows_verifica_registroincentivo==0){
				$fecharegistroincentivoacademico=date("Y-m-d H:i:s");
				$query_insertar_registroincentivoacademico="
	insert into registroincentivoacademico values 
	('','".$_GET['idregistrograduado']."','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
	'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
	'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
	'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
	'100','".$_GET['idusuario']."')";
				//echo $query_insertar_registroincentivoacademico;
				$insertar_registroincentivoacademico=mysql_query($query_insertar_registroincentivoacademico,$sala) or die($query_insertar_registroincentivoacademico);
				if($insertar_registroincentivoacademico){
					$idregistroincentivoacademico=mysql_insert_id();
					$query_insertar_log_registroincentivoacademico="
		insert into logregistroincentivoacademico values 
		('','$idregistroincentivoacademico','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
		'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
		'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
		'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
		'100','".$_GET['idusuario']."')";
					//echo $query_insertar_log_registroincentivoacademico;
					$insertar_log_registroincentivoacademico=mysql_query($query_insertar_log_registroincentivoacademico,$sala) or die(mysql_error());
					if($insertar_log_registroincentivoacademico){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
				}
			}
			elseif($totalrows_verifica_registroincentivo>0)
			{
				$fecharegistroincentivoacademico=date("Y-m-d H:i:s");
				$idregistroincentivoacademico=$row_verifica_registroincentivo['idregistroincentivoacademico'];
				$query_actualizar_registroincentivoacademico="
	update registroincentivoacademico set
	idincentivoacademico='".$_POST['idincentivoacademico']."',
	nombreregistroincentivoacademico='".$_POST['nombreregistroincentivoacademico']."', 
	numeroacuerdoregistroincentivoacademico='".$_POST['numeroacuerdoregistroincentivoacademico']."', 
	fechaacuerdoregistroincentivoacademico='".$_POST['fechaacuerdoregistroincentivoacademico']."',
	numeroactaregistroincentivoacademico='".$_POST['numeroactaregistroincentivoacademico']."',
	fechaactaregistroincentivoacademico='".$_POST['fechaactaregistroincentivoacademico']."',
	observacionregistroincentivoacademico='".$_POST['observacionregistroincentivoacademico']."'
	where idincentivoacademico='$idincentivoacademico' and idregistrograduado = '$idregistrograduado' and idregistroincentivoacademico='$idregistroincentivoacademico_2'
	";
				//echo $query_actualizar_registroincentivoacademico;
				$actualizar_registroincentivoacademico=mysql_query($query_actualizar_registroincentivoacademico, $sala) or die(mysql_error()."$query_actualizar_registroincentivoacademico");
				$query_insertar_log_registroincentivoacademico="
		insert into logregistroincentivoacademico values 
		('','".$row_verifica_registroincentivo['idregistroincentivoacademico']."','".$_POST['idincentivoacademico']."','$fecharegistroincentivoacademico',
		'".$_POST['nombreregistroincentivoacademico']."','".$_POST['numeroacuerdoregistroincentivoacademico']."',
		'".$_POST['fechaacuerdoregistroincentivoacademico']."','".$_POST['numeroactaregistroincentivoacademico']."',
		'".$_POST['fechaactaregistroincentivoacademico']."','".$_POST['observacionregistroincentivoacademico']."',
		'100','".$_GET['idusuario']."')";
				//echo $query_insertar_log_registroincentivoacademico;
				$insertar_log_registroincentivoacademico=mysql_query($query_insertar_log_registroincentivoacademico,$sala) or die(mysql_error()."$query_insertar_log_registroincentivoacademico");
				if($actualizar_registroincentivoacademico and $insertar_log_registroincentivoacademico){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
			}
			//fin
			//insertar datos firmas insentivos nuevos
			require('insertar_datos_firmas_incentivos_nuevos.php');
			unset($incentivos);
			unset($_SESSION['incentivos']);
			unset($accion);
		}
		else
		{
			if(!isset($incentivos)){
				unset($_SESSION["incentivos"]);
				unset($incentivos);
				echo '<script language="JavaScript">alert("No ha ingresado firmas para los incentivos de grado")</script>';
			}
		}
	}


}
?>
<?php 
if(isset($_POST['Atras'])){echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';}
?>

<script type="text/javascript">
Calendar.setup(
{
	inputField : "fechaactaregistroincentivoacademico", // ID of the input field
	ifFormat : "%Y-%m-%d", // the date format
	button : "btfechaactaregistroincentivoacademico" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
{
	inputField : "fechaacuerdoregistroincentivoacademico", // ID of the input field
	ifFormat : "%Y-%m-%d", // the date format
	button : "btfechaacuerdoregistroincentivoacademico" // ID of the button
}
);
</script>

