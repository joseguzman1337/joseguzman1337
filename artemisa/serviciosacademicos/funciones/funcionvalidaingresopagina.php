<?php
function validaringresopagina($user, $programa, $sala)
{
	echo $programa;
	
	if($user == "")
	{
		return false;
	}
	ereg("[A-z]+.php", $programa, $regs);
	$regs[0];
	mysql_select_db($database_sala, $sala);
	$query_rol = "SELECT p.idmenuopcion 
	FROM permisorol p, menuopcion m, usuario u
	WHERE p.idmenuopcion = m.idmenuopcion
	AND m.linkmenuopcion LIKE '%".$regs[0]."'
	AND u.codigorol = p.idrol
	AND u.usuario = '$user'";	
	$rol = mysql_query($query_rol, $sala) or die("$query_rol");
	$row_rol = mysql_fetch_assoc($rol);	
	$totalRows_rol = mysql_num_rows($rol);
	//echo $totalRows_rol,"aca";
	//print_r $row_rol;
	if($row_rol != "")
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>
