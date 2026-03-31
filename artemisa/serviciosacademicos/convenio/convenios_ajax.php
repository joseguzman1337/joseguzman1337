<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
    include_once ('../EspacioFisico/templates/template.php');
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

				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
					$mime = finfo_file($finfo, $_FILES['archivo']['tmp_name']); 
				finfo_close($finfo);
				if($_FILES['archivo']['type'] == "application/pdf" && $mime=="application/pdf")
				{
					$id = $_POST['id'];
					$user = $_POST['usuario'];
					$fechamodifiacion = date("Y-m-d H:i:s");
					//obtenemos el archivo a subir
					$file = $_FILES['archivo']['name'];
				
					//comprobamos si existe un directorio para subir el archivo
					//si no es así, lo creamos
					//if(!is_dir("fileConvenio/")) 
					//    mkdir("fileConvenio/", 7777);
					 
					//comprobamos si el archivo ha subido
					if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"fileConvenio/".$file))
					{
						$sqlupdate = "update Convenios set RutaArchivo='fileConvenio/".$file."', UsuarioModificacion = '".$user."', FechaModificacion='".$fechamodifiacion."' where ConvenioId = '".$id."'";
						$update= $db->execute($sqlupdate);
						
					   sleep(3);//retrasamos la petición 3 segundos
					   echo $file;//devolvemos el nombre del archivo para pintar la imagen
					}
				}else{
					throw new Exception("No es un archivo valido", 1);   
				}
			}else{
					throw new Exception("Error Processing Request", 1);   
			}			
    }break;
    case 'Calcularclausula':{
          $fecha = $_POST['fecha'];
          $C_Fecha = strtotime("-3 month",strtotime($fecha));          
          $Fecha = date("Y-m-d", $C_Fecha);          
          $Fecha = explode('-',$Fecha);
         // $tmpFecha = "<input type='text' name='fechaClausula' id='fechaClausula' value='".."' readonly='readonly'/>";
          echo $tmpFecha = $Fecha[0].'-'.$Fecha[1].'-'.$Fecha[2];
          
    }break;
}  
?>