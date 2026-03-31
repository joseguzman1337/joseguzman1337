<?php  
/*/
@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**/
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se modifica este documento dentro del desarrollo del proyecto PIR para consulta de resultados ICFES 
     * a traves de un webservice preveeido por el MIN
     * Proyecto solicitado por el area de Atencion al usuario
     * @since Octubre 25, 2017
     */
    
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se incluye la definicion de constantes para el httproot y pathroot que se utilizaran para importar librerias
     * @since Octubre 25, 2017
     */
    if(!defined("HTTP_ROOT")){
        if($_SERVER[HTTP_HOST] == "artemisa.unbosque.edu.co" ){
            $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }else{
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
//        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("/serviciosacademicos", $actual_link);
        define("HTTP_ROOT", $actual_link[0]);
    }
    if(!defined("PATH_ROOT")){
        //Definimos el root del http
        $actual_link = getcwd();
        $actual_link = explode("/serviciosacademicos", $actual_link);
        define("PATH_ROOT", $actual_link[0]);
    }
    
    require (PATH_ROOT.'/kint/Kint.class.php');

    require(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');
    $sala2 = $sala;
    $rutaado = PATH_ROOT."/serviciosacademicos/funciones/adodb/";
    require_once(PATH_ROOT.'/serviciosacademicos/Connections/salaado.php');
    include (PATH_ROOT."/serviciosacademicos/consulta/prematricula/inscripcionestudiante/calendario/calendario.php");
    session_start();
    
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se incluye un documento llamado funcionesEditarInresoIfesNew.php en el cual se almacenan todo 
     * el codigo php que se encontraba incluido dentro del html hasta el momento de la modificacion
     * @since Octubre 25, 2017
     */
    require_once(PATH_ROOT.'/serviciosacademicos/consulta/prematricula/inscripcionestudiante/funcionesEditarIngresoIcfesNew.php');
        
    $data = getInfoEstudiante($db, $_REQUEST['codigoestudiante'], $_GET['idestudiante'], @$_SESSION['numerodocumentosesion'], @$_SESSION['inscripcionsession']);
    $totalRows_data = $data->RecordCount;
    $row_data = $data->FetchRow;


    //se ejecuta la funcion para traer la fecha actual registrada
    $fechaActual=getFechaActual($db, $row_data['idestudiantegeneral']);

    $date = $_GET['date'];

    //Se ejecuta la funcion para traer los datos Grabados acutalmente
    $data = getDatosGrabados($db, $fechaActual, $date, $row_data['idestudiantegeneral'], @$_GET['tipoPrueba']);
    $dataTipo = $data->dataTipo;
    $aplica_reclasificacion = $data->aplica_reclasificacion;
    $datosgrabados = $data->datosgrabados;
    $row_datosgrabados = $data->row_datosgrabados;

    $data= getMateriasF($db, $dataTipo, $aplica_reclasificacion);
    $materiasF = $data->materiasF;
    $asignaturas2 = $data->asignaturas2;
    $row_asignaturas2 = $data->row_asignaturas2;
    
    $tipoDocumento = getTipoDocumento($db);
    
    $datosDocumentoActual = getDatosDocumentoAcutal($db, $_REQUEST['codigoestudiante'], @$_GET['idestudiante'], @$_SESSION['numerodocumentosesion'], $row_datosgrabados['numeroregistroresultadopruebaestado']);
    /*/
    echo "<pre>";print_r($datosDocumentoActual);
    echo "</pre>";exit;/**/
    //$_REQUEST['codigoestudiante'],
    
    $estadoActualizacionPIR = getEstadoActualizacionPIR($db, $row_datosgrabados['numeroregistroresultadopruebaestado']);
    //d($estadoActualizacionPIR);
    
    if (empty($idestudiantegeneral)) {
        $idestudiantegeneral = $_REQUEST['idestudiante'];
    }
    
    if(!empty($row_datosgrabados['actualizadoPir'])){
        require (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php'); 
        require (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        require (PATH_ROOT.'/serviciosacademicos/PIR/entidad/DetalleResultadoPruebaEstado.php');
        require (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlActualizarMaterias.php');
        
        $ControlActualizarMaterias = new ControlActualizarMaterias($db);
        
        $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($idestudiantegeneral);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($row_datosgrabados['numeroregistroresultadopruebaestado']);
        $ResultadoPruebaEstado->getResultadoEsutiante();
        
        //d($ResultadoPruebaEstado);
        
        $DetalleResultadoPruebaEstado = new DetalleResultadoPruebaEstado($db);
        $resultados = $DetalleResultadoPruebaEstado->getDetallesResultadoActual($row_datosgrabados['idresultadopruebaestado']);
        //d($resultados);
        $ControlConsultarPIR = new ControlConsultarPIR($datosDocumentoActual['nombrecortodocumento'], $datosDocumentoActual['numerodocumento'], $row_datosgrabados['numeroregistroresultadopruebaestado'], $idestudiantegeneral);
        
        $tabla = $ControlConsultarPIR->printTablaResultados($ResultadoPruebaEstado, $ControlActualizarMaterias, $resultados, $db);
        
        //d($tabla);
        
    }
    //d($estadoActualizacionPIR);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>.:INGRESO ICFES:.</title>
        <?php
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se modifica el llamado de importacion de estilos css utilizanto la constante definida HTTP_ROOT 
         * @since Octubre 25, 2017
         */
        ?>
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/serviciosacademicos/css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            .ui-datepicker{
                display:none;
            }
            <?php
            if(!empty($row_datosgrabados['actualizadoPir'])){
                ?>
                table.resultados, 
                .fechaPresentacionPrueba, 
                #btnEnviar{
                    display:none !important;
                }
                <?php
            }
            ?>
	</style>
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/serviciosacademicos/estilos/sala.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT ?>/serviciosacademicos/funciones/calendario_nuevo/calendar-win2k-1.css" type="text/css" />	
        <?php
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se modifica el llamado de importacion de documentos js utilizanto la constante definida HTTP_ROOT 
         * @since Octubre 25, 2017
         */
        ?>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/observatorio/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/observatorio/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/observatorio/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_ROOT ?>/serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript">
            var numeroregistroresultadopruebaestado = <?php echo empty($row_datosgrabados['numeroregistroresultadopruebaestado'])?"null":"'".$row_datosgrabados['numeroregistroresultadopruebaestado']."'"; ?>;
            var idEstudianteGeneral = '<?php echo isset($idestudiantegeneral)?$idestudiantegeneral:$_REQUEST['idestudiante'];?>';
            var permiteActualizar = <?php echo empty($estadoActualizacionPIR)?( "true" ):( "false" ); ?>;
            console.log(numeroregistroresultadopruebaestado);
            console.log(permiteActualizar);
            function cosultarResultadosPIR(){
                consultarPermiteActualizar();
                var tipoDocumento = $("#tipoDocumento").val();
                var numeroDocumento = $("#numeroDocumento").val();
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT;?>/serviciosacademicos/PIR/index.php";
                
                var parametros = {
                    tipoDocumento : tipoDocumento,
                    numeroDocumento : numeroDocumento,
                    registro : registro,
                    idEstudianteGeneral : idEstudianteGeneral,
                    action : 'consultarPIR'
                };
                $.getJSON(
                    urlCURL,
                    parametros,
                    function(data){
                        if(data.s){
                            $(".resultados").remove();
                            $("#resultados").html(data.tabla);
                        }else{
                            alert("Error de consulta: "+data.msj+", por favor intente de nuevo mas tarde");
                            $(".fechaPresentacionPrueba").css("display","table-cell");
                            $("#btnEnviar").css("display","");
                        } 
                    }
                ); 
            }
            function cosultarEstructuraPIR(){
                var registro = $("#registro").val();
                var urlCURL = "<?php echo HTTP_ROOT;?>/serviciosacademicos/PIR/index.php";
                var parametros = { 
                    registro : registro,
                    action : 'consultarEstructuraPIR'
                };
                /*$.getJSON(
                    urlCURL,
                    parametros,
                    function(data){
                        if(data.s){
                            var estr = parseInt(data.estructura);
                            if( estr < 5 ){
                                $(".fechaPresentacionPrueba").css("display","");
                                $(".botonConsultarPir").css("display","none");
                                $("#btnEnviar").css("display","");
                            }else{
                                $(".fechaPresentacionPrueba").css("display","none");
                                $(".botonConsultarPir").css("display","");
                                $(".resultados").css("display","none"); 
                                $("#btnEnviar").css("display","none");
                            }
                        }else{
                            $(".fechaPresentacionPrueba").css("display","");
                            $(".botonConsultarPir").css("display","none");
                            $("#btnEnviar").css("display","");
                        } 
                    }
                );/**/
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
                    console.log(numeroregistroresultadopruebaestado);
                    console.log(permiteActualizar);
                    
                    if(registro!==numeroregistroresultadopruebaestado){
                        permiteActualizar = true;
                    }
                    console.log(permiteActualizar);
                    if(tipoDocumento.trim()=="0"){
                        alert("Debe seleccionar el tipo de documento con el que presento la prueba");
                    }else if(numeroDocumento.trim()==""){
                        alert("Debe ingresar el número de documento con el que presento la prueba");
                    }else if(registro.trim()==""){
                        alert("Debe ingresar el número de registro de la prueba");
                    }else if(permiteActualizar){
                        cosultarResultadosPIR();
                    }
                });
            });
        </script>
    </head>
    <body>
        <form name="inscripcion" method="post" action="editaringresoicfes_new.php">
            <input type="hidden" id="idestudiante" name="idestudiante" value="<?php echo !empty($idestudiantegeneral)?$idestudiantegeneral:$_REQUEST["idestudiante"];?>" />
            <?php
            if(isset($_POST['inicial']) or isset($_GET['inicial'])){ 
                // vista previa
                ?>
                <p>FORMULARIO DEL ASPIRANTE</p>
                <table width="70%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
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
                            <?php
                            //echo strtotime($row_datosgrabados['fecharesultadopruebaestado'])." y ".strtotime('2014-08-10');die;
                            
                            if (isset($_GET['inicial'])){
                                $moduloinicial = $_GET['inicial'];
                                echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">';
                            }else{
                                $moduloinicial = $_POST['inicial'];
                                echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';
                            }
                            ?>
                            <br>
                            <table width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                                <tr>
                                    <td colspan="7" id="tdtitulogris">RESULTADO PRUEBA DE ESTADO</td>
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
                                            while($tp = $tipoDocumento->FetchRow()){
                                                $selected="";
                                                if(!empty($datosDocumentoActual['nombrecortodocumento']) && ($datosDocumentoActual['nombrecortodocumento']==$tp['nombrecortodocumento']) ){
                                                    $selected=" selected ";
                                                }
                                                ?>
                                                <option value="<?php echo $tp['nombrecortodocumento']; ?>" <?php echo $selected;?>>
                                                    <?php echo $tp['nombredocumento'];?>
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
                                        <input type="text" name="registro" id="registro" value="<?php echo $row_datosgrabados['numeroregistroresultadopruebaestado']; ?>">
                                        <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $_REQUEST['codigoestudiante'] ?>">
                                    </td>
                                    
                                    <td class="fechaPresentacionPrueba" id="tdtitulogris">Fecha de la prueba</td>
                                    <td class="fechaPresentacionPrueba" colspan="4" >
                                        <?php //echo substr($row_datosgrabados['fecharesultadopruebaestado'],0,10)?>
                                        <input name="fecha1" type="text" id="fecha1"  size="15" value="<?php if(!empty($_GET['date'])){echo $fechaActual=$_GET['date'];}else{echo $fechaActual=substr($row_datosgrabados['fecharesultadopruebaestado'],0,10);}?>" onchange="fechasaber11('fecha1');">
                                    </td>
                                </tr>
                                <tr class="botonConsultarPir" <?php if($estadoActualizacionPIR==1){?>style="display: none !important"<?php  } ?>>
                                    <td colspan="7">
                                        <input type="button" id="consultarPIR" value="Consultar Resultados" />
                                    </td>
                                </tr>
                            </table>
                            <div id="resultados">
                                <?php
                                echo $tabla;
                                ?>
                            </div>
                            <table class="resultados"  width="100%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                                <tr>
                                    <?php
                                    if($row_datosgrabados['TipoPrueba']!==3){                                        
                                    ?>
                                    <td id="tdtitulogris">Puesto</td>
                                    <td colspan="1"><input type="text" name="puesto" id="puesto" size="3" value="<?php echo $row_datosgrabados['puestoresultadopruebaestado']; ?>" maxlength="3"></td>
                                    <?php
                                    }
                                    ?>
                                    <?php                                    
                                    if($row_datosgrabados['TipoPrueba']==1){
                                    ?>
                                        <td id="tdtitulogris">&nbsp;</td>
                                        <td colspan="2">&nbsp;</td>
                                        <td colspan="2">&nbsp;</td>
                                    <?php
                                    }
                                    if($row_datosgrabados['TipoPrueba']==2){
                                     ?>
                                        <td id="tdtitulogris">Puntaje Global</td>
                                        <td colspan="2"><input type="text" value="<?php echo $row_datosgrabados['PuntajeGlobal']; ?>" name="puntaje_global" id="puntaje_global"/></td>
                                        <td colspan="2">&nbsp;</td>
                                    <?php   
                                    }
                                    if($row_datosgrabados['TipoPrueba']==3){                                       
                                     ?>
                                        <td id="tdtitulogris">Puntaje Global</td>
                                        <td colspan="2"><input type="text" value="<?php echo $row_datosgrabados['PuntajeGlobal']; ?>" name="puntaje_global" id="puntaje_global"/></td>
                                        <td colspan="2">&nbsp;</td>
                                    <?php   
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="2" id="tdtitulogris">Asignatura</td>
                                    <td colspan="2" id="tdtitulogris">Puntaje</td>
                                    <?php
                                    //if($row_datosgrabados['TipoPrueba']==1){
                                    if($dataTipo==1){
                                        ?>
                                        <td colspan="2" id="tdtitulogris">&nbsp;</td>
                                        <td colspan="2" id="tdtitulogris">&nbsp;</td>
                                        <?php
                                    }
                                    if($dataTipo==2){
                                        ?>
                                        <td colspan="2" id="tdtitulogris">Nivel</td>
                                        <td colspan="2" id="tdtitulogris">Decil</td>
                                        <?php   
                                    }
                                    if($dataTipo==3){
                                        ?>
                                        <td colspan="2" id="tdtitulogris">Nivel</td>
                                        <td colspan="2" id="tdtitulogris">Percentil</td>
                                        <?php   
                                    }
                                    $cuentaidioma = 1;
                                    
                                    if ($row_datosgrabados <> ""){
                                        //carga las materias y los datos de los puntajes del saber 11
                                        do {
                                            unset($materiasF[$row_datosgrabados['idasignaturaestado']]);
                                            $row_datosgrabados['TipoPrueba']=$dataTipo;
                                            $row_datosgrabados['opcional']=$opcional;
                                            
                                            include("pintarCamposMaterias.php");
                                            
                                        }while($row_datosgrabados = $datosgrabados->FetchRow());
                                    }
                                    
                                    //carga las materias
                                    foreach($materiasF as $row_datosgrabados){
                                        $row_datosgrabados['TipoPrueba']=$dataTipo;
                                        include("pintarCamposMaterias.php");
                                    }
                                    ?>
                                    <input type="hidden" name="cuentaidioma" id="cuentaidioma" value="<?php echo $cuentaidioma; ?>" />
                                </tr>	
                            </table>
                        </td>
                    </tr>
                    <?php 
                    if($aplica_reclasificacion) { 
                        ?>
                        <tr>
                            <td>
                                <table class="resultados" width="100%" cellspacing="0" cellpadding="1" bordercolor="#E9E9E9" border="1" style="margin-top:20px">
                                    <tr>
                                        <td colspan="7" id="tdtitulogris" align="left">RECLASIFICACIÓN</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="tdtitulogris" align="center">ASIGNATURA</td>
                                        <td colspan="1" id="tdtitulogris" align="center">PUNTAJE (00)</td>
                                    </tr>
                                    <?php
                                        $cuentaidiomar = 1;
                                        if ($row_asignaturas2 <> ""){
                                            do{
                                                ?>
                                                <tr>
                                                    <td colspan="2"><?php echo $row_asignaturas2['nombreasignaturaestado'] ;?> 
                                                        <input type="hidden" name="total_array[]" value="1">
                                                        <input type="hidden" name="asignatura_reclasificacion<?php echo $cuentaidiomar;?>" value="<?php echo $row_asignaturas2['idasignaturaestado'] ; ?>"> 
                                                    </td>
                                                    <td colspan="1"align="center">
                                                        <input type="text" name="puntaje_reclasificacion<?php echo $cuentaidiomar;?>" size="4" maxlength="6" value="<?php echo $_POST['puntaje_reclasificacion'.$cuentaidiomar]; ?>">
                                                        <input type="hidden" name="idr<?php echo $cuentaidiomar;?>" size="3"  value="<?php echo $row_datosgrabadosr['ResultadoReclasificacionPruebaEstadoID']; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $cuentaidiomar ++;
                                            }while($row_asignaturas2 = $asignaturas2->FetchRow());
                                        }
                                        ?>            
                                </table>
                            </td>
                        </tr>
                        <?php 
                    }
                    ?>
                </table>
                <script language="javascript">
                    function grabar(){
                        document.inscripcion.submit();
                    }
                    function vista(){
                        window.location.href="vistaformularioinscripcion.php";
                    }
                </script>
                <br><br>
                <!-- 
                <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>
                <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>
                -->
                <input type="button" id="btnEnviar" value="Enviar" onClick="grabar()" />
                <input type="hidden" name="tipoPrueba" id="tipoPrueba" value="<?php echo $dataTipo; ?>" />
                <!--
                <input type="button" value="Vista Previa" onClick="vista()">
                -->
                <input type="hidden" name="grabado" value="grabado" />
                <!-- 
                <a onClick="regresar()" style="cursor: pointer"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Regresar"></a>  <input type="hidden" name="grabado" value="grabado">
                -->
                <?php 
                if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!="")){
                    $url=HTTP_ROOT."/serviciosacademicos/consulta/prematricula/matriculaautomaticabusquedaestudiante.php?codigocreado=".$row_data['numerodocumento'];
                }else{
                    $url=HTTP_ROOT."/serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariodeinscripcion.php?".$_SESSION['fppal']."#ancla".$_SESSION['modulosesion'];
                }
                ?>
                <input type="button" onClick="window.location.href='<?php echo $url; ?>'" name="Regresar" value="Regresar">
                <?php
                //proceso de guardado
                $banderagrabar = 0;
                if (isset($_POST['grabado'])) {
                    
                    if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombre']) and $_POST['nombre'] <> "")) {
                        echo '<script language="JavaScript">alert("El Nombre de la Prueba es Incorrecto"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }elseif ($_POST['registro'] == "") {
                        echo '<script language="JavaScript">alert("Debe digitar el No. de registro"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }elseif (!eregi("^[0-9]{1,15}$", $_POST['puesto']) and $_POST['puesto'] <> "") {
                        echo '<script language="JavaScript">alert("Puesto Incorrecto"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }
                    //validacion de materias y puntajes
                    for ($i=1; $i<intval($_POST['cuentaidioma']);$i++){
                        if($_POST['asignatura'.$i]<9){
                            if (!eregi("^[0-9]{1,3}\.[0-9]{1,2}$", $_POST['puntaje'.$i]) or $_POST['puntaje'.$i]> 100){
                                $banderagrabar = 1;
                            }    
                        }else{
                            if(!(is_numeric($_POST['puntaje'.$i]))){
                                $banderagrabar = 1;
                            }else{
                                if(floatval($_POST['puntaje'.$i])> 100){
                                    $banderagrabar = 1;
                                }
                            }
                        }
                    }
                    
                    if($_POST['aplica_reclasificacion']=="1"){
                        for ($i=1; $i<$cuentaidiomar;$i++){
                            if (!eregi("^[0-9]{1,3}$", $_POST['puntaje_reclasificacion'.$i])){
                                $banderagrabar = 1;
                            }else{
                                if(floatval($_POST['puntaje_reclasificacion'.$i])> 100){
                                    $banderagrabar = 1;
                                }
                            }
                        }
                    }
                    
                    if ($banderagrabar == 1) {
                        echo '<script language="JavaScript">alert("Los puntajes deben estar dados en rangos de 0 - 100 con dos decimales (00.00)"); history.go(-1);</script>';
                        $banderagrabar = 1;
                    }elseif ($banderagrabar == 0) {
                        $base="update resultadopruebaestado
                            set nombreresultadopruebaestado = '".$_POST['nombre']."',
                            numeroregistroresultadopruebaestado = '".$_POST['registro']."',
                            puestoresultadopruebaestado = '".$_POST['puesto']."',
                            fecharesultadopruebaestado = '".$_POST['fecha1']."',
                            observacionresultadopruebaestado = '".$_POST['descripcion']."',
                            PuntajeGlobal = '".$_POST['puntaje_global']."'
                            where idestudiantegeneral = '".$_POST['idestudiante']."'";                        
                        
                        $sol = $db->Execute($base);
                        
                        $datos = $db->GetRow("SELECT * FROM resultadopruebaestado where idestudiantegeneral = '".$_POST['idestudiante']."'");
                        
                        $fech2 = '2014-07-31';
                        $updateEstado="";
                        for ($i=1; $i<intval($_POST['cuentaidioma']);$i++) {
                            if ($_POST['puntaje'.$i] <> "") {
                                if($_POST['id'.$i]<> ""){
                                    $base1="update detalleresultadopruebaestado
                                        set notadetalleresultadopruebaestado = '".$_POST['puntaje'.$i]."',
                                        nivel = '".$_POST['nivel'.$i]."',
                                        decil = '".$_POST['decil'.$i]."'
                                        where iddetalleresultadopruebaestado = '".$_POST['id'.$i]."'";
                                }else{
                                    $base1="INSERT INTO `detalleresultadopruebaestado` (`idresultadopruebaestado`, 
                                        `idasignaturaestado`, `notadetalleresultadopruebaestado`, 
                                        `nivel`, `decil`, `codigoestado`)
                                        VALUES ('".$datos["idresultadopruebaestado"]."', '".$_POST['asignatura'.$i]."',
                                            '".$_POST['puntaje'.$i]."', '".$_POST['nivel'.$i]."', '".$_POST['decil'.$i]."', '100')";
                                }
                                $sol1 = $db->Execute($base1);
                            }
                            
                            $idResult=$datos["idresultadopruebaestado"];
                        }
                        /*
                         * Modificacion de variables en la reclasificacion
                         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Universidad el Bosque - Direccion de Tecnologia.
                         * Modificado 26 de Septiembre de 2017.
                         */ 
                        for ($i=1; $i<intval($_POST['cuentaidioma']);$i++) {
                            if ($_POST['puntaje_reclasificacion'.$i] <> "") {
                                if($_POST['idr'.$i]<> ""){
                                    $base1="update detalleresultadopruebaestado
                                        set notadetalleresultadopruebaestado = '".$_POST['puntaje_reclasificacion'.$i]."',
                                            nivel = '".$_POST['nivel'.$i]."',
                                            decil = '".$_POST['decil'.$i]."'
                                        where iddetalleresultadopruebaestado = '".$_POST['idr'.$i]."'";
                                } else {
                                    $base1="INSERT INTO `detalleresultadopruebaestado` (`idresultadopruebaestado`, 
                                        `idasignaturaestado`, `notadetalleresultadopruebaestado`, 
                                        `nivel`, `decil`, `codigoestado`)
                                        VALUES ('".$datos["idresultadopruebaestado"]."', '".$_POST['asignatura'.$i]."', 
                                            '".$_POST['puntaje'.$i]."', '".$_POST['nivel'.$i]."', '".$_POST['decil'.$i]."', '100')";
                                }
                                $sol1 = $db->Execute($base1);
                            }
                        }
                        $tipoP=$_POST['tipoPrueba'];
                        
                        if($tipoP !== '1'){
                            $base1="update detalleresultadopruebaestado
                                set codigoestado = '300'
                                where idasignaturaestado < 10
                                AND idresultadopruebaestado ='".$idResult."'";
                            $sol2 = $db->Execute($base1);
                        }else{
                            $base2="update detalleresultadopruebaestado
                                set codigoestado = '300'
                                where idasignaturaestado >9
                                AND idresultadopruebaestado ='".$idResult."'";
                            $sol2 = $db->Execute($base2);
                        }
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=editaringresoicfes_new.php?inicial&idestudiante=".$_POST['idestudiante']."&codigoestudiante=".$_POST['codigoestudiante']."&tipoPrueba=".$_POST['tipoPrueba']."'>";
                    }
                }
            }// vista previa
            ?>
        </form>

        <script type="text/javascript">
            /*Calendar.setup({
                inputField : "fecha1", // ID of the input field
                ifFormat : "%Y-%m-%d", // the date format
                button : "btfechavencimiento" // ID of the button
            });*/
            $(function(){
                $( "#fecha1" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
            });
            
            function fechasaber11(fechaprueba) {
                var fech1 = document.getElementById(fechaprueba).value;
                var fech2 = '2014-07-31';
                var fech3 = '2016-03-01';
                var idEstudiante = document.getElementById('idestudiante').value;
                if((parseDate(fech1)) > (parseDate(fech2))){
                    if((parseDate(fech1)) > (parseDate(fech3))){
                        document.location=('editaringresoicfes_new.php?inicial&idestudiante='+idEstudiante+'&date='+fech1+'&tipoPrueba=3&codigoestudiante=');
                    }else{
                        document.location=('editaringresoicfes_new.php?inicial&idestudiante='+idEstudiante+'&date='+fech1+'&tipoPrueba=2&codigoestudiante=');
                    }
                }else{
                    document.location=('editaringresoicfes_new.php?inicial&idestudiante='+idEstudiante+'&date='+fech1+'&codigoestudiante=');
                }
            }
            
            function parseDate(input) {
                var parts = input.split('-');
                // new Date(year, month [, day [, hours[, minutes[, seconds[, ms]]]]])
                return new Date(parts[0], parts[1]-1, parts[2]); // Note: months are 0-based
            }
        </script>
    </body>
</html>