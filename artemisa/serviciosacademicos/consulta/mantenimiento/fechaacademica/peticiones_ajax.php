<?php
/*
 * Ivan Dario Quintero rios
 * Julio 9 del 2018
 * Ajustes de educacion virtual pregrado y postgrado
 */
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
    
    switch($_REQUEST['actionID']){
        case 'carga_facultad':{
            $a_vectt['val'] = 'TRUE';
            $modalidad = $_REQUEST['modalidad'];
            if($modalidad == 200){
                $SQL = 'SELECT
                        DISTINCT fac.codigofacultad,
                        fac.nombrefacultad
                        FROM
                        facultad fac        
                        WHERE
                        fac.codigoestado = 100
                        ORDER BY fac.nombrefacultad';
            }else{
                $SQL = 'SELECT
                        DISTINCT car.codigocarrera,
                        car.nombrecarrera
                        FROM
                        carrera car                
                        WHERE
                        (fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
                        AND car.codigomodalidadacademica = '.$modalidad.' 
                        ORDER BY car.nombrecarrera';
            }
			
            if($Resultado=&$db->Execute($SQL)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'ERROR '.$sql_update_actividades; 
            }else{
                if($modalidad == 200){
                    $imp = '<option value="0" selected="selected">Seleccione</option>';
                    if(!$Resultado->EOF){
                        while(!$Resultado->EOF){
                            $imp .= '<option value="'.$Resultado->fields['codigofacultad'].'">'.$Resultado->fields['nombrefacultad'].'</option>';
                            $Resultado->MoveNext();
                        }
                    }
                }else{
                    $periodo = $_REQUEST['periodo'];
                    $imp = '<table width="80%" align="center" class="primera"><tr><td width="80%" align="center"><b>Carrera</b></td><td align="center"><b>Seleccionar</b></td></tr>';
                    if(!$Resultado->EOF){
                        while(!$Resultado->EOF){
                            $SQL = 'SELECT * FROM fechaacademica WHERE codigoperiodo = '.$periodo.' AND codigocarrera = '.$Resultado->fields['codigocarrera'].' LIMIT 1';
                            if($Anterior=&$db->Execute($SQL)===false){
                                $a_vectt['val'] = 'FALSE';
                                $a_vectt['descrip'] = 'ERROR '.$sql_update_actividades; 
                            }
                            if($Anterior->_numOfRows != 0){
                                $imp .= '<tr><td align="center">'.$Resultado->fields['nombrecarrera'].'</td><td align="center"><input type="checkbox" name="carrera[]" value="'.$Resultado->fields['codigocarrera'].'"> | <span onclick="carga_fechas(\''.$Resultado->fields['codigocarrera'].'\')">Ver fechas asignadas</span></td></tr>';					
                            }else{
                                $imp .= '<tr><td align="center">'.$Resultado->fields['nombrecarrera'].'</td><td align="center"><input type="checkbox" name="carrera[]" value="'.$Resultado->fields['codigocarrera'].'"></td></tr>';
                            }
                            $Resultado->MoveNext();
                        }
                    }
                    $imp .= '</table>';
                }
            }
            $a_vectt['imp'] = $imp;			
            $a_vectt['modalidad'] = $modalidad;
            echo json_encode($a_vectt); 
        }break;
        case 'cargar_carrera':{
            $a_vectt['val'] = 'TRUE';
            $facultad = $_REQUEST['facultad'];
            $modalidad = $_REQUEST['modalidad'];
            $periodo = $_REQUEST['periodo'];
            $SQL = 'SELECT DISTINCT car.codigocarrera,
                    car.nombrecarrera
                    FROM
                    carrera car                
                    WHERE
                    (car.fechavencimientocarrera >= NOW() OR car.EsAdministrativa = 1)
                    AND car.codigofacultad = '.$facultad.'
                    AND car.codigomodalidadacademica <> 400
                    AND car.codigomodalidadacademica = '.$modalidad.'
                    ORDER BY car.nombrecarrera';
			
            if($Resultado=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$sql_update_actividades; 
            }
            $imp = '<table width="80%" align="center" class="primera"><tr><td width="80%" align="center"><b>Carrera</b></td><td align="center"><b>Seleccionar</b></td></tr>';
            if(!$Resultado->EOF){
                while(!$Resultado->EOF){
                    $SQL = 'SELECT * FROM fechaacademica WHERE codigoperiodo = '.$periodo.' AND codigocarrera = '.$Resultado->fields['codigocarrera'].' LIMIT 1';
                    if($Anterior=&$db->Execute($SQL)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'ERROR '.$sql_update_actividades; 
                    }
                    if($Anterior->_numOfRows != 0){
                        $imp .= '<tr><td align="center">'.$Resultado->fields['nombrecarrera'].'</td><td align="center"><input type="checkbox" name="carrera[]" value="'.$Resultado->fields['codigocarrera'].'"> | <span onclick="carga_fechas(\''.$Resultado->fields['codigocarrera'].'\')">Ver fechas asignadas</span></td></tr>';					
                    }else{
                        $imp .= '<tr><td align="center">'.$Resultado->fields['nombrecarrera'].'</td><td align="center"><input type="checkbox" name="carrera[]" value="'.$Resultado->fields['codigocarrera'].'"></td></tr>';
                    }
                    $Resultado->MoveNext();
                }
            }
            $imp .= '</table>';
            $a_vectt['imp'] = $imp;			
            echo json_encode($a_vectt); 
        }break;
        case 'cargar_anteriores':{
            $carrera = $_REQUEST['codigocarrera'];
            $periodo = $_REQUEST['periodo'];
            $SQL = 'SELECT * FROM fechaacademica WHERE codigoperiodo = '.$periodo.' AND codigocarrera = '.$carrera.' LIMIT 1';
            if($Resultado=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'ERROR '.$SQL; 
            }else{
                $a_vectt['notas'] = $Resultado->fields['fechacortenotas'];
                $a_vectt['carga'] = $Resultado->fields['fechacargaacademica'];
                $a_vectt['inicial_pre'] = $Resultado->fields['fechainicialprematricula'];
                $a_vectt['final_pre'] = $Resultado->fields['fechafinalprematricula'];
                $a_vectt['inicial_pos'] = $Resultado->fields['fechainicialpostmatriculafechaacademica'];
                $a_vectt['final_pos'] = $Resultado->fields['fechafinalpostmatriculafechaacademica'];
                $a_vectt['inicial_pre_carrera'] = $Resultado->fields['fechainicialprematriculacarrera'];
                $a_vectt['final_pre_carrera'] = $Resultado->fields['fechafinalprematriculacarrera'];
                $a_vectt['inicial_retiro'] = $Resultado->fields['fechainicialretiroasignaturafechaacademica'];
                $a_vectt['final_retiro'] = $Resultado->fields['fechafinallretiroasignaturafechaacademica'];
                $a_vectt['inicial_orden'] = $Resultado->fields['fechainicialentregaordenpago'];
                $a_vectt['final_orden'] = $Resultado->fields['fechafinalentregaordenpago'];
                $a_vectt['final_orden_carrera'] = $Resultado->fields['fechafinalordenpagomatriculacarrera'];
            }
            echo json_encode($a_vectt); 
        }break;
        case 'cargar_periodo':{
            $modalidad = $_POST['modalidad'];
            
            if($modalidad == '800' || $modalidad == '810'){
                //consulta los periodos para pregrado virtual o postgrado viertual
                $SQLperiodo = "SELECT pv.CodigoPeriodo AS 'periodo'
                FROM PeriodoVirtualCarrera pvc 
                INNER JOIN PeriodosVirtuales pv ON ( pvc.idPeriodoVirtual = pv.IdPeriodoVirtual) 
                WHERE pvc.codigoModalidadAcademica = ".$modalidad." 
                AND pvc.codigoCarrera = 0 ORDER BY pv.CodigoPeriodo DESC";	
            }else{
                //consulta los periodos para pregrado, postgrado o educacion continuada
                $SQLperiodo = "SELECT codigoperiodo as 'periodo' FROM periodo ORDER BY codigoperiodo DESC";	
            }            
            $ResultadoPeriodo=$db->GetAll($SQLperiodo);
            
            $htmlperiodo="<option value='0'>Seleccione</option>";
            foreach($ResultadoPeriodo as $listado){
               $htmlperiodo.= '<option value="'.$listado['periodo'].'">'.$listado['periodo'].'</option>';
            }
            
            $a_vectt['periodo']= $htmlperiodo;
            echo json_encode($a_vectt);
        }break;
    }
?>