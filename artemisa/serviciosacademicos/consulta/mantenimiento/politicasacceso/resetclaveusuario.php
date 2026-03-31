<?php
session_start();
include("../../../../sala/includes/adaptador.php");
include("modelo/resetClaveUsuarioModelo.php");
//require(realpath(dirname(__FILE__) . "../../../../sala/includes/adaptador.php"));
$fechahoy = date("Y-m-d H:i:s");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resetear clave de usuario</title>
    <link rel="stylesheet" href="../../../../sala/assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../../../../sala/assets/css/sweetalert.css" />

</head>
<body>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 col-xs-offset-4">

                <form name="frmResetClave" id="frmResetClave"  method="POST" >
                    <input type="hidden" name="AnularOK" value="">
                    <table class="table table-bordered  table-condensed table-striped">
                        <caption>
                            <h3 class="panel-title" colspan="2">Reestablecer contraseña de usuario</h3>
                        </caption>
                        <tr class="success text-center filPaso2">
                            <td colspan="2">Tipo Usuario</td>
                        </tr>
                        <tr class="text-center filPaso2">
                            <td colspan="2">
                                <select id ="tipoUsuario" name="tipoUsuario" class="required form-control" >
                                    <option value="">Seleccion</option>
                                    <option value="administrativo">Administrativo</option>
                                    <option value="docente">Docente</option>
                                </select>
                                <!--<input type="radio" name="tipoUsuario" id="tpDocente" class="rdTpUsuario" value="docente" required></td>
                                <td><input type="radio" name="tipoUsuario" id="tpAdministrativo" class="rdTpUsuario" value="administrativo" required></td>-->
                        </tr>
                        <tr class="text-center">
                            <td colspan="2" class="success">Usuario:</td>
                        </tr>
                        <tr class="text-center">
                            <td colspan="3"><input type="text" class="required form-control" name="nombreUsuario" id="usuario" autofocus value="" placeholder="nombre usuario" disabled ></td>
                        </tr>
                        <tr class="filPaso2">
                            <td colspan="2">
                                <input type="text" name="emailAdministrativo" id="emailAdministrativo" class="form-control" value="" placeholder="Correo de recuperacion"  disabled>
                            </td>
                        </tr>
                        <tr class="filPaso2">
                            <td colspan="3" class="text-center">
                                <button type="submit" class="btn btn btn-success"  name="Enviar" id="Enviar" value="Enviar" data-bb-example-key="confirm-options" >Enviar</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div id="cargaAjax"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">

            </div>
        </div>
    </div>
</div>
<script src="../../../../sala/assets/js/jquery-3.1.1.js"></script>
<script src="../../../../sala/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/sweetalert.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

<?php

$fecha_actual = date("Y-m-d");
$fechaLimiteCambio = date("Y-m-d",strtotime($fecha_actual."+ 3 days"));

if (isset($_POST['nombreUsuario'])) {
    require_once('../../facultades/creacionestudiante/phpmailer/class.phpmailer.php');
    $tipoUsuario = $_POST["tipoUsuario"];
    $nombreUsuario = $_POST["nombreUsuario"];
    if ($tipoUsuario == 'administrativo'){
        $condicion = "u.codigotipousuario='400'";
    }else if($tipoUsuario == 'docente') {
        $condicion = "c.codigotipoclaveusuario='3' AND u.codigotipousuario='500'";
    }
    
    $mdlUsuario = modeloResetClave::mdlCnsusuario($nombreUsuario, $condicion);// pilas no se valida con el conteo de los intentos de clave

    if (count($mdlUsuario)>0) {
        $nombreUsuarioCompleto = $mdlUsuario['nombres'].' '.$mdlUsuario['apellidos'];
        $idAdministrativoDocente = $mdlUsuario['idadministrativosdocentes'];
        $idClaveUsuario = $mdlUsuario['maxidclaveusuario'];
        $idusuario = $mdlUsuario['idusuario'];
        $psswd = substr(md5(microtime()), 1, 8);

        $encriptPass = hash('sha256', $psswd);
        switch ($tipoUsuario) {
            case 'administrativo':
                $emailAdministrativo= $_POST["emailAdministrativo"];
                $parametros = "fechavenceclaveusuario = '".$fechaLimiteCambio."', codigoestado = '200',codigoindicadorclaveusuario = '400', claveusuario='".$encriptPass."'";
                $update = modeloResetClave::mdlUpdateClaveusuario($idClaveUsuario, $idusuario,$parametros);
                if ($update > 0) {

                    $condicion = "emailadministrativosdocentes='".$emailAdministrativo."'";
                     $updateCorreo=modeloResetClave::mdlActualizaCorreo($idAdministrativoDocente,$condicion);
                    if ($updateCorreo>0){
                        echo "<script>swal('Correo Administrativo Actualizado: ".$nombreUsuario."');</script>";
                    }
                    ## correo
                    $mail = new PHPMailer();
                    $urlSala = $Configuration->getHTTP_SITE();
                    $urlSala .= '/?tmpl=login&option=login';
                    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                            <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta charset="UTF-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <style type="text/css">
                                    @media only screen and (max-width: 500px){
                                        .footer_mailing_UEB{
                                            width: 100%;
                                            margin-bottom: 20px;
                                        }
                                        .columna{
                                            width:100% !important;
                                            margin: 0 auto 10px !important;
                                            border: none !important;
                                            text-align: center !important;
                                            float: none !important;
                                            align-content: center;
                                        }
                                    }
                                </style>
                            </head>
                            <body>
                            <!-- inicio del contenedor general -->
                            <table cellpadding="30" cellspacing="0" align="center" border="0" width="100%" height="auto" bgcolor="#FAFAFA">
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
                                                                            <td><img src="https://www.unbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/head.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                            
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
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
                                                                    <b>Apreciado(a): <br> '.$nombreUsuarioCompleto.'</b> <br/><br/><br/>
                                                                    En nombre de la Universidad El Bosque, le  informamos que el proceso de reestablecimiento de contraseña fue exitoso, por ende lo invitamos a continuar con el proceso realizando los siguientes pasos:<br><br>
                                                                    1) Click en el Enlace, <a href="'.$urlSala.'" target="_blank">Universidad El Bosque</a><br>
                                                                    2) Inicie Sesión con sus datos de autenticación.<br>
                                                                    ---- 2.1) Nombre de usuario: <strong>'.$nombreUsuario.'</strong><br>
                                                                    ---- 2.2) Contraseña: <strong>'.$psswd.'</strong><br>
                                                                    ---- 2.3) Presione el boton Entrar. <br>
                                                                    3) en la ventana que se desplego por favor seguir los parametros de recuperacion.<br>
                                                                    4) En el campo <strong>(Digite clave Antigua)</strong> debe digitar la siguiente clave: <strong>'.$psswd.'</strong><br>
                                                                    5) en los campos <strong>(Digite clave y Confirme clave)</strong> ingresa su nueva contraseña segura.<br>
                                                                    6) Presione Boton Enviar.<br>
                                                                    7) Ingrese a sala y diligencie sus datos actualizados.
                                                                     <br> <br> 
                                                                   <strong><p style="font: 14px/22px Helvetica,  text-align:justify;">Nota: la vigencia de este reestablecimiento de contraseña tiene una duració de 3 Dias, por este motivo es necesario que continue con el proceso de restauración de forma oportuna.</p></strong>
                            
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
                            </table>
                            </body>
                            </html>';
                    $body = utf8_decode($body);
                    $mail->SetFrom('mesadeservicio@unbosque.edu.co', 'Universidad El Bosque');
                    $mail->Subject = "Desbloqueo Clave Usuario Sala";
                    $mail->MsgHTML($body);
                    $mail->AddAddress($emailAdministrativo,$nombreUsuarioCompleto);
                    if (!$mail->Send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }
                    ## correo
                    echo "<script>
                                swal('Contraseña restaurada usuario:".$nombreUsuario.", se envia correo a: ".$emailAdministrativo."');
                          </script>";
                }else{
                    echo "<script>
                                swal('Posiblemente ya se actualizo clave para: ".$nombreUsuario."');
                          </script>";
                }

                break;
            case 'docente':
                $parametros = "fechavenceclaveusuario = now(), codigoestado = '200', codigoindicadorclaveusuario = '500'";
                $update = modeloResetClave::mdlUpdateClaveusuario($idClaveUsuario, $idusuario,$parametros);
                if ($update > 0) {
                    echo "<script>
                                swal('Se restauro la contraseña correctamente: ".$nombreUsuario."');
                          </script>";
                }else {
                    echo "<script>
                                swal('Posiblemente ya se actualizo clave para: ".$nombreUsuario."');
                          </script>";
                }
                break;
            default:
                break;
        }


        // echo " lo realizo";
    }else{
        echo "<script>
                swal('Usuario No encontrado Verificar el perfil de usuario');
              </script>";
        //alerta_javascript("No se encontro usuario " . $_POST['usuario'] . "");
    }



}
?>

