<?php
#1 Consumo Servicio principal web services trm
use Sala\entidadDAO\TrmHistoricoDAO;

class TrmServices
{

    function __construct(){
    }
    public function getTrmOfTheDay (){
        $service2 ="";
        $fechaActual = date('Y-m-d');
        $dataServices = array();
        $service1 = json_decode(file_get_contents('https://www.datos.gov.co/resource/mcec-87by.json?$limit=1'), true);

        if (!empty($service1)) {

            $dataServices["unidad"]        = $service1[0]["unidad"];
            $dataServices["valor"]         = $service1[0]["valor"];
            $dataServices["vigenciaDesde"] = $service1[0]["vigenciadesde"];
            $dataServices["vigenciaHasta"] = $service1[0]["vigenciahasta"];
            $dataServices["novedadApi"]     = "Api-Superfinanciera";

        }else{
            $service2 = json_decode(file_get_contents('https://www.datos.gov.co/resource/ceyp-9c7c.json?vigenciadesde='.$fechaActual.'T00:00:00.000'), true);
            if (!empty($service2)){
                $dataServices["unidad"]         = "COP";
                $dataServices["valor"]          = $service2[0]["valor"];
                $dataServices["vigenciaDesde"]  = $service2[0]["vigenciadesde"];
                $dataServices["vigenciaHasta"]  = $service2[0]["vigenciahasta"];
                $dataServices["novedadApi"]= "Api-Superfinanciera-Segunda Opcion";
            }else{
                $instance = TrmServices::reportarTrmDiarioSala();
            }
        }
        return $dataServices;
    }
    //  Funcion encargada de gestionar los datos en sala cuando consulta la trm del dia

    public function reportarTrmDiarioSala(){

        include (realpath(dirname(__FILE__) . "/../../../includes/adaptador.php"));
        require_once ("../../../entidad/TrmHistorico.php");
        require_once ("../../../entidadDAO/TrmHistoricoDAO.php");
        $dataTrmDia =TrmServices::getTrmOfTheDay();// datos trm del dia.
        // la primera validacion manifiesta que el api tiene datos y funciona correctamente
        if (!empty($dataTrmDia)){
            $trmDiaSala = TrmServices::existenciaTrmHistorico($dataTrmDia);
            if (empty($trmDiaSala)) {
                $fechaCreacion = date('Y-m-d H:i:s');
                $novedadApi = "OK-CRON_".$dataTrmDia["novedadApi"];
                $tipoTrm = "Proceso-Automatico";
                $tipoMoneda = 2;// 28/04/2021 este campo se envia quemado para que siempre cree la trm en dolar, puesto que la universidad de momento trabaja con este tipo de moneda
                $unidad = $dataTrmDia["unidad"];
                $valor = $dataTrmDia["valor"];
                $vigenciaDesde = date("Y-m-d H:i:s", strtotime($dataTrmDia["vigenciaDesde"]));
                $vigenciaHasta = date("Y-m-d 23:59:59", strtotime($dataTrmDia["vigenciaHasta"]));
                $dia = TrmServices::obtenerDia($vigenciaDesde);
                $trmHistorico = new TrmHistorico();
                $trmHistorico->setFechaCreacion($fechaCreacion);
                $trmHistorico->setDia($dia);
                $trmHistorico->setNovedad($novedadApi);
                $trmHistorico->setTipoTrm($tipoTrm);
                $trmHistorico->setTipoMoneda($tipoMoneda);
                $trmHistorico->setValorTrm($valor);
                $trmHistorico->setVigenciaDesde($vigenciaDesde);
                $trmHistorico->setVigenciaHasta($vigenciaHasta);
                $trmHistorico->setCodigoEstado(100);
                $trmHistoricoDAO = new TrmHistoricoDAO($trmHistorico);
                $trmHistoricoDAO->setDb();
                return  $trmHistoricoDAO->save();
            }
            return true;
        }else{
            require_once ("ReportMail.php");
            $emailDe = "mesadeservicio@unbosque.edu.co";
            $emailPara = "coordinadortesoreria@unbosque.edu.co";
            $mensajeContenido = '<table cellpadding="30" cellspacing="0" align="center" border="0" width="100%" height="auto" bgcolor="#FAFAFA">
            <tr>
                <td align="center" valign="top">
                    <div style="max-width:600px; margin:0 auto;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff">
                            <tbody>
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                        <tr>
                                            <td>
        
                                                <table align="right" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                    <tr>
                                                        <td><img src="http://www.uelbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/head.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
        
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna">
                                        <tbody>
                                        <tr>
                                            <td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif;">
                                                Bogota, '.date("d-m-Y").'
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </b> <br/><br/>
                                    <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
                                        <tbody>
                                        <tr>
                                            <td align="left" style="color: #3F4826;font: 13px/22px Helvetica, sans-serif; text-align:justify;">
                                                <b>Apreciador(a):</b><br><br><b>Cordinacíon  de Tesorería</b><br/><b>Secretaria de Tesorería</b><br><br/>
                                                En nombre de la Universidad El Bosque, le  informamos que el servicio de <b>TRM</b> en sala se encuentra temporalmente fuera de servicio,
                                                por ende lo invitamos a revisar el historico de la TRM y parametrizar su valor del dia con el componente en sala llamado <b>"Gestion TRM"</b>,
                                                esto con el fin de normalizar el pago electronico el dia de hoy en sala.<br><br>
                                                Pasos a reproducir:<br><br>
                                                1) Si ya inicio sesion en sala presione click en el siguiente enlace:<br>
                                                    <a href=" https://artemisa.unbosque.edu.co/sala/?option=trmHistoricos" target="_blank">Componente de Parametrizacion TRM</a><br>
                                                2) Si no inicio sesión por favor presione click en el siguiente enlace para iniciar sesion:<br>
                                                    <a href="https://artemisa.unbosque.edu.co/sala/?tmpl=login&option=login" target="_blank">Sala Universidad El Bosque</a><br>
                                                3) Inicie Sesión con sus datos de autenticación.<br>
                                                ---- 3.1) Ingrese al Componente <strong>Gestion TRM </strong><br>
                                                ---- 3.2) Presione el boton llamado <b>Nuevo</b><br>
                                                ---- 3.3) Diligencie el formulario segun la <b>TRM del Día</b> <br>
                                                ---- 3.4) Presione el boton <b>Guardar</b><br>
                                                4) Fin del proceso.
                                                 <br> <br>
                                               <strong><p style="font: 14px/22px Helvetica,  text-align:justify;">Nota: Este proceso es de suma importancia y se debe realizar la gestion en su menor brevedad, de lo contrario se presentaran inconvenientes con pagos electronicos en sala.</p></strong>
        
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br> <br> <br>
                                    <table align="center" cellpadding="10" cellspacing="0" border="0" width="87%" class="columna" >
                                        <tr>
                                            <td align="left" style="color: #3F4826;font: 13px/22px Helvetica, sans-serif; text-align:justify;">
                                                <strong>Cordialmente,</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"><p>Mesa de Servicio<br>
                                               Unidad de Servicios IT-Dirección de Tecnología. <br>
                                               Pbx: 6331368 Extensión 1555, mesadeservicio@unbosque.edu.co</p>
                                            </th>
                                        </tr>
        
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>';
            $reportMail = ReportMail::reportarCaidaServicio($mensajeContenido,$emailDe,$emailPara,"coordinadorsisinfo@unbosque.edu.co");
            return false;
        }
    }
    public function existenciaTrmHistorico($arrayTrm){
        $unidad        = $arrayTrm["unidad"];
        $valorTrm      = $arrayTrm["valor"];
        #fecha de inicio y fin del trm
        $vigenciaDesde = date("Y-m-d 00:00:00", strtotime($arrayTrm["vigenciaDesde"]));
        $vigenciaHasta = date("Y-m-d 23:59:59", strtotime($arrayTrm["vigenciaHasta"]));
        $trmHistorico = new TrmHistorico();
        $where = " vigenciatrmdesde >='".$vigenciaDesde."' AND vigenciatrmhasta <='".$vigenciaHasta."' AND codigoestado=100";
        $trmDeldia =  $trmHistorico->getList($where,' idtrmhistorico desc');
        return $trmDeldia;
    }
    public function obtenerDia($fecha){
        $nuemeroDia="";
        $fechats = strtotime($fecha); //pasamos a timestamp
        //el parametro w en la funcion date indica que queremos el dia de la semana
        //lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)){
            case 0:  $nuemeroDia = 7;   break;
            case 1:  $nuemeroDia = 1;   break;
            case 2:  $nuemeroDia = 2;   break;
            case 3:  $nuemeroDia = 3;   break;
            case 4:  $nuemeroDia = 4;   break;
            case 5:  $nuemeroDia = 5;   break;
            case 6:  $nuemeroDia = 6;   break;
        }
        return $nuemeroDia;
    }
}
