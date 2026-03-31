<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
<!--
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga()
{
	document.location.href="<?php echo 'menuusuarioclave.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'menuusuarioclave.php';?>";
}
function enviacorreoajax(archivo,parametros){

process(archivo,parametros);
//alert(xmlHttp2.responseText);
 setTimeout('muestrarespuesta()',500);

//alert("entro");

return false;
}
function muestrarespuesta(){
if(xmlRoot!=null){
var responseText = xmlRoot.firstChild.data;
alert(responseText);
//document.location.href="listadousuarioclave.php";
}
else
setTimeout('muestrarespuesta()',500);

}

</script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>

<?php
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 


function encuentra_array_materias($arraysesion,$objetobase,$imprimir=0){

$codigocarrera=$arraysesion['codigocarrerausuarioclave'];
$codigomodalidadacademica=$arraysesion['codigomodalidadacademicaseguimiento'];
$codigoperiodo=$arraysesion['codigoperiodousuarioclave'];
$numerodocumento=$arraysesion['numerodocumentousuarioclave'];



if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";


if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";


$query="select distinct eg.apellidosestudiantegeneral Apellidos,eg.nombresestudiantegeneral Nombres,
eg.numerodocumento Documento,
eg.emailestudiantegeneral Email,u.usuario Usuario from  estudiantegeneral eg
left join usuario u on u.numerodocumento=eg.numerodocumento and codigoestadousuario like '1%'
left join logcreacionusuario l on l.idusuario=u.idusuario  and 
l.codigoestado=100 and 
l.tmpclavelogcreacionusuario <> ''
 where 
eg.numerodocumento='".$numerodocumento."'
order by Apellidos, Nombres
";
/*
o.codigoestudiante=e.codigoestudiante and
o.codigoestadoordenpago LIKE '4%' and 
o.numeroordenpago=d.numeroordenpago 
AND d.codigoconcepto=151  and
o.codigoperiodo >= e.codigoperiodo and
o.numeroordenpago = (
select min(o2.numeroordenpago) from 
ordenpago o2,detalleordenpago d2 where
o2.numeroordenpago=d2.numeroordenpago and
 o2.codigoestudiante=e.codigoestudiante and
o2.codigoestadoordenpago LIKE '4%' and 
d2.codigoconcepto=151 
)
*/
//".$condiciontipoobservacion."
//having Codigo_Estado='".$codigoestado."'
		 
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		//$row_operacion["Seguimientos"]="<a href='listadodetalleseguimiento.php?codigocarrera=".$row_operacion["codigocarrera"]."&'>".$row_operacion["Seguimientos"]."</a>";
	$enviacorreoget="numerodocumento=".$row_operacion["Documento"]."&usuario=".$row_operacion["Usuario"]."";
	$row_operacion["Envia_Correo"]="<a href=Javascript onclick=\"return enviacorreoajax('cambioclavecorreo.php','".$enviacorreoget."');\">Envia Correo</a>";
	$array_interno[]=$row_operacion;
	}
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerausuarioclave']&&trim($_REQUEST['codigocarrera'])!='')
$_SESSION['codigocarrerausuarioclave']=$_REQUEST['codigocarrera'];


//if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicaseguimiento']&&trim($_REQUEST['codigomodalidadacademica'])!='')
//$_SESSION['codigomodalidadacademicaseguimiento']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodousuarioclave']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiodousuarioclave']=$_REQUEST['codigoperiodo'];


if($_REQUEST['numerodocumento']!=$_SESSION['numerodocumentousuarioclave']&&(trim($_REQUEST['numerodocumento'])!=''))
$_SESSION['numerodocumentousuarioclave']=$_REQUEST['numerodocumento'];

//echo "<h1>codigocarrera=".$_REQUEST['codigocarrera']."---".."</h1>"

$_SESSION['SESIONINICIADASAHDJASHER8921743']=1;

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
$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigofacultad'],"","",0);
echo "<table width='400'><tr><td align='center'><h3>USUARIO DE ESTUDIANTE EN ".$datoscarrera["nombrecarrera"]." </h3></td></tr><tr><td>";
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
$motor = new matriz($cantidadestmparray,"ESTADISTICAS ALUMNOS X MATERIA ","listadousuarioclave.php",'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadonotascorte.php','listadodetalleseguimiento.php','','codigomateria',
//"&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadodetalleestudianteseguimiento.php','listadodetalleseguimiento.php','','codigocarrera',"&codigomateria=".$_SESSION['codigomaterianotascorte']."&columna=1",'idestudianteseguimiento','','','','onclick= "return ventanaprincipal(this)"');

//$motor->agregar_llaves_totales('Estudiantes',"listadonotascorte.php","listadodetallenotascortes.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&codigocarrera=".$_SESSION['codigocarreranotascorte']."&codigoperiodo=".$_SESSION['codigoperiododnotascorte']."&columna=0","","","Totales");
//$motor->agregar_llaves_totales('Seguimientos',"listadodetalleestudianteseguimiento.php","listadodetalleseguimiento.php","totales","&codigomateria=".$_SESSION['codigomaterianotascorte']."&Codigo_Estado=".$_SESSION['codigoestadodetalleseguimiento']."&codigocarrera=".$_SESSION['codigocarreradetalleseguimiento']."&columna=1","","","Totales");
//$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
unset($_GET);
$motor->mostrar();
echo "</td></tr></table>";
?>
