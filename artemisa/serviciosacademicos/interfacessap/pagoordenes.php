<?php

require('../Connections/sala2.php');
mysql_select_db($database_sala, $sala);

$query_data = "SELECT * FROM tmpordenes";
//echo $query_data,"<br>";
$data = mysql_query($query_data, $sala) or die(mysql_error());
$row_data = mysql_fetch_assoc($data);
$totalRows_data = mysql_num_rows($data);
do {
    $documentocuentaxcobrarsap = $row_data['documento'];
    $documentocuentacompensacionsap = $row_data['pago'];
    $fechapagosapordenpago = date("Y-m-d");
    $numeroordenpago = substr($row_data['orden'], 0, 7);

    if ($row_data <> "") { //if 2
        $query_data2 = "SELECT * FROM ordenpago
			where numeroordenpago = '$numeroordenpago'
			and codigoestadoordenpago like '1%'";
        //echo $query_data,"<br>";
        $data2 = mysql_query($query_data2, $sala) or die(mysql_error());
        $row_data2 = mysql_fetch_assoc($data2);
        $totalRows_data2 = mysql_num_rows($data2);

        if ($row_data2 <> "") {
        require_once('../funciones/funcion_inscribir.php');
        hacerInscripcion_mysql($numeroordenpago);

            /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
			   SET i.codigosituacioncarreraestudiante = '107',
			   e.codigosituacioncarreraestudiante = '107',
                           e.codigoperiodo = o.codigoperiodo
			   WHERE o.codigoestudiante = e.codigoestudiante
			   AND e.idestudiantegeneral = i.idestudiantegeneral 
			   AND e.codigocarrera = ec.codigocarrera
			   AND i.idinscripcion = ec.idinscripcion
			   AND o.numeroordenpago = '$numeroordenpago'";
            echo $query_inscripcion, "<br>";
            $inscripcion = mysql_db_query($database_sala, $query_inscripcion);*/

            $query_ordenpago = "UPDATE ordenpago
				set codigoestadoordenpago = '40',
				documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
				documentocuentacompensacionsap = '$documentocuentacompensacionsap',
				fechapagosapordenpago = '$fechapagosapordenpago'
				where numeroordenpago = '$numeroordenpago'";
            echo $query_ordenpago, "<br>";
            $ordenpago = mysql_db_query($database_sala, $query_ordenpago);
        }
    }
} while ($row_data = mysql_fetch_assoc($data));
?>

