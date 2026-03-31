<?php
    include('../../assets/Complementos/piepagina.php');
    $rutaado = ("../../serviciosacademicos/funciones/adodb/");
    require_once("../../serviciosacademicos/Connections/salaado-pear.php");
    $lang = "es-es";
    if(isset($_GET["lang"])&&$_GET["lang"]!=""){
        $lang = $_GET["lang"];
    }
    //inicio de la url
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_linkb = explode("/aspirantes", $actual_link);
 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Servicios Académicos</title>
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css"> 
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css"> 
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css"> 
        <link type="text/css" rel="stylesheet" href="../../assets/css/general.css"> 
        <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css"> 
        <link type="text/css" rel="stylesheet" href="../../assets/css/custom.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css?v=1">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap-datetimepicker.min.css?v=1">
        <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script> 
        <script type="text/javascript" src="../../assets/js/bootstrap.js"></script>
        <script src="../../assets/js/moment.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
        <script src="../../assets/js/calendar_format.js?v=1"></script>
        <script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>
       <script src="js/registrarpasouno.js"></script>
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>
        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_SITE; ?>/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">
    </head>
    <body>
        <header id="header" role="banner">
            <div class="header-inner">
                <div class="header_first">
                    <div class="block block-system block-system-branding-block">
                        <div class="block-inner">
                            <div class="title-suffix"></div>
                            <a href="http://www.uelbosque.edu.co/" title="Inicio" rel="home">
                                <img src="../../assets/ejemplos/img/logo.png" width="50%" alt="Inicio">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="close-search"></div>
            </div>
        </header>
        <div class="container">
            <div class="row centered-form">
                <div>
                    <div class="panel-body form-group">
                <br>
                <form role="form" id="inscripcion" name="inscripcion" method="post">
                    <div class="form-group col-xs-12 col-md-12">
                        <div class="form-group col-md-12">
                            &nbsp;
                        </div>
                        <div class="form-group col-md-12">
                            &nbsp;
                        </div>
                        <center>
                        <div class="form-group col-md-12">                                       
                            <h1>Registro Usuario Aspirante Paso Uno</h1>
                        </div>
                        </center>
                        <div class="form-group col-md-12">
                            <h2>Datos Básicos</h2>
                            <input  type="hidden" id="url" name="url" value="<?php echo $actual_linkb[0]; ?>"
                                    class="form-control" autocomplete="off" >
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="col-xs-12 custom-control">
                                    <label for="nombres">Nombres:<span style="color:red;"> (*)</span></label>
                                    <input  type="text" id="nombre" name="nombre" value=""
                                        style="text-transform:uppercase;"
                                        class="form-control" autocomplete="off" placeholder=""
                                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                                        onkeypress="return val_texto(event)">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                    <label for="apellido">Apellidos:<span style="color:red;"> (*)</span></label>
                                    <input  type="text" id="apellido" name="apellido" value=""
                                            style="text-transform:uppercase;"
                                        class="form-control" autocomplete="off" placeholder=""
                                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                                        onkeypress="return val_texto(event)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                    <label for="idpaisnacimiento">País de nacimiento:<span style="color:red;"> (*)</span></label>
                                    <select id="idpaisnacimiento" name="idpaisnacimiento" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php
                                         if($lang=="es-es"){
                                            $selpaisnacimiento="select idpais, nombrepais from pais ".
                                            " where codigoestado like '%1%' order by idpais, nombrepais ";
                                         }
                                        $rowspaisnacimiento = $sala->GetAll($selpaisnacimiento);
                                        $numpn = count($rowspaisnacimiento);
                                        $resultadopn = "";
                                        for ($i = 0; $i < $numpn; $i++){
                                            $resultadopn.= "<option value='".$rowspaisnacimiento[$i]['idpais'].
                                                "|**|".$rowspaisnacimiento[$i]['nombrepais']."'>".
                                                $rowspaisnacimiento[$i]['nombrepais']."</option>";
                                        }
                                        echo $resultadopn;
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                <label for="fechanacimiento">Fecha de nacimiento:<span style="color:red;"> (*)</span></label>
                                <div class="col-xs-12 input-group date form_datetime">
                                    <input  type="text" id="fechanacimiento" name="fechanacimiento" value="" class="form-control" readonly autocomplete="off" placeholder="AAAA-MM-DD" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                <label for="tipodocumento">Tipo de documento:<span style="color:red;"> (*)</span></label>
                                <select id="tipodocumento" name="tipodocumento" class="form-control" onchange="val_tipodocumento(this.value);">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    if($lang=="es-es"){
                                        $seltipodocumento = "select tipodocumento, nombredocumento from documento ".
                                        " where tipodocumento <>'0' and codigoestado like '%1%' order by nombredocumento";
                                    } else {
                                        $seltipodocumento = "SELECT g.tipodocumento, gt.nombredocumento FROM documento g ".
                                        " INNER JOIN documento_traducciones gt ON gt.tipodocumento=g.tipodocumento ".
                                        " AND lenguaje='".$lang."' AND g.codigoestado like '%1%' ".
                                        " order by gt.nombredocumento";
                                    }
                                    $rowsipodocumento = $sala->GetAll($seltipodocumento);
                                    $numtd = count($rowsipodocumento);
                                    $resultadotd = "";
                                    for ($i = 0; $i < $numtd; $i++){
                                        $resultadotd.= "<option value='".$rowsipodocumento[$i]['tipodocumento']."|*||*|".$rowsipodocumento[$i]['nombredocumento']."'>".$rowsipodocumento[$i]['nombredocumento']."</option>";
                                    }
                                    echo $resultadotd;
                                    ?>
                                </select>
                                <input  type="hidden" id="tipodoc" name="tipodoc" value="" class="form-control" autocomplete="off" placeholder="td">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                <label for="documento">Documento:<span style="color:red;"> (*)</span></label>
                                <input  type="text" id="documento" name="documento" value="" class="form-control" autocomplete="off" placeholder="" onkeypress="return val_numero_documento(event)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="codigogenero">Género:<span style="color:red;"> (*)</span></label>
                            <select id="codigogenero" name="codigogenero" class="form-control">
                                <option value="">Seleccione...</option>
                                <?php
                                if($lang=="es-es"){
                                    $selgenero = "select codigogenero, nombregenero  from genero ".
                                    " where 1=1 order by nombregenero  ";
                                } else {
                                    $selgenero = "SELECT g.codigogenero, gt.nombregenero FROM genero g".
                                    " INNER JOIN genero_traducciones gt ON gt.codigogenero=g.codigogenero ".
                                    " AND lenguaje='".$lang."' order by gt.nombregenero";
                                }
                                $rowsgenero = $sala->GetAll($selgenero);
                                $numgen = count($rowsgenero);
                                $resultadogen = "";
                                for ($i = 0; $i < $numgen; $i++){
                                    $resultadogen.= "<option value='".$rowsgenero[$i]['codigogenero'].
                                    "*|**|*".$rowsgenero[$i]['nombregenero']."'>".
                                    $rowsgenero[$i]['nombregenero']."</option>";
                                }
                                echo $resultadogen;
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="telefonoresidencia">Teléfono de residencia:</label>
                            <input  type="text" id="telefonoresidencia" name="telefonoresidencia" value=""
                                    class="form-control" autocomplete="off" placeholder="" onkeypress="return
                                    val_numero(event)">
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="celular">Celular:<span style="color:red;"> (*)</span></label>
                            <input  type="text" id="celular" name="celular" value="" class="form-control"
                                    autocomplete="off" placeholder="" onkeypress="return val_numero(event)">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                                &nbsp;
                            </div>
                        </div>
                        </div>
                     <hr class="col-xs-12">
                        <div class="form-group col-md-12">
                            <h2>Información de su cuenta de usuario</h2>
                        </div>
                        <div class="form-group col-md-12">
                            <h5><em>Por favor verifique que su E-mail este escrito correctamente
                                debido a que no podrá completar su registro si presenta algún error.
                                Recuerde que esta dirección tambien se utilizará para mantenerlo
                                informado durante todo su proceso de inscripción</em>.</h5>
                        </div>
                        <div class="form-group col-md-12">
                            <h5><em><strong>Nota: </strong>Su nombre de usuario es la dirección de correo electrónico que va a ingresar</em>.</h5>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="correo">E-mail:<span style="color:red;"> (*)</span></label>
                            <input  type="email" id="correo" name="correo" value="" class="form-control"
                                    autocomplete="off" placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="confirmacorreo">Confirmar E-mail:<span style="color:red;"> (*)</span></label>
                            <input  type="email" id="confirmacorreo" name="confirmacorreo" value=""
                                    class="form-control" autocomplete="off" placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                        </div>
                        <div class="form-group col-md-12">
                            <h5><em><strong>Recomendación: </strong>La clave debe tener mínimo 6 carácteres</em>.</h5>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="clave">Clave:<span style="color:red;"> (*)</span></label>
                            <input  type="password" id="clave" name="clave" value="" class="form-control"
                                    autocomplete="off" placeholder="">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="col-xs-12">
                            <label for="confirmarclave">Confirmar Clave:<span style="color:red;"> (*)</span></label>
                            <input  type="password" id="confirmarclave" name="confirmarclave" value=""
                                    class="form-control" autocomplete="off" placeholder="">
                            </div>
                        </div>
                        </div>
                        <div class="form-group col-md-12">
                            &nbsp;
                        </div>
                      <div class="row form-group col-md-12">
                            <h5>
                                <em>
                                    <input  type="checkbox" id="politica" name="politica" value="1" class="">&nbsp;
                                    Consiento y autorizo de manera expresa e inequívoca el tratamiento de mis datos personales. Ver términos
                                    <a href="https://www.unbosque.edu.co/sites/default/files/2021-01/Autorizacion-Tratamiento-de-Datos-Personales-Web.pdf" target="_blank">aqui</a>.
                                </em>
                            </h5>
                        </div>

                        <div class="form-group col-md-12" style="display:flex;justify-content:center">
                            <input type="button" id="Enviar" name="Enviar"
                                   value="Enviar" class="btn btn-fill-green-XL">
                        </div>
                </div>
        </form>
                    </div>
                </div>
            </div>
        </div>
		
	<?php	       
        $piepagina = new piepagina; 
        $ruta='../../';
        echo $piepagina->Mostrar($ruta);
    ?>

    <script>
        $(()=>{
                bootbox.confirm({
                    message: "Estimado aspirante: ¿Deseas inscribirte a los programas de Contaduría Pública, Finanzas o Marketing y Transformación Digital modalidad virtual?",
                    buttons: {
                        confirm: {
                            label: 'Sí',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            
                            const url = window.location.href
                            const urlVirtual = url.replace('artemisa','artemisavirtual');
                                                                                    
                            window.location.href = urlVirtual
                        }
                    }
                });
        })
    </script>
    
    </body>
</html>