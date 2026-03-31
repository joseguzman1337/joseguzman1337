<!--
* Cambio a la nueva interfaz con librerias de bootstrap
* Vega Gabriel <vegagabriel@unbosque.edu.do>.
* Universidad el Bosque - Dirección de Tecnología.
* Modificado 7 de abril de 2016.
-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../../assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="registraCorreo.js"></script>

    </head>
    <body>
        <div class="container">
        <a title="Ir a la página principal" href="http://www.uelbosque.edu.co">
            <img alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/files/logo.png">
        </a>
        </div>
        <div class="container">
            <div class="row centered-form">
                <div class="panel panel-default" style="margin:20px;">
                    <div class="panel-heading">
                        <h1>Registro de correos </h1>
                    </div>
                    <div class="panel-body form-group">
                        <form id="Capchat" name="Capchat" action="validar.php"  method="post" role="form">
                            <div class="form-group col-xs-12 col-md-12">
                                <input type="hidden" value="registra_correo" name="actionID" id="actionID" />

                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="">Datos solicitante</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="nombres">Nombre:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="nombres" id="nombres" value="" autocomplete="off" placeholder="Ingrese el nombre completo" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="nombres">Apellido:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="" autocomplete="off" placeholder="Ingrese el apellido completo" >
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="correo">Correo a registrar:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="email" class="form-control" name="correo" id="correo" value="" autocomplete="off" placeholder="Ingrese el correo a registrar" >
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="">¿A qui&eacute;n desea contactar?</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Nombre:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="contactar" id="contactar" value="" autocomplete="off" placeholder="Nombre" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Apellido:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="contactarA" id="contactarA" value="" autocomplete="off" placeholder="Apellido" >
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="area">&Aacute;rea a contactar:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="area" id="area" value="" autocomplete="off" placeholder="Ingrese el area a contactar" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Facultad y/o Dependencia:</label>
                                        <input type="text" class="form-control" name="dependencia" id="dependencia" value="" autocomplete="off" placeholder="Ingrese la facultad y/o dependencia" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Motivo de contacto:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="text" class="form-control" name="asunto" id="asunto" value="" autocomplete="off" placeholder="Ingres el motivo de Contacto" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Correo a contactar:<span style="color:red; font-size:9px;"> (*)</span></label>
                                        <input type="email" class="form-control" name="correoelec" id="correoelec" value="" autocomplete="off" placeholder="Ingrese el Correo a contactar" >
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="">Telefono o extension:</label>
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="" autocomplete="off" placeholder="Ingrese el telefono o extension" >
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="">Ingrese el contenido de la imagen<span style="color:red; font-size:9px;"> (*)</span></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <div class="col-xs-12">
                                        <img src="captcha.php"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="col-xs-12">
                                        <input type="text" class="form-control"  name="captcha" id="captcha" maxlength="6" size="6" autocomplete="off" placeholder="" >
                                    </div>
                                </div> 
                                <div class="form-group col-md-12">
                                    &nbsp;
                                </div>    
                                <div class="form-group col-md-12">
                                    <div class="col-xs-4">
                                        <input class="btn btn-fill-green-XL" type="submit"  value="Solicitar registro de correo" id="submitRegistro" name="submitRegistro" onclick="return validar(this);"/>
                                    </div>
                                </div>    
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <p>Vigilada Mineducaci&oacute;n. Personer&iacute;a Jur&iacute;dica otorgada mediante resoluci&oacute;n 11153 del 4 de agosto de 1978.</p>
                    </div>
                </div>
            </div>
        </div>  
        

    </body>
</html>
<!--end-->