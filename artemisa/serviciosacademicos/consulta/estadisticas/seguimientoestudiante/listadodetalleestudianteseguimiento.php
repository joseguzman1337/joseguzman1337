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
function reCarga()
{
	document.location.href="<?php echo 'listadoseguimiento.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'listadoseguimiento.php';?>";
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


function encuentra_array_materias($arraysesion,$objetobase,$imprimir=0){

$codigoestado=$arraysesion['codigoestadodetalleestudianteseguimiento'];
$fechainicial=$arraysesion['fechainicialseguimiento'];
$fechafinal=$arraysesion['fechafinalseguimiento'];
$codigocarrera=$arraysesion['codigocarreradetalleestudianteseguimiento'];
$codigomodalidadacademica=$arraysesion['codigomodalidadacademicaseguimiento'];
$codigoperiodo=$arraysesion['codigoperiododseguimiento'];
$codigotipoestudianteseguimiento=$arraysesion['codigotipoestudianteseguimientodetalle'];
$idtipodetalleestudianteseguimiento=$arraysesion['idtipodetalleestudianteseguimientodetalle'];
$tipoobservacion=$arraysesion['tipoobservaciondetalleestudianteseguimiento'];
if(trim($codigotipoestudianteseguimiento)!="todos"){
$condiciontipoestudiantees=" and es.codigotipoestudianteseguimiento=".$codigotipoestudianteseguimiento.
							" and es.idtipodetalleestudianteseguimiento=".$idtipodetalleestudianteseguimiento;
$condiciontipoestudianteps=" and ps.codigotipoestudianteseguimiento=".$codigotipoestudianteseguimiento.
							" and ps.idtipodetalleestudianteseguimiento=".$idtipodetalleestudianteseguimiento;
}
else{
$condiciontipoestudianteps="";
$condiciontipoestudiantees="";
}


if(trim($tipoobservacion)!="todos"){
$condiciontipoobservacion=" and TipoObservacion='".$tipoobservacion."'";
}
else{
$condiciontipoobservacion="";
}


if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";


if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

if($codigoestado!="todos")
$condicionestado="having Codigo_Estado='".$codigoestado."'";
else
$condicionestado="";


$query="select e.codigoestudiante idestudianteseguimiento,sce.codigosituacioncarreraestudiante Codigo_Estado,
sce.nombresituacioncarreraestudiante Estado_Estudiante, 
c.nombrecarrera Carrera,c.codigocarrera,
eg.numerodocumento, eg.apellidosestudiantegeneral Apellidos,
eg.nombresestudiantegeneral Nombres,
dtes.idtipodetalleestudianteseguimiento,
tes.codigotipoestudianteseguimiento,

if(dtes.idtipodetalleestudianteseguimiento=1,tes.nombretipoestudianteseguimiento,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)) TipoObservacion,
count(distinct es.idestudianteseguimiento) Seguimientos

from  subperiodo s, carrera c, 
carreraperiodo cp, situacioncarreraestudiante sce, 
estudiante e,estudiantegeneral eg, estudianteseguimiento es
left join tipoestudianteseguimiento tes on es.codigotipoestudianteseguimiento=tes.codigotipoestudianteseguimiento
left join tipodetalleestudianteseguimiento dtes on es.idtipodetalleestudianteseguimiento=dtes.idtipodetalleestudianteseguimiento
where 
es.codigoestudiante=e.codigoestudiante and 
e.idestudiantegeneral=eg.idestudiantegeneral and 
s.idcarreraperiodo=cp.idcarreraperiodo and 
sce.codigosituacioncarreraestudiante=es.codigosituacioncarreraestudiante
and c.codigomodalidadacademica='".$codigomodalidadacademica."'
and cp.codigoperiodo='".$codigoperiodo."' 
	".$carreradestino."
 ".$condiciontipoestudiantees."
and s.idsubperiodo=es.idsubperiodo 
and c.codigocarrera=cp.codigocarrera
and fechadesdeestudianteseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
group by e.codigoestudiante,Carrera,Codigo_Estado,TipoObservacion
".$condicionestado."
UNION
select p.idpreinscripcion idestudianteseguimiento,'999' Codigo_Estado, 'Interesado' Estado_Estudiante,c.nombrecarrera Carrera ,c.codigocarrera
,p.numerodocumento, p.apellidosestudiante Apellidos,p.nombresestudiante Nombres, 
dtes.idtipodetalleestudianteseguimiento,
tes.codigotipoestudianteseguimiento,
if(tes.nombretipoestudianteseguimiento='MANEJO DEL SISTEMA',
if(epe.nombreestadopreinscripcionestudiante='Sin seguimiento','Observacion estudiante',epe.nombreestadopreinscripcionestudiante),
if(dtes.idtipodetalleestudianteseguimiento=1,tes.nombretipoestudianteseguimiento,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)))
TipoObservacion,
count(distinct ps.idpreinscripcionseguimiento) Seguimientos
from  preinscripcion p,preinscripcioncarrera pc, 
carrera c,estadopreinscripcionestudiante epe,preinscripcionseguimiento ps
left join tipoestudianteseguimiento tes on ps.codigotipoestudianteseguimiento=tes.codigotipoestudianteseguimiento
left join tipodetalleestudianteseguimiento dtes on ps.idtipodetalleestudianteseguimiento=dtes.idtipodetalleestudianteseguimiento
where 
ps.idpreinscripcion=p.idpreinscripcion 
and pc.idpreinscripcion=p.idpreinscripcion 
and pc.codigocarrera=c.codigocarrera 
and epe.codigoestadopreinscripcionestudiante=p.codigoestadopreinscripcionestudiante
and fechapreinscripcionseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
and c.codigomodalidadacademica='".$codigomodalidadacademica."'
and p.codigoperiodo='".$codigoperiodo."' 
	".$carreradestino."
	".$condiciontipoestudianteps."
group by p.idpreinscripcion,Carrera,Codigo_Estado,TipoObservacion
".$condicionestado."
".$condiciontipoobservacion."
";
//".$condiciontipoobservacion."
//having Codigo_Estado='".$codigoestado."'
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		//$row_operacion["Seguimientos"]="<a href='listadodetalleseguimiento.php?codigocarrera=".$row_operacion["codigocarrera"]."&'>".$row_operacion["Seguimientos"]."</a>";
		
		$cadenagetestudiantes="codigocarrera=".$row_operacion["codigocarrera"].
							  "&Codigo_Estado=".$row_operacion["Codigo_Estado"].
							  "&codigotipoestudianteseguimiento=".$row_operacion["codigotipoestudianteseguimiento"].
							  "&idtipodetalleestudianteseguimiento=".$row_operacion["idtipodetalleestudianteseguimiento"].
							  "&idestudianteseguimiento=".$row_operacion["idestudianteseguimiento"].
							   "&link_origen=listadodetalleestudianteseguimiento.php".
							  "&tipoobservacion=".$row_operacion["TipoObservacion"];
		unset($row_operacion["codigotipoestudianteseguimiento"]);
		unset($row_operacion["idtipodetalleestudianteseguimiento"]);
		$Seguimientos+=$row_operacion["Seguimientos"];
		$row_operacion["Seguimientos"]="<a href='listadodetalleseguimiento.php?".$cadenagetestudiantes."'>".$row_operacion["Seguimientos"]."</a>";
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
		foreach($row_operacion as $llave=>$valor)
	$row[$llave]="";

	}
$row["TipoObservacion"]="<b>Totales</b>";
	$cadenagetestudiantes="codigoperiodo=".$codigoperiodo.
					   "&codigocarrera=".$codigocarrera.
					   "&codigotipoestudianteseguimiento=".$codigotipoestudianteseguimiento."".
					   "&Codigo_Estado=".$codigoestado."".
					   "&link_origen=listadodetalleestudianteseguimiento.php".
					   "&tipoobservacion=".$tipoobservacion."";
$row["Seguimientos"]="<a href='listadodetalleseguimiento.php?".$cadenagetestudiantes."' >".$Seguimientos."</a>";
$array_interno[]=$row;

return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriaseguimiento']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriaseguimiento']=$_REQUEST['codigomateria'];


//if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicaseguimiento']&&trim($_REQUEST['codigomodalidadacademica'])!='')
//$_SESSION['codigomodalidadacademicaseguimiento']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradetalleestudianteseguimiento']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradetalleestudianteseguimiento']=$_REQUEST['codigocarrera'];

//echo "<h1>codigocarrera=".$_REQUEST['codigocarrera']."---".."</h1>"

if($_REQUEST['Codigo_Estado']!=$_SESSION['codigoestadoetalleseguimiento']&&(trim($_REQUEST['Codigo_Estado'])!=''))
$_SESSION['codigoestadodetalleestudianteseguimiento']=$_REQUEST['Codigo_Estado'];

if($_REQUEST['codigotipoestudianteseguimiento']!=$_SESSION['codigotipoestudianteseguimientodetalle']&&(trim($_REQUEST['codigotipoestudianteseguimiento'])!=''))
$_SESSION['codigotipoestudianteseguimientodetalle']=$_REQUEST['codigotipoestudianteseguimiento'];

if($_REQUEST['idtipodetalleestudianteseguimiento']!=$_SESSION['idtipodetalleestudianteseguimientodetalle']&&(trim($_REQUEST['idtipodetalleestudianteseguimiento'])!=''))
$_SESSION['idtipodetalleestudianteseguimientodetalle']=$_REQUEST['idtipodetalleestudianteseguimiento'];

if($_REQUEST['tipoobservacion']!=$_SESSION['tipoobservaciondetalleestudianteseguimiento']&&(trim($_REQUEST['tipoobservacion'])!=''))
$_SESSION['tipoobservaciondetalleestudianteseguimiento']=$_REQUEST['tipoobservacion'];


/*if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododseguimiento']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododseguimiento']=$_REQUEST['codigoperiodo'];

if($_REQUEST['fechainicial']!=$_SESSION['fechainicialseguimiento']&&trim($_REQUEST['fechainicial'])!='')
$_SESSION['fechainicialseguimiento']=$_REQUEST['fechainicial'];

if($_REQUEST['fechafinal']!=$_SESSION['fechafinalseguimiento']&&trim($_REQUEST['fechafinal'])!='')
$_SESSION['fechafinalseguimiento']=$_REQUEST['fechafinal'];*/

echo "<pre>";
unset($_REQUEST['Codigo_Estado']);
echo "</pre>";

unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigocarreraseguimiento'],"","",0);
echo "<table width='400'><tr><td align='center'><h3>LISTADO SEGUIMIENTOS  ".$datoscarrera["nombrecarrera"]." PERIODO ".$_SESSION['codigoperiododseguimiento']."</h3></td></tr><tr><td>";
//$_SESSION['codigoestadodetalleestudianteseguimiento'],$_SESSION['fechainicialseguimiento'],$_SESSION['fechafinalseguimiento'],$_SESSION['codigocarreradetalleestudianteseguimiento'],$_SESSION['codigomodalidadacademicaseguimiento'],$_SESSION['codigoperiododseguimiento']
$cantidadestmparray=encuentra_array_materias($_SESSION,$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
//unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray,"ESTADISTICAS ALUMNOS X MATERIA ","listadodetalleestudianteseguimiento.php?codigomateria=".$_SESSION['codigomateria']."&codigocarrera=".$_SESSION['codigocarrera']."&codigocarrerad=".$_SESSION['codigocarrerad']."&codigoperiodo=".$_SESSION['codigoperiodo'],'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadonotascorte.php','listadodetalleseguimiento.php','','codigomateria',"&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadodetalleestudianteseguimiento.php','listadodetalleseguimiento.php','','codigocarrera',"&codigomateria=".$_SESSION['codigomaterianotascorte']."&columna=1",'idestudianteseguimiento','','','','onclick= "return ventanaprincipal(this)"');

//$motor->agregar_llaves_totales('Estudiantes',"listadonotascorte.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&codigocarrera=".$_SESSION['codigocarreranotascorte']."&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0","","","Totales");
//$motor->agregar_llaves_totales('Seguimientos',"listadodetalleestudianteseguimiento.php","listadodetalleseguimiento.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&Codigo_Estado=".$_SESSION['codigoestadodetalleseguimiento']."&codigocarrera=".$_SESSION['codigocarreradetalleseguimiento']."&columna=1","","","Totales");
//$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
unset($_GET);
$motor->mostrar();
echo "</td></tr></table>";
?>
