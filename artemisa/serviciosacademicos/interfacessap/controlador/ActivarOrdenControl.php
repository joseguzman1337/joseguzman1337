<?php

class ActivarOrdenControl
{
    public function ctrActivaOrdenPago(){
        require_once('../Connections/sala2.php');
        $msjAlerta = '';
        $numeroordenpago =  $_POST['busqueda_numero'];
        $observacionActivacion = $_POST['busqueda_observacion'];
        $validaorden=ActivarOrdenModelo::mdlOrdenPago($numeroordenpago);
        #si la orden existe en sala
        if (!empty($validaorden)){// si existe la orden anulada
            if ($validaorden[0]['codigoestadoordenpago']!='40' &&
                $validaorden[0]['codigoestadoordenpago']!='41' &&
                $validaorden[0]['codigoestadoordenpago']!='42' &&
                $validaorden[0]['codigoestadoordenpago']!='44' &&
                $validaorden[0]['codigoestadoordenpago']!='10') {
                $numeroordenpago = $validaorden[0]['numeroordenpago'];
                $codigoEstudiante = $validaorden[0]['codigoestudiante'];
                $idPrematricula = $validaorden[0]['idprematricula'];
                $codigoperiodo = $validaorden[0]['codigoperiodo'];
                //activa la orden en sala
                $rta_orden = ActivarOrdenModelo::mdlActivaOrden($numeroordenpago);
                if ($rta_orden){
                    # validacion orden si es concepto matricula
                            $msjAlerta .= '"OK!",';
                            $msjAlerta .= '"La orden número '.$numeroordenpago.'  se  activo en SALA correctamente por favor verificar",';
                            $msjAlerta .= '"success"';
                    // Cada vez que se modifique una orden de pago guardar en logordenpago si existe sesión de usuario
                    if (isset($_SESSION['MM_Username'])) {
                        $cnsUsuario = ActivarOrdenModelo::mdlConsultaUsuario($_SESSION['MM_Username']);
                        if(!empty($cnsUsuario)){
                            $idUsuario = $cnsUsuario["idusuario"];
                        }else{
                            $idUsuario=0;
                        }
                    } else {
                        $idUsuario = 0;
                    }
                    # inserta el log de seguimiento
                    ActivarOrdenModelo::mdlInsertLogOrdenPago($idUsuario,$numeroordenpago,$observacionActivacion);
                    //validacion orden concepto inscripcion o formularios
                    $row_concepto = ActivarOrdenModelo::mdlOrdenInscripcionFormula($numeroordenpago);
                    /* La siguiente variable permite informar a la seccion de envio del xml a people sobre de donde proviene la orden */
                    $_POST['modulo']='activar_ordenes';

                    if (!empty($row_concepto)) {
                        $subirorden = genera_prodiverso($sala, $numeroordenpago, $idgrupo = 1);
                    } else {
                        $subirorden = crea_estudiante($sala, $numeroordenpago, $idgrupo);
                    }
                }else{
                    $msjAlerta .= '"OK!",';
                    $msjAlerta .= '"La orden número '.$numeroordenpago.'  no pudo ser activada",';
                    $msjAlerta .= '"warning"';
                }
            } else if ($validaorden[0]['codigoestadoordenpago']=='40' ||
                       $validaorden[0]['codigoestadoordenpago']=='41' ||
                       $validaorden[0]['codigoestadoordenpago']=='42' ||
                       $validaorden[0]['codigoestadoordenpago']=='44') {
                            $msjAlerta .= '"Alerta!",';
                            $msjAlerta .= '"La orden número '.$numeroordenpago.'  ya estaba paga, por lo tanto no se llevo a cabo ninguna operación",';
                            $msjAlerta .= '"warning"';
           } else if ($validaorden[0]['codigoestadoordenpago'] == '10' ||
                $validaorden[0]['codigoestadoordenpago'] == '11' ||
                $validaorden[0]['codigoestadoordenpago'] == '14' ) {
                        $msjAlerta .= '"Alerta!';
                        $msjAlerta .= '"La orden número '.$numeroordenpago.'  ya ya se encuentra activa",';
                        $msjAlerta .= '"warning"';
            }
        }else{
                        $msjAlerta = '"Informacion!",';
                        $msjAlerta .= '"La orden número '.$numeroordenpago.'  no existe en SALA",';
                        $msjAlerta .= '"info"';
        }
        return $msjAlerta;
    }
}