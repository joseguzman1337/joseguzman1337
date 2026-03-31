<?
session_start();
require_once('../Connections/sala2.php' );
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

$Query= "select numeroordenpago from tmpAnulacionorden where estado='' or estado is null";
$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());
echo "<center>ORDENES POR ANULAR : <b>".mysql_num_rows($resultado)."</b></center><br>";

echo '<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">';
echo '<tr>';
echo '<td colspan="5">
    <form name=form action="anulacionordenps.php" method="post">
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
$Query= "select * from tmpAnulacionorden where estado<>'' order by numeroordenpago";
$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());    
while (($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) != NULL) {
    echo '<tr>';
    echo '<td>' . $row['idtmpAnulacionorden'] . '</td>';
    echo '<td>' . $row['numeroordenpago'] . '</td>';
    echo '<td>' . $row['numerodocumento'] . '</td>';
    echo '<td>' . $row['estado'] . '</td>';
    echo '<td>' . $row['respuesta'] . '</td>';
    echo '</tr>';
}
echo '</table>';

if($_REQUEST['procesar']=="true" and  $_REQUEST['numeroderegistros'] > 0){
    $QueryMigracion = "select * from tmpAnulacionorden where estado='' or estado is null order by numeroordenpago limit ".$_REQUEST['numeroderegistros'];
    $resultado3 = mysql_query($QueryMigracion, $sala) or die("$QueryMigracion<br>" . mysql_error());    
    $row =mysql_fetch_array($resultado3);        
    echo $_REQUEST['numeroderegistros'] = $_REQUEST['numeroderegistros'] - 1;
    anularps_orden($row['numerodocumento'],$row['numeroordenpago'],$sala,$row['idtmpAnulacionorden']);
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=anulacionordenps.php?numeroderegistros=".($_REQUEST['numeroderegistros'])."&procesar=true'>";
}

function anularps_orden($numerodocumento,$ordenpago,$sala,$id) {
	require_once($_SESSION['path_live'].'consulta/interfacespeople/ordenesdepago/anularordenespagosala_PARAMIGRACION.php');
        $query_update = "UPDATE tmpAnulacionorden SET estado='".$result['ERRNUM']."', respuesta='".$result['DESCRLONG']."' WHERE idtmpAnulacionorden = $id";
        mysql_query($query_update, $sala) or die("$query_update<br>" . mysql_error());
}
?>
