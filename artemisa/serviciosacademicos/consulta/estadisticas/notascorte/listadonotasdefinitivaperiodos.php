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
	document.location.href="<?php echo 'menunotasdefinitivaperiodos.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menunotasdefinitivaperiodos.php';?>";
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


function encuentra_array_materias($codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$codigoperiodofinal,$objetobase,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query="select c.codigocarrera,c.nombrecarrera,m.codigomateria,m.nombremateria,g.codigoperiodo,
count(distinct e.codigoestudiante) total,

count(distinct h.codigoestudiante) definitiva,
CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') porcentaje_definitiva

 from  grupo g, materia m, corte co, estudiante e, carrera c,detallenota d
left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
co.idcorte=d.idcorte and
g.codigoperiodo between ".$codigoperiodo." and ".$codigoperiodofinal."
".$carreradestino."
".$materiadestino."
and  m.codigocarrera=c.codigocarrera 
and c.codigomodalidadacademica=".$codigomodalidadacademica."
group by g.codigoperiodo,m.codigomateria
order by c.nombrecarrera";
/*".$carreradestino."*/
/*".$materiadestino."*/		 

	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		//$array_interno[]=$row_operacion;
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["codigocarrera"]=$row_operacion["codigocarrera"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["nombrecarrera"]=$row_operacion["nombrecarrera"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["codigomateria"]=$row_operacion["codigomateria"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["nombremateria"]=$row_operacion["nombremateria"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Total_Estudiantes_".$row_operacion["codigoperiodo"]]=$row_operacion["total"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=$row_operacion["definitiva"];
		$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["%Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=$row_operacion["porcentaje_definitiva"];
		$arrayperiodos[$row_operacion["codigoperiodo"]]=$row_operacion["codigoperiodo"];
		
		$arraycolumnas["codigocarrera"]=1;
		$arraycolumnas["nombrecarrera"]=1;
		$arraycolumnas["codigomateria"]=1;
		$arraycolumnas["nombremateria"]=1;
		$arraycolumnas["Total_Estudiantes_".$row_operacion["codigoperiodo"]]=1;
		$arraycolumnas["Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=1;
		$arraycolumnas["%Perdieron_Periodo_".$row_operacion["codigoperiodo"]]=1;
		
	
		$arraylistadotmp[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["total_estudiantes"]+=$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Total_Estudiantes_".$row_operacion["codigoperiodo"]];
		$arraylistadotmp[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["total_perdieron"]+=$arraylistado[$row_operacion["codigocarrera"]][$row_operacion["codigomateria"]]["Perdieron_Periodo_".$row_operacion["codigoperiodo"]];
	 	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	if(is_array($arraylistado))
	foreach($arraylistado as $carrera => $arraymateria){
		foreach($arraylistado[$carrera] as $materia => $arrayvalores){
		 $arrayvalores["Total_Estudiantes"]=$arraylistadotmp[$carrera][$materia]["total_estudiantes"];
		 $arrayvalores["Total_Perdieron"]=$arraylistadotmp[$carrera][$materia]["total_perdieron"];
		
		 $arrayvalores["%Total_Perdieron"]=round($arraylistadotmp[$carrera][$materia]["total_perdieron"]/$arraylistadotmp[$carrera][$materia]["total_estudiantes"]*100)."%";
			foreach($arraycolumnas as $llave => $valor)
				if(!isset($arrayvalores[$llave]))
					$arrayvalores[$llave]="&nbsp";
			
			$array_lsta[]=$arrayvalores;
			
			
			
		}
	}
	$array_interno[0]=$array_lsta;
	$array_interno[1]=$arrayperiodos;
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if($_REQUEST['codigomateria']!=$_SESSION['codigomateriadefinitivaperiodo']&&trim($_REQUEST['codigomateria'])!='')
$_SESSION['codigomateriadefinitivaperiodo']=$_REQUEST['codigomateria'];


if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicadefinitivaperiodo']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicadefinitivaperiodo']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomateriadefinitivaperiodo]=".$_SESSION['codigomateriadefinitivaperiodo'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreradefinitivaperiodo']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreradefinitivaperiodo']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododdefinitivaperiodo']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododdefinitivaperiodo']=$_REQUEST['codigoperiodo'];

if($_REQUEST['codigoperiodofinal']!=$_SESSION['codigoperiodofinaldefinitivaperiodo']&&(trim($_REQUEST['codigoperiodofinal'])!=''))
$_SESSION['codigoperiodofinaldefinitivaperiodo']=$_REQUEST['codigoperiodofinal'];

if($_SESSION['codigoperiodofinaldefinitivaperiodo'] <$_SESSION['codigoperiododdefinitivaperiodo']){
alerta_javascript("Periodo final es menor al periodo inicial");
echo "<script LANGUAGE='JavaScript'>
regresarGET();
</script>
";
}


unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriadefinitivaperiodo'],$_SESSION['codigocarreradefinitivaperiodo'],$_SESSION['codigomodalidadacademicadefinitivaperiodo'],$_SESSION['codigoperiododdefinitivaperiodo'],$_SESSION['codigoperiodofinaldefinitivaperiodo'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarreradefinitivaperiodo'],"","",0);

echo "<table><tr><td><h3>HISTORICO DE NOTAS  ".$datoscarrera["nombrecarrera"]." POR PERIODOS ".$_SESSION['codigoperiododdefinitivaperiodo']." AL ".$_SESSION['codigoperiodofinaldefinitivaperiodo']."</h3></td></tr></table>";
$motor = new matriz($cantidadestmparray[0],"ESTADISTICAS ALUMNOS X MATERIA ","listadonotasdefinitivaperiodos.php?codigomateria=".$_SESSION['codigomateria']."&codigocarrera=".$_SESSION['codigocarrera']."&codigocarrerad=".$_SESSION['codigocarrerad'],'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");

//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
foreach($cantidadestmparray[1] as $codigoperiodo => $codigoperiodo ){
$motor->agregarllave_drilldown("Perdieron_Periodo_".$codigoperiodo,'centrostrabajo.php','listadodetallenotasdefinitivaperiodos.php','','codigomateria',"&periodoinicial=".$codigoperiodo."&periodofinal=".$codigoperiodo."&columna=5",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown("Total_Estudiantes_".$codigoperiodo,'centrostrabajo.php','listadodetallenotasdefinitivaperiodos.php','','codigomateria',"&periodoinicial=".$codigoperiodo."&periodofinal=".$codigoperiodo."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');




$motor->agregar_llaves_totales("Perdieron_Periodo_".$codigoperiodo,"centrostrabajo.php","listadodetallenotasdefinitivaperiodos.php","totales","&codigomateria=".$_SESSION['codigomateriadefinitivaperiodo']."&codigocarrera=".$_SESSION['codigocarreradefinitivaperiodo']."&periodoinicial=".$codigoperiodo."&periodofinal=".$codigoperiodo."&columna=5","","","Totales");
$motor->agregar_llaves_totales("Total_Estudiantes_".$codigoperiodo,"centrostrabajo.php","listadodetallenotasdefinitivaperiodos.php","totales","&codigomateria=".$_SESSION['codigomateriadefinitivaperiodo']."&codigocarrera=".$_SESSION['codigocarreradefinitivaperiodo']."&periodoinicial=".$codigoperiodo."&periodofinal=".$codigoperiodo."&columna=0","","","Totales");
}

$motor->agregarllave_drilldown("Total_Estudiantes",'centrostrabajo.php','listadodetallenotasdefinitivaperiodos.php','','codigomateria',"&periodoinicial=".$_SESSION['codigoperiododdefinitivaperiodo']."&periodofinal=".$_SESSION['codigoperiodofinaldefinitivaperiodo']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown("Total_Perdieron",'centrostrabajo.php','listadodetallenotasdefinitivaperiodos.php','','codigomateria',"&periodoinicial=".$_SESSION['codigoperiododdefinitivaperiodo']."&periodofinal=".$_SESSION['codigoperiodofinaldefinitivaperiodo']."&columna=5",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');

$motor->agregar_llaves_totales("Total_Estudiantes","centrostrabajo.php","listadodetallenotasdefinitivaperiodos.php","totales","&codigomateria=".$_SESSION['codigomateriadefinitivaperiodo']."&codigocarrera=".$_SESSION['codigocarreradefinitivaperiodo']."&periodoinicial=".$_SESSION['codigoperiododdefinitivaperiodo']."&periodofinal=".$_SESSION['codigoperiodofinaldefinitivaperiodo']."&columna=5","","","Totales");
$motor->agregar_llaves_totales("Total_Perdieron","centrostrabajo.php","listadodetallenotasdefinitivaperiodos.php","totales","&codigomateria=".$_SESSION['codigomateriadefinitivaperiodo']."&codigocarrera=".$_SESSION['codigocarreradefinitivaperiodo']."&periodoinicial=".$_SESSION['codigoperiododdefinitivaperiodo']."&periodofinal=".$_SESSION['codigoperiodofinaldefinitivaperiodo']."&columna=0","","","Totales");


$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
