<?php
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden . 'claseordenpago.php');

if(isset($_POST['accion']) && !empty($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'gruposyhorarios':{
            global $db;
            $codigomateria = $_POST['codigomateria'];
            $codigoperiodo = $_POST['periodo'];

            $query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, " .
                " g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, " .
                " g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo " .
                " from grupo g, docente d " .
                " where g.numerodocumento = d.numerodocumento " .
                " and g.codigomateria = $codigomateria and g.codigoperiodo = $codigoperiodo " .
                " and g.codigoestadogrupo = '10'";
            $datosgrupos = $db->GetAll($query_datosgrupos);
            $result['html']="";
                if (count($datosgrupos) > 0) {
                    foreach ($datosgrupos as $row_datosgrupos) {
                        // Selecciona los datos de los horarios
                        $query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, " .
                            " s.codigosalon, d.nombredia,h.idhorario from horario h, dia d, salon s " .
                            " where h.codigodia = d.codigodia and h.codigosalon = s.codigosalon " .
                            " and h.idgrupo = '" . $row_datosgrupos['idgrupo'] . "' order by 1,2,3";
                        $datoshorarios = $db->GetAll($query_datoshorarios);

                        $matriculados =$row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva'];
                        //encabezado
                        $result['html'].= "<table class='table table-bordered' cellpadding='1' cellspacing='0' width='75%'>".
                        "<tr><td id='tdtitulogris'>Grupo</td><td>".$row_datosgrupos['idgrupo']."</td>".
                        "<td id='tdtitulogris'>Docente</td><td>".$row_datosgrupos['nombre']."</td>".
                        "<td id='tdtitulogris'>Nombre Grupo</td><td>".$row_datosgrupos['nombregrupo']."</td>".
                        "<td id='tdtitulogris'>Max. Grupo</td><td>".$row_datosgrupos['maximogrupo']."</td>".
                        "<td id='tdtitulogris'>Matri./Prematri.</td><td>".$matriculados."</td>".
                        "<td><input class='radio' name='grupo' type='radio' id='habilita' value='".$row_datosgrupos['idgrupo']."' onclick='genera(this)'></td>".
                        "</tr>";
                        //detalle
                        $result['html'].="<tr> ".
                        "<td colspan='11'>".
                        " <table class='table table-bordered' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='100%'> ".
                        " <tr>".
                        " <td><strong>Fecha de Inicio</strong></td><td>".$row_datosgrupos['fechainiciogrupo']."</td>".
                        "<td><strong>Fecha de Vencimiento</strong></td><td>".$row_datosgrupos['fechafinalgrupo']."</td>".
                        "</tr>";

                        if (count($datoshorarios) >0) {

                            $result['html'].= "<tr id='trtitulogris'><td>Día</td><td>Hora Inicial</td><td>Hora Final</td> ".
                            "<td>Salón</td> </tr>";

                            foreach ($datoshorarios as $row_datoshorarios) {
                                $result['html'] .= "<tr>".
                                "<td>".$row_datoshorarios['nombredia']."</td>".
                                "<td>".$row_datoshorarios['horainicial']."</td>".
                                "<td>".$row_datoshorarios['horafinal']."</td>".
                                "<td>".$row_datoshorarios['codigosalon']."</td></tr>";
                            }//foreach
                        } else {
                            $result['html'].="<tr>".
                            " <td colspan='11'><label id='labelresaltado'>No se encuentra horario para ".
                            " el grupo.<BR> Este grupo requiere horario, diríjase a su facultad para informarlo. ".
                            "</label></td> </tr>";
                        }

                        $result['html'].= "</table></td></tr></table>";
                        $result['val'] = true;
                    }//foreach
                } else {
                    $result['html']= "No cuenta con grupos disponibles";
                    $result['val'] = false;
                }
                echo json_encode($result);
            }//case
            break;
        case 'generarorden':{
            global $db;
            $codigoperiodo = $_POST['periodo'];
            $codigogrupo = $_POST['grupo'];

            #query para saber si existe un valor pecuniario vigente para el periodo para cobro de materiales de estudio
            $queryValorMateriales = "select * from valorpecuniario where codigoconcepto = 'C9081' " .
            " and codigoperiodo = '" . $codigoperiodo . "'";
            $valorMateriales = $db->GetRow($queryValorMateriales);

            $query_valor = "SELECT * FROM valoreducacioncontinuada v " .
            " where v.codigocarrera = 341 and now() <= v.fechafinalvaloreducacioncontinuada";
            $row_valor = $db->GetRow($query_valor);
            $valordetallecohorte = $row_valor['preciovaloreducacioncontinuada'];

            $html = "<table class='table table-bordered' cellpadding='1' cellspacing='0'>".
            "<tr id='tdtituloNaranjaInst'>".
            "<td align='center' colspan='4'>Datos para la Generación de la Orden</td>".
            "</tr><tr>".
            "<td colspan='1' align='center' id='tdtitulogris'>Concepto</td>".
            "<td colspan='1' align='center' id='tdtitulogris'>Valor</td> ".
            "<td colspan='1' align='center' id='tdtitulogris'>Estado</td>".
            "</tr><tr>".
            "<td align='center'>Matricula</td><td align='center'>".$valordetallecohorte." ".
            "<input type='hidden' value='".$valordetallecohorte."' name='valor' id='valor'></td><td></td>".
            "</tr><tr>".
            "<td align='center'>Material de idiomas</td>".
            "<td align='center'>";
            if (!empty($valorMateriales)) {
                $html.= $valorMateriales['valorpecuniario'];
            }
            $html.= "</td><td align='center'>";

            if (!empty($valorMateriales)) {
                $html.= "<input type='checkbox' value='Materiales' id='cobroMaterialesIdiomas'
                       name='cobroMaterialesIdiomas'>";
            }//end if
            else {
                $html.= "<img src='../../../../assets/icons/lock.png' style='width: 20px;' ".
                 "title='no existen valores pecuniarios para cobro de material para el periodo seleccionado'>";
            }
            $html.="</td></tr><tr>".
            "<td align='center'>Descuento Beca</td><td align='center'>30%</td>".
            "<td align='center'><input type='checkbox' value='Descuento' id='cobroDescuento' name='cobroDescuento'></td>".
            "</tr><tr>".
            "<td align='center' id='tdtitulogris'>Seleccione la fecha de pago</td>".
            "<td colspan='2' id='tdtitulogris' align='center'>".
            "<input type='date' name='fechapago' id='fechapago' ";
            if (isset($_POST['fechapago']) && !empty($_POST['fechapago'])) {
                $html.= "value='".$_POST['fechapago']."'";
            }
            $html.= "></td></tr><tr>".
            " <td colspan='3' align='center'><input type='hidden' name='valordetallecohorte' value='".$valordetallecohorte."' >".
            " <input type='hidden' id='accion' name='accion' value='crearordeningles'>".
            " <button type='button' class='btn btn-fill-green-XL' onclick='crearorden()'>Generar Orden</button></td></tr></table></div>";
            echo $html;
        }
        break;
        case 'crearordeningles':{

            global $db;

            $fechapago = $_POST['fechapago'];
            $codigoperiodo = $_POST['codigoperiodo'];
            $codigoestudiante = $_POST['codigoestudiante'];
            $codigomateria = $_POST['codigomateria'];
            $grupo = $_POST['grupo'];

            if(isset($_POST['observacion']) && !empty($_POST['observacion'])){
                $observacion = $_POST['observacion'];
            }else{
                $observacion = "";
            }

            $conceptos[] = '151';
            if (!isset($_POST['valor']) || empty($_POST['valor'])) {
                $cantidad['151'] = $_POST['valordetallecohorte'];
            } else {
                $cantidad['151'] = $_POST['valor'];
            }

            #Valida que existan el cobro de materiales
            if(isset($_POST['cobroMaterialesIdiomas'])){
                $conceptos[] = 'C9081';
                #query para conocer el valor de material de idiomas
                $queryValorMateriales = "select valorpecuniario from valorpecuniario where codigoconcepto = 'C9081' ".
                    " and codigoperiodo = '".$codigoperiodo."'";
                $valorMateriales = $db->GetRow($queryValorMateriales);
                $cantidad['C9081'] = $valorMateriales['valorpecuniario'];
            }

            #Valida que existan el descuento
            if(isset($_POST['cobroDescuento'])){
                $conceptos[] = 'C9120';
                $queryValorMateriales = "select valorpecuniario from valorpecuniario where codigoconcepto = 'C9120' ".
                    " and codigoperiodo = '".$codigoperiodo."'";
                $valorMateriales = $db->GetRow($queryValorMateriales);
                $cantidad['C9120'] = $valorMateriales['valorpecuniario'];
            }

            //generacion de orden de matricula
            $ordenesxestudiante = new Ordenesestudiante($db, $codigoestudiante, $codigoperiodo);
            $ordennueva = $ordenesxestudiante->generarordenpago_matricula_fechaMaterialIngles($conceptos, $cantidad, $fechapago);

            $query_prematricula = "SELECT idprematricula FROM prematricula ".
                " where codigoestudiante = '$ordennueva->codigoestudiante' and codigoperiodo=$codigoperiodo ".
                " and (codigoestadoprematricula like '1%' or codigoestadoprematricula like '3%')";
            $prematricula = $db->GetRow($query_prematricula);

            if (!isset($prematricula['idprematricula']) || empty($prematricula['idprematricula'])) {
                $query_semestre = "SELECT e.semestre FROM estudiante e ".
                    " where e.codigoestudiante = ".$ordennueva->codigoestudiante;
                $row_ordenpago = $db->GetRow($query_semestre);
                $semestre = $row_ordenpago['semestre'];

                $query_insprematricula = "insert into prematricula (`idprematricula`, `fechaprematricula`, ".
                    " `codigoestudiante`, `codigoperiodo`, `codigoestadoprematricula`, `observacionprematricula`, ".
                    " `semestreprematricula`) ".
                    " values(0, now(), '$codigoestudiante','$codigoperiodo','10','','$semestre')";
                $insprematricula = $db->Execute($query_insprematricula);
                $idprematricula = $db->Insert_ID();

                $query_insdetalleprematricula = "insert into detalleprematricula (`idprematricula`, `codigomateria`, ".
                    " `codigomateriaelectiva`, `codigoestadodetalleprematricula`, `codigotipodetalleprematricula`, ".
                    " `idgrupo`, `numeroordenpago`) ".
                    " values($idprematricula, '" . $codigomateria . "', '0','10','100','".
                    $grupo."','$ordennueva->numeroordenpago')";
                $db->Execute($query_insdetalleprematricula);

                $query_updordenpago = "update ordenpago ".
                    " set idprematricula = '$idprematricula', observacionordenpago = '".$observacion."' ".
                    " where numeroordenpago = $ordennueva->numeroordenpago";
                $updordenpago = $db->Execute($query_updordenpago);
                $result['val'] = true;
            } else {
                $idprematricula = $prematricula['idprematricula'];

                $query_insdetalleprematricula = "insert into detalleprematricula (`idprematricula`, `codigomateria`, ".
                    " `codigomateriaelectiva`, `codigoestadodetalleprematricula`, `codigotipodetalleprematricula`, `idgrupo`, ".
                    " `numeroordenpago`) ".
                    " values($idprematricula, '" . $codigomateria . "', '0','10','100','".$grupo."','$ordennueva->numeroordenpago')";;
                $db->Execute($query_insdetalleprematricula);

                $query_updordenpago = "update ordenpago ".
                    " set idprematricula = '$idprematricula', observacionordenpago = '".$observacion."' ".
                    " where numeroordenpago = '$ordennueva->numeroordenpago'";
                $updordenpago = $db->Execute($query_updordenpago);
                $result['val'] = true;
            }

            $msg= " El proceso se ha ejecutado, por favor verifique que la orden ".$ordennueva->numeroordenpago.
                " se haya generado correctamente";

            $result['msg'] = $msg;
            echo json_encode($result);
            }
        break;
    }//switch
}//if