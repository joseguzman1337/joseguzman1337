<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();w
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

//print_r($_POST);

function encuentra_array_materias($codigomateria,$codigocarrera,$codigocarrerad,$codigoperiodo,$objetobase,$imprimir=0){
	//global $db;
	$materiaArreglo = "";
	//$objetobase->conexion->debug=true;
	if($_SESSION['traeelectivassesion'] == "si")
	{
		$query_electivas = "select distinct dg.codigomateria
		from grupomateria g, detallegrupomateria dg
		where dg.idgrupomateria=g.idgrupomateria
            and codigotipogrupomateria like '1%' and
                g.codigoperiodo = '$codigoperiodo'";
		$rta_electivas=$objetobase->conexion->query($query_electivas);
		//echo "<h1>$query_electivas</h1>$rta_electivas";
		$materiaArreglo = "";
		
		while($row_electivas=$rta_electivas->fetchRow())
		{
			//print_r($row_electivas);
			$materiaArreglo .= $row_electivas['codigomateria'].",";
			//$array_interno[]=$row_operacion;
			//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
		}
		if($materiaArreglo != "")
		{
			$materiaArreglo = ereg_replace(",$","",$materiaArreglo);
			$materiaArreglo = " and m.codigomateria in($materiaArreglo) ";
		}
		$materiaArreglo = "and m.codigomateria in($query_electivas)";
			
	}
 
if($codigocarrerad!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrerad."'";
else
$carreradestino="";


if($codigocarrera!="todos")
    $carreraorigen="AND m.codigocarrera='".$codigocarrera."'";
else
     $carreraorigen = "";

if($_SESSION['traeelectivassesion'] == "si")
	$carreraorigen="";

if($codigomateria!="todos")
	$materiadestino= "AND dpr.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

	//AND m.codigocarrera='".$codigocarrera."'
		
 $select="select distinct  e.codigoestudiante from ordenpago o, detalleordenpago d, concepto co,estudiante e
 where o.numeroordenpago=d.numeroordenpago  and
  e.codigoestudiante=o.codigoestudiante AND
  d.codigoconcepto=co.codigoconcepto AND
  co.cuentaoperacionprincipal=151 
  AND o.codigoperiodo='".$codigoperiodo."' AND o.codigoestadoordenpago LIKE '4%'";
 $condicion="pr.codigoperiodo='".$codigoperiodo."'
		AND e.codigoestudiante=pr.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND dpr.idprematricula=pr.idprematricula
		AND m.codigomateria=dpr.codigomateria
		AND g.codigomateria=m.codigomateria 
		AND g.codigoperiodo='".$codigoperiodo."'
		AND g.codigoestadogrupo like '1%'
		and dpr.idgrupo=g.idgrupo
		AND dpr.codigoestadodetalleprematricula like '3%'
		and cm.codigocarrera=m.codigocarrera
                and c.codigomodalidadacademica='".$_SESSION['codigomodalidadacademicafacultadesmateria']."'
		$carreraorigen
		$carreradestino
		$materiadestino
		$materiaArreglo
		and e.codigoestudiante in (".$select.")			
		GROUP by m.codigomateria,e.codigocarrera
		order by c.nombrecarrera,m.nombremateria";
$tablas="estudiante e, carrera c, prematricula pr, detalleprematricula dpr, materia m
    left join detalleplanestudio dp on m.codigomateria=dp.codigomateria
    and dp.codigoestadodetalleplanestudio like '1%'
    and dp.idplanestudio in (select p2.idplanestudio from planestudio p2
    where p2.idplanestudio=dp.idplanestudio
    and p2.codigoestadoplanestudio like '1%'),grupo g, carrera cm";
$query="select cm.nombrecarrera Carrera_Materia,
cm.codigocarrera, m.codigomateria,m.nombremateria Materia
		,if(dp.idplanestudio is null,'No','Si') Plan_Estudio,c.codigocentrobeneficio Centro_Beneficio_Carrera_Estudiante,c.nombrecarrera Carrera_Estudiante,c.codigocarrera codigocarrerad,count(distinct e.codigoestudiante) Total_Estudiantes,
		 count(distinct g.idgrupo) Total_Grupos, m.numerocreditos Creditos_Materia,(count(distinct e.codigoestudiante)*m.numerocreditos) Total_Creditos_Alumnos from $tablas where
 		 $condicion	";
		 
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


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriafacultadesmateria']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriafacultadesmateria']=$_REQUEST['codigomateria'];

if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicafacultadesmateria']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicafacultadesmateria']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomateriafacultadesmateria]=".$_SESSION['codigomateriafacultadesmateria'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerafacultadesmateria']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarrerafacultadesmateria']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigocarrerad']!=$_SESSION['codigocarreradfacultadesmateria']&&(trim($_REQUEST['codigocarrerad'])!=''))
$_SESSION['codigocarreradfacultadesmateria']=$_REQUEST['codigocarrerad'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododfacultadesmateria']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododfacultadesmateria']=$_REQUEST['codigoperiodo'];

if($_REQUEST['traeelectivas']!=$_SESSION['traeelectivassesion']&&(trim($_REQUEST['traeelectivas'])!=''))
$_SESSION['traeelectivassesion']=$_REQUEST['traeelectivas'];


if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";

unset($filacarreras);
/*if($_POST['codigocarrera']=="todos"){
$filacarreras=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera","codigofacultad='".$codigofacultad."'");
	$i=0;
	foreach($filacarreras as $codigocarrera => $nombrecarrera){

		if($i!=0){
		$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
		$cantidadestmparray=encuentra_array_materias($_GET['codigomateria'],$_GET['codigocarrera'],$_GET['codigocarrerad'],$_GET['codigoperiodo'],$objetobase,$imprimir=0);
		
			echo "<BR>MATERIAS<pre>";
			print_r($materiastmparray);
			echo "</pre>";

			if(is_array($materiastmparray))
				$arraymaterias=InsertaVectorFinal($arraymaterias,$materiastmparray);
			else
				$arraymaterias=$materiastmparray;

			
		}
		else{
			$arraymaterias=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,1);
			echo "<BR>MATERIAS<pre>";
			print_r($arraymaterias);
			echo "</pre>";
		}
		
		$i++;
	}

}
else{
	//$filacarreras[$_POST['codigocarrera']]="";
	$arraymaterias=encuentra_array_materias($_POST['codigocarrera'],$_POST['periodo'],$objetobase);
}*/

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriafacultadesmateria'],$_SESSION['codigocarrerafacultadesmateria'],$_SESSION['codigocarreradfacultadesmateria'],$_SESSION['codigoperiododfacultadesmateria'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"ESTADISTICAS ALUMNOS X MATERIA ","listadofacultadesmaterias.php?codigomateria=".$_SESSION['codigomateria']."&codigocarrera=".$_SESSION['codigocarrera']."&codigocarrerad=".$_SESSION['codigocarrerad']."&codigoperiodo=".$_SESSION['codigoperiodo'],'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");

//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('Total_Estudiantes','centrostrabajo.php','listadodetallefacultadesmaterias.php','','codigomateria',"&codigocarrera=".$_SESSION['codigocarrerafacultadesmateria']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateria']."",'codigocarrerad','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Total_Grupos','centrostrabajo.php','listadodetallegruposmaterias.php','','codigomateria',"&codigocarrera=".$_SESSION['codigocarrerafacultadesmateria']."&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateria']."",'codigocarrerad','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Grupos',"centrostrabajo.php","listadodetallegruposmaterias.php","totales","&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateria']."&codigocarrera=".$_SESSION['codigocarrerafacultadesmateria']."&codigocarrerad=".$_SESSION['codigocarreradfacultadesmateria']."&codigomateria=".$_SESSION['codigomateriafacultadesmateria']."","","","Totales");
$motor->agregar_llaves_totales('Total_Estudiantes',"centrostrabajo.php","listadodetallefacultadesmaterias.php","totales","&codigoperiodo=".$_SESSION['codigoperiododfacultadesmateria']."&codigocarrera=".$_SESSION['codigocarrerafacultadesmateria']."&codigocarrerad=".$_SESSION['codigocarreradfacultadesmateria']."&codigomateria=".$_SESSION['codigomateriafacultadesmateria']."","","","Totales");
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);

$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
