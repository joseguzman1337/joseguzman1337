

<HTML>
    <BODY>
        <TABLE>
            <TR><TD>IDENTIFICACION</td><TD>OBSERVACION</td><TD>OPCION</td><TD>FECHA</td></TR>        
<?php
header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename=csv_excel.xls');
header("Pragma: ");
header("Cache-Control: ");

    include '../db/db.inc';
    error_reporting(0);    
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
    
    $query = "
        select identificacion,observacion, opcion,fecha_evaluacion 
from cl_observacion ob
inner join cl_evaluacion ev on ob.idcl_evaluacion = ev.idcl_evaluacion
inner join cl_opcion_evaluacion op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion
;";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);    
    while($row = mysql_fetch_array($result)) {            
        ECHO "<TR><TD>".$row['identificacion']."</TD><TD>".$row['observacion']."</TD>
            <TD>".$row['opcion']."</TD><TD>".$row['fecha_evaluacion']."</TD></TR>"; 
        
    }
    mysql_free_result($result);
?>
            </table>
</body>
</html>
