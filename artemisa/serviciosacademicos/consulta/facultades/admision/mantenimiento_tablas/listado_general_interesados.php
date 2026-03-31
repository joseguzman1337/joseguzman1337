<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
function reCarga(pagina){
	document.location.href=pagina;
}
function recargar(){
pagina=document.location.href;
document.location.href= pagina;
}

</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/motorv2/motor.php');
require_once('funciones/ObtenerDatos.php');

require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');

require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$idmenuopcion=116;
if(!validaUsuarioMenuOpcion($idmenuopcion,$formulario,$objetobase))
{
	 echo "<script language='javascript'>
		 	alert('Usted no tiene permiso para entrar a esta opcion');
	   		parent.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
	 	  </script>";
}

?>
<?php
$debug=false;
if($_GET['depurar']==si)
{
	$debug=true;
	$sala->debug=true;
}
if($_GET['codigocarrera']=='todos' or $_GET['codigocarrera']=="" or $_GET['codigoperiodo']=="")
{
	echo '<script language="javascript">alert("Debe seleccionar solo una carrera y periodo codigocarrera='.$_GET['codigocarrera'].' codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'")</script>';
}
else
{
	$codigocarrera=$_GET['codigocarrera'];
	$codigoperiodo=$_GET['codigoperiodo'];
	$codigomodalidadacademica=$_GET['codigomodalidadacademica'];
}


$admisiones_consulta=new TablasAdmisiones($sala,$debug);
//$array_carreras=$admisiones_consulta->LeerCarreras($codigomodalidadacademica,$codigocarrera);
$array_subperiodo=$admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera,$codigoperiodo);
$idsubperiodo=$array_subperiodo['idsubperiodo'];
//$array_listado_asignacion_salones=$admisiones_consulta->GenerarArrayListadoAsignacionSalones($codigocarrera,$idsubperiodo);
//$array_listado_sin_asignacion=$admisiones_consulta->GenerarArrayListadoNoAsignados($codigocarrera,$codigoperiodo,$idsubperiodo);
//print_r($array_listado_sin_asignacion);
if($array_listado_asignacion_salones=$admisiones_consulta->GenerarArrayListadoInteresados($codigocarrera,$codigoperiodo,$idsubperiodo)){

	foreach ($array_listado_asignacion_salones as $llave => $valor)
	{
		if($codigomodalidadacademica<>300)
		{
			$array_colegios[]['colegio_egreso']=$admisiones_consulta->ObtenerColegio($valor['codigoestudiante']);
		}
		else
		{
			$array_colegios[]['universidad_egreso']=$admisiones_consulta->ObtenerUniversidadEgreso($valor['codigoestudiante']);
		}
	}
}
if($debug==true)
{
	$admisiones_consulta->DibujarTabla($array_colegios,"Array Colegios");
}

$array_sumado=$admisiones_consulta->SumaArreglosBidimensionalesDelMismoTamano($array_listado_asignacion_salones,$array_colegios);
$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general_interesados.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'],'si','si','menuasignacionsalones.php','listado_general_interesados.php',false,"si","../../../../");
if($_SESSION['MM_Username']=='admintecnologia')
$tabla->agregarllave_emergente('nombresituacioncarreraestudiante','listado_general_interesados.php','cambioestado.php','idinscripcion','idinscripcion','',480,160);

$tabla->agregarllave_emergente('nombre','listado_general_interesados.php','modificarestudianteadmision.php','numerodocumento','numerodocumento','idsubperiodo='.$idsubperiodo.'&codigocarrera='.$codigocarrera,670,300);

$tabla->botonRecargar=false;
$tabla->mostrar();
?>