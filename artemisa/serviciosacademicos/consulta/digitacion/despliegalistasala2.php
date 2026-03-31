<?php session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

//require_once('Connections/sala.php');?>
<style type="text/css">
	<!--
	.Estilo1 {font-family: Tahoma; font-size: 12px}
	.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
	.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
	-->
</style>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<form name="form1" method="post" action="cusossala.php">
<?php 
	mysql_select_db($database_sala, $sala);
	$query_estudiantes = "	SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,c.numerocorte,c.porcentajecorte,dn.nota,c.fechafinalcorte,c.fechainicialcorte,dn.numerofallasteoria,dn.numerofallaspractica 
				FROM estudiante e,corte c,detallenota dn,estudiantegeneral eg
				WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
					and dn.codigoestudiante = e.codigoestudiante									
					AND c.idcorte = dn.idcorte
					AND c.idcorte = '".$_POST['idcorte']."'
					AND dn.idgrupo ='".$_SESSION['grupos']."'							
				ORDER BY 4";
	//echo $query_estudiantes;
	$estudiantes = mysql_query($query_estudiantes,$sala) or die(mysql_error());
	$row_estudiantes = mysql_fetch_assoc($estudiantes);
	$totalRows_estudiantes = mysql_num_rows($estudiantes);
	if ($row_estudiantes <> "") { 
?>
		<div align="center">
			<p align="center">LISTADO GRUPO ACAD&Eacute;MICO</p>
		</div>
		<table width="600"  border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php
	$thead="	<tr align=\"center\">
				<td id=\"tdtitulogris\">Materia</td>
				<td id=\"tdtitulogris\">Porcentaje</td>
				<td id=\"tdtitulogris\">Corte</td>
				<td id=\"tdtitulogris\">Fecha</td>
			</tr>
			<tr class=\"Estilo1\">
				<td align=\"center\" class=\"Estilo1\">".$_POST['nombremateria']."--".$_POST['materia']."</td>
				<td align=\"center\" class=\"Estilo1\">".$row_estudiantes['porcentajecorte']."</td>
				<td align=\"center\" class=\"Estilo1\">".$row_estudiantes['numerocorte']."</td>
				<td align=\"center\" class=\"Estilo1\">".date("j/m/Y G:i:s",time())."</td>
			</tr>";
			echo $thead;
?>
			<tr>
				<td colspan="4" class="style5"><div align="right"></div>        
<?php  
					echo "<span class='Estilo2'><a href='JavaScript:window.print()' id='aparencialinknaranja'>Imprimir</a></span>";
?>
				</td>
			</tr>
		</table>
		<br>
		<table width="600" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php  
			$tbody="
			<tr align=\"center\">
				<td id=\"tdtitulogris\">No</td>
				<td id=\"tdtitulogris\">Documento</td>
				<td id=\"tdtitulogris\">Apellidos</td>
				<td id=\"tdtitulogris\">Nombres</td>
				<td id=\"tdtitulogris\">Nota</td>
				<td id=\"tdtitulogris\">FT</td>
				<td id=\"tdtitulogris\" >FP</td>
			</tr>";
			$j=1;
			$datosModif=false;
			do {
				if( ($row_estudiantes['nota'] != $_REQUEST["nota".$row_estudiantes["codigoestudiante"]]) || ($row_estudiantes['numerofallasteoria'] != $_REQUEST["fallateorica".$row_estudiantes["codigoestudiante"]]) || ($row_estudiantes['numerofallaspractica'] != $_REQUEST["fallapractica".$row_estudiantes["codigoestudiante"]]) ) {
					$datosModif=true;
					$tbody.="
					<tr>
						<td align=\"center\" class=\"Estilo1\">".$j."</td>
						<td align=\"left\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['numerodocumento']."</td>
						<td align=\"left\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['apellidosestudiantegeneral']." </td>
						<td align=\"left\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['nombresestudiantegeneral']."</td>
						<td align=\"center\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['nota']."&nbsp;</td>
						<td align=\"center\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['numerofallasteoria']."</td>
						<td align=\"center\" valign=\"middle\" class=\"Estilo1\">".$row_estudiantes['numerofallaspractica']."</td>
					</tr>";
				}
				$j++;
			} while ($row_estudiantes = mysql_fetch_assoc($estudiantes)); 
			echo $tbody;
?>
			<tr>
				<td colspan="7" align="right" valign="middle">
					<font size="2" face="Tahoma">
						Responsable
						<br><br><br>
						 ___________________________________
						<br>
						<?php echo $_POST['nombre'];?>
					</font>
				</td>
			</tr>     
		</table>
<?php
		
		if($datosModif) {
			$query_docente="select concat(usuario,'@unbosque.edu.co') emaildocente
						,concat(nombres,' ',apellidos) nombredocente
					from grupo
					join usuario using(numerodocumento) 
					where idgrupo='".$_SESSION['grupos']."'";
			$docente = mysql_query($query_docente,$sala) or die(mysql_error());
			$row_docente = mysql_fetch_assoc($docente);
			require_once("../../funciones/phpmailer/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->From = "no-reply@unbosque.edu.co";
			$mail->FromName = "Sistema SALA";
			$mail->ContentType = "text/html";
			$mail->Subject = "Inserción o actualización de notas";
			$mail->Body = "<b>Señor(a) docente, se han realizado las siguientes modificaciones:</b><br><br> <table width='600'  border='1' align='center' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>".$thead."</table> <br> <table width='600' border='1' align='center' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9'>".$tbody."</table> <br><br><b>Cualquier irregularidad, por favor comuniquese con la facultad.</b>";
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
			$mail->AddAddress($row_docente["emaildocente"],$row_docente["nombredocente"]);
			$mail->Send();
		}
	}
	/*else
	{ 
	echo '<script language="JavaScript">alert("No se produjo ningun resultado")</script>';			
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listassala.php'>";
	exit();
	}*/
	session_unregister('materias');
	session_unregister('periodos');
	session_unregister('grupos');
	session_unregister('facultades');
?>

	<div align="left"></div> 
	<div align="center">
		<span class="Estilo24 Estilo26 Estilo32 Estilo1 Estilo2">
			<input name="Regresar" type="submit" id="Regresar" value="Regresar">
		</span>
	</div>
</form>
