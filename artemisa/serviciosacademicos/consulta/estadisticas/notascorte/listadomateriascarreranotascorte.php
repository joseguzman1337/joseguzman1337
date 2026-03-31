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
	document.location.href="<?php echo 'menumateriascarreranotascorte.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo 'menumateriascarreranotascorte.php';?>";
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
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 


function encuentra_array_materias($codigocarrera,$codigoperiodo,$semestreestudiante,$numerocorte,$objetobase,$imprimir=0){
 
 
if($codigocarrera!="todos")
$carreradestino="AND m.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($semestreestudiante!="todos")
$semestredestino="and p.semestreprematricula='".$semestreestudiante."'";
else
$semestredestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query="select *,c.nombrecarrera nombrecarreramateria, ce.nombrecarrera nombrecarreraestudiante from
materia m , prematricula p, detalleprematricula d, 
estudiante e, detallenota dn, grupo g, 
estudiantegeneral eg, corte co, carrera c, carrera ce
where 
ce.codigocarrera=e.codigocarrera and 
m.codigomateria=d.codigomateria and
c.codigocarrera=m.codigocarrera and
d.idprematricula=p.idprematricula and
e.codigoestudiante=p.codigoestudiante 
and g.idgrupo=dn.idgrupo
and dn.codigoestudiante=e.codigoestudiante
and g.codigomateria=m.codigomateria
and g.codigoperiodo=p.codigoperiodo
and eg.idestudiantegeneral=e.idestudiantegeneral
and co.idcorte=dn.idcorte
AND p.codigoestadoprematricula LIKE '4%'
AND d.codigoestadodetalleprematricula  LIKE '3%'
and p.codigoperiodo=".$codigoperiodo."
".$carreradestino."
".$semestredestino."
and co.numerocorte=".$numerocorte."
order by p.semestreprematricula,m.nombremateria,
		 eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral";
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		$array_armado[$row_operacion['numerodocumento']]["nombre"]=$row_operacion['apellidosestudiantegeneral']."  ".$row_operacion['nombresestudiantegeneral'];
		$array_armado[$row_operacion['numerodocumento']]["numerodocumento"]=$row_operacion['numerodocumento'];
		$array_armado[$row_operacion['numerodocumento']]["nombrecarreramateria"]=$row_operacion['nombrecarreramateria'];
		$array_armado[$row_operacion['numerodocumento']]["nombrecarreraestudiante"]=$row_operacion['nombrecarreraestudiante'];

		$array_armado[$row_operacion['numerodocumento']]["semestreprematricula"]=$row_operacion['semestreprematricula'];
		$array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['nota'];
		$materias[cambiarespacio($row_operacion['nombremateria'])]=1;
		$notasmateria[cambiarespacio($row_operacion['nombremateria'])][]=$row_operacion['nota'];
		$array_creditos[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]=$row_operacion['numerocreditos'];
		
		if($array_armado[$row_operacion['numerodocumento']][cambiarespacio($row_operacion['nombremateria'])]<$row_operacion["notaminimaaprobatoria"])
		$notasperdidasmateria[cambiarespacio($row_operacion['nombremateria'])][]=$row_operacion['nota'];
		$row_operacion;
		
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
	}
	/*echo "<pre>";
	print_r($array_armado);
	echo "</pre>";*/
	$i=0;
	if(is_array($array_armado))
	foreach($array_armado as $numerodocumento => $row_armado){

		$row_otro["NOMBRE"]=$row_armado["nombre"];
		$row_otro["DOCUMENTO"]=$row_armado["numerodocumento"];
		$row_otro["CARRERA"]=$row_armado["nombrecarreramateria"];
		$row_otro["CARRERA_ESTUDIANTE"]=$row_armado["nombrecarreraestudiante"];

		$row_otro["SEMESTRE"]=$row_armado["semestreprematricula"];
		unset($creditos);
		unset($notas);

		foreach($materias as $materia => $numeral){

			//echo "if((!isset(".$row_armado[$materia]."))||(trim(".$row_armado[$materia].")==''))<br>";
			if((!isset($row_armado[$materia]))||(trim($row_armado[$materia])=='')){
				$row_otro[$materia]="&nbsp;";
				$creditos[]="0";
				$notas[]="0";

				}
			else{	
				$row_otro[$materia]=$row_armado[$materia];
				$creditos[]=$array_creditos[$numerodocumento][$materia];
				$notas[]=$row_otro[$materia];
				}
		}
		
		$row_otro["PROMEDIO_PONDERADO"]=round(promedioponderado($notas,$creditos),2);	

/*  		echo "$i<pre>";
		print_r($notas);
		echo "</pre>";
 */ 
		//$row_otro
		
		$arrayinterno1[$i]=$row_otro;
		$i++;
	}
	if(is_array($notasmateria))
	foreach ($notasmateria as $materia => $arraynotas){
	$arrayinterno2[0]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MINIMA</B>";
	$arrayinterno2[0][$materia]=min($arraynotas);
	$arrayinterno2[1]["TIPO DE CALCULO\\ASIGNATURA"]="<B>NOTA MAXIMA</B>";
	$arrayinterno2[1][$materia]=max($arraynotas);
	$arrayinterno2[2]["TIPO DE CALCULO\\ASIGNATURA"]="<B>DESVIACIÓN ESTANDAR</B>";
	$arrayinterno2[2][$materia]=round(desviacionestandar($arraynotas),2);
	$arrayinterno2[3]["TIPO DE CALCULO\\ASIGNATURA"]="<B>PROMEDIO</B>";
	$arrayinterno2[3][$materia]=round(promedio($arraynotas),2);
	$arrayinterno2[4]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES PERDIERON</B>";
	$arrayinterno2[4][$materia]=count($notasperdidasmateria[$materia]);
	$arrayinterno2[5]["TIPO DE CALCULO\\ASIGNATURA"]="<B>Nº ESTUDIANTES ASIGNATURA</B>";
	$arrayinterno2[5][$materia]=count($arraynotas);
	}
		$array_interno[0]=$arrayinterno1;
		$array_interno[1]=$arrayinterno2;

	/*echo "<pre>";
	print_r($array_interno);
	echo "</pre>";*/

	
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');




if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicanotasmateriacorte']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicanotasmateriacorte']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotasmateriacorte]=".$_SESSION['codigomaterianotasmateriacorte'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreranotasmateriacorte']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreranotasmateriacorte']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododnotasmateriacorte']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododnotasmateriacorte']=$_REQUEST['codigoperiodo'];

if($_REQUEST['semestreestudiante']!=$_SESSION['semestreestudiantenotasmateriacorte']&&(trim($_REQUEST['semestreestudiante'])!=''))
$_SESSION['semestreestudiantenotasmateriacorte']=$_REQUEST['semestreestudiante'];

if($_REQUEST['numerocorte']!=$_SESSION['numerocortenotasmateriacorte']&&(trim($_REQUEST['numerocorte'])!=''))
$_SESSION['numerocortenotasmateriacorte']=$_REQUEST['numerocorte'];


unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO PROMEDIO CORTE ".$_SESSION['numerocortenotasmateriacorte']." PERIODO ".$_SESSION['codigoperiododnotasmateriacorte']." SEMESTRE ".strtoupper($_SESSION['semestreestudiantenotasmateriacorte'])."</h3></td></tr></table>";
$cantidadestmparray=encuentra_array_materias($_SESSION['codigocarreranotasmateriacorte'],$_SESSION['codigoperiododnotasmateriacorte'],$_SESSION['semestreestudiantenotasmateriacorte'],$_SESSION['numerocortenotasmateriacorte'],$objetobase,0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
//unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
if($_GET['exporte']==2){

$motor = new matriz($cantidadestmparray[1],"RESUMEN DE PROMEDIOS CORTES","listadomateriascarreranotascorte.php?exporte=2",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla->botonRecargar=false;
$motor->mostrar();

$motor = new matriz($cantidadestmparray[0],"ESTADISTICAS PROMEDIOS CORTES","listadomateriascarreranotascorte.php?exporte=1",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla->botonRecargar=false;
$motor->mostrar();
}
else{
$motor = new matriz($cantidadestmparray[0],"ESTADISTICAS PROMEDIOS CORTES","listadomateriascarreranotascorte.php?exporte=1",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla->botonRecargar=false;
$motor->mostrar();

$motor = new matriz($cantidadestmparray[1],"RESUMEN DE PROMEDIOS CORTES","listadomateriascarreranotascorte.php?exporte=2",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla->botonRecargar=false;
$motor->mostrar();
}


?>
