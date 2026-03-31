<?php
function getIdusuario($usuarionombre)
{
	global $db;
	$query_usuarios = "select idusuario
	from usuario
	where usuario = '$usuarionombre'";
	$usuarionombres = $db->Execute($query_usuarios);
	$totalRows_usuarios = $usuarionombres->RecordCount();
	$row_usuarios = $usuarionombres->FetchRow();
	return $row_usuarios['idusuario'];
}

function getHijos($idmenuopcion, $idusuario)
{
	global $db;
	$query_hijos = "select m.idmenuopcion, m.nombremenuopcion, m.linkmenuopcion, m.idpadremenuopcion, m.codigotipomenuopcion, m.nivelmenuopcion
	from menuopcion m
	where m.idpadremenuopcion = '$idmenuopcion'
	and m.codigoestadomenuopcion like '01%'
	order by m.nombremenuopcion";
	//echo "$query_hijos<br>";
	$hijos = $db->Execute($query_hijos);
	$totalRows_hijos = $hijos->RecordCount();
	if($totalRows_hijos != 0)
	{
		while($row_hijos = $hijos->FetchRow())
		{
?>
		<li><?php getCheck($row_hijos['idmenuopcion'], $idusuario); echo $row_hijos['idmenuopcion']."-".$row_hijos['nombremenuopcion']; ?>
		<ul>

<?php
			getHijos($row_hijos['idmenuopcion'], $idusuario);
?>
		</ul>
		</li>
<?php		
		}
	}
	return true;	
}

function getCheck($idmenuopcion, $idusuario)
{
	global $db;
	$check = "";
	$query_hijos = "select m.nombremenuopcion, m.linkmenuopcion, m.idpadremenuopcion, m.codigotipomenuopcion, m.nivelmenuopcion
	from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum
	where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
	and pum.idusuario = '$idusuario'
	and pum.codigoestado like '1%'
	and m.codigoestadomenuopcion like '01%'
	and dpum.codigoestado like '1%'
	and m.idmenuopcion = dpum.idmenuopcion
	and m.idmenuopcion = '$idmenuopcion'
	order by m.nombremenuopcion";
	//echo "$query_hijos<br>";
	$hijos = $db->Execute($query_hijos);
	$totalRows_hijos = $hijos->RecordCount();
	$row_hijos = $hijos->FetchRow();
	//if($idmenuopcion == 122)
	//	echo "Y que es lo que pasa $totalRows_hijos $query_hijos";
	if($totalRows_hijos != 0)
	{
		$check = "checked";
	}
?>
<input type="checkbox" <?php echo $check; ?> name="opciones[]" value="<?php echo $idmenuopcion; ?>">
<?php
}

function tienePermiso($usuarionombre, $idmenuopcion)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$query_hijos = "select m.nombremenuopcion, m.linkmenuopcion, m.idpadremenuopcion, m.codigotipomenuopcion, m.nivelmenuopcion
	from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum
	where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
	and pum.idusuario = '$idusuario'
	and pum.codigoestado like '1%'
	and m.codigoestadomenuopcion like '01%'
	and m.idmenuopcion = dpum.idmenuopcion
	and m.idmenuopcion = '$idmenuopcion'
	order by m.nombremenuopcion";
	//echo "$query_hijos<br>";
	$hijos = $db->Execute($query_hijos);
	$totalRows_hijos = $hijos->RecordCount();
	$row_hijos = $hijos->FetchRow();
	
	// Si no tiene permiso retorna falso
	if($totalRows_hijos == 0)
	{
		return false;
	}
	
	// Si tiene el permiso lo vuelve a activar
	$idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
	$query_upd = "update detallepermisomenuopcion
	set codigoestado = 100
	where idpermisomenuopcion = '$idpermisomenuopcion'
	and idmenuopcion = '$idmenuopcion'";
	//echo "$query_hijos<br>";
	$upd = $db->Execute($query_upd);	
	return true;
}

function darPermiso($usuarionombre, $idmenuopcion)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
	$query = "INSERT INTO detallepermisomenuopcion
	(iddetallepermisomenuopcion, idpermisomenuopcion, idmenuopcion, codigoestado) 
    VALUES(0, '$idpermisomenuopcion', '$idmenuopcion', 100)";
	$rta = $db->Execute($query);
	if($rta == 0)
	{
		return false;
	}
	return true;
}

function getIdpermisomenuopcion($idusuario)
{
	global $db;
	$query_usuarios = "select pum.idpermisomenuopcion
	from permisousuariomenuopcion pum
	where pum.idusuario = '$idusuario' 
	and pum.codigoestado like '1%'";
	$usuarionombres = $db->Execute($query_usuarios);
	//echo "$query_usuarios <br>";
	$totalRows_usuarios = $usuarionombres->RecordCount();
	$row_usuarios = $usuarionombres->FetchRow();
	return $row_usuarios['idpermisomenuopcion'];
}

function mostrarUsuariosEquivalentes($usuarionombre)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
	
	$query_usuarios = "select pum.idpermisomenuopcion, u.usuario, u.numerodocumento, concat(u.apellidos,' ', u.nombres) as nombre
	from permisousuariomenuopcion pum, usuario u
	where pum.idpermisomenuopcion = '$idpermisomenuopcion' 
	and pum.codigoestado like '1%'
	and u.idusuario = pum.idusuario
	order by nombre";
	$usuarionombres = $db->Execute($query_usuarios);
	//echo "$query_usuarios <br>";
	$totalRows_usuarios = $usuarionombres->RecordCount();
?>
	<table>
<tr id="trtitulogris">
<td>Usuario</td><td>Nombre</td><td>Documento</td>
</tr>
<?php
	while($row_usuarios = $usuarionombres->FetchRow())
	{
?>
<tr>
<td><?php echo $row_usuarios['usuario']; ?></td>
<td><?php echo $row_usuarios['nombre']; ?></td>
<td><?php echo $row_usuarios['numerodocumento']; ?></td>
</tr>
<?php
	} 
?>
</table>
<?php	
}

function quitarPermisos($usuarionombre)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
	$query_hijos = "update detallepermisomenuopcion
	set codigoestado = 200
	where idpermisomenuopcion = '$idpermisomenuopcion'";
	//echo "$query_hijos<br>";
	$hijos = $db->Execute($query_hijos);	
}

function mostrarUsuariosyPermisos()
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
	$query_usuarios = "select pum.idpermisomenuopcion, u.usuario, u.numerodocumento, concat(u.apellidos,' ', u.nombres) as nombre
	from permisousuariomenuopcion pum, usuario u
	where pum.codigoestado like '1%'
	and u.idusuario = pum.idusuario
	order by 1, 2";
	//group by 1 echo "$query_hijos<br>";
	$usuarionombres = $db->Execute($query_usuarios);
?>
<table>
<tr id="trtitulogris">
<td>Sel.</td><td>Idpermisomenuopcion</td><td>Usuario</td><td>Nombre</td>
</tr>
<?php			
	while($row_usuarios = $usuarionombres->FetchRow())
	{
?>
<tr>
<td><input type="radio" name="copiarpermiso" value="<?php echo $row_usuarios['idpermisomenuopcion']; ?>"></td>
<td><?php echo $row_usuarios['idpermisomenuopcion']; ?></td>
<td><?php echo $row_usuarios['usuario']; ?></td>
<td><?php echo $row_usuarios['nombre']; ?></td>
</tr>
<?php			
	}
?>
</table>
<?php
}

function crearPermisoPropio($usuarionombre)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	$query1 = "INSERT INTO permisomenuopcion(idpermisomenuopcion, fecharegistropermisomenuopcion, fechainiciopermisomenuopcion, fechavencimientopermisomenuopcion, codigoestado) 
	VALUES(0, now(), '2008-01-01', '2999-12-31', 100)";
	//echo "$query_hijos<br>";
	$rta1 = $db->Execute($query1);
	$idpermisomenuopcion = $db->Insert_ID();
	
	$query = "INSERT INTO permisousuariomenuopcion(idpermisousuariomenuopcion, idpermisomenuopcion, idusuario, codigoestado) 
    VALUES(0, '$idpermisomenuopcion', '$idusuario', '100')";
	//echo "$query_hijos<br>";
	$rta = $db->Execute($query);
	$idpermisousuariomenuopcion = $db->Insert_ID();
	return true;	
}

function copiarPermiso($usuarionombre, $idpermisomenuopcion)
{
	global $db;
	$idusuario = getIdusuario($usuarionombre);
	
	$query = "INSERT INTO permisousuariomenuopcion(idpermisousuariomenuopcion, idpermisomenuopcion, idusuario, codigoestado) 
    VALUES(0, '$idpermisomenuopcion', '$idusuario', '100')";
	//echo "$query_hijos<br>";
	$rta = $db->Execute($query);
	$idpermisousuariomenuopcion = $db->Insert_ID();
	return true;	
}
?>
