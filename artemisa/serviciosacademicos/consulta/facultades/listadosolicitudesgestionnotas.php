<?php require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();

$queryDoF = "select codigocarrera, nombrecarrera from carrera join (select distinct codigocarrera from solicitudaprobacionmodificacionnotas join materia using(codigomateria)) sub using(codigocarrera)";

$tblEnc="<table border='1' align='center' cellpadding='2' cellspacing='1' bordercolor='#003333'>
		<tr>
			<td bgcolor='#C5D5D6' class='Estilo5'>
				<div align='center'><strong>Dpto o facultad</strong></div>
			</td>";
			$queryEst = "	select * from estadosolicitudcredito where codigoestadosolicitudcredito in (10,11,20,21)";
			$regsEst = mysql_query($queryEst,$sala);
			while ($rowEst = mysql_fetch_assoc($regsEst)) {
				$tblEnc.="<td bgcolor='#C5D5D6' class='Estilo5'>
						<div align='center'><strong>".$rowEst["nombreestadosolicitudcredito"]."</strong></div>
					</td>";
			}
$tblEnc.="	</tr>";
		$condicion=($_REQUEST["codigocarrera"]!="")?"where codigocarrera=".$_REQUEST["codigocarrera"]:"";
        $order =" ORDER BY nombrecarrera ASC";
		$query=$queryDoF." ".$condicion;
		$regs = mysql_query($query,$sala);
		while ($row = mysql_fetch_assoc($regs)) {
			$tblEnc.="<tr>
					<td class='Estilo5'><div>".$row["nombrecarrera"]."</div></td>";
					$regsEst = mysql_query($queryEst,$sala);
					while ($rowEst = mysql_fetch_assoc($regsEst)) {
						$query2="select count(*) total
							from solicitudaprobacionmodificacionnotas
							join materia using(codigomateria)
							where codigoestadosolicitud='".$rowEst["codigoestadosolicitudcredito"]."'
								and codigocarrera='".$row["codigocarrera"]."'
								and (fechasolicitud between '".$_REQUEST["fechadesde"]." 00:00:00' and '".$_REQUEST["fechahasta"]." 23:59:59')";
						$regs2 = mysql_query($query2,$sala);
						$row2 = mysql_fetch_assoc($regs2);
						$vlr=($row2["total"]==0)?$row2["total"]:"<a href=\"?accion=Detalle&codigoestadosolicitud=".$rowEst["codigoestadosolicitudcredito"]."&codigocarrera=".$row["codigocarrera"]."&fechadesde=".$_REQUEST["fechadesde"]."&fechahasta=".$_REQUEST["fechahasta"]."\" target=\"_blank\" onClick=\"window.open(this.href, this.target, 'width=1200, height=600, scrollbars=yes'); return false;\">".$row2["total"]."</a>";
						$tblEnc.="<td class='Estilo5'><div align='center'>".$vlr."</div></td>";
					
					}
			$tblEnc.="</tr>";
		}
$tblEnc.="</table>";

$tblDet="<table border='1' align='center' cellpadding='2' cellspacing='1' bordercolor='#003333'>
		<tr>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Id solicitud</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Usuario solicitante</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Nombre solicitante</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Fecha solicitud</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Carrera</strong></div></td>
            <td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Codigo Matería</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Matería</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Grupo</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Nro. corte</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Nro. documento estudiante</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Apellidos estudiante</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Nombres estudiante</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Tipo solicitud</strong></div></td>
			<td bgcolor='#C5D5D6' class='Estilo5'><div align='center'><strong>Modificaciones</strong></div></td>
		</tr>";
		$query=" SELECT s.id
				,g.nombregrupo
				,c.numerocorte
				,m.nombremateria
                ,m.codigomateria
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
				,ts.tiposolicitudaprobacionmodificacionnotas
				,concat(apellidos,' ',nombres) as solicitante
			from solicitudaprobacionmodificacionnotas s
			left join grupo g on s.idgrupo=g.idgrupo
			left join corte c on s.idcorte=c.idcorte
			join materia m on s.codigomateria=m.codigomateria
			join carrera ca on m.codigocarrera=ca.codigocarrera
			join estudiante e on s.codigoestudiante=e.codigoestudiante
			join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
			join usuario u on s.idsolicitante=u.idusuario
			join tipossolicitudaprobacionmodificacionnotas ts on s.idtiposolicitudaprobacionmodificacionnotas=ts.id
			where codigoestadosolicitud=".$_REQUEST["codigoestadosolicitud"]."
				and m.codigocarrera=".$_REQUEST["codigocarrera"]."
				and (fechasolicitud between '".$_REQUEST["fechadesde"]." 00:00:00' and '".$_REQUEST["fechahasta"]." 23:59:59')";
		$regs = mysql_query($query,$sala);
		if(mysql_num_rows($regs)) {
			while ($row = mysql_fetch_assoc($regs)) {
				$tblDet.="<tr>
						<td class='Estilo5'><div>".$row["id"]."</div></td>
						<td class='Estilo5'><div>".$row["usuario"]."</div></td>
						<td class='Estilo5'><div>".$row["solicitante"]."</div></td>
						<td class='Estilo5'><div>".$row["fechasolicitud"]."</div></td>
						<td class='Estilo5'><div>".$row["nombrecarrera"]."</div></td>
                        <td class='Estilo5'><div>".$row["codigomateria"]."</div></td>
						<td class='Estilo5'><div>".$row["nombremateria"]."</div></td>
						<td class='Estilo5'><div>".$row["nombregrupo"]."</div></td>
						<td class='Estilo5'><div>".$row["numerocorte"]."</div></td>
						<td class='Estilo5'><div>".$row["numerodocumento"]."</div></td>
						<td class='Estilo5'><div>".$row["apellidosestudiantegeneral"]."</div></td>
						<td class='Estilo5'><div>".$row["nombresestudiantegeneral"]."</div></td>
						<td class='Estilo5'><div>".$row["tiposolicitudaprobacionmodificacionnotas"]."</div></td>
						<td class='Estilo6'>
							<div>";
								if($row["notaanterior"]!=$row["notamodificada"]) {
									$tblDet.="<table width='100%' bgcolor='#CFFFEC'>
											<tr><td>Nota anterior:</td><th>".$row["notaanterior"]."</th></tr>
											<tr><td>Nueva nota:</td><th>".$row["notamodificada"]."</th></tr>
										</table>";
								}
								if($row["numerofallasteoriaanterior"]!=$row["numerofallasteoriamodificada"]) {
									$tblDet.="<table width='100%' bgcolor='#FAFFCF'>
											<tr><td>FT anteriores:</td><th>".$row["numerofallasteoriaanterior"]."</th></tr>
											<tr><td>Nuevas FT:</td><th>".$row["numerofallasteoriamodificada"]."</th></tr>
										</table>";
								}
								if($row["numerofallaspracticaanterior"]!=$row["numerofallaspracticamodificada"]) {
									$tblDet.="<table width='100%' bgcolor='#FFDFFE'>
											<tr><td>FP anteriores:</td><th>".$row["numerofallaspracticaanterior"]."</th></tr>
											<tr><td>Nuevas FP:</td><th>".$row["numerofallaspracticamodificada"]."</th></tr>
										</table>";
								}
				$tblDet.="		</div>
						</td>
					</tr>";
			} // cierra while
		} else {
			$tblDet.="<tr><th colspan='11'>No se encontró información</th></tr>";
		}
$tblDet.="</table>";

if($_REQUEST["accion"]=="ExportarEnc") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="archivoEnc.xls"');
	header('Cache-Control: max-age=0');
	echo $tblEnc;
	exit;
}
if($_REQUEST["accion"]=="ExportarDet") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="archivoDet.xls"');
	header('Cache-Control: max-age=0');
	echo $tblDet;
	exit;
}
?>
<html>
<head>
	<title>Consulta solicitudes modificacion de Notas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        <?php
        /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         * cambio de librerias externas por locales
         *<script src="//code.jquery.com/jquery-1.13.1.js"></script>
         *<script src="//code.jquery.com/ui/3.6.0/jquery-ui.js"></script>
         *<link rel="stylesheet" href="//code.jquery.com/ui/3.6.0/themes/smoothness/jquery-ui.css">
         *se realiza cambio de url de buttonimage  http://jqueryui.com/resources/demos/datepicker/images/calendar.gif de imagen por imagen local 
         *@since 30 november,2018
         */
        ?>
        <link rel="stylesheet" href="../../../assets/css/jquery-ui-git.css">
        <script src="../../../assets/js/jquery.js"></script>
	<script src="../../../assets/js/jquery-ui.js"></script>
        
	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				 dateFormat: 'yy-mm-dd'
				,showOn: 'both'
				,buttonImage: '../../../assets/css/images/calendar.gif'
				,buttonImageOnly: true
				,changeMonth: true
				,changeYear: true
			});
			$( "#datepicker2" ).datepicker({
				 dateFormat: 'yy-mm-dd'
				,showOn: 'both'
				,buttonImage: '../../../assets/css/images/calendar.gif'
				,buttonImageOnly: true
				,changeMonth: true
				,changeYear: true
			});
		});
	</script>
</head>
<body>
	<span class="style5">  </span>
	<form name="form1" method="post" action="">
		<div align="center">
			<p class="Estilo1 Estilo2">CONSULTA DE SOLICITUDES DE MODIFICACIÓN DE NOTAS</p>
		</div>
		<br>
<?php
		if($_REQUEST["accion"]=="Detalle") {
			echo "<center><a href='listadosolicitudesgestionnotas.php?accion=ExportarDet&codigoestadosolicitud=".$_REQUEST["codigoestadosolicitud"]."&codigocarrera=".$_REQUEST["codigocarrera"]."&fechadesde=".$_REQUEST["fechadesde"]."&fechahasta=".$_REQUEST["fechahasta"]."'>Exportar</a></center>";
			echo $tblDet;
			exit;
		}
?>
		<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
			<tr>	
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Departamento o facultad</strong></div></td>
				<td class="Estilo5" colspan="3">
					<select name="codigocarrera">
						<option value="">Seleccione dpto o facultad...</option> 
<?php   
                        $queryDoF = $queryDoF." order by nombrecarrera ASC";
						$regs = mysql_query($queryDoF,$sala);
						while ($row = mysql_fetch_assoc($regs)) {
							$selected=($_REQUEST["codigocarrera"]==$row["codigocarrera"])?"selected":"";
?>
							<option value="<?php echo$row["codigocarrera"]?>" <?php echo$selected?>><?php echo$row["nombrecarrera"]?></option>
<?php
						}
?>
					</select>
				</td>
			</tr>
			<tr>	
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha desde:</strong></div></td>
				<td class="Estilo5">
					<div align="center">
						<input type="text" name="fechadesde" value="<?php echo$_REQUEST["fechadesde"]?>" size="10" style="text-align:center" id="datepicker" required readonly>
					</div>
				</td>
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha hasta:</strong></div></td>
				<td class="Estilo5">
					<div align="center">
						<input type="text" name="fechahasta" value="<?php echo$_REQUEST["fechahasta"]?>" size="10" style="text-align:center" id="datepicker2" required readonly>
					</div>
				</td>
			</tr>
			<tr>
				<td class="Estilo5" colspan="4">
					<div align="center">
						<input type="submit" name="accion" value="Generar">
					</div>
				</td>
			</tr>
		</table>
		<br>
<?php
		if($_REQUEST["accion"]=="Generar") {
			echo "<center><a href='listadosolicitudesgestionnotas.php?accion=ExportarEnc&codigocarrera=".$_REQUEST["codigocarrera"]."&fechadesde=".$_REQUEST["fechadesde"]."&fechahasta=".$_REQUEST["fechahasta"]."'>Exportar</a></center>";
			echo $tblEnc;
		}
?>
	</form>
</body>
</html>
