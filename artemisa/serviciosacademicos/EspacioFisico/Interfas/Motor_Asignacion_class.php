<?php

class MotorAsignacion{
    public function Display($db){
        ?>
        <script>
        $(function() {
            $( "#tabs" ).tabs();
        });
        
        </script>
        <div id="container">
           <h2>Motor de Asignaci&oacute;n de  Espacios F&iacute;sicos</h2>
            <div id="tabs" style="margin-left: 10px;">
                <ul>
                    <li><a href="#tabs-1" style="cursor: pointer;">N&deg; de Estudiantes</a></li>
                    <li><a href="#tabs-2" style="cursor: pointer;">Programa acad&eacute;mico</a></li>
                    <li><a href="#tabs-3" style="cursor: pointer;">Materia</a></li>
                    <li><a href="#tabs-4" style="cursor: pointer;">Todo</a></li>
                </ul>
                <div id="tabs-1">
                    <form id="NumEstudiante">
                        <?PHP $this->NumEstudiante($db);?>
                    </form>
                </div>
                <div id="tabs-2">
                    <form id="Programa">
                        <?PHP $this->PorPrograma($db);?>
                    </form>
                </div>
                <div id="tabs-3">
                    <form id="Materia">
                        <?PHP $this->PorMateria($db);?>
                    </form>
                </div>
                <div id="tabs-4">
                    <form id="All">
                        <?PHP $this->Todo($db);?>
                    </form>
                </div>
                <div id="DataView"></div>
            </div>
        </div>
        <?PHP
    }//public function Display
    public function Todo($db){
        ?>
        <fieldset>
            <div>
                <input type="hidden" id="actionID" name="actionID" />
                <table>
                    <tr>
                        <td>Sedes</td>
                        <td>
                            <?PHP $this->Sedes($db);?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" id="BuscarNum" name="BuscarNum" onclick="SolicitudDatta(4)" value="Buscar..." />
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <?PHP
    }//public function Todo
    public function Sedes($db){
        $SQL='select ClasificacionEspaciosId,Nombre from ClasificacionEspacios where EspaciosFisicosId = 3 AND codigoestado = 100';
        
        if($Sedes=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Sedes....<br><br>'.$SQL;
            die;
        }
        ?>
        <select id="Sedes" name="Sedes">
            <option value="-1">Todo</option>
        <?PHP
        while(!$Sedes->EOF){
            ?>
            <option value="<?PHP echo $Sedes->fields['ClasificacionEspaciosId']?>"><?PHP echo $Sedes->fields['Nombre']?></option>p
            <?PHP
            $Sedes->MoveNext();
        }
        ?>
        </select>
        <?PHP
    }//public function Sedes
    public function NumEstudiante($db){
        ?>
        <fieldset>
            <div>
                <input type="hidden" id="actionID" name="actionID" />
                <table>
                    <thead>
                    <tr>
                        <th>Maximo Cupo</th>
                        <th>Matriculados</th>
                        <th>Prematriculados</th>
                        <th>Matriculados y Prematriculados</th>
                    </tr>
                    <tr>
                        <th><input type="radio" name="TypeBuscar" id="Cupo" value="1"/></th>
                        <th><input type="radio" name="TypeBuscar" id="matriculados" value="2" /></th>
                        <th><input type="radio" name="TypeBuscar" id="prematriculados" value="3" /></th>
                        <th><input type="radio" name="TypeBuscar" id="MatriPrema" value="4" /></th>
                    </tr>
                    <tr>
                        <th colspan="2">Numero de Estudiantes a Buscar</th>
                        <th colspan="2">&nbsp;&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="4">
                            <table style="width: 100%;">
                                <tr>
                                    <th>
                                        <input type="text" maxlength="3" placeholder="Valor 1" name="Num_1" id="Num_1" style="text-align: center;" onkeydown="return validarNumeros(event)" />
                                    </th>
                                    <th>a</th>
                                    <th>
                                        <input type="text" maxlength="3" placeholder="Valor 2" name="Num_2" id="Num_2" style="text-align: center;" onkeydown="return validarNumeros(event)" />
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" style="text-align: right;">
                            <input type="button" id="BuscarNum" name="BuscarNum" onclick="SolicitudDatta(1)" value="Buscar..." />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </fieldset>
        <?PHP
    }//public function NumEstudiante
    public function PorPrograma($db){
        ?>
        <fieldset>
            <div>
                <input type="hidden" id="actionID" name="actionID" />
                <table>
                    <thead>
                    <tr>
                        <th>Modalidad Acad&eacute;mica</th>
                        <th><?PHP $this->Modalidad($db,'BuscarPrograma','Programa');?></th>
                    </tr>
                    <tr>
                        <th>Programa Acad&eacute;mico</th>
                        <th id="Th_Programa">
                            <select id="Programa" name="Programa">
                                <option value="-1"></option>
                            </select>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: right;">
                                <input type="button" id="BuscarXPrograma" name="BuscarXPrograma" value="Buscar..." onclick="SolicitudDatta(2)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <?PHP
    }//public function PorPrograma
    public function PorMateria($db){
        ?>
        <fieldset>
            <div>
               <input type="hidden" id="actionID" name="actionID" />
                <table>
                    <thead>
                    <tr>
                        <th>Modalidad Acad&eacute;mica</th>
                        <th><?PHP $this->Modalidad($db,'BuscarPrograma','Materia');?></th>
                        <th colspan="2">&nbsp;</th>
                    </tr>
                    <tr>
                        <th>Programa Acad&eacute;mico</th>
                        <th id="Th_Programa">
                            <select id="Programa" name="Programa">
                                <option value="-1"></option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th>Materia</th>
                        <th id="Th_Materia">
                            <select id="Materia" name="Materia">
                                <option value="-1"></option>
                            </select>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: right;">
                                <input type="button" id="BuscarXMateria" name="BuscarXMateria" value="Buscar..." onclick="SolicitudDatta(3)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <?PHP
    }//public function PorMateria
    public function Modalidad($db,$funcion,$form){
         $SQL='SELECT 
                
                codigomodalidadacademica AS id,
                nombremodalidadacademica AS Nombre
                
                FROM modalidadacademica
                
                WHERE
                
                codigoestado=100';
                
          if($Modalidad=&$db->Execute($SQL)===false){
            echo 'Error en el SQL Modalidad....<br><br>'.$SQL;
            die;
          }
        ?>
        <select id="Modalidad" name="Modalidad" onchange="<?PHP echo $funcion?>('<?PHP echo $form?>');">
            <option value="-1"></option>
            <?PHP
            while(!$Modalidad->EOF){
                ?>
                <option value="<?PHP echo $Modalidad->fields['id']?>"><?PHP echo $Modalidad->fields['Nombre']?></option>
                <?PHP
                $Modalidad->MoveNext();
            }
            ?>
        </select> 
        <?PHP
    }//public function Modalidad
    public function ProgramaAcademico($db,$Modalidad,$Op='',$userid=''){
        
        $SQL='SELECT 

                codigocarrera AS id,
                nombrecarrera AS Nombre
                
                FROM carrera
                
                WHERE
                
                codigomodalidadacademica="'.$Modalidad.'"
                AND fechavencimientocarrera > Now()
                ORDER BY  nombrecarrera ASC';
                
          if($Programa=&$db->Execute($SQL)===false){
                echo 'Error En el SQL .....<br><br>'.$SQL;
                die;
          }   
          
          $DataPrograma = $Programa->GetArray();
        
        if(!$Op){  
          $Data = $this->SolicitudCarrera($db,$Modalidad,$userid);
          
         
        ?>
        <select id="ProgramaAcade" name="ProgramaAcade">
            <option value="-1"></option>
            <?PHP 
               for($i=0;$i<count($DataPrograma);$i++){
                if($Data[$DataPrograma[$i]['id']]){
                    ?>
                    <option value="<?PHP echo $DataPrograma[$i]['id']?>"><?PHP echo $DataPrograma[$i]['Nombre'].'&nbsp;&nbsp;::&nbsp;&nbsp;'.$Data[$DataPrograma[$i]['id']]['valor']?></option>
                    <?PHP
                   }
                }//for
            ?>
        </select>
        <?PHP
        }else{
           ?>
            <select id="ProgramaAcade" name="ProgramaAcade" onchange="BuscarMateria()">
                <option value="-1"></option>
                <?PHP 
                   for($i=0;$i<count($DataPrograma);$i++){
                        ?>
                        <option value="<?PHP echo $DataPrograma[$i]['id']?>"><?PHP echo $DataPrograma[$i]['Nombre'];?></option>
                        <?PHP                        
                    }//for
                ?>
            </select>
           <?PHP 
        }
    }//public function ProgramaAcademico
     public function SolicitudCarrera($db,$Modalidad,$userid){
        include_once('InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
        
        $Fechas = $C_InterfazSolicitud->FechasPeriodo($db);
        
        if($Fechas['val']==true){
            $C_fecha = explode('-',$Fechas['FechaFin']);
           if($C_fecha[1]==06 || $C_fecha[1]=='06'){
                $Fechaini_2 = $C_fecha[0].'-07-01';
                $Fechafin_2 = $C_fecha[0].'-12-31';
            }if($C_fecha[1]==12 || $C_fecha[1]=='12'){
                $year       = $C_fecha[0]+1;
                $Fechaini_2 = $year.'-01-01';
                $Fechafin_2 = $year.'-06-30';
            }
             $CondicionFecha = ' AND (s.FechaInicio>="'.$Fechas['FechaIni'].'" )';//AND s.FechaFinal<="'.$Fechas['FechaFin'].'"  OR  s.FechaInicio>="'.$Fechaini_2.'" AND s.FechaFinal<="'.$Fechafin_2.'"
             //$CondicionFecha = '';
        }else{
            $CondicionFecha = '';
        }
        
             $SQL='SELECT
                    	p.SolicitudPadreId,
                    	c.codigocarrera,
                    	c.nombrecarrera
                    FROM
                    	SolicitudPadre p
                    INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = p.SolicitudPadreId
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                    INNER JOIN carrera c ON c.codigocarrera = s.codigocarrera                    
                    INNER JOIN SolicitudAsignacionEspaciostiposalon t ON t.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN ResponsableEspacioFisico r ON r.CodigoTipoSalon=t.codigotiposalon
                    
                    WHERE
                    	p.CodigoEstado = 100
                    AND s.codigoestado = 100
                    AND s.codigomodalidadacademica = 001
                    '.$CondicionFecha.'
                    AND c.codigomodalidadacademica="'.$Modalidad.'"
                    AND r.UsuarioId="'.$userid.'"
                    AND r.CodigoEstado=100
                    
                    GROUP BY
                    	p.SolicitudPadreId
                    ORDER BY 
                        c.codigocarrera';
                        
                
            if($SolicituCarrera=&$db->GetAll($SQL)===false){
                echo 'Error en el SQL ....<br><br>'.$SQL;
                die;
            } 
            
            $x = 0;  
            
            for($i=0;$i<count($SolicituCarrera);$i++){
                  $SQL='SELECT
                                s.SolicitudAsignacionEspacioId
                        FROM
                                AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                        WHERE
                        
                                a.SolicitudPadreId ="'.$SolicituCarrera[$i]['SolicitudPadreId'].'"
                                AND
                                s.codigoestado=100
                        
                        GROUP BY s.SolicitudAsignacionEspacioId';
                        
                   if($SolicitudHijos=&$db->GetAll($SQL)===false){
                        echo 'Error en el SQL de Solicitud Hijos...<br><br>'.$SQL;
                        die;
                   }    
                   
                   $O=0;
                   $N=0; 
                   for($j=0;$j<count($SolicitudHijos);$j++){
                    
                        $Hijo = $SolicitudHijos[$j]['SolicitudAsignacionEspacioId'];
                        
                        $SQL_X='SELECT
                                     a.ClasificacionEspaciosId
                                FROM 
                                     AsignacionEspacios a
                                
                                WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Hijo.'"';
                                
                                if($Info=&$db->Execute($SQL_X)===false){
                                    echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                                    die;
                                }
                                   
                              while(!$Info->EOF){
                                /************************************/
                                if($Info->fields['ClasificacionEspaciosId']!=212){
                                    $O = $O+1;//Asignadas
                                }else{
                                    $N = $N+1;//Sin Asignar
                                }
                                /************************************/
                                $Info->MoveNext();
                              }   
                   }//for 
                   
                   if($O<1 && $N>1){
                      
                       $echo[$x]['id'] =  $SolicituCarrera[$i]['SolicitudPadreId'];
                       $echo[$x]['codigocarrera'] =  $SolicituCarrera[$i]['codigocarrera'];
                       if($Data[$SolicituCarrera[$i]['codigocarrera']]){
                                
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['codigocarrera']    =  $SolicituCarrera[$i]['codigocarrera'];
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['nombrecarrera']    =  $SolicituCarrera[$i]['nombrecarrera'];
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['valor']++;
                       }else{
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['codigocarrera']    =  $SolicituCarrera[$i]['codigocarrera'];
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['nombrecarrera']    =  $SolicituCarrera[$i]['nombrecarrera'];
                                $Data[$SolicituCarrera[$i]['codigocarrera']]['valor']            =  1;
                       }
                       
                       $x++;
                   }//if
            }//for   
            
            
            
         //  echo '<pre>';print_r($echo);die;
          
          Return $Data;  
    }//public function SolicitudCarrera
    public function SolicitudMateria($db,$Carrera){
        include_once('InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
        
        $Fechas = $C_InterfazSolicitud->FechasPeriodo($db);
        
        if($Fechas['val']==true){
            $C_fecha = explode('-',$Fechas['FechaFin']);
           if($C_fecha[1]==06 || $C_fecha[1]=='06'){
                $Fechaini_2 = $C_fecha[0].'-07-01';
                $Fechafin_2 = $C_fecha[0].'-12-31';
            }if($C_fecha[1]==12 || $C_fecha[1]=='12'){
                $year       = $C_fecha[0]+1;
                $Fechaini_2 = $year.'-01-01';
                $Fechafin_2 = $year.'-06-30';
            }
             $CondicionFecha = ' AND (s.FechaInicio>="'.$Fechas['FechaIni'].'" )';//AND s.FechaFinal<="'.$Fechas['FechaFin'].'"  OR  s.FechaInicio>="'.$Fechaini_2.'" AND s.FechaFinal<="'.$Fechafin_2.'"
             //$CondicionFecha = '';
        }else{
            $CondicionFecha = '';
        }
        
              $SQL='SELECT
                    	p.SolicitudPadreId,
                    	s.SolicitudAsignacionEspacioId AS id,
                    	sg.idgrupo,
                    	m.codigomateria,
                    	m.nombremateria,
                        s.codigocarrera
                    FROM
                    	SolicitudPadre p
                    INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = p.SolicitudPadreId
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                    INNER JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                    INNER JOIN grupo g ON g.idgrupo = sg.idgrupo
                    INNER JOIN materia m ON m.codigomateria = g.codigomateria 
                    INNER JOIN SolicitudAsignacionEspaciostiposalon t ON t.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN ResponsableEspacioFisico r ON r.CodigoTipoSalon=t.codigotiposalon
                    WHERE
                    	p.CodigoEstado = 100
                    AND s.codigoestado = 100
                    AND s.codigomodalidadacademica = 001
                    '.$CondicionFecha.'
                    AND r.UsuarioId=4186
                    AND r.CodigoEstado=100
                    AND m.codigocarrera = "'.$Carrera.'"
                    GROUP BY
                    	p.SolicitudPadreId
                    ORDER BY
                    	m.codigomateria';
                
          if($DatosMateria=&$db->GetAll($SQL)===false){
            echo 'Error en el SQL ....<br><br>'.$SQL;
            die;
          }    
          
          for($i=0;$i<count($DatosMateria);$i++){
            $Padre = $DatosMateria[$i]['SolicitudPadreId'];
            
              $SQL='SELECT
                            s.SolicitudAsignacionEspacioId
                    FROM
                            AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                    WHERE
                    
                            a.SolicitudPadreId ="'.$Padre.'"
                            AND
                            s.codigoestado=100
                    
                    GROUP BY s.SolicitudAsignacionEspacioId';
                    
               if($SolicitudHijos=&$db->GetAll($SQL)===false){
                    echo 'Error en el SQL de Solicitud Hijos...<br><br>'.$SQL;
                    die;
               }    
               
               $O=0;
               $N=0; 
               for($j=0;$j<count($SolicitudHijos);$j++){
                
                    $Hijo = $SolicitudHijos[$j]['SolicitudAsignacionEspacioId'];
                    
                    $SQL_X='SELECT
                                 a.ClasificacionEspaciosId
                            FROM 
                                 AsignacionEspacios a
                            
                            WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Hijo.'"';
                            
                            if($Info=&$db->Execute($SQL_X)===false){
                                echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                                die;
                            }
                               
                          while(!$Info->EOF){
                            /************************************/
                            if($Info->fields['ClasificacionEspaciosId']!=212){
                                $O = $O+1;//Asignadas
                            }else{
                                $N = $N+1;//Sin Asignar
                            }
                            /************************************/
                            $Info->MoveNext();
                          }   
               }//for 
               
               if($O<1 && $N>1){
                  
                   $echo[$x]['id'] =  $Padre;
                   $echo[$x]['codigomateria'] =  $DatosMateria[$i]['codigocarrera'];
                   if($Data[$DatosMateria[$i]['codigomateria']]){
                            
                            $Data[$DatosMateria[$i]['codigomateria']]['codigocarrera']    =  $DatosMateria[$i]['codigocarrera'];
                            $Data[$DatosMateria[$i]['codigomateria']]['nombremateria']    =  $DatosMateria[$i]['nombremateria'];
                            $Data[$DatosMateria[$i]['codigomateria']]['codigomateria']    =  $DatosMateria[$i]['codigomateria'];
                            $Data[$DatosMateria[$i]['codigomateria']]['valor']++;
                   }else{
                            $Data[$DatosMateria[$i]['codigomateria']]['codigocarrera']    =  $DatosMateria[$i]['codigocarrera'];
                            $Data[$DatosMateria[$i]['codigomateria']]['nombremateria']    =  $DatosMateria[$i]['nombremateria'];
                            $Data[$DatosMateria[$i]['codigomateria']]['codigomateria']    =  $DatosMateria[$i]['codigomateria'];
                            $Data[$DatosMateria[$i]['codigomateria']]['valor']            =  1;
                   }
                   
                   $x++;
               }//if
          }//for  
          
            $SQL_M='SELECT
                    codigomateria
                    FROM
                    materia
                    WHERE
                    codigocarrera="'.$Carrera.'"';
                    
            if($Materias=&$db->GetAll($SQL_M)===false){
                echo 'Error en el SQL de Materia Data...<br><br>'.$SQL;
                die;
            }        
          
          ?>
          <select id="Materia" name="Materia">
            <option value="-1"></option>
            <?PHP 
            for($j=0;$j<count($Materias);$j++){
                if($Data[$Materias[$j]['codigomateria']]){
                    ?>
                    <option value="<?PHP echo $Data[$Materias[$j]['codigomateria']]['codigomateria']?>"><?PHP echo $Data[$Materias[$j]['codigomateria']]['nombremateria'].'&nbsp;&nbsp;::&nbsp;&nbsp;'.$Data[$Materias[$j]['codigomateria']]['valor']?></option>
                    <?PHP
                }
            }
            ?>
          </select>
          <?PHP
    }//public function SolicitudMateria
    public function BuscarDataReporte($db,$data,$op,$userid){
        include_once('InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
        
        $Fechas = $C_InterfazSolicitud->FechasPeriodo($db);
        
        if($Fechas['val']==true){
            $C_fecha = explode('-',$Fechas['FechaFin']);
           if($C_fecha[1]==06 || $C_fecha[1]=='06'){
                $Fechaini_2 = $C_fecha[0].'-07-01';
                $Fechafin_2 = $C_fecha[0].'-12-31';
            }if($C_fecha[1]==12 || $C_fecha[1]=='12'){
                $year       = $C_fecha[0]+1;
                $Fechaini_2 = $year.'-01-01';
                $Fechafin_2 = $year.'-06-30';
            }
             $CondicionFecha = ' AND (s.FechaInicio>="'.$Fechas['FechaIni'].'" )';//AND s.FechaFinal<="'.$Fechas['FechaFin'].'"  OR  s.FechaInicio>="'.$Fechaini_2.'" AND s.FechaFinal<="'.$Fechafin_2.'"
             //$CondicionFecha = '';
        }else{
            $CondicionFecha = '';
        }
           $SQL='SELECT
                    	sp.SolicitudPadreId,
                    	a.SolicitudAsignacionEspaciosId,
                    	s.SolicitudAsignacionEspacioId,
                    	DATE(s.FechaInicio),
                    	t.nombretiposalon
                    FROM
                    	SolicitudPadre sp
                                        INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
                                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                                        INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                        INNER JOIN AsignacionEspacios asi ON asi.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                        INNER JOIN tiposalon t ON t.codigotiposalon = st.codigotiposalon
                                        INNER JOIN ResponsableEspacioFisico r ON r.CodigoTipoSalon = st.codigotiposalon
                                        LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                        LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
                                        LEFT JOIN materia m ON m.codigomateria = g.codigomateria
                    WHERE
                    	
                     r.UsuarioId = "'.$userid.'"
                    '.$CondicionFecha.'
                    AND r.CodigoEstado = 100
                    AND (
                    	sp.CodigoEstado = 100
                    	OR sp.CodigoEstado IS NULL
                    )
                    AND s.codigoestado = 100
                    AND s.codigomodalidadacademica=001
                    
                    GROUP BY
                    	sp.SolicitudPadreId';
                        
              if($DataVer=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL ......<br><br>'.$SQL;
                    die;
              }    
          $i=0; 
            
          while(!$DataVer->EOF){
            
              $SolicitudPadre = $DataVer->fields['SolicitudPadreId'];
            
              $SQL='SELECT
                            s.SolicitudAsignacionEspacioId
                    FROM
                            AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                    WHERE
                    
                            a.SolicitudPadreId ="'.$SolicitudPadre.'"
                            AND
                            s.codigoestado=100
                    
                    GROUP BY s.SolicitudAsignacionEspacioId';
                    
               if($SolicitudHijos=&$db->GetAll($SQL)===false){
                    echo 'Error en el SQL de Solicitud Hijos...<br><br>'.$SQL;
                    die;
               }     
               $O=0;
               $N=0; 
              
               for($j=0;$j<count($SolicitudHijos);$j++){
                
                    $Hijo = $SolicitudHijos[$j]['SolicitudAsignacionEspacioId'];
                    
                    $SQL_X='SELECT
                                 a.ClasificacionEspaciosId
                            FROM 
                                 AsignacionEspacios a
                            
                            WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="'.$Hijo.'"';
                            
                            if($Info=&$db->Execute($SQL_X)===false){
                                echo 'Error al Calcular Atendidas...<br><br>'.$SQL_X;
                                die;
                            }
                               
                          while(!$Info->EOF){
                            /************************************/
                            if($Info->fields['ClasificacionEspaciosId']!=212){
                                $O = $O+1;//Asignadas
                            }else{
                                $N = $N+1;//Sin Asignar
                            }
                            /************************************/
                            $Info->MoveNext();
                          }   
               }//for
               //echo '<br><br>O->'.$O.'<->N->'.$N.'<->Hijo->'.$Hijo;
               if($O<1 && $N>1){
                
                
                    
                      $SQL='SELECT

                            s.SolicitudAsignacionEspacioId,
                            s.FechaInicio,
                            s.FechaFinal,
                            s.ClasificacionEspaciosId,
                            s.AccesoDiscapacitados,
                            s.codigocarrera,
                            s.observaciones,
                            c.Nombre
                            
                            FROM
                            AsociacionSolicitud a INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                                                  INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=s.ClasificacionEspaciosId                            
                            
                            WHERE
                            
                            a.SolicitudPadreId="'.$SolicitudPadre.'"
                            AND
                            s.codigoestado=100';
                            
                      if($DataInfo=&$db->GetAll($SQL)===false){
                         echo 'Error en el SQL de data informacion ....<br><br>'.$SQL;
                         die;
                      }      
                         
                      $Result[$i]['Padre'] = $SolicitudPadre;   
                      for($x=0;$x<count($DataInfo);$x++){
                           $Result[$i]['Hijos'][]                = $DataInfo[$x]['SolicitudAsignacionEspacioId']; 
                           $Result[$i]['FechaInicio']            = $DataInfo[$x]['FechaInicio'];
                           $Result[$i]['FechaFinal']             = $DataInfo[$x]['FechaFinal'];
                           $Result[$i]['Campus']                 = $DataInfo[$x]['Nombre'];
                           $Result[$i]['AccesoDiscapacitados']   = $DataInfo[$x]['AccesoDiscapacitados'];
                           $Result[$i]['codigocarrera']          = $DataInfo[$x]['codigocarrera'];
                           $Result[$i]['Observaciones']          = $DataInfo[$x]['observaciones'];
                           $Result[$i]['ClasificacionEspaciosId']= $DataInfo[$x]['ClasificacionEspaciosId'];
                           /********************************************************************************/
                              $SQL='SELECT

                                    SUM(g.maximogrupo) AS MaxGrupo
                                    
                                    FROM
                                    	SolicitudEspacioGrupos s INNER JOIN grupo g ON s.idgrupo=g.idgrupo
                                    WHERE
                                    	s.SolicitudAsignacionEspacioId = "'.$DataInfo[$x]['SolicitudAsignacionEspacioId'].'"
                                    AND
                                    s.codigoestado=100';  
                                    
                              if($NumGrupo=&$db->Execute($SQL)===false){
                                    echo 'Error en el SQL data de Maxi Grupo...<br>'.$SQL;
                                    die;
                                } 
                                
                              $SQL='SELECT
                                    	g.idgrupo,
                                    	g.nombregrupo,
                                    	m.codigomateria,
                                    	m.nombremateria
                                    FROM
                                    	SolicitudEspacioGrupos s
                                    INNER JOIN grupo g ON g.idgrupo = s.idgrupo
                                    INNER JOIN materia m ON m.codigomateria = g.codigomateria
                                    WHERE
                                    	s.codigoestado = 100
                                    AND s.SolicitudAsignacionEspacioId ="'.$DataInfo[$x]['SolicitudAsignacionEspacioId'].'"';  
                                    
                                    
                               if($Grupos=&$db->GetAll($SQL)===false){
                                    echo 'Error en el SQL de Grupos Asociados...<br><br>'.$SQL;
                                    die;
                               }  
                              
                              $Pre = 0;
                              $Mat = 0; 
                              for($G=0;$G<count($Grupos);$G++){  
                                
                                 $Result[$i]['nombregrupo'][$DataInfo[$x]['SolicitudAsignacionEspacioId']][]            = $Grupos[$G]['nombregrupo'];
                                 $Result[$i]['nombremateria'][$DataInfo[$x]['SolicitudAsignacionEspacioId']][]          = $Grupos[$G]['nombremateria']; 
                                 $Result[$i]['codigomateria'][$DataInfo[$x]['SolicitudAsignacionEspacioId']][]          = $Grupos[$G]['codigomateria'];
                                 $Result[$i]['idgrupo'][$DataInfo[$x]['SolicitudAsignacionEspacioId']][]                = $Grupos[$G]['idgrupo'];
                                 
                                 
                                      $SQL='SELECT
                                            	COUNT(codigoestadodetalleprematricula) AS Num
                                            FROM
                                            	detalleprematricula
                                            WHERE
                                            	idgrupo= "'.$Grupos[$G]['idgrupo'].'"
                                            AND codigoestadodetalleprematricula IN ("10")';
                                            
                                            
                                      if($Prematriculados=&$db->Execute($SQL)===false){
                                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                                            die;
                                        }
                                        
                                      $SQL='SELECT
                                            	COUNT(codigoestadodetalleprematricula) AS Num
                                            FROM
                                            	detalleprematricula
                                            WHERE
                                            	idgrupo= "'.$Grupos[$G]['idgrupo'].'"
                                            AND codigoestadodetalleprematricula IN ("30")';
                                            
                                            
                                      if($Matriculados=&$db->Execute($SQL)===false){
                                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                                            die;
                                        } 
                                        
                                    $Pre = $Pre+$Prematriculados->fields['Num'];      
                                    $Mat = $Mat+$Matriculados->fields['Num'];
                              }//for  
                              
                         $Result[$i]['matriculados']           = $Mat;
                         $Result[$i]['prematriculados']        = $Pre; 
                         $Result[$i]['max']                    = $NumGrupo->fields['MaxGrupo'];
                              
                      }//for 
                   $i++;  
               }//if
               
            $DataVer->MoveNext();
          }//while      
           
         //echo '<pre>';print_r($Result);die;  
          
        $i = 0;
      
        for($x=0;$x<count($Result);$x++){
            
            switch($op){
                case 1:{
                    /**********************************************/
                        $TypeBuscar  = $data['TypeBuscar'];//=> 1 ó 2 ó 3 ó 4
                        $num_1       = $data['Num_1'];
                        $num_2       = $data['Num_2'];
                        
                        switch($TypeBuscar){
                            case 1:{//Grupo
                                if($Result[$x]['max']>=$num_1 && $Result[$x]['max']<=$num_2){
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'] ;   
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                                     
                                     $i++;
                                }
                            }break;
                            case 2:{//Matriuclados
                                if($Result[$x]['matriculados']>=$num_1 && $Result[$x]['matriculados']<=$num_2){
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'] ;  
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                                     
                                     $i++;
                                }
                            }break;
                            case 3:{//PreMatriculados
                                if($Result[$x]['prematriculados']>=$num_1 && $Result[$x]['prematriculados']<=$num_2){
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'] ;   
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                                     
                                     $i++;
                                }
                            }break;
                            case 4:{//Suma de Pre y Matriculados
                                 $Pre_Matri = $Result[$x]['matriculados']+$Result[$x]['prematriculados'];
                                 
                                 if($Pre_Matri>=$num_1 && $Pre_Matri<=$num_2){
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'] ;   
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                                     
                                     $i++;
                                }
                            }break;
                        }
                    /**********************************************/
                }break;
                case 2:{
                    /**********************************************/
                    $Carrera = $data['ProgramaAcade'];
                
                    if($Result[$x]['codigocarrera']==$Carrera){
                        
                                 $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'] ;   
                                 $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                 $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                 $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                 $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                 $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                 $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                 $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                 $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                 $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                 $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                 $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                 $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                 $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                 $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                 $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                                 
                         $i++;
                    }
                    /**********************************************/
                }break;
                case 3:{
                    /**********************************************/
                        $materia  = $data['Materia'];
                        $Val = 0;
                        for($c=0;$c<count($Result[$x]['Hijos']);$c++){
                            
                            $Hijo_id = $Result[$x]['Hijos'][$c];
                            
                            for($l=0;$l<count($Result[$x]['codigomateria'][$Hijo_id]);$l++){
                                
                                $Materia_id = $Result[$x]['codigomateria'][$Hijo_id][$l];
                                
                                if($Materia_id==$materia){
                                    $Val = 1;
                                }
                                
                            }//for
                            
                        }//for
                        
                        
                        if($Val==1){
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'];  
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                             $i++;
                        }
                    /**********************************************/
                }break;
                case 4:{
                    /**********************************************/
                        $Sede = $data['Sedes'];
                        
                        if($Result[$x]['ClasificacionEspaciosId']==$Sede){
                            
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'];  
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                             $i++;
                             
                        }else if($Sede=='-1'){
                             
                                     $DataFina[$i]['Padre']                 =  $Result[$x]['Padre'];  
                                     $DataFina[$i]['Hijos']                 =  $Result[$x]['Hijos'] ;                
                                     $DataFina[$i]['FechaInicio']           =  $Result[$x]['FechaInicio'] ;
                                     $DataFina[$i]['FechaFinal']            =  $Result[$x]['FechaFinal'] ;
                                     $DataFina[$i]['nombregrupo']           =  $Result[$x]['nombregrupo'] ;
                                     $DataFina[$i]['nombremateria']         =  $Result[$x]['nombremateria'] ;
                                     $DataFina[$i]['codigomateria']         =  $Result[$x]['codigomateria'] ;
                                     $DataFina[$i]['Campus']                =  $Result[$x]['Campus'] ;
                                     $DataFina[$i]['AccesoDiscapacitados']  =  $Result[$x]['AccesoDiscapacitados'] ;
                                     $DataFina[$i]['codigocarrera']         =  $Result[$x]['codigocarrera'] ;
                                     $DataFina[$i]['idgrupo']               =  $Result[$x]['idgrupo'] ;
                                     $DataFina[$i]['Observaciones']         =  $Result[$x]['Observaciones'] ;
                                     $DataFina[$i]['matriculados']          =  $Result[$x]['matriculados'] ;
                                     $DataFina[$i]['max']                   =  $Result[$x]['max'] ;
                                     $DataFina[$i]['prematriculados']       =  $Result[$x]['prematriculados'] ;
                                     $DataFina[$i]['ClasificacionEspaciosId'] =  $Result[$x]['ClasificacionEspaciosId'] ;
                             $i++;
                             
                        }  
                    
                    /**********************************************/
                }break;
               }//switch 
        }//for
        
        
      $this->ViewReporteMotor($db,$DataFina);
      
    }//public function BuscarDataReporte
    public function ViewReporteMotor($db,$Data){
        
       ?>
        <form id="DataMotor">
        <input id="actionID" type="hidden" name="actionID" value="MotorSave" />
        <table>
            <thead>
                <tr>
                    <th>Maximo Cupo</th>
                    <th>Matriculados</th>
                    <th>Prematriculados</th>
                    <th>Matriculados y Prematriculados</th>
                </tr>
                <tr>
                    <th><input type="radio" name="Type" id="Cupo" value="1"/></th>
                    <th><input type="radio" name="Type" id="matriculados" value="2" /></th>
                    <th><input type="radio" name="Type" id="prematriculados" value="3" /></th>
                    <th><input type="radio" name="Type" id="MatriPrema" value="4" /></th>
                </tr>
            </thead>
        </table>
        <table >
            <thead>
                <tr>
                    <th style="border: black solid 1px;">#&nbsp;&nbsp;</th>
                    <th style="border: black solid 1px;">Solicitud Padre</th>
                    <th style="border: black solid 1px;">ID Solicitud Detalle</th>
                    <th style="border: black solid 1px;">Programa Acad&eacute;mico</th>
                    <th style="border: black solid 1px;">Materia</th>
                    <th style="border: black solid 1px;">Fecha Inico</th>
                    <th style="border: black solid 1px;">Fecha Final</th>
                    <th style="border: black solid 1px;">Maximo Grupo</th>
                    <th style="border: black solid 1px;">Matriculados</th>
                    <th style="border: black solid 1px;">Prematriculados</th>
                    <th style="border: black solid 1px;">Matriculados + Prematriculados</th>
                    <th style="border: black solid 1px;">Sede o Campus</th>
                    <th style="border: black solid 1px;">Acceso a Discapacitados</th>
                    <th style="border: black solid 1px;">Observaciones</th>
                    <th style="border: black solid 1px;">&nbsp;<img src="../imagenes/engranaje-13.gif" onclick="AlmacenarMotor()" style="cursor: pointer;" title="Adicionar Solicitudes Al Motor..." />&nbsp;<br /><input type="checkbox" name="All" id="All" onclick="AllCheckInOut()" title="Selecionar o Desmarcar Todo" style="cursor: pointer;" /></th>
                </tr>
            </thead>
            <tbody>
               <?PHP
                for($i=0;$i<count($Data);$i++){
                    if($Data[$i]['AccesoDiscapacitados']==1){
                        $Valor = 'Si';
                    }else{
                        $Valor = 'No';
                    }
                    
                    $Hijos = '<ul>';
                    for($h=0;$h<count($Data[$i]['Hijos']);$h++){
                        
                        $Hijos = $Hijos.'<li>'.$Data[$i]['Hijos'][$h].'</li>';
                        
                    }//for hijos
                    $Hijos = $Hijos.'</ul>';
                    
                    $Materia = '<ul>';
                    for($h=0;$h<count($Data[$i]['Hijos']);$h++){
                        for($m=0;$m<count($Data[$i]['nombremateria'][$Data[$i]['Hijos'][$h]]);$m++){
                            $Materia = $Materia.'<li>'.$Data[$i]['nombremateria'][$Data[$i]['Hijos'][$h]][$m].'</li>';
                        }
                    }//for hijos
                    $Materia = $Materia.'</ul>';
                    ?>
                    <tr>
                        <td style="border: black solid 1px;"><?PHP echo $i+1?>&nbsp;&nbsp;</td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['Padre']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Hijos;?></td>
                        <td style="border: black solid 1px;"><?PHP echo $NameCarrera = $this->DataCarrera($db,$Data[$i]['codigocarrera'])?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Materia;?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['FechaInicio']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['FechaFinal']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['max']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['matriculados']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['prematriculados']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['matriculados']+$Data[$i]['prematriculados']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['Campus']?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Valor?></td>
                        <td style="border: black solid 1px;"><?PHP echo $Data[$i]['Observaciones']?></td>
                        <td style="border: black solid 1px;"><input type="checkbox" checked="true" class="MotorCheck" id="Check_<?PHP echo $i ?>" name="Data_SolicitudID[]" value="<?PHP echo $Data[$i]['Padre']?>" /></td>
                    </tr>
                    <?PHP
                }//for 
                ?>
            </tbody>
       </table>
       </form>
       <?PHP
    }//public function ViewReporteMotor
    public function ListaView($db,$Datos){
        ?>
        <legend>Solicitudes ID Existentes en el Motor</legend>
        <ul>
        <?PHP
        for($i=0;$i<count($Datos);$i++){
            ?>
            <li><?PHP echo $Datos[$i]?></li>
            <?PHP
        }//for
        ?>
        </ul>
        <?PHP
    }//public function ListaView 
    public function DataCarrera($db,$id){
          $SQL='SELECT
                	nombrecarrera
                FROM
                	carrera
                WHERE
                	codigocarrera = "'.$id.'"';
                    
              if($Carrera=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de la Carrera...<br><br>'.$SQL;
                    die;
              }    
              
              
           $NameCarrera = $Carrera->fields['nombrecarrera'];
           
           return $NameCarrera;     
    }//public function DataCarrera
    public function DataMateria($db,$id){
          $SQL='SELECT
                	nombremateria
                FROM
                	materia
                WHERE
                	codigomateria = "'.$id.'"';
                    
             if($Materia=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de la Materia...<br><br>'.$SQL;
                    die;
              }    
              
              
           $NameMateria = $Materia->fields['nombremateria'];
           
           return $NameMateria;        
    }//public function DataMateria
}//class

?>
