<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
class RotacionSubGrupos{
    public function Instituciones($db,$carrera){
        $SQL ="SELECT distinct c.ConvenioId as id, c.NombreConvenio as Nombre FROM Convenios c 
        inner join InstitucionConvenios ic on c.InstitucionConvenioId = ic.InstitucionConvenioId
        INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = ic.InstitucionConvenioId
        where c.idsiq_estadoconvenio = '1' and ic.idsiq_estadoconvenio = 1 ORDER BY c.NombreConvenio";
        if($Institucion=&$db->GetAll($SQL)===false){
             echo 'Error en el SQL de Institucion ...<br><br>'.$SQL;
             die;
          }      
          return $Institucion;        
    }//public function Instituciones
    public function CareraGrupo($db,$grupo,$op=''){ 
          $SQL='SELECT
                	m.codigocarrera,
                    CONCAT(m.nombremateria," :: ",m.codigomateria) AS NameMateria,
                    CONCAT(g.nombregrupo," :: ",g.idgrupo) AS NameGrupo,
                    m.codigomateria
                FROM
                	grupo g
                INNER JOIN materia m ON m.codigomateria = g.codigomateria
                WHERE
                	idgrupo ="'.$grupo.'"';
                    
         if($Carrera=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Carrera Grupo...<br><br>'.$SQL;
            die;
         }      
         
         if($op==1){ 
            $Data['NameMateria'] = $Carrera->fields['NameMateria'];
            $Data['NameGrupo']   = $Carrera->fields['NameGrupo'];
            $Data['codigomateria']   = $Carrera->fields['codigomateria'];
            
            return $Data;
         }else{
            return $Carrera->fields['codigocarrera'];
         }     
    }//public function CareraGrupo
    
    public function Diasopcionales($db, $SubGrupo)
    {
        $sqldiasopcionales = "SELECT d.DetalleRotacionId AS id, d.codigodia AS NumeroDia, d.codigoestado AS estadodia FROM DetalleRotaciones d INNER JOIN RotacionEstudiantes r ON r.RotacionEstudianteId = d.RotacionEstudianteId where r.SubgrupoId = '".$SubGrupo."'";
        
        $Diasopcionales=&$db->GetAll($sqldiasopcionales);
        /*if($Diasopcionales=&$db->GetAll($sqldiasopcionales)===false)
        {
            echo 'Error en el SQL de la dias Grupo...<br><br>';
            die;
        }*/
        foreach($Diasopcionales as $datosdias)
        {
            $DiasO[$datosdias['NumeroDia']] = $datosdias['estadodia'];
        }
        return $DiasO;
    }//public function Diasopcionales
    
    
    
    public function VerInstituciones($db,$id)
    {
        $sqlinstituciones = "select ic.InstitucionConvenioId, ic.NombreInstitucion, ui.IdUbicacionInstitucion, ui.NombreUbicacion FROM InstitucionConvenios ic INNER JOIN Convenios c ON c .InstitucionConvenioId = ic.InstitucionConvenioId INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = ic.InstitucionConvenioId where c.ConvenioId = '".$id."' ORDER BY ui.NombreUbicacion";
        $instituciones = $db->GetAll($sqlinstituciones);
        ?>
        <select id="LugarRotacion"  name="LugarRotacion" >
        <option value="-1" ></option>
        <?PHP
        foreach($instituciones as $lista)
        {
        ?>
        <option value="<?PHP echo $lista['InstitucionConvenioId']."-".$lista['IdUbicacionInstitucion'];?>"><?PHP echo $lista['NombreInstitucion']."-".$lista['NombreUbicacion'];?></option>
        <?PHP
        } 
        ?>
        </select>
        <?PHP
    }//public function VerConvenios
    public function Convenios($db,$id){
        $dato = explode('-',$id);
        
          $SQL='SELECT
                        ConvenioId,
                        NombreConvenio
                FROM
                        Convenios                
                WHERE
                        InstitucionConvenioId="'.$dato[0].'"
                        AND
                        idsiq_estadoconvenio IN(1,2)';
                        
             if($Convenios=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL;
                die;
             }  
             
          return $Convenios;            
    }//public function Convenios
    
    public function EliminarRotaccion ($db,$Datos)
    {        
        //$updateestado = "UPDATE RotacionEstudiantes SET codigoestado='200' WHERE (RotacionEstudianteId='".$Datos['eliminar']."')";
        $updateestado = "DELETE FROM RotacionEstudiantes WHERE (RotacionEstudianteId='".$Datos['rotacion']."')";        
        $resultados = $db->execute($updateestado);    

       //log auditoria
        $sqllog_anterior = "SELECT FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new from LogRotacionEstudiantes where RotacionEstudianteId ='".$Datos['rotacion']."' ORDER BY FechaActividad desc";
        $datos_old = $db->GetRow($sqllog_anterior);


        $sqllog = "INSERT INTO LogRotacionEstudiantes(RotacionEstudianteId, FechaIngreso_old, FechaEgreso_old, jornada_old, codigoperiodo_old, TotalDias_old, SubGrupoId_old, TotalHoras_old,
            UsuarioActividad, FechaActividad, TipoActividad) 
        values ('".$Datos['rotacion']."', '".$datos_old['FechaIngreso_new']."', '".$datos_old['FechaEgreso_new']."', '".$datos_old['jornada_new']."', '".$datos_old['codigoperiodo_new']."',
                '".$datos_old['TotalDias_new']."', '".$datos_old['SubGrupoId_new']."', '".$datos_old['TotalHoras_new']."', '".$Datos['user']."', NOW(), 'Delete')";
        $db->execute($sqllog);   
        
        $a_vectt['val']      = true;        
        echo json_encode($a_vectt);
        exit;
    }
    
    
    public function InsertRotacion($db,$Datos,$userid)
    {
        function limpiarCadena($cadena) {
            $cadena = (ereg_replace('[^ A-Za-z0-9_������������\s]', '', $cadena));
            return $cadena;
        }

        $SubGrupo      = $Datos['SubgrupoId'];
        $idgrupo       = $Datos['idgrupo'];
        $Fecha_1       = date("Y-m-d", strtotime($Datos['fechaingreso']));
        $Fecha_2       = date("Y-m-d", strtotime($Datos['fechaegreso']));
        $Lugar         = explode('-',$Datos['LugarRotacion']);
        $Convenio      = $Datos['Convenio'];
        $Estado        = $Datos['estadorotacion'];
        $Dias          = (int)$Datos['Totaldias'];
        $Jornada       = $Datos['Jornada'];
        $codigomateria = $Datos['codigomateria'];
        $Periodo       = $Datos['Periodo'];
        $Carrera       = $Datos['Carrera'];
        $DocenteCargo  = $Datos['docentecargo'];
        $DocenteEmail  = $Datos['docenteemail'];
        $DocenteCel    = $Datos['docentecel'];
        $TotalHoras    = $Datos['TotalHoras'];
        $Observacion   = $Datos['Observacion'];
        $especiliadades = $Datos['Especialidad'];//array

        if(isset($Datos['dia1'])){$codigodia[0]= '1';}
        if(isset($Datos['dia2'])){$codigodia[1]= '2';}
        if(isset($Datos['dia3'])){$codigodia[2]= '3';}
        if(isset($Datos['dia4'])){$codigodia[3]= '4';}
        if(isset($Datos['dia5'])){$codigodia[4]= '5';}
        if(isset($Datos['dia6'])){$codigodia[5]= '6';}
        if(isset($Datos['dia7'])){$codigodia[6]= '7';}
        
        $SubGrupo = limpiarCadena(filter_var($SubGrupo,FILTER_SANITIZE_NUMBER_INT));
        $idgrupo = limpiarCadena(filter_var($idgrupo,FILTER_SANITIZE_NUMBER_INT));
        $Convenio = limpiarCadena(filter_var($Convenio,FILTER_SANITIZE_NUMBER_INT));
        $Estado = limpiarCadena(filter_var($Estado,FILTER_SANITIZE_NUMBER_INT));
        $Dias = limpiarCadena(filter_var($Dias,FILTER_SANITIZE_NUMBER_INT));
        $Jornada = limpiarCadena(filter_var($Jornada,FILTER_SANITIZE_NUMBER_INT));
        $codigomateria = limpiarCadena(filter_var($codigomateria,FILTER_SANITIZE_NUMBER_INT));
        $Periodo = limpiarCadena(filter_var($Periodo,FILTER_SANITIZE_NUMBER_INT));
        $Carrera = limpiarCadena(filter_var($Carrera,FILTER_SANITIZE_NUMBER_INT));
        $DocenteCargo = limpiarCadena(filter_var($DocenteCargo,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $DocenteEmail = filter_var($DocenteEmail,FILTER_SANITIZE_EMAIL);
        $DocenteCel = limpiarCadena(filter_var($DocenteCel,FILTER_SANITIZE_NUMBER_INT));
        $TotalHoras = limpiarCadena(filter_var($TotalHoras,FILTER_SANITIZE_NUMBER_INT));
        $Observacion = limpiarCadena(filter_var($Observacion,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            
        //comvierte la lista de dias en un string para crear una consulta de sql 
        $listadias = implode("', '",$codigodia);
        $listaespecialidad = implode("', '",$especiliadades);
        //lista de estudiantes registrados en el grupo y en la carrera                
        $Estudiante = $this->DataEstudiantesSubGrupo($db,$SubGrupo,$Carrera);
        
        if($Datos['action_ID']== 'NewRotacionSubGrupo')
        {
            /*********************************************/
            //valida que un estudiante tenga una rotacion durante la mismas fechas y para la misma jornada
            $Conteo_validacion='0';
            foreach ($Estudiante as $lista ) 
            {
                $Validacion = $this->ValidarInfo($db,$lista['codigoestudiante'],$Fecha_1,$Fecha_2,$Jornada);            
                $Conteo_validacion += $Validacion;
            }
            /*********************************************/ 

            if($Conteo_validacion == '0')
            {
                for($i=0;$i<count($Estudiante);$i++)
                {
                    $Estudiante_id = $Estudiante[$i]['codigoestudiante'];

                    $Insert1='INSERT INTO RotacionEstudiantes (codigoestudiante,codigomateria,idsiq_convenio,IdUbicacionInstitucion,IdInstitucion,FechaIngreso,FechaEgreso,codigoestado,UsuarioCreacion,FechaCreacion,EstadoRotacionId,codigoperiodo,codigocarrera,TotalDias,JornadaId,SubgrupoId,FechaUltimaModificacion,UsuarioUltimaModificacion, TotalHoras)
                    VALUES("'.$Estudiante_id.'","'.$codigomateria.'","'.$Convenio.'","'.$Lugar[1].'","'.$Lugar[0].'","'.$Fecha_1.'","'.$Fecha_2.'",100,"'.$userid.'",NOW(),"'.$Estado.'","'.$Periodo.'","'.$Carrera.'","'.$Dias.'","'.$Jornada.'","'.$SubGrupo.'",NOW(),"'.$userid.'","'.$TotalHoras.'");';
                    if($InsertNew=$db->Execute($Insert1)===false)
                    {
                        $a_vectt['val']           =false;
                        $a_vectt['descrip']       ='Error al Insertar la Rotacion del Subgrupo';
                        echo json_encode($a_vectt);
                        exit;
                    }
                    $lastid = $db->insert_ID();

                    //logrotaciones                     
                    $sqllog = "INSERT INTO LogRotacionEstudiantes(RotacionEstudianteId, FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new, UsuarioActividad, FechaActividad, TipoActividad) 
                    values ('".$lastid."', '".$Fecha_1."', '".$Fecha_2."', '".$Jornada."', '".$Periodo."', '".$Dias."', '".$SubGrupo."', '".$TotalHoras."', '".$userid."', NOW(), 'Insert')";
                    $db->execute($sqllog);    

                    foreach($especiliadades as $listaespecialidades)
                    {
                        $sqlselect="select RotacionEspecialidadId, CodigoEstado from RotacionEspecialidades where RotacionEstudianteId='".$lastid."' and EspecialidadCarreraId='".$listaespecialidades."'";
                        $select = $db->GetRow($sqlselect);
                        //S� la especialidad exite 
                        if($select['RotacionEspecialidadId'])
                        {
                            //S� el codigo de estado es inactivo se ingresa para activarla
                            if($select['CodigoEstado']== '200')
                            {
                                $sqlupdate="UPDATE RotacionEspecialidades SET CodigoEstado='100' WHERE (RotacionEspecialidadId='".$select['RotacionEspecialidadId']."')";              
                                $update1 = $db->execute($sqlupdate);    
                            }//if
                        }else
                        {
                            $sqlinsert="INSERT INTO RotacionEspecialidades (RotacionEstudianteId, EspecialidadCarreraId, UsuarioCreacion, FechaCreacion, FechaUltimaModificacion, UsuarioUltimaModificacion, CodigoEstado) 
                            values ('".$lastid."', '".$listaespecialidades."', '".$userid."', NOW(), NOW(), '".$userid."', '100');";   
                            $insertespecialidad = $db->execute($sqlinsert);    
                        }//else
                    }
                    foreach($codigodia as $numerodia)
                    {
                        $sqlDetallerotacion = "INSERT INTO DetalleRotaciones (RotacionEstudianteId, codigodia, codigoestado, NombreDocenteCargo, EmailDocente, TelefonoDocente, UsuarioCreacion, FechaCreacion) 
                        VALUES ('".$lastid."', '".$numerodia."', '100', '".$DocenteCargo."', '".$DocenteEmail."' , '".$DocenteCel."', '".$userid."', NOW());";
                       if($Consultadetalle=$db->execute($sqlDetallerotacion)===false)
                        { 
                            $a_vectt['val']         =false;
                            $a_vectt['descrip']     ='La rotacion no fue agregada..';
                            echo json_encode($a_vectt);
                            exit;                      
                        }
                    }
                    $descrip="Se ha Almacenado de Forma Correcta."; 
                    $a_vectt['val']           =true; 
                } 
            }//validacion de registro
            else
            {
               $descrip = "La rotacion no se puede crear, las fechas ya se encuentran registradas.";
               $a_vectt['val']  =false; 
            }                   
        }//nueva rotacion 
        else
        {            
            if($Datos['action_ID']=='UpdateData')
            {
                for($i=0;$i<count($Estudiante);$i++)
                {
                    $Estudiante_id = $Estudiante[$i]['codigoestudiante'];

                    $sqlexite = "select RotacionEstudianteId, FechaIngreso, FechaEgreso from RotacionEstudiantes re where re.codigoestudiante = '".$Estudiante_id."' and codigomateria='".$codigomateria."' and idsiq_convenio ='".$Convenio."' and IdUbicacionInstitucion ='".$Lugar[1]."' and IdInstitucion='".$Lugar[0]."' and SubgrupoId='".$SubGrupo."'";                                             
                    $exiteestudiante = $db->GetRow($sqlexite);

                    $sqlFechas = "SELECT RotacionEstudianteId FROM RotacionEstudiantes WHERE codigoestudiante ='".$Estudiante_id."' AND codigoestado='100' AND EstadoRotacionId='1' AND RotacionEstudianteId <> '".$exiteestudiante['RotacionEstudianteId']."' AND (FechaIngreso BETWEEN '".$exiteestudiante['FechaIngreso']."' AND '".$exiteestudiante['FechaEgreso']."' or FechaEgreso BETWEEN '".$exiteestudiante['FechaIngreso']."' AND '".$exiteestudiante['FechaEgreso']."');";
                    $FechaExiste = $db->GetRow($sqlFechas);
                    
                    if($exiteestudiante['FechaIngreso'] == $Fecha_1 && $exiteestudiante['FechaIngreso'] == $Fecha_2 || $FechaExiste['RotacionEstudianteId'] == null)
                    {
                        //valida si existe una rotacion para el estudiante solicitado
                        if($exiteestudiante['RotacionEstudianteId'] && $Lugar[1] != 0)
                        {                            
                            $sqlupdaterotacion = "UPDATE RotacionEstudiantes SET TotalHoras='".$TotalHoras."', TotalDias='".$Dias."', EstadoRotacionId='".$Estado."', FechaUltimaModificacion=NOW(), UsuarioUltimaModificacion='".$userid."', JornadaId='".$Jornada."', FechaIngreso='".$Fecha_1."', FechaEgreso='".$Fecha_2."' WHERE (RotacionEstudianteId='".$exiteestudiante['RotacionEstudianteId']."')";                            
                            $updatere = $db->execute($sqlupdaterotacion);
                            
                            /*********************************************/                             //log auditoria
                            $sqllog_anterior = "SELECT FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new,  SubGrupoId_new, TotalHoras_new from LogRotacionEstudiantes where RotacionEstudianteId ='".$exiteestudiante['RotacionEstudianteId']."' ORDER BY FechaActividad desc";                                                       
                           $datos_old = $db->GetRow($sqllog_anterior);                            

                            $sqllog =  "INSERT INTO LogRotacionEstudiantes(RotacionEstudianteId, FechaIngreso_old, FechaEgreso_old, jornada_old, codigoperiodo_old, TotalDias_old,  SubGrupoId_old, TotalHoras_old, FechaIngreso_new, FechaEgreso_new, jornada_new, codigoperiodo_new, TotalDias_new, SubGrupoId_new, TotalHoras_new, UsuarioActividad, FechaActividad, TipoActividad, Observacion)values ('".$exiteestudiante['RotacionEstudianteId']."', '".$datos_old['FechaIngreso_new']."', '".$datos_old['FechaEgreso_new']."', '".$datos_old['jornada_new']."', '".$datos_old['codigoperiodo_new']."', '".$datos_old['TotalDias_new']."', '".$datos_old['SubGrupoId_new']."', '".$datos_old['TotalHoras_new']."', '".$Fecha_1."',  '".$Fecha_2."', '".$Jornada."', '".$Periodo."', '".$Dias."', '".$SubGrupo."',  '".$TotalHoras."', '".$userid."',  NOW(), 'Update', '".$Observacion."')";
                            $db->execute($sqllog);                            
                            /*********************************************/
                            foreach($codigodia as $dia)
                            {                                
                                $sqlvalidacion = "select DetalleRotacionId from DetalleRotaciones where codigodia='".$dia."' and RotacionEstudianteId='".$exiteestudiante['RotacionEstudianteId']."'";                                
                                $validacionsql = $db->GetRow($sqlvalidacion);
                                if($validacionsql['DetalleRotacionId'])
                                {
                                    $sqlupdatedetallerotacion ="UPDATE DetalleRotaciones SET codigodia='".$dia."', codigoestado='100', NombreDocenteCargo='".$DocenteCargo."', EmailDocente='".$DocenteEmail."', Telefonodocente='".$DocenteCel."', UsuarioModificacion ='".$userid."', FechaModificacion =NOW() 
                                    WHERE (DetalleRotacionId = '".$validacionsql['DetalleRotacionId']."')";
                                    $update = $db->execute($sqlupdatedetallerotacion);    
                                }else
                                {
                                    $sqlDetallerotacion = "INSERT INTO DetalleRotaciones (RotacionEstudianteId, codigodia, codigoestado, NombreDocenteCargo, EmailDocente, TelefonoDocente, UsuarioCreacion, FechaCreacion) VALUES ('".$exiteestudiante['RotacionEstudianteId']."', '".$dia."', '100', '".$DocenteCargo."', '".$DocenteEmail."' , '".$DocenteCel."', '".$userid."', NOW());";
                                    $Consultadetalle=$db->execute($sqlDetallerotacion);
                                } 
                            }//foreach lista dias                            
                            $sqldetallerotaciones = "select DetalleRotacionId from DetalleRotaciones where RotacionEstudianteId = '".$exiteestudiante['RotacionEstudianteId']."' and codigodia not in ('".$listadias."')";                            
                            $listadesactivar = $db->GetAll($sqldetallerotaciones);
                            //se desactivan los dias que no se actuivaron y ya existian.
                            foreach($listadesactivar as $desactivar)
                            {                                
                               $sqlupdatedetallerotacion ="UPDATE DetalleRotaciones SET codigoestado='200', FechaModificacion=NOW(), UsuarioModificacion='".$userid."' WHERE (DetalleRotacionId = '".$desactivar['DetalleRotacionId']."')";                               
                               $update = $db->execute($sqlupdatedetallerotacion);    
                            }
                            //ingreso para registro de los servicios o especilidades de los estudiantes de la rotacion
                            foreach($especiliadades as $listaespecialidades)
                            {
                                //consulta si exite una especiliadad creada y consulta su id y el estado
                                $sqlselect="select RotacionEspecialidadId, CodigoEstado from RotacionEspecialidades where RotacionEstudianteId='".$exiteestudiante['RotacionEstudianteId']."' and EspecialidadCarreraId='".$listaespecialidades."'";                                
                                $select = $db->GetRow($sqlselect);                                
                                
                                //S� la especialidad exite 
                                if(!empty($select['RotacionEspecialidadId']))
                                {
                                    //S� el codigo de estado es inactivo se ingresa para activarla
                                    if($select['CodigoEstado']== '200')
                                    {
                                        $sqlupdate="UPDATE RotacionEspecialidades SET CodigoEstado='100' WHERE (RotacionEspecialidadId='".$select['RotacionEspecialidadId']."')";          
                                        $update1 = $db->execute($sqlupdate);    
                                    }//if
                                }else
                                {
                                    $sqlinsert="INSERT INTO RotacionEspecialidades (RotacionEstudianteId, EspecialidadCarreraId, UsuarioCreacion, FechaCreacion, FechaUltimaModificacion, UsuarioUltimaModificacion, CodigoEstado) values ('".$exiteestudiante['RotacionEstudianteId']."', '".$listaespecialidades."', '".$userid."', NOW(), NOW(), '".$userid."', '100');";
                                    $insertespecialidad = $db->execute($sqlinsert);    
                                }//else                                
                                
                            }//foreach lista especialidades
                            //consulta las especialidades que no se crearon o actualizaron en el anterior proceso y cambia su estado a inactiva  
                            $sqlupdateespecialidades = "select RotacionEspecialidadId from RotacionEspecialidades where RotacionEstudianteId = '".$exiteestudiante['RotacionEstudianteId']."' and EspecialidadCarreraId not in ('".$listaespecialidad."')";
                            $consultaespecial = $db->GetAll($sqlupdateespecialidades);
                            foreach($consultaespecial as $listadesactivar)
                            {
                                $sqlupdate="UPDATE RotacionEspecialidades SET CodigoEstado='200' WHERE (RotacionEspecialidadId='".$listadesactivar['RotacionEspecialidadId']."')";
                                $update2 = $db->execute($sqlupdate);    
                            }
                        }//if exite estudiante 
                        else
                        {
                            //sin no existe validacion de la informacion,  nuevamente se busca el lugar de rotacion.
                             $sqlexite2 = "select RotacionEstudianteId from RotacionEstudiantes re where re.codigoestudiante = '".$Estudiante_id."' and codigomateria='".$codigomateria."' and idsiq_convenio ='".$Convenio."' and SubgrupoId='".$SubGrupo."'";                                                                                 
                            $exiteestudiante2 = $db->GetRow($sqlexite2);
                                                    
                            $consultainstitucion = "select u.IdUbicacionInstitucion from UbicacionInstituciones u where u.InstitucionConvenioId = '".$Lugar[0]."'";
                            $ubicaciones = $db->GetAll($consultainstitucion); 

                            $d=0;
                            foreach($ubicaciones as $lugares)
                            {
                                if($lugares['IdUbicacionInstitucion'] == $Lugar[1])
                                {
                                    $updateinstitucion = "UPDATE RotacionEstudiantes SET IdInstitucion='".$Lugar[0]."', IdUbicacionInstitucion='".$Lugar[1]."'  WHERE (RotacionEstudianteId='".$exiteestudiante2['RotacionEstudianteId']."')";                                                           
                                    $db->execute($updateinstitucion);
                                    $d++;
                                }
                            }
                            if($d==0)
                            {
                                $updateinstitucion = "UPDATE RotacionEstudiantes SET IdInstitucion='".$Lugar[0]."', IdUbicacionInstitucion='".$ubicaciones[0][0]."'  WHERE (RotacionEstudianteId='".$exiteestudiante2['RotacionEstudianteId']."')";                        
                                $db->execute($updateinstitucion);                            
                                $d++;
                            }                        
                        }
                        $descrip = "Se ha actualizado correctamente la rotacion.";
                        $a_vectt['val']           =true;
                    }//fecha de ingreso diferentes
                    else
                    {                        
                        $descrip = "La rotacion no se puede crear, las fechas ya se encuentran registradas.";
                        $a_vectt['val']  =false; 
                    }
                }
            }// update data
        }
        $a_vectt['descrip']       =$descrip;
        $a_vectt['grupo']         =$idgrupo;
        $a_vectt['materia']       =$codigomateria;
    
        echo json_encode($a_vectt);
        exit;
    }//public function InsertRotacion
    public function DataEstudiantesSubGrupo($db,$SubGrupo,$Carrera){
          $SQL='SELECT
                	s.idestudiantegeneral,
                    e.codigoestudiante,
                    e.codigocarrera
                FROM
                	SubgruposEstudiantes s INNER JOIN estudiante e ON  e.idestudiantegeneral=s.idestudiantegeneral 
                WHERE
                	SubgrupoId ="'.$SubGrupo.'"
                    AND 
                    codigoestado = 100
                    AND
                    e.codigocarrera="'.$Carrera.'"';
                
          if($Estudiante=&$db->GetAll($SQL)===false){
            $a_vectt['val']			  =false;
            $a_vectt['descrip']		  ='Error al Consultar Subgrupo Estudiante';
            echo json_encode($a_vectt);
            exit;
          }
          
          return $Estudiante;      
    }//public function DataEstudiantesSubGrupo
    public function ValidacionFechas($Fecha_1,$Fecha_2,$fecha_3){ 
        
        $start_ts = strtotime($Fecha_1);
        $end_ts   = strtotime($Fecha_2);
        $user_ts  = strtotime($fecha_3);
        
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts)); 
        
        //return (($Fecha_A >= $Fecha_In) && ($Fecha_A <= $Fecha_Fi));
    }//public function ValidacionFechas
    public function Jornadas($db){
          $SQL="SELECT
                        JornadaRotacionesId AS id,
                        Jornada
                FROM
                        JornadaRotaciones
                WHERE
                        CodigoEstado='100' order by Jornada";
                        
          $Jornada=$db->GetAll($SQL);
          return $Jornada;             
    }//public function Jornadas
   public function Espcialidad($db,$carrera){
          $SQL='SELECT EspecialidadCarreraId AS id, Especialidad FROM EspecialidadCarrera WHERE codigocarrera ="'.$carrera.'" AND CodigoEstado = 100';
                
          if($Especialidad=&$db->GetAll($SQL)===false){
             Echo 'Error en el SQL de la Espcialidad Carrrea...<br><br>'.$SQL;
             die;
          }      
          $t=0;
          $c=1;
          foreach($Especialidad as $numero)
          {
            $Especialidad[$t]['numero'] = $c;
            $t++;
            $c++;
          }
          return $Especialidad;
   }//public function Espcialidad
   public function ValidarInfo($db,$Estudiante,$Fecha_1,$Fecha_2,$Jornada){
        $contador = '0';
        $i= '0';
        $SQLjornada="SELECT DISTINCT JornadaId
                FROM
                	RotacionEstudiantes
                WHERE
                	codigoestudiante ='".$Estudiante."'
                AND 
                  codigoestado='100'
                AND
                 EstadoRotacionId='1'
                AND
                (FechaIngreso BETWEEN '".$Fecha_1."' AND '".$Fecha_2."'
                or
                FechaEgreso BETWEEN '".$Fecha_1."' AND '".$Fecha_2."');";
        $DataEstudiante=$db->GetAll($SQLjornada);
        $jornadas = count($DataEstudiante);
        //echo $SQLjornada.'--'.$DataEstudiante['JornadaId'].'--'.$jornadas.'///';
        if($jornadas != 0)
        {
            foreach ($DataEstudiante as $C_Data)
            {
                $Jornada_Old = $C_Data[$i]['JornadaId'];
                if($Jornada == $Jornada_Old || $Jornada_Old == '1' && $Jornada == '5' || $Jornada_Old == '5' && $Jornada == '1' || $Jornada_Old == '2' && $Jornada== '7' || $Jornada_Old == '7' && $Jornada== '2')
                {
                    $contador=1;                    
                }                
                $i++;
            }
        }        
        return $contador;        
   }//public function ValidarInfo
   public function ListCruce($db,$Estudiantes){
    ?>
    <table> 
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Estudiante</th>
                <th>N&deg; Documento</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Egreso</th>
                <th>Jornada</th>
            </tr>
        </thead>
        <tbody>
           <?PHP 
           for($i=0;$i<count($Estudiantes);$i++){
                $Data = $this->InfoEstudiante($db,$Estudiantes[$i]['id']);
                ?>
                <tr>
                    <td><?PHP echo $i+1;?></td>
                    <td><?PHP echo $Data[0]['nameEstudiante']?></td>
                    <td><?PHP echo $Data[0]['numerodocumento']?></td>
                    <td><?PHP echo $Data[0]['FechaIngreso']?></td>
                    <td><?PHP echo $Data[0]['FechaEgreso']?></td>
                    <td><?PHP echo $Data[0]['Jornada']?></td>
                </tr>
                <?PHP
           }//for
           ?> 
        </tbody>
    </table>
    <?PHP
   }//public function ListCruce
   public function InfoEstudiante($db,$id){
          $SQL='SELECT
                        r.FechaIngreso,
                        r.FechaEgreso,
                        r.JornadaId,
                        CONCAT(e.nombresestudiantegeneral," ",e.apellidosestudiantegeneral) AS nameEstudiante,
                        e.numerodocumento,
                        r.SubgrupoId,
                        j.Jornada
                FROM
                        RotacionEstudiantes r INNER JOIN estudiantegeneral e ON e.idestudiantegeneral=r.idestudiantegeneral
                                              INNER JOIN JornadaRotaciones j ON j.JornadaRotacionesId=r.JornadaId
                WHERE
                        r.idestudiantegeneral = "'.$id.'"
                        AND r.codigoestado = 100
                        AND r.EstadoRotacionId = 1
                
                GROUP BY r.SubgrupoId';
                
         if($Data=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL de la Data Estudiante...<br><br>'.$SQL;
            die;
         }       
         return $Data;
   }//public function InfoEstudiante
}//class
?>