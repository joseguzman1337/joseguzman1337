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
        document.location.href="<?php echo 'menutiempograduados.php'; ?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menutiempograduados.php'; ?>";
    }

</script>
<?php
$rutaado = ("../../../funciones/adodb/");
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


function encuentra_array_materias($objetobase, $imprimir=0) {


    if (trim($_SESSION['codigocarreragraduados']) != "todos")
        $carreradestino = "AND c.codigocarrera='" . $_SESSION['codigocarreragraduados'] . "'";
    else
        $carreradestino="";

    $query = "SELECT eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
    e.codigoestudiante,e.codigoperiodo codigoperiodoentrada,
(substring(p.codigoperiodo,1,4)-substring(e.codigoperiodo,1,4))*2 +
(substring(p.codigoperiodo,5,5)-substring(e.codigoperiodo,5,5)) semestres,

pl.cantidadsemestresplanestudio,
if(
((substring(p.codigoperiodo,1,4)-substring(e.codigoperiodo,1,4))*2 +
(substring(p.codigoperiodo,5,5)-substring(e.codigoperiodo,5,5)) - pl.cantidadsemestresplanestudio)=0,1,0
) cumplimiento,
c.nombrecarrera, COUNT(rg.idregistrograduado) as graduados,0 graduadosantiguos,
p.codigoperiodo periodogrado,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))

fecha_inicial,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

fecha_final
	FROM registrograduado rg, estudiante e,periodo p,carrera c,
        modalidadacademica m,planestudioestudiante pe,planestudio pl,estudiantegeneral eg

	WHERE
        e.idestudiantegeneral=eg.idestudiantegeneral
        and rg.codigoestudiante=e.codigoestudiante
	and m.codigomodalidadacademica='" . $_SESSION['codigomodalidadacademicagraduados'] . "'
	and c.codigomodalidadacademica=m.codigomodalidadacademica
	and c.codigocarrera = e.codigocarrera
	" . $carreradestino . "
	AND rg.codigoestado='100'
	AND rg.codigoautorizacionregistrograduado='100'
	and e.codigoperiodo between " . $_SESSION['codigoperiododgraduados'] . " and " . $_SESSION['codigoperiodofinaldgraduados'] . "
         and e.codigoestudiante=pe.codigoestudiante
         and pe.idplanestudio=pl.idplanestudio
and pe.codigoestadoplanestudioestudiante like '1%'
	and rg.fechagradoregistrograduado BETWEEN

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))  AND

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

group by c.codigocarrera,p.codigoperiodo,e.codigoestudiante

UNION
SELECT eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,
rg.codigoestudiante,e.codigoperiodo codigoperiodoentrada,
(substring(p.codigoperiodo,1,4)-substring(e.codigoperiodo,1,4))*2 +
(substring(p.codigoperiodo,5,5)-substring(e.codigoperiodo,5,5)) semestres,

pl.cantidadsemestresplanestudio,
if(
((substring(p.codigoperiodo,1,4)-substring(e.codigoperiodo,1,4))*2 +
(substring(p.codigoperiodo,5,5)-substring(e.codigoperiodo,5,5)) - pl.cantidadsemestresplanestudio)=0,1,0
) cumplimiento,
c.nombrecarrera,0 graduados,COUNT(distinct rg.idregistrograduadoantiguo) as graduadosantiguos,
p.codigoperiodo periodogrado,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))

fecha_inicial,
	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

 fecha_final
	FROM registrograduadoantiguo rg,periodo p,carrera c,
        modalidadacademica m,estudiante e,planestudioestudiante pe,
        planestudio pl,estudiantegeneral eg
	WHERE
         e.idestudiantegeneral=eg.idestudiantegeneral and
	 m.codigomodalidadacademica='" . $_SESSION['codigomodalidadacademicagraduados'] . "'
         and e.codigoestudiante=rg.codigoestudiante
         and e.codigoestudiante=pe.codigoestudiante
         and pe.idplanestudio=pl.idplanestudio
          and pe.codigoestadoplanestudioestudiante like '1%'
	and c.codigomodalidadacademica=m.codigomodalidadacademica
	and rg.codigocarrera=c.codigocarrera
	" . $carreradestino . "
	and e.codigoperiodo between " . $_SESSION['codigoperiododgraduados'] . " and " . $_SESSION['codigoperiodofinaldgraduados'] . "
	and rg.fechagradoregistrograduadoantiguo BETWEEN

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-07-16'),
	concat(substring(p.codigoperiodo,1,4),'-01-01'))  AND

	if(substring(p.codigoperiodo,5,5)='2',
	concat(substring(p.codigoperiodo,1,4),'-12-31'),
	concat(substring(p.codigoperiodo,1,4),'-07-15'))

group by c.codigocarrera,p.codigoperiodo,e.codigoestudiante
order by codigoperiodoentrada desc,nombrecarrera ";
//exit();

    if ($imprimir)
        echo $query;

    $operacion = $objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
    $i = 0;
    while ($row_operacion = $operacion->fetchRow()) {
        if($i==0){
            $estudiantes .= $row_operacion["codigoestudiante"];
        }
        else{
            $estudiantes .= "," . $row_operacion["codigoestudiante"];
        }
        $array_interno[] = $row_operacion;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
        foreach ($row_operacion as $llave => $valor)
            $row[$llave] = "";
        $i++;
    }

    $query = "SELECT eg.numerodocumento,eg.apellidosestudiantegeneral,
                eg.nombresestudiantegeneral,e.codigoestudiante,e.codigoperiodo codigoperiodoentrada
                ,'&nbsp;' semestres,pl.cantidadsemestresplanestudio,'&nbsp;' cumplimiento,c.nombrecarrera,'0' graduados
                ,'0' graduadosantiguos,'&nbsp;' periodogrado,'&nbsp;' fechainicial,'&nbsp;' fechafinal
                FROM notahistorico ee, carrera c,
                estudiante e,estudiantegeneral eg,
                planestudioestudiante pe,planestudio pl
                where 
                e.codigocarrera=c.codigocarrera
                and c.codigomodalidadacademica='" . $_SESSION['codigomodalidadacademicagraduados'] . "'
                and e.codigoestudiante=pe.codigoestudiante
                and pe.idplanestudio=pl.idplanestudio
                and eg.idestudiantegeneral=e.idestudiantegeneral
        	" . $carreradestino . "
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoestadonotahistorico like '1%'
                and e.codigoperiodo=ee.codigoperiodo
                and e.codigoperiodo between " . $_SESSION['codigoperiododgraduados'] . "
                and " . $_SESSION['codigoperiodofinaldgraduados'] . "
                and e.codigoestudiante not in (".$estudiantes.")
                    group by e.codigoestudiante
                order by 1";

    if ($imprimir)
        echo $query;

    $operacion = $objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
    while ($row_operacion = $operacion->fetchRow()) {

        $array_interno[] = $row_operacion;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
        foreach ($row_operacion as $llave => $valor)
            $row[$llave] = "";
    }
    return $array_interno;
}

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');



if ($_REQUEST['codigomodalidadacademica'] != $_SESSION['codigomodalidadacademicagraduados'] && trim($_REQUEST['codigomodalidadacademica']) != '')
    $_SESSION['codigomodalidadacademicagraduados'] = $_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarreragraduados'] && (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarreragraduados'] = $_REQUEST['codigocarrera'];

if ($_REQUEST['codigoperiodo'] != $_SESSION['codigoperiododgraduados'] && (trim($_REQUEST['codigoperiodo']) != ''))
    $_SESSION['codigoperiododgraduados'] = $_REQUEST['codigoperiodo'];

if ($_REQUEST['codigoperiodofinal'] != $_SESSION['codigoperiodofinaldgraduados'] && (trim($_REQUEST['codigoperiodofinal']) != ''))
    $_SESSION['codigoperiodofinaldgraduados'] = $_REQUEST['codigoperiodofinal'];



unset($filacarreras);
$_SESSION['idestudianteseguimientogeneral'] = '';

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera = $objetobase->recuperar_datos_tabla('carrera', 'codigocarrera', $_SESSION['codigocarreragraduados'], "", "", 0);
if (isset($datoscarrera["nombrecarrera"]) != '')
    $titulocarrera = "EN LA CARRERA " . $datoscarrera["nombrecarrera"];
echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE GRADUADOS VS MATRICULADOS QUE INGRESARON DEL PERIODO " . $_SESSION['codigoperiododgraduados'] . " AL PERIODO " . $_SESSION['codigoperiodofinaldgraduados'] . "
				 " . $titulocarrera . " </h3></td></tr></table>";

$cantidadestmparray = encuentra_array_materias($objetobase, 0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray, "ESTADISTICAS GRADUADOS ", "listadotiempograduado.php", 'si', 'si', 'menutiempograduados.php', 'listadotiempograduado.php', true, "si", "../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Estudiantes','listadoseguimiento.php','listadodetalleestudianteseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=0",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregarllave_drilldown('Seguimientos','listadoseguimiento.php','listadodetalleseguimiento.php','','Codigo_Estado',"&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&columna=1",'codigocarrera','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('graduados',"listadoseguimiento.php","listadodetalleestudianteseguimiento.php","totales","&codigomateria=".$_SESSION['codigomateriaseguimiento']."&codigocarrera=".$_SESSION['codigocarreraseguimiento']."&codigoperiodo=".$_SESSION['codigoperiododseguimiento']."&Codigo_Estado=todos","","","Totales");
$motor->agregar_llaves_totales('cumplimiento', "", "", "totales", "", "", "", "Totales");

$motor->agregar_llaves_totales('graduados', "", "", "totales", "", "", "", "Totales");
$motor->agregar_llaves_totales('graduadosantiguos', "", "", "totales", "", "", "", "Totales");


$tabla->botonRecargar = false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
