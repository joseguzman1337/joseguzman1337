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
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'menudesercion.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menudesercion.php';?>";
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

function encuentra_array_materias($tipodesercion,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$objetobase,$imprimir=0){


if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($tipodesercion==1){
$carreradestinodos=$carreradestino;
$modalidadacademicados="and c.codigomodalidadacademica=".$codigomodalidadacademica;
}
else{
$carreradestinodos="";
$modalidadacademicados="";
}

$periodoanterior=encontrarPeriodoAnterior($codigoperiodo);

$query1="SELECT e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,c.nombrecarrera,e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
sce.nombresituacioncarreraestudiante Situacion_Periodo_Salida,sce2.nombresituacioncarreraestudiante Situacion_Actual
                               FROM ordenpago o, detalleordenpago d, carrera c,
                               concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                               left join historicosituacionestudiante h on
                                                    h.idhistoricosituacionestudiante =

(
select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
hh.codigoestudiante=e.codigoestudiante and
hh.codigoperiodo='".$codigoperiodo."'
group by hh.codigoestudiante
)
                             left join situacioncarreraestudiante sce on
                               h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                              left join situacioncarreraestudiante sce2 on
                              e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
							   WHERE o.numeroordenpago=d.numeroordenpago
                               AND pr.codigoperiodo='".$codigoperiodo."'
                               AND e.codigoestudiante=pr.codigoestudiante
                               AND e.codigoestudiante=o.codigoestudiante
                               AND d.codigoconcepto=co.codigoconcepto
                               AND co.cuentaoperacionprincipal=151
                               AND o.codigoperiodo='".$codigoperiodo."'
                               AND o.codigoestadoordenpago LIKE '4%'
                               and c.codigocarrera=e.codigocarrera
                               and c.codigomodalidadacademica='".$codigomodalidadacademica."'
                               and eg.idestudiantegeneral=e.idestudiantegeneral
							   and c.codigocarrera <> 13
                               and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
							   ".$carreradestino."

				and (h.idhistoricosituacionestudiante  not in (
                                               select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                                               where h.codigosituacioncarreraestudiante in (400,104,107,105,106,111,109,112,108)
                                               and   h.codigoperiodo='".$codigoperiodo."'
                               )
				or (h.idhistoricosituacionestudiante is null and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112,108))
				)
                               and e.idestudiantegeneral not in (
                                               SELECT e.idestudiantegeneral
                                               FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                                               concepto co, prematricula pr, estudiantegeneral eg
                                               WHERE o.numeroordenpago=d.numeroordenpago
                                               AND pr.codigoperiodo>'".$codigoperiodo."'
                                               AND e.codigoestudiante=pr.codigoestudiante
                                               AND e.codigoestudiante=o.codigoestudiante
                                               AND d.codigoconcepto=co.codigoconcepto
                                               AND co.cuentaoperacionprincipal=151
                                               AND o.codigoperiodo=pr.codigoperiodo
                                               AND o.codigoestadoordenpago LIKE '4%'
                                               and c.codigocarrera=e.codigocarrera
						   ".$modalidadacademicados."
                                               and eg.idestudiantegeneral=e.idestudiantegeneral
					 	   ".$carreradestinodos."
                               )
                               GROUP by e.codigoestudiante";


$query2="SELECT e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,c.nombrecarrera,e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
sce.nombresituacioncarreraestudiante Situacion_Periodo_Salida,sce2.nombresituacioncarreraestudiante Situacion_Actual
                               FROM ordenpago o, detalleordenpago d, carrera c,
                               concepto co, prematricula pr, estudiantegeneral eg, estudiante e
                               left join historicosituacionestudiante h on
                                                    h.idhistoricosituacionestudiante =

(
select max(hh.idhistoricosituacionestudiante) from historicosituacionestudiante hh where
hh.codigoestudiante=e.codigoestudiante and
hh.codigoperiodo='".$periodoanterior."'
group by hh.codigoestudiante
)
                             left join situacioncarreraestudiante sce on
                               h.codigosituacioncarreraestudiante =sce.codigosituacioncarreraestudiante
                              left join situacioncarreraestudiante sce2 on
                              e.codigosituacioncarreraestudiante =sce2.codigosituacioncarreraestudiante
							   WHERE o.numeroordenpago=d.numeroordenpago
                               AND pr.codigoperiodo='".$periodoanterior."'
                               AND e.codigoestudiante=pr.codigoestudiante
                               AND e.codigoestudiante=o.codigoestudiante
                               AND d.codigoconcepto=co.codigoconcepto
                               AND co.cuentaoperacionprincipal=151
                               AND o.codigoperiodo='".$periodoanterior."'
                               AND o.codigoestadoordenpago LIKE '4%'
                               and c.codigocarrera=e.codigocarrera
                               and c.codigomodalidadacademica='".$codigomodalidadacademica."'
                               and eg.idestudiantegeneral=e.idestudiantegeneral
							   and c.codigocarrera <> 13
                               and e.codigosituacioncarreraestudiante not in (400,104,107,105,106,111,109,112)
							   ".$carreradestino."

				and( h.idhistoricosituacionestudiante in (
                                               select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                                               where h.codigosituacioncarreraestudiante in (108)
                                               and   h.codigoperiodo='".$periodoanterior."'
	                               )
				or (h.idhistoricosituacionestudiante is null and e.codigosituacioncarreraestudiante = '108'))

                               and e.idestudiantegeneral not in (
                                               SELECT e.idestudiantegeneral
                                               FROM ordenpago o, detalleordenpago d, estudiante e, carrera c,
                                               concepto co, prematricula pr, estudiantegeneral eg
                                               WHERE o.numeroordenpago=d.numeroordenpago
                                               AND pr.codigoperiodo>'".$periodoanterior."'
                                               AND e.codigoestudiante=pr.codigoestudiante
                                               AND e.codigoestudiante=o.codigoestudiante
                                               AND d.codigoconcepto=co.codigoconcepto
                                               AND co.cuentaoperacionprincipal=151
                                               AND o.codigoperiodo=pr.codigoperiodo
                                               AND o.codigoestadoordenpago LIKE '4%'
                                               and c.codigocarrera=e.codigocarrera
						   ".$modalidadacademicados."
                                               and eg.idestudiantegeneral=e.idestudiantegeneral
					 	   ".$carreradestinodos."
                               )
                               GROUP by e.codigoestudiante
                               order by apellidosestudiantegeneral,nombresestudiantegeneral";

$query = $query1 ." UNION ". $query2;
/*
                               and h.idhistoricosituacionestudiante  not in (
                                               select h.idhistoricosituacionestudiante from historicosituacionestudiante h
                                               where h.codigosituacioncarreraestudiante in (400,104,107,105,106,111,109,112)
                                               and   h.codigoperiodo='".$codigoperiodo."'
                               )
*/
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


if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";



unset($filacarreras);
//echo "<h1>codigomodalidadacademica=".$_REQUEST['codigomodalidadacademica']."</h1>";
if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicadeserciondetalle']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicadeserciondetalle']=$_REQUEST['codigomodalidadacademica'];
//echo "<h1>_SESSION['codigomodalidadacademicadeserciondetalle']=".$_SESSION['codigomodalidadacademicadeserciondetalle']."</h1>";


if($_REQUEST['tipodesercion']!=$_SESSION['tipodeserciondetalle']&&trim($_REQUEST['tipodesercion'])!='')
$_SESSION['tipodeserciondetalle']=$_REQUEST['tipodesercion'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerafacultadesmateriadetalle']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarrerafacultadesmateriadetalle']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigocarrerad']!=$_SESSION['codigocarreradfacultadesmateriadetalle']&&(trim($_REQUEST['codigocarrerad'])!=''))
$_SESSION['codigocarreradfacultadesmateriadetalle']=$_REQUEST['codigocarrerad'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododfacultadesmateriadetalle']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododfacultadesmateriadetalle']=$_REQUEST['codigoperiodo'];



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
$cantidadestmparray=encuentra_array_materias($_SESSION['tipodeserciondetalle'],$_SESSION['codigocarrerafacultadesmateriadetalle'],$_SESSION['codigomodalidadacademicadeserciondetalle'],$_SESSION['codigoperiododfacultadesmateriadetalle'],$objetobase,0);
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
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetalledesercion.php",'si','si','menudesercion.php','menudesercion.php',false,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);

$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
