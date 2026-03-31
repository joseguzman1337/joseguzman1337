<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    
//var_dump(is_file("../../EspacioFisico/templates/template.php"));die;
require_once('../../Connections/sala2.php');
	//conexion personal

//var_dump($sala);
    
mysql_select_db($database_sala, $sala);
session_start();
//$_SESSION['MM_Username'] = 'Manejo Sistema';
//$_SESSION['MM_Username'] = 'coorposodonto';


$Automatico = $_REQUEST['op'];

?>
<html>
<head>
	<title>Modificacion de Notas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script>
		function aprobar(id) {
			if(confirm('Esta seguro de aprobar las modificaciones para la solicitud "'+id+'"?')){
				document.form1.id.value=id;
				document.form1.accion.value="aprobar";
				document.form1.submit();
			}
		}
		function rechazar(id) {
			if(confirm('Esta seguro de rechazar las modificaciones para la solicitud "'+id+'"?')){
				document.form1.id.value=id;
				document.form1.accion.value="rechazar";
				document.form1.submit();
			}
		}
	</script>
	<style type="text/css">
		<!--
		.style1 {
			font-family: Tahoma;
			font-size: small;
		}
		.style3 {
			font-size: x-small;
			font-weight: bold;
			font-family: Tahoma;
		}
		.style4 {
			font-size: x-small;
			font-family: Tahoma;
		}
		.style5 {
			font-family: Tahoma;
			font-size: x-small;
		}
		body {
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		a:link {
			text-decoration: none;
			color: #000000;
		}
		a:visited {
			text-decoration: none;
			color: #000000;
		}
		a:hover {
			text-decoration: none;
			color: #000000;
		}
		a:active {
			text-decoration: none;
			color: #000000;
		}
		.Estilo1 {
			font-family: Tahoma;
			font-weight: bold;
			font-size: small;
		}
		.Estilo2 {font-size: 14px}
		.Estilo4 {font-size: 12; font-weight: bold; }
		.Estilo5 {font-family: Tahoma; font-size: 12px; }
		.Estilo6 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
		.Estilo7 {font-size: 12px; font-weight: bold; }
		.Estilo9 {font-size: 12}
		-->
	</style>
</head>
<body>
<?php
$query="select	 a.idaprobador
		,group_concat(a.codigocarrera separator ',') as codigoscarrera
	from aprobadoresmodificacionnotas a
	join (select idusuario from usuario where usuario='".$_SESSION['MM_Username']."') s on a.idaprobador=s.idusuario
	group by  a.idaprobador";
    
    //echo '<pre>'.$query;
   if(!$Automatico){
        $regAprobador = mysql_query($query,$sala);
        $Num = mysql_num_rows($regAprobador);
    }else{
        $Num = $Automatico;
    }
    
if ($Num==0) {
	echo "<h2>No tiene permisos para acceder a esta opción o su sesión ha caducado.</h2>";
	exit;
} else {
    
	$rowAprobador = mysql_fetch_assoc($regAprobador);
?>
	<span class="style5">  </span>
	<form name="form1" method="post" action="">
<?php
		if($_REQUEST["accion"]=="aprobar" || $_REQUEST["accion"]=="rechazar") {
			$fecha=date("Y-m-d H:i:s");
			$query="select	 s.*
					,tnh.nombretiponotahistorico
					,eg.numerodocumento
					,eg.apellidosestudiantegeneral
					,eg.nombresestudiantegeneral
					,u.numerodocumento as documentosolicitante
					,u.usuario as usuariosolicitante
					,concat(u.usuario,'@unbosque.edu.co') as emailsolicitante
					,concat(u.apellidos,' ',u.nombres) as nombresolicitante
					,m.nombremateria
				from solicitudaprobacionmodificacionnotas s
				left join tiponotahistorico tnh using(codigotiponotahistorico)
				join estudiante e using(codigoestudiante)
				join estudiantegeneral eg using(idestudiantegeneral)
				join usuario u on s.idsolicitante=u.idusuario
				join materia m using(codigomateria)
				where id=".$_REQUEST["id"];
                
              //echo $query;
			$reg = mysql_query($query,$sala);
			$row = mysql_fetch_assoc($reg);
        
			$tabla="<table border='1' align='center' bordercolor='#003333'>       
					<tr>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Id Solicitud</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Documento</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Apellidos y Nombres</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Materia</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>Nota</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FT</strong></font></td>
						<td align='center' bgcolor='#C5D5D6'><font face='Tahoma' size='2'><strong>FP</strong></font></td>
					</tr>
					<tr>
						<td align='center'><font face='Tahoma' size='2'>".$_REQUEST["id"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row['numerodocumento']."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row["apellidosestudiantegeneral"]." ".$row["nombresestudiantegeneral"]."</font></td>
						<td align='center'><font face='Tahoma' size='2'>".$row['nombremateria']."</font></td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row["notaanterior"] != $row["notamodificada"]) {
								$tabla.="<table width='100%' bgcolor='#CFFFEC'>
										<tr><td>Nota anterior:</td><th>".$row["notaanterior"]."</th></tr>
										<tr><td>Nueva nota:</td><th>".$row["notamodificada"]."</th></tr>
									</table>";
							}
			$tabla.="		</td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row["numerofallasteoriaanterior"] != $row["numerofallasteoriamodificada"]) {
								$tabla.="<table width='100%' bgcolor='#FAFFCF'>
										<tr><td>FT anteriores:</td><th>".$row["numerofallasteoriaanterior"]."</th></tr>
										<tr><td>Nuevas FT:</td><th>".$row["numerofallasteoriamodificada"]."</th></tr>
									</table>";
							}
			$tabla.="		</td>
						<td align='center'><font face='Tahoma' size='2'>";
							if ($row["numerofallaspracticaanterior"] != $row["numerofallaspracticamodificada"]) {
								$tabla.="<table width='100%' bgcolor='#FFDFFE'>
										<tr><td>FP anteriores:</td><th>".$row["numerofallaspracticaanterior"]."</th></tr>
										<tr><td>Nuevas FP:</td><th>".$row["numerofallaspracticamodificada"]."</th></tr>
									</table>";
							}
			$tabla.="		</td>
					</tr>
				</table>";

			if($_REQUEST["accion"]=="aprobar") { 
                //si es 10 es una nota normal de modificacion
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==10) { 
					if($row["insdelupd"]=='I') {
						$query="INSERT INTO detallenota
								(idgrupo
								,idcorte
								,codigoestudiante
								,codigomateria
								,nota
								,numerofallasteoria
								,numerofallaspractica
								,codigotiponota)
							VALUES ( ".$row["idgrupo"]."
								,".$row["idcorte"]."
								,".$row["codigoestudiante"]."
								,".$row["codigomateria"]."
								,'".$row["notamodificada"]."'
								,".$row["numerofallasteoriamodificada"]."
								,".$row["numerofallaspracticamodificada"]."
								,'10')";
					} else {
						$queryCampos="";
						if($row["notaanterior"] != $row["notamodificada"])
							$queryCampos .= "nota='".$row["notamodificada"]."'";
						if($row["numerofallasteoriaanterior"] != $row["numerofallasteoriamodificada"]) {
							$queryCampos .= ($queryCampos)?",":"";
							$queryCampos .= "numerofallasteoria='".$row["numerofallasteoriamodificada"]."'";
						}
						if($row["numerofallaspracticaanterior"] != $row["numerofallaspracticamodificada"]) {
							$queryCampos .= ($queryCampos)?",":"";
							$queryCampos .= "numerofallaspractica='".$row["numerofallaspracticamodificada"]."'";
						}
						$query="UPDATE detallenota
							SET ".$queryCampos." 
							WHERE idcorte = '".$row['idcorte']."'
								AND codigomateria = '".$row['codigomateria']."'
								AND codigoestudiante = '".$row['codigoestudiante']."'";
						//echo $query."<br>";
					}
					mysql_query($query,$sala);
					$msjsubject="Solicitud de modificación de notas aprobada";
				}
                
               	if ($row["idtiposolicitudaprobacionmodificacionnotas"]==20) { 
					$_GET["tiponota"]=$row["codigotiponotahistorico"];
					$_GET["nota"]=$row["notamodificada"];
					$_GET["nombretiponotahistorico"]=$row["nombretiponotahistorico"];
					$_GET["estadonota"]=$row["codigoestadonotahistorico"];
					$_GET["observacion"]=$row["observaciones"];
					$_GET["idhistorico"]=$row["idnotahistorico"];
					$_GET["ajax"]="";
                    
					require_once("modificahistoricooperacion.php");
					$msjsubject="Solicitud de desactivación de nota en el histórico de notas aprobada";
				}
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==30) { 
					$_GET["tiponota"]=$row["codigotiponotahistorico"];
					$_GET["codigoestudiante"]=$row["codigoestudiante"]; 
					$_GET["periodo"]=$row["codigoperiodo"]; 
					$_GET["materia"]=$row["codigomateria"]; 
					$_GET["notas"]=$row["notamodificada"];
					$_GET["planestudiante"]=$row["idplanestudio"]; 
					$_GET["observacion"]=$row["observaciones"];
					$_GET["tipomateria"]=$row["codigotipomateria"]; 
					if($row["CodigoMateriaElectiva"]!=1){
						$_GET['materia']=$row["CodigoMateriaElectiva"]; 
						$_GET['materiaelectiva']=$row["codigomateria"]; 
					}
					$_GET["ajax"]="";
					require_once("modificahistoricooperacion.php");
					$msjsubject="Solicitud de ingreso de nota en el histórico de notas aprobada";
				}
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==40) { 
					$_GET["tiponota"]=$row["codigotiponotahistorico"];
					$_GET["codigoestudiante"]=$row["codigoestudiante"];
					$_GET["periodo"]=$row["codigoperiodo"];
					$_GET["materia"]=$row["codigomateria"];
					$_GET["notas"]=$row["notamodificada"];
					$_GET["planestudiante"]=$row["idplanestudio"];
					$_GET["observacion"]=$row["observaciones"];
					if($row["CodigoMateriaElectiva"]!=1){
						$_GET['materia']=$row["CodigoMateriaElectiva"]; 
						$_GET['materiaelectiva']=$row["codigomateria"]; 
					}
					$_GET["ajax"]="";
					require_once("modificahistoricooperacionmedicina.php");
					$msjsubject="Solicitud de ingreso de notas por homologación aprobada";
				}

				$query="update solicitudaprobacionmodificacionnotas
					set codigoestadosolicitud='11',fechaaprobacion='".$fecha."'
					where id=".$_REQUEST["id"];
				//echo $query."<br>";
				mysql_query($query,$sala);

				$nota_ant=($row["notaanterior"])?$row["notaanterior"]:"null";
				$nota_mod=($row["notamodificada"])?$row["notamodificada"]:"null";
				$query="insert into auditoria
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
					values ( '".$row["documentosolicitante"]."'
						,'".$row["usuariosolicitante"]."'
						,'".$fecha."'
						,".$row["codigomateria"]."
						,'".$row["idgrupo"]."'
						,".$row["codigoestudiante"]."
						,".$nota_ant."
						,".$nota_mod."
						,'".$row["idcorte"]."'
						,'10'
						,'".$row["ipsolicitante"]."')";
				mysql_query($query,$sala);
				$msjalert="La solicitud \"".$_REQUEST["id"]."\" ha sido aprobada.";
				$msjbody="La siguiente solicitud ha sido aprobada:";
			}
			if($_REQUEST["accion"]=="rechazar") {
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==10) 
					$msjsubject="Solicitud de modificación de notas rechazada";
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==20) 
					$msjsubject="Solicitud de desactivación de nota en el histórico de notas rechazada";
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==30) 
					$msjsubject="Solicitud de ingreso de nota en el histórico de notas rechazada";
				if ($row["idtiposolicitudaprobacionmodificacionnotas"]==40) 
					$msjsubject="Solicitud de ingreso de notas por homologación rechazada";
				$fecha=date("Y-m-d H:i:s");
				$query="update solicitudaprobacionmodificacionnotas
					set codigoestadosolicitud='20',fechaaprobacion='".$fecha."'
					where id=".$_REQUEST["id"];
				//echo $query."<br>";
				mysql_query($query,$sala);
				
				$msjalert="La solicitud \"".$_REQUEST["id"]."\" ha sido rechazada.";
				$msjbody="La siguiente solicitud ha sido rechazada:";
			}
            if(!$Automatico){
            
			require_once("../../funciones/phpmailer/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->From = "no-reply@unbosque.edu.co";
			$mail->FromName = "Sistema SALA";
			$mail->ContentType = "text/html";
			$mail->Subject = $msjsubject;
			$mail->Body = "<b>".$msjbody."</b><br><br>".$tabla;
			//$mail->AddAddress("dianarojas@unbosque.edu.co","Diana Rojas");
			//$mail->AddBCC("quinteroivan@unbosque.edu.co","Ivan Dario Quintero");
			//$mail->AddAddress("it@unbosque.edu.co","Jorge Martínez");
			//$mail->AddAddress("stipmp@gmail.com","Edwin Murcia");
			$mail->AddAddress($row["emailsolicitante"],$row["nombresolicitante"]);
			$mail->Send();
			echo "<script>alert('".$msjalert."');</script>";
            
            }
		}
		if(!$Automatico){
?>

		<input type="hidden" name="accion">
		<input type="hidden" name="id">

		<div align="center">
			<p class="Estilo1 Estilo2">SOLICITUDES EN ESPERA DE APROBACIÓN</p>
		</div>
		<br>
		<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
			<tr>	
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Tipo de solicitud</strong></div></td>
				<td class="Estilo5">
					<div align="center">
						<select name="tiposolicitud" onchange="document.form1.submit()">
							<option value="">Seleccione un tipo de solicitud...</option> 
<?php
							$query="select	 id
									,tiposolicitudaprobacionmodificacionnotas
								from tipossolicitudaprobacionmodificacionnotas
								where codigoestado like '1%';";
							$regs = mysql_query($query,$sala);
							while ($row = mysql_fetch_assoc($regs)) {
								$selected=($_REQUEST["tiposolicitud"]==$row["id"])?"selected":"";
?>
								<option value="<?php echo$row["id"]?>" <?php echo$selected?>><?php echo$row["tiposolicitudaprobacionmodificacionnotas"]?></option>
<?php
							}
?>
						</select>
					</div>
				</td>
			</tr>
		</table>
<?php
		if($_REQUEST["tiposolicitud"]!="") {
?>
			<br>
			<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
				<tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Id solicitud</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Usuario solicitante</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nombre solicitante</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha solicitud</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Carrera</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Matería</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Grupo</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nro. corte</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nro. documento estudiante</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Apellidos estudiante</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nombres estudiante</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center" width="15%"><strong>Modificaciones</strong></div></td>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>&nbsp;</strong></div></td>
				</tr>
<?php
				$condicion=($_REQUEST["tiposolicitud"]==40)?"e":"m";
				$query=" SELECT s.id
						,g.nombregrupo
						,c.numerocorte
						,m.nombremateria
						,ca.nombrecarrera
						,eg.numerodocumento
						,eg.apellidosestudiantegeneral
						,eg.nombresestudiantegeneral
						,s.notaanterior
						,s.notamodificada
						,s.numerofallasteoriaanterior
						,s.numerofallasteoriamodificada
						,s.numerofallaspracticaanterior
						,s.numerofallaspracticamodificada
						,s.fechasolicitud
						,u.usuario
						,concat(apellidos,' ',nombres) as solicitante,
						s.CodigoMateriaElectiva
					from solicitudaprobacionmodificacionnotas s
					left join grupo g on s.idgrupo=g.idgrupo
					left join corte c on s.idcorte=c.idcorte
					join materia m on s.codigomateria=m.codigomateria
					join carrera ca on m.codigocarrera=ca.codigocarrera
					join estudiante e on s.codigoestudiante=e.codigoestudiante
					join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
					join usuario u on s.idsolicitante=u.idusuario
					where codigoestadosolicitud=10
						and ".$condicion.".codigocarrera in (".$rowAprobador["codigoscarrera"].")
						and s.idtiposolicitudaprobacionmodificacionnotas=".$_REQUEST["tiposolicitud"]."
					order by id desc";
                    //echo $query;
					$regs = mysql_query($query,$sala);
				if(mysql_num_rows($regs)) {
					while ($row = mysql_fetch_assoc($regs)) {
?>
						<tr>
							<td class="Estilo5"><div align="center"><?php echo$row["id"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["usuario"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["solicitante"]?></div></td>
							<td class="Estilo5"><div align="center"><?php echo$row["fechasolicitud"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["nombrecarrera"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["nombremateria"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["nombregrupo"]?></div></td>
							<td class="Estilo5"><div align="center"><?php echo$row["numerocorte"]?></div></td>
							<td class="Estilo5"><div align="right"><?php echo$row["numerodocumento"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["apellidosestudiantegeneral"]?></div></td>
							<td class="Estilo5"><div><?php echo$row["nombresestudiantegeneral"]?></div></td>
							<td class="Estilo6" width="15%">

								<div>
<?php 
								if($row["notaanterior"]!=$row["notamodificada"]) {
									echo "	<table width='100%' bgcolor='#CFFFEC'>
											<tr><td>Nota anterior:</td><th>".$row["notaanterior"]."</th></tr>
											<tr><td>Nueva nota:</td><th>".$row["notamodificada"]."</th></tr>
										</table>";
								}
								if($row["numerofallasteoriaanterior"]!=$row["numerofallasteoriamodificada"]) {
									echo "	<table width='100%' bgcolor='#FAFFCF'>
											<tr><td>FT anteriores:</td><th>".$row["numerofallasteoriaanterior"]."</th></tr>
											<tr><td>Nuevas FT:</td><th>".$row["numerofallasteoriamodificada"]."</th></tr>
										</table>";
								}
								if($row["numerofallaspracticaanterior"]!=$row["numerofallaspracticamodificada"]) {
									echo "	<table width='100%' bgcolor='#FFDFFE'>
											<tr><td>FP anteriores:</td><th>".$row["numerofallaspracticaanterior"]."</th></tr>
											<tr><td>Nuevas FP:</td><th>".$row["numerofallaspracticamodificada"]."</th></tr>
										</table>";
								}
	?>
								</div>
							</td>
							<td class="Estilo5" width="8%">
								<div align="center">
									<img src="imagesAlt2/aprobar.png"  onclick="javascript:aprobar(<?php echo$row["id"]?>)">
									<img src="imagesAlt2/rechazar.png"  onclick="javascript:rechazar(<?php echo$row["id"]?>)">
								</div>
							</td>
						</tr>
<?php
					} // cierra while
				} else {
					echo "<tr><th colspan='12'>Actualmente no tiene solicitudes pendientes</th></tr>";
				}
?>
			</table>
<?php
			}
		
		} //si no es automatico
?>
	</form>
<?php
}
?>
</body>
</html>
