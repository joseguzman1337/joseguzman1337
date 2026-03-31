<?php   
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../funciones/funciones.php'); $funciones = new funcionesMatriculas();
    include_once (realpath(dirname(__FILE__)).'/../../utilidades/ValidacionesTipoDocumento.php'); $validaciones = new validacionesDocumento();

    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $usuario = $_SESSION['usuario'];

    $codigoperiodo = $_POST['periodo'];
    $contador = '0';

    //encabezado de los campos del documento
    $html1 = "Error,programa,Año,Semestre,Tipo_Documento,Numero_Documento,Pro_consecutivo,ID_municipio,Telefono_Contacto,E-Mail_Personal,Fecha_Nacimiento\r\n";  
    if($codigoperiodo)
    {
        /*ListaCarreras*/
        $arrayListaCarreras=$funciones->listadocarreras($db);
        
        $arreglob= array();
        $i=1;
        foreach ($arrayListaCarreras as $val) {
            $arrayAdmitidos_No_Matriculados=$funciones->seguimiento_inscripcionvsmatriculadosnuevos($db,$val['codigocarrera'],'arreglo', $codigoperiodo);
            $arrayAdmitidos_No_Matriculados1="";
            if(!empty($arrayAdmitidos_No_Matriculados)||$arrayAdmitidos_No_Matriculados!=null){
                $arrayAdmitidos_No_Matriculados1=$arrayAdmitidos_No_Matriculados;
            }else{
                $arrayAdmitidos_No_Matriculados1=array();
            }
            
            /*Admitidos_Que_No_Ingresaron*/
            $arrayAdmitidos_Que_No_Ingresaron=$funciones->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($db,$codigoperiodo,$val['codigocarrera'],153,'arreglo');
            $arrayAdmitidos_Que_No_Ingresaron1="";
            if(!empty($arrayAdmitidos_Que_No_Ingresaron)||$arrayAdmitidos_Que_No_Ingresaron!=null){
                $arrayAdmitidos_Que_No_Ingresaron1=$arrayAdmitidos_Que_No_Ingresaron;
            }else{
                $arrayAdmitidos_Que_No_Ingresaron1=array();
            }
            
            /*MatriculadosNuevos*/
            $arrayMatriculadosNuevos=$funciones->obtener_datos_estudiantes_matriculados_nuevos($db,$val['codigocarrera'],'arreglo',$codigoperiodo);
            $arrayMatriculadosNuevos1="";
            if(!empty($arrayMatriculadosNuevos)||$arrayMatriculadosNuevos!=null){
                $arrayMatriculadosNuevos1=$arrayMatriculadosNuevos;
            }else{
                $arrayMatriculadosNuevos1=array();
            }
            
            $temp = array_merge($arrayAdmitidos_No_Matriculados1,$arrayAdmitidos_Que_No_Ingresaron1,$arrayMatriculadosNuevos1);
            
            foreach ($temp as $value) {
                $arreglob[] = $value;
            }
            $i++;
        }

        $anio = substr($codigoperiodo, 0, -1);
        $periodo = substr($codigoperiodo, 4, 1);
        
        $fecha = date("Y-m-d");
        
        //lista de materias activas 
        $sqldatos = "SELECT DISTINCT e.codigoestudiante, e.codigocarrera 
                FROM estudianteestadistica ee, carrera c, estudiante e
                WHERE c.codigomodalidadacademica IN(200,300,600) 
		AND c.codigocarrera NOT IN(1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                AND e.codigocarrera=c.codigocarrera
                AND ee.codigoestudiante=e.codigoestudiante
                AND ee.codigoperiodo = '".$codigoperiodo."'
                AND ee.codigoprocesovidaestudiante= 400
                AND ee.codigoestado LIKE '1%'
                GROUP BY e.codigoestudiante
                UNION
                SELECT DISTINCT
                    e.codigoestudiante,
                    e.codigocarrera
                FROM
                    estudianteestadistica ee
                    INNER JOIN PeriodosVirtuales pv ON ee.codigoperiodo = pv.CodigoPeriodo
                    INNER JOIN PeriodoVirtualCarrera pvc ON pv.IdPeriodoVirtual = pvc.idPeriodoVirtual
                    INNER JOIN estudiante e ON ee.codigoestudiante = e.codigoestudiante
                    INNER JOIN carrera c ON e.codigocarrera = c.codigocarrera
                    AND pvc.codigoModalidadAcademica=c.codigomodalidadacademica
                WHERE
                    c.codigomodalidadacademica IN (800, 810)
                AND c.codigocarrera NOT IN(1,12,79,96,117,262,264,355,434,468,2,3,6,7,13,30,39,74,92,94,97,120,138,204,417,554,560)
                AND pvc.codigoPeriodo = '".$codigoperiodo."'
                AND ee.codigoprocesovidaestudiante = 400
                AND ee.codigoestado LIKE '1%'
                GROUP BY
                    e.codigoestudiante";
        

        $listados = $db->GetAll($sqldatos);
        
        $todo1= array_merge($arreglob,$listados);
        
        $todo = array_map("unserialize", array_unique(array_map("serialize", $todo1)));
        
        foreach($todo as $estudiantes)
        {
            $codigoestudiante = $estudiantes['codigoestudiante'];
            //consulta de datos de los estudiantes 
            $datos = $funciones->Infoparticipante($db,$codigoestudiante);
            
            $codigocarrera = $estudiantes['codigocarrera'];
            //consulta el pro consecutivo de la carrera
            $pro_consecutivo = $funciones->carreraregistro($db,$codigocarrera);
            
            $tipodoc = $datos['TipoDocumento'];
            $numerodoc = $datos['numerodocumento'];
            $genero = $datos['Genero'];
            
            //validaciones de campos para tipos de numeros de identifiacion
            $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);
            $validacion['programa'] = sanear_string($validacion['programa']);
            
            if($datos['ciudad']=='0')
            {
                $datos['ciudad']='11001';
                $validacion['Error'].= "la ciudad no puede ser cero";
            }            

            $htmlRegistro.= $validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$numerodoc.",".$pro_consecutivo.",11001,".$datos['Telefono'].",".$datos['EmailPersonal'].",".$datos['FECHA_NACIM']."\r\n";
            $contador++;
        }
        
        //crear el registro del log de reportes
        $funciones->logReporte($db, "Admitidos", $usuario, $contador, $codigoperiodo);
                                
       $html = $html1.$htmlRegistro;         
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_Admitidos_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html; 
    }