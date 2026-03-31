<?php 
function validahorarioprematricula($objetobase,$formulario,$codigoperiodo,$codigocarrera,$imprimir){
	$usuario=$formulario->datos_usuario();
	$tablas="horarioprematricula h,usuario u, usuariorol ur, UsuarioTipo ut";
	$condicion=" and h.idrol=ur.idrol and 
                ut.CodigoTipoUsuario = ur.idusuariotipo and 
                ut.UsuarioId = u.idusuario and 
				h.codigoperiodo='".$codigoperiodo."' and
				h.codigocarrera='".$codigocarrera."' and
				h.codigoestado like '1%'";
	if($datospermiso=$objetobase->recuperar_datos_tabla($tablas,"u.idusuario",$usuario['idusuario'],$condicion,'',$imprimir)){
		if(!ereg("^1.+$",$datospermiso["codigotipopermisohorarioprematricula"])){		
			$tablas="horarioprematricula h,detallehorarioprematricula d,usuario u,usuariorol ur,UsuarioTipo ut";
			$condicion=" and h.idhorarioprematricula=d.idhorarioprematricula and
						h.idrol=ur.idrol and 
						ut.CodigoTipoUsuario = ur.idusuariotipo and 
                        ut.UsuarioId = u.idusuario and 
						h.codigoperiodo='".$codigoperiodo."' and
						h.codigocarrera='".$codigocarrera."' and
						h.codigoestado like '1%' and 
						d.codigoestado like '1%' and
						NOW() between d.fechainicialdetallehorarioprematricula and d.fechafinaldetallehorarioprematricula and
						'".date("H:i:s")."' between d.horainicialdetallehorarioprematricula and d.horafinaldetallehorarioprematricula ";
			if(!($datoshorario=$objetobase->recuperar_datos_tabla($tablas,"u.idusuario",$usuario['idusuario'],$condicion,'',$imprimir))){
					$tablas="horarioprematricula h,detallehorarioprematricula d,usuario u,usuariorol ur,UsuarioTipo ut";
					$condicion=" and h.idhorarioprematricula=d.idhorarioprematricula and
						h.idrol=ur.idrol and 
						ut.CodigoTipoUsuario = ur.idusuariotipo and 
                        ut.UsuarioId = u.idusuario and
						h.codigoperiodo='".$codigoperiodo."' and
						h.codigocarrera='".$codigocarrera."' and
						h.codigoestado like '1%' and 
						d.codigoestado like '1%'";
					$operacionhorario=$objetobase->recuperar_resultado_tabla($tablas,"u.idusuario",$usuario['idusuario'],$condicion,'',$imprimir);
					alerta_javascript("No puede ingresar en este momento a realizar su prematricula");
					while($row_operacion=$operacionhorario->fetchRow()){
						$cadenahorario.="\\n";
						$cadenahorario.=" De ";
						$cadenahorario.=$row_operacion['fechainicialdetallehorarioprematricula']." al ";
						$cadenahorario.=$row_operacion['fechafinaldetallehorarioprematricula']." a la(s)  ";
						$cadenahorario.=$row_operacion['horainicialdetallehorarioprematricula']." hasta la(s) ";
						$cadenahorario.=$row_operacion['horafinaldetallehorarioprematricula'];
					}
					alerta_javascript("Puede realizar su prematricula en el (los) siguiente(s) horario(s)".$cadenahorario);
				return 0;				
			}
			else{
				return 1;
			}
		}
		else{
			return 1;
		}
	}
	return 1;
}
?>