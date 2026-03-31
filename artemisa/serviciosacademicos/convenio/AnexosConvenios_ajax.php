<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    include_once('TipoAnexoConvenio_class.php');  $C_TipoAnexo = new TiposAnexos();
    $db = getBD();
 
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
 
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
function limpiarCadena($cadena) {
     $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
     return $cadena;
}

switch($_REQUEST['actionID'])
{
    case 'Carrera':{
        $C_TipoAnexo->Carrera($db,$_POST['id']);
    }break;
    case 'Calcular':{
          if($_POST['id']==3){
            $modo = 'year';
          }else{
            $modo = 'month';
          }
          
          $fechaFutura = $C_TipoAnexo->calculaFecha($modo,$_POST['valor'],$_POST['fecha']);
          
          $C_Fecha = strtotime("-1 day",strtotime($fechaFutura));
          
          $Fecha = date("Y-m-d", $C_Fecha);
          
          $Fecha = explode('-',$Fecha);
          
          echo $Fecha[2].'-'.$Fecha[1].'-'.$Fecha[0];
          
    }break;
    case 'validar':
    {
        $tipoanexo = $_REQUEST['tipoanexo'];
        $id = $_REQUEST['id'];
        
        switch($tipoanexo)
        {
            case '1':
            {
                $C_TipoAnexo->Tecnico($db,$id);
              
            }break;
            case '2':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '3':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '4':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '5':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '6':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '7':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '8':{ 
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
                }break;
            case '9':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '10':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '11':{
                ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP
            }break;
            case '12':{
                $C_TipoAnexo->Liquidacion($db);
            }break;
            case '13':{
                $C_TipoAnexo->Prorroga($db,$id);
            }break;
            case '14':{
                $C_TipoAnexo->Adicion($db);
            }break;
            case '15':{
                 ?>
                <tr>
                    <td>Anexo no disponible.</td>
                </tr>                
                <?PHP                
            }break;
            case '16':{
                $C_TipoAnexo->Modificar($db);           
            }break;
        }
    }break;
    case 'SaveData':
	{
	  // echo '<pre>';print_r($_POST);
        $tipoanexos = $_POST['tipoanexos'];
        switch($tipoanexos)
		{
            case '1':{//Anexo Tecnico
            
            
                $Modalidad                  = $_POST['Modalidad']; 
                $carrera                    = $_POST['carrera'];
                $NivelFormacion             = $_POST['NivelFormacion'];               
                $cupos                      = $_POST['cuposubicacion_'];
				$dato 						= $_FILES["dato"];
                $FechaCreacion              = date("Y-m-d H:i:s"); 
                $Consecutivo                = $_POST['Consecutivo'];
                $semetre                    = $_POST['semestre'];//array
               
                $Modalidad = limpiarCadena(filter_var($Modalidad,FILTER_SANITIZE_NUMBER_INT));
                $carrera = limpiarCadena(filter_var($carrera,FILTER_SANITIZE_NUMBER_INT));
                $NivelFormacion = limpiarCadena(filter_var($NivelFormacion,FILTER_SANITIZE_NUMBER_INT));
                $cupos = limpiarCadena(filter_var($cupos,FILTER_SANITIZE_NUMBER_INT));
                $Consecutivo = limpiarCadena(filter_var($Consecutivo,FILTER_SANITIZE_NUMBER_INT));
                    
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
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                                echo "</script>"; 
                				}
                		}    
                }

                $sql1="SELECT count(a.IdAnexoConvenio)
                        FROM
                        	AnexoConvenios a INNER JOIN CarreraAnexoConvenio c ON c.IdAnexoConvenio=a.IdAnexoConvenio 
                        WHERE
                        
                         a.idsiq_tipoanexo = '".$tipoanexos."'
                        AND a.ConvenioId = '".$idconvenio."'
                        AND a.codigoestado = 100
                        AND c.CodigoCarrera='".$carrera."'
                        AND c.CodigoEstado=100";
                
                if($Consulta=$db->Execute($sql1)===true)
                {
                    $mensaje = "Error de consulta en la base de datos.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>"; 
                }
				
                $datos = $db->GetAll($sql1);
                
                /*$datos =  $valores->GetArray();
                echo 'paso...2';die;*/
                if ($datos[0][0]==1){
                    
                    $mensaje = "El anexo que esta intentando ingresar ya se encuentra registrado.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>";
                      
                }else
                {
                    
                        $nombre_archivo= str_replace(" ", "",$nombre_archivo);
                        $resultado = move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                        if ($resultado == true)
                        {
                            $URL="Uploader/files/".$nombre_archivo;
                            $estado                     ='100';
                            $FechaCreacion              = date("Y-m-d H:i:s");
                            if(!empty($cupos))
                            {
                                foreach($cupos as $datos => $valor)
                                {
                                    $clave= $datos;
                                    $Totalcupos +=  $valor;
                                }    
                            }
                            
                            $sql2="insert into AnexoConvenios(idsiq_tipoanexo,  TotalCupos, codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ,Consecutivo) values ('".$tipoanexos."', '".$Totalcupos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."','".$Consecutivo."')";
                     
                            $agregar = $db->Execute($sql2);
                            $last_ID = $db->Insert_ID();
                            $campossemestre ="'";
                            foreach($semetre as $lista)
                            {
                                $campossemestre .=$lista."', '"; 
                                $sqlselect = "select SemestreAnexoConvenioId, CodigoEstado from SemestreAnexoConvenios where AnexoConvenioId ='".$last_ID."' and Semestre='".$lista."'";
                                $consultasemestre = $db->GetRow($sqlselect);
                                if($consultasemestre['SemestreAnexoConvenioId'])
                                {
                                    if($consultasemestre['CodigoEstado']=='200')
                                    {     
                                    $update ="update SemestreAnexoConvenios set CodigoEstado ='100' where (SemestreAnexoConvenioId = '".$semestresconsulta['SemestreAnexoConvenioId']."')";
                                    $updates = $db->execute($update);
                                    }//if
                                }else
                                { 
                                    $insertsemestre = "insert into SemestreAnexoConvenios (AnexoConvenioId, Semestre, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion, CodigoEstado) values('".$last_ID."', '".$lista."', '".$user."', '".$FechaCreacion."', '".$user."', '".$FechaCreacion."', '100' );";
                                    $insert = $db->execute($insertsemestre);
                                }//else
                            }
                            $campossemestre .= "'";
                            $sqlselectsemestres = "select SemestreAnexoConvenioId from SemestreAnexoConvenios where AnexoConvenioId ='".$last_ID."' and Semestre not in (".$campossemestre.")";
                            $listano = $db->GetAll($sqlselectsemestres);
                            foreach($listano as $no)
                            {
                               $update ="update SemestreAnexoConvenios set CodigoEstado ='200' where (SemestreAnexoConvenioId = '".$no['SemestreAnexoConvenioId']."')";
                               $updates = $db->execute($update); 
                            }
                            $InsertCarrera='INSERT INTO  CarreraAnexoConvenio(IdAnexoConvenio,CodigoCarrera,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$last_ID.'","'.$carrera.'","'.$user.'",NOW(),"'.$user.'",NOW())';
                    
                            $CarreraAnexoNew= $db->Execute($InsertCarrera);
                    
                    /**
 * $sqlAnexo = "select IdAnexoConvenio from AnexoConvenios where codigocarrera='".$carrera."' and idsiq_tipoanexo ='".$tipoanexo."' and codigomodalidadacademica= '".$Modalidad."' and idsiq_convenio = '".$idconvenio."'";
 * 					$valoresAnexo = $db->Execute($sqlAnexo);
 *                     if(!empty($valoresAnexo)){
 *                          foreach($valoresAnexo as $datosAnexo)
 *                          {
 *                             $IdAnexoConvenio = $datosAnexo['IdAnexoConvenio'];
 *                         }    
 *                     }else{
 *                         echo 'vacio';
 *                         echo $valoresAnexo;   
 *                     }
 */
                            if(!empty($cupos)){
                            foreach($cupos as $datoss => $valor)
                            {
                                $clave= $datoss;
                                $Totalcupos +=  $valor;
                                $SqlCupos = "insert into UbicacionInstitucionCupos(IdUbicacionInstitucion, IdAnexoConvenio, NumeroCupos, codigocarrera, codigoestado, UsuarioCreacion, FechaCreacion) values('".$clave."','".$last_ID."','".$valor."', '".$carrera."', '100', '".$user."', '".$FechaCreacion."')";
                            $agregar = $db->Execute($SqlCupos);
                            }    
                        }
                        //$mensaje = "El anexo fue agregado.";
                        echo "<script>";
                        echo "alert('El anexo fue agregado.');";  
                        echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                        echo "</script>";
                    }else
                    {
                        $mensaje = "El archivo PDF que esta intentando ingresar no se cargo correctamente.";
                        echo "<script>";
                        echo "alert('".$mensaje."');";  
                        echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                        echo "</script>";
                    
                     }
                   //}
                }
            }break;
        case '13': {//prorroga
        
           // echo '<pre>';print_r($db);die;
			$dato = $_FILES["dato"];
           
			if($dato== "")
            {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                                echo "</script>"; 
                				}
                		}    
                }

                
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $idconvenio      = $_POST['idconvenio'];
                    $idtipoconvenio  = $_POST['idtipoconvenio'];
                    $idinstitucion   = $_POST['idinstitucion'];
                    $tipoanexos      = $_POST['tipoanexos'];
                    $Consecutivo     = $_POST['Consecutivo'];
                    $FechaIni        = $_POST['FechaIni'];
                    $NumProrroga     = $_POST['NumProrroga'];
                    $Tiempo          = $_POST['Tiempo'];
                    $Modalidad       = $_POST['Modalidad'];
                    $Carrera         = $_POST['Carrera'];//array
                    $Observacion     = $_POST['Observacion'];
                    
                    
                    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idtipoconvenio = limpiarCadena(filter_var($idtipoconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idinstitucion = limpiarCadena(filter_var($idinstitucion,FILTER_SANITIZE_NUMBER_INT));
                    $tipoanexos = limpiarCadena(filter_var($tipoanexos,FILTER_SANITIZE_NUMBER_INT));
                    $Consecutivo = limpiarCadena(filter_var($Consecutivo,FILTER_SANITIZE_NUMBER_INT));
                    $NumProrroga = limpiarCadena(filter_var($NumProrroga,FILTER_SANITIZE_NUMBER_INT));
                    $Tiempo = limpiarCadena(filter_var($Tiempo,FILTER_SANITIZE_NUMBER_INT));
                    $Modalidad = limpiarCadena(filter_var($Modalidad,FILTER_SANITIZE_NUMBER_INT));                    
                    $Observacion = limpiarCadena(filter_var($Observacion,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
                    /*******************************************/
                    if($Tiempo==3){
                        $modo = 'year';
                      }else{
                        $modo = 'month';
                      }
                      
                      $fechaFutura = $C_TipoAnexo->calculaFecha($modo,$NumProrroga,$FechaIni);
                      
                      $C_Fecha = strtotime("-1 day",strtotime($fechaFutura));
                      
                      $Fecha = date("Y-m-d", $C_Fecha);
                      
                      $C_Fecha_2 = strtotime("-3 month",strtotime($fechaFutura));
          
                      $Fecha_2 = date("Y-m-d", $C_Fecha_2);
                    /*******************************************/
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                    
                    $SQL='SELECT
                            FechaFin
                          FROM
                            Convenios
                          WHERE
                            ConvenioId="'.$idconvenio.'"';
                            
                       if($FechaConvenio_OLD =&$db->Execute($SQL)===false){
                          echo 'Error en el SQL de la Fecha Anterior...<br>';
                          die;
                       }     
                    
					
					 $sql2="INSERT INTO AnexoConvenios(idsiq_tipoanexo,codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ,Consecutivo,FechaInicio,prorroga,idsiq_tipoValorPeriodicidad,FechaFinal,FechaFinalAnterior,Observacion) values ('".$tipoanexos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."','".$Consecutivo."','".$FechaIni."','".$NumProrroga."','".$Tiempo."','".$Fecha."','".$FechaConvenio_OLD->fields['FechaFin']."','".$Observacion."')";
                     
                    if($agregar =&$db->Execute($sql2)===false){
                        echo 'Error en el SQL del Insert Prorroga...<br><br>'.$sql2;
                        die;
                    }
                    
                    $last_ID = $db->Insert_ID();
                    
                    if($Modalidad==200 || $Modalidad==300){
                        for($i=0;$i<count($Carrera);$i++){
                            $InsertCarrera='INSERT INTO  CarreraAnexoConvenio(IdAnexoConvenio,CodigoCarrera,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$last_ID.'","'.$Carrera[$i].'","'.$user.'",NOW(),"'.$user.'",NOW())';
                    
                            if($CarreraAnexoNew=&$db->Execute($InsertCarrera)===false){
                                echo 'error en el Insetr Carrera Prorroga...<br><br>'.$InsertCarrera;
                                die;
                            }
                        }//for
                    }//if modalidad

			        $sqlfecha = "UPDATE Convenios SET FechaFin='".$Fecha."', idsiq_estadoconvenio=1, FechaClausulaTerminacion='".$Fecha_2."'  WHERE (ConvenioId='".$idconvenio."')";
                    
					if($updatefecha =&$db->Execute($sqlfecha)===false){
					   echo 'Error al Modificar la Fecha del Convenio....<br><br>'.$sqlfecha;
                       die;
					}
        
                    echo "<script>";
                    echo "alert('El anexo fue agregado.');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>";
         }break;
         case '12':{//Acta de Liquidacion
            $dato = $_FILES["dato"];
           
			if($dato== "")
            {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                                echo "</script>"; 
                				}
                		}    
                }

                
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $idconvenio      = $_POST['idconvenio'];
                    $idtipoconvenio  = $_POST['idtipoconvenio'];
                    $idinstitucion   = $_POST['idinstitucion'];
                    $tipoanexos      = $_POST['tipoanexos'];
                    $FechaFin        = $_POST['FechaFin'];
                   
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                    
                    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idtipoconvenio = limpiarCadena(filter_var($idtipoconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idinstitucion = limpiarCadena(filter_var($idinstitucion,FILTER_SANITIZE_NUMBER_INT));
                    $tipoanexos = limpiarCadena(filter_var($tipoanexos,FILTER_SANITIZE_NUMBER_INT));
                    
                   	
					 $sql2="INSERT INTO AnexoConvenios(idsiq_tipoanexo,   codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ,FechaFinal) values ('".$tipoanexos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."','".$FechaFin."')";
                     
                    $agregar = $db->Execute($sql2);
                    
                    $last_ID = $db->Insert_ID();
                    
                    
			        $sqlfecha = "UPDATE Convenios SET idsiq_estadoconvenio=4 WHERE (ConvenioId='".$idconvenio."')";
                    
					$updatefecha = $db->Execute($sqlfecha);
        
                    echo "<script>";
                    echo "alert('El anexo fue agregado.');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>";
             }break;
             case '14':{//adicion
            $dato = $_FILES["dato"];
           
			if($dato== "")
            {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                                echo "</script>"; 
                				}
                		}    
                }

                
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $idconvenio      = $_POST['idconvenio'];
                    $idtipoconvenio  = $_POST['idtipoconvenio'];
                    $idinstitucion   = $_POST['idinstitucion'];
                    $tipoanexos      = $_POST['tipoanexos'];
                    $Consecutivo     = $_POST['Consecutivo'];
                    $FechaIni        = $_POST['FechaIni'];
                    $Modalidad       = $_POST['Modalidad'];
                    $Carrera         = $_POST['Carrera'];//array
                    
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                    
                    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idtipoconvenio = limpiarCadena(filter_var($idtipoconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idinstitucion = limpiarCadena(filter_var($idinstitucion,FILTER_SANITIZE_NUMBER_INT));
                    $tipoanexos = limpiarCadena(filter_var($tipoanexos,FILTER_SANITIZE_NUMBER_INT));
                    $Consecutivo = limpiarCadena(filter_var($Consecutivo,FILTER_SANITIZE_NUMBER_INT));
                    $Modalidad = limpiarCadena(filter_var($Modalidad,FILTER_SANITIZE_NUMBER_INT));
					
					 $sql2="INSERT INTO AnexoConvenios(idsiq_tipoanexo,   codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ,Consecutivo,FechaInicio) values ('".$tipoanexos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."','".$Consecutivo."','".$FechaIni."')";
                     
                    $agregar = $db->Execute($sql2);
                    
                    $last_ID = $db->Insert_ID();
                    
                    if($Modalidad==200 || $Modalidad==300){
                        for($i=0;$i<count($Carrera);$i++){
                            $InsertCarrera='INSERT INTO  CarreraAnexoConvenio(IdAnexoConvenio,CodigoCarrera,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$last_ID.'","'.$Carrera[$i].'","'.$user.'",NOW(),"'.$user.'",NOW())';
                    
                            $CarreraAnexoNew= $db->Execute($InsertCarrera);
                        }//for
                    }//if modalidad

			        
        
                    echo "<script>";
                    echo "alert('El anexo fue agregado.');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>";
             }break;
             case '16':{//modificacion
            $dato = $_FILES["dato"];
           
			if($dato== "")
            {
                $mensaje = "No se puede subir el archivo.";
                echo "<script>";
                echo "alert('".$mensaje."');";  
                echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
                    echo "</script>"; 
            	}
              	if($tipo!='application/pdf')
                  {
                    $mensaje = "No es del Tipo de Documento permitido /n el formato del documento permitido es PDF.";
                    echo "<script>";
                    echo "alert('".$mensaje."');";  
                    echo "window.location = '../convenio/NuevoAnexoConvenio.php?idconvenio=".$idconvenio."';";
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
                                echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                                echo "</script>"; 
                				}
                		}    
                }

                
                    move_uploaded_file($_FILES["dato"]["tmp_name"],"Uploader/files/".$nombre_archivo);
                    $URL="Uploader/files/".$nombre_archivo;
                    
                    $idconvenio      = $_POST['idconvenio'];
                    $idtipoconvenio  = $_POST['idtipoconvenio'];
                    $idinstitucion   = $_POST['idinstitucion'];
                    $tipoanexos      = $_POST['tipoanexos'];
                    $Consecutivo     = $_POST['Consecutivo'];
                    $FechaIni        = $_POST['FechaIni'];
                    $Modalidad       = $_POST['Modalidad'];
                    $Carrera         = $_POST['carrera'];//array
                    
                    $estado                     ='100';
                    $FechaCreacion              = date("Y-m-d H:i:s");
                    
                    $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idtipoconvenio = limpiarCadena(filter_var($idtipoconvenio,FILTER_SANITIZE_NUMBER_INT));
                    $idinstitucion = limpiarCadena(filter_var($idinstitucion,FILTER_SANITIZE_NUMBER_INT));
                    $tipoanexos = limpiarCadena(filter_var($tipoanexos,FILTER_SANITIZE_NUMBER_INT));
                    $Consecutivo = limpiarCadena(filter_var($Consecutivo,FILTER_SANITIZE_NUMBER_INT));
                    $Modalidad = limpiarCadena(filter_var($Modalidad,FILTER_SANITIZE_NUMBER_INT));
                    
					
					$sql2="INSERT INTO AnexoConvenios(idsiq_tipoanexo,   codigoestado, RutaArchivo, UsuarioCreacion, FechaCreacion, ConvenioId ,Consecutivo,FechaInicio) values ('".$tipoanexos."', '".$estado."', '".$URL."', '".$user."','".$FechaCreacion."', '".$idconvenio."','".$Consecutivo."','".$FechaIni."')";
                     
                    $agregar = $db->Execute($sql2);
                    
                    $last_ID = $db->Insert_ID();
                    
                    if($Carrera){
                        $InsertCarrera='INSERT INTO  CarreraAnexoConvenio(IdAnexoConvenio,CodigoCarrera,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$last_ID.'","'.$Carrera.'","'.$user.'",NOW(),"'.$user.'",NOW())';
                
                        $CarreraAnexoNew= $db->Execute($InsertCarrera);
                    }    

                    echo "<script>";
                    echo "alert('El anexo fue agregado.');";  
                    echo "window.location = '../convenio/DetalleConvenio.php?Detalle=".$idconvenio."';";
                    echo "</script>";
            }break;
        }//swicths tipos
    }break;
    case 'Semestre':
    {
        $carerra = $_POST['Carrera'];
        
        $carerra = limpiarCadena(filter_var($carerra,FILTER_SANITIZE_NUMBER_INT));
        
        $sqldatos = "SELECT MAX(cantidadsemestresplanestudio) FROM planestudio WHERE codigocarrera = '".$carerra."'";
        $semestres = $db->GetAll($sqldatos);         
        $imp = "";
        for($i=1; $i<=$semestres[0][0];$i++)
        {          
            $imp.= "<input type='checkbox' id='semestre".$i."' name='semestre[]' value='".$i."'/>".$i;                    
        }
        echo $imp;
    }break;
}//  
?>