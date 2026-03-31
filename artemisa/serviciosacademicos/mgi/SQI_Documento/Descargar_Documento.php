<?PHP 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
include('../../Connections/salaado.php');

$id   = $_REQUEST['Documento_id'];

        $SQL_Archivos='SELECT  

						idsiq_archivodocumento as id,
						nombre_archivo,
						file_size,
						tamano_unida,
						tipo_documento,
						fecha_carga,
						descripcion,
						tipo,
						Ubicaicion_url
						
						FROM 
						
						siq_archivo_documento
						
						WHERE
						
						idsiq_archivodocumento="'.$id.'"
						AND
						codigoestado=100';
						
					if($Result_Archivos=&$db->Execute($SQL_Archivos)===false){
							echo 'Error en el SQl de los Archivos...<br>'.$SQL_Archivos;
							die;
						}	
						
header("Content-type: application/force-download");						
//OBTENEMOS EL TIPO MIME DEL ARCHIVO ASI EL NAVEGADOR SABRA DE QUE SE TRATA
header('Content-type:"'.$Result_Archivos->fields['tipo'].'"');

//OBTENEMOS EL NOMBRE DEL ARCHIVO POR SI LO QUE SE REQUIERE ES DESCARGARLO
header('Content-Disposition: attachment;filename="'.$Result_Archivos->fields['nombre_archivo'].'"');
//Y PO ULTIMO SIMPLEMENTE IMPRIMIMOS EL CONTENIDO DEL ARCHIVO
#print $Result_Archivos->fields['contiene'];	
?>
<a href="<?PHP echo $Result_Archivos->fields['Ubicaicion_url']?>"><?PHP echo $Result_Archivos->fields['Ubicaicion_url']?></a>   
<?PHP
#echo $Result_Archivos->fields['contiene'];		


?>