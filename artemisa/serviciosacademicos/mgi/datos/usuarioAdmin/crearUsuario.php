<?php
	session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Crear Usuario</title>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/functionsUtils.js?v=1"></script>
		<script type="text/javascript" language="javascript" src="js/validCampoFranz.js"></script>
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
    </head>
    <body>
		<div id="contenido" style="margin-top: 10px;">
			<table>
                <tr>
                    <td colspan='3'><h1>CREACION USUARIOS SALA</h1></td>
                </tr>
				<tr>
					<td><input type="submit" value="Crear Usuario Administrativo" name="crear" id="crear" class="paging"></td>
					<td><input type="submit" value="Crear Usuario Docente o Estudiante" name="crearDocente" id="crearDocente" class="paging"></td>
					<td><input type="submit" value="Editar Usuario" name="editar" id="editar" class="paging"></td>
				</tr>
			</table>
			<table id="crearUsuario">
					<tr><th colspan="2" align="center">Crear Usuario Administrativo</th></tr>
					<tr>
						<td>Número de Documento:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="documento" id="documento" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Nombre:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="nombre" id="nombre" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Apellido:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="apellido" id="apellido" autocomplete="off"  maxlength="25"/></td>
					</tr>
					<tr>
						<td>Usuario:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="usuario" id="usuario" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Seleccione el Rol:<span  style="color:#F71D1D">*</span></td>
						<td><div id="idSelectRol"></div><!--<input type="text" name="rol" id="rol" autocomplete="off"/>--></td>					
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="guardarNew" value="Guardar" id="guardarNew" class="paging" /></td>
					</tr>
					<div id="idDataCorrecto"></div>
			</table>
			<table id="crearUsuarioDocente">
					<tr><th colspan="2" align="center">Crear Usuario Docente o Estudiante</th></tr>
					<tr>
						<td>Número de Documento:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="documentoD" id="documentoD" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Nombre:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="nombreD" id="nombreD" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Apellido:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="apellidoD" id="apellidoD" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Usuario:<span  style="color:#F71D1D">*</span></td>
						<td><input type="text" name="usuarioD" id="usuarioD" autocomplete="off" maxlength="25"/></td>
					</tr>
					<tr>
						<td>Tipo Usuario:<span  style="color:#F71D1D">*</span></td>
						<td>
							<select  name="TipoUsuario" id="TipoUsuario">
							<option></option>
							<option value = "600">Estudiante</option>
							<option value = "500">Docente</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="guardarNewD" value="Guardar" id="guardarNewD" class="paging" /></td>
					</tr>
					<div id="idDataCorrectoD"></div>
			</table>
			<table id="editarUsuario">
				<tr><th colspan="2" align="center">Editar Usuario</th></tr>
				<tr>
					<td>Digite Usuario:<span  style="color:#F71D1D">*</span></td>
					<td><input type="text" name="documentoB" id="documentoB" autocomplete="off"/>
					<input type="hidden" id="id_usuario" name="id_usuario" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" name="buscarEdit" value="Buscar" id="buscarEdit" class="paging" /></td>
				</tr>
				<tr>	
					<td colspan="2">
						<div id="idDataUsuario"></div>
					</td>
				</tr>
				<tr id="vencimiento"><td>Fecha Vencimiento<span  style="color:#F71D1D">*</span></td>
					<td>
						<input type='text' name='fechavencimientousuario' id='fechavencimientousuario' maxlength="10" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type='submit' name='guardarEdit' id='guardarEdit' size='35' value='Guardar Cambios' class="paging"/>
					</td>
				</tr>	
				<div id="idDataCorrectoUpdate"></div>
			</table>
		</div>
  </body>
  
</html>
