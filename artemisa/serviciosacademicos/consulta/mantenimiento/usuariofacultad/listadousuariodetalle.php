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

$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');



$query="select u.codigotipousuario,tu.nombretipousuario,
if(nombresituacioncarreraestudiante<>'',nombresituacioncarreraestudiante,'no') situacioncarrera,
count(distinct codigodocente) total_docente,
count(distinct eg.idestudiantegeneral) total_estudiante,
count(distinct u.idusuario) total_usuario 
  from tipousuario tu,usuario u
left join docente d on  u.numerodocumento=d.numerodocumento
left join estudiantegeneral eg on u.numerodocumento=eg.numerodocumento
left join estudiante e on e.idestudiantegeneral=eg.idestudiantegeneral
left join carrera c on e.codigocarrera=c.codigocarrera
left join situacioncarreraestudiante sc on e.codigosituacioncarreraestudiante=sc.codigosituacioncarreraestudiante
where 
tu.codigotipousuario=u.codigotipousuario 
group by u.codigotipousuario,sc.codigosituacioncarreraestudiante
order by u.codigotipousuario";
	 
	
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
unset($_GET['Regresar']);
//unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$motor = new matriz($array_interno,"ESTADISTICAS ALUMNOS X MATERIA","listadousuariodetalle.php",'si','si','listadousuariodetalle.php','listadousuariodetalle.php',true,"si","../../../");
//$motor->agregarllave_drilldown('iddetallehorarioprematricula','listadohorarioprematricula.php','horarioprematricula.php','','iddetallehorarioprematricula',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('total_estudiante',"","","totales","","","","Totales");
$motor->agregar_llaves_totales('total_docente',"","","totales","","","","Totales");
$motor->agregar_llaves_totales('total_usuario',"","","totales","","","","Totales");

$tabla->botonRecargar=false;
$motor->mostrar();
?>
