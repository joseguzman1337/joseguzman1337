<?PHP 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
#phpinfo();
$userid    = $_REQUEST['User_id'];



$tab      = $_REQUEST['numPestana'];
$idForm   = $_REQUEST['idFormulario'];
$Descripcion   = $_REQUEST['Descripcion'];
$Tipo_Carga    = $_REQUEST['Tipo_Carga'];
$Periodo       = $_REQUEST['Periodo'];
$url = 'Carga_Documento.html.php?actionID=Huerfana&idFormulario='.$idForm.'&tab='.$tab.'&periodo='.$Periodo;
if(isset($_REQUEST['codigocarrera'])){
    $carrera       = $_REQUEST['codigocarrera'];
    $url = $url.'&carrera='.$carrera;
} else {
    $carrera = null;
}

#echo '<br>$Factor_id-->'.$Factor_id.'<br>$caracteristica_id-->'.$caracteristica_id.'<br>$Aspecto_id-->'.$Aspecto_id.'<br>$Inicador_id-->'.$Inicador_id.'<br>$Descripcion-->'.$Descripcion.'<br>$Tipo_Carga-->'.$Tipo_Carga.'<br>periodo-->'.$Periodo.'<br>pregunta-->'.$Pregunta_id; die;
##########################################################

//VERIFICAMOS QUE SE SELECCIONO ALGUN ARCHIVO
  if(sizeof($_FILES)==0){
     echo "No se puede subir el archivo";
     exit();
  }
// EN ESTA VARIABLE ALMACENAMOS EL NOMBRE TEMPORAL QU SE LE ASIGNO ESTE NOMBRE ES GENERADO POR EL SERVIDOR
// ASI QUE SI NUESTRO ARCHIVO SE LLAMA foto.jpg el tmp_name no sera foto.jpg sino un nombre como SI12349712983.tmp por decir un ejemplo
$archivo = $_FILES["file"]["tmp_name"];
//Definimos un array para almacenar el tamaño del archivo
$tamanio=array();
//OBTENEMOS EL TAMAÑO DEL ARCHIVO
$tamanio = $_FILES["file"]["size"];
//OBTENEMOS EL TIPO MIME DEL ARCHIVO

$tipo = $_FILES["file"]["type"];

$Info = pathinfo($_FILES["file"]["name"]);
	//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
	

//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
if($tipo=='application/pdf' || $Info['extension']=='docx' || $tipo=='image/pjpeg' || 
        $tipo=='application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 
        $tipo=='application/vnd.ms-excel' || $tipo=='application/msexcel' || $tipo=='image/jpeg' || $tipo=='image/jpg' || 
        $tipo=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
    //todo bien
    /*$mimetype = array( 
        'doc'=>'application/msword', 
        'eps'=>'application/postscript', 
        'htm'=>'text/html', 
        'html'=>'text/html', 
        'gif'=>'image/gif', 
        'png'=>'image/png', 
        'ping'=>'image/ping', 
        'jpg'=>'image/jpeg', 
        'jpeg'=>'image/jpg', 
        'jpg'=>'image/pjpeg', 
        'jpe'=>'image/jpeg', 
        'pdf'=>'application/pdf', 
        'txt'=>'text/plain', 
        'ppt'=>"application/vnd.ms-powerpoint"
        'xls'=>'application/vnd.ms-excel' 
        'xlsx'=>application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
        'ppt2010'=>application/vnd.openxmlformats-officedocument.presentationml.presentation
        ); */
} else {
   // var_dump($tipo);
	#application/pdf -->PDF 
	#application/msword ---->word 
	#application/vnd.openxmlformats-officedocument.wordprocessingml.document --->2007 and 2010	?>
	<script>
		alert('No es del Tipo de Documento permitido. Los formatos permitidos son Word 2007 en adelante o .docx, PDF, Excel y JPG');
		location.href='<?php echo $url; ?>';
	</script>
	<?PHP
	die;
	}
$nombre_archivo = $_FILES["file"]["name"];
//PARA HACERNOS LA VIDA MAS FACIL EXTRAEMOS LOS DATOS DEL REQUEST
extract($_REQUEST);
//VERIFICAMOS DE NUEVO QUE SE SELECCIONO ALGUN ARCHIVO
if ( $archivo != "none" ){
	//ABRIMOS EL ARCHIVO EN MODO SOLO LECTURA
	// VERIFICAMOS EL TAÑANO DEL ARCHIVO
	$fp = fopen($archivo, "rb");
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
	$tamanio=filesize_format($tamanio);
   }else{
	   $tamanio=filesize_format($tamanio);
	   }
	   
	if($tamanio[1]=='MB'){
			if($tamanio[0]>10){
				?>
                <script>
                	alert('Supera el Tama\u00f1o permitido');
					location.href='<?php echo $url; ?>';
                </script>
                <?PHP
				}
		}    
}

include('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
include('../../Connections/salaado.php');



$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}

$userid=$Usario_id->fields['id'];

if($carrera===null){
    $SQL_Doc='SELECT idsiq_documento_infoHuerfana as id FROM siq_documento_infoHuerfana WHERE idFormulario="'.$idForm.'" AND numPestana="'.$tab.'" AND periodo="'.$Periodo.'" AND codigoestado=100 AND codigocarrera IS NULL';
} else {
    $SQL_Doc='SELECT idsiq_documento_infoHuerfana as id FROM siq_documento_infoHuerfana WHERE idFormulario="'.$idForm.'" AND numPestana="'.$tab.'" AND periodo="'.$Periodo.'" AND codigoestado=100 AND codigocarrera="'.$carrera.'"';
}
$doc=$db->GetRow($SQL_Doc);
if(count($doc)>0){
    $Documento_id = $doc["id"];
} else {
    if($carrera===null){
        $SQL_Carga='INSERT INTO siq_documento_infoHuerfana(idFormulario,numPestana,periodo,userid,entrydate)VALUES("'.$idForm.'","'.$tab.'","'.$Periodo.'","'.$userid.'",NOW())';
    } else {
        $SQL_Carga='INSERT INTO siq_documento_infoHuerfana(idFormulario,numPestana,periodo,codigocarrera,userid,entrydate)VALUES("'.$idForm.'","'.$tab.'","'.$Periodo.'","'.$carrera.'","'.$userid.'",NOW())';
    }
    if($Insert_Doc=&$db->Execute($SQL_Carga)===false){
            echo 'Error al Insertar El Documento....<br>'.$SQL_Carga;
            die;	
    }

    ##################################
    $Documento_id=$db->Insert_ID();
    ##################################
}
 

 
 $Info = pathinfo($_FILES["file"]["name"]);
 
 #echo '<pre>';print_r($Info);die;
 


$SQL_Doc_Carga='INSERT INTO siq_archivo_documento_infoHuerfana(siq_documento_id,descripcion,file_size,nombre_archivo,tamano_unida,fecha_carga,tipo_documento,userid,entrydate,tipo,extencion)VALUES("'.$Documento_id.'","'.$Descripcion.'","'.$tamanio[0].'","'.$nombre_archivo.'","'.$tamanio[1].'",NOW(),"'.$Tipo_Carga.'","'.$userid.'",NOW(),"'.$tipo.'","'.$Info['extension'].'")';


if($Inser_Detalle=&$db->Execute($SQL_Doc_Carga)===false){
	echo 'Error al Insertar El Documento....<br>'.$SQL_Doc_Carga;
	die;
}

##################################
$archivo_id=$db->Insert_ID();
##################################

move_uploaded_file($_FILES["file"]["tmp_name"],"documentos_infoHuerfana/".$archivo_id.'.'.$Info['extension']);
 
 $URL="documentos_infoHuerfana/".$archivo_id.'.'.$Info['extension'];  

$SQL_Update='UPDATE  siq_archivo_documento_infoHuerfana
			 SET  Ubicaicion_url="'.$URL.'"
			 WHERE  idsiq_archivo_documento_infoHuerfana="'.$archivo_id.'"';
			 
			 if($Update_Name=&$db->Execute($SQL_Update)===false){
				 	echo 'Error al Insertar El Documento....<br>'.$SQL_Update;
					die;
				 }

?>

<table border="0" width="40%" align="center">
	<tr>
    	<td colspan="2" align="left"><strong style="color:#6671A4">Se Ha Cargado el Documento con Éxito...</strong></td>
    </tr>
    <tr>
    	<td>Nombre:</td>
        <td><?PHP echo $nombre_archivo?></td>
    </tr>
    <tr>
    	<td>tama&ntilde;o:</td>
        <td><?PHP echo $tamanio[0].'&nbsp;'.$tamanio[1]?></td>
    </tr>
    <tr>
    	<td>Temp Archivo :</td>
        <td><?PHP echo $archivo?></td>
    </tr>
    <tr>
    	<td>Fecha de Almacenamiento</td>
        <?PHP 
		$hora = date('H');
		if($hora<12){
				$tipo_hora = 'a.m.';
				$H = $hora;
			}else{
					$tipo_hora ='p.m.';
					if($hora>12){
						
							$H = $hora-12;
						}
				}
				
		?>
        <td><?PHP echo date('Y-m-d').'&nbsp;Hora:'.date($H.':m:s').$tipo_hora?></td>
    </tr>
</table>
</body>
</head>
<?PHP 

function filesize_format($bytes, $format = '', $force = ''){
	#echo 'Entro..';
	$bytes=(float)$bytes;
		if ($bytes< 1024){
		$numero=number_format($bytes, 0, '.', ',');
        return array($numero,"B");
        }
	if ($bytes< 1048576){
		$numero=number_format($bytes/1024, 2, '.', ',');
		return array($numero,"KBs");
		}
	if ($bytes>= 1048576){
		$numero=number_format($bytes/1048576, 2, '.', ',');
		return array($numero,"MB");
	}
}


?>