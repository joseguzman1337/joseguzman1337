<?php

// Clase que carga un fichero txt

class CargarArchivo {

    var $nombrearchivo;
    var $nombrearchivonuevo;
    var $tipo;
    var $nombretemporal;
    var $error;
    var $tamano;
    var $tipospermitidos = array();
    var $filtroxtamano = 1000000;
    var $mensaje;

    function formularioPrincipal() {
?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="archivo">
            <input type="submit" name="enviar" value="enviar">
        </form>
<?php
    }

    function formularioPrincipalConFecha() {
?>
        <form action="" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><b>Digite una fecha</b></td>
                    <td><input type="text" name="fecha"><b> aaaa-mm-dd</b></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Seleccione el archivo:</p>
                        <input type="file" name="archivo">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="enviar" value="enviar">
                    </td>
                </tr>
            </table>
        </form>
<?php
    }

    /**
     * Recibe: string $nombrearchivo (Nombre del archivo que va a poner cuando se cargue)
     *         array $filtroxtipo (Filtra por los tipos de archivos, ver http://www.w3schools.com/media/media_mimeref.asp MIME Types. ejm: text/plain - image/gif - image/jpeg)
     *
     * */
    function recibirArchivo() {
        /* echo "<pre>ACA";
          print_r($_FILES);
          echo "</pre>"; */
        if (!is_array($_FILES))
            $_FILES = $HTTP_POST_FILES;
        foreach ($_FILES as $archivo) {
            $this->nombrearchivo = $archivo['name'];
            $this->tipo = $archivo['type'];
            $this->nombretemporal = $archivo['tmp_name'];
            $this->error = $archivo['error'];
            $this->tamano = $archivo['size'];
        }
        if (is_uploaded_file($this->nombretemporal)) {
            if ($this->tamano > $this->filtroxtamano) {
                $this->mensaje = "El archivo es demasiado grande";
                unlink($this->nombretemporal);
            } elseif (in_array($this->tipo, $this->tipospermitidos)) {
                if (!move_uploaded_file($this->nombretemporal, "$this->nombrearchivonuevo")) {
                    $this->mensaje = "El archivo no pudo ser subido";
                } else {
                    $this->mensaje = "El archivo fue subido satisfactoriamente";
                }
            } else {
                $this->mensaje = "El archivo no es del tipo especificado";
                unlink($this->nombretemporal);
            }
        }
    }

}

/* $carga = new CargarArchivo();
  if (isset($_REQUEST['enviar'])) {
  $carga->nombrearchivonuevo = '/tmp/dispersion.txt';
  $carga->tipospermitidos[] = 'text/plain';
  $carga->recibirArchivo();
  }
  else
  $carga->formularioPrincipal(); */
?>
