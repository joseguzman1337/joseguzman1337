<?php
    session_start();
    include_once('../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	/************************************************
	+-----------------------------------------------+
	|	PROYECTO: GESTION DE ROTACIONES MASIVAS     |
	+-----------------------------------------------+
	|												|
	|												|
	+-----------------------------------------------+
	************************************************/

	$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once("../../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	$template_index = $mustache->loadTemplate('CargueRotaciones'); /*carga la plantilla index*/   
    session_start();
    include_once ('../../../../../../EspacioFisico/templates/template.php');
    $db = getBD();    
    require_once('../../../../../../educacionContinuada/Excel/reader.php');
    
    //echo '<pre>';print_r($_SESSION);
    //exit;
    $periodo = $_SESSION['codigoperiodosesion'];
    $programa=$_SESSION['nombrefacultad'];
    $codigocarrera = $_SESSION['codigofacultad'];
    
    function limpiarCadena($cadena) {
        $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑ\s]', '', $cadena));
        return $cadena;
    }
    
    $periodo = limpiarCadena(filter_var($periodo,FILTER_SANITIZE_NUMBER_INT));
    $programa = limpiarCadena(filter_var($programa,FILTER_SANITIZE_NUMBER_INT));
    $codigocarrera = limpiarCadena(filter_var($codigocarrera,FILTER_SANITIZE_NUMBER_INT));
    
    if($codigocarrera != 1)
    {
        $sql2 = "and cc.codigocarrera = '".$codigocarrera."'";
    }else
    {
        $sql2= "";
    }
    
    $sqlconvenios = "SELECT DISTINCT c.ConvenioId, c.InstitucionConvenioId, ui.IdUbicacionInstitucion, ic.NombreInstitucion, ui.NombreUbicacion FROM Convenios c INNER JOIN conveniocarrera cc ON cc.ConvenioId = c.ConvenioId INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId =c.InstitucionConvenioId INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = ic.InstitucionConvenioId WHERE c.idsiq_estadoconvenio = '1' ";
//echo $sqlconvenios;
    $convenios=$db->GetAll($sqlconvenios);
    
    $sqljornada = "Select JornadaRotacionesId AS id, Jornada FROM JornadaRotaciones  WHERE CodigoEstado='100'";
    $JornadaData=$db->GetAll($sqljornada);
    
    $sqlespecialidad ="SELECT EspecialidadCarreraId AS id, Especialidad FROM EspecialidadCarrera WHERE codigocarrera ='".$codigocarrera."' AND CodigoEstado = '100'";
    $EspecialidadD=$db->GetAll($sqlespecialidad);
    $t=0;
    foreach($EspecialidadD as $datoses)
    {
        $EspecialidadData[$t] = array('id'=>(string)(int)$datoses['id'], 'Especialidad'=>$datoses['Especialidad']);
        $t++;
    }
    
    $sqlmateria ="SELECT m.codigomateria, CONCAT(m.nombremateria,' :: ',m.codigomateria) AS NameMateria FROM materia m WHERE m.codigocarrera = '".$codigocarrera."' and m.codigomateria >'999' and m.TipoRotacionId != '1'";
    $materiasData = $db->GetAll($sqlmateria);
    
    switch($_POST['Action_id'])
    {
        case 'listagrupos':
        {            
            $periodos = $_POST['periodo'];
            $materias = $_POST['materia'];
                   
            $sqlgrupos = "SELECT g.idgrupo, sg.SubgrupoId, g.nombregrupo FROM grupo g INNER JOIN Subgrupos sg ON sg.idgrupo = g.idgrupo where g.codigomateria = '".$materias."' and g.codigoperiodo='".$periodos."'";
            $gruposdata = $db->GetAll($sqlgrupos);
            $imp ="<select name='grupos' id='grupos'><option value='0'></option>";
            foreach($gruposdata as $grupo)
            {
                $imp.= "<option value='".$grupo['SubgrupoId']."'>".$grupo['nombregrupo']." - ".$grupo['idgrupo']."</option>";
            }
            $imp.="</select>";
            echo $imp;
            exit;    
        }break;
        case 'SaveData':
        {           
            if($_FILES["file"]["name"]!=null)
            {
                $periodo = $_POST['periodo']; 
                $carrera = $_POST['programa'];
                $instituciones = $_POST['instituciones'];
                $convenios = explode("-", $instituciones);
                $institucionid = $convenios[0];
                $convenioid = $convenios[1];
                $ubicacionid = $convenios[2];
                $fechaing = $_POST['fechaingreso'];
                $fechaingreso = date("Y-m-d", strtotime($fechaing));
                $fechaeg = $_POST['fechaegreso'];
                $fechaegreso = date("Y-m-d", strtotime($fechaeg));
                $Totaldias = $_POST['Totaldias'];
                $jornada = $_POST['Jornada'];
                $materias = $_POST['materias'];
                $Especialidad[] = $_POST['Especialidad'];//array
                $docentecargo = $_POST['docentecargo'];
                $docentecel = $_POST['docentecel'];
                $docenteemail = $_POST['docenteemail'];
                $grupoid = $_POST['grupos'];
                $dias = $_POST['Totaldias'];
                $servicio = $_POST['servicio'];
                $TotalHoras = $_POST['TotalHoras'];
                $codigodia = array();//array
                if(isset($_POST['Semanadias1'])){$codigodia[0] = '1';}
                if(isset($_POST['Semanadias2'])){$codigodia[1] = '2';}
                if(isset($_POST['Semanadias3'])){$codigodia[2] = '3';}
                if(isset($_POST['Semanadias4'])){$codigodia[3] = '4';}
                if(isset($_POST['Semanadias5'])){$codigodia[4] = '5';}
                if(isset($_POST['Semanadias6'])){$codigodia[5] = '6';}
                if(isset($_POST['Semanadias7'])){$codigodia[6] = '7';}
                
                $periodo = limpiarCadena(filter_var($periodo,FILTER_SANITIZE_NUMBER_INT));
                $carrera = limpiarCadena(filter_var($carrera,FILTER_SANITIZE_NUMBER_INT));                
                $Totaldias = limpiarCadena(filter_var($Totaldias,FILTER_SANITIZE_NUMBER_INT));
                $jornada = limpiarCadena(filter_var($jornada,FILTER_SANITIZE_NUMBER_INT));
                $materias = limpiarCadena(filter_var($materias,FILTER_SANITIZE_NUMBER_INT));
                $dias = limpiarCadena(filter_var($dias,FILTER_SANITIZE_NUMBER_INT));                
                $DocenteCargo = limpiarCadena(filter_var($DocenteCargo,FILTER_SANITIZE_NUMBER_INT));
                $DocenteEmail = limpiarCadena(filter_var($DocenteEmail,FILTER_SANITIZE_NUMBER_INT));
                $DocenteCel = limpiarCadena(filter_var($DocenteCel,FILTER_SANITIZE_NUMBER_INT));
                $totalhoras = limpiarCadena(filter_var($totalhoras,FILTER_SANITIZE_NUMBER_INT)); 
                $grupoid = limpiarCadena(filter_var($grupoid,FILTER_SANITIZE_NUMBER_INT));
                $servicio = limpiarCadena(filter_var($servicio,FILTER_SANITIZE_NUMBER_INT));
                $TotalHoras = limpiarCadena(filter_var($TotalHoras,FILTER_SANITIZE_NUMBER_INT));
                
                $sqlusuario = "SELECT idusuario FROM usuario WHERE usuario ='".$_SESSION['f_usuario']."'";
                $usuario = $db->GetRow($sqlusuario);
                $usuarioCreacion = $usuario['idusuario'];
                
                $FechaCreacion = date("Y-m-d");

                $data = new Spreadsheet_Excel_Reader();
               	$data->setOutputEncoding('CP1251');
                $data->read($_FILES["file"]["tmp_name"]); 
                $filas = $data->sheets[0]['numRows'];
                
                $contador=0;
                $errores = 0;
                $x=0;
                $d=0;
                for ($z = 2; $z <= $filas; $z++) 
                {
                    $fields['Documento']=$data->sheets[0]['cells'][$z][1];
                    $fields['nombre']=$data->sheets[0]['cells'][$z][2];                    
                    $documentonumero = str_replace(' ', '', $fields['Documento']);
                    
                    $sqlestudiante = "SELECT DISTINCT e.codigoestudiante FROM estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral INNER JOIN prematricula p ON p.codigoestudiante = e.codigoestudiante INNER JOIN detalleprematricula dp ON dp.idprematricula = p.idprematricula INNER JOIN materia m ON m.codigomateria = dp.codigomateria WHERE eg.numerodocumento = '".$documentonumero."' and p.codigoperiodo = '".$periodo."' and p.codigoestadoprematricula= '40' and m.codigocarrera = '".$carrera."'";
                    $Resultadocodigoestudiante = $db->GetRow($sqlestudiante); 
                    //echo "<pre>";
                    //echo $sqlestudiante." -- ";                   
                    $codigoestudiante = $Resultadocodigoestudiante['codigoestudiante'];
                    // var_dump($codigoestudiante);
                    if($codigoestudiante!= null)
                    {
                         $sqlinsert = "INSERT INTO RotacionEstudiantes (codigoestudiante,	codigomateria,	idsiq_convenio,	IdUbicacionInstitucion,IdInstitucion, FechaIngreso,	FechaEgreso,	codigoestado,	UsuarioCreacion,	FechaCreacion,	EstadoRotacionId, codigoperiodo, codigocarrera, TotalDias,JornadaId, SubgrupoId) VALUES ('".$codigoestudiante ."', '".$materias."', '".$convenioid."', '".$ubicacionid."','".$institucionid."', '".$fechaingreso."', '".$fechaegreso."', '100','".$usuarioCreacion."', '".$FechaCreacion."', '1', '".$periodo."', '".$carrera."', '".$dias."','".$jornada."', '".$grupoid."');";
                        $resultadoinsert = $db->execute($sqlinsert);
                        
                        $RotacionEstudianteId = $db->insert_ID();
                        foreach($codigodia as $numerodia)
                        {
                            $sqlDetallerotacion = "INSERT INTO DetalleRotaciones (RotacionEstudianteId, codigodia, codigoestado, NombreDocenteCargo, EmailDocente, TelefonoDocente) VALUES ('".$RotacionEstudianteId."', '".$numerodia."', '100', '".$docentecargo."', '".$docenteemail."', '".$docentecel."')";
                            $insertdetalle = $db->execute($sqlDetallerotacion);  
                        }
                        $d++;
                        
                        for($i=0; isset($Especialidad[$i]);$i++)
                        {   
                            if(is_array($Especialidad[$i]))//valida si viene mas datos tipo array para finalizar el conteo
                            {}else
                            {                                
                                $sqlespecialidades = "Select RotacionEspecialidadId, CodigoEstado from RotacionEspecialidades where RotacionEstudianteId = '".$RotacionEstudianteId."' and EspecialidadCarreraId ='".$Especialidad[$i]."'";
                                $Datos = $db->GetRow($sqlespecialidades);
                                if($Datos['CodigoEstado']=='200')//si ya existe la especialidad en estado inactiva se reactiva
                                {
                                    $sqlupdate = "UPDATE RotacionEspecialidades SET CodigoEstado='100' WHERE (RotacionEspecialidadId='".$Datos['RotacionEspecialidadId']."');";
                                    $update = $db->execute($sqlupdate);
                                }//if
                                if($Datos['CodigoEstado']== null)//si no exite la especialidad se inserta
                                {
                                    $sqlespecialidades = "INSERT INTO RotacionEspecialidades (RotacionEstudianteId, EspecialidadCarreraId, UsuarioCreacion, FechaCreacion, FechaUltimaModificacion, UsuarioUltimaModificacion, CodigoEstado) values ('".$RotacionEstudianteId."', '".$Especialidad[$i]."', '".$userid."', NOW(), NOW(), '".$userid."', '100');";                                          $insertespecialidad = $db->execute($sqlespecialidades);
                                }//if
                            }//else
                        }
                        $datos = implode(",",$Especialidad);
                        $datos = str_replace(",Array", "", $datos);
                        $sqldesactivar = "select RotacionEspecialidadId from RotacionEspecialidades where EspecialidadCarreraId NOT IN (".$datos.") and RotacionEstudianteId = '".$RotacionEstudianteId."'";
                        $listadesactivar = $db->GetAll($sqldesactivar);
                        foreach($listadesactivar as $desactivar)
                        {
                            $sqldesactiva = "UPDATE RotacionEspecialidades SET CodigoEstado='200' WHERE (RotacionEspecialidadId='".$desactivar['RotacionEspecialidadId']."')';"; 
                        }
                    }//if estudiante   
                }//for
            }//file null
          if($d==0)
          {
            $mensaje = "No se realizao el Cargue Masivo, numero de estudiantes registrados ".$d." ";
          }
          else
          {
            $mensaje = "Cargue Masivo Realizado, se registraron ".$d." Estudiantes";  
          }  
        }break; 
    }    
    echo $template_index->render(array(
			'title' => 'CARGUE DE ROTACIONES MASIVAS',
            'Periodo' => $periodo,
            'Programa' => $programa,
            'Carrera' => $codigocarrera,
            'Convenios' => $convenios,
            'JornadaData' => $JornadaData,
            'EspecialidadData' => $EspecialidadData,
            'MateriasData' => $materiasData,
            'Mensaje' => $mensaje
		)
	);	
?>
