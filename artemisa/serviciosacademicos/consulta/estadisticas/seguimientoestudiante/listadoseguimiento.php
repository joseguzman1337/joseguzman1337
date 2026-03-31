<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
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
	document.location.href="<?php echo 'menuseguimiento.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'menuseguimiento.php';?>";
}

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 


function encuentra_array_materias($fechainicial,$fechafinal,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$objetobase,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query="select sce.codigosituacioncarreraestudiante Codigo_Estado, 
sce.nombresituacioncarreraestudiante Estado_Estudiante,
 c.codigocarrera, c.nombrecarrera Carrera,
tes.codigotipoestudianteseguimiento,
dtes.idtipodetalleestudianteseguimiento,

if(dtes.idtipodetalleestudianteseguimiento=1,
tes.nombretipoestudianteseguimiento
,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)) TipoObservacion,

count(distinct es.codigoestudiante) Estudiantes, count(es.idestudianteseguimiento) Seguimientos

from  subperiodo s, carrera c, carreraperiodo cp, 
situacioncarreraestudiante sce,estudianteseguimiento es
left join tipoestudianteseguimiento tes on es.codigotipoestudianteseguimiento=tes.codigotipoestudianteseguimiento
left join tipodetalleestudianteseguimiento dtes on es.idtipodetalleestudianteseguimiento=dtes.idtipodetalleestudianteseguimiento
 where 
s.idcarreraperiodo=cp.idcarreraperiodo and 
sce.codigosituacioncarreraestudiante=es.codigosituacioncarreraestudiante
and c.codigomodalidadacademica='".$codigomodalidadacademica."'
and cp.codigoperiodo='".$codigoperiodo."' 
".$carreradestino."
and s.idsubperiodo=es.idsubperiodo 
and c.codigocarrera=cp.codigocarrera
and fechadesdeestudianteseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
 group by c.codigocarrera,sce.codigosituacioncarreraestudiante,TipoObservacion
 UNION
select '999' Codigo_Estado, 'Interesado' Estado_Estudiante, c.codigocarrera,c.nombrecarrera Carrera, 
tes.codigotipoestudianteseguimiento,
dtes.idtipodetalleestudianteseguimiento,
if(tes.nombretipoestudianteseguimiento='MANEJO DEL SISTEMA',
if(epe.nombreestadopreinscripcionestudiante='Sin seguimiento','Observacion estudiante',epe.nombreestadopreinscripcionestudiante),
if(dtes.idtipodetalleestudianteseguimiento=1,
tes.nombretipoestudianteseguimiento
,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)))
TipoObservacion,

count(distinct p.idpreinscripcion) Estudiantes, count(distinct ps.idpreinscripcionseguimiento) Seguimientos

from preinscripcion p,preinscripcioncarrera pc, carrera c ,estadopreinscripcionestudiante epe,preinscripcionseguimiento ps

left join tipoestudianteseguimiento tes on ps.codigotipoestudianteseguimiento=tes.codigotipoestudianteseguimiento
left join tipodetalleestudianteseguimiento dtes on ps.idtipodetalleestudianteseguimiento=dtes.idtipodetalleestudianteseguimiento
where ps.idpreinscripcion=p.idpreinscripcion and pc.idpreinscripcion=p.idpreinscripcion 
and epe.codigoestadopreinscripcionestudiante=p.codigoestadopreinscripcionestudiante
and pc.codigocarrera=c.codigocarrera 
and fechapreinscripcionseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
and c.codigomodalidadacademica='".$codigomodalidadacademica."'
and p.codigoperiodo='".$codigoperiodo."' 
".$carreradestino."
group by c.codigocarrera,TipoObservacion
";
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$cadenagetestudiantes="codigocarrera=".$row_operacion["codigocarrera"].
							  "&Codigo_Estado=".$row_operacion["Codigo_Estado"].
							  "&codigotipoestudianteseguimiento=".$row_operacion["codigotipoestudianteseguimiento"].
							  "&idtipodetalleestudianteseguimiento=".$row_operacion["idtipodetalleestudianteseguimiento"].
							   "&link_origen=listadoseguimiento.php".
							  "&tipoobservacion=".$row_operacion["TipoObservacion"];
							  
		unset($row_operacion["codigotipoestudianteseguimiento"]);
		unset($row_operacion["idtipodetalleestudianteseguimiento"]);
		$Estudiantes+=$row_operacion["Estudiantes"];
		$Seguimientos+=$row_operacion["Seguimientos"];
		$row_operacion["Estudiantes"]="<a href='listadodetalleestudianteseguimiento.php?".$cadenagetestudiantes."'>".$row_operacion["Estudiantes"]."</a>";
		$row_operacion["Seguimientos"]="<a href='listadodetalleseguimiento.php?".$cadenagetestudiantes."'>".$row_operacion["Seguimientos"]."</a>";

		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	foreach($row_operacion as $llave=>$valor)
	$row[$llave]="";

	}

$row["TipoObservacion"]="<b>Totales</b>";
$cadenagetestudiantes="codigoperiodo=".$codigoperiodo.
					   "&codigocarrera=".$codigocarrera.
					   "&codigotipoestudianteseguimiento=todos".
					   "&Codigo_Estado=todos".
					   "&link_origen=listadoseguimiento.php".
					   "&tipoobservacion=todos";
$row["Estudiantes"]="<a href='listadodetalleestudianteseguimiento.php?".$cadenagetestudiantes."' >".$Estudiantes."</a>";
$row["Seguimientos"]="<a href='listadodetalleseguimiento.php?".$cadenagetestudiantes."' >".$Seguimientos."</a>";

$array_interno[]=$row;
	
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriaseguimiento']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriaseguimiento']=$_REQUEST['codigomateria'];


if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicaseguimiento']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicaseguimiento']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreraseguimiento']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreraseguimiento']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododseguimiento']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododseguimiento']=$_REQUEST['codigoperiodo'];

if($_REQUEST['fechainicial']!=$_SESSION['fechainicialseguimiento']&&trim($_REQUEST['fechainicial'])!='')
$_SESSION['fechainicialseguimiento']=$_REQUEST['fechainicial'];

if($_REQUEST['fechafinal']!=$_SESSION['fechafinalseguimiento']&&trim($_REQUEST['fechafinal'])!='')
$_SESSION['fechafinalseguimiento']=$_REQUEST['fechafinal'];


unset($filacarreras);
$_SESSION['idestudianteseguimientogeneral']='';

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigocarreraseguimiento'],"","",0);
echo "<table width='100%'><tr><td align='center'><h3>SEGUIMIENTOS  ".$datoscarrera["nombrecarrera"]." PERIODO ".$_SESSION['codigoperiododseguimiento']."</h3></td></tr></table>";

$cantidadestmparray=encuentra_array_materias($_SESSION['fechainicialseguimiento'],$_SESSION['fechafinalseguimiento'],$_SESSION['codigocarreraseguimiento'],$_SESSION['codigomodalidadacademicaseguimiento'],$_SESSION['codigoperiododseguimiento'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray,"ESTADISTICAS ALUMNOS X MATERIA ","listadoseguimiento.php",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadoseguimiento.php','listadodetalleestudianteseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadoseguimiento.php','listadodetalleseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=1",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');

//$motor->agregar_llaves_totales('Estudiantes',"listadoseguimiento.php","listadodetalleestudianteseguimiento.php","totales","&codigomateria=".$_SESSION['codigomateriaseguimiento']."&codigocarrera=".$_SESSION['codigocarreraseguimiento']."&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&Codigo_Estado=todos","","","Totales");
//$motor->agregar_llaves_totales('Seguimientos',"listadoseguimiento.php","listadodetalleseguimiento.php","totales","&codigomateria=".$_SESSION['codigomateriaseguimiento']."&codigocarrera=".$_SESSION['codigocarreraseguimiento']."&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&Codigo_Estado=todos","","","Totales");


$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
