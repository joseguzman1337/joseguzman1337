<?php

require_once('../../funciones/funcionip.php' );
$ip = "SIN DEFINIR";
$ip = tomarip();

if (isset($_SESSION['programaprincipal'])) {
    $usuario = "admintecnologia";
    $codigousuario = '145';
} else {
    $usuario = $_SESSION['MM_Username'];
    $codigousuario = $_SESSION['codigodocente'];
}
mysql_select_db($database_sala, $sala);
$query_nota = "SELECT *
			FROM nota n  
			WHERE idcorte = '" . $_POST['idcorte'] . "'
			AND idgrupo = '" . $_POST['idgrupo'] . "'";

$nota = mysql_query($query_nota, $sala) OR die(mysql_error());
$row_nota = mysql_fetch_assoc($nota);
$totalRows_nota = mysql_num_rows($nota);


if (!$row_nota) {
    $insertSQL = "INSERT INTO nota (idgrupo,idcorte,fechaorigennota,fechaultimoregistronota, actividadesacademicasteoricanota, actividadesacademicaspracticanota, codigotipoequivalencianota)";
    $insertSQL .= "VALUES( 
                                            '" . $_POST['idgrupo'] . "',
                                            '" . $_POST['idcorte'] . "',
                                            '" . date("Y-m-j G:i:s", time()) . "', 
                                            '" . date("Y-m-j G:i:s", time()) . "',
                                            '" . $_POST['actividadteorica'] . "', 
                                            '" . $_POST['actividadpractica'] . "',
                                            '10')";

    mysql_select_db($database_sala, $sala);

    $Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
} else {

    $query_updnota = "update nota 
				set actividadesacademicasteoricanota = '" . $_POST['actividadteorica'] . "', actividadesacademicaspracticanota = '" . $_POST['actividadpractica'] . "'
				where idcorte = '" . $_POST['idcorte'] . "'
				and idgrupo = '" . $_POST['idgrupo'] . "'";

    $updnota = mysql_query($query_updnota, $sala) or die(mysql_error());
}

$query_estudiantess = "SELECT e.codigoestudiante,eg.numerodocumento,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral
					FROM prematricula p,detalleprematricula d,estudiante e,estudiantegeneral eg
					WHERE eg.idestudiantegeneral = e.idestudiantegeneral 
					AND p.codigoestudiante = e.codigoestudiante
					AND p.idprematricula = d.idprematricula
					AND d.idgrupo = '" . $_POST['idgrupo'] . "'
					AND p.codigoestadoprematricula LIKE '4%'
					AND d.codigoestadodetalleprematricula LIKE '3%'
					ORDER BY 4 ";

$estudiantess = mysql_query($query_estudiantess, $sala) OR die(mysql_error());
$row_estudiantess = mysql_fetch_assoc($estudiantess);
$totalRows_estudiantess = mysql_num_rows($estudiantess);

$f = 1;

do {



    /*
     * Se agrega codigoestudiantel para que no haya cruce de datos caso 95213
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Modificado 30 de Octubre de 2017.
     */
    $query_estudiantes2 = "SELECT *
                            FROM detallenota d,nota n  
                            WHERE d.idcorte=n.idcorte
                            and d.idcorte = '" . $_POST['idcorte'] . "'
                            AND d.codigomateria = '" . $_POST['materia'] . "'							
                            and d.codigoestudiante = '" . $_POST['codigoestudiantel' . $f] . "'";
    
    $estudiantes2 = mysql_query($query_estudiantes2, $sala) OR die(mysql_error());
    $row_estudiantes2 = mysql_fetch_assoc($estudiantes2);
    $totalRows_estudiantes2 = mysql_num_rows($estudiantes2);
    
    $codigoestudiante = $_POST['codigoestudiantel' . $f];
    $nota = $_POST['notal' . $f];
    $fallasteoricas = $_POST['fallateorical' . $f];
    $fallaspracticas = $_POST['fallapractical' . $f];
    $insertSQL5 = "INSERT INTO auditoria ( numerodocumento,usuario,fechaauditoria, codigomateria, grupo, codigoestudiante, notaanterior, notamodificada, corte, tipoauditoria,ip)";
    $insertSQL5 .= "VALUES( 
                            '" . $codigousuario . "',
                            '" . $usuario . "',
                            '" . date("Y-m-j G:i:s", time()) . "', 
                            '" . $_POST['materia'] . "', 
                            '" . $_POST['idgrupo'] . "', 
                            '" . $codigoestudiante . "', 
                            '" . $row_estudiantes2['nota'] . "',
                            '" . $nota . "', 
                            '" . $_POST['idcorte'] . "', 
                            '10',
                            '$ip')";
    mysql_select_db($database_sala, $sala);
    $Result1 = mysql_query($insertSQL5, $sala) or die(mysql_error());

    if (!$row_estudiantes2) {

        $insertSQL1 = "INSERT INTO detallenota (idgrupo,idcorte,codigoestudiante,codigomateria,nota,numerofallasteoria,numerofallaspractica,codigotiponota)";
        $insertSQL1 .= "VALUES( 
                           '" . $_POST['idgrupo'] . "',
                           '" . $_POST['idcorte'] . "', 
                           '" . $codigoestudiante . "', 
                           '" . $_POST['materia'] . "', 
                           '" . $nota . "', 
                           '" . $fallasteoricas . "',
                           '" . $fallaspracticas . "',
                           '10')";

        mysql_select_db($database_sala, $sala);

        $Result2 = mysql_query($insertSQL1, $sala) or die(mysql_error());
    } else {
        $base = "update detallenota set  
		       nota ='" . $nota . "',	
			   numerofallasteoria = '" . $fallasteoricas . "',
			   numerofallaspractica = '" . $fallaspracticas . "'
                           where idcorte = '" . $_POST['idcorte'] . "'
			   and codigomateria = '" . $_POST['materia'] . "'
			   and codigoestudiante = '" . $codigoestudiante . "' ";

        $sol = mysql_db_query($database_sala, $base);
    }

    $f++;
//end
} while ($row_estudiantess = mysql_fetch_assoc($estudiantess));

require_once('despliegalistasala2.php');
?>

