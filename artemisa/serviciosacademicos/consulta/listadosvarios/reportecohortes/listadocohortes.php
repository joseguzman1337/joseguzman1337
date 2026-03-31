<?php
session_start();
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
	document.location.href="<?php echo 'menu.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo "menu.php?codigomodalidadacademica=".$_SESSION['codigomodalidadacademicacohorte']."&codigocarrera=".$_SESSION['codigocarreracohorte']."&codigoperiodo=".$_SESSION['codigoperiodocohorte'];?>";
}
</script>
<?php
if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicacohorte']&&trim($_REQUEST['codigomodalidadacademica'])!='')
	$_SESSION['codigomodalidadacademicacohorte']=$_REQUEST['codigomodalidadacademica'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreracohorte']&&(trim($_REQUEST['codigocarrera'])!=''))
	$_SESSION['codigocarreracohorte']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodocohorte']&&(trim($_REQUEST['codigoperiodo'])!=''))
	$_SESSION['codigoperiodocohorte']=$_REQUEST['codigoperiodo'];


//print_r($_REQUEST);
if($_SESSION['codigomodalidadacademicacohorte'] == "" || $_SESSION['codigocarreracohorte'] == "")
{
?>
<script language="javascript">
    alert('Debe seleccionar la modalidad y la carrera')
    history.go(-1);
</script>
<?php
	exit();
}
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

require_once('../../../Connections/sala2.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
/*if(isset($_GET['debug']))
{
	$db->debug = true;
}*/
function encuentra_array_cohortes($codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$objetobase,$imprimir=0){
    if($codigocarrera!="todos")
        $carreradestino="AND c.codigocarrera='".$codigocarrera."'";
    else
        $carreradestino="";

    $query="select c.codigoperiodo, ca.codigocentrobeneficio, ca.nombrecarrera,  c.codigoperiodoinicial as `Periodo Inicial Cohorte`, c.codigoperiodofinal as `Periodo Final Cohorte`, j.nombrejornada, dc.semestredetallecohorte, dc.valordetallecohorte
    from cohorte c, detallecohorte dc, carrera ca, jornada j
    where c.idcohorte = dc.idcohorte
    and c.codigoperiodo = $codigoperiodo
    and c.codigoestadocohorte = '01'
    and ca.codigocarrera = c.codigocarrera
    and ca.codigomodalidadacademica = $codigomodalidadacademica
    and c.codigojornada = j.codigojornada
    $carreradestino";

    //echo "sadasd".$query;
    if($imprimir)
        echo "sadasd".$query;

    $operacion=$objetobase->conexion->query($query);
    //$row_operacion=$operacion->fetchRow();
    $tmpidgrupo = 0;

    while ($row_operacion = $operacion->fetchRow())
    {
        $array_interno[] = $row_operacion;
    }
    return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$cantidadestmparray=encuentra_array_cohortes($_SESSION['codigomateriariesgo'],$_SESSION['codigocarreracohorte'],$_SESSION['codigomodalidadacademicacohorte'],$_SESSION['codigoperiodocohorte'],$objetobase,0);
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray,"REPORTE COHORTES ","listadocohortes.php?codigomateria=".$_SESSION['codigomateria']."&codigocarrera=".$_SESSION['codigocarrera']."&codigocarrerad=".$_SESSION['codigocarrerad']."&codigoperiodo=".$_SESSION['codigoperiodo'],'si','si','menuasignacionsalones.php','listado_general.php',true,"si","../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");

//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"

/*
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
*/

$tabla->botonRecargar=false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
