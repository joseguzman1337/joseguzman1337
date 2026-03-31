<?php
session_start();
ini_set('max_execution_time','6000');
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
        document.location.href="<?php echo 'menulistadocontrolencuesta.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menulistadocontrolencuesta.php'; ?>";
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

function encuentra_array_materias($idencuesta, $tablarespuesta, $objetobase, $imprimir=0) {





$query = "SELECT  c.codigocarrera,c.nombrecarrera,count(distinct r.numerodocumento) Diligenciados
 FROM  encuestapregunta ep," . $tablarespuesta . " r
 left join carrera c on c.codigocarrera = r.codigocarrera
where r.valor" . $tablarespuesta . " <> ''
and r.numerodocumento not in (SELECT r2.numerodocumento FROM
" . $tablarespuesta . " r2, encuestapregunta ep2
where r2.valor" . $tablarespuesta . " = ''
and r2.numerodocumento = r.numerodocumento
and ep2.codigoestado like '1%'
and r2.idencuestapregunta=ep2.idencuestapregunta
and r2.idencuestapregunta not in (
select ep3.idencuestapregunta from encuestapregunta ep3, pregunta p3
where 
p3.idpregunta = ep3.idpregunta
and ep3.idencuestapregunta=r2.idencuestapregunta
and p3.estadoobligatoriopregunta='0'
)
  )
and r.idencuestapregunta = ep.idencuestapregunta
and ep.codigoestado like '1%'
and ep.idencuesta = '" . $idencuesta . "'
group by c.codigocarrera
order by c.nombrecarrera";



    if ($imprimir)
        echo $query;

    $operacion = $objetobase->conexion->query($query);

/*
    $condicion = " and t.codigocarrera=c.codigocarrera group by c.codigocarrera 
        order by c.nombrecarrera";
    $tabla = "(select g.numerodocumento,m.codigocarrera
from grupo g, materia m, carrera c  where
g.codigoperiodo='20111'
and g.codigomateria = m.codigomateria
and g.codigoestadogrupo like '1%'
and g.numerodocumento <> 1
and c.codigocarrera=m.codigocarrera
and c.codigomodalidadacademica like '2%'
and  m.numerocreditos =  (select max(m2.numerocreditos) maxcreditos
from grupo g2, materia m2, carrera c2  where
g2.codigoperiodo='20111'
and c2.codigocarrera=m2.codigocarrera
and c2.codigomodalidadacademica like '2%'
and g2.codigomateria = m2.codigomateria
and g2.numerodocumento=g.numerodocumento)
group by numerodocumento) t, carrera c";
    $rescarrerasdocente = $objetobase->recuperar_resultado_tabla($tabla, "1","1", $condicion, ',count(distinct numerodocumento) cuentadocente', 1);
 * */


   $query=" select c.nombrecarrera,c.codigocarrera, count(distinct e.codigoestudiante)  estudiantes from  ordenpago o, detalleordenpago d, 
estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg
where 
o.numeroordenpago=d.numeroordenpago and eg.idestudiantegeneral=e.idestudiantegeneral AND e.codigoestudiante=pr.codigoestudiante AND pr.codigoperiodo='20112' AND e.codigoestudiante=o.codigoestudiante AND c.codigocarrera=e.codigocarrera AND d.codigoconcepto=co.codigoconcepto AND co.cuentaoperacionprincipal=151 AND o.codigoperiodo='20112' AND o.codigoestadoordenpago LIKE '4%' and c.codigomodalidadacademica in ('300')
group by c.codigocarrera
order by c.nombrecarrera

";

   $i = 0;

    $rescarrerasdocente = $objetobase->conexion->query($query);
    while ($rowresultadodocente = $rescarrerasdocente->fetchRow()) {
        $arrayinicial[$rowresultadodocente["codigocarrera"]] = $rowresultadodocente;
        $array_interno[$i]["codigocarrera"] = $rowresultadodocente["codigocarrera"];
        $array_interno[$i]["nombrecarrera"] = $rowresultadodocente["nombrecarrera"];
        $array_interno[$i]["Diligenciados"] = "0";
       $array_interno[$i]["Estudiantes"] = $rowresultadodocente["estudiantes"];

        $sumamatriculados+=$rowresultadodocente["estudiantes"];
        $i++;
    }

 /*   echo "<pre>";
print_r($array_interno);
echo "</pre>";*/

//$row_operacion=$operacion->fetchRow();
    while ($row_operacion = $operacion->fetchRow()) {


        $codigocarrera = $row_operacion["codigocarrera"];

        $row_operacion["Docentes"] = $datosnombresegresado["cuentadocente"];


        unset($row_operacion["codigocarrera"]);
        $jmal=0;
        for ($j = 0; $j<count($array_interno); $j++) {
            if($array_interno[$j]["nombrecarrera"]==$row_operacion["nombrecarrera"]) {
                $jmal++;
                $array_interno[$j]["Diligenciados"] = $row_operacion["Diligenciados"];
                $sumacuenta+=$row_operacion["Diligenciados"];
            }
        }
        if($jmal==0){
          $array_interno[$j]["nombrecarrera"]=$row_operacion["nombrecarrera"];
          $array_interno[$j]["Diligenciados"]=$row_operacion["Diligenciados"];
  //        $array_interno[$j]["Docentes_aprox"]=0;
              $j++;
        }
        //$row_operacion["Docentes"];

        
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    }
    $row_operacion["codigocarrera"] = "";
    $row_operacion["nombrecarrera"] = "TOTAL";
    $row_operacion["Diligenciados"] = $sumacuenta;
    $row_operacion["Estudiantes"] = $sumamatriculados;
   $array_interno[] = $row_operacion;
    return $array_interno;
}

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');


if (isset($_POST['codigocarrera']) && ($_POST['codigocarrera'] != ''))
    $codigofacultad = "05";



unset($filacarreras);
$_REQUEST['idencuesta'] = 55;
$_REQUEST['tablarespuesta'] = "respuestaestudiantespostgrado";

//echo "<h1>codigomodalidadacademica=".$_REQUEST['codigomodalidadacademica']."</h1>";
if ($_REQUEST['idencuesta'] != $_SESSION['idencuestacontrolencuesta'] && trim($_REQUEST['idencuesta']) != '')
    $_SESSION['idencuestacontrolencuesta'] = $_REQUEST['idencuesta'];
//echo "<h1>_SESSION['codigomodalidadacademicadeserciondetalle']=".$_SESSION['codigomodalidadacademicadeserciondetalle']."</h1>";

if ($_REQUEST['tablarespuesta'] != $_SESSION['tablarespuestacontrolencuesta'] && trim($_REQUEST['tablarespuesta']) != '')
    $_SESSION['tablarespuestacontrolencuesta'] = $_REQUEST['tablarespuesta'];


if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarrerafacultadesmateriadetalle'] && (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarrerafacultadesmateriadetalle'] = $_REQUEST['codigocarrera'];

if ($_REQUEST['codigocarrerad'] != $_SESSION['codigocarreradfacultadesmateriadetalle'] && (trim($_REQUEST['codigocarrerad']) != ''))
    $_SESSION['codigocarreradfacultadesmateriadetalle'] = $_REQUEST['codigocarrerad'];

if ($_REQUEST['codigoperiodo'] != $_SESSION['codigoperiododfacultadesmateriadetalle'] && (trim($_REQUEST['codigoperiodo']) != ''))
    $_SESSION['codigoperiododfacultadesmateriadetalle'] = $_REQUEST['codigoperiodo'];



/* if($_POST['codigocarrera']=="todos"){
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
  //$filacarreras[$_POST['codigocarrera']]="";HISTORIAL
  $arraymaterias=encuentra_array_materias($_POST['codigocarrera'],$_POST['periodo'],$objetobase);
  } */

//$materiastmparray=encuentra_array_materias($codigocarrera,$_POST['codigoperiodo'],$objetobase,0);
$cantidadestmparray = encuentra_array_materias($_SESSION['idencuestacontrolencuesta'], $_SESSION['tablarespuestacontrolencuesta'], $objetobase, 0);
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);

$estudiante = ucwords(strtolower($datosestudiante['nombresestudiantegeneral'] . " " . $datosestudiante['apellidosestudiantegeneral'] . " con  " . $datosestudiante['nombrecortodocumento'] . " " . $datosestudiante['numerodocumento']));
$motor = new matriz($cantidadestmparray, "HISTORIAL LINEA ENFASIS ", "listadocontrolencuesta.php", 'si', 'si', 'listadocontrolencuesta.php', 'listadocontrolencuesta.php', false, "si", "../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idcentrotrabajoarp', 'centrostrabajo.php', 'centrostrabajo.php', '', 'idcentrotrabajoarp', "", '', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos', "", "", "totales", "", "codigomateria", "", "xx", true);
$motor->agregar_llaves_totales('Creditos_Materia', "", "", "totales", "", "codigomateria", "", "xx", true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos', "", "", "totales", "", "codigomateria", "", "xx", true);

$motor->botonRecargar = false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
