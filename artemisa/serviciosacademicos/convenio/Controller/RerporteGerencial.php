<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();

    require (realpath(dirname(__FILE__))."/../Formula/Formula.php");
   
    $rutaVistas  = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */ 
    require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	$template_index = $mustache->loadTemplate('buscar'); /*carga la plantilla index*/
    $template_institucion = $mustache->loadTemplate('institucion'); /*carga la plantilla para los reportes por instituciones*/
    $template_facultades = $mustache->loadTemplate('facultades'); /*carga la plantilla para los reportes por facultades*/ 
    include (realpath(dirname(__FILE__)).'/../../utilidades/funcionesFechas.php');    
    
    $Accion = $_POST['Accion'];
    $tipo = $_POST['tipo'];
    $coperiodo = $_POST['periodo'];    
    
    switch($Accion)
    {
        case 'buscar':
        {
            if($tipo == '1')
            {
                $listaubicaciones = ubicaciones($db, $coperiodo);
                $c=0;
                $totales = array();
                foreach($listaubicaciones as $datoss)
                {                    
                    $totales[$c]['IdUbicacionInstitucion'] = $datoss['IdUbicacionInstitucion'];
                    $totales[$c]['NombreUbicacion'] = $datoss['NombreUbicacion'];
                    $totales[$c]['NombreInstitucion'] = $datoss['NombreInstitucion'];
                    $totales[$c]['InstitucionConvenioId'] = $datoss['InstitucionConvenioId'];               
                    //estudiantes con rotacion
                    $tipo = "IdInstitucion";
                    $listaestudiantes = estudiantesrotacion($db, $coperiodo, $datoss['InstitucionConvenioId'], $tipo);
                    $cantidad = count($listaestudiantes);
                    
                    $totalfacultad=0;
                    $tmp_institucion;
                    $tmp_nombreinstitucion; 
                    $tmp_nombreubicacion;                 
                    
                    $total=0;
                    $detalles= array();
                    $d=0;
                    
                    for($i=0;$i<$cantidad;$i++)
                    {
                        //total de creditos del semestre
                        $numerocreditos = creditos($db, $listaestudiantes[$i]);  
                        //consulta las fehcas de inicio y fin del semestre y el numero de creditos
                        $dias_semestre = diassemestreEstudiante($db, $coperiodo, $listaestudiantes[$i]);
                        //calcula los dias del semestre
                        $Dias_Calculados = CalcularFechas_new($dias_semestre['fechainiciogrupo'],$dias_semestre['fechafinalgrupo']);
                        //calcula el valor del credito  dividiendo el valor del cohorte entre el total de creditos del semestre                    
                        $valorcredito = ($listaestudiantes[$i]['valordetallecohorte']) /( $numerocreditos['totalcreditossemestre']);
                        //calcula el valor de la asignatura multiplicando el numero de creditos del semestre 
                        $valorcreditoasignatura = (int)$valorcredito * $dias_semestre['numerocreditos'];                    
                        //calcula el valor del credito del dia ... valor de la asignatura dividido los dias del semestre
                        $valorcreditodia = ((int)$valorcreditoasignatura / $Dias_Calculados);                     
                        //calcula el valor de la rotacion multiplicando el valor del dredito de un dia por la catidad de dias de rotacion del estudiante
                        $valorrotaciontotal = ((int)$valorcreditodia * (int)$listaestudiantes[$i]['TotalDias']);                    
                        //si la carrera a la que el estudiantes es 200 sera pregrado y si es 300 sera postgrado
                        $tiempoRotacionSemanas = date ("W",strtotime($listaestudiantes[$i]['FechaEgreso'])) - date("W",strtotime($listaestudiantes[$i]['FechaIngreso'])); 
                        
                        $fechainicial = new DateTime($listaestudiantes[$i]['FechaEgreso']);
                        $fechafinal = new DateTime($listaestudiantes[$i]['FechaIngreso']);
                        
                        $diferencia = $fechainicial->diff($fechafinal);
                        $Meses=$diferencia->format("%m");
                        
                        switch($listaestudiantes[$i]['codigomodalidadacademica'])
                        {
                            case '200':{ $tipopracticante = '1'; }break;
                            case '300':{ $tipopracticante = '2'; }break;
                        }

                        //consulta el valor y eltipo de contraprestacion
                        $valorcontrapestacion = contraprestacion($db, $listaestudiantes[$i], $tipopracticante);

                        $tipocontraprestacion=$valorcontrapestacion['IdTipoPagoContraprestacion'];  

                        if($tipocontraprestacion == '1')
                        {
                            $contrapestacion = (int)$valorcontrapestacion['ValorContraprestacion'];    
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "%";
                        }
                        if($tipocontraprestacion == '2')
                        {
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "Cr.";
                        }
                        if($tipocontraprestacion == '3')
                        {
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "% + SS.";
                        }
                        if($tipocontraprestacion == '4')
                        {
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $contrapestacion = "$ ".(number_format($valorcontrapestacion['ValorContraprestacion'], 2));
                            $nombretipocontraprestacion = "";
                        }
                        if($tipocontraprestacion == '5')
                        {
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "% + Cr.";
                        }                       
                        
                        $valoresformula['1'] = $listaestudiantes[$i]['valordetallecohorte'];//valor matricula
                        $valoresformula['2'] = $numerocreditos['totalcreditossemestre']; //Total creditos                           
                        // 3 Horas creidto
                        $valoresformula['4'] = (int)$listaestudiantes[$i]['TotalDias']; //Numero de dias rotados
                        $valoresformula['5'] = $dias_semestre['numerocreditos']; //Numero de creditos de la materia
                        //6 dias en el mes
                        $valoresformula['7'] = $tiempoRotacionSemanas; //Tiempo rotacion por semanas                           
                        //8 
                        //9 valor base
                        $valoresformula['10'] = $formulacontrapestacion; //Valor de la contraprestacion                           
                        //11 valor pagado a un docente
                        //12 numero
                        $valoresformula['13'] = $Dias_Calculados;//13 Dias en el semestre
                        $valoresformula['14'] = (int)$listaestudiantes[$i]['TotalHoras'];// total de horas de la rotacion
                        $valoresformula['18'] = $Meses;// Numero de meses rotados

                        $codigocarrera= $listaestudiantes[$i]['codigocarrera'];
                        $idconvenio = $listaestudiantes[$i]['idsiq_convenio'];
                        
                        $valorcreditodia = ($valorcreditoasignatura / $Dias_Calculados);                             
                        $formulasalida = Formula($db, $codigocarrera, $idconvenio, $valoresformula,$listaestudiantes[$i]['FechaIngreso']);
                        $totalformula = $formulasalida['total'];

                        if(is_array($detalles))
                        {
                            //verificacion de si existe la carrera en el array de destalles
                            $p=0; 
                            $con=0;
                            foreach($detalles as $posicion)
                            {
                                //si existe de suma el valor de la formula
                                if($posicion['codigocarrera']== $codigocarrera)
                                {
                                    $detalles[$con]['totaldetalle']+= $totalformula;
                                    $detalles[$con]['numero_total']+= 1;
                                    $totalcarrera+= $totalformula; 
                                    $p++;
                                }
                                $con++;
                            }
                            //si la carrera buscada no esta, se procede a crearse
                            if($p==0)
                            {
                                $detalles[$d]['codigocarrera'] =  $listaestudiantes[$i]['codigocarrera'];
                                $detalles[$d]['facultad'] = $listaestudiantes[$i]['nombrecarrera'];
                                $detalles[$d]['totaldetalle'] = $totalformula;
                                $detalles[$d]['numero_total'] = 1;
                                //se suma el valor a la variable del total de la carrera
                                $d++;   
                                $totalcarrera+= $totalformula; 
                            }
                        }else
                        {                            
                            $detalles[$d]['codigocarrera'] =  $listaestudiantes[$i]['codigocarrera'];
                            $detalles[$d]['facultad'] = $listaestudiantes[$i]['nombrecarrera'];
                            $detalles[$d]['totaldetalle'] = $totalformula;
                            $detalles[$d]['numero_total'] = 1;
                            //se suma el valor a la variable del total de la carrera
                            $d++;
                            $totalcarrera+= $totalformula;                            
                        }                                              
                    }//for estudiantes
                    
                    $totales[$c]['total']=  number_format($totalcarrera, 2);
                    $xx =0;
                    foreach($detalles as $valores)
                    {
                        $detalles[$xx]['totaldetalle'] = number_format($valores['totaldetalle'], 2);                        
                        $xx++;
                    }
                    $totales[$c]['Detalles'] = $detalles; 
                    $totales[$c]['total'] = number_format($totalcarrera, 2);
                    $c++;
                    unset($detalles);
                    unset($totalformula);  
                    unset($totalcarrera);
                    $listaestudiantes ='';
                    $totalcarrera=0;   
                }//ubicaciones
            
                echo $template_institucion->render(array(
                'title' => 'REPORTE GENERAL INSTITUCIONES',
                'listainstituciones' => $totales                
                  )
                );
            }else if($tipo == '2')
            {
                $carreras = carreras($db, $coperiodo);
                $c=0;
                foreach($carreras as $listacarreras)
                {
                    $tipo = "codigocarrera";
                    $lista_estudiantes = estudiantesrotacion($db, $coperiodo, $listacarreras['codigocarrera'], $tipo);
                       
                    $numero_total=0;
                    $detalles = ''; 
                    $r=0;                                                                                                             
                    foreach($lista_estudiantes as $estudiante)
                    {                        
                        //informacion del semestre 
                        $valoresEstudiante =  valoresestudiante($db, $estudiante);                                          
                        $numerocreditos = creditos($db, $valoresEstudiante);                        
                        //consulta las fehcas de inicio y fin del semestre y el numero de creditos                      
                        $dias_semestre = diassemestreEstudiante($db, $coperiodo, $estudiante);
                        //calcula los dias del semestre
                        $Dias_Calculados = CalcularFechas_new($dias_semestre['fechainiciogrupo'],$dias_semestre['fechafinalgrupo']);                        
                        //calcula el valor del credito  dividiendo el valor del cohorte entre el total de creditos del semestre                    
                    	$valorcredito = number_format(($estudiante['valordetallecohorte']) /( $numerocreditos['totalcreditossemestre']), 2, '.', '');
                        //calcula el valor de la asignatura multiplicando el numero de creditos del semestre                         
                        $valorcreditoasignatura = $valorcredito * $dias_semestre['numerocreditos'];  
                        //calcula el valor del credito del dia ... valor de la asignatura dividido los dias del semestre                        
                        $valorcreditodia = number_format(((int)$valorcreditoasignatura / $Dias_Calculados), 2, '.', '');  
                        //calcula el valor de la rotacion multiplicando el valor del dredito de un dia por la catidad de dias de rotacion del estudiante
                        //$valorrotaciontotal = ((int)$valorcreditodia * (int)$estudiante['TotalDias']);                    
                        //si la carrera a la que el estudiantes es 200 sera pregrado y si es 300 sera postgrado
                        switch($estudiante['codigomodalidadacademica'])
                        {
                            case '200':{ $tipopracticante = '1'; }break;
                            case '300':{ $tipopracticante = '2'; }break;
                        }
                       
                        //consulta el valor y eltipo de contraprestacion
                        $valorcontrapestacion = contraprestacion($db, $estudiante, $tipopracticante);

                        $tipocontraprestacion=$valorcontrapestacion['IdTipoPagoContraprestacion'];                         

                        if($tipocontraprestacion == '1')
                        {
                            $contrapestacion = (int)$valorcontrapestacion['ValorContraprestacion'];    
                            $formulacontrapestacion = "0.".(int)$valorcontrapestacion['ValorContraprestacion'];
                            $nombretipocontraprestacion = "%";
                        }
                        if($tipocontraprestacion == '2')
                        {
                            $nombretipocontraprestacion = "Cr.";
                        }
                        if($tipocontraprestacion == '3')
                        {
                            $nombretipocontraprestacion = "% + SS.";
                        }
                        if($tipocontraprestacion == '4')
                        {
                            $formulacontrapestacion = (int)$valorcontrapestacion['ValorContraprestacion'];                            
                        }
                        if($tipocontraprestacion == '5')
                        {
                            $nombretipocontraprestacion = "% + Cr.";
                        }
                        
                        $tiempoRotacionSemanas = date ("W",strtotime($estudiante['FechaEgreso'])) - date("W",strtotime($estudiante['FechaIngreso']));  
                        
                        $fechainicial = new DateTime($estudiante['FechaEgreso']);
                        $fechafinal = new DateTime($estudiante['FechaIngreso']);
                        
                        $diferencia = $fechainicial->diff($fechafinal);
                        $Meses=$diferencia->format("%m");

                        $valoresformula['1'] = $estudiante['valordetallecohorte'];//valor matricula
                        $valoresformula['2'] = $numerocreditos['totalcreditossemestre']; //Total creditos                           
                        // 3 Horas creidto
                        $valoresformula['4'] = (int)$estudiante['TotalDias']; //Numero de dias rotados
                        $valoresformula['5'] = $dias_semestre['numerocreditos']; //Numero de creditos de la materia
                        //6 dias en el mes
                        $valoresformula['7'] = $tiempoRotacionSemanas; //Tiempo rotacion por semanas                           
                        //8 
                        //9 valor base
                        $valoresformula['10'] = $formulacontrapestacion; //Valor de la contraprestacion                           
                        //11 valor pagado a un docente
                        //12 numero
                        $valoresformula['13'] = $Dias_Calculados;//13 Dias en el semestre
                        $valoresformula['14'] = (int)$estudiante['TotalHoras'];// total de horas de la rotacion
                        $valoresformula['18'] = $Meses;// Numero de meses rotados
                        
                        $codigocarrera= $estudiante['codigocarrera'];
                        $idconvenio = $estudiante['idsiq_convenio'];
                                                    
                        $formulasalida = Formula($db, $codigocarrera, $idconvenio, $valoresformula,$estudiante['FechaIngreso']);
                        $totalformula  = $formulasalida['total'];
                                                
                        if(is_array($detalles))
                        {                               
                            $p=0;
                            $con=0;
                            foreach($detalles as $posicion)
                            {
                                if($posicion['idinstitucion']== $estudiante['IdInstitucion'])
                                {
                                    $detalles[$con]['totaldetalle']+= $totalformula;
                                    $detalles[$con]['numero_total']+= 1;
                                    $totalcarrera+= $totalformula;
                                    $p++;
                                }
                                $con++;
                            }
                            if($p==0)
                            {
                                $detalles[$r]['idinstitucion'] = $estudiante['IdInstitucion'];
                                $detalles[$r]['institucion'] = $estudiante['NombreInstitucion'];
                                $detalles[$r]['totaldetalle']+= $totalformula;
                                $detalles[$r]['numero_total'] = 1;
                                //se suma el valor a la variable del total de la carrera
                                $totalcarrera+= $totalformula;
                                $r++;
                            }
                        }else
                        {                            
                            $detalles[$r]['idinstitucion'] = $estudiante['IdInstitucion'];
                            $detalles[$r]['institucion'] = $estudiante['NombreInstitucion'];
                            $detalles[$r]['totaldetalle']+= $totalformula;
                            $detalles[$r]['numero_total'] = 1;
                            //se suma el valor a la variable del total de la carrera
                            $totalcarrera+= $totalformula;
                            $r++;
                        }  
                    }// foreach   estudaintes 
                    $listafacultades[$c]['codigocarrera'] = $listacarreras['codigocarrera'];
                    $listafacultades[$c]['NombreFacultad'] = $listacarreras['nombrecarrera'];  
                    $listafacultades[$c]['total'] = number_format($totalcarrera, 2);
                    $xx =0;
                    foreach($detalles as $valores)
                    {
                        $detalles[$xx]['totaldetalle'] = number_format($valores['totaldetalle'], 2);
                        
                        $xx++;
                    }
                    $listafacultades[$c]['Detalles'] = $detalles;                    
                    unset($detalles);
                    unset($totalcarrera);
                    unset($numero_total);
                    $c++;                                                                            
                }//foreach carreras 
                
                 echo $template_facultades->render(array(
        			'title' => 'REPORTE GENERAL FACULTADES',
                    'listafacultades' => $listafacultades
        		  )
                );
            } //if tipo =2
        }//case buscar  
        break;
        case '':
        {
            $periodo = "select codigoperiodo from periodo ORDER BY codigoperiodo DESC";
            $codigosPeriodo = $db->GetAll($periodo);
            
            echo $template_index->render(array(
        			'title' => 'Consulta Reporte gerencial',
                    'periodo' => $codigosPeriodo 
        		)
        	);  
        }break;
    }//switch
    
    
?>