<?php
session_start();
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
$idmenuopcion=$_REQUEST['idmenuopcion'];

$query_menuopcion="SELECT mu.nombremenuopcion,mu.linkmenuopcion FROM menuopcion mu WHERE mu.idmenuopcion='$idmenuopcion'";
$op=$sala->query($query_menuopcion);

if(!empty($_SESSION['MM_Username'])){
	$query_usuario="SELECT u.* FROM usuario u WHERE u.usuario = '".$_SESSION['MM_Username']."'";
	$op_usuario=$sala->query($query_usuario);
	$row_op_usuario=$op_usuario->fetchRow();
}
else{
	"<h1>Se han perdido variables de sesión, no se puede continuar</h1>";
	exit();
}
$query_permisos="
	SELECT
	u.idusuario,
	u.usuario,
	u.codigotipousuario,
	tu.nombretipousuario,
	pumu.idpermisomenuopcion,
	dpmu.iddetallepermisomenuopcion,
	dpmu.idmenuopcion,
	mu.idmenuopcion as id, mu.idpadremenuopcion as parent_id, mu.nombremenuopcion as text, mu.linkmenuopcion as link, mu.framedestinomenuopcion as linkTarget
	from 
	usuario u
	inner join permisousuariomenuopcion pumu on u.idusuario=pumu.idusuario
	inner join permisomenuopcion pmu on pumu.idpermisomenuopcion=pmu.idpermisomenuopcion
	inner join detallepermisomenuopcion dpmu on pmu.idpermisomenuopcion=dpmu.idpermisomenuopcion
	inner join tipousuario tu on u.codigotipousuario=tu.codigotipousuario
	inner join menuopcion mu on dpmu.idmenuopcion=mu.idmenuopcion
	and now() between u.fechainiciousuario and u.fechavencimientousuario
	and pmu.codigoestado=100
	and dpmu.codigoestado=100
	and mu.codigoestadomenuopcion='01'
	and mu.idmenuopcion='$idmenuopcion'
	and u.idusuariopadre='".$row_op_usuario['idusuario']."'
	and u.codigotipousuario <> 500";

if($_SESSION['MM_Username']=='admintecnologia' or $row_op_usuario['codigotipousuario']==300){
	$query_permisos=$query_permisos." and u.codigotipousuario='301'";
}
//echo $query_permisos;
$op_permisos=$sala->query($query_permisos);
while ($row_permisos=$op_permisos->fetchRow()){
	$array_permisos[$row_permisos['idusuario']]=$row_permisos;
}

$query_usuario="select u.idusuario, u.usuario, tu.nombretipousuario,concat(u.apellidos,' ',u.nombres) as nombre
from usuario u inner join tipousuario tu on tu.codigotipousuario=u.codigotipousuario 
and now() between u.fechainiciousuario and u.fechavencimientousuario and u.idusuariopadre='".$row_op_usuario['idusuario']."'
and u.codigotipousuario <> 500 and u.codigotipousuario='301'
";
$op_usuario=$sala->query($query_usuario);
while ($row_op_usuario=$op_usuario->fetchRow()) {
	$array_usuarios[$row_op_usuario['idusuario']]=$row_op_usuario;
}
//DibujarTablaNormal($array_permisos);
//DibujarTablaNormal($array_usuarios);
?>
<strong>Nombre Menú:<?php echo $op->fields['nombremenuopcion']?><br>
Link Menú: <?php echo $op->fields['linkmenuopcion']?></strong>
<table align="center" border="1" cellpadding="1" cellspacing="1">
<tr>
	<td>Usuario</td>
	<td>Tipo</td>
	<td>Nombre</td>
	<td>Permiso</td>
</tr>
<?php 
foreach ($array_usuarios as $llave_u => $valor_u){
	if(in_array($valor_u['idusuario'],array_keys($array_permisos))){
		$chuliado='checked';
	}
	else{
		$chuliado=null;
	}
	?>
<tr>
	<td><?php echo $valor_u['usuario']?></td>
	<td><?php echo $valor_u['nombretipousuario']?></td>
	<td><?php echo $valor_u['nombre']?></td>
	<td  align="center"><input type="checkbox" <?php echo $chuliado?> value="<?php echo $valor_u['idusuario']?>" id="<?php echo "idusuario_".$valor_u['idusuario']?>" name="<?php echo "idusuario_".$valor_u['idusuario']?>" onclick="asignarPermisoNodo(this,<?php echo $idmenuopcion?>)"></td>
</tr>
<?php }?>	
</tr>	
</table>
<?php
function DibujarTablaNormal($matriz,$texto="")
{
	if(is_array($matriz))
	{
		echo "<table border=1 cellpadding='1' cellspacing='1' align=center>\n";
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
?>