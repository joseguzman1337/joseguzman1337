<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");
$rutaJS="../../../../funciones/sala_genericas/ajax/jquery/";
$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
   <link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>


<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/ajax.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/context-menu.js"></script> 
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/drag-drop-folder-tree.js"></script> 

<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/drag-drop-folder-tree.css" type="text/css"></link>
<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/context-menu.css" type="text/css"></link>

<script type="text/javascript">
function save(tipovisualiza,exporta){
//alert(window.parent.frames[1].location);
window.parent.frames[1].saveMyTree_byForm(tipovisualiza,exporta);
}
function nuevo(){
//alert(window.parent.frames[2].location);
window.parent.frames[2].location.href="formularioitem.php";
//window.parent.frames[1].saveMyTree();
}
function enviarmodalidad(){
var codigocarrera=document.getElementById("codigocarrera");
var formulario=document.getElementById("form1");
//document.getElementById("tr0")
if(codigocarrera!=null)
codigocarrera.value="";
formulario.submit();
}

</script>

<title>Servicios Académicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body  bgcolor="" leftmargin="0"  marginwidth="0" marginheight="0"  topmargin="0">
<form  action="" method="post" id="form1" name="form1">
		
<table align="center" width="100%" bgcolor="#8AB200" height="40" ><TR ><TD align="center" id='tdtitulosic' valign="middle" height="23"><img src="../../imagenes/escudo.gif" height="25"></TR>
<TR bgcolor="#F8F8F8" ><TD  valign="top" >
<table  width="100%"><TR bgcolor="#F8F8F8" ><TD  valign="top" align="left" width="90%">


<?php
$usuario=$formulario->datos_usuario();

if($usuario["idusuario"]==4186||$usuario["idusuario"]==17937){

echo "<input type='button' onclick=\"save('previsualiza','');\" value='Previsualizacion'>";

}
?>

<input type='button' onclick="save('final','');" value='Final'>
<?php

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
if(!isset($_SESSION['sissic_codigomodalidadacademica'])||trim($_SESSION['sissic_codigomodalidadacademica'])=='')
$_SESSION['sissic_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];
else
	if(isset($_POST['codigomodalidadacademica'])&&$_SESSION['sissic_codigomodalidadacademica']!=$_POST['codigomodalidadacademica'])
		$_SESSION['sissic_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];


if(!isset($_SESSION['sissic_codigocarrera'])||trim($_SESSION['sissic_codigocarrera'])==''){
$_SESSION['sissic_codigocarrera']=$_POST['codigocarrera'];
if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!='')
	$_SESSION['codigofacultad']=$_POST['codigocarrera'];
echo "
<script type='text/javascript'>
window.parent.frames[1].location.href='creararbolsic.php';
window.parent.frames[2].location.href='central.php';
</script>
";
}
else	
  if(isset($_POST['codigocarrera'])&&$_SESSION['sissic_codigocarrera']!=$_POST['codigocarrera']){
	$_SESSION['sissic_codigocarrera']=$_POST['codigocarrera'];
	if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!='')
		$_SESSION['codigofacultad']=$_POST['codigocarrera'];
		//$_SESSION['codigofacultad']=$_SESSION['sissic_codigocarrera'];
echo "
<script type='text/javascript'>

window.parent.frames[1].location.href='creararbolsic.php';
window.parent.frames[2].location.href='central.php';
</script>
";
}
//'501','502',503','504','300',
$condicion=" codigomodalidadacademica in ('200','500','506')
		order by pesomodalidadacademica";
$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_SESSION['sissic_codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		
$formulario->menu_fila('codigomodalidadacademica',$_SESSION['sissic_codigomodalidadacademica'],'onchange=enviarmodalidad();');
$condicion="";
			if($usuario["idusuario"]==4186||$usuario["idusuario"]==17937||$usuario["idusuario"]==18134){
				$condicion=" codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							and c.codigocarrera not in (124,134,119,427)
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$tabla="carrera c, usuariofacultad uf, usuario u,usuariodependencia ud";
				$condicion=" ((c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."' 
					and uf.usuario=u.usuario)
					or (c.codigocarrera=ud.codigodependencia
					and u.idusuario='".$usuario["idusuario"]."' 
					and ud.usuario=u.usuario))
					and c.codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."'					
					order by nombrecarrera2
					";
				//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tabla,"c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",1);
				
				$formulario->filatmp[" "]="Seleccionar";
				$query="select c.codigocarrera,  c.nombrecarrera , replace(c.nombrecarrera,' ','') nombrecarrera2 from carrera c, usuariofacultad uf, usuario u where (c.codigocarrera=uf.codigofacultad and u.idusuario='".$usuario["idusuario"]."'  and uf.usuario=u.usuario) 
				and c.codigocarrera not in (124,134,119,427)
				and c.codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."'
				
				union 
				
				select c.codigocarrera,  c.nombrecarrera , replace(c.nombrecarrera,' ','') nombrecarrera2 from carrera c, usuariodependencia ud, usuario u where (c.codigocarrera=ud.codigodependencia and u.idusuario='".$usuario["idusuario"]."' and ud.usuario=u.usuario)
				and c.codigocarrera not in (124,134,119,427)
				and c.codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."' 
				order by nombrecarrera2
				";
				$resultado=$objetobase->conexion->query($query);
				while($rowcarreras=$resultado->fetchRow())
								{
					$formulario->filatmp[$rowcarreras["codigocarrera"]]=$rowcarreras["nombrecarrera"];
				}
				
				
			}
	$formulario->menu_fila('codigocarrera',$_SESSION['sissic_codigocarrera'],'onchange=enviar();');

?>
</TD><TD valign="top" align="right"><a href="#"  onclick="save('final','doc')">Exportar</a></TD></TR></table>

<br><br></TD></TR>

</table>
</form>
</body>
</html>