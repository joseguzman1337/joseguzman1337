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
        document.location.href="<?php echo 'menunotascorte.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menunotascorte.php'; ?>";
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
require_once('../../../funciones/clases/autenticacion/redirect.php' );


#echo '<br>codigomateria->'.$codigomateria.'<br>codigocarrera->'.$codigocarrera.'<br>codigomodalidadacademica->'.$codigomodalidadacademica.'<br>codigoperiodo->'.$codigoperiodo.'<br>objetobase->'.$objetobase;

function encuentra_array_materias($codigomateria, $codigocarrera, $codigomodalidadacademica, $codigoperiodo, $objetobase, $imprimir=0) {


    if ($codigocarrera != "todos")
        $carreradestino = "AND c.codigocarrera='" . $codigocarrera . "'";
    else
        $carreradestino="";

    if ($codigomateria != "todos")
        $materiadestino = "AND m.codigomateria='" . $codigomateria . "'";
    else
        $materiadestino= "";

    $query = "select c.codigocarrera,c.nombrecarrera,m.codigomateria,m.nombremateria,g.codigoperiodo,
count(distinct e.codigoestudiante) Total_Estudiantes,
count(distinct d1.codigoestudiante) Perdieron_Corte1,
CONCAT((ROUND((count(distinct d1.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte1',
count(distinct d2.codigoestudiante) Perdieron_Corte2,
CONCAT((ROUND((count(distinct d2.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte2',

count(distinct d3.codigoestudiante) Perdieron_Corte3,
CONCAT((ROUND((count(distinct d3.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte3',

count(distinct d4.codigoestudiante) Perdieron_Corte4,
CONCAT((ROUND((count(distinct d4.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%') as '%Perdieron_corte4',

count(distinct h.codigoestudiante) Perdieron_Definitiva,
CONCAT((ROUND((count(distinct h.codigoestudiante)/count(distinct e.codigoestudiante))*100)),'%')  as '%Perdieron_definitiva',

count(distinct g.idgrupo) Total_Grupo

 from  grupo g, materia m, corte co, estudiante e, carrera c,detallenota d
	left join detallenota d1 on 
	d1.codigoestudiante=d.codigoestudiante and
	d1.idgrupo=d.idgrupo and
	d1.idcorte in (select idcorte from corte c1 where numerocorte=1 and c1.idcorte=co.idcorte) and
	ROUND(d1.nota,1) < (select notaminimaaprobatoria from materia m1 where m1.codigomateria=d1.codigomateria)

	left join detallenota d2 on 
	d2.codigoestudiante=d.codigoestudiante and
	d2.idgrupo=d.idgrupo and
	d2.idcorte in (select idcorte from corte c2 where numerocorte=2 and c2.idcorte=co.idcorte) and
	ROUND(d2.nota,1) < (select notaminimaaprobatoria from materia m2 where m2.codigomateria=d2.codigomateria)

	left join detallenota d3 on 
	d3.codigoestudiante=d.codigoestudiante and
	d3.idgrupo=d.idgrupo and
	d3.idcorte = (select idcorte from corte c3 where numerocorte=3 and c3.idcorte=co.idcorte) and
	ROUND(d3.nota,1) < (select notaminimaaprobatoria from materia m3 where m3.codigomateria=d3.codigomateria)


	left join detallenota d4 on 
	d4.codigoestudiante=d.codigoestudiante and
	d4.idgrupo=d.idgrupo and
	d4.idcorte = (select idcorte from corte c3 where numerocorte=4 and c3.idcorte=co.idcorte) and
	ROUND(d4.nota,1) < (select notaminimaaprobatoria from materia m4 where m4.codigomateria=d4.codigomateria)

left join notahistorico h on 
	h.codigoestudiante=d.codigoestudiante and
	h.idgrupo=d.idgrupo and
	ROUND(h.notadefinitiva,1) < (select notaminimaaprobatoria from materia m5 where m5.codigomateria=h.codigomateria)

where 
d.idgrupo=g.idgrupo and
g.codigomateria=m.codigomateria and
d.codigoestudiante=e.codigoestudiante and 
co.idcorte=d.idcorte and
g.codigoperiodo=" . $codigoperiodo . "
" . $carreradestino . "
" . $materiadestino . "
 and  m.codigocarrera=c.codigocarrera and 
c.codigomodalidadacademica=" . $codigomodalidadacademica . "
AND g.codigoestadogrupo like '1%'
group by m.codigomateria
order by c.nombrecarrera";

    if ($imprimir)
        echo $query;

$iarray_interno=0;
    $operacion = $objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
    while ($row_operacion = $operacion->fetchRow()) {

        $tabla = "planestudio p,detalleplanestudio dp";
        $condicion = " and p.idplanestudio=dp.idplanestudio"
                . " and dp.codigomateria='" . $row_operacion["codigomateria"] . "'";
        $resultado = $objetobase->recuperar_resultado_tabla($tabla, "p.codigocarrera", $row_operacion["codigocarrera"], $condicion);
        $cadenasemestremateria = "";
        unset($filassemestre);
        while ($rowdetalleplan = $resultado->fetchRow()) {
            $filassemestre[$rowdetalleplan["semestredetalleplanestudio"]] = $rowdetalleplan["semestredetalleplanestudio"];
        }
        $isemestremateria = 0;
        if(is_array($filassemestre))
        foreach ($filassemestre as $ifilassemestre => $rowfilassemestre) {
            if ($isemestremateria == 0)
                $cadenasemestremateria.=$rowfilassemestre;
            else
                $cadenasemestremateria.="," . $rowfilassemestre;
            $isemestremateria++;
        }
        $row_operacion["semestremateria"] = $cadenasemestremateria;

$rowarrayinterno["codigocarrera"]=$row_operacion["codigocarrera"];
$rowarrayinterno["nombrecarrera"]=$row_operacion["nombrecarrera"];
$rowarrayinterno["codigomateria"]=$row_operacion["codigomateria"];
$rowarrayinterno["nombremateria"]=$row_operacion["nombremateria"];
$rowarrayinterno["semestremateria"]=$row_operacion["semestremateria"];
$rowarrayinterno["codigoperiodo"]=$row_operacion["codigoperiodo"];
$rowarrayinterno["Total_Estudiantes"]=$row_operacion["Total_Estudiantes"];
$rowarrayinterno["Perdieron_Corte1"]=$row_operacion["Perdieron_Corte1"];
$rowarrayinterno["%Perdieron_corte1"]=$row_operacion["%Perdieron_corte1"];
$rowarrayinterno["Perdieron_Corte2"]=$row_operacion["Perdieron_Corte2"];
$rowarrayinterno["%Perdieron_corte2"]=$row_operacion["%Perdieron_corte2"];
$rowarrayinterno["Perdieron_Corte3"]=$row_operacion["Perdieron_Corte3"];
$rowarrayinterno["%Perdieron_corte3"]=$row_operacion["%Perdieron_corte3"];
$rowarrayinterno["Perdieron_Corte4"]=$row_operacion["Perdieron_Corte4"];
$rowarrayinterno["%Perdieron_corte4"]=$row_operacion["%Perdieron_corte4"];
$rowarrayinterno["Perdieron_Definitiva"]=$row_operacion["Perdieron_Definitiva"];
$rowarrayinterno["%Perdieron_Definitiva"]=$row_operacion["%Perdieron_Definitiva"];
$rowarrayinterno["Total_Grupo"]=$row_operacion["Total_Grupo"];


        $array_interno[$iarray_interno] = $rowarrayinterno;
        $iarray_interno++;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    }
    return $array_interno;
}

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');


if ($_REQUEST['codigomateria'] != $_SESSION['codigomaterianotascorte'] && trim($_REQUEST['codigomateria']) != '')
    $_SESSION['codigomaterianotascorte'] = $_REQUEST['codigomateria'];


if ($_REQUEST['codigomodalidadacademica'] != $_SESSION['codigomodalidadacademicanotascorte'] && trim($_REQUEST['codigomodalidadacademica']) != '')
    $_SESSION['codigomodalidadacademicanotascorte'] = $_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomaterianotascorte]=".$_SESSION['codigomaterianotascorte'];
if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarreranotascorte'] && (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarreranotascorte'] = $_REQUEST['codigocarrera'];

if ($_REQUEST['codigoperiodo'] != $_SESSION['codigoperiododnotascorte'] && (trim($_REQUEST['codigoperiodo']) != ''))
    $_SESSION['codigoperiododnotascorte'] = $_REQUEST['codigoperiodo'];



unset($filacarreras);

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$datoscarrera = $objetobase->recuperar_datos_tabla('carrera', 'codigocarrera', $_SESSION['codigocarreranotascorte'], "", "", 0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO NOTAS PERDIDAS POR CORTE  " . $datoscarrera["nombrecarrera"] . " PERIODO " . $_SESSION['codigoperiododfacultadesmateriadetalle'] . "</h3></td></tr></table>";

$cantidadestmparray = encuentra_array_materias($_SESSION['codigomaterianotascorte'], $_SESSION['codigocarreranotascorte'], $_SESSION['codigomodalidadacademicanotascorte'], $_SESSION['codigoperiododnotascorte'], $objetobase, 0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
$motor = new matriz($cantidadestmparray, "ESTADISTICAS ALUMNOS X MATERIA ", "listadonotascortes.php?codigomateria=" . $_SESSION['codigomateria'] . "&codigocarrera=" . $_SESSION['codigocarrera'] . "&codigocarrerad=" . $_SESSION['codigocarrerad'] . "&codigoperiodo=" . $_SESSION['codigoperiodo'], 'si', 'si', 'menuasignacionsalones.php', 'listado_general.php', true, "si", "../../../");


//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");
//$tabla = new matriz($array_sumado,"Listado asignación de salones $codigoperiodo",'listado_general.php','si','si','menuasignacionsalones.php','listado_general.php',false,"si","../../../../");//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('Total_Estudiantes', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=0", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte1', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=1", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte2', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=2", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte3', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=3", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Corte4', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=4", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Perdieron_Definitiva', 'listadonotascorte.php', 'listadodetallenotascortes.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregarllave_drilldown('Total_Grupo', 'listadonotascorte.php', 'listadodetallegruposmaterias.php', '', 'codigomateria', "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", 'codigocarrera', '', '', '', 'onclick= "return ventanaprincipal(this)"');

$motor->agregar_llaves_totales('Total_Estudiantes', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=0", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte1', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=1", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte2', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=2", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte3', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=3", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Corte4', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=4", "", "", "Totales");
$motor->agregar_llaves_totales('Perdieron_Definitiva', "listadonotascorte.php", "listadodetallenotascortes.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", "", "", "Totales");
$motor->agregar_llaves_totales('Total_Grupo', "listadonotascorte.php", "listadodetallegruposmaterias.php", "totales", "&codigomateria=" . $_SESSION['codigomaterianotascorte'] . "&codigocarrera=" . $_SESSION['codigocarreranotascorte'] . "&codigoperiodo=" . $_SESSION['codigoperiododnotascorte'] . "&columna=5", "", "", "Totales");


$tabla->botonRecargar = false;

//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
