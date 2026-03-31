<?
session_start();
require_once('../Connections/sala2.php' );
require_once("zfica_sala_crea_aspirante_PARAMIGRACION.php");
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

$Query= "select numeroordenpago from tmpIntegracionorden where estado='' or estado is null";
$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());
echo "<center>ORDENES POR PROCESAR : <b>".mysql_num_rows($resultado)."</b></center><br>";

echo '<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">';
echo '<tr>';
echo '<td colspan="5">
    <form name=form action="migracionordenps.php" method="post">
    <input type=hidden name=procesar value=true>
    <div align="center">Numero de ordenes a procesar: <input type=text name=numeroderegistros><input type=submit></div>
  </form>
    </td>';
echo '</tr>';
echo '<tr>';
echo '<th>Id</th>';
echo '<th>numero de orden</th>';
echo '<th>numero de documento</th>';
echo '<th>estado</th>';
echo '<th>Request de integaracion</th>';
echo '</tr>';
$Query= "select * from tmpIntegracionorden where estado<>'' order by numeroordenpago";
$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());    
while (($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) != NULL) {
    echo '<tr>';
    echo '<td>' . $row['idtmpIntegracionorden'] . '</td>';
    echo '<td>' . $row['numeroordenpago'] . '</td>';
    echo '<td>' . $row['numerodocumento'] . '</td>';
    echo '<td>' . $row['estado'] . '</td>';
    echo '<td>' . $row['respuesta'] . '</td>';
    echo '</tr>';
}
echo '</table>';

if($_REQUEST['procesar']=="true" and  $_REQUEST['numeroderegistros'] > 0){
    $QueryMigracion = "select * from tmpIntegracionorden where estado='' or estado is null order by numeroordenpago limit ".$_REQUEST['numeroderegistros'];
    $resultado3 = mysql_query($QueryMigracion, $sala) or die("$QueryMigracion<br>" . mysql_error());    
    $row =mysql_fetch_array($resultado3);        
    echo $_REQUEST['numeroderegistros'] = $_REQUEST['numeroderegistros'] - 1;
    enviarps_orden($row['numeroordenpago'],$sala,$row['idtmpIntegracionorden']);
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=migracionordenps.php?numeroderegistros=".($_REQUEST['numeroderegistros'])."&procesar=true'>";
}

function enviarps_orden($ordenpago,$sala,$id) {
	$resultado = "";
	$query_selmaxnumeroordenpago = "SELECT do.codigoconcepto
		FROM detalleordenpago do,concepto c
		WHERE c.codigoconcepto = do.codigoconcepto
		AND do.numeroordenpago = '" . $ordenpago . "'
		AND c.cuentaoperacionprincipal = '153' ";
	//echo $query_selmaxnumeroordenpago."<br>";
        $selmaxnumeroordenpago = mysql_query($query_selmaxnumeroordenpago, $sala) or die("$query_selmaxnumeroordenpago<br>" . mysql_error());
        $row_selmaxnumeroordenpago = mysql_fetch_array($selmaxnumeroordenpago);
        if ($row_selmaxnumeroordenpago <> "") {
            $resultado = genera_prodiverso_PARAMIGRACION($sala, $ordenpago, 0);
        } else {
            $resultado = genera_prodiverso_PARAMIGRACION($sala, $ordenpago, 0);
            //$resultado = crea_estudiante($sala, $ordenpago, $idgrupo, 0);
        }
	//print_r($resultado);
        $query_update = "UPDATE tmpIntegracionorden SET estado='".$resultado['ERRNUM']."', respuesta='".$resultado['DESCRLONG']."' WHERE idtmpIntegracionorden = $id";
        mysql_query($query_update, $sala) or die("$query_update<br>" . mysql_error());

}
?>
