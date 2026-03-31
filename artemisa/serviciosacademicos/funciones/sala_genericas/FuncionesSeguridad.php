<?php 
function validaUsuarioMenuOpcion($idmenuopcion,$formulario,$objetobase){
	
	$usuario=$formulario->datos_usuario();
	$condicion=" and pu.idpermisomenuopcion=pm.idpermisomenuopcion 
				and dpm.idpermisomenuopcion=pm.idpermisomenuopcion".
			   " and dpm.idmenuopcion=".$idmenuopcion;
	if($datosrolusuario=$objetobase->recuperar_datos_tabla(" permisousuariomenuopcion pu, permisomenuopcion pm, detallepermisomenuopcion dpm","pu.idusuario",$usuario['idusuario'],$condicion,'',0))
	{
	return 1;
	}
	return 0;
}
function validaUsuarioMenuBoton($idmenuboton,$formulario,$objetobase){

	$usuario=$formulario->datos_usuario();
	$condicion=" and ut.UsuarioId = u.idusuario
                adn ut.CodigoTipoUsuario = ur.idusuariotipo
				and ur.idrol=p.idrol".
			   " and p.idmenuboton=".$idmenuboton;
	if($datosrolusuario=$objetobase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorolboton p, UsuarioTipos ut","u.idusuario",$usuario['idusuario'],$condicion,'',0))
	{
	return 1;
	}
	return 0;
}

?>