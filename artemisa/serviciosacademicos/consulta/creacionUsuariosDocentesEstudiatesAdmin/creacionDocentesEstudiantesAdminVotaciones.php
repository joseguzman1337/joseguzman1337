<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	//session_start();
	require_once($_SESSION["path_live"].'Connections/sala2.php');
	$rutaado = $_SESSION["path_live"]."funciones/adodb/";
	require_once($_SESSION["path_live"].'Connections/salaado.php');
?>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<form name="form1" id="form1" action="" method="POST" enctype="multipart/form-data">
	<table align="center" border="0" width="40%" cellpadding="5">
		<tr>
			<td><b>Tipo de usuario <font color="red">(*)</font></b></td>
			<td>
				<select name="tipo_usuario" required>
					<option value="1" <?=($_REQUEST["tipo_usuario"]==1)?"selected":""?>>Docente</option>
				</select>
			</td>	
		</tr>
		<tr>
			<td><b>Tipo de documento <font color="red">(*)</font></b></td>
			<td>
				<select name="tipodocumento">
<?php
					$query="select * from documento where tipodocumento<>0";
					$row=$db->Execute($query);
					while($reg=$row->FetchRow()) {
						$selected=($_REQUEST['tipodocumento']==$reg['tipodocumento'])?"selected":"";
						echo "<option value='".$reg['tipodocumento']."' ".$selected.">".$reg['nombredocumento']."</option>";
					}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Número de documento <font color="red">(*)</font></b></td>
			<td><input type="number" name="numerodocumento" value="<?=$_REQUEST["numerodocumento"]?>" size="10" maxlength="10" required></td>
		</tr>
		<tr>
			<td><b>Apellidos <font color="red">(*)</font></b></td>
			<td><input type="text" name="apellidos" value="<?=$_REQUEST["apellidos"]?>" size="20" required></td>
		</tr>
		<tr>
			<td><b>Nombres <font color="red">(*)</font></b></td>
			<td><input type="text" name="nombres" value="<?=$_REQUEST["nombres"]?>" size="20" required></td>
		</tr>
		<tr>
			<td><b>Dirección de correo alternativo <font color="red">(*)</font></b></td>
			<td><input type="email" name="email" value="<?=$_REQUEST["email"]?>" size="30" required></td>
		</tr>
		<tr>
			<td><b>Carrera <font color="red">(*)</font></b></td>
			<td>
				<select name="codigocarrera">
<?php
					$query="select codigocarrera,nombrecarrera from carrera where current_timestamp <= fechavencimientocarrera and codigomodalidadacademica in (200,300) and codigocarrera<>1 order by codigomodalidadacademica,nombrecarrera";
					$row=$db->Execute($query);
					while($reg=$row->FetchRow()) {
						$selected=($_REQUEST['codigocarrera']==$reg['codigocarrera'])?"selected":"";
						echo "<option value='".$reg['codigocarrera']."' ".$selected.">".$reg['nombrecarrera']."</option>";
					}
?>
				</select>
			</td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="hidden" name="tipo_creacion" value="1">
				<input type="hidden" name="espracticante" value="99">
				<input type="submit" name="accion" value="Crear">
			</th>
		</tr>
	</table>
<?php
	if($_REQUEST["accion"]=="Crear") {
		echo "<br>Creando docente en las diferentes plataformas ...<br>";
		$creaciondesdetalentohumano=true;
		include_once $_SESSION["path_live"]."consulta/creacionUsuariosDocentesEstudiatesAdmin/creacionDocentesEstudiantesAdmin.php";
		echo "<br>¡¡¡ USUARIO CREADO ¡¡¡<br>";
		echo "<br><br>Ligando docente a la carrera seleccionada ...<br>";
		$query="select codigocarrera,nombrecarrera from docentesvoto join carrera using(codigocarrera) where numerodocumento='".$_REQUEST["numerodocumento"]."'";
		$row=$db->Execute($query);
		if($row->NumRows()==0) {
			$query2="insert into docentesvoto values ('".$_REQUEST["numerodocumento"]."',".$_REQUEST["codigocarrera"].")";
			$db->Execute($query2);
			echo "<b><font color='green'>CORRECTO:</font></b> El docente se ingresó en la tabla <b>docentesvotacion</b>, para la carrera <b>".$reg["nombrecarrera"]."</b>.<br>";
		} else {
			$reg=$row->FetchRow();
			if($reg["codigocarrera"]!=$_REQUEST["codigocarrera"])
				echo "<b><font color='red'>ERROR:</font></b> El docente ya se encuentra en la tabla <b>docentesvotacion</b>, pero se encuentra ligado a la carrera <b>".$reg["nombrecarrera"]."</b>.<br>";
			else
				echo "<b><font color='orange'>ADVERTENCIA:</font></b> El docente ya se encuentra en la tabla <b>docentesvotacion</b>, ligado a la carrera <b>".$reg["nombrecarrera"]."</b>.<br>";
		}
	} // cierra accion "crear"
?>
</form>
