<?php

function cargaarchivoencuesta($HTTP_POST_FILES, $_POST, $objetobase) {
    $cadenatexto = $_POST["cadenatexto"];
    //echo "Escribió en el campo de texto: " . $cadenatexto . "<br><br>";
    //datos del arhivo
    $nombre_archivo = $HTTP_POST_FILES['encuestaarchivo']['name'];
    $tipo_archivo = $HTTP_POST_FILES['encuestaarchivo']['type'];
    $tamano_archivo = $HTTP_POST_FILES['encuestaarchivo']['size'];
    //echo "$nombre_archivo <br> Tipo: $tipo_archivo <br> $tamano_archivo";
    //compruebo si las características del archivo son las que deseo
    //if((ereg("gif",$tipo_archivo) || ereg("jpeg",$tipo_archivo) || ereg("text",$tipo_archivo)) && ($tamano_archivo < 200000))
    $extension = explode(".", $nombre_archivo);

    if ("xls" != $extension[1]) {
        alerta_javascript("El archivo debe ser de excel");
        //exit();
    } else if ($tamano_archivo > 2000000) {

        alerta_javascript("El archivo sobrepasa el tamaño adecuado para ser subido, maximo de 2Mb");
        //exit();
    } else {

        if (copy($HTTP_POST_FILES['encuestaarchivo']['tmp_name'], "/tmp/archivoencuesta.xls")) {
            $archivo_cargado_ok = true;
            //echo "<h1>Archivo Cargado</h1>";
            alerta_javascript("Archivo Cargado");
            $dataexcel = new Spreadsheet_Excel_Reader();
            $dataexcel->setOutputEncoding('CP1251');
            $dataexcel->read('/tmp/archivoencuesta.xls');
            //$service->addRecipientToEmailList("aabello@unbosque.edu.co", "listapruebai");
            $objetobase->conexion->execute("delete from preguntatipousuario where
idpregunta in (select idpregunta from encuestapregunta where idencuesta='" . $_POST["idencuesta"] . "')");

            $objetobase->conexion->execute("delete from detallepregunta where
idpregunta in (select idpregunta from encuestapregunta where idencuesta='" . $_POST["idencuesta"] . "')");
            $objetobase->conexion->execute("delete from preguntacarrera where
idpregunta in (select idpregunta from encuestapregunta where idencuesta='" . $_POST["idencuesta"] . "')");
            $objetobase->conexion->execute("set foreign_key_checks=0;");
            $objetobase->conexion->execute("delete from pregunta where
idpregunta in (select idpregunta from encuestapregunta where idencuesta='" . $_POST["idencuesta"] . "')");
            $objetobase->conexion->execute("set foreign_key_checks=1;");
            $objetobase->conexion->execute("delete from encuestapregunta where idencuesta='" . $_POST["idencuesta"] . "'");
            
echo "Numero de columnas=".$dataexcel->sheets[0]['numRows'];

            for ($i = 1; $i <= $dataexcel->sheets[0]['numRows']; $i++) {
                //try {
                    $pregunta = trim($dataexcel->sheets[0]['cells'][$i][1]);
                    if (isset($pregunta)&&(trim($pregunta) != '')) {
                        $detallepregunta = $dataexcel->sheets[0]['cells'][$i][7];
                        if (trim(strtoupper($detallepregunta)) == 'NO') {
                            unset($filapregunta);
                            $tabla = "pregunta";
                            $filapregunta["idtipopregunta"] = $dataexcel->sheets[0]['cells'][$i][4];
                            $filapregunta["nombrepregunta"] = $pregunta;
                            $filapregunta["descripcionpregunta"] = "";
                            $filapregunta["idpreguntagrupo"] = $arraypreguntaid[$dataexcel->sheets[0]['cells'][$i][6]];
                            $filapregunta["pesopregunta"] = $i;
                            $filapregunta["codigoestado"] = "100";
                            $filapregunta["estadoobligatoriopregunta"] = $dataexcel->sheets[0]['cells'][$i][8];
                            $filapregunta["valordependenciapregunta"] = $dataexcel->sheets[0]['cells'][$i][9];
                            $condicionactualiza = "";
                          //  echo "<pre>";
                            $objetobase->insertar_fila_bd($tabla, $filapregunta, 0, $condicionactualiza);
                           // echo "</pre>";
                            $datospregunta = $objetobase->recuperar_datos_tabla("pregunta p", "1", "1", "", ",max(idpregunta) maxidpregunta");
                            $arraypreguntaid[$dataexcel->sheets[0]['cells'][$i][2]] = $datospregunta["maxidpregunta"];
/*if($i>10){
    exit();
}*/
                            unset($fila);
                            $tabla = "encuestapregunta";
                            $fila["idpregunta"] = $datospregunta["maxidpregunta"];
                            $fila["idencuesta"] = $_POST["idencuesta"];
                            $fila["codigoestado"] = "100";
                            $condicionactualiza = "";
                            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
                            unset($fila);
                            $tabla = "preguntatipousuario";
                            $fila["idpregunta"] = $datospregunta["maxidpregunta"];
                            $fila["codigotipousuario"] = $_POST["codigotipousuario"];
                            $fila["codigoestado"] = "100";
                            $condicionactualiza = "";
                            $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);

                            $carreras = $dataexcel->sheets[0]['cells'][$i][10];
                            unset($fila);
                            $arraycarrera = explode(",", $carreras);
                            if(is_array($arraycarrera))
                            for ($j = 0; $j < count($arraycarrera); $j++) {
                                unset($fila);
                                $tabla = "preguntacarrera";
                                $fila["idpregunta"] = $datospregunta["maxidpregunta"];                                
                                $fila["codigocarrera"] = $arraycarrera[$j];
                                $fila["codigoestado"] = "100";
                                $condicionactualiza = "";
                                $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
                            }
                            unset($fila);
                        } else {
                            unset($filapregunta);
                            $tabla = "detallepregunta";
                            /*   echo "fila<pre>";
                              print_r($dataexcel->sheets[0]['cells'][$i]);
                              echo "</pre>"; */
                            $filapregunta["idtipodetallepregunta"] = $dataexcel->sheets[0]['cells'][$i][4];
                            $filapregunta["nombredetallepregunta"] = $pregunta;
                            $filapregunta["valordetallepregunta"] = $dataexcel->sheets[0]['cells'][$i][8];
                            $filapregunta["idpregunta"] = $arraypreguntaid[$dataexcel->sheets[0]['cells'][$i][6]];
                            $filapregunta["codigoestado"] = "100";
                            $condicionactualiza = "";
                            $objetobase->insertar_fila_bd($tabla, $filapregunta, 0, $condicionactualiza);
                        }
                    }
                /*} catch (Exception $e) {
                    $erroresdecarga[] = $filapregunta;
                    echo "<br><H1>ERROR </H1> " . $filapregunta["nombrepregunta"] . "<br>";
                    ob_flush();
                    flush();
                }*/
            }
            echo "<br>ERRORES DE CARGA " . count($erroresdecarga) . ":";
            if (is_array($erroresdecarga))
                foreach ($erroresdecarga as $i => $row) {
                    echo "$i<pre>";
                    print_r($erroresdecarga[$i]);
                    echo "</pre>";
                }
        } else {
            $archivo_cargado_ok = false;
            alerta_javascript("Ocurrió algún error al subir el fichero. No pudo guardarse.");
        }
    }
}
?>
