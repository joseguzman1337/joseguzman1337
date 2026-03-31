<?PHP
session_start();
include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

##############################################
$userid = $_REQUEST['User_id'];
$id_Documento = $_REQUEST['id_Documento'];
$id_factor = $_REQUEST['id_factor'];
$id_Caract = $_REQUEST['id_Caract'];
$id_aspecto = $_REQUEST['id_aspecto'];
$id_indicador = $_REQUEST['id_indicador'];
$Tipo_Carga = $_REQUEST['Tipo_Carga'];
$Observ = $_REQUEST['Observ'];
$estado = $_REQUEST['estado'];
$Descripcion = $_REQUEST['Descripcion'];
$estato_actual = $_REQUEST['estato_actual'];

if ($estado == '0' || $estado == '1' || $estado == '2') {

    $Estado_final = $estado;
} else {

    $Estado_final = $estato_actual;
}


#echo '<br>id_Documento-->'.$id_Documento.'<br>id_factor-->'.$id_factor.'<br>id_Caract-->'.$id_Caract.'<br>id_aspecto-->'.$id_aspecto.'<br>id_indicador-->'.$id_indicador.'<br>Tipo_Carga-->'.$Tipo_Carga.'<br>Observ-->'.$Observ.'<br>estado-->'.$estado.'<br>Descripcion-->'.$Descripcion.'<br>$estato_actual->'.$estato_actual;
//VERIFICAMOS QUE SE SELECCIONO ALGUN ARCHIVO
if (sizeof($_FILES) == 0) {
    echo "No se puede subir el archivo";
    exit();
}
// EN ESTA VARIABLE ALMACENAMOS EL NOMBRE TEMPORAL QU SE LE ASIGNO ESTE NOMBRE ES GENERADO POR EL SERVIDOR
// ASI QUE SI NUESTRO ARCHIVO SE LLAMA foto.jpg el tmp_name no sera foto.jpg sino un nombre como SI12349712983.tmp por decir un ejemplo
$archivo = $_FILES["file"]["tmp_name"];
//Definimos un array para almacenar el tamaño del archivo
$tamanio = array();
//OBTENEMOS EL TAMAÑO DEL ARCHIVO
$tamanio = $_FILES["file"]["size"];
//OBTENEMOS EL TIPO MIME DEL ARCHIVO
$tipo = $_FILES["file"]["type"];

if ($Tipo_Carga == 1 || $Tipo_Carga == '1' || $Tipo_Carga == 2 || $Tipo_Carga == '2') {
    $Info = pathinfo($_FILES["file"]["name"]);
    //OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
    //echo "1"; print_r($Info);die;
    if ($Info['extension'] != 'docx' && $tipo != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' && $Info['extension'] != 'pdf') {
        #application/pdf -->PDF 
        #application/msword ---->word application/vnd.openxmlformats-officedocument.wordprocessingml.document
        #application/vnd.openxmlformats-officedocument.wordprocessingml.document --->2007 and 2010
        ?>
        <script>
            alert('No es del Tipo de Documento permitido \n el formato del documento permitido es Word 2007 en adelante o .docx');
            location.href = 'Carga_Documento.html.php';
        </script>
        <?PHP
        die;
    }
}

if ($Tipo_Carga == 3 || $Tipo_Carga == '3') {
    //echo "2 <br/><pre>";  print_r($_FILES); die;
    //OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
    if ($tipo != 'application/pdf') {
        #application/pdf -->PDF 
        #application/msword ---->word 
        #application/vnd.openxmlformats-officedocument.wordprocessingml.document --->2007 and 2010
        ?>
        <script>
            alert('No es del Tipo de Documento permitido \n el formato del documento permitido es PDF');
            location.href = 'Carga_Documento.html.php';
        </script>
        <?PHP
        die;
    }
}

//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
$nombre_archivo = $_FILES["file"]["name"];
//PARA HACERNOS LA VIDA MAS FACIL EXTRAEMOS LOS DATOS DEL REQUEST
extract($_REQUEST);
//VERIFICAMOS DE NUEVO QUE SE SELECCIONO ALGUN ARCHIVO
if ($archivo != "none") {
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
    if ($tamanio > 1048576) {
        //HACEMOS LA CONVERSION PARA PODER GUARDAR SI EL TAMAÑO ESTA EN b ó MB
        $tamanio = filesize_format($tamanio);
    } else {
        $tamanio = filesize_format($tamanio);
    }

    if ($tamanio[1] == 'MB') {
        if ($tamanio[0] > 10) {
            ?>
            <script>
                alert('Supera el Tama\u00f1o permitido');
                location.href = 'Documento_Ver.html.php?Docuemto_id=' +<?PHP echo $id_Documento ?>;
            </script>
            <?PHP
        }
    }
}

include('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
include('../../Connections/salaado.php');

include ('../API_Monitoreo.php');
$C_Api_Monitoreo = new API_Monitoreo();

$SQL_UpdateDoc = 'UPDATE siq_documento
					SET    estado="' . $Estado_final . '", userid_estado="' . $userid . '", changedate=NOW()
					WHERE  idsiq_documento="' . $id_Documento . '"  AND  codigoestado=100';

if ($Update_Documento = &$db->Execute($SQL_UpdateDoc) === false) {
    echo 'Error en el SQL ....<br>' . $SQL_UpdateDoc;
    die;
}


$Info = pathinfo($_FILES["file"]["name"]);

if ($Tipo_Carga != 3 || $Tipo_Carga != '3') {

    $SQL_Doc_Carga = 'INSERT INTO siq_archivo_documento(siq_documento_id,descripcion,file_size,nombre_archivo,tamano_unida,fecha_carga,tipo_documento,userid,entrydate,tipo,extencion)VALUES("' . $id_Documento . '","' . $Descripcion . '","' . $tamanio[0] . '","' . $nombre_archivo . '","' . $tamanio[1] . '",NOW(),"' . $Tipo_Carga . '","' . $userid . '",NOW(),"' . $tipo . '","' . $Info['extension'] . '")';
} else {

    $SQL_Doc_Carga = 'INSERT INTO siq_archivo_documento(siq_documento_id,descripcion,file_size,nombre_archivo,tamano_unida,fecha_carga,tipo_documento,userid,entrydate,tipo,extencion)VALUES("' . $id_Documento . '","' . $Descripcion . '","' . $tamanio[0] . '","' . $nombre_archivo . '","' . $tamanio[1] . '",NOW(),"' . $Tipo_Carga . '","' . $userid . '",NOW(),"' . $tipo . '","' . $Info['extension'] . '")';
}

if ($Inser_New = &$db->Execute($SQL_Doc_Carga) === false) {
    echo 'Error en el SQl 2....<br>' . $SQL_Doc_Carga;
    die;
}

$archivo_id = $db->Insert_ID();

if(!is_dir("Documento_upload")){
    mkdir("Documento_upload",0775);
}

move_uploaded_file($_FILES["file"]["tmp_name"], "Documento_upload/" . $archivo_id . '.' . $Info['extension']);

if (is_file("Documento_upload/" . $archivo_id . '.' . $Info['extension'])) {
    
    $URL = "Documento_upload/" . $archivo_id . '.' . $Info['extension'];

    $SQL_Update = 'UPDATE  siq_archivo_documento
			 SET     Ubicaicion_url="' . $URL . '"
			 WHERE   idsiq_archivodocumento="' . $archivo_id . '"';

    if ($Update_Name = &$db->Execute($SQL_Update) === false) {
        echo 'Error al Insertar El Documento....<br>' . $SQL_Update;
        die;
    }

    $Update = 'UPDATE siq_indicador
            SET    idEstado=2,
                   fecha_modificacion=NOW(),
                   usuario_modificacion="' . $userid . '"
                   
            WHERE
                  idsiq_indicador="' . $id_indicador . '"';

    if ($ModEstado = &$db->Execute($Update) === false) {
        echo 'Error en el SQl de Modificacion del estado .....<br>' . $Update;
        die;
    }
}else {
    $SQL_Update = 'UPDATE  siq_archivo_documento
				 SET  codigoestado="200" 
				 WHERE  idsiq_archivodocumento="' . $archivo_id . '"';
    $db->Execute($SQL_Update);

    echo 'Error al cargar el documento al servidor. Por favor comuniquese con tecnología.<br>';
    die;
}
/* switch($Estado_final){
  case '0':{
  $resultado=$C_Api_Monitoreo->enviarIndicadorARevision($id_indicador);
  }break;
  case '1':{
  $resultado=$C_Api_Monitoreo->registrarRevisionCalidadIndicador($id_indicador,0,$Observ);
  }break;
  case '2':{
  $resultado=$C_Api_Monitoreo->registrarRevisionCalidadIndicador($id_indicador,1,$Observ);
  }break;
  default:{
  echo
  $resultado=$C_Api_Monitoreo->actualizarEstadoIndicador($id_indicador,'2');//indicador id y estado id 2 = en proceso.
  }break;
  } */

#echo '<pre>';print_r($resultado);					
/* if($Estado_final==0){
  echo '<br>aa';
  $C_Api_Monitoreo->enviarIndicadorARevision($id_indicador);
  }else
  if($Estado_final==1){
  echo '<br>bb';
  $R=$C_Api_Monitoreo->registrarRevisionCalidadIndicador($id_indicador,0,0,$Observ);

  }
  if($Estado_final==2){
  echo '<br>cc';
  $C_Api_Monitoreo->registrarRevisionCalidadIndicador($id_indicador,0,1,$Observ);
  }
  if($Estado_final!=0 || $Estado_final!=1 || $Estado_final!=2){
  echo '<br>zzz';
  $C_Api_Monitoreo->actualizarEstadoIndicador($id_indicador,'2');#indicador id y estado id 2 = en proceso.
  } */

##############################################
?>

<table border="0" width="40%" align="center">
    <tr>
        <td colspan="2" align="left"><strong style="color:#6671A4">Se Ha Cargado el Documento con Exito...</strong></td>
    </tr>
    <tr>
        <td>Nombre:</td>
        <td><?PHP echo $nombre_archivo ?></td>
    </tr>
    <tr>
        <td>tama&ntilde;o:</td>
        <td><?PHP echo $tamanio[0] . '&nbsp;' . $tamanio[1] ?></td>
    </tr>
    <tr>
        <td>Temp Archivo :</td>
        <td><?PHP echo $archivo ?></td>
    </tr>
    <tr>
        <td>Fecha de Almacenamiento</td>
<?PHP
$hora = date('H');
if ($hora < 12) {
    $tipo_hora = 'a.m.';
    $H = $hora;
} else {
    $tipo_hora = 'p.m.';
    if ($hora > 12) {

        $H = $hora - 12;
    }
}
?>
        <td><?PHP echo date('Y-m-d') . '&nbsp;Hora:' . date($H . ':m:s') . $tipo_hora ?></td>
    </tr>
</table>
</body>
</head>
<?PHP
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan las siguientes variables de session para controlar cuando se debe recargar
 * el listado de indicadores dependiendo si se a agregado un nuevo archivo
 * @since octubre 9, 2018
 */
$_SESSION["reloadIndicadores"]=1;
function filesize_format($bytes, $format = '', $force = '') {
    $bytes = (float) $bytes;
    if ($bytes < 1024) {
        $numero = number_format($bytes, 0, '.', ',');
        return array($numero, "B");
    }
    if ($bytes < 1048576) {
        $numero = number_format($bytes / 1024, 2, '.', ',');
        return array($numero, "KBs");
    }
    if ($bytes >= 1048576) {
        $numero = number_format($bytes / 1048576, 2, '.', ',');
        return array($numero, "MB");
    }
}
?>