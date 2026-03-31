<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'menufacultadmaterias.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menufacultadmaterias.php';?>";
}

</script>
<?php
$rutaado=('../../../funciones/adodb/');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/motorv2/motor.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


//if($_GET['codigomodalidadacademicahpre']!=$_SESSION['codigomodalidadacademicahpresesion']&&trim($_GET['codigomodalidadacademicahpre'])!='')
//$_SESSION['codigomodalidadacademicahpresesion']=$_GET['codigomodalidadacademicahpre'];


//if($_GET['codigocarrerahpre']!=$_SESSION['codigocarrerahpresesion']&&trim($_GET['codigocarrerahpre'])!='')
//$_SESSION['codigocarrerahpresesion']=$_GET['codigocarrerahpre'];

if($_GET['codigoperiodohpre']!=$_SESSION['codigoperiodohpresesion']&&trim($_GET['codigoperiodohpre'])!='')
$_SESSION['codigoperiodohpresesion']=$_GET['codigoperiodohpre'];
/*
if($_GET['idrolhpre']!=$_SESSION['idrolhpresesion']&&trim($_GET['idrolhpre'])!='')
$_SESSION['idrolhpresesion']=$_GET['idrolhpre'];

if(trim($_SESSION['codigocarrerahpresesion'])=="todos"){
	$condicioncarrera="";
	$condicionmodalidadacademica=" and c.codigomodalidadacademica=".$_SESSION['codigomodalidadacademicahpresesion'];
}
else{
	$condicioncarrera=" and h.codigocarrera=".$_SESSION['codigocarrerahpresesion'];
	$condicionmodalidadacademica="";
}*/



$query="select h.idhorarioprematricula,h.codigoperiodo,h.codigocarrera,c.nombrecarrera,r.nombrerol,h.iphorarioprematricula,u.usuario,h.fechahorarioprematricula,
iddetallehorarioprematricula, fechadetallehorarioprematricula, fechainicialdetallehorarioprematricula, fechafinaldetallehorarioprematricula, horainicialdetallehorarioprematricula, horafinaldetallehorarioprematricula 
from  carrera c, rol r, usuario u, horarioprematricula h  
left join detallehorarioprematricula d on d.idhorarioprematricula=h.idhorarioprematricula and d.codigoestado like '1%'
where 
c.codigocarrera=h.codigocarrera and 
r.idrol=h.idrol and 
h.idusuario=u.idusuario and 
h.codigoestado like '1%' 
and h.codigoperiodo='".$_SESSION['codigoperiodohpresesion']."'
";
/*$otro="$condicioncarrera 
$condicionmodalidadacademica
and h.idrol='".$_SESSION['idrolhpresesion']."'
and h.codigoperiodo='".$_SESSION['codigoperiodohpresesion']."'
";*/		 
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_interno[]=$row_operacion;
		//print_r($row_operacion);
		//echo "<br>";
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$motor = new matriz($array_interno,"ESTADISTICAS ALUMNOS X MATERIA ","listadohorarioprematricula.php",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
$motor->agregarllave_drilldown('iddetallehorarioprematricula','listadohorarioprematricula.php','horarioprematricula.php','','iddetallehorarioprematricula',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('idhorarioprematricula','listadohorarioprematricula.php','horarioprematricula.php','','idhorarioprematricula',"",'','','','','onclick= "return ventanaprincipal(this)"');

$tabla->botonRecargar=false;
$motor->mostrar();
?>
