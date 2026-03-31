<?php
/** @modified Ivan quintero <quinteroivan@unbosque.edu.co>
 *  @since  mayo 8 del 2019
 *  Ajuste de realpath
 */
session_start();
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../Connections/sala2.php' );
require_once("../../funciones/validacion.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/errores_plandeestudio.php");
require_once("../../funciones/funcionboton.php");

$ruta = "../../funciones/";
$rutaorden = "../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');

mysql_select_db($database_sala, $sala);

function calcular_valorcredito($sala, $valordetallecohorte, $codigoestudiante){
    $valor = 0;

    $query_selplanestudiante= "SELECT p.idplanestudio 
                               FROM planestudioestudiante p, planestudio pe
                               WHERE p.codigoestudiante = '$codigoestudiante' 
                                     AND  p.idplanestudio = pe.idplanestudio 
                                     AND pe.codigoestadoplanestudio like '1%' 
                                     AND p.codigoestadoplanestudioestudiante like '1%'";
    $selplanestudiante=mysql_query($query_selplanestudiante, $sala) or die("$query_selplanestudiante".mysql_error());
    $row_selplanestudiante = mysql_fetch_array($selplanestudiante);
    $idplan = $row_selplanestudiante['idplanestudio'];

    // Ahora con el plan de estudio hallo el numero de creditos del plan de estudios, y hallo el valor por credito
    // del plan de estudio
    $query_selcreditosplan = "SELECT p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, dp.codigomateria, dp.semestredetalleplanestudio, sum(dp.numerocreditosdetalleplanestudio) as creditos 	
                              FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp
                              WHERE p.codigocarrera = c.codigocarrera 
                                    AND  p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre 
                                    AND p.idplanestudio = '$idplan' 
                                    AND p.idplanestudio = dp.idplanestudio 
                                     group by 1";
    $selcreditosplan = mysql_query($query_selcreditosplan, $sala) or die("$query_selcreditosplan".mysql_error());
    $row_selcreditosplan = mysql_fetch_array($selcreditosplan);

    // Multiplico el numero de semestres del plan de estudio por la cohorte mas alta y lo divido por los creditos del plan de estudio
    if($row_selcreditosplan['creditos']>0)
        $valor = $valordetallecohorte*$row_selcreditosplan['cantidadsemestresplanestudio']/$row_selcreditosplan['creditos'];
    return $valor;
}//function calcular_valorcredito

if(isset($_SESSION['cursosvacacionalessesion'])){
    session_unregister("cursosvacacionalessesion");
    unset($_SESSION['cursosvacacionalessesion']);
}

// Si hay dos periodos activos mostrar las ordenes de cada uno por aparte.
$query_selperiodoprevig = "select p.codigoperiodo from periodo p where ".
    "(p.codigoestadoperiodo like '1%' or p.codigoestadoperiodo like '3%') order by 1";
$selperiodoprevig = mysql_query($query_selperiodoprevig, $sala) or die(mysql_error());
$totalRows_selperiodoprevig = mysql_num_rows($selperiodoprevig);
$row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);

if($totalRows_selperiodoprevig == 1){
    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);
    $codigoperiodopre = "";
}else{
    $codigoperiodopre = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiantepre = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodopre);

    $row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);

    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);
}

$esta_enperiodosesion = true;
if($codigoperiodoact == $_SESSION['codigoperiodosesion'] || $codigoperiodopre == $_SESSION['codigoperiodosesion']){
    $esta_enperiodosesion = false;
}else{
    $otrasordenes = new Ordenesestudiante($sala, $_SESSION['codigo'], $_SESSION['codigoperiodosesion']);
}

// Selecciona el periodo activo que halla sido seleccionado por la facultad
$bloquear = false;
$codigoperiodo = $_SESSION['codigoperiodosesion'];
$ffechapago = 1;
$usuarioeditar = "facultad";
$usuario = $_SESSION['MM_Username'];
if(isset($_GET['programausadopor']) & !empty($_GET['programausadopor'])){
    $programausadopor = $_GET['programausadopor'];
}


mysql_select_db($database_sala, $sala);
$query_tipousuario = "SELECT rol.idrol FROM usuariorol rol INNER JOIN UsuarioTipo ut ON ".
    "(ut.UsuarioTipoId = rol.idusuariotipo) INNER JOIN usuario u ON (u.idusuario = ut.UsuarioId)".
    " WHERE u.usuario = '".$usuario."'";

$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);

if(isset($row_orden['numeroordenpago'])){
    $query_valor_pago = "SELECT valorfechaordenpago FROM fechaordenpago WHERE numeroordenpago = ".
        "'" . $row_orden['numeroordenpago'] . "' AND fechaordenpago = '".$fecha_pago."';";
    $resultp = mysql_db_query($database_sala,$query_valor_pago);
    $row_valor_pago = mysql_fetch_array($resultp);
}
//-------------------------------------------------------------------------- FIN PSE
?>
<html lang="es">
<head>
    <title>Estudiante</title>
<!--  Jquery  -->
    <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
    <!--  Space loading indicator  -->
    <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>

    <!--  loading cornerIndicator  -->
    <link href="<?php echo HTTP_SITE; ?>/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">

    <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
    <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Darker+Grotesque&display=swap');
    </style>
    <script>
        function verOrdenes(codigo,periodopre,periodoAc,periodo) {
            Pace.restart();
            <?php
//            hace seguimiento al ajax para visualización de pace.js
            ?>
            Pace.track(function() {
                $.ajax({
                    type: 'POST',
                    url: 'showOrderPayments.php',
                    data:
                        {
                            codest: codigo,
                            periodopre: periodopre,
                            periodoAct: periodoAc,
                            periodo: periodo
                        },
                    beforeSend: function (data) {

                    },
                    success: function (data) {
                        $('#divOrdenes').html(data);
                    }//success,
                }); //ajax
            });
        }
    </script>

</head>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<?php
if(!isset($_SESSION['codigo'])){
    ?>
    <script language="javascript">
        alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
        document.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
    </script>
    <?php
}//if

$sinprematricula = false;
$codigoestudiante = $_SESSION['codigo'];
require_once("../../utilidades/datosEstudiante.php");
$linkimagen = obtenerFotoCodigoEstudiante($sala,$codigoestudiante);
$cuentaconplandeestudio = true;

$query_selplan = "select p.idplanestudio, p.nombreplanestudio from planestudioestudiante pe, ".
    "planestudio p where pe.idplanestudio = p.idplanestudio and pe.codigoestudiante = '$codigoestudiante' ".
    "and pe.codigoestadoplanestudioestudiante like '1%' and p.codigoestadoplanestudio like '1%'";

$selplan = mysql_db_query($database_sala,$query_selplan) or die("$query_selplan");
$totalRows_selplan = mysql_num_rows($selplan);

if($totalRows_selplan != ""){
    $row_selplan=mysql_fetch_array($selplan);
    $idplan = $row_selplan['idplanestudio'];
    $nombreplan = $row_selplan['nombreplanestudio'];
}else{
    $cuentaconplandeestudio = false;
    $idplan = "0";
    $nombreplan = "Sin Asignar";

    // Verifica si la carrera necesita plan de estudio
    $query_datocarreraplan = "select c.codigoindicadorplanestudio ".
        " from carrera c, estudiante e ".
        " where e.codigocarrera = c.codigocarrera ".
        " and e.codigoestudiante = '$codigoestudiante'";
    $datocarreraplan = mysql_db_query($database_sala,$query_datocarreraplan) or die("$query_datocarreraplan".mysql_error());
    $totalRows_datocarreraplan = mysql_num_rows($datocarreraplan);
    $row_datocarreraplan = mysql_fetch_array($datocarreraplan);

    // Mira si la carrera requiere o no requiere plan de estudio
    if(preg_match("/^1.+$/",$row_datocarreraplan['codigoindicadorplanestudio'])){
        ?>
        <script language="javascript">
            alert("El estudiante no tiene plan de estudio activo. Debe asignarle un plan de estudio");
        </script>
        <?php
    }
}//else

// Selecciona la cohorte del estudiante
$query_datocohorte = "select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal from cohorte c, ".
    " estudiante e where c.codigocarrera = e.codigocarrera and c.codigoperiodo = '".$codigoperiodo."' and ".
    " e.codigoestudiante = '".$codigoestudiante."' and e.codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
$totalRows_datocohorte = mysql_num_rows($datocohorte);
$row_datocohorte = mysql_fetch_array($datocohorte);
$numerocohorte = $row_datocohorte['numerocohorte'];

$query_iniciales= "select eg.codigogenero, c.codigocarrera, p.idprematricula, c.nombrecarrera, p.semestreprematricula, ".
    " e.codigoestudiante, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.semestre,g.nombregenero, ".
    " det.valordetallecohorte, e.codigotipoestudiante, eg.numerodocumento, e.codigosituacioncarreraestudiante, e.codigocarrera,".
    " eg.idestudiantegeneral, e.codigojornada from prematricula p, estudiante e, carrera c, detallecohorte det, ".
    " cohorte coh, estudiantegeneral eg, genero g where p.codigoestudiante = e.codigoestudiante and ".
    " p.codigoperiodo = '".$codigoperiodo."' and e.codigocarrera = c.codigocarrera  and ".
    "(p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') and ".
    " e.codigoestudiante = '".$codigoestudiante."' and coh.codigocarrera = c.codigocarrera and coh.codigoperiodo = p.codigoperiodo ".
    " and coh.idcohorte = det.idcohorte and det.semestredetallecohorte = p.semestreprematricula AND g.codigogenero=eg.codigogenero ".
    " and coh.numerocohorte = '$numerocohorte' and e.idestudiantegeneral = eg.idestudiantegeneral and coh.codigojornada = e.codigojornada";
$iniciales=mysql_db_query($database_sala,$query_iniciales) or die("$query_iniciales".mysql_error());
$totalRows_oiniciales = mysql_num_rows($iniciales);
$row_iniciales=mysql_fetch_array($iniciales);
$existeinicial = true;
if($totalRows_oiniciales == ""){
    $usarcondetalleprematricula = false;
    // Usar educacion continuada para obtener el valor de la matricula
    $query_iniciales= "SELECT eg.codigogenero, c.codigocarrera, p.idprematricula, c.nombrecarrera, ".
        " p.semestreprematricula, e.codigoestudiante,  concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral)".
        " AS nombre, e.semestre, ve.preciovaloreducacioncontinuada AS valordetallecohorte, e.codigotipoestudiante, ".
        " eg.numerodocumento,g.nombregenero,  e.codigosituacioncarreraestudiante, e.codigocarrera, eg.idestudiantegeneral, ".
        " e.codigojornada 	FROM prematricula p, estudiante e, carrera c, estudiantegeneral eg, valoreducacioncontinuada ve, ".
        " genero g  WHERE p.codigoestudiante = e.codigoestudiante 	AND p.codigoperiodo = '".$codigoperiodo."' ".
        " AND e.codigocarrera = c.codigocarrera AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE  '1%') ".
        " AND e.codigoestudiante = '".$codigoestudiante."' AND e.idestudiantegeneral = eg.idestudiantegeneral AND ".
        " g.codigogenero=eg.codigogenero  AND ve.codigocarrera = e.codigocarrera AND ve.fechafinalvaloreducacioncontinuada > '".date("Y-m-d")."'";
    $iniciales=mysql_db_query($database_sala,$query_iniciales) or die("$query_iniciales".mysql_error());
    $totalRows_oiniciales = mysql_num_rows($iniciales);
    $row_iniciales=mysql_fetch_array($iniciales);
    $existeinicial = false;
    $creditosadicionales = 0;

    if($totalRows_oiniciales == ""){
        $query_iniciales2= "SELECT p.idprematricula, c.nombrecarrera,det.valordetallecohorte, ".
            " IF(p.semestreprematricula='' OR p.semestreprematricula IS NULL, e.semestre, p.semestreprematricula) ".
            " as semestreprematricula,  e.semestre,	e.codigoestudiante, concat(eg.nombresestudiantegeneral,' ".
            "',eg.apellidosestudiantegeneral) AS nombre, e.codigotipoestudiante, eg.numerodocumento, ".
            " e.codigosituacioncarreraestudiante, e.codigocarrera, g.nombregenero,  eg.idestudiantegeneral, ".
            " e.codigojornada  FROM prematricula p, estudiante e, carrera c, cohorte coh, estudiantegeneral eg, ".
            " genero g, detallecohorte det  WHERE p.codigoestudiante = e.codigoestudiante AND ".
            " p.codigoperiodo = '".$codigoperiodo."' AND e.codigocarrera = c.codigocarrera 	AND ".
            " (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') AND ".
            " e.codigoestudiante = '".$codigoestudiante."' AND coh.codigocarrera = c.codigocarrera AND ".
            " coh.codigoperiodo = p.codigoperiodo and coh.numerocohorte = '".$numerocohorte."'  ".
            " AND g.codigogenero=eg.codigogenero  and coh.codigojornada = e.codigojornada and eg.idestudiantegeneral ".
            " = e.idestudiantegeneral  and coh.idcohorte = det.idcohorte  and (det.semestredetallecohorte = p.semestreprematricula ".
            " or det.semestredetallecohorte = e.semestre ) ORDER BY p.semestreprematricula DESC ";
        $iniciales2=mysql_db_query($database_sala,$query_iniciales2);
        $totalRows_oiniciales2 = mysql_num_rows($iniciales2);
        $row_iniciales=mysql_fetch_array($iniciales2);
        $existeinicial = false;
        $creditosadicionales = 0;
    }//if
}else{
    $usarcondetalleprematricula = true;

    $query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, ".
        " d.idplanestudio from detalleplanestudio d, planestudioestudiante p where ".
        " d.idplanestudio = p.idplanestudio and p.codigoestudiante = '".$codigoestudiante."' ".
        " and d.semestredetalleplanestudio = '".$row_iniciales['semestreprematricula']."' and ".
        " p.codigoestadoplanestudioestudiante like '1%' group by 2 ";
    $seltotalcreditossemestre = mysql_db_query($database_sala,$query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
    $totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
    $row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
    $totalcreditossemestre = $row_seltotalcreditossemestre['totalcreditossemestre'];
    $idPlanEnfasis = tieneLineaEnfasis($codigoestudiante);
    #si el estudiante tiene enfasis se debe restar el
    #valor de creditos de la matgeria padre
    if($idPlanEnfasis != false)
    {
        $restarCreditosMateriaPadreEnfasis = materiaPadreEnfasisPlanEstudio($idPlanEnfasis,$row_iniciales['semestreprematricula']);
        $totalcreditossemestre = $totalcreditossemestre - $restarCreditosMateriaPadreEnfasis;
    }

    $query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetallelineaenfasisplanestudio) 
as totalcreditossemestre, d.idplanestudio from detallelineaenfasisplanestudio d, lineaenfasisestudiante l 
where d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio and now() between  l.fechainiciolineaenfasisestudiante 
and l.fechavencimientolineaenfasisestudiante  and l.codigoestudiante = '$codigoestudiante' 
and d.semestredetallelineaenfasisplanestudio = '".$row_iniciales['semestreprematricula']."' 
and d.codigotipomateria not like '4' group by 2 ";
    $seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
    $totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
    $row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
    $totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
    if($totalcreditossemestre2 == ""){
        $query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, 
d.idplanestudio from detalleplanestudio d, planestudioestudiante p where d.idplanestudio = p.idplanestudio 
and p.codigoestudiante = '$codigoestudiante' and d.semestredetalleplanestudio = ".$row_iniciales['semestreprematricula']." 
and d.codigoestadodetalleplanestudio like '1%' and d.codigotipomateria like '5%' 
and p.codigoestadoplanestudioestudiante like '1%' group by 2";
        $seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
        $totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
        $row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
        $totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
    }
    
    if($totalcreditossemestre != "" || $totalcreditossemestre2){
        $totalcreditossemestre = $totalcreditossemestre + $totalcreditossemestre2;
        $valoradicional=($row_iniciales['valordetallecohorte'] / $totalcreditossemestre * ($creditoscalculados -  $totalcreditossemestre));
    }else{
        $totalcreditossemestre = 0;
    }
    if ($valoradicional < 0){
        $valoradicional=0;
    }
    $valoradi=round($valoradicional,0);
    $creditosadicionales = number_format($valoradi,2);
}//else


// El total de creditos se calcula de calculocreditossemestre.php
// Calculo de los creditos del semestre
$codigocarrera = $row_iniciales['codigocarrera'];
$semestredelestudiante = $row_iniciales['semestre'];

require_once('calculocreditossemestre.php');
$valorcreditonormal=calcular_valorcredito($sala, $row_iniciales['valordetallecohorte'], $codigoestudiante);
$valoradicional=$valorcreditonormal* ($creditoscalculados -  $totalcreditossemestre);

if($valoradicional < 0){
    $valoradicional = 0;
}
$valoradi=round($valoradicional,0);

?>
<body >
<table class="table table-bordered" style="font-size: 12px">
    <tr>
        <td id="tdtitulogris">
            <?php
            if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido"){
                $query_estudiante = "SELECT DISTINCT estudiantegeneral.nombresestudiantegeneral, estudiantegeneral.apellidosestudiantegeneral, ".
                    " estudiantedocumento.numerodocumento, carrera.nombrecarrera, estudiante.codigocarrera ".
                    " FROM estudiantedocumento INNER JOIN estudiantegeneral ON (estudiantedocumento.numerodocumento=estudiantegeneral.numerodocumento) ".
                    " INNER JOIN estudiante ON (estudiante.idestudiantegeneral=estudiantegeneral.idestudiantegeneral) ".
                    " INNER JOIN carrera ON (carrera.codigocarrera=estudiante.codigocarrera) ".
                    " INNER JOIN prematricula ON (prematricula.codigoestudiante=estudiante.codigoestudiante) ".
                    " INNER JOIN detalleprematricula ON  (prematricula.idprematricula=detalleprematricula.idprematricula) ".
                    " INNER JOIN ordenpago ON (ordenpago.idprematricula=prematricula.idprematricula) WHERE ".
                    "(estudiante.codigoestudiante = '$codigoestudiante') AND (prematricula.codigoestadoprematricula like '4%') ".
                    " AND (ordenpago.codigoestadoordenpago like '4%')";
                $estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante");
                $totalRows_estudiante = mysql_num_rows($estudiante);
                $row_estudiante = mysql_fetch_assoc($estudiante);

                if ($row_estudiante <> ""){
                    $query_carrera = "SELECT * from evaluacioncarrera where carrera = '".$row_estudiante['codigocarrera']."' ".
                        " AND codigoperiodo = '20102'";
                    $carrera = mysql_query($query_carrera, $sala) or die("$query_estudiante");
                    $totalRows_carrera = mysql_num_rows($carrera);
                    $row_carrera = mysql_fetch_assoc($carrera);
                }//if
            }//if MM_Username

            $paseautoevaluacion="0";
            if(isset($row_estudiante['codigocarrera']) && !empty($row_estudiante['codigocarrera'])){
                switch($row_estudiante['codigocarrera']){
                    case 133:
                        $paseautoevaluacion="1";
                        break;
                    case 134:
                        $paseautoevaluacion="1";
                        break;
                    default:
                        $paseautoevaluacion="0";
                        break;
                }//swicth
            }else{
                $paseautoevaluacion = "0";
            }

            $paseautoevaluacion="0";
            if($paseautoevaluacion){
                echo " <a href='../facultades/validaautoevaluacion.php?codigoestudiante=".$codigoestudiante."'>
 <img src='../../../imagenes/autoevaluacion.jpg' width='20' height='25' alt='Autoevaluacion' style='border-color:#FFFFFF'></a>";
            }
            if($_SESSION['MM_Username'] == "colegio"){
                ?>
                <a href="generarordenescolegio/generarordenescolegio.php">
                    <img src="../../../imagenes/ordenautomaticaindividual.gif" width="20" height="25" alt="Generar Orden Automï¿½tica" style="border-color:#FFFFFF"></a>
                <?php
            }

            // Boton para la generaciï¿½n de la orden automatica
            if($sinprematricula){
                $query_selperiodo = "select p.codigoperiodo, e.nombreestadoperiodo, e.codigoestadoperiodo, p.nombreperiodo ".
                    " from periodo p, estadoperiodo e 	where p.codigoestadoperiodo = e.codigoestadoperiodo and ".
                    " p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' order by 1 desc";
                $selperiodo = mysql_query($query_selperiodo, $sala) or die("<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI."'>");
                $totalRows_selperiodo = mysql_num_rows($selperiodo);
                $row_selperiodo = mysql_fetch_assoc($selperiodo);

                if($row_dataestudiante['codigotipoestudiante'] == '10' && $row_selperiodo['codigoestadoperiodo'] == '1'
                    && $programausadopor == "facultad" && $row_dataestudiante['codigosituacioncarreraestudiante'] == '300'){
                    ?>
                    <!-- <a href="generarordenautomatica/generarprimersemestreindividual.php?estudiante=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/ordenautomaticaindividual.gif" width="30" height="35" alt="Orden de Matricula Automï¿½tica"></a> -->
                    <?php
                }
            }//if 	$sinprematricula

            // Para grados
            if($row_iniciales['codigocarrera'] == ""){
                if(isset($row_dataestudiante['codigocarrera']) && !empty($row_dataestudiante['codigocarrera'])){
                    $valores['codigocarrera'] = $row_dataestudiante['codigocarrera'];
                    $valores['codigogenero'] = $row_dataestudiante['codigogenero'];
                }
            }else{
                $valores['codigocarrera'] = $row_iniciales['codigocarrera'];
                $valores['codigogenero'] = $row_iniciales['codigogenero'];
            }
            $valores['estudiante']=$codigoestudiante;

            // Documentaciï¿½n
            $valores['facultad'] = $_SESSION['codigofacultad'];

            // Documentaciï¿½n y Certificados
            $valores['codigo'] = $codigoestudiante;

            // Mensajes
            $valores['usuarioeditar'] = $usuarioeditar;
            $valores['creditoscalculados'] = $creditoscalculados;

            // Horarios y Prematricula
            if(isset($programausadopor) && !empty($programausadopor)){
                $valores['programausadopor'] = $programausadopor;
            }

            // Consultar Historico
            $valores['tipocertificado'] = "todo";
            $valores['periodos'] = "true";

            // Modificar Historico
            $valores['codigoestudiante'] = $codigoestudiante;

            // Boletin de Calificaciones
            $valores['busqueda_codigo'] = $codigoestudiante;

            // Editar Estudiante
            $valores['usuarioeditar'] = $usuarioeditar;
            $valores['codigocreado'] = $codigoestudiante;

            // Cerrar sesiï¿½n
            $valores['doLogout'] = "true";

            //creacion de botones para el usuario
            if(!isset($HTTP_SERVER_VARS['SCRIPT_NAME']) || empty($HTTP_SERVER_VARS['SCRIPT_NAME'])){
                $HTTP_SERVER_VARS['SCRIPT_NAME'] = $_SERVER['SCRIPT_FILENAME'];
            }

            //botones de perfil de estudiante
            crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala);

            if(isset($programausadopor) && !empty($programausadopor) && $programausadopor == "facultad"){
                ?>
                <!-- <a href="../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=<?php echo "$usuarioeditar&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."";?>"><img src="../../../imagenes/estudiante.gif" width="50" height="50" alt="Estudiante"></a>
                            -->
                <!-- <table bordercolor="#0000FF" border="1" cellspacing="0" width="50" height="50">
                            <tr>
                            <td style="cursor:pointer">
                            <a onClick="<?php echo "window.open('../facultades/mensajesestudiante.php','mensaje','width=800,height=600,top=200,left=150,scrollbars=yes')";?>">
                            <img src="../../../imagenes/Mensajes.gif" width="48" height="48" alt="Mensajes"></a>
                            </td>
                            </tr>
                            </table> -->
                <!-- <a href="../facultades/consultadocumentacionformulario.php?facultad=<?php echo $_SESSION['codigofacultad']."&codigo=".$_SESSION['codigo'];?>"><img src="../../../imagenes/Documentacion.gif" width="50" height="50" alt="Documentaciï¿½n"></a><a href="../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=<?php echo "$usuarioeditar&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."";?>"><img src="../../../imagenes/estudiante.gif" width="50" height="50" alt="Estudiante"></a> -->
                <!-- <a href="../facultades/registromatriculas/registromatriculasformulario.php?usuarioeditar=<?php echo "$usuarioeditar&creditoscalculados=$creditoscalculados";?>"><img src="../../../imagenes/Registro.gif" width="50" height="50" alt="Registro Matricula"></a> -->
                <?php
            }
            ?>
            <!-- <a href="matriculaautomaticahorariosseleccionados.php?programausadopor=<?php echo $programausadopor?>"><img src="../../../imagenes/Horario.gif" width="50" height="50" alt="Horarios"></a> -->
            <?php
            if(isset($programausadopor) && !empty($programausadopor) && $programausadopor != "creditoycartera" && $programausadopor != "estudianterestringido"){
                if(!$bloquear){
                    if ($row_tipousuario['idrol'] == 3){
                        ?>
                        <!--    <a href="matriculaautomatica.php?programausadopor=<?php //echo $_GET['programausadopor']?>"><img src="../../../imagenes/Prematricula.gif" width="50" height="50" alt="Prematricula"></a> -->
                        <?php
                    }
                    ?>
                    <!-- <a href="../facultades/certificados/certificadosformulario.php?tipocertificado=reglamento&periodos=true"><img src="../../../imagenes/Historico.gif" width="50" height="50" alt="Consultar Historico"></a> -->
                    <?php
                }
            }

            if(isset($programausadopor) && !empty($programausadopor) && $programausadopor == "facultad"){
                ?>
                <!-- <a href="../facultades/certificados/certificadosformularioperiodos.php?codigo=<?php //echo $codigoestudiante;?>"><img src="../../../imagenes/certificado.gif" width="50" height="50" alt="Certificados"></a> -->
                <!-- <a href="../facultades/boletines/consultarboletinesformulario.php?busqueda_codigo=<?php //echo $codigoestudiante;?>"><img src="../../../imagenes/Boletin.gif" width="50" height="50" alt="Boletin de Calificaciones"></a> -->
                <?php
                if ($row_tipousuario['idrol'] == 3){
                    ?>
                    <!--       <a href="../facultades/modificahistoricoformulario.php?codigoestudiante=<?php //echo $codigoestudiante;?>"><img src="../../../imagenes/Modificar historico.gif" width="50" height="50" alt="Modificaciï¿½n Historico de Notas"></a>  -->
                    <?php
                }
                ?>
                <!-- <a href="matriculaautomaticabusquedaestudiante.php"><img src="../../../imagenes/terminar.gif" width="50" height="50" alt="Terminar"></a> -->
                <?php
            }
            if(isset($programausadopor) && !empty($programausadopor) && $programausadopor == "creditoycartera"){
                ?>
                <!-- <a href="matriculaautomaticabusquedaestudiante.php"><img src="../../../imagenes/terminar.gif" width="50" height="50" alt="Terminar"></a> -->
                <?php
            }

            if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido"){
                ?>
                <a href="../consultanotasl.php?doLogout=true" id="aparencialinknaranja" target="_top"><img src="../../../imagenes/iconos/salir.gif" width="20" height="25" alt="Cerrar Sesiï¿½n"  style="border-color:#FFFFFF"></a>
                <?php
            }
            ?>
        </td>
    </tr>
</table>
<!--<form name="form1" method="post" action="matriculaautomaticaordenmatricula.php?programausadopor=--><?php //echo $programausadopor;?><!--">-->
    <?php
    if (isset($_POST['terminar']) && !empty($_POST['terminar'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../central.htm'>";
        exit();
    }
    if (isset($_POST['finalizar']) && !empty($_POST['finalizar'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../creditoycartera/accesoprematricula/accesoprematricula.php'>";
        exit();
    }
    if (isset($_POST['horarios']) && !empty($_POST['horarios'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticahorariosseleccionados.php?programausadopor=".$programausadopor."'>";
    }
    if (isset($_POST['modificar']) && !empty($_POST['modificar'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomatica.php?programausadopor=".$programausadopor."'>";
        exit();
    }
    if (isset($_POST['documentacion']) && !empty($_POST['documentacion'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/consultadocumentacionformulario.php?facultad=".$_SESSION['codigofacultad']."'&codigo=".$_SESSION['codigo']."'>";
        exit();
    }
    if (isset($_POST['estudiante']) && !empty($_POST['estudiante'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=".$usuarioeditar."'&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."'>";
        exit();
    }
    if (isset($_POST['registro']) && !empty($_POST['registro'])){
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/registromatriculas/registromatriculasformulario.php?usuarioeditar=".$usuarioeditar."&creditoscalculados=$creditoscalculados'>";
        exit();
    }

    if($totalRows_oiniciales != "" || $totalRows_oiniciales2 != ""){
        ?>
        <!--<a href="../facultades/materiasgrupos/rotaciones/Rotaciones_html.php?actionID=VwRotacionEstudiantes"  title="Rotaciones">Rotaciones</a>-->
        <h3>DATOS GENERALES DE LA MATRICULA </h3>
        <div class="alert alert-info">
            <strong>Info!</strong> <em>“ Te informamos que de acuerdo al Plan de Fomento a la Educación, ponemos a tu disposición la alternativa a través de la cual podrás escoger tu carga académica cancelando únicamente el valor correspondiente al número de créditos adicionales que decidas cursar, siempre y cuando formalices más de media matrícula.

                Debes tener en cuenta que para periodos con número de créditos impares, la mitad se aproximará al número entero superior. ”</em>
        </div>

        <table class="table table-bordered" style="font-size: 12px">
            <tr id="trtituloNaranjaInst">
                <td>Id. General</td>
                <td colspan="3" >Nombre Estudiante</td>
                <td>Documento</td>
                <td>Género</td>
                <td rowspan="6" align="center" style="background-color: #FFFFFF">
                    <img src="<?php echo $linkimagen; ?>" style="margin-top: 20px" width="120px">
                </td>
            </tr>
            <tr>
                <td style=""><?php echo $row_iniciales['idestudiantegeneral'];?></td>
                <td colspan="3"><?php echo $row_iniciales['nombre'];?></td>
                <td><?php echo $row_iniciales['numerodocumento'];?></td>
                <td><?php echo $row_iniciales['nombregenero'];?></td>
            </tr>
            <tr id="trtituloNaranjaInst">
                <td>Id. Estudiante</td>
                <td>No. Prematricula</td>
                <td>No. Plan de Estudio</td>
                <td colspan="3">Nombre Del Plan de Estudio</td>
            </tr>
            <tr>
                <td><?php echo $row_iniciales['codigoestudiante'];?></td>
                <td><?php echo $row_iniciales['idprematricula'];?></td>
                <td><?php echo $idplan;?></td>
                <td colspan="3"><?php echo $nombreplan;?></td>
            </tr>
            <tr id="trtituloNaranjaInst">
                <td colspan="2">Carrera</td>
                <td colspan="2">Cr&eacute;ditos Semestre </td>
                <td colspan="2">Cr&eacute;ditos Seleccionados: <?php echo $creditoscalculados+$numcreditoelectivalibre; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $row_iniciales['nombrecarrera'];?></td>
                <td colspan="2"><?php if($nombreplan == "Sin Asignar"){
                    echo "Sin Asignar";
                }
                   else if($existeinicial){
                        echo $totalcreditossemestre;
                    } else echo "0";?></td>
                <td><?php if($nombreplan == "Sin Asignar"){
                    echo "Sin Asignar";
                } 
                else if($existeinicial){
                    $creditosobligatorios = $creditoscalculados;
                    echo '<b>Obligatorios:</b> '.$creditosobligatorios;
                } else echo "0";?></td>
                <td><?php if($nombreplan == "Sin Asignar"){
                    echo "Sin Asignar";
                } else if($existeinicial){
                    echo '<b>Electivos:</b> '.$numcreditoelectivalibre;
                } else echo "0";?></td>
            </tr>
            <?php
            if($creditosotrajornada != 0){
                $valorcreditootrajornada = calcular_valormatriculaotrajornada($sala, $row_iniciales['codigocarrera'], $codigoperiodo, $row_iniciales['codigojornada']);
                $valorcreditos = $valorcreditootrajornada*$creditosotrajornada;
            }

            if(isset($numcreditoelectivalibre) && !empty($numcreditoelectivalibre)){
                 $creditoscalculados=$creditoscalculados-$numcreditoelectivalibre;
            }
            if(!isset($totalcreditossemestre)){
                $totalcreditossemestre = 0;
            }
            $creditosadicionales=$creditoscalculados-$totalcreditossemestre;
            
            if($creditosadicionales>0){
                $valorcreditoadicional=$valoradi/$creditosadicionales;
            }

            $cobroadicional = number_format(($row_iniciales['valordetallecohorte']/$totalcreditossemestre)*$creditosadicionales);
            if($cobroadicional<0)
                $cobroadicional=0;
            ?>

            <tr id="trtituloNaranjaInst">
                <td>Fecha</td>
                <td>Valor Matricula 100%</td>
                <td>Valor Matricula 50%</td>
                <td colspan="3">Valor Adicional</td>
                <td>Semestre</td>
                
            </tr>
            <tr>
               <td><?php echo date("Y-m-d",time());?></td>
                <td colspan="1"><?php echo "$ ".number_format($row_iniciales['valordetallecohorte']);?></td>
                <td colspan="1"><?php echo "$ ".number_format($row_iniciales['valordetallecohorte']/2);?></td>
                <td colspan="3"><?php echo "$ ".$cobroadicional; ?></td>
                <td><?php echo $row_iniciales['semestreprematricula'];?></td>
               
            </tr>
            <tr id="trtituloNaranjaInst">
                <td colspan="2">Valor Cr&eacute;dito Adicional</td>
                <td colspan="4">Valor Crédito Adicional Otra Jornada</td>
                <td colspan="3">Creditos Otra Jornada</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo "$ ".number_format($row_iniciales['valordetallecohorte']/$totalcreditossemestre);?></td>
                <td colspan="4"><?php echo "$ ".number_format($valorcreditootrajornada); ?></td>
                <td colspan="3"><?php echo "$creditosotrajornada" ?></td>
            </tr>
        </table>
        <br><br>
        <?PHP
    }else{
        $sinprematricula = true;
        $query_dataestudiante = "select c.codigocarrera, c.nombrecarrera, concat(eg.apellidosestudiantegeneral,' ',".
            " eg.nombresestudiantegeneral) as nombre, 	c.codigocarrera, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, ".
            " eg.expedidodocumento, e.codigojornada, e.semestre, e.numerocohorte, e.codigotipoestudiante, t.nombretipoestudiante, ".
            " e.codigosituacioncarreraestudiante, s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, ".
            " eg.emailestudiantegeneral, eg.codigogenero, eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, ".
            " eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, ".
            " eg.ciudadcorrespondenciaestudiantegeneral, e.codigoestudiante, eg.idestudiantegeneral, g.nombregenero  ".
            " from estudiante e, carrera c, tipoestudiante t, situacioncarreraestudiante s, estudiantegeneral eg, genero g  ".
            " where e.codigocarrera = c.codigocarrera and e.codigotipoestudiante =  t.codigotipoestudiante and ".
            " e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante and e.codigoestudiante = '".$codigoestudiante."' ".
            " AND g.codigogenero=eg.codigogenero  and e.idestudiantegeneral = eg.idestudiantegeneral";
        $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
        $totalRows_dataestudiante = mysql_num_rows($dataestudiante);
        $row_dataestudiante = mysql_fetch_assoc($dataestudiante);

        if(preg_match("/^1[0-9]{1}$/",$row_dataestudiante['codigosituacioncarreraestudiante'])
            || preg_match("/^5[0-9]{1}$/",$row_dataestudiante['codigosituacioncarreraestudiante'])){
            $bloquear = true;
        }
        ?>
        <div class="alert alert-info">
            <strong>Info!</strong> <em>“ Te informamos que de acuerdo al Plan de Fomento a la Educación, ponemos a tu disposición la alternativa a través de la cual podrás escoger tu carga académica cancelando únicamente el valor correspondiente al número de créditos adicionales que decidas cursar, siempre y cuando formalices más de media matrícula.

                Debes tener en cuenta que para periodos con número de créditos impares, la mitad se aproximará al número entero superior. ”</em>
        </div>
        <p>DATOS DEL ESTUDIANTE</p>
        <table class="table table-bordered" style="font-size: 12px">
            <tr id="trtituloNaranjaInst">
                <td>Id. General</td>
                <td>Documento</td>
                <td colspan="2">Nombre Estudiante</td>
                <td>Género</td>
                <td colspan="0" rowspan="6" align="center" style="background-color: #FFFFFF">
                    <img src="<?php echo $linkimagen; ?>" style="margin-top: 20px" width="120px">
                </td>
            </tr>
            <tr>
                <td><?php echo $row_dataestudiante['idestudiantegeneral'];?></td>
                <td><?php echo $row_dataestudiante['numerodocumento'];?></td>
                <td colspan="2"><?php echo $row_dataestudiante['nombre'];?></td>
                <td><?php echo $row_dataestudiante['nombregenero'];?></td>
            </tr>
            <tr id="trtituloNaranjaInst">
                <td>Id. Estudiante</td>
                <td colspan="1">No. Plan de Estudio</td>
                <td colspan="2">Nombre Del Plan de Estudio</td>
                <td colspan="1">Semestre</td>
            </tr>
            <tr>
                <td><?php echo $row_dataestudiante['codigoestudiante'];?></td>
                <td colspan="1"><?php echo $idplan;?></td>
                <td colspan="2"><?php echo $nombreplan;?></td>
                <td colspan="1"><?php echo $row_dataestudiante['semestre'];?></td>
            </tr>
            <tr id="trtituloNaranjaInst">
                <td colspan="2">Carrera</td>
                <td colspan="2">Situación</td>
                <td>Tipo</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $row_dataestudiante['nombrecarrera'];?></td>
                <td colspan="2"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></td>
                <td><?php echo $row_dataestudiante['nombretipoestudiante'];?></td>
            </tr>
        </table>
        <br>
        <?php
    }//else
    ?>
    <div class="col-md-12 row">
        <?php

        $queryOrdenesEstudiante = "
        SELECT numeroordenpago
        FROM ordenpago
        where codigoperiodo = ".$_SESSION['codigoperiodosesion']."
          and codigoestudiante = ".$codigoestudiante."
          and (codigoestadoordenpago like '1%' or codigoestadoordenpago like '4%' or codigoestadoordenpago like '6%')
  ";
        $estudianteOrdenes = mysql_query($queryOrdenesEstudiante, $sala) or die(mysql_error(). __FILE__.__LINE__);
        $totalRowsOrdenesEStudiantes = mysql_num_rows($estudianteOrdenes);

        if($totalRowsOrdenesEStudiantes != 0) {
            ?>
            <button class="btn btn-success colorBtn1" onclick="verOrdenes('<?php echo $_SESSION['codigo'] ?>','<?php echo $codigoperiodopre ?>','<?php echo $codigoperiodoact ?>','<?php echo $codigoperiodo ?>')">
                Ver Ordenes de Pago
            </button>
            <?php
        }else
            {?>
                <div class="alert alert-info" role="alert" >
                    <p style="font-size: 17px;font-family: 'Darker Grotesque', sans-serif">
                        El estudiante no posee ordenes
                    </p>
                </div>
        <?php
            }
        ?>
    </div>
    <div class="row col-md-12" id="divOrdenes">

    </div>
    <?php

    ///// FIN ///////
    $query_dataestudiante = "select p.idprematricula FROM prematricula p, detalleprematricula pr  
where p.codigoestudiante = '$codigoestudiante'  AND p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' 
and pr.idprematricula = p.idprematricula AND ( pr.codigomateria IN (16716, 16717) 
OR pr.codigomateriaelectiva IN (16716, 16717) ) AND pr.codigoestadodetalleprematricula IN (30,10)";
    $dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
    $totalRows_dataestudiante = mysql_num_rows($dataestudiante);
    if($totalRows_dataestudiante>0)
    {
        ?>
        <a href="../../mgi/datos/crons/INSTRUCTIVO_MYELT.pdf" style="color: #000099;cursor:pointer;" target="_blank">DESCARGAR INSTRUCTIVO INGLÉS</a><br>
        <?php
    }
    ?>

    <?php
    if(isset($programausadopor) && !empty($programausadopor)){
        if($programausadopor != "creditoycartera" && $programausadopor != "estudianterestringido"){
            if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido"){

                ?>
                <br><a href="../../../libsoap/ayudapse/AyudaPSE.htm" id="aparencialinknaranja">NUEVO SISTEMA DE PAGO PSE</a>
                | <a href="../../mgi/datos/crons/INSTRUCTIVO_MYELT.pdf" id="aparencialinknaranja" target="_blank">DESCARGAR INSTRUCTIVO INGL&Eacute;S</a>
                <?php
            }
            ?>
            <br><strong>AL MODIFICAR LA PREMATRICULA O MATRICULAR ASIGNATURAS,
                <br> SE PUEDE GENERAR UN VALOR ADICIONAL A PAGAR.<br></strong><?php
        }
    }
    ?>
    <br>
    <?php
    if(isset($_POST['ordenautomatica']))
    {
        if($ffechapago)
        {
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../creditoycartera/generacionordenespago/automatriculaestudiante.php?programausadopor=".$programausadopor."&estudiante=".$_SESSION['codigo']."&fechapago=".$fechapago."'>";
        }
    }
    ?>
<!--</form>-->
</body>
</html>
<script language="javascript">
    function terminar()
    {
        window.location.href="matriculaautomaticabusquedaestudiante.php";
    }
</script>

<?php

function tieneLineaEnfasis($codigoEstudiante)
{
    $db = Factory::createDbo();
    $sql = "
            select * from lineaenfasisestudiante where codigoestudiante = '".$codigoEstudiante."'
            and fechavencimientolineaenfasisestudiante > now() limit 1
        ";

    $data = $db->GetRow($sql);
    if(!$data)
    {
        return false;
    }

    return isset($data['idlineaenfasisplanestudio'])?$data['idlineaenfasisplanestudio']:false;
}

function materiaPadreEnfasisPlanEstudio($idPlanEstudiEnfasis, $semestreEstudiante)
{
    $db = Factory::createDbo();
    $sql = "
                select distinct dp.codigomateria, m.numerocreditos from detallelineaenfasisplanestudio dp
                inner join materia m on dp.codigomateria = m.codigomateria
                where dp.idlineaenfasisplanestudio = '".$idPlanEstudiEnfasis."'
                and dp.semestredetallelineaenfasisplanestudio = '".$semestreEstudiante."'
        ";

    $data = $db->GetRow($sql);
    return isset($data['numerocreditos'])?$data['numerocreditos']:0;
}

?>