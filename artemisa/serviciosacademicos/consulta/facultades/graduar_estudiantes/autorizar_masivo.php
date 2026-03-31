<?php
@session_start();
//print_r($_POST);
?>
<script language="javascript">
function Verificacion()
{
	if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
	{
		document.form1.submit();
	}
	else
	{

	}
}

</script>

<?php

require_once('../../../Connections/sala2.php');
require_once('funciones/funcionip.php');

$fechaautorizacionregistrograduado=date("Y-m-d H:i:s");
$direccionipregistrograduado=tomarip();
$usuario=$_SESSION['MM_Username'];
//$usuario="auxsecgen";
?>
  <script language="javascript">
  function HabilitarTodos(chkbox, seleccion)
  {
  	for (var i=0;i < document.forms[0].elements.length;i++)
  	{
  		var elemento = document.forms[0].elements[i];
  		if(elemento.type == "checkbox")
  		{
  			if (elemento.title == "autorizar")
  			{
  				elemento.checked = chkbox.checked
  			}
  		}
  	}
  }
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php
mysql_select_db($database_sala, $sala);
$query_idusuario="select idusuario from usuario where usuario='$usuario'";
$idusuario=mysql_query($query_idusuario, $sala) or die(mysql_error());
$row_idusuario=mysql_fetch_assoc($idusuario);

$query_iddirectivo="select * from directivo where idusuario='".$row_idusuario['idusuario']."'";
$iddirectivo=mysql_query($query_iddirectivo,$sala) or die(mysql_error());
$row_iddirectivo=mysql_fetch_assoc($iddirectivo);
$totalrows_iddirectivo=mysql_num_rows($iddirectivo);
//echo $query_iddirectivo;
$query_autorizadosino="SELECT * FROM autorizagraduado WHERE iddirectivo='".$row_iddirectivo['iddirectivo']."' AND
'$fechaautorizacionregistrograduado' >= fechainicioautorizagraduado AND
'$fechaautorizacionregistrograduado' <= fechafinalautorizagraduado";
$autorizadosino=mysql_query($query_autorizadosino, $sala) or die (mysql_error());
//echo $query_autorizadosino;
//$row_autorizadosino=mysql_fetch_assoc($autorizadosino);
$totalrows_autorizadosino=mysql_num_rows($autorizadosino);
//echo $totalrows_autorizadosino;


mysql_select_db($database_sala, $sala);
/*$query_resumen="SELECT eg.numerodocumento,s.nombresituacioncarreraestudiante,rg.idregistrograduado,rg.codigoestudiante,concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre,
rg.numeroacuerdoregistrograduado,rg.fechaacuerdoregistrograduado, rg.responsableacuerdoregistrograduado,rg.numeroactaregistrograduado,
rg.numerodiplomaregistrograduado, rg.fechagradoregistrograduado, rg.presidioregistrograduado, rg.lugarregistrograduado, rg. observacionregistrograduado,
rg.codigoestado, rg.codigoautorizacionregistrograduado
FROM registrograduado rg, estudiantegeneral eg, estudiante e, situacioncarreraestudiante s
WHERE 
e.idestudiantegeneral=eg.idestudiantegeneral AND
e.codigoestudiante=rg.codigoestudiante AND
rg.codigoestado='100' AND
e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante AND
rg.codigoautorizacionregistrograduado='200'
";*/
$query_resumen="SELECT eg.numerodocumento,s.nombresituacioncarreraestudiante,rg.idregistrograduado,rg.codigoestudiante,concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre,
rg.numeroacuerdoregistrograduado,rg.fechaacuerdoregistrograduado, rg.responsableacuerdoregistrograduado,rg.numeroactaregistrograduado,
rg.numerodiplomaregistrograduado, rg.fechagradoregistrograduado, rg.presidioregistrograduado, rg.lugarregistrograduado, rg. observacionregistrograduado,
rg.codigoestado, rg.codigoautorizacionregistrograduado FROM sala.registrograduado rg 
inner join estudiante e ON e.codigoestudiante=rg.codigoestudiante
inner join estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
inner join situacioncarreraestudiante s ON e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante
WHERE rg.codigoautorizacionregistrograduado='200' AND
rg.codigoestado='100'";
$resumen = mysql_query($query_resumen, $sala) or die(mysql_error());
$row_resumen=mysql_fetch_assoc($resumen);
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo2">LISTADO DE ESTUDIANTES REGISTRADOS PARA IMPRESIÓN DE DIPLOMAS Y ACTAS </p>
  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td align="center" class="Estilo2"><div align="center">N&uacute;mero de Registro&nbsp; </div></td>
      <td align="center" class="Estilo2"><div align="center">Documento&nbsp;</div></td>
      <td align="center" class="Estilo2"><div align="center">Nombre&nbsp;</div></td>
      <td align="center" class="Estilo2">Estado</td>
      <td align="center" class="Estilo2"><div align="center">No. Acuerdo&nbsp;</div></td>
      <td align="center" class="Estilo2"><div align="center">No. Acta&nbsp;</div></td>
      <td align="center" class="Estilo2"><div align="center">No. Diploma&nbsp;</div></td>
      <td align="center" class="Estilo2"><div align="center">Autorizar&nbsp;</div></td>
      <?php 
      do {

      	$chequear="";
      	//echo $row_resumen['codigoautorizacionregistrograduado'];

      	echo '<tr>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['idregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numerodocumento'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1"><a href="graduar_estudiantes_ingreso.php?autorizar&estudiante='.$row_resumen['codigoestudiante'].'">'.$row_resumen['nombre'].'</a>&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['nombresituacioncarreraestudiante'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numeroacuerdoregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numeroactaregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numerodiplomaregistrograduado'].'&nbsp;</td>
  <td><div align="center"><input type="checkbox" title="autorizar" name="sel'.$row_resumen['idregistrograduado'].'" '.$chequear.' value='.$row_resumen['idregistrograduado'].'>&nbsp;</div></td>
  </tr>
  ';
      }
      while ($row_resumen=mysql_fetch_assoc($resumen))
  ?>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#FFFFFF" class="Estilo2"><input type="button" name="Enviar" value="Enviar" onClick="Verificacion()"></td>
      <td height="25" align="center" bgcolor="#FFFFFF" class="Estilo2"><input type="checkbox" name="checkbox" value="checkbox" onClick="HabilitarTodos(this)"></td>
  </table>
</form>
<?php 
if($totalrows_autorizadosino=='1'){
	//if(isset($_POST['Enviar'])){

		foreach($_POST as $vpost => $valor)
		{
			if (ereg("sel",$vpost))
			{
				$idregistrograduado = $_POST[$vpost];
				$query_datoslog="SELECT rg.*,concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre,e.codigoestudiante
					FROM registrograduado rg, estudiantegeneral eg, estudiante e
					WHERE
					e.idestudiantegeneral=eg.idestudiantegeneral AND
					e.codigoestudiante=rg.codigoestudiante AND
					rg.codigoestado='100'
					AND idregistrograduado='$idregistrograduado'
					";
				echo $query_datoslog;
				$datoslog=mysql_query($query_datoslog,$sala) or die (mysql_error());
				$row_datoslog=mysql_fetch_assoc($datoslog);

				$query_autorizar="update registrograduado set iddirectivo='".$row_iddirectivo['iddirectivo']."', fechaautorizacionregistrograduado='$fechaautorizacionregistrograduado',
					codigoautorizacionregistrograduado='100' where idregistrograduado='$idregistrograduado'";
				$autorizar=mysql_query($query_autorizar,$sala) or die (mysql_error());

				$query_cambioestado_graduado="update estudiante set codigosituacioncarreraestudiante='400' where codigoestudiante='".$row_datoslog['codigoestudiante']."'";
				//echo $query_cambioestado_graduado;
				$cambioestado_graduado=mysql_query($query_cambioestado_graduado,$sala) or die (mysql_error());
				$query_ingresardatos_log_autorizacion=
				"
					insert into logregistrograduado
					values
					(
					'',
					'".$row_datoslog['idregistrograduado']."',
					'".$row_datoslog['codigoestudiante']."',
					'".$row_datoslog['numeropromocion']."',
					'$fechaautorizacionregistrograduado',
					'".$row_datoslog['numeroacuerdoregistrograduado']."',
					'".$row_datoslog['fechaacuerdoregistrograduado']."',
					'".$row_datoslog['responsableacuerdoregistrograduado']."',
					'".$row_datoslog['numeroactaregistrograduado']."',
					'".$row_datoslog['fechaactaregistrograduado']."',
					'".$row_datoslog['numerodiplomaregistrograduado']."',
					'".$row_datoslog['fechadiplomaregistrograduado']."',
					'".$row_datoslog['fechagradoregistrograduado']."',
					'".$row_datoslog['lugarregistrograduado']."',
					'".$row_datoslog['presidioregistrograduado']."',
					'".$row_datoslog['observacionregistrograduado']."',
					'100',
					'".$row_datoslog['codigotiporegistrograduado']."',
					'$direccionipregistrograduado',
					'$usuario',
					'".$row_iddirectivo['iddirectivo']."',
					'100',
					'$fechaautorizacionregistrograduado',
					'216',
					'".$row_datoslog['idtipogrado']."'
					)
					";
				$ingresardatos_log_autorizacion=mysql_query($query_ingresardatos_log_autorizacion,$sala)  or die(mysql_error());
				//echo $query_ingresardatos_log_autorizacion;

			}
		}
		if($autorizar==true and $ingresardatos_log_autorizacion==true and $cambioestado_graduado==true)
		{
			unset($_POST);
			echo '<script language="javascript">window.location.reload("autorizar_masivo.php");</script>';
		}

	}


//}
else
{
	echo '<script language="javascript">alert("Usted no tiene la facultad de autorizar grados");</script>';
}

?>
