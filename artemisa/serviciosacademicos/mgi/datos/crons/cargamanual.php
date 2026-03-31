<?php
    require_once("../templates/template.php");
    $db = getBD();
	require_once('../../../educacionContinuada/Excel/reader.php');
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Cargar manual de aspirantes estadisticas</title>
        <!--<link rel="stylesheet" type="text/css" href="../mgi/css/themes/smoothness/jquery-ui-1.8.4.custom.css" media="screen" /> -->
        <link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/functions.js"></script>
    </head>
    <body>
    <div id="pageContainer" class="wrapper" align="center">
        <h4>Cargar manual de aspirantes estadisticas Drupal</h4>

        <form name="f1" action="cargamanual.php" method="POST" enctype="multipart/form-data">
            <label>carga manual:</label>
            <input type="file" class="required" value="" name="file" id="file" /><br/><br/>
            <input name="buscar" type="submit" value="Cargar">
        </form>
    </div>
    </body>
<?php

if(isset($_POST['buscar']) &&  isset($_FILES)){
    ?>
    <table class="table">
        <tr>
            <td>#</td><td>Aspirantes</td><td>Mensaje</td>
        </tr>
    <?php
    //TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');

    $data->read($_FILES["file"]["tmp_name"]);
    $filas = $data->sheets[0]['numRows'];
    //var_dump($filas); die;
    $contador=1;
    $errores = 0;
    //se asume la primera como titulo
    for ($z = 2; $z <= $filas; $z++) {
        $fields['Nombres'] = $data->sheets[0]['cells'][$z][1];
        $fields['Apellidos'] = trim($data->sheets[0]['cells'][$z][2]);
        $fields['Email'] = $data->sheets[0]['cells'][$z][3];
        $fields['Ciudad'] = $data->sheets[0]['cells'][$z][4];
        $fields['Telefono'] = $data->sheets[0]['cells'][$z][5];
        $fields['Programa'] = $data->sheets[0]['cells'][$z][6];
        $fields['FechaInicio'] = $data->sheets[0]['cells'][$z][7];
        $fields['Origen'] = 'organico';

        echo "<tr><td>$contador</td><td>".$fields['Nombres']." - ".$fields['Apellidos']." ".$fields['Email']."</td>";
        $mensaje = enviar($fields);
        echo "<td>$mensaje</td></tr>";
        $contador++;
    }
    ?>
    </table>
    <?php
}

function enviar($valores){
    $curl = curl_init();
    $url = "https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/estadisticas/matriculasnew/apirantesWeb.php";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $valores);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($curl);

    curl_close($curl);
    return $output;
}
