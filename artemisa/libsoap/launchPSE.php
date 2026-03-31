<?php
require_once(dirname(__FILE__).'/../sala/includes/adaptador.php');
require_once(dirname(__FILE__).'/VerifyEcolletProcess.php');

$c ='0';
echo "<table border='2px'><tr><td>#</td><td>Ticket</td><td>Reference1</td><td>Reference2</td>".
"<td>Reference3</td><td>PaymentDesc</td><td>TransValue</td><td>StadCode</td><td>Estado Orden</td><td>Descripcion</td></tr>";

/**
 * Conectamos a la base de datos y obtenemos las transacciones que se
encuentren es estado de PENDING, se opto por dejar todo en este scritp
por seguridad e integridad con el sistema de PSE, tambien teniendo la
opcionde de que este script es ejecutado por el sistema operativo bajo un
ambiente Linux.
 */

//consulta de ordenes en estado pediente, bank o creadas.
$strConsulta = "SELECT o.codigoestadoordenpago, l.*, b.* FROM  LogPagos l ".
    " LEFT JOIN bancopse b ON ( l.FIName LIKE CONCAT('%', b.nombrebancopse, '%') AND codigoestado = 100 ) ".
    " INNER JOIN ordenpago o ON (l.Reference1 = o.numeroordenpago) ".
    " WHERE ".
    " l.StaCode LIKE 'PEND%' OR l.StaCode = 'BANK' OR l.StaCode = 'CREATED' AND PaymentSystem <> 100 ".
    " union  ".
    " SELECT o.codigoestadoordenpago, l.*, b.* FROM  LogPagos l ".
    " LEFT JOIN bancopse b ON ( l.FIName LIKE CONCAT('%', b.nombrebancopse, '%') AND codigoestado = 100 ) ".
    " INNER JOIN ordenpago o ON (l.Reference1 = o.numeroordenpago ) ".
    " WHERE".
    " l.StaCode = 'OK' AND PaymentSystem <> 100 AND o.codigoestadoordenpago not in (40, 52, 41, 44, 51) ".
    " order by TicketId asc limit 20";
$rowregistros = $db->GetAll($strConsulta);
$trace = null;
if(isset($_GET['trace']))
{
    $trace = true;
}
//Inicio de proceso de actualizacion de estado
foreach($rowregistros as $row){
    $c++;
    echo "<tr><td>".$c."</td><td>".$row['TicketId']."</td><td>".$row['Reference1']."</td><td>".$row['Reference2']."</td>
    <td>".$row['Reference3']."</td><td>".$row['PaymentDesc']."</td><td>".$row['TransVatValue']."</td><td>".
        $row['StaCode']."</td><td>".$row['codigoestadoordenpago']."</td>";
    $classVerifyEcollet = new VerifyEcolletProcess($db,$row,$c,$trace);
}