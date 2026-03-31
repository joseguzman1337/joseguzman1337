<?php

class ObtenerDatosMail {

    var $conexion;
    var $codigocarrera;
    var $idproceso;
    var $fechahoy;
    var $depurar;
    var $correo_destinatario;
    var $nombre_destinatario;
    var $array_datos_correspondencia;
    var $array_detalle_correspondencia;
    var $array_seguimiento;

    function ObtenerDatosMail($conexion, $codigocarrera, $idproceso, $depurar=false) {
        $this->conexion = $conexion;
        $this->correo_destinatario = $correo_destinatario;
        $this->nombre_destinatario = $nombre_destinatario;
        $this->fechahoy = date("Y-m-d H:i:s");
        $this->codigocarrera = $codigocarrera;
        $this->idproceso = $idproceso;
        $this->depurar = $depurar;
        if ($depurar == true) {
            $this->conexion->debug = true;
        }
        $this->array_datos_correspondencia = $this->Obtener_datos_correspondencia();
        if (is_array($this->array_datos_correspondencia)) {
            if (is_array($this->array_datos_correspondencia)) {
                $this->array_detalle_correspondencia = $this->Obtener_detalle_correspondencia($this->array_datos_correspondencia);
                $this->Obtener_seguimiento($this->array_datos_correspondencia);
            }
        }
    }

    function Obtener_datos_correspondencia() {
        $i = 0;
        foreach ($this->codigocarrera as $llave => $valor) {
            if ($i == 0)
                $valores.="" . $valor;
            else
                $valores.="," . $valor;
            $i++;
        }

        $query = "SELECT * from correspondencia c
		WHERE
		c.idproceso='$this->idproceso'
		AND '$this->fechahoy' >= c.fechadesdecorrespondencia
		AND '$this->fechahoy' <= c.fechahastacorrespondencia
		AND c.codigocarrera in (" . $valores . ")
		";
        $operacion = $this->conexion->query($query);
        //$row_operacion=$operacion->fetchRow();
        while ($row_operacion = $operacion->fetchRow()) {
            $arraycarreras[] = $row_operacion;
        }

        if ($this->depurar == true) {
            echo "<pre>";
            print_r($arraycarreras);
            echo "</pre>";
        }
        return $arraycarreras;
    }

    function Obtener_detalle_correspondencia($correspondencia) {
        $i = 0;
        foreach ($correspondencia as $llave => $valor) {
            if ($i == 0)
                $valores.="" . $valor['idcorrespondencia'];
            else
                $valores.="," . $valor['idcorrespondencia'];
            $i++;
        }

        $query = "
		SELECT dc.* FROM detallecorrespondencia dc, correspondencia c
		WHERE
		c.idcorrespondencia=dc.idcorrespondencia
		AND dc.codigoestado=100
		AND dc.idcorrespondencia in (" . $valores . ")
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            $array_interno[$row_operacion['idcorrespondencia']] = $row_operacion;
        } while ($row_operacion = $operacion->fetchRow());
        if ($this->depurar == true) {
            $this->tabla($array_interno, 'detallecorrespondencia');
        }
        return $array_interno;
    }

    function Obtener_seguimiento($correspondencia) {
        $i = 0;
        foreach ($correspondencia as $llave => $valor) {
            if ($i == 0)
                $valores.="" . $valor['idcorrespondencia'];
            else
                $valores.="," . $valor['idcorrespondencia'];
            $i++;
        }

        $query = "
		SELECT * from correspondenciaseguimiento cs, correspondencia c
		WHERE
		cs.idcorrespondencia=c.idcorrespondencia
		AND c.idcorrespondencia in (" . $valores . ")
		AND '$this->fechahoy' >= cs.fechainiciocorrespondenciaseguimiento
		AND '$this->fechahoy' <= cs.fechafinalcorrespondenciaseguimiento
		";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        do {
            $array_interno[$row_operacion['idcorrespondencia']][] = $row_operacion;
        } while ($row_operacion = $operacion->fetchRow());
        $this->array_seguimiento = $array_interno;
        if ($this->depurar == true) {
            $this->tabla($array_interno, 'seguimiento');
        }
        return $array_interno;
    }

    function Obtener_trato() {
        $query = "SELECT * FROM trato WHERE idtrato='" . $_POST['idtrato'] . "'";
        $operacion = $this->conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        return $row_operacion;
    }

    function cuerpoHtml($archivo, $body, $valor) {
        $gestor = fopen($archivo, "rb");
        $contenido = fread($gestor, filesize($archivo));
        $arraylink = explode(".", $valor['linkcorrespondencia']);
        $nombrelink = explode("/", $valor['linkcorrespondencia']);

        $extension = $arraylink[(count($arraylink) - 1)];
         $rutainicial = "https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/prematricula/interesados/archivos/";
        //$rutainicial = "http://172.16.3.202/~javeeto/serviciosacademicos/consulta/prematricula/interesados/archivos/";

        if ($extension == "html") {
            $body.="<br>" . str_replace("imgs/", $rutainicial . $nombrelink[0] . "/imgs/", $contenido);
        }
        // echo "EXTENSION=".$extension;
        //echo $body;
        //exit();
        fclose($gestor);
        return $body;
    }

    function Construir_correo($destinatario, $nombre_destinatario, $trato="Señor(a)") {
        if (is_array($this->array_datos_correspondencia) and is_array($this->array_detalle_correspondencia)) {
            for ($i = 0; $i < count($this->array_datos_correspondencia); $i++) {
                $mail = new PHPMailer();
                $mail->From = $this->array_datos_correspondencia[$i]['correoorigencorrespondencia'];
                $mail->FromName = $this->array_datos_correspondencia[$i]['nombreorigencorrespondencia'];
                $mail->ContentType = "text/html";
                $mail->Subject = $this->array_datos_correspondencia[$i]['asuntocorrespondencia'];
                //aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
                $encabezado = $trato . ":<br>" . $nombre_destinatario;
                $cuerpo = $encabezado . "<br><br>" . $this->array_datos_correspondencia[$i]['encabezamientocorrespondencia'] . "<br><br>" . $this->array_datos_correspondencia['firmacorrespondencia'];
                $mail->Body = $cuerpo;
                $mail->AddAddress($destinatario, $nombre_destinatario);
                //$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
                //echo "ARRAY_DETALLE_CORRESPONDENCIA<pre>";
                //print_r($this->array_detalle_correspondencia);
                //echo "</pre>";
                // foreach ($this->array_detalle_correspondencia[$this->array_datos_correspondencia[$i]['idcorrespondencia']] as $llave => $valor) {
                $valor = $this->array_detalle_correspondencia[$this->array_datos_correspondencia[$i]['idcorrespondencia']];
                //echo "ENTRO A VALORES<pre>";
                //print_r($valor);
                //echo "</pre>";
                $mail->Body=$this->cuerpoHtml("archivos/" . $valor['linkcorrespondencia'], $cuerpo, $valor);
                $arraylink = explode(".", $valor['linkcorrespondencia']);
                $extension = $arraylink[(count($arraylink) - 1)];
                if ($extension != "html") {
                    if (is_array($valor)) {
                        $ruta = "archivos/" . $valor['linkcorrespondencia'];
                        $mail->AddAttachment($ruta, $valor['linkcorrespondencia']);
                    }
                }
                //}

                if (!$mail->Send()) {
                    echo "El mensaje no pudo ser enviado";
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    if ($this->depurar == true) {
                        echo "Mensaje Enviado?";
                        echo "<br>";
                        echo "<pre>";
                        print_r($mail);
                        echo "</pre>";
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function ConstruirCorreoAsignacionSalones($array_datos_correo, $destinatario, $nombredestinatario, $trato) {
        if (is_array($this->array_datos_correspondencia)) {
            $mail = new PHPMailer();
            $mail->From = $this->array_datos_correspondencia['correoorigencorrespondencia'];
            $mail->FromName = $this->array_datos_correspondencia['nombreorigencorrespondencia'];
            $mail->ContentType = "text/html";
            $mail->Subject = $this->array_datos_correspondencia['asuntocorrespondencia'];
            //aquí en $cuerpo se guardan, el encabezado(carreta) y la firma
            $encabezado = $trato . ":<br>" . $nombre_destinatario;
            $cuerpo = $encabezado . "<br><br>" . $this->array_datos_correspondencia['encabezamientocorrespondencia'];
            $cuerpo2 = "en " . $array_datos_correo['direccionsitioadmision'] . ", teléfono: " . $array_datos_correo['telefonositioadmision'] . " el día " . $array_datos_correo['dia'] . " de " . $array_datos_correo['mesTexto'] . " del año " . $array_datos_correo['ano'] . ' a las ' . substr($array_datos_correo['hora'], 0, 5) . " en el salón " . $array_datos_correo['codigosalon'] . ".<br>";
            $cuerpo3 = "<br><br>" . $this->$array_datos_correo['firmacorrespondencia'];
            $mail->Body = $cuerpo . $cuerpo2 . $cuerpo3;
            //echo $cuerpo.$cuerpo2.$cuerpo3;
            $mail->AddAddress($destinatario, $nombre_destinatario);
            //$mail->AddAddress("castroabraham@unbosque.edu.co","Prueba");
            //$mail->AddAddress("dianarojas@sistemasunbosque.edu.co","Prueba");

            if (is_array($this->array_detalle_correspondencia)) {
                foreach ($this->array_detalle_correspondencia as $llave => $valor) {
                    $ruta = "archivos/" . $valor['linkcorrespondencia'];
                    $mail->AddAttachment($ruta, $valor['linkcorrespondencia']);
                }
            }
            if (!$mail->Send()) {
                echo "El mensaje no pudo ser enviado";
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit();
            } else {
                if ($this->depurar == true) {
                    echo "Mensaje Enviado";
                    echo "<br>";
                    echo "<pre>";
                    print_r($mail);
                    echo "</pre>";
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function Construir_correo_seguimiento($nombre_interesado, $idpreinscripcion) {
        if (is_array($this->array_datos_correspondencia) and is_array($this->array_detalle_correspondencia) and is_array($this->array_seguimiento)) {
            for ($i = 0; $i < count($this->array_datos_correspondencia); $i++)
                if (is_array($this->array_seguimiento[$this->array_datos_correspondencia[$i]['idcorrespondencia']]))
                    foreach ($this->array_seguimiento[$this->array_datos_correspondencia[$i]['idcorrespondencia']] as $llave => $valor) {
                        $mail_seguimiento = new PHPMailer();
                        $mail_seguimiento->From = $this->array_datos_correspondencia[$i]['correoorigencorrespondencia'];
                        $mail_seguimiento->FromName = $valor['nombrecorrespondenciaseguimiento'];
                        $mail_seguimiento->ContentType = "text/html";
                        $mail_seguimiento->Subject = "Nuevo interesado";
                        $mail_seguimiento->AddAddress($valor['emailcorrespondenciaseguimiento'], 'Automático');
                        //$mail_seguimiento->AddAddress("javeeto@gmail.com",'Automático');
                        $cuerpo = "<br>Nombre: " . $nombre_interesado . "<br>" . "No_preinscripcion: " . $idpreinscripcion . "<br>" . $valor['mensajecorrespondenciaseguimiento'] . "<br>";
                        $mail_seguimiento->Body = $cuerpo;
                        if (!$mail_seguimiento->Send()) {
                            echo "El mensaje no pudo ser enviado";
                            echo "Mailer Error: " . $mail_seguimiento->ErrorInfo;
                        } else {
                            if ($this->depurar == true) {
                                echo "Mensaje Enviado";
                                echo "<br>";
                                print_r($mail_seguimiento);
                            }
                        }
                        unset($mail_seguimiento);
                    }
            return true;
        } else {
            return false;
        }
    }

    function escribir_cabeceras($matriz) {
        echo "<tr>\n";
        while ($elemento = each($matriz)) {
            echo "<td>$elemento[0]</a></td>\n";
        }
        echo "</tr>\n";
    }

    function tabla($matriz, $texto="") {
        echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
        echo "<caption align=TOP>$texto</caption>";
        $this->escribir_cabeceras($matriz[0], $link);
        for ($i = 0; $i < count($matriz); $i++) {
            echo "<tr>\n";
            while ($elemento = each($matriz[$i])) {
                echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    }

}
?>
