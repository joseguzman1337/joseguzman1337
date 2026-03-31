<?php
session_start();
include('../../../../assets/Complementos/piepagina.php');
require_once(realpath(dirname(__FILE__)) . "/../../../Connections/sala2.php");
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)) . "/../../../Connections/salaado.php");

$fechahoy = date("Y-m-d H:i:s");
$cargarCursos = false;
$carreras = "";
$alerta = false;

if ($_REQUEST['Enviar'] != '') {
    if ($_POST['captcha'] != $_SESSION['cap_code']) {
        $alerta = "Verifique que los datos ingresados sean igual a la imagen en pantalla";
    } else {
        $query = "SELECT numerodocumento,idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='" . $_POST['numerodocumento'] . "' AND 
		nombresestudiantegeneral like '%" . $_POST['nombre'] . "%' AND apellidosestudiantegeneral like '%" . $_POST['apellido'] . "%'";
        $estudiante = $db->Execute($query);
        if ($estudiante->_numOfRows == 0) {            
            
            // se verifica si el estudiante existe en Sala Virtual

            // 1. se obtiene la url por enviar

            $protocol = "https";

            if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"
            ||$Configuration->getEntorno()=="Preproduccion")
            {
                $protocol = "http";
            }

            $urlToSend = $protocol."://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."?moduloPublico";

            // 2. cambiar la informacion parametrizada
            $urlToSend = str_replace('artemisa','artemisavirtual',$urlToSend);
            
            // 3. adjuntar la informacion
            $postValues = array(
            'nombre'=>$_POST['nombre'],
            'apellido'=>$_POST['apellido'],
            'numerodocumento'=>$_POST['numerodocumento']
            );
                        
            // 4. Realizar la conexion
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $urlToSend);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postValues);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curl_output = curl_exec ($ch); 

            curl_close ($ch);

            // 5. validar el resultado
            
            if ($curl_output == 'existe') {
                $_SESSION['numerodocumento'] = $_POST['numerodocumento'];
                header("Location: pagoDerechosMatriculaPregrado.php?documentoingreso=");
                die();
            }else{
                $alerta = "Por favor verifique que los datos ingresados sean correctos.";
            }
           
        } else {
            $_SESSION['numerodocumento'] = $_POST['numerodocumento'];
            header("Location: pagoDerechosMatriculaPregrado.php?documentoingreso=");
            die();
        }
    }
    ?>
    <script type="text/javascript">
        alert("<?php echo utf8_decode($alerta); ?>");
    </script>
    <?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <title>Ingreso pago de ordenes</title> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/custom.css">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script> 
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>	
        <script type="text/javascript" src="../../../../assets/js/custom.js"></script>
        <script type="text/javascript">
            function submitform() {
                var mensajevalidacion = '';
                var nombre = $('#nombre').val();
                if (nombre == '') {
                    mensajevalidacion += 'Debe ingresar los nombres \n';
                }
                var apellido = $('#apellido').val();
                if (apellido == '') {
                    mensajevalidacion += 'Debe ingresar los apellidos \n';
                }
                var numerodocumento = $('#numerodocumento').val();
                if (numerodocumento == '') {
                    mensajevalidacion += 'Debe ingresar el numero de documento \n';
                }
                var captcha = $('#captcha').val();
                if (captcha == '') {
                    mensajevalidacion += 'Debe ingresar el contenido de la imagen \n';
                }
                if (mensajevalidacion == '') {
                    $('#form1').submit();
                } else {
                    alert(mensajevalidacion);
                }
            }
        </script>
    </head>
    <body>
        <header id="header" role="banner">
            <div class="header-inner">
                <div class="header_first">
                    <div class="block block-system block-system-branding-block">
                        <div class="block-inner">
                            <div class="title-suffix"></div>
                            <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                                <img alt="Universidad El Bosque" src="../../../../assets/ejemplos/img/logo.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row centered-form">
                <div class="panel-body form-group">
                    <center>
                        <form name="form1" id="form1" action="" method="POST" >
                            <input type="hidden" name="AnularOK" value="">
                            <input type="hidden" name="Enviar" value="1">    
                            <div class="form-group col-xs-12 col-md-12">  
                                <div class="form-group col-md-12">
                                    &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>
                                </div>
                                <div class="form-group col-md-12">
                                    <br>
                                    <h1>CONSULTA ESTUDIANTIL DE ORDENES PENDIENTES</h1>
                                </div>
                                <div class="form-group col-md-12">  
                                    <p>
                                        <strong>
                                            A través de éste medio usted puede realizar el pago de cualquier orden de pago vigente.<br />
                                            Recuerde que su cuenta bancaria debe estar previamente autorizada por su banco para realizar 
                                            pagos por medio de PSE
                                        </strong>
                                    </p>
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="col-xs-14">
                                        <input type="text" value="" id="nombre" name="nombre" class="form-control" size="15" autocomplete="off" placeholder="Ingrese los Nombres">
                                        <br>
                                        <input type="text" value="" id="apellido" name="apellido" class="form-control" size="15" autocomplete="off" placeholder="Ingrese los Apellidos">
                                        <br>
                                        <input type="text" value="" id="numerodocumento" name="numerodocumento" class="form-control" size="15" autocomplete="off" placeholder="Ingrese el Numero de Documento ">
                                    </div>
                                    <div class="col-md-12">
                                        <p><strong><span>Ingrese el contenido de la imagen*</span></strong></p> 
                                    </div>
                                    <div class="col-xs-14 col-md-8">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-4">
                                            <img src="../../../mgi/autoevaluacion/interfaz/phpcaptcha/captcha.php">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" size="6" maxlength="6" id="captcha" name="captcha" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                    <div class="col-xs-14">
                                        <button type="button" onclick="submitform();"  class="btn btn-fill-green-XL" />Consultar Ordenes</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p><strong>Nota: se recomienda usar navegador Mozilla Firefox 38+ o Internet Explorer 10+</strong></p>
                                </div>
                            </div>
                        </form>
                    </center>
                </div>
            </div>
        </div>

    <?php
    $piepagina = new piepagina;
    $ruta='../../../../';
    echo $piepagina->Mostrar($ruta);
    ?>
    </body>
</html>
<!--end-->