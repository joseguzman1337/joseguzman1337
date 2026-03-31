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
	document.location.href="<?php echo 'menuriesgos.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo "menuriesgos.php?codigomodalidadacademica=".$_SESSION['codigomodalidadacademicariesgo']."&codigocarrera=".$_SESSION['codigocarrerariesgo']."&codigomateria=".$_SESSION['codigomateriariesgo']."&codigoperiodo=".$_SESSION['codigoperiodoriesgo'];?>";
}
</script>
<?php
if($_REQUEST['codigomateria']!=$_SESSION['codigomateriariesgo']&&trim($_REQUEST['codigomateria'])!='')
	$_SESSION['codigomateriariesgo']=$_REQUEST['codigomateria'];

if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicariesgo']&&trim($_REQUEST['codigomodalidadacademica'])!='')
	$_SESSION['codigomodalidadacademicariesgo']=$_REQUEST['codigomodalidadacademica'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrerariesgo']&&(trim($_REQUEST['codigocarrera'])!=''))
	$_SESSION['codigocarrerariesgo']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodoriesgo']&&(trim($_REQUEST['codigoperiodo'])!=''))
	$_SESSION['codigoperiodoriesgo']=$_REQUEST['codigoperiodo'];


//print_r($_REQUEST);
if($_SESSION['codigomodalidadacademicariesgo'] == "" || $_SESSION['codigocarrerariesgo'] == "" || $_SESSION['codigomateriariesgo'] == "")
{
?>
<script language="javascript">
    alert('Debe seleccionar la modalidad, la carrera y la materia')
    history.go(-1);
</script>
<?php
	exit();	
}
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/sala2.php');
$salatmp=$sala;

require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php' );
require_once('../../../funciones/sala/nota/nota.php');

//$salatmp=$sala;
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 
/*if(isset($_GET['debug']))
{
	$db->debug = true; 
}*/
function encuentra_array_materias($codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$objetobase,$imprimir=0){
    global $salatmp;
    if($codigocarrera!="todos")
        $carreradestino="AND c.codigocarrera='".$codigocarrera."'";
    else
        $carreradestino="";

    if($codigomateria!="todos")
        $materiadestino= "AND m.codigomateria='".$codigomateria."'";
    else
        $materiadestino= "";

    $query="select c.codigocarrera, c.nombrecarrera, m.codigomateria, m.nombremateria, g.idgrupo, g.codigoperiodo
    from  grupo g, materia m, carrera c
    where g.codigomateria = m.codigomateria 
    and g.codigoperiodo = $codigoperiodo 
    $carreradestino
    $materiadestino
    and m.codigocarrera = c.codigocarrera 
    and c.codigomodalidadacademica = $codigomodalidadacademica
    group by g.idgrupo";
 	
    //echo "sadasd".$query;
    if($imprimir)
        echo "sadasd".$query;

    $operacion=$objetobase->conexion->query($query);
    //$row_operacion=$operacion->fetchRow();
    $tmpidgrupo = 0;
            
    while ($row_operacion = $operacion->fetchRow())
    {
        unset($arrayRiesgos);
        $row_operacion['Riesgo_Alto'] = 0;
        $row_operacion['Riesgo_Medio'] = 0;
        $row_operacion['Riesgo_Bajo'] = 0;
        $row_operacion['Sin_Riesgo'] = 0;
        $row_operacion['Estudiantes_Matriculados'] = 0;
        if($tmpidgrupo != $row_operacion['idgrupo'])
        {
            /*$iniformAlto = "falto".$row_operacion['idgrupo'];
            $iniformMedio = "fmedio".$row_operacion['idgrupo'];
            $iniformBajo = "fbajo".$row_operacion['idgrupo'];
            $iniformSin = "fsin".$row_operacion['idgrupo'];
            $iniformTodos = "ftodos".$row_operacion['idgrupo'];
            
            $inihrefAlto = ' <a href="javascript: document.falto'.$row_operacion['idgrupo'].'.submit()">';
            $inihrefMedio = '<a href="javascript: document.fmedio'.$row_operacion['idgrupo'].'.submit()">';
            $inihrefBajo = '<a href="javascript: document.fbajo'.$row_operacion['idgrupo'].'.submit()">';
            $inihrefSin = '<a href="javascript: document.fsin'.$row_operacion['idgrupo'].'.submit()">';
            $inihrefTodos = '<a href="javascript: document.ftodos'.$row_operacion['idgrupo'].'.submit()">';
            $finhref = "</a>";*/
            
            // Trae un arreglo con las cantidades por cada materia
            unset($sala);
            $sala=$salatmp;
            $arrayRiesgos = tomarCantidadesRiesgosXMateria($row_operacion['idgrupo'], $row_operacion['codigomateria']);
            /*$row_operacion['Riesgo_Alto'] = trim(" $inihrefAlto ".$arrayRiesgos['Riesgo_Alto']." $finhref");
            $row_operacion['Riesgo_Medio'] = trim(" $inihrefMedio ".$arrayRiesgos['Riesgo_Medio']." $finhref");
            $row_operacion['Riesgo_Bajo'] = trim(" $inihrefBajo ".$arrayRiesgos['Riesgo_Bajo']." $finhref");
            $row_operacion['Sin_Riesgo'] = trim(" $inihrefSin ".$arrayRiesgos['Sin_Riesgo']." $finhref");
            $row_operacion['Estudiantes_Matriculados'] = trim(" $inihrefTodos ".$arrayRiesgos['Estudiantes_Matriculados']." $finhref");*/
            $row_operacion['Riesgo_Alto'] = $arrayRiesgos['Riesgo_Alto'];
            $row_operacion['Riesgo_Medio'] = $arrayRiesgos['Riesgo_Medio'];
            $row_operacion['Riesgo_Bajo'] = $arrayRiesgos['Riesgo_Bajo'];
            $row_operacion['Sin_Riesgo'] = $arrayRiesgos['Sin_Riesgo'];
            $row_operacion['Estudiantes_Matriculados'] = $arrayRiesgos['Estudiantes_Matriculados'];
            /*?>
<form name="<?php echo $iniformAlto; ?>" method="post" action="listadodetalleriesgos.php">
<?php       echo $arrayRiesgos['hiddenAlto']; ?>
</form>
<form name="<?php echo $iniformMedio; ?>" method="post" action="listadodetalleriesgos.php">
<?php       echo $arrayRiesgos['hiddenMedio']; ?>
</form>
<form name="<?php echo $iniformBajo; ?>" method="post" action="listadodetalleriesgos.php">
<?php       echo $arrayRiesgos['hiddenBajo']; ?>
</form>
<form name="<?php echo $iniformSin; ?>" method="post" action="listadodetalleriesgos.php">
<?php       echo $arrayRiesgos['hiddenSin']; ?>
</form>
<form name="<?php echo $iniformTodos; ?>" method="post" action="listadodetalleriesgos.php">
<?php       echo $arrayRiesgos['hiddenTodos']; ?>
</form>
<?php
            //$row_operacion['Estudiantes_Matriculados'] = trim(" $iniformTodos ".$arrayRiesgos['hiddenAlto'].$arrayRiesgos['hiddenMedio'].$arrayRiesgos['hiddenBajo'].$arrayRiesgos['hiddenSin']." $inihrefTodos ".$arrayRiesgos['Estudiantes_Matriculados']." $finhref $finform");
        */
        }
        $array_interno[] = $row_operacion;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    }
    return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$cantidadestmparray=encuentra_array_materias($_SESSION['codigomateriariesgo'],$_SESSION['codigocarrerariesgo'],$_SESSION['codigomodalidadacademicariesgo'],$_SESSION['codigoperiodoriesgo'],$objetobase,0);
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray,"REPORTE RIESGOS DE DECERSION ","listadoriesgos.php?codigomateria=".$_SESSION['codigomateria']."&codigocarrera=".$_SESSION['codigocarrera']."&codigocarrerad=".$_SESSION['codigocarrerad']."&codigoperiodo=".$_SESSION['codigoperiodo'],'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");

//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('Riesgo_Alto','listadoriesgos.php','listadodetalleriesgos.php','','idgrupo',"",'riesgo=Riesgo_Alto&','','','','');
$motor->agregarllave_drilldown('Riesgo_Medio','listadoriesgos.php','listadodetalleriesgos.php','','idgrupo',"",'riesgo=Riesgo_Medio&','','','','');
$motor->agregarllave_drilldown('Riesgo_Bajo','listadoriesgos.php','listadodetalleriesgos.php','','idgrupo',"",'riesgo=Riesgo_Bajo&','','','','');
$motor->agregarllave_drilldown('Sin_Riesgo','listadoriesgos.php','listadodetalleriesgos.php','','idgrupo',"",'riesgo=Sin_Riesgo&','','','','');
$motor->agregarllave_drilldown('Estudiantes_Matriculados','listadoriesgos.php','listadodetalleriesgos.php','','idgrupo',"",'riesgo=Estudiantes_Matriculados&','','','','');

$motor->agregar_llaves_totales('Riesgo_Alto',"listadoriesgos.php","listadodetalleriesgos.php","totales","riesgo=Riesgo_Alto","","","Totales");
$motor->agregar_llaves_totales('Riesgo_Medio',"listadoriesgos.php","listadodetalleriesgos.php","totales","riesgo=Riesgo_Medio","","","Totales");
$motor->agregar_llaves_totales('Riesgo_Bajo',"listadoriesgos.php","listadodetalleriesgos.php","totales","riesgo=Riesgo_Bajo","","","Totales");
$motor->agregar_llaves_totales('Sin_Riesgo',"listadoriesgos.php","listadodetalleriesgos.php","totales","riesgo=Sin_Riesgo","","","Totales");
$motor->agregar_llaves_totales('Estudiantes_Matriculados',"listadoriesgos.php","listadodetalleriesgos.php","totales","riesgo=Estudiantes_Matriculados","","","Totales");


$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
