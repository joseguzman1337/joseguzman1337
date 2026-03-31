<?php
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
Factory::validateSession($variables);

$entornoPruebas = false;
$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    require_once(PATH_ROOT . '/kint/Kint.class.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $entornoPruebas = true;
}

@session_start();
$link = "../../../../imagenes/estudiantes/";
require('../../estadocredito/funcionesestadocuenta.php');

$cont = 0;
//se adiciona la funcion limpiarInvoice

$codigoestudiante = $_SESSION['codigo'];
$hoy = date('Y-m-d');
//obtiene los datos del estudiante
$row_dataestudiante = datosEstudianteEstadoCuenta($db, $codigoestudiante, $link);

?>
<html>
<head>
    <title>Plan pagos</title>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
    <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    <?php
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
    ?>
</head>
<body>
<table class="table table-responsive" >
    <tr id="trtituloNaranjaInst">
        <td colspan="4" class="text-center">
            Plan de Pagos
        </td>
    </tr>
    <tr id="trtitulogris">
        <td>Documento</td>
        <td colspan="2">Nombre Estudiante</td>
        <td colspan="0" rowspan="6" align="center"><img src="<?php echo $row_dataestudiante['linkimagen']; ?>"
                                                        style="margin-top: 20px" width="120px" ></td>
    </tr>
    <tr>
        <td><div><?php echo $row_dataestudiante['numerodocumento'];?></div></td>
        <td colspan="2"><div><?php echo $row_dataestudiante['nombre'];?></div></td>
    </tr>
    <tr id="trtitulogris">
        <td colspan="1">No. Plan de Estudio</td>
        <td colspan="1">Nombre Del Plan de Estudio</td>
        <td colspan="1">Semestre</td>
    </tr>
    <tr>
        <td colspan="1"><?php echo $row_dataestudiante['idplan'];?></td>
        <td colspan="1"><?php echo $row_dataestudiante['nombreplan'];?></td>
        <td colspan="1"><?php echo $row_dataestudiante['semestre'];?></td>
    </tr>
    <tr id="trtitulogris">
        <td>Carrera</td>
        <td colspan="1">Situación</td>
        <td>Fecha</td>
    </tr>
    <tr>
        <td><?php echo $row_dataestudiante['nombrecarrera'];?></td>
        <td><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></td>
        <td><?php echo date("Y-m-d H:i:s");?></td>
    </tr>
</table>

<table class="table table-responsive" >
    <tr id="trtituloNaranjaInst">
        <td colspan="7" class="text-center">
            CUOTAS PENDIENTES
        </td>
    </tr>
    <tr bgcolor="#E9E9E9">
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Tipo documento</span></div>
        </td>
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Número Documento</span></div>
        </td>
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Descripcion Orden</span></div>
        </td>
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Fecha Vencimiento</span></div>
        </td>
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Valor</span></div>
        </td>
        <td>
            <div align="center" class="Estilo12"><span class="Estilo10">Ordenes</span></div>
        </td>
    </tr>
    <?php
    //consulta el historico de documento del estudiante
    $documentos = historicoDocumentos($db, $codigoestudiante);

    $arr = array();
    foreach($documentos as $documento) {
        //consulta las deudas o saldos a favor del documento
        $resultados = cuotasplanpagos($db, $documento);

        //si existe resultados en el array
        if(count($resultados)> 0) {
            $_SESSION['arreglos'] = $resultados;
            foreach ($resultados as $array) {
                $ordenpago = $array['INVOICE_ID'];
                $ordenpago = limpiarInvoice($ordenpago);

                // CONSULTA PARA SEPARAR PLAN DE PAGO POR CARRERA
                $query = "select e.codigoestudiante from ordenpago o, estudiante e " .
                    " where o.codigoestudiante=e.codigoestudiante and numeroordenpago=$ordenpago";
                $row_orden = $db->GetRow($query);

                if ($row_orden['codigoestudiante'] == $_SESSION['codigo']) {
                    $arr[$array['DUE_DT']]['DESCR'] = $arr[$array['DUE_DT']]['DESCR'] . $array['DESCR'] . " - ";
                    $arr[$array['DUE_DT']]['ITEM_AMT'] =
                        $arr[$array['DUE_DT']]['ITEM_AMT'] -
                        $arr[$array['DUE_DT']]['APPLIED_AMT'] +
                        $array['ITEM_AMT'] -
                        $array['APPLIED_AMT'];
                    $numeroorden = limpiarInvoice($array['INVOICE_ID']);
                }
            }//foreach

            // Query para determinar si es la primera cuota del plan de pagos
            $queryPrimeraCuota = "SELECT o.numeroordenpago FROM ordenpago o " .
                "inner join ordenpagoplandepago op on o.numeroordenpago = op.numerorodencoutaplandepagosap ".
                " WHERE o.codigoestudiante = " . $_SESSION['codigo'] . " " .
                " AND o.codigoperiodo = " . $_SESSION['codigoperiodosesion'] . " " .
                " and o.codigoestadoordenpago not in ('20', '21') and o.idprematricula <> 1 and op.codigoestado = 100";
            $cuota = $db->GetAll($queryPrimeraCuota);
            $i = count($cuota);

            $queryModalidadAcademica = "SELECT c.codigomodalidadacademica FROM estudiante e " .
                " INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera " .
                " WHERE e.codigoestudiante = " . $_SESSION['codigo'];
            $row_datamodalidad = $db->GetRow($queryModalidadAcademica);

            if (isset($arr)) {
                foreach ($arr as $clave => $valor) {
                    if ($i <= 1 && ($row_datamodalidad['codigomodalidadacademica'] == "200" ||
                            $row_datamodalidad['codigomodalidadacademica'] == "300")) {
                        $inicial = "&inicial=1";
                    }else{
                        $inicial = "";
                    }

                    echo "<tr>" .
                        "<td align='center'>" . $documento['nombrecortodocumento'] . "</td>" .
                        "<td align='center'>" . $documento['numerodocumento'] . "</td>" .
                        "<td align='center'>" . rtrim($arr[$clave]['DESCR'], ' - ') . "</td>" .
                        "<td align='center'>$clave</td>" .
                        "<td align='right'>" . $arr[$clave]['ITEM_AMT'] . "</td>" ;

                    $deuda= false;
                    $date1 = new DateTime($clave);
                    $date2 = new DateTime($hoy);
                    //comprar las dos fechas y obtenie la diferencia
                    $diff = $date2->diff($date1);

                    //si la diferencia de años es mayor a 0
                    if($diff->y > 0 ){
                        $deuda = true;
                    }else{
                        //si la diferencia de meses es mayor a 6
                        if($diff->m >= 6){
                            $deuda = true;
                        }
                    }

                    //valida si el estudiante esta reportado en covinoc
                    $sqlcovinoc = "select count(*) as 'count' from pazysalvoestudiante p ".
                        " inner join detallepazysalvoestudiante d on p.idpazysalvoestudiante = d.idpazysalvoestudiante ".
                        " inner join estudiante e on e.idestudiantegeneral = p.idestudiantegeneral ".
                        " where e.codigoestudiante = ".$row_orden['codigoestudiante']." and ".
                        " (d.descripciondetallepazysalvoestudiante like '%COVINOC%' or d.descripciondetallepazysalvoestudiante like '%CASTIGO DE CARTERA%') ".
                        " and d.codigotipopazysalvoestudiante = 100";
                    $row_covinoc = $db->GetRow($sqlcovinoc);

                    if(!$deuda && $row_covinoc['count'] == "0"){
                        echo "<td align='center'><a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fecha=$clave$inicial'>Generar Orden Pago</a></td></tr>";
                    }else{
                        //si el usuario es administrador de tecnologia, administrador credito y cartera, tesoreria cajas
                        if($_SESSION['rol'] == 13 || $_SESSION['rol'] == 48 || $_SESSION['rol'] == 4){
                            echo "<td align='center'>Generacion bloqueada // <a href='../../estadocredito/generarorden.php?ordenpago=$numeroorden&fecha=$clave$inicial'>Generar Orden Pago</a></td></tr>";
                        }else {
                            if ($deuda) {
                                echo "<td><strong>Generacion bloqueada<br> FECHA VENCIDA</strong></td></tr>";
                            } else {
                                echo "<td><strong>Generacion bloqueada<br> paz y salvo</strong></td></tr>";
                            }
                        }
                    }
                }//forerach
            } else {
                echo "<tr><td colspan='4'>sin cuotas pendientes</td></tr>";
            }
        }
    }//foreach
    ?>
</table>
<div>
    <p>Si la fecha de la cuota tiene mas de 6 meses o pertenece al año imnediatamente anterior, se mostrará bloqueda.</p>
    <p>Si el estudiante es su paz y salvo esta registrado por castigo de cartera o COVINOC, se mostrará bloqueda.</p>
</div>
<div align="left">
    <input type="button" name="Imprimir" onClick="print()" value="Imprimir" class="btn btn-success">
    <input type="button" name="Regresar" onClick="history.go(-1)" value="Regresar" class="btn btn-success">
</div>