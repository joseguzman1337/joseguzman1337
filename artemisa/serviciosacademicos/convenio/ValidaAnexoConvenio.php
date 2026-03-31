<?php
session_start();
include_once ('../EspacioFisico/templates/template.php');
if(!isset ($_SESSION['MM_Username']))
{
    //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
    echo "No ha iniciado sesión en el sistema";
    exit();
}
$db = getBD();
$sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
$usuario = $db->Execute($sqlS);
$datosusuario =  $usuario->getarray();
$user = $datosusuario[0][0];
$id = $_REQUEST['idconvenio'];
$tipoanexo = $_REQUEST['tipoanexo'];
$idtipoconvenio = $_REQUEST['idtipoconvenio'];
$idinstitucion = $_REQUEST['idinstitucion'];
$tipoanexo = $_REQUEST['tipoanexo'];
$tipoprorroga = $_REQUEST['tipoprorroga'];


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

switch($_REQUEST['Action_id'])
{
    case 'SaveData':
	{
        switch($tipoanexo)
		{
            case '1':
            {
                $Modalidad                  = $_POST['Modalidad']; 
                $carrera                    = $_POST['carrera'];
                $NivelFormacion             = $_POST['NivelFormacion'];               
                $cupos                      = $_POST['cuposubicacion_'];
				$dato 						= $_FILES["dato"];
                $FechaCreacion              = date("Y-m-d H:i:s"); 
       
               if($dato== "")
               {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                echo "</script>";
                exit();
              }
              $archivotmp = $_FILES["dato"]["tmp_name"];
              //$tamanio = getArray();
              $tamanio[] = $_FILES["dato"]["size"];
              $tipo = $_FILES["dato"]["type"];
              $Info = pathinfo($_FILES["dato"]["name"]);
                 
              if( $Info['extension']!='doc' && $tipo!='application/vnd.openxmlformats-officedocument.wordprocessingml.document' && $Info['extension']!='pdf')
              {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es Word 2007 en adelante o .docx.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                    echo "</script>"; 
            	}	
             
                $nombre_archivo = $_FILES["dato"]["name"];
                
                extract($_REQUEST);
                if ( $archivotmp != "none" ){
                    //ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
                	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
                	$fp = fopen($archivotmp, "rb");
                	//LEEMOS EL CONTENIDO DEL ARCHIVO
                	$contenido = fread($fp, $tamanio);
                	//CON LA FUNCION addslashes AGREGAMOS UN \ A CADA COMILLA SIMPLE ' PORQUE DE OTRA MANERA
                	//NOS MARCARIA ERROR A LA HORA DE REALIZAR EL INSERT EN NUESTRA TABLA
                	$contenido = addslashes($contenido);
                	//CERRAMOS EL ARCHIVO
                	fclose($fp);
                	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
                    if ($tamanio > 1048576){
                	  //HACEMOS LA CONVERSION PARA PODER GUARDAR SI EL TAMAÑO ESTA EN b ó MB
                	    $tamaniodatos=CalcularTamano($tamanio);
                       }else{
                    $tamaniodatos=CalcularTamano($tamanio);
                   }
                   
                   if($tamaniodatos[1]=='MB'){
                			if($tamaniodatos[0]>10)
                            {
                                $mensaje = "Supera el Tama\u00f1o permitido.";
                                echo "<script>";
                                echo "alert('".$mensaje."');";  
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                                echo "</script>"; 
                				}
                		}    
                }

                $sql1="SELECT count(IdAnexoConvenio) FROM AnexoConvenios WHERE codigomodalidadacademica = '".$Modalidad."' AND codigocarrera = '".$carrera."' 
				AND idsiq_tipoanexo = '".$tipoanexo."' AND ConvenioId = '".$idconvenio."' And codigoestado = '100'";
                if($Consulta=$db->Execute($sql1)===true)
                {
                    $mensaje = "Error de consulta en la base de datos.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                    echo "</script>"; 
                }
				
                $valores = $db->Execute($sql1);
                $datos =  $valores->getarray();
                if (!empty($datos[0][0]))
                {
                    $mensaje = "El anexo que esta intentando ingresar ya se encuentra registrado.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                    echo "</script>";  
                }else
                {
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                     if(!empty($cupos)){
                        foreach($cupos as $datos => $valor)
                        {
                            $clave= $datos;
                            $Totalcupos +=  $valor;
                       }    
                    }
				
                    $sql2="insert into AnexoConvenios(idsiq_tipoanexo, codigocarrera, codigomodalidadacademica, TotalCupos, codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ) values ('".$tipoanexo."', '".$carrera."', '".$Modalidad."', '".$Totalcupos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."')"; 
                    $agregar = $db->Execute($sql2);
                    $sqlAnexo = "select IdAnexoConvenio from AnexoConvenios where codigocarrera='".$carrera."' and idsiq_tipoanexo ='".$tipoanexo."' and codigomodalidadacademica= '".$Modalidad."' and idsiq_convenio = '".$idconvenio."'";
					$valoresAnexo = $db->Execute($sqlAnexo);
                    if(!empty($valoresAnexo)){
                         foreach($valoresAnexo as $datosAnexo)
                         {
                            $IdAnexoConvenio = $datosAnexo['IdAnexoConvenio'];
                        }    
                    }else{
                        echo 'vacio';
                        echo $valoresAnexo;   
                    }
                    if(!empty($cupos)){
                        foreach($cupos as $datoss => $valor)
                        {
                            $clave= $datoss;
                            $Totalcupos +=  $valor;
                            $SqlCupos = "insert into UbicacionInstitucionCupos(IdUbicacionInstitucion, IdAnexoConvenio, NumeroCupos, codigocarrera, codigoestado, UsuarioCreacion, FechaCreacion) values('".$clave."','".$IdAnexoConvenio."','".$valor."', '".$carrera."', '100', '".$user."', '".$FechaCreacion."')";
                            $agregar = $db->Execute($SqlCupos);
                        }    
                    }
                    //$mensaje = "El anexo fue agregado.";
                    echo "<script>";
                    echo "alert('El anexo fue agregado.');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                    echo "</script>";
                    
                }
            }
            break;
        case '13':
        {            
			$dato = $_FILES["dato"];
			if($dato== "")
            {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                echo "</script>";
                exit();
            }
              $archivotmp = $_FILES["dato"]["tmp_name"];
              //$tamanio = getArray();
              $tamanio[] = $_FILES["dato"]["size"];
              $tipo = $_FILES["dato"]["type"];
              $Info = pathinfo($_FILES["dato"]["name"]);
                 
              if( $Info['extension']!='doc' && $tipo!='application/vnd.openxmlformats-officedocument.wordprocessingml.document' && $Info['extension']!='pdf')
              {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es Word 2007 en adelante o .docx.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$id."';";
                    echo "</script>"; 
            	}	
             
                $nombre_archivo = $_FILES["dato"]["name"];
                
                extract($_REQUEST);
                if ( $archivotmp != "none" ){
                    //ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
                	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
                	$fp = fopen($archivotmp, "rb");
                	//LEEMOS EL CONTENIDO DEL ARCHIVO
                	$contenido = fread($fp, $tamanio);
                	//CON LA FUNCION addslashes AGREGAMOS UN \ A CADA COMILLA SIMPLE ' PORQUE DE OTRA MANERA
                	//NOS MARCARIA ERROR A LA HORA DE REALIZAR EL INSERT EN NUESTRA TABLA
                	$contenido = addslashes($contenido);
                	//CERRAMOS EL ARCHIVO
                	fclose($fp);
                	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
                    if ($tamanio > 1048576){
                	  //HACEMOS LA CONVERSION PARA PODER GUARDAR SI EL TAMAÑO ESTA EN b ó MB
                	    $tamaniodatos=CalcularTamano($tamanio);
                       }else{
                    $tamaniodatos=CalcularTamano($tamanio);
                   }
                   
                   if($tamaniodatos[1]=='MB'){
                			if($tamaniodatos[0]>10)
                            {
                                $mensaje = "Supera el Tama\u00f1o permitido.";
                                echo "<script>";
                                echo "alert('".$mensaje."');";  
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                                echo "</script>"; 
                				}
                		}    
                }

                $sql1="SELECT count(IdAnexoConvenio) FROM AnexoConvenios WHERE codigomodalidadacademica = '0' AND codigocarrera = '0' AND idsiq_tipoanexo = '".$tipoanexo."' AND ConvenioId = '".$idconvenio."' And codigoestado = '100'";
                if($Consulta=$db->Execute($sql1)===true)
                {
                    $mensaje = "Error de consulta en la base de datos.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                    echo "</script>"; 
                }
				$valores = $db->Execute($sql1);
                $datos =  $valores->getarray();
				
                if (!empty($datos[0][0]))
                {
                    $mensaje = "El anexo que esta intentando ingresar ya se encuentra registrado.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
                    echo "</script>";  
                }else
                {
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $fecha  = $_POST['fechafin'];
                    $prorroga  = $_REQUEST['prorroga']; 
				
				    switch($tipoprorroga)
					{
						case '1':
                        {
                            //años
                            list($year,$mon,$day) = explode('-',$fecha);
                            $fecha =  date('Y-m-d',mktime(0,0,0,$mon,$day,$year+$prorroga));                         
						}
						break;
						case '2':
						{
						  //meses
                            list($year,$mon,$day) = explode('-',$fecha);
                            $fecha =  date('Y-m-d',mktime(0,0,0,$mon+$prorroga,$day,$year));
						}
						break;
						case '3':
                        {
                            //dias
                            list($year,$mon,$day) = explode('-',$fecha);
                            $fecha =  date('Y-m-d',mktime(0,0,0,$mon,$day+$prorroga,$year));
						}
						break;
					} 
                   
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                    
					$sqlfecha = "UPDATE Convenio SET FechaFin='".$fecha."' WHERE (ConvenioId='".$id."') AND (InstitucionConvenioId='".$idinstitucion."') AND (idsiq_tipoconvenio='".$idtipoconvenio."')";
					$updatefecha = $db->Execute($sqlfecha);
                    
					$sql2="insert into AnexoConvenios(idsiq_tipoanexo, codigocarrera, codigomodalidadacademica, codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, idsiq_convenio )
                    values ('".$tipoanexo."', '2', '001', '100', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."')"; 
                    $agregar = $db->Execute($sql2);

			echo "<script>";
			echo "alert('El anexo tipo proroga fue agregado.');";  
			echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$id."';";
			echo "</script>";
        }
        break;
     }
   }
   
}
} 
?>