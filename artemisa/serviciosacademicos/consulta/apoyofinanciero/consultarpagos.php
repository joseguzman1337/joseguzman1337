<?php

session_start();
include_once(realpath(dirname(__FILE__)) . '/../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include_once ('../../EspacioFisico/templates/template.php');
$db = getBD();

$fechainicio = $_REQUEST["fechainicio"];
$fechafin = $_REQUEST["fechafin"];
$fechafin = date('Y-m-d', strtotime($fechafin . ' +1 day'));

 /*
  * Se agregan los campos: Apellidos,Nombres,Email,Telefono,Celular,Codigo_carrera y Nomnbre_carrera 
  * Vega Gabriel <vegagabriel@unbosque.edu.do>.
  * Universidad el Bosque - Direccion de Tecnologia.
  * Modificado 10 y 11 de Agosto de 2017.
  */


/* Esta consulta lista los pagos de acuerdo al rango de fechas seleccionadas */

$query = "SELECT
    l.reference1 AS OrdenPago
    ,l.reference2 AS NumeroDocumento
    ,l.transvalue AS Valor
    ,l.solicitedate AS FechaSolicitud
    ,l.bankprocessdate AS FechaPago
    ,l.finame AS Entidad
    ,l.stacode AS Estado
    ,l.trazabilitycode AS CodigoTransaccion
    ,l.PaymentSystem as SistemaPago
    ,IF(stacode = 'OK', substr(log.enviologtraceintegracionps,instr(log.enviologtraceintegracionps,'<ITEM_TYPE>') + 11, 12),'') as ItemBanco
    ,if(l.PaymentSystem=100,'Agent Bank','PSE') AS NamePago
    ,log.transaccionlogtraceintegracionps
    ,eg.apellidosestudiantegeneral AS Apellidos
    ,eg.nombresestudiantegeneral AS Nombres
    ,eg.emailestudiantegeneral AS EMail
    ,eg.telefonoresidenciaestudiantegeneral AS Telefono
    ,eg.celularestudiantegeneral AS Celular
    ,e.codigocarrera AS Codigo_carrera
    ,ca.nombrecarrera AS Nombre_carrera
    FROM LogPagos l 
    LEFT JOIN logtraceintegracionps log ON l.reference1=log.documentologtraceintegracionps 
                                        AND log.respuestalogtraceintegracionps LIKE '%Correcto%' 
                                        AND log.transaccionlogtraceintegracionps IN ('Informa Pago AgentBank','Informa Pago PSE')
    INNER JOIN estudiantegeneral eg ON eg.numerodocumento=l.reference2
    INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
    INNER JOIN ordenpago op ON op.codigoestudiante=e.codigoestudiante
                            AND op.numeroordenpago=l.reference1
    INNER JOIN carrera ca ON ca.codigocarrera=e.codigocarrera
	WHERE l.solicitedate BETWEEN '" . $fechainicio . "' AND '" . $fechafin . "' 
	ORDER BY l.reference1 DESC";

if ($Resultado = &$db->Execute($query) === false) {
    echo 'Error en la consulta a la base de datos';
    die;
}
$imprimir = '<table width="700" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr> 
        <td height="13" bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Orden Pago</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Numero Documento</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"><div align="center" class="Estilo10"><font color="#000000">Valor</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Fecha Solicitud</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Fecha Pago</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"><div align="center" class="Estilo10"><font color="#000000">Entidad</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Estado</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Codigo Transaccion</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Sistema Pago</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Item Banco</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Name Pago</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">transaccionlogtraceintegracionps</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Apellidos</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Nombres</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">EMail</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Telefono</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Celular</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Codigo_Carrera</font></div></td>
        <td bgcolor="#C5D5D6" class="Estilo5"> <div align="center" class="Estilo10"><font color="#000000">Nombre_Carrera</font></div></td>
      </tr>';

if (!$Resultado->EOF) {
    while (!$Resultado->EOF) {
        $imprimir .= "<tr>
                        <td>" . $Resultado->fields['OrdenPago'] . "</td>
                        <td>" . $Resultado->fields['NumeroDocumento'] . "</td>
                        <td>" . $Resultado->fields['Valor'] . "</td>
                        <td>" . $Resultado->fields['FechaSolicitud'] . "</td>
                        <td>" . $Resultado->fields['FechaPago'] . "</td>
                        <td>" . $Resultado->fields['Entidad'] . "</td>
                        <td>" . $Resultado->fields['Estado'] . "</td>
                        <td>" . $Resultado->fields['CodigoTransaccion'] . "</td>
                        <td>" . $Resultado->fields['SistemaPago'] . "</td>
                        <td>" . $Resultado->fields['ItemBanco'] . "</td>
                        <td>" . $Resultado->fields['NamePago'] . "</td>
                        <td>" . $Resultado->fields['transaccionlogtraceintegracionps'] . "</td>
                        <td>" . $Resultado->fields['Apellidos'] . "</td>
                        <td>" . $Resultado->fields['Nombres'] . "</td>
                        <td>" . $Resultado->fields['EMail'] . "</td>
                        <td>" . $Resultado->fields['Telefono'] . "</td>
                        <td>" . $Resultado->fields['Celular'] . "</td>
                        <td>" . $Resultado->fields['Codigo_carrera'] . "</td>
                        <td>" . $Resultado->fields['Nombre_carrera'] . "</td>
                    </tr>";
        $Resultado->MoveNext();
    }
}
$imprimir .= '</table>';
//end

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=ReportePagos.xls");// Disable caching
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies

echo $imprimir;
?>