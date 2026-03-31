<?php
class adjunto_novedad {
    var $error = 2;
    var $estatus;
    var $cantidadadjuntados;
    var $cantidadadjuntospermitidos=1;

    function adjuntarArchivoUnico($tabla) {
        global $idnovedadesconvenio, $db;
        //print_r($_FILES);
        $this->error = 0;
        $tamano = $_FILES["archivo"]['size'];
        $tipo = $_FILES["archivo"]['type'];
        $archivo = $_FILES["archivo"]['name'];
        $nombrearchivoorigen = $archivo;
        $prefijo = substr(md5(uniqid(rand())),0,6);
        $nombrearchivonuevo = $prefijo."_".$archivo;
        if($archivo != "") {
            if(ereg("PDF|pdf",$archivo)) {
                $destino = "adjuntos_novedades/$idnovedadesconvenio.pdf";
                $ruta = "$idnovedadesconvenio.pdf";
            }
            elseif(ereg("DOC|doc",$archivo)) {
                $destino = "adjuntos_novedades/$idnovedadesconvenio.doc";
                $ruta = "$idnovedadesconvenio.doc";
            }
            if((ereg("PDF|pdf",$archivo) || ereg("DOC|doc",$archivo)) && ($tamano < 2090000)) {
                if (copy($_FILES['archivo']['tmp_name'],$destino)) {
                    $this->estatus = "$nombrearchivoorigen";
                    // Modifica en la base de datos
                    if($tabla == "novedadesconvenio") {
                        $query_actualizar = "UPDATE novedadesconvenio
                        SET adjuntonovedadesconvenio='$ruta'
                        where idnovedadesconvenio = '$idnovedadesconvenio'";
                        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                        //exit();
                    }
                }
                else
                {
                    $this->estatus = "ERROR: No se pudo subir el archivo, el tamaño del archivo no puede ser mayor de 2Mb ";
                    $this->error = 1;
                }
            }
            else
            {
                $this->estatus = "ERROR: No se pudo subir archivo, revisar que la extensión del archivo sea jpg, png, gif o que el tamaño del archivo no sea mayor de 2Mb";
                $this->error = 1;
            }
        }
        else
        {
            $this->status = "Error al subir archivo";
            $this->error = 1;
        }
    }
}
?>