<?php
echo dirname( __FILE__ );
 $uploaddir = "uploads/";
 mkdir('../../../../../serviciosacademicos/convenio/jQueryFileUpload/server/php/prueba');
print_r($_FILES);
echo $tamano = $_FILES["archivo"]['size'];
echo $tipo = $_FILES["archivo"]['type'];
echo $archivo = $_FILES["archivo"]['name'];
echo $prefijo = substr(md5(uniqid(rand())),0,6);

if ($archivo != "") {
        // guardamos el archivo a la carpeta files
        print_r($_FILES['archivo']['tmp_name']);
        $destino =  "/usr/local/apache2/htdocs/html/serviciosacademicos/convenio/jQueryFileUpload/server/files/".$prefijo."_".$archivo;
        //$destino =  "/tmp/".$prefijo."_".$archivo;
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
            $status = "Archivo subido: <b>".$archivo."</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
        $status = "Error al subir archivo";
    }
echo $status;
exit(); 
 
 $uploadfilename = strtolower(str_replace(" ", "_",basename($_FILES['archivo']['name'])));
 $uploadfile = $uploaddir.$uploadfilename;
 $error = $_FILES['archivo']['error'];
 $subido = false;
 if(isset($_POST['boton']) && $error==UPLOAD_ERR_OK) {
    if($_FILES['archivo']['type']!="image/gif" || $_FILES['archivo']['size'] > 100000) {
      $error = "Comprueba que el archivo sea una imagen en formato gif y de tamano inferior a 10Kb.";
    } elseif(preg_match("/[^0-9a-zA-Z_.-]/",$uploadfilename)) {
      $error = "El nombre del archivo contiene caracteres no v�lidos.";
    } else {
        echo $uploadfile;
        $subido = copy($_FILES['archivo']['tmp_name'], $uploadfile); 
    }
 } 
 if($subido) {
    echo "El archivo subio con exito";
   } else {
    echo "Se ha producido un error: ".$error;
  }
?>
