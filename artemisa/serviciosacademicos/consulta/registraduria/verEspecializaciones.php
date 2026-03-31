<?php

$ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    include_once('./functions.php');
    
    $query = "SELECT c.codigocarrera, c.nombrecarrera FROM detallecarrera dc INNER JOIN carrera c on c.codigocarrera=dc.codigocarrera 
        where dc.codigoestado=100 and dc.esMedicoQuirurgica=1 ORDER BY c.nombrecarrera ASC";
    //echo $query;
    $results = $db->Execute($query);
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Carreras Medico-Quirúrgica</title>
        <style>
            table
            {
                border-collapse:collapse;
            }
            table,th, td
            {
                border: 1px solid black;
            }
            th{
                background-color:#C5D5AA;
            }
            th.category{
                background-color: #FEF7ED;
                text-align:center;
            }
         </style>
         </head>
    <body>
        
        <table CELLPADDING="10" id="tableResult" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Carrera</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $results->FetchRow()) { 
                        echo "<tr><td>".$row["codigocarrera"]."</td><td>".$row["nombrecarrera"]."</td></tr>";
                } ?>
            </tbody>
        </table>
        
</body>
</html>