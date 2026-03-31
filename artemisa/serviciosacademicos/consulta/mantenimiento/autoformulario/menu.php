<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
unset($_SESSION['where']);
unset($_SESSION['paginar']);
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../../sala/includes/adaptador.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
$formulario = new formulario($sala,'form1','post','','true');
$array_tablas=$formulario->LeerTablasBD();

$permission = getPermissionByUser($db);

if(count($permission) == 0)
{
    ?>
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
<?php

    echo "
        <div class='alert alert-danger' role='alert'>
          Usted no tiene permiso para ver esta página
        </div>";
    exit();
}?>

<?php
if($_GET['depurar']=='si')
{
	$formulario->DibujarTabla($array_tablas,"array tablas");
}

?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<form name="form1" method="POST" action="">
<p align="left" class="Estilo3">MENU SELECCION DE TABLA</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<tr>
	<td><?php $formulario->etiqueta('tabla','tabla','requerido');?></td>
	<td><?php $formulario->combo_array('tabla','','post',$array_tablas,'Tables_in_sala','Tables_in_sala');?></td>
</tr>
<tr>
	<td><?php $formulario->etiqueta('filasporpagina',"Número de registros","");?></td>
	<td><?php $formulario->campotexto('filasporpagina','','5',"","","Número de registros por página");?></td>
</tr>
<tr>
	<td><?php $formulario->etiqueta('where',"Where","");?></td>
	<td><?php $formulario->memo('where',"",60,6,"","","Condición WHERE en SQL");?></td>
</tr>
<tr>
  <td>Editar</td>
  <td><input name="editar" type="checkbox" id="editar" value="editar"></td>
</tr>
</table>
<input name="Enviar" type="submit" id="Enviar" value="Enviar">
</form>
<?php
if(isset($_REQUEST['Enviar']))
{
	if($_REQUEST['where']<>"")
	{
		$_SESSION['where']=stripslashes($_REQUEST['where']);
	}
	if($_REQUEST['filasporpagina']<>"")
	{
		$_SESSION['filasporpagina']=$_REQUEST['filasporpagina'];
	}
	if($_POST['paginar']=='si')
	{
		$_SESSION['paginar']=='si';
	}
	$formulario->submitir();
	$validacion=$formulario->valida_formulario();
	if($validacion==true)
	{
		if(isset($_POST['editar']))
		{
			echo '<meta http-equiv="REFRESH" content="0;URL=editor.php?tabla='.$_POST['tabla'].'&link_origen=menu.php&inferior='.$_POST['inferior'].'&superior='.$_POST['superior'].'&paginar='.$_POST['paginar'].'"/>';		
		}
		else
		{
			echo '<meta http-equiv="REFRESH" content="0;URL=listado.php?tabla='.$_POST['tabla'].'&link_origen=menu.php&inferior='.$_POST['inferior'].'&superior='.$_POST['superior'].'&paginar='.$_POST['paginar'].'"/>';
		}
	}
}

function getPermissionByUser($db)
{
    $query = "
        SELECT p.id, p.idTipoPermiso, idRelacionUsuario,
                       p.idUsuario, p.editar, p.ver, p.insertar, p.eliminar,p.idComponenteModulo,mo.nombremenuopcion
                  FROM Permiso p
                      inner join usuario u on p.idUsuario = u.idusuario
                      inner join menuopcion mo on mo.idmenuopcion = p.idComponenteModulo
            INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso)
            where u.usuario = '".$_SESSION['usuario']."'
            and p.idComponenteModulo = 117;
    ";

    $data = $db->GetRow($query);
    return $data;
}
?>
