<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
$idmenuopcion=$_GET['idmenuopcion'];
$idusuario=$_GET['idusuario'];
$estado=$_GET['estado'];
/*echo "<pre>";
print_r($_GET);
echo "</pre>";*/
$fechahoy=date("Y-m-d H:i:s");

switch ($estado){
	case 'existe':
		$query_permisomenuopcion="
		SELECT
		pmo.idpermisomenuopcion,dpmo.idmenuopcion,dpmo.iddetallepermisomenuopcion,dpmo.codigoestado
		FROM usuario u
		INNER JOIN permisousuariomenuopcion pumo ON u.idusuario=pumo.idusuario
		INNER JOIN permisomenuopcion pmo ON pumo.idpermisomenuopcion = pmo.idpermisomenuopcion
		INNER JOIN detallepermisomenuopcion dpmo ON pmo.idpermisomenuopcion = dpmo.idpermisomenuopcion
		AND u.idusuario='$idusuario'
		AND dpmo.idmenuopcion='$idmenuopcion'
		";
		$permisomenuopcion=$sala->query($query_permisomenuopcion);
		$row_permisomenuopcion=$permisomenuopcion->fetchRow();

		$query="UPDATE detallepermisomenuopcion SET codigoestado='200' WHERE idpermisomenuopcion='".$row_permisomenuopcion['idpermisomenuopcion']."' AND idmenuopcion='".$row_permisomenuopcion['idmenuopcion']."' AND iddetallepermisomenuopcion='".$row_permisomenuopcion['iddetallepermisomenuopcion']."'";
		break;
	case 'noexiste':
		$query_permisomenuopcion="
		SELECT
		pmo.idpermisomenuopcion,dpmo.idmenuopcion,dpmo.iddetallepermisomenuopcion,dpmo.codigoestado
		FROM usuario u
		INNER JOIN permisousuariomenuopcion pumo ON u.idusuario=pumo.idusuario
		INNER JOIN permisomenuopcion pmo ON pumo.idpermisomenuopcion = pmo.idpermisomenuopcion
		INNER JOIN detallepermisomenuopcion dpmo ON pmo.idpermisomenuopcion = dpmo.idpermisomenuopcion
		AND u.idusuario='$idusuario'
		AND dpmo.idmenuopcion='$idmenuopcion'
		";
		$permisomenuopcion=$sala->query($query_permisomenuopcion);
		$row_permisomenuopcion=$permisomenuopcion->fetchRow();
		if($row_permisomenuopcion['codigoestado']==200){
			//ya existia, pero estaba deshabilitada
			$query="UPDATE detallepermisomenuopcion SET codigoestado='100' WHERE idpermisomenuopcion='".$row_permisomenuopcion['idpermisomenuopcion']."' AND idmenuopcion='".$row_permisomenuopcion['idmenuopcion']."' AND iddetallepermisomenuopcion='".$row_permisomenuopcion['iddetallepermisomenuopcion']."'";
		}
		else{
			$query_permisomenuopcion="
			SELECT
			pmo.idpermisomenuopcion
			FROM usuario u
			INNER JOIN permisousuariomenuopcion pumo ON u.idusuario=pumo.idusuario
			INNER JOIN permisomenuopcion pmo ON pumo.idpermisomenuopcion = pmo.idpermisomenuopcion
			AND u.idusuario='$idusuario'
			";
			$permisomenuopcion=$sala->query($query_permisomenuopcion);
			$row_permisomenuopcion=$permisomenuopcion->fetchRow();
			$idpermisomenuopcion=$row_permisomenuopcion['idpermisomenuopcion'];
			if(!empty($idpermisomenuopcion)){
				//no existe, toca insertar nuevo reg
				$query="insert into detallepermisomenuopcion values ('', '$idpermisomenuopcion', '$idmenuopcion', '100')";
			}
			else{
				$query_inserta="INSERT INTO permisomenuopcion VALUES('','$fechahoy','$fechahoy','2999-12-31','100')";
				$inserta=$sala->execute($query_inserta);
				$idpermisomenuopcion=$sala->Insert_ID();
				
				$query_inserta_permiso_usuario="INSERT INTO permisousuariomenuopcion VALUES('','$idpermisomenuopcion','$idusuario','100')";
				$inserta_permiso_usuario=$sala->execute($query_inserta_permiso_usuario);
				
				$query="insert into detallepermisomenuopcion values ('', '$idpermisomenuopcion', '$idmenuopcion', '100')";
			}
		}
		break;
}
//echo $query;
$operacion=$sala->query($query);
if($operacion){
	echo "OK";
}
else{
	echo "ERROR";
}

?>