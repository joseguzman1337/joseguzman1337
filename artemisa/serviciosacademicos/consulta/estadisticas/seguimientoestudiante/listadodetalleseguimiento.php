<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
if($_REQUEST['link_origen']!=$_SESSION['link_origenseguimiento']&&trim($_REQUEST['link_origen'])!='')
$_SESSION['link_origenseguimiento']=$_REQUEST['link_origen'];
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
	document.location.href="<?php echo $_SESSION['link_origenseguimiento'];?>";

}
function regresarGET()
{
	document.location.href="<?php echo $_SESSION['link_origenseguimiento'];?>";
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
$idestudianteseguimiento=$arraysesion['idestudianteseguimientogeneral'];
$codigoestado=$arraysesion['codigoestadodetalleseguimiento'];
$fechainicial=$arraysesion['fechainicialseguimiento'];
$fechafinal=$arraysesion['fechafinalseguimiento'];
$codigocarrera=$arraysesion['codigocarreradetalleseguimiento'];
$codigomodalidadacademica=$arraysesion['codigomodalidadacademicaseguimiento'];
$codigoperiodo=$arraysesion['codigoperiododseguimiento'];
$codigotipoestudianteseguimiento=$arraysesion['codigotipoestudianteseguimientodetalle'];
$idtipodetalleestudianteseguimiento=$arraysesion['idtipodetalleestudianteseguimientodetalle'];
$tipoobservacion=$arraysesion['tipoobservaciondetalleseguimiento'];
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
$condiciontipoobservacion=" TipoObservacion='".$tipoobservacion."'";
$having="having";
}


 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";


if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";
	$havinges="";
$condicionestado="";
//echo "<h1>ENTRAR HABER SEÑOR</h1>";
if($codigoestado!="todos"){
$condicionestado="Codigo_Estado='".$codigoestado."' ";
$andps=" and ";
$having="having";
$havinges="having";
}else
$condicionestado="";




$condicionestudianteseguimiento="";
//if($codigoestado=='999')
//{
	if(trim($idestudianteseguimiento)!='')
		$condicionestudianteseguimientopreinscripcion=" and p.idpreinscripcion=".$idestudianteseguimiento;
	else
		$condicionestudianteseguimientopreinscripcion="";
//}
//else
//{
	//$condicionestudianteseguimientopreinscripcion="";
	if(trim($idestudianteseguimiento)!='')
		$condicionestudianteseguimiento=" and e.codigoestudiante=".$idestudianteseguimiento;
//}


$query="select es.idestudianteseguimiento Identificador,sce.codigosituacioncarreraestudiante Codigo_Estado,
sce.nombresituacioncarreraestudiante Estado_Estudiante, 
c.nombrecarrera Carrera,eg.numerodocumento, eg.apellidosestudiantegeneral Apellido,
eg.nombresestudiantegeneral Nombre,
if(u.usuario='wfcortes','FormularioInteresado',u.usuario) Asesora,
es.fechadesdeestudianteseguimiento Fecha_Contacto, 

if('1970-01-01' > es.fechahastaestudianteseguimiento,'&nbsp;',es.fechahastaestudianteseguimiento) Fecha_Proximo_Contacto,  
if(dtes.idtipodetalleestudianteseguimiento=1,tes.nombretipoestudianteseguimiento,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)) TipoObservacion,

es.observacionestudianteseguimiento Observacion
from  subperiodo s, carrera c, 
carreraperiodo cp, situacioncarreraestudiante sce, 
estudiante e,estudiantegeneral eg, usuario u,estudianteseguimiento es
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
and u.idusuario=es.idusuario
and c.codigocarrera=cp.codigocarrera
and fechadesdeestudianteseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
".$condicionestudianteseguimiento."
".$havinges."
".$condicionestado."
UNION
select ps.idpreinscripcionseguimiento Identificador,'999' Codigo_Estado, 'Interesado' Estado_Estudiante,c.nombrecarrera Carrera 
,p.numerodocumento, p.apellidosestudiante Apellido,p.nombresestudiante Nombre,
if(u.usuario='wfcortes','FormularioInteresado',u.usuario) Asesora,
ps.fechapreinscripcionseguimiento Fecha_Contacto, if('1970-01-01' > ps.fechahastapreinscripcionseguimiento,'&nbsp;',ps.fechahastapreinscripcionseguimiento) Fecha_Proximo_Contacto, 

if(tes.nombretipoestudianteseguimiento='MANEJO DEL SISTEMA',
if(epe.nombreestadopreinscripcionestudiante='Sin seguimiento','Observacion estudiante',epe.nombreestadopreinscripcionestudiante),
if(dtes.idtipodetalleestudianteseguimiento=1,tes.nombretipoestudianteseguimiento,CONCAT(tes.nombretipoestudianteseguimiento,' / ',dtes.nombretipodetalleestudianteseguimiento)))
TipoObservacion,

ps.observacionpreinscripcionseguimiento Observacion
from  preinscripcion p,preinscripcioncarrera pc, 
carrera c,usuario u,estadopreinscripcionestudiante epe,preinscripcionseguimiento ps
left join tipoestudianteseguimiento tes on ps.codigotipoestudianteseguimiento=tes.codigotipoestudianteseguimiento
left join tipodetalleestudianteseguimiento dtes on ps.idtipodetalleestudianteseguimiento=dtes.idtipodetalleestudianteseguimiento
where 
ps.idpreinscripcion=p.idpreinscripcion 
and pc.idpreinscripcion=p.idpreinscripcion 
and pc.codigocarrera=c.codigocarrera 
and u.idusuario=ps.idusuario
and epe.codigoestadopreinscripcionestudiante=p.codigoestadopreinscripcionestudiante
and fechapreinscripcionseguimiento between '".formato_fecha_mysql($fechainicial)." 00:00' and '".formato_fecha_mysql($fechafinal)." 23:59'
and c.codigomodalidadacademica='".$codigomodalidadacademica."'
and p.codigoperiodo='".$codigoperiodo."' 
".$condiciontipoestudianteps."
".$condicionestudianteseguimientopreinscripcion."
".$carreradestino."
".$having."
".$condicionestado."
".$andps."
".$condiciontipoobservacion."
order by Apellido,Nombre
";
//having Codigo_Estado='".$codigoestado."'
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');
if($_REQUEST['codigomateria']!=$_SESSION['codigomateriaseguimiento']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriaseguimiento']=$_REQUEST['codigomateria'];


//if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicaseguimiento']&&trim($_REQUEST['codigomodalidadacademica'])!='')
//$_SESSION['codigomodalidadacademicaseguimiento']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradetalleseguimiento']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradetalleseguimiento']=$_REQUEST['codigocarrera'];

if($_REQUEST['Codigo_Estado']!=$_SESSION['codigoestadoetalleseguimiento'])
$_SESSION['codigoestadodetalleseguimiento']=$_REQUEST['Codigo_Estado'];

if(isset($_REQUEST['idestudianteseguimiento'])&&$_REQUEST['idestudianteseguimiento']!=$_SESSION['idestudianteseguimientogeneral'])
$_SESSION['idestudianteseguimientogeneral']=$_REQUEST['idestudianteseguimiento'];


if($_REQUEST['tipoobservacion']!=$_SESSION['tipoobservaciondetalleseguimiento']&&(trim($_REQUEST['tipoobservacion'])!=''))
$_SESSION['tipoobservaciondetalleseguimiento']=$_REQUEST['tipoobservacion'];

if($_REQUEST['codigotipoestudianteseguimiento']!=$_SESSION['codigotipoestudianteseguimientodetalle']&&(trim($_REQUEST['codigotipoestudianteseguimiento'])!=''))
$_SESSION['codigotipoestudianteseguimientodetalle']=$_REQUEST['codigotipoestudianteseguimiento'];

if($_REQUEST['idtipodetalleestudianteseguimiento']!=$_SESSION['idtipodetalleestudianteseguimientodetalle']&&(trim($_REQUEST['idtipodetalleestudianteseguimiento'])!=''))
$_SESSION['idtipodetalleestudianteseguimientodetalle']=$_REQUEST['idtipodetalleestudianteseguimiento'];

/*if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododseguimiento']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododseguimiento']=$_REQUEST['codigoperiodo'];

if($_REQUEST['fechainicial']!=$_SESSION['fechainicialseguimiento']&&trim($_REQUEST['fechainicial'])!='')
$_SESSION['fechainicialseguimiento']=$_REQUEST['fechainicial'];

if($_REQUEST['fechafinal']!=$_SESSION['fechafinalseguimiento']&&trim($_REQUEST['fechafinal'])!='')
$_SESSION['fechafinalseguimiento']=$_REQUEST['fechafinal'];*/
unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigocarreraseguimiento'],"","",0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO SEGUIMIENTOS  ".$datoscarrera["nombrecarrera"]." PERIODO ".$_SESSION['codigoperiododseguimiento']."</h3></td></tr></table>";

//$_SESSION['idestudianteseguimientogeneral'],$_SESSION['codigoestadodetalleseguimiento'],$_SESSION['fechainicialseguimiento'],$_SESSION['fechafinalseguimiento'],$_SESSION['codigocarreradetalleseguimiento'],$_SESSION['codigomodalidadacademicaseguimiento'],$_SESSION['codigoperiododseguimiento'],
$cantidadestmparray=encuentra_array_materias($_SESSION,$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);

//unset($_GET['Filtrar']);

$motor = new matriz($cantidadestmparray,"","listadodetalleseguimiento.php",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadonotascorte.php','listadodetallenotascortes.php','','codigomateria',"&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadonotascorte.php','listadodetallenotascortes.php','','codigomateria',"&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=1",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');

//$motor->agregar_llaves_totales('Estudiantes',"listadonotascorte.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&codigocarrera=".$_SESSION['codigocarreranotascorte']."&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0","","","Totales");
//$motor->agregar_llaves_totales('Seguimientos',"listadonotascorte.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&codigocarrera=".$_SESSION['codigocarreranotascorte']."&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=1","","","Totales");


$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
unset($_GET);
$motor->mostrar();

?>
