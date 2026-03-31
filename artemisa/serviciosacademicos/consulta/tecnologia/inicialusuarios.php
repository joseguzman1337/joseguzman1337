<?php 
session_start();
//print_r($_SESSION);
?>
<script language="javascript">
var http;
var browser = navigator.appName;
if(browser == 'Microsoft Internet Explorer') {
	http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
	http = new XMLHttpRequest();
}

function peticionAjaxCarrera(usuario){
	http.open('post','../facultades/selfac.php?sel='+usuario);
	http.onreadystatechange=function loginRespuesta(){
		if(http.readyState==4 && http.status==200){
			hRefIzq('../facultades/facultadeslv2.php');
			hRefCentral('../facultades/central.php');
		}
	}
	http.send(null);
}

function hRefCentral(url){
	var nav = navigator.appName;
	if(nav == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return false;
}

function hRefIzq(url){
	var navi = navigator.appName;
	if(navi == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{
		parent.leftFrame.location=url;
	}
	return false;
}
</script>

<?php
require_once('../../Connections/sala2.php');
require_once("../../funciones/clases/filtro.php");
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

mysql_select_db($database_sala, $sala);

//print_r($_SESSION);
if(isset($_GET['ordenamiento']) and $_GET['ordenamiento']!="")
{
	$_SESSION['ordenamiento']=$_GET['ordenamiento'];
}
//echo($_SESSION['ordenamiento']);
if(isset($_GET['f_usuario']) and $_GET['f_usuario']!="")
{
	$_SESSION['f_usuario']=$_GET['f_usuario'];
}

if(isset($_GET['f_nombres']) and $_GET['f_nombres']!="")
{
	$_SESSION['f_nombres']=$_GET['f_nombres'];
}

if(isset($_GET['f_apellidos']) and $_GET['f_apellidos']!="")
{
	$_SESSION['f_apellidos']=$_GET['f_apellidos'];
}

if(isset($_GET['f_carrera']) and $_GET['f_carrera']!="")
{
	$_SESSION['f_carrera']=$_GET['f_carrera'];
}

/* session_unregister('MM_UserGroup');
session_unregister('codigo');
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['codigo']);
session_unregister('materias');
session_unregister('grupos');
session_unregister('facultades');
session_unregister('cortes');
*/

if(isset($_SESSION['nuevoMenu'])){
	$target="";
}
else{
	$target="_top";
}
$query_carrera = "SELECT u.usuario, u.nombres,u.apellidos, c.nombrecarrera
FROM usuario u, usuariofacultad uf, carrera c
where u.codigorol not like '1%'
and u.codigorol not like '2%'
and uf.usuario = u.usuario
and c.codigocarrera = uf.codigofacultad
";
//if(isset($_GET['Filtrar']) and $_GET['Filtrar']=='Filtrar')
{
	$mifiltro=new filtro($query_carrera);
	$mifiltro->agregarcolumna("u.usuario", $_SESSION['f_usuario'],"like");
	$mifiltro->agregarcolumna("u.nombres", $_SESSION['f_nombres'],"like");
	$mifiltro->agregarcolumna("u.apellidos", $_SESSION['f_apellidos'],"like");
	$mifiltro->agregarcolumna("c.nombrecarrera", $_SESSION['f_carrera'],"like");
	if(isset($_SESSION['ordenamiento']) and $_SESSION['ordenamiento']!="")
	{
		$mifiltro->agregarordenamiento($_SESSION['ordenamiento']);
	}
	$filtro=$mifiltro->filtrar();
	$res_carrera = mysql_db_query($database_sala, $filtro) or die("$filtro");
	//echo $filtro;
}
//else
if($_GET['f_usuario']=="" and $_GET['f_nombres']=="" and $_GET['f_apellidos']=="" and $_GET['f_carrera']=="" and !isset($_SESSION['ordenamiento']))
{
	$res_carrera = mysql_db_query($database_sala, $query_carrera) or die("$$query_carrera");
	//echo $query_carrera;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INICIAL</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
</head>
<body>
<form name="form1" method="get" action="">
<p align="center" class="Estilo3">SELECCIONE LOS PERMISOS DE USUARIO </p>
<table align="center" width="639" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td colspan="4" align="center"><input name="Filtrar" type="submit" id="Filtrar" value="Filtrar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="Restablecer" type="submit" id="Restablecer" value="Restablecer"></td>
    </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td width="174" align="center"><input name="f_usuario" type="text" id="f_usuario" value="<?php echo $_SESSION['f_usuario']?>" size="29"></td>
    <td width="144" align="center"><input name="f_nombres" type="text" id="f_nombres" value="<?php echo $_SESSION['f_nombres']?>"></td>
    <td width="144" align="center"><input name="f_apellidos" type="text" id="f_apellidos" value="<?php echo $_SESSION['f_apellidos']?>"></td>
    <td width="146" align="center"><input name="f_carrera" type="text" id="f_carrera" value="<?php echo $_SESSION['f_carrera']?>"></td>
  </tr>
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td align="center"><a href="inicialusuarios.php?ordenamiento=usuario<?php if(isset($_GET['Filtrar']) and $_GET['Filtrar']=='Filtrar'){echo "&Filtrar=Filtrar";}?>">USUARIO</a></td>
	<td align="center"><a href="inicialusuarios.php?ordenamiento=nombres<?php if(isset($_GET['Filtrar']) and $_GET['Filtrar']=='Filtrar'){echo "&Filtrar=Filtrar";}?>">NOMBRES</a></td>
	<td align="center"><a href="inicialusuarios.php?ordenamiento=apellidos<?php if(isset($_GET['Filtrar']) and $_GET['Filtrar']=='Filtrar'){echo "&Filtrar=Filtrar";}?>">APELLIDOS</a></td>
	<td align="center"><a href="inicialusuarios.php?ordenamiento=nombrecarrera<?php if(isset($_GET['Filtrar']) and $_GET['Filtrar']=='Filtrar'){echo "&Filtrar=Filtrar";}?>">CARRERA</a></td>
  </tr>
<?php while($carrera = mysql_fetch_assoc($res_carrera)){ ?>  
<tr class="Estilo1">
<?php if(isset($_SESSION['nuevoMenu'])){?>    
	<td align="center"><a href="../facultades/selfac.php?sel=<?php echo $carrera['usuario'];?>" target="<?php echo $target?>"><?php echo $carrera['usuario'];?></a></td>
    <?php }    
    else { ?>
    
    <td align="center"><a href="../logintecnologia.php?user=<?php echo $carrera['usuario'];?>" target="<?php echo $target?>" ><?php echo $carrera['usuario'];?></a></td>
    <?php }?>
<td align="center"><?php echo $carrera['nombres'];?></td>
    <td align="center"><?php echo $carrera['apellidos'];?></td>
    <td align="center"><?php echo $carrera['nombrecarrera'];?></td>
  </tr>
<?php } ?>  
</table>
</form>
</body>
</html>
<?php
if(isset($_GET['Restablecer']))
{
	unset($_SESSION['ordenamiento'],$_GET['ordenamiento']);
	unset($_SESSION['f_usuario'],$_GET['f_usuario']);
	unset($_SESSION['f_nombres'],$_GET['f_nombres']);
	unset($_SESSION['f_apellidos'],$_GET['f_apellidos']);
	unset($_SESSION['f_carrera'],$_GET['f_carrera']);
	//echo '<script language="javascript">window.location.reload("inicialusuarios.php")</script>';
	//unset($_GET['Borrar']);
}
?>
