<script language="javascript">
    function validar(){

        if(document.getElementById('annio').value.length < 1){
            alert('Porfavor Digite Año');
        }
        else if(document.getElementById('periodo').value.length < 1){
            alert('Porfavor Seleccione Periodo');
        }
        else if(document.getElementById('accion').value.length < 1){
            alert('Porfavor Seleccione Accion');
        }
        else{
            document.getElementById('form1').submit();
        }
    }
</script>
<form name="form1" id="form1" action="" method="POST">
    <table>
        <tr>
            <td>Año</td>
            <td><input name="annio" id="annio" value="<?php echo $_POST['annio'] ?>"></td>
        </tr>
        <tr>
            <td>Periodo</td>
            <td>
                <select name="periodo" id="periodo">
                    <option value="">Seleccionar</option>>
                    <option value="1" <?php if ($_POST['periodo'] == '1')
    echo "selected" ?>>01</option>
                    <option value="2" <?php if ($_POST['periodo'] == '2')
    echo "selected" ?>>02</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Accion</td>
            <td>
                <select name="accion" id="accion">
                    <option value="">Seleccionar</option>>
                    <option value="1" <?php if ($_POST['accion'] == '1')
    echo "selected" ?>>Reportar</option>
                    <option value="2" <?php if ($_POST['accion'] == '2')
    echo "selected" ?>>Insertar</option>
                </select>
            </td>
        </tr>
    </table>
    <input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
//phpinfo();
if (!empty($_POST['annio']) and !empty($_POST['periodo'])) {

    $codigoperiodo = $_POST['annio'] . $_POST['periodo'];

    error_reporting(0);
    //ini_set('memory_limit', '128M');
    ini_set('max_execution_time', '10000000');
    $rutaado = ("../serviciosacademicos/funciones/adodb_mod/");
    require_once('../serviciosacademicos/Connections/salaado-pear.php');
    require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
    require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
    require_once('funciones/obtener_datos.php');
    echo date("Y-m-d H:i:s"), "\n\n";
    //$sala->debug=true;
    //$snies_conexion->debug=true;
    //SET CLIENT_ENCODING TO 'value';
    //$snies_conexion->query("SET NAMES '8859-1';");
    $snies = new snies($sala, $codigoperiodo);
    $snies->asignaConexionPostgreSQL(&$snies_conexion);


    $array_codigoestudiante_estudiante = $snies->codigoestudiante_complementario($codigoperiodo);
    echo "<pre>";
    print_r($array_codigoestudiante_estudiante[0]);
    echo "</pre>";
    echo "<h1>" . count($array_codigoestudiante_estudiante) . " registros reportados</h1><br>";
    if ($_POST['accion'] == '2') {
        $i = 0;
        $j = 0;
        $pobres = 0;
        foreach ($array_codigoestudiante_estudiante as $llave => $valor) {
            echo $j;
            ob_flush();
            flush();

            $participante = $snies->datos_participante($valor['codigoestudiante']);
            $fila['ies_code'] = 1729;
            $fila['codigo_unico'] = $participante['CODIGO_UNICO'];
            $fila['tipo_doc_unico'] = $participante['TIPO_DOC_UNICO'];
            //$fila['annio']=$_POST['annio'];
            //$fila['semestre']="0".$_POST['periodo'];
            $parteciudad = explode(" ", trim($valor["nombreciudad"]));
            $datosmunicipio = $snies->codigomunicipio_complementario($parteciudad[0]);
            // $fila['municipio']=$datosmunicipio["nombremunicipio"];
            if (trim($datosmunicipio["codigomunicipio"]) != '' &&
                    isset($datosmunicipio["codigomunicipio"])) {
                $fila['mun_origen'] = $datosmunicipio["codigomunicipio"];
            } else {
                $fila['mun_origen'] = '0001';
            }
            if (trim($datosmunicipio["codigomunicipio"]) != '' &&
                    isset($datosmunicipio["codigomunicipio"])) {
                $fila['dep_origen'] = $datosmunicipio["codigodpto"];
            } else {
                $fila['dep_origen'] = '0';
            }
            $fila['grupo_vulnerable'] = "02";
            $fila['grupo_etnico'] = "00";
            // $fila['resguardo']="00";
            $fila['victima'] = "02";
            //  $fila['lugar_exp']="00";
            //$fila['codigonaturaleza']=$valor['codigonaturaleza'];
            switch (trim($valor['codigonaturaleza'])) {
                case '001':
                    $pobres++;
                    $fila['proviene_sectpriv'] = "02";
                    break;
                case '002':

                    $fila['proviene_sectpriv'] = "01";
                    break;
                default:
                    $fila['proviene_sectpriv'] = "01";
                    break;
            }
            $fila['especiales'] = "02";
            $fila['tipo_discapacidad'] = "99";
            $fila['capac_code'] = "09";
            //  $filafrontera['pafron_code']="05";
            $fila['sisben'] = '07';
            $datosestratoestudiante = $snies->estudiante_historico($valor['idestudiantegeneral']);
            if (!$datosestratoestudiante['idestrato'])
                $datosestratoestudiante['idestrato'] = 3;

            if ($datosestratoestudiante['idestrato'] == '9') {
                $datosestratoestudiante['idestrato'] = '6';
            }

            $fila['estrato'] = "0" . $datosestratoestudiante['idestrato'];
            //$filaexamenicfes['esei_snp']=$valor["nombrecortoinstitucioneducativa"];
            $filaexamenicfes['esei_snp'] = $valor["numeroregistroresultadopruebaestado"];
            //if($tipofinanciero[0]["idtipoestudianterecursofinanciero"]){
            if ($i < 100) {
                $array_datos[] = $fila;
                /* 				echo "<pre>";
                  print_r($valor);
                  echo "</pre>";
                 */
            }
            //if(($fila['annio']==$_POST['annio'])&&($fila['semestre']==$_POST['periodo'])){
            //$snies->insertar_fila_bd($snies_conexion,'estudiante_complementario',$fila);
            $nombreidtabla = '1';
            $idtabla = '1';
            $condicion = " and codigo_unico= '" . $participante['CODIGO_UNICO'] . "'" .
                    " and tipo_doc_unico='" . $participante['TIPO_DOC_UNICO'] . "';";

            $snies->ingresar_actualizar_fila_bd($snies_conexion, 'estudiante_complementario', $fila, $nombreidtabla, $idtabla, $condicion);
            //}

            $i++;
            //}
            unset($fila);
            unset($participante);
            $j++;
        }
        echo "cant registros insertados: $snies->contador_inserta\n\n";
        echo "cant registros actualizados: $snies->contador_actualiza\n\n";
        echo "cantidad de arriados=$pobres";
    } else {
        echo $query = "SELECT count(*) as cantidad FROM estudiante";
        $operacion = $snies_conexion->query($query);
        $row_operacion = $operacion->fetchRow();
        echo "CANTIDAD=" . $row_operacion['cantidad'];
        $query = "SELECT * FROM estudiante limit 100 offset " . ($row_operacion['cantidad'] - 100);
        $operacion = $snies_conexion->query($query);
        while ($row_operacion = $operacion->fetchRow()) {
            $array_datos[] = $row_operacion;
        }
    }

    $motor = new matriz($array_datos);
    $motor->mostrar();
}
?>

