<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.

 */


session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<style type="text/css">
    <!--
    #Layer1 {
        position:relative;
        width:400px;
        height:15px;
        z-index:1;
        border-top-color: #00CCFF;
        border-right-color: #00CCFF;
        border-bottom-color: #00CCFF;
        border-left-color: #00CCFF;
        overflow: auto;
        border-collapse:collapse;
        cursor:pointer;


    }
    .textodescripcion{

        font-family: Arial, Helvetica, sans-serif;
        color: #0000FF;
        text-decoration:underline;
    }
    -->
</style>
<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
    }
    var tmpobj,tmptxtobj;
    function ampliarDiv(obj,txtiobj){
        var objtxt=document.getElementById(txtiobj);
        objtxt.style.textDecoration='none'
        objtxt.style.color='#000000';
        if(tmpobj!=null){
            tmpobj.style.width='400px';
            tmpobj.style.height='15px';
        }
        if(tmptxtobj!=null){
            tmptxtobj.style.textDecoration='underline'
            tmptxtobj.style.color='#0000FF';
        }
        obj.style.width='400px';
        obj.style.height='300px';
        tmpobj=obj;
        tmptxtobj=objtxt;
    }
    function reCarga(){
        document.location.href="<?php echo 'menulistadopprocesodisciplinarioxcarrera.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menulistadopprocesodisciplinarioxcarrera.php'; ?>";
    }

</script>
<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena, $longitud) {

    $rescad = "";
    for ($i = 0; $i < $longitud; $i++)
        $rescad .= $cadena[$i];

    return $rescad;
}

function encuentra_array_materias($codigocarrera, $codigoperiodo, $objetobase, $imprimir=0) {


    if ($codigocarrera != "todos")
        $carreradestino = "e.codigocarrera='" . $codigocarrera . "' and ";
    else
        $carreradestino="";


    $query = "select p.idprocesodisciplinario,eg.apellidosestudiantegeneral Apellidos,
eg.nombresestudiantegeneral Nombres,
eg.numerodocumento Documento,
td.nombrecortodocumento TipoDocumento,
c.nombrecarrera Carrera,
p.codigoestudiante,  p.fecharegistroprocesodisciplinario Fecha_Registro,
p.descripcionprocesoadmnistrativoprocesodisciplinario Descripcion,
 ep.nombreestadoprocesodisciplinario Estado,
d.cargodirectivo Directivo,
t.nombretipofaltaprocesodisciplinario Falta, ts.nombretiposancionprocesodisciplinario Sancion,
p.numeroactoadministrativoprocesodisciplinario Numero_Acta, p.fechaactoadministrativoprocesodisciplinario
Fecha_Acto_Administrativo,
p.fechaaperturaprocesodisciplinario Fecha_de_Apertura,p.fechanotificacionsancionprocesodisciplinario Fecha_de_Notificacion,
p.fechanotificacionsancionprocesodisciplinario Fecha_de_Sancion, p.fechacierreprocesodisciplinario Fecha_de_Cierre,
p.direccionipregistroprocesodisciplinario Equipo_de_Ingreso,
u.usuario
from procesodisciplinario p, estadoprocesodisciplinario ep,
directivo d, tipofaltaprocesodisciplinario t, tiposancionprocesodisciplinario ts,
estudiantegeneral eg, estudiante e, usuario u,carrera c,documento td
where
p.codigoestado like '1%' and
p.codigoestadoprocesodisciplinario=ep.codigoestadoprocesodisciplinario and
p.iddirectivoresponsablesancionprocesodisciplinario=d.iddirectivo and
p.idtipofaltaprocesodisciplinario=t.idtipofaltaprocesodisciplinario and
p.idtiposancionprocesodisciplinario=ts.idtiposancionprocesodisciplinario and
p.idestudiantegeneral=eg.idestudiantegeneral and
p.codigoestudiante=e.codigoestudiante and
p.idusuarioregistroprocesodisciplinario=u.idusuario and
c.codigocarrera=e.codigocarrera and
c.codigomodalidadacademica='" . $_SESSION['codigomodalidadaprocesodisciplinario'] . "' and
" . $carreradestino . "
td.tipodocumento=eg.tipodocumento
order by fecharegistroprocesodisciplinario desc
";


    $operacion = $objetobase->conexion->query($query);
    $row_operacion = $operacion->fetchRow();
    do {
        $row_operacion["Descripcion"] = "<div id='Layer1' onclick=ampliarDiv(this,'txt" . $row_operacion['idprocesodisciplinario'] . "');>
        <table width='380px' height='100%' border='0' cellpadding='0' cellspacing='0' >
        <tr><td><div id='txt" . $row_operacion['idprocesodisciplinario'] . "' class='textodescripcion' >" .
                str_replace("\n", "<br>", $row_operacion["Descripcion"]) . "</div></td></tr></table></div>";
        $array_interno[] = $row_operacion;
        //$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
    } while ($row_operacion = $operacion->fetchRow());



    return $array_interno;
}

if (isset($_GET['codigoestudiante']) && ($_GET['codigoestudiante'] != ''))
    $_SESSION['sesion_codigoestudiante'] = $_GET['codigoestudiante'];


if ($_REQUEST['codigomodalidadacademica'] != $_SESSION['codigomodalidadaprocesodisciplinario']
        && trim($_REQUEST['codigomodalidadacademica']) != '')
    $_SESSION['codigomodalidadaprocesodisciplinario'] = $_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomateriafacultadesmateria]=".$_SESSION['codigomateriafacultadesmateria'];
if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarreraprocesodisciplinario'] &&
        (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarreraprocesodisciplinario'] = $_REQUEST['codigocarrera'];


$codigoperiodo = "";

$objetobase = new BaseDeDatosGeneral($sala);

$array_interno = encuentra_array_materias($_SESSION['codigocarreraprocesodisciplinario'], $codigoperiodo, $objetobase, $imprimir = 0);
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);

//unset($_GET['Filtrar']);
$datosestudiante = $objetobase->recuperar_datos_tabla("estudiantegeneral eg, documento d", "idestudiantegeneral", $_GET['idestudiantegeneral'], ' and eg.tipodocumento=d.tipodocumento ', '', 0);
$estudiante = ucwords(strtolower($datosestudiante['nombresestudiantegeneral'] . " " . $datosestudiante['apellidosestudiantegeneral'] . " con  " . $datosestudiante['nombrecortodocumento'] . " " . $datosestudiante['numerodocumento']));
$motor = new matriz($array_interno, "LISTADO PROCESO DISCIPLINARIO  ","listasoprocesodisciplinarioxcarrera.php",'si','si','menulistadopprocesodisciplinarioxcarrera.php','listasoprocesodisciplinarioxcarrera.php',true,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('idprocesodisciplinario', 'procesodisciplinario.php&codigoestudiante=' . $_GET['codigoestudiante'], 'procesodisciplinario.php', '', 'idprocesodisciplinario', "", '', '', '', '', 'onclick= "return ventanaprincipal(this)"');
$motor->botonRecargar = false;

$motor->mostrar();
?>
