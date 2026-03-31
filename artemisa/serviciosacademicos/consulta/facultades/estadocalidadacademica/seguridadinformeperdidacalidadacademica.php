<?php
    /*
     * Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
     * Enero 08 del 2019
     */
    require_once(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));
    
    $fecha = date("Y-m-d G:i:s",time());
    
    switch($_POST['action']){
        case 'consulta_carreras':{
            $query_car = "SELECT nombrecarrera, codigocarrera ".
            " FROM carrera WHERE codigomodalidadacademica IN ('200', '300', '800', '810') ".
            " AND fechavencimientocarrera > '".$fecha."' ORDER BY 1";        
            $row_car = $db->GetAll($query_car);    

            $listacarreras = "<option value='0'>Seleccione...</option><option value='1'>Todas las Carreras</option>";
            foreach($row_car as $carreras){
                if($carreras['codigocarrera'] == $_POST['carrera']){
                    $listacarreras.= "<option value=".$carreras['codigocarrera']." SELECTED >".$carreras['nombrecarrera']."</option>";
                }else{
                    $listacarreras.= "<option value=".$carreras['codigocarrera'].">".$carreras['nombrecarrera']."</option>";
                }
            }//foreach
            echo $listacarreras;
        }break;
        case 'consulta_situaciones':{   
            $query_documentosestuduante = "SELECT codigosituacioncarreraestudiante, nombresituacioncarreraestudiante ".
            "FROM situacioncarreraestudiante ORDER BY nombresituacioncarreraestudiante";
            $row_documentosestuduante = $db->GetAll($query_documentosestuduante);
            $listasitaucion = "<option value='0'>Seleccione</opction>";
            foreach($row_documentosestuduante as $situaciones){
                if($situaciones['codigosituacioncarreraestudiante'] == $_POST['situacion']){
                    $listasitaucion.= "<option value=".$situaciones['codigosituacioncarreraestudiante']." SELECTED >".$situaciones['nombresituacioncarreraestudiante']."</option>";
                }else{
                    $listasitaucion.= "<option value=".$situaciones['codigosituacioncarreraestudiante'].">".$situaciones['nombresituacioncarreraestudiante']."</option>";
                }
            }
            echo $listasitaucion;
        }break;
        /**
         * Caso 986.
         * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
         * Adición de los campos correo Personal, Correo Institucional y Género a la consulta. 
         * Para el reporte: Listado de Estudiantes Bloqueados Académicamente.
         * @since 24 de Abril 2019.
        */
        case 'consultardatos':{
            $carrera = $_POST['carrera'];
            $situacion = $_POST['situacion'];            
            $html="";
            
            $sqlcarrera = "";
            
            if($carrera <> 1){
              $sqlcarrera = " AND e.codigocarrera='".$carrera."' ";  
            }
            $perdidacalidad = "SELECT ".
                " e.codigoestudiante, ".
                " CONCAT(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS 'nombreestudiante', ".
                " s.nombresituacioncarreraestudiante, ".
                " eg.numerodocumento, ".
                " h.codigoperiodo, ".
                " e.semestre, ".
                " h.fechainiciohistoricosituacionestudiante, ".
                " h.fechafinalhistoricosituacionestudiante, ".
                " c.nombrecarrera, ".
                " ma.nombremodalidadacademica, ".
                " eg.emailestudiantegeneral, ".
                " CONCAT(u.usuario,'@unbosque.edu.co') AS 'CorreoInstitucional', ".    
                " gen.nombregenero ".
            " FROM ".
                    " estudiante e ".
            " INNER JOIN situacioncarreraestudiante s ON (s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante) ".
            " INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral) ".
            " LEFT JOIN usuario u ON (eg.numerodocumento = u.numerodocumento AND u.codigoestadousuario = '100') ".        
            " INNER JOIN historicosituacionestudiante h ON (e.codigoestudiante = h.codigoestudiante) ".
            " INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) ".
            " INNER JOIN modalidadacademica ma ON (ma.codigomodalidadacademica = c.codigomodalidadacademica) ".
            " INNER JOIN genero gen ON (eg.codigogenero = gen.codigogenero) ".
            " WHERE ".
                   " e.codigosituacioncarreraestudiante = '".$situacion."' ".
            " AND c.codigomodalidadacademica <> '400' ".
            " AND h.fechafinalhistoricosituacionestudiante > '".$fecha."' ".$sqlcarrera." ".
            " ORDER BY eg.apellidosestudiantegeneral";
            
              
            $perdidacalidad1=$db->GetAll($perdidacalidad);               	
                  
            $p=1;
            foreach($perdidacalidad1 as $datos){
                $html.= "<tr>";
                    $html.= "<td>".$p."</td>";
                    $html.= "<td>".$datos['numerodocumento']."</td>";
                    $html.= "<td>".$datos['nombreestudiante']."</td>";
                    $html.= "<td>".$datos['nombresituacioncarreraestudiante']."</td>";
                    $html.= "<td>".$datos['codigoperiodo']."</td>";
                    $html.= "<td>".$datos['nombrecarrera']."</td>";
                    $html.= "<td>".$datos['nombremodalidadacademica']."</td>";
                    $html.= "<td>".$datos['semestre']."</td>";
                    $html.= "<td>".$datos['fechainiciohistoricosituacionestudiante']."</td>";
                    $html.= "<td>".$datos['fechafinalhistoricosituacionestudiante']."</td>";
                    $html.= "<td>".$datos['emailestudiantegeneral']."</td>";
                    $html.= "<td>".$datos['CorreoInstitucional']."</td>";
                    $html.= "<td>".$datos['nombregenero']."</td>";
                $html.= "</tr>";
                $p++;
            }
            echo $html;
        }break;
    }//switch
    
