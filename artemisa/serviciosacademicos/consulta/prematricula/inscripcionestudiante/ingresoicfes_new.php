<?php
    require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
    Factory::validateSession($variables);

    $pos = strpos($Configuration->getEntorno(), "local");
    if($Configuration->getEntorno()=="local" ||
        $Configuration->getEntorno()=="pruebas" ||
        $Configuration->getEntorno()=="Preproduccion" || $pos!==false){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        require_once(PATH_ROOT.'/kint/Kint.class.php');
    }
    
    include (PATH_ROOT."/serviciosacademicos/consulta/prematricula/inscripcionestudiante/calendario/calendario.php");
    require_once(PATH_ROOT.'/serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionesIngresoIcfesNew.php');
    require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');

    $data = getIdsEstudiante($db, @$_GET['idestudiante'], @$_REQUEST['codigoestudiante'], @$_SESSION['inscripcionsession']);
    $idestudiantegeneral = $data->idestudiantegeneral;
    
    $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
    $ResultadoPruebaEstado->setIdestudiantegeneral($idestudiantegeneral);
    $ResultadoPruebaEstado->getResultadoEsutiante();
    $ACResultadoPruebaEstado = $ResultadoPruebaEstado->getNumeroregistroresultadopruebaestado();
    
    $idinscripcion = $data->idinscripcion;

    $data = getInfoEstudiante($db, $idestudiantegeneral);

    $datosgrabados = $data->datosgrabados;
    $totalRows_datosgrabados = $data->totalRows_datosgrabados;
    $row_datosgrabados = $data->row_datosgrabados;
    if ($row_datosgrabados <> ""){
        if(!isset($_REQUEST['flag']) && empty($_REQUEST['flag'])){
            $_REQUEST['flag'] = "";
        }
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=editaringresoicfes_new.php?inicial&idestudiante=".$idestudiantegeneral."&codigoestudiante=".$_REQUEST['codigoestudiante']."&flag=".$_REQUEST['flag']."'>";
        exit();
    }
    $resultado = getInfoEstudianteCarrera($db, $idestudiantegeneral, $idinscripcion);
    $data = $resultado->data;
    $row_data = $resultado->row_data;

    $resultado = getAsignaturas($db);

    $asignatura = $resultado->asignatura;
    $asignatura2 = $resultado->asignatura2;
    $asignaturas2 = $resultado->asignaturas2;
    $asignatura3 = $resultado->asignatura3;
    $asignaturas3 = $resultado->asignaturas3;
    $totalRows_asignatura = $resultado->totalRows_asignatura;
    $row_asignatura = $resultado->row_asignatura;
    $row_asignatura2 = $resultado->row_asignatura2;
    $row_asignaturas2 = $resultado->row_asignaturas2;
    $row_asignatura3 = $resultado->row_asignatura3;
    $row_asignaturas3 = $resultado->row_asignaturas3;

    $tipoDocumento = getTipoDocumento($db); 

    $datosDocumentoActual = getDatosDocumentoAcutal($db, @$_REQUEST['codigoestudiante'], @$_GET['idestudiante'], @$_SESSION['numerodocumentosesion']);
    $estadoActualizacionPIR = getEstadoActualizacionPIR($db, $row_datosgrabados['numeroregistroresultadopruebaestado']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>.:INGRESO ICFES:.</title>
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/general.js");
        ?>
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/jquery-3.1.1.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>/sala/assets/css/estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/sala/assets/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            .ui-datepicker{ display:none;}
	    </style>
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-win2k-1.css" type="text/css" />
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/jquery-3.1.1.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/datatables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/sala/assets/js/calendario/calendar-setup.js"></script>
        <script type="text/javascript">
            function cosultarResultadosPIR(){
                showLoader();  
                $("#mensajeLoader").html("Consultando puntaje ICFES...");              
                clearTimeout(timeOutVar);
                timeOutVar = window.setTimeout(function(){
                    $("#mensajeLoader").html("La carga esta tardando demasiado...");
                    timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
                }, 15000);
                consultarPermiteActualizar();
                var tipoDocumento = $("#tipoDocumento").val();
                var numeroDocumento = $("#numeroDocumento").val();
                var idEstudianteGeneral = $("#idestudiante").val();
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT;?>/serviciosacademicos/PIR/index.php";
                
                var parametros = {
                    tipoDocumento : tipoDocumento,
                    numeroDocumento : numeroDocumento,
                    registro : registro,
                    idEstudianteGeneral : idEstudianteGeneral,
                    action : 'consultarPIR'
                };
                
                $.ajax({
                    url: urlCURL,
                    type: "GET",
                    data:parametros,
                    dataType: "json",
                    timeout : 20000,
                    success: function( data ){
                        if(data.s){
                            $(".resultados").remove();
                            $("#resultados").html(data.tabla);
                            hideLoader();
                        }else{
                            alert("Problema de conexión: "+data.msj+", por favor intente de nuevo mas tarde o ingrese manualmente sus resultados");
                            $(".fechaPresentacionPrueba").css("display","table-cell");
                            $("#btnEnviar").css("display","");
                            hideLoader();
                        } 
                    },
                    error: function( ){
                        alert("Problema de conexión: No fue posible establecer conexion con el Ministerio de educación, por favor intente de nuevo mas tarde o ingrese manualmente sus resultados");
                        $(".fechaPresentacionPrueba").css("display","table-cell");
                        $("#btnEnviar").css("display","");
                        hideLoader();
                    }
                }).always(function() {
                    hideLoader();
                });
            }
            function cosultarEstructuraPIR(){
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT;?>/serviciosacademicos/PIR/index.php";
                var parametros = { 
                    registro : registro,
                    action : 'consultarEstructuraPIR'
                };
            }
            function consultarPermiteActualizar(){ 
                var tipoDocumento = $("#tipoDocumento").val();
                var numeroDocumento = $("#numeroDocumento").val();
                var idestudiante = $("#idestudiante").val();
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT;?>/serviciosacademicos/PIR/index.php";
                var parametros = { 
                    tipoDocumento : tipoDocumento,
                    numeroDocumento : numeroDocumento,
                    idestudiante : idestudiante,
                    registro : registro,
                    action : 'validarIdestudiantegeneralAC'
                };
                $.getJSON(
                    urlCURL,
                    parametros,
                    function(data){
                        if(data.s){
                            if(registro.trim()!=""){
                                cosultarEstructuraPIR(); 
                            }
                        }else{
                            permiteActualizar=false;
                            alert("Error de consulta: "+data.msj+", por favor intente de nuevo mas tarde");
                        } 
                    }
                ); 
            }
            $(document).ready(function(){
                $("#numeroDocumento").blur(function(){
                    var numeroDocumento = $("#numeroDocumento").val();
                    if(numeroDocumento.trim()!=""){ 
                        consultarPermiteActualizar();
                    }
                });
                $("#registro").blur(function(){
                    var registro = $("#registro").val();
                    if(registro.trim()!=""){
                        cosultarEstructuraPIR();
                    }
                });
                $("#consultarPIR").click(function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    var tipoDocumento = $("#tipoDocumento").val();
                    var numeroDocumento = $("#numeroDocumento").val();
                    var registro = $("#registro").val(); 
                    
                    if(tipoDocumento.trim()=="0"){
                        alert("Debe seleccionar el tipo de documento con el que presento la prueba");
                    }else if(numeroDocumento.trim()==""){
                        alert("Debe ingresar el número de documento con el que presento la prueba");
                    }else if(registro.trim()==""){
                        alert("Debe ingresar el número de registro de la prueba");
                    }else{
                        cosultarResultadosPIR();
                    }
                });
                <?php
                if(!empty($ACResultadoPruebaEstado)){
                    ?>
                    $("#consultarPIR").trigger("click");
                    <?php
                }
                ?>
            });
        </script>
    </head>            
    <body>
        <div class="container">
            <div class="loaderContent" style="">
                <div class="contenedorInterior">
                    <i class="fa fa-spinner fa-pulse fa-5x"></i>
                    <span class="sr-only">Cargando...</span>
                    <div id="mensajeLoader"></div>
                </div>
            </div>
            <form name="inscripcion" method="post" action="ingresoicfes_new.php">
                <?php
                if(isset($_POST['inicial']) or isset($_GET['inicial'])){
                    if (isset($_GET['inicial'])){
                        $moduloinicial = $_GET['inicial'];
                        echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';
                    }else{
                        $moduloinicial = $_POST['inicial'];
                        echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
                    }
                    ?>
                    <table class="table table-bordered" style="font-size: 13px">
                        <tr id="trtituloNaranjaInst" class="text-center">
                            <td colspan="4">
                                FORMULARIO DEL ASPIRANTE
                            </td>
                        </tr>
                        <tr id="trgris">
                            <td id="tdtitulogris">Nombre</td>
                            <td><?php echo $row_data['nombresestudiantegeneral']." ".$row_data['apellidosestudiantegeneral'];?></font></td>
                        </tr>
                        <tr id="trgris">
                            <td id="tdtitulogris">Modalidad Acad&eacute;mica</td>
                            <td><?php echo $row_data['nombremodalidadacademica'];?></td>
                        </tr>
                        <tr id="trgris">
                            <td id="tdtitulogris">Nombre del Programa</td>
                            <td><?php echo $row_data['nombrecarrera'];?></td>
                        </tr>
                    </table>
                    <table class="table table-bordered" style="font-size: 13px">
                        <tr id="trtituloNaranjaInst" class="text-center">
                            <td colspan="6" >RESULTADO PRUEBA DE ESTADO</td>
                        </tr>
                        <tr>
                            <td colspan="6" id="tdtitulogris">
                                <label id="labelresaltado">ATENCION! Para los resultados icfes que tengan Ciencias Sociales, por favor diligenciar ese puntaje en Historia y Geografia.</label>
                            </td>
                        </tr>
                        <tr>
                            <td id="tdtitulogris">
                                Tipo de documento<span class="Estilo4">*</span><br/>
                                (Registrado en la prueba)
                            </td>
                            <td>
                                <select id="tipoDocumento" name="tipoDocumento">
                                    <option value="0">Seleccionar...</option>
                                    <?php
                                    foreach($tipoDocumento as $tipos){
                                        $selected = "";
                                        if (!empty($datosDocumentoActual['nombrecortodocumento']) && ($datosDocumentoActual['nombrecortodocumento'] == $tipos['nombrecortodocumento'])) {
                                            $selected = " selected ";
                                        }
                                        ?>
                                    <option value="<?php echo $tipos['nombrecortodocumento']; ?>" <?php echo $selected; ?>>
                                        <?php echo $tipos['nombredocumento']; ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST['codigoestudiante'] ?>">
                            </td>
                            <td id="tdtitulogris">
                                Numero de documento<span class="Estilo4">*</span><br/>
                                (Registrado en la prueba)
                            </td>
                            <td colspan="4" >
                                <input name="numeroDocumento" type="text" id="numeroDocumento"  value="<?php echo $datosDocumentoActual['numerodocumento'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td id="tdtitulogris">No. Registro<span class="Estilo4">*</span></td>
                            <td>
                                <input type="text" name="registro" id="registro" value="<?php echo !empty($ACResultadoPruebaEstado)?$ACResultadoPruebaEstado:@$_POST['registro']; ?>" />
                            </td>
                            <td id="tdtitulogris" class="fechaPresentacionPrueba" >Fecha presentación</td>
                            <td class="fechaPresentacionPrueba" >
                                <input type="hidden" id="aplica_reclasificacion" name="aplica_reclasificacion"  value="0"/>
                                <input type="hidden" id="prueba_tipo" name="prueba_tipo"  value=""/>
                                <input name="fecha1" type="text" id="fecha1"  size="8" value="<?php echo substr($row_datosgrabados['fecharesultadopruebaestado'],0,10)?>" onchange="fechasaber11('fecha1');" readonly="yes" />
                            </td>
                        </tr>
                    </table>
                    <div id="resultados">
                        <?php
                        echo @$tabla;
                        ?>
                    </div>
                    <table class="resultados table"  width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                        <tr>
                            <td colspan="4">
                                <div id="tipo1" style="display: none;">
                                    <table class="table">
                                        <tr>
                                            <td id="tdtitulogris">Puesto</td>
                                            <td width="15%" colspan="1">
                                                <input type="text" id="puesto" name="puesto" size="3" value="<?php if(isset($_POST['puesto']) && !empty($_POST['puesto'])){echo $_POST['puesto'];} ?>" maxlength="3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="tdtitulogris" align="center">ASIGNATURA</td>
                                            <td colspan="8" id="tdtitulogris" align="center">PUNTAJE (00.00)</td>
                                        </tr>
                                        <?php
                                        $cuentaidioma = 1;
                                        if ($row_asignatura <> ""){
                                            do{
                                                ?>
                                                <tr>
                                                    <td colspan="8"><?php echo $row_asignatura['nombreasignaturaestado'] ;?> <input type="hidden" name="asignatura<?php echo $cuentaidioma;?>" value="<?php echo $row_asignatura['idasignaturaestado'] ; ?>"> </td>
                                                    <td colspan="5"align="center">
                                                        <input type="text" name="puntaje<?php echo $cuentaidioma;?>" size="4" maxlength="6" value="<?php if(isset($_POST['puntaje'.$cuentaidioma]) && !empty($_POST['puntaje'.$cuentaidioma])){echo $_POST['puntaje'.$cuentaidioma];} ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cuentaidioma ++;
                                            }while($row_asignatura = $asignatura->FetchRow());
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div id="reclasificacion" style="display: none;">
                                    <table class="table" style="margin-top:20px">
                                        <tr id="trtituloNaranjaInst">
                                            <td colspan="16" align="left">RECLASIFICACIÓN</td>
                                        </tr>
                                        <tr>
                                            <td id="tdtitulogris">Puntaje Global</td>
                                            <td width="15%" colspan="1">
                                                <input type="text" name="puntaje_global" size="3" value="<?php if(isset($_POST['puntaje_global']) && !empty($_POST['puntaje_global'])){echo $_POST['puntaje_global'];} ?>" maxlength="3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" id="tdtitulogris" align="center">ASIGNATURA</td>
                                            <td colspan="8" id="tdtitulogris" align="center">PUNTAJE (00)</td>
                                        </tr>
                                        <?php
                                        $cuentaidiomar = 1;
                                        if ($row_asignaturas2 <> ""){
                                            do{
                                                ?>
                                                <tr>
                                                    <td colspan="8">
                                                        <?php echo $row_asignaturas2['nombreasignaturaestado'] ;?>
                                                        <input type="hidden" name="total_array[]" value="1" />
                                                        <input type="hidden" name="asignatura_reclasificacion<?php echo $cuentaidiomar;?>" value="<?php echo $row_asignaturas2['idasignaturaestado'] ; ?>" />
                                                    </td>
                                                    <td colspan="5"align="center">
                                                        <input type="text" name="puntaje_reclasificacion<?php echo $cuentaidiomar;?>" size="4" maxlength="6" value="<?php if(isset($_POST['puntaje_reclasificacion'.$cuentaidiomar]) && !empty($_POST['puntaje_reclasificacion'.$cuentaidiomar])){echo $_POST['puntaje_reclasificacion'.$cuentaidiomar];} ?>" />
                                                    </td>
                                                </tr>
                                                <?php
                                                $cuentaidiomar ++;
                                            }while($row_asignaturas2 = $asignaturas2->FetchRow());
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div id="tipo2" style="display: none;" >
                                    <table class="table">
                                        <tr>
                                            <td id="tdtitulogris">Puesto</td>
                                            <td width="15%" colspan="1"><input type="text" id="puestodos" name="puestodos" size="3" value="<?php echo $_POST['puestodos']; ?>" maxlength="3"></td>
                                            <td id="tdtitulogris">Puntaje Global</td>
                                            <td width="15%" colspan="1"><input type="text" name="puntaje_global2" size="3" value="<?php echo $_POST['puntaje_global']; ?>" maxlength="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" id="tdtitulogris" align="center">PRUEBA</td>
                                            <td colspan="1" id="tdtitulogris" align="center">PUNTAJE <span id="txtDecimal">(00.00)</span></td>
                                            <td colspan="1" id="tdtitulogris" align="center">NIVEL</td>
                                            <td colspan="1" id="tdtitulogris" align="center">DECIL</td>
                                        </tr>
                                        <?php
                                        $cuentaidioma2 = 1;
                                        if ($row_asignatura2 <> ""){
                                            do{
                                                ?>
                                                <tr>
                                                    <td >
                                                        <?php echo $row_asignatura2['nombreasignaturaestado'] ;?>
                                                        <input type="hidden" name="asignaturados<?php echo $cuentaidioma2;?>" value="<?php echo $row_asignatura2['idasignaturaestado'] ; ?>">
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" name="puntajedos<?php echo $cuentaidioma2;?>" size="3" maxlength="5" value="<?php echo $_POST['puntajedos'.$cuentaidioma]; ?>">
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        if($row_asignatura2['idasignaturaestado']=="14"){
                                                            ?>
                                                            <select name="nivel<?php echo $cuentaidioma2;?>" id="nivel<?php echo $cuentaidioma;?>">
                                                                <option value="-1" >Seleccione:</option>
                                                                <option value="A-" <?php if($_POST['nivel'.$cuentaidioma2]=='A-'){ echo "selected";} ?>>A-</option>
                                                                <option value="A1" <?php if($_POST['nivel'.$cuentaidioma2]=='A1'){ echo "selected";} ?>>A1</option>
                                                                <option value="A2" <?php if($_POST['nivel'.$cuentaidioma2]=='A2'){ echo "selected";} ?>>A2</option>
                                                                <option value="B1" <?php if($_POST['nivel'.$cuentaidioma2]=='B1'){ echo "selected";} ?>>B1</option>
                                                                <option value="B+" <?php if($_POST['nivel'.$cuentaidioma2]=='B+'){ echo "selected";} ?>>B+</option>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" name="decil<?php echo $cuentaidioma2;?>" size="3" maxlength="5" value="<?php echo $_POST['decil'.$cuentaidioma2]; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cuentaidioma2 ++;
                                            }while($row_asignatura2 = $asignatura2->FetchRow());
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div id="tipo3" style="display: none;" >
                                    <table class="table">
                                        <tr>
                                            <td id="tdtitulogris"></td>
                                            <td width="15%" colspan="1">
                                                <input type="hidden" id="puestotres" name="puestotres" size="3" value="<?php echo $_POST['puestotres']; ?>" maxlength="3">
                                            </td>
                                            <td id="tdtitulogris">Puntaje Global</td>
                                            <td width="15%" colspan="1">
                                                <input type="text" name="puntaje_global3" size="3" value="<?php if(isset($_POST['puntaje_global']) && !empty($_POST['puntaje_global'])){echo $_POST['puntaje_global'];} ?>" maxlength="3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" id="tdtitulogris" align="center">PRUEBA</td>
                                            <td colspan="1" id="tdtitulogris" align="center">PUNTAJE <span id="txtDecimal">(00)</span></td>
                                            <td colspan="1" id="tdtitulogris" align="center">NIVEL</td>
                                            <td colspan="1" id="tdtitulogris" align="center">PERCENTIL</td>
                                        </tr>
                                        <?php
                                        $cuentaidioma3 = 1;
                                        if ($row_asignatura3 <> ""){
                                            do{
                                                ?>
                                                <tr>
                                                    <td >
                                                        <?php echo $row_asignatura3['nombreasignaturaestado'] ;?> <input type="hidden" name="asignaturatres<?php echo $cuentaidioma3;?>" value="<?php echo $row_asignatura3['idasignaturaestado'] ; ?>">
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" name="puntajetres<?php echo $cuentaidioma3;?>" size="3" maxlength="5" value="<?php if(isset($_POST['puntajetres'.$cuentaidioma]) && !empty($_POST['puntajetres'.$cuentaidioma])){echo $_POST['puntajetres'.$cuentaidioma];} ?>">
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        if($row_asignatura3['idasignaturaestado']=="21"){
                                                            ?>
                                                            <select name="nivel3<?php echo $cuentaidioma3;?>" id="nivel3<?php echo $cuentaidioma;?>">
                                                                <option value="-1" >Seleccione:</option>
                                                                <option value="A-" <?php if($_POST['nivel'.$cuentaidioma3]=='A-'){ echo "selected";} ?>>A-</option>
                                                                <option value="A1" <?php if($_POST['nivel'.$cuentaidioma3]=='A1'){ echo "selected";} ?>>A1</option>
                                                                <option value="A2" <?php if($_POST['nivel'.$cuentaidioma3]=='A2'){ echo "selected";} ?>>A2</option>
                                                                <option value="B1" <?php if($_POST['nivel'.$cuentaidioma3]=='B1'){ echo "selected";} ?>>B1</option>
                                                                <option value="B+" <?php if($_POST['nivel'.$cuentaidioma3]=='B+'){ echo "selected";} ?>>B+</option>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td align="center">
                                                        <input type="text" name="percentil<?php echo $cuentaidioma3;?>" size="3" maxlength="5" value="<?php if(isset($_POST['percentil'.$cuentaidioma3]) && !empty($_POST['percentil'.$cuentaidioma3])){echo $_POST['percentil'.$cuentaidioma3];} ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cuentaidioma3 ++;
                                            }while($row_asignatura3 = $asignatura3->FetchRow());
                                        }
                                        ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                            <tr>
                                <td colspan="6">
                                    <a href="http://www.icfesinteractivo.gov.co:8090/resultados/res_est/sniee_log_per.jsp"  target="_blank" id="aparencialinknaranja">CONSULTAR PUNTAJE ICFES</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <script language="javascript">
                function grabar(){
                    document.inscripcion.submit();
                }

                function vista(){
                    window.location.reload("vistaformularioinscripcion.php");
                }
            </script>
            <br><br>
            <input type="button" id="btnEnviar" value="Enviar" onClick="grabar()" />
            <input type="hidden" name="grabado" value="grabado" />
            <input type="hidden" id="idestudiante" name="idestudiante" value="<?php echo $idestudiantegeneral;?>" />
            <?php
            if (isset($_GET['codigoestudiante']) && !empty($_GET['codigoestudiante']) && isset($_GET['flag']) && !empty($_GET['flag'])) {
                $url = HTTP_ROOT . "/serviciosacademicos/consulta/prematricula/matriculaautomaticabusquedaestudiante.php?codigocreado=" . $row_data['numerodocumento'];
            } else {
                if(isset($_SESSION['fppal']) && !empty($_SESSION['fppal'])){
                    $url = HTTP_ROOT . "/serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?" . $_SESSION['fppal'] . "#ancla" . $_SESSION['modulosesion'];
                }else{
                    $url = HTTP_ROOT."/serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php";
                }
            }
            ?>
            <input type="button" onClick="window.location.href = '<?php echo $url; ?>'" name="Regresar" value="Regresar">
            <?php
            $banderagrabar = 0;
            if (isset($_POST['grabado'])){
                if(isset($_POST['nombre']) && !empty($_POST['nombre'])){
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombre']) and $_POST['nombre'] <> "")){
                        echo '<script language="JavaScript">alert("El Nombre de la Prueba es Incorrecto");</script>';
                        $banderagrabar = 1;
                    }
                }else{
                    $_POST['nombre'] = "";
                }

                if ($_POST['registro'] == ""){
                    echo '<script language="JavaScript">alert("Debe digitar el No. de registro");</script>';
                    $banderagrabar = 1;
                }elseif (!eregi("^[0-9]{1,15}$", $_POST['puesto']) and $_POST['puesto'] <> ""){
                    echo '<script language="JavaScript">alert("Puesto Incorrecto"); </script>';
                    $banderagrabar = 1;
                }
                if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="1")){
                    for ($i=1; $i<$cuentaidioma;$i++){
                        if(floatval($_POST['puntaje'.$i])> 100){
                            $banderagrabar = 1;
                        }
                    }

                    if ($banderagrabar == 1){
                        echo '<script language="JavaScript">alert("Debe digitar todos los puntajes, los cuales deben estar dados en rangos de 0 - 100 con dos decimales (00.00)");</script>';
                        $banderagrabar = 1;
                    }
                }else{
                    if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="2")){
                        $_POST['puntaje_global'] = $_POST['puntaje_global2'];
                        for ($i=1; $i<$cuentaidioma2;$i++){
                            if ($_POST['nivel'.$i]=="-1"){
                                $banderagrabar = 1;
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe Selecciona un nivel de Ingles");</script>';
                            $banderagrabar = 1;
                        }

                        for ($i=1; $i<$cuentaidioma2;$i++){
                            if (!eregi("^[0-9]{1,3}$", $_POST['puntajedos'.$i])){
                                $banderagrabar = 1;
                            }else{
                                if(floatval($_POST['puntajedos'.$i])> 100){
                                    $banderagrabar = 1;
                                }
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe digitar todos los puntajes, en rangos de 0 - 100, sin decimales");</script>';
                            $banderagrabar = 1;
                        }

                        for ($i=1; $i<$cuentaidioma2;$i++){
                            if ($_POST['decil'.$i]==""){
                                $banderagrabar = 1;
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe escribir todos los deciles correctamente"); </script>';
                            $banderagrabar = 1;
                        }
                    }

                    if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="3")){
                        $_POST['puntaje_global'] = $_POST['puntaje_global3'];
                        for ($i=1; $i<$cuentaidioma3;$i++){
                            if (isset($_POST['nivel3'.$i]) && $_POST['nivel3'.$i]=="-1"){
                                $banderagrabar = 1;
                            }
                            if(isset($_POST['nivel3'.$i]) && $_POST['nivel3'.$i]){
                                $_POST['nivel'.$i]= $_POST['nivel3'.$i];
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe Selecciona un nivel de Ingles");</script>';
                            $banderagrabar = 1;
                        }
                        for ($i=1; $i<$cuentaidioma3;$i++){
                            if (!eregi("^[0-9]{1,3}$", $_POST['puntajetres'.$i])){
                                $banderagrabar = 1;
                            }else{
                                if(floatval($_POST['puntajetres'.$i])> 100){
                                    $banderagrabar = 1;
                                }
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe digitar todos los puntajes, en rangos de 0 - 100, sin decimales");</script>';
                            $banderagrabar = 1;
                        }
                        for ($i=1; $i<$cuentaidioma3;$i++){
                            if ($_POST['percentil'.$i]==""){
                                $banderagrabar = 1;
                            }
                        }
                        if ($banderagrabar == 1){
                            echo '<script language="JavaScript">alert("Debe escribir todos los percentiles correctamente"); </script>';
                            $banderagrabar = 1;
                        }
                    }
                }

                if ($banderagrabar == 0){
                    if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="1")){
                        $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,
                            numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,codigoestado)
                            VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puesto']."','".$_POST['fecha1']."',
                                'prueba antes del 01-ago-2014: ".$_POST['descripcion']."','100' )";
                        $resultado = $db->Execute($query_resultado);
                        $idrespuesta = $db->Insert_ID();
                        for ($i=1; $i<$cuentaidioma;$i++){
                            if ($_POST['puntaje'.$i] <> ""){
                                $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,
                                    idasignaturaestado,notadetalleresultadopruebaestado,codigoestado)
                                    VALUES(0,'$idrespuesta','".$_POST['asignatura'.$i]."','".$_POST['puntaje'.$i]."','100' )";
                                $puntajeresultado = $db->Execute($query_puntajeresultado);
                            }
                        }

                        if($_POST['aplica_reclasificacion']=="1"){
                            for ($i=1; $i<$cuentaidiomar;$i++){
                                if ($_POST['puntaje_reclasificacion'.$i] <> ""){
                                    $fecha = date("Y-m-d H:i:s");
                                    if(isset($_SESSION['MM_Username']) && $_SESSION['MM_Username']!=null && $_SESSION['MM_Username']!=""){
                                        if($_SESSION['MM_Username'] == "estudiante2"){
                                            $usuario = 6492;
                                        }else {
                                            $query_tipousuario = "SELECT idusuario FROM usuario where usuario = '" . $usuario . "'";
                                            $tipousuario = $db->Execute($query_tipousuario);
                                            $totalRows_tipousuario = $tipousuario->RecordCount();
                                            $row_stipousuario = $tipousuario->FetchRow();
                                            $usuario = $row_stipousuario["idusuario"];
                                        }
                                    } else {
                                        $usuario = 6492;
                                    }
                                    $query_puntajeresultado = "INSERT INTO ResultadoReclasificacionPruebaEstado(idresultadopruebaestado,idasignaturaestado,
                                        Puntaje,UsuarioCreacion,FechaCreacion,UsuarioModificacion,FechaModificacion,CodigoEstado)
                                        VALUES('$idrespuesta','".$_POST['asignatura'.$i]."','".$_POST['puntaje_reclasificacion'.$i]."','$usuario','$fecha','$usuario',
                                            '$fecha','100' )";
                                    $puntajeresultadoReclasificacion = $db->Execute($query_puntajeresultado);
                                }
                            }
                        }
                    }else{
                        if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="2")){
                            $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,                    numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,PuntajeGlobal,codigoestado)
                                VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puestodos']."','".$_POST['fecha1']."',
                                    'prueba despues del 01-ago-2014: ".$_POST['descripcion']."','".$_POST['puntaje_global']."','100' )";
                            $resultado = $db->Execute($query_resultado);
                            $idrespuesta = $db->Insert_ID();
                            for ($i=1; $i<$cuentaidioma2;$i++){
                                if ($_POST['puntajedos'.$i] <> ""){
                                    $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,nivel,decil,codigoestado)
                                        VALUES(0,'$idrespuesta','".$_POST['asignaturados'.$i]."','".$_POST['puntajedos'.$i]."','".$_POST['nivel'.$i]."','".$_POST['decil'.$i]."','100' )";
                                    $puntajeresultado = $db->Execute($query_puntajeresultado);
                                }
                            }
                        }

                        if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="3")){
                            $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,                    numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,PuntajeGlobal,codigoestado)
                                VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puestotres']."','".$_POST['fecha1']."',
                                    'prueba despues del 22-oct-2016: ".$_POST['descripcion']."','".$_POST['puntaje_global']."','100' )";
                            $resultado = $db->Execute($query_resultado);
                            $idrespuesta = $db->Insert_ID();
                            for ($i=1; $i<$cuentaidioma3;$i++){
                                if ($_POST['puntajetres'.$i] <> ""){
                                    $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,nivel,decil,codigoestado)
                                        VALUES(0,'$idrespuesta','".$_POST['asignaturatres'.$i]."','".$_POST['puntajetres'.$i]."','".$_POST['nivel'.$i]."','".$_POST['percentil'.$i]."','100' )";

                                    $puntajeresultado = $db->Execute($query_puntajeresultado);
                                }
                            }
                        }
                    }
                    desactivarRegistrosAnteriores($db, $_POST['idestudiante']);
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresoicfes_new.php?inicial&idestudiante=".$_POST['idestudiante']."'>";
                }
            }
        }
        ?>
        <script language="javascript">
            function recargar(dir){
                window.location.reload("idiomas.php"+dir);
                history.go();
            }
        </script>
        </form>
        </div>
        <script type="text/javascript">
        $(function() {
            $( "#fecha1" ).datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: "button",
                buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
                buttonImageOnly: true,
                dateFormat: "yy-mm-dd"
            });
        });
        
        function parseDate(input) {
            var parts = input.split('-');
            return new Date(parts[0], parts[1]-1, parts[2]); // Note: months are 0-based
        }
        
        function fechasaber11(fechaprueba) {
            var fech1 = document.getElementById(fechaprueba).value;
            var fech2 = '2014-07-31';
            var fech3 = '2012-01-01';
            var fech4 = '2016-03-01';
            if((parseDate(fech1)) > (parseDate(fech2))){
                if((parseDate(fech1)) > (parseDate(fech4))){
                    //muestra formulario tipo 3
                    document.getElementById('tipo1').style.display = 'none';
                    document.getElementById('tipo2').style.display = 'none';
                    document.getElementById('txtDecimal').style.display = 'none';
                    document.getElementById('tipo3').style.display = '';
                    document.getElementById('prueba_tipo').value = '3';
                    document.getElementById('aplica_reclasificacion').value = '0';
                    document.getElementById('reclasificacion').style.display = 'none';
                }else{
                    //muestra formulario tipo 2
                    document.getElementById('tipo1').style.display = 'none';
                    document.getElementById('tipo3').style.display = 'none';
                    document.getElementById('txtDecimal').style.display = 'none';
                    document.getElementById('tipo2').style.display = '';
                    document.getElementById('prueba_tipo').value = '2';
                    document.getElementById('aplica_reclasificacion').value = '0';
                    document.getElementById('reclasificacion').style.display = 'none';
                }
            }else{
                //muestra formulario tipo 1
                document.getElementById('tipo2').style.display = 'none';
                document.getElementById('tipo3').style.display = 'none';
                document.getElementById('tipo1').style.display = '';
                document.getElementById('prueba_tipo').value = '1'; 
                if((parseDate(fech1)) > (parseDate(fech3))){
                    document.getElementById('aplica_reclasificacion').value = '1';
                    document.getElementById('reclasificacion').style.display = '';
                }else{
                    document.getElementById('aplica_reclasificacion').value = '0';
                    document.getElementById('reclasificacion').style.display = 'none';
                }
            }
        }
        </script>
    </body>
</html>