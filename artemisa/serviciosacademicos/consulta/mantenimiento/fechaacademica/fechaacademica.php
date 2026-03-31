<?php	
/*
 * Ivan Dario Quintero rios
 * Julio 9 del 2018
 * Ajustes de educacion virtual pregrado y postgrado
 */
    session_start();
    
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    //consulta de modalidades academicas
    $SQLmodalidad = "SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica ".
    "WHERE codigomodalidadacademica IN(200,300,400,800,810) AND codigoestado = 100";
    $Resultadomodalidades=$db->GetAll($SQLmodalidad);
    
    $htmlmodalidad="";
    foreach($Resultadomodalidades as $lista){
        $htmlmodalidad.="<option value='".$lista['codigomodalidadacademica']."'>".$lista['nombremodalidadacademica']."</option>";
    }    
    	
    if(!empty($_REQUEST['modalidad'])){
        $carreras = $_POST['carrera'];
        $periodo = $_POST['periodo'];      
        
        //valida si la primera posicion del array de carreras tiene algun dato.
        if(empty($carreras['0'])){
            echo '<script>alert("Debe seleccionar al menos una carrera");</script>';
        }else{
            if(empty($periodo)){
                echo '<script>alert("Debe seleccionar el periodo");</script>';
            }else{
                $N = count($carreras);
                $notas = ($_POST['notas'] == '') ? '0000-00-00' : $_POST['notas'];				
                $carga = ($_POST['carga'] == '') ? '0000-00-00' : $_POST['carga'];
                $inicial_pre = ($_POST['inicial_pre'] == '') ? '0000-00-00' : $_POST['inicial_pre'];
                $final_pre = ($_POST['final_pre'] == '') ? '0000-00-00' : $_POST['final_pre'];
                $inicial_pos = ($_POST['inicial_pos'] == '') ? '0000-00-00' : $_POST['inicial_pos'];
                $final_pos = ($_POST['final_pos'] == '') ? '0000-00-00' : $_POST['final_pos'];
                $inicial_pre_carrera = ($_POST['inicial_pre_carrera'] == '') ? '0000-00-00' : $_POST['inicial_pre_carrera'];
                $final_pre_carrera = ($_POST['final_pre_carrera'] == '') ? '0000-00-00' : $_POST['final_pre_carrera'];
                $inicial_retiro = ($_POST['inicial_retiro'] == '') ? '0000-00-00' : $_POST['inicial_retiro'];
                $final_retiro = ($_POST['final_retiro'] == '') ? '0000-00-00' : $_POST['final_retiro'];
                $inicial_orden = ($_POST['inicial_orden'] == '') ? '0000-00-00' : $_POST['inicial_orden'];
                $final_orden = ($_POST['final_orden'] == '') ? '0000-00-00' : $_POST['final_orden'];
                $final_orden_carrera = ($_POST['final_orden_carrera'] == '') ? '0000-00-00' : $_POST['final_orden_carrera'];
                
                for($i=0; $i < $N; $i++){
                    //valida si existe un registro para le fecha academica que se va a registrar
                    $SQLfechaacademica="SELECT count(idfechaacademica) as 'contador' ".
                    "FROM fechaacademica WHERE codigocarrera = '".$carreras[$i]."' AND codigoperiodo = '".$periodo."'";
                    $Resultado=$db->GetRow($SQLfechaacademica);                                        
                    
                    //validacion de periodo existente
                    if($_REQUEST['modalidad']== '800' || $_REQUEST['modalidad']== '810'){
                        //si es modalidad virtual 
                        $SLQperiodo = "SELECT pv.CodigoPeriodo as 'periodo' FROM PeriodoVirtualCarrera pvc  ".
                        "INNER JOIN PeriodosVirtuales pv on (pvc.idPeriodoVirtual = pv.IdPeriodoVirtual) ".
                        "where pv.codigoperiodo = ".$periodo." and pvc.codigoModalidadAcademica = ".$_REQUEST['modalidad']." ".
                        " and pvc.codigoCarrera = 0";
                    }else{
                        //si es modalidad generica
                        $SLQperiodo = "select codigoperiodo as 'periodo' from periodo where codigoperiodo =".$periodo." ";
                    }
                    $resultadoperiodo= $db->GetRow($SLQperiodo);
                    $error = 0;
                    
                    if(!empty($resultadoperiodo['periodo'])){
                        if($Resultado['contador'] == '0'){
                            if((strtotime($inicial_pre) > strtotime($final_pre)) || ($inicial_pre == '0000-00-00')){
                                echo '<script>alert("La fecha final de la prematricula debe ser Mayor a la fecha Inicial o diferente a cero...");</script>';  
                                $error = 1;
                            }else{
                                if((strtotime($inicial_pos) > strtotime($final_pos)) || ($inicial_pos == '0000-00-00')){
                                    echo '<script>alert("La fecha final de la Posmatricula debe ser Mayor a la fecha Inicial o diferente a cero...");</script>'; 
                                    $error = 1;
                                }else{
                                    if((strtotime($inicial_pre_carrera) > strtotime($final_pre_carrera))|| ($inicial_pre_carrera == '0000-00-00')){
                                        echo '<script>alert("La fecha final de la Prematricula Carrera debe ser Mayor a la fecha Inicial o diferente a cero...");</script>'; 
                                        $error = 1;
                                    }else{
                                        if((strtotime($inicial_retiro) > strtotime($final_retiro))|| ($inicial_retiro == '0000-00-00')){
                                           echo '<script>alert("La fecha final para el Retiro de Asignaturas debe ser Mayor a la fecha Inicial o diferente a cero...");</script>'; 
                                           $error = 1;
                                        }else{
                                            if((strtotime($inicial_orden) > strtotime($final_orden))|| ($inicial_orden == '0000-00-00')){
                                                echo '<script>alert("La fecha final para la Entrega de Ordenes de Pago debe ser Mayor a la fecha Inicial o diferente a cero...");</script>'; 
                                                $error = 1;
                                            }else{
                                                if($error == 0){
                                                    //si no existe registro para esa carrera y para ese periodo se crea en la tabla
                                                    $SQLinsert = "INSERT INTO fechaacademica (codigoperiodo, codigocarrera, fechacortenotas, fechacargaacademica, fechainicialprematricula, "
                                                    . "fechafinalprematricula, fechainicialpostmatriculafechaacademica, fechafinalpostmatriculafechaacademica, "
                                                    . "fechainicialprematriculacarrera, fechafinalprematriculacarrera, fechainicialretiroasignaturafechaacademica, "
                                                    . "fechafinallretiroasignaturafechaacademica, fechainicialentregaordenpago, fechafinalentregaordenpago, "
                                                    . "fechafinalordenpagomatriculacarrera) VALUES ('".$periodo."', '".$carreras[$i]."', '".$notas."', '".$carga."', "
                                                    . "'".$inicial_pre."', '".$final_pre."', '".$inicial_pos."', '".$final_pos."', '".$inicial_pre_carrera."', "
                                                    . "'".$final_pre_carrera."', '".$inicial_retiro."', '".$final_retiro."', '".$inicial_orden."', '".$final_orden."', "
                                                    . "'".$final_orden_carrera."')";
                                                    $db->Execute($SQLinsert); 
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            //si ya existen los datos se actualizan en la tabla
                            $SQLupdate1 = "UPDATE fechaacademica SET fechacortenotas='".$notas."', fechacargaacademica='".$carga."', fechainicialprematricula="
                            . "'".$inicial_pre."', fechafinalprematricula='".$final_pre."', fechainicialpostmatriculafechaacademica='".$inicial_pos."', "
                            . "fechafinalpostmatriculafechaacademica='".$final_pos."', fechainicialprematriculacarrera='".$inicial_pre_carrera."', "
                            . "fechafinalprematriculacarrera='".$final_pre_carrera."', fechainicialretiroasignaturafechaacademica='".$inicial_retiro."', "
                            . "fechafinallretiroasignaturafechaacademica='".$final_retiro."', fechainicialentregaordenpago='".$inicial_orden."', "
                            . "fechafinalentregaordenpago='".$final_orden."', fechafinalordenpagomatriculacarrera='".$final_orden_carrera."' "
                            . "WHERE codigocarrera = '".$carreras[$i]."' AND codigoperiodo = '".$periodo."'";
                            $db->Execute($SQLupdate1);
                        }
                    }
                }//for
                
                if($_REQUEST['codigocarrera_oculto'] != ''){
                    //
                    $SQLupdate2 = "UPDATE fechaacademica SET fechacortenotas='".$notas."', fechacargaacademica='".$carga."', "
                    . "fechainicialprematricula='".$inicial_pre."', fechafinalprematricula='".$final_pre."', "
                    . "fechainicialpostmatriculafechaacademica='".$inicial_pos."', fechafinalpostmatriculafechaacademica='".$final_pos."', "
                    . "fechainicialprematriculacarrera='".$inicial_pre_carrera."', fechafinalprematriculacarrera='".$final_pre_carrera."', "
                    . "fechainicialretiroasignaturafechaacademica='".$inicial_retiro."', fechafinallretiroasignaturafechaacademica='".$final_retiro."', "
                    . "fechainicialentregaordenpago='".$inicial_orden."', fechafinalentregaordenpago='".$final_orden."', "
                    . "fechafinalordenpagomatriculacarrera='".$final_orden_carrera."' WHERE codigocarrera = '".$_REQUEST['codigocarrera_oculto']."' "
                    . "AND codigoperiodo = '".$periodo."'";
                    $db->Execute($SQLupdate2);
                }
                
                if($error == 0){
                    echo '<script>alert("Datos Insertados Correctamente...");</script>';        
                }                
            }
        }
    }//if	
?>
<html>
    <head>
	<?php
        /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         *se cambia  css externa <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">por css local
         *se cambia js externa <script src="//code.jquery.com/jquery-1.13.1.js"></script> por js local
         *se cambia js externa <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> por js local
         * @Since November 29,2018
         */
        ?>
        <link rel="stylesheet" href="../../../../assets/css/jquery-ui-git.css">
        <link rel="stylesheet" href="css/styles.css">
        <script src="../../../../assets/js/jquery.js"></script>	
        <script src="../../../../assets/js/jquery-ui.js"></script>	
        <script src="js/functions.js?1"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>	
	<h2 align="center">Fechas académicas - Menu Principal</h2>
        <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">	
            <table width="80%" align="center" class="primera">
                <tr>
                    <td width="50%" align="center">Modalidad Académica</td>
                    <td align="center">
                        <select name="modalidad" id="modalidad">
                            <option value="0">Seleccione</option>
                            <?php echo $htmlmodalidad; ?>
			</select>
                    </td>
		</tr>
		<tr>
                    <td width="50%" align="center">Periodo</td>
                    <td align="center">
                        <select name="periodo" id="periodo">
			</select>
                    </td>
		</tr>
		<tr id="tr_facultad" style="display:none">
                    <td align="center">Facultades</td>
                    <td align="center">
                        <select name="facultad" id="facultad" disabled>
                            <option value="0">Seleccione</option>
                        </select>
                    </td>
		</tr>		
            </table>
            <br />
            <div id="tabla_check"></div>
            <br />
            <div id="tabla_fechas" style="display:none">
		<table width="80%" align="center" class="primera">
                    <tr>
                        <td colspan="2" align="center"><b>Fechas</b></td>
                    </tr>
                    <tr>
                        <td width="50%">Fecha Corte Notas <span class="required">*</span></td>
                        <td align="center"><input id="notas" name="notas" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Carga Academica <span class="required">*</span></td>
                        <td align="center"><input id="carga" name="carga" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicial Prematricula <span class="required">*</span></td>
                        <td align="center"><input id="inicial_pre" name="inicial_pre" autocomplete="off" readonly="true" required="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Prematricula <span class="required">*</span></td>
                        <td align="center"><input id="final_pre" name="final_pre" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicial Posmatricula <span class="required">*</span></td>
                        <td align="center"><input id="inicial_pos" name="inicial_pos" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Posmatricula <span class="required">*</span></td>
                        <td align="center"><input id="final_pos" name="final_pos" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicial Prematricula Carrera <span class="required">*</span></td>
                        <td align="center"><input id="inicial_pre_carrera" name="inicial_pre_carrera" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Prematricula Carrera <span class="required">*</span></td>
                        <td align="center"><input id="final_pre_carrera" name="final_pre_carrera" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicial Retiro Asignatura Fecha Academica <span class="required">*</span></td>
                        <td align="center"><input id="inicial_retiro" name="inicial_retiro" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Retiro Asignatura Fecha Academica <span class="required">*</span></td>
                        <td align="center"><input id="final_retiro" name="final_retiro" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicial Entrega Orden Pago <span class="required">*</span></td>
                        <td align="center"><input id="inicial_orden" name="inicial_orden" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Entrega Orden Pago <span class="required">*</span></td>
                        <td align="center"><input id="final_orden" name="final_orden" autocomplete="off" readonly="true" /></td>
                    </tr>
                    <tr>
                        <td>Fecha Final Orden Pago Matricula Carrera <span class="required">*</span></td>
                        <td align="center"><input id="final_orden_carrera" name="final_orden_carrera" autocomplete="off" readonly="true" /></td>
                    </tr>	
                    <input type="hidden" id="codigocarrera_oculto" name="codigocarrera_oculto" value="">
		</table>
            </div>
            <br />	
            <table id="button" width="80%" align="center" class="primera" style="display:none;">
		<tr>
                    <td align="center">
                        <input id="limpiar" type="button" value="Limpiar" >
                        <input id="guardar" type="submit" value="Enviar" >
                    </td>
		</tr>		
            </table>
	</form>
    </body>
</html>