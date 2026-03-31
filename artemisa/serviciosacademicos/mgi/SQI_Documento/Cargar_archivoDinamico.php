<?php
/*
 * @modified Andres Ariza <arizaancres@unbosque.edu.co>
 * Se unifica la declaracion del archivo de configuracion general para validacion de sesion
 * e instanciacion de conexion a base de datos
 * @since  Agosto 23 2018
*/
require_once(realpath(dirname(__FILE__)."/../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    require (PATH_ROOT.'/kint/Kint.class.php');
}

require_once (PATH_SITE.'/lib/Factory.php');
Factory::importGeneralLibraries();
$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        //d($key_post);
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}
Factory::validateSession($variables);

$db = Factory::createDbo();

require_once(PATH_ROOT.'/serviciosacademicos/mgi/API_Monitoreo.php');
$C_Api_Monitoreo = new API_Monitoreo();

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $sql = "select ig.idAspecto, a.idCaracteristica, c.idFactor from siq_indicador i 
		INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico 
		INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto
		INNER JOIN siq_caracteristica c on c.idsiq_caracteristica=a.idCaracteristica 
		WHERE i.idsiq_indicador='$id'";
    $row = $db->GetRow($sql);
    $Factor_id = $row["idFactor"];
    $caracteristica_id = $row["idCaracteristica"];
    $Aspecto_id = $row["idAspecto"];
    $Inicador_id = $id;
} else {
    $id;
}

$userid = $_REQUEST['User_id'];


if (isset($_REQUEST['Factor_id_' . $id])) {
    $Factor_id = $_REQUEST['Factor_id_' . $id];
    $caracteristica_id = $_REQUEST['caracteristica_id_' . $id];
    $Aspecto_id = $_REQUEST['Aspecto_id_' . $id];
    $Inicador_id = $_REQUEST['Inicador_id_' . $id];
}

$Descripcion = $_REQUEST['Descripcion_' . $id];
$Tipo_Carga = $_REQUEST['Tipo_Carga_' . $id];
$Periodo = $_REQUEST['Periodo_' . $id];
$id_DocumentoEstrucutra = $_REQUEST['id_DocumentoEstrucutra_' . $id];


#echo '<br>$Factor_id-->'.$Factor_id.'<br>$caracteristica_id-->'.$caracteristica_id.'<br>$Aspecto_id-->'.$Aspecto_id.'<br>$Inicador_id-->'.$Inicador_id.'<br>$Descripcion-->'.$Descripcion.'<br>$Tipo_Carga-->'.$Tipo_Carga;die;
##########################################################
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
//OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
if ($Tipo_Carga == 1 || $Tipo_Carga == '1' || $Tipo_Carga == 2 || $Tipo_Carga == '2') {
    $Info = pathinfo($_FILES["file"]["name"]);
    //OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
    if ($Info['extension'] != 'docx' && $tipo != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' && $Info['extension'] != 'pdf') {
        #application/pdf -->PDF 
        #application/msword ---->word 
        #application/vnd.openxmlformats-officedocument.wordprocessingml.document --->2007 and 2010
        ?>
        <script>
            alert('No es del Tipo de Documento permitido /n el formato del documento permitido es Word 2007 en adelante o .docx');
            location.href = 'Carga_Documento.html.php';
        </script>
        <?php
        die;
    }
}

if ($Tipo_Carga == 3 || $Tipo_Carga == '3') {

    //OBTENEMOS EL NOMBRE REAL DEL ARCHIVO AQUI SI SERIA foto.jpg
    if ($tipo != 'application/pdf') {
        #application/pdf -->PDF 
        #application/msword ---->word 
        #application/vnd.openxmlformats-officedocument.wordprocessingml.document --->2007 and 2010
        ?>
        <script>
            alert('No es del Tipo de Documento permitido /n el formato del documento permitido es PDF');
            location.href = 'Carga_Documento.html.php';
        </script>
        <?php
        die;
    }
}

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
                location.href = '../tablero_siq/Creacion_Docuemto/Alimentar_Documento.html.php?actionID=Ver&opcion=1&id=' +<?php echo $id_DocumentoEstrucutra ?>;
            </script>
            <?php
        }
    }
}

$SQL_User = 'SELECT idusuario as id FROM usuario WHERE usuario="' . $_SESSION['MM_Username'] . '"';

if ($Usario_id = &$db->Execute($SQL_User) === false) {
    echo 'Error en el SQL Userid...<br>';
    die;
}

$userid = $Usario_id->fields['id'];

$SQL_Carga = 'INSERT INTO siq_documento'
        . ' SET '
        . ' siqfactor_id = "' . $Factor_id . '" , '
        . ' siqcaracteristica_id = "' . $caracteristica_id . '", '
        . ' siqaspecto_id = "' . $Aspecto_id . '", '
        . ' siqindicador_id = "' . $Inicador_id . '", '
        . ' fecha_ingreso = NOW(), '
        . ' userid = "' . $userid . '", '
        . ' entrydate = NOW(), '
        . ' periodo = "' . $Periodo . '", '
        . ' idsiq_estructuradocumento = "' . $id_DocumentoEstrucutra . '" ';

if ($Insert_Doc = &$db->Execute($SQL_Carga) === false) {
    echo 'Error al Insertar El Documento....<br>' . $SQL_Carga;
    die;
}

##################################
$Documento_id = $db->Insert_ID();
##################################




$Info = pathinfo($_FILES["file"]["name"]);

#echo '<pre>';print_r($Info);die;



if ($Tipo_Carga != 3 || $Tipo_Carga != '3') {

    $SQL_Doc_Carga = 'INSERT INTO siq_archivo_documento(siq_documento_id,descripcion,file_size,nombre_archivo,tamano_unida,fecha_carga,tipo_documento,userid,entrydate,tipo,extencion)VALUES("' . $Documento_id . '","' . $Descripcion . '","' . $tamanio[0] . '","' . $nombre_archivo . '","' . $tamanio[1] . '",NOW(),"' . $Tipo_Carga . '","' . $userid . '",NOW(),"' . $tipo . '","' . $Info['extension'] . '")';
} else {

    $SQL_Doc_Carga = 'INSERT INTO siq_archivo_documento(siq_documento_id,descripcion,file_size,nombre_archivo,tamano_unida,fecha_carga,tipo_documento,userid,entrydate,tipo,extencion)VALUES("' . $Documento_id . '","' . $Descripcion . '","' . $tamanio[0] . '","' . $nombre_archivo . '","' . $tamanio[1] . '",NOW(),"' . $Tipo_Carga . '","' . $userid . '",NOW(),"' . $tipo . '","' . $Info['extension'] . '")';
}


if ($Inser_Detalle = &$db->Execute($SQL_Doc_Carga) === false) {
    echo 'Error al Insertar El Documento....<br>' . $SQL_Doc_Carga;
    die;
}

##################################
$archivo_id = $db->Insert_ID();
##################################
move_uploaded_file($_FILES["file"]["tmp_name"], PATH_ROOT."/serviciosacademicos/mgi/SQI_Documento/Documento_upload/" . $archivo_id . '.' . $Info['extension']);
if (is_file(PATH_ROOT."/serviciosacademicos/mgi/SQI_Documento/Documento_upload/" . $archivo_id . '.' . $Info['extension'])) {

    $URL = "/Documento_upload/" . $archivo_id . '.' . $Info['extension'];

    $SQL_Update = 'UPDATE  siq_archivo_documento
				 SET  Ubicaicion_url="' . $URL . '"
				 WHERE  idsiq_archivodocumento="' . $archivo_id . '"';

    if ($Update_Name = &$db->Execute($SQL_Update) === false) {
        echo 'Error al Insertar El Documento....<br>' . $SQL_Update;
        die;
    }

    $C_Api_Monitoreo->actualizarEstadoIndicador($Inicador_id, '2'); #indicador id y estado id 2 = en proceso.
} else {
    $SQL_Update = 'UPDATE  siq_archivo_documento
				 SET  codigoestado="200" 
				 WHERE  idsiq_archivodocumento="' . $archivo_id . '"';
    $db->Execute($SQL_Update);

    echo 'Error al cargar el documento al servidor. Por favor comuniquese con tecnología.<br>';
    die;
}
?>

<style>
    .Boton{
        padding: 9px 17px;
        font-family: Helvetica, Arial, sans-serif;
        font-weight: bold;
        line-height: 1;
        color: #444;
        border: none;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
        background-image: -webkit-gradient( linear, 0% 0%, 0% 100%, from(#fff), to(#bbb));
        background-image: -moz-linear-gradient(0% 100% 90deg, #BBBBBB, #FFFFFF);
        background-color: #fff;
        border: 1px solid #f1f1f1;
        border-radius: 10px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5)
    }
</style>
<script>
    function Retro(id) {

        location.href = '../tablero_siq/Creacion_Docuemto/Alimentar_Documento.html.php?actionID=Ver&opcion=1&id=' + id;

    }
</script>
<table border="0" width="40%" align="center">
    <tr>
        <td colspan="2" align="left"><strong style="color:#6671A4">Se Ha Cargado el Documento con Exito...</strong></td>
    </tr>
    <tr>
        <td>Nombre:</td>
        <td><?php echo $nombre_archivo ?></td>
    </tr>
    <tr>
        <td>tama&ntilde;o:</td>
        <td><?php echo $tamanio[0] . '&nbsp;' . $tamanio[1] ?></td>
    </tr>
    <tr>
        <td>Temp Archivo :</td>
        <td><?php echo $archivo ?></td>
    </tr>
    <tr>
        <td>Fecha de Almacenamiento</td>
<?php
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
        <td><?php echo date('Y-m-d') . '&nbsp;Hora:' . date($H . ':m:s') . $tipo_hora ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

</table>
</body>
</head>
<?php
/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agregan las siguientes variables de session para controlar cuando se debe recargar
 * el listado de indicadores dependiendo si se a agregado un nuevo archivo
 * @since octubre 9, 2018
 */
Factory::setSessionVar("reloadIndicadores", 1);
function filesize_format($bytes, $format = '', $force = '') {
    #echo 'Entro..';
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
