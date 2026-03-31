<?php

session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */

$PlanTrabajo_id  = $_REQUEST['PlanTrabajo_id'];
$index           = $_REQUEST['index'];
$Docente_id      = $_REQUEST['Docente_id'];



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
					location.href='Carga_Documento.html.php';
                </script>
                <?PHP
				}
		}    
}
/*************************************************/
    include("templates/mainjson.php");
	
    global $db;  	
		
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

	if($Usario_id=&$db->Execute($SQL_User)===false){
			echo 'Error en el SQL Userid...<br>'.$SQL_User;
			die;
		}
	
	 $userid=$Usario_id->fields['id'];
     
     $SQL_Periodo='SELECT 

                   codigoperiodo

                   FROM 
                   
                   periodo 
                   
                   WHERE 
                   
                   codigoestadoperiodo=1';
                   
       if($Periodo=&$db->Execute($SQL_Periodo)===false){
            echo 'Error en el SQL ....<br><br>'.$SQL_Periodo;
            die;
       }   
       
      $CodigoPeriodo=$Periodo->fields['codigoperiodo'];          
/*
evidencia_index
plantrabajo_id
codigoperiodo
*/

      $SQL_Rebisar='SELECT 

                    id_documento,
                    evidencia_index,
                    plantrabajo_id,
                    codigoperiodo
                    
                    FROM 
                    
                    doc_evidenciaplantrabajo
                    
                    WHERE
                    
                    plantrabajo_id="'.$PlanTrabajo_id.'"  
                    AND
                    evidencia_index="'.$index.'"
                    AND
                    codigoperiodo="'.$CodigoPeriodo.'"
                    AND
                    codigoestado=100';
                    
             if($Rebisar=&$db->Execute($SQL_Rebisar)===false){
                echo 'Error en el SQl Rebisar...<br><br>'.$SQL_Rebisar;
                die;
             }       
    
    if($Rebisar->EOF){
        /************************************************************/
        $SQL_Insert='INSERT INTO doc_evidenciaplantrabajo(evidencia_index,plantrabajo_id,codigoperiodo,userid,entrydate,docente_id)VALUES("'.$index.'","'.$PlanTrabajo_id.'","'.$CodigoPeriodo.'","'.$userid.'",NOW(),"'.$Docente_id.'")';
        
       if($Insert_Doc=&$db->Execute($SQL_Insert)===false){
                echo 'Error en el SQL ...<br><br>'.$SQL_Insert;
                die;
           }
        /************************************************************/
        $Documento_id=$db->Insert_ID();
        /************************************************************/
    }else{
        $Documento_id=$Rebisar->fields['id_documento'];
    }

$Info = pathinfo($_FILES["file"]["name"]);


    
   $SQL_D_Insert='INSERT INTO archivos_evidenciaplantrabajo(doc_evidenciaplantrabajo_id,file_size,nombre_archivo,tamano_unida,tipo_documento,userid,entrydate,docente_id)VALUES("'.$Documento_id.'","'.$tamanio[0].'","'.$nombre_archivo.'","'.$tamanio[1].'","'.$Info['extension'].'","'.$userid.'",NOW(),"'.$Docente_id.'")';
   
   if($Insert_Archivo=&$db->Execute($SQL_D_Insert)===false){
        echo 'Error en el SQL ...<br><br>'.$SQL_D_Insert;
        die;
   }
    
    ##############################################
    $Archivo_id=$db->Insert_ID();    
    ##############################################
/*************************************************/

move_uploaded_file($_FILES["file"]["tmp_name"],"DocumentoEvidencia/".$Archivo_id.'.'.$Info['extension']);

$URL="DocumentoEvidencia/".$Archivo_id.'.'.$Info['extension'];  

/*************************************************/

   $SQL_UP='UPDATE archivos_evidenciaplantrabajo
             SET    Ubicaicion_url="'.$URL.'"
             WHERE  id_archivodocumento="'.$Archivo_id.'"';
             
       if($ULR_Up=&$db->Execute($SQL_UP)===false){
            echo 'Error en SQL Update...<br><br>'.$SQL_UP;
            die;
       }      
        
        
/**************************************************/
?>
<table border="0" aling="center">
    <thead>
        <tr>
            <th>Se ha Cargado Correctamente...</th>
        </tr>
        <tr>
            <th>Nombre Archivo:</th>
            <td><?PHP echo $nombre_archivo.'.'.$Info['extension']?></td>
        </tr>
    </thead>
</table>
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