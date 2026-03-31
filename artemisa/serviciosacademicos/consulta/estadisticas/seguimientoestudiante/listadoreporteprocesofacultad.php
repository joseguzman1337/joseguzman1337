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
	document.location.href="<?php echo 'menureporteprocesofacultad.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menureporteprocesofacultad.php';?>";
}

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../seguridadsocial/funciones/FuncionesAportes.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../matriculas/funciones/obtener_datos.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");



function arreglo_registro_proceso($sala,$columnas){
$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo_reporte']);
$datos_matriculas->codigoperiodo=$_SESSION['codigoperiodoreporteprocesofacultad'];

if($_SESSION['codigocarrerareporteprocesofacultad']!="todos")
$carreradestino="and c.codigocarrera='".$_SESSION['codigocarrerareporteprocesofacultad']."'";
else
$carreradestino="";


/*select c.codigocarrera,c.nombrecarrera,count(rf2.codigoestudiante) InscritosProceso ,
count(rf1.codigoestudiante) MatriculadosProceso from  carrera c 
left join estudiante e on c.codigocarrera=e.codigocarrera 
left join registroprocesofacultad rf1 on
e.codigoestudiante=rf1.codigoestudiante and
rf1.codigoestado like '1%' and
rf1.codigoperiodo=".$_SESSION['codigoperiodoreporteprocesofacultad']." and
rf1.codigotiporegistroprocesofacultad like '2%'
left join registroprocesofacultad rf2 on
e.codigoestudiante=rf2.codigoestudiante and
rf2.codigoestado like '1%' and
rf2.codigoperiodo=".$_SESSION['codigoperiodoreporteprocesofacultad']." and
rf2.codigotiporegistroprocesofacultad like '1%'
where 
now() between fechainiciocarrera and fechavencimientocarrera
and c.codigomodalidadacademica='".$_SESSION['codigomodalidadreporteprocesofacultad']."'
$carreradestino
group by c.codigocarrera
order by nombrecarrera*/



$query="
select rf1.codigoestudiante estudiantematricula ,rf2.codigoestudiante estudianteinscripcion,c.codigocarrera,c.nombrecarrera  from  carrera c 
left join estudiante e on c.codigocarrera=e.codigocarrera 
left join registroprocesofacultad rf1 on
e.codigoestudiante=rf1.codigoestudiante and
rf1.codigoestado like '1%' and
rf1.codigoperiodo=".$_SESSION['codigoperiodoreporteprocesofacultad']." and
rf1.codigotiporegistroprocesofacultad like '2%'
left join registroprocesofacultad rf2 on
e.codigoestudiante=rf2.codigoestudiante and
rf2.codigoestado like '1%' and
rf2.codigoperiodo=".$_SESSION['codigoperiodoreporteprocesofacultad']." and
rf2.codigotiporegistroprocesofacultad like '1%'
where 
now() between fechainiciocarrera and fechavencimientocarrera
and c.codigomodalidadacademica='".$_SESSION['codigomodalidadreporteprocesofacultad']."'
$carreradestino
group by rf2.codigoestudiante,rf1.codigoestudiante,c.codigocarrera 
order by nombrecarrera
";
//en.fechainicioestudiantenovedadarp >= '$inicio_mes' 

$operacion=$sala->query($query);
//$row_operacion=$operacion->fetchRow();
$tmpcodigocarrera="";
while ($row_operacion=$operacion->fetchRow()){
	//if(validar_diferencia_fechas(formato_fecha_defecto($row_operacion['Fecha_Inicio']),formato_fecha_defecto($inicio_mes)))
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	$arrayprogramas[$row_operacion["codigocarrera"]]=$row_operacion["nombrecarrera"];
	
	if($tmpcodigocarrera!=$row_operacion["codigocarrera"]){
	$i=0;
	$tmpcodigocarrera=$row_operacion["codigocarrera"];
	}
	if(isset($row_operacion["estudianteinscripcion"])&&($row_operacion["estudianteinscripcion"]!='')){
		$arrayinscritosprograma[$row_operacion["codigocarrera"]][$i]=$row_operacion["estudianteinscripcion"];
	}
	if(isset($row_operacion["estudiantematricula"])&&($row_operacion["estudiantematricula"]!='')){
		$arraymatdosprograma[$row_operacion["codigocarrera"]][$i]=$row_operacion["estudiantematricula"];
	}

$i++;
}
$j=0;
foreach($arrayprogramas as $carrera => $nombrecarrera){
/*ARRAY PARA INSCRITOS */
	$arrayinscritosest=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodoreporteprocesofacultad'],$carrera,153,'arreglo');
	$i=0;
	if(is_array($arrayinscritosest))
	foreach($arrayinscritosest as $llave => $valor){
		
		$arrayinscritosest[$llave]["codigoperiodo"]=NULL;
		$tmpcodigoestudiante=$arrayinscritosest[$llave]["codigoestudiante"];
		$arrayinscritosest[$llave]["codigoestudiante"]=NULL;
		$arrayinscritosest[$llave]=$tmpcodigoestudiante;


		$i++;
	}
	else{
	$arrayinscritosest=array();
	}
	if(count($arrayinscritosest)==0)
	$arrayinscritosest=array();
	if(count($arrayinscritosprograma[$carrera])==0)
	$arrayinscritosprograma[$carrera]=array();

		$arraintersectinscritos=@array_intersect($arrayinscritosest,$arrayinscritosprograma[$carrera]);
		if(count($arraintersectinscritos)==0)
		$arraintersectinscritos=array();
		$arraydiferenciasregistradas=@array_diff($arrayinscritosprograma[$carrera],$arraintersectinscritos);
		$arraydiferenciasradicadas=@array_diff($arrayinscritosest,$arraintersectinscritos);
		
/*ARRAY PARA MATRICULADOS*/
	$arraymatriculados=$datos_matriculas->obtener_total_matriculados($carrera,'arreglo');
	$i=0;
	if(is_array($arraymatriculados))
	foreach($arraymatriculados as $llave => $valor){
		
		$arraymatriculados[$llave]["codigoperiodo"]=NULL;
		$tmpcodigoestudiante=$arraymatriculados[$llave]["codigoestudiante"];
		$arraymatriculados[$llave]["codigoestudiante"]=NULL;
		$arraymatriculados[$llave]=$tmpcodigoestudiante;
		
		$i++;
	}
	else{
	$arraymatriculados=array();
	}
/*echo "MATRICULADOS = $carrera<pre>";
print_r($arraymatriculados);
echo "</pre>";*/
	if(count($arraymatriculados)==0)
	$arraymatriculados=array();
	if(count($arraymatdosprograma[$carrera])==0)
	$arraymatdosprograma[$carrera]=array();

		$arraintersectmatdos=@array_intersect($arraymatriculados,$arraymatdosprograma[$carrera]);
		if(count($arraintersectmatdos)==0)
		$arraintersectmatdos=array();
		$arraydiferenciasregistradasmat=@array_diff($arraymatdosprograma[$carrera],$arraintersectmatdos);
		$arraydiferenciasradicadasmat=@array_diff($arraymatriculados,$arraintersectmatdos);



/*if(count($arraintersectinscritos)>0){
echo "INSCRITOS RADICADOS CARRERA = $carrera<pre>";
print_r($arrayinscritosprograma[$carrera]);
echo "</pre>";

echo "INSCRITOS REGISTRADOS  CARRERA = $carrera PERIODO = ".$_SESSION['codigoperiodoreporteprocesofacultad']." <pre>";
print_r($arrayinscritosest);
echo "</pre>";

echo "REALES<pre>";
print_r($arraintersectinscritos);
echo "</pre>";	

$matriculadosuevos
echo "DIFERENCIAS REGISTRADAS<pre>";
print_r($arraydiferenciasregistradas);
echo "</pre>";	

echo "DIFERENCIAS RADICADAS<pre>";
print_r($arraydiferenciasradicadas);
echo "</pre>";	


}*/
//array_flip()
//$arraytotalinscritos=array_merge_recursive($arrayinscritosprograma[$carrera],$arrayinscritosest);
unset($arraytotalinscritos);
unset($arraytotalmatriculados);

$arraytotalinscritos=UnionArray($arrayinscritosprograma[$carrera],$arrayinscritosest);
$arraytotalmatriculados=UnionArray($arraymatdosprograma[$carrera],$arraymatriculados);
//$arraytotalinscritos=array_flip($arraytotalinscritos);
//$arraytotalmatriculados=array_flip($arraytotalmatriculados);

/***MATRICULADOS NUEVOS***/
$matriculadosnuevos=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($carrera,'arreglo');
	$i=0;
	if(is_array($matriculadosnuevos))
	foreach($matriculadosnuevos as $llave => $valor){
		
		$matriculadosnuevos[$llave]["codigoperiodo"]=NULL;
		$tmpcodigoestudiante=$matriculadosnuevos[$llave]["codigoestudiante"];
		$matriculadosnuevos[$llave]["codigoestudiante"]=NULL;
		$matriculadosnuevos[$llave]=$tmpcodigoestudiante;
		
		$i++;
	}
	else{
	$arraymatriculados=array();
	}



$matriculadosnuevosradicados=@array_intersect($matriculadosnuevos,$arraymatdosprograma[$carrera]);
$totalmatriculadosnuevos=@UnionArray($matriculadosnuevosradicados,$matriculadosnuevos);
$matriculadosnuevosfinal=@array_intersect($matriculadosnuevosradicados,$matriculadosnuevos);

$diferenciasregistradasmatnu=@array_diff($totalmatriculadosnuevos,$matriculadosnuevos);
$diferenciasradicadasmatnu=@array_diff($totalmatriculadosnuevos,$matriculadosnuevosradicados);

/***MATRICULADOS ANTIGUOS***/
$matriculadosantiguos=@array_diff($arraymatriculados,$matriculadosnuevos);
$matriculadosantiguosradicados=@array_intersect($matriculadosantiguos,$arraymatdosprograma[$carrera]);
$totalmatriculadosantiguos=@UnionArray($matriculadosantiguosradicados,$matriculadosantiguos);
$diferenciasregistradasmatant=@array_diff($totalmatriculadosantiguos,$matriculadosantiguos);
$diferenciasradicadasmatant=@array_diff($totalmatriculadosantiguos,$matriculadosantiguosradicados);
$matriculadosantiguosfinal=@array_intersect($matriculadosantiguosradicados,$matriculadosantiguos);
/*
echo "matriculadosnuevos<pre>";
print_r($matriculadosnuevos);
echo "</pre>";
echo "arraymatdosprograma[carrera]<pre>";
print_r($arraymatdosprograma[$carrera]);
echo "</pre>";
echo "arraymatriculados<pre>";
print_r($arraymatriculados);
echo "</pre>";
echo "arraytotalmatriculados<pre>";
print_r($arraytotalmatriculados);
echo "</pre>";
echo "matriculadosantiguos<pre>";
print_r($matriculadosantiguos);
echo "</pre>";
*/
/*
echo "arrayinscritosprograma<pre>";
print_r(array_flip($arrayinscritosprograma[$carrera]));
echo "</pre>";
echo "arrayinscritosest<pre>";
print_r(array_flip($arrayinscritosest));
echo "</pre>";
echo "arraytotalinscritos<pre>";
print_r($arraytotalinscritos);
echo "</pre>";
*/
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['CARRERA']=$nombrecarrera;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['INS_RAD']=$arrayinscritosprograma[$carrera];
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['INS_REG']=$arrayinscritosest;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['TOTAL_INS']=$arraytotalinscritos;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_RAD_INS']=$arraydiferenciasradicadas;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_REG_INS']=$arraydiferenciasregistradas;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['INSCRITOS']=$arraintersectinscritos;


$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_NU_RAD']=$matriculadosnuevosradicados;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_NU_REG']=$matriculadosnuevos;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['TOTAL_MAT_NU']=$totalmatriculadosnuevos;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_MAT_NU_REG']=$diferenciasregistradasmatnu;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_MAT_NU_RAD']=$diferenciasradicadasmatnu;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_NUEVO']=$matriculadosnuevosfinal;

$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_ANT_RAD']=$matriculadosantiguosradicados;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_ANT_REG']=$matriculadosantiguos;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['TOTAL_MAT_ANT']=$totalmatriculadosantiguos;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_MAT_ANT_REG']=$diferenciasregistradasmatant;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_MAT_ANT_RAD']=$diferenciasradicadasmatant;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_ANTIGUO']=$matriculadosantiguosfinal;

$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_RAD']=$arraymatdosprograma[$carrera];
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MAT_REG']=$arraymatriculados;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['TOTAL_MAT']=$arraytotalmatriculados;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_RAD_MAT']=$arraydiferenciasradicadasmat;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['FAL_REG_MAT']=$arraydiferenciasregistradasmat;
$_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera]['MATRICULADOS']=$arraintersectmatdos;

$array_interno[$j]["codigocarrera"]=$carrera;

$array_interno[$j]["CARRERA"]=$nombrecarrera;

if($columnas["0"]!='todos'){
	for($h=0;$h<count($columnas);$h++){
		$array_interno[$j][$columnas[$h]]=count($_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera][$columnas[$h]]);
	}
}
else{
unset($_SESSION['columnasreporteprocesofacultad']);
	foreach ($_SESSION['ARRAYREPORTEPROCESOFACULTAD'][$carrera] as $llave=>$valor){
		if($llave!='CARRERA'){
		$array_interno[$j][$llave]=count($valor);
		//$_SESSION['columnasreporteprocesofacultad'][]=$llave;
		}
	}
}




$j++;
	//$arraintersectmatdos=array_intersect($arraymatriculados,$arraymatdosprograma[$carrera]);
	//$arraymatdosprograma[$carrera]
}

/*
	$row_operacion["InscritosEstadistica"]=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodoreporteprocesofacultad'],$row_operacion['codigocarrera'],153,'conteo');
	$row_operacion["MatriculadosEstadistica"]=$datos_matriculas->obtener_total_matriculados($row_operacion['codigocarrera'],'conteo');
	$row_operacion["DiferenciaInscritos"]=abs($row_operacion["InscritosProceso"]-$row_operacion["InscritosEstadistica"]);
	$row_operacion["DiferenciaMatriculados"]=abs($row_operacion["MatriculadosProceso"]-$row_operacion["MatriculadosEstadistica"]);
	$array_interno[]=$row_operacion;*/

//exit();
return $array_interno;
}
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerareporteprocesofacultad']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarrerareporteprocesofacultad']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodoreporteprocesofacultad']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiodoreporteprocesofacultad']=$_REQUEST['codigoperiodo'];


if($_REQUEST['columnas']!=$_SESSION['columnasreporteprocesofacultad']&&(trim($_REQUEST['columnas'])!=''))
$_SESSION['columnasreporteprocesofacultad']=$_REQUEST['columnas'];

//echo "MODALIDAD ACADEMICA=".$_REQUEST['codigomodalidadacademica'];
if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadreporteprocesofacultad']&&(trim($_REQUEST['codigomodalidadacademica'])!=''))
$_SESSION['codigomodalidadreporteprocesofacultad']=$_REQUEST['codigomodalidadacademica'];

$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['codigocarrerareporteprocesofacultad'],"","",0);
//$datostipoproceso=$objetobase->recuperar_datos_tabla("tiporegistroprocesofacultad","codigotiporegistroprocesofacultad",$_SESSION['codigotiporeporteprocesofacultad'],"","",0);

//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datose studiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));



if($_SESSION['columnasreporteprocesofacultad'][0]!="todos"){
	for($i=0;$i<count($_SESSION['columnasreporteprocesofacultad']);$i++)
		if(is_array($_SESSION['sesionprocesofacultadcolumnas'][$_SESSION['columnasreporteprocesofacultad'][$i]]))
			foreach($_SESSION['sesionprocesofacultadcolumnas'][$_SESSION['columnasreporteprocesofacultad'][$i]] as $llave => $valor)
	 		$columnastmp[]=$llave;
}
else{
		foreach($_SESSION['sesionprocesofacultadcolumnas'] as $llave1 => $valor1)
		foreach($_SESSION['sesionprocesofacultadcolumnas'][$llave1] as $llave2 => $valor2)
	 		$columnastmp[]=$llave2;

}


//exit();
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');

echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE ESTUDIANTES EN EL PROCESO ".strtoupper($datostipoproceso["nombretiporegistroprocesofacultad"])." DEL PROGRAMA ".$datoscarrera["nombrecarrera"]." EN EL PERIODO ".$_SESSION['codigoperiodoreporteprocesofacultad']."</h3></td></tr></table>";
echo "<iframe  src='listacolumnasreporteprocesofacultad.php' height='200' width='780'  ></iframe>";

if(!isset($_SESSION['ARREGLOREPORTEPROCESOFACULTAD'])&&$_SESSION['ARREGLOREPORTEPROCESOFACULTAD']=='')
$_SESSION['ARREGLOREPORTEPROCESOFACULTAD']=arreglo_registro_proceso($sala,$columnastmp);

$motor = new matriz($_SESSION['ARREGLOREPORTEPROCESOFACULTAD'],"Listado de proceso de facultad","listadoreporteprocesofacultad.php?semestre=$semestre","si","si","menu.php","listadoreporteprocesofacultad.php?semestre=$semestre&link_origen=menu.php",true,"si","../../../");
$formulario->filatmp["todos"]="*Todos*";

//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//echo "columnasreporteprocesofacultad=".count($_SESSION['columnasreporteprocesofacultad']);


	for($h=0;$h<count($columnastmp);$h++){
	$motor->agregarllave_drilldown($columnastmp[$h],'listadodetallereporteprocesofacultad.php','listadodetallereporteprocesofacultad.php','','codigocarrera',"columna=".$columnastmp[$h]."&codigoperiodo=".$_SESSION['codigoperiodoreporteprocesofacultad']."&codigotiporeporteprocesofacultad=".$_SESSION['codigotiporegistroreporteprocesofacultad']."&codigomodalidadacademica=".$_SESSION['codigomodalidadreporteprocesofacultad']."",'','','','','onclick= "return ventanaprincipal(this)"');
	$motor->agregar_llaves_totales($columnastmp[$h],"","","totales","","","","Totales");
	}
$motor->mostrar();
?>