<?php
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
require_once("../../../funciones/clases/motorv2/motor.php");
function listaEstudiantesPendientes($codigoperiodo,$codigocarrera,$objetobase){

   $query ="select codigoestudiante,sum(materiasfaltantes) materiafaltante,  materiasinscritas totalmaterias,
semestre,numerodocumento,apellidosestudiantegeneral,nombresestudiantegeneral from (
SELECT e.codigoestudiante,count(distinct g.idgrupo) materiasfaltantes,
count(distinct g2.idgrupo) materiasinscritas,e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
        FROM ordenpago o, detalleordenpago d, estudiante e,
carrera c, concepto co, prematricula pr,estudiantegeneral eg,
detalleprematricula dp,detalleprematricula dp2,grupo g,grupo g2
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='".$codigoperiodo."'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='".$codigocarrera."'
        AND o.codigoperiodo='".$codigoperiodo."'
        AND o.codigoestadoordenpago LIKE '4%'
 and eg.idestudiantegeneral=e.idestudiantegeneral
 and pr.idprematricula=dp.idprematricula
 and pr.idprematricula=dp2.idprematricula
 and g2.idgrupo =dp.idgrupo
 and g.idgrupo =dp2.idgrupo
 and g.idgrupo  in (select idgrupo
 from respuestas
 where codigoperiodo='".$codigoperiodo."'
 and codigoestudiante=e.codigoestudiante)
group by e.codigoestudiante
union
SELECT e.codigoestudiante,0 materiasfaltantes,
count(distinct g2.idgrupo) materiasinscritas,e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
        FROM ordenpago o, detalleordenpago d, estudiante e,
carrera c, concepto co, prematricula pr,estudiantegeneral eg,
detalleprematricula dp,detalleprematricula dp2,grupo g,grupo g2
        WHERE o.numeroordenpago=d.numeroordenpago
        AND pr.codigoperiodo='".$codigoperiodo."'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='".$codigocarrera."'
        AND o.codigoperiodo='".$codigoperiodo."'
        AND o.codigoestadoordenpago LIKE '4%'
 and eg.idestudiantegeneral=e.idestudiantegeneral
 and pr.idprematricula=dp.idprematricula
 and pr.idprematricula=dp2.idprematricula
 and g2.idgrupo =dp.idgrupo
 and g.idgrupo =dp2.idgrupo
 and eg.idestudiantegeneral=e.idestudiantegeneral
group by e.codigoestudiante
) tabla1
GROUP by codigoestudiante
order by apellidosestudiantegeneral,nombresestudiantegeneral";
            $resultado=$objetobase->conexion->query($query);
        while($row=$resultado->fetchRow()) {
            $arrayresultado[]=$row;
        }
        return $arrayresultado;
}
?>
<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo 'menulistadoautoevafacultad.php';?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menulistadoautoevafacultad.php';?>";
    }
</script>
<?php
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodo_evafacultad']&&trim($_REQUEST['codigoperiodo'])!='')
    $_SESSION['codigoperiodo_evafacultad']=$_REQUEST['codigoperiodo'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrera_evafacultad']&&trim($_REQUEST['codigocarrera'])!='')
    $_SESSION['codigocarrera_evafacultad']=$_REQUEST['codigocarrera'];


$carrera=$_SESSION['codigocarrera_evafacultad'];

$i=0;

//$listaestudiantes=$objconsultaencuesta->listaEstudiantesEncuesta($_SESSION["codigoperiodo_evafacultad"], $carrera);
$listaestudiantes= listaEstudiantesPendientes($_SESSION["codigoperiodo_evafacultad"], $carrera,$objetobase);
if(isset($listaestudiantes)) {
    foreach($listaestudiantes as $i=>$filalistaestudiantes) {
        $arrayresultado[$i]["Materias_Diligenciadas"]=$filalistaestudiantes["materiafaltante"];
        $arrayresultado[$i]["Materias_Inscritas"]=$filalistaestudiantes["totalmaterias"];
        $arrayresultado[$i]["Semestre"]=$filalistaestudiantes["semestre"];
        $arrayresultado[$i]["Documento"]=$filalistaestudiantes["numerodocumento"];
        $arrayresultado[$i]["Apellidos"]=$filalistaestudiantes["apellidosestudiantegeneral"];
        $arrayresultado[$i]["Nombres"]=$filalistaestudiantes["nombresestudiantegeneral"];
        $i++;
    }
}
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera", "codigocarrera", $carrera);

echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE ESTUDIANTES EN PROCESO DE EVALUACION DOCENTE DEL PROGRAMA ".$datoscarrera["nombrecarrera"]." EN EL PERIODO ".$_SESSION['codigoperiodo_evafacultad']."</h3></td></tr></table>";
$motor = new matriz($arrayresultado,"HISTORIAL LINEA ENFASIS ","listadoestudiantefaltantesevafacultad.php",'si','si','menulistadoautoevafacultad.php','menudesercion.php',false,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
//$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
//$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>