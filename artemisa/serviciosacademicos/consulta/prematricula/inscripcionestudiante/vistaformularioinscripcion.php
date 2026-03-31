<?php      
    /*
     * Ivan Dario quintero rios
     * Modified 19 de octubre 2018
     * Ajuste de variables de session y limpieza de codigo inicial
     */
    require(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
    $Configuration = Configuration::getInstance();

    if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
        @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
        @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
        require (PATH_ROOT.'/kint/Kint.class.php');
    }
    
    require (PATH_SITE.'/lib/Factory.php');
    $db = Factory::createDbo();

    $variables = new stdClass();
    $option = "";
    $tastk = "";
    $action = "";
    if(!empty($_REQUEST)){
        $keys_post = array_keys($_REQUEST);
        foreach ($keys_post as $key_post) {
            $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
            //d($key_post);
            switch($key_post){
                case 'option':
                    @$option = $_REQUEST[$key_post];
                    break;
                case 'task':
                    @$task = $_REQUEST[$key_post];
                    break;
                case 'action':
                    @$action = $_REQUEST[$key_post];
                    break;
                case 'layout':
                    @$layout = $_REQUEST[$key_post];
                    break;
                    break;
                case 'itemId':
                    @$itemId = $_REQUEST[$key_post];
                    break;
            }
        }
    }
    Factory::validateSession($variables);

    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    //valida si las variables de session existen
    if(isset($_SESSION['numerodocumentosesion'])){
        @$codigoinscripcion = $_SESSION['numerodocumentosesion'];   
        @$idinscripcion = $_SESSION['inscripcionsession'];
        @$modalidadacademica = $_SESSION['modalidadacademicasesion'];
//        @ć = $_SESSION['codigoestudiante'];

    }

   // echo '<pre>',print_r($_SESSION); die;
    
    /*
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se agregan MAX(ci.idinscripcion) y MAX(i.codigomodalidadacademica) para que muestre la informacion asociada del ultimo idinscripcion 
     * @since Octubre 26, 2018
     */ 
    //valida si se envia el id de la facultad en la url
    if (isset($_GET['facultad'])){
        if (isset($_GET['codigoestudiante'])){
            $_SESSION['codigo'] =$_GET['codigoestudiante'];
        }

        $query_estudiante = "SELECT MAX(ci.idinscripcion) idinscripcion,eg.numerodocumento,MAX(i.codigomodalidadacademica) codigomodalidadacademica "
        ."FROM estudiante e,inscripcion i,estudiantecarrerainscripcion ci,estudiantegeneral eg "
        ."WHERE e.codigoestudiante = '".$_SESSION['codigo']."' "
        ."AND e.idestudiantegeneral = i.idestudiantegeneral "
        ."AND i.idinscripcion = ci.idinscripcion "
        ."AND eg.idestudiantegeneral = e.idestudiantegeneral "
        ."AND ci.codigocarrera = e.codigocarrera";
        //echo $query_estudiante;
        
        $row_estudiante = $db->GetRow($query_estudiante);        

        if(count($row_estudiante) > 0){
            $codigoinscripcion = $row_estudiante['numerodocumento'];
            $idinscripcion = $row_estudiante['idinscripcion'];
            $modalidadacademica = $row_estudiante['codigomodalidadacademica'];
        }
    }
    
    //verifica si el codigoinscripcion esta vacio
    if(empty($codigoinscripcion)){ 
        $codigoestudiante = $_SESSION['codigo']; 
        $codigoperiodo = $_SESSION['codigoperiodosesion'];

        $query_documento = "select g.numerodocumento, i.idinscripcion, c.codigomodalidadacademica from estudiantegeneral g "
        ." INNER JOIN estudiante e ON (g.idestudiantegeneral = e.idestudiantegeneral) "
        ." INNER JOIN inscripcion i on (g.idestudiantegeneral = i.idestudiantegeneral)"
        ." INNER JOIN carrera c on (e.codigocarrera = c.codigocarrera) "
        ." where e.codigoestudiante = ".$codigoestudiante." and i.codigoperiodo = ".$codigoperiodo."";        
        $documento = $db->GetRow($query_documento);
        
        $codigoinscripcion = $documento['numerodocumento'];
        $_SESSION['numerodocumentosesion'] = $codigoinscripcion;
        
        $idinscripcion = $documento['idinscripcion'];  
        $_SESSION['inscripcionsession'] = $idinscripcion;
        
        $modalidadacademica = $documento['codigomodalidadacademica']; 
        $_SESSION['modalidadacademicasesion'] = $modalidadacademica;
    }
    /*
     * Caso 107045.
     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>.
     * Se adiciona la condición e.codigoestado = '100' para que valide las carreras activas 
     * Dentro de la tabla estudiantecarrerainscripcion y se muestre la correcta. 
     * @copyright Dirección de Tecnología Universidad el Bosque
     * @since 7 de Noviembre de 2018.
    */   

    // consulta los datos basicos del estudiante
    $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,do.nombredocumento,g.nombregenero,est.nombreestadocivil,ci.nombreciudad,nombretipoestudiantefamilia
    FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci,documento do,genero g,estadocivil est,tipoestudiantefamilia ti
    WHERE numerodocumento = '$codigoinscripcion'
    AND eg.idestudiantegeneral = i.idestudiantegeneral
    AND eg.idciudadnacimiento = ci.idciudad
    and do.tipodocumento = eg.tipodocumento
    and ti.idtipoestudiantefamilia = eg.idtipoestudiantefamilia
    AND i.idinscripcion = e.idinscripcion
    and eg.idestadocivil = eg.idestadocivil
    and g.codigogenero = eg.codigogenero
    and est.idestadocivil=eg.idestadocivil
    AND e.codigocarrera = c.codigocarrera
    AND m.codigomodalidadacademica = i.codigomodalidadacademica
    AND e.codigoestado = '100'
    AND i.codigoestado like '1%'
    AND e.idnumeroopcion = '1'
    and i.idinscripcion = '$idinscripcion'";      
    //End Caso 107045.
    $row_data = $db->GetRow($query_data);        
    
    // consulta los datos de la ciudad, departamento y pais de la residencia
    $seleccion4="SELECT pai.codigosappais, dep.codigosapdepartamento, ciu.nombreciudad FROM "
    ." estudiantegeneral eg INNER JOIN ciudad ciu on (eg.ciudadresidenciaestudiantegeneral = ciu.idciudad) "
    ." INNER JOIN departamento dep on (ciu.iddepartamento = dep.iddepartamento) "
    ." INNER JOIN pais pai on (dep.idpais = pai.idpais) WHERE eg.numerodocumento = '$codigoinscripcion'";    
    $registros4 = $db->GetRow($seleccion4);     
	
    //consulta los datos de la ciudad, departamento y ciudad de la correspondencia
    $seleccion5="SELECT pai.codigosappais, "
    ." dep.codigosapdepartamento, ciu.nombreciudad "
    ." FROM estudiantegeneral eg "
    ." INNER JOIN ciudad ciu on (eg.ciudadcorrespondenciaestudiantegeneral = ciu.idciudad) "
    ." INNER JOIN departamento dep on (ciu.iddepartamento = dep.iddepartamento) "
    ." INNER JOIN pais pai on (dep.idpais = pai.idpais) "
    ." WHERE eg.numerodocumento = '$codigoinscripcion'";    
    $registros5 = $db->GetRow($seleccion5);         
	
    if (count($row_data) == 0){
        echo '<script language="JavaScript">alert("No Presenta Inscripción"); history.go(-1);</script>';
        exit();	   	 
    } 	
?>
<!doctype html>
<html>
    <head>
        <title>.:Vista Previa:.</title>                
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
            <table>
                <tr>
                    <td>
            <center>
                <h2 id="titulo1">FORMULARIO DEL ASPIRANTE</h2>
            </center>
                        <table class="table table-hover">
                            <tr id="trgris">
                                <td id="tdtitulogris">Nombre</td>
                                <td colspan="3">
                                    <?php echo $row_data['nombresestudiantegeneral']." ".$row_data['apellidosestudiantegeneral'];?>
                                </td>
                        </tr>
                        <tr id="trgris">
                            <td id="tdtitulogris">Modalidad Académica</td>
                            <td colspan="3">
                                <?php echo $row_data['nombremodalidadacademica'];?>&nbsp;
                            </td>
                        </tr> 
                        <tr id="trgris">
                            <td width="37%" id="tdtitulogris">&nbsp;Nombre del Programa</td>
                            <td><?php echo $row_data['nombrecarrera'];?>&nbsp;</td>
                            <td id="tdtitulogris">Inscripción No.</td>
                            <td><?php echo $idinscripcion;?></td>
                        </tr>
                    </table>
                    <br>
                    <?php 
                    // debo validar si ya pago y entro logeado
                    if ($codigoinscripcion <> ""){  // if 1  
                        ?>    
                        <table class="table table-hover">
                            <tr id="trtitulogris">		
                                <td colspan="7">INFORMACI&Oacute;N PERSONAL</td>
                            </tr>
                            <tr>         
                                <td id="tdtitulogris">Nombre</td>
                                <td><?php echo $row_data['nombresestudiantegeneral']; ?>&nbsp;</td>
                                <td id="tdtitulogris">Apellidos</td>
                                <td colspan="3"><?php if(isset($row_data['apellidosestudiantegeneral'])) echo $row_data['apellidosestudiantegeneral']; ?></td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Tipo Documento</td>
                                <td><?php echo $row_data['nombredocumento']?></td>
                                <td id="tdtitulogris">No. Documento</td>
                                <td><?php echo $row_data['numerodocumento']; ?></td>
                                <td id="tdtitulogris">Expedida en </td>
                                <td><?php echo $row_data['expedidodocumento']; ?></td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Libreta Militar</td>
                                <td><?php echo $row_data['numerolibretamilitar'];?>&nbsp;</td>
                                <td id="tdtitulogris">Distrito</td>
                                <td><?php echo $row_data['numerodistritolibretamilitar'];?>&nbsp;</td>
                                <td id="tdtitulogris">Expedida en </td>
                                <td><?php echo $row_data['expedidalibretamilitar']; ?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">G&eacute;nero</td>
                                <td><?php echo $row_data['nombregenero']; ?>&nbsp;</td>
                                <td id="tdtitulogris">Estado Civil</td>
                                <td colspan="3"><?php echo $row_data['nombreestadocivil'];?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Lugar de Nacimiento</td>
                                <td><?php echo $row_data['nombreciudad'];?>&nbsp;</td>
                                <td id="tdtitulogris">Fecha de Nacimiento</td>
                                <td colspan="3"><?php echo $row_data['fechanacimientoestudiantegeneral'];?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Direcci&oacute;n Residencia</td>
                                <td><?php echo $row_data['direccionresidenciaestudiantegeneral']; ?>&nbsp;</td>
                                <td id="tdtitulogris">Tel&eacute;fono Residencia</td>
                                <td><?php echo $row_data['telefonoresidenciaestudiantegeneral'];?></td>
                                <td id="tdtitulogris">Ciudad</td>
                                <td><?php echo $registros4['nombreciudad'];?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Direcci&oacute;n Correspondencia</td>
                                <td><?php echo $row_data['direccioncorrespondenciaestudiantegeneral'];?>&nbsp;</td>
                                <td id="tdtitulogris">Tel&eacute;fono Correspondencia</td>
                                <td><?php echo $row_data['telefono2estudiantegeneral']; ?>&nbsp;</td>
                                <td id="tdtitulogris">Ciudad</td>
                                <td><?php if(count($registros5) > 0){ echo $registros5['nombreciudad']; }?></td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">E-mail 1</td>
                                <td><?php echo $row_data['emailestudiantegeneral']; ?>&nbsp;</td>
                                <td id="tdtitulogris">E-mail 2</td>
                                <td><?php echo $row_data['email2estudiantegeneral']; ?>&nbsp;</td>
                                <td id="tdtitulogris">Celular</td>
                                <td><?php echo $row_data['celularestudiantegeneral'];?>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="1" rowspan="2" id="tdtitulogris">En caso de Emergencia Llamar a </td>
                                <td rowspan="2" ><?php echo $row_data['casoemergenciallamarestudiantegeneral']; ?></td>
                                <td rowspan="2"  id="tdtitulogris">Parentesco </td>
                                <td rowspan="2"><?php echo $row_data['nombretipoestudiantefamilia']; ?></td>
                                <td id="tdtitulogris">Tel&eacute;fono1</td>
                                <td><?php echo $row_data['telefono1casoemergenciallamarestudiantegeneral']; ?></td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Tel&eacute;fono2</td>
                                <td><?php echo $row_data['telefono2casoemergenciallamarestudiantegeneral']; ?></td>
                            </tr>
                        </table>
                        <br>
                        <table class="table table-hover">
                            <tr  colspan="7">
                                <td colspan="6" id="tdtitulogris">RESULTADO ICFES</td>
                            </tr>
                            <?php 
                            $query_datosgrabados = "SELECT a.nombreasignaturaestado,d.notadetalleresultadopruebaestado
                            FROM detalleresultadopruebaestado d,resultadopruebaestado r,asignaturaestado a
                            WHERE r.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
                            AND a.idasignaturaestado = d.idasignaturaestado
                            AND r.idresultadopruebaestado = d.idresultadopruebaestado
                            and d.codigoestado like '1%'
                            order by 1";			  
                            $datosgrabados = $db->Execute($query_datosgrabados);
                            $totalRows_datosgrabados = $datosgrabados->RecordCount();
                            $row_datosgrabados = $datosgrabados->FetchRow();
                            if ($row_datosgrabados <> ""){
                                ?>
                                <tr colspan="7"  id="trtitulogris">
                                    <td colspan="3" >Asignatura</td>
                                    <td colspan="3" >Resultado</td>
                                </tr> 
                                <?php 
                                do{
                                    ?> 	  
                                    <tr  colspan="7">
                                        <td colspan="3" ><?php echo $row_datosgrabados['nombreasignaturaestado'];?></td>
                                        <td colspan="3" ><?php echo $row_datosgrabados['notadetalleresultadopruebaestado'];?></td>
                                    </tr>
                                    <?php 
                                }while($row_datosgrabados = $datosgrabados->FetchRow());
                            }else{
                                ?> 		  
                                <!-- <tr>
                                <td colspan="6">Sin datos diligenciados</td>
                                </tr> -->
                                <?php 
                            }
                            ?>	   
                        </table>  
                        <?php
                        //consulta 
                          $query_formularios1 = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo "
                        ."FROM inscripcionformulario ip INNER JOIN inscripcionmodulo im on (ip.idinscripcionmodulo = im.idinscripcionmodulo)"
                        ."WHERE ip.codigomodalidadacademica = '$modalidadacademica' "
                        ."AND ip.codigoestado = 100 AND linkinscripcionmodulo <> 'datosbasicos.php' "
                        ."order by posicioninscripcionformulario";

                        $row_formularios1= $db->GetAll($query_formularios1); 
                        foreach($row_formularios1 as $links){
                            ?>
                            <table class="table table-hover">
                                <tr colspan="7">
                                    <td id="tdtitulogris">
                                        <?php  echo ''.$links['nombreinscripcionmodulo'].'';?>	 
                                    </td>
                                </tr>  
                                <tr>
                                    <td colspan="7">
                                <?php	
                                if(file_exists($links['linkinscripcionmodulo'])){
                                    include($links['linkinscripcionmodulo']);
                                }
                                ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <?php
                        }                                                    
                        ?>
                        <br>
                        <br>
                        <?php if (!isset($_GET['codigoestudiante'])){?>
                        <input type="button" onClick="history.go(-1)" value="Regresar">
                        <?php }?>
                        <input type="button" onClick="window.print()" value="Imprimir">
                        <!-- <a onClick="history.go(-1)" style="cursor: pointer"><img src="../../../../imagenes/izquierda.gif" width="25" height="25" alt="Regresar"></a>  <input type="hidden" name="grabado" value="grabado">   
                        <a onClick="window.print()" style="cursor: pointer"><img src="../../../../imagenes/iconos/imprimir.gif" width="25" height="25" alt="Imprimir"></a> -->
                    <?php 
                    }   
                    ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>