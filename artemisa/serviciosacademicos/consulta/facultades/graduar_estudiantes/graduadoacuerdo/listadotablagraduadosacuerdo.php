<?php
session_start();
ini_set('max_execution_time','6000');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
	function  ventanaprincipal(pagina)
	{
		opener.focus();
		opener.location.href=pagina.href;
		window.close();
		return false;
	}
	function reCarga()
	{
		document.location.href="<?php echo 'marcograduadosacuerdo.php';?>";	
	}
	function regresarGET()
	{
		document.location.href="<?php echo 'marcograduadosacuerdo.php';?>";
	}
</script>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/sala_genericas/funciones_javascript.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>

<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../registro_graduados/carta_egresados/funciones/validaciones.php");

//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($sala,$nombreacuerdo,$fechainicio,$fechafinal,$codigoperiodo,$columna,$objetobase,$formulario,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino="AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino="";

if($columna){
$numerocorte="and co.numerocorte='".$columna."' ";
$condicionnotaaprobada="and ROUND(d.nota,1) < m.notaminimaaprobatoria";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}

if($columna==5){
$condicionnotaaprobada="and ROUND(h.notadefinitiva,1) < m.notaminimaaprobatoria";
$numerocorte="";
}

$query="select * from acuerdograduado a where 
fechageneracionacuerdograduado between '".formato_fecha_mysql($fechainicio)."' and '".formato_fecha_mysql($fechafinal)."' 
and nombreacuerdograduado like '%".$nombreacuerdo."%'
and codigoestado like '1%'
order by fechageneracionacuerdograduado desc
";
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
$i=0;
	while ($row_operacion=$operacion->fetchRow())
	{
		$i++;
		//echo "$i) ESTUDIANTE=".$row_operacion['codigoestudiante']."<br>";
		$row_operacion["Documento"]="<a href='cartaacuerdopdf.php?codigoacuerdograduado=".$row_operacion["codigoacuerdograduado"]."' target=new>Ver Documento</a>";
		$row_operaciontmp["Habilitar_Deshabilitar"]=$formulario->cajax_chequeo("codigoacuerdograduado","\"".$row_operacion["codigoacuerdograduado"]."&habilita=si\"","\"".$row_operacion["codigoacuerdograduado"]."&habilita=no\"","habilitadeshabilitaacuerdograduado.php",'checked',"Desea deshabilitar este listado?",0);
		//$row_operacion=InsertaCeldaPosicion($row_operacion,$row_operaciontmp,1);
		 $row_operacion=InsertarColumnaFila($row_operacion,$row_operaciontmp,0);
		$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	
	
/* 	echo "<pre>";
	print_r($array_materias_pendientes_tmp);
	echo "</pre>";
 */
 return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
$codigofacultad="05";



unset($filacarreras);




if($_REQUEST['nombreacuerdo']!=$_SESSION['nombreacuerdotablagraduadosacuerdo'])
$_SESSION['nombreacuerdotablagraduadosacuerdo']=$_REQUEST['nombreacuerdo'];

//echo "<br>_SESSION[codigomateriagraduadosacuerdo]=".$_SESSION['codigomateriagraduadosacuerdo'];
if($_REQUEST['fechainicial']!=$_SESSION['fechainiciograduadosacuerdo']&&(trim($_REQUEST['fechainicial'])!=''))
$_SESSION['fechainiciograduadosacuerdo']=$_REQUEST['fechainicial'];

if($_REQUEST['fechafinal']!=$_SESSION['fechafinalgraduadosacuerdo']&&(trim($_REQUEST['fechafinal'])!=''))
$_SESSION['fechafinalgraduadosacuerdo']=$_REQUEST['fechafinal'];


//if(isset($_REQUEST['Enviar'])){
$cantidadestmparray=encuentra_array_materias($sala,$_SESSION['nombreacuerdotablagraduadosacuerdo'],$_SESSION['fechainiciograduadosacuerdo'],$_SESSION['fechafinalgraduadosacuerdo'],$_SESSION['codigoperiododgraduadosacuerdo'],$_SESSION['columnagraduadosacuerdo'],$objetobase,$formulario,0);
//$_SESSION['cantidadestmparraygraduadosacuerdo']=$cantidadestmparray;
//}
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";
 

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray,"HISTORIAL LINEA ENFASIS ","listadograduadosacuerdo.php",'si','si','listadograduadosacuerdo.php','listadogeneral.php',true,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
// echo "<pre>";
//print_r($motor->matriz_filtrada);


//echo "</pre>";
 
$motor->agregarllave_drilldown('nombreacuerdograduado','listadodetalletablagraduadosacuerdo.php','listadodetalletablagraduadosacuerdo.php','','codigoacuerdograduado',"&Enviar=1",'','','','','onclick= "return ventanaprincipal(this)"');
/*
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
*/
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();


?>
