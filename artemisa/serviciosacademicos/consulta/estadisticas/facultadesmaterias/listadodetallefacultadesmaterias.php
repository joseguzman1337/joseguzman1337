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
	document.location.href="<?php echo 'listadofacultadesmaterias.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'listadofacultadesmaterias.php';?>";
}

</script>
<?php
ini_set("memory_limit","200M");
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
require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($codigomateria,$codigocarrera,$codigocarrerad,$codigoperiodo,$objetobase,$imprimir=0){
 
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

if($codigomateria!="todos")
	$materiadestino="AND dpr.codigomateria='".$codigomateria."'";
else
	$materiadestino="";

if($codigocarrera!="todos")
	$carreramateria="AND m.codigocarrera='".$codigocarrera."'";
else
	$carreramateria="";


$select="select distinct  e.codigoestudiante from ordenpago o, detalleordenpago d, concepto co,estudiante e
 where o.numeroordenpago=d.numeroordenpago  and
  e.codigoestudiante=o.codigoestudiante AND
  d.codigoconcepto=co.codigoconcepto AND
  co.cuentaoperacionprincipal=151 
  AND o.codigoperiodo='".$codigoperiodo."' AND o.codigoestadoordenpago LIKE '4%'";  
 
 $condicion="  pr.codigoperiodo='".$codigoperiodo."'
		AND e.codigoestudiante=pr.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND dpr.idprematricula=pr.idprematricula
		AND m.codigomateria=dpr.codigomateria
		and eg.idestudiantegeneral=e.idestudiantegeneral
		and dpr.codigoestadodetalleprematricula like '3%'
		AND g.codigomateria=m.codigomateria 
		AND g.codigoperiodo='".$codigoperiodo."'
		AND g.codigoestadogrupo like '1%'
		and dpr.idgrupo=g.idgrupo
                and c.codigomodalidadacademica='".$_SESSION['codigomodalidadacademicafacultadesmateria']."'
		$carreradestino
		$materiadestino
$carreramateria
$materiaArreglo
		and e.codigoestudiante in (".$select.")			
		order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
                ";
$tablas="estudiante e, estudiantegeneral eg
   , carrera c,
		 prematricula pr, detalleprematricula dpr, materia m,grupo g
                 left join docente d on d.numerodocumento=g.numerodocumento
                 left join usuario ud on ud.numerodocumento=d.numerodocumento
                 and ud.codigotipousuario='500'";
 $query="select distinct e.codigoestudiante,e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
		 eg.numerodocumento,
                eg.emailestudiantegeneral Correo_Personal,
                (select distinct trim(concat(u.usuario,'@unbosque.edu.co')) from usuario u
                where eg.numerodocumento=u.numerodocumento and u.codigotipousuario='600' group by u.numerodocumento) Correo_Institucional,
                m.codigomateria numerocodigomateria,c.nombrecarrera,m.nombremateria
		,m.numerocreditos Creditos_Materia, g.idgrupo, g.nombregrupo,d.nombredocente,d.apellidodocente,
               d.emaildocente,trim(concat(ud.usuario,'@unbosque.edu.co')) emaildocenteinstitucional from $tablas where $condicion";
// left join usuario u on eg.numerodocumento=u.numerodocumento
//    and u.codigotipousuario='600'
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


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriafacultadesmateriadetalle']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriafacultadesmateriadetalle']=$_REQUEST['codigomateria'];

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
$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriafacultadesmateriadetalle'],$_SESSION['codigocarrerafacultadesmateriadetalle'],$_SESSION['codigocarreradfacultadesmateriadetalle'],$_SESSION['codigoperiododfacultadesmateriadetalle'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
unset($_GET['Filtrar']);

$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadodetallefacultadesmaterias.php",'si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../");
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
