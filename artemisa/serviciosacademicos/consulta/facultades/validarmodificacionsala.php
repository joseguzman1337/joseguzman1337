<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../funciones/funcionip.php' );
require_once('../../utilidades/notas/funcionesModificarNotas.php' );
	$ip = "SIN DEFINIR";
	$ip = tomarip();
       
	$query="select * from ipsvalidasmodificacionnotas where ip='".$ip."' and '".date("Y-m-d")."' between fechadesde and fechahasta";
$regIP = mysql_query($query,$sala);
if (mysql_num_rows($regIP)==0) {
	echo "	<script>
			alert('Esta dirección IP no es válida para realizar modificaciones: $ip. Por favor comuniquese con la mesa de ayuda')
			history.back();
		</script>";
} else {
	$query=queryAprobadorCarrera($_SESSION["codigofacultad"]);
	$regAprobador = mysql_query($query,$sala);
	if (mysql_num_rows($regAprobador)==0) {
		echo "	<script>
				alert('No se encontro aprobador de notas definido para esta carrera. Por favor comuniquese con el área de registro y control.')
				history.back();
			</script>";
	} else {
		require_once("../../funciones/phpmailer/class.phpmailer.php");
	
		$rowAprobador = mysql_fetch_assoc($regAprobador);
		$query_nota = "	SELECT *
				FROM nota n  
				WHERE idcorte = '".$_POST['idcorte']."'
					AND idgrupo = '".$_SESSION['grupos']."'";                            		
		$nota = mysql_query($query_nota,$sala) OR die(mysql_error());
		$row_nota = mysql_fetch_assoc($nota);
		if (!$row_nota) {
		  
			 $insertSQL = "	INSERT INTO nota 
						(idgrupo
						,idcorte
						,fechaorigennota
						,actividadesacademicasteoricanota
						,actividadesacademicaspracticanota
						,fechaultimoregistronota
						,codigotipoequivalencianota)
					VALUES( '".$_SESSION['grupos']."',
						'".$_POST['idcorte']."',
						'".date("Y-m-j G:i:s",time())."', 
						'".$_POST['teorico']."',
						'".$_POST['practico']."',
						'".date("Y-m-j G:i:s",time())."',
						'10')";			   
			mysql_select_db($database_sala, $sala);
			$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());			  
		} else {
			$updateSQL = "	UPDATE nota 
					SET	actividadesacademicasteoricanota = '".$_POST['teorico']."', 
						actividadesacademicaspracticanota    = '".$_POST['practico']."'		 
					WHERE idcorte = '".$_POST['idcorte']."'
						and idgrupo = '".$_SESSION['grupos']."'";		
			mysql_select_db($database_sala, $sala);
			$Result1 = mysql_query($updateSQL,  $sala) or die(mysql_error());
			//echo $updateSQL;
		}	

		echo "<br>";
		echo "<div align='center'><font color='#990000' face='Tahoma' size='3'><strong>LAS SIGUIENTES MODIFICACIONES QUEDAN PENDIENTE DE APROBACIÓN O RECHAZO</strong></font></div>";
		echo "<br>";

		$ip = (tomarip())?tomarip():"SIN DEFINIR";
		
		$query="select idusuario from usuario where usuario='".$_SESSION['MM_Username']."'";
		$regSolicitante = mysql_query($query,$sala) OR die(mysql_error());
		$rowSolicitante = mysql_fetch_assoc($regSolicitante);	
		$query_mat = "	SELECT nombremateria
				FROM materia
				WHERE codigomateria = '".$_SESSION['materias']."'";	
		$mat = mysql_query($query_mat,$sala) OR die(mysql_error());
		$row_mat = mysql_fetch_assoc($mat);
        
		$query_estudiantess = "	SELECT e.codigoestudiante
						,eg.numerodocumento
						,eg.nombresestudiantegeneral
						,eg.apellidosestudiantegeneral
					FROM prematricula p
					,detalleprematricula d
					,estudiante e
					,estudiantegeneral eg
					WHERE eg.idestudiantegeneral = e.idestudiantegeneral 
						AND p.codigoestudiante = e.codigoestudiante
						AND p.idprematricula = d.idprematricula
						AND d.idgrupo = '".$_SESSION['grupos']."'
						AND p.codigoestadoprematricula LIKE '4%'
						AND d.codigoestadodetalleprematricula LIKE '3%'
					ORDER BY 4";
		//echo $query_estudiantess;
		$estudiantess = mysql_query($query_estudiantess,$sala) OR die(mysql_error());
		$f = 1;
		$findModif=0;
		$tbody="";
		while($row_estudiantess = mysql_fetch_assoc($estudiantess)) {
        
			$nota = $_POST['nota1'.$row_estudiantess['codigoestudiante']];
            $fallasteoricas= $_POST['fallateorica1'.$row_estudiantess['codigoestudiante']];
			$fallaspracticas= $_POST['fallapractica1'.$row_estudiantess['codigoestudiante']];
            
			$query_estudiantes2 = "	SELECT *
						FROM detallenota d
						,nota n  
						WHERE d.idcorte=n.idcorte
							and d.idcorte = '".$_POST['idcorte']."'
							AND d.codigomateria = '".$_SESSION['materias']."'							
							and d.codigoestudiante = '".$row_estudiantess['codigoestudiante']."'";
                  		
			$estudiantes2 = mysql_query($query_estudiantes2,$sala) OR die(mysql_error());
			$row_estudiantes2 = mysql_fetch_assoc($estudiantes2);
			$totalRows_estudiantes2 = mysql_num_rows($estudiantes2);
            			
			$query_modif = "SELECT *
					FROM solicitudaprobacionmodificacionnotas
					WHERE idcorte = '".$_POST['idcorte']."'
						AND codigomateria = '".$_SESSION['materias']."'							
						and codigoestudiante = '".$row_estudiantess['codigoestudiante']."'
						and codigoestadosolicitud=10";
			$modif = mysql_query($query_modif,$sala) OR die(mysql_error());
			$row_modif = mysql_fetch_assoc($modif);
			$totalRows_modif = mysql_num_rows($modif);
			
            
			$insertRow=0;
			if ($totalRows_modif==0) { 
				if ($totalRows_estudiantes2==0) {
					$insertRow=1;
				} else {
					if( ($row_estudiantes2["nota"] != $nota) || ($row_estudiantes2["numerofallasteoria"] != $fallasteoricas) || ($row_estudiantes2["numerofallaspractica"] != $fallaspracticas) ) 
						$insertRow=1;
				}
			}
			if($insertRow) {
				$findModif=1;
                $vlrinsdelupd=($totalRows_estudiantes2==0)?'I':'U';
                $nota_ant=($row_estudiantes2["nota"]!="")?$row_estudiantes2["nota"]:"null";
				$fallasteoricas_ant=($row_estudiantes2["numerofallasteoria"]!="")?$row_estudiantes2["numerofallasteoria"]:"null";
				$fallaspracticas_ant=($row_estudiantes2["numerofallaspractica"]!="")?$row_estudiantes2["numerofallaspractica"]:"null";
				$query="INSERT INTO solicitudaprobacionmodificacionnotas
						(idgrupo
						,idcorte
						,codigomateria
						,codigoestudiante
						,notaanterior
						,notamodificada
						,numerofallasteoriaanterior
						,numerofallasteoriamodificada
						,numerofallaspracticaanterior
						,numerofallaspracticamodificada
						,idsolicitante
						,fechasolicitud
						,ipsolicitante
						,idaprobador
						,insdelupd
						,idtiposolicitudaprobacionmodificacionnotas
						,codigoestadosolicitud)
					VALUES( '".$_SESSION['grupos']."'
						,'".$_POST['idcorte']."'
						,'".$_SESSION['materias']."'
						,'".$row_estudiantess['codigoestudiante']."'
						,".$nota_ant."
						,".$nota."
						,".$fallasteoricas_ant."
						,".$fallasteoricas."
						,".$fallaspracticas_ant."
						,".$fallaspracticas."
						,'".$rowSolicitante["idusuario"]."'
						,'".date("Y-m-d H:i:s")."'
						,'".$ip."'
						,'".$rowAprobador["idaprobador"]."'
						,'".$vlrinsdelupd."'
						,10
						,10)";
				//echo $query."<br>";	
				mysql_query($query,$sala);
				
				$idSol=mysql_insert_id();
			
				$tbody.="<tr>
						<td align='center'><font face='Tahoma' size='2'>".$idSol."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row_estudiantess['numerodocumento']."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row_estudiantess["apellidosestudiantegeneral"]." ".$row_estudiantess["nombresestudiantegeneral"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row_mat["nombremateria"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row_estudiantes2["nota"] != $nota) {
								$tbody.="<table width='100%' bgcolor='#CFFFEC'>
										<tr><td>Nota anterior:</td><th>".$row_estudiantes2["nota"]."</th></tr>
										<tr><td>Nueva nota:</td><th>".$nota."</th></tr>
									</table>";
							}
				$tbody.="	</td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row_estudiantes2["numerofallasteoria"] != $fallasteoricas) {
								$tbody.="<table width='100%' bgcolor='#FAFFCF'>
										<tr><td>FT anteriores:</td><th>".$row_estudiantes2["numerofallasteoria"]."</th></tr>
										<tr><td>Nuevas FT:</td><th>".$fallasteoricas."</th></tr>
									</table>";
							}
				$tbody.="	</td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row_estudiantes2["numerofallaspractica"] != $fallaspracticas) {
								$tbody.="<table width='100%' bgcolor='#FFDFFE'>
										<tr><td>FP anteriores:</td><th>".$row_estudiantes2["numerofallaspractica"]."</th></tr>
										<tr><td>Nuevas FP:</td><th>".$fallaspracticas."</th></tr>
									</table>";
							}
				$tbody.="	</td>
					</tr>"; 
			}
			$f++;
		}
		$tabla="<table border='1' align='center' bordercolor='#003333'>       
				<tr>
					<td colspan='7' bgcolor='#C5D5D6' align='center' >
						<font face='Tahoma' size='2'><strong>LISTADO DE ESTUDIANTES</strong></font>
					</td> 
				</tr>
				<tr>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FT</strong></font></td>
					<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FP</strong></font></td>
				</tr>";
		if($findModif)
			$tabla.=$tbody;
		else
			$tabla.="<tr><td colspan='6' align='center'><font face='Tahoma' size='2'>No se registraron modificaciones</font></td></tr>";
		$tabla.="</table>";
	
		echo $tabla;

		if($findModif) {
			$mail = new PHPMailer();
			$mail->From = "no-reply@unbosque.edu.co";
			$mail->FromName = "Sistema SALA";
			$mail->ContentType = "text/html";
			$mail->Subject = "Tiene nuevas solicitudes de modificación de notas";
			$mail->Body = "<b>Las siguientes solicitudes están pendientes de aprobación o rechazo:</b><br><br>".$tabla;
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
			$mail->AddAddress($rowAprobador["emailaprobador"],$rowAprobador["nombreaprobador"]);
			if(!$mail->Send())
				echo "<br><div align='center'><font color='#990000' face='Tahoma' size='3'><strong>Falló al enviar email de notificación al aprobador.</strong></font></div>";
			else
				echo "<br><div align='center'><font color='#2B5F00' face='Tahoma' size='3'><strong>Se envió email de notificación al aprobador a ".$rowAprobador["emailaprobador"]."</strong></font></div>";
		}
		echo "	<br>
			<center><input type=\"button\" value=\"Volver\" onclick=\"location.href='notassala.php'\"></center>";
	}
}



/*
print_r($_SESSION);
exit;
if (isset($_SESSION['programaprincipal'])) {
	$usuario = "admintecnologia";	 
	$codigousuario = '145';
} else {
	$usuario = $_SESSION['MM_Username'];	 
	$codigousuario = $_SESSION['codigofacultad'];
}	 


$query_nota = "	SELECT *
		FROM nota n  
		WHERE idcorte = '".$_POST['idcorte']."'
			AND idgrupo = '".$_SESSION['grupos']."'";                            		
$nota = mysql_query($query_nota,$sala) OR die(mysql_error());
$row_nota = mysql_fetch_assoc($nota);
$totalRows_nota = mysql_num_rows($nota);		

if (!$row_nota) {
	$insertSQL = "	INSERT INTO nota 
				(idgrupo
				,idcorte
				,fechaorigennota
				,actividadesacademicasteoricanota
				,actividadesacademicaspracticanota
				,fechaultimoregistronota
				,codigotipoequivalencianota)
			VALUES( '".$_SESSION['grupos']."',
				'".$_POST['idcorte']."',
				'".date("Y-m-j G:i:s",time())."', 
				'".$_POST['teorico']."',
				'".$_POST['practico']."',
				'".date("Y-m-j G:i:s",time())."',
				'10')";			   
	mysql_select_db($database_sala, $sala);
	$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());			  
} else {
	$updateSQL = "	UPDATE nota 
			SET	actividadesacademicasteoricanota = '".$_POST['teorico']."', 
				actividadesacademicaspracticanota    = '".$_POST['practico']."'		 
			WHERE idcorte = '".$_POST['idcorte']."'
				and idgrupo = '".$_SESSION['grupos']."'";		
	mysql_select_db($database_sala, $sala);
	$Result1 = mysql_query($updateSQL,  $sala) or die(mysql_error());
	//echo $updateSQL;
}	

$query_estudiantess = "	SELECT e.codigoestudiante
				,eg.numerodocumento
				,eg.nombresestudiantegeneral
				,eg.apellidosestudiantegeneral
			FROM prematricula p
			,detalleprematricula d
			,estudiante e
			,estudiantegeneral eg
			WHERE eg.idestudiantegeneral = e.idestudiantegeneral 
				AND p.codigoestudiante = e.codigoestudiante
				AND p.idprematricula = d.idprematricula
				AND d.idgrupo = '".$_SESSION['grupos']."'
				AND p.codigoestadoprematricula LIKE '4%'
				AND d.codigoestadodetalleprematricula LIKE '3%'
			ORDER BY 4";
//echo $query_estudiantess;
//exit;

$estudiantess = mysql_query($query_estudiantess,$sala) OR die(mysql_error());
$row_estudiantess = mysql_fetch_assoc($estudiantess);
$totalRows_estudiantess = mysql_num_rows($estudiantess);  

$f = 1;

echo "<br>";
echo "<div align='center'><font color='#990000' face='Tahoma' size='3'><strong>HAN QUEDADO REGISTRADOS LOS SIGUIENTES DATOS</strong></font></div>";
echo "<br>";

echo "	<table border='1' align='center' bordercolor='#003333'>       
		<tr>
			<td colspan='5' bgcolor='#C5D5D6' align='center' >
				<font face='Tahoma' size='2'><strong>LISTADO DE ESTUDIANTES</strong></font>
			</td> 
		</tr>
		<tr>
			<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
			<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
			<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
			<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FT</strong></font></td>
			<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FP</strong></font></td>
		</tr>";
do {

	$query_estudiantes2 = "	SELECT *
				FROM detallenota d
				,nota n  
				WHERE d.idcorte=n.idcorte
					and d.idcorte = '".$_POST['idcorte']."'
					AND d.codigomateria = '".$_SESSION['materias']."'							
					and d.codigoestudiante = '".$row_estudiantess['codigoestudiante']."'"; 		
	$estudiantes2 = mysql_query($query_estudiantes2,$sala) OR die(mysql_error());
	$row_estudiantes2 = mysql_fetch_assoc($estudiantes2);
	$totalRows_estudiantes2 = mysql_num_rows($estudiantes2);


	$nota = $_POST['nota1'.$f];

	$fallasteoricas= $_POST['fallateorica1'.$f];

	$fallaspracticas= $_POST['fallapractica1'.$f];

	if( ($row_estudiantes2["nota"] != $nota) || ($row_estudiantes2["numerofallasteoria"] != $fallasteoricas) || ($row_estudiantes2["numerofallaspractica"] != $fallaspracticas) ) {
		$query="INSERT INTO solicitudaprobacionmodificacionnotas
				(idgrupo
				,idcorte
				,codigomateria
				,codigoestudiante
				,notaanterior
				,notamodificada
				,numerofallasteoriaanterior
				,numerofallasteoriamodificada
				,numerofallaspracticaanterior
				,numerofallaspracticamodificada
				,idsolicitante
				,solicitante
				,fechasolicitud
				,ipsolicitante
				,codigoestadosolicitud)
			VALUES( '".$_SESSION['grupos']."'
				,'".$_POST['idcorte']."'
				,'".$_SESSION['materias']."'
				,'".$row_estudiantess['codigoestudiante']."'
				,'".$row_estudiantes2["nota"]."'
				,'".$nota."'
				,'".$row_estudiantes2["numerofallasteoria"]."'
				,'".$fallasteoricas."'
				,'".$row_estudiantes2["numerofallaspractica"]."'
				,'".$fallaspracticas."'
				,'4186'
				,'".$usuario."'
				,'".date("Y-m-d H:i:s")."'
				,'".$ip."'
				,10)";	
		mysql_query($query,$sala);
		echo $query."<br>";
	}

	$insertSQL5 = "	INSERT INTO auditoria 
				(numerodocumento
				,usuario
				,fechaauditoria
				,codigomateria
				,grupo
				,codigoestudiante
				,notaanterior
				,notamodificada
				,corte
				,tipoauditoria
				,ip)
			VALUES( '".$codigousuario."',
				'".$usuario."',
				'".date("Y-m-j G:i:s",time())."', 
				'".$_SESSION['materias']."', 
				'".$_SESSION['grupos']."', 
				'".$row_estudiantess['codigoestudiante']."', 
				'".$row_estudiantes2['nota']."',
				'".$nota."', 
				'".$_POST['idcorte']."', 
				'10',
				'$ip')";				   
	mysql_select_db($database_sala, $sala);
	$Result1 = mysql_query($insertSQL5, $sala) or die(mysql_error());

	if (! $row_estudiantes2) { 
		$insertSQL1 = "	INSERT INTO detallenota 
					(idgrupo
					,idcorte
					,codigoestudiante
					,codigomateria
					,nota
					,numerofallasteoria
					,numerofallaspractica
					,codigotiponota)
				VALUES( '".$_SESSION['grupos']."',
					'".$_POST['idcorte']."', 
					'".$row_estudiantess['codigoestudiante']."',
					'".$_SESSION['materias']."',
					'".$nota."', 
					'".$fallasteoricas."',
					'".$fallaspracticas."',				   
					'10')";				   
		//echo $insertSQL1;
		//exit;
		mysql_select_db($database_sala, $sala);
		$Result2= mysql_query($insertSQL1, $sala) or die("$insertSQL1");
	} else {
		$base= "update detallenota
			set	nota ='".$nota."',			   
				numerofallasteoria = '".$fallasteoricas."',
				numerofallaspractica = '".$fallaspracticas."'
			where idcorte = '".$_POST['idcorte']."'
				and codigomateria = '".$_SESSION['materias']."'	
				and codigoestudiante = '".$row_estudiantess['codigoestudiante']."'"; 
		//echo $base,"<br>"; 
		$sol=mysql_db_query($database_sala,$base);	  
	} 

	$codigo = $row_estudiantess['numerodocumento'];
	$nombre= $row_estudiantess["apellidosestudiantegeneral"]." ".$row_estudiantess["nombresestudiantegeneral"];
	$query_grabar="	SELECT *
			FROM detallenota 
			WHERE idgrupo = '".$_SESSION['grupos']."'
				AND idcorte = '".$_POST['idcorte']."'
				and codigoestudiante = '".$row_estudiantess['codigoestudiante']."'";

	$grabar = mysql_query($query_grabar,$sala) OR die(mysql_error());
	$row_grabar = mysql_fetch_assoc($grabar);
	$totalRows_grabar = mysql_num_rows($grabar);

	echo "	<tr>
			<td align='center'><font face='Tahoma' size='2'>$codigo</font></td>
			<td align='center'><font face='Tahoma' size='2'>$nombre</font></td>
			<td align='center'><font face='Tahoma' size='2'>".$row_grabar['nota']."</font></td>
			<td align='center'><font face='Tahoma' size='2'>".$row_grabar['numerofallasteoria']."</font></td>
			<td align='center'><font face='Tahoma' size='2'>".$row_grabar['numerofallaspractica']."</font></td>
		</tr>"; 
	$f++;
} while($row_estudiantess = mysql_fetch_assoc($estudiantess));

echo "</table>";

session_unregister('materias');
session_unregister('grupos');
session_unregister('facultades');
session_unregister('cortes');
*/


?>