<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Asigna Permisos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php 
/*$query_permisomenuopcion="SELECT idpadremenuopcion,nombremenuopcion,u.idusuario,r.usuario,pu.idpermisomenuopcion
FROM menuopcion m,permisorol p,usuariorol r,usuario u,permisousuariomenuopcion pu
WHERE m.idmenuopcion = p.idmenuopcion
AND u.usuario = r.usuario
AND pu.idusuario = u.idusuario
AND p.idrol = r.idrol
AND codigoestadomenuopcion = 01
AND u.idusuario = 2101
ORDER BY 2";*/
$query_permisomenuopcion="SELECT idpadremenuopcion,nombremenuopcion,u.idusuario,u.usuario,pu.idpermisomenuopcion
FROM menuopcion m,permisorol p,usuariorol r,usuario u,permisousuariomenuopcion pu, UsuarioTipo ut
WHERE m.idmenuopcion = p.idmenuopcion
AND ut.UsuarioId = u.idusuario
and ut.CodigoTipoUsuario = r.idusuariotipo
AND pu.idusuario = u.idusuario
AND p.idrol = r.idrol
AND codigoestadomenuopcion = 01
AND u.idusuario = 2101
ORDER BY 2";
 
$permisomenuopcion=$sala->query($query_permisomenuopcion);
$row_permisomenuopcion=$permisomenuopcion->fetchRow();

do {
  $idpermisomenuopcion = $row_permisomenuopcion['idpermisomenuopcion'];
  if ($row_permisomenuopcion['idpadremenuopcion'] <> 0)
   {
    
	$query_valida="SELECT * from detallepermisomenuopcion
	where idpermisomenuopcion = '$idpermisomenuopcion'
	and idmenuopcion = '".$row_permisomenuopcion['idpadremenuopcion']."'";
    $valida=$sala->query($query_valida);
    $row_valida=$valida->fetchRow();
	 
	 if(!$row_valida)
	 {
		$query="insert into detallepermisomenuopcion values ('0', '$idpermisomenuopcion', '".$row_permisomenuopcion['idpadremenuopcion']."', '100')";
		echo "$query<br<br><br>";
		$operacion=$sala->execute($query); 
     }
	 
    $query_papa="SELECT idpadremenuopcion from menuopcion
	where idpadremenuopcion <> '0'
	and idmenuopcion = '".$row_permisomenuopcion['idpadremenuopcion']."'";
    $papa=$sala->query($query_papa);
    $row_papa=$papa->fetchRow();
    
	if ($row_papa <> "")
	 {	  
	    $query_valida="SELECT * from detallepermisomenuopcion
		where idpermisomenuopcion = '$idpermisomenuopcion'
		and idmenuopcion = '".$row_papa['idpadremenuopcion']."'";
		$valida=$sala->query($query_valida);
		$row_valida=$valida->fetchRow();
	 
	    if(!$row_valida)
	     {
		  $query="insert into detallepermisomenuopcion values ('0', '$idpermisomenuopcion', '".$row_papa['idpadremenuopcion']."', '100')";
		  echo "$query<br<br><br>>";
		  //$operacion=$sala->execute($query);	  
	     }
	 }   
   
   }
}while($row_permisomenuopcion=$permisomenuopcion->fetchRow());
?>
</body>
</html>
