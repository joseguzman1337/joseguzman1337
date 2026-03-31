<?php require_once('../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
?>
<html>
<head>
	<title>Modificacion de Notas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script>
		function validar() {
			if(document.form1.usuario.value=="" || document.form1.carrera.value=="") {
				alert("Seleccione carrera y usuario");
			} else {
				document.form1.accion.value="guardar";
				document.form1.submit();
			}
		}
		function eliminar(id) {
			if(confirm('Esta seguro de eliminar el registro?')){
				document.form1.idelim.value=id;
				document.form1.accion.value="eliminar";
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
		.Estilo6 {font-family: Tahoma; font-weight: bold;}
		.Estilo7 {font-size: 12px; font-weight: bold; }
		.Estilo9 {font-size: 12}
		-->
	</style>
</head>
<body>
<?php
if ($_SESSION['MM_Username']!="admintecnologia") {
	echo "<h2>No tiene permisos para acceder a esta opción o su sesión ha caducado.</h2>";
	exit;
} else {
?>
	<span class="style5">  </span>
	<form name="form1" method="post" action="">
<?php
		if($_REQUEST["accion"]=="guardar") {
			$query="insert into aprobadoresmodificacionnotas (idaprobador,codigocarrera) values (".$_REQUEST["usuario"].",".$_REQUEST["carrera"].")";
			mysql_query($query,$sala);
			echo "<script>alert('Registro incorporado.')</script>";
		}
		if($_REQUEST["accion"]=="eliminar") {
			$query="delete from aprobadoresmodificacionnotas where id=".$_REQUEST["idelim"];
			mysql_query($query,$sala);
			echo "<script>alert('Registro eliminado.')</script>";
		}
?>
		<input type="hidden" name="accion">
		<input type="hidden" name="idelim">
		<div align="center">
			<p class="Estilo1 Estilo2">PERMISOS USUARIOS PARA GESTIÓN NOTAS</p>
		</div>
		<br>
		<table width="70%"  border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
			<tr>
				<td bgcolor="#C5D5D6" class="Estilo5" width="30%"><div align="center"><strong>Carrera</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5" width="30%"><div align="center"><strong>Usuario</strong></div></td>
				<td bgcolor="#C5D5D6" class="Estilo5" width="10%"><div align="center"><strong>&nbsp;</strong></div></td>
			</tr>
			<tr>
				<td bgcolor="#C5D5D6" class="Estilo5" width="30%">
					<div align="center">
						<strong>
							<select name="carrera" style="width:400px" onchange="form1.submit()">
								<option value="">seleccione carrera...</option>
<?php           
                /*
                 * Agreagr codigomodalidadacademica 600
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Modificado 17 de Enero de 2018.
                 */
								$query="select codigocarrera
										,nombrecarrera
									from carrera
									where codigomodalidadacademica in (200,300,400,600)
										and fechavencimientocarrera>current_date()
										and codigocarrera<>1
										and codigocarrera not in (select codigocarrera from aprobadoresmodificacionnotas)
									order by nombrecarrera";
								$regs = mysql_query($query,$sala);
								while ($row = mysql_fetch_assoc($regs)) {
									$selected=($_REQUEST["carrera"]==$row["codigocarrera"])?"selected":"";
									echo "<option value='".$row["codigocarrera"]."' ".$selected.">".$row["nombrecarrera"]."</option>";
								}
//                                                                end
?>
							</select>
						</strong>
					</div>
				</td>
<?php
				if ($_REQUEST["carrera"] && !$_REQUEST["accion"]) {
?>
					<td bgcolor="#C5D5D6" class="Estilo5" width="30%">
						<div align="center">
							<strong>
								<select name="usuario" style="width:400px">
									<option value="">seleccione usuario...</option>
<?php
                    //from usuario u join usuariorol ur using(usuario)
                /*
                 * Agreagr idrol 99 (coordinador de facultad)
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Modificado 17 de Enero de 2018.
                 */
                    
									$query="select	 distinct
											 u.idusuario
											,concat(u.usuario,' - ',u.apellidos,' ',nombres) as user
                                            from usuario u
                                            INNER JOIN UsuarioTipo ut on ut.UsuarioId = u.idusuario
                                            INNER JOIN usuariorol ur on ur.idusuariotipo = ut.UsuarioTipoId
										where ur.idrol in (93,99)
											and u.codigoestadousuario like '1%'
											and usuario in ( 
													select usuario
													from usuariofacultad 
													where codigofacultad=".$_REQUEST["carrera"]."
													)
										order by user";
									$regs = mysql_query($query,$sala);
									while ($row = mysql_fetch_assoc($regs))
										echo "<option value='".$row["idusuario"]."'>".$row["user"]."</option>";
?>
								</select>
							</strong>
						</div>
					</td>
					<td bgcolor="#C5D5D6" class="Estilo5" width="10%">
						<div align="center">
							<strong>
								<input type="button" value="Guardar" onclick="javascript:validar()">
							</strong>
						</div>
					</td>
<?php
				}
?>
			</tr>
<?php
		$query="select	 id
				,concat(usuario,' - ',apellidos,' ',nombres) as user
				,nombrecarrera
			from aprobadoresmodificacionnotas a
			join usuario u on a.idaprobador=u.idusuario
			join carrera c using(codigocarrera)
			order by id desc";
		$regs = mysql_query($query,$sala);
		while ($row = mysql_fetch_assoc($regs)) {
?>
			<tr>
				<td class="Estilo5" width="30%"><div align="center"><strong> </strong><?php echo$row["nombrecarrera"]?></div></td>
				<td class="Estilo5" width="30%"><div align="center"><strong> </strong><?php echo$row["user"]?></div></td>
				<td class="Estilo5" width="10%"><div align="center"><strong> </strong><input type="button" value="X" onclick="javascript:eliminar(<?php echo$row["id"]?>)"></div></td>
			</tr>
<?php
		}
?>
		</table>
	</form>
<?php
}
?>
</body>
</html>
