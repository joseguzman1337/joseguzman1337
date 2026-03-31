<?php
class adjunto {
    var $error = 2;
    var $estatus;
    var $cantidadadjuntados;
    var $cantidadadjuntospermitidos=1;

    function adjuntarArchivoUnico($tabla) {
        global $idconvenio, $db;
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
                $destino = "adjuntos/$idconvenio.pdf";
                $ruta = "$idconvenio.pdf";
            }
            elseif(ereg("DOC|doc",$archivo)) {
                $destino = "adjuntos/$idconvenio.doc";
                $ruta = "$idconvenio.doc";
            }
            if((ereg("PDF|pdf",$archivo) || ereg("DOC|doc",$archivo)) && ($tamano < 2090000)) {
                if (copy($_FILES['archivo']['tmp_name'],$destino)) {
                    $this->estatus = "$nombrearchivoorigen";
                    // Modifica en la base de datos
                    if($tabla == "convenio") {
                        $query_actualizar = "UPDATE convenio
                        SET adjuntoconvenio='$ruta'
                        where idconvenio = '$idconvenio'";
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