<?php
session_start();
include_once(realpath(dirname(__FILE__)) . '/../../../../utilidades/ValidarSesion.php');
include_once(realpath(dirname(__FILE__)) . '/../../../../funciones/funcionip.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

class CambioCargaAcademica {

    //En esta función se definen los estados de las ordenes tanto origen como destino para realizar el traslado de la carga académica.
    public function SaveValidaciones($db, $Data) {

        $Orden_1 = $Data['Orden_1'];
        $Orden_2 = $Data['Orden_2'];
        $in_1 = '(10,11,14)';  //ESTADO ORDEN ORIGEN PARA REALIZAR EL TRASLADO DE LA CARGA
        $in_2 = '(10,11,14,40,41,44)';  //ESTADO ORDEN DESTINO PARA REALIZAR EL TRASLADO DE LA CARGA
        $Orden_1_Existe = $this->ValidacionExisteOrden($db, $Orden_1, $in_1);
        $Orden_2_Existe = $this->ValidacionExisteOrden($db, $Orden_2, $in_2);
        $ExtudianteIgual = $this->ValidaEstudianteOrden($db, $Orden_1, $Orden_2, $in_1, $in_2);
        if ($ExtudianteIgual) {
            if ($Orden_1_Existe == true && $Orden_2_Existe == true) {
                $CargaAcademica = $this->ExisteCargaAcademica($db, $Orden_1, 1);
                if ($CargaAcademica) {                    
                    //como primera medida, se intenta anular la orden antigua
                    //acorde con la respuesta de people, se procede a continuar

                    $_GET['numeroordenpago']=$Orden_1;
                    $_GET['modulo'] = 'cambioCargaAcademica';
            
                    require_once($_SESSION['path_live'].'consulta/interfacespeople/ordenesdepago/anularordenespagosala.php');
                
                    if($result['ERRNUM']!=0){

                        $msj = "La orden numero ".$_GET['numeroordenpago']." no pudo ser anulada. 
                        Por favor tome nota de este numero y contactese con la universidad para recibir ayuda en este proceso.";

                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = $msj;
                    echo json_encode($a_vectt);
                    exit;    
                    }

                    $this->TrasladarPrematricula($db, $Orden_1, $Orden_2);
                    $this->TrasladarCargaAcademica($db, $Orden_1, $Orden_2);
                    $a_vectt['val'] = true;
                    $a_vectt['descrip'] = 'Traslado de la Carga Academica se Realizado de Forma Correcta';
                    echo json_encode($a_vectt);
                    exit;
                } else {
                    $a_vectt['val'] = false;
                    $a_vectt['descrip'] = 'Traslado de carga academica no realizado No se encontraron materias prematriculadas...';
                    echo json_encode($a_vectt);
                    exit;
                }
            }
        }
    }

    //Esta función valida si la orden esta en uno de los estados de la variable de ingreso $in 
    public function ValidacionExisteOrden($db, $Orden, $in) {
        $SQL = "SELECT numeroordenpago " .
                " FROM ordenpago " .
                " WHERE " .
                " numeroordenpago= " . $db->qstr($Orden) . " " .
                " AND codigoestadoordenpago  IN " . $in . " ";

        if ($ExisteOrdenActiva = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Al Hacer la Validacion de la Orden ...';
            echo json_encode($a_vectt);
            exit;
        }

        if (!$ExisteOrdenActiva->EOF) {
            return true;
        } else {
            return false;
        }
    }

    //Valida si existe carga académica de acuerdo a los estados de la variable de ingreso $Orden.
    public function ExisteCargaAcademica($db, $Orden, $Op) {
        $SQL = "SELECT " .
                " dp.idgrupo, " .
                " dp.numeroordenpago, " .
                " dp.idprematricula, " .
                " dp.codigomateria, " .
                " dp.codigomateriaelectiva, " .
                " dp.codigotipodetalleprematricula " .
                " FROM " .
                " detalleprematricula dp " .
                " INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula " .
                " WHERE " .
                " dp.numeroordenpago = " . $db->qstr($Orden) . " " .
                " AND dp.codigoestadodetalleprematricula IN (10,20,30) " .
                " AND p.codigoestadoprematricula IN (10,40,41)";

        if ($CargaAcademica = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Al Hacer la Validacion de la Orden ...';
            echo json_encode($a_vectt);
            exit;
        }
        if ($Op == 1) {
            if (!$CargaAcademica->EOF) {
                return true;
            } else {
                return false;
            }
        } else {
            $xxx = $CargaAcademica->GetArray();
            return $xxx;
        }
    }

    //Esta función realiza la consulta la carga académica de acuerdo a los valores de las variables de ingreso $Orden_1 y $Orden_2
    public function TrasladarCargaAcademica($db, $Orden_1, $Orden_2) {
        $SQL = "SELECT op.numeroordenpago, op.codigoestadoordenpago " .
                " FROM  ordenpago op " .
                " WHERE op.numeroordenpago = " . $db->qstr($Orden_2) . " ";

        if ($EstadoNueva = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Error Al Verificar el Estado de la Orden 2...';
            echo json_encode($a_vectt);
            exit;
        }

        if (!$EstadoNueva->EOF) {

            $CargaAcademica = $this->ExisteCargaAcademica($db, $Orden_1, 2);

            if ($EstadoNueva->fields['codigoestadoordenpago'] == 10 || $EstadoNueva->fields['codigoestadoordenpago'] == 11 || $EstadoNueva->fields['codigoestadoordenpago'] == 14) {
                // Si el estado es 10,11 o 14 la carga académica solo se traslada y no se cambia el estado y sigue en 10.
                $this->Cambio($db, $CargaAcademica, $Orden_2, 10, 10);
            } else if ($EstadoNueva->fields['codigoestadoordenpago'] == 40 || $EstadoNueva->fields['codigoestadoordenpago'] == 41 || $EstadoNueva->fields['codigoestadoordenpago'] == 44) {
                // Si el estado es 40,41 ó 44 la orden esta paga y la carga pasa a estado matriculada 40.
                $this->Cambio($db, $CargaAcademica, $Orden_2, 30, 40);
            }
            // Cambio de estado a anulada 20 la orden Origen sin carga académica
            $SQL_InL = "INSERT INTO logordenpago " .
                    " SET fechalogordenpago = " . $db->qstr(date("Y-m-d H:i:s")) . " " .
                    " ,idusuario = " . $db->qstr($_SESSION['idusuario']) . " " .
                    " ,ip = " . $db->qstr(tomarip()) . " ";
            $SQL_InLO1 = " ,observacionlogordenpago = " . $db->qstr("ANULACION - TRASLADO DE CARGA ACADEMICA A LA ORDEN ".$Orden_2)
                    ." ,numeroordenpago = " . $db->qstr($Orden_1) . " ";
            $SQL_InLO2 = " ,observacionlogordenpago = " .$db->qstr("RECEPCION - DE CARGA ACADEMICA DE LA ORDEN ".$Orden_1)
                    ." ,numeroordenpago = " . $db->qstr($Orden_2) . " ";
            
            $insertLogordenPago1=$SQL_InL.$SQL_InLO1;
            if ($AnularOrdenl1 = &$db->Execute($insertLogordenPago1) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Insertar registro de la Orden 1 en logordenpago';
                echo json_encode($a_vectt);
                exit;
            }
            
            $insertLogordenPago2=$SQL_InL.$SQL_InLO2;
            if ($AnularOrdenl2 = &$db->Execute($insertLogordenPago2) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Insertar registro de la Orden 2 en logordenpago';
                echo json_encode($a_vectt);
                exit;
            }
            
            $SQL_Up = "UPDATE ordenpago " .
                    " SET codigoestadoordenpago = 20 " .
                    " WHERE numeroordenpago = " . $db->qstr($Orden_1) . " ";

            if ($AnularOrden = &$db->Execute($SQL_Up) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Realizar el Anular la Orden 1..';
                echo json_encode($a_vectt);
                exit;
            } else {
                $a_vectt['descrip1'] = 'Traslado de la Carga Academica se Realizado de Forma Correcta';
            }
            echo json_encode($a_vectt);
            exit;
        }
    }

    //Esta 
    public function TrasladarPrematricula($db, $Orden_1, $Orden_2) {
       
        $SQL = "SELECT idprematricula from ordenpago where numeroordenpago  = " . $db->qstr($Orden_1) . ";";

        $result = $db->GetRow($SQL);

        $idPrematricula = $result['idprematricula'];
                
        $newSQL = "UPDATE ordenpago set idprematricula = $idPrematricula where numeroordenpago  =  ". $db->qstr($Orden_2) . ";";

        if ($cambioPrematricula = &$db->Execute($newSQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Error al modificar la prematricula';
            echo json_encode($a_vectt);
            exit;
        }
       
    }

    //Esta fuanción realiza el traslado de la carga académica de acuerdo a los valores de entrada de las variables $CargaAcademica, $Orden, $Estado, $Estadopre     
    public function Cambio($db, $CargaAcademica, $Orden, $Estado, $Estadopre) {
        for ($i = 0; $i < count($CargaAcademica); $i++) {
            $Grupo = $CargaAcademica[$i]['idgrupo'];
            $NumeroOrden = $CargaAcademica[$i]['numeroordenpago'];
            $Prematricula = $CargaAcademica[$i]['idprematricula'];
            $Materia = $CargaAcademica[$i]['codigomateria'];
            $MateriaElectiva = $CargaAcademica[$i]['codigomateriaelectiva'];
            $TipoDetallePrematricula = $CargaAcademica[$i]['codigotipodetalleprematricula'];

            $SQL_Up = "UPDATE detalleprematricula " .
                    " SET numeroordenpago = " . $db->qstr($Orden) . ", " .
                    " codigoestadodetalleprematricula = " . $db->qstr($Estado) . " " .
                    " WHERE " .
                    " numeroordenpago = " . $db->qstr($NumeroOrden) . " " .
                    " AND idgrupo = " . $db->qstr($Grupo) . " " .
                    " AND idprematricula = " . $db->qstr($Prematricula) . " LIMIT 1 ";

            if ($Traslado = &$db->Execute($SQL_Up) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Realizar el Traslado..';
                echo json_encode($a_vectt);
                exit;
            }

            $SQL_UPpre = "UPDATE prematricula " .
                    " SET codigoestadoprematricula = " . $db->qstr($Estadopre) . " " .
                    " WHERE idprematricula = " . $db->qstr($Prematricula) . " ";
            if ($Trasladopre = &$db->Execute($SQL_UPpre) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Realizar el Traslado..';
                echo json_encode($a_vectt);
                exit;
            }

            $SQL_InLopDetPre = "INSERT INTO logdetalleprematricula " .
                    " SET idgrupo = " . $db->qstr($Grupo) . " " .
                    " ,numeroordenpago = " . $db->qstr($Orden) . " " .
                    " ,idprematricula = " . $db->qstr($Prematricula) . " " .
                    " ,codigomateria = " . $db->qstr($Materia) . " " .
                    " ,codigomateriaelectiva = " . $db->qstr($MateriaElectiva) . " " .
                    " ,codigoestadodetalleprematricula = " . $db->qstr($Estado) . " " .
                    " ,codigotipodetalleprematricula = " . $db->qstr($TipoDetallePrematricula) . " " .
                    " ,fechalogfechadetalleprematricula = " . $db->qstr(date("Y-m-d H:i:s")) . " " .
                    " ,usuario = " . $db->qstr($_SESSION['MM_Username']) . " " .
                    " ,ip = " . $db->qstr(tomarip()) . " ";
            if ($InsertLopDetPre = &$db->Execute($SQL_InLopDetPre) === false) {
                $a_vectt['val'] = false;
                $a_vectt['descrip'] = 'Error Al Insertar en logdetalleprematricula..';
                echo json_encode($a_vectt);
                exit;
            }
        }
    }

    //Esta función valida la orden del estudiante de acuerdo a los valores de entrada de las variables $Orden_1 y $in
    public function ValidaEstudianteOrden($db, $Orden_1, $Orden_2, $in, $in_2) {

        $SQL = " SELECT codigoestadoordenpago, numeroordenpago, codigoestudiante, codigoperiodo " .
                " FROM " .
                " ordenpago " .
                " WHERE " .
                " numeroordenpago = " . $db->qstr($Orden_1) . " " .
                " AND codigoestadoordenpago  IN " . $in . " ";

        if ($OrdenActiva_1 = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Al Hacer la Validacion de la Orden ...';
            echo json_encode($a_vectt);
            exit;
        }

        $SQL = " SELECT codigoestadoordenpago, numeroordenpago, codigoestudiante, codigoperiodo " .
                " FROM " .
                " ordenpago " .
                " WHERE " .
                " numeroordenpago = " . $db->qstr($Orden_2) . " " .
                " AND codigoestadoordenpago  IN " . $in_2 . " ";

        if ($OrdenActiva_2 = &$db->Execute($SQL) === false) {
            $a_vectt['val'] = false;
            $a_vectt['descrip'] = 'Al Hacer la Validacion de la Orden ...';
            echo json_encode($a_vectt);
            exit;
        } else {
            $Regreso = '<div id="regresar">
                    <input type="button" class="btn btn-fill-green-XL" id="regreso" value="Regresar" onclick="Regresar()" />
                    </div>';
            if ($Orden_1 == $Orden_2) {
                $msj = 'Las Ordenes de Pago no pueden ser Iguales...';
            } else
            if ($OrdenActiva_1->fields['codigoestudiante'] != $OrdenActiva_2->fields['codigoestudiante']) {
                $msj = 'Las Ordenes números ' . $Orden_1 . ' y ' . $Orden_2 . ' no pertenecen al mismo estudiante o esta anulada...';
            } else
            if ($OrdenActiva_1->fields['codigoperiodo'] != $OrdenActiva_2->fields['codigoperiodo']) {
                $msj = 'La Orden número ' . $Orden_1 . ' y la ' . $Orden_2 . ' No pertenecen al mismo Periodo...';
            } else {
                return true;
            }
            echo $msj;
            echo $Regreso;
        }
    }

    //Esta función consulta cada una de las ordenes para realizar el traslado de la carga académica
    public function BuscarInfo($db, $Data) {

        $Orden_1 = $Data['Orden_1'];
        $Orden_2 = $Data['Orden_2'];
        $in_1 = '(10,11,14,20,21,40,41,44)';  //ESTADO ORDEN ORIGEN PARA REALIZAR LA CONSULTA DE LA CARGA.
        $in_2 = '(10,11,14,40,41,44)';       //ESTADO ORDEN DESTINO PARA REALIZAR LA CONSULTA DE LA CARGA.
        $Orden_1_Existe = $this->ValidacionExisteOrden($db, $Orden_1, $in_1);
        $Orden_2_Existe = $this->ValidacionExisteOrden($db, $Orden_2, $in_2);
        $ExtudianteIgual = $this->ValidaEstudianteOrden($db, $Orden_1, $Orden_2, $in_1, $in_2);

        if ($ExtudianteIgual) {
            if ($Orden_1_Existe == true && $Orden_2_Existe == true) {
                $this->ViewInfo($db, $Orden_1, $Orden_2);
            } else {
                if ($Orden_1_Existe === false) {
                    $msj = 'La orden Numero...' . $Orden_1 . ' No Existe o esta anulada...';
                }
                if (!$Orden_2_Existe) {
                    $msj = 'La orden Numero...' . $Orden_2 . ' No Existe o esta anulada...';
                }
                if ($Orden_1_Existe == false && $Orden_2_Existe == false || (!$Orden_1_Existe && !$Orden_2_Existe)) {
                    $msj = 'Las ordenes con  Numero...' . $Orden_1 . ' y ' . $Orden_2 . ' No Existen...';
                }

                echo $msj;
            }
        }
    }

    //Esta función muestra en pantalla la carga académica de cada una de las ordenes.
    public function ViewInfo($db, $Orden_1, $Orden_2) {
        $info_orden_1 = $this->DataEstudianteInfo($db, $Orden_1);
        $info_orden_2 = $this->DataEstudianteInfo($db, $Orden_2);
        $CargaAcademica = $this->ExisteCargaAcademica($db, $Orden_1, 2);
        $CargaAcademica2 = $this->ExisteCargaAcademica($db, $Orden_2, 2);
        ?>

        <table style="width: 100%;">
            <tr>
                <td>
                    <fieldset>
                        <legend>Información Orden <strong><?PHP echo $Orden_1 ?></strong></legend>
                        <table  style="width: 100%;text-align: left;">
                            <thead>
                                <tr>
                                    <th>Estudiante:</th>
                                    <th><?PHP echo $info_orden_1[0]['fulname'] ?></th>
                                </tr>
                                <tr>
                                    <th>Programa Académico:</th>
                                    <th><?PHP echo $info_orden_1[0]['fullcarrera'] ?></th>
                                </tr>
                                <tr>
                                    <th>Estado de la Orden:</th>
                                    <th><?PHP echo $info_orden_1[0]['nombreestadoordenpago'] ?></th>
                                </tr>
                                <tr>
                                    <th>Periodo:</th>
                                    <th><?PHP echo $info_orden_1[0]['codigoperiodo'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2"><strong>Carga Académica</strong></td>
                                </tr>
                                <tr>
                                    <td>Num</td>
                                    <td>Grupo</td>
                                    <td>Materia</td>
                                </tr>
                                <?PHP
                                for ($i = 0; $i < count($CargaAcademica); $i++) {
                                    $Datos = $this->DataMateriaGrupo($db, $CargaAcademica[$i]['idgrupo'], $CargaAcademica[$i]['codigomateria']);
                                    ?>
                                    <tr>
                                        <td><?PHP echo $i + 1 ?></td>
                                        <td><?PHP echo $CargaAcademica[$i]['idgrupo'] . '::' . $Datos[0]['nombregrupo'] ?></td>
                                        <td><?PHP echo $CargaAcademica[$i]['codigomateria'] . '::' . $Datos[0]['nombremateria'] ?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                            </tbody>
                        </table>
                    </fieldset>
                </td>
                <td>&nbsp;</td>
                <td>
                    <fieldset align="right">
                        <legend>Información Orden <strong><?PHP echo $Orden_2 ?></strong></legend>
                        <table  style="width: 100%;text-align: left;" >
                            <thead>
                                <tr>
                                    <th>Estudiante:</th>
                                    <th><?PHP echo $info_orden_2[0]['fulname'] ?></th>
                                </tr>
                                <tr>
                                    <th>Programa Académico:</th>
                                    <th><?PHP echo $info_orden_2[0]['fullcarrera'] ?></th>
                                </tr>
                                <tr>
                                    <th>Estado de la Orden:</th>
                                    <th><?PHP echo $info_orden_2[0]['nombreestadoordenpago'] ?></th>
                                </tr>
                                <tr>
                                    <th>Periodo:</th>
                                    <th><?PHP echo $info_orden_2[0]['codigoperiodo'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2"><strong>Carga Académica</strong></td>
                                </tr>
                                <tr>
                                    <td>Num</td>
                                    <td>Grupo</td>
                                    <td>Materia</td>
                                </tr>
                                <?PHP
                                for ($j = 0; $j < count($CargaAcademica2); $j++) {
                                    $Datos = $this->DataMateriaGrupo($db, $CargaAcademica2[$j]['idgrupo'], $CargaAcademica2[$j]['codigomateria']);
                                    ?>
                                    <tr>
                                        <td><?PHP echo $j + 1 ?></td>
                                        <td><?PHP echo $CargaAcademica2[$j]['idgrupo'] . '::' . $Datos[0]['nombregrupo'] ?></td>
                                        <td><?PHP echo $CargaAcademica2[$j]['codigomateria'] . '::' . $Datos[0]['nombremateria'] ?></td>
                                    </tr>
                                    <?PHP
                                }
                                ?>
                            </tbody>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
        <div id="SaveOut">
            <input type="button" class="btn btn-fill-green-XL" id="Save" value="Hacer Traslado de Carga Académica" onclick="CambiarOrdenes()" />
        </div>
        <br>
        <div id="regresar">
            <input type="button" class="btn btn-fill-green-XL" id="regreso" value="Regresar" onclick="Regresar()" />
        </div>                                                                                                                                            
        <?PHP
    }

    //Esta función Lista los datos básicos del estudiante de acuerdo al número de orden de pago.
    public function DataEstudianteInfo($db, $orden) {
        $SQL = " SELECT " .
                " CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS fulname, " .
                " CONCAT(c.codigocarrera,'::',c.nombrecarrera) AS fullcarrera, " .
                " o.codigoestadoordenpago, " .
                " es.nombreestadoordenpago, " .
                " o.codigoperiodo " .
                " FROM " .
                " ordenpago o " .
                " INNER JOIN estudiante e ON e.codigoestudiante=o.codigoestudiante " .
                " INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral " .
                " INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera " .
                " INNER JOIN estadoordenpago es ON es.codigoestadoordenpago = o.codigoestadoordenpago " .
                " WHERE " .
                " numeroordenpago = " . $db->qstr($orden) . " ";

        if ($InforEstudiante = &$db->GetAll($SQL) === false) {
            echo 'Error Falla del Sistema...';
            die;
        }
        return $InforEstudiante;
    }

    //Lista las materias y los grupos de acuerdo a los valores de entrada de la variables $grupo, $materia.
    public function DataMateriaGrupo($db, $grupo, $materia) {
        $SQL = "SELECT g.nombregrupo, m.nombremateria " .
                " FROM " .
                " grupo g " .
                " INNER JOIN materia m ON m.codigomateria = g.codigomateria " .
                " WHERE " .
                " g.idgrupo = " . $db->qstr($grupo) . " " .
                " AND m.codigomateria = " . $db->qstr($materia) . " ";

        if ($Informateria = &$db->GetAll($SQL) === false) {
            echo 'Error Falla del Sistema...';
            die;
        }

        return $Informateria;
    }

}
