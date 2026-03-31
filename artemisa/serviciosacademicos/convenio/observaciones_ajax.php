<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");
    require_once("NotificacionConvenio.php");

    if(!$db){
    	$db = getBD();
    }
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    
    $userid=$Usario_id['id'];
    $fecha = date('Y-m-d H-i-s');
    
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }


switch($_POST['Action_id'])
{
     
    case 'PasoFirmasProceso':{
        
        $id     = $_POST['id'];
        $userid = $_POST['usuario'];
        
        $SQL_Cambio= 'UPDATE SolicitudConvenios
                      SET    ConvenioProcesoId="13",
                             UsuarioModificacion="'.$userid.'",
                             FechaModificacion=NOW()
                      WHERE  SolicitudConvenioId="'.$id.'"';
                      
        if($CambioContraparte=&$db->Execute($SQL_Cambio)===false){
            $a_vectt['val'] = false;         
            echo json_encode($a_vectt);
            exit;
        }   
        
            $a_vectt['val'] = true;         
            echo json_encode($a_vectt);
            exit;  
    }break;
    case 'CambioProcesoContraParte':{
        $id     = $_POST['id'];
        $valor  = $_POST['valor'];
        $userid = $_POST['usuario'];
        
        $SQL_Cambio= 'UPDATE SolicitudConvenios
                      SET    ConvenioProcesoId="'.$valor.'",
                             UsuarioModificacion="'.$userid.'",
                             FechaModificacion=NOW()
                      WHERE  SolicitudConvenioId="'.$id.'"';
                      
        if($CambioContraparte=&$db->Execute($SQL_Cambio)===false){
            $a_vectt['val'] = false;         
            echo json_encode($a_vectt);
            exit;
        }   
        
            $a_vectt['val'] = true;         
            echo json_encode($a_vectt);
            exit;           
    }break;
    case 'Observaciones': 
    {
       //Se incluye información para agregar a la observacion y se cambia el estado de la solicitud para reportarla a la facultad solicitante.
        $rol = $_POST['rol'];           
        //1 Administrador Jurídico
        if($rol == '11' || $rol == 11)
        {        
            if($_POST['textarea'])
            {
                if($_POST['procesoConvenio']=='1' || $_POST['procesoConvenio']==1){
                    $valorProceso = 5;                    
                }else{
                    $valorProceso = 10;
                }
                $textarea = limpiarCadena(filter_var($_POST['textarea'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
                $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$_POST['id']."', '".$valorProceso."', '".$_POST['usuario']."', '".$fecha."')";                
                $insertar4= $db->execute($logCambios);
                
                $selectlogid = "select LogSolicitudConvenioId from LogSolicitudConvenios where SolicitudConvenioId='".$_POST['id']."' and ConvenioProcesoId ='".$valorProceso."' and UsuarioCreacion ='".$_POST['usuario']."' ORDER BY LogSolicitudConvenioId DESC";
                 $buscar= $db->GetRow($selectlogid);
                
                $sqlinsert = "INSERT INTO ObservacionSolicitudes (SolicitudConvenioId, Observacion, Usuario, FechaCreacion, CodigoEstado, LogSolicitudConvenioId) VALUES ('".$_POST['id']."', '".$textarea."', '".$_POST['usuario']."', '".$fecha."', '100', '".$buscar['LogSolicitudConvenioId']."');";
                $insertar = $db->execute($sqlinsert);
                
                $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='".$valorProceso."' WHERE (SolicitudConvenioId='".$_POST['id']."')";
                $update = $db->execute($updatesolicitud);
                
                if($valorProceso==10)
                {
                    $to ="direcciondedesarrollo@unbosque.edu.co, quinteroivan@unbosque.edu.co";
                    $asunto = "Notificacion solicitud de convenio";
                    $mensaje = "Nueva Solicitud Convenio por revisar en la oficina de desarrollo. por favor ingrese al sistema para consultar la lista de convenios en tramite.";  
                    EnviarCorreo($to,$asunto,$mensaje);
                  }                
                echo true;      
            }else
            {
                //si en la informacion no se reporta informacion de la obsevación, se reporta error.
                echo json_encode(false);        
            }
        }
       if($rol == '1' || $rol == 1)
        {        
            if($_POST['textarea'])
            {
                $textarea = limpiarCadena(filter_var($_POST['textarea'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
                $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$_POST['id']."', '12', '".$_POST['usuario']."', '".$fecha."')";                
                $insertar4= $db->execute($logCambios);
                
                $selectlogid = "select LogSolicitudConvenioId from LogSolicitudConvenios where SolicitudConvenioId='".$_POST['id']."' and ConvenioProcesoId ='12' and UsuarioCreacion ='".$_POST['usuario']."' ORDER BY LogSolicitudConvenioId DESC";
                 $buscar= $db->GetRow($selectlogid);
                
                $sqlinsert = "INSERT INTO ObservacionSolicitudes (SolicitudConvenioId, Observacion, Usuario, FechaCreacion, CodigoEstado, LogSolicitudConvenioId) VALUES ('".$_POST['id']."', '".$textarea."', '".$_POST['usuario']."', '".$fecha."', '100', '".$buscar['LogSolicitudConvenioId']."');";
                $insertar = $db->execute($sqlinsert);
                
                $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='12' WHERE (SolicitudConvenioId='".$_POST['id']."')";
                $update = $db->execute($updatesolicitud);              
                echo true;      
            }else
            {
                //si en la informacion no se reporta informacion de la obsevación, se reporta error.
                echo json_encode(false);        
            }
        }
        //2 Administrador Convenios
        if($rol == '2' || $rol == 2)
        {
            if($_POST['textarea'])
            {
                $textarea = limpiarCadena(filter_var($_POST['textarea'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
                $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$_POST['id']."', '9', '".$_POST['usuario']."', '".$fecha."')";
                $insertar4= $db->execute($logCambios);
                
                $selectlogid = "select LogSolicitudConvenioId from LogSolicitudConvenios where SolicitudConvenioId='".$_POST['id']."' and ConvenioProcesoId ='9' and UsuarioCreacion ='".$_POST['usuario']."' ORDER BY LogSolicitudConvenioId DESC";
                $buscar= $db->GetRow($selectlogid);
                
                $sqlinsert = "INSERT INTO ObservacionSolicitudes (SolicitudConvenioId, Observacion, Usuario, FechaCreacion, CodigoEstado, LogSolicitudConvenioId) VALUES ('".$_POST['id']."', '".$textarea."', '".$_POST['usuario']."', '".$fecha."', '100', '".$buscar['LogSolicitudConvenioId']."');";
                $insertar = $db->execute($sqlinsert);
                
                $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='9', PasoSolicitud = '6' WHERE (SolicitudConvenioId='".$_POST['id']."')";
                $update = $db->execute($updatesolicitud);
                
                $sqlusuario = "SELECT u.usuario, uf.emailusuariofacultad FROM SolicitudConvenios s INNER JOIN usuario u ON u.idusuario = s.UsuarioCreacion LEFT JOIN usuariofacultad uf ON uf.idusuario = s.UsuarioCreacion WHERE s.SolicitudConvenioId= '".$_POST['id']."'";
                $emailusuario = $db->GetRow($sqlusuario);
                if(!isset($emailusuario['emailusuariofacultad']))
                {
                    $email = $emailusuario['usuario']."@unbosque.edu.co";
                }else
                {
                    $email = $emailusuario['emailusuariofacultad'];
                }
                $to = "quinteroivan@unbosque.edu.co, ".$email;
                $asunto = "Notificacion solicitud de convenio";
                $mensaje = "Solicitud de ajustes para la facultad solicitante. por favor ingrese al sistema para verificar las solicitudes de convenios pendientes.";        
                EnviarCorreo($to,$asunto,$mensaje);
                
                echo true;       
            }else
            {
                //si en la informacion no se reporta informacion de la obsevación, se reporta error.
                echo json_encode(false);        
            }
        } 
    }break;
    case 'Instituciones':
    {
        $ciudad = limpiarCadena(filter_var($_POST['ciudad'],FILTER_SANITIZE_NUMBER_INT));        
        $tipoisntitucion = limpiarCadena(filter_var($_POST['tipoinstitucion'],FILTER_SANITIZE_NUMBER_INT));        
        $nombre = limpiarCadena(filter_var($_POST['nombreinstitucion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        
        $sqlconsulta = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where CiudadId = '".$ciudad."' and idsiq_tipoinstitucion = '".$tipoisntitucion."' and NombreInstitucion like '%".$nombre."%'";
        $instituciones = $db->GetAll($sqlconsulta);
        $imp = "<td>Instituciones Disponibles </td><td>";
        $c=1;
        foreach($instituciones as $lista)
        {
            $imp.= "<input type='radio' id='institucion".$c."' name='institucion' value='".$lista['InstitucionConvenioId']."'>".$lista['NombreInstitucion']."</br>";
            $c++;
        }
        $imp.= "</td>" ;
        echo $imp;
    }break;
    case 'SaveData':
    {   
        $id=$_POST['id'];             
        $Direccion = limpiarCadena($_POST['Direccion']);             
        $nombreinstitucion = limpiarCadena(filter_var($_POST['nombreinstitucion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));//%C3%8DNICA&e
        $ciudadid = limpiarCadena(filter_var($_POST['ciudadid'],FILTER_SANITIZE_NUMBER_INT));
        $tipoinstitucion = limpiarCadena(filter_var($_POST['tipoinstitucion'],FILTER_SANITIZE_NUMBER_INT));
        $RepresentanteLegal = limpiarCadena(filter_var($_POST['RepresentanteLegal'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));//representante&
        $IdentificacionRepresentante = limpiarCadena(filter_var($_POST['IdentificacionRepresentante'],FILTER_SANITIZE_NUMBER_INT));
        $nombresupervisor = limpiarCadena(filter_var($_POST['nombresupervisor'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $correosupervisor = filter_var($_POST['correosupervisor'],FILTER_SANITIZE_EMAIL);//%40gmail.com&
        $cargosupervisor = limpiarCadena(filter_var($_POST['cargosupervisor'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $telefonosupervisor = limpiarCadena(filter_var($_POST['telefonosupervisor'],FILTER_SANITIZE_NUMBER_INT));
        $nombresolicitante = limpiarCadena(filter_var($_POST['nombresolicitante'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $cargosolicitante = limpiarCadena(filter_var($_POST['cargosolicitante'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $correosolicitante = filter_var($_POST['correosolicitante'],FILTER_SANITIZE_EMAIL);
        $telefonosolicitante = limpiarCadena(filter_var($_POST['telefonosolicitante'],FILTER_SANITIZE_NUMBER_INT));
        $duracion = limpiarCadena(filter_var($_POST['duracion'],FILTER_SANITIZE_NUMBER_INT));
        
        $sqlinsertinstitucion = "INSERT INTO InstitucionConvenios (NombreInstitucion, Direccion, RepresentanteLegal, IdentificacionRepresentante, CiudadId, idsiq_tipoinstitucion, idsiq_estadoconvenio, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion, NombreSupervisor, TelefonoSupervisor, CargoSupervisor, NombreSolicitanteBosque, TelefonoSolicitanteBosque, CargoSolicitanteBosque, Vigencia) VALUES ('".$nombreinstitucion."', '".$Direccion."', '".$RepresentanteLegal."', '".$IdentificacionRepresentante."', '".$ciudadid."', '".$tipoinstitucion."', '1', '".$userid."', '".$fecha."', '".$userid."', '".$fecha."', '".$nombresupervisor."', '".$telefonosupervisor."', '".$cargosupervisor."', '".$nombresolicitante."', '".$telefonosolicitante."', '".$cargosolicitante."', '".$duracion."');";                     
        $insertar= $db->execute($sqlinsertinstitucion);
        $InstitucionConvenioId = $db->Insert_ID();
        
        if($InstitucionConvenioId)
        {            
            $a_vectt['descrip'] = "La institución se reguistro correctamente. ";
            $a_vectt['val'] = true;
            
            $sqlinsertSolicitudInstituciones = "INSERT INTO SolicitudInstituciones (SolicitudConvenioId, InstitucionConvenioId, FechaCreacion, FechaModificacion, UsuarioCreacion, UsuarioModificacion) VALUES ('".$id."', '".$InstitucionConvenioId."', '".$fecha."', '".$fecha."', '".$userid."', '".$userid."');";            
            $insertar2= $db->execute($sqlinsertSolicitudInstituciones);
            
            $sqlCambioestado = "UPDATE SolicitudConvenios SET ConvenioProcesoId='4' WHERE (SolicitudConvenioId='".$id."')";            
            $insertar3= $db->execute($sqlCambioestado);
            
            $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$id."', '4', '".$userid."', '".$fecha."')";            
            $insertar4= $db->execute($logCambios);
            
            $to = "adminconvenios2@unbosque.edu.co, quinteroivan@unbosque.edu.co";      
            $asunto = "Notificacion solicitud de convenio";
            $mensaje = "Nueva Solicitud Convenio por revisar en Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
            EnviarCorreo($to,$asunto,$mensaje);
        }else
        {
            $a_vectt['descrip'] = "La instituciónno no se reguistro.";
            $a_vectt['val'] = false;
        }
        echo $a_vectt['val'];         
        echo json_encode($a_vectt);
        exit;
    }break;
    case 'SaveFile':
    {        
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
        {               
            //Tipo de Anexo
            $TipoAnexo = $_POST['TipoAnexo'];
            $id = $_POST['id'];
            $user = $_POST['usuario'];
            $fecha = date("Y-m-d H:i:s");
            //obtenemos el archivo a subir
            $file = $_FILES['archivoConvenio']['name']; 
            //print_r($_FILES['archivoConvenio']);die;
            $filetmp = $_FILES['archivoConvenio']['tmp_name'];
            
            if(!is_dir("fileSolicitudConvenio/"))
            {
                mkdir("fileSolicitudConvenio/", 775);
            } 
            $file = str_replace(" ", "_", $file);    
            //comprobamos si el archivo ha subido
            $nombre = str_replace(".pdf", "", $file);
            $nombre = str_replace(".docx", "", $nombre);
            $nombre = str_replace(".doc", "", $nombre);
            if($_FILES['archivoConvenio']['type']== "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
            {
                $formato = "doc";
            }
            if($_FILES['archivoConvenio']['type'] == "application/pdf")
            {
                $formato = "pdf";
            }
            
            if ($file && move_uploaded_file($filetmp,"fileSolicitudConvenio/".$file))
            {
                $sqlselect = "Select SolicitudAnexoId from SolicitudAnexos where SolicitudConvenioId= '".$id."' and TipoAnexoId='".$TipoAnexo."' and CodigoEstado='100';";
                $buscar = $db->GetRow($sqlselect);
                if($buscar['SolicitudAnexoId'])
                {
                    $sqlupdate = "UPDATE SolicitudAnexos SET CodigoEstado = '200' WHERE (SolicitudAnexoId='".$buscar['SolicitudAnexoId']."')";
                //echo $sqlupdate;
                    if($update= $db->execute($sqlupdate)===false){
                        $Data['val'] = false;
                        $Data['mesj'] = 'Error del sistema';
                        echo json_encode($Data);
                        exit;
                    }
                    $sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$id."', '".$nombre."', 'fileSolicitudConvenio/".trim($file)."', '".$TipoAnexo."', '".$formato."', '".$fecha."', '".$user."', '".$fecha."', '".$user."', '100');";
                    //echo $sqlinsert;
                    if($insert= $db->execute($sqlinsert)===false){
                    $Data['val'] = false;
                    $Data['mesj'] = 'Error del sistema';
                    echo json_encode($Data);
                    exit;
                    }
                }
                else
                {
                    $sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$id."', '".$nombre."', 'fileSolicitudConvenio/".trim($file)."', '".$TipoAnexo."', '".$formato."', '".$fecha."', '".$user."', '".$fecha."', '".$user."', '100');";
                    //echo $sqlinsert;
                    if($insert= $db->execute($sqlinsert)===false){
                    $Data['val'] = false;
                    $Data['mesj'] = 'Error del sistema';
                    echo json_encode($Data);
                    exit;
                    }
                }
                sleep(1);//retrasamos la petición 3 segundos
                //echo $file;//devolvemos el nombre del archivo para pintar la imagen
                $Data['val'] = true;
                echo json_encode($Data);
                exit;
            }
            else
            {
                throw new Exception("Error Processing Request", 1);   
            }
        }            
    }break;
    case 'PasoJuridico':
    {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        
        $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='5' WHERE (SolicitudConvenioId='".$_POST['id']."')";
        $update = $db->execute($updatesolicitud);
                
        $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$id."', '5', '".$usuario."', '".$fecha."')";
        $insertar4= $db->execute($logCambios);  
               
        $to = "adminconvenios2@unbosque.edu.co";
        $asunto = "Notificacion solicitud de Convenio";
        $mensaje = "Nueva Solicitud de convenio por revisar por la Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
        EnviarCorreo($to,$asunto,$mensaje);     
        
        echo json_encode(true);
    }break;
    case 'PasoSecretaria':
    {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        
        $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='4' WHERE (SolicitudConvenioId='".$id."')";      
        if($update = $db->execute($updatesolicitud)===false){
        echo json_encode(false);
        exit;
        }
                
        $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$id."', '4', '".$usuario."', '".$fecha."')";   
        if($insertar4= $db->execute($logCambios)===false){
        echo json_encode(false);
        exit;
        }
        
        $sqlusuario = "SELECT u.usuario, uf.emailusuariofacultad FROM SolicitudConvenios s INNER JOIN usuario u ON u.idusuario = s.UsuarioCreacion LEFT JOIN usuariofacultad uf ON uf.idusuario = s.UsuarioCreacion WHERE s.SolicitudConvenioId= '".$id."'";
        $emailusuario = $db->GetRow($sqlusuario);
        if(!isset($emailusuario['emailusuariofacultad']))
        {
            $email = $emailusuario['usuario']."@unbosque.edu.co";
        }else
        {
            $email = $emailusuario['emailusuariofacultad'];
        }
        
        $to = "quinteroivan@unbosque.edu.co,  adminconvenios2@unbosque.edu.co, ".$email;
        $asunto = "Notificacion solicitud de convenio";
        $mensaje = "Nueva Solicitud de convenio por revisar por la Secretaria General. Por favor ingrese al sistema para verificar la lista de convenios en tramite.";
        EnviarCorreo($to,$asunto,$mensaje);
        
        echo json_encode(true); 
    }break;
    case 'contraparte':
    {
        $id = $_POST['id'];
        $usuario = $_POST['usuario'];
        $rol = '2';
        
        $updatesolicitud = "UPDATE SolicitudConvenios SET ConvenioProcesoId='8' WHERE (SolicitudConvenioId='".$id."')";      
        if($update = $db->execute($updatesolicitud)===false){
        echo json_encode(false);
        exit;
        }
                
        $logCambios = "Insert into LogSolicitudConvenios (SolicitudConvenioId, ConvenioProcesoId, UsuarioCreacion, FechaCreacion) values('".$id."', '8', '".$usuario."', '".$fecha."')";   
        if($insertar4= $db->execute($logCambios)===false){
        echo json_encode(false);
        exit;
        }
        
        $institucion = "select InstitucionConvenioId from SolicitudConvenios where SolicitudConvenioId= '".$id."'";
        $estado_institucion = $db->GetRow($institucion);
        
        if($estado_institucion == '0')
        {
            $SQL="SELECT s.NombreInstitucion,
                        s.DuracionConvenioId, 
                        s.NumeroActa,
                        s.FechaEnvioSolicitud,
                        ss.InstitucionConvenioId,
                        i.CiudadId,
                        p.idpais                    
                FROM
                        SolicitudConvenios s INNER JOIN SolicitudInstituciones ss ON ss.SolicitudConvenioId=s.SolicitudConvenioId
                                             INNER JOIN InstitucionConvenios i ON i.InstitucionConvenioId=ss.InstitucionConvenioId
                                             INNER JOIN ciudad c ON c.idciudad=i.CiudadId
                                             INNER JOIN departamento d ON d.iddepartamento=c.iddepartamento
                                             INNER JOIN pais p ON p.idpais=d.idpais
                WHERE
                s.SolicitudConvenioId='".$id."';";
            
        }else
        {
            $SQL = "SELECT
                            	s.NombreInstitucion,
                            	s.DuracionConvenioId,
                            	s.NumeroActa,
                            	s.FechaEnvioSolicitud,
                            	s.ambito,
                            	s.InstitucionConvenioId,
                            	i.CiudadId,
                            	p.idpais
                            FROM
                            	SolicitudConvenios s
                            INNER JOIN InstitucionConvenios i ON i.InstitucionConvenioId = s.InstitucionConvenioId
                            INNER JOIN ciudad c ON c.idciudad = i.CiudadId
                            INNER JOIN departamento d ON d.iddepartamento = c.iddepartamento
                            INNER JOIN pais p ON p.idpais = d.idpais
                            WHERE
                            	s.SolicitudconvenioId = '".$id."'";
        }
        $datosconsulta = $db->GetRow($SQL);                
        $NombreConvenio = $datosconsulta['NombreInstitucion'];
        $institucion = $datosconsulta['InstitucionConvenioId'];
        $Pais_id = $datosconsulta['idpais'];
        $DuracionConvenio = $datosconsulta['DuracionConvenioId'];
        $NumeroActaConsejo = $datosconsulta['NumeroActa'];
        $FechaActa  = $datosconsulta['FechaEnvioSolicitud'];
        
        $fecha1 = date('Y-m-d');
        
        $nuevafecha = strtotime("+".$DuracionConvenio." year",strtotime($fecha1));        
        $nuevafecha = date("Y-m-d", $nuevafecha);        
        
        $fechaclausula = strtotime("-3 month",strtotime($nuevafecha));         
        $fechaclausula = date("Y-m-d", $fechaclausula); 
        
        $Insert='INSERT INTO Convenios (`NombreConvenio`,`PaisId`,`FechaInicio`, `FechaFin`, `InstitucionConvenioId`,`idsiq_tipoconvenio`,`TipoRenovacionId`,`idsiq_duracionconvenio`,`idsiq_estadoconvenio`,`UsuarioCreacion`,`FechaCreacion`,`UsuarioModificacion`,`FechaModificacion`,`NumeroActaConsejo`,`FechaActa`,`FechaClausulaTerminacion` )VALUES("'.$NombreConvenio.'","'.$Pais_id.'",NOW(), "'.$nuevafecha.'", "'.$institucion.'","1","1","'.$DuracionConvenio.'","1","'.$userid.'",NOW(),"'.$userid.'",NOW(),"'.$NumeroActaConsejo.'","'.$FechaActa.'", "'.$fechaclausula.'");';        
        $executa = $db->execute($Insert);
        
        $sqlusuario = "SELECT u.usuario, uf.emailusuariofacultad FROM SolicitudConvenios s INNER JOIN usuario u ON u.idusuario = s.UsuarioCreacion LEFT JOIN usuariofacultad uf ON uf.idusuario = s.UsuarioCreacion WHERE s.SolicitudConvenioId = '".$id."'";
        $emailusuario = $db->GetRow($sqlusuario);
                
        if(!isset($emailusuario['emailusuariofacultad']))
        {
            $email = $emailusuario['usuario']."@unbosque.edu.co";
        }else
        {
            $email = $emailusuario['emailusuariofacultad'];
        }
        
        $to = "quinteroivan@unbosque.edu.co, lealhannia@unbosque.edu.co, internacionalizacion2@unbosque.edu.co, direcciondedesarrollo@unbosque.edu.co, relacionesinterinstitucionales@unbosque.edu.co, adminconvenios2@unbosque.edu.co, ".$email;
        $asunto = "Notificacion solicitud de convenio";
        $mensaje = "Solicitud de convenio Finalizado. Por favor ingrese al sistema para verificar la lista de convenios activos.";
        EnviarCorreo($to,$asunto,$mensaje);
        echo json_encode(true);
        
    }break;
}
?>