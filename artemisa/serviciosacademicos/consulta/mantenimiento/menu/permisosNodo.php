<?php
error_reporting(2047);
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
$idmenuopcion=$_REQUEST['idmenuopcion'];
$query_roles="SELECT r.* FROM rol r";
$op_roles=$sala->query($query_roles);

$row_roles=$op_roles->fetchRow();
do{
	$array_roles[]=$row_roles;
}
while ($row_roles=$op_roles->fetchRow());
?>
<table align="center" border="1" cellpadding="1" cellspacing="1">
<tr>
	<td>Rol</td>
	<td>Permiso</td>
</tr>
<?php foreach ($array_roles as $llave_roles => $valor_roles){
	$chuliado=null;
	$query_permisorol="SELECT pr.* FROM permisorol pr WHERE pr.idmenuopcion='".$idmenuopcion."' AND pr.idrol='".$valor_roles['idrol']."' ";
	$op_permisorol=$sala->query($query_permisorol);
	$row_op_permisorol=$op_permisorol->fetchRow();
	if(count($row_op_permisorol)==2){
		$chuliado='checked';
	}
	?>
<tr>
	<td><?php echo $valor_roles['nombrerol']?></td>
	<td  align="center"><input type="checkbox" <?php echo $chuliado?> value="<?php echo $valor_roles['idrol']?>" id="<?php echo "idrol_".$valor_roles['idrol']?>" name="<?php echo "idrol_".$valor_roles['idrol']?>" onclick="asignarPermisoNodo(this,<?php echo $idmenuopcion?>)"></td>
</tr>	
<?php }?>
</table>