<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
require_once("../../../../Connections/sala2.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
mysql_select_db($database_sala,$sala);
error_reporting(2047);
?>

<?php
//llenaTablasPermisosNuevosMenuOpcion($sala);
llenaTablasPermisosNuevosMenuBoton($sala);
?>

<?php
function leePermisosMenuOpcion($sala){
	$query_us="select idusuario from usuario u";
	$operacion_us=mysql_query($query_us);
	$row_operacion_us=mysql_fetch_assoc($operacion_us);
	do{
		$query="select u.idusuario,u.usuario,pr.idmenuopcion from usuario u
		inner join usuariorol ur on u.usuario=ur.usuario
		inner join rol r on ur.idrol = r.idrol
		inner join permisorol pr on r.idrol=pr.idrol
		inner join menuopcion mu on pr.idmenuopcion=mu.idmenuopcion
		where u.idusuario='".$row_operacion_us['idusuario']."' and mu.codigoestadomenuopcion='01'
		";
		$operacion=mysql_query($query,$sala) or die($query_us.mysql_error());
		$numRows=mysql_numrows($operacion);
		if($numRows > 0){
			$row_operacion=mysql_fetch_assoc($operacion);
			do{
				$arrayInterno[]=$row_operacion;
			}
			while ($row_operacion=mysql_fetch_assoc($operacion));
			//DibujarTablaNormal($arrayInterno);
			$arrayPermisosMenuOpcion[$row_operacion_us['idusuario']]=$arrayInterno;
			unset($arrayInterno);
		}
	}
	while ($row_operacion_us=mysql_fetch_assoc($operacion_us));
	return $arrayPermisosMenuOpcion;
}

function llenaTablasPermisosNuevosMenuOpcion($sala){
	$menuopcion=leePermisosMenuOpcion($sala);
	/*echo "<pre>";
	print_r($menuopcion);
	echo "</pre>";*/
	foreach ($menuopcion as $llave_mu => $valor_mu){
		$idpermisomenuopcion=permisomenuopcion($sala);
		detallepermisomenuopcion($sala,$idpermisomenuopcion,$valor_mu);
		permisousuariomenuopcion($sala,$llave_mu,$idpermisomenuopcion);
	}
}

function llenaTablasPermisosNuevosMenuBoton($sala){
	$menuboton=leePermisosMenuBoton($sala);
	/*echo "<pre>";
	print_r($menuboton);
	echo "</pre>";*/
	foreach ($menuboton as $llave_mb => $valor_mb){
		$idpermisomenuboton=permisomenuboton($sala);
		detallepermisomenuboton($sala,$idpermisomenuboton,$valor_mb);
		permisousuariomenuboton($sala,$llave_mb,$idpermisomenuboton);
	}
}

function permisomenuopcion($sala){
	$query="insert into permisomenuopcion values ('','2007-05-10', '2007-05-10','2999-12-31', '100')";
	echo $query,"<br>";
	$op=mysql_query($query) or die($query.mysql_error());
	$idpermisomenuopcion=mysql_insert_id($sala);
	return $idpermisomenuopcion;
}

function detallepermisomenuopcion($sala,$idpermisomenuopcion,$array_menuopcion){
	foreach ($array_menuopcion as $llave => $valor){
		$query="insert into detallepermisomenuopcion values ('','$idpermisomenuopcion','".$valor['idmenuopcion']."','100')";
		echo $query,"<br>";
		$op=mysql_query($query) or die($query.mysql_error());
	}
}

function permisousuariomenuopcion($sala,$idusuario,$idpermisomenuopcion){
	$query="insert into permisousuariomenuopcion values ('','$idpermisomenuopcion','$idusuario','100')";
	echo $query,"<br>";
	$op=mysql_query($query) or die($query.mysql_error());
}

function leePermisosMenuBoton($sala){
	$query_us="select idusuario from usuario u";
	$operacion_us=mysql_query($query_us);
	$row_operacion_us=mysql_fetch_assoc($operacion_us);
	do{
		$query="select u.idusuario,u.usuario,prb.idmenuboton from usuario u
		inner join usuariorol ur on u.usuario=ur.usuario
		inner join rol r on ur.idrol = r.idrol
		inner join permisorolboton prb on r.idrol=prb.idrol
		inner join menuboton mb on prb.idmenuboton=mb.idmenuboton
		where u.idusuario='".$row_operacion_us['idusuario']."' and mb.codigoestadomenuboton='01'
		";
		$operacion=mysql_query($query,$sala) or die($query_us.mysql_error());
		$numRows=mysql_numrows($operacion);
		if($numRows > 0){
			$row_operacion=mysql_fetch_assoc($operacion);
			do{
				$arrayInterno[]=$row_operacion;
			}
			while ($row_operacion=mysql_fetch_assoc($operacion));
			//DibujarTablaNormal($arrayInterno);
			$arrayPermisosMenuBoton[$row_operacion_us['idusuario']]=$arrayInterno;
			unset($arrayInterno);
		}
	}
	while ($row_operacion_us=mysql_fetch_assoc($operacion_us));
	return $arrayPermisosMenuBoton;
}

function permisomenuboton($sala){
	$query="insert into permisomenuboton values ('','2007-05-10', '2007-05-10','2999-12-31', '100')";
	echo $query,"<br>";
	$op=mysql_query($query) or die($query.mysql_error());
	$idpermisomenuboton=mysql_insert_id($sala);
	return $idpermisomenuboton;
}

function detallepermisomenuboton($sala,$idpermisomenuboton,$array_menuboton){
	foreach ($array_menuboton as $llave => $valor){
		$query="insert into detallepermisomenuboton values ('','$idpermisomenuboton','".$valor['idmenuboton']."','100')";
		echo $query,"<br>";
		$op=mysql_query($query) or die($query.mysql_error());
	}
}

function permisousuariomenuboton($sala,$idusuario,$idpermisomenuboton){
	$query="insert into permisousuariomenuboton values ('','$idpermisomenuboton','$idusuario','100')";
	echo $query,"<br>";
	$op=mysql_query($query) or die($query.mysql_error());
}


function DibujarTablaNormal($matriz,$texto="")
{
	if(is_array($matriz))
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		EscribirCabecerasTablaNormal($matriz[0],$link);
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	else
	{
		echo $texto." Matriz no valida<br>";
	}
}


function EscribirCabecerasTablaNormal($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}
//insert into detallepermisomenuopcion select '','28' as idpermisomenuopcion,idmenuopcion,'100' as codigoestado from menuopcion where linkmenuopcion='' and codigoestadomenuopcion=01
?>