<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    $db = getBD();

    function CalcularTamano($bytes) 
    {
        $bytes = $bytes[0];
        $labels = array('B', 'KB', 'MB', 'GB', 'TB');
    	foreach($labels AS $label)
        {
            if ($bytes > 1024)
            {
    	       $bytes = $bytes / 1024;
            }
            else {
    	      break;
    	    }
        }  
        $datos[] =round($bytes, 2);
        $datos[] = $label; 
        return $datos;
    } 

switch($_REQUEST['actionID']){
    case 'SaveFile':
        {
			
            //comprobamos que sea una petición ajax
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
            {  
					//Tipo de Anexo
					$TipoAnexo = $_POST['TipoAnexo'];
					$id = $_POST['id'];
					$user = $_POST['usuario'];
					$fecha = date("Y-m-d H:i:s");
					//obtenemos el archivo a subir                    
					switch($TipoAnexo)
					{
						case '1': { 
				            $file = $_FILES['archivoCarta']['name']; 
                            $filetmp = $_FILES['archivoCarta']['tmp_name']; 
                            $tipofile = $_FILES['archivoCarta']['type'];} break;
						case '2': { 
                            $file = $_FILES['archivoConvenio']['name']; 
                            $filetmp = $_FILES['archivoConvenio']['tmp_name']; 
                            $tipofile = $_FILES['archivoConvenio']['type'];} break;
						case '3': { 
				            $file = $_FILES['archivoCamara']['name']; 
                            $filetmp = $_FILES['archivoCamara']['tmp_name']; 
                            $tipofile = $_FILES['archivoCamara']['type'];} break;
						case '4': { 
				            $file = $_FILES['archivoRepresentante']['name']; 
                            $filetmp = $_FILES['archivoRepresentante']['tmp_name']; 
                            $tipofile = $_FILES['archivoRepresentante']['type'];} break;
						case '5': { 
                            $file = $_FILES['archivoPlan']['name']; 
                            $filetmp = $_FILES['archivoPlan']['tmp_name']; 
                            $tipofile = $_FILES['archivoPlan']['type'];} break;
						case '6': { 
				            $file = $_FILES['archivoPresupuesto']['name']; 
                            $filetmp = $_FILES['archivoPresupuesto']['tmp_name']; 
                            $tipofile = $_FILES['archivoPresupuesto']['type'];} break;
						case '7': { 
                            $file = $_FILES['otro']['name']; 
                            $filetmp = $_FILES['otro']['tmp_name']; 
                            $tipofile = $_FILES['otro']['type'];} break;
					}
				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
					$mime = finfo_file($finfo, $filetmp); 
				finfo_close($finfo);
				$requerido = "pdf";
				if(isset($_POST["indicador2"]) || isset($_POST["indicador7"])){
					$requerido="doc";
				}/*                
				var_dump($filetmp);
				var_dump($mime);
				var_dump($tipofile);
				var_dump($requerido);
                die;*/                         
				if( ($requerido == "pdf" && $tipofile == "application/pdf" && $mime=="application/pdf") 
					|| 
					($requerido == "doc" && $tipofile == "application/msword" && $mime=="application/msword") 
					|| 
					($requerido == "doc" && $tipofile == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $mime=="application/msword"))
				{				    
				
					//comprobamos si existe un directorio para subir el archivo
					//si no es así, lo creamos                                      
					if(!is_dir("fileSolicitudConvenio/"))
					{
						mkdir("fileSolicitudConvenio/", 775);
					} 
					$file = str_replace(" ", "_", $file);    
					//comprobamos si el archivo ha subido
					$nombre = str_replace(".pdf", "", $file);
					$nombre = str_replace(".docx", "", $nombre);
					$nombre = str_replace(".doc", "", $nombre);
					
					if($tipofile== "application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword" || $tipofile == "application/msword")
					{
						$formato = "doc";
					}
					if($tipofile == "application/pdf")
					{
						$formato = "pdf";
					}
                   
					
					if ($file && move_uploaded_file($filetmp,"fileSolicitudConvenio/".$id."-".$TipoAnexo."-".$file))
					{
						$sqlselect = "Select SolicitudAnexoId from SolicitudAnexos where SolicitudConvenioId= '".$id."' and TipoAnexoId='".$TipoAnexo."';";                        
						$buscar = $db->GetRow($sqlselect);
						if($buscar['SolicitudAnexoId'])
						{
							$sqlupdate = "UPDATE SolicitudAnexos SET CodigoEstado ='200' WHERE (SolicitudAnexoId='".$buscar['SolicitudAnexoId']."')";
						//echo $sqlupdate;
							if($update= $db->execute($sqlupdate)===false){
								$Data['val'] = false;
								$Data['mesj'] = 'Error del sistema';
								echo json_encode($Data);
								exit;
							}
							$sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$id."', '".$nombre."', 'fileSolicitudConvenio/".$id."-".$TipoAnexo."-".trim($file)."', '".$TipoAnexo."', '".$formato."', '".$fecha."', '".$user."', '".$fecha."', '".$user."', '100');";
							//echo $sqlinsert;
							if($insert= $db->execute($sqlinsert)===false){
								$Data['val'] = false;
								$Data['mesj'] = 'Error del sistema';
								echo json_encode($Data);
								exit;
							}
							sleep(1);//retrasamos la petición 3 segundos
							//echo $file;//devolvemos el nombre del archivo para pintar la imagen
							$Data['val'] = true;
							echo json_encode($Data);
							exit;
							
						}
						else
						{
							$sqlinsert = "INSERT INTO SolicitudAnexos (SolicitudConvenioId, Nombre, Url, TipoAnexoId, Formato, FechaCreacion, UsuarioCreacion, FechaModificacion, UsuarioModificacion, CodigoEstado) VALUES ('".$id."', '".$nombre."', 'fileSolicitudConvenio/".$id."-".$TipoAnexo."-".trim($file)."', '".$TipoAnexo."', '".$formato."', '".$fecha."', '".$user."', '".$fecha."', '".$user."', '100');";                            
							if($insert= $db->execute($sqlinsert)===false){
								$Data['val'] = false;
								$Data['mesj'] = 'Error del sistema';
								echo json_encode($Data);
								exit;
							}
							sleep(1);//retrasamos la petición 3 segundos
							//echo $file;//devolvemos el nombre del archivo para pintar la imagen
							$Data['val'] = true;
							echo json_encode($Data);
							exit;
						}
					}
				}else{
								$Data['val'] = false;
								$Data['mesj'] = 'Error del sistema. No es un archivo valido.';
								echo json_encode($Data);
							exit;
				}
            }else{
                throw new Exception("Error Processing Request", 1);   
            }
        }break;
}  
?>