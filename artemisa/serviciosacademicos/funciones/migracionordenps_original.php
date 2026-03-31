<?
session_start();
require_once('../Connections/sala2.php' );
require_once("zfica_sala_crea_aspirante.php");
require_once("zfica_crea_estudiante.php");
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['procesar']=="true" and  $_REQUEST['numeroderegistros'] > 0){
    $QueryMigracion = "select * from tmpIntegracionorden where estadointegracion = 0 and respuestaservidor = '' limit ".$_REQUEST['numeroderegistros']."";
    $resultado3 = mysql_query($QueryMigracion, $sala) or die("$QueryMigracion<br>" . mysql_error());    
    $row =mysql_fetch_array($resultado3);        
    echo $_REQUEST['numeroderegistros'] = $_REQUEST['numeroderegistros'] - 1;
    echo "<pre>";
    echo "enviando ".$key ."<br>";
   enviarps_orden($row['numeroordenpago'],$sala,$row['idtmpIntegracionorden']);
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=migracionordenps.php?numeroderegistros=".($_REQUEST['numeroderegistros'])."&procesar=true'>";
//        foreach ($itemsmigracion as $key  => $value){
//
//        }
}
$QueryMigracion = "select * from tmpIntegracionorden where estadointegracion = 0 and respuestaservidor = ''";
$resultadoMigra = mysql_query($QueryMigracion, $sala) or die("$QueryMigracion<br>" . mysql_error());
echo '<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">';
echo '<tr>';
echo '<th>Id</th>';
echo '<th>numero de orden</th>';
echo '<th>numero de documento</th>';
echo '<th>estado</th>';
echo '<th>Request de integaracion</th>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="5">
    <form name=form action="migracionordenps.php" method="post">
    <input type=hidden name=procesar value=true>
    <div align="center">Total de ordenes sin generar  : '.mysql_num_rows($resultadoMigra).' </div>
    <div align="center">Numero de ordenes a procesar: <input type=text name=numeroderegistros><input type=submit></div>
  </form>
    </td>';
echo '</tr>';
while (($row = mysql_fetch_array($resultadoMigra, MYSQL_ASSOC)) != NULL) {

    echo '<tr>';
    echo '<td>' . $row['idtmpIntegracionorden'] . '</td>';
    echo '<td>' . $row['numeroordenpago'] . '</td>';
    echo '<td>' . $row['numerodocumento'] . '</td>';
    echo '<td>' . $row['estadointegracion'] . '</td>';
    echo '<td>&nbsp;' . $row['respuestaservidor'] . '</td>';
    echo '</tr>';
}
echo '</table>';

function enviarps_orden($ordenpago,$sala,$id) {
    $resultado = "";
      $query_selmaxnumeroordenpago = "SELECT do.codigoconcepto
		FROM detalleordenpago do,concepto c
		WHERE c.codigoconcepto = do.codigoconcepto
		AND do.numeroordenpago = '" . $ordenpago . "'
		AND c.cuentaoperacionprincipal = '153' ";
        $selmaxnumeroordenpago = mysql_query($query_selmaxnumeroordenpago, $sala) or die("$query_selmaxnumeroordenpago<br>" . mysql_error());
        $row_selmaxnumeroordenpago = mysql_fetch_array($selmaxnumeroordenpago);
        if ($row_selmaxnumeroordenpago <> "") {
            $resultado = genera_prodiverso($sala, $ordenpago, 0);
        } else {
            $resultado = crea_estudiante($sala, $ordenpago, $idgrupo, 0);
        }
	if(is_array($resultado) &&($resultado['ERRNUM']!=0)) {            
              $query_update = "UPDATE tmpIntegracionorden SET respuestaservidor = 'error : ".$resultado['DESCRLONG']."' WHERE idtmpIntegracionorden = $id";
              $query_update = mysql_query($query_update, $sala) or die("$query_update<br>" . mysql_error());
	}else{                
              $query_update = "UPDATE tmpIntegracionorden SET estadointegracion = 1 WHERE idtmpIntegracionorden = $id";
              $query_update = mysql_query($query_update, $sala) or die("$query_update<br>" . mysql_error());
        }
}
?>
