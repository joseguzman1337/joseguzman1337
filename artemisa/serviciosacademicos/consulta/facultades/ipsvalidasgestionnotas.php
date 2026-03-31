<?php require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
?>
<html>
<head>
	<title>IPs válidas Gestión de Notas</title>
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
		caption {
			text-align: left;
			padding: 10px 0;
		}
		-->
	</style>
        <?php
        /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         * Se cambian js ,css y imagen externa por locales
         *<link rel="stylesheet" href="//code.jquery.com/ui/3.6.0/themes/smoothness/jquery-ui.css">
          <script src="//code.jquery.com/jquery-1.13.1.js"></script>
	  <script src="//code.jquery.com/ui/3.6.0/jquery-ui.js"></script>
         * http://jqueryui.com/resources/demos/datepicker/images/calendar.gif
         *@since november 30,2018
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
<?php
//if ($_SESSION['MM_Username']!="admintecnologia") {
//	echo "<h2>No tiene permisos para acceder a esta opción o su sesión ha caducado.</h2>";
//	exit;
//} else {
?>
	<span class="style5">  </span>
	<form name="form1" method="post" action="ipsvalidasgestionnotas.php">
<?php
		if($_REQUEST["accion"]=="Guardar") {
			if($_REQUEST["id"])
				$query="update ipsvalidasmodificacionnotas set ip='".$_REQUEST["ip"]."',fechadesde='".$_REQUEST["fechadesde"]."',fechahasta='".$_REQUEST["fechahasta"]."',nombreusuario='".$_REQUEST["nombreusario"]."',facultadprograma='".$_REQUEST["facprograma"]."',cargo='".$_REQUEST["cargo"]."',codigoestado='".$_REQUEST["codigoestado"]."' where id=".$_REQUEST["id"];
			else
				$query="insert into ipsvalidasmodificacionnotas (ip,fechadesde,fechahasta,nombreusuario,facultadprograma,cargo) values ('".$_REQUEST["ip"]."','".$_REQUEST["fechadesde"]."','".$_REQUEST["fechahasta"]."','".$_REQUEST["nombreusario"]."','".$_REQUEST["facprograma"]."','".$_REQUEST["cargo"]."')";	
			mysql_query($query,$sala);
			echo "<script>alert('el registro ha sido guardado.')</script>";
		}
		if($_REQUEST["accion"]=="Eliminar") {
			$query="delete from ipsvalidasmodificacionnotas where id=".$_REQUEST["id"];
			mysql_query($query,$sala);
			echo "<script>alert('el registro ha sido eliminado.')</script>";
		}
?>


		<div align="center">
			<p class="Estilo1 Estilo2">IPs VÁLIDAS GESTIÓN NOTAS</p>
		</div>
		<br>
		<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
		<caption><input type="button" value="Nueva" onclick="location.href='ipsvalidasgestionnotas.php?accion=Nueva'"></caption>
<thead>
			<tr>
                <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nombre usuario</strong></div></td>
                <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Facultad/Programa</strong></div></td>
                <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Cargo</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Dirección IP</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha desde</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha hasta</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Estado</strong></div></td>
                <td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>&nbsp;</strong></div></td>
			</tr>
</thead>
<tbody>
<?php
			$query="SELECT *
				FROM ipsvalidasmodificacionnotas
				JOIN estado using(codigoestado)";
			$regs = mysql_query($query,$sala);
			if(mysql_num_rows($regs)) {
				while ($row = mysql_fetch_assoc($regs)) {
?>
					<tr>
						<td class="Estilo5"><div align="center"><?php echo$row["nombreusuario"]?></div></td>
                        <td class="Estilo5"><div align="center"><?php echo$row["facultadprograma"]?></div></td>
                        <td class="Estilo5"><div align="center"><?php echo$row["cargo"]?></div></td>
                        <td class="Estilo5"><div align="center"><?php echo$row["ip"]?></div></td>
						<td class="Estilo5"><div align="center"><?php echo$row["fechadesde"]?></div></td>
						<td class="Estilo5"><div align="center"><?php echo$row["fechahasta"]?></div></td>
                        <td class="Estilo5"><div align="center"><?php echo$row["nombreestado"]?></div></td>
						<td class="Estilo6">

							<div>
<?php
								echo "<input type='button' value='Editar' onclick=\"location.href='ipsvalidasgestionnotas.php?accion=Editar&id=".$row["id"]."'\"><input type='button' value='Eliminar' onclick=\"if(confirm('Está seguro de eliminar el registro?')){location.href='ipsvalidasgestionnotas.php?accion=Eliminar&id=".$row["id"]."'}\">" 
?>
							</div>
						</td>
					</tr>
<?php
				} // cierra while
			} else {
				echo "<tr><th colspan='5'>Actualmente no hay ip's configuradas</th></tr>";
			}
?>
</tbody>
		</table>
<?php
		if($_REQUEST["accion"]=="Nueva" || $_REQUEST["accion"]=="Editar") {
			if($_REQUEST["id"]) {
				$query="SELECT *
					FROM ipsvalidasmodificacionnotas
					WHERE id=".$_REQUEST["id"];
				$regs = mysql_query($query,$sala);
				$row = mysql_fetch_assoc($regs);
			}
?>
			<br><br>
			<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
				<tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Nombre usuario</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='nombreusario' value='<?php echo$row["nombreusuario"]?>' style='text-align:center' id="nombreusario" size="40" required></div></td>
				</tr>
                <tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Facultad/Programa</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='facprograma' value='<?php echo$row["facultadprograma"]?>' style='text-align:center' id="facprograma" size="40" required></div></td>
				</tr>
                <tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Cargo</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='cargo' value='<?php echo$row["cargo"]?>' style='text-align:center' id="cargo" size="40" required></div></td>
				</tr>
                <tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Dirección IP</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='ip' value='<?php echo$row["ip"]?>' style='text-align:center' required></div></td>
				</tr>
				<tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha desde</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='fechadesde' value='<?php echo$row["fechadesde"]?>' style='text-align:center' id="datepicker" size="10" required readonly></div></td>
				</tr>
				<tr>
					<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Fecha hasta</strong></div></td>
					<td class="Estilo5"><div align="center"><input type='text' name='fechahasta' value='<?php echo$row["fechahasta"]?>' style='text-align:center' id="datepicker2" size="10" required readonly></div></td>
				</tr>
                
<?php
				if($_REQUEST["id"]) {
?>
					<tr>
						<td bgcolor="#C5D5D6" class="Estilo5"><div align="center"><strong>Estado</strong></div></td>
						<td class="Estilo5">
							<select name="codigoestado">
<?php
								$query2="SELECT * from estado where codigoestado<>'300'";
								$regs2 = mysql_query($query2,$sala);
								while ($row2 = mysql_fetch_assoc($regs2)) {
									$selected=($row["codigoestado"]==$row2["codigoestado"])?"selected":"";
									echo "<option value='".$row2["codigoestado"]."' ".$selected.">".$row2["nombreestado"]."</option>";
								}
?>
							</select>
						</td>
					</tr>
<?php
				}
?>
				<tr>
					<td bgcolor="#C5D5D6" class="Estilo5" colspan="2"><div align="center">
						<input type="hidden" name="id" value="<?php echo$_REQUEST["id"]?>">
						<input type="submit" value="Guardar" name="accion">
					</div></td>
				</tr>
			</table>
<?php
		}
?>
	</form>
<?php
//}
?>
</body>
</html>
