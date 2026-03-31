<?php   
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../funciones/funciones.php');
    $funciones = new funcionesMatriculas();
    include_once (realpath(dirname(__FILE__)).'/../../utilidades/ValidacionesTipoDocumento.php');
    $validaciones = new validacionesDocumento();

    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $usuario = $_SESSION['usuario'];

    $contador = '0';
    $codigoperiodo = $_POST['periodo'];
    
    //encabezado de los campos del documento
    $html1 = "Error,programa,Año,Semestre,Tipo_Documento,Numero_Documento,Pro_consecutivo,ID_municipio,Num_materias_inscritas,Num_materias_aprobadas\r\n";  

    if($codigoperiodo)
    {
        $anio = substr($codigoperiodo, 0, -1);
        $periodo = substr($codigoperiodo, 4, 1);
        
        $fecha = date("Y-m-d");
        
        //lista de materias activas
        $sqlcarreras="SELECT c.codigocarrera, c.nombrecarrera, c.codigomodalidadacademica, cr.* FROM carrera c LEFT JOIN carreraregistro cr ON cr.codigocarrera = c.codigocarrera WHERE c.fechainiciocarrera <= '".$fecha."' AND c.fechavencimientocarrera >= '".$fecha."' AND c.codigocarrera <> '13' AND c.codigocarrera <> '1' AND c.codigomodalidadacademica IN ('200', '300') AND c.nombrecarrera not LIKE '%CURSO%' ORDER BY c.codigocarrera"; 
        $carreras = $db->GetAll($sqlcarreras);
        
        foreach($carreras as $carrera)
        {
            if($carrera['codigocarrera']=='')
            {
                $codigocarrera = $carrera[0] ;
            }else
            {
                $codigocarrera = $carrera['codigocarrera'];
            }//else            
            //lista de estudiantes nuevos matriculados
            $matriculadosnuevos = $funciones->MatriculadosNuevos($db,$codigocarrera,$codigoperiodo);                             
            //lista de estudiantes antiguos matriculados
            $datosmatriculadosantiguos = $funciones->MatriculadosAntiguos($db,$codigocarrera,$codigoperiodo);               
            //listado de estudiantes de reintegro
            $datosmatriculadosreintegro = $funciones->reintegro($db,$codigocarrera,$codigoperiodo);
            
            //pro_consecutivo
            if($carrera['numeroregistrocarreraregistro'])
            {
                $pro_consecutivo = $carrera['numeroregistrocarreraregistro'];
            }
            else
            {
                $pro_consecutivo = '0';
            }
            
            if (is_array($datosmatriculadosantiguos))
            {
                foreach ($datosmatriculadosantiguos as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-N-".$pro_consecutivo;                        
                    }
                }
            }
            if (is_array($matriculadosnuevos))
            {
                foreach ($matriculadosnuevos as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-N-".$pro_consecutivo;                        
                    }
                }
            }
            if (is_array($datosmatriculadosreintegro))
            {
                foreach ($datosmatriculadosreintegro as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-S-".$pro_consecutivo;                        
                    }
                }
            }
           
        }//foreach carreras
        
        foreach($resultado as $listado)
        {
            $datosestudiante = explode("-", $listado['codigoestudiante']);            
            
            $codigoestudiante = $datosestudiante[0];
            $reintegro = $datosestudiante[1];
            $pro_consecutivo = $datosestudiante[2];            
            
            $totaldatos = $funciones->infomateriasestudiante($db,$codigoestudiante,$codigoperiodo); 
                
            $tipodoc = $totaldatos['tipodocumento'];
            $numerodoc = $totaldatos['numerodocumento'];
            $genero = $totaldatos['Genero'];
			//municipio del programa, todos son bogotá
			$totaldatos['idciudad'] = '11001';
		   
            //validaciones de campos para tipos de numeros de identifiacion
            $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);            
            
            $validacion['programa'] = sanear_string($validacion['programa']);
            
            //asignacion de los datos del estudiante a la variable de html
            $htmlRegistro.= $validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$numerodoc.",".$pro_consecutivo.",".$totaldatos['idciudad'].",".$totaldatos['matriculadas'].",".$totaldatos['Aprobadas']."\r\n";
            
            $contador++;
        }//foreach
        
        //crear el registro del log de reportes
        $funciones->logReporte($db, "Matriculados", $usuario, $contador, $codigoperiodo);
        
        $html = $html1.$htmlRegistro;        
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_MateriasMatriculados_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html;
    }//if        
?>